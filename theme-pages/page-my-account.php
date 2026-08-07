<?php
/**
 * Template Name: WooCommerce My Account Page
 * Description: Mẫu trang thông tin tài khoản cá nhân.
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Tài khoản của tôi'
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50 mb-8">
            <!-- WooCommerce My Account Shortcode Output -->
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="prose max-w-none">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; else: ?>
                <!-- Fallback mockup if WooCommerce is empty -->
                <div class="text-center py-16 max-w-md mx-auto space-y-4">
                    <div class="text-5xl">👤</div>
                    <h2 class="text-xl font-black text-gray-800">Đăng ký hoặc Đăng nhập</h2>
                    <p class="text-xs text-gray-400">Bạn cần đăng nhập để quản lý lịch sử đơn hàng, địa chỉ giao nhận và thông tin tài khoản.</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-lc-blue hover:bg-lc-darkblue text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-md">
                        Trở Về Trang Chủ
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
get_footer();
