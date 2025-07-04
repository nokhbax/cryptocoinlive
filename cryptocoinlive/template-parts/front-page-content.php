<?php
/**
 * Template part for displaying front page content
 * 
 * @package CryptoCoinLive
 */

$isLoggedIn = is_user_logged_in();
$canAnalyze = true; // يمكن تخصيص هذا حسب منطق التطبيق
$user = null;

if ($isLoggedIn) {
    $user = wp_get_current_user();
    // يمكن إضافة منطق فحص الاشتراك هنا
}
?>

<!-- Background Animation -->
<div class="bg-animation"></div>
<div class="floating-particles" id="particles"></div>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="hero-content">
        <h1 class="hero-title">
            <?php echo esc_html(get_theme_mod('hero_title', __('تحليل العملات الرقمية بالذكاء الاصطناعي', 'cryptocoin-live'))); ?>
        </h1>
        <p class="hero-description">
            <?php echo esc_html(get_theme_mod('hero_description', __('احصل على توقعات دقيقة لاتجاه السوق باستخدام أحدث تقنيات الذكاء الاصطناعي', 'cryptocoin-live'))); ?>
        </p>
        
        <!-- Upload Section -->
        <div class="upload-section">
            <?php if (!$isLoggedIn): ?>
                <!-- For Non-logged in users -->
                <div class="upload-area disabled">
                    <div class="upload-icon">🔒</div>
                    <h3><?php _e('يجب تسجيل الدخول أولاً', 'cryptocoin-live'); ?></h3>
                    <p><?php _e('سجل دخولك للاستفادة من خدمات التحليل', 'cryptocoin-live'); ?></p>
                    <div class="upload-buttons">
                        <button class="btn-primary" disabled>
                            <span>📁</span> <?php _e('اختر من الجهاز', 'cryptocoin-live'); ?>
                        </button>
                        <button class="btn-camera" disabled>
                            <span>📷</span> <?php _e('التقط صورة', 'cryptocoin-live'); ?>
                        </button>
                    </div>
                </div>
                <div class="login-required">
                    <div class="login-required-icon">🔐</div>
                    <h3><?php _e('مطلوب تسجيل الدخول', 'cryptocoin-live'); ?></h3>
                    <p><?php _e('للاستفادة من خدمات تحليل العملات الرقمية، يجب عليك تسجيل الدخول أولاً', 'cryptocoin-live'); ?></p>
                    <div style="margin-top: 1.5rem;">
                        <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="margin-left: 1rem;"><?php _e('إنشاء حساب جديد', 'cryptocoin-live'); ?></a>
                        <a href="<?php echo wp_login_url(); ?>" class="btn-secondary"><?php _e('تسجيل الدخول', 'cryptocoin-live'); ?></a>
                    </div>
                </div>
            <?php else: ?>
                <!-- For logged in users -->
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">📊</div>
                    <h3><?php _e('ارفع صورة الشارت', 'cryptocoin-live'); ?></h3>
                    <p><?php _e('اسحب وأفلت الصورة هنا', 'cryptocoin-live'); ?></p>
                    <div class="upload-buttons">
                        <button class="btn-primary" onclick="document.getElementById('fileInput').click()">
                            <span>📁</span> <?php _e('اختر من الجهاز', 'cryptocoin-live'); ?>
                        </button>
                        <button class="btn-camera" onclick="openCamera()" id="cameraBtn">
                            <span>📷</span> <?php _e('التقط صورة', 'cryptocoin-live'); ?>
                        </button>
                    </div>
                    <input type="file" id="fileInput" accept="image/*" style="display: none;" onchange="handleFileUpload(event)">
                    <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display: none;" onchange="handleFileUpload(event)">
                </div>

                <!-- Loading Animation -->
                <div class="loading" id="loading">
                    <div class="loading-spinner"></div>
                    <p><?php _e('جاري تحليل الصورة بالذكاء الاصطناعي...', 'cryptocoin-live'); ?></p>
                    <p style="font-size: 0.9rem; margin-top: 0.5rem; opacity: 0.7;"><?php _e('قد يستغرق هذا بضع ثوانٍ', 'cryptocoin-live'); ?></p>
                </div>
                
                <div class="subscription-status premium">
                    <p>
                        <strong><?php _e('نوع الاشتراك:', 'cryptocoin-live'); ?></strong> 
                        <?php _e('مجاني', 'cryptocoin-live'); ?>
                    </p>
                    <p><?php _e('تحليلات غير محدودة متاحة', 'cryptocoin-live'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Hero Widgets Area -->
        <?php if (is_active_sidebar('hero-section')): ?>
            <div class="hero-widgets">
                <?php dynamic_sidebar('hero-section'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Camera Preview -->
<div class="camera-preview" id="cameraPreview">
    <div class="camera-container">
        <video id="videoElement" autoplay playsinline></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <div class="camera-controls">
            <button class="camera-btn" onclick="capturePhoto()">📸</button>
            <button class="camera-btn" onclick="closeCamera()">❌</button>
        </div>
    </div>
</div>

<!-- Features Section -->
<section class="features-section" id="features">
    <div class="container">
        <h2 class="section-title"><?php _e('مميزات النظام', 'cryptocoin-live'); ?></h2>
        <div class="features-grid">
            <?php
            $features = cryptocoin_live_get_features(6);
            if ($features):
                foreach ($features as $feature):
                    $icon = get_post_meta($feature->ID, '_feature_icon', true) ?: '🤖';
                    ?>
                    <div class="feature-card">
                        <div class="feature-icon"><?php echo esc_html($icon); ?></div>
                        <h3><?php echo get_the_title($feature); ?></h3>
                        <p><?php echo get_the_excerpt($feature) ?: wp_trim_words(get_the_content(null, false, $feature), 20); ?></p>
                    </div>
                    <?php
                endforeach;
            else:
                // Default features if none are created
                $default_features = array(
                    array('icon' => '🤖', 'title' => __('ذكاء اصطناعي متطور', 'cryptocoin-live'), 'desc' => __('نموذج مدرب لتحليل الصور بنسبة دقة عالية', 'cryptocoin-live')),
                    array('icon' => '⚡', 'title' => __('تحليل فوري', 'cryptocoin-live'), 'desc' => __('احصل على النتائج في ثوانٍ معدودة', 'cryptocoin-live')),
                    array('icon' => '📈', 'title' => __('دقة عالية', 'cryptocoin-live'), 'desc' => __('إذا وجدت نسبة توقع عالية اغتنم الفرصة', 'cryptocoin-live')),
                    array('icon' => '🎯', 'title' => __('محلل أنماط متقدم', 'cryptocoin-live'), 'desc' => __('اكتشف الأنماط المتكررة في السوق', 'cryptocoin-live')),
                    array('icon' => '📷', 'title' => __('التقاط مباشر', 'cryptocoin-live'), 'desc' => __('صور الشارت مباشرة من هاتفك', 'cryptocoin-live')),
                    array('icon' => '🔐', 'title' => __('أمان وخصوصية', 'cryptocoin-live'), 'desc' => __('بياناتك محمية بأحدث تقنيات التشفير', 'cryptocoin-live'))
                );
                
                foreach ($default_features as $feature):
                    ?>
                    <div class="feature-card">
                        <div class="feature-icon"><?php echo esc_html($feature['icon']); ?></div>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['desc']); ?></p>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Pattern Analyzer Section -->
<section class="pattern-analyzer-section" id="pattern-analyzer">
    <div class="container">
        <h2 class="section-title"><?php _e('محلل الأنماط المتقدم', 'cryptocoin-live'); ?></h2>
        <div class="pattern-analyzer-content">
            <div class="pattern-analyzer-info">
                <h2><?php _e('اكتشف الأنماط المخفية في الأسواق', 'cryptocoin-live'); ?></h2>
                <p><?php _e('يستخدم محلل الأنماط المتقدم خوارزميات الذكاء الاصطناعي لاكتشاف الأنماط المتكررة في بيانات الأسعار التاريخية، مما يساعدك على:', 'cryptocoin-live'); ?></p>
                
                <div class="pattern-features">
                    <div class="pattern-feature">
                        <span class="pattern-feature-icon">✓</span>
                        <span><?php _e('تحديد الأنماط المربحة', 'cryptocoin-live'); ?></span>
                    </div>
                    <div class="pattern-feature">
                        <span class="pattern-feature-icon">✓</span>
                        <span><?php _e('التنبؤ بالحركات المستقبلية', 'cryptocoin-live'); ?></span>
                    </div>
                    <div class="pattern-feature">
                        <span class="pattern-feature-icon">✓</span>
                        <span><?php _e('تحليل أزواج متعددة', 'cryptocoin-live'); ?></span>
                    </div>
                    <div class="pattern-feature">
                        <span class="pattern-feature-icon">✓</span>
                        <span><?php _e('إحصائيات دقيقة', 'cryptocoin-live'); ?></span>
                    </div>
                </div>
                
                <?php if ($isLoggedIn): ?>
                    <a href="<?php echo home_url('/pattern-analyzer'); ?>" class="btn-primary"><?php _e('ابدأ تحليل الأنماط', 'cryptocoin-live'); ?></a>
                <?php else: ?>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn-primary"><?php _e('سجل للوصول لمحلل الأنماط', 'cryptocoin-live'); ?></a>
                <?php endif; ?>
            </div>
            
            <div class="pattern-analyzer-visual">
                <div class="pattern-chart">
                    <div class="pattern-demo">
                        <?php 
                        $heights = array(75, 45, 60, 85, 35, 70, 55, 90, 40, 65, 80, 50, 95, 60, 75);
                        for ($i = 0; $i < 15; $i++) {
                            $height = $heights[$i];
                            $delay = $i * 0.15;
                            echo "<div class='pattern-bar' style='height: {$height}%; animation: growBarAnimation 2s ease-out {$delay}s forwards;'></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section" id="pricing">
    <div class="container">
        <h2 class="section-title"><?php _e('خطط الاشتراكات', 'cryptocoin-live'); ?></h2>
        <div class="pricing-grid">
            <?php
            $pricing_plans = cryptocoin_live_get_pricing_plans(3);
            if ($pricing_plans):
                foreach ($pricing_plans as $plan):
                    $price = get_post_meta($plan->ID, '_price', true);
                    $period = get_post_meta($plan->ID, '_price_period', true);
                    $featured = get_post_meta($plan->ID, '_featured', true);
                    $features_text = get_post_meta($plan->ID, '_features', true);
                    $features = $features_text ? explode("\n", $features_text) : array();
                    ?>
                    <div class="pricing-card <?php echo $featured ? 'featured' : ''; ?>">
                        <h3><?php echo get_the_title($plan); ?></h3>
                        <div class="price">
                            <?php echo esc_html($price); ?>
                            <span class="price-period"><?php echo esc_html($period ? ' ' . $period : ''); ?></span>
                        </div>
                        <?php if ($features): ?>
                            <ul class="price-features">
                                <?php foreach ($features as $feature): ?>
                                    <li <?php echo strpos($feature, '✓') === 0 ? 'class="highlight"' : ''; ?>>
                                        <?php echo esc_html(trim($feature)); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        
                        <?php if (get_the_content(null, false, $plan)): ?>
                            <div class="plan-content">
                                <?php echo apply_filters('the_content', get_the_content(null, false, $plan)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($isLoggedIn): ?>
                            <a href="<?php echo home_url('/subscription-plans'); ?>" class="btn-primary" style="width: 100%;"><?php _e('اشترك الآن', 'cryptocoin-live'); ?></a>
                        <?php else: ?>
                            <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="width: 100%;"><?php _e('سجل واشترك', 'cryptocoin-live'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php
                endforeach;
            else:
                // Default pricing plans if none are created
                $default_plans = array(
                    array(
                        'title' => __('مجاني', 'cryptocoin-live'),
                        'price' => '0',
                        'period' => __('دولار/شهر', 'cryptocoin-live'),
                        'featured' => false,
                        'features' => array(
                            '✓ ' . __('2 تحليلات يومياً', 'cryptocoin-live'),
                            '✓ ' . __('تحليل الصور بالذكاء الاصطناعي', 'cryptocoin-live'),
                            '✓ ' . __('دقة أساسية', 'cryptocoin-live'),
                            '✗ ' . __('محلل الأنماط', 'cryptocoin-live'),
                            '✗ ' . __('توصيات متقدمة', 'cryptocoin-live'),
                            '✗ ' . __('دعم فني', 'cryptocoin-live')
                        )
                    ),
                    array(
                        'title' => __('شهري', 'cryptocoin-live'),
                        'price' => '25',
                        'period' => __('دولار/شهر', 'cryptocoin-live'),
                        'featured' => true,
                        'features' => array(
                            '✓ ' . __('تحليلات غير محدودة', 'cryptocoin-live'),
                            '✓ ' . __('تحليل الصور بالذكاء الاصطناعي', 'cryptocoin-live'),
                            '✓ ' . __('دقة عالية', 'cryptocoin-live'),
                            '✓ ' . __('محلل الأنماط المتقدم', 'cryptocoin-live'),
                            '✓ ' . __('توصيات متقدمة', 'cryptocoin-live'),
                            '✓ ' . __('دعم فني 24/7', 'cryptocoin-live')
                        )
                    ),
                    array(
                        'title' => __('سنوي', 'cryptocoin-live'),
                        'price' => '250',
                        'period' => __('دولار/سنة', 'cryptocoin-live'),
                        'featured' => false,
                        'features' => array(
                            '✓ ' . __('تحليلات غير محدودة', 'cryptocoin-live'),
                            '✓ ' . __('تحليل الصور بالذكاء الاصطناعي', 'cryptocoin-live'),
                            '✓ ' . __('دقة عالية', 'cryptocoin-live'),
                            '✓ ' . __('محلل الأنماط المتقدم', 'cryptocoin-live'),
                            '✓ ' . __('توصيات متقدمة', 'cryptocoin-live'),
                            '✓ ' . __('دعم فني 24/7', 'cryptocoin-live'),
                            '✓ ' . __('وفر شهرين مجاناً!', 'cryptocoin-live')
                        )
                    )
                );
                
                foreach ($default_plans as $plan):
                    ?>
                    <div class="pricing-card <?php echo $plan['featured'] ? 'featured' : ''; ?>">
                        <h3><?php echo esc_html($plan['title']); ?></h3>
                        <div class="price">
                            <?php echo esc_html($plan['price']); ?>
                            <span class="price-period"> <?php echo esc_html($plan['period']); ?></span>
                        </div>
                        <ul class="price-features">
                            <?php foreach ($plan['features'] as $feature): ?>
                                <li <?php echo strpos($feature, '✓') === 0 ? 'class="highlight"' : ''; ?>>
                                    <?php echo esc_html($feature); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ($isLoggedIn): ?>
                            <a href="<?php echo home_url('/subscription-plans'); ?>" class="btn-primary" style="width: 100%;"><?php _e('اشترك الآن', 'cryptocoin-live'); ?></a>
                        <?php else: ?>
                            <a href="<?php echo wp_registration_url(); ?>" class="btn-primary" style="width: 100%;"><?php _e('سجل واشترك', 'cryptocoin-live'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Testimonials Section (if available) -->
<?php
$testimonials = cryptocoin_live_get_testimonials(3);
if ($testimonials):
?>
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title"><?php _e('آراء العملاء', 'cryptocoin-live'); ?></h2>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $testimonial):
                $author = get_post_meta($testimonial->ID, '_testimonial_author', true);
                $position = get_post_meta($testimonial->ID, '_testimonial_position', true);
                $rating = get_post_meta($testimonial->ID, '_testimonial_rating', true);
                ?>
                <div class="testimonial-card">
                    <?php if ($rating): ?>
                        <div class="testimonial-rating">
                            <?php echo cryptocoin_live_display_rating($rating); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="testimonial-content">
                        <?php echo apply_filters('the_content', get_the_content(null, false, $testimonial)); ?>
                    </div>
                    
                    <div class="testimonial-author">
                        <?php if (has_post_thumbnail($testimonial->ID)): ?>
                            <div class="author-avatar">
                                <?php echo get_the_post_thumbnail($testimonial->ID, array(60, 60), array('class' => 'avatar')); ?>
                            </div>
                        <?php endif; ?>
                        <div class="author-info">
                            <h4><?php echo esc_html($author); ?></h4>
                            <?php if ($position): ?>
                                <p><?php echo esc_html($position); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Recent Posts Section -->
<?php
$recent_posts = new WP_Query(array(
    'posts_per_page' => 3,
    'post_status' => 'publish'
));

if ($recent_posts->have_posts()):
?>
<section class="recent-posts-section">
    <div class="container">
        <h2 class="section-title"><?php _e('أحدث المقالات', 'cryptocoin-live'); ?></h2>
        <div class="posts-grid">
            <?php while ($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                <article class="post-card">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('post-thumbnail'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <div class="post-meta">
                            <span class="post-date"><?php echo cryptocoin_live_time_ago(get_the_date('c')); ?></span>
                            <span class="post-category"><?php the_category(', '); ?></span>
                        </div>
                        
                        <h3 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <div class="post-excerpt">
                            <?php echo cryptocoin_live_excerpt(15); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="read-more btn-secondary">
                            <?php _e('اقرأ المزيد', 'cryptocoin-live'); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <div class="posts-link-wrapper">
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-primary">
                <?php _e('جميع المقالات', 'cryptocoin-live'); ?>
            </a>
        </div>
    </div>
</section>
<?php 
wp_reset_postdata();
endif; 
?>

<!-- JavaScript for Front Page -->
<script>
// Front page specific functionality
jQuery(document).ready(function($) {
    // Initialize floating particles
    initializeFloatingParticles();
    
    // Initialize upload functionality for logged in users
    <?php if ($isLoggedIn): ?>
    initializeImageUpload();
    initializeCameraFunctionality();
    <?php endif; ?>
    
    // Initialize animations
    initializeAnimations();
});

function initializeFloatingParticles() {
    const particlesContainer = document.getElementById('particles');
    if (!particlesContainer) return;

    const particleCount = window.innerWidth > 768 ? 50 : 25;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 20 + 's';
        particle.style.animationDuration = (15 + Math.random() * 10) + 's';
        particle.style.width = (2 + Math.random() * 4) + 'px';
        particle.style.height = (2 + Math.random() * 4) + 'px';
        particlesContainer.appendChild(particle);
    }
}

function initializeAnimations() {
    // Intersection Observer for animations
    if ('IntersectionObserver' in window) {
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

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .pricing-card, .post-card, .testimonial-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }
}

<?php if ($isLoggedIn): ?>
function initializeImageUpload() {
    // Image upload functionality here
    console.log('Image upload functionality initialized');
}

function initializeCameraFunctionality() {
    // Camera functionality here
    console.log('Camera functionality initialized');
}
<?php endif; ?>
</script>