<?php
/**
 * Template Name: Contact Page (Liên Hệ)
 * Description: Giao diện trang Liên Hệ chuẩn sang trọng cho On The Rock Cocktail Bar (100% khớp mockup).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// 1. Nhúng Header điều hướng On The Rock
get_template_part( 'template-parts/components/site-header' );

// 2. Nhúng Khối thông tin liên hệ 4 ô (100% khớp mockup)
get_template_part( 'template-parts/sections/contact/section-contact-info' );

// 3. Nhúng Không Gian 5 Ảnh & Dải Marquee Ticker (Y hệt trang booking theo yêu cầu)
get_template_part( 'template-parts/sections/booking/section-booking-atmosphere' );

// 4. Nhúng Chân trang On The Rock
get_footer();
