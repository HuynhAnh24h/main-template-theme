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

// 2. Nhúng CSS/JS thông minh (Biên dịch qua Vite) vào theme
function theme_scripts(){
    
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
    } elseif (is_page_template('theme-pages/page-about.php')) {
        $page_script = 'about';
    } elseif (is_page_template('theme-pages/page-contact.php')) {
        $page_script = 'contact';
    } elseif (is_page_template('theme-pages/page-category-all.php')) {
        $page_script = 'category-all';
    } elseif (is_product_category() || is_tax('product_cat')) {
        $page_script = 'category';
    } elseif (is_post_type_archive('product') || (function_exists('is_shop') && is_shop())) {
        $page_script = 'product';
    } elseif (is_singular('product')) {
        $page_script = 'product-detail';
    } elseif (is_home()) {
        $page_script = 'blog';
    } elseif (is_category()) {
        $page_script = 'category-blog';
    } elseif (is_single()) {
        $page_script = 'blog-detail';
    } elseif (function_exists('is_cart') && is_cart()) {
        $page_script = 'cart';
    } elseif (function_exists('is_checkout') && is_checkout()) {
        $page_script = 'checkout';
    } elseif (function_exists('is_account_page') && is_account_page()) {
        $page_script = 'my-account';
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
    $file_name = basename($template);
    
    // Đường dẫn tệp tin trong thư mục theme-pages/
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