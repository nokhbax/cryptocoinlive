<?php
/**
 * The template for displaying 404 pages (not found)
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<div class="error-404-container">
    <div class="container">
        <div class="error-404-content">
            
            <!-- 404 Animation -->
            <div class="error-404-animation">
                <div class="error-number">4</div>
                <div class="error-bitcoin">₿</div>
                <div class="error-number">4</div>
            </div>
            
            <div class="error-404-text">
                <h1><?php _e('عذراً، الصفحة غير موجودة!', 'cryptocoin-live'); ?></h1>
                <p><?php _e('يبدو أن الصفحة التي تبحث عنها قد اختفت في عالم البلوك تشين.', 'cryptocoin-live'); ?></p>
                <p><?php _e('لا تقلق، يمكنك العثور على ما تبحث عنه من خلال الروابط التالية:', 'cryptocoin-live'); ?></p>
            </div>
            
            <!-- Quick Actions -->
            <div class="error-404-actions">
                <a href="<?php echo home_url(); ?>" class="btn-primary">
                    <span>🏠</span>
                    <?php _e('الصفحة الرئيسية', 'cryptocoin-live'); ?>
                </a>
                
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-secondary">
                    <span>📝</span>
                    <?php _e('المدونة', 'cryptocoin-live'); ?>
                </a>
                
                <button onclick="history.back()" class="btn-secondary">
                    <span>↩️</span>
                    <?php _e('العودة للخلف', 'cryptocoin-live'); ?>
                </button>
            </div>
            
            <!-- Search Form -->
            <div class="error-404-search">
                <h3><?php _e('أو ابحث عما تريد:', 'cryptocoin-live'); ?></h3>
                <?php get_search_form(); ?>
            </div>
            
            <!-- Popular Content -->
            <div class="error-404-suggestions">
                <h3><?php _e('المحتوى الشائع', 'cryptocoin-live'); ?></h3>
                
                <div class="suggestions-grid">
                    <!-- Recent Posts -->
                    <div class="suggestion-section">
                        <h4><?php _e('أحدث المقالات', 'cryptocoin-live'); ?></h4>
                        <?php
                        $recent_posts = new WP_Query(array(
                            'posts_per_page' => 3,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($recent_posts->have_posts()):
                        ?>
                            <ul class="suggestion-list">
                                <?php while ($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                        <span class="suggestion-date">
                                            <?php echo cryptocoin_live_time_ago(get_the_date('c')); ?>
                                        </span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php 
                        wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    
                    <!-- Popular Pages -->
                    <div class="suggestion-section">
                        <h4><?php _e('صفحات مهمة', 'cryptocoin-live'); ?></h4>
                        <ul class="suggestion-list">
                            <li>
                                <a href="<?php echo home_url('/#features'); ?>">
                                    <?php _e('مميزات النظام', 'cryptocoin-live'); ?>
                                </a>
                                <span class="suggestion-desc"><?php _e('تعرف على مميزات تحليل العملات', 'cryptocoin-live'); ?></span>
                            </li>
                            <li>
                                <a href="<?php echo home_url('/#pricing'); ?>">
                                    <?php _e('خطط الاشتراك', 'cryptocoin-live'); ?>
                                </a>
                                <span class="suggestion-desc"><?php _e('اختر الخطة المناسبة لك', 'cryptocoin-live'); ?></span>
                            </li>
                            <li>
                                <a href="<?php echo home_url('/contact'); ?>">
                                    <?php _e('اتصل بنا', 'cryptocoin-live'); ?>
                                </a>
                                <span class="suggestion-desc"><?php _e('تواصل معنا للحصول على المساعدة', 'cryptocoin-live'); ?></span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Categories -->
                    <div class="suggestion-section">
                        <h4><?php _e('التصنيفات', 'cryptocoin-live'); ?></h4>
                        <ul class="suggestion-list">
                            <?php
                            $categories = get_categories(array(
                                'number' => 5,
                                'orderby' => 'count',
                                'order' => 'DESC'
                            ));
                            
                            foreach ($categories as $category):
                            ?>
                                <li>
                                    <a href="<?php echo get_category_link($category->term_id); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                    <span class="suggestion-count">
                                        <?php echo sprintf(_n('%d مقال', '%d مقالات', $category->count, 'cryptocoin-live'), $category->count); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="error-404-contact">
                <p><?php _e('إذا كنت تعتقد أن هذا خطأ، يرجى', 'cryptocoin-live'); ?> 
                   <a href="<?php echo home_url('/contact'); ?>"><?php _e('التواصل معنا', 'cryptocoin-live'); ?></a>
                </p>
            </div>
            
        </div>
    </div>
</div>

<style>
/* 404 Page Styles */
.error-404-container {
    padding: 6rem 0 4rem;
    min-height: 100vh;
    background: var(--darker);
    position: relative;
    overflow: hidden;
}

.error-404-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 40%, rgba(0, 255, 136, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 60%, rgba(255, 0, 170, 0.1) 0%, transparent 50%);
    z-index: -1;
}

.error-404-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.error-404-animation {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 3rem;
    font-size: 8rem;
    font-weight: bold;
}

.error-number {
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: pulse 2s ease-in-out infinite;
}

.error-bitcoin {
    color: var(--primary);
    animation: spin 4s linear infinite;
    text-shadow: 0 0 20px var(--primary);
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.error-404-text {
    margin-bottom: 3rem;
}

.error-404-text h1 {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.error-404-text p {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.error-404-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 4rem;
}

.error-404-actions .btn-primary,
.error-404-actions .btn-secondary {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.error-404-actions .btn-primary:hover,
.error-404-actions .btn-secondary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 255, 136, 0.3);
}

.error-404-search {
    background: var(--light);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 3rem;
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.error-404-search h3 {
    color: var(--primary);
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

.error-404-search .search-form {
    max-width: 500px;
    margin: 0 auto;
    display: flex;
    gap: 0.5rem;
}

.error-404-search .search-field {
    flex: 1;
    background: var(--dark);
    border: 2px solid rgba(0, 255, 136, 0.3);
    border-radius: 25px;
    padding: 1rem 1.5rem;
    color: var(--text);
    font-size: 1rem;
    transition: all 0.3s ease;
}

.error-404-search .search-field:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
}

.error-404-search .search-submit {
    background: var(--gradient);
    border: none;
    border-radius: 25px;
    padding: 1rem 2rem;
    color: var(--text);
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.error-404-search .search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 255, 136, 0.4);
}

.error-404-suggestions {
    text-align: left;
    margin-bottom: 3rem;
}

.error-404-suggestions > h3 {
    text-align: center;
    color: var(--primary);
    font-size: 2rem;
    margin-bottom: 2rem;
}

.suggestions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.suggestion-section {
    background: var(--light);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid rgba(0, 255, 136, 0.1);
    transition: all 0.3s ease;
}

.suggestion-section:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 10px 20px rgba(0, 255, 136, 0.2);
}

.suggestion-section h4 {
    color: var(--primary);
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.suggestion-section h4::before {
    content: '✨';
    font-size: 1.2rem;
}

.suggestion-list {
    list-style: none;
    padding: 0;
}

.suggestion-list li {
    margin-bottom: 1rem;
    padding: 0.8rem;
    background: var(--dark);
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.suggestion-list li:hover {
    border-color: var(--primary);
    transform: translateX(5px);
}

.suggestion-list a {
    color: var(--text);
    text-decoration: none;
    font-weight: 600;
    display: block;
    margin-bottom: 0.3rem;
    transition: all 0.3s ease;
}

.suggestion-list a:hover {
    color: var(--primary);
}

.suggestion-date,
.suggestion-desc,
.suggestion-count {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    display: block;
}

.error-404-contact {
    background: rgba(0, 255, 136, 0.05);
    border: 1px solid rgba(0, 255, 136, 0.2);
    border-radius: 15px;
    padding: 1.5rem;
    margin-top: 3rem;
}

.error-404-contact p {
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
}

.error-404-contact a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    border-bottom: 1px solid var(--primary);
    transition: all 0.3s ease;
}

.error-404-contact a:hover {
    color: var(--secondary);
    border-bottom-color: var(--secondary);
}

/* Responsive Design */
@media (max-width: 768px) {
    .error-404-animation {
        font-size: 5rem;
        gap: 0.5rem;
    }
    
    .error-404-text h1 {
        font-size: 2rem;
    }
    
    .error-404-text p {
        font-size: 1rem;
    }
    
    .error-404-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-404-actions .btn-primary,
    .error-404-actions .btn-secondary {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
    
    .suggestions-grid {
        grid-template-columns: 1fr;
    }
    
    .error-404-search .search-form {
        flex-direction: column;
    }
    
    .error-404-search .search-submit {
        align-self: center;
        width: 150px;
    }
}

@media (max-width: 480px) {
    .error-404-container {
        padding: 4rem 0 2rem;
    }
    
    .error-404-content {
        padding: 0 1rem;
    }
    
    .error-404-animation {
        font-size: 3.5rem;
        flex-direction: column;
        gap: 0;
    }
    
    .error-404-text h1 {
        font-size: 1.5rem;
    }
    
    .error-404-search,
    .suggestion-section {
        padding: 1.5rem;
    }
    
    .suggestions-grid {
        gap: 1rem;
    }
}

/* Loading Animation */
.error-404-animation .error-number:nth-child(1) {
    animation-delay: 0s;
}

.error-404-animation .error-bitcoin {
    animation-delay: 0.5s;
}

.error-404-animation .error-number:nth-child(3) {
    animation-delay: 1s;
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .error-number,
    .error-bitcoin {
        animation: none;
    }
    
    .suggestion-section:hover,
    .suggestion-list li:hover {
        transform: none;
    }
}

/* Print Styles */
@media print {
    .error-404-animation,
    .error-404-actions,
    .error-404-search {
        display: none !important;
    }
    
    .error-404-text {
        color: #000 !important;
    }
    
    .suggestions-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
// 404 Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive elements
    const errorNumbers = document.querySelectorAll('.error-number');
    const bitcoin = document.querySelector('.error-bitcoin');
    
    // Click animation for error numbers
    errorNumbers.forEach(number => {
        number.addEventListener('click', function() {
            this.style.animation = 'none';
            this.offsetHeight; // Trigger reflow
            this.style.animation = 'pulse 0.5s ease-in-out';
        });
    });
    
    // Bitcoin click animation
    if (bitcoin) {
        bitcoin.addEventListener('click', function() {
            this.style.animation = 'none';
            this.offsetHeight; // Trigger reflow
            this.style.animation = 'spin 1s linear';
        });
    }
    
    // Add typing effect to search placeholder
    const searchField = document.querySelector('.search-field');
    if (searchField) {
        const placeholders = [
            '<?php _e("ابحث عن المقالات...", "cryptocoin-live"); ?>',
            '<?php _e("تحليل العملات الرقمية", "cryptocoin-live"); ?>',
            '<?php _e("أخبار البيتكوين", "cryptocoin-live"); ?>',
            '<?php _e("استراتيجيات التداول", "cryptocoin-live"); ?>'
        ];
        
        let currentIndex = 0;
        
        function changePlaceholder() {
            searchField.placeholder = placeholders[currentIndex];
            currentIndex = (currentIndex + 1) % placeholders.length;
        }
        
        // Change placeholder every 3 seconds
        setInterval(changePlaceholder, 3000);
    }
    
    // Animate suggestions on scroll
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

    // Observe suggestion sections
    document.querySelectorAll('.suggestion-section').forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = `all 0.6s ease ${index * 0.2}s`;
        observer.observe(section);
    });
    
    // Add click tracking for analytics (if needed)
    document.querySelectorAll('.suggestion-list a').forEach(link => {
        link.addEventListener('click', function() {
            // Add analytics tracking here if needed
            console.log('404 suggestion clicked:', this.textContent.trim());
        });
    });
});
</script>

<?php get_footer(); ?>