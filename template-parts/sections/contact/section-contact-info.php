<?php
/**
 * Template Part: Section Contact Info
 * Description: Khối thông tin liên hệ 4 ô (Địa chỉ, Liên hệ, Giờ hoạt động, Mạng xã hội)
 * Thiết kế chuẩn 100% theo mockup On The Rock Cocktail Bar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id = get_the_ID();

// 1. Tiêu đề chính trang Liên Hệ
$page_title = function_exists('otr_get_field') ? otr_get_field('contact_page_title', $post_id, function_exists('otr_t') ? otr_t('LIÊN HỆ VỚI CHÚNG MÌNH', 'GET IN TOUCH WITH US') : 'LIÊN HỆ VỚI CHÚNG MÌNH') : 'LIÊN HỆ VỚI CHÚNG MÌNH';

// 2. Khối 1: ĐỊA CHỈ
$addr_title = function_exists('otr_get_field') ? otr_get_field('contact_address_title', $post_id, function_exists('otr_t') ? otr_t('ĐỊA CHỈ', 'ADDRESS') : 'ĐỊA CHỈ') : 'ĐỊA CHỈ';
$addr_link = function_exists('otr_get_field') ? otr_get_field('contact_address_link', $post_id, 'https://maps.google.com/?q=69+Trương+Công+Định,+Phường+1,+Đà+Lạt') : 'https://maps.google.com/?q=69+Trương+Công+Định,+Phường+1,+Đà+Lạt';
$addr_lines_raw = function_exists('otr_get_field') ? otr_get_field('contact_address_lines', $post_id) : '';
if (empty($addr_lines_raw)) {
    if (function_exists('otr_is_en') && otr_is_en()) {
        $addr_lines = array(
            'BASEMENT 69',
            'TRUONG CONG DINH,',
            'WARD 01, DA LAT'
        );
    } else {
        $addr_lines = array(
            'TẦNG HẦM 69',
            'TRƯƠNG CÔNG ĐỊNH,',
            'PHƯỜNG 01, ĐÀ LẠT'
        );
    }
} else {
    $addr_lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $addr_lines_raw))));
}

// 3. Khối 2: LIÊN HỆ
$info_title = function_exists('otr_get_field') ? otr_get_field('contact_info_title', $post_id, function_exists('otr_t') ? otr_t('LIÊN HỆ', 'CONTACT') : 'LIÊN HỆ') : 'LIÊN HỆ';
$email = function_exists('otr_get_field') ? otr_get_field('contact_email', $post_id, 'ONTHEROCK@GMAIL.COM') : 'ONTHEROCK@GMAIL.COM';
$phone = function_exists('otr_get_field') ? otr_get_field('contact_phone', $post_id, '070 297 0268') : '070 297 0268';
$clean_phone = preg_replace('/[^0-9+]/', '', $phone);

// 4. Khối 3: GIỜ HOẠT ĐỘNG
$hours_title = function_exists('otr_get_field') ? otr_get_field('contact_hours_title', $post_id, function_exists('otr_t') ? otr_t('GIỜ HOẠT ĐỘNG', 'OPENING HOURS') : 'GIỜ HOẠT ĐỘNG') : 'GIỜ HOẠT ĐỘNG';
$hours_days = function_exists('otr_get_field') ? otr_get_field('contact_hours_days', $post_id, function_exists('otr_t') ? otr_t('THỨ HAI – CHỦ NHẬT', 'MONDAY – SUNDAY') : 'THỨ HAI – CHỦ NHẬT') : 'THỨ HAI – CHỦ NHẬT';
$hours_time = function_exists('otr_get_field') ? otr_get_field('contact_hours_time', $post_id, function_exists('otr_t') ? otr_t('18H30 – 2H', '6:30 PM – 2:00 AM') : '18H30 – 2H') : '18H30 – 2H';

// 5. Khối 4: MẠNG XÃ HỘI
$social_title = function_exists('otr_get_field') ? otr_get_field('contact_social_title', $post_id, function_exists('otr_t') ? otr_t('MẠNG XÃ HỘI', 'SOCIAL MEDIA') : 'MẠNG XÃ HỘI') : 'MẠNG XÃ HỘI';
$fb_url = function_exists('otr_get_field') ? otr_get_field('contact_facebook_url', $post_id, 'https://facebook.com/ontherock.dalat') : 'https://facebook.com/ontherock.dalat';
$insta_url = function_exists('otr_get_field') ? otr_get_field('contact_instagram_url', $post_id, 'https://instagram.com/ontherock.dalat') : 'https://instagram.com/ontherock.dalat';
$tiktok_url = function_exists('otr_get_field') ? otr_get_field('contact_tiktok_url', $post_id, 'https://tiktok.com/@ontherock.dalat') : 'https://tiktok.com/@ontherock.dalat';
?>

<section class="otr-contact-section bg-[#080604] text-[#caa875] pt-32 sm:pt-40 md:pt-48 pb-20 sm:pb-28 md:pb-36 px-4 sm:px-6 md:px-8 w-full select-none">
    <div class="max-w-4xl mx-auto">

        <!-- TIÊU ĐỀ TRANG: LIÊN HỆ VỚI CHÚNG MÌNH -->
        <h1 class="font-serif text-2xl sm:text-3xl md:text-[38px] lg:text-[44px] text-[#caa875] text-center uppercase tracking-[0.18em] sm:tracking-[0.25em] font-normal leading-tight mb-16 sm:mb-20 md:mb-28">
            <?php echo esc_html( $page_title ); ?>
        </h1>

        <!-- KHỐI 4 Ô THÔNG TIN (2x2 GRID CÂN ĐỐI) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 sm:gap-x-20 md:gap-x-28 lg:gap-x-36 gap-y-12 sm:gap-y-16 md:gap-y-20 max-w-2xl sm:max-w-3xl mx-auto text-center">

            <!-- Ô 1: ĐỊA CHỈ (Góc trên bên trái) -->
            <div class="flex flex-col items-center justify-start">
                <h2 class="text-[#caa875] text-[13px] sm:text-[14px] font-normal tracking-[0.22em] uppercase mb-4 sm:mb-5">
                    <?php echo esc_html( $addr_title ); ?>
                </h2>
                <a href="<?php echo esc_url( $addr_link ); ?>" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center text-center space-y-1 text-xs sm:text-sm md:text-[14px] text-[#caa875] hover:text-white tracking-[0.14em] leading-relaxed transition-colors duration-200">
                    <?php foreach ( $addr_lines as $line ): ?>
                        <span class="inline-block border-b border-[#caa875] group-hover:border-white pb-0.5 transition-colors duration-200">
                            <?php echo esc_html( $line ); ?>
                        </span>
                    <?php endforeach; ?>
                </a>
            </div>

            <!-- Ô 2: LIÊN HỆ (Góc trên bên phải) -->
            <div class="flex flex-col items-center justify-start">
                <h2 class="text-[#caa875] text-[13px] sm:text-[14px] font-normal tracking-[0.22em] uppercase mb-4 sm:mb-5">
                    <?php echo esc_html( $info_title ); ?>
                </h2>
                <div class="flex flex-col items-center text-center space-y-2 text-xs sm:text-sm md:text-[14px] tracking-[0.14em] leading-relaxed">
                    <?php if ( ! empty( $email ) ): ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="inline-block border-b border-[#caa875] hover:border-white text-[#caa875] hover:text-white pb-0.5 transition-colors duration-200">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $phone ) ): ?>
                        <a href="tel:<?php echo esc_attr( $clean_phone ); ?>" class="inline-block border-b border-[#caa875] hover:border-white text-[#caa875] hover:text-white pb-0.5 transition-colors duration-200">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ô 3: GIỜ HOẠT ĐỘNG (Góc dưới bên trái) -->
            <div class="flex flex-col items-center justify-start">
                <h2 class="text-[#caa875] text-[13px] sm:text-[14px] font-normal tracking-[0.22em] uppercase mb-4 sm:mb-5">
                    <?php echo esc_html( $hours_title ); ?>
                </h2>
                <div class="flex flex-col items-center text-center space-y-1.5 text-xs sm:text-sm md:text-[14px] text-[#caa875] tracking-[0.14em] leading-relaxed">
                    <p class="uppercase font-normal">
                        <?php echo esc_html( $hours_days ); ?>
                    </p>
                    <p class="uppercase font-normal">
                        <?php echo esc_html( $hours_time ); ?>
                    </p>
                </div>
            </div>

            <!-- Ô 4: MẠNG XÃ HỘI (Góc dưới bên phải) -->
            <div class="flex flex-col items-center justify-start">
                <h2 class="text-[#caa875] text-[13px] sm:text-[14px] font-normal tracking-[0.22em] uppercase mb-4 sm:mb-5">
                    <?php echo esc_html( $social_title ); ?>
                </h2>
                <div class="flex flex-col items-center text-center space-y-2 text-xs sm:text-sm md:text-[14px] tracking-[0.14em] leading-relaxed">
                    <?php if ( ! empty( $fb_url ) ): ?>
                        <a href="<?php echo esc_url( $fb_url ); ?>" target="_blank" rel="noopener noreferrer" class="inline-block border-b border-[#caa875] hover:border-white text-[#caa875] hover:text-white pb-0.5 transition-colors duration-200">
                            FACEBOOK
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $insta_url ) ): ?>
                        <a href="<?php echo esc_url( $insta_url ); ?>" target="_blank" rel="noopener noreferrer" class="inline-block border-b border-[#caa875] hover:border-white text-[#caa875] hover:text-white pb-0.5 transition-colors duration-200">
                            INSTAGRAM
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $tiktok_url ) ): ?>
                        <a href="<?php echo esc_url( $tiktok_url ); ?>" target="_blank" rel="noopener noreferrer" class="inline-block border-b border-[#caa875] hover:border-white text-[#caa875] hover:text-white pb-0.5 transition-colors duration-200">
                            TIKTOK
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
