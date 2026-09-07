<?php
/**
 * Template Name: Booking Page (Đặt Bàn)
 * Description: Giao diện trang Đặt Bàn (Bookings) sang trọng cho On The Rock Cocktail Bar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// 1. Nhúng Header điều hướng On The Rock
get_template_part( 'template-parts/components/site-header' );

// 2. Nhúng Form Đặt Bàn (100% khớp mockup)
get_template_part( 'template-parts/sections/booking/section-booking-form' );

// 3. Nhúng Không Gian 5 Ảnh & Dải Marquee Ticker
get_template_part( 'template-parts/sections/booking/section-booking-atmosphere' );

// 4. Nhúng Chân trang On The Rock
get_footer();
