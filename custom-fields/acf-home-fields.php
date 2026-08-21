<?php
/**
 * ACF Custom Fields: Home Page Configuration
 * Description: Cấu hình các trường dữ liệu tùy biến dành riêng cho Trang chủ (Home Page).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_home_settings',
        'title' => 'Cấu hình Trang chủ (Home Page)',
        'fields' => array(
            array(
                'key' => 'field_home_slider',
                'label' => 'Bộ Slider Banner Trang chủ',
                'name' => 'home_slider',
                'type' => 'repeater',
                'instructions' => 'Thêm các slide cho phần biểu ngữ lớn trên trang chủ. Bấm "Thêm slide" để bổ sung hình ảnh, tiêu đề và liên kết.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => 'field_slide_title',
                'min' => 0,
                'max' => 10,
                'layout' => 'block',
                'button_label' => 'Thêm Slide mới',
                'sub_fields' => array(
                    array(
                        'key' => 'field_slide_image',
                        'label' => 'Hình ảnh Banner',
                        'name' => 'slide_image',
                        'type' => 'image',
                        'instructions' => 'Chọn hoặc tải lên hình ảnh cho banner (Kích thước khuyên dùng: 1200x600px).',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_slide_badge',
                        'label' => 'Nhãn nhỏ (Badge)',
                        'name' => 'slide_badge',
                        'type' => 'text',
                        'instructions' => 'Ví dụ: Cam kết 100%, Khuyến mãi lớn...',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '20',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_slide_title',
                        'label' => 'Tiêu đề chính (Title)',
                        'name' => 'slide_title',
                        'type' => 'text',
                        'instructions' => 'Nhập tiêu đề cho slide (Có thể dùng thẻ <br> để xuống dòng).',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_slide_subtitle',
                        'label' => 'Mô tả ngắn (Subtitle)',
                        'name' => 'slide_subtitle',
                        'type' => 'textarea',
                        'instructions' => 'Mô tả phụ cho banner.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '70',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'rows' => 3,
                        'new_lines' => '',
                    ),
                    array(
                        'key' => 'field_slide_button_text',
                        'label' => 'Nhãn nút bấm (Button Text)',
                        'name' => 'slide_button_text',
                        'type' => 'text',
                        'instructions' => 'Nhãn hiển thị trên nút (Ví dụ: Mua sắm ngay).',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'Xem chi tiết',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_slide_link',
                        'label' => 'Đường dẫn liên kết (Link)',
                        'name' => 'slide_link',
                        'type' => 'text',
                        'instructions' => 'Nhập URL liên kết đến danh mục sản phẩm, bài viết hoặc bộ sưu tập (Ví dụ: /danh-muc-san-pham/thuoc).',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '70',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                ),
            ),
        ),
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
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Cấu hình Slider và biểu ngữ cho trang chủ',
    ));
}
