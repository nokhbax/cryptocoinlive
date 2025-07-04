<?php
/**
 * The main template file
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    
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
            background: rgba(10, 10, 10, 0.8);
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

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
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

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            margin-top: 60px;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2rem, 8vw, 4rem);
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideInUp 1s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.8;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        /* Upload Section */
        .upload-section {
            max-width: 600px;
            margin: 0 auto;
            animation: slideInUp 1s ease-out 0.4s both;
        }

        .upload-area {
            background: var(--light);
            border: 2px dashed var(--primary);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: var(--secondary);
            background: rgba(0, 255, 136, 0.05);
        }

        .upload-area.dragover {
            background: rgba(0, 255, 136, 0.1);
            border-color: var(--primary);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        #fileInput, #cameraInput {
            display: none;
        }

        .upload-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--dark);
            transform: translateY(-2px);
        }

        .btn-camera {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--text);
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .btn-camera:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: var(--darker);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--light);
            padding: 2rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0, 255, 136, 0.2);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        /* Pricing Section */
        .pricing {
            padding: 5rem 2rem;
            background: var(--dark);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .pricing-card {
            background: var(--light);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .pricing-card.featured {
            border: 2px solid var(--primary);
            transform: scale(1.05);
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 255, 136, 0.2);
        }

        .price {
            font-size: 3rem;
            font-weight: bold;
            margin: 1rem 0;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .price-period {
            font-size: 1rem;
            opacity: 0.7;
        }

        .price-features {
            list-style: none;
            margin: 2rem 0;
        }

        .price-features li {
            padding: 0.5rem 0;
            opacity: 0.8;
        }

        .price-features .highlight {
            color: var(--primary);
            font-weight: bold;
        }

        /* Footer */
        footer {
            background: var(--dark);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3rem 2rem 2rem;
            margin-top: 5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary);
            transform: translateX(-5px);
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: bold;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: var(--text);
            text-decoration: none;
            font-size: 1.2rem;
        }

        .social-links a:hover {
            background: var(--gradient);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        .footer-bottom a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links a:not(.btn-primary) {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .upload-buttons {
                flex-direction: column;
            }

            .pricing-card.featured {
                transform: scale(1);
            }

            .features-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
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
            <div class="logo"><?php bloginfo('name'); ?></div>
            <div class="nav-links">
                <a href="<?php echo home_url(); ?>">الرئيسية</a>
                <a href="#features">المميزات</a>
                <a href="#pricing">الأسعار</a>
                <?php if (class_exists('WooCommerce')): ?>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>">المتجر</a>
                    <a href="<?php echo wc_get_cart_url(); ?>">السلة (<?php echo WC()->cart->get_cart_contents_count(); ?>)</a>
                <?php endif; ?>
                <a href="<?php echo wp_login_url(); ?>" class="btn-primary">تسجيل الدخول</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1><?php echo get_theme_mod('hero_title', 'تحليل العملات الرقمية بالذكاء الاصطناعي'); ?></h1>
            <p><?php echo get_theme_mod('hero_description', 'احصل على توقعات دقيقة لاتجاه السوق باستخدام أحدث تقنيات الذكاء الاصطناعي'); ?></p>
            
            <!-- Upload Section -->
            <div class="upload-section">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">📊</div>
                    <h3>ارفع صورة الشارت</h3>
                    <p>اسحب وأفلت الصورة هنا أو انقر للاختيار</p>
                    <div class="upload-buttons">
                        <button class="btn-primary" onclick="document.getElementById('fileInput').click()">
                            <span>📁</span> اختر من الجهاز
                        </button>
                        <button class="btn-camera" onclick="openCamera()" id="cameraBtn">
                            <span>📷</span> التقط صورة
                        </button>
                    </div>
                    <input type="file" id="fileInput" accept="image/*" style="display: none;">
                    <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display: none;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">مميزات النظام</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3>ذكاء اصطناعي متطور</h3>
                    <p>نموذج مدرب لتحليل الصور بنسبة دقة عالية</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>تحليل فوري</h3>
                    <p>احصل على النتائج في ثوانٍ معدودة</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3>دقة عالية</h3>
                    <p>إذا وجدت نسبة توقع عالية اغتنم الفرصة</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📷</div>
                    <h3>التقاط مباشر</h3>
                    <p>صور الشارت مباشرة من هاتفك</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>أمان وخصوصية</h3>
                    <p>بياناتك محمية بأحدث تقنيات التشفير</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>متوافق مع جميع الأجهزة</h3>
                    <p>يعمل بكفاءة على جميع الأجهزة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            <h2 class="section-title">خطط الاشتراكات</h2>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3>مجاني</h3>
                    <div class="price">0<span class="price-period"> دولار/شهر</span></div>
                    <ul class="price-features">
                        <li>✓ 2 تحليلات يومياً</li>
                        <li>✓ تحليل الصور بالذكاء الاصطناعي</li>
                        <li>✓ دقة أساسية</li>
                        <li>✗ توصيات متقدمة</li>
                        <li>✗ دعم فني</li>
                    </ul>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="width: 100%;">ابدأ مجاناً</a>
                </div>
                
                <div class="pricing-card featured">
                    <h3>شهري</h3>
                    <div class="price">25<span class="price-period"> دولار/شهر</span></div>
                    <ul class="price-features">
                        <li>✓ تحليلات غير محدودة</li>
                        <li class="highlight">✓ تحليل الصور بالذكاء الاصطناعي</li>
                        <li>✓ دقة عالية</li>
                        <li>✓ توصيات متقدمة</li>
                        <li>✓ دعم فني 24/7</li>
                    </ul>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="width: 100%;">اشترك الآن</a>
                </div>
                
                <div class="pricing-card">
                    <h3>سنوي</h3>
                    <div class="price">250<span class="price-period"> دولار/سنة</span></div>
                    <ul class="price-features">
                        <li>✓ تحليلات غير محدودة</li>                        
                        <li class="highlight">✓ تحليل الصور بالذكاء الاصطناعي</li>
                        <li>✓ دقة عالية</li>
                        <li>✓ توصيات متقدمة</li>
                        <li>✓ دعم فني 24/7</li>
                        <li class="highlight">✓ وفر شهرين مجاناً!</li>
                    </ul>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="width: 100%;">اشترك الآن</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo"><?php bloginfo('name'); ?></div>
                <p class="footer-description">
                    <?php echo get_theme_mod('footer_description', 'منصة متقدمة لتحليل العملات الرقمية باستخدام الذكاء الاصطناعي. نساعدك في اتخاذ قرارات استثمارية ذكية.'); ?>
                </p>
                <div class="social-links">
                    <?php if (get_theme_mod('twitter_url')): ?>
                        <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>" target="_blank" title="تابعنا على X">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php if (get_theme_mod('tiktok_url')): ?>
                        <a href="<?php echo esc_url(get_theme_mod('tiktok_url')); ?>" target="_blank" title="تابعنا على TikTok">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.38 6.38 0 0 0-6.35 6.39 6.38 6.38 0 0 0 6.38 6.38 6.38 6.38 0 0 0 6.37-6.38V8.83a8.28 8.28 0 0 0 4.79 1.52v-3.4a4.85 4.85 0 0 1-1.96-.26z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <a href="mailto:<?php echo get_option('admin_email'); ?>" title="راسلنا عبر البريد الإلكتروني">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-section">
                <h3>روابط سريعة</h3>
                <ul>
                    <li><a href="<?php echo home_url(); ?>">الرئيسية</a></li>
                    <li><a href="#features">المميزات</a></li>
                    <li><a href="#pricing">الأسعار</a></li>
                    <?php if (class_exists('WooCommerce')): ?>
                        <li><a href="<?php echo wc_get_page_permalink('shop'); ?>">المتجر</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo get_permalink(get_page_by_path('about')); ?>">من نحن</a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('contact')); ?>">اتصل بنا</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>للمستخدمين</h3>
                <ul>
                    <li><a href="<?php echo wp_login_url(); ?>">تسجيل الدخول</a></li>
                    <li><a href="<?php echo wp_registration_url(); ?>">إنشاء حساب</a></li>
                    <li><a href="<?php echo wp_lostpassword_url(); ?>">نسيت كلمة المرور</a></li>
                    <?php if (get_page_by_path('api-docs')): ?>
                        <li><a href="<?php echo get_permalink(get_page_by_path('api-docs')); ?>">API للمطورين</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-section">
                <h3>قانوني</h3>
                <ul>
                    <li><a href="<?php echo get_permalink(get_page_by_path('terms')); ?>">شروط الاستخدام</a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('privacy')); ?>">سياسة الخصوصية</a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('cookies')); ?>">سياسة الكوكيز</a></li>
                    <li><a href="<?php echo get_permalink(get_page_by_path('disclaimer')); ?>">إخلاء المسؤولية</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo get_theme_mod('footer_copyright', 'جميع الحقوق محفوظة.'); ?> | تم التطوير بواسطة <a href="#">فريق <?php bloginfo('name'); ?></a></p>
        </div>
    </footer>

    <script>
        // إنشاء الجسيمات المتحركة
        const particlesContainer = document.getElementById('particles');
        if (particlesContainer) {
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // وظائف الرفع والكاميرا
        function openCamera() {
            alert('ميزة الكاميرا ستكون متاحة قريباً! يرجى استخدام رفع الملف حالياً.');
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

        // تأثير التمرير على التنقل
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (nav) {
                if (window.pageYOffset > 100) {
                    nav.style.background = 'rgba(10, 10, 10, 0.95)';
                    nav.style.padding = '0.5rem 2rem';
                } else {
                    nav.style.background = 'rgba(10, 10, 10, 0.8)';
                    nav.style.padding = '1rem 2rem';
                }
            }
        });

        // تحريك العناصر عند التمرير
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // مراقبة بطاقات المميزات
        document.querySelectorAll('.feature-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });

        // مراقبة بطاقات التسعير
        document.querySelectorAll('.pricing-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>