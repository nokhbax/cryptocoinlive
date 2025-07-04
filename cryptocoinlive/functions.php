<?php
/**
 * CryptoCoin Live Theme Functions
 * 
 * @package CryptoCoinLive
 * @version 1.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

// إعداد القالب
function cryptocoin_live_setup() {
    // دعم تعدد اللغات
    load_theme_textdomain('cryptocoin-live', get_template_directory() . '/languages');
    
    // دعم العنوان التلقائي
    add_theme_support('title-tag');
    
    // دعم الصور المميزة
    add_theme_support('post-thumbnails');
    
    // دعم RSS Links
    add_theme_support('automatic-feed-links');
    
    // دعم HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // دعم محرر الكتل
    add_theme_support('editor-styles');
    add_editor_style('style.css');
    
    // دعم ألوان القالب
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Color', 'cryptocoin-live'),
            'slug'  => 'primary',
            'color' => '#00ff88',
        ),
        array(
            'name'  => __('Secondary Color', 'cryptocoin-live'),
            'slug'  => 'secondary',
            'color' => '#ff00aa',
        ),
        array(
            'name'  => __('Dark Color', 'cryptocoin-live'),
            'slug'  => 'dark',
            'color' => '#0a0a0a',
        ),
        array(
            'name'  => __('Light Color', 'cryptocoin-live'),
            'slug'  => 'light',
            'color' => '#1a1a1a',
        ),
    ));
    
    // أحجام الصور المخصصة
    add_image_size('feature-card', 400, 300, true);
    add_image_size('post-thumbnail', 600, 400, true);
    add_image_size('hero-image', 1200, 600, true);
    
    // دعم التنقل المخصص
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'cryptocoin-live'),
        'footer'  => __('Footer Menu', 'cryptocoin-live'),
    ));
    
    // دعم Logo المخصص
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // دعم الخلفية المخصصة
    add_theme_support('custom-background', array(
        'default-color' => '050505',
    ));
    
    // دعم محرر Gutenberg
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    // إضافة دعم WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'cryptocoin_live_setup');

// تسجيل وتحميل الملفات
function cryptocoin_live_scripts() {
    // تحميل ملف CSS الرئيسي
    wp_enqueue_style('cryptocoin-live-style', get_stylesheet_uri(), array(), '1.0');
    
    // تحميل خط Cairo من Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap', array(), '1.0');
    
    // تحميل ملف JavaScript الرئيسي
    wp_enqueue_script('cryptocoin-live-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
    
    // إضافة متغيرات AJAX
    wp_localize_script('cryptocoin-live-script', 'cryptocoin_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('cryptocoin_nonce'),
        'loading_text' => __('Loading...', 'cryptocoin-live'),
        'strings' => array(
            'invalid_file' => __('الرجاء رفع صورة فقط', 'cryptocoin-live'),
            'file_too_large' => __('حجم الصورة كبير جداً. الحد الأقصى 10 ميجابايت', 'cryptocoin-live'),
            'analysis_complete' => __('تم التحليل بنجاح!', 'cryptocoin-live'),
            'analysis_error' => __('حدث خطأ في التحليل', 'cryptocoin-live'),
            'connection_error' => __('حدث خطأ في الاتصال', 'cryptocoin-live'),
            'analysis_results' => __('نتائج التحليل', 'cryptocoin-live'),
            'dominant_trend' => __('الاتجاه السائد', 'cryptocoin-live'),
            'bullish_trend' => __('اتجاه صعودي', 'cryptocoin-live'),
            'bearish_trend' => __('اتجاه هبوطي', 'cryptocoin-live'),
            'sideways_trend' => __('اتجاه عرضي', 'cryptocoin-live'),
            'bullish' => __('صعودي', 'cryptocoin-live'),
            'bearish' => __('هبوطي', 'cryptocoin-live'),
            'sideways' => __('عرضي', 'cryptocoin-live'),
            'recommendation' => __('التوصية الذكية', 'cryptocoin-live'),
            'analysis_id' => __('معرف التحليل', 'cryptocoin-live'),
            'timestamp' => __('الوقت', 'cryptocoin-live'),
            'new_analysis' => __('تحليل جديد', 'cryptocoin-live'),
            'share_results' => __('مشاركة النتائج', 'cryptocoin-live'),
            'camera_not_supported' => __('الكاميرا غير مدعومة في هذا المتصفح', 'cryptocoin-live'),
            'camera_error' => __('لا يمكن الوصول للكاميرا', 'cryptocoin-live'),
            'camera_not_ready' => __('الكاميرا غير جاهزة بعد', 'cryptocoin-live'),
            'capture_failed' => __('فشل في التقاط الصورة', 'cryptocoin-live'),
            'invalid_email' => __('الرجاء إدخال بريد إلكتروني صحيح', 'cryptocoin-live'),
            'newsletter_success' => __('تم الاشتراك في النشرة بنجاح!', 'cryptocoin-live'),
            'newsletter_error' => __('حدث خطأ. حاول مرة أخرى.', 'cryptocoin-live'),
            'contact_success' => __('تم إرسال الرسالة بنجاح!', 'cryptocoin-live'),
            'contact_error' => __('فشل في إرسال الرسالة', 'cryptocoin-live'),
            'form_validation_error' => __('الرجاء ملء جميع الحقول المطلوبة بشكل صحيح', 'cryptocoin-live'),
            'send_message' => __('إرسال الرسالة', 'cryptocoin-live'),
            'skip_to_content' => __('تخطى إلى المحتوى', 'cryptocoin-live'),
            'upload_area_label' => __('منطقة رفع الصور للتحليل', 'cryptocoin-live'),
            'copied_to_clipboard' => __('تم النسخ للحافظة!', 'cryptocoin-live'),
            'crypto_analysis' => __('تحليل العملات الرقمية', 'cryptocoin-live'),
            'powered_by_ai' => __('مدعوم بالذكاء الاصطناعي', 'cryptocoin-live'),
        ),
    ));
    
    // تحميل ملف التعليقات
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cryptocoin_live_scripts');

// إضافة خيارات التخصيص
function cryptocoin_live_customize_register($wp_customize) {
    // قسم إعدادات الموقع
    $wp_customize->add_section('cryptocoin_site_settings', array(
        'title'    => __('Site Settings', 'cryptocoin-live'),
        'priority' => 30,
    ));
    
    // نص Hero Section
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('تحليل العملات الرقمية بالذكاء الاصطناعي', 'cryptocoin-live'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Title', 'cryptocoin-live'),
        'section'  => 'cryptocoin_site_settings',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('hero_description', array(
        'default'           => __('احصل على توقعات دقيقة لاتجاه السوق باستخدام أحدث تقنيات الذكاء الاصطناعي', 'cryptocoin-live'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label'    => __('Hero Description', 'cryptocoin-live'),
        'section'  => 'cryptocoin_site_settings',
        'type'     => 'textarea',
    ));
    
    // إعدادات الألوان
    $wp_customize->add_section('color_settings', array(
        'title'    => __('Color Settings', 'cryptocoin-live'),
        'priority' => 45,
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#00ff88',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => __('Primary Color', 'cryptocoin-live'),
        'section'  => 'color_settings',
    )));
    
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#ff00aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => __('Secondary Color', 'cryptocoin-live'),
        'section'  => 'color_settings',
    )));
}
add_action('customize_register', 'cryptocoin_live_customize_register');

// إضافة CSS مخصص بناءً على إعدادات التخصيص
function cryptocoin_live_customize_css() {
    $primary_color = get_theme_mod('primary_color', '#00ff88');
    $secondary_color = get_theme_mod('secondary_color', '#ff00aa');
    
    ?>
    <style type="text/css">
        :root {
            --primary: <?php echo esc_html($primary_color); ?>;
            --secondary: <?php echo esc_html($secondary_color); ?>;
            --gradient: linear-gradient(135deg, <?php echo esc_html($primary_color); ?>, <?php echo esc_html($secondary_color); ?>);
        }
    </style>
    <?php
}
add_action('wp_head', 'cryptocoin_live_customize_css');

// إضافة AJAX functions للتفاعل
function cryptocoin_live_ajax_analyze_image() {
    check_ajax_referer('cryptocoin_nonce', 'nonce');
    
    if (!isset($_FILES['image'])) {
        wp_die(__('لم يتم رفع صورة', 'cryptocoin-live'));
    }
    
    // هنا يمكن إضافة منطق تحليل الصورة الحقيقي
    // للمثال، سنرجع نتائج وهمية
    $results = array(
        'success' => true,
        'results' => array(
            'bullish' => rand(30, 70),
            'bearish' => rand(20, 50),
            'sideways' => rand(10, 40)
        ),
        'recommendation' => __('بناءً على التحليل، يبدو الاتجاه صعودياً. ضع في اعتبارك تحمل المخاطر قبل اتخاذ أي قرارات.', 'cryptocoin-live'),
        'analysis_id' => uniqid()
    );
    
    wp_send_json($results);
}
add_action('wp_ajax_analyze_image', 'cryptocoin_live_ajax_analyze_image');
add_action('wp_ajax_nopriv_analyze_image', 'cryptocoin_live_ajax_analyze_image');

// دالة تحسين الأداء
function cryptocoin_live_performance_optimizations() {
    // إزالة الأشياء غير الضرورية من WordPress
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    
    // تحسين الـ Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'cryptocoin_live_performance_optimizations');

// إضافة إعدادات الأمان
function cryptocoin_live_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'cryptocoin_live_security_headers');

/**
 * ================================
 * CRYPTOAI WOOCOMMERCE INTEGRATION
 * ================================
 * تكامل CryptoAI مع WooCommerce للدفعات التلقائية
 */

// تفعيل webhook تلقائي عند تغيير حالة الطلب
add_action('woocommerce_order_status_completed', 'crypto_auto_webhook', 10, 1);
add_action('woocommerce_order_status_processing', 'crypto_auto_webhook', 10, 1);
add_action('woocommerce_payment_complete', 'crypto_auto_webhook', 10, 1);

function crypto_auto_webhook($order_id) {
    // تسجيل الحدث
    error_log("CryptoAI: Auto webhook triggered for order " . $order_id);
    
    // إرسال webhook فوري
    $webhook_url = 'https://cryptocoinlive.co/woocommerce_webhook.php';
    
    // تحضير البيانات
    $order = wc_get_order($order_id);
    if (!$order) {
        error_log("CryptoAI: Order not found - " . $order_id);
        return;
    }
    
    $webhook_data = array(
        'id' => $order_id,
        'action' => 'order.completed',
        'status' => $order->get_status(),
        'total' => $order->get_total(),
        'customer_id' => $order->get_customer_id(),
        'customer_user_id' => $order->get_user_id(),
        'billing_email' => $order->get_billing_email(),
        'payment_method' => $order->get_payment_method(),
        'date_completed' => current_time('mysql'),
        'items' => array()
    );
    
    // إضافة عناصر الطلب
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $webhook_data['items'][] = array(
            'product_id' => $item->get_product_id(),
            'name' => $item->get_name(),
            'quantity' => $item->get_quantity(),
            'total' => $item->get_total()
        );
    }
    
    // إرسال webhook
    $response = wp_remote_post($webhook_url, array(
        'method' => 'POST',
        'timeout' => 30,
        'headers' => array(
            'Content-Type' => 'application/json',
            'X-WC-Webhook-Topic' => 'order.completed',
            'X-WC-Webhook-Source' => get_site_url()
        ),
        'body' => json_encode($webhook_data)
    ));
    
    // تسجيل النتيجة
    if (is_wp_error($response)) {
        error_log("CryptoAI: Webhook failed - " . $response->get_error_message());
        
        // إضافة ملاحظة للطلب
        $order->add_order_note('فشل إرسال webhook إلى CryptoAI: ' . $response->get_error_message());
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        
        error_log("CryptoAI: Webhook sent successfully - Response: " . $response_code);
        
        // إضافة ملاحظة للطلب
        $order->add_order_note('تم إرسال webhook إلى CryptoAI بنجاح - Response: ' . $response_code);
        
        // إذا كانت الاستجابة ناجحة، أضف ملاحظة إضافية
        if ($response_code == 200) {
            $response_data = json_decode($response_body, true);
            if ($response_data && isset($response_data['status'])) {
                $order->add_order_note('CryptoAI Response: ' . $response_data['status']);
                
                // تسجيل معالجة ناجحة
                update_post_meta($order_id, '_crypto_last_processed', current_time('mysql'));
                update_post_meta($order_id, '_crypto_webhook_status', 'success');
            }
        }
    }
}

// إضافة زر معالجة يدوي في صفحة الطلب
add_action('woocommerce_admin_order_data_after_order_details', 'add_crypto_manual_process_button');

function add_crypto_manual_process_button($order) {
    $order_id = $order->get_id();
    $last_processed = get_post_meta($order_id, '_crypto_last_processed', true);
    ?>
    <div class="crypto-manual-process" style="margin: 15px 0; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
        <h4>🚀 CryptoAI Manual Processing</h4>
        <p>إذا لم يتم تحديث اشتراك العميل تلقائياً، يمكنك معالجة الطلب يدوياً:</p>
        
        <div style="margin: 10px 0;">
            <a href="<?php echo admin_url('admin.php?page=crypto_manual_process&order_id=' . $order_id); ?>" 
               class="button button-primary" style="margin-right: 10px;">
                🔄 معالجة يدوية
            </a>
            
            <a href="https://cryptocoinlive.co/woocommerce_webhook.php?test=1&order_id=<?php echo $order_id; ?>" 
               target="_blank" class="button button-secondary">
                🔗 اختبار Webhook
            </a>
        </div>
        
        <p style="font-size: 12px; color: #666;">
            آخر معالجة: <?php echo $last_processed ?: 'لم تتم معالجة'; ?>
        </p>
    </div>
    <?php
}

// إضافة صفحة المعالجة اليدوية
add_action('admin_menu', 'add_crypto_manual_process_page');

function add_crypto_manual_process_page() {
    add_submenu_page(
        'woocommerce',
        'CryptoAI Manual Process',
        'CryptoAI Manual Process',
        'manage_woocommerce',
        'crypto_manual_process',
        'crypto_manual_process_page'
    );
}

function crypto_manual_process_page() {
    if (!isset($_GET['order_id'])) {
        wp_die('Order ID is required');
    }
    
    $order_id = intval($_GET['order_id']);
    $order = wc_get_order($order_id);
    
    if (!$order) {
        wp_die('Order not found');
    }
    
    ?>
    <div class="wrap">
        <h1>🚀 CryptoAI Manual Processing</h1>
        <h2>Order #<?php echo $order_id; ?></h2>
        
        <div style="background: white; padding: 20px; border: 1px solid #ddd; border-radius: 5px; margin: 20px 0;">
            <h3>Order Details:</h3>
            <p><strong>Customer:</strong> <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></p>
            <p><strong>Email:</strong> <?php echo $order->get_billing_email(); ?></p>
            <p><strong>Total:</strong> <?php echo $order->get_total() . ' ' . $order->get_currency(); ?></p>
            <p><strong>Status:</strong> <?php echo $order->get_status(); ?></p>
            <p><strong>Date:</strong> <?php echo $order->get_date_created()->format('Y-m-d H:i:s'); ?></p>
        </div>
        
        <?php
        if (isset($_POST['process_order'])) {
            // معالجة الطلب
            echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
            echo "<h3>🔄 Processing Order...</h3>";
            
            try {
                // تفعيل webhook يدوي
                crypto_auto_webhook($order_id);
                
                echo "<div style='color: green;'>✅ تم إرسال webhook للطلب بنجاح!</div>";
                echo "<p>تحقق من logs الـ webhook للتأكد من المعالجة.</p>";
                
            } catch (Exception $e) {
                echo "<div style='color: red;'>❌ خطأ في المعالجة: " . $e->getMessage() . "</div>";
            }
            
            echo "</div>";
        }
        ?>
        
        <form method="post">
            <div style="background: #e3f2fd; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h3>⚠️ تأكيد المعالجة اليدوية</h3>
                <p>هذا سيرسل webhook للطلب إلى نظام CryptoAI لمعالجة الاشتراك:</p>
                
                <ul>
                    <li>سيتم ترقية العميل حسب المنتج المشترى</li>
                    <li>سيتم إضافة سجل في جدول المدفوعات</li>
                    <li>سيتم تحديث تاريخ انتهاء الاشتراك</li>
                </ul>
                
                <p>
                    <input type="submit" name="process_order" value="🚀 معالجة الطلب الآن" 
                           class="button button-primary button-large"
                           onclick="return confirm('هل أنت متأكد من معالجة هذا الطلب؟');">
                </p>
            </div>
        </form>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3>🔗 روابط مفيدة:</h3>
            <p>
                <a href="https://cryptocoinlive.co/woocommerce_webhook.php?test=1&order_id=<?php echo $order_id; ?>" 
                   target="_blank" class="button">اختبار Webhook</a>
                
                <a href="https://cryptocoinlive.co/check_real_order.php" 
                   target="_blank" class="button">فحص الطلبات</a>
                   
                <a href="<?php echo admin_url('post.php?post=' . $order_id . '&action=edit'); ?>" 
                   class="button">العودة للطلب</a>
            </p>
        </div>
    </div>
    <?php
}

// إضافة عمود في قائمة الطلبات لإظهار حالة CryptoAI
add_filter('manage_edit-shop_order_columns', 'add_crypto_status_column');
add_action('manage_shop_order_posts_custom_column', 'show_crypto_status_column', 10, 2);

function add_crypto_status_column($columns) {
    $columns['crypto_status'] = 'CryptoAI Status';
    return $columns;
}

function show_crypto_status_column($column, $post_id) {
    if ($column === 'crypto_status') {
        $last_processed = get_post_meta($post_id, '_crypto_last_processed', true);
        $webhook_status = get_post_meta($post_id, '_crypto_webhook_status', true);
        
        if ($last_processed && $webhook_status === 'success') {
            echo '<span style="color: green;">✅ Processed</span><br>';
            echo '<small>' . $last_processed . '</small>';
        } else {
            echo '<span style="color: orange;">⏳ Pending</span><br>';
            echo '<a href="' . admin_url('admin.php?page=crypto_manual_process&order_id=' . $post_id) . '">Process</a>';
        }
    }
}

// إضافة إعداد سريع في لوحة التحكم
add_action('wp_dashboard_widgets', 'crypto_dashboard_widget');

function crypto_dashboard_widget() {
    wp_add_dashboard_widget(
        'crypto_quick_actions',
        '🚀 CryptoAI Quick Actions',
        'crypto_dashboard_widget_content'
    );
}

function crypto_dashboard_widget_content() {
    echo '<p>إدارة سريعة لنظام CryptoAI:</p>';
    echo '<p>';
    echo '<a href="https://cryptocoinlive.co/check_real_order.php" target="_blank" class="button">فحص الطلبات</a> ';
    echo '<a href="https://cryptocoinlive.co/woocommerce_webhook.php?test=1" target="_blank" class="button">اختبار Webhook</a>';
    echo '</p>';
    
    // إظهار آخر الطلبات غير المعالجة
    $unprocessed_orders = get_posts(array(
        'post_type' => 'shop_order',
        'post_status' => 'wc-completed',
        'meta_query' => array(
            array(
                'key' => '_crypto_last_processed',
                'compare' => 'NOT EXISTS'
            )
        ),
        'numberposts' => 5
    ));
    
    if ($unprocessed_orders) {
        echo '<h4>⚠️ طلبات تحتاج معالجة:</h4>';
        echo '<ul>';
        foreach ($unprocessed_orders as $order_post) {
            echo '<li>';
            echo '<a href="' . admin_url('post.php?post=' . $order_post->ID . '&action=edit') . '">';
            echo 'Order #' . $order_post->ID;
            echo '</a> - ';
            echo '<a href="' . admin_url('admin.php?page=crypto_manual_process&order_id=' . $order_post->ID) . '">معالجة</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p style="color: green;">✅ جميع الطلبات تمت معالجتها</p>';
    }
}

/**
 * ================================
 * WOOCOMMERCE CUSTOM FUNCTIONS
 * ================================
 * إضافات مخصصة لـ WooCommerce
 */

/**
 * تسجيل سكريبتات وأنماط السلة المخصصة
 */
function enqueue_custom_cart_assets() {
    // التحقق من كون الصفحة هي صفحة السلة أو الدفع
    if (is_cart() || is_checkout()) {
        // تسجيل JavaScript للسلة
        wp_enqueue_script(
            'custom-cart-ajax',
            get_template_directory_uri() . '/assets/js/cart-ajax.js',
            array('jquery', 'wc-cart'),
            '1.0.0',
            true
        );

        // إضافة متغيرات JavaScript للـ AJAX
        wp_localize_script('custom-cart-ajax', 'wc_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'update_cart_nonce' => wp_create_nonce('wc_update_cart'),
            'remove_cart_nonce' => wp_create_nonce('wc_remove_cart_item'),
            'apply_coupon_nonce' => wp_create_nonce('wc_apply_coupon'),
            'remove_coupon_nonce' => wp_create_nonce('wc_remove_coupon'),
            'shop_url' => wc_get_page_permalink('shop'),
            'cart_url' => wc_get_cart_url(),
            'checkout_url' => wc_get_checkout_url(),
            'currency_symbol' => get_woocommerce_currency_symbol(),
            'currency_position' => get_option('woocommerce_currency_pos'),
            'thousand_separator' => wc_get_price_thousand_separator(),
            'decimal_separator' => wc_get_price_decimal_separator(),
            'number_of_decimals' => wc_get_price_decimals(),
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_cart_assets');

/**
 * ================================
 * إصلاح مشاكل الأسعار والقائمة الجانبية
 * ================================
 */

/**
 * إصلاح تنسيق الأسعار في WooCommerce
 */
function fix_woocommerce_price_format() {
    // تعيين رمز العملة
    add_filter('woocommerce_currency_symbol', function($currency_symbol, $currency) {
        switch ($currency) {
            case 'USD':
                return '$';
            case 'EUR':
                return '€';
            case 'SAR':
                return 'ر.س';
            case 'AED':
                return 'د.إ';
            case 'EGP':
                return 'ج.م';
            default:
                return $currency_symbol;
        }
    }, 10, 2);
    
    // تحديد موضع رمز العملة
    add_filter('woocommerce_price_format', function($format, $currency_pos) {
        return '%2$s %1$s'; // افتراضي للعربية: السعر ثم العملة
    }, 10, 2);
    
    // تحديد عدد الخانات العشرية
    add_filter('woocommerce_price_num_decimals', function($decimals) {
        return 2; // عدد الخانات العشرية
    });
    
    // تحديد الفاصل العشري
    add_filter('woocommerce_price_decimal_separator', function($separator) {
        return '.'; // النقطة كفاصل عشري
    });
    
    // تحديد فاصل الآلاف
    add_filter('woocommerce_price_thousand_separator', function($separator) {
        return ','; // الفاصلة لفصل الآلاف
    });
}
add_action('init', 'fix_woocommerce_price_format');

/**
 * إصلاح عرض الأسعار المرتفعة بشكل خاطئ
 */
function normalize_product_prices() {
    // التحقق من الأسعار عند عرض المنتج
    add_filter('woocommerce_get_price_html', function($price, $product) {
        if (!$product) return $price;
        
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        
        // التحقق من الأسعار المرتفعة بشكل غير طبيعي
        if ($regular_price > 1000) {
            // تحويل السعر إلى قيمة معقولة (قسمة على 100 مثلاً)
            $regular_price = $regular_price / 100;
        }
        
        if ($sale_price && $sale_price > 1000) {
            $sale_price = $sale_price / 100;
        }
        
        // إعادة تنسيق السعر
        if ($sale_price && $sale_price < $regular_price) {
            return wc_format_sale_price($regular_price, $sale_price);
        } else {
            return wc_price($regular_price);
        }
    }, 10, 2);
}
add_action('init', 'normalize_product_prices');

/**
 * إخفاء القائمة الجانبية في WooCommerce
 */
function hide_woocommerce_sidebar() {
    // إخفاء القائمة الجانبية من صفحات WooCommerce
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_shop() || is_product_category() || is_product_tag()) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
        
        // إضافة CSS لإخفاء الشريط الجانبي
        add_action('wp_head', function() {
            ?>
            <style>
                /* إخفاء القائمة الجانبية في WooCommerce */
                .woocommerce .sidebar,
                .woocommerce-page .sidebar,
                .woocommerce .widget-area,
                .woocommerce-page .widget-area,
                #secondary,
                .secondary-sidebar,
                .left-sidebar,
                .right-sidebar,
                .shop-sidebar,
                .archive-sidebar,
                .custom-sidebar,
                .widget,
                .widget-container,
                .sidebar-widget {
                    display: none !important;
                    visibility: hidden !important;
                    width: 0 !important;
                    height: 0 !important;
                }
                
                /* إخفاء عناصر البحث والتصنيفات */
                .search-widget,
                .categories-widget,
                .tags-widget,
                .filter-widget,
                .layered-nav,
                .product-categories,
                .product-search,
                .woocommerce-widget-layered-nav,
                .woocommerce-widget-product-categories,
                .woocommerce-widget-product-search,
                .recent-posts,
                .recent-comments,
                .latest-posts,
                .latest-comments,
                .widget_recent_posts,
                .widget_recent_comments,
                .widget_categories,
                .widget_tag_cloud,
                .widget_archive,
                .widget_search,
                .archive-section,
                .categories-section,
                .archive-filters,
                .shop-filters,
                .product-filters {
                    display: none !important;
                }
                
                /* توسيع المحتوى الرئيسي */
                .woocommerce .content-area,
                .woocommerce-page .content-area,
                .woocommerce .site-main,
                .woocommerce-page .site-main,
                .content-area,
                .site-main,
                .main-content,
                .primary,
                .woocommerce,
                .woocommerce-page {
                    width: 100% !important;
                    max-width: 100% !important;
                    margin: 0 !important;
                    float: none !important;
                    clear: both !important;
                }
                
                /* تحسين عرض المنتجات */
                .woocommerce ul.products {
                    display: grid !important;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
                    gap: 2rem !important;
                    padding: 2rem !important;
                    margin: 0 !important;
                    width: 100% !important;
                }
                
                .woocommerce ul.products li.product {
                    width: 100% !important;
                    margin: 0 !important;
                    float: none !important;
                    clear: none !important;
                    background: var(--light, #1a1a1a) !important;
                    border-radius: 15px !important;
                    padding: 1.5rem !important;
                    border: 1px solid rgba(255, 255, 255, 0.1) !important;
                    transition: all 0.3s ease !important;
                    text-align: center !important;
                }
                
                .woocommerce ul.products li.product:hover {
                    transform: translateY(-5px) !important;
                    box-shadow: 0 15px 30px rgba(0, 255, 136, 0.2) !important;
                    border-color: var(--primary, #00ff88) !important;
                }
                
                /* تحسين تنسيق الأسعار */
                .woocommerce .price {
                    font-size: 1.2rem !important;
                    font-weight: bold;
                    color: var(--primary, #00ff88) !important;
                    margin: 0.5rem 0 !important;
                }
                
                .woocommerce .price del {
                    opacity: 0.7;
                    text-decoration: line-through;
                    margin-left: 0.5rem;
                    font-size: 0.9rem !important;
                }
                
                .woocommerce .price ins {
                    text-decoration: none;
                    font-weight: bold;
                }
                
                /* تحسين صور المنتجات */
                .woocommerce ul.products li.product img {
                    width: 100% !important;
                    height: 200px !important;
                    object-fit: cover !important;
                    border-radius: 10px !important;
                    margin-bottom: 1rem !important;
                    transition: transform 0.3s ease !important;
                }
                
                .woocommerce ul.products li.product:hover img {
                    transform: scale(1.05) !important;
                }
                
                /* تحسين عناوين المنتجات */
                .woocommerce ul.products li.product h2,
                .woocommerce ul.products li.product .woocommerce-loop-product__title {
                    font-size: 1.1rem !important;
                    margin-bottom: 0.5rem !important;
                    color: var(--text, #ffffff) !important;
                    line-height: 1.4 !important;
                }
                
                /* تحسين أزرار إضافة للسلة */
                .woocommerce ul.products li.product .button {
                    background: var(--gradient, linear-gradient(135deg, #00ff88, #ff00aa)) !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 25px !important;
                    padding: 0.7rem 1.5rem !important;
                    font-size: 0.95rem !important;
                    transition: all 0.3s ease !important;
                    width: 100% !important;
                    margin-top: 1rem !important;
                }
                
                .woocommerce ul.products li.product .button:hover {
                    transform: translateY(-2px) !important;
                    box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3) !important;
                }
                
                /* للشاشات الكبيرة */
                @media (min-width: 1200px) {
                    .woocommerce ul.products {
                        grid-template-columns: repeat(4, 1fr) !important;
                        max-width: 1400px !important;
                        margin: 0 auto !important;
                    }
                }
                
                /* للشاشات المتوسطة */
                @media (max-width: 1199px) and (min-width: 768px) {
                    .woocommerce ul.products {
                        grid-template-columns: repeat(3, 1fr) !important;
                        padding: 1.5rem !important;
                    }
                }
                
                /* للشاشات الصغيرة */
                @media (max-width: 767px) {
                    .woocommerce ul.products {
                        grid-template-columns: repeat(2, 1fr) !important;
                        gap: 1rem !important;
                        padding: 1rem !important;
                    }
                }
            </style>
            <?php
        });
    }
}
add_action('template_redirect', 'hide_woocommerce_sidebar');

/**
 * تخصيص تخطيط WooCommerce بدون قائمة جانبية
 */
function customize_woocommerce_layout() {
    // تخصيص عدد المنتجات في الصف
    add_filter('loop_shop_columns', function() {
        return 4; // 4 منتجات في الصف على الشاشات الكبيرة
    });
    
    // تخصيص عدد المنتجات المعروضة في الصفحة
    add_filter('loop_shop_per_page', function() {
        return 12; // 12 منتج في الصفحة
    });
}
add_action('init', 'customize_woocommerce_layout');

/**
 * إصلاح مشكلة الأسعار الكبيرة في قاعدة البيانات
 */
function fix_large_prices_in_database() {
    // تشغيل هذه الدالة مرة واحدة لإصلاح الأسعار
    if (get_option('prices_fixed') !== 'yes') {
        
        // الحصول على جميع المنتجات
        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
        ));
        
        foreach ($products as $product) {
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            
            $updated = false;
            
            // إصلاح السعر العادي إذا كان كبيراً جداً
            if ($regular_price && $regular_price > 1000) {
                $new_regular_price = $regular_price / 100; // تقسيم على 100
                $product->set_regular_price($new_regular_price);
                $updated = true;
            }
            
            // إصلاح سعر التخفيض إذا كان كبيراً جداً
            if ($sale_price && $sale_price > 1000) {
                $new_sale_price = $sale_price / 100;
                $product->set_sale_price($new_sale_price);
                $updated = true;
            }
            
            if ($updated) {
                $product->save();
            }
        }
        
        // تسجيل أن الإصلاح تم
        update_option('prices_fixed', 'yes');
    }
}

/**
 * إضافة زر في لوحة التحكم لإصلاح الأسعار يدوياً
 */
function add_price_fix_admin_page() {
    add_submenu_page(
        'woocommerce',
        'إصلاح الأسعار',
        'إصلاح الأسعار',
        'manage_woocommerce',
        'fix-prices',
        'price_fix_admin_page_content'
    );
}
add_action('admin_menu', 'add_price_fix_admin_page');

function price_fix_admin_page_content() {
    if (isset($_POST['fix_prices'])) {
        delete_option('prices_fixed');
        fix_large_prices_in_database();
        echo '<div class="notice notice-success"><p>تم إصلاح الأسعار بنجاح!</p></div>';
    }
    
    if (isset($_POST['reset_flag'])) {
        delete_option('prices_fixed');
        echo '<div class="notice notice-success"><p>تم إعادة تعيين علامة الإصلاح.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>إصلاح أسعار المنتجات</h1>
        <p>استخدم هذه الأدوات لإصلاح الأسعار المرتفعة بشكل غير طبيعي في متجرك.</p>
        
        <form method="post" style="margin-bottom: 20px;">
            <input type="submit" name="fix_prices" class="button button-primary" value="إصلاح الأسعار الآن" 
                   onclick="return confirm('هل أنت متأكد؟ سيتم تقسيم جميع الأسعار الأكبر من 1,000 على 100.')">
        </form>
        
        <form method="post">
            <input type="submit" name="reset_flag" class="button button-secondary" value="إعادة تعيين علامة الإصلاح">
        </form>
        
        <h3>معلومات الحالة:</h3>
        <p><strong>حالة إصلاح الأسعار:</strong> <?php echo get_option('prices_fixed') === 'yes' ? 'تم الإصلاح' : 'لم يتم الإصلاح بعد'; ?></p>
        
        <h3>معاينة الأسعار الحالية:</h3>
        <?php
        if (class_exists('WooCommerce')) {
            $products = wc_get_products(array('limit' => 5));
            if ($products) {
                echo '<table class="wp-list-table widefat fixed striped">';
                echo '<thead><tr><th>اسم المنتج</th><th>السعر العادي</th><th>سعر التخفيض</th></tr></thead>';
                echo '<tbody>';
                
                foreach ($products as $product) {
                    echo '<tr>';
                    echo '<td>' . $product->get_name() . '</td>';
                    echo '<td>' . ($product->get_regular_price() ? wc_price($product->get_regular_price()) : 'غير محدد') . '</td>';
                    echo '<td>' . ($product->get_sale_price() ? wc_price($product->get_sale_price()) : 'غير محدد') . '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<p>لا توجد منتجات في المتجر حالياً.</p>';
            }
        } else {
            echo '<p>WooCommerce غير مثبت أو غير مفعل.</p>';
        }
        ?>
    </div>
    <?php
}

/**
 * تخصيص رسائل WooCommerce للعربية
 */
function customize_woocommerce_messages($translated, $original, $domain) {
    if ($domain === 'woocommerce') {
        switch ($original) {
            case 'Cart updated.':
                return 'تم تحديث السلة بنجاح.';
            case 'Item removed.':
                return 'تم حذف المنتج من السلة.';
            case 'Coupon code applied successfully.':
                return 'تم تطبيق كوبون الخصم بنجاح.';
            case 'Coupon removed successfully.':
                return 'تم إزالة كوبون الخصم بنجاح.';
            case 'Please enter a coupon code.':
                return 'الرجاء إدخال رمز الكوبون.';
            case 'Coupon code does not exist!':
                return 'رمز الكوبون غير موجود!';
            case 'Coupon code already applied!':
                return 'رمز الكوبون مطبق بالفعل!';
            case 'You must be logged in to checkout.':
                return 'يجب تسجيل الدخول لإتمام عملية الشراء.';
            case 'Your cart is currently empty.':
                return 'سلة مشترياتك فارغة حالياً.';
            case 'Return to shop':
                return 'العودة للمتجر';
        }
    }
    return $translated;
}
add_filter('gettext', 'customize_woocommerce_messages', 10, 3);

/**
 * إضافة عداد المنتجات في القائمة
 */
function add_cart_count_to_menu($items, $args) {
    if ($args->theme_location == 'primary' && class_exists('WooCommerce')) {
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_url = wc_get_cart_url();
        
        $cart_item = '<li class="menu-item cart-menu-item">';
        $cart_item .= '<a href="' . esc_url($cart_url) . '" class="cart-link">';
        $cart_item .= '🛒 <span class="cart-count">' . $cart_count . '</span>';
        $cart_item .= '</a>';
        $cart_item .= '</li>';
        
        $items .= $cart_item;
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'add_cart_count_to_menu', 10, 2);

/**
 * تحسين أداء WooCommerce
 */
function optimize_woocommerce_performance() {
    // إزالة الأنماط غير المستخدمة
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'optimize_woocommerce_performance', 99);

/**
 * دالة إنشاء breadcrumbs
 */
function cryptocoin_live_breadcrumbs() {
    if (is_front_page()) return;
    
    echo '<nav class="breadcrumbs" aria-label="مسار التنقل">';
    echo '<a href="' . home_url() . '">' . __('الرئيسية', 'cryptocoin-live') . '</a>';
    
    if (is_category() || is_single()) {
        echo ' / ';
        if (is_single()) {
            $categories = get_the_category();
            if ($categories) {
                $category = $categories[0];
                echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                echo ' / ';
            }
        }
        if (is_category()) {
            echo single_cat_title('', false);
        } else {
            echo get_the_title();
        }
    } elseif (is_page()) {
        $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
        foreach ($ancestors as $ancestor) {
            echo ' / <a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
        }
        echo ' / ' . get_the_title();
    } elseif (is_search()) {
        echo ' / ' . __('نتائج البحث عن:', 'cryptocoin-live') . ' "' . get_search_query() . '"';
    } elseif (is_404()) {
        echo ' / ' . __('صفحة غير موجودة', 'cryptocoin-live');
    } elseif (is_archive()) {
        echo ' / ' . get_the_archive_title();
    } elseif (is_author()) {
        echo ' / ' . __('مقالات الكاتب:', 'cryptocoin-live') . ' ' . get_the_author();
    } elseif (is_tag()) {
        echo ' / ' . __('الوسم:', 'cryptocoin-live') . ' ' . single_tag_title('', false);
    } elseif (is_day()) {
        echo ' / ' . __('أرشيف يوم:', 'cryptocoin-live') . ' ' . get_the_date();
    } elseif (is_month()) {
        echo ' / ' . __('أرشيف شهر:', 'cryptocoin-live') . ' ' . get_the_date('F Y');
    } elseif (is_year()) {
        echo ' / ' . __('أرشيف سنة:', 'cryptocoin-live') . ' ' . get_the_date('Y');
    }
    
    echo '</nav>';
}

/**
 * دالة pagination مخصصة
 */
function cryptocoin_live_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    echo paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => __('&laquo; السابق', 'cryptocoin-live'),
        'next_text' => __('التالي &raquo;', 'cryptocoin-live'),
        'type'      => 'list',
        'end_size'  => 3,
        'mid_size'  => 3
    ));
}

/**
 * دالة إنشاء مقتطف مخصص
 */
function cryptocoin_live_excerpt($limit = 20) {
    return wp_trim_words(get_the_excerpt(), $limit, '...');
}

/**
 * دالة عرض الوقت بصيغة عربية
 */
function cryptocoin_live_time_ago($date) {
    $time_diff = time() - strtotime($date);
    
    if ($time_diff < 60) {
        return __('منذ لحظات', 'cryptocoin-live');
    } elseif ($time_diff < 3600) {
        $minutes = floor($time_diff / 60);
        return sprintf(_n('منذ %d دقيقة', 'منذ %d دقائق', $minutes, 'cryptocoin-live'), $minutes);
    } elseif ($time_diff < 86400) {
        $hours = floor($time_diff / 3600);
        return sprintf(_n('منذ %d ساعة', 'منذ %d ساعات', $hours, 'cryptocoin-live'), $hours);
    } elseif ($time_diff < 2592000) {
        $days = floor($time_diff / 86400);
        return sprintf(_n('منذ %d يوم', 'منذ %d أيام', $days, 'cryptocoin-live'), $days);
    } else {
        return date_i18n(get_option('date_format'), strtotime($date));
    }
}

/**
 * تسجيل الشريط الجانبي والودجات
 */
function cryptocoin_live_widgets_init() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'cryptocoin-live'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your main sidebar.', 'cryptocoin-live'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widgets', 'cryptocoin-live'),
        'id'            => 'footer-widgets',
        'description'   => __('Add widgets here to appear in your footer.', 'cryptocoin-live'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Hero Section', 'cryptocoin-live'),
        'id'            => 'hero-section',
        'description'   => __('Add widgets here to appear in the hero section.', 'cryptocoin-live'),
        'before_widget' => '<div id="%1$s" class="hero-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="hero-widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'cryptocoin_live_widgets_init');

/**
 * ================================
 * إضافة hooks لتسجيل تغييرات الاشتراك
 * ================================
 */

// تسجيل جميع أحداث الطلبات للتشخيص
add_action('woocommerce_order_status_changed', 'log_order_status_changes', 10, 4);

function log_order_status_changes($order_id, $old_status, $new_status, $order) {
    error_log("CryptoAI: Order {$order_id} status changed from {$old_status} to {$new_status}");
    
    // إرسال webhook عند التغيير إلى completed أو processing
    if ($new_status === 'completed' || $new_status === 'processing') {
        // تأخير قصير للتأكد من حفظ البيانات
        wp_schedule_single_event(time() + 5, 'crypto_delayed_webhook', array($order_id));
    }
}

// hook للمعالجة المؤجلة
add_action('crypto_delayed_webhook', 'crypto_delayed_webhook_handler');

function crypto_delayed_webhook_handler($order_id) {
    crypto_auto_webhook($order_id);
}

/**
 * إضافة تحديث تلقائي لحالة الطلب عند الحفظ اليدوي
 */
add_action('woocommerce_process_shop_order_meta', 'crypto_order_manual_update', 20, 2);

function crypto_order_manual_update($order_id, $post) {
    // التحقق من أن الطلب مكتمل
    $order = wc_get_order($order_id);
    if ($order && ($order->get_status() === 'completed' || $order->get_status() === 'processing')) {
        
        // التحقق من عدم المعالجة السابقة
        $last_processed = get_post_meta($order_id, '_crypto_last_processed', true);
        if (!$last_processed) {
            error_log("CryptoAI: Manual order update detected for order {$order_id}");
            crypto_auto_webhook($order_id);
        }
    }
}

/**
 * ================================
 * إضافة إشعارات إدارية للطلبات غير المعالجة
 * ================================
 */

add_action('admin_notices', 'crypto_admin_notices');

function crypto_admin_notices() {
    // عرض الإشعار فقط في صفحات WooCommerce
    $screen = get_current_screen();
    if (!$screen || strpos($screen->id, 'woocommerce') === false) {
        return;
    }
    
    // البحث عن طلبات غير معالجة
    $unprocessed_orders = get_posts(array(
        'post_type' => 'shop_order',
        'post_status' => 'wc-completed',
        'meta_query' => array(
            array(
                'key' => '_crypto_last_processed',
                'compare' => 'NOT EXISTS'
            )
        ),
        'numberposts' => 5,
        'date_query' => array(
            array(
                'after' => '1 week ago'
            )
        )
    ));
    
    if ($unprocessed_orders) {
        $count = count($unprocessed_orders);
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>CryptoAI:</strong> يوجد ' . $count . ' طلب مكتمل لم تتم معالجته لتحديث اشتراكات العملاء. ';
        echo '<a href="' . admin_url('admin.php?page=crypto_manual_process') . '">معالجة الطلبات</a></p>';
        echo '</div>';
    }
}

/**
 * ================================
 * إضافة قائمة بجميع الطلبات غير المعالجة
 * ================================
 */

add_action('admin_menu', 'add_crypto_orders_list_page');

function add_crypto_orders_list_page() {
    add_submenu_page(
        'woocommerce',
        'CryptoAI Orders',
        'CryptoAI Orders',
        'manage_woocommerce',
        'crypto_orders_list',
        'crypto_orders_list_page'
    );
}

function crypto_orders_list_page() {
    ?>
    <div class="wrap">
        <h1>🚀 CryptoAI Orders Management</h1>
        
        <?php
        // معالجة الطلبات المحددة
        if (isset($_POST['process_selected']) && isset($_POST['order_ids'])) {
            $processed_count = 0;
            foreach ($_POST['order_ids'] as $order_id) {
                crypto_auto_webhook((int)$order_id);
                $processed_count++;
            }
            
            echo '<div class="notice notice-success"><p>تم معالجة ' . $processed_count . ' طلب بنجاح!</p></div>';
        }
        
        // جلب جميع الطلبات المكتملة
        $all_orders = get_posts(array(
            'post_type' => 'shop_order',
            'post_status' => 'wc-completed',
            'numberposts' => 50,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if ($all_orders) {
            ?>
            <form method="post">
                <div class="tablenav top">
                    <div class="alignleft actions">
                        <input type="submit" name="process_selected" class="button button-primary" value="معالجة المحدد">
                    </div>
                </div>
                
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <td class="manage-column column-cb check-column">
                                <input type="checkbox" id="cb-select-all">
                            </td>
                            <th>رقم الطلب</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>المبلغ</th>
                            <th>حالة CryptoAI</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_orders as $order_post) {
                            $order = wc_get_order($order_post->ID);
                            $last_processed = get_post_meta($order_post->ID, '_crypto_last_processed', true);
                            $crypto_status = $last_processed ? 'معالج' : 'غير معالج';
                            $status_color = $last_processed ? 'green' : 'red';
                            
                            ?>
                            <tr>
                                <th class="check-column">
                                    <?php if (!$last_processed): ?>
                                    <input type="checkbox" name="order_ids[]" value="<?php echo $order_post->ID; ?>">
                                    <?php endif; ?>
                                </th>
                                <td><strong>#<?php echo $order_post->ID; ?></strong></td>
                                <td><?php echo $order->get_date_created()->format('Y-m-d H:i'); ?></td>
                                <td><?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></td>
                                <td><?php echo $order->get_total() . ' ' . $order->get_currency(); ?></td>
                                <td style="color: <?php echo $status_color; ?>">
                                    <?php echo $crypto_status; ?>
                                    <?php if ($last_processed): ?>
                                        <br><small><?php echo $last_processed; ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo admin_url('post.php?post=' . $order_post->ID . '&action=edit'); ?>" class="button button-small">تحرير</a>
                                    <?php if (!$last_processed): ?>
                                    <a href="<?php echo admin_url('admin.php?page=crypto_manual_process&order_id=' . $order_post->ID); ?>" class="button button-small button-primary">معالجة</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            
            <script>
                document.getElementById('cb-select-all').addEventListener('change', function() {
                    var checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = this.checked;
                    }
                });
            </script>
            <?php
        } else {
            echo '<p>لا توجد طلبات مكتملة.</p>';
        }
        ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            <h3>📊 إحصائيات سريعة</h3>
            <?php
            $total_orders = count($all_orders);
            $processed_orders = 0;
            $unprocessed_orders = 0;
            
            foreach ($all_orders as $order_post) {
                $last_processed = get_post_meta($order_post->ID, '_crypto_last_processed', true);
                if ($last_processed) {
                    $processed_orders++;
                } else {
                    $unprocessed_orders++;
                }
            }
            
            $processing_rate = $total_orders > 0 ? round(($processed_orders / $total_orders) * 100, 1) : 0;
            ?>
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 15px;">
                <div style="text-align: center; padding: 15px; background: white; border-radius: 5px;">
                    <h4 style="margin: 0; color: #333;">إجمالي الطلبات</h4>
                    <p style="font-size: 24px; font-weight: bold; margin: 5px 0; color: #007cba;"><?php echo $total_orders; ?></p>
                </div>
                
                <div style="text-align: center; padding: 15px; background: white; border-radius: 5px;">
                    <h4 style="margin: 0; color: #333;">تم معالجتها</h4>
                    <p style="font-size: 24px; font-weight: bold; margin: 5px 0; color: #28a745;"><?php echo $processed_orders; ?></p>
                </div>
                
                <div style="text-align: center; padding: 15px; background: white; border-radius: 5px;">
                    <h4 style="margin: 0; color: #333;">غير معالجة</h4>
                    <p style="font-size: 24px; font-weight: bold; margin: 5px 0; color: #dc3545;"><?php echo $unprocessed_orders; ?></p>
                </div>
                
                <div style="text-align: center; padding: 15px; background: white; border-radius: 5px;">
                    <h4 style="margin: 0; color: #333;">معدل المعالجة</h4>
                    <p style="font-size: 24px; font-weight: bold; margin: 5px 0; color: #6f42c1;"><?php echo $processing_rate; ?>%</p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
// إكمال بيانات Checkout تلقائياً للمستخدمين المسجلين
add_filter('woocommerce_checkout_get_value', 'auto_fill_checkout_fields', 10, 2);
function auto_fill_checkout_fields($value, $input) {
    if (is_user_logged_in() && !$value) {
        $user = wp_get_current_user();
        
        switch ($input) {
            case 'billing_first_name':
                return $user->display_name ?: $user->user_login;
            case 'billing_email':
                return $user->user_email;
            case 'billing_country':
                return 'SA';
            case 'billing_city':
                return 'الرياض';
            case 'billing_address_1':
                return 'عنوان افتراضي';
            case 'billing_postcode':
                return '12345';
        }
    }
    return $value;
}

// تفعيل SSO التلقائي
add_action('init', 'crypto_sso_auto_login');
function crypto_sso_auto_login() {
    // إذا كان المستخدم مسجل دخول بالفعل، لا نحتاج شيء
    if (is_user_logged_in()) {
        return;
    }
    
    // التحقق من وجود توكن SSO
    $sso_token = null;
    
    // من الكوكيز
    if (isset($_COOKIE['crypto_sso_token'])) {
        $sso_token = $_COOKIE['crypto_sso_token'];
    }
    
    // من الـ URL (احتياطي)
    if (!$sso_token && isset($_GET['sso_token'])) {
        $sso_token = $_GET['sso_token'];
    }
    
    if ($sso_token) {
        crypto_process_sso_login($sso_token);
    }
}

function crypto_process_sso_login($token) {
    $secret_key = 'scsSx%n2s9MpU$%h!kllfjv'; // نفس المفتاح المستخدم في الموقع الأساسي
    
    $parts = explode('.', $token);
    if (count($parts) !== 2) return false;
    
    list($data, $signature) = $parts;
    
    // التحقق من التوقيع
    if (!hash_equals($signature, hash_hmac('sha256', $data, $secret_key))) {
        return false;
    }
    
    $token_data = json_decode(base64_decode($data), true);
    
    // التحقق من انتهاء الصلاحية
    if ($token_data['expires'] < time()) {
        return false;
    }
    
    // البحث عن المستخدم في WordPress
    $wp_user = get_user_by('email', $token_data['email']);
    
    if (!$wp_user) {
        // إنشاء مستخدم جديد
        $wp_user = crypto_create_wp_user_from_sso($token_data);
    }
    
    if ($wp_user) {
        // تسجيل دخول تلقائي
        wp_set_current_user($wp_user->ID);
        wp_set_auth_cookie($wp_user->ID, true);
        
        // تحديث آخر نشاط
        update_user_meta($wp_user->ID, 'last_sso_login', time());
        
        // إعادة توجيه لتجنب عرض التوكن في الـ URL
        if (isset($_GET['sso_token'])) {
            $redirect_url = remove_query_arg('sso_token');
            wp_redirect($redirect_url);
            exit;
        }
    }
}

function crypto_create_wp_user_from_sso($token_data) {
    $username = crypto_generate_unique_username($token_data['username'], $token_data['user_id']);
    
    $user_data = [
        'user_login' => $username,
        'user_email' => $token_data['email'],
        'user_pass' => wp_generate_password(12, false),
        'display_name' => $token_data['username'],
        'first_name' => $token_data['username'],
        'role' => 'customer'
    ];
    
    $user_id = wp_insert_user($user_data);
    
    if (!is_wp_error($user_id)) {
        // ربط المستخدم
        update_user_meta($user_id, 'crypto_user_id', $token_data['user_id']);
        update_user_meta($user_id, 'sso_created', true);
        
        return get_user_by('id', $user_id);
    }
    
    return false;
}

function crypto_generate_unique_username($base_username, $user_id) {
    $username = sanitize_user($base_username . '_' . $user_id);
    $original_username = $username;
    $counter = 1;
    
    while (username_exists($username)) {
        $username = $original_username . '_' . $counter;
        $counter++;
    }
    
    return $username;
}

// إضافة رابط للعودة للموقع الأساسي
add_action('woocommerce_account_dashboard', 'crypto_add_main_site_link');
function crypto_add_main_site_link() {
    echo '<div class="woocommerce-info" style="margin-bottom: 20px;">';
    echo '<a href="https://cryptocoinlive.co/" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">';
    echo '🏠 <strong>العودة للموقع الرئيسي - لوحة التحكم</strong>';
    echo '</a>';
    echo '</div>';
}

// تسجيل خروج موحد
add_action('wp_logout', 'crypto_sso_logout');
function crypto_sso_logout() {
    // حذف كوكيز SSO
    setcookie('crypto_sso_token', '', time() - 3600, '/', '.cryptocoinlive.co');
}

// === نهاية نظام SSO ===
?>