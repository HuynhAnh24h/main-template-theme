<?php
/**
 * Template Name: Menu Page
 * Description: Trang Menu chi tiết cho On The Rock Cocktail Bar với các tùy chọn giao diện hiển thị linh hoạt.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// 1. Nhúng Header điều hướng On The Rock đồng bộ
get_template_part( 'template-parts/components/site-header' );

// 2. Nhúng nội dung Trang Menu chính (Hero 2 ảnh + Selector + Bố cục được chọn)
get_template_part( 'template-parts/sections/menu/section-menu-page' );

// 3. Nhúng Chân trang On The Rock
get_footer();
