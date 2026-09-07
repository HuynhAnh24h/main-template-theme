<?php
/**
 * Template Part: Section Loading & Intro Quote (On The Rock)
 * Description: Khối giao diện loader, hiệu ứng quăng ảnh, board ảnh không gian và câu nói thương hiệu nổi trên ảnh.
 * 
 * Arguments ($args):
 * - quote_text (string)
 * - images (array)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

$front_page_id = get_option('page_on_front');

// 1. Cấu hình Câu nói mở đầu (Intro Quote)
$quote_text = ! empty($args['quote_text']) ? $args['quote_text'] : '';
if (empty($quote_text)) {
    $raw_intro = function_exists('get_field') ? get_field('home_intro_quote', $front_page_id) : '';
    if (empty($raw_intro) && function_exists('get_field')) {
        $raw_intro = get_field('home_reveal_title', $front_page_id);
    }
    if (!empty($raw_intro) && strpos($raw_intro, 'Ánh sáng') === false) {
        $clean_intro = preg_replace('/<br\s*\/?>/i', "\n", $raw_intro);
        $quote_text = trim(strip_tags($clean_intro));
    } else {
        $quote_text = "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.";
    }
}

// 2. Cấu hình 10 hình ảnh cho Loading & Moodboard
$images = isset($args['images']) ? $args['images'] : array();
if (empty($images)) {
    $theme_uri = get_template_directory_uri();
    $fallback_images = array(
        $theme_uri . '/assets/images/atmosphere-1.jpg',
        $theme_uri . '/assets/images/atmosphere-2.jpg',
        $theme_uri . '/assets/images/atmosphere-3.jpg',
        $theme_uri . '/assets/images/atmosphere-4.jpg',
        $theme_uri . '/assets/images/atmosphere-5.jpg',
        $theme_uri . '/assets/images/atmosphere-6.jpg',
        $theme_uri . '/assets/images/atmosphere-7.jpg',
        $theme_uri . '/assets/images/atmosphere-8.jpg',
        $theme_uri . '/assets/images/atmosphere-9.jpg',
        'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop'
    );

    for ($i = 1; $i <= 10; $i++) {
        $img_arr = function_exists('get_field') ? get_field('home_reveal_image_' . $i, $front_page_id) : null;
        if (!empty($img_arr) && is_array($img_arr)) {
            $images[] = $img_arr['url'];
        } elseif (!empty($img_arr) && is_string($img_arr)) {
            $images[] = $img_arr;
        } else {
            $images[] = $fallback_images[$i - 1];
        }
    }
}
?>

<!-- 1. Cung cấp dữ liệu hình ảnh cho JS cục bộ -->
<script>
window.WanderConfig = {
    images: <?php echo json_encode($images); ?>
};
</script>

<!-- 2. Khung loading quăng ảnh -->
<div id="loader">
  <div class="frame" id="frame">
    <div id="stackWrap"></div>
    <div class="ring"></div>
    <div class="progress-container">
      <div class="progress-bar" id="progressBar"></div>
    </div>
    <div class="progress-percent" id="pctNum">0%</div>
  </div>
</div>

<!-- 3. Khu vực Moodboard Intro (Màn hình đầu tiên: Ảnh nằm dưới, chữ nổi ở trên) -->
<section id="section-intro" class="relative w-full h-screen overflow-hidden bg-[#080604]">
  <!-- Các hình ảnh nằm bên dưới -->
  <div id="board"></div>
  <div id="wash"></div>

  <!-- Câu chữ nổi lên trên hình ảnh với màu vàng champagne chuẩn mockup -->
  <div id="home-wander" class="relative z-30 h-screen flex flex-col items-center justify-center text-center px-4 sm:px-6 md:px-8 select-none pointer-events-none">
    <div class="otr-quote-box max-w-4xl mx-auto">
      <h1 class="otr-quote-title" style="color: #c2a066 !important; font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;">
        <?php echo nl2br(esc_html($quote_text)); ?>
      </h1>
    </div>
  </div>
</section>
