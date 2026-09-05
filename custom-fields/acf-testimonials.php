<?php
/**
 * Custom Post Type: Testimonials (Cảm nhận khách hàng)
 * Description: Đăng ký CPT Đánh giá khách hàng và các trường ACF hỗ trợ thêm/xóa/sửa không giới hạn trong WP Admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Đăng ký Custom Post Type "testimonial"
function theme_register_testimonial_cpt() {
    $labels = array(
        'name'               => 'Cảm nhận khách hàng',
        'singular_name'      => 'Cảm nhận',
        'menu_name'          => 'Cảm nhận KH',
        'name_admin_bar'     => 'Cảm nhận KH',
        'add_new'            => 'Thêm cảm nhận mới',
        'add_new_item'       => 'Thêm cảm nhận khách hàng mới',
        'new_item'           => 'Cảm nhận mới',
        'edit_item'          => 'Chỉnh sửa cảm nhận',
        'view_item'          => 'Xem cảm nhận',
        'all_items'          => 'Tất cả cảm nhận',
        'search_items'       => 'Tìm cảm nhận',
        'not_found'          => 'Chưa có cảm nhận nào.',
        'not_found_in_trash' => 'Không có cảm nhận nào trong thùng rác.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title', 'editor'), // Title = Tên khách, Editor = Lời nhận xét
        'show_in_rest'       => true,
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'theme_register_testimonial_cpt');

// 2. Đăng ký trường ACF cho CPT "testimonial" (Số sao đánh giá)
add_action('acf/init', function() {
    if ( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_testimonial_details',
            'title' => 'Chi tiết Đánh giá',
            'fields' => array(
                array(
                    'key' => 'field_testimonial_stars',
                    'label' => 'Số sao đánh giá (Stars)',
                    'name' => 'testimonial_stars',
                    'type' => 'select',
                    'choices' => array(
                        '5' => '★★★★★ (5 sao)',
                        '4' => '★★★★☆ (4 sao)',
                        '3' => '★★★☆☆ (3 sao)',
                        '2' => '★★☆☆☆ (2 sao)',
                        '1' => '★☆☆☆☆ (1 sao)',
                    ),
                    'default_value' => '5',
                    'allow_null' => 0,
                    'instructions' => 'Chọn số sao hiển thị.',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'testimonial',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'side',
            'style' => 'default',
        ));
    }
});

// 3. Tự động nạp sẵn 5 bài đánh giá mẫu từ ảnh thiết kế nếu CPT chưa có bài nào
function theme_seed_initial_testimonials() {
    // Chỉ chạy trong admin và chỉ khi CPT đã đăng ký
    if ( ! is_admin() || ! post_type_exists('testimonial') ) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'testimonial',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));

    if ( empty($existing) ) {
        $samples = array(
            array(
                'author' => 'Ognium',
                'quote'  => "Quán nằm ở ngay trung tâm và khá là dễ tìm. Đồ uống ngon, hợp gu mình Các bạn nhân viên siêu dễ thương 🍕",
                'stars'  => 5,
            ),
            array(
                'author' => 'Roger Ramjet',
                'quote'  => "Spectacular. Been to a cocktail bar or seven in my time and this place nails everything. My standard test case of dry martini passed with special honours and a commendation.",
                'stars'  => 5,
            ),
            array(
                'author' => 'Cường 0140 Nguyễn',
                'quote'  => "Quán decor quá là ok luôn, nhạc thi chắc k phải gu mình nhưng bạn bè thi lại thích ( chắc do gu mình lạ), giá đồ uống thì cũng rất hợp lý so với chất lượng và dịch vụ quá là cute của quán. Nhất định sẽ còn quay lại",
                'stars'  => 5,
            ),
            array(
                'author' => 'Anh Kim',
                'quote'  => "Đêm tối Đà Lạt trở lạnh, On The Rocks là một sự lựa chọn mang đến trải nghiệm khá chill với mình. Nước ngon, không gian ấm cúng, nhân viên ở đây chu đáo và cực vui, siu mê❤️✨",
                'stars'  => 5,
            ),
            array(
                'author' => 'Dang Khoa',
                'quote'  => "Quán cocktail xịn xò, không gian chill, đồ uống cân vị cực đã 🍸✨ Đã uống một tỷ lần rùi.",
                'stars'  => 5,
            ),
        );

        foreach ( $samples as $item ) {
            $post_id = wp_insert_post(array(
                'post_title'   => $item['author'],
                'post_content' => $item['quote'],
                'post_type'    => 'testimonial',
                'post_status'  => 'publish',
            ));

            if ( $post_id && ! is_wp_error($post_id) ) {
                update_post_meta($post_id, 'testimonial_stars', $item['stars']);
            }
        }
    }
}
add_action('admin_init', 'theme_seed_initial_testimonials');
