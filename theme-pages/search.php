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

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <div class="mb-8 pb-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-gray-800">Kết quả tìm kiếm</h1>
                    <p class="text-xs text-gray-400 mt-1">Tìm thấy các kết quả khớp với từ khóa "<span class="text-lc-blue font-bold"><?php echo esc_html($search_query); ?></span>"</p>
                </div>
                
                <span class="text-xs font-bold bg-blue-50 text-lc-blue px-3 py-1 rounded-full shrink-0">
                    <?php
                    global $wp_query;
                    echo $wp_query->found_posts . ' kết quả';
                    ?>
                </span>
            </div>

            <?php if (have_posts()) : ?>
                <!-- Phân tách Sản phẩm và Bài viết để hiển thị giao diện phù hợp -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <?php
                    while (have_posts()) : the_post();
                        $post_type = get_post_type();
                        
                        if ($post_type === 'product') {
                            // Nhúng Card sản phẩm
                            get_template_part('template-parts/components/product-card', null, [
                                'product_id' => get_the_ID()
                            ]);
                        } else {
                            // Nhúng Card tin tức (Đẩy class rộng 100% cột để grid chia đều)
                            get_template_part('template-parts/components/blog-card', null, [
                                'post_id' => get_the_ID(),
                                'class'   => 'col-span-1 md:col-span-2' // Tin tức hiển thị to hơn một chút trong lưới
                            ]);
                        }
                    endwhile;
                    ?>
                </div>

                <!-- Phân trang -->
                <div class="mt-12 flex justify-center">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <!-- Không có kết quả -->
                <div class="text-center py-16 max-w-sm mx-auto space-y-4">
                    <div class="text-5xl">🔍</div>
                    <h2 class="text-lg font-black text-gray-800">Không tìm thấy kết quả phù hợp</h2>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Hãy thử kiểm tra lại chính tả hoặc sử dụng từ khóa khác chung hơn (ví dụ: "vitamin", "thuốc cảm", "sữa rửa mặt").
                    </p>
                    
                    <div class="relative pt-2">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" name="s" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 pl-10 text-xs focus:outline-none focus:border-lc-blue focus:bg-white transition" placeholder="Tìm kiếm lại...">
                            <div class="absolute left-3.5 top-3.5 text-gray-400">
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
