<?php
/**
 * Template Name: Trang Blog & Event
 * Description: Mẫu trang hiển thị danh sách bài viết và sự kiện với bố cục so le Zig-Zag chuẩn On The Rock.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Gọi Section Danh Sách Blog & Event
get_template_part( 'template-parts/sections/blog/section-blog-list' );

get_footer();
