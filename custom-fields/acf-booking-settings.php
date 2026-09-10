<?php
/**
 * ACF Custom Fields for Booking Page
 * Description: Cấu hình danh sách Email nhận thông báo và các tùy biến cho trang Đặt Bàn (Booking Page).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key' => 'group_otr_booking_settings',
        'title' => 'Cài Đặt Trang Đặt Bàn & Email Nhận Thông Báo (Booking Settings)',
        'fields' => array(
            // Tab 1: Cấu hình Email
            array(
                'key' => 'field_tab_booking_email',
                'label' => '✉ Cấu hình Email Nhận Thông Báo',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_booking_notification_emails',
                'label' => 'Danh sách Email nhận thông báo đặt bàn',
                'name' => 'booking_notification_emails',
                'type' => 'textarea',
                'rows' => 4,
                'placeholder' => "manager@ontherock.vn, booking@ontherock.vn, quanly@gmail.com",
                'instructions' => 'Nhập các địa chỉ email của bạn và những người liên quan (quản lý, phục vụ, thu ngân) nhận thông báo khi có khách đặt bàn. Các email phân cách nhau bằng dấu phẩy (,) hoặc xuống dòng.',
                'wrapper' => array( 'width' => '100' ),
            ),

            // Tab 2: Nội dung Form đặt bàn
            array(
                'key' => 'field_tab_booking_form_content',
                'label' => '📝 Nội dung Form Đặt Bàn',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_booking_form_title',
                'label' => 'Tiêu đề chính (VI)',
                'name' => 'booking_form_title',
                'type' => 'text',
                'default_value' => 'ĐẶT BÀN TRƯỚC',
                'placeholder' => 'ĐẶT BÀN TRƯỚC',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_booking_form_title_en',
                'label' => 'Tiêu đề chính (EN)',
                'name' => 'booking_form_title_en',
                'type' => 'text',
                'default_value' => 'TABLE RESERVATION',
                'placeholder' => 'TABLE RESERVATION',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_booking_form_subtitle',
                'label' => 'Phụ đề / Lời nhắn đầu trang (VI)',
                'name' => 'booking_form_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.",
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_booking_form_subtitle_en',
                'label' => 'Phụ đề / Lời nhắn đầu trang (EN)',
                'name' => 'booking_form_subtitle_en',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Select your booking details, and we will\nreserve the finest table for your evening.",
                'wrapper' => array( 'width' => '50' ),
            ),

            // Tab 3: Phần Không gian (Atmosphere) & Marquee
            array(
                'key' => 'field_tab_booking_atmosphere',
                'label' => '🍸 Không Gian & Marquee',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_booking_atmosphere_quote',
                'label' => 'Câu slogan không gian (VI)',
                'name' => 'booking_atmosphere_quote',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "ẤM CÚNG, TINH TẾ VÀ ĐẦY NĂNG LƯỢNG\nKHI MÀN ĐÊM BUÔNG XUỐNG.",
                'instructions' => 'Dòng chữ hiển thị trên phần 5 ảnh không gian của On The Rock',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_booking_atmosphere_quote_en',
                'label' => 'Câu slogan không gian (EN)',
                'name' => 'booking_atmosphere_quote_en',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "COZY, SOPHISTICATED AND ENERGETIC\nWHEN NIGHT FALLS.",
                'instructions' => 'Bản dịch tiếng Anh hiển thị ngoài frontend khi chọn EN',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_booking_img_1',
                'label' => 'Ảnh không gian 1 (Lối vào cầu thang đá)',
                'name' => 'booking_img_1',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ tự động dùng ảnh chụp thực tế On The Rock mặc định',
                'wrapper' => array( 'width' => '20' ),
            ),
            array(
                'key' => 'field_booking_img_2',
                'label' => 'Ảnh không gian 2 (Bàn khách & Logo neon)',
                'name' => 'booking_img_2',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ dùng ảnh mặc định',
                'wrapper' => array( 'width' => '20' ),
            ),
            array(
                'key' => 'field_booking_img_3',
                'label' => 'Ảnh không gian 3 (Bartender pha chế cocktail)',
                'name' => 'booking_img_3',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ dùng ảnh mặc định',
                'wrapper' => array( 'width' => '20' ),
            ),
            array(
                'key' => 'field_booking_img_4',
                'label' => 'Ảnh không gian 4 (Quầy Bar gỗ & Đèn tròn)',
                'name' => 'booking_img_4',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ dùng ảnh mặc định',
                'wrapper' => array( 'width' => '20' ),
            ),
            array(
                'key' => 'field_booking_img_5',
                'label' => 'Ảnh không gian 5 (Khuôn viên ngoài trời)',
                'name' => 'booking_img_5',
                'type' => 'image',
                'return_format' => 'url',
                'instructions' => 'Để trống sẽ dùng ảnh mặc định',
                'wrapper' => array( 'width' => '20' ),
            ),
            array(
                'key' => 'field_booking_marquee_text',
                'label' => 'Chữ chạy Marquee Ticker',
                'name' => 'booking_marquee_text',
                'type' => 'text',
                'default_value' => 'MEET THE ON THE ROCK TEAM',
                'placeholder' => 'MEET THE ON THE ROCK TEAM',
                'wrapper' => array( 'width' => '100' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'theme-pages/page-booking.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

}
