<?php
/**
 * Template Name: WooCommerce Checkout Page
 * Description: Mẫu trang Thanh toán cao cấp.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Thanh toán'
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        
        <!-- Steps Progress Tracker -->
        <div class="max-w-xl mx-auto mb-8 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex justify-between items-center text-xs md:text-sm font-bold text-gray-400">
            <div class="flex items-center gap-2 text-green-600">
                <span class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold">✓</span>
                <span>Giỏ hàng</span>
            </div>
            <div class="h-0.5 bg-green-200 flex-1 mx-4"></div>
            <div class="flex items-center gap-2 text-lc-blue">
                <span class="w-6 h-6 rounded-full bg-lc-blue text-white flex items-center justify-center text-xs">2</span>
                <span>Thanh toán</span>
            </div>
            <div class="h-0.5 bg-gray-100 flex-1 mx-4"></div>
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs">3</span>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <!-- WooCommerce Checkout Shortcode Output -->
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="prose max-w-none">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; else: ?>
                <!-- Fallback mockup if WooCommerce is empty -->
                <div class="text-center py-16 max-w-md mx-auto space-y-4">
                    <div class="text-5xl">🛍️</div>
                    <h2 class="text-xl font-black text-gray-800">Không có thông tin thanh toán</h2>
                    <p class="text-xs text-gray-400">Vui lòng quay lại cửa hàng chọn mua sản phẩm trước khi thanh toán.</p>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="inline-block bg-lc-blue hover:bg-lc-darkblue text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-md">
                        Đến Cửa Hàng
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
get_footer();
