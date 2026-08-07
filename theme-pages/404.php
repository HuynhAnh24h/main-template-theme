<?php
/**
 * The template for displaying 404 pages (not found)
 * Description: Mẫu hiển thị lỗi 404 (Không tìm thấy trang).
 */

get_header();
?>

<div class="bg-lc-bg min-h-[70vh] flex items-center justify-center py-16">
    <div class="container mx-auto px-4 text-center max-w-lg">
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-50 space-y-6">
            <!-- 404 Illustration -->
            <div class="w-24 h-24 bg-red-50 text-lc-red rounded-full flex items-center justify-center mx-auto text-4xl animate-bounce">
                <?php echo get_svg_icon('shield-alert', 'w-12 h-12'); ?>
            </div>
            
            <h1 class="text-3xl md:text-5xl font-black text-gray-800">Lỗi 404</h1>
            <h2 class="text-base font-bold text-gray-600">Rất tiếc! Không tìm thấy trang này</h2>
            
            <p class="text-xs text-gray-400 leading-relaxed">
                Đường dẫn bạn truy cập có thể đã bị thay đổi, xóa bỏ hoặc không tồn tại. Hãy thử tìm kiếm nội dung khác hoặc quay trở về trang chủ.
            </p>

            <!-- Search Bar Fallback -->
            <div class="relative max-w-xs mx-auto">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" name="s" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 pl-10 text-xs focus:outline-none focus:border-lc-blue focus:bg-white transition" placeholder="Tìm kiếm sản phẩm, bài viết...">
                    <div class="absolute left-3.5 top-3.5 text-gray-400">
                        <?php echo get_svg_icon('search', 'w-4 h-4'); ?>
                    </div>
                </form>
            </div>

            <div class="pt-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-lc-blue hover:bg-lc-darkblue text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-md shadow-blue-500/10">
                    Quay về Trang Chủ
                </a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
