<?php
/**
 * The header for CryptoCoin Live theme
 * 
 * @package CryptoCoinLive
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/cairo.woff2" as="font" type="font/woff2" crossorigin>
    
    <!-- Security headers -->
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <!-- Theme color for mobile browsers -->
    <meta name="theme-color" content="#00ff88">
    <meta name="msapplication-TileColor" content="#00ff88">
    
    <!-- Apple touch icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/images/site.webmanifest">
    
    <!-- Critical CSS inline for faster loading -->
    <style>
        /* Critical CSS - Above the fold styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: <?php echo esc_html(get_theme_mod('primary_color', '#00ff88')); ?>;
            --secondary: <?php echo esc_html(get_theme_mod('secondary_color', '#ff00aa')); ?>;
            --dark: #0a0a0a;
            --darker: #050505;
            --light: #1a1a1a;
            --text: #ffffff;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        
        body {
            font-family: 'Cairo', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--darker);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .main-navigation {
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
        
        .site-logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            animation: glow 2s ease-in-out infinite;
        }
        
        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 10px var(--primary)); }
            50% { filter: drop-shadow(0 0 20px var(--secondary)); }
        }
        
        .main-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }
        
        .main-menu a {
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .main-menu a:hover {
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
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }
        
        .mobile-menu-toggle {
            display: none;
            background: var(--gradient);
            border: none;
            color: var(--text);
            padding: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2rem;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .main-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--dark);
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
                border-radius: 0 0 15px 15px;
            }
            
            .main-menu.active {
                display: flex;
            }
            
            .nav-container {
                padding: 0 1rem;
            }
            
            .main-navigation {
                padding: 0.5rem 1rem;
            }
        }
    </style>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Skip to content link for accessibility -->
    <a class="skip-link screen-reader-text" href="#main" style="
        position: absolute;
        left: -9999px;
        top: auto;
        width: 1px;
        height: 1px;
        overflow: hidden;
        background: var(--primary);
        color: var(--dark);
        padding: 0.5rem 1rem;
        text-decoration: none;
        z-index: 100000;
    " onfocus="this.style.left='6px'; this.style.top='7px'; this.style.width='auto'; this.style.height='auto';" onblur="this.style.left='-9999px'; this.style.top='auto'; this.style.width='1px'; this.style.height='1px';">
        <?php _e('Skip to content', 'cryptocoin-live'); ?>
    </a>

    <!-- Navigation -->
    <nav class="main-navigation" role="navigation" aria-label="<?php _e('Primary Navigation', 'cryptocoin-live'); ?>">
        <div class="nav-container">
            <!-- Logo -->
            <div class="site-branding">
                <?php if (has_custom_logo()): ?>
                    <div class="custom-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else: ?>
                    <a href="https://cryptocoinlive.co/index.php" class="site-logo" rel="home">
                        <?php echo esc_html(get_bloginfo('name')); ?>
                    </a>
                <?php endif; ?>
                
                <?php if (get_bloginfo('description') && !is_front_page()): ?>
                    <p class="site-description" style="
                        font-size: 0.8rem;
                        color: rgba(255, 255, 255, 0.7);
                        margin: 0;
                        line-height: 1.2;
                    ">
                        <?php echo esc_html(get_bloginfo('description')); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Mobile menu toggle -->
            <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false" onclick="toggleMobileMenu()">
                <span class="menu-icon">☰</span>
                <span class="screen-reader-text"><?php _e('Toggle Menu', 'cryptocoin-live'); ?></span>
            </button>

            <!-- Navigation Menu -->
            <div class="main-menu-wrapper">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'main-menu',
                        'container'      => false,
                        'walker'         => new Cryptocoin_Live_Walker_Nav_Menu(),
                    ));
                } else {
                    cryptocoin_live_default_menu();
                }
                ?>
            </div>
        </div>
    </nav>

    <main id="main" class="site-main" role="main">

<?php
// Default menu fallback if no menu is assigned
function cryptocoin_live_default_menu() {
    echo '<ul class="main-menu">';
    // تعديل رابط الرئيسية ليشير إلى index.php
    echo '<li><a href="https://cryptocoinlive.co/index.php">' . __('الرئيسية', 'cryptocoin-live') . '</a></li>';
    
    // Get pages for menu
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        if ($page->post_title !== 'Sample Page') {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
    }
    
    // Blog link
    if (get_option('page_for_posts')) {
        echo '<li><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . __('المدونة', 'cryptocoin-live') . '</a></li>';
    }
    
    // Authentication links
    if (is_user_logged_in()) {
        echo '<li><a href="' . esc_url(wp_logout_url('https://cryptocoinlive.co/index.php')) . '">' . __('تسجيل الخروج', 'cryptocoin-live') . '</a></li>';
        echo '<li><a href="' . esc_url(admin_url()) . '" class="btn-primary">' . __('لوحة التحكم', 'cryptocoin-live') . '</a></li>';
    } else {
        echo '<li><a href="' . esc_url(wp_login_url()) . '">' . __('تسجيل الدخول', 'cryptocoin-live') . '</a></li>';
        echo '<li><a href="' . esc_url(wp_registration_url()) . '" class="btn-primary">' . __('إنشاء حساب', 'cryptocoin-live') . '</a></li>';
    }
    
    echo '</ul>';
}

// Custom Walker for Navigation Menu
if (!class_exists('Cryptocoin_Live_Walker_Nav_Menu')) {
    class Cryptocoin_Live_Walker_Nav_Menu extends Walker_Nav_Menu {
        
        // Start Level - wrap in ul
        function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }

        // End Level
        function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        // Start Element - li and a tags
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names .'>';

            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

            // Add button class for CTA items
            $button_class = '';
            if (in_array('cta-button', $classes)) {
                $button_class = ' class="btn-primary"';
            } elseif (in_array('secondary-button', $classes)) {
                $button_class = ' class="btn-secondary"';
            }

            $link_before = isset($args->link_before) ? $args->link_before : '';
            $link_after = isset($args->link_after) ? $args->link_after : '';
            $before = isset($args->before) ? $args->before : '';
            $after = isset($args->after) ? $args->after : '';

            $item_output = $before;
            $item_output .= '<a' . $attributes . $button_class . '>';
            $item_output .= $link_before . apply_filters('the_title', $item->title, $item->ID) . $link_after;
            $item_output .= '</a>';
            $item_output .= $after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        // End Element
        function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= "</li>\n";
        }
    }
}
?>