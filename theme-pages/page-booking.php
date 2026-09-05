<?php
/**
 * Template Name: Booking Page (Đặt Bàn)
 * Description: Giao diện trang Đặt Bàn (Bookings) sang trọng cho On The Rock Cocktail Bar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$front_page_id   = get_option('page_on_front');
$header_fb       = function_exists('get_field') ? (get_field('header_facebook_url', $front_page_id) ?: 'https://facebook.com/ontherock.dalat') : 'https://facebook.com/ontherock.dalat';
$header_insta    = function_exists('get_field') ? (get_field('header_instagram_url', $front_page_id) ?: 'https://instagram.com/ontherock.dalat') : 'https://instagram.com/ontherock.dalat';
$header_logo     = function_exists('get_field') ? get_field('header_logo', $front_page_id) : null;
$header_menu     = function_exists('get_field') ? (get_field('header_menu_text', $front_page_id) ?: 'MENU') : 'MENU';
$raw_menu_url    = function_exists('get_field') ? get_field('header_menu_url', $front_page_id) : '';
$header_menu_url = (empty($raw_menu_url) || in_array($raw_menu_url, array('#menu', '#', ''))) ? home_url('/menu/') : (function_exists('otr_url') ? otr_url($raw_menu_url) : home_url('/' . ltrim($raw_menu_url, '/')));
$header_contact  = function_exists('get_field') ? (get_field('header_contact_text', $front_page_id) ?: 'CONTACT') : 'CONTACT';
$raw_contact_url = function_exists('get_field') ? get_field('header_contact_url', $front_page_id) : '';
$header_contact_url = (empty($raw_contact_url) || in_array($raw_contact_url, array('#contact', '#', ''))) ? home_url('/contact/') : (function_exists('otr_url') ? otr_url($raw_contact_url) : home_url('/' . ltrim($raw_contact_url, '/')));
$header_booking  = function_exists('get_field') ? (get_field('header_booking_text', $front_page_id) ?: 'ĐẶT BÀN TRƯỚC') : 'ĐẶT BÀN TRƯỚC';
$header_booking_url = home_url('/booking/');

// 1. Nhúng Header điều hướng On The Rock
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

// 2. Nhúng Form Đặt Bàn (100% khớp mockup)
get_template_part( 'template-parts/booking/section-booking-form' );

// 3. Nhúng Không Gian 5 Ảnh & Dải Marquee Ticker
get_template_part( 'template-parts/booking/section-booking-atmosphere' );

// 4. Nhúng Chân trang On The Rock
get_footer();
