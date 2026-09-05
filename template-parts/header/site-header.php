<?php
/**
 * Component: Site Header (Fixed Top Navigation)
 * Description: Header điều hướng cố định sang trọng cho On The Rocks Cocktail Bar (100% khớp mockup).
 * 
 * Arguments ($args):
 * - facebook_url (string)
 * - instagram_url (string)
 * - logo (array|string)
 * - menu_text (string)
 * - menu_url (string)
 * - contact_text (string)
 * - contact_url (string)
 * - booking_text (string)
 * - booking_url (string)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

$raw_fb = ! empty( $args['facebook_url'] ) ? $args['facebook_url'] : get_field('header_facebook_url', $front_page_id);
if (empty($raw_fb) || in_array(rtrim($raw_fb, '/'), array('https://facebook.com', 'http://facebook.com', '#'))) {
    $facebook_url = 'https://facebook.com/ontherock.dalat';
} else {
    $facebook_url = $raw_fb;
}

$raw_insta = ! empty( $args['instagram_url'] ) ? $args['instagram_url'] : get_field('header_instagram_url', $front_page_id);
if (empty($raw_insta) || in_array(rtrim($raw_insta, '/'), array('https://instagram.com', 'http://instagram.com', '#'))) {
    $instagram_url = 'https://instagram.com/ontherock.dalat';
} else {
    $instagram_url = $raw_insta;
}

$logo = ! empty( $args['logo'] ) ? $args['logo'] : get_field('header_logo', $front_page_id);

$raw_menu = ! empty( $args['menu_url'] ) ? $args['menu_url'] : get_field('header_menu_url', $front_page_id);
if (empty($raw_menu) || in_array($raw_menu, array('#menu', '#', ''))) {
    $menu_url = home_url('/menu/');
} else {
    $menu_url = function_exists('otr_url') ? otr_url($raw_menu) : ((strpos($raw_menu, 'http') === 0) ? $raw_menu : home_url('/' . ltrim($raw_menu, '/')));
}
$menu_text = ! empty( $args['menu_text'] ) ? $args['menu_text'] : (get_field('header_menu_text', $front_page_id) ?: 'MENU');

$raw_contact = ! empty( $args['contact_url'] ) ? $args['contact_url'] : get_field('header_contact_url', $front_page_id);
if (empty($raw_contact) || in_array($raw_contact, array('#contact', '#', ''))) {
    $contact_url = home_url('/contact/');
} else {
    $contact_url = function_exists('otr_url') ? otr_url($raw_contact) : ((strpos($raw_contact, 'http') === 0) ? $raw_contact : home_url('/' . ltrim($raw_contact, '/')));
}
$contact_text = ! empty( $args['contact_text'] ) ? $args['contact_text'] : (get_field('header_contact_text', $front_page_id) ?: 'CONTACT');

$raw_booking = ! empty( $args['booking_url'] ) ? $args['booking_url'] : get_field('header_booking_url', $front_page_id);
if (empty($raw_booking) || in_array($raw_booking, array('#book', '#booking', '#', ''))) {
    $booking_url = home_url('/booking/');
} else {
    $booking_url = function_exists('otr_url') ? otr_url($raw_booking) : ((strpos($raw_booking, 'http') === 0) ? $raw_booking : home_url('/' . ltrim($raw_booking, '/')));
}
$booking_text = ! empty( $args['booking_text'] ) ? $args['booking_text'] : (get_field('header_booking_text', $front_page_id) ?: 'ĐẶT BÀN TRƯỚC');

// Lấy link ảnh logo nếu truyền vào mảng ACF
$logo_url = '';
if ( is_array( $logo ) && ! empty( $logo['url'] ) ) {
    $logo_url = $logo['url'];
} elseif ( is_string( $logo ) && ! empty( $logo ) ) {
    $logo_url = $logo;
} else {
    // Mặc định: Logo Monogram On The Rocks sang trọng chuẩn từ mockup
    $logo_url = get_template_directory_uri() . '/assets/images/otr-logo-gold.png';
}
?>

<header id="site-header" class="site-header fixed top-0 left-0 right-0 z-[9999] transition-all duration-300 py-3 sm:py-3.5 px-4 sm:px-8 md:px-12 lg:px-16 bg-[#160f09]/95 backdrop-blur-md border-b border-[#caa875]/25 shadow-[0_4px_30px_rgba(0,0,0,0.85)]">
    <div class="w-full mx-auto flex items-center justify-between">
        
        <!-- Nhóm mạng xã hội bên trái (Chữ đậm, to rõ nét, màu vàng champagne) -->
        <nav class="hidden md:flex items-center gap-7 lg:gap-9 text-[13px] lg:text-[14px] font-bold tracking-[0.2em] text-[#caa875] uppercase">
            <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors duration-200">
                FACEBOOK
            </a>
            <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors duration-200">
                INSTAGRAM
            </a>
        </nav>

        <!-- Logo Monogram On The Rocks ở giữa -->
        <div class="site-header__logo flex justify-center py-0.5">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block transition-transform duration-300 hover:scale-105" title="<?php bloginfo( 'name' ); ?>">
                <img 
                    src="<?php echo esc_url( $logo_url ); ?>" 
                    alt="On The Rocks Bar Logo" 
                    class="h-10 sm:h-11 md:h-12 w-auto object-contain select-none"
                >
            </a>
        </div>

        <!-- Nhóm điều hướng & nút Đặt bàn bên phải -->
        <div class="flex items-center gap-5 sm:gap-7 lg:gap-8">
            <nav class="hidden md:flex items-center gap-7 lg:gap-9 text-[13px] lg:text-[14px] font-bold tracking-[0.2em] text-[#caa875] uppercase">
                <a href="<?php echo esc_url( $menu_url ); ?>" class="hover:text-white transition-colors duration-200">
                    <?php echo esc_html( $menu_text ); ?>
                </a>
                <a href="<?php echo esc_url( $contact_url ); ?>" class="hover:text-white transition-colors duration-200">
                    <?php echo esc_html( $contact_text ); ?>
                </a>
            </nav>

            <!-- Nút Đặt bàn trước (Capsule Button chuẩn mockup) -->
            <div class="hidden sm:block">
                <a 
                    href="<?php echo esc_url( $booking_url ); ?>" 
                    class="inline-flex items-center justify-center rounded-full px-5 md:px-7 py-2 md:py-2.5 bg-[#2b2014] hover:bg-[#caa875] border border-[#caa875]/70 hover:border-[#caa875] text-[#caa875] hover:text-[#080604] font-bold text-xs md:text-[13px] tracking-[0.16em] uppercase transition-all duration-300 shadow-md select-none cursor-pointer"
                >
                    <?php echo esc_html( $booking_text ); ?>
                </a>
            </div>

            <!-- Nút Mobile Menu Toggle (Chỉ hiện trên mobile) -->
            <button id="mobile-nav-toggle" class="md:hidden text-[#caa875] p-2 hover:text-white transition cursor-pointer" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav-menu" class="hidden md:hidden bg-[#160f09] border-t border-[#caa875]/25 px-6 py-6 mt-3 rounded-b-2xl shadow-2xl">
        <nav class="flex flex-col gap-4 text-sm font-bold tracking-[0.2em] text-[#caa875] uppercase">
            <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-white">FACEBOOK</a>
            <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-white">INSTAGRAM</a>
            <a href="<?php echo esc_url( $menu_url ); ?>" class="py-1 hover:text-white"><?php echo esc_html( $menu_text ); ?></a>
            <a href="<?php echo esc_url( $contact_url ); ?>" class="py-1 hover:text-white"><?php echo esc_html( $contact_text ); ?></a>
            <div class="pt-2">
                <a 
                    href="<?php echo esc_url( $booking_url ); ?>" 
                    class="block text-center rounded-full px-6 py-3 bg-[#2b2014] hover:bg-[#caa875] border border-[#caa875]/70 text-[#caa875] hover:text-[#080604] font-bold text-xs tracking-[0.18em] uppercase transition-all shadow-md"
                >
                    <?php echo esc_html( $booking_text ); ?>
                </a>
            </div>
        </nav>
    </div>
</header>
