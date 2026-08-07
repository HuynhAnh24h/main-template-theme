<?php
/**
 * Template Name: Front Page
 * Description: Trang chủ hệ thống.
 */

get_header();
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4 py-6">

        <!-- 1. HERO SECTION -->
        <?php get_template_part('template-parts/sections/section-hero'); ?>

        <!-- 2. DANH MỤC NỔI BẬT -->
        <section class="bg-white rounded-3xl p-6 md:p-8 shadow-sm mb-8 border border-gray-50">
            <h2 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                <span class="w-2 h-5 bg-lc-blue rounded-full inline-block"></span> Danh Mục Nổi Bật
            </h2>
            
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 text-center">
                <?php
                // Tùy biến lấy danh mục sản phẩm WooCommerce
                $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => 6]);
                if (!empty($terms) && !is_wp_error($terms)) :
                    foreach ($terms as $term) :
                        $link = get_term_link($term);
                        // Lấy ảnh danh mục
                        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                        $image_url = wp_get_attachment_url($thumbnail_id);
                        $image_html = $image_url 
                            ? '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" class="w-10 h-10 object-cover mx-auto mb-2 group-hover:scale-110 transition duration-300">'
                            : '<div class="w-10 h-10 mx-auto mb-2 rounded-full bg-gray-100 flex items-center justify-center text-xl group-hover:scale-110 transition">📦</div>';
                ?>
                        <a href="<?php echo esc_url($link); ?>" class="group p-3 rounded-2xl hover:bg-blue-50/50 transition border border-transparent hover:border-blue-100 block">
                            <?php echo $image_html; ?>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-lc-blue line-clamp-1"><?php echo esc_html($term->name); ?></span>
                        </a>
                <?php 
                    endforeach;
                else: 
                ?>
                    <!-- Fallback giao diện tĩnh nếu chưa có dữ liệu Woo -->
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">💊</div><span class="text-xs font-bold text-gray-600">Dược phẩm</span></div>
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">🍊</div><span class="text-xs font-bold text-gray-600">Thực phẩm chức năng</span></div>
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">🧼</div><span class="text-xs font-bold text-gray-600">Chăm sóc cá nhân</span></div>
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">🌡️</div><span class="text-xs font-bold text-gray-600">Thiết bị y tế</span></div>
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">🧴</div><span class="text-xs font-bold text-gray-600">Mỹ phẩm Dược</span></div>
                    <div class="p-3 bg-gray-50 rounded-2xl"><div class="text-xl mb-1">🛒</div><span class="text-xs font-bold text-gray-600">Hàng tiêu dùng</span></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- 3. KHỐI FLASH SALE -->
        <?php get_template_part('template-parts/sections/section-flash-sale'); ?>

        <!-- 4. GÓC SỨC KHỎE / TIN TỨC NỔI BẬT -->
        <?php get_template_part('template-parts/sections/section-blog-grid'); ?>

    </div>
</div>

<?php
get_footer();