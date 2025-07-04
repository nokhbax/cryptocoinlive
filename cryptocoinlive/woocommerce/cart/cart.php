<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined( 'ABSPATH' ) || exit;

// Get site settings (assuming same structure as index.php)
global $wpdb;
$siteSettings = [
    'site_name' => get_bloginfo('name'),
    'support_email' => get_option('admin_email')
];

do_action( 'woocommerce_before_cart' ); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة المشتريات - <?php echo esc_html($siteSettings['site_name']); ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #00ff88;
            --secondary: #ff00aa;
            --dark: #0a0a0a;
            --darker: #050505;
            --light: #1a1a1a;
            --text: #ffffff;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
            --error: #ff0055;
            --success: #00ff88;
            --warning: #ffaa00;
        }

        body {
            font-family: 'Cairo', -apple-system, sans-serif;
            background: var(--darker);
            color: var(--text);
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle at 20% 50%, rgba(0, 255, 136, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 0, 170, 0.1) 0%, transparent 50%);
        }

        .floating-particles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(0, 255, 136, 0.5);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            from {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            to {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1rem 2rem;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite;
            text-decoration: none;
        }

        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 10px var(--primary)); }
            50% { filter: drop-shadow(0 0 20px var(--secondary)); }
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--text);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        /* Main Content */
        .main-content {
            margin-top: 100px;
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Cart Styles */
        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .cart-items {
            background: var(--light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(0, 255, 136, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cart-items::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient);
        }

        .cart-summary {
            background: var(--light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 0, 170, 0.2);
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .cart-summary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto auto auto;
            gap: 1rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .item-image:hover img {
            transform: scale(1.1);
        }

        .item-details h3 {
            color: var(--text);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .item-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .item-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 2px solid var(--primary);
            background: transparent;
            color: var(--primary);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--primary);
            color: var(--dark);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--text);
            padding: 0.5rem;
            font-size: 1rem;
        }

        .remove-btn {
            width: 40px;
            height: 40px;
            border: 2px solid var(--error);
            background: transparent;
            color: var(--error);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: var(--error);
            color: white;
            transform: scale(1.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .summary-row:last-child {
            border-bottom: none;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary);
            padding-top: 1.5rem;
            border-top: 2px solid var(--primary);
        }

        .checkout-btn {
            width: 100%;
            background: var(--gradient);
            color: white;
            padding: 1rem 2rem;
            border-radius: 15px;
            border: none;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .checkout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .checkout-btn:hover::before {
            left: 100%;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 255, 136, 0.3);
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--light);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .empty-cart-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-cart h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .empty-cart p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .continue-shopping {
            background: var(--gradient);
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .continue-shopping:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        /* Responsive */
        @media (max-width: 968px) {
            .cart-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
                padding: 2rem 0;
            }

            .item-image {
                justify-self: center;
                width: 120px;
                height: 120px;
            }

            .quantity-controls {
                justify-content: center;
            }

            .nav-links a:not(.btn-primary) {
                display: none;
            }

            .page-title {
                font-size: 2rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(0, 255, 136, 0.3);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Background Animation -->
    <div class="bg-animation"></div>
    <div class="floating-particles" id="particles"></div>

    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="<?php echo home_url(); ?>" class="logo"><?php echo esc_html($siteSettings['site_name']); ?></a>
            <div class="nav-links">
                <a href="<?php echo home_url(); ?>">الرئيسية</a>
                <a href="<?php echo home_url(); ?>#features">المميزات</a>
                <a href="<?php echo home_url(); ?>#pricing">الأسعار</a>
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn-primary">المتجر</a>
            </div>
        </div>
    </nav>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h1 class="page-title">🛒 سلة المشتريات</h1>

            <?php if ( WC()->cart->is_empty() ) : ?>

                <div class="empty-cart">
                    <div class="empty-cart-icon">😔</div>
                    <h3>سلة مشترياتك فارغة في الوقت الحالي</h3>
                    <p>اكتشف منتجاتنا الرائعة وابدأ في إضافة ما يعجبك إلى سلة المشتريات</p>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="continue-shopping">
                        <span>🛍️</span> تصفح المنتجات
                    </a>
                </div>

            <?php else : ?>

                <div class="cart-container">
                    <div class="cart-items">
                        <h2 class="section-title">
                            <span>🛍️</span> منتجاتك المختارة
                        </h2>

                        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                            <?php do_action( 'woocommerce_before_cart_table' ); ?>

                            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                    ?>

                                    <div class="cart-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                        <!-- Product Image -->
                                        <div class="item-image">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                            if ( ! $product_permalink ) {
                                                echo $thumbnail;
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                            }
                                            ?>
                                        </div>

                                        <!-- Product Details -->
                                        <div class="item-details">
                                            <h3>
                                                <?php
                                                if ( ! $product_permalink ) {
                                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                                } else {
                                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                                }

                                                do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                                // Meta data.
                                                echo wc_get_formatted_cart_item_data( $cart_item );

                                                // Backorder notification.
                                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                                }
                                                ?>
                                            </h3>
                                            <p class="item-description"><?php echo wp_kses_post( $_product->get_short_description() ); ?></p>
                                        </div>

                                        <!-- Price -->
                                        <div class="item-price">
                                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="quantity-controls">
                                            <button type="button" class="quantity-btn quantity-minus" data-key="<?php echo esc_attr( $cart_item_key ); ?>">-</button>
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $min_quantity = 1;
                                                $max_quantity = 1;
                                            } else {
                                                $min_quantity = 0;
                                                $max_quantity = $_product->get_max_purchase_quantity();
                                            }

                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $_product->get_name(),
                                                    'classes'      => 'quantity-input',
                                                ),
                                                $_product,
                                                false
                                            );

                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                            ?>
                                            <button type="button" class="quantity-btn quantity-plus" data-key="<?php echo esc_attr( $cart_item_key ); ?>">+</button>
                                        </div>

                                        <!-- Remove -->
                                        <div class="item-actions">
                                            <?php
                                            echo apply_filters(
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<button type="button" class="remove-btn" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s" title="%s">🗑️</button>',
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() ),
                                                    esc_attr( $cart_item_key ),
                                                    esc_html__( 'Remove this item', 'woocommerce' )
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </div>
                                    </div>

                                    <?php
                                endif;
                            endforeach;
                            ?>

                            <?php do_action( 'woocommerce_cart_actions' ); ?>
                            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                        </form>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <h2 class="section-title">
                            <span>💰</span> ملخص الطلب
                        </h2>

                        <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

                        <div class="cart-collaterals">
                            <div class="summary-row">
                                <span>المجموع الفرعي:</span>
                                <span><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>

                            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                                <div class="summary-row">
                                    <span><?php wc_cart_totals_coupon_label( $coupon ); ?>:</span>
                                    <span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
                                </div>
                            <?php endforeach; ?>

                            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                                <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
                                <div class="summary-row">
                                    <span>الشحن:</span>
                                    <span><?php wc_cart_totals_shipping_html(); ?></span>
                                </div>
                                <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
                            <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
                                <div class="summary-row">
                                    <span>الشحن:</span>
                                    <span><?php woocommerce_shipping_calculator(); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                <div class="summary-row">
                                    <span><?php echo esc_html( $fee->name ); ?>:</span>
                                    <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
                                </div>
                            <?php endforeach; ?>

                            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                                        <div class="summary-row">
                                            <span><?php echo esc_html( $tax->label ); ?>:</span>
                                            <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="summary-row">
                                        <span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</span>
                                        <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

                            <div class="summary-row">
                                <span>الإجمالي:</span>
                                <span><?php wc_cart_totals_order_total_html(); ?></span>
                            </div>

                            <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
                        </div>

                        <button type="button" class="checkout-btn" onclick="window.location.href='<?php echo esc_url( wc_get_checkout_url() ); ?>'">
                            <span>🚀</span> متابعة للدفع
                        </button>

                        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

                        <div style="margin-top: 1rem; text-align: center;">
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" style="color: var(--primary); text-decoration: none;">
                                ← متابعة التسوق
                            </a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php do_action( 'woocommerce_after_cart' ); ?>
        </div>
    </main>

    <script>
        // إنشاء الجسيمات المتحركة
        const particlesContainer = document.getElementById('particles');
        if (particlesContainer) {
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // إظهار/إخفاء شاشة التحميل
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // التعامل مع أزرار الكمية
        document.querySelectorAll('.quantity-plus').forEach(button => {
            button.addEventListener('click', function() {
                const cartItemKey = this.dataset.key;
                const quantityInput = this.parentNode.querySelector('.quantity-input');
                let currentQuantity = parseInt(quantityInput.value) || 1;
                
                quantityInput.value = currentQuantity + 1;
                updateCartQuantity(cartItemKey, quantityInput.value);
            });
        });

        document.querySelectorAll('.quantity-minus').forEach(button => {
            button.addEventListener('click', function() {
                const cartItemKey = this.dataset.key;
                const quantityInput = this.parentNode.querySelector('.quantity-input');
                let currentQuantity = parseInt(quantityInput.value) || 1;
                
                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                    updateCartQuantity(cartItemKey, quantityInput.value);
                }
            });
        });

        // التعامل مع أزرار الحذف
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('هل أنت متأكد من حذف هذا المنتج من السلة؟')) {
                    const cartItemKey = this.dataset.cart_item_key;
                    removeCartItem(cartItemKey);
                }
            });
        });

        // تحديث كمية المنتج في السلة
        function updateCartQuantity(cartItemKey, quantity) {
            showLoading();

            const formData = new FormData();
            formData.append('action', 'update_cart_quantity');
            formData.append('cart_item_key', cartItemKey);
            formData.append('quantity', quantity);
            formData.append('nonce', wc_cart_params.update_cart_nonce);

            fetch(wc_cart_params.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ في تحديث الكمية');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في الاتصال');
            })
            .finally(() => {
                hideLoading();
            });
        }

        // حذف منتج من السلة
        function removeCartItem(cartItemKey) {
            showLoading();

            const formData = new FormData();
            formData.append('action', 'remove_cart_item');
            formData.append('cart_item_key', cartItemKey);
            formData.append('nonce', wc_cart_params.remove_cart_nonce);

            fetch(wc_cart_params.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ في حذف المنتج');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في الاتصال');
            })
            .finally(() => {
                hideLoading();
            });
        }

        // التمرير السلس للروابط
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // إخفاء شاشة التحميل عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading();
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>