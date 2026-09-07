<?php
/**
 * Template Part: Section Hero (On The Rocks Cocktail Bar)
 * Description: Khối Hero chính sang trọng kèm Google Review và Marquee Ticker đáy trang.
 * 
 * Arguments ($args):
 * - hero_bg_image (array|string)
 * - hero_title (string)
 * - hero_btn_text (string)
 * - hero_btn_link (string)
 * - hero_btn_style (string)
 * - hero_review_score (string)
 * - hero_review_max (string)
 * - hero_review_title (string)
 * - hero_review_subtitle (string)
 * - hero_review_link (string)
 * - hero_marquee_text (string)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

// 1. Phân giải dữ liệu đầu vào (tự nạp từ ACF nếu không truyền tham số)
$bg_image_raw        = ! empty( $args['hero_bg_image'] ) ? $args['hero_bg_image'] : (function_exists('get_field') ? get_field('hero_bg_image', $front_page_id) : null);
$hero_title          = ! empty( $args['hero_title'] ) ? $args['hero_title'] : (function_exists('get_field') ? (get_field('hero_title', $front_page_id) ?: "BESPEAK YOUR\nBESPOKE COCKTAIL") : "BESPEAK YOUR\nBESPOKE COCKTAIL");
$hero_btn_text       = ! empty( $args['hero_btn_text'] ) ? $args['hero_btn_text'] : (function_exists('get_field') ? (get_field('hero_btn_text', $front_page_id) ?: 'XEM MENU') : 'XEM MENU');

$raw_hero_btn        = ! empty( $args['hero_btn_link'] ) ? $args['hero_btn_link'] : (function_exists('get_field') ? get_field('hero_btn_link', $front_page_id) : '');
$hero_btn_link       = (empty($raw_hero_btn) || in_array($raw_hero_btn, array('#menu', '#', ''))) ? home_url('/menu/') : (function_exists('otr_url') ? otr_url($raw_hero_btn) : $raw_hero_btn);
$hero_btn_style      = ! empty( $args['hero_btn_style'] ) ? $args['hero_btn_style'] : (function_exists('get_field') ? (get_field('hero_btn_style', $front_page_id) ?: 'solid-dark') : 'solid-dark');

$hero_review_score   = ! empty( $args['hero_review_score'] ) ? $args['hero_review_score'] : (function_exists('get_field') ? (get_field('hero_review_score', $front_page_id) ?: '4.7') : '4.7');
$hero_review_max     = ! empty( $args['hero_review_max'] ) ? $args['hero_review_max'] : (function_exists('get_field') ? (get_field('hero_review_max', $front_page_id) ?: '/5') : '/5');
$hero_review_title   = ! empty( $args['hero_review_title'] ) ? $args['hero_review_title'] : (function_exists('get_field') ? (get_field('hero_review_title', $front_page_id) ?: 'Excellent') : 'Excellent');
$hero_review_sub     = ! empty( $args['hero_review_subtitle'] ) ? $args['hero_review_subtitle'] : (function_exists('get_field') ? (get_field('hero_review_subtitle', $front_page_id) ?: 'Based on 3 576 reviews') : 'Based on 3 576 reviews');
$hero_review_link    = ! empty( $args['hero_review_link'] ) ? $args['hero_review_link'] : (function_exists('get_field') ? (get_field('hero_review_link', $front_page_id) ?: '#') : '#');

$hero_marquee_text   = ! empty( $args['hero_marquee_text'] ) ? $args['hero_marquee_text'] : (function_exists('get_field') ? (get_field('hero_marquee_text', $front_page_id) ?: 'ON THE ROCKS COCKTAIL BAR') : 'ON THE ROCKS COCKTAIL BAR');

// Xử lý ảnh nền (có fallback ảnh Unsplash chuẩn quầy bar cocktail nếu chưa cấu hình)
$bg_image_url = 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1920&auto=format&fit=crop';
if ( is_array( $bg_image_raw ) && ! empty( $bg_image_raw['url'] ) ) {
    $bg_image_url = $bg_image_raw['url'];
} elseif ( is_string( $bg_image_raw ) && ! empty( $bg_image_raw ) ) {
    $bg_image_url = $bg_image_raw;
}
?>

<section id="section-hero" class="relative min-h-screen w-full flex flex-col justify-between overflow-hidden bg-black text-[#f4efe8]">
    
    <!-- 1. Ảnh nền Hero Cocktail với lớp phủ điện ảnh (Cinematic Vignette & Subtle Fixed Parallax) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <img src="<?php echo esc_url( $bg_image_url ); ?>" 
             alt="On The Rocks Bar Background" 
             class="hero-bg-parallax w-full h-[125%] -top-[12%] absolute object-cover object-center filter brightness-[0.78]">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/35 to-black/60 pointer-events-none"></div>
        <div class="absolute inset-0 bg-radial from-transparent via-black/20 to-black/70 pointer-events-none"></div>
    </div>

    <!-- 2. Nội dung chính giữa màn hình (Title bên trái, Đánh giá Google bên phải) -->
    <div class="relative z-10 flex-1 flex items-center px-4 sm:px-10 md:px-16 lg:px-20 pt-24 sm:pt-28 md:pt-36 pb-10 sm:pb-12">
        <div class="max-w-7xl w-full mx-auto flex flex-col lg:flex-row lg:items-center justify-between gap-10 sm:gap-12">
            
            <!-- Cột bên trái: Tiêu đề Hero & Nút Xem Menu -->
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl sm:text-6xl md:text-7xl lg:text-8xl xl:text-[88px] font-normal tracking-wide text-[#caa875] leading-[1.06] uppercase drop-shadow-md">
                    <?php echo nl2br( esc_html( $hero_title ) ); ?>
                </h1>

                <div class="mt-8 sm:mt-10">
                    <?php
                    get_template_part( 'template-parts/components/button', null, array(
                        'text'        => $hero_btn_text,
                        'link'        => $hero_btn_link,
                        'style'       => $hero_btn_style,
                        'extra_class' => '!px-8 !py-3.5 !text-xs !tracking-[0.18em] shadow-2xl',
                    ) );
                    ?>
                </div>
            </div>

            <!-- Cột bên phải: Thẻ đánh giá Google (Google Review Card) -->
            <div class="w-full sm:w-auto self-start lg:self-center">
                <a href="<?php echo esc_url( $hero_review_link ); ?>" target="_blank" rel="noopener noreferrer" class="block group">
                    <div class="w-full sm:w-[320px] md:w-[340px] bg-[#d7cdbd] text-[#28211b] p-5 md:p-6 rounded-md shadow-2xl transition-transform duration-300 group-hover:-translate-y-1">
                        
                        <!-- Hàng trên: 5 sao vàng cam & Logo Google đa sắc -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1 text-[#e89c38] text-base select-none">
                                <span>★</span>
                                <span>★</span>
                                <span>★</span>
                                <span>★</span>
                                <span>★</span>
                            </div>
                            
                            <!-- Google G Logo SVG -->
                            <div class="w-5 h-5">
                                <svg viewBox="0 0 24 24" class="w-full h-full">
                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.17 0 9.99 0 12s.45 3.83 1.25 5.42l4.03-3.15z"/>
                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Hàng dưới: Điểm số 4.7/5 & Chữ Excellent / Based on reviews -->
                        <div class="mt-3 flex items-baseline justify-between gap-4">
                            <div class="flex items-baseline font-serif">
                                <span class="text-4xl md:text-5xl font-bold tracking-tight text-[#28211b]"><?php echo esc_html( $hero_review_score ); ?></span>
                                <span class="text-xs font-semibold text-[#5a4d3f] ml-0.5"><?php echo esc_html( $hero_review_max ); ?></span>
                            </div>

                            <div class="text-right">
                                <div class="font-bold text-xs md:text-sm text-[#28211b]"><?php echo esc_html( $hero_review_title ); ?></div>
                                <div class="text-[10px] md:text-xs text-[#5a4d3f] mt-0.5"><?php echo esc_html( $hero_review_sub ); ?></div>
                            </div>
                        </div>

                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- 3. Đáy Section: Dải chữ Marquee chạy ngang vô tận (Continuous Infinite Ticker) -->
    <div class="relative z-10 w-full bg-black border-t border-[#caa875]/25 py-3 md:py-4 overflow-hidden select-none">
        <div class="ticker-wrapper flex overflow-hidden">
            <div class="ticker-content flex shrink-0 items-center animate-marquee">
                <?php for ( $j = 0; $j < 8; $j++ ) : ?>
                    <span class="font-serif text-xs md:text-sm tracking-[0.25em] text-[#caa875] uppercase px-4 whitespace-nowrap">
                        <?php echo esc_html( $hero_marquee_text ); ?>
                    </span>
                    <span class="text-[#caa875] px-2 text-xs opacity-70">✦</span>
                <?php endfor; ?>
            </div>
            <!-- Nhân bản track thứ 2 để chạy tiếp nối không vết cắt (Seamless Infinite Loop) -->
            <div class="ticker-content flex shrink-0 items-center animate-marquee" aria-hidden="true">
                <?php for ( $j = 0; $j < 8; $j++ ) : ?>
                    <span class="font-serif text-xs md:text-sm tracking-[0.25em] text-[#caa875] uppercase px-4 whitespace-nowrap">
                        <?php echo esc_html( $hero_marquee_text ); ?>
                    </span>
                    <span class="text-[#caa875] px-2 text-xs opacity-70">✦</span>
                <?php endfor; ?>
            </div>
        </div>
    </div>

</section>
