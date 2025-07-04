<?php
/**
 * The template for displaying single posts
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<div class="single-post-container">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <?php cryptocoin_live_breadcrumbs(); ?>
        
        <div class="content-wrapper">
            <main class="main-content">
                <?php while (have_posts()): the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                        
                        <!-- Post Header -->
                        <header class="post-header">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="post-featured-image">
                                    <?php the_post_thumbnail('hero-image', array('class' => 'featured-img')); ?>
                                    
                                    <!-- Image overlay with post meta -->
                                    <div class="image-overlay">
                                        <div class="post-meta-overlay">
                                            <span class="post-date">
                                                <i class="icon-calendar"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            
                                            <?php if (get_the_category()): ?>
                                                <span class="post-category">
                                                    <i class="icon-folder"></i>
                                                    <?php the_category(', '); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <span class="reading-time">
                                                <i class="icon-clock"></i>
                                                <?php echo cryptocoin_live_reading_time(); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-title-section">
                                <h1 class="post-title"><?php the_title(); ?></h1>
                                
                                <?php if (has_excerpt()): ?>
                                    <div class="post-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Post Meta -->
                                <div class="post-meta">
                                    <div class="author-info">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'author-avatar')); ?>
                                        <div class="author-details">
                                            <span class="author-name">
                                                <?php _e('بواسطة', 'cryptocoin-live'); ?> 
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                            <span class="post-date-detail">
                                                <?php echo cryptocoin_live_time_ago(get_the_date('c')); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="post-actions">
                                        <!-- Share buttons -->
                                        <div class="share-buttons">
                                            <button class="share-btn" onclick="cryptocoinLive.sharePost()" title="<?php _e('مشاركة المقال', 'cryptocoin-live'); ?>">
                                                <span>📤</span>
                                            </button>
                                            
                                            <!-- Bookmark button -->
                                            <button class="bookmark-btn" onclick="cryptocoinLive.toggleBookmark(<?php the_ID(); ?>)" title="<?php _e('إضافة إلى المفضلة', 'cryptocoin-live'); ?>">
                                                <span>🔖</span>
                                            </button>
                                            
                                            <!-- Print button -->
                                            <button class="print-btn" onclick="window.print()" title="<?php _e('طباعة المقال', 'cryptocoin-live'); ?>">
                                                <span>🖨️</span>
                                            </button>
                                        </div>
                                        
                                        <!-- Views counter -->
                                        <div class="post-views">
                                            <span class="views-icon">👁️</span>
                                            <span class="views-count"><?php echo cryptocoin_live_get_post_views(get_the_ID()); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                        
                        <!-- Post Content -->
                        <div class="post-content">
                            <?php 
                            the_content();
                            
                            // Page break pagination
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . __('الصفحات:', 'cryptocoin-live'),
                                'after'  => '</div>',
                                'link_before' => '<span class="page-number">',
                                'link_after'  => '</span>',
                            ));
                            ?>
                        </div>
                        
                        <!-- Post Footer -->
                        <footer class="post-footer">
                            
                            <!-- Tags -->
                            <?php if (has_tag()): ?>
                                <div class="post-tags">
                                    <h4><?php _e('الكلمات المفتاحية', 'cryptocoin-live'); ?></h4>
                                    <div class="tags-list">
                                        <?php the_tags('', ' ', ''); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Social Share Section -->
                            <div class="social-share-section">
                                <h4><?php _e('شارك هذا المقال', 'cryptocoin-live'); ?></h4>
                                <div class="social-share-buttons">
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" class="share-twitter" title="<?php _e('مشاركة على Twitter', 'cryptocoin-live'); ?>">
                                        <span>𝕏</span>
                                        <span>Twitter</span>
                                    </a>
                                    
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                       target="_blank" class="share-facebook" title="<?php _e('مشاركة على Facebook', 'cryptocoin-live'); ?>">
                                        <span>📘</span>
                                        <span>Facebook</span>
                                    </a>
                                    
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" 
                                       target="_blank" class="share-whatsapp" title="<?php _e('مشاركة على WhatsApp', 'cryptocoin-live'); ?>">
                                        <span>💬</span>
                                        <span>WhatsApp</span>
                                    </a>
                                    
                                    <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                       target="_blank" class="share-telegram" title="<?php _e('مشاركة على Telegram', 'cryptocoin-live'); ?>">
                                        <span>✈</span>
                                        <span>Telegram</span>
                                    </a>
                                    
                                    <button class="share-copy" onclick="cryptocoinLive.copyToClipboard('<?php echo get_permalink(); ?>')" 
                                            title="<?php _e('نسخ الرابط', 'cryptocoin-live'); ?>">
                                        <span>🔗</span>
                                        <span><?php _e('نسخ الرابط', 'cryptocoin-live'); ?></span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Author Bio -->
                            <?php if (get_the_author_meta('description')): ?>
                                <div class="author-bio">
                                    <div class="author-bio-header">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'author-bio-avatar')); ?>
                                        <div class="author-bio-info">
                                            <h4><?php the_author(); ?></h4>
                                            <p class="author-role">
                                                <?php echo get_the_author_meta('job_title') ?: __('كاتب', 'cryptocoin-live'); ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="author-bio-content">
                                        <p><?php echo get_the_author_meta('description'); ?></p>
                                        
                                        <!-- Author social links -->
                                        <div class="author-social">
                                            <?php if (get_the_author_meta('twitter')): ?>
                                                <a href="<?php echo esc_url(get_the_author_meta('twitter')); ?>" target="_blank" title="Twitter">𝕏</a>
                                            <?php endif; ?>
                                            
                                            <?php if (get_the_author_meta('linkedin')): ?>
                                                <a href="<?php echo esc_url(get_the_author_meta('linkedin')); ?>" target="_blank" title="LinkedIn">💼</a>
                                            <?php endif; ?>
                                            
                                            <?php if (get_the_author_meta('website')): ?>
                                                <a href="<?php echo esc_url(get_the_author_meta('website')); ?>" target="_blank" title="<?php _e('الموقع الشخصي', 'cryptocoin-live'); ?>">🌐</a>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="btn-secondary author-posts-link">
                                            <?php _e('جميع مقالات', 'cryptocoin-live'); ?> <?php the_author(); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </footer>
                        
                    </article>
                    
                    <!-- Post Navigation -->
                    <nav class="post-navigation">
                        <div class="nav-links">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if ($prev_post): ?>
                                <div class="nav-previous">
                                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                        <span class="nav-direction"><?php _e('المقال السابق', 'cryptocoin-live'); ?></span>
                                        <span class="nav-icon">←</span>
                                        <div class="nav-content">
                                            <?php if (has_post_thumbnail($prev_post->ID)): ?>
                                                <div class="nav-thumbnail">
                                                    <?php echo get_the_post_thumbnail($prev_post->ID, array(60, 60)); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="nav-text">
                                                <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                                <span class="nav-date"><?php echo get_the_date('', $prev_post->ID); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($next_post): ?>
                                <div class="nav-next">
                                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                        <span class="nav-direction"><?php _e('المقال التالي', 'cryptocoin-live'); ?></span>
                                        <span class="nav-icon">→</span>
                                        <div class="nav-content">
                                            <?php if (has_post_thumbnail($next_post->ID)): ?>
                                                <div class="nav-thumbnail">
                                                    <?php echo get_the_post_thumbnail($next_post->ID, array(60, 60)); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="nav-text">
                                                <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                                <span class="nav-date"><?php echo get_the_date('', $next_post->ID); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </nav>
                    
                    <!-- Related Posts -->
                    <?php
                    $related_posts = cryptocoin_live_get_related_posts(get_the_ID(), 3);
                    if ($related_posts):
                    ?>
                        <section class="related-posts">
                            <h3><?php _e('مقالات ذات صلة', 'cryptocoin-live'); ?></h3>
                            <div class="related-posts-grid">
                                <?php foreach ($related_posts as $related_post):
                                    setup_postdata($related_post);
                                ?>
                                    <article class="related-post-item">
                                        <?php if (has_post_thumbnail($related_post->ID)): ?>
                                            <div class="related-post-thumbnail">
                                                <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                    <?php echo get_the_post_thumbnail($related_post->ID, 'post-thumbnail'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="related-post-content">
                                            <h4 class="related-post-title">
                                                <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                    <?php echo get_the_title($related_post->ID); ?>
                                                </a>
                                            </h4>
                                            
                                            <div class="related-post-meta">
                                                <span class="related-post-date">
                                                    <?php echo cryptocoin_live_time_ago(get_the_date('c', $related_post->ID)); ?>
                                                </span>
                                                
                                                <?php 
                                                $related_categories = get_the_category($related_post->ID);
                                                if ($related_categories):
                                                ?>
                                                    <span class="related-post-category">
                                                        <?php echo esc_html($related_categories[0]->name); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="related-post-excerpt">
                                                <?php echo wp_trim_words(get_the_excerpt($related_post), 15); ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php 
                                endforeach;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    
                <?php endwhile; ?>
                
                <!-- Comments Section -->
                <?php
                if (comments_open() || get_comments_number()):
                    comments_template();
                endif;
                ?>
                
            </main>
            
            <!-- Sidebar -->
            <aside class="sidebar">
                <?php if (is_active_sidebar('sidebar-1')): ?>
                    <?php dynamic_sidebar('sidebar-1'); ?>
                <?php else: ?>
                    
                    <!-- Popular Posts Widget -->
                    <div class="widget">
                        <h3 class="widget-title"><?php _e('المقالات الشائعة', 'cryptocoin-live'); ?></h3>
                        <div class="popular-posts">
                            <?php
                            $popular_posts = new WP_Query(array(
                                'posts_per_page' => 5,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post__not_in' => array(get_the_ID())
                            ));
                            
                            if ($popular_posts->have_posts()):
                                while ($popular_posts->have_posts()): $popular_posts->the_post();
                            ?>
                                <div class="popular-post-item">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="popular-post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail(array(60, 60)); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="popular-post-content">
                                        <h4>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <span class="popular-post-date">
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
                    
                    <!-- Newsletter Widget -->
                    <div class="widget newsletter-widget">
                        <h3 class="widget-title"><?php _e('اشترك في النشرة الإخبارية', 'cryptocoin-live'); ?></h3>
                        <p><?php _e('احصل على آخر التحديثات والتحليلات', 'cryptocoin-live'); ?></p>
                        
                        <form class="newsletter-form widget-newsletter-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                            <div class="form-group">
                                <input type="email" name="newsletter_email" placeholder="<?php _e('بريدك الإلكتروني', 'cryptocoin-live'); ?>" required>
                                <button type="submit" class="btn-primary">
                                    <span><?php _e('اشتراك', 'cryptocoin-live'); ?></span>
                                    <span class="loading-spinner" style="display: none;">⟳</span>
                                </button>
                            </div>
                            <input type="hidden" name="action" value="newsletter_signup">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('newsletter_nonce'); ?>">
                        </form>
                    </div>
                    
                <?php endif; ?>
            </aside>
        </div>
    </div>
</div>

<style>
/* Single Post Styles */
.single-post-container {
    padding: 2rem 0;
    min-height: 100vh;
}

.content-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.single-post {
    background: var(--light);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.post-featured-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.single-post:hover .featured-img {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    padding: 2rem;
}

.post-meta-overlay {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    color: white;
    font-size: 0.9rem;
}

.post-meta-overlay span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
}

.post-title-section {
    padding: 2rem;
}

.post-title {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.post-excerpt {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.author-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    border-radius: 50%;
    border: 2px solid var(--primary);
}

.author-details {
    display: flex;
    flex-direction: column;
}

.author-name a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.post-date-detail {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.post-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.share-buttons {
    display: flex;
    gap: 0.5rem;
}

.share-btn, .bookmark-btn, .print-btn {
    background: rgba(0, 255, 136, 0.1);
    border: 1px solid rgba(0, 255, 136, 0.3);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.share-btn:hover, .bookmark-btn:hover, .print-btn:hover {
    background: var(--primary);
    color: var(--dark);
    transform: scale(1.1);
}

.post-views {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.post-content {
    padding: 2rem;
    line-height: 1.8;
    font-size: 1.1rem;
}

.post-content h1, .post-content h2, .post-content h3,
.post-content h4, .post-content h5, .post-content h6 {
    color: var(--primary);
    margin: 2rem 0 1rem 0;
    line-height: 1.3;
}

.post-content p {
    margin-bottom: 1.5rem;
    color: rgba(255, 255, 255, 0.9);
}

.post-content ul, .post-content ol {
    margin-bottom: 1.5rem;
    padding-right: 2rem;
}

.post-content li {
    margin-bottom: 0.5rem;
    color: rgba(255, 255, 255, 0.9);
}

.post-content a {
    color: var(--primary);
    text-decoration: none;
    border-bottom: 1px solid var(--primary);
    transition: all 0.3s ease;
}

.post-content a:hover {
    color: var(--secondary);
    border-bottom-color: var(--secondary);
}

.post-content blockquote {
    background: rgba(0, 255, 136, 0.1);
    border-right: 4px solid var(--primary);
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 10px;
    font-style: italic;
    color: rgba(255, 255, 255, 0.9);
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
}

.post-content pre {
    background: var(--dark);
    border: 1px solid rgba(0, 255, 136, 0.3);
    border-radius: 10px;
    padding: 1rem;
    overflow-x: auto;
    margin: 1rem 0;
}

.post-content code {
    background: var(--dark);
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
    font-family: 'Courier New', monospace;
    color: var(--primary);
}

.page-links {
    text-align: center;
    margin: 2rem 0;
}

.page-number {
    background: var(--primary);
    color: var(--dark);
    padding: 0.5rem 1rem;
    border-radius: 5px;
    margin: 0 0.3rem;
    text-decoration: none;
}

.post-footer {
    padding: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.post-tags {
    margin-bottom: 2rem;
}

.post-tags h4 {
    color: var(--primary);
    margin-bottom: 1rem;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tags-list a {
    background: rgba(0, 255, 136, 0.1);
    color: var(--primary);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.9rem;
    border: 1px solid rgba(0, 255, 136, 0.3);
    transition: all 0.3s ease;
}

.tags-list a:hover {
    background: var(--primary);
    color: var(--dark);
}

.social-share-section {
    margin-bottom: 2rem;
}

.social-share-section h4 {
    color: var(--primary);
    margin-bottom: 1rem;
}

.social-share-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-share-buttons a,
.social-share-buttons button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.2rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.share-twitter {
    background: #1da1f2;
    color: white;
}

.share-facebook {
    background: #4267b2;
    color: white;
}

.share-whatsapp {
    background: #25d366;
    color: white;
}

.share-telegram {
    background: #0088cc;
    color: white;
}

.share-copy {
    background: rgba(0, 255, 136, 0.1);
    color: var(--primary);
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.social-share-buttons a:hover,
.social-share-buttons button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.author-bio {
    background: rgba(0, 255, 136, 0.05);
    border: 1px solid rgba(0, 255, 136, 0.2);
    border-radius: 15px;
    padding: 2rem;
}

.author-bio-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.author-bio-avatar {
    border-radius: 50%;
    border: 3px solid var(--primary);
}

.author-bio-info h4 {
    color: var(--primary);
    margin: 0;
    font-size: 1.3rem;
}

.author-role {
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    font-size: 0.9rem;
}

.author-bio-content p {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.author-social {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.author-social a {
    width: 35px;
    height: 35px;
    background: rgba(0, 255, 136, 0.1);
    border: 1px solid rgba(0, 255, 136, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.author-social a:hover {
    background: var(--primary);
    color: var(--dark);
}

.author-posts-link {
    display: inline-block;
    margin-top: 0.5rem;
}

.post-navigation {
    margin: 3rem 0;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.nav-link {
    display: block;
    background: var(--light);
    border: 1px solid rgba(0, 255, 136, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
    text-decoration: none;
    color: var(--text);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-link:hover {
    border-color: var(--primary);
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 255, 136, 0.2);
}

.nav-direction {
    display: block;
    color: var(--primary);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.nav-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.5rem;
    color: var(--primary);
}

.nav-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
}

.nav-text {
    flex: 1;
}

.nav-title {
    display: block;
    font-weight: 600;
    margin-bottom: 0.3rem;
    line-height: 1.3;
}

.nav-date {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.nav-previous .nav-icon {
    left: 1rem;
    right: auto;
}

.related-posts {
    margin: 3rem 0;
    background: var(--light);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(0, 255, 136, 0.1);
}

.related-posts h3 {
    color: var(--primary);
    text-align: center;
    margin-bottom: 2rem;
    font-size: 2rem;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.related-post-item {
    background: var(--dark);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.related-post-item:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 10px 20px rgba(0, 255, 136, 0.2);
}

.related-post-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.related-post-item:hover .related-post-thumbnail img {
    transform: scale(1.1);
}

.related-post-content {
    padding: 1.5rem;
}

.related-post-title a {
    color: var(--text);
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    display: block;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.related-post-title a:hover {
    color: var(--primary);
}

.related-post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.8rem;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
}

.related-post-category {
    color: var(--primary);
}

.related-post-excerpt {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.5;
}

/* Sidebar Styles */
.sidebar {
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

.popular-posts {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-post-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--dark);
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.popular-post-item:hover {
    border-color: var(--primary);
    transform: translateX(5px);
}

.popular-post-thumbnail img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.popular-post-content {
    flex: 1;
}

.popular-post-content h4 {
    margin: 0 0 0.3rem 0;
}

.popular-post-content h4 a {
    color: var(--text);
    text-decoration: none;
    font-size: 0.95rem;
    line-height: 1.3;
    transition: all 0.3s ease;
}

.popular-post-content h4 a:hover {
    color: var(--primary);
}

.popular-post-date {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
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

.newsletter-widget {
    background: linear-gradient(135deg, rgba(0, 255, 136, 0.1), rgba(255, 0, 170, 0.1));
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.newsletter-widget p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1.5rem;
}

.widget-newsletter-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.widget-newsletter-form input[type="email"] {
    background: var(--dark);
    border: 2px solid rgba(0, 255, 136, 0.3);
    border-radius: 10px;
    padding: 0.8rem;
    color: var(--text);
    font-size: 1rem;
}

.widget-newsletter-form input[type="email"]:focus {
    outline: none;
    border-color: var(--primary);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .content-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .post-title {
        font-size: 2rem;
    }
    
    .post-featured-image {
        height: 300px;
    }
}

@media (max-width: 768px) {
    .content-wrapper {
        padding: 0 1rem;
    }
    
    .single-post {
        border-radius: 15px;
    }
    
    .post-title-section,
    .post-content,
    .post-footer {
        padding: 1.5rem;
    }
    
    .post-title {
        font-size: 1.8rem;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .post-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .social-share-buttons {
        justify-content: center;
    }
    
    .nav-links {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .author-bio-header {
        flex-direction: column;
        text-align: center;
    }
    
    .nav-content {
        flex-direction: column;
        text-align: center;
    }
    
    .nav-icon {
        position: static;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 480px) {
    .post-featured-image {
        height: 250px;
    }
    
    .post-title {
        font-size: 1.5rem;
    }
    
    .post-excerpt {
        font-size: 1rem;
    }
    
    .post-content {
        font-size: 1rem;
        padding: 1rem;
    }
    
    .social-share-buttons a,
    .social-share-buttons button {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
    
    .image-overlay {
        padding: 1rem;
    }
    
    .post-meta-overlay {
        font-size: 0.8rem;
    }
}

/* Print Styles */
@media print {
    .sidebar,
    .post-navigation,
    .related-posts,
    .social-share-section,
    .share-buttons,
    .post-actions {
        display: none !important;
    }
    
    .content-wrapper {
        grid-template-columns: 1fr;
    }
    
    .single-post {
        box-shadow: none;
        border: 1px solid #ccc;
    }
    
    .post-content {
        color: #000;
    }
    
    .post-title {
        color: #000;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .single-post {
        background: #000000;
        border: 2px solid var(--primary);
    }
    
    .post-content {
        color: #ffffff;
    }
    
    .post-title {
        color: var(--primary);
    }
    
    .nav-link:hover {
        background: var(--primary);
        color: #000000;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .single-post:hover .featured-img,
    .nav-link:hover,
    .related-post-item:hover,
    .popular-post-item:hover {
        transform: none;
        transition: none;
    }
    
    .social-share-buttons a:hover,
    .social-share-buttons button:hover {
        transform: none;
    }
}

/* Focus Styles for Accessibility */
.nav-link:focus,
.social-share-buttons a:focus,
.social-share-buttons button:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Loading Animation for Images */
.featured-img,
.related-post-thumbnail img,
.popular-post-thumbnail img {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.featured-img[src],
.related-post-thumbnail img[src],
.popular-post-thumbnail img[src] {
    animation: none;
    background: none;
}
</style>

<script>
// Single post specific JavaScript
jQuery(document).ready(function($) {
    // Update post views
    updatePostViews();
    
    // Initialize reading progress
    initializeReadingProgress();
    
    // Initialize table of contents (if needed)
    generateTableOfContents();
    
    // Initialize social share functionality
    initializeSocialShare();
    
    // Initialize copy to clipboard
    initializeCopyToClipboard();
    
    // Initialize bookmark functionality
    initializeBookmarks();
    
    // Initialize image zoom
    initializeImageZoom();
    
    // Initialize code syntax highlighting
    initializeCodeHighlighting();
});

/**
 * Update post views counter
 */
function updatePostViews() {
    if (typeof cryptocoin_ajax !== 'undefined') {
        $.ajax({
            url: cryptocoin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'update_post_views',
                post_id: <?php echo get_the_ID(); ?>,
                nonce: cryptocoin_ajax.nonce
            }
        });
    }
}

/**
 * Initialize reading progress indicator
 */
function initializeReadingProgress() {
    // Create progress bar
    const progressBar = $('<div class="reading-progress"><div class="reading-progress-fill"></div></div>');
    $('body').append(progressBar);
    
    // Add styles
    $('<style>').text(`
        .reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }
        
        .reading-progress-fill {
            height: 100%;
            background: var(--gradient);
            width: 0%;
            transition: width 0.1s ease;
        }
    `).appendTo('head');
    
    // Update progress on scroll
    $(window).on('scroll', function() {
        const postContent = $('.post-content');
        if (postContent.length) {
            const scrollTop = $(window).scrollTop();
            const docHeight = $(document).height() - $(window).height();
            const scrollPercent = (scrollTop / docHeight) * 100;
            
            $('.reading-progress-fill').css('width', scrollPercent + '%');
        }
    });
}

/**
 * Generate table of contents
 */
function generateTableOfContents() {
    const headings = $('.post-content').find('h2, h3, h4');
    
    if (headings.length > 2) {
        const toc = $('<div class="table-of-contents"><h4>جدول المحتويات</h4><ul class="toc-list"></ul></div>');
        const tocList = toc.find('.toc-list');
        
        headings.each(function(index) {
            const heading = $(this);
            const id = 'heading-' + index;
            const text = heading.text();
            const level = heading.prop('tagName').toLowerCase();
            
            heading.attr('id', id);
            
            const tocItem = $(`<li class="toc-item toc-${level}"><a href="#${id}">${text}</a></li>`);
            tocList.append(tocItem);
        });
        
        // Add styles
        $('<style>').text(`
            .table-of-contents {
                background: rgba(0, 255, 136, 0.1);
                border: 1px solid rgba(0, 255, 136, 0.3);
                border-radius: 10px;
                padding: 1.5rem;
                margin: 2rem 0;
            }
            
            .table-of-contents h4 {
                color: var(--primary);
                margin: 0 0 1rem 0;
            }
            
            .toc-list {
                list-style: none;
                padding: 0;
            }
            
            .toc-item {
                margin-bottom: 0.5rem;
            }
            
            .toc-item a {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                transition: all 0.3s ease;
            }
            
            .toc-item a:hover {
                color: var(--primary);
                padding-right: 0.5rem;
            }
            
            .toc-h3 {
                padding-right: 1rem;
            }
            
            .toc-h4 {
                padding-right: 2rem;
            }
        `).appendTo('head');
        
        // Insert TOC after first paragraph
        $('.post-content p:first').after(toc);
        
        // Smooth scroll for TOC links
        $('.toc-list a').on('click', function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });
    }
}

/**
 * Initialize social share functionality
 */
function initializeSocialShare() {
    // Make share post function globally available
    window.cryptocoinLive = window.cryptocoinLive || {};
    
    window.cryptocoinLive.sharePost = function() {
        const title = '<?php echo addslashes(get_the_title()); ?>';
        const url = '<?php echo get_permalink(); ?>';
        const text = `${title} - ${url}`;
        
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).catch(console.error);
        } else {
            window.cryptocoinLive.copyToClipboard(url);
        }
    };
}

/**
 * Initialize copy to clipboard
 */
function initializeCopyToClipboard() {
    window.cryptocoinLive = window.cryptocoinLive || {};
    
    window.cryptocoinLive.copyToClipboard = function(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                window.cryptocoinLive.showNotification('تم نسخ الرابط!', 'success');
            }).catch(() => {
                fallbackCopyTextToClipboard(text);
            });
        } else {
            fallbackCopyTextToClipboard(text);
        }
    };
    
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            window.cryptocoinLive.showNotification('تم نسخ الرابط!', 'success');
        } catch (err) {
            console.error('Failed to copy: ', err);
            window.cryptocoinLive.showNotification('فشل في النسخ', 'error');
        }
        
        document.body.removeChild(textArea);
    }
}

/**
 * Initialize bookmark functionality
 */
function initializeBookmarks() {
    window.cryptocoinLive = window.cryptocoinLive || {};
    
    window.cryptocoinLive.toggleBookmark = function(postId) {
        const bookmarkBtn = $('.bookmark-btn');
        const isBookmarked = bookmarkBtn.hasClass('bookmarked');
        
        $.ajax({
            url: cryptocoin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'toggle_bookmark',
                post_id: postId,
                nonce: cryptocoin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.bookmarked) {
                        bookmarkBtn.addClass('bookmarked');
                        bookmarkBtn.find('span').text('🔖');
                        window.cryptocoinLive.showNotification('تم إضافة المقال للمفضلة', 'success');
                    } else {
                        bookmarkBtn.removeClass('bookmarked');
                        bookmarkBtn.find('span').text('🔖');
                        window.cryptocoinLive.showNotification('تم إزالة المقال من المفضلة', 'info');
                    }
                }
            }
        });
    };
}

/**
 * Initialize image zoom functionality
 */
function initializeImageZoom() {
    $('.post-content img').on('click', function() {
        const imgSrc = $(this).attr('src');
        const imgAlt = $(this).attr('alt') || '';
        
        const modal = $(`
            <div class="image-zoom-modal">
                <div class="image-zoom-overlay"></div>
                <div class="image-zoom-container">
                    <img src="${imgSrc}" alt="${imgAlt}">
                    <button class="image-zoom-close">×</button>
                </div>
            </div>
        `);
        
        $('body').append(modal);
        
        // Add styles
        $('<style>').text(`
            .image-zoom-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 0.3s ease;
            }
            
            .image-zoom-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
            }
            
            .image-zoom-container {
                position: relative;
                max-width: 90%;
                max-height: 90%;
            }
            
            .image-zoom-container img {
                max-width: 100%;
                max-height: 100%;
                border-radius: 10px;
            }
            
            .image-zoom-close {
                position: absolute;
                top: -10px;
                right: -10px;
                width: 40px;
                height: 40px;
                background: var(--primary);
                border: none;
                border-radius: 50%;
                color: var(--dark);
                font-size: 1.5rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        `).appendTo('head');
        
        // Close modal
        modal.find('.image-zoom-close, .image-zoom-overlay').on('click', function() {
            modal.fadeOut(() => modal.remove());
        });
        
        // Close on escape key
        $(document).on('keydown.imageZoom', function(e) {
            if (e.key === 'Escape') {
                modal.fadeOut(() => modal.remove());
                $(document).off('keydown.imageZoom');
            }
        });
    });
}

/**
 * Initialize code syntax highlighting
 */
function initializeCodeHighlighting() {
    $('.post-content pre code').each(function() {
        $(this).addClass('highlighted');
    });
    
    // Add copy button to code blocks
    $('.post-content pre').each(function() {
        const codeBlock = $(this);
        const copyBtn = $('<button class="copy-code-btn">نسخ</button>');
        
        copyBtn.css({
            position: 'absolute',
            top: '10px',
            left: '10px',
            background: 'var(--primary)',
            color: 'var(--dark)',
            border: 'none',
            borderRadius: '5px',
            padding: '5px 10px',
            fontSize: '0.8rem',
            cursor: 'pointer'
        });
        
        codeBlock.css('position', 'relative').append(copyBtn);
        
        copyBtn.on('click', function() {
            const code = codeBlock.find('code').text();
            window.cryptocoinLive.copyToClipboard(code);
        });
    });
}
</script>

<?php
// Add functions for single post functionality

/**
 * Get reading time estimate
 */
function cryptocoin_live_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed
    
    return sprintf(_n('%d دقيقة قراءة', '%d دقائق قراءة', $reading_time, 'cryptocoin-live'), $reading_time);
}

/**
 * Get and update post views
 */
function cryptocoin_live_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return '0';
    }
    
    return number_format_i18n($count);
}

/**
 * Update post views via AJAX
 */
function cryptocoin_live_update_post_views() {
    if (!wp_verify_nonce($_POST['nonce'], 'cryptocoin_nonce')) {
        wp_die('Security check failed');
    }
    
    $post_id = intval($_POST['post_id']);
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '1');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
    
    wp_die();
}
add_action('wp_ajax_update_post_views', 'cryptocoin_live_update_post_views');
add_action('wp_ajax_nopriv_update_post_views', 'cryptocoin_live_update_post_views');

/**
 * Get related posts
 */
function cryptocoin_live_get_related_posts($post_id, $number_posts = 3) {
    $post_categories = wp_get_post_categories($post_id);
    $post_tags = wp_get_post_tags($post_id);
    
    if (empty($post_categories) && empty($post_tags)) {
        return array();
    }
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $number_posts,
        'post__not_in' => array($post_id),
        'orderby' => 'rand',
        'meta_query' => array(
            array(
                'key' => 'post_views_count',
                'compare' => 'EXISTS'
            )
        )
    );
    
    if (!empty($post_categories)) {
        $args['category__in'] = $post_categories;
    } elseif (!empty($post_tags)) {
        $tag_ids = array();
        foreach ($post_tags as $tag) {
            $tag_ids[] = $tag->term_id;
        }
        $args['tag__in'] = $tag_ids;
    }
    
    $related_posts = get_posts($args);
    
    // If no related posts found, get recent posts
    if (empty($related_posts)) {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_posts,
            'post__not_in' => array($post_id),
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $related_posts = get_posts($args);
    }
    
    return $related_posts;
}

/**
 * Toggle bookmark functionality
 */
function cryptocoin_live_toggle_bookmark() {
    if (!wp_verify_nonce($_POST['nonce'], 'cryptocoin_nonce') || !is_user_logged_in()) {
        wp_die('Security check failed');
    }
    
    $post_id = intval($_POST['post_id']);
    $user_id = get_current_user_id();
    
    $bookmarks = get_user_meta($user_id, 'bookmarked_posts', true) ?: array();
    
    if (in_array($post_id, $bookmarks)) {
        // Remove bookmark
        $bookmarks = array_diff($bookmarks, array($post_id));
        $bookmarked = false;
    } else {
        // Add bookmark
        $bookmarks[] = $post_id;
        $bookmarked = true;
    }
    
    update_user_meta($user_id, 'bookmarked_posts', $bookmarks);
    
    wp_send_json_success(array('bookmarked' => $bookmarked));
}
add_action('wp_ajax_toggle_bookmark', 'cryptocoin_live_toggle_bookmark');

?>

<?php get_footer(); ?>