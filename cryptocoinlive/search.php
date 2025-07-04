<?php
/**
 * The template for displaying search results
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<div class="search-results-container">
    <div class="container">
        
        <!-- Search Header -->
        <header class="search-header">
            <h1 class="search-title">
                <?php if (have_posts()): ?>
                    <?php printf(__('نتائج البحث عن: "%s"', 'cryptocoin-live'), get_search_query()); ?>
                <?php else: ?>
                    <?php printf(__('لا توجد نتائج للبحث عن: "%s"', 'cryptocoin-live'), get_search_query()); ?>
                <?php endif; ?>
            </h1>
            
            <?php if (have_posts()): ?>
                <p class="search-results-count">
                    <?php
                    global $wp_query;
                    printf(_n('تم العثور على نتيجة واحدة', 'تم العثور على %d نتائج', $wp_query->found_posts, 'cryptocoin-live'), $wp_query->found_posts);
                    ?>
                </p>
            <?php endif; ?>
            
            <!-- Search Form -->
            <div class="search-form-container">
                <?php get_search_form(); ?>
            </div>
        </header>
        
        <div class="search-wrapper">
            <main class="search-content">
                
                <?php if (have_posts()): ?>
                    
                    <div class="search-results">
                        <?php while (have_posts()): the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                                
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="search-result-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('post-thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="search-result-content">
                                    <div class="search-result-meta">
                                        <span class="post-type">
                                            <?php 
                                            $post_type_obj = get_post_type_object(get_post_type());
                                            echo $post_type_obj->labels->singular_name;
                                            ?>
                                        </span>
                                        
                                        <span class="post-date">
                                            <?php echo cryptocoin_live_time_ago(get_the_date('c')); ?>
                                        </span>
                                        
                                        <?php if (get_the_category()): ?>
                                            <span class="post-category">
                                                <?php the_category(', '); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h2 class="search-result-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="search-result-excerpt">
                                        <?php 
                                        // Highlight search terms in excerpt
                                        $excerpt = get_the_excerpt();
                                        $search_query = get_search_query();
                                        if ($search_query) {
                                            $excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                                        }
                                        echo wp_trim_words($excerpt, 30);
                                        ?>
                                    </div>
                                    
                                    <div class="search-result-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more btn-primary">
                                            <?php _e('اقرأ المزيد', 'cryptocoin-live'); ?>
                                        </a>
                                        
                                        <div class="search-result-stats">
                                            <?php if (function_exists('cryptocoin_live_get_post_views')): ?>
                                                <span class="views-count">
                                                    👁️ <?php echo cryptocoin_live_get_post_views(get_the_ID()); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <span class="comments-count">
                                                💬 <?php echo get_comments_number(); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </article>
                            
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="search-pagination">
                        <?php cryptocoin_live_pagination(); ?>
                    </div>
                    
                <?php else: ?>
                    
                    <!-- No Results Found -->
                    <div class="no-search-results">
                        <div class="no-results-icon">🔍</div>
                        <h2><?php _e('لم يتم العثور على أي نتائج', 'cryptocoin-live'); ?></h2>
                        <p><?php _e('عذراً، لم نجد أي محتوى يطابق بحثك. جرب كلمات مفتاحية أخرى أو تصفح المحتوى التالي:', 'cryptocoin-live'); ?></p>
                        
                        <!-- Search Suggestions -->
                        <div class="search-suggestions">
                            <h3><?php _e('اقتراحات للبحث:', 'cryptocoin-live'); ?></h3>
                            <ul class="suggestions-list">
                                <li><?php _e('تأكد من كتابة الكلمات بشكل صحيح', 'cryptocoin-live'); ?></li>
                                <li><?php _e('استخدم كلمات مفتاحية أقل أو مختلفة', 'cryptocoin-live'); ?></li>
                                <li><?php _e('استخدم مصطلحات أكثر عمومية', 'cryptocoin-live'); ?></li>
                                <li><?php _e('جرب البحث عن موضوع بدلاً من مقال محدد', 'cryptocoin-live'); ?></li>
                            </ul>
                        </div>
                        
                        <!-- Alternative Actions -->
                        <div class="no-results-actions">
                            <a href="<?php echo home_url(); ?>" class="btn-primary">
                                <span>🏠</span>
                                <?php _e('الصفحة الرئيسية', 'cryptocoin-live'); ?>
                            </a>
                            
                            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-secondary">
                                <span>📝</span>
                                <?php _e('جميع المقالات', 'cryptocoin-live'); ?>
                            </a>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
            </main>
            
            <!-- Sidebar -->
            <aside class="search-sidebar">
                <?php if (is_active_sidebar('sidebar-1')): ?>
                    <?php dynamic_sidebar('sidebar-1'); ?>
                <?php else: ?>
                    
                    <!-- Popular Searches Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('البحث الشائع', 'cryptocoin-live'); ?></h3>
                        <div class="popular-searches">
                            <?php
                            $popular_terms = array(
                                __('بيتكوين', 'cryptocoin-live'),
                                __('تحليل فني', 'cryptocoin-live'),
                                __('عملات رقمية', 'cryptocoin-live'),
                                __('تداول', 'cryptocoin-live'),
                                __('استثمار', 'cryptocoin-live'),
                                __('بلوك تشين', 'cryptocoin-live')
                            );
                            
                            foreach ($popular_terms as $term):
                            ?>
                                <a href="<?php echo home_url('/?s=' . urlencode($term)); ?>" class="popular-search-term">
                                    <?php echo esc_html($term); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('تصفح حسب التصنيف', 'cryptocoin-live'); ?></h3>
                        <ul class="categories-list">
                            <?php
                            wp_list_categories(array(
                                'title_li' => '',
                                'show_count' => true,
                                'number' => 10
                            ));
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('مقالات حديثة', 'cryptocoin-live'); ?></h3>
                        <div class="recent-posts">
                            <?php
                            $recent_posts = new WP_Query(array(
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ));
                            
                            if ($recent_posts->have_posts()):
                                while ($recent_posts->have_posts()): $recent_posts->the_post();
                            ?>
                                <div class="recent-post-item">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="recent-post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail(array(60, 60)); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="recent-post-content">
                                        <h4>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <span class="recent-post-date">
                                            <?php echo cryptocoin_live_time_ago(get_the_date('c')); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('الكلمات المفتاحية', 'cryptocoin-live'); ?></h3>
                        <div class="tags-cloud">
                            <?php wp_tag_cloud(array('number' => 20)); ?>
                        </div>
                    </div>
                    
                <?php endif; ?>
            </aside>
        </div>
    </div>
</div>

<style>
/* Search Results Styles */
.search-results-container {
    padding: 6rem 0 2rem;
    min-height: 100vh;
}

.search-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem 0;
}

.search-title {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.search-results-count {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 2rem;
}

.search-form-container {
    max-width: 600px;
    margin: 0 auto;
}

.search-form-container .search-form {
    display: flex;
    gap: 0.5rem;
}

.search-form-container .search-field {
    flex: 1;
    background: var(--dark);
    border: 2px solid rgba(0, 255, 136, 0.3);
    border-radius: 25px;
    padding: 1rem 1.5rem;
    color: var(--text);
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-form-container .search-field:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
}

.search-form-container .search-submit {
    background: var(--gradient);
    border: none;
    border-radius: 25px;
    padding: 1rem 2rem;
    color: var(--text);
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-form-container .search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 255, 136, 0.4);
}

.search-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.search-results {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.search-result-item {
    background: var(--light);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
}

.search-result-item:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 15px 30px rgba(0, 255, 136, 0.2);
}

.search-result-thumbnail {
    flex-shrink: 0;
    width: 150px;
    height: 150px;
    overflow: hidden;
    border-radius: 10px;
}

.search-result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.search-result-item:hover .search-result-thumbnail img {
    transform: scale(1.1);
}

.search-result-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.search-result-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    flex-wrap: wrap;
}

.post-type {
    background: var(--primary);
    color: var(--dark);
    padding: 0.2rem 0.8rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.search-result-title a {
    color: var(--text);
    text-decoration: none;
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 1.3;
    display: block;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.search-result-title a:hover {
    color: var(--primary);
}

.search-result-excerpt {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.search-result-excerpt mark {
    background: var(--primary);
    color: var(--dark);
    padding: 0.1rem 0.3rem;
    border-radius: 3px;
    font-weight: 600;
}

.search-result-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.read-more {
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.search-result-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

.search-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.widget {
    background: var(--light);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.widget-title {
    color: var(--primary);
    margin-bottom: 1rem;
    font-size: 1.3rem;
    font-weight: 600;
}

.popular-searches {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.popular-search-term {
    background: rgba(0, 255, 136, 0.1);
    color: var(--primary);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.9rem;
    border: 1px solid rgba(0, 255, 136, 0.3);
    transition: all 0.3s ease;
}

.popular-search-term:hover {
    background: var(--primary);
    color: var(--dark);
    transform: translateY(-2px);
}

.no-search-results {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--light);
    border-radius: 20px;
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.no-results-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.no-search-results h2 {
    color: var(--primary);
    margin-bottom: 1rem;
    font-size: 2rem;
}

.no-search-results p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.search-suggestions {
    background: var(--dark);
    border-radius: 15px;
    padding: 2rem;
    margin: 2rem 0;
    text-align: left;
}

.search-suggestions h3 {
    color: var(--primary);
    margin-bottom: 1rem;
    text-align: center;
}

.suggestions-list {
    list-style: none;
    padding: 0;
}

.suggestions-list li {
    padding: 0.5rem 0;
    color: rgba(255, 255, 255, 0.8);
    position: relative;
    padding-right: 1.5rem;
}

.suggestions-list li::before {
    content: '💡';
    position: absolute;
    right: 0;
    top: 0.5rem;
}

.no-results-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.search-pagination {
    text-align: center;
    margin: 3rem 0;
}

.search-pagination .page-numbers {
    background: var(--dark);
    color: var(--text);
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    margin: 0 0.3rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.search-pagination .page-numbers:hover,
.search-pagination .page-numbers.current {
    background: var(--primary);
    color: var(--dark);
}

/* Categories and Recent Posts - Same as blog styles */
.categories-list {
    list-style: none;
    padding: 0;
}

.categories-list li {
    margin-bottom: 0.8rem;
}

.categories-list a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.categories-list a:hover {
    color: var(--primary);
    padding-right: 1rem;
}

.recent-posts {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.recent-post-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--dark);
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.recent-post-item:hover {
    border-color: var(--primary);
    transform: translateX(5px);
}

.recent-post-thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.recent-post-content {
    flex: 1;
}

.recent-post-content h4 {
    margin: 0 0 0.3rem 0;
}

.recent-post-content h4 a {
    color: var(--text);
    text-decoration: none;
    font-size: 0.95rem;
    line-height: 1.3;
    transition: all 0.3s ease;
}

.recent-post-content h4 a:hover {
    color: var(--primary);
}

.recent-post-date {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
}

.tags-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tags-cloud a {
    background: rgba(0, 255, 136, 0.1);
    color: var(--primary);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.9rem;
    border: 1px solid rgba(0, 255, 136, 0.3);
    transition: all 0.3s ease;
}

.tags-cloud a:hover {
    background: var(--primary);
    color: var(--dark);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .search-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .search-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .search-wrapper {
        padding: 0 1rem;
    }
    
    .search-result-item {
        flex-direction: column;
        padding: 1rem;
    }
    
    .search-result-thumbnail {
        width: 100%;
        height: 200px;
    }
    
    .search-result-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .search-title {
        font-size: 1.8rem;
    }
    
    .search-form-container .search-form {
        flex-direction: column;
    }
    
    .search-form-container .search-submit {
        align-self: center;
        width: 150px;
    }
    
    .no-results-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .no-results-actions .btn-primary,
    .no-results-actions .btn-secondary {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .search-results-container {
        padding: 5rem 0 1rem;
    }
    
    .search-header {
        padding: 1rem 0;
        margin-bottom: 2rem;
    }
    
    .search-title {
        font-size: 1.5rem;
    }
    
    .search-result-item {
        padding: 1rem;
    }
    
    .search-result-thumbnail {
        height: 150px;
    }
    
    .no-search-results {
        padding: 2rem 1rem;
    }
    
    .search-suggestions {
        padding: 1.5rem;
    }
}

/* Print Styles */
@media print {
    .search-sidebar,
    .search-form-container,
    .no-results-actions {
        display: none !important;
    }
    
    .search-wrapper {
        grid-template-columns: 1fr;
    }
    
    .search-result-item {
        border: 1px solid #ccc;
        box-shadow: none;
    }
}
</style>

<script>
// Search Results JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Highlight search terms in results
    const searchQuery = '<?php echo esc_js(get_search_query()); ?>';
    
    if (searchQuery) {
        // Highlight terms in content
        const resultItems = document.querySelectorAll('.search-result-excerpt');
        resultItems.forEach(item => {
            const text = item.innerHTML;
            const highlightedText = text.replace(
                new RegExp('(' + searchQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'),
                '<mark>$1</mark>'
            );
            item.innerHTML = highlightedText;
        });
    }
    
    // Animate results on load
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

    // Observe search result items
    document.querySelectorAll('.search-result-item').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(item);
    });
    
    // Track search interactions for analytics
    document.querySelectorAll('.search-result-title a').forEach(link => {
        link.addEventListener('click', function() {
            // Add analytics tracking here if needed
            console.log('Search result clicked:', this.textContent.trim());
        });
    });
    
    document.querySelectorAll('.popular-search-term').forEach(term => {
        term.addEventListener('click', function() {
            // Add analytics tracking here if needed
            console.log('Popular search term clicked:', this.textContent.trim());
        });
    });
});
</script>

<?php get_footer(); ?>