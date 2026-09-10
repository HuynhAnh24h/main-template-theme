<?php
/**
 * ACF Custom Fields for Contact Page
 * Description: Cấu hình thông tin địa chỉ, liên hệ, giờ hoạt động và mạng xã hội cho trang Liên Hệ.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key' => 'group_otr_contact_settings',
        'title' => 'Cài Đặt Trang Liên Hệ (Contact Page Settings)',
        'fields' => array(
            // Tab 1: Tiêu đề trang
            array(
                'key' => 'field_tab_contact_header',
                'label' => '📝 Tiêu Đề',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_contact_page_title',
                'label' => 'Tiêu đề trang (VI)',
                'name' => 'contact_page_title',
                'type' => 'text',
                'default_value' => 'LIÊN HỆ VỚI CHÚNG MÌNH',
                'placeholder' => 'LIÊN HỆ VỚI CHÚNG MÌNH',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_contact_page_title_en',
                'label' => 'Tiêu đề trang (EN)',
                'name' => 'contact_page_title_en',
                'type' => 'text',
                'default_value' => 'GET IN TOUCH WITH US',
                'placeholder' => 'GET IN TOUCH WITH US',
                'wrapper' => array( 'width' => '50' ),
            ),

            // Tab 2: Địa chỉ & Giờ hoạt động
            array(
                'key' => 'field_tab_contact_location',
                'label' => '📍 Địa Chỉ & Giờ Mở Cửa',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_contact_address_title',
                'label' => 'Tiêu đề khối địa chỉ (VI)',
                'name' => 'contact_address_title',
                'type' => 'text',
                'default_value' => 'ĐỊA CHỈ',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_address_title_en',
                'label' => 'Tiêu đề khối địa chỉ (EN)',
                'name' => 'contact_address_title_en',
                'type' => 'text',
                'default_value' => 'ADDRESS',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_address_link',
                'label' => 'Link Google Maps',
                'name' => 'contact_address_link',
                'type' => 'url',
                'default_value' => 'https://maps.google.com/?q=69+Trương+Công+Định,+Phường+1,+Đà+Lạt',
                'placeholder' => 'https://maps.google.com/...',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_contact_address_lines',
                'label' => 'Nội dung địa chỉ (VI - mỗi dòng một ý)',
                'name' => 'contact_address_lines',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => "TẦNG HẦM 69\nTRƯƠNG CÔNG ĐỊNH,\nPHƯỜNG 01, ĐÀ LẠT",
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_contact_address_lines_en',
                'label' => 'Nội dung địa chỉ (EN - each line an item)',
                'name' => 'contact_address_lines_en',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => "BASEMENT 69\nTRUONG CONG DINH,\nWARD 01, DA LAT",
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_contact_hours_title',
                'label' => 'Tiêu đề giờ hoạt động (VI)',
                'name' => 'contact_hours_title',
                'type' => 'text',
                'default_value' => 'GIỜ HOẠT ĐỘNG',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_hours_title_en',
                'label' => 'Tiêu đề giờ hoạt động (EN)',
                'name' => 'contact_hours_title_en',
                'type' => 'text',
                'default_value' => 'OPENING HOURS',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_hours_days',
                'label' => 'Ngày hoạt động (VI)',
                'name' => 'contact_hours_days',
                'type' => 'text',
                'default_value' => 'THỨ HAI – CHỦ NHẬT',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_hours_days_en',
                'label' => 'Ngày hoạt động (EN)',
                'name' => 'contact_hours_days_en',
                'type' => 'text',
                'default_value' => 'MONDAY – SUNDAY',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_hours_time',
                'label' => 'Khung giờ mở cửa (VI)',
                'name' => 'contact_hours_time',
                'type' => 'text',
                'default_value' => '18H30 – 2H',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_hours_time_en',
                'label' => 'Khung giờ mở cửa (EN)',
                'name' => 'contact_hours_time_en',
                'type' => 'text',
                'default_value' => '6:30 PM – 2:00 AM',
                'wrapper' => array( 'width' => '25' ),
            ),

            // Tab 3: Kênh Liên hệ & Mạng xã hội
            array(
                'key' => 'field_tab_contact_social',
                'label' => '📞 Liên Hệ & Mạng Xã Hội',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_contact_info_title',
                'label' => 'Tiêu đề khối liên hệ',
                'name' => 'contact_info_title',
                'type' => 'text',
                'default_value' => 'LIÊN HỆ',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_contact_email',
                'label' => 'Email',
                'name' => 'contact_email',
                'type' => 'text',
                'default_value' => 'ONTHEROCK@GMAIL.COM',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_contact_phone',
                'label' => 'Số điện thoại',
                'name' => 'contact_phone',
                'type' => 'text',
                'default_value' => '070 297 0268',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_contact_social_title',
                'label' => 'Tiêu đề khối mạng xã hội',
                'name' => 'contact_social_title',
                'type' => 'text',
                'default_value' => 'MẠNG XÃ HỘI',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_facebook_url',
                'label' => 'Link Facebook',
                'name' => 'contact_facebook_url',
                'type' => 'url',
                'default_value' => 'https://facebook.com/ontherock.dalat',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_instagram_url',
                'label' => 'Link Instagram',
                'name' => 'contact_instagram_url',
                'type' => 'url',
                'default_value' => 'https://instagram.com/ontherock.dalat',
                'wrapper' => array( 'width' => '25' ),
            ),
            array(
                'key' => 'field_contact_tiktok_url',
                'label' => 'Link TikTok',
                'name' => 'contact_tiktok_url',
                'type' => 'url',
                'default_value' => 'https://tiktok.com/@ontherock.dalat',
                'wrapper' => array( 'width' => '25' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'theme-pages/page-contact.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-contact.php',
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
