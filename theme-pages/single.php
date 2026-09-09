<?php
/**
 * Template Name: Single Post Template
 * Description: Mẫu trang chi tiết bài viết Blog & Event chuẩn phong cách On The Rock.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/sections/blog/section-blog-detail' );
    endwhile;
endif;

get_footer();
