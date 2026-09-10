<?php
/**
 * Template Part: Section Loading & Intro (On The Rock)
 * Description: Khối hoạt ảnh Loading 4 giai đoạn chuẩn mockup:
 * - Giai đoạn 1: Logo OTR trung tâm trên nền nâu #472b08
 * - Giai đoạn 2: Quăng 10 xấp ảnh vào giữa + Thanh tiến trình & % đếm
 * - Giai đoạn 3: Bung tỏa 10 ảnh ra viền màn hình + Logo OTR ở tâm điểm
 * - Giai đoạn 4: Màn nhung đen, Header cố định & Câu slogan thương hiệu phông MRCH-NewYork
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

// 1. Cấu hình Câu nói mở đầu Giai đoạn 4 (Intro Quote)
$quote_text = ! empty($args['quote_text']) ? $args['quote_text'] : '';
if (empty($quote_text)) {
    $fallback_default = function_exists('otr_t') ? otr_t("Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.", "A cocktail bar in Da Lat,\ncrafted by locals, for those seeking\nan authentic Da Lat experience.") : "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.";
    $raw_intro = function_exists('otr_get_field') ? otr_get_field('home_intro_quote', $front_page_id, $fallback_default) : (function_exists('get_field') ? get_field('home_intro_quote', $front_page_id) : '');
    if (empty($raw_intro) && function_exists('otr_get_field')) {
        $raw_intro = otr_get_field('home_reveal_title', $front_page_id);
    }
    if (!empty($raw_intro) && strpos($raw_intro, 'Ánh sáng') === false) {
        $clean_intro = preg_replace('/<br\s*\/?>/i', "\n", $raw_intro);
        $quote_text = trim(strip_tags($clean_intro));
    } else {
        $quote_text = $fallback_default;
    }
}

// 2. Logo Monogram OTR cho Giai đoạn 1 & Giai đoạn 3
$header_logo = function_exists('get_field') ? get_field('header_logo', $front_page_id) : null;
$logo_url = '';
if (is_array($header_logo) && !empty($header_logo['url'])) {
    $logo_url = $header_logo['url'];
} elseif (is_string($header_logo) && !empty($header_logo)) {
    $logo_url = $header_logo;
} else {
    $logo_url = get_template_directory_uri() . '/assets/images/otr-logo-gold.png';
}

// 3. Cấu hình 10 hình ảnh từ ACF (home_reveal_image_1 -> 10), fallback ảnh chuẩn thiết kế
$images = isset($args['images']) ? $args['images'] : array();
if (empty($images)) {
    $theme_uri = get_template_directory_uri();
    $fallback_images = array(
        $theme_uri . '/assets/images/loading-1.jpg',
        $theme_uri . '/assets/images/loading-2.jpg',
        $theme_uri . '/assets/images/loading-3.jpg',
        $theme_uri . '/assets/images/loading-4.jpg',
        $theme_uri . '/assets/images/loading-5.jpg',
        $theme_uri . '/assets/images/loading-6.jpg',
        $theme_uri . '/assets/images/loading-7.jpg',
        $theme_uri . '/assets/images/loading-8.jpg',
        $theme_uri . '/assets/images/loading-9.jpg',
        $theme_uri . '/assets/images/loading-10.jpg',
    );

    for ($i = 1; $i <= 10; $i++) {
        $img_arr = function_exists('get_field') ? get_field('home_reveal_image_' . $i, $front_page_id) : null;
        $chosen_url = '';

        if (!empty($img_arr) && is_array($img_arr) && !empty($img_arr['url'])) {
            if (strpos($img_arr['url'], 'test-image.jpg') === false) {
                $chosen_url = $img_arr['url'];
            }
        } elseif (!empty($img_arr) && is_string($img_arr) && !empty($img_arr)) {
            if (strpos($img_arr, 'test-image.jpg') === false) {
                $chosen_url = $img_arr;
            }
        }

        if (empty($chosen_url)) {
            $chosen_url = $fallback_images[$i - 1];
        }

        $images[] = $chosen_url;
    }
}
?>

<!-- Dữ liệu truyền sang JavaScript -->
<script>
window.WanderConfig = {
    images: <?php echo json_encode($images); ?>,
    logo: "<?php echo esc_url($logo_url); ?>"
};
</script>

<!-- ================= 4-STAGE LOADING OVERLAY ================= -->
<div id="loader" class="fixed inset-0 z-[100000] w-full h-full bg-[#472b08] flex items-center justify-center overflow-hidden select-none pointer-events-none">
    
    <!-- GIAI ĐOẠN 1: Logo OTR Trung Tâm (Chuẩn Header Logo, sắc nét tuyệt đối, không bể hình) -->
    <div id="loader-stage1" class="absolute inset-0 flex items-center justify-center pointer-events-none z-30 transition-all duration-1000 ease-out">
        <img 
            src="<?php echo esc_url($logo_url); ?>" 
            alt="On The Rocks Bar Logo" 
            class="h-10 sm:h-12 md:h-14 w-auto object-contain select-none transform transition-transform duration-1000 ease-out drop-shadow-sm"
        >
    </div>

    <!-- GIAI ĐOẠN 2: Xấp Ảnh Quăng Vào + Thanh Tiến Trình & % (Hình 2) -->
    <div id="loader-stage2" class="absolute inset-0 flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-700 ease-out z-25">
        <!-- Khung xấp bài trung tâm -->
        <div id="stackWrap" class="relative w-[165px] sm:w-[185px] md:w-[205px] h-[230px] sm:h-[260px] md:h-[290px]"></div>
        
        <!-- Thanh tiến trình & số % -->
        <div id="loader-progress-wrap" class="mt-8 sm:mt-9 flex flex-col items-center gap-2.5 transition-opacity duration-500">
            <div class="w-40 sm:w-48 h-[2.5px] bg-[#2a1a05] rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-[#caa875] w-0 rounded-full"></div>
            </div>
            <span id="pctNum" class="text-[12px] sm:text-xs font-sans font-medium text-[#caa875] tracking-[0.22em]">0%</span>
        </div>
    </div>

    <!-- GIAI ĐOẠN 3: Logo OTR Trung Tâm (Hình 3) -->
    <div id="loader-stage3-logo" class="absolute inset-0 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-1000 ease-out z-20">
        <img 
            src="<?php echo esc_url($logo_url); ?>" 
            alt="On The Rocks Bar Logo" 
            class="w-16 sm:w-20 md:w-24 lg:w-28 h-auto object-contain select-none"
        >
    </div>

</div>

<!-- ================= GIAI ĐOẠN 4 & MOODBOARD INTRO SECTION ================= -->
<section id="section-intro" class="relative w-full h-screen overflow-hidden bg-[#070504] flex items-center justify-center select-none">
    
    <!-- 1. Lớp nền nhung đen cao cấp (Hiện ở Stage 4) -->
    <div 
        id="intro-velvet-bg"
        class="absolute inset-0 bg-cover bg-center pointer-events-none z-0" 
        style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/black-velvet-bg.jpg'); ?>'); opacity: 0.75;"
    ></div>

    <!-- 2. Lớp nền nâu cà phê ấm #472b08 (Stage 1, 2, 3 - mờ dần khi sang Stage 4) -->
    <div id="intro-brown-bg" class="absolute inset-0 bg-[#472b08] pointer-events-none z-1"></div>

    <!-- 3. Board chứa 10 bức ảnh (Bung ra ở Stage 3 và Ở LẠI LÀM NỀN CHO STAGE 4!) -->
    <div id="board" class="absolute inset-0 w-full h-full pointer-events-none z-2 overflow-hidden"></div>

    <!-- 4. Lớp phủ Vignette / Wash làm dịu trung tâm để tôn câu Slogan -->
    <div id="intro-wash" class="absolute inset-0 bg-radial-[at_center_center] from-[#070504]/82 via-[#070504]/50 to-transparent pointer-events-none z-3 opacity-0"></div>

    <!-- 5. Câu châm ngôn / Slogan thương hiệu với Font MRCH-NewYork (Chậm rãi, siêu mượt) -->
    <div id="home-quote" class="relative z-10 max-w-4xl mx-auto px-6 sm:px-8 text-center select-none">
        <h1 class="MRCH-NewYork text-2xl sm:text-3xl md:text-4xl lg:text-[42px] leading-[1.45] sm:leading-[1.5] text-[#caa875] tracking-wide font-normal">
            <?php echo nl2br(esc_html($quote_text)); ?>
        </h1>
    </div>

</section>
