<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&subset=vietnamese,latin&display=swap" rel="stylesheet">
    <?php wp_head(); ?> 
</head>
<body <?php body_class('bg-[#080604] text-[#f4efe8] antialiased selection:bg-[#caa875] selection:text-black'); ?>>
<?php wp_body_open(); ?>

<?php
// Tự động nhúng Site Header cho các trang generic nếu chưa tự gọi
if ( ! is_front_page() && ! is_page_template( 'theme-pages/page-booking.php' ) && ! is_page( 'booking' ) && ! is_page_template( 'theme-pages/page-contact.php' ) && ! is_page( 'contact' ) && ! is_page_template( 'theme-pages/page-menu.php' ) && ! is_page( 'menu' ) ) {
    get_template_part( 'template-parts/components/site-header' );
}
?>

<?php if ( ! is_front_page() ) : ?>
<!-- Main Content Wrapper -->
<main id="main-content" class="min-h-[70vh]">
<?php endif; ?>