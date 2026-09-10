<?php
/**
 * ACF Custom Fields for Blog & Event Page
 * Description: Cấu hình tiêu đề, phụ đề, bộ lọc chuyên mục và nút tải thêm cho trang Blog & Event.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key' => 'group_otr_blog_settings',
        'title' => 'Cài Đặt Trang Blog & Sự Kiện (Blog Page Settings)',
        'fields' => array(
            // Tab 1: Tiêu đề trang & Phụ đề
            array(
                'key' => 'field_tab_blog_header',
                'label' => '📝 Tiêu Đề & Giới Thiệu',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_blog_page_title',
                'label' => 'Tiêu đề trang (VI)',
                'name' => 'blog_page_title',
                'type' => 'text',
                'default_value' => 'BLOG & EVENT',
                'placeholder' => 'BLOG & EVENT',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_page_title_en',
                'label' => 'Tiêu đề trang (EN)',
                'name' => 'blog_page_title_en',
                'type' => 'text',
                'default_value' => 'BLOG & EVENT',
                'placeholder' => 'BLOG & EVENT',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_page_subtitle',
                'label' => 'Phụ đề / Lời nhắn đầu trang (VI)',
                'name' => 'blog_page_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Những câu chuyện về hương vị, văn hóa cocktail và sự kiện đặc biệt tại On The Rock.",
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_page_subtitle_en',
                'label' => 'Phụ đề / Lời nhắn đầu trang (EN)',
                'name' => 'blog_page_subtitle_en',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Stories of taste, cocktail culture, and exclusive events at On The Rock.",
                'wrapper' => array( 'width' => '50' ),
            ),

            // Tab 2: Nhãn bộ lọc & Nút bấm
            array(
                'key' => 'field_tab_blog_ui',
                'label' => '🔘 Nhãn Bộ Lọc & Nút Bấm',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_blog_filter_all_label',
                'label' => 'Nhãn Tab "Tất cả" (VI)',
                'name' => 'blog_filter_all_label',
                'type' => 'text',
                'default_value' => 'Tất cả',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_filter_all_label_en',
                'label' => 'Nhãn Tab "All" (EN)',
                'name' => 'blog_filter_all_label_en',
                'type' => 'text',
                'default_value' => 'All',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_filter_events_label',
                'label' => 'Nhãn Tab "Sự kiện" (VI)',
                'name' => 'blog_filter_events_label',
                'type' => 'text',
                'default_value' => 'Sự kiện',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_filter_events_label_en',
                'label' => 'Nhãn Tab "Events" (EN)',
                'name' => 'blog_filter_events_label_en',
                'type' => 'text',
                'default_value' => 'Events',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_filter_articles_label',
                'label' => 'Nhãn Tab "Bài viết" (VI)',
                'name' => 'blog_filter_articles_label',
                'type' => 'text',
                'default_value' => 'Bài viết',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_filter_articles_label_en',
                'label' => 'Nhãn Tab "Articles" (EN)',
                'name' => 'blog_filter_articles_label_en',
                'type' => 'text',
                'default_value' => 'Articles',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_load_more_label',
                'label' => 'Nhãn nút "Xem thêm" (VI)',
                'name' => 'blog_load_more_label',
                'type' => 'text',
                'default_value' => 'XEM THÊM',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_blog_load_more_label_en',
                'label' => 'Nhãn nút "Xem thêm" (EN)',
                'name' => 'blog_load_more_label_en',
                'type' => 'text',
                'default_value' => 'LOAD MORE',
                'wrapper' => array( 'width' => '50' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'theme-pages/page-blog.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-blog.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => '79',
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
