<?php
/**
 * Template Name: About Page
 * Description: Mẫu trang Giới thiệu công ty/cửa hàng.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Giới thiệu'
]);
?>

<div class="container mx-auto px-4 pb-12">
    <!-- Nhúng Section About -->
    <?php get_template_part('template-parts/sections/section-about'); ?>

    <!-- Thêm một số nội dung tùy biến khác của trang Giới thiệu -->
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-50 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-4">
            <div class="w-12 h-12 bg-blue-100 text-lc-blue rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <h3 class="font-extrabold text-gray-800 text-base mb-2">Chất lượng hàng đầu</h3>
            <p class="text-xs text-gray-400">Cam kết cung cấp thuốc và sản phẩm chính hãng có nguồn gốc xuất xứ rõ ràng.</p>
        </div>

        <div class="text-center p-4">
            <div class="w-12 h-12 bg-orange-100 text-lc-orange rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <h3 class="font-extrabold text-gray-800 text-base mb-2">Tư vấn tận tâm</h3>
            <p class="text-xs text-gray-400">Dược sĩ chuyên môn cao sẵn sàng giải đáp và hướng dẫn sử dụng thuốc an toàn.</p>
        </div>

        <div class="text-center p-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <h3 class="font-extrabold text-gray-800 text-base mb-2">Giao hàng siêu tốc</h3>
            <p class="text-xs text-gray-400">Nhận thuốc tại nhà nhanh chóng chỉ trong 1 giờ đồng hồ.</p>
        </div>
    </div>
</div>

<?php
get_footer();
