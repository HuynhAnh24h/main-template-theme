<?php
/**
 * Component: Site Footer (On The Rock)
 * Description: Chân trang phong cách Cocktail Bar với tone màu hổ phách, 4 cột thông tin và chữ thương hiệu khổng lồ.
 * 
 * Arguments ($args): Có thể truyền từ ngoài vào hoặc tự động lấy từ ACF Trang chủ tĩnh.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

// 1. Cột 1: Danh mục
$col1_title   = ! empty( $args['col1_title'] )   ? $args['col1_title']   : ( function_exists('otr_get_field') ? otr_get_field( 'footer_col1_title', $front_page_id, function_exists('otr_t') ? otr_t('DANH MỤC', 'NAVIGATION') : 'DANH MỤC' ) : 'DANH MỤC' );
$menu_text    = ! empty( $args['menu_text'] )    ? $args['menu_text']    : ( function_exists('otr_get_field') ? otr_get_field( 'footer_menu_text', $front_page_id, function_exists('otr_t') ? otr_t('TRANG MENU', 'MENU') : 'TRANG MENU' ) : 'TRANG MENU' );
$raw_footer_menu = ! empty( $args['menu_url'] ) ? $args['menu_url'] : get_field( 'footer_menu_url', $front_page_id );
if (empty($raw_footer_menu) || in_array($raw_footer_menu, array('#menu', '#', ''))) {
    $menu_url = home_url('/menu/');
} else {
    $menu_url = function_exists('otr_url') ? otr_url($raw_footer_menu) : ((strpos($raw_footer_menu, 'http') === 0) ? $raw_footer_menu : home_url('/' . ltrim($raw_footer_menu, '/')));
}

$contact_text = ! empty( $args['contact_text'] ) ? $args['contact_text'] : ( function_exists('otr_get_field') ? otr_get_field( 'footer_contact_text', $front_page_id, function_exists('otr_t') ? otr_t('TRANG LIÊN HỆ', 'CONTACT') : 'TRANG LIÊN HỆ' ) : 'TRANG LIÊN HỆ' );
$raw_footer_contact = ! empty( $args['contact_url'] ) ? $args['contact_url'] : get_field( 'footer_contact_url', $front_page_id );
if (empty($raw_footer_contact) || in_array($raw_footer_contact, array('#contact', '#', ''))) {
    $contact_url = home_url('/contact/');
} else {
    $contact_url = function_exists('otr_url') ? otr_url($raw_footer_contact) : ((strpos($raw_footer_contact, 'http') === 0) ? $raw_footer_contact : home_url('/' . ltrim($raw_footer_contact, '/')));
}

$booking_text = ! empty( $args['booking_text'] ) ? $args['booking_text'] : ( function_exists('otr_get_field') ? otr_get_field( 'footer_booking_text', $front_page_id, function_exists('otr_t') ? otr_t('ĐẶT BÀN TRƯỚC', 'RESERVATION') : 'ĐẶT BÀN TRƯỚC' ) : 'ĐẶT BÀN TRƯỚC' );
$raw_footer_booking = ! empty( $args['booking_url'] ) ? $args['booking_url'] : get_field( 'footer_booking_url', $front_page_id );
if (empty($raw_footer_booking) || in_array($raw_footer_booking, array('#book', '#booking', '#', ''))) {
    $booking_url = home_url('/booking/');
} else {
    $booking_url = function_exists('otr_url') ? otr_url($raw_footer_booking) : ((strpos($raw_footer_booking, 'http') === 0) ? $raw_footer_booking : home_url('/' . ltrim($raw_footer_booking, '/')));
}

// 2. Cột 2: Mạng xã hội
$col2_title     = ! empty( $args['col2_title'] )     ? $args['col2_title']     : ( function_exists('otr_get_field') ? otr_get_field( 'footer_col2_title', $front_page_id, function_exists('otr_t') ? otr_t('MẠNG XÃ HỘI', 'SOCIAL MEDIA') : 'MẠNG XÃ HỘI' ) : 'MẠNG XÃ HỘI' );
$facebook_text  = ! empty( $args['facebook_text'] )  ? $args['facebook_text']  : ( get_field( 'footer_facebook_text', $front_page_id ) ?: 'FACEBOOK' );
$raw_fb = ! empty( $args['facebook_url'] ) ? $args['facebook_url'] : get_field( 'footer_facebook_url', $front_page_id );
if (empty($raw_fb) || in_array(rtrim($raw_fb, '/'), array('https://facebook.com', 'http://facebook.com', '#', ''))) {
    $facebook_url = 'https://facebook.com/ontherock.dalat';
} else {
    $facebook_url = $raw_fb;
}

$instagram_text = ! empty( $args['instagram_text'] ) ? $args['instagram_text'] : ( get_field( 'footer_instagram_text', $front_page_id ) ?: 'INSTAGRAM' );
$raw_insta = ! empty( $args['instagram_url'] ) ? $args['instagram_url'] : get_field( 'footer_instagram_url', $front_page_id );
if (empty($raw_insta) || in_array(rtrim($raw_insta, '/'), array('https://instagram.com', 'http://instagram.com', '#', ''))) {
    $instagram_url = 'https://instagram.com/ontherock.dalat';
} else {
    $instagram_url = $raw_insta;
}

$tiktok_text    = ! empty( $args['tiktok_text'] )    ? $args['tiktok_text']    : ( get_field( 'footer_tiktok_text', $front_page_id ) ?: 'TIKTOK' );
$raw_tiktok = ! empty( $args['tiktok_url'] ) ? $args['tiktok_url'] : get_field( 'footer_tiktok_url', $front_page_id );
if (empty($raw_tiktok) || in_array(rtrim($raw_tiktok, '/'), array('https://tiktok.com', 'http://tiktok.com', '#', ''))) {
    $tiktok_url = 'https://tiktok.com/@ontherock.dalat';
} else {
    $tiktok_url = $raw_tiktok;
}

// 3. Cột 3: Đến và trải nghiệm
$col3_title     = ! empty( $args['col3_title'] )     ? $args['col3_title']     : ( function_exists('otr_get_field') ? otr_get_field( 'footer_col3_title', $front_page_id, function_exists('otr_t') ? otr_t('ĐẾN VÀ TRẢI NGHIỆM', 'VISIT & EXPERIENCE') : 'ĐẾN VÀ TRẢI NGHIỆM' ) : 'ĐẾN VÀ TRẢI NGHIỆM' );
$hours_days     = ! empty( $args['hours_days'] )     ? $args['hours_days']     : ( function_exists('otr_get_field') ? otr_get_field( 'footer_hours_days', $front_page_id, function_exists('otr_t') ? otr_t('THỨ HAI – CHỦ NHẬT', 'MONDAY – SUNDAY') : 'THỨ HAI – CHỦ NHẬT' ) : 'THỨ HAI – CHỦ NHẬT' );
$hours_time     = ! empty( $args['hours_time'] )     ? $args['hours_time']     : ( function_exists('otr_get_field') ? otr_get_field( 'footer_hours_time', $front_page_id, function_exists('otr_t') ? otr_t('18H30 – 2H', '6:30 PM – 2:00 AM') : '18H30 – 2H' ) : '18H30 – 2H' );
$address_line1  = ! empty( $args['address_line1'] )  ? $args['address_line1']  : ( function_exists('otr_get_field') ? otr_get_field( 'footer_address_line1', $front_page_id, function_exists('otr_t') ? otr_t('TẦNG HẦM 69', 'BASEMENT 69') : 'TẦNG HẦM 69' ) : 'TẦNG HẦM 69' );
$address_line2  = ! empty( $args['address_line2'] )  ? $args['address_line2']  : ( function_exists('otr_get_field') ? otr_get_field( 'footer_address_line2', $front_page_id, function_exists('otr_t') ? otr_t('TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT', 'TRUONG CONG DINH, WARD 01, DA LAT') : 'TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT' ) : 'TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT' );
$raw_maps = ! empty( $args['maps_url'] ) ? $args['maps_url'] : get_field( 'footer_maps_url', $front_page_id );
if (empty($raw_maps) || $raw_maps === '#') {
    $maps_url = 'https://maps.google.com/?q=69+Trương+Công+Định,+Phường+1,+Đà+Lạt';
} else {
    $maps_url = $raw_maps;
}

// 4. Cột 4: Liên hệ
$col4_title = ! empty( $args['col4_title'] ) ? $args['col4_title'] : ( function_exists('otr_get_field') ? otr_get_field( 'footer_col4_title', $front_page_id, function_exists('otr_t') ? otr_t('LIÊN HỆ', 'CONTACT US') : 'LIÊN HỆ' ) : 'LIÊN HỆ' );
$email      = ! empty( $args['email'] )      ? $args['email']      : ( get_field( 'footer_email', $front_page_id ) ?: 'ONTHEROCK@GMAIL.COM' );
$phone      = ! empty( $args['phone'] )      ? $args['phone']      : ( get_field( 'footer_phone', $front_page_id ) ?: '070 297 0268' );

// 5. Thương hiệu & Bản quyền
$brand_title = ! empty( $args['brand_title'] ) ? $args['brand_title'] : ( get_field( 'footer_brand_title', $front_page_id ) ?: 'ON THE ROCK' );
$copyright   = ! empty( $args['copyright'] )   ? $args['copyright']   : ( function_exists('otr_get_field') ? otr_get_field( 'footer_copyright', $front_page_id, '@2026 ON THE ROCK' ) : '@2026 ON THE ROCK' );
?>

<footer id="site-footer" class="w-full bg-[#36230d] text-[#caa875] pt-16 md:pt-24 pb-8 overflow-hidden font-sans select-none">
    
    <!-- 1. KHỐI 4 CỘT THÔNG TIN: Giới hạn trong container tiêu chuẩn để căn chỉnh thẳng hàng, dễ đọc -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 md:px-14 lg:px-16 mb-14 md:mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 lg:gap-12">
            
            <!-- Cột 1: DANH MỤC -->
            <div>
                <h4 class="text-[#caa875]/60 text-[11px] md:text-xs font-semibold tracking-[0.22em] uppercase mb-4 md:mb-5 font-sans">
                    <?php echo esc_html( $col1_title ); ?>
                </h4>
                <nav class="flex flex-col gap-2.5 md:gap-3 text-xs md:text-sm tracking-[0.08em] uppercase font-light font-sans">
                    <a href="<?php echo esc_url( $menu_url ); ?>" class="hover:text-white hover:translate-x-1.5 transition-all duration-300 w-fit inline-block">
                        <?php echo esc_html( $menu_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-white hover:translate-x-1.5 transition-all duration-300 w-fit inline-block">
                        BLOG &amp; EVENT
                    </a>
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="hover:text-white hover:translate-x-1.5 transition-all duration-300 w-fit inline-block">
                        <?php echo esc_html( $contact_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="hover:text-white hover:translate-x-1.5 transition-all duration-300 w-fit inline-block">
                        <?php echo esc_html( $booking_text ); ?>
                    </a>
                </nav>
            </div>

            <!-- Cột 2: MẠNG XÃ HỘI -->
            <div>
                <h4 class="text-[#caa875]/60 text-[11px] md:text-xs font-semibold tracking-[0.22em] uppercase mb-4 md:mb-5 font-sans">
                    <?php echo esc_html( $col2_title ); ?>
                </h4>
                <div class="flex flex-col gap-2.5 md:gap-3 text-xs md:text-sm tracking-[0.08em] uppercase font-light font-sans">
                    <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit">
                        <?php echo esc_html( $facebook_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit">
                        <?php echo esc_html( $instagram_text ); ?>
                    </a>
                    <a href="<?php echo esc_url( $tiktok_url ); ?>" target="_blank" rel="noopener noreferrer" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit">
                        <?php echo esc_html( $tiktok_text ); ?>
                    </a>
                </div>
            </div>

            <!-- Cột 3: ĐẾN VÀ TRẢI NGHIỆM -->
            <div>
                <h4 class="text-[#caa875]/60 text-[11px] md:text-xs font-semibold tracking-[0.22em] uppercase mb-4 md:mb-5 font-sans">
                    <?php echo esc_html( $col3_title ); ?>
                </h4>
                <div class="flex flex-col gap-2.5 md:gap-3 text-xs md:text-sm tracking-[0.08em] uppercase font-light font-sans">
                    <p class="leading-relaxed">
                        <?php echo esc_html( $hours_days ); ?>
                    </p>
                    <p class="leading-relaxed">
                        <?php echo esc_html( $hours_time ); ?>
                    </p>
                    <div class="pt-1 flex flex-col gap-1.5">
                        <a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit leading-relaxed">
                            <?php echo esc_html( $address_line1 ); ?>
                        </a>
                        <a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit leading-relaxed">
                            <?php echo esc_html( $address_line2 ); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cột 4: LIÊN HỆ -->
            <div>
                <h4 class="text-[#caa875]/60 text-[11px] md:text-xs font-semibold tracking-[0.22em] uppercase mb-4 md:mb-5 font-sans">
                    <?php echo esc_html( $col4_title ); ?>
                </h4>
                <div class="flex flex-col gap-2.5 md:gap-3 text-xs md:text-sm tracking-[0.08em] uppercase font-light font-sans">
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit">
                        <?php echo esc_html( $email ); ?>
                    </a>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="underline underline-offset-[5px] decoration-1 decoration-[#caa875]/50 hover:decoration-white hover:text-white transition-all duration-300 w-fit tracking-[0.08em]">
                        <?php echo esc_html( $phone ); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. CHỮ THƯƠNG HIỆU KHỔNG LỒ: TRÀN TOÀN BỘ MÀN HÌNH (Full Width Edge-to-Edge) -->
    <div class="w-full overflow-hidden select-none px-3 sm:px-6 md:px-8 mb-6 sm:mb-8 md:mb-10 text-center">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block transition-opacity duration-300 hover:opacity-85 cursor-pointer" title="<?php echo esc_attr( $brand_title ); ?>">
            <h2 class="footer-brand-title w-full block font-mrch font-normal text-[#caa875] uppercase leading-[0.88] tracking-[0.03em] sm:tracking-[0.05em] text-[11.5vw] whitespace-nowrap">
                <?php echo esc_html( $brand_title ); ?>
            </h2>
        </a>
    </div>

    <!-- Language Switcher in Footer -->
    <?php if (function_exists('otr_language_switcher')): ?>
        <div class="flex justify-center items-center mb-6">
            <?php echo otr_language_switcher(); ?>
        </div>
    <?php endif; ?>

    <!-- 3. VIỀN NÉT ĐỨT & BẢN QUYỀN: TRÀN TOÀN BỘ MÀN HÌNH -->
    <div class="w-full border-t border-dashed border-[#caa875]/25 pt-6 md:pt-7 text-center px-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block text-[10px] md:text-xs tracking-[0.25em] text-[#caa875]/60 hover:text-[#caa875] uppercase font-sans transition-colors duration-200">
            <?php echo esc_html( $copyright ); ?>
        </a>
    </div>

</footer>

