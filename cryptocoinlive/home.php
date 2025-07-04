<?php
/**
 * The template for displaying the blog home page
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<div class="blog-container">
    <div class="container">
        
        <!-- Blog Header -->
        <header class="blog-header">
            <h1 class="blog-title"><?php _e('المدونة', 'cryptocoin-live'); ?></h1>
            <p class="blog-description"><?php _e('آخر الأخبار والتحليلات في عالم العملات الرقمية', 'cryptocoin-live'); ?></p>
        </header>
        
        <div class="blog-wrapper">
            <main class="blog-content">
                
                <?php if (have_posts()): ?>
                    
                    <div class="posts-grid">
                        <?php while (have_posts()): the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-card'); ?>>
                                
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('post-thumbnail'); ?>
                                        </a>
                                        
                                        <!-- Post Meta Overlay -->
                                        <div class="post-meta-overlay">
                                            <span class="post-date">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            
                                            <?php if (get_the_category()): ?>
                                                <span class="post-category">
                                                    <?php the_category(', '); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <div class="post-meta">
                                        <span class="post-author">
                                            <?php _e('بواسطة', 'cryptocoin-live'); ?> 
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                <?php the_author(); ?>
                                            </a>
                                        </span>
                                        
                                        <span class="reading-time">
                                            <?php echo cryptocoin_live_reading_time(); ?>
                                        </span>
                                    </div>
                                    
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="post-excerpt">
                                        <?php echo cryptocoin_live_excerpt(20); ?>
                                    </div>
                                    
                                    <div class="post-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more btn-primary">
                                            <?php _e('اقرأ المزيد', 'cryptocoin-live'); ?>
                                        </a>
                                        
                                        <div class="post-stats">
                                            <span class="post-views">
                                                👁️ <?php echo cryptocoin_live_get_post_views(get_the_ID()); ?>
                                            </span>
                                            
                                            <span class="post-comments">
                                                💬 <?php echo get_comments_number(); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </article>
                            
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="blog-pagination">
                        <?php cryptocoin_live_pagination(); ?>
                    </div>
                    
                <?php else: ?>
                    
                    <div class="no-posts">
                        <div class="no-posts-icon">📝</div>
                        <h2><?php _e('لا توجد مقالات', 'cryptocoin-live'); ?></h2>
                        <p><?php _e('لم يتم نشر أي مقالات بعد. تابعنا للحصول على آخر التحديثات.', 'cryptocoin-live'); ?></p>
                    </div>
                    
                <?php endif; ?>
                
            </main>
            
            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <?php if (is_active_sidebar('sidebar-1')): ?>
                    <?php dynamic_sidebar('sidebar-1'); ?>
                <?php else: ?>
                    
                    <!-- Search Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('البحث', 'cryptocoin-live'); ?></h3>
                        <?php get_search_form(); ?>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('التصنيفات', 'cryptocoin-live'); ?></h3>
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
                        <h3 class="widget-title"><?php _e('المقالات الحديثة', 'cryptocoin-live'); ?></h3>
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
/* Blog Styles */
.blog-container {
    padding: 6rem 0 2rem;
    min-height: 100vh;
}

.blog-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem 0;
}

.blog-title {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 1rem;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.blog-description {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
    margin: 0 auto;
}

.blog-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.blog-post-card {
    background: var(--light);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    position: relative;
}

.blog-post-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px rgba(0, 255, 136, 0.2);
}

.post-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.blog-post-card:hover .post-thumbnail img {
    transform: scale(1.1);
}

.post-meta-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    color: white;
    font-size: 0.9rem;
}

.post-content {
    padding: 1.5rem;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

.post-author a {
    color: var(--primary);
    text-decoration: none;
}

.post-title a {
    color: var(--text);
    text-decoration: none;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.4;
    display: block;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.post-title a:hover {
    color: var(--primary);
}

.post-excerpt {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.read-more {
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.post-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

.blog-sidebar {
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

.no-posts {
    text-align: center;
    padding: 5rem 2rem;
    background: var(--light);
    border-radius: 20px;
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.no-posts-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.no-posts h2 {
    color: var(--primary);
    margin-bottom: 1rem;
}

.no-posts p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.1rem;
}

.blog-pagination {
    text-align: center;
    margin: 2rem 0;
}

.blog-pagination .page-numbers {
    background: var(--dark);
    color: var(--text);
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    margin: 0 0.3rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background: var(--primary);
    color: var(--dark);
}

/* Search Form */
.search-form {
    display: flex;
    gap: 0.5rem;
}

.search-field {
    flex: 1;
    background: var(--dark);
    border: 2px solid rgba(0, 255, 136, 0.3);
    border-radius: 10px;
    padding: 0.8rem;
    color: var(--text);
    font-size: 1rem;
}

.search-field:focus {
    outline: none;
    border-color: var(--primary);
}

.search-submit {
    background: var(--gradient);
    border: none;
    border-radius: 10px;
    padding: 0.8rem 1rem;
    color: var(--text);
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-submit:hover {
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .blog-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .posts-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .blog-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .blog-wrapper {
        padding: 0 1rem;
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
    }
    
    .blog-title {
        font-size: 2rem;
    }
    
    .blog-description {
        font-size: 1rem;
    }
    
    .post-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .blog-container {
        padding: 5rem 0 1rem;
    }
}

@media (max-width: 480px) {
    .blog-header {
        padding: 1rem 0;
        margin-bottom: 2rem;
    }
    
    .blog-title {
        font-size: 1.8rem;
    }
    
    .post-content {
        padding: 1rem;
    }
    
    .recent-post-item {
        flex-direction: column;
        text-align: center;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
}

/* Print Styles */
@media print {
    .blog-sidebar {
        display: none !important;
    }
    
    .blog-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>