<?php
/**
 * Template Part: Section Menu (Interactive Cocktail List)
 * Description: Khối thực đơn cocktail tương tác 8 món với nhãn MENU sát lề trái, menu lệch phải,
 * ảnh nằm ngang hàng và hiệu ứng chữ trượt sang phải khi rê chuột, cùng nút Xem Menu dài ở cuối.
 * 
 * Arguments ($args):
 * - title (string)
 * - items (array)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$front_page_id = get_option('page_on_front');
$section_title = ! empty( $args['title'] ) ? $args['title'] : (function_exists('get_field') ? (get_field('menu_section_title', $front_page_id) ?: 'MENU') : 'MENU');
$menu_items    = ! empty( $args['items'] ) ? $args['items'] : array();

$fallback_menu_images = array(
    1 => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
    2 => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
    3 => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
    4 => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
    5 => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
    6 => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?q=80&w=1000&auto=format&fit=crop',
    7 => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?q=80&w=1000&auto=format&fit=crop',
    8 => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop',
);

// Nạp từ ACF nếu không truyền từ ngoài
if ( empty( $menu_items ) && function_exists('get_field') ) {
    for ($m = 1; $m <= 8; $m++) {
        $num_str   = sprintf('%02d', $m);
        $title_val = get_field('menu_item_title_' . $m, $front_page_id);
        $desc_val  = get_field('menu_item_desc_' . $m, $front_page_id);
        $img_val   = get_field('menu_item_image_' . $m, $front_page_id);

        $img_url = '';
        if (!empty($img_val)) {
            if (is_array($img_val) && !empty($img_val['url'])) {
                $img_url = $img_val['url'];
            } elseif (is_string($img_val)) {
                $img_url = $img_val;
            } elseif (is_numeric($img_val)) {
                $img_url = wp_get_attachment_image_url($img_val, 'large');
            }
        }
        if (empty($img_url) && isset($fallback_menu_images[$m])) {
            $img_url = $fallback_menu_images[$m];
        }

        if (!empty($title_val)) {
            $menu_items[] = array(
                'num'   => $num_str,
                'title' => $title_val,
                'desc'  => $desc_val,
                'image' => $img_url,
            );
        }
    }
}

// Fallback 8 món mẫu chuẩn quán bar nếu chưa cấu hình trong ACF
if ( empty( $menu_items ) ) {
    $menu_items = array(
        array(
            'num'   => '01',
            'title' => 'BESPOKE COCKTAIL',
            'desc'  => 'Đi ngang lâu lắm rồi giờ mới có dịp ghé quán, trời mưa có nhân viên siêu nice hỗ trợ',
            'image' => $fallback_menu_images[1],
        ),
        array(
            'num'   => '02',
            'title' => 'CLASSIC COCKTAIL',
            'desc'  => 'Hương vị cổ điển vượt thời gian — từ Old Fashioned đậm đà đến Negroni trầm lắng.',
            'image' => $fallback_menu_images[2],
        ),
        array(
            'num'   => '03',
            'title' => 'SIGNATURE CREATION',
            'desc'  => 'Sáng tạo độc quyền từ các bartender lành nghề với các tầng hương độc bản của thảo mộc cao nguyên.',
            'image' => $fallback_menu_images[3],
        ),
        array(
            'num'   => '04',
            'title' => 'MOCKTAIL & BOTANICAL',
            'desc'  => 'Trải nghiệm tinh tế không cồn, thanh mát và cân bằng hoàn hảo cho buổi tối thư thái.',
            'image' => $fallback_menu_images[4],
        ),
        array(
            'num'   => '05',
            'title' => 'PREMIUM SPIRITS & WHISKY',
            'desc'  => 'Bộ sưu tập single malt và whisky tuyển chọn từ các nhà chưng cất danh tiếng thế giới.',
            'image' => $fallback_menu_images[5],
        ),
        array(
            'num'   => '06',
            'title' => 'WINE & CHAMPAGNE',
            'desc'  => 'Những giọt vang thượng hạng và bọt sủi champagne lấp lánh nâng niu từng khoảnh khắc đáng nhớ.',
            'image' => $fallback_menu_images[6],
        ),
        array(
            'num'   => '07',
            'title' => 'BAR BITES & TAPAS',
            'desc'  => 'Món ăn nhẹ tinh hoa kết hợp phong vị Á - Âu, được thiết kế để tôn vinh hương vị đồ uống.',
            'image' => $fallback_menu_images[7],
        ),
        array(
            'num'   => '08',
            'title' => 'SEASONAL SPECIALS',
            'desc'  => 'Bản giao hưởng hương vị theo mùa — biến tấu ngẫu hứng với nguyên liệu tươi mới độc đáo.',
            'image' => $fallback_menu_images[8],
        ),
    );
}

$raw_menu_link = function_exists('get_field') ? get_field('header_menu_url', $front_page_id) : '';
$menu_page_url = (empty($raw_menu_link) || in_array($raw_menu_link, array('#menu', '#', ''))) ? home_url('/menu/') : (function_exists('otr_url') ? otr_url($raw_menu_link) : home_url('/' . ltrim($raw_menu_link, '/')));
?>

<section id="menu" class="relative w-full py-16 sm:py-24 md:py-36 px-4 sm:px-8 md:px-14 lg:px-20 bg-[#090705] text-[#f4efe8] overflow-hidden scroll-mt-20 md:scroll-mt-32">
    
    <!-- Ánh sáng nền đen mờ tinh tế -->
    <div class="absolute inset-0 bg-gradient-to-b from-black via-[#0d0906]/85 to-black pointer-events-none"></div>

    <div class="max-w-[1440px] mx-auto relative z-10">
        
        <!-- Khối Menu lệch về bên phải (không nằm giữa) theo yêu cầu người dùng -->
        <div class="w-full max-w-5xl ml-auto">
            
            <!-- 1. Chữ MENU đưa từ bên trái lên trên đầu của Menu -->
            <div class="mb-6 sm:mb-8 md:mb-12">
                <span class="font-sans text-xs sm:text-sm md:text-base lg:text-lg tracking-[0.35em] text-[#caa875] uppercase select-none font-medium block">
                    <?php echo esc_html( $section_title ); ?>
                </span>
            </div>

            <!-- 2. Danh sách Menu (Giữ nguyên 100% layout, cấu trúc hàng, ảnh và hiệu ứng) -->
            <div id="menu-items-list" class="flex flex-col border-t border-dashed border-[#caa875]/25">
                    <?php foreach ( $menu_items as $idx => $item ) : 
                        $item_image = !empty($item['image']) ? $item['image'] : (isset($fallback_menu_images[$idx + 1]) ? $fallback_menu_images[$idx + 1] : $fallback_menu_images[1]);
                    ?>
                        <div class="menu-item-row group relative border-b border-dashed border-[#caa875]/25 py-6 sm:py-8 md:py-12 transition-colors duration-300 cursor-pointer overflow-visible"
                             data-index="<?php echo esc_attr( $idx ); ?>">
                            
                            <!-- Hàng nội dung: Chữ bên trái, Ảnh cùng hàng ngang bên phải (đồng bộ trên cả mobile và desktop) -->
                            <div class="flex flex-row items-center justify-between gap-3 sm:gap-6 relative">
                                
                                <!-- Cột văn bản: Khi hover thì dịch sang trái mượt mà -->
                                <div class="flex-1 max-w-2xl pr-2 sm:pr-4 min-w-0">
                                    
                                    <!-- Khối Tiêu đề dịch sang trái nhiều hơn nữa khi hover theo yêu cầu người dùng -->
                                    <div class="menu-title-wrapper transition-transform duration-500 ease-out group-hover:-translate-x-3 sm:group-hover:-translate-x-8 md:group-hover:-translate-x-14 lg:group-hover:-translate-x-20 group-[.is-active]:-translate-x-3 sm:group-[.is-active]:-translate-x-8 md:group-[.is-active]:-translate-x-14 lg:group-[.is-active]:-translate-x-20">
                                        <div class="menu-item-num font-sans text-[11px] sm:text-xs md:text-sm tracking-widest text-[#caa875] group-hover:text-[#ecd9b4] group-[.is-active]:text-[#ecd9b4] transition-colors duration-300 mb-1 sm:mb-1.5 font-medium">
                                            <?php echo esc_html( $item['num'] ); ?>
                                        </div>
                                        <div class="menu-item-title font-mrch text-lg sm:text-2xl md:text-3xl lg:text-[44px] xl:text-[50px] font-normal tracking-wide text-[#caa875] group-hover:text-[#ecd9b4] group-[.is-active]:text-[#ecd9b4] transition-colors duration-400 uppercase leading-[1.12]">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </div>
                                    </div>

                                    <!-- Dòng mô tả: Bung mở khi hover, nằm nguyên vị trí cố định không bị dịch sang trái theo yêu cầu người dùng -->
                                    <div class="menu-item-desc overflow-hidden transition-all duration-500 max-h-0 opacity-0 group-hover:max-h-36 group-[.is-active]:max-h-36 group-hover:opacity-100 group-[.is-active]:opacity-100 group-hover:mt-2.5 sm:group-hover:mt-3.5 group-[.is-active]:mt-2.5 sm:group-[.is-active]:mt-3.5">
                                        <p class="font-sans text-[11px] sm:text-xs md:text-sm leading-relaxed text-[#caa875]/90 font-light tracking-wide max-w-xl pl-0.5">
                                            <?php echo esc_html( $item['desc'] ); ?>
                                        </p>
                                    </div>

                                </div>

                                <!-- Cột hình ảnh: khi hover nghiêng nhẹ và scale vừa vặn che viền mà không bị quá to -->
                                <div class="menu-item-photo-col shrink-0 self-center relative transition-all duration-500">
                                    <div class="menu-item-photo relative w-[85px] sm:w-[110px] md:w-[135px] lg:w-[155px] h-[115px] sm:h-[150px] md:h-[185px] lg:h-[210px] rounded-sm overflow-hidden border border-[#caa875]/25 bg-[#120e0a] 
                                                transition-all duration-500 ease-out 
                                                rotate-0 brightness-[0.85] shadow-lg
                                                group-hover:-rotate-[4deg] group-hover:scale-[1.2] group-hover:brightness-100 group-hover:border-[#caa875]/80 group-hover:shadow-[0_16px_36px_-4px_rgba(0,0,0,0.9),0_0_16px_1px_rgba(202,168,117,0.22)]
                                                group-[.is-active]:-rotate-[4deg] group-[.is-active]:scale-[1.2] group-[.is-active]:brightness-100 group-[.is-active]:border-[#caa875]/80 group-[.is-active]:shadow-[0_16px_36px_-4px_rgba(0,0,0,0.9),0_0_16px_1px_rgba(202,168,117,0.22)]">
                                        <img src="<?php echo esc_url( $item_image ); ?>" 
                                             alt="<?php echo esc_attr( $item['title'] ); ?>" 
                                             loading="lazy"
                                             decoding="async"
                                             class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/15 pointer-events-none group-hover:opacity-0 transition-opacity duration-500"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                    <!-- 3. Nút Xem Menu dài nằm ở cuối danh sách menu trên Trang Chủ -->
                    <div class="pt-10 sm:pt-14 md:pt-16">
                        <a href="<?php echo esc_url( $menu_page_url ); ?>" 
                           class="btn-liquid-glass group/btn w-full py-4 sm:py-5 px-8 rounded-full font-serif font-medium text-xs sm:text-sm md:text-base tracking-[0.25em] uppercase flex items-center justify-center gap-3.5 select-none cursor-pointer">
                            <span class="btn-roll-wrap">
                                <span class="btn-roll-text">
                                    <span>XEM MENU</span>
                                    <span aria-hidden="true">XEM MENU</span>
                                </span>
                            </span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-transform duration-300 group-hover/btn:translate-x-2 text-current" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>

                </div>

        </div>

    </div>

</section>
