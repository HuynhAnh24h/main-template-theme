<?php
/**
 * Template Part: Section Moments (@ONTHEROCK Gallery)
 * Description: Khối khoảnh khắc tràn viền 100% hỗ trợ cả hình ảnh và video dọc (vertical video),
 * kèm thanh tiêu đề mạng xã hội và huy hiệu nghệ thuật "THE BAR is where STORIES BEGIN".
 * 
 * Arguments ($args):
 * - title_1 (string)
 * - title_2 (string)
 * - instagram_url (string)
 * - facebook_url (string)
 * - items (array of 4 items with type, image, video, badge)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

$title_1       = ! empty( $args['title_1'] ) ? $args['title_1'] : (function_exists('otr_get_field') ? otr_get_field('moments_title_1', $front_page_id, function_exists('otr_t') ? otr_t('THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC', 'SAVOR, CAPTURE THE MOMENT') : 'SAVOR, CAPTURE THE MOMENT') : 'THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC');
$title_2       = ! empty( $args['title_2'] ) ? $args['title_2'] : (function_exists('otr_get_field') ? otr_get_field('moments_title_2', $front_page_id, function_exists('otr_t') ? otr_t('VÀ GẮN THẺ @ONTHEROCK.', 'AND TAG @ONTHEROCK.') : 'AND TAG @ONTHEROCK.') : 'VÀ GẮN THẺ @ONTHEROCK.');
$instagram_url = ! empty( $args['instagram_url'] ) ? $args['instagram_url'] : (function_exists('get_field') ? (get_field('moments_instagram_url', $front_page_id) ?: 'https://instagram.com') : 'https://instagram.com');
$facebook_url  = ! empty( $args['facebook_url'] ) ? $args['facebook_url'] : (function_exists('get_field') ? (get_field('moments_facebook_url', $front_page_id) ?: 'https://facebook.com') : 'https://facebook.com');
$items         = ! empty( $args['items'] ) ? $args['items'] : array();

$fallback_moments_media = array(
    1 => array('image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
    2 => array('image' => 'https://images.unsplash.com/photo-1543007630-9710e4a00a20?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
    3 => array('image' => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop', 'badge' => 'THE BAR is where STORIES BEGIN'),
    4 => array('image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1000&auto=format&fit=crop', 'badge' => ''),
);

if ( empty( $items ) && function_exists('get_field') ) {
    for ($i = 1; $i <= 4; $i++) {
        $m_type  = get_field('moments_media_type_' . $i, $front_page_id) ?: 'image';
        $m_img   = get_field('moments_image_' . $i, $front_page_id);
        $m_vid   = get_field('moments_video_' . $i, $front_page_id);
        $m_badge = get_field('moments_badge_' . $i, $front_page_id);
        if ($m_badge === null || $m_badge === '') {
            $m_badge = isset($fallback_moments_media[$i]['badge']) ? $fallback_moments_media[$i]['badge'] : '';
        }

        $img_url = (!empty($m_img) && is_array($m_img)) ? $m_img['url'] : (is_string($m_img) && !empty($m_img) ? $m_img : $fallback_moments_media[$i]['image']);

        $items[] = array(
            'type'  => $m_type,
            'image' => $img_url,
            'video' => $m_vid ?: '',
            'badge' => $m_badge,
        );
    }
}

// Dữ liệu mẫu chuẩn ảnh thiết kế nếu chưa tải ảnh/video trong ACF
if ( empty( $items ) ) {
    foreach ($fallback_moments_media as $f_item) {
        $items[] = array(
            'type'  => 'image',
            'image' => $f_item['image'],
            'video' => '',
            'badge' => $f_item['badge'],
        );
    }
}
?>

<section id="section-moments" class="relative w-full bg-[#080604] pt-20 md:pt-28 pb-0 overflow-hidden text-[#f4efe8]">
    
    <!-- 1. Thanh Tiêu Đề & Mạng Xã Hội (Nằm trong container chuẩn) -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 md:px-16 mb-10 md:mb-14">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
            
            <!-- Tiêu đề 2 dòng màu vàng kim: Font SVN-Gilroy chuẩn thiết kế -->
            <div class="font-sans text-base sm:text-lg md:text-xl lg:text-2xl tracking-[0.2em] text-[#caa875] uppercase leading-relaxed font-light select-none">
                <div><?php echo esc_html( $title_1 ); ?></div>
                <div><?php echo esc_html( $title_2 ); ?></div>
            </div>

            <!-- Các liên kết Mạng Xã Hội -->
            <div class="flex items-center gap-6 md:gap-8 shrink-0 pb-1 font-sans">
                <?php if ( ! empty( $instagram_url ) ) : ?>
                    <a href="<?php echo esc_url( $instagram_url ); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="font-sans text-sm md:text-base tracking-[0.22em] text-[#caa875] underline underline-offset-4 hover:text-[#e8cda2] transition-colors duration-300 uppercase">
                        INSTAGRAM
                    </a>
                <?php endif; ?>

                <?php if ( ! empty( $facebook_url ) ) : ?>
                    <a href="<?php echo esc_url( $facebook_url ); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="font-sans text-sm md:text-base tracking-[0.22em] text-[#caa875] underline underline-offset-4 hover:text-[#e8cda2] transition-colors duration-300 uppercase">
                        FACEBOOK
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- 2. Thư Viện Ảnh & Video Dọc TRÀN VIỀN 100% (Edge-to-Edge) -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-0">
        <?php foreach ( $items as $idx => $media ) : ?>
            <div class="relative w-full h-[480px] sm:h-[560px] md:h-[640px] lg:h-[720px] overflow-hidden group cursor-pointer bg-[#0e0a07]">
                
                <?php if ( $media['type'] === 'video' && ! empty( $media['video'] ) ) : ?>
                    <!-- Hiển thị Video dọc tự động phát lặp mượt mà -->
                    <video autoplay loop muted playsinline data-parallax
                           class="w-full h-full object-cover object-center filter brightness-[0.88] group-hover:brightness-100 group-hover:scale-105 transition-all duration-700 ease-out">
                        <source src="<?php echo esc_url( $media['video'] ); ?>" type="video/mp4">
                    </video>
                <?php else : ?>
                    <!-- Hiển thị Hình ảnh dọc chất lượng cao -->
                    <img src="<?php echo esc_url( $media['image'] ); ?>" 
                         alt="On The Rocks Moments <?php echo esc_attr( $idx + 1 ); ?>" 
                         data-parallax
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover object-center filter brightness-[0.88] group-hover:brightness-100 group-hover:scale-105 transition-all duration-700 ease-out">
                <?php endif; ?>

                <!-- Lớp phủ điện ảnh làm dịu màu -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none group-hover:opacity-30 transition-opacity duration-500"></div>

                <!-- Huy hiệu chữ nghệ thuật "THE BAR is where STORIES BEGIN" (cho cột 3 hoặc mục có badge) -->
                <?php if ( ! empty( $media['badge'] ) ) : ?>
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center pointer-events-none z-10 select-none">
                        <div class="text-white drop-shadow-[0_4px_20px_rgba(0,0,0,0.95)]">
                            <div class="font-serif text-2xl sm:text-3xl lg:text-[34px] tracking-[0.22em] font-normal uppercase leading-tight">
                                THE BAR
                            </div>
                            <div class="font-serif italic text-xs sm:text-sm tracking-[0.25em] text-[#f4efe8]/90 my-1 font-light">
                                is where
                            </div>
                            <div class="font-serif text-lg sm:text-xl lg:text-[22px] tracking-[0.24em] font-normal uppercase leading-tight">
                                STORIES BEGIN
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

</section>
