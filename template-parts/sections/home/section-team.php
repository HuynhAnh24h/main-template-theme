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

$marquee_text = ! empty( $args['marquee_text'] ) ? $args['marquee_text'] : 'MEET THE ON THE ROCK TEAM';
$members      = ! empty( $args['members'] ) ? $args['members'] : array();

// Dữ liệu mẫu chuẩn 5 thành viên theo ảnh thiết kế
if ( empty( $members ) ) {
    $members = array(
        array(
            'name'  => 'QUỲNH VÂN',
            'role'  => 'STORE MANAGER',
            'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop',
        ),
        array(
            'name'  => 'TUẤN KIỆT',
            'role'  => 'BAR MANAGER',
            'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800&auto=format&fit=crop',
        ),
        array(
            'name'  => 'VĂN BẢO',
            'role'  => 'BAR CAPTAIN',
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&auto=format&fit=crop',
        ),
        array(
            'name'  => 'THÀNH ĐỨC',
            'role'  => 'BAR CAPTAIN',
            'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=800&auto=format&fit=crop',
        ),
        array(
            'name'  => 'HỒNG PHÚ',
            'role'  => 'BARTENDER',
            'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&auto=format&fit=crop',
        ),
    );
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
                <svg class="w-7 h-7 md:w-9 md:h-9 text-[#caa875] shrink-0 inline-block opacity-90" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="1.5" stroke-dasharray="2 2"/>
                    <circle cx="50" cy="50" r="41" stroke="#caa875" stroke-width="0.75"/>
                    <text x="50" y="32" font-family="'Fraunces', serif" font-size="9" fill="#caa875" text-anchor="middle" letter-spacing="3">ON THE ROCKS</text>
                    <text x="50" y="62" font-family="'Fraunces', serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                    <text x="50" y="78" font-family="'Fraunces', serif" font-size="7" fill="#caa875" text-anchor="middle" letter-spacing="4">BAR</text>
                </svg>
            <?php endfor; ?>
        </div>

        <!-- Track 2 (Clone nối tiếp để chạy vô tận 100% liền mạch) -->
        <div class="flex shrink-0 items-center animate-marquee" aria-hidden="true">
            <?php for ( $k = 0; $k < 4; $k++ ) : ?>
                <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                    <?php echo esc_html( $marquee_text ); ?>
                </span>
                
                <svg class="w-7 h-7 md:w-9 md:h-9 text-[#caa875] shrink-0 inline-block opacity-90" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="1.5" stroke-dasharray="2 2"/>
                    <circle cx="50" cy="50" r="41" stroke="#caa875" stroke-width="0.75"/>
                    <text x="50" y="32" font-family="'Fraunces', serif" font-size="9" fill="#caa875" text-anchor="middle" letter-spacing="3">ON THE ROCKS</text>
                    <text x="50" y="62" font-family="'Fraunces', serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                    <text x="50" y="78" font-family="'Fraunces', serif" font-size="7" fill="#caa875" text-anchor="middle" letter-spacing="4">BAR</text>
                </svg>
            <?php endfor; ?>
        </div>

    </div>

    <!-- 2. Dàn 5 Thành Viên Đội Ngũ (Team Grid) -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-0">
        <?php foreach ( $members as $idx => $member ) : ?>
            <div class="relative w-full h-[480px] sm:h-[540px] md:h-[600px] lg:h-[680px] overflow-hidden group cursor-pointer bg-[#0c0906] border-r border-dashed border-[#caa875]/20 last:border-r-0">
                
                <!-- Ảnh chân dung thành viên -->
                <img src="<?php echo esc_url( $member['photo'] ); ?>" 
                     alt="<?php echo esc_attr( $member['name'] ); ?>" 
                     data-parallax
                     class="w-full h-full object-cover object-center filter brightness-[0.88] group-hover:brightness-100 group-hover:scale-105 transition-all duration-700 ease-out">
                
                <!-- Lớp phủ Gradient điện ảnh giúp tôn chữ vàng kim -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent pointer-events-none group-hover:opacity-75 transition-opacity duration-500"></div>

                <!-- Tên & Chức vụ thành viên ở góc dưới bên trái -->
                <div class="absolute bottom-8 left-6 md:left-7 right-4 z-10 select-none">
                    <div class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[25px] text-[#caa875] uppercase tracking-wider font-normal drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)] leading-tight">
                        <?php echo esc_html( $member['name'] ); ?>
                    </div>
                    <div class="font-serif text-xs sm:text-sm text-[#caa875]/80 uppercase tracking-[0.22em] font-light mt-1 drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)]">
                        <?php echo esc_html( $member['role'] ); ?>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- 3. Dải Marquee Chạy Ngang Phía Dưới (Bottom Ticker - Chạy liên tục không khoảng nghỉ) -->
    <div class="ticker-wrapper w-full overflow-hidden whitespace-nowrap bg-black py-4 md:py-6 border-t border-b border-dashed border-[#caa875]/25 select-none flex">
        
        <!-- Track 1 -->
        <div class="flex shrink-0 items-center animate-marquee">
            <?php for ( $k = 0; $k < 4; $k++ ) : ?>
                <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                    <?php echo esc_html( $marquee_text ); ?>
                </span>
                
                <svg class="w-7 h-7 md:w-9 md:h-9 text-[#caa875] shrink-0 inline-block opacity-90" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="1.5" stroke-dasharray="2 2"/>
                    <circle cx="50" cy="50" r="41" stroke="#caa875" stroke-width="0.75"/>
                    <text x="50" y="32" font-family="'Fraunces', serif" font-size="9" fill="#caa875" text-anchor="middle" letter-spacing="3">ON THE ROCKS</text>
                    <text x="50" y="62" font-family="'Fraunces', serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                    <text x="50" y="78" font-family="'Fraunces', serif" font-size="7" fill="#caa875" text-anchor="middle" letter-spacing="4">BAR</text>
                </svg>
            <?php endfor; ?>
        </div>

        <!-- Track 2 (Clone nối tiếp để chạy vô tận 100% liền mạch) -->
        <div class="flex shrink-0 items-center animate-marquee" aria-hidden="true">
            <?php for ( $k = 0; $k < 4; $k++ ) : ?>
                <span class="font-serif text-lg sm:text-xl md:text-2xl lg:text-[26px] tracking-[0.25em] text-[#caa875] uppercase px-6 md:px-10 font-normal">
                    <?php echo esc_html( $marquee_text ); ?>
                </span>
                
                <svg class="w-7 h-7 md:w-9 md:h-9 text-[#caa875] shrink-0 inline-block opacity-90" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="46" stroke="#caa875" stroke-width="1.5" stroke-dasharray="2 2"/>
                    <circle cx="50" cy="50" r="41" stroke="#caa875" stroke-width="0.75"/>
                    <text x="50" y="32" font-family="'Fraunces', serif" font-size="9" fill="#caa875" text-anchor="middle" letter-spacing="3">ON THE ROCKS</text>
                    <text x="50" y="62" font-family="'Fraunces', serif" font-size="28" font-weight="600" fill="#caa875" text-anchor="middle" letter-spacing="2">OTR</text>
                    <text x="50" y="78" font-family="'Fraunces', serif" font-size="7" fill="#caa875" text-anchor="middle" letter-spacing="4">BAR</text>
                </svg>
            <?php endfor; ?>
        </div>

    </div>

</section>
