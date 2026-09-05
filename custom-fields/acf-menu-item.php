<?php
/**
 * ACF Custom Fields for Menu Items & Categories
 * Description: Trường dữ liệu tùy biến cho Món Thực Đơn và Danh Mục Menu Bar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'acf_add_local_field_group' ) ) {

    // 1. Nhóm trường cho từng Món Thực Đơn (otr_menu_item)
    acf_add_local_field_group( array(
        'key' => 'group_otr_menu_item_details',
        'title' => 'Thông Tin Món Thực Đơn (Bar Menu Item)',
        'fields' => array(
            array(
                'key' => 'field_item_price',
                'label' => 'Giá tiền',
                'name' => 'item_price',
                'type' => 'text',
                'default_value' => '199k',
                'placeholder' => 'VD: 199k hoặc 250.000đ',
                'instructions' => 'Nhập mức giá hiển thị trên menu',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_item_spirit',
                'label' => 'Nền rượu / Tên cột (Cột hiển thị Kiểu 3)',
                'name' => 'item_spirit',
                'type' => 'text',
                'default_value' => 'WHISKY',
                'placeholder' => 'VD: WHISKY, GIN, RUM, TEQUILA...',
                'instructions' => 'Dùng để chia cột trong Kiểu 3 (VD: Cột WHISKY, Cột GIN)',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_item_subtab',
                'label' => 'Tên Tab Con (Subtab)',
                'name' => 'item_subtab',
                'type' => 'text',
                'placeholder' => 'VD: CLASSIC COCKTAIL, CLASSIC PREMIUM...',
                'instructions' => 'Phân nhóm tab nhỏ trong danh mục (nếu có)',
                'wrapper' => array( 'width' => '33' ),
            ),
            array(
                'key' => 'field_item_desc',
                'label' => 'Thành phần / Mô tả ngắn',
                'name' => 'item_desc',
                'type' => 'textarea',
                'rows' => 2,
                'placeholder' => 'VD: Bourbon, Campari, Sweet Vermouth, Orange Twist',
                'instructions' => 'Mô tả hương vị hoặc thành phần chính của món',
                'wrapper' => array( 'width' => '100' ),
            ),
            array(
                'key' => 'field_item_alcohol',
                'label' => 'Độ cồn (Alcohol Level)',
                'name' => 'item_alcohol',
                'type' => 'select',
                'choices' => array(
                    'Medium' => 'Medium (Vừa phải)',
                    'High'   => 'High (Đậm / Nặng)',
                    'Low'    => 'Low (Nhẹ / Thanh mát)',
                ),
                'default_value' => 'Medium',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_item_flavors',
                'label' => 'Nốt hương vị chính (Flavors)',
                'name' => 'item_flavors',
                'type' => 'text',
                'placeholder' => 'VD: Ngọt / Sweet, Chua / Sour, Khói / Smoky',
                'instructions' => 'Các nốt hương vị, cách nhau bằng dấu phẩy',
                'wrapper' => array( 'width' => '50' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'otr_menu_item',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
    ) );

    // 2. Nhóm trường cho Danh Mục Menu (otr_menu_cat taxonomy)
    acf_add_local_field_group( array(
        'key' => 'group_otr_menu_cat_details',
        'title' => 'Cấu hình Bổ sung Danh Mục Menu',
        'fields' => array(
            array(
                'key' => 'field_cat_number',
                'label' => 'Số thứ tự danh mục',
                'name' => 'cat_number',
                'type' => 'text',
                'placeholder' => 'VD: 01, 02, 03, 04',
                'instructions' => 'Số hiển thị trước tên danh mục (VD: 02 CLASSIC COCKTAIL)',
                'wrapper' => array( 'width' => '50' ),
            ),
            array(
                'key' => 'field_cat_image',
                'label' => 'Ảnh đại diện danh mục (Dùng cho Kiểu 2 & Kiểu 1)',
                'name' => 'cat_image',
                'type' => 'image',
                'return_format' => 'array',
                'instructions' => 'Chọn ảnh minh họa banner cho phân mục thực đơn này',
                'wrapper' => array( 'width' => '50' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'otr_menu_cat',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
    ) );
}
