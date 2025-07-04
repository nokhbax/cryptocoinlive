/**
 * Cart AJAX Handler
 * ملف JavaScript لمعالجة عمليات AJAX في صفحة السلة
 */

(function($) {
    'use strict';

    // متغيرات عامة
    const CartAjax = {
        init: function() {
            this.bindEvents();
            this.initQuantityControls();
            this.initRemoveButtons();
        },

        bindEvents: function() {
            // تحديث السلة عند تغيير الكمية
            $(document).on('change', '.quantity-input', this.updateQuantity);
            
            // تحديث السلة عند النقر على أزرار الكمية
            $(document).on('click', '.quantity-plus, .quantity-minus', this.handleQuantityButtons);
            
            // حذف منتج من السلة
            $(document).on('click', '.remove-btn', this.removeItem);
            
            // تطبيق كوبون
            $(document).on('click', '.apply-coupon-btn', this.applyCoupon);
            
            // إزالة كوبون
            $(document).on('click', '.remove-coupon', this.removeCoupon);
        },

        initQuantityControls: function() {
            $('.quantity-plus').on('click', function(e) {
                e.preventDefault();
                const input = $(this).siblings('.quantity-input');
                const currentVal = parseInt(input.val()) || 1;
                const maxVal = parseInt(input.attr('max')) || 999;
                
                if (currentVal < maxVal) {
                    input.val(currentVal + 1).trigger('change');
                }
            });

            $('.quantity-minus').on('click', function(e) {
                e.preventDefault();
                const input = $(this).siblings('.quantity-input');
                const currentVal = parseInt(input.val()) || 1;
                const minVal = parseInt(input.attr('min')) || 1;
                
                if (currentVal > minVal) {
                    input.val(currentVal - 1).trigger('change');
                }
            });
        },

        initRemoveButtons: function() {
            $('.remove-btn').on('click', function(e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                    const cartItemKey = $(this).data('cart_item_key');
                    CartAjax.removeItemFromCart(cartItemKey, $(this));
                }
            });
        },

        updateQuantity: function(e) {
            const $input = $(e.target);
            const cartItemKey = $input.closest('.cart-item').data('key');
            const quantity = parseInt($input.val()) || 1;
            
            // التحقق من الحد الأدنى والأقصى
            const minVal = parseInt($input.attr('min')) || 1;
            const maxVal = parseInt($input.attr('max')) || 999;
            
            if (quantity < minVal) {
                $input.val(minVal);
                return;
            }
            
            if (quantity > maxVal) {
                $input.val(maxVal);
                return;
            }

            CartAjax.updateCartQuantity(cartItemKey, quantity, $input);
        },

        handleQuantityButtons: function(e) {
            e.preventDefault();
            const $button = $(e.target);
            const $input = $button.siblings('.quantity-input');
            const currentVal = parseInt($input.val()) || 1;
            
            if ($button.hasClass('quantity-plus')) {
                const maxVal = parseInt($input.attr('max')) || 999;
                if (currentVal < maxVal) {
                    $input.val(currentVal + 1).trigger('change');
                }
            } else if ($button.hasClass('quantity-minus')) {
                const minVal = parseInt($input.attr('min')) || 1;
                if (currentVal > minVal) {
                    $input.val(currentVal - 1).trigger('change');
                }
            }
        },

        removeItem: function(e) {
            e.preventDefault();
            
            if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                const $button = $(e.target);
                const cartItemKey = $button.data('cart_item_key');
                CartAjax.removeItemFromCart(cartItemKey, $button);
            }
        },

        updateCartQuantity: function(cartItemKey, quantity, $element) {
            CartAjax.showLoading();
            
            const data = {
                action: 'woocommerce_update_cart_quantity',
                cart_item_key: cartItemKey,
                quantity: quantity,
                security: wc_cart_params.update_cart_nonce
            };

            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // تحديث السلة بنجاح
                        CartAjax.updateCartUI(response.data);
                        CartAjax.showNotification('تم تحديث الكمية بنجاح', 'success');
                    } else {
                        // فشل في التحديث
                        CartAjax.showNotification(response.data.message || 'حدث خطأ في تحديث الكمية', 'error');
                        // إعادة القيمة السابقة
                        $element.val($element.data('prev-value') || 1);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    CartAjax.showNotification('حدث خطأ في الاتصال بالخادم', 'error');
                    $element.val($element.data('prev-value') || 1);
                },
                complete: function() {
                    CartAjax.hideLoading();
                }
            });
        },

        removeItemFromCart: function(cartItemKey, $element) {
            CartAjax.showLoading();
            
            const data = {
                action: 'woocommerce_remove_cart_item',
                cart_item_key: cartItemKey,
                security: wc_cart_params.remove_cart_nonce
            };

            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // إزالة العنصر من DOM مع تأثير
                        const $cartItem = $element.closest('.cart-item');
                        $cartItem.fadeOut(300, function() {
                            $(this).remove();
                            
                            // تحديث ملخص السلة
                            CartAjax.updateCartUI(response.data);
                            
                            // التحقق من وجود منتجات في السلة
                            if ($('.cart-item').length === 0) {
                                CartAjax.showEmptyCart();
                            }
                        });
                        
                        CartAjax.showNotification('تم حذف المنتج من السلة', 'success');
                    } else {
                        CartAjax.showNotification(response.data.message || 'فشل في حذف المنتج', 'error');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    CartAjax.showNotification('حدث خطأ في الاتصال بالخادم', 'error');
                },
                complete: function() {
                    CartAjax.hideLoading();
                }
            });
        },

        applyCoupon: function(e) {
            e.preventDefault();
            
            const couponCode = $('#coupon-code').val().trim();
            if (!couponCode) {
                CartAjax.showNotification('الرجاء إدخال رمز الكوبون', 'warning');
                return;
            }

            CartAjax.showLoading();
            
            const data = {
                action: 'woocommerce_apply_coupon',
                coupon_code: couponCode,
                security: wc_cart_params.apply_coupon_nonce
            };

            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        CartAjax.updateCartUI(response.data);
                        CartAjax.showNotification('تم تطبيق الكوبون بنجاح', 'success');
                        $('#coupon-code').val('');
                    } else {
                        CartAjax.showNotification(response.data.message || 'فشل في تطبيق الكوبون', 'error');
                    }
                },
                error: function() {
                    CartAjax.showNotification('حدث خطأ في الاتصال بالخادم', 'error');
                },
                complete: function() {
                    CartAjax.hideLoading();
                }
            });
        },

        removeCoupon: function(e) {
            e.preventDefault();
            
            const couponCode = $(e.target).data('coupon');
            
            CartAjax.showLoading();
            
            const data = {
                action: 'woocommerce_remove_coupon',
                coupon_code: couponCode,
                security: wc_cart_params.remove_coupon_nonce
            };

            $.ajax({
                type: 'POST',
                url: wc_cart_params.ajax_url,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        CartAjax.updateCartUI(response.data);
                        CartAjax.showNotification('تم إزالة الكوبون', 'success');
                    } else {
                        CartAjax.showNotification('فشل في إزالة الكوبون', 'error');
                    }
                },
                error: function() {
                    CartAjax.showNotification('حدث خطأ في الاتصال بالخادم', 'error');
                },
                complete: function() {
                    CartAjax.hideLoading();
                }
            });
        },

        updateCartUI: function(data) {
            // تحديث ملخص السلة
            if (data.cart_totals) {
                $('.cart-summary').html(data.cart_totals);
            }
            
            // تحديث عدد المنتجات في الهيدر (إذا وجد)
            if (data.cart_count !== undefined) {
                $('.cart-count').text(data.cart_count);
            }
            
            // تحديث إجمالي السلة
            if (data.cart_total) {
                $('.cart-total').text(data.cart_total);
            }
        },

        showEmptyCart: function() {
            const emptyCartHtml = `
                <div class="empty-cart">
                    <div class="empty-cart-icon">😔</div>
                    <h3>سلة مشترياتك فارغة في الوقت الحالي</h3>
                    <p>اكتشف منتجاتنا الرائعة وابدأ في إضافة ما يعجبك إلى سلة المشتريات</p>
                    <a href="${wc_cart_params.shop_url}" class="continue-shopping">
                        <span>🛍️</span> تصفح المنتجات
                    </a>
                </div>
            `;
            
            $('.cart-container').fadeOut(300, function() {
                $(this).html(emptyCartHtml).fadeIn(300);
            });
        },

        showLoading: function() {
            if ($('#loadingOverlay').length) {
                $('#loadingOverlay').show();
            } else {
                // إنشاء overlay للتحميل إذا لم يكن موجوداً
                const loadingHtml = `
                    <div id="loadingOverlay" class="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                `;
                $('body').append(loadingHtml);
            }
        },

        hideLoading: function() {
            $('#loadingOverlay').hide();
        },

        showNotification: function(message, type = 'info') {
            // إزالة الإشعارات السابقة
            $('.cart-notification').remove();
            
            const notificationClass = `cart-notification notification-${type}`;
            const iconMap = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };
            
            const colorMap = {
                success: '#00ff88',
                error: '#ff0055',
                warning: '#ffaa00',
                info: '#0088ff'
            };
            
            const notificationHtml = `
                <div class="${notificationClass}" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${colorMap[type]};
                    color: white;
                    padding: 1rem 2rem;
                    border-radius: 10px;
                    z-index: 10000;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                    font-weight: 600;
                    max-width: 400px;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    animation: slideInRight 0.3s ease;
                ">
                    <span>${iconMap[type]}</span>
                    <span>${message}</span>
                </div>
            `;
            
            $('body').append(notificationHtml);
            
            // إزالة الإشعار بعد 4 ثوانٍ
            setTimeout(function() {
                $(`.${notificationClass}`).fadeOut(300, function() {
                    $(this).remove();
                });
            }, 4000);
        },

        // حفظ القيم السابقة للكميات
        saveInputValues: function() {
            $('.quantity-input').each(function() {
                $(this).data('prev-value', $(this).val());
            });
        },

        // تهيئة الصفحة
        initPage: function() {
            // حفظ القيم الأولية
            this.saveInputValues();
            
            // إضافة أنماط CSS للحركات إذا لم تكن موجودة
            if (!$('#cart-animations-css').length) {
                const animationCSS = `
                    <style id="cart-animations-css">
                        @keyframes slideInRight {
                            from {
                                transform: translateX(100%);
                                opacity: 0;
                            }
                            to {
                                transform: translateX(0);
                                opacity: 1;
                            }
                        }
                        
                        .cart-item {
                            transition: all 0.3s ease;
                        }
                        
                        .cart-item:hover {
                            background: rgba(255, 255, 255, 0.05);
                            border-radius: 10px;
                        }
                        
                        .quantity-btn:active {
                            transform: scale(0.95);
                        }
                        
                        .remove-btn:active {
                            transform: scale(0.95);
                        }
                    </style>
                `;
                $('head').append(animationCSS);
            }
        }
    };

    // تهيئة عند تحميل الصفحة
    $(document).ready(function() {
        CartAjax.init();
        CartAjax.initPage();
    });

    // تصدير للاستخدام العام
    window.CartAjax = CartAjax;

})(jQuery);