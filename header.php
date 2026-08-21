<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?> <!-- BẮT BUỘC: Để WP nhúng CSS/JS và Meta Tag -->
</head>
<body <?php body_class('bg-lc-bg text-gray-800 antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Sticky Header -->
<header class="site-header sticky top-0 z-40 w-full bg-black">
    <div class="site-header__container container mx-auto px-4 py-3 flex items-center justify-between gap-6">
 
        <!-- Logo (Bên trái) -->
        <div class="site-header__logo shrink-0">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo-link flex items-center gap-2">
                <span class="site-header__logo-mark w-10 h-10 rounded-2xl bg-white text-black flex items-center justify-center font-black text-xl shadow-md shadow-white/10">
                    <?php echo esc_html( mb_strtoupper( mb_substr( get_bloginfo('name'), 0, 2 ) ) ); ?>
                </span>
                <span class="site-header__logo-text text-xl font-black text-white tracking-tight hover:text-gray-300 transition"><?php bloginfo('name'); ?></span>
            </a>
        </div>
 
        <!-- Search bar (Ở giữa - Desktop) -->
        <div class="site-header__search hidden lg:block flex-1 max-w-lg relative">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="site-header__search-form w-full">
                <input type="search" name="s" class="site-header__search-input w-full bg-neutral-900 border border-white/15 rounded-2xl px-5 py-2.5 pl-11 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-white focus:bg-neutral-800 transition duration-200" placeholder="Tìm kiếm sản phẩm...">
                <div class="site-header__search-icon absolute left-4 top-3 text-gray-500">
                    <?php echo get_svg_icon('search', 'w-4.5 h-4.5'); ?>
                </div>
            </form>
        </div>
 
        <!-- Navigation Menu (Desktop) -->
        <nav class="site-header__nav desktop-nav hidden lg:flex items-center font-extrabold text-xs uppercase tracking-wider text-gray-400">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary_menu',
                'container'      => false,
                'menu_class'     => 'site-header__nav-list flex items-center gap-6',
                'fallback_cb'    => 'theme_primary_menu_fallback'
            ));
            ?>
        </nav>
 
        <!-- Utilities (Desktop + Mobile) -->
        <div class="site-header__utilities flex items-center gap-4 text-gray-400 shrink-0">
            <!-- Search Icon (Hiện ở Mobile/Tablet thay vì thanh Search dài) -->
            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>?s=" class="site-header__icon-link p-1.5 hover:text-white transition lg:hidden" title="Tìm kiếm">
                <?php echo get_svg_icon('search', 'w-5 h-5'); ?>
            </a>
 
            <!-- User Account Profile (Desktop) -->
            <a href="<?php echo function_exists('get_permalink') ? esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) : '#'; ?>" class="site-header__icon-link p-1.5 hover:text-white transition hidden sm:block" title="Tài khoản">
                <?php echo get_svg_icon('user', 'w-5 h-5'); ?>
            </a>
 
            <!-- Cart Icon (WooCommerce - Luôn hiện) -->
            <a href="<?php echo function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#'; ?>" class="site-header__icon-link p-1.5 hover:text-white transition relative" title="Giỏ hàng">
                <?php echo get_svg_icon('shopping-cart', 'w-5 h-5'); ?>
                <?php if (function_exists('WC') && WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                    <span class="site-header__cart-badge absolute -top-1 -right-1 bg-white text-black text-[9px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center animate-pulse">
                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                    </span>
                <?php endif; ?>
            </a>
 
            <!-- Mobile Menu Toggle Button (Chỉ hiện ở Mobile/Tablet) -->
            <button id="mobile-menu-btn" class="site-header__mobile-toggle lg:hidden p-1.5 hover:text-white transition" title="Menu">
                <?php echo get_svg_icon('menu', 'w-5 h-5'); ?>
            </button>
        </div>
    </div>
 
    <!-- Mobile Navigation Menu Dropdown -->
    <div id="mobile-menu" class="site-header__mobile-menu hidden lg:hidden bg-black border-t border-white/10 shadow-xl shadow-black/40 absolute w-full left-0 py-5 px-6">
        <nav class="site-header__mobile-nav flex flex-col gap-4 font-extrabold text-xs uppercase tracking-wider text-gray-400">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary_menu',
                'container'      => false,
                'menu_class'     => 'site-header__mobile-nav-list flex flex-col gap-4',
                'fallback_cb'    => 'theme_primary_menu_fallback'
            ));
            ?>
            <!-- Search Mobile -->
            <div class="site-header__mobile-search relative mt-2 pt-2 border-t border-white/10">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" name="s" class="site-header__mobile-search-input w-full bg-neutral-900 border border-white/15 rounded-xl px-4 py-2.5 pl-10 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-white" placeholder="Tìm kiếm...">
                    <div class="site-header__mobile-search-icon absolute left-3.5 top-5.5 text-gray-500">
                        <?php echo get_svg_icon('search', 'w-4 h-4'); ?>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</header>

<!-- Main Wrapper -->
<main id="main-content" class="min-h-[70vh]">