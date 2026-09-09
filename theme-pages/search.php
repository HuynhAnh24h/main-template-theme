<?php
/**
 * The template for displaying search results pages
 * Description: Mẫu hiển thị kết quả tìm kiếm sản phẩm & bài viết.
 */

get_header();

$search_query = get_search_query();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Tìm kiếm: "' . $search_query . '"'
]);
?>

<div class="bg-[#080604] text-stone-300 min-h-screen pb-16 pt-8">
    <div class="container mx-auto px-4 max-w-5xl">
        
        <div class="bg-[#120e0a]/80 backdrop-blur-md rounded-2xl p-6 md:p-10 border border-white/10 shadow-2xl mb-8">
            <div class="mb-8 pb-4 border-b border-white/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-serif text-[#caa875]">Kết quả tìm kiếm</h1>
                    <p class="text-xs text-stone-400 mt-1">Tìm thấy các kết quả khớp với từ khóa "<span class="text-white font-medium"><?php echo esc_html($search_query); ?></span>"</p>
                </div>
                
                <span class="text-xs font-medium tracking-wider uppercase bg-[#caa875]/10 text-[#caa875] border border-[#caa875]/20 px-3.5 py-1.5 rounded-full shrink-0">
                    <?php
                    global $wp_query;
                    echo $wp_query->found_posts . ' kết quả';
                    ?>
                </span>
            </div>

            <?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/components/blog-card', null, [
                            'post_id' => get_the_ID(),
                            'class'   => 'col-span-1'
                        ]);
                    endwhile;
                    ?>
                </div>

                <!-- Phân trang -->
                <div class="mt-12 flex justify-center text-stone-400">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <!-- Không có kết quả -->
                <div class="text-center py-16 max-w-md mx-auto space-y-4">
                    <div class="text-5xl opacity-80">🍸</div>
                    <h2 class="text-xl font-serif text-stone-200">Không tìm thấy kết quả phù hợp</h2>
                    <p class="text-xs text-stone-400 leading-relaxed">
                        Hãy thử kiểm tra lại chính tả hoặc tìm kiếm món ăn, cocktail, rượu vang hoặc các sự kiện tại On The Rock.
                    </p>
                    
                    <div class="relative pt-4 max-w-sm mx-auto">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" name="s" class="w-full bg-[#1c1611] border border-white/10 text-stone-200 rounded-xl px-4 py-3 pl-11 text-xs focus:outline-none focus:border-[#caa875] transition placeholder-stone-500" placeholder="Tìm kiếm món ăn, cocktail...">
                            <div class="absolute left-3.5 top-7 text-stone-400">
                                <?php echo get_svg_icon('search', 'w-4 h-4'); ?>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<?php
get_footer();
