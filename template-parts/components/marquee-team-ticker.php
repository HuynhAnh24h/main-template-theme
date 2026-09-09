<?php
/**
 * Component: Marquee Team Ticker ("MEET THE ON THE ROCK TEAM")
 * Description: Dải chữ chạy ngang vô tận chuẩn thương hiệu On The Rock nằm ngay trên Footer.
 *              Đảm bảo xuất hiện đồng bộ trên tất cả các trang con và không bị trùng lặp.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Ngăn trùng lặp nếu trang đã tự nhúng trước đó
global $otr_marquee_ticker_rendered;
if ( ! empty( $otr_marquee_ticker_rendered ) ) {
    return;
}
$otr_marquee_ticker_rendered = true;

$front_page_id = get_option('page_on_front');
$marquee_text  = function_exists('get_field') ? get_field('team_marquee_text', $front_page_id) : '';
if (empty($marquee_text)) {
    $marquee_text = 'MEET THE ON THE ROCK TEAM';
}

$icon_url = get_template_directory_uri() . '/assets/images/otr-monogram-icon.png';
?>

<!-- Dải Marquee Chạy Chữ Vô Tận Trước Footer ("MEET THE ON THE ROCK TEAM") -->
<div class="ticker-wrapper w-full overflow-hidden whitespace-nowrap bg-black py-4 md:py-6 border-t border-b border-dashed border-[#caa875]/25 select-none flex">
    <!-- Track 1 -->
    <div class="flex shrink-0 items-center animate-marquee">
        <?php for ( $k = 0; $k < 6; $k++ ) : ?>
            <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                <?php echo esc_html( $marquee_text ); ?>
            </span>
            <img src="<?php echo esc_url( $icon_url ); ?>" alt="OTR Icon" class="w-6 h-6 md:w-8 md:h-8 object-contain shrink-0 inline-block opacity-90 mx-3 md:mx-4">
        <?php endfor; ?>
    </div>

    <!-- Track 2 (Clone nối tiếp để chạy vô tận 100% liền mạch) -->
    <div class="flex shrink-0 items-center animate-marquee" aria-hidden="true">
        <?php for ( $k = 0; $k < 6; $k++ ) : ?>
            <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                <?php echo esc_html( $marquee_text ); ?>
            </span>
            <img src="<?php echo esc_url( $icon_url ); ?>" alt="OTR Icon" class="w-6 h-6 md:w-8 md:h-8 object-contain shrink-0 inline-block opacity-90 mx-3 md:mx-4">
        <?php endfor; ?>
    </div>
</div>

<style>
@keyframes marquee {
  0% { transform: translate3d(0, 0, 0); }
  100% { transform: translate3d(-100%, 0, 0); }
}
.animate-marquee {
  display: flex !important;
  flex-shrink: 0 !important;
  will-change: transform;
  animation: marquee 35s linear infinite !important;
}
.ticker-wrapper:hover .animate-marquee {
  animation-play-state: paused;
}
</style>
