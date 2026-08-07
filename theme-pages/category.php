<?php
/**
 * Description: Mẫu trang danh mục bài viết Blog.
 */

get_header();

$cat_title = single_cat_title('', false);
$cat_desc = category_description();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Danh mục: ' . $cat_title
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <div class="mb-8 pb-4 border-b border-gray-100">
                <span class="text-xs uppercase font-extrabold text-lc-blue tracking-wider block mb-1">Danh mục chuyên đề</span>
                <h1 class="text-2xl font-black text-gray-800"><?php echo esc_html($cat_title); ?></h1>
                <?php if (!empty($cat_desc)) : ?>
                    <p class="text-xs text-gray-400 mt-1"><?php echo esc_html(wp_strip_all_tags($cat_desc)); ?></p>
                <?php else : ?>
                    <p class="text-xs text-gray-400 mt-1">Các bài viết và chia sẻ kinh nghiệm hữu ích liên quan đến chủ đề <?php echo esc_html($cat_title); ?>.</p>
                <?php endif; ?>
            </div>

            <!-- Danh sách Bài viết dạng lưới -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/components/blog-card', null, [
                            'post_id' => get_the_ID()
                        ]);
                    endwhile;
                else :
                    // Dummy posts fallback
                    for ($i = 1; $i <= 3; $i++) :
                        get_template_part('template-parts/components/blog-card', null, [
                            'post_id' => $i
                        ]);
                    endfor;
                endif;
                ?>
            </div>

            <!-- Phân trang -->
            <div class="mt-12 text-center">
                <?php if (have_posts()) : ?>
                    <div class="flex justify-center gap-2">
                        <?php
                        echo paginate_links([
                            'type'      => 'list',
                            'prev_text' => '&larr;',
                            'next_text' => '&rarr;'
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<?php
get_footer();
