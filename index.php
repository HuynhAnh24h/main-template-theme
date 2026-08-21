<?php
/**
 * The main template file
 * Description: Mẫu trang dự phòng chính (Fallback Index).
 */

get_header();

// Nhúng Breadcrumb
// get_template_part('template-parts/components/breadcrumb', null, [
//     'title' => get_the_title() ? get_the_title() : 'Nội dung'
// ]);
// ?>

<div class="bg-lc-bg min-h-screen pb-12">

    <!-- Section slider -->
   <?php get_template_part('template-parts/sections/section-hero'); ?>
    <div class="container mx-auto px-4">

            <?php get_template_part('template-parts/sections/home/section-category'); ?>
            <h1>Đây là trang chủ</h1>

    </div>
    </div>
</div>

<?php
get_footer();