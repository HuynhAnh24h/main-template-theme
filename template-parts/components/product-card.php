<?php
/**
 * Component: Product Card
 * Hiển thị thông tin tóm tắt của sản phẩm.
 * Hỗ trợ truyền dữ liệu thông qua $args trong get_template_part().
 */

// Lấy ID sản phẩm truyền vào, mặc định là ID của post hiện tại trong loop
$product_id = isset($args['product_id']) ? $args['product_id'] : get_the_ID();
$class_custom = isset($args['class']) ? $args['class'] : '';

// Lấy đối tượng sản phẩm nếu WooCommerce được kích hoạt
$product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;

if ($product) :
    $title = $product->get_name();
    $permalink = get_permalink($product_id);
    $price_html = $product->get_price_html();
    $image_html = $product->get_image('medium', ['class' => 'object-cover w-full h-full group-hover:scale-105 transition duration-300']);
else :
    // Fallback dữ liệu mẫu nếu không có WooCommerce hoặc không tìm thấy sản phẩm
    $title = get_the_title($product_id) ? get_the_title($product_id) : 'Sản phẩm bảo vệ sức khỏe Vitamin C 1000mg';
    $permalink = get_the_permalink($product_id) ? get_the_permalink($product_id) : '#';
    $price_html = '<span class="price"><span class="woocommerce-Price-amount amount">185.000&nbsp;<span class="woocommerce-Price-currencySymbol">₫</span></span></span>';
    $image_html = '<div class="w-full h-full bg-blue-50 flex items-center justify-center text-lc-blue text-3xl font-bold">💊</div>';
endif;
?>

<div class="bg-white border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:shadow-xl transition-all duration-300 relative group <?php echo esc_attr($class_custom); ?>">
    <!-- Badge ưu đãi / sale nếu có -->
    <?php if ($product && $product->is_on_sale()) : ?>
        <span class="absolute top-3 left-3 bg-lc-red text-white text-xs font-bold px-2 py-0.5 rounded-lg z-10 animate-pulse">Giảm Giá</span>
    <?php endif; ?>

    <div>
        <!-- Link ảnh sản phẩm -->
        <a href="<?php echo esc_url($permalink); ?>" class="relative overflow-hidden rounded-xl mb-4 aspect-square bg-gray-50 flex items-center justify-center block">
            <?php echo $image_html; ?>
        </a>
        
        <!-- Danh mục sản phẩm (nếu có) -->
        <?php if ($product) : 
            $categories = wc_get_product_category_list($product_id, ', ', '<span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 mb-1 block">', '</span>');
            echo $categories;
        endif; ?>

        <!-- Tiêu đề sản phẩm -->
        <h3 class="text-xs md:text-sm font-semibold text-gray-800 line-clamp-2 mb-2 group-hover:text-lc-blue transition duration-200">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
        </h3>
    </div>

    <div>
        <!-- Giá sản phẩm -->
        <div class="text-lc-red font-extrabold text-sm md:text-base mb-3">
            <?php echo $price_html; ?>
        </div>

        <!-- Nút Chọn Mua / Chi Tiết -->
        <a href="<?php echo esc_url($permalink); ?>" class="block text-center w-full bg-blue-50 hover:bg-lc-blue text-lc-blue hover:text-white font-bold text-xs py-2.5 rounded-xl transition duration-200 shadow-sm hover:shadow">
            Chọn Mua
        </a>
    </div>
</div>
