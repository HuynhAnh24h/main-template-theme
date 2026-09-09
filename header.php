<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Tải trước font chữ không chặn hiển thị màn hình (Non-blocking Asynchronous Fonts) -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Roboto:wght@300;400;500;700&subset=vietnamese,latin&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Roboto:wght@300;400;500;700&subset=vietnamese,latin&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Roboto:wght@300;400;500;700&subset=vietnamese,latin&display=swap">
    </noscript>
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