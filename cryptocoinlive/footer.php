</main><!-- #main -->

    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="footer-content">
            <!-- Company Info Section -->
            <div class="footer-section company-info">
                <?php if (has_custom_logo()): ?>
                    <div class="footer-logo-img">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <div class="footer-logo">
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    </div>
                <?php endif; ?>
                
                <p class="footer-description">
                    <?php echo esc_html(get_theme_mod('footer_description', __('منصة متقدمة لتحليل العملات الرقمية باستخدام الذكاء الاصطناعي. نساعدك في اتخاذ قرارات استثمارية ذكية.', 'cryptocoin-live'))); ?>
                </p>
                
                <!-- Social Media Links -->
                <div class="social-links">
                    <?php
                    $social_networks = array(
                        'twitter' => array('icon' => '𝕏', 'label' => 'Twitter/X'),
                        'tiktok' => array('icon' => '🎵', 'label' => 'TikTok'),
                        'telegram' => array('icon' => '✈', 'label' => 'Telegram'),
                        'youtube' => array('icon' => '📺', 'label' => 'YouTube'),
                        'instagram' => array('icon' => '📷', 'label' => 'Instagram'),
                        'facebook' => array('icon' => '📘', 'label' => 'Facebook'),
                        'linkedin' => array('icon' => '💼', 'label' => 'LinkedIn')
                    );
                    
                    foreach ($social_networks as $network => $data) {
                        $url = get_theme_mod($network . '_url');
                        if ($url) {
                            echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr($data['label']) . '" aria-label="' . esc_attr($data['label']) . '">';
                            echo '<span>' . $data['icon'] . '</span>';
                            echo '</a>';
                        }
                    }
                    
                    // Default social links if none are set
                    if (!get_theme_mod('twitter_url') && !get_theme_mod('tiktok_url')) {
                        echo '<a href="https://x.com/cryptocoinliv" target="_blank" title="تابعنا على X" aria-label="Twitter/X">';
                        echo '<span>𝕏</span>';
                        echo '</a>';
                        echo '<a href="https://tiktok.com/@cryptocoinlive" target="_blank" title="تابعنا على TikTok" aria-label="TikTok">';
                        echo '<span>🎵</span>';
                        echo '</a>';
                        echo '<a href="mailto:support@cryptocoinlive.com" title="راسلنا عبر البريد الإلكتروني" aria-label="Email">';
                        echo '<span>📧</span>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="footer-section quick-links">
                <h3><?php _e('روابط سريعة', 'cryptocoin-live'); ?></h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('الرئيسية', 'cryptocoin-live'); ?></a></li>
                    <?php
                    // Get pages for footer menu
                    $footer_pages = get_pages(array(
                        'meta_key' => '_wp_page_template',
                        'meta_value' => 'page-about.php',
                        'number' => 1
                    ));
                    if (empty($footer_pages)) {
                        $footer_pages = get_pages(array('number' => 5, 'sort_column' => 'menu_order'));
                    }
                    
                    foreach ($footer_pages as $page) {
                        if ($page->post_title !== get_bloginfo('name')) {
                            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
                        }
                    }
                    ?>
                    <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php _e('المدونة', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('اتصل بنا', 'cryptocoin-live'); ?></a></li>
                </ul>
            </div>

            <!-- User Links Section -->
            <div class="footer-section user-links">
                <h3><?php _e('للمستخدمين', 'cryptocoin-live'); ?></h3>
                <ul>
                    <?php if (is_user_logged_in()): ?>
                        <li><a href="<?php echo esc_url(admin_url()); ?>"><?php _e('لوحة التحكم', 'cryptocoin-live'); ?></a></li>
                        <li><a href="<?php echo esc_url(get_edit_user_link()); ?>"><?php _e('الملف الشخصي', 'cryptocoin-live'); ?></a></li>
                        <li><a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('تسجيل الخروج', 'cryptocoin-live'); ?></a></li>
                    <?php else: ?>
                        <li><a href="<?php echo esc_url(wp_login_url()); ?>"><?php _e('تسجيل الدخول', 'cryptocoin-live'); ?></a></li>
                        <li><a href="<?php echo esc_url(wp_registration_url()); ?>"><?php _e('إنشاء حساب', 'cryptocoin-live'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('نسيت كلمة المرور', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/api-docs')); ?>"><?php _e('API للمطورين', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/help')); ?>"><?php _e('المساعدة', 'cryptocoin-live'); ?></a></li>
                </ul>
            </div>

            <!-- Legal Links Section -->
            <div class="footer-section legal-links">
                <h3><?php _e('قانوني', 'cryptocoin-live'); ?></h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/terms')); ?>"><?php _e('شروط الاستخدام', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy')); ?>"><?php _e('سياسة الخصوصية', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/cookies')); ?>"><?php _e('سياسة الكوكيز', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/disclaimer')); ?>"><?php _e('إخلاء المسؤولية', 'cryptocoin-live'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/gdpr')); ?>"><?php _e('حماية البيانات', 'cryptocoin-live'); ?></a></li>
                </ul>
            </div>

            <!-- Footer Widgets Area -->
            <?php if (is_active_sidebar('footer-widgets')): ?>
                <div class="footer-section footer-widgets">
                    <?php dynamic_sidebar('footer-widgets'); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Newsletter Signup (Optional) -->
        <?php if (get_theme_mod('show_newsletter', true)): ?>
        <div class="newsletter-section">
            <div class="container">
                <div class="newsletter-content">
                    <h3><?php _e('اشترك في النشرة الإخبارية', 'cryptocoin-live'); ?></h3>
                    <p><?php _e('احصل على آخر التحديثات والتحليلات مباشرة في بريدك الإلكتروني', 'cryptocoin-live'); ?></p>
                    
                    <form class="newsletter-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" id="newsletter-form">
                        <div class="form-group">
                            <input type="email" name="newsletter_email" placeholder="<?php _e('أدخل بريدك الإلكتروني', 'cryptocoin-live'); ?>" required>
                            <button type="submit" class="btn-primary">
                                <span><?php _e('اشتراك', 'cryptocoin-live'); ?></span>
                                <span class="loading-spinner" style="display: none;">⟳</span>
                            </button>
                        </div>
                        <input type="hidden" name="action" value="newsletter_signup">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">
                        &copy; <?php echo date('Y'); ?> 
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php echo esc_html(get_bloginfo('name')); ?>
                        </a>. 
                        <?php echo esc_html(get_theme_mod('footer_copyright', __('جميع الحقوق محفوظة.', 'cryptocoin-live'))); ?>
                    </p>
                    
                    <div class="footer-credits">
                        <span><?php _e('تم التطوير بواسطة', 'cryptocoin-live'); ?> </span>
                        <a href="#" target="_blank"><?php _e('فريق CryptoCoin Live', 'cryptocoin-live'); ?></a>
                    </div>
                    
                    <!-- Language switcher if multilingual -->
                    <?php if (function_exists('pll_the_languages')): ?>
                    <div class="language-switcher-footer">
                        <?php pll_the_languages(array('show_flags' => 1, 'show_names' => 0)); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php _e('العودة إلى الأعلى', 'cryptocoin-live'); ?>" title="<?php _e('العودة إلى الأعلى', 'cryptocoin-live'); ?>">
        <span>↑</span>
    </button>

    <!-- Cookie Notice (GDPR Compliance) -->
    <?php if (get_theme_mod('show_cookie_notice', true) && !isset($_COOKIE['cryptocoin_cookies_accepted'])): ?>
    <div id="cookie-notice" class="cookie-notice">
        <div class="cookie-content">
            <p>
                <?php _e('نحن نستخدم الكوكيز لتحسين تجربتك على موقعنا. بالمتابعة، فإنك توافق على استخدام الكوكيز.', 'cryptocoin-live'); ?>
                <a href="<?php echo esc_url(home_url('/cookies')); ?>"><?php _e('اعرف المزيد', 'cryptocoin-live'); ?></a>
            </p>
            <div class="cookie-actions">
                <button id="accept-cookies" class="btn-primary"><?php _e('موافق', 'cryptocoin-live'); ?></button>
                <button id="decline-cookies" class="btn-secondary"><?php _e('رفض', 'cryptocoin-live'); ?></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php wp_footer(); ?>

    <script>
    // Back to top functionality
    document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.getElementById('back-to-top');
        
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });
            
            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
        
        // Newsletter form submission
        const newsletterForm = document.getElementById('newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const spinner = submitBtn.querySelector('.loading-spinner');
                const text = submitBtn.querySelector('span:first-child');
                
                // Show loading state
                spinner.style.display = 'inline-block';
                text.style.display = 'none';
                submitBtn.disabled = true;
                
                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('<?php _e("تم الاشتراك بنجاح!", "cryptocoin-live"); ?>', 'success');
                        newsletterForm.reset();
                    } else {
                        showNotification(data.data || '<?php _e("حدث خطأ، حاول مرة أخرى", "cryptocoin-live"); ?>', 'error');
                    }
                })
                .catch(error => {
                    showNotification('<?php _e("حدث خطأ في الاتصال", "cryptocoin-live"); ?>', 'error');
                })
                .finally(() => {
                    // Hide loading state
                    spinner.style.display = 'none';
                    text.style.display = 'inline';
                    submitBtn.disabled = false;
                });
            });
        }
        
        // Cookie notice functionality
        const cookieNotice = document.getElementById('cookie-notice');
        const acceptCookies = document.getElementById('accept-cookies');
        const declineCookies = document.getElementById('decline-cookies');
        
        if (acceptCookies) {
            acceptCookies.addEventListener('click', function() {
                setCookie('cryptocoin_cookies_accepted', 'true', 365);
                hideCookieNotice();
            });
        }
        
        if (declineCookies) {
            declineCookies.addEventListener('click', function() {
                setCookie('cryptocoin_cookies_accepted', 'false', 365);
                hideCookieNotice();
            });
        }
        
        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }
        
        function hideCookieNotice() {
            if (cookieNotice) {
                cookieNotice.style.transform = 'translateY(100%)';
                setTimeout(() => {
                    cookieNotice.style.display = 'none';
                }, 300);
            }
        }
        
        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
        // Enhanced footer animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe footer sections
        document.querySelectorAll('.footer-section').forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(section);
        });
        
        // Social links hover effects
        document.querySelectorAll('.social-links a').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.1)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Footer links tracking (for analytics)
        document.querySelectorAll('.site-footer a').forEach(link => {
            link.addEventListener('click', function() {
                // Add analytics tracking here if needed
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'click', {
                        'event_category': 'Footer Link',
                        'event_label': this.textContent.trim() || this.href
                    });
                }
            });
        });
    });

    // Progressive Web App support
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('SW registered: ', registration);
            }).catch(function(registrationError) {
                console.log('SW registration failed: ', registrationError);
            });
        });
    }
    </script>

    <style>
    /* Footer Styles */
    .site-footer {
        background: var(--dark);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 3rem 2rem 0;
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
        font-weight: 600;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.8rem;
    }

    .footer-section a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
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

    .footer-logo-img img {
        max-height: 60px;
        width: auto;
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
        flex-wrap: wrap;
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

    .newsletter-section {
        background: rgba(0, 255, 136, 0.05);
        border-top: 1px solid rgba(0, 255, 136, 0.1);
        border-bottom: 1px solid rgba(0, 255, 136, 0.1);
        padding: 2rem 0;
        margin: 2rem 0;
    }

    .newsletter-content {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .newsletter-content h3 {
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }

    .newsletter-content p {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 1.5rem;
    }

    .newsletter-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .newsletter-form .form-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .newsletter-form input[type="email"] {
        flex: 1;
        min-width: 200px;
        background: var(--dark);
        border: 2px solid rgba(0, 255, 136, 0.3);
        border-radius: 25px;
        padding: 0.8rem 1rem;
        color: var(--text);
        font-size: 1rem;
    }

    .newsletter-form input[type="email"]:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
    }

    .newsletter-form button {
        white-space: nowrap;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 2rem 0;
    }

    .footer-bottom-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        margin: 0;
    }

    .copyright a {
        color: var(--primary);
        text-decoration: none;
    }

    .footer-credits {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
    }

    .footer-credits a {
        color: var(--primary);
        text-decoration: none;
    }

    .language-switcher-footer {
        display: flex;
        gap: 0.5rem;
    }

    .language-switcher-footer a {
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.8rem;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
    }

    .language-switcher-footer a:hover,
    .language-switcher-footer a.current {
        background: var(--primary);
        color: var(--dark);
    }

    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        width: 50px;
        height: 50px;
        background: var(--gradient);
        border: none;
        border-radius: 50%;
        color: var(--text);
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transform: translateY(100px);
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3);
    }

    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .back-to-top:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 255, 136, 0.4);
    }

    /* Cookie Notice */
    .cookie-notice {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--dark);
        border-top: 2px solid var(--primary);
        padding: 1rem 2rem;
        z-index: 10000;
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .cookie-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .cookie-content p {
        margin: 0;
        color: rgba(255, 255, 255, 0.8);
        flex: 1;
    }

    .cookie-content a {
        color: var(--primary);
        text-decoration: none;
    }

    .cookie-actions {
        display: flex;
        gap: 1rem;
    }

    .cookie-actions button {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    /* Notification System */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--dark);
        color: var(--text);
        padding: 1rem 1.5rem;
        border-radius: 10px;
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border-left: 4px solid;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    }

    .notification-success {
        border-left-color: var(--success);
        background: rgba(0, 255, 136, 0.1);
    }

    .notification-error {
        border-left-color: var(--error);
        background: rgba(255, 0, 85, 0.1);
    }

    .notification-info {
        border-left-color: var(--primary);
        background: rgba(0, 255, 136, 0.1);
    }

    .notification button {
        background: none;
        border: none;
        color: var(--text);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

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

    /* Responsive Design */
    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2rem;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .social-links {
            justify-content: center;
        }

        .newsletter-form .form-group {
            flex-direction: column;
        }

        .newsletter-form input[type="email"] {
            min-width: auto;
        }

        .cookie-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .cookie-actions {
            justify-content: center;
        }

        .notification {
            right: 10px;
            left: 10px;
            max-width: none;
        }

        .back-to-top {
            bottom: 1rem;
            left: 1rem;
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
        }
    }

    /* Print Styles */
    @media print {
        .site-footer,
        .back-to-top,
        .cookie-notice,
        .notification {
            display: none !important;
        }
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .site-footer {
            background: #000000;
            border-top: 2px solid var(--primary);
        }

        .footer-section a {
            color: #ffffff;
        }

        .footer-section a:hover {
            background: var(--primary);
            color: #000000;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
        }
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        .back-to-top,
        .footer-section a,
        .social-links a,
        .notification {
            transition: none;
        }

        .footer-section {
            animation: none;
        }

        @keyframes slideInRight {
            from, to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    }
    </style>

</body>
</html>