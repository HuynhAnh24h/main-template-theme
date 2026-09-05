<?php
/**
 * Template Part: Section Menu (Interactive Cocktail List)
 * Description: Khối thực đơn cocktail tương tác 8 món với nhãn MENU sát lề trái, menu lệch phải,
 * ảnh nằm ngang hàng và hiệu ứng chữ trượt sang trái khi rê chuột.
 * 
 * Arguments ($args):
 * - title (string)
 * - items (array)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$section_title = ! empty( $args['title'] ) ? $args['title'] : 'MENU';
$menu_items    = ! empty( $args['items'] ) ? $args['items'] : array();

// Fallback 8 món mẫu chuẩn quán bar nếu chưa cấu hình trong ACF
if ( empty( $menu_items ) ) {
    $menu_items = array(
        array(
            'num'   => '01',
            'title' => 'BESPOKE COCKTAIL',
            'desc'  => 'Đi ngang lâu lắm rồi giờ mới có dịp ghé quán, trời mưa có nhân viên siêu nice hỗ trợ',
            'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '02',
            'title' => 'CLASSIC COCKTAIL',
            'desc'  => 'Hương vị cổ điển vượt thời gian — từ Old Fashioned đậm đà đến Negroni trầm lắng.',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '03',
            'title' => 'SIGNATURE CREATION',
            'desc'  => 'Sáng tạo độc quyền từ các bartender lành nghề với các tầng hương độc bản của thảo mộc cao nguyên.',
            'image' => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '04',
            'title' => 'MOCKTAIL & BOTANICAL',
            'desc'  => 'Trải nghiệm tinh tế không cồn, thanh mát và cân bằng hoàn hảo cho buổi tối thư thái.',
            'image' => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '05',
            'title' => 'PREMIUM SPIRITS & WHISKY',
            'desc'  => 'Bộ sưu tập single malt và whisky tuyển chọn từ các nhà chưng cất danh tiếng thế giới.',
            'image' => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '06',
            'title' => 'WINE & CHAMPAGNE',
            'desc'  => 'Những giọt vang thượng hạng và bọt sủi champagne lấp lánh nâng niu từng khoảnh khắc đáng nhớ.',
            'image' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '07',
            'title' => 'BAR BITES & TAPAS',
            'desc'  => 'Món ăn nhẹ tinh hoa kết hợp phong vị Á - Âu, được thiết kế để tôn vinh hương vị đồ uống.',
            'image' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?q=80&w=1000&auto=format&fit=crop',
        ),
        array(
            'num'   => '08',
            'title' => 'SEASONAL SPECIALS',
            'desc'  => 'Bản giao hưởng hương vị theo mùa — biến tấu ngẫu hứng với nguyên liệu tươi mới độc đáo.',
            'image' => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop',
        ),
    );
}
?>

<section id="menu" class="relative w-full py-24 md:py-36 px-5 sm:px-10 md:px-16 lg:px-20 bg-[#090705] text-[#f4efe8] overflow-hidden scroll-mt-28 md:scroll-mt-32">
    
    <!-- Ánh sáng nền đen mờ tinh tế -->
    <div class="absolute inset-0 bg-gradient-to-b from-black via-[#0d0906]/85 to-black pointer-events-none"></div>

    <div class="max-w-[1440px] mx-auto relative z-10">
        
        <!-- Bố cục Container: Chữ MENU sát lề trái, Danh sách Menu lệch sang phải -->
        <div class="flex flex-col lg:flex-row items-start justify-between gap-10 lg:gap-16">
            
            <!-- 1. Chữ MENU nằm sát lề trái theo container -->
            <div class="lg:w-36 shrink-0 pt-4 lg:sticky lg:top-36">
                <span class="font-serif text-sm md:text-base lg:text-lg tracking-[0.35em] text-[#caa875] uppercase select-none font-medium">
                    <?php echo esc_html( $section_title ); ?>
                </span>
            </div>

            <!-- 2. Danh sách Menu lệch về phía bên phải -->
            <div class="flex-1 w-full max-w-5xl ml-auto">
                <div id="menu-items-list" class="flex flex-col">
                    <?php foreach ( $menu_items as $idx => $item ) : ?>
                        <div class="menu-item-row group relative border-b border-dashed border-[#caa875]/25 py-8 md:py-12 transition-colors duration-300 cursor-pointer overflow-visible"
                             data-index="<?php echo esc_attr( $idx ); ?>">
                            
                            <!-- Hàng nội dung: Chữ bên trái, Ảnh cùng hàng ngang bên phải -->
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative">
                                
                                <!-- Cột văn bản -->
                                <div class="flex-1 max-w-2xl pr-4">
                                    
                                    <!-- Khối Tiêu đề có animation trượt nhẹ sang trái và đổi màu khi hover -->
                                    <div class="menu-title-wrapper transition-transform duration-500 ease-out group-hover:-translate-x-4 md:group-hover:-translate-x-6 group-[.is-active]:-translate-x-4 md:group-[.is-active]:-translate-x-6">
                                        <div class="menu-item-num text-xs sm:text-sm tracking-widest text-[#caa875]/70 group-hover:text-[#caa875] group-[.is-active]:text-[#caa875] transition-colors duration-300 mb-1.5 font-mono">
                                            <?php echo esc_html( $item['num'] ); ?>
                                        </div>
                                        <div class="menu-item-title font-serif text-2xl sm:text-3xl md:text-4xl lg:text-[46px] xl:text-[52px] font-normal tracking-wide text-[#f4efe8] group-hover:text-[#caa875] group-[.is-active]:text-[#caa875] transition-colors duration-400 uppercase leading-[1.08]">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </div>
                                    </div>

                                    <!-- Dòng mô tả (chỉ bung mở khi hover vào) -->
                                    <div class="menu-item-desc overflow-hidden transition-all duration-500 max-h-0 opacity-0 group-hover:max-h-36 group-[.is-active]:max-h-36 group-hover:opacity-100 group-[.is-active]:opacity-100 group-hover:mt-3.5 group-[.is-active]:mt-3.5 group-hover:-translate-x-4 md:group-hover:-translate-x-6 group-[.is-active]:-translate-x-4 md:group-[.is-active]:-translate-x-6">
                                        <p class="text-xs sm:text-[13px] md:text-sm leading-relaxed text-[#caa875]/90 font-light tracking-wide max-w-xl pl-0.5">
                                            <?php echo esc_html( $item['desc'] ); ?>
                                        </p>
                                    </div>

                                </div>

                                <!-- Cột hình ảnh: LUÔN HIỆN, khi hover thì kích hoạt xoay nghiêng nghệ thuật & phóng to -->
                                <div class="shrink-0 self-center md:self-auto relative z-10 group-hover:z-30 group-[.is-active]:z-30 transition-all duration-500">
                                    <div class="menu-item-photo relative w-[180px] sm:w-[210px] md:w-[230px] lg:w-[260px] h-[240px] sm:h-[280px] md:h-[310px] lg:h-[340px] rounded-sm overflow-hidden border border-[#caa875]/25 bg-[#120e0a] 
                                                transition-all duration-500 ease-out 
                                                rotate-0 brightness-[0.78] shadow-lg
                                                group-hover:rotate-[4.2deg] group-hover:scale-105 group-hover:brightness-100 group-hover:border-[#caa875]/60 group-hover:shadow-[0_25px_60px_rgba(0,0,0,0.95)]
                                                group-[.is-active]:rotate-[4.2deg] group-[.is-active]:scale-105 group-[.is-active]:brightness-100 group-[.is-active]:border-[#caa875]/60 group-[.is-active]:shadow-[0_25px_60px_rgba(0,0,0,0.95)]">
                                        <img src="<?php echo esc_url( $item['image'] ); ?>" 
                                             alt="<?php echo esc_attr( $item['title'] ); ?>" 
                                             class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/15 pointer-events-none group-hover:opacity-0 transition-opacity duration-500"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </div>

</section>
