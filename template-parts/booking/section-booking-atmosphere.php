<?php
/**
 * Template Part: Section Booking Atmosphere & Marquee
 * Description: Khối hình ảnh không gian On The Rock và dải chữ chạy Marquee (100% khớp mockup).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();
$booking_page = get_page_by_path('booking');
$booking_page_id = $booking_page ? $booking_page->ID : null;

$quote = function_exists('get_field') ? get_field('booking_atmosphere_quote', $post_id) : '';
if (empty($quote) && $booking_page_id) {
    $quote = get_field('booking_atmosphere_quote', $booking_page_id);
}
if (empty($quote)) {
    $quote = "ẤM CÚNG, TINH TẾ VÀ ĐẦY NĂNG LƯỢNG\nKHI MÀN ĐÊM BUÔNG XUỐNG.";
}

$marquee_text = function_exists('get_field') ? get_field('booking_marquee_text', $post_id) : '';
if (empty($marquee_text) && $booking_page_id) {
    $marquee_text = get_field('booking_marquee_text', $booking_page_id);
}
if (empty($marquee_text)) {
    $marquee_text = 'MEET THE ON THE ROCK TEAM';
}

$theme_uri = get_template_directory_uri();

// Lấy 5 ảnh từ ACF hoặc dùng 5 ảnh mặc định đã cắt từ mockup
$photos = array();
for ($i = 1; $i <= 5; $i++) {
    $acf_img = function_exists('get_field') ? get_field("booking_img_{$i}", $post_id) : '';
    if (empty($acf_img) && $booking_page_id) {
        $acf_img = get_field("booking_img_{$i}", $booking_page_id);
    }
    if (!empty($acf_img)) {
        $photos[] = is_array($acf_img) ? $acf_img['url'] : $acf_img;
    } else {
        $photos[] = $theme_uri . "/assets/images/atmosphere-{$i}.jpg";
    }
}
?>

<section class="otr-atmosphere-section bg-[#080604] text-white pt-12 pb-14 sm:pb-20 overflow-hidden w-full">
    
    <!-- Tiêu đề / Câu nói không gian tràn theo chiều ngang với lề thoáng -->
    <div class="w-full px-5 sm:px-8 md:px-12 lg:px-16 mb-8 md:mb-12">
        <h2 class="font-serif text-xl sm:text-2xl md:text-3xl lg:text-[34px] text-[#caa875] uppercase tracking-[0.15em] font-normal leading-relaxed max-w-2xl">
            <?php echo nl2br(esc_html($quote)); ?>
        </h2>
    </div>

    <!-- Khối 5 ảnh không gian dọc tràn toàn màn hình (Full width, không container, ảnh to) -->
    <div class="w-full px-2 sm:px-3 md:px-4 lg:px-6 mb-12 sm:mb-16">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 sm:gap-3 md:gap-4 lg:gap-5 w-full">
            <?php foreach ($photos as $idx => $photo_url): ?>
                <div class="group relative overflow-hidden rounded-sm bg-[#121212] aspect-[3/4] sm:aspect-[9/14] md:h-[500px] lg:h-[620px] xl:h-[720px] 2xl:h-[780px] w-full shadow-2xl">
                    <img 
                        src="<?php echo esc_url($photo_url); ?>" 
                        alt="On The Rock Bar Atmosphere <?php echo esc_attr($idx + 1); ?>" 
                        loading="lazy"
                        class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter brightness-95 group-hover:brightness-105"
                    >
                    <!-- Lớp phủ ánh sáng ấm tinh tế khi hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-50 group-hover:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Dải Marquee Chạy Chữ Liên Tục: MEET THE ON THE ROCK TEAM -->
    <div class="otr-marquee-wrapper relative w-full overflow-hidden border-t border-b border-[#caa875]/20 py-4 md:py-5 bg-gradient-to-r from-[#0a0705] via-[#120d09] to-[#0a0705]">
        <div class="otr-marquee-content flex items-center whitespace-nowrap will-change-transform">
            <?php 
            // Lặp lại nhiều lần để tạo chuỗi chạy vô tận
            for ($k = 0; $k < 10; $k++): 
            ?>
                <div class="flex items-center gap-6 sm:gap-10 pr-6 sm:pr-10 select-none">
                    <span class="font-serif text-sm sm:text-base md:text-lg lg:text-xl uppercase tracking-[0.25em] text-[#caa875] font-light">
                        <?php echo esc_html($marquee_text); ?>
                    </span>
                    
                    <!-- Monogram OTR biểu tượng giữa các câu -->
                    <div class="w-6 h-6 sm:w-7 sm:h-7 text-[#caa875]/80 flex-shrink-0">
                        <svg viewBox="0 0 100 100" fill="none" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="2"/>
                            <text x="50" y="58" font-family="'Fraunces', Georgia, serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                        </svg>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</section>

<style>
/* Hiệu ứng chạy chữ vô tận cho Marquee */
.otr-marquee-content {
    display: flex;
    width: max-content;
    animation: otrMarqueeScroll 28s linear infinite;
}
.otr-marquee-wrapper:hover .otr-marquee-content {
    animation-play-state: paused;
}
@keyframes otrMarqueeScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
</style>
