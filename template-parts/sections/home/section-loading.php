<?php
/**
 * Template Part: Section Loading & Intro Quote (On The Rock)
 * Description: Khối giao diện loader, hiệu ứng quăng ảnh, board ảnh không gian và câu nói thương hiệu nổi trên ảnh.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

// Nhận dữ liệu truyền từ front-page.php
$quote_text = ! empty($args['quote_text']) ? $args['quote_text'] : '';
if (empty($quote_text)) {
    $quote_text = "Một quán cocktail bar ở Đà Lạt,\ncủa người Đà Lạt, dành cho những ai\nmuốn một trãi nghiệm Đà Lạt thú vị.";
}

$images = isset($args['images']) ? $args['images'] : array();
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
