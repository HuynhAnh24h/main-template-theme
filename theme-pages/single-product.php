<?php
/**
 * The Template for displaying all single products
 * Description: Mẫu trang chi tiết sản phẩm.
 */

get_header();

$product_id = get_the_ID();
$product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;

if ($product) :
    $title = $product->get_name();
    $price_html = $product->get_price_html();
    $description = $product->get_description();
    $short_desc = $product->get_short_description();
    $gallery_ids = $product->get_gallery_image_ids();
    $main_image_url = wp_get_attachment_url($product->get_image_id());
else :
    // Fallback data if WooCommerce is not set up
    $title = get_the_title() ? get_the_title() : 'Thực Phẩm Chức Năng Vitamin C 1000mg Hộp 100 Viên';
    $price_html = '<span class="price"><span class="woocommerce-Price-amount amount">185.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></span></span>';
    $description = 'Sản phẩm bổ sung Vitamin C hàm lượng cao giúp tăng cường hệ miễn dịch, thúc đẩy quá trình sản sinh collagen tự nhiên và chống oxy hóa mạnh mẽ. Sản phẩm đạt chuẩn GMP quốc tế, an toàn cho cả gia đình khi sử dụng lâu dài.';
    $short_desc = 'Hộp 100 viên nén. Bổ sung 1000mg Vitamin C mỗi ngày. Tăng sức đề kháng hiệu quả.';
    $gallery_ids = [];
    $main_image_url = 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=800';
endif;

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => $title
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Product Gallery (Bên trái) -->
                <div>
                    <div class="relative rounded-2xl overflow-hidden aspect-square bg-gray-50 flex items-center justify-center border border-gray-100">
                        <?php if ($product && has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', ['id' => 'product-main-image', 'class' => 'object-cover w-full h-full']); ?>
                        <?php else : ?>
                            <img id="product-main-image" src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="object-cover w-full h-full">
                        <?php endif; ?>
                    </div>

                    <!-- Thumbnails (Nếu có) -->
                    <div class="flex items-center gap-3 mt-4 overflow-x-auto no-scrollbar">
                        <div class="product-thumb-item w-16 h-16 rounded-xl overflow-hidden border-2 border-lc-blue shrink-0 cursor-pointer" data-large-src="<?php echo esc_url($main_image_url); ?>">
                            <img src="<?php echo esc_url($main_image_url); ?>" class="w-full h-full object-cover">
                        </div>
                        <?php
                        if (!empty($gallery_ids)) :
                            foreach ($gallery_ids as $attachment_id) :
                                $thumb_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
                                $large_url = wp_get_attachment_image_url($attachment_id, 'large');
                        ?>
                                <div class="product-thumb-item w-16 h-16 rounded-xl overflow-hidden border border-gray-100 shrink-0 cursor-pointer" data-large-src="<?php echo esc_url($large_url); ?>">
                                    <img src="<?php echo esc_url($thumb_url); ?>" class="w-full h-full object-cover">
                                </div>
                        <?php
                            endforeach;
                        else:
                            // Mock gallery thumbnails
                            $mock_thumbs = [
                                'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&q=80&w=200',
                                'https://images.unsplash.com/photo-1607619056574-7b8d304f3c6f?auto=format&fit=crop&q=80&w=200'
                            ];
                            foreach ($mock_thumbs as $m_thumb) :
                        ?>
                                <div class="product-thumb-item w-16 h-16 rounded-xl overflow-hidden border border-gray-100 shrink-0 cursor-pointer" data-large-src="<?php echo esc_url($m_thumb); ?>">
                                    <img src="<?php echo esc_url($m_thumb); ?>" class="w-full h-full object-cover">
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Product Summary Info (Bên phải) -->
                <div class="flex flex-col justify-between">
                    <div>
                        <span class="bg-blue-50 text-lc-blue text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">
                            Chính hãng
                        </span>
                        
                        <h1 class="text-xl md:text-3xl font-black text-gray-800 mb-2 leading-snug"><?php echo esc_html($title); ?></h1>
                        
                        <!-- Ratings -->
                        <div class="flex items-center gap-1.5 mb-4">
                            <div class="flex text-lc-orange">
                                <?php for($i=1; $i<=5; $i++): echo get_svg_icon('star', 'w-4 h-4 fill-current'); endfor; ?>
                            </div>
                            <span class="text-xs text-gray-400 font-bold">(5.0/5.0 từ 128 đánh giá)</span>
                        </div>

                        <!-- Price -->
                        <div class="bg-gray-50 rounded-2xl p-4 md:p-6 mb-6">
                            <span class="text-xs font-bold text-gray-400 block mb-1">Giá bán lẻ khuyến nghị</span>
                            <div class="text-lc-red font-black text-2xl md:text-3xl flex items-baseline gap-2">
                                <?php echo $price_html; ?>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="text-sm text-gray-500 mb-6 leading-relaxed">
                            <?php echo wp_kses_post($short_desc); ?>
                        </div>

                        <!-- Quantity Selector & Action -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 mb-6 border-t border-b border-gray-100 py-6">
                            <!-- Qty Selector -->
                            <div class="flex items-center border border-gray-200 rounded-xl h-12 bg-white max-w-[140px]">
                                <button type="button" class="quantity-minus w-10 h-full flex items-center justify-center text-gray-400 hover:text-gray-600 transition">&minus;</button>
                                <input type="number" class="quantity-input w-12 h-full text-center font-bold text-gray-800 text-sm focus:outline-none bg-transparent" value="1" min="1" step="1">
                                <button type="button" class="quantity-plus w-10 h-full flex items-center justify-center text-gray-400 hover:text-gray-600 transition">&plus;</button>
                            </div>

                            <!-- Buy Buttons -->
                            <button type="submit" class="flex-1 bg-lc-blue hover:bg-lc-darkblue text-white font-extrabold h-12 rounded-xl transition duration-200 shadow-md shadow-blue-500/10 flex items-center justify-center gap-2">
                                <?php echo get_svg_icon('shopping-cart', 'w-4 h-4'); ?> Thêm Vào Giỏ Hàng
                            </button>
                        </div>
                    </div>

                    <!-- Trust factors badges -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                            <?php echo get_svg_icon('shield', 'w-5 h-5 text-lc-blue'); ?> Cam kết 100% chính hãng
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                            <?php echo get_svg_icon('truck', 'w-5 h-5 text-lc-blue'); ?> Giao thuốc nhanh 1h
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                            <i data-lucide="rotate-ccw" class="w-5 h-5 text-lc-blue"></i> Đổi trả hàng dễ dàng
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50">
            <!-- Tab buttons -->
            <div class="flex border-b border-gray-100 gap-6 md:gap-8 mb-6 overflow-x-auto no-scrollbar">
                <button class="product-tab-btn border-b-2 border-lc-blue text-lc-blue font-bold text-sm md:text-base pb-3 cursor-pointer shrink-0 transition" data-tab="desc">
                    Mô tả sản phẩm
                </button>
                <button class="product-tab-btn border-b-2 border-transparent text-gray-400 hover:text-gray-600 font-medium text-sm md:text-base pb-3 cursor-pointer shrink-0 transition" data-tab="specs">
                    Thông số kỹ thuật
                </button>
                <button class="product-tab-btn border-b-2 border-transparent text-gray-400 hover:text-gray-600 font-medium text-sm md:text-base pb-3 cursor-pointer shrink-0 transition" data-tab="reviews">
                    Đánh giá khách hàng
                </button>
            </div>

            <!-- Tab panels -->
            <!-- Description Panel -->
            <div id="tab-panel-desc" class="product-tab-panel text-sm text-gray-500 leading-relaxed space-y-4">
                <p><?php echo wp_kses_post($description); ?></p>
            </div>

            <!-- Specs Panel -->
            <div id="tab-panel-specs" class="product-tab-panel text-sm text-gray-600 hidden">
                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="border-b border-gray-50"><td class="py-3 font-bold w-1/3 text-gray-400">Quy cách đóng gói</td><td class="py-3">Hộp 100 viên</td></tr>
                        <tr class="border-b border-gray-50"><td class="py-3 font-bold text-gray-400">Thương hiệu</td><td class="py-3">Long Châu Pharma</td></tr>
                        <tr class="border-b border-gray-50"><td class="py-3 font-bold text-gray-400">Xuất xứ thương hiệu</td><td class="py-3">Việt Nam</td></tr>
                        <tr class="border-b border-gray-50"><td class="py-3 font-bold text-gray-400">Nhà sản xuất</td><td class="py-3">Dược phẩm Mediphar</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Reviews Panel -->
            <div id="tab-panel-reviews" class="product-tab-panel text-sm text-gray-500 hidden">
                <p>Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên gửi ý kiến đánh giá của bạn!</p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();