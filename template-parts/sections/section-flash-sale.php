<?php
/**
 * Section: Flash Sale
 * Bố cục: Flash Sale Header với Countdown + Grid sản phẩm giảm giá
 */
?>
<section class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-red-50/50 mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 border-b border-gray-100 pb-4">
        <div class="flex flex-wrap items-center gap-3">
            <span class="bg-lc-red text-white font-black text-xs px-3 py-1 rounded-xl animate-pulse tracking-wide">
                FLASH SALE
            </span>
            <h2 class="text-xl font-black text-gray-800">Khuyến Mãi Giới Hạn</h2>
            
            <!-- Countdown Timer -->
            <div class="flex items-center gap-1 bg-red-50 text-lc-red px-3 py-1 rounded-xl font-extrabold text-xs">
                <span>Kết thúc trong:</span>
                <span id="flash-sale-countdown" class="tracking-widest font-mono text-sm ml-1">03:00:00</span>
            </div>
        </div>
        
        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="text-xs md:text-sm font-bold text-lc-blue hover:text-lc-darkblue flex items-center gap-1 transition">
            Xem tất cả <?php echo get_svg_icon('chevron-right', 'w-3.5 h-3.5'); ?>
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 5,
        );
        $loop = new WP_Query($args);
        
        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                get_template_part('template-parts/components/product-card', null, [
                    'product_id' => get_the_ID()
                ]);
            endwhile;
            wp_reset_postdata();
        else :
            // Dummy Products nếu chưa có sản phẩm WooCommerce
            for ($i = 1; $i <= 5; $i++) :
                get_template_part('template-parts/components/product-card', null, [
                    'product_id' => $i
                ]);
            endfor;
        endif;
        ?>
    </div>
</section>
