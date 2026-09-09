<?php
/**
 * Single Post Template Fallback
 * Description: Điều hướng tới theme-pages/single.php chuẩn On The Rock.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$custom_single = get_template_directory() . '/theme-pages/single.php';
if ( file_exists( $custom_single ) ) {
    include $custom_single;
} else {
    get_header();
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/sections/blog/section-blog-detail' );
        endwhile;
    endif;
    get_footer();
}
