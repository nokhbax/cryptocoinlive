<?php
/**
 * The template for displaying pages
 * 
 * @package CryptoCoinLive
 */

get_header(); ?>

<div class="page-container">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <?php 
        if (function_exists('cryptocoin_live_breadcrumbs')) {
            cryptocoin_live_breadcrumbs(); 
        }
        ?>
        
        <div class="page-wrapper">
            <main class="page-content">
                <?php while (have_posts()): the_post(); ?>
                    
                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                        
                        <!-- Page Header -->
                        <header class="page-header">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="page-featured-image">
                                    <?php the_post_thumbnail('hero-image', array('class' => 'page-featured-img')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="page-title-section">
                                <h1 class="page-title"><?php the_title(); ?></h1>
                                
                                <?php if (has_excerpt()): ?>
                                    <div class="page-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </header>
                        
                        <!-- Page Content -->
                        <div class="page-content-area">
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
                        
                    </article>
                    
                <?php endwhile; ?>
                
                <!-- Comments Section for pages if enabled -->
                <?php
                if (comments_open() || get_comments_number()):
                    comments_template();
                endif;
                ?>
                
            </main>
            
            <!-- Sidebar for pages if active (hidden for now) -->
            <?php if (false && is_active_sidebar('sidebar-1')): ?>
                <aside class="page-sidebar">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Page Styles */
.page-container {
    padding: 6rem 0 2rem;
    min-height: 100vh;
    background: var(--darker, #050505);
}

.page-wrapper {
    display: block;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.page-article {
    background: var(--light, #1a1a1a);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(0, 255, 136, 0.1);
    margin-bottom: 2rem;
}

.page-featured-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.page-featured-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.page-article:hover .page-featured-img {
    transform: scale(1.05);
}

.page-title-section {
    padding: 2rem;
}

.page-title {
    font-size: 2.5rem;
    color: var(--primary, #00ff88);
    margin-bottom: 1rem;
    line-height: 1.2;
    background: linear-gradient(135deg, var(--primary, #00ff88), var(--secondary, #ff00aa));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-excerpt {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1rem;
    line-height: 1.6;
}

.page-content-area {
    padding: 2rem;
    line-height: 1.8;
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
}

.page-content-area h1, .page-content-area h2, .page-content-area h3,
.page-content-area h4, .page-content-area h5, .page-content-area h6 {
    color: var(--primary, #00ff88);
    margin: 2rem 0 1rem 0;
    line-height: 1.3;
}

.page-content-area h2 {
    font-size: 2rem;
    border-bottom: 2px solid var(--primary, #00ff88);
    padding-bottom: 0.5rem;
}

.page-content-area h3 {
    font-size: 1.5rem;
}

.page-content-area p {
    margin-bottom: 1.5rem;
    color: rgba(255, 255, 255, 0.9);
}

.page-content-area ul, .page-content-area ol {
    margin-bottom: 1.5rem;
    padding-right: 2rem;
}

.page-content-area li {
    margin-bottom: 0.5rem;
    color: rgba(255, 255, 255, 0.9);
}

.page-content-area a {
    color: var(--primary, #00ff88);
    text-decoration: none;
    border-bottom: 1px solid var(--primary, #00ff88);
    transition: all 0.3s ease;
}

.page-content-area a:hover {
    color: var(--secondary, #ff00aa);
    border-bottom-color: var(--secondary, #ff00aa);
    transform: translateY(-1px);
}

.page-content-area blockquote {
    background: rgba(0, 255, 136, 0.1);
    border-right: 4px solid var(--primary, #00ff88);
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 10px;
    font-style: italic;
    color: rgba(255, 255, 255, 0.9);
    position: relative;
}

.page-content-area blockquote::before {
    content: '"';
    font-size: 4rem;
    color: var(--primary, #00ff88);
    position: absolute;
    top: -10px;
    right: 10px;
    opacity: 0.3;
}

.page-content-area img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
}

.page-content-area img:hover {
    transform: scale(1.02);
}

.page-links {
    text-align: center;
    margin: 2rem 0;
}

.page-number {
    background: var(--gradient, linear-gradient(135deg, #00ff88, #ff00aa));
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    margin: 0 0.3rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.page-number:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 255, 136, 0.3);
}

/* Breadcrumbs Styling */
.breadcrumbs {
    background: rgba(255, 255, 255, 0.05);
    padding: 1rem 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.breadcrumbs a {
    color: var(--primary, #00ff88);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumbs a:hover {
    color: var(--secondary, #ff00aa);
}

/* Table Styling */
.page-content-area table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    overflow: hidden;
}

.page-content-area th,
.page-content-area td {
    padding: 1rem;
    text-align: right;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.page-content-area th {
    background: var(--primary, #00ff88);
    color: var(--dark, #0a0a0a);
    font-weight: bold;
}

.page-content-area tr:last-child td {
    border-bottom: none;
}

.page-content-area tr:hover {
    background: rgba(0, 255, 136, 0.05);
}

/* Code Styling */
.page-content-area code {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
    font-family: 'Courier New', monospace;
    color: var(--primary, #00ff88);
}

.page-content-area pre {
    background: rgba(0, 0, 0, 0.3);
    padding: 1.5rem;
    border-radius: 10px;
    overflow-x: auto;
    margin: 2rem 0;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.page-content-area pre code {
    background: none;
    padding: 0;
}

/* Button Styling */
.page-content-area .btn,
.page-content-area .button {
    background: var(--gradient, linear-gradient(135deg, #00ff88, #ff00aa));
    color: white;
    padding: 1rem 2rem;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    margin: 1rem 0;
}

.page-content-area .btn:hover,
.page-content-area .button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
    border-bottom: none;
}

/* Form Styling */
.page-content-area input,
.page-content-area textarea,
.page-content-area select {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 1rem;
    color: white;
    width: 100%;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.page-content-area input:focus,
.page-content-area textarea:focus,
.page-content-area select:focus {
    outline: none;
    border-color: var(--primary, #00ff88);
    box-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
}

/* Comments Styling */
.comments-area {
    background: var(--light, #1a1a1a);
    border-radius: 20px;
    padding: 2rem;
    margin-top: 3rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.comments-title {
    color: var(--primary, #00ff88);
    font-size: 1.5rem;
    margin-bottom: 2rem;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .page-title {
        font-size: 2rem;
    }
    
    .page-featured-image {
        height: 300px;
    }
    
    .page-content-area {
        font-size: 1rem;
    }
}

@media (max-width: 768px) {
    .page-wrapper {
        padding: 0 1rem;
    }
    
    .page-article {
        border-radius: 15px;
    }
    
    .page-title-section,
    .page-content-area {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
    
    .page-container {
        padding: 5rem 0 1rem;
    }
    
    .breadcrumbs {
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
    }
}

@media (max-width: 480px) {
    .page-featured-image {
        height: 250px;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-excerpt {
        font-size: 1rem;
    }
    
    .page-content-area {
        font-size: 0.95rem;
        padding: 1rem;
    }
    
    .page-content-area h2 {
        font-size: 1.5rem;
    }
    
    .page-content-area h3 {
        font-size: 1.3rem;
    }
}

/* Print Styles */
@media print {
    .page-article {
        box-shadow: none;
        border: 1px solid #ccc;
        background: white;
    }
    
    .page-content-area,
    .page-title {
        color: #000 !important;
    }
    
    .breadcrumbs {
        display: none;
    }
    
    .page-content-area a {
        color: #000 !important;
        border-bottom: 1px solid #000;
    }
}

/* Animation Effects */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.page-article {
    animation: fadeInUp 0.6s ease-out;
}

.page-content-area p,
.page-content-area h1,
.page-content-area h2,
.page-content-area h3,
.page-content-area h4,
.page-content-area h5,
.page-content-area h6 {
    animation: fadeInUp 0.6s ease-out;
}

/* Accessibility Improvements */
.page-content-area :focus {
    outline: 2px solid var(--primary, #00ff88);
    outline-offset: 2px;
}

.page-title:focus,
.page-content-area a:focus {
    outline: 2px solid var(--primary, #00ff88);
    outline-offset: 2px;
}

/* Skip to content link for screen readers */
.skip-link {
    position: absolute;
    left: -9999px;
    z-index: 999999;
    padding: 8px 16px;
    background: var(--primary, #00ff88);
    color: var(--dark, #0a0a0a);
    text-decoration: none;
}

.skip-link:focus {
    left: 6px;
    top: 7px;
}
</style>

<?php get_footer(); ?>