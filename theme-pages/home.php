<?php
/**
 * The template for displaying the blog posts index (home.php)
 * Description: Trang Blog & Event mặc định của WordPress theo chuẩn On The Rock.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

get_template_part( 'template-parts/sections/blog/section-blog-list' );

get_footer();
