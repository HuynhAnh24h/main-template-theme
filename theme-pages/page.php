<?php
/**
 * The template for displaying all pages
 * Description: Mẫu trang thông tin tĩnh mặc định.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => get_the_title()
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-gray-50 mb-8 max-w-4xl mx-auto">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="prose prose-blue max-w-none text-gray-600 text-sm md:text-base leading-relaxed space-y-6">
                    <h1 class="text-2xl md:text-4xl font-black text-gray-800 border-b border-gray-100 pb-4 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <div>
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; endif; ?>

        </div>
    </div>
</div>

<?php
get_footer();
