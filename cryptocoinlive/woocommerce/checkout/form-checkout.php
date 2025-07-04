<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 */

defined( 'ABSPATH' ) || exit;

// Get site settings
global $wpdb;
$siteSettings = [
    'site_name' => get_bloginfo('name'),
    'support_email' => get_option('admin_email')
];

do_action( 'woocommerce_before_checkout_form_cart_notices' );
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الطلب - <?php echo esc_html($siteSettings['site_name']); ?></title>
    
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

        /* Checkout Styles */
        .checkout-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .checkout-form {
            background: var(--light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(0, 255, 136, 0.2);
            position: relative;
            overflow: hidden;
        }

        .checkout-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient);
        }

        .order-summary {
            background: var(--light);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 0, 170, 0.2);
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .order-summary::before {
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

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .form-section h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-row {
            display: grid;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-row.two-columns {
            grid-template-columns: 1fr 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: var(--text);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group label .required {
            color: var(--error);
        }

        .form-control {
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        /* Order Summary */
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-info h4 {
            color: var(--text);
            margin-bottom: 0.3rem;
            font-size: 1rem;
        }

        .item-details {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: bold;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .order-totals {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--primary);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .total-row.final-total {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary);
            padding: 1rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 0.5rem;
        }

        /* Payment Methods */
        .payment-methods {
            margin-top: 2rem;
        }

        .payment-method {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: var(--primary);
            background: rgba(0, 255, 136, 0.05);
        }

        .payment-method input[type="radio"] {
            display: none;
        }

        .payment-method label {
            display: block;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method input[type="radio"]:checked + label {
            background: rgba(0, 255, 136, 0.1);
            border-left: 4px solid var(--primary);
        }

        .payment-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-left: 10px;
            vertical-align: middle;
        }

        /* Place Order Button */
        .place-order-btn {
            width: 100%;
            background: var(--gradient);
            color: white;
            padding: 1.2rem 2rem;
            border-radius: 15px;
            border: none;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .place-order-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .place-order-btn:hover::before {
            left: 100%;
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 255, 136, 0.3);
        }

        .place-order-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Error Messages */
        .error-message {
            background: rgba(255, 0, 85, 0.1);
            border: 1px solid rgba(255, 0, 85, 0.3);
            color: var(--error);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-size: 0.95rem;
        }

        /* Success Messages */
        .success-message {
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid rgba(0, 255, 136, 0.3);
            color: var(--success);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-size: 0.95rem;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding: 0.8rem;
            background: rgba(0, 255, 136, 0.1);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--success);
        }

        /* Progress Steps */
        .checkout-progress {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .progress-step.active {
            background: var(--gradient);
            color: white;
        }

        .progress-step.completed {
            background: rgba(0, 255, 136, 0.2);
            color: var(--success);
        }

        /* Responsive */
        @media (max-width: 968px) {
            .checkout-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .order-summary {
                position: static;
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .form-row.two-columns {
                grid-template-columns: 1fr;
            }

            .nav-links a:not(.btn-primary) {
                display: none;
            }

            .page-title {
                font-size: 2rem;
            }

            .checkout-progress {
                flex-direction: column;
                align-items: center;
            }
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

        /* Hide WooCommerce default styles */
        .woocommerce-checkout .col2-set,
        .woocommerce-checkout .woocommerce-checkout-review-order-table,
        .woocommerce-checkout #order_review_heading,
        .woocommerce-checkout .woocommerce-checkout-payment {
            display: none !important;
        }

        /* Custom form styling */
        .woocommerce-input-wrapper {
            position: relative;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 10px !important;
            color: var(--text) !important;
            padding: 1rem !important;
            min-height: auto !important;
        }

        .select2-selection:focus {
            border-color: var(--primary) !important;
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
                <a href="<?php echo wc_get_cart_url(); ?>">السلة</a>
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
            <h1 class="page-title">🛒 إتمام الطلب</h1>

            <!-- Progress Steps -->
            <div class="checkout-progress">
                <div class="progress-step completed">
                    <span>✓</span> السلة
                </div>
                <div class="progress-step active">
                    <span>📝</span> بيانات الشحن
                </div>
                <div class="progress-step">
                    <span>💳</span> الدفع
                </div>
                <div class="progress-step">
                    <span>✅</span> تأكيد الطلب
                </div>
            </div>

            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                <div class="checkout-container">
                    <!-- Checkout Form -->
                    <div class="checkout-form">
                        <h2 class="section-title">
                            <span>📝</span> بيانات الطلب
                        </h2>

                        <?php if ( $checkout->get_checkout_fields() ) : ?>

                            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                            <!-- Billing Details -->
                            <div class="form-section">
                                <h3><span>👤</span> بيانات الفاتورة</h3>
                                
                                <?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>
                                    <div class="form-group">
                                        <?php 
                                        $field['class'] = array('form-control');
                                        $field['input_class'] = array('form-control');
                                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                                        ?>
                                    </div>
                                <?php endforeach; ?>

                                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                            </div>

                            <!-- Shipping Details -->
                            <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
                                <div class="form-section">
                                    <h3><span>🚚</span> بيانات الشحن</h3>
                                    
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="ship_to_different_address" name="ship_to_different_address" value="1" <?php checked( $checkout->get_value( 'ship_to_different_address' ), 1 ); ?>>
                                        <label for="ship_to_different_address">الشحن لعنوان مختلف؟</label>
                                    </div>

                                    <div class="shipping-fields" style="<?php echo ! $checkout->get_value( 'ship_to_different_address' ) ? 'display: none;' : ''; ?>">
                                        <?php foreach ( $checkout->get_checkout_fields( 'shipping' ) as $key => $field ) : ?>
                                            <div class="form-group">
                                                <?php 
                                                $field['class'] = array('form-control');
                                                $field['input_class'] = array('form-control');
                                                woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                                                ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Order Notes -->
                            <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_checkout_order_notes_field' ) ) ) : ?>
                                <div class="form-section">
                                    <h3><span>📝</span> ملاحظات إضافية</h3>
                                    <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                                        <div class="form-group">
                                            <?php 
                                            $field['class'] = array('form-control');
                                            $field['input_class'] = array('form-control');
                                            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); 
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                        <!-- Payment Methods -->
                        <div class="form-section">
                            <h3><span>💳</span> طريقة الدفع</h3>
                            
                            <?php if ( WC()->cart->needs_payment() ) : ?>
                                <div class="payment-methods">
                                    <?php
                                    $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                                    if ( ! empty( $available_gateways ) ) :
                                        foreach ( $available_gateways as $gateway ) :
                                    ?>
                                        <div class="payment-method">
                                            <input type="radio" id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?>>
                                            <label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                                                <span class="payment-icon"><?php echo $gateway->get_icon(); ?></span>
                                                <?php echo $gateway->get_title(); ?>
                                                <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
                                                    <div class="payment-description" style="margin-top: 0.5rem; font-size: 0.9rem; color: rgba(255,255,255,0.7);">
                                                        <?php echo wp_kses_post( $gateway->get_description() ); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php 
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Security Badge -->
                            <div class="security-badge">
                                <span>🔒</span>
                                <span>معاملتك آمنة ومحمية بأحدث تقنيات التشفير</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <h2 class="section-title">
                            <span>📋</span> ملخص الطلب
                        </h2>

                        <!-- Order Items -->
                        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                        ?>
                            <div class="order-item">
                                <div class="item-info">
                                    <h4><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?></h4>
                                    <div class="item-details">
                                        الكمية: <?php echo esc_html( $cart_item['quantity'] ); ?>
                                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                </div>
                            </div>
                        <?php endif; endforeach; ?>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="total-row">
                                <span>المجموع الفرعي:</span>
                                <span><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>

                            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                                <div class="total-row">
                                    <span>كوبون (<?php echo esc_html( $code ); ?>):</span>
                                    <span>-<?php wc_cart_totals_coupon_html( $coupon ); ?></span>
                                </div>
                            <?php endforeach; ?>

                            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                                <div class="total-row">
                                    <span>الشحن:</span>
                                    <span><?php wc_cart_totals_shipping_html(); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                <div class="total-row">
                                    <span><?php echo esc_html( $fee->name ); ?>:</span>
                                    <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
                                </div>
                            <?php endforeach; ?>

                            <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                                <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                                        <div class="total-row">
                                            <span><?php echo esc_html( $tax->label ); ?>:</span>
                                            <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="total-row">
                                        <span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</span>
                                        <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="total-row final-total">
                                <span>الإجمالي:</span>
                                <span><?php wc_cart_totals_order_total_html(); ?></span>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <?php if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) : ?>
                            <div class="checkbox-group" style="margin-top: 1.5rem;">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">
                                    أوافق على <a href="<?php echo esc_url( wc_get_page_permalink( 'terms' ) ); ?>" target="_blank" style="color: var(--primary);">الشروط والأحكام</a> *
                                </label>
                            </div>
                        <?php endif; ?>

                        <!-- Place Order Button -->
                        <button type="submit" class="place-order-btn" id="place_order">
                            <span>🚀</span> إتمام الطلب
                        </button>

                        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                    </div>
                </div>

            </form>

            <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
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

        // التعامل مع عنوان شحن مختلف
        document.getElementById('ship_to_different_address').addEventListener('change', function() {
            const shippingFields = document.querySelector('.shipping-fields');
            if (this.checked) {
                shippingFields.style.display = 'block';
            } else {
                shippingFields.style.display = 'none';
            }
        });

        // التعامل مع إرسال النموذج
        document.querySelector('.checkout').addEventListener('submit', function(e) {
            showLoading();
            
            // التحقق من الشروط والأحكام
            const termsCheckbox = document.getElementById('terms');
            if (termsCheckbox && !termsCheckbox.checked) {
                e.preventDefault();
                hideLoading();
                alert('يجب الموافقة على الشروط والأحكام');
                return false;
            }
            
            // التحقق من بيانات الدفع
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                hideLoading();
                alert('يرجى اختيار طريقة دفع');
                return false;
            }
        });

        // تحديث التقدم عند تغيير البيانات
        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('change', function() {
                // تحديث مؤشر التقدم هنا إذا لزم الأمر
            });
        });

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

        // تحسين تجربة المستخدم
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading();
            
            // تركيز على أول حقل
            const firstInput = document.querySelector('.form-control');
            if (firstInput) {
                firstInput.focus();
            }
            
            // إضافة تأثيرات التحميل للحقول
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                group.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });

        // معالجة أخطاء الشبكة
        window.addEventListener('online', function() {
            hideLoading();
        });

        window.addEventListener('offline', function() {
            alert('تم قطع الاتصال بالإنترنت. يرجى التحقق من الاتصال والمحاولة مرة أخرى.');
            hideLoading();
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>