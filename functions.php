<?php

// 1. Kích hoạt các tính năng cơ bản của Wordpress & Woocommerce
function theme_setup(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // Tích hợp woocommerce
    add_theme_support('woocommerce');

    // Đăng ký Menu
    register_nav_menus(array(
        "primary_menu" => "Primary Menu (Header)",
        "footer_menu" => "Footer Menu"
    ));
}
add_action('after_setup_theme', 'theme_setup');

// 1.b Callback Menu Dự Phòng (Đảm bảo giao diện thẳng hàng kể cả khi chưa cấu hình Menu trong WP Admin)
function theme_primary_menu_fallback() {
    $pages = get_pages(array('number' => 5, 'sort_column' => 'menu_order'));
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_page_link($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    echo '</ul>';
}

function theme_footer_menu_fallback() {
    $pages = get_pages(array('number' => 4, 'sort_column' => 'menu_order'));
    echo '<ul>';
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_page_link($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * 1.c Helper: Chuẩn hóa URL nội bộ theme, luôn đảm bảo trỏ đúng thư mục WordPress kể cả trong localhost/subfolder
 */
function otr_url($path_or_url) {
    if (empty($path_or_url) || in_array($path_or_url, array('#', ''))) {
        return home_url('/');
    }
    // Nếu là link tuyệt đối bên ngoài hoặc protocol đặc biệt
    if (strpos($path_or_url, 'http://') === 0 || strpos($path_or_url, 'https://') === 0 || strpos($path_or_url, 'mailto:') === 0 || strpos($path_or_url, 'tel:') === 0) {
        return $path_or_url;
    }
    // Chuẩn hóa link nội bộ thành link tuyệt đối đầy đủ theo home_url()
    return home_url('/' . ltrim($path_or_url, '/'));
}

// 2. Nhúng CSS/JS thông minh (Biên dịch qua Vite) vào theme
function theme_scripts(){
    
    // 0. Nhúng Google Fonts (Roboto, Cormorant Garamond & Playfair Display hỗ trợ tiếng Việt)
    wp_enqueue_style(
        'theme-font-google',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&subset=vietnamese,latin&display=swap',
        array(),
        null
    );

    // Nhúng CSS Biên dịch từ Tailwind CSS v4
    $css_path = '/assets/dist/css/style.css';
    if (file_exists(get_template_directory() . $css_path)) {
        wp_enqueue_style(
            'theme-tailwind-style', 
            get_template_directory_uri() . $css_path, 
            array(), 
            filemtime(get_template_directory() . $css_path)
        );
    } else {
        // Fallback CSS gốc nếu chưa biên dịch
        wp_enqueue_style(
            'theme-fallback-style', 
            get_stylesheet_uri(), 
            array(), 
            '1.0.0'
        );
    }
    
    // 3. Nhúng JS chính dùng chung (Global Script & Lucide Icons)
    $main_js_path = '/assets/dist/js/main.js';
    if (file_exists(get_template_directory() . $main_js_path)) {
        wp_enqueue_script(
            'theme-main-script',
            get_template_directory_uri() . $main_js_path,
            array(),
            filemtime(get_template_directory() . $main_js_path),
            true
        );
    }

    // 4. Cơ chế MAP JS: Tự động tải JS tương ứng cho từng trang
    $page_script = '';

    if (is_front_page()) {
        $page_script = 'home';
    } elseif (is_page_template('theme-pages/page-menu.php') || is_page('menu')) {
        $page_script = 'menu';
    } elseif (is_page_template('theme-pages/page-booking.php') || is_page('booking')) {
        $page_script = 'booking';
    } elseif (is_page_template('theme-pages/page-contact.php') || is_page('contact')) {
        $page_script = 'contact';
    } elseif (is_page_template('theme-pages/page-blog.php') || is_page_template('page-blog.php') || is_page('blog') || is_page('blog-event') || is_home() || is_category() || is_archive()) {
        $page_script = 'blog';
    } elseif (is_single()) {
        $page_script = 'blog-detail';
    } elseif (is_search()) {
        $page_script = 'search';
    } elseif (is_page()) {
        $page_script = 'page';
    }

    if (!empty($page_script)) {
        $page_js_path = '/assets/dist/js/' . $page_script . '.js';
        if (file_exists(get_template_directory() . $page_js_path)) {
            wp_enqueue_script(
                'theme-page-' . $page_script,
                get_template_directory_uri() . $page_js_path,
                array('theme-main-script'), // Phụ thuộc vào main script chứa Lucide Icons
                filemtime(get_template_directory() . $page_js_path),
                true
            );

            if ($page_script === 'booking') {
                wp_localize_script(
                    'theme-page-' . $page_script,
                    'otrBookingData',
                    array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'nonce'    => wp_create_nonce('otr_booking_nonce'),
                    )
                );
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'theme_scripts');

/**
 * 5. Helper nhúng Icon SVG (Hỗ trợ cả Server-side & Client-side)
 * Hướng dẫn sử dụng:
 * - Dùng PHP render trực tiếp (Tốt cho SEO, tải trang nhanh): <?php echo get_svg_icon('shopping-cart', 'w-6 h-6 text-blue-500'); ?>
 * - Hoặc dùng client-side: <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-500"></i>
 */
function get_svg_icon($icon_name, $classes = '') {
    $icon_path = get_template_directory() . '/assets/icons/' . $icon_name . '.svg';
    
    if (file_exists($icon_path)) {
        $svg = file_get_contents($icon_path);
        // Nhúng thêm class CSS vào thẻ SVG
        if (!empty($classes)) {
            $svg = preg_replace('/<svg([^>]+)>/i', '<svg$1 class="' . esc_attr($classes) . '">', $svg);
        }
        return $svg;
    }
    
    // Nếu chưa có file SVG cục bộ, trả về thẻ i để Lucide JS tự render ở Client-side
    return '<i data-lucide="' . esc_attr($icon_name) . '" class="' . esc_attr($classes) . '"></i>';
}

/**
 * 6. Bộ nạp Template Tùy biến (Custom Template Loader)
 * Tự động chuyển hướng WordPress tìm kiếm các file giao diện trong thư mục 'theme-pages/'
 * giúp thư mục gốc (root) của theme luôn sạch sẽ, chỉ chừa lại các file setup chuẩn.
 */
function theme_custom_template_loader($template) {
    $template_file = '';

    // 1. Ánh xạ các trang đặc biệt sử dụng Conditional Tags của WordPress
    if ( is_front_page() ) {
        $template_file = 'front-page.php';
    } elseif ( is_page_template('theme-pages/page-menu.php') || is_page('menu') ) {
        $template_file = 'page-menu.php';
    } elseif ( is_page_template('theme-pages/page-booking.php') || is_page('booking') ) {
        $template_file = 'page-booking.php';
    } elseif ( is_page_template('theme-pages/page-contact.php') || is_page('contact') ) {
        $template_file = 'page-contact.php';
    } elseif ( is_page_template('theme-pages/page-blog.php') || is_page_template('page-blog.php') || is_page('blog') || is_page('blog-event') ) {
        $template_file = 'page-blog.php';
    } elseif ( is_home() ) {
        $template_file = 'home.php';
    } elseif ( is_single() ) {
        $template_file = 'single.php';
    } elseif ( is_category() ) {
        $template_file = 'category.php';
    } elseif ( is_search() ) {
        $template_file = 'search.php';
    } elseif ( is_404() ) {
        $template_file = '404.php';
    } elseif ( is_page() ) {
        $custom_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
        if ( $custom_template && $custom_template !== 'default' ) {
            return $template;
        }
        $template_file = 'page.php';
    }

    if ( !empty($template_file) ) {
        $custom_path = get_template_directory() . '/theme-pages/' . $template_file;
        if ( file_exists($custom_path) ) {
            return $custom_path;
        }
    }

    // 2. Cơ chế dự phòng: Tìm theo tên tệp tin gốc nếu khớp
    $file_name = basename($template);
    $custom_template_path = get_template_directory() . '/theme-pages/' . $file_name;
    
    if (file_exists($custom_template_path)) {
        return $custom_template_path;
    }
    
    return $template;
}
add_filter('template_include', 'theme_custom_template_loader', 99);

/**
 * 7. Tối ưu hóa hiệu năng (Performance Optimization)
 * Bao gồm: Tải trễ hình ảnh (Lazy load), tải bất đồng bộ JS (Defer JS), 
 * và Preconnect các liên kết ngoài giúp tối ưu điểm số Google PageSpeed Insights.
 */

// 7.a Thêm thuộc tính defer="defer" vào tất cả các thẻ script để tránh chặn HTML Render (Tải JS bất đồng bộ)
function theme_defer_scripts($tag, $handle, $src) {
    // Không defer các script quản trị (admin) hoặc jquery core để tránh xung đột plugin
    if (is_admin() || $handle === 'jquery' || $handle === 'jquery-core') {
        return $tag;
    }
    // Defer cho toàn bộ script của theme và các thư viện frontend khác
    if (strpos($handle, 'theme-') !== false || strpos($handle, 'woocommerce') !== false || strpos($handle, 'lucide') !== false) {
        // Thêm type="module" cho script của theme để hỗ trợ ES Modules của Vite
        if (strpos($handle, 'theme-') !== false) {
            $tag = str_replace('<script ', '<script type="module" ', $tag);
        }
        return str_replace(' src', ' defer="defer" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'theme_defer_scripts', 10, 3);

// 7.b Tự động tối ưu hóa hình ảnh: Thêm loading="lazy" và decoding="async" cho mọi thẻ <img> trong bài viết/sản phẩm
function theme_optimize_images_attributes($attr, $attachment, $size) {
    // Ép buộc tất cả ảnh do WordPress sinh ra dùng cơ chế Lazy Load và Giải mã bất đồng bộ
    $attr['loading'] = 'lazy';
    $attr['decoding'] = 'async';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'theme_optimize_images_attributes', 10, 3);

// 7.c Lọc nội dung bài viết và tự động bổ sung loading="lazy" & decoding="async" cho hình ảnh chèn thủ công
function theme_lazyload_content_images($content) {
    if (!is_admin() && !empty($content)) {
        // Thêm loading="lazy" nếu chưa có
        $content = preg_replace_callback('/<img\s([^>]*)/i', function($matches) {
            $img = $matches[0];
            if (strpos($img, 'loading=') === false) {
                $img .= ' loading="lazy"';
            }
            if (strpos($img, 'decoding=') === false) {
                $img .= ' decoding="async"';
            }
            return $img;
        }, $content);
    }
    return $content;
}
add_filter('the_content', 'theme_lazyload_content_images', 99);

// 7.d Preconnect và DNS Prefetch các tên miền bên ngoài để tối ưu thời gian phân giải DNS (như Google Fonts, Unpkg)
function theme_resource_hints($urls, $relation_type) {
    if ('wp-resource-hints' === $relation_type) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = 'https://fonts.gstatic.com';
        $urls[] = 'https://unpkg.com';
    }
    return $urls;
}
add_filter('wp_resource_hints', 'theme_resource_hints', 10, 2);


/**
 * 9. Quản lý Custom Fields (ACF Settings)
 * Nạp cấu hình các trường dữ liệu tùy biến từ thư mục custom-fields/
 */
require get_template_directory() . '/custom-fields/acf-setup.php';

/**
 * 10. Quản lý Hệ thống Đặt Bàn (Booking CPT & Email Notification)
 */
require get_template_directory() . '/inc/cpt-booking.php';

/**
 * 10.b Quản lý Thực đơn đa cấp TheRocks (Menu TheRocks CRUD)
 */
require get_template_directory() . '/inc/admin-menu-therocks.php';

/**
 * 11. Tự động khởi tạo trang Đặt Bàn nếu chưa tồn tại
 */
function otr_auto_create_booking_page() {
    $booking_page = get_page_by_path('booking');
    if (!$booking_page) {
        wp_insert_post(array(
            'post_title'     => 'Đặt Bàn',
            'post_name'      => 'booking',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
            'page_template'  => 'theme-pages/page-booking.php',
        ));
    }
}
add_action('after_setup_theme', 'otr_auto_create_booking_page');

/**
 * 12. Tự động khởi tạo trang Liên Hệ nếu chưa tồn tại
 */
function otr_auto_create_contact_page() {
    $contact_page = get_page_by_path('contact');
    if (!$contact_page) {
        wp_insert_post(array(
            'post_title'     => 'Liên Hệ',
            'post_name'      => 'contact',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
            'page_template'  => 'theme-pages/page-contact.php',
        ));
    }
}
add_action('after_setup_theme', 'otr_auto_create_contact_page');

/**
 * 13. Shortcode: [otr_voucher]
 * Hiển thị thẻ vé voucher sự kiện phong cách On The Rock x DayM
 */
function otr_voucher_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'date_start' => '21 AUG',
        'date_end'   => '30 SEP',
        'year'       => '2026',
        'title'      => 'Voucher: OTR x DayM Collaboration',
        'desc'       => 'Giảm giá 50% cho 01 sản phẩm bất kỳ tại cửa hàng DayM.',
        'qty'        => 'Số lượng: 100 voucher.',
    ), $atts, 'otr_voucher' );

    ob_start();
    ?>
    <div class="otr-voucher-card my-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#2a2219] via-[#221b13] to-[#1a140e] border border-[#caa875]/35 p-5 md:p-6 shadow-2xl transition-all duration-300 hover:border-[#caa875]/60 group">
        <div class="flex flex-col sm:flex-row items-center gap-5 sm:gap-6">
            <!-- Phần cuống vé (Ticket Stub) -->
            <div class="shrink-0 w-full sm:w-auto flex sm:flex-col items-center justify-center gap-2 sm:gap-0.5 bg-[#f5ebd7] text-[#1c1712] rounded-xl px-5 py-3 sm:py-4 text-center select-none shadow-md">
                <span class="text-sm sm:text-base font-black tracking-wider uppercase leading-none"><?php echo esc_html( $atts['date_start'] ); ?></span>
                <span class="text-xs sm:text-sm font-semibold tracking-wider uppercase text-[#5a4833] leading-none"><?php echo esc_html( $atts['date_end'] ); ?></span>
                <span class="text-lg sm:text-2xl font-black tracking-tight text-[#1c1712] leading-tight mt-1 sm:mt-1.5"><?php echo esc_html( $atts['year'] ); ?></span>
            </div>

            <!-- Đường kẻ đục lỗ nét đứt (Perforated Line) -->
            <div class="hidden sm:block w-px self-stretch border-r border-dashed border-[#caa875]/40 mx-1"></div>
            <div class="block sm:hidden w-full h-px border-b border-dashed border-[#caa875]/40 my-1"></div>

            <!-- Phần thân vé (Ticket Body) -->
            <div class="grow text-left">
                <h4 class="font-bold text-base sm:text-lg md:text-xl text-[#f4efe8] mb-1.5 group-hover:text-[#caa875] transition-colors leading-snug font-mrch">
                    <?php echo esc_html( $atts['title'] ); ?>
                </h4>
                <p class="text-xs sm:text-sm text-stone-300 font-light leading-relaxed mb-1">
                    <?php echo esc_html( $atts['desc'] ); ?>
                </p>
                <?php if ( ! empty( $atts['qty'] ) ) : ?>
                    <span class="inline-block text-[11px] sm:text-xs text-[#caa875]/90 font-medium">
                        <?php echo esc_html( $atts['qty'] ); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'otr_voucher', 'otr_voucher_shortcode' );

/**
 * Tự động thêm class 'is-loaded' vào body cho tất cả các trang con (Menu, Blog, Contact, Booking,...)
 * Đảm bảo cuộn trang bình thường và hiển thị header ngay từ phía server HTML.
 */
add_filter( 'body_class', function ( $classes ) {
    if ( ! is_front_page() ) {
        $classes[] = 'is-loaded';
    }
    return $classes;
} );