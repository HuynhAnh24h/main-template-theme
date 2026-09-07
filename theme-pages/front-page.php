<?php
/**
 * Template Name: Front Page (Wander Reveal & Cocktail Bar)
 * Description: Trang chủ On The Rock Cocktail Bar với hiệu ứng Loading Reveal, Hero quầy bar, Menu tương tác, Testimonials, Moments và Team.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// 1. Header cố định (Fixed Header)
get_template_part( 'template-parts/components/site-header' );

// 2. Màn hình Intro Moodboard & Loading Reveal (Ảnh nằm dưới, Chữ nổi ở trên)
get_template_part( 'template-parts/sections/home/section-loading' );

// 3. Khối Hero Quầy Bar Cocktail & Google Reviews & Marquee Ticker
get_template_part( 'template-parts/sections/home/section-hero' );

// 4. Khối Cảm nhận từ khách hàng (Testimonials Slider)
get_template_part( 'template-parts/sections/home/section-testimonials' );

// 5. Khối Thực đơn Menu Cocktail tương tác (8 Món)
get_template_part( 'template-parts/sections/home/section-menu' );

// 6. Khối Khoảnh khắc & Mạng xã hội tràn viền (@ONTHEROCK Moments Gallery)
get_template_part( 'template-parts/sections/home/section-moments' );

// 7. Khối Đội ngũ (Meet The On The Rock Team)
get_template_part( 'template-parts/sections/home/section-team' );

get_footer();