<?php
/**
 * The template for displaying category archives (category.php)
 * Description: Mẫu trang danh mục bài viết & sự kiện chuẩn On The Rock.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

get_template_part( 'template-parts/sections/blog/section-blog-list' );

get_footer();
