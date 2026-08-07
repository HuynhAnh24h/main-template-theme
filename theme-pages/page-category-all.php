<?php
/**
 * Template Name: All Categories Page
 * Description: Mẫu hiển thị toàn bộ danh mục sản phẩm.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Tất cả danh mục'
]);
?>

<div class="container mx-auto px-4 pb-12">
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50">
        <!-- Tiêu đề & Input Tìm kiếm nhanh -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-6 border-b border-gray-100">
            <div>
                <h1 class="text-2xl font-black text-gray-800">Danh Mục Sản Phẩm</h1>
                <p class="text-xs text-gray-400 mt-1">Dễ dàng tìm kiếm nhóm sản phẩm bạn quan tâm</p>
            </div>
            
            <div class="relative w-full md:w-80">
                <input type="text" id="category-search-input" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-xs focus:outline-none focus:border-lc-blue focus:bg-white transition" placeholder="Tìm kiếm nhanh danh mục...">
                <div class="absolute left-3.5 top-3.5 text-gray-400">
                    <?php echo get_svg_icon('search', 'w-4 h-4'); ?>
                </div>
            </div>
        </div>

        <!-- Lưới Danh mục -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <?php
            // Lấy toàn bộ danh mục WooCommerce
            $terms = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ]);

            if (!empty($terms) && !is_wp_error($terms)) :
                foreach ($terms as $term) :
                    $link = get_term_link($term);
                    // Lấy ảnh danh mục
                    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_url($thumbnail_id);
                    $image_html = $image_url 
                        ? '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" class="w-14 h-14 object-cover mx-auto mb-3 group-hover:scale-110 transition duration-300">'
                        : '<div class="w-14 h-14 mx-auto mb-3 rounded-full bg-blue-50 text-lc-blue flex items-center justify-center text-xl font-bold group-hover:scale-110 transition duration-300">📦</div>';
            ?>
                    <a href="<?php echo esc_url($link); ?>" class="category-grid-item group p-4 rounded-2xl hover:bg-blue-50/50 transition-all border border-gray-100/50 hover:border-blue-100 text-center">
                        <?php echo $image_html; ?>
                        <span class="category-title text-xs md:text-sm font-bold text-gray-700 group-hover:text-lc-blue transition line-clamp-1"><?php echo esc_html($term->name); ?></span>
                        <span class="text-[10px] text-gray-400 mt-1 block"><?php echo esc_html($term->count); ?> sản phẩm</span>
                    </a>
            <?php 
                endforeach;
            else: 
                // Dummy data fallback
                $dummies = [
                    ['name' => 'Dược phẩm', 'count' => 120, 'icon' => '💊'],
                    ['name' => 'Thực phẩm chức năng', 'count' => 85, 'icon' => '🍊'],
                    ['name' => 'Chăm sóc cá nhân', 'count' => 95, 'icon' => '🧼'],
                    ['name' => 'Thiết bị y tế', 'count' => 30, 'icon' => '🌡️'],
                    ['name' => 'Mỹ phẩm Dược', 'count' => 64, 'icon' => '🧴'],
                    ['name' => 'Hàng tiêu dùng', 'count' => 42, 'icon' => '🛒'],
                ];
                foreach ($dummies as $index => $dum) :
            ?>
                    <a href="#" class="category-grid-item group p-5 rounded-2xl hover:bg-blue-50/50 transition-all border border-gray-100/50 hover:border-blue-100 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-50 flex items-center justify-center text-2xl group-hover:scale-110 transition duration-300">
                            <?php echo $dum['icon']; ?>
                        </div>
                        <span class="category-title text-xs md:text-sm font-bold text-gray-700 group-hover:text-lc-blue transition line-clamp-1"><?php echo esc_html($dum['name']); ?></span>
                        <span class="text-[10px] text-gray-400 mt-1 block"><?php echo $dum['count']; ?> sản phẩm</span>
                    </a>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
