<?php
/**
 * Template Name: Contact Page
 * Description: Mẫu trang Liên hệ.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Liên hệ'
]);
?>

<div class="container mx-auto px-4 pb-12">
    <!-- Nhúng Section Contact -->
    <?php get_template_part('template-parts/sections/section-contact'); ?>
</div>

<?php
get_footer();
