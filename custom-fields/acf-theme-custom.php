<?php
/**
 * ACF Custom Fields: Theme Custom Homepage
 * Description: Cấu hình Menu Admin "Theme Custom" và các Custom Fields cho Trang chủ sử dụng bản ACF Free.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

/**
 * 1. Đăng ký Menu Admin Theme Custom & Home
 */
add_action('admin_menu', 'theme_custom_menu_registration');
function theme_custom_menu_registration() {
    // Menu chính "Theme Custom"
    add_menu_page(
        'Theme Custom',
        'Theme Custom',
        'manage_options',
        'theme-custom',
        'theme_custom_fallback_page',
        'dashicons-admin-customizer',
        60
    );

    // Menu con "Trang chủ" (ghi đè mục đầu tiên của Theme Custom)
    add_submenu_page(
        'theme-custom',
        'Cấu hình Trang chủ',
        '<span class="dashicons dashicons-admin-home" style="font-size:16px;width:16px;height:16px;margin-right:6px;vertical-align:text-bottom;"></span> Trang chủ',
        'manage_options',
        'theme-custom',
        'theme_custom_fallback_page'
    );

    // Menu con "Trang Menu"
    add_submenu_page(
        'theme-custom',
        'Cấu hình Trang Menu',
        '<span class="dashicons dashicons-food" style="font-size:16px;width:16px;height:16px;margin-right:6px;vertical-align:text-bottom;"></span> Trang Menu',
        'manage_options',
        'theme-custom-menu',
        'theme_custom_fallback_menu_page'
    );

    // Menu con "Cấu hình Đặt Bàn"
    add_submenu_page(
        'theme-custom',
        'Cấu hình Đặt Bàn',
        '<span class="dashicons dashicons-calendar-alt" style="font-size:16px;width:16px;height:16px;margin-right:6px;vertical-align:text-bottom;"></span> Cấu hình Đặt Bàn',
        'manage_options',
        'theme-custom-booking',
        'theme_custom_fallback_booking_page'
    );

    // Menu con "Cấu hình Liên Hệ"
    add_submenu_page(
        'theme-custom',
        'Cấu hình Liên Hệ',
        '<span class="dashicons dashicons-location-alt" style="font-size:16px;width:16px;height:16px;margin-right:6px;vertical-align:text-bottom;"></span> Cấu hình Liên Hệ',
        'manage_options',
        'theme-custom-contact',
        'theme_custom_fallback_contact_page'
    );

    // Menu con "Cấu hình Blog & Event"
    add_submenu_page(
        'theme-custom',
        'Cấu hình Blog & Event',
        '<span class="dashicons dashicons-welcome-write-blog" style="font-size:16px;width:16px;height:16px;margin-right:6px;vertical-align:text-bottom;"></span> Blog & Event',
        'manage_options',
        'theme-custom-blog',
        'theme_custom_fallback_blog_page'
    );
}

/**
 * Hàm hiển thị giao diện dự phòng nếu chưa thiết lập Trang chủ tĩnh
 */
function theme_custom_fallback_page() {
    $read_settings_url = admin_url('options-reading.php');
    echo '<div class="wrap">';
    echo '<h2>Theme Custom - Trang chủ</h2>';
    echo '<div class="notice notice-warning"><p>';
    echo 'Hiện tại bạn chưa cấu hình Trang chủ tĩnh. Vui lòng truy cập <a href="' . esc_url($read_settings_url) . '"><strong>Cài đặt -> Đọc</strong></a>, chọn <strong>"Một trang tĩnh"</strong> và gán một trang làm Trang chủ để bắt đầu cấu hình giao diện này.';
    echo '</p></div>';
    echo '</div>';
}

/**
 * Hàm hiển thị giao diện dự phòng nếu chưa tìm thấy trang Menu
 */
function theme_custom_fallback_menu_page() {
    echo '<div class="wrap">';
    echo '<h2>Theme Custom - Trang Menu</h2>';
    echo '<div class="notice notice-warning"><p>';
    echo 'Vui lòng tạo một trang và gán mẫu giao diện (Template) là <strong>"Menu Page"</strong> để quản trị kiểu hiển thị menu.';
    echo '</p></div>';
    echo '</div>';
}

/**
 * Hàm hiển thị giao diện dự phòng nếu chưa tìm thấy trang Đặt Bàn
 */
function theme_custom_fallback_booking_page() {
    echo '<div class="wrap">';
    echo '<h2>Theme Custom - Cấu hình Đặt Bàn</h2>';
    echo '<div class="notice notice-warning"><p>';
    echo 'Vui lòng truy cập <a href="' . esc_url(admin_url('edit.php?post_type=otr_booking&page=otr-booking-settings')) . '"><strong>Cài đặt nhận Email</strong></a> hoặc chỉnh sửa trang <strong>Đặt Bàn</strong> để cấu hình.';
    echo '</p></div>';
    echo '</div>';
}

/**
 * Hàm hiển thị giao diện dự phòng nếu chưa tìm thấy trang Liên Hệ
 */
function theme_custom_fallback_contact_page() {
    echo '<div class="wrap">';
    echo '<h2>Theme Custom - Cấu hình Liên Hệ</h2>';
    echo '<div class="notice notice-warning"><p>';
    echo 'Vui lòng tạo hoặc kích hoạt trang có đường dẫn <strong>/contact/</strong> hoặc gắn mẫu giao diện <strong>Contact Page</strong> để bắt đầu cấu hình.';
    echo '</p></div>';
    echo '</div>';
}

/**
 * Hàm hiển thị giao diện dự phòng nếu chưa tìm thấy trang Blog & Event
 */
function theme_custom_fallback_blog_page() {
    echo '<div class="wrap">';
    echo '<h2>Theme Custom - Cấu hình Blog & Event</h2>';
    echo '<div class="notice notice-warning"><p>';
    echo 'Vui lòng tạo hoặc kích hoạt trang có đường dẫn <strong>/blog/</strong> hoặc gắn mẫu giao diện <strong>Trang Blog & Event</strong> để bắt đầu cấu hình.';
    echo '</p></div>';
    echo '</div>';
}

/**
 * Tự động chuyển hướng khi click vào Theme Custom, Home hoặc Trang Menu / Đặt Bàn / Liên Hệ / Blog
 */
add_action('admin_init', 'theme_custom_admin_redirect');
function theme_custom_admin_redirect() {
    global $pagenow;
    if ($pagenow === 'admin.php' && isset($_GET['page'])) {
        if ($_GET['page'] === 'theme-custom' || $_GET['page'] === 'theme-custom-home') {
            $frontpage_id = get_option('page_on_front');
            if ($frontpage_id) {
                wp_redirect(admin_url('post.php?post=' . $frontpage_id . '&action=edit'));
                exit;
            }
        } elseif ($_GET['page'] === 'theme-custom-menu') {
            $menu_pages = get_posts(array(
                'post_type'      => 'page',
                'meta_key'       => '_wp_page_template',
                'meta_value'     => 'theme-pages/page-menu.php',
                'posts_per_page' => 1,
                'post_status'    => 'any',
            ));
            if (empty($menu_pages)) {
                $menu_page = get_page_by_path('menu');
                if ($menu_page) {
                    $menu_pages = array($menu_page);
                }
            }
            if (!empty($menu_pages)) {
                wp_redirect(admin_url('post.php?post=' . $menu_pages[0]->ID . '&action=edit'));
                exit;
            }
        } elseif ($_GET['page'] === 'theme-custom-booking') {
            $booking_pages = get_posts(array(
                'post_type'      => 'page',
                'meta_key'       => '_wp_page_template',
                'meta_value'     => 'theme-pages/page-booking.php',
                'posts_per_page' => 1,
                'post_status'    => 'any',
            ));
            if (empty($booking_pages)) {
                $bpage = get_page_by_path('booking');
                if ($bpage) {
                    $booking_pages = array($bpage);
                }
            }
            if (!empty($booking_pages)) {
                wp_redirect(admin_url('post.php?post=' . $booking_pages[0]->ID . '&action=edit'));
                exit;
            } else {
                wp_redirect(admin_url('edit.php?post_type=otr_booking&page=otr-booking-settings'));
                exit;
            }
        } elseif ($_GET['page'] === 'theme-custom-contact') {
            $contact_pages = get_posts(array(
                'post_type'      => 'page',
                'meta_key'       => '_wp_page_template',
                'meta_value'     => 'theme-pages/page-contact.php',
                'posts_per_page' => 1,
                'post_status'    => 'any',
            ));
            if (empty($contact_pages)) {
                $cpage = get_page_by_path('contact');
                if ($cpage) {
                    $contact_pages = array($cpage);
                }
            }
            if (!empty($contact_pages)) {
                wp_redirect(admin_url('post.php?post=' . $contact_pages[0]->ID . '&action=edit'));
                exit;
            }
        } elseif ($_GET['page'] === 'theme-custom-blog') {
            $blog_pages = get_posts(array(
                'post_type'      => 'page',
                'meta_key'       => '_wp_page_template',
                'meta_value'     => 'theme-pages/page-blog.php',
                'posts_per_page' => 1,
                'post_status'    => 'any',
            ));
            if (empty($blog_pages)) {
                $bpage = get_page_by_path('blog');
                if ($bpage) {
                    $blog_pages = array($bpage);
                }
            }
            if (!empty($blog_pages)) {
                wp_redirect(admin_url('post.php?post=' . $blog_pages[0]->ID . '&action=edit'));
                exit;
            }
        }
    }
}

/**
 * 2. Đăng ký nhóm trường ACF Free cho Trang chủ
 */
if (function_exists('acf_add_local_field_group')) {

    $fields = array(
        // Tab 1: Câu nói mở đầu (Intro Quote)
        array(
            'key' => 'field_tab_home_reveal_content',
            'label' => 'Câu nói mở đầu (Intro Quote)',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_home_intro_quote',
            'label' => '<span class="dashicons dashicons-translation" style="color:#2271b1;font-size:16px;width:16px;height:16px;vertical-align:text-bottom;"></span> Câu nói mở đầu (Tiếng Việt)',
            'name' => 'home_intro_quote',
            'type' => 'textarea',
            'default_value' => "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.",
            'placeholder' => "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.",
            'instructions' => 'Dòng chữ màu vàng nổi bật ở giữa màn hình trên các hình ảnh sau khi hiệu ứng loading hoàn tất.',
            'rows' => 3,
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'field_home_intro_quote_en',
            'label' => '<span class="dashicons dashicons-admin-site-alt3" style="color:#caa875;font-size:16px;width:16px;height:16px;vertical-align:text-bottom;"></span> Câu nói mở đầu (English Translation)',
            'name' => 'home_intro_quote_en',
            'type' => 'textarea',
            'default_value' => "A cocktail bar in Da Lat,\nby Da Lat locals, crafted for those\nseeking an enchanting Da Lat experience.",
            'placeholder' => "A cocktail bar in Da Lat,\nby Da Lat locals, crafted for those\nseeking an enchanting Da Lat experience.",
            'instructions' => 'Bản dịch tiếng Anh hiển thị khi người xem chọn ngôn ngữ EN.',
            'rows' => 3,
            'wrapper' => array('width' => '50'),
        ),

        // Tab 2: Hình ảnh (10 ảnh)
        array(
            'key' => 'field_tab_home_reveal_images',
            'label' => 'Hình ảnh (10 ảnh)',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
    );

    // Sinh tự động 10 trường ảnh để tương thích ACF Free
    for ($i = 1; $i <= 10; $i++) {
        $fields[] = array(
            'key' => 'field_home_reveal_image_' . $i,
            'label' => 'Hình ảnh thứ ' . $i,
            'name' => 'home_reveal_image_' . $i,
            'type' => 'image',
            'instructions' => 'Tải lên hình ảnh thứ ' . $i . ' cho slider và moodboard.',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'wrapper' => array(
                'width' => '50', // Hiển thị 2 cột
            ),
        );
    }

    // Tab 3: Cấu hình Header
    $fields[] = array(
        'key' => 'field_tab_home_header',
        'label' => 'Header (Thanh điều hướng)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_header_facebook_url',
        'label' => 'Link Facebook',
        'name' => 'header_facebook_url',
        'type' => 'text',
        'default_value' => 'https://facebook.com/ontherock.dalat',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_header_instagram_url',
        'label' => 'Link Instagram',
        'name' => 'header_instagram_url',
        'type' => 'text',
        'default_value' => 'https://instagram.com/ontherock.dalat',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_header_logo',
        'label' => 'Logo Thương hiệu (Monogram)',
        'name' => 'header_logo',
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'instructions' => 'Tải lên logo monogram dạng đứng (nếu để trống sẽ dùng logo SVG mặc định).',
    );
    $fields[] = array(
        'key' => 'field_header_menu_text',
        'label' => 'Chữ link Menu (VI)',
        'name' => 'header_menu_text',
        'type' => 'text',
        'default_value' => 'MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_menu_text_en',
        'label' => 'Chữ link Menu (EN)',
        'name' => 'header_menu_text_en',
        'type' => 'text',
        'default_value' => 'MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_menu_url',
        'label' => 'Đường dẫn Menu',
        'name' => 'header_menu_url',
        'type' => 'text',
        'default_value' => '/menu/',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_header_contact_text',
        'label' => 'Chữ link Contact (VI)',
        'name' => 'header_contact_text',
        'type' => 'text',
        'default_value' => 'CONTACT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_contact_text_en',
        'label' => 'Chữ link Contact (EN)',
        'name' => 'header_contact_text_en',
        'type' => 'text',
        'default_value' => 'CONTACT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_contact_url',
        'label' => 'Đường dẫn Contact',
        'name' => 'header_contact_url',
        'type' => 'text',
        'default_value' => '/contact/',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_header_booking_text',
        'label' => 'Chữ nút Đặt bàn (VI)',
        'name' => 'header_booking_text',
        'type' => 'text',
        'default_value' => 'ĐẶT BÀN TRƯỚC',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_booking_text_en',
        'label' => 'Chữ nút Đặt bàn (EN)',
        'name' => 'header_booking_text_en',
        'type' => 'text',
        'default_value' => 'RESERVATION',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_header_booking_url',
        'label' => 'Đường dẫn Đặt bàn',
        'name' => 'header_booking_url',
        'type' => 'text',
        'default_value' => '/booking/',
        'wrapper' => array('width' => '50'),
    );

    // Tab 4: Cấu hình Hero Cocktail
    $fields[] = array(
        'key' => 'field_tab_home_hero',
        'label' => 'Hero Section (Cocktail Bar)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_hero_bg_image',
        'label' => 'Ảnh nền Hero (Quầy Cocktail)',
        'name' => 'hero_bg_image',
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => 'medium',
        'instructions' => 'Tải lên hình nền quầy bar chất lượng cao (nếu để trống sẽ dùng ảnh mẫu).',
    );
    $fields[] = array(
        'key' => 'field_hero_title',
        'label' => 'Tiêu đề chính Hero',
        'name' => 'hero_title',
        'type' => 'textarea',
        'default_value' => "BESPEAK YOUR\nBESPOKE COCKTAIL",
        'placeholder' => "BESPEAK YOUR\nBESPOKE COCKTAIL",
        'instructions' => 'Hỗ trợ xuống dòng để tách các dòng chữ nghệ thuật.',
        'rows' => 2,
    );
    $fields[] = array(
        'key' => 'field_hero_btn_text',
        'label' => 'Chữ nút Hero (VI)',
        'name' => 'hero_btn_text',
        'type' => 'text',
        'default_value' => 'XEM MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_hero_btn_text_en',
        'label' => 'Chữ nút Hero (EN)',
        'name' => 'hero_btn_text_en',
        'type' => 'text',
        'default_value' => 'VIEW MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_hero_btn_link',
        'label' => 'Đường dẫn nút Hero',
        'name' => 'hero_btn_link',
        'type' => 'text',
        'default_value' => '#menu',
        'wrapper' => array('width' => '33'),
    );
    $fields[] = array(
        'key' => 'field_hero_btn_style',
        'label' => 'Kiểu nút Hero',
        'name' => 'hero_btn_style',
        'type' => 'select',
        'choices' => array(
            'solid-dark' => 'Solid Dark (Nâu Sẫm - Theo ảnh mẫu)',
            'outline' => 'Outline (Viền mảnh)',
            'solid-gold' => 'Solid Gold (Vàng Cát)',
            'solid-light' => 'Solid Light (Vàng Sáng)',
            'solid-black' => 'Solid Black (Nền đen viền vàng)',
        ),
        'default_value' => 'solid-dark',
        'wrapper' => array('width' => '34'),
    );

    // Tab 5: Thẻ đánh giá Google
    $fields[] = array(
        'key' => 'field_tab_home_review',
        'label' => 'Đánh giá Google (Review)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_hero_review_score',
        'label' => 'Điểm số đánh giá',
        'name' => 'hero_review_score',
        'type' => 'text',
        'default_value' => '4.7',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_max',
        'label' => 'Điểm tối đa',
        'name' => 'hero_review_max',
        'type' => 'text',
        'default_value' => '/5',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_title',
        'label' => 'Đánh giá chữ (VI)',
        'name' => 'hero_review_title',
        'type' => 'text',
        'default_value' => 'Xuất sắc',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_title_en',
        'label' => 'Đánh giá chữ (EN)',
        'name' => 'hero_review_title_en',
        'type' => 'text',
        'default_value' => 'Excellent',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_subtitle',
        'label' => 'Số lượt đánh giá (VI)',
        'name' => 'hero_review_subtitle',
        'type' => 'text',
        'default_value' => 'Dựa trên 3 576 lượt đánh giá',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_subtitle_en',
        'label' => 'Số lượt đánh giá (EN)',
        'name' => 'hero_review_subtitle_en',
        'type' => 'text',
        'default_value' => 'Based on 3 576 reviews',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_hero_review_link',
        'label' => 'Link đánh giá Google Maps',
        'name' => 'hero_review_link',
        'type' => 'text',
        'default_value' => '#',
    );

    // Tab 6: Dải chữ Marquee chạy ngang
    $fields[] = array(
        'key' => 'field_tab_home_marquee',
        'label' => 'Dải chữ chạy (Marquee)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_hero_marquee_text',
        'label' => 'Nội dung chữ chạy',
        'name' => 'hero_marquee_text',
        'type' => 'text',
        'default_value' => 'ON THE ROCKS COCKTAIL BAR',
    );

    // Tab 7: Khối Cảm nhận khách hàng (Testimonials)
    $fields[] = array(
        'key' => 'field_tab_home_testimonials',
        'label' => 'Cảm nhận khách hàng',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_testimonials_title',
        'label' => 'Tiêu đề khối Cảm nhận (VI)',
        'name' => 'testimonials_title',
        'type' => 'text',
        'default_value' => 'CẢM NHẬN TỪ KHÁCH HÀNG',
        'instructions' => 'Dòng tiêu đề hiển thị ở đầu khối cảm nhận khách hàng.',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_testimonials_title_en',
        'label' => 'Tiêu đề khối Cảm nhận (EN)',
        'name' => 'testimonials_title_en',
        'type' => 'text',
        'default_value' => 'GUEST REVIEWS',
        'instructions' => 'Bản dịch tiếng Anh hiển thị ngoài frontend khi chọn EN.',
        'wrapper' => array('width' => '50'),
    );

    // Tab 8: Khối Thực đơn Menu
    $fields[] = array(
        'key' => 'field_tab_home_menu',
        'label' => 'Thực đơn Menu',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_menu_section_title',
        'label' => 'Tiêu đề khối Menu (VI)',
        'name' => 'menu_section_title',
        'type' => 'text',
        'default_value' => 'THỰC ĐƠN',
        'instructions' => 'Dòng chữ tiêu đề khối menu.',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_menu_section_title_en',
        'label' => 'Tiêu đề khối Menu (EN)',
        'name' => 'menu_section_title_en',
        'type' => 'text',
        'default_value' => 'MENU',
        'instructions' => 'Bản dịch tiếng Anh hiển thị khi chọn EN.',
        'wrapper' => array('width' => '50'),
    );

    // Đăng ký 8 món menu cocktail
    $default_menu_items = array(
        1 => array('BESPOKE COCKTAIL', 'Đi ngang lâu lắm rồi giờ mới có dịp ghé quán, trời mưa có nhân viên siêu nice hỗ trợ', 'BESPOKE COCKTAIL', 'Passed by many times, finally visited; on a rainy day, the staff was exceptionally nice and supportive.'),
        2 => array('CLASSIC COCKTAIL', 'Hương vị cổ điển vượt thời gian — từ Old Fashioned đậm đà đến Negroni trầm lắng.', 'CLASSIC COCKTAIL', 'Timeless classic flavors — from the bold Old Fashioned to the contemplative Negroni.'),
        3 => array('SIGNATURE CREATION', 'Sáng tạo độc quyền từ các bartender lành nghề với các tầng hương độc bản của thảo mộc cao nguyên.', 'SIGNATURE CREATION', 'Exclusive creations by skilled bartenders with distinct layers of highland botanicals.'),
        4 => array('MOCKTAIL & BOTANICAL', 'Trải nghiệm tinh tế không cồn, thanh mát và cân bằng hoàn hảo cho buổi tối thư thái.', 'MOCKTAIL & BOTANICAL', 'Refined non-alcoholic experience, crisp and perfectly balanced for a relaxed evening.'),
        5 => array('PREMIUM SPIRITS & WHISKY', 'Bộ sưu tập single malt và whisky tuyển chọn từ các nhà chưng cất danh tiếng thế giới.', 'PREMIUM SPIRITS & WHISKY', 'Curated single malts and whiskies from world-renowned distilleries.'),
        6 => array('WINE & CHAMPAGNE', 'Những giọt vang thượng hạng và bọt sủi champagne lấp lánh nâng niu từng khoảnh khắc đáng nhớ.', 'WINE & CHAMPAGNE', 'Fine wines and sparkling champagne bubbles celebrating every memorable moment.'),
        7 => array('BAR BITES & TAPAS', 'Món ăn nhẹ tinh hoa kết hợp phong vị Á - Âu, được thiết kế để tôn vinh hương vị đồ uống.', 'BAR BITES & TAPAS', 'Artisanal Asian-European fusion bar bites crafted to elevate drink pairings.'),
        8 => array('SEASONAL SPECIALS', 'Bản giao hưởng hương vị theo mùa — biến tấu ngẫu hứng với nguyên liệu tươi mới độc đáo.', 'SEASONAL SPECIALS', 'A seasonal symphony of flavors — improvised with fresh and unique local produce.'),
    );

    for ($m = 1; $m <= 8; $m++) {
        $num_str = sprintf('%02d', $m);
        $title_def    = isset($default_menu_items[$m]) ? $default_menu_items[$m][0] : "COCKTAIL ITEM $num_str";
        $desc_def     = isset($default_menu_items[$m]) ? $default_menu_items[$m][1] : "Mô tả ngắn hương vị đồ uống món $num_str.";
        $title_def_en = isset($default_menu_items[$m]) ? $default_menu_items[$m][2] : "COCKTAIL ITEM $num_str";
        $desc_def_en  = isset($default_menu_items[$m]) ? $default_menu_items[$m][3] : "Short tasting notes for item $num_str.";

        $fields[] = array(
            'key' => 'field_menu_item_title_' . $m,
            'label' => "Tên món $num_str (VI)",
            'name' => 'menu_item_title_' . $m,
            'type' => 'text',
            'default_value' => $title_def,
            'wrapper' => array('width' => '50'),
        );
        $fields[] = array(
            'key' => 'field_menu_item_title_' . $m . '_en',
            'label' => "Tên món $num_str (EN)",
            'name' => 'menu_item_title_' . $m . '_en',
            'type' => 'text',
            'default_value' => $title_def_en,
            'wrapper' => array('width' => '50'),
        );
        $fields[] = array(
            'key' => 'field_menu_item_desc_' . $m,
            'label' => "Mô tả món $num_str (VI)",
            'name' => 'menu_item_desc_' . $m,
            'type' => 'textarea',
            'rows' => 2,
            'default_value' => $desc_def,
            'wrapper' => array('width' => '50'),
        );
        $fields[] = array(
            'key' => 'field_menu_item_desc_' . $m . '_en',
            'label' => "Mô tả món $num_str (EN)",
            'name' => 'menu_item_desc_' . $m . '_en',
            'type' => 'textarea',
            'rows' => 2,
            'default_value' => $desc_def_en,
            'wrapper' => array('width' => '50'),
        );
        $fields[] = array(
            'key' => 'field_menu_item_image_' . $m,
            'label' => "Ảnh minh họa món $num_str",
            'name' => 'menu_item_image_' . $m,
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'wrapper' => array('width' => '100'),
        );
    }

    // Tab 9: Khối Khoảnh khắc @OnTheRock (Hỗ trợ Ảnh & Video dọc tràn viền)
    $fields[] = array(
        'key' => 'field_tab_home_moments',
        'label' => 'Khoảnh khắc @OnTheRock',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_moments_title_1',
        'label' => 'Tiêu đề dòng 1 (VI)',
        'name' => 'moments_title_1',
        'type' => 'text',
        'default_value' => 'THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_moments_title_1_en',
        'label' => 'Tiêu đề dòng 1 (EN)',
        'name' => 'moments_title_1_en',
        'type' => 'text',
        'default_value' => 'SAVOR, CAPTURE THE MOMENT',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_moments_title_2',
        'label' => 'Tiêu đề dòng 2 (VI)',
        'name' => 'moments_title_2',
        'type' => 'text',
        'default_value' => 'VÀ GẮN THẺ @ONTHEROCK.',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_moments_title_2_en',
        'label' => 'Tiêu đề dòng 2 (EN)',
        'name' => 'moments_title_2_en',
        'type' => 'text',
        'default_value' => 'AND TAG @ONTHEROCK.',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_moments_instagram_url',
        'label' => 'Link Instagram',
        'name' => 'moments_instagram_url',
        'type' => 'url',
        'default_value' => 'https://instagram.com',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_moments_facebook_url',
        'label' => 'Link Facebook',
        'name' => 'moments_facebook_url',
        'type' => 'url',
        'default_value' => 'https://facebook.com',
        'wrapper' => array('width' => '50'),
    );

    // Cấu hình 4 cột phương tiện (hỗ trợ cả ảnh và video dọc)
    for ($i = 1; $i <= 4; $i++) {
        $fields[] = array(
            'key' => 'field_moments_media_type_' . $i,
            'label' => "Cột $i: Định dạng",
            'name' => 'moments_media_type_' . $i,
            'type' => 'select',
            'choices' => array(
                'image' => 'Hình ảnh (Image)',
                'video' => 'Video dọc (Vertical Video .mp4)',
            ),
            'default_value' => 'image',
            'wrapper' => array('width' => '25'),
        );
        $fields[] = array(
            'key' => 'field_moments_image_' . $i,
            'label' => "Cột $i: Hình ảnh",
            'name' => 'moments_image_' . $i,
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'wrapper' => array('width' => '25'),
        );
        $fields[] = array(
            'key' => 'field_moments_video_' . $i,
            'label' => "Cột $i: Tệp Video .mp4 (dọc)",
            'name' => 'moments_video_' . $i,
            'type' => 'file',
            'return_format' => 'url',
            'mime_types' => 'mp4,webm',
            'instructions' => 'Tải lên video .mp4 dọc hoặc dán link video.',
            'wrapper' => array('width' => '25'),
        );
        $fields[] = array(
            'key' => 'field_moments_badge_' . $i,
            'label' => "Cột $i: Chữ nghệ thuật đè lên ảnh/video",
            'name' => 'moments_badge_' . $i,
            'type' => 'text',
            'default_value' => ($i === 3) ? 'THE BAR is where STORIES BEGIN' : '',
            'instructions' => 'Để trống nếu không muốn hiện chữ đè lên.',
            'wrapper' => array('width' => '25'),
        );
    }

    // Tab 10: Khối Đội ngũ (Meet The On The Rock Team)
    $fields[] = array(
        'key' => 'field_tab_home_team',
        'label' => 'Đội ngũ (Team OTR)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );
    $fields[] = array(
        'key' => 'field_team_marquee_text',
        'label' => 'Nội dung chữ chạy (VI)',
        'name' => 'team_marquee_text',
        'type' => 'text',
        'default_value' => 'GẶP GỠ ĐỘI NGŨ ON THE ROCK',
        'instructions' => 'Dòng chữ chạy vô tận ở dải trên và dải dưới của khối đội ngũ.',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_team_marquee_text_en',
        'label' => 'Nội dung chữ chạy (EN)',
        'name' => 'team_marquee_text_en',
        'type' => 'text',
        'default_value' => 'MEET THE ON THE ROCK TEAM',
        'instructions' => 'Bản dịch tiếng Anh hiển thị khi chọn EN.',
        'wrapper' => array('width' => '50'),
    );

    $default_team_members = array(
        1 => array('QUỲNH VÂN', 'QUẢN LÝ CỬA HÀNG', 'STORE MANAGER'),
        2 => array('TUẤN KIỆT', 'QUẢN LÝ QUẦY BAR', 'BAR MANAGER'),
        3 => array('VĂN BẢO', 'TRƯỞNG CA QUẦY BAR', 'BAR CAPTAIN'),
        4 => array('THÀNH ĐỨC', 'TRƯỞNG CA QUẦY BAR', 'BAR CAPTAIN'),
        5 => array('HỒNG PHÚ', 'CHUYÊN VIÊN PHA CHẾ', 'BARTENDER'),
    );

    for ($t = 1; $t <= 5; $t++) {
        $t_name_def    = isset($default_team_members[$t]) ? $default_team_members[$t][0] : "THÀNH VIÊN $t";
        $t_role_def    = isset($default_team_members[$t]) ? $default_team_members[$t][1] : "CHUYÊN VIÊN PHA CHẾ";
        $t_role_def_en = isset($default_team_members[$t]) ? $default_team_members[$t][2] : "BARTENDER";

        $fields[] = array(
            'key' => 'field_team_member_name_' . $t,
            'label' => "Thành viên $t: Họ tên",
            'name' => 'team_member_name_' . $t,
            'type' => 'text',
            'default_value' => $t_name_def,
            'wrapper' => array('width' => '33'),
        );
        $fields[] = array(
            'key' => 'field_team_member_role_' . $t,
            'label' => "Thành viên $t: Chức vụ (VI)",
            'name' => 'team_member_role_' . $t,
            'type' => 'text',
            'default_value' => $t_role_def,
            'wrapper' => array('width' => '33'),
        );
        $fields[] = array(
            'key' => 'field_team_member_role_' . $t . '_en',
            'label' => "Thành viên $t: Chức vụ (EN)",
            'name' => 'team_member_role_' . $t . '_en',
            'type' => 'text',
            'default_value' => $t_role_def_en,
            'wrapper' => array('width' => '34'),
        );
        $fields[] = array(
            'key' => 'field_team_member_photo_' . $t,
            'label' => "Thành viên $t: Ảnh chân dung",
            'name' => 'team_member_photo_' . $t,
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'wrapper' => array('width' => '100'),
        );
    }

    // ================= TAB 11: CHÂN TRANG (FOOTER) ================= //
    $fields[] = array(
        'key' => 'field_tab_footer_settings',
        'label' => 'Chân trang (Footer)',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );

    // Cột 1: Danh mục
    $fields[] = array(
        'key' => 'field_footer_col1_title',
        'label' => 'Cột 1: Tiêu đề cột (VI)',
        'name' => 'footer_col1_title',
        'type' => 'text',
        'default_value' => 'DANH MỤC',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_col1_title_en',
        'label' => 'Cột 1: Tiêu đề cột (EN)',
        'name' => 'footer_col1_title_en',
        'type' => 'text',
        'default_value' => 'NAVIGATION',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_menu_text',
        'label' => 'Cột 1: Chữ Menu (VI)',
        'name' => 'footer_menu_text',
        'type' => 'text',
        'default_value' => 'TRANG MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_menu_text_en',
        'label' => 'Cột 1: Chữ Menu (EN)',
        'name' => 'footer_menu_text_en',
        'type' => 'text',
        'default_value' => 'MENU',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_menu_url',
        'label' => 'Cột 1: Link Menu',
        'name' => 'footer_menu_url',
        'type' => 'text',
        'default_value' => '/menu/',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_contact_text',
        'label' => 'Cột 1: Chữ Liên hệ (VI)',
        'name' => 'footer_contact_text',
        'type' => 'text',
        'default_value' => 'TRANG LIÊN HỆ',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_contact_text_en',
        'label' => 'Cột 1: Chữ Liên hệ (EN)',
        'name' => 'footer_contact_text_en',
        'type' => 'text',
        'default_value' => 'CONTACT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_contact_url',
        'label' => 'Cột 1: Link Liên hệ',
        'name' => 'footer_contact_url',
        'type' => 'text',
        'default_value' => '/contact/',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_booking_text',
        'label' => 'Cột 1: Chữ Đặt bàn (VI)',
        'name' => 'footer_booking_text',
        'type' => 'text',
        'default_value' => 'ĐẶT BÀN TRƯỚC',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_booking_text_en',
        'label' => 'Cột 1: Chữ Đặt bàn (EN)',
        'name' => 'footer_booking_text_en',
        'type' => 'text',
        'default_value' => 'RESERVATION',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_booking_url',
        'label' => 'Cột 1: Link Đặt bàn',
        'name' => 'footer_booking_url',
        'type' => 'text',
        'default_value' => '/booking/',
        'wrapper' => array('width' => '50'),
    );

    // Cột 2: Mạng xã hội
    $fields[] = array(
        'key' => 'field_footer_col2_title',
        'label' => 'Cột 2: Tiêu đề cột (VI)',
        'name' => 'footer_col2_title',
        'type' => 'text',
        'default_value' => 'MẠNG XÃ HỘI',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_col2_title_en',
        'label' => 'Cột 2: Tiêu đề cột (EN)',
        'name' => 'footer_col2_title_en',
        'type' => 'text',
        'default_value' => 'SOCIAL MEDIA',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_facebook_text',
        'label' => 'Cột 2: Nhãn Facebook',
        'name' => 'footer_facebook_text',
        'type' => 'text',
        'default_value' => 'FACEBOOK',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_facebook_url',
        'label' => 'Cột 2: Link Facebook',
        'name' => 'footer_facebook_url',
        'type' => 'text',
        'default_value' => 'https://facebook.com/ontherock.dalat',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_instagram_text',
        'label' => 'Cột 2: Nhãn Instagram',
        'name' => 'footer_instagram_text',
        'type' => 'text',
        'default_value' => 'INSTAGRAM',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_instagram_url',
        'label' => 'Cột 2: Link Instagram',
        'name' => 'footer_instagram_url',
        'type' => 'text',
        'default_value' => 'https://instagram.com/ontherock.dalat',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_tiktok_text',
        'label' => 'Cột 2: Nhãn TikTok',
        'name' => 'footer_tiktok_text',
        'type' => 'text',
        'default_value' => 'TIKTOK',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_tiktok_url',
        'label' => 'Cột 2: Link TikTok',
        'name' => 'footer_tiktok_url',
        'type' => 'text',
        'default_value' => 'https://tiktok.com/@ontherock.dalat',
        'wrapper' => array('width' => '50'),
    );

    // Cột 3: Đến và trải nghiệm
    $fields[] = array(
        'key' => 'field_footer_col3_title',
        'label' => 'Cột 3: Tiêu đề cột (VI)',
        'name' => 'footer_col3_title',
        'type' => 'text',
        'default_value' => 'ĐẾN VÀ TRẢI NGHIỆM',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_col3_title_en',
        'label' => 'Cột 3: Tiêu đề cột (EN)',
        'name' => 'footer_col3_title_en',
        'type' => 'text',
        'default_value' => 'VISIT & EXPERIENCE',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_hours_days',
        'label' => 'Cột 3: Ngày hoạt động (VI)',
        'name' => 'footer_hours_days',
        'type' => 'text',
        'default_value' => 'THỨ HAI – CHỦ NHẬT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_hours_days_en',
        'label' => 'Cột 3: Ngày hoạt động (EN)',
        'name' => 'footer_hours_days_en',
        'type' => 'text',
        'default_value' => 'MONDAY – SUNDAY',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_hours_time',
        'label' => 'Cột 3: Giờ mở cửa (VI)',
        'name' => 'footer_hours_time',
        'type' => 'text',
        'default_value' => '18H30 – 2H',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_hours_time_en',
        'label' => 'Cột 3: Giờ mở cửa (EN)',
        'name' => 'footer_hours_time_en',
        'type' => 'text',
        'default_value' => '6:30 PM – 2:00 AM',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_address_line1',
        'label' => 'Cột 3: Địa chỉ dòng 1 (VI)',
        'name' => 'footer_address_line1',
        'type' => 'text',
        'default_value' => 'TẦNG HẦM 69',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_address_line1_en',
        'label' => 'Cột 3: Địa chỉ dòng 1 (EN)',
        'name' => 'footer_address_line1_en',
        'type' => 'text',
        'default_value' => 'BASEMENT 69',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_address_line2',
        'label' => 'Cột 3: Địa chỉ dòng 2 (VI)',
        'name' => 'footer_address_line2',
        'type' => 'text',
        'default_value' => 'TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_address_line2_en',
        'label' => 'Cột 3: Địa chỉ dòng 2 (EN)',
        'name' => 'footer_address_line2_en',
        'type' => 'text',
        'default_value' => 'TRUONG CONG DINH, WARD 01, DA LAT',
        'wrapper' => array('width' => '25'),
    );
    $fields[] = array(
        'key' => 'field_footer_maps_url',
        'label' => 'Cột 3: Link Google Maps',
        'name' => 'footer_maps_url',
        'type' => 'text',
        'default_value' => 'https://maps.google.com/?q=69+Trương+Công+Định+Đà+Lạt',
        'wrapper' => array('width' => '100'),
    );

    // Cột 4: Liên hệ
    $fields[] = array(
        'key' => 'field_footer_col4_title',
        'label' => 'Cột 4: Tiêu đề cột (VI)',
        'name' => 'footer_col4_title',
        'type' => 'text',
        'default_value' => 'LIÊN HỆ',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_col4_title_en',
        'label' => 'Cột 4: Tiêu đề cột (EN)',
        'name' => 'footer_col4_title_en',
        'type' => 'text',
        'default_value' => 'CONTACT US',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_email',
        'label' => 'Cột 4: Email liên hệ',
        'name' => 'footer_email',
        'type' => 'text',
        'default_value' => 'ONTHEROCK@GMAIL.COM',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_phone',
        'label' => 'Cột 4: Hotline',
        'name' => 'footer_phone',
        'type' => 'text',
        'default_value' => '070 297 0268',
        'wrapper' => array('width' => '50'),
    );

    // Thương hiệu & Bản quyền
    $fields[] = array(
        'key' => 'field_footer_brand_title',
        'label' => 'Chữ thương hiệu lớn (Big Title)',
        'name' => 'footer_brand_title',
        'type' => 'text',
        'default_value' => 'ON THE ROCK',
        'wrapper' => array('width' => '50'),
    );
    $fields[] = array(
        'key' => 'field_footer_copyright',
        'label' => 'Dòng chữ bản quyền (Copyright)',
        'name' => 'footer_copyright',
        'type' => 'text',
        'default_value' => '@2026 ON THE ROCK',
        'wrapper' => array('width' => '50'),
    );

    // Đăng ký nhóm trường Trang chủ
    acf_add_local_field_group(array(
        'key' => 'group_home_reveal_settings',
        'title' => 'Cấu hình Trang chủ (On The Rock Home)',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'theme-pages/front-page.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Trang trí và thiết lập hiệu ứng loading reveal cho Trang chủ',
    ));

    // ================= NHÓM TRƯỜNG RIÊNG CHO TRANG MENU (MENU PAGE) ================= //
    acf_add_local_field_group(array(
        'key' => 'group_menu_page_settings',
        'title' => 'Cấu hình Giao diện Trang Menu (On The Rock Menu)',
        'fields' => array(
            array(
                'key' => 'field_menu_display_layout',
                'label' => 'Kiểu hiển thị Trang Menu',
                'name' => 'menu_display_layout',
                'type' => 'radio',
                'choices' => array(
                    'layout_3' => 'Kiểu 3: Danh Sách Cột Theo Nền Rượu (Classic Cocktail - Hình mới nhất)',
                    'layout_2' => 'Kiểu 2: Sidebar Cố Định Cuộn Trang (Sticky Sidebar bám theo cuộn)',
                    'layout_1' => 'Kiểu 1: Showcase Card & Slider Ảnh (Card hương vị & Slider - Hình ban đầu)',
                ),
                'default_value' => 'layout_3',
                'layout' => 'vertical',
                'instructions' => 'Chọn 1 trong 3 kiểu bố cục cho trang Menu. Hệ thống sẽ áp dụng trực tiếp ra ngoài trang Menu mà không hiển thị thanh chọn nào cho người xem.',
            ),
            array(
                'key' => 'field_menu_page_title',
                'label' => 'Tiêu đề Menu (VI)',
                'name' => 'menu_page_title',
                'type' => 'text',
                'default_value' => 'MENU',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_menu_page_title_en',
                'label' => 'Tiêu đề Menu (EN)',
                'name' => 'menu_page_title_en',
                'type' => 'text',
                'default_value' => 'MENU',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_menu_page_desc',
                'label' => 'Mô tả ngắn Menu (VI)',
                'name' => 'menu_page_desc',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Thưởng thức những ly cocktail thủ công và các món ăn được chế biến tinh tế trong một không gian đầy cảm hứng.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_menu_page_desc_en',
                'label' => 'Mô tả ngắn Menu (EN)',
                'name' => 'menu_page_desc_en',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Experience handcrafted cocktails and delicately prepared delicacies in an inspiring ambiance.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_menu_hero_photo_dish',
                'label' => 'Ảnh đĩa món ăn (Hero trái)',
                'name' => 'menu_hero_photo_dish',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ tự động dùng ảnh món ăn nghệ thuật mặc định',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_menu_hero_photo_cocktail',
                'label' => 'Ảnh ly cocktail (Hero phải)',
                'name' => 'menu_hero_photo_cocktail',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ tự động dùng ảnh cocktail nghệ thuật mặc định',
                'wrapper' => array('width' => '50'),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'theme-pages/page-menu.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-menu.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => '30',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Tùy chọn kiểu hiển thị trang Menu độc lập',
    ));
}
