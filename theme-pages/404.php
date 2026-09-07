<?php
/**
 * The template for displaying 404 pages (not found)
 * Description: Mẫu hiển thị lỗi 404 (Không tìm thấy trang).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="bg-[#080604] min-h-[75vh] flex items-center justify-center py-20 px-4 font-serif text-[#caa875]">
    <div class="max-w-lg mx-auto text-center">
        <!-- 404 Số lớn -->
        <span class="text-7xl sm:text-9xl font-light tracking-widest text-[#caa875]/40 block mb-2">404</span>
        
        <h1 class="text-2xl sm:text-4xl font-normal uppercase tracking-wider mb-4">
            Không Tìm Thấy Trang
        </h1>
        
        <p class="text-[#f4efe8]/70 font-sans text-sm md:text-base leading-relaxed mb-8 max-w-md mx-auto">
            Trang bạn đang tìm kiếm có thể đã bị di chuyển hoặc không còn tồn tại. Hãy quay lại hoặc ghé thăm thực đơn của chúng mình.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-liquid-glass btn-liquid-gold inline-flex items-center justify-center rounded-full px-7 py-3 bg-[#caa875] text-[#080604] font-bold text-xs tracking-[0.18em] uppercase shadow-lg select-none cursor-pointer">
                <span class="btn-roll-wrap">
                    <span class="btn-roll-text">
                        <span>Về Trang Chủ</span>
                        <span aria-hidden="true">Về Trang Chủ</span>
                    </span>
                </span>
            </a>
            <a href="<?php echo esc_url(home_url('/menu/')); ?>" class="btn-liquid-glass inline-flex items-center justify-center rounded-full px-7 py-3 bg-[#1e1710] border border-[#caa875]/70 text-[#caa875] font-bold text-xs tracking-[0.18em] uppercase shadow-lg select-none cursor-pointer">
                <span class="btn-roll-wrap">
                    <span class="btn-roll-text">
                        <span>Xem Menu</span>
                        <span aria-hidden="true">Xem Menu</span>
                    </span>
                </span>
            </a>
        </div>
    </div>
</div>

<?php
get_footer();
