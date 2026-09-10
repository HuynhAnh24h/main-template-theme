<?php
/**
 * Module: Content Seeder & Sync for Admin Pages
 * Description: Tự động nạp (seed) đầy đủ nội dung song ngữ chuẩn (VI & EN) vào database
 * cho tất cả các trang chính (Trang Chủ, Menu, Đặt Bàn, Liên Hệ, Blog)
 * để quản trị viên có sẵn 100% dữ liệu để chỉnh sửa ngay trong WP Admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Hàm khởi tạo và đồng bộ dữ liệu song ngữ cho từng trang
 * Có thể chạy tự động khi admin truy cập hoặc gọi chủ động qua hook/action
 */
function otr_seed_all_page_contents( $force = false ) {
    // 1. Xác định ID các trang chính
    $front_id = get_option( 'page_on_front' );
    if ( ! $front_id ) {
        $home_page = get_page_by_path( 'trang-chu' );
        if ( ! $home_page ) {
            $home_page = get_page_by_path( 'home' );
        }
        $front_id = $home_page ? $home_page->ID : 14;
    }

    $menu_page = get_page_by_path( 'menu' );
    $menu_id   = $menu_page ? $menu_page->ID : 30;

    $booking_page = get_page_by_path( 'booking' );
    $booking_id   = $booking_page ? $booking_page->ID : 62;

    $contact_page = get_page_by_path( 'contact' );
    $contact_id   = $contact_page ? $contact_page->ID : 65;

    $blog_page = get_page_by_path( 'blog' );
    $blog_id   = $blog_page ? $blog_page->ID : 79;

    // Đảm bảo Trang Blog sử dụng đúng mẫu giao diện template
    if ( $blog_id ) {
        update_post_meta( $blog_id, '_wp_page_template', 'theme-pages/page-blog.php' );
    }

    // ================= 1. DỮ LIỆU TRANG CHỦ (HOME PAGE) ================= //
    if ( $front_id ) {
        $home_meta = array(
            // Intro Quote
            'home_intro_quote'    => "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.",
            'home_intro_quote_en' => "A cocktail bar in Da Lat,\ncrafted by locals, for those seeking\nan authentic Da Lat experience.",

            // Header
            'header_menu_text'       => 'MENU',
            'header_menu_text_en'    => 'MENU',
            'header_contact_text'    => 'LIÊN HỆ',
            'header_contact_text_en' => 'CONTACT',
            'header_blog_text'       => 'BÀI VIẾT',
            'header_blog_text_en'    => 'BLOG',
            'header_booking_text'    => 'ĐẶT BÀN TRƯỚC',
            'header_booking_text_en' => 'RESERVATION',

            // Hero
            'hero_title'             => "BESPEAK YOUR\nBESPOKE COCKTAIL",
            'hero_btn_text'          => 'XEM MENU',
            'hero_btn_text_en'       => 'VIEW MENU',
            'hero_btn_link'          => home_url( '/menu/' ),
            'hero_review_score'      => '4.7',
            'hero_review_max'        => '/5',
            'hero_review_title'      => 'Xuất sắc',
            'hero_review_title_en'   => 'Excellent',
            'hero_review_subtitle'   => 'Dựa trên 3 576 lượt đánh giá',
            'hero_review_subtitle_en'=> 'Based on 3 576 reviews',
            'hero_marquee_text'      => 'ON THE ROCKS COCKTAIL BAR',

            // Testimonials
            'testimonials_title'     => 'CẢM NHẬN TỪ KHÁCH HÀNG',
            'testimonials_title_en'  => 'GUEST REVIEWS',

            // Menu Section Preview
            'menu_section_title'     => 'THỰC ĐƠN',
            'menu_section_title_en'  => 'MENU',

            // 8 Món Menu Preview
            'menu_item_title_1'    => 'BESPOKE COCKTAIL',
            'menu_item_title_1_en' => 'BESPOKE COCKTAIL',
            'menu_item_desc_1'     => 'Đi ngang lâu lắm rồi giờ mới có dịp ghé quán, trời mưa có nhân viên siêu nice hỗ trợ',
            'menu_item_desc_1_en'  => 'Passed by many times, finally visited; on a rainy day, the staff was exceptionally nice and supportive.',

            'menu_item_title_2'    => 'CLASSIC COCKTAIL',
            'menu_item_title_2_en' => 'CLASSIC COCKTAIL',
            'menu_item_desc_2'     => 'Hương vị cổ điển vượt thời gian — từ Old Fashioned đậm đà đến Negroni trầm lắng.',
            'menu_item_desc_2_en'  => 'Timeless classic flavors — from the bold Old Fashioned to the contemplative Negroni.',

            'menu_item_title_3'    => 'SIGNATURE CREATION',
            'menu_item_title_3_en' => 'SIGNATURE CREATION',
            'menu_item_desc_3'     => 'Sáng tạo độc quyền từ các bartender lành nghề với các tầng hương độc bản của thảo mộc cao nguyên.',
            'menu_item_desc_3_en'  => 'Exclusive creations by skilled bartenders with distinct layers of highland botanicals.',

            'menu_item_title_4'    => 'MOCKTAIL & BOTANICAL',
            'menu_item_title_4_en' => 'MOCKTAIL & BOTANICAL',
            'menu_item_desc_4'     => 'Trải nghiệm tinh tế không cồn, thanh mát và cân bằng hoàn hảo cho buổi tối thư thái.',
            'menu_item_desc_4_en'  => 'Refined non-alcoholic experience, crisp and perfectly balanced for a relaxed evening.',

            'menu_item_title_5'    => 'PREMIUM SPIRITS & WHISKY',
            'menu_item_title_5_en' => 'PREMIUM SPIRITS & WHISKY',
            'menu_item_desc_5'     => 'Bộ sưu tập single malt và whisky tuyển chọn từ các nhà chưng cất danh tiếng thế giới.',
            'menu_item_desc_5_en'  => 'Curated single malts and whiskies from world-renowned distilleries.',

            'menu_item_title_6'    => 'WINE & CHAMPAGNE',
            'menu_item_title_6_en' => 'WINE & CHAMPAGNE',
            'menu_item_desc_6'     => 'Những giọt vang thượng hạng và bọt sủi champagne lấp lánh nâng niu từng khoảnh khắc đáng nhớ.',
            'menu_item_desc_6_en'  => 'Fine wines and sparkling champagne bubbles celebrating every memorable moment.',

            'menu_item_title_7'    => 'BAR BITES & TAPAS',
            'menu_item_title_7_en' => 'BAR BITES & TAPAS',
            'menu_item_desc_7'     => 'Món ăn nhẹ tinh hoa kết hợp phong vị Á - Âu, được thiết kế để tôn vinh hương vị đồ uống.',
            'menu_item_desc_7_en'  => 'Artisanal Asian-European fusion bar bites crafted to elevate drink pairings.',

            'menu_item_title_8'    => 'SEASONAL SPECIALS',
            'menu_item_title_8_en' => 'SEASONAL SPECIALS',
            'menu_item_desc_8'     => 'Bản giao hưởng hương vị theo mùa — biến tấu ngẫu hứng với nguyên liệu tươi mới độc đáo.',
            'menu_item_desc_8_en'  => 'A seasonal symphony of flavors — improvised with fresh and unique local produce.',

            // Moments
            'moments_title_1'    => 'THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC',
            'moments_title_1_en' => 'SAVOR, CAPTURE THE MOMENT',
            'moments_title_2'    => 'VÀ GẮN THẺ @ONTHEROCK.',
            'moments_title_2_en' => 'AND TAG @ONTHEROCK.',

            // Team
            'team_marquee_text'    => 'GẶP GỠ ĐỘI NGŨ ON THE ROCK',
            'team_marquee_text_en' => 'MEET THE ON THE ROCK TEAM',

            'team_member_name_1'    => 'QUỲNH VÂN',
            'team_member_role_1'    => 'QUẢN LÝ CỬA HÀNG',
            'team_member_role_1_en' => 'STORE MANAGER',

            'team_member_name_2'    => 'TUẤN KIỆT',
            'team_member_role_2'    => 'QUẢN LÝ QUẦY BAR',
            'team_member_role_2_en' => 'BAR MANAGER',

            'team_member_name_3'    => 'VĂN BẢO',
            'team_member_role_3'    => 'TRƯỞNG CA QUẦY BAR',
            'team_member_role_3_en' => 'BAR CAPTAIN',

            'team_member_name_4'    => 'THÀNH ĐỨC',
            'team_member_role_4'    => 'TRƯỞNG CA QUẦY BAR',
            'team_member_role_4_en' => 'BAR CAPTAIN',

            'team_member_name_5'    => 'HỒNG PHÚ',
            'team_member_role_5'    => 'CHUYÊN VIÊN PHA CHẾ',
            'team_member_role_5_en' => 'BARTENDER',

            // Footer
            'footer_col1_title'       => 'DANH MỤC',
            'footer_col1_title_en'    => 'NAVIGATION',
            'footer_menu_text'        => 'TRANG MENU',
            'footer_menu_text_en'     => 'MENU',
            'footer_contact_text'     => 'TRANG LIÊN HỆ',
            'footer_contact_text_en'  => 'CONTACT',
            'footer_booking_text'     => 'ĐẶT BÀN TRƯỚC',
            'footer_booking_text_en'  => 'RESERVATION',

            'footer_col2_title'       => 'MẠNG XÃ HỘI',
            'footer_col2_title_en'    => 'SOCIAL MEDIA',

            'footer_col3_title'       => 'ĐẾN VÀ TRẢI NGHIỆM',
            'footer_col3_title_en'    => 'VISIT & EXPERIENCE',
            'footer_hours_days'       => 'THỨ HAI – CHỦ NHẬT',
            'footer_hours_days_en'    => 'MONDAY – SUNDAY',
            'footer_hours_time'       => '18H30 – 2H',
            'footer_hours_time_en'    => '6:30 PM – 2:00 AM',
            'footer_address_line1'    => 'TẦNG HẦM 69',
            'footer_address_line1_en' => 'BASEMENT 69',
            'footer_address_line2'    => 'TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT',
            'footer_address_line2_en' => 'TRUONG CONG DINH ST., WARD 01, DA LAT',

            'footer_col4_title'       => 'LIÊN HỆ',
            'footer_col4_title_en'    => 'CONTACT US',
            'footer_email'            => 'ONTHEROCK@GMAIL.COM',
            'footer_phone'            => '070 297 0268',
            'footer_brand_title'      => 'ON THE ROCK',
            'footer_copyright'        => '@2026 ON THE ROCK',
            'footer_copyright_en'     => '@2026 ON THE ROCK',
        );

        foreach ( $home_meta as $k => $v ) {
            if ( $force || get_post_meta( $front_id, $k, true ) === '' ) {
                update_post_meta( $front_id, $k, $v );
            }
        }
    }

    // ================= 2. DỮ LIỆU TRANG MENU (MENU PAGE) ================= //
    if ( $menu_id ) {
        $menu_meta = array(
            'menu_display_layout'     => 'layout_3',
            'menu_page_title'         => 'MENU',
            'menu_page_title_en'      => 'MENU',
            'menu_page_desc'          => 'Thưởng thức những ly cocktail thủ công và các món ăn được chế biến tinh tế trong một không gian đầy cảm hứng.',
            'menu_page_desc_en'       => 'Experience handcrafted cocktails and delicately prepared delicacies in an inspiring ambiance.',
            'menu_hero_photo_dish'    => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop',
            'menu_hero_photo_cocktail'=> 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=800&auto=format&fit=crop',
        );
        foreach ( $menu_meta as $k => $v ) {
            if ( $force || get_post_meta( $menu_id, $k, true ) === '' ) {
                update_post_meta( $menu_id, $k, $v );
            }
        }
    }

    // ================= 3. DỮ LIỆU TRANG ĐẶT BÀN (BOOKING PAGE) ================= //
    if ( $booking_id ) {
        $booking_meta = array(
            'booking_form_title'            => 'ĐẶT BÀN TRƯỚC',
            'booking_form_title_en'         => 'TABLE RESERVATION',
            'booking_form_subtitle'         => "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.",
            'booking_form_subtitle_en'      => "Select your booking details, and we will\nreserve the finest table for your evening.",
            'booking_atmosphere_quote'      => "ẤM CÚNG, TINH TẾ VÀ ĐẦY NĂNG LƯỢNG\nKHI MÀN ĐÊM BUÔNG XUỐNG.",
            'booking_atmosphere_quote_en'   => "COZY, SOPHISTICATED AND ENERGETIC\nWHEN NIGHT FALLS.",
            'booking_marquee_text'          => 'MEET THE ON THE ROCK TEAM',
            'booking_marquee_text_en'       => 'MEET THE ON THE ROCK TEAM',
            'booking_notification_emails'   => 'manager@ontherock.vn, booking@ontherock.vn',
        );
        foreach ( $booking_meta as $k => $v ) {
            if ( $force || get_post_meta( $booking_id, $k, true ) === '' ) {
                update_post_meta( $booking_id, $k, $v );
            }
        }
    }

    // ================= 4. DỮ LIỆU TRANG LIÊN HỆ (CONTACT PAGE) ================= //
    if ( $contact_id ) {
        $contact_meta = array(
            'contact_page_title'       => 'LIÊN HỆ VỚI CHÚNG MÌNH',
            'contact_page_title_en'    => 'GET IN TOUCH WITH US',
            'contact_address_title'    => 'ĐỊA CHỈ',
            'contact_address_title_en' => 'ADDRESS',
            'contact_address_link'     => 'https://maps.google.com/?q=69+Trương+Công+Định,+Phường+1,+Đà+Lạt',
            'contact_address_lines'    => "TẦNG HẦM 69\nTRƯƠNG CÔNG ĐỊNH,\nPHƯỜNG 01, ĐÀ LẠT",
            'contact_address_lines_en' => "BASEMENT 69\nTRUONG CONG DINH,\nWARD 01, DA LAT",
            'contact_hours_title'      => 'GIỜ HOẠT ĐỘNG',
            'contact_hours_title_en'   => 'OPENING HOURS',
            'contact_hours_days'       => 'THỨ HAI – CHỦ NHẬT',
            'contact_hours_days_en'    => 'MONDAY – SUNDAY',
            'contact_hours_time'       => '18H30 – 2H',
            'contact_hours_time_en'    => '6:30 PM – 2:00 AM',
            'contact_info_title'       => 'LIÊN HỆ',
            'contact_info_title_en'    => 'CONTACT',
            'contact_email'            => 'ONTHEROCK@GMAIL.COM',
            'contact_phone'            => '070 297 0268',
            'contact_social_title'     => 'MẠNG XÃ HỘI',
            'contact_social_title_en'  => 'SOCIAL MEDIA',
            'contact_facebook_url'     => 'https://facebook.com/ontherock.dalat',
            'contact_instagram_url'    => 'https://instagram.com/ontherock.dalat',
            'contact_tiktok_url'       => 'https://tiktok.com/@ontherock.dalat',
        );
        foreach ( $contact_meta as $k => $v ) {
            if ( $force || get_post_meta( $contact_id, $k, true ) === '' ) {
                update_post_meta( $contact_id, $k, $v );
            }
        }
    }

    // ================= 5. DỮ LIỆU TRANG BLOG & EVENT ================= //
    if ( $blog_id ) {
        $blog_meta = array(
            'blog_page_title'             => 'BLOG & EVENT',
            'blog_page_title_en'          => 'BLOG & EVENT',
            'blog_page_subtitle'          => 'Những câu chuyện về hương vị, văn hóa cocktail và sự kiện đặc biệt tại On The Rock.',
            'blog_page_subtitle_en'       => 'Stories of taste, cocktail culture, and exclusive events at On The Rock.',
            'blog_filter_all_label'       => 'Tất cả',
            'blog_filter_all_label_en'    => 'All',
            'blog_filter_events_label'    => 'Sự kiện',
            'blog_filter_events_label_en' => 'Events',
            'blog_filter_articles_label'  => 'Bài viết',
            'blog_filter_articles_label_en'=> 'Articles',
            'blog_load_more_label'        => 'XEM THÊM',
            'blog_load_more_label_en'     => 'LOAD MORE',
        );
        foreach ( $blog_meta as $k => $v ) {
            if ( $force || get_post_meta( $blog_id, $k, true ) === '' ) {
                update_post_meta( $blog_id, $k, $v );
            }
        }
    }

    return true;
}

// Tự động kiểm tra nạp dữ liệu nếu chưa từng nạp
add_action( 'admin_init', function() {
    if ( ! get_option( 'otr_content_seeded_v1' ) ) {
        otr_seed_all_page_contents( false );
        update_option( 'otr_content_seeded_v1', 1 );
    }
} );
