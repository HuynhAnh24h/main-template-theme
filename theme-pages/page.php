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

<div class="bg-[#080604] min-h-screen pb-16 pt-6">
    <div class="container mx-auto px-4">
        <div class="bg-[#140e08] rounded-2xl p-6 md:p-10 shadow-xl border border-[#caa875]/20 mb-8 max-w-4xl mx-auto text-[#f4efe8]">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="max-w-none text-[#d1d5db] text-sm md:text-base leading-relaxed space-y-6">
                    <h1 class="font-serif text-2xl md:text-4xl font-normal text-[#caa875] border-b border-[#caa875]/20 pb-4 mb-6 leading-tight">
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
