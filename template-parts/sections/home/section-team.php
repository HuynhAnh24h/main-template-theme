<?php
/**
 * Template Part: Section Team (Meet The On The Rock Team)
 * Description: Khối đội ngũ quán với 2 dải Marquee chạy ngang liên tục vô tận không khoảng nghỉ
 * và dàn 5 thành viên phong cách nghệ thuật.
 * 
 * Arguments ($args):
 * - marquee_text (string)
 * - members (array of 5 members with name, role, photo)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');

$marquee_text = ! empty( $args['marquee_text'] ) ? $args['marquee_text'] : (function_exists('get_field') ? (get_field('team_marquee_text', $front_page_id) ?: 'MEET THE ON THE ROCK TEAM') : 'MEET THE ON THE ROCK TEAM');
$members      = ! empty( $args['members'] ) ? $args['members'] : array();

$fallback_team_photos = array(
    1 => array('name' => 'QUỲNH VÂN', 'role' => 'STORE MANAGER', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop'),
    2 => array('name' => 'TUẤN KIỆT', 'role' => 'BAR MANAGER', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop'),
    3 => array('name' => 'VĂN BẢO', 'role' => 'BAR CAPTAIN', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&auto=format&fit=crop'),
    4 => array('name' => 'THÀNH ĐỨC', 'role' => 'BAR CAPTAIN', 'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=800&auto=format&fit=crop'),
    5 => array('name' => 'HỒNG PHÚ', 'role' => 'BARTENDER', 'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&auto=format&fit=crop'),
);

if ( empty( $members ) && function_exists('get_field') ) {
    for ($t = 1; $t <= 5; $t++) {
        $t_name  = get_field('team_member_name_' . $t, $front_page_id);
        $t_role  = get_field('team_member_role_' . $t, $front_page_id);
        $t_photo = get_field('team_member_photo_' . $t, $front_page_id);

        $photo_url = (!empty($t_photo) && is_array($t_photo)) ? $t_photo['url'] : (is_string($t_photo) && !empty($t_photo) ? $t_photo : $fallback_team_photos[$t]['photo']);

        $members[] = array(
            'name'  => !empty($t_name) ? $t_name : $fallback_team_photos[$t]['name'],
            'role'  => !empty($t_role) ? $t_role : $fallback_team_photos[$t]['role'],
            'photo' => $photo_url,
        );
    }
}

// Dữ liệu mẫu chuẩn 5 thành viên theo ảnh thiết kế
if ( empty( $members ) ) {
    $members = array_values($fallback_team_photos);
}
?>

<section id="section-team" class="relative w-full bg-[#070503] py-0 overflow-hidden text-[#f4efe8]">
    
    <!-- 1. Dải Marquee Chạy Ngang Phía Trên (Top Ticker - Chạy liên tục không khoảng nghỉ) -->
    <div class="ticker-wrapper w-full overflow-hidden whitespace-nowrap bg-black py-4 md:py-6 border-t border-b border-dashed border-[#caa875]/25 select-none flex">
        
        <!-- Track 1 -->
        <div class="flex shrink-0 items-center animate-marquee">
            <?php for ( $k = 0; $k < 4; $k++ ) : ?>
                <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                    <?php echo esc_html( $marquee_text ); ?>
                </span>
                
                <!-- Logo Monogram OTR làm dấu phân cách -->
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/otr-monogram-icon.png' ); ?>" alt="OTR Icon" class="w-6 h-6 md:w-8 md:h-8 object-contain shrink-0 inline-block opacity-90 mx-3 md:mx-4">
            <?php endfor; ?>
        </div>

        <!-- Track 2 (Clone nối tiếp để chạy vô tận 100% liền mạch) -->
        <div class="flex shrink-0 items-center animate-marquee" aria-hidden="true">
            <?php for ( $k = 0; $k < 4; $k++ ) : ?>
                <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                    <?php echo esc_html( $marquee_text ); ?>
                </span>
                
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/otr-monogram-icon.png' ); ?>" alt="OTR Icon" class="w-6 h-6 md:w-8 md:h-8 object-contain shrink-0 inline-block opacity-90 mx-3 md:mx-4">
            <?php endfor; ?>
        </div>

    </div>

    <!-- 2. Dàn Thành Viên Đội Ngũ (Team Grid - 2 người 1 hàng trên mobile theo yêu cầu) -->
    <div class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-0">
        <?php foreach ( $members as $idx => $member ) : ?>
            <div class="relative w-full h-[260px] sm:h-[340px] md:h-[480px] lg:h-[680px] overflow-hidden group cursor-pointer bg-[#0c0906] border-b border-dashed border-[#caa875]/20 lg:border-b-0 border-r lg:border-r border-[#caa875]/20 [&:nth-child(2n)]:border-r-0 md:[&:nth-child(2n)]:border-r-0 lg:[&:nth-child(2n)]:border-r lg:last:border-r-0">
                
                <!-- Ảnh chân dung thành viên -->
                <img src="<?php echo esc_url( $member['photo'] ); ?>" 
                     alt="<?php echo esc_attr( $member['name'] ); ?>" 
                     data-parallax
                     class="w-full h-full object-cover object-center filter brightness-[0.88] group-hover:brightness-100 group-hover:scale-105 transition-all duration-700 ease-out">
                
                <!-- Lớp phủ Gradient điện ảnh giúp tôn chữ vàng kim -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent pointer-events-none group-hover:opacity-75 transition-opacity duration-500"></div>

                <!-- Tên & Chức vụ thành viên ở góc dưới bên trái -->
                <div class="absolute bottom-3.5 sm:bottom-5 md:bottom-8 left-3 sm:left-5 md:left-7 right-2 sm:right-4 z-10 select-none">
                    <div class="font-serif text-sm sm:text-base md:text-xl lg:text-[25px] text-[#caa875] uppercase tracking-wider font-normal drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)] leading-tight">
                        <?php echo esc_html( $member['name'] ); ?>
                    </div>
                    <div class="font-sans text-[10px] sm:text-xs md:text-sm text-[#caa875]/80 uppercase tracking-[0.16em] sm:tracking-[0.22em] font-light mt-0.5 sm:mt-1 drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)] truncate">
                        <?php echo esc_html( $member['role'] ); ?>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

        <?php if ( count( $members ) % 2 !== 0 ) : ?>
            <!-- Thẻ Thương Hiệu lấp đầy ô chẵn hàng cuối trên mobile/tablet để cân đối 2 người 1 hàng -->
            <div class="relative w-full h-[260px] sm:h-[340px] md:h-[480px] lg:hidden flex flex-col items-center justify-center text-center p-5 sm:p-6 bg-[#0a0705] border-b border-dashed border-[#caa875]/20 select-none group">
                <svg class="w-10 h-10 sm:w-14 sm:h-14 text-[#caa875] opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500 mb-2 sm:mb-3" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="1.5" stroke-dasharray="2 2"/>
                    <circle cx="50" cy="50" r="41" stroke="#caa875" stroke-width="0.75"/>
                    <text x="50" y="32" font-family="'Fraunces', serif" font-size="9" fill="#caa875" text-anchor="middle" letter-spacing="3">ON THE ROCKS</text>
                    <text x="50" y="62" font-family="'Fraunces', serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                    <text x="50" y="78" font-family="'Fraunces', serif" font-size="7" fill="#caa875" text-anchor="middle" letter-spacing="4">TEAM</text>
                </svg>
                <span class="font-serif text-xs sm:text-sm tracking-[0.22em] text-[#caa875] uppercase font-medium">ON THE ROCKS</span>
                <span class="font-serif text-[9px] sm:text-[11px] tracking-[0.25em] text-[#caa875]/60 uppercase mt-1">THE ART OF COCKTAIL</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- 3. Dải Marquee Chạy Ngang Phía Dưới (Bottom Ticker) -->
    <?php get_template_part( 'template-parts/components/marquee-team-ticker' ); ?>

</section>
