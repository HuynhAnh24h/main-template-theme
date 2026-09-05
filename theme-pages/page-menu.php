<?php
/**
 * Template Name: Menu Page
 * Description: Trang Menu chi tiết cho On The Rock Cocktail Bar với các tùy chọn giao diện hiển thị linh hoạt.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$front_page_id   = get_option('page_on_front');
$header_fb       = get_field('header_facebook_url', $front_page_id) ?: 'https://facebook.com/ontherock.dalat';
$header_insta    = get_field('header_instagram_url', $front_page_id) ?: 'https://instagram.com/ontherock.dalat';
$header_logo     = get_field('header_logo', $front_page_id);
$header_menu     = get_field('header_menu_text', $front_page_id) ?: 'MENU';
$raw_menu_url    = get_field('header_menu_url', $front_page_id);
$header_menu_url = (empty($raw_menu_url) || in_array($raw_menu_url, array('#menu', '#', ''))) ? home_url('/menu/') : (function_exists('otr_url') ? otr_url($raw_menu_url) : home_url('/' . ltrim($raw_menu_url, '/')));
$header_contact  = get_field('header_contact_text', $front_page_id) ?: 'CONTACT';
$raw_contact_url = get_field('header_contact_url', $front_page_id);
$header_contact_url = (empty($raw_contact_url) || in_array($raw_contact_url, array('#contact', '#', ''))) ? home_url('/contact/') : (function_exists('otr_url') ? otr_url($raw_contact_url) : home_url('/' . ltrim($raw_contact_url, '/')));
$header_booking  = get_field('header_booking_text', $front_page_id) ?: 'ĐẶT BÀN TRƯỚC';
$raw_booking_url = get_field('header_booking_url', $front_page_id);
$header_booking_url = (empty($raw_booking_url) || in_array($raw_booking_url, array('#book', '#booking', '#', ''))) ? home_url('/booking/') : (function_exists('otr_url') ? otr_url($raw_booking_url) : home_url('/' . ltrim($raw_booking_url, '/')));

// 1. Nhúng Header điều hướng On The Rock đồng bộ
get_template_part( 'template-parts/header/site-header', null, array(
    'facebook_url'  => $header_fb,
    'instagram_url' => $header_insta,
    'logo'          => $header_logo,
    'menu_text'     => $header_menu,
    'menu_url'      => $header_menu_url,
    'contact_text'  => $header_contact,
    'contact_url'   => $header_contact_url,
    'booking_text'  => $header_booking,
    'booking_url'   => $header_booking_url,
) );

// 2. Nhúng nội dung Trang Menu chính (Hero 2 ảnh + Selector + Bố cục được chọn)
get_template_part( 'template-parts/menu/section-menu-page' );

// 3. Nhúng Chân trang On The Rock
get_footer();
