<?php
/**
 * Template Part: Section Menu Page
 * Description: Trang Thực Đơn On The Rock lấy dữ liệu từ hệ thống đa tầng Menu TheRocks.
 * Hiển thị các Menu Cha dạng hàng ngang ngăn cách bởi nét đứt chuẩn theo thiết kế,
 * khi click vào hàng thì xổ xuống hiển thị Menu Con (Tabs) và nội dung theo Kiểu 1, 2, 3.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_id = get_queried_object_id();
if ( empty( $current_id ) ) {
    $current_id = get_the_ID();
}
if ( empty( $current_id ) ) {
    $menu_page = get_page_by_path( 'menu' );
    if ( $menu_page ) {
        $current_id = $menu_page->ID;
    }
}
$front_page_id = get_option('page_on_front');

// 1. Dữ liệu mở đầu (Hero Intro) từ ACF
$hero_title = function_exists('otr_get_field') ? otr_get_field('menu_page_title', $current_id, (otr_get_field('menu_page_title', $front_page_id, 'MENU'))) : 'MENU';
$hero_desc  = function_exists('otr_get_field') ? otr_get_field('menu_page_desc', $current_id, (otr_get_field('menu_page_desc', $front_page_id, otr_t('Thưởng thức những ly cocktail thủ công và các món ăn được chế biến tinh tế trong một không gian đầy cảm hứng.', 'Experience handcrafted cocktails and delicately prepared delicacies in an inspiring ambiance.')))) : 'MENU';

$raw_dish = function_exists('otr_get_field') ? otr_get_field('menu_hero_photo_dish', $current_id) : '';
$photo_dish = ! empty($raw_dish) ? $raw_dish : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop';

$raw_cocktail = function_exists('otr_get_field') ? otr_get_field('menu_hero_photo_cocktail', $current_id) : '';
$photo_cocktail = ! empty($raw_cocktail) ? $raw_cocktail : 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=800&auto=format&fit=crop';

// 2. Lấy dữ liệu Cây Thực Đơn Menu TheRocks
$menu_tree = function_exists('otr_get_therocks_menu_tree') ? otr_get_therocks_menu_tree() : array();
?>

<section class="w-full bg-[#080604] text-[#caa875] pt-28 sm:pt-36 md:pt-40 pb-24 md:pb-32 font-serif">
    
    <!-- KHỐI MỞ ĐẦU (MENU HERO INTRO) -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 md:px-14 lg:px-16 mb-14 md:mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <!-- Cột trái: Tiêu đề & Đoạn tựa -->
            <div class="lg:col-span-6 flex flex-col justify-center">
                <h1 class="font-serif font-light text-[#caa875] text-5xl sm:text-6xl md:text-7xl lg:text-[86px] uppercase tracking-[0.02em] leading-[1.05] mb-5 md:mb-6">
                    <?php echo esc_html( $hero_title ); ?>
                </h1>
                <p class="text-[#caa875]/75 text-xs sm:text-sm md:text-base leading-relaxed max-w-lg font-normal font-sans">
                    <?php echo esc_html( $hero_desc ); ?>
                </p>
            </div>

            <!-- Cột phải: 2 Khung ảnh nghệ thuật nằm ngang cạnh nhau -->
            <div class="lg:col-span-6 grid grid-cols-2 gap-4 sm:gap-6">
                
                <!-- Ảnh 1: Đĩa món ăn khai vị tinh tế -->
                <div class="relative aspect-[4/3] rounded-sm overflow-hidden border border-[#caa875]/20 shadow-2xl group">
                    <img src="<?php echo esc_url( $photo_dish ); ?>" alt="On The Rock Gourmet Food" loading="lazy" decoding="async" class="w-full h-full object-cover brightness-[0.9] group-hover:scale-105 group-hover:brightness-100 transition-all duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                </div>

                <!-- Ảnh 2: Ly cocktail hổ phách bên không gian sang trọng -->
                <div class="relative aspect-[4/3] rounded-sm overflow-hidden border border-[#caa875]/20 shadow-2xl group">
                    <img src="<?php echo esc_url( $photo_cocktail ); ?>" alt="On The Rock Cocktail Bar" loading="lazy" decoding="async" class="w-full h-full object-cover brightness-[0.9] group-hover:scale-105 group-hover:brightness-100 transition-all duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                </div>

            </div>

        </div>
    </div>

    <!-- DANH SÁCH MENU CHA DẠNG HÀNG XỔ XUỐNG (CHUẨN 100% THEO HÌNH ẢNH MẪU) -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 md:px-14 lg:px-16 menu-accordion-container">
        <?php 
        $cha_idx = 0;
        foreach ($menu_tree as $cha_id => $cha): 
            $children = !empty($cha['children']) && is_array($cha['children']) ? $cha['children'] : array();
            $cha_display_title = function_exists('otr_t_menu') ? otr_t_menu($cha, 'title') : $cha['title'];
            $cha_display_desc  = function_exists('otr_t_menu') ? otr_t_menu($cha, 'desc') : ($cha['desc'] ?? '');
        ?>
            <!-- Đường kẻ nét đứt ngăn cách -->
            <div class="w-full border-t border-dashed border-[#caa875]/30"></div>

            <!-- HÀNG TIÊU ĐỀ MENU CHA (Click để xổ xuống) -->
            <div class="menu-accordion-row group py-8 sm:py-10 md:py-12 cursor-pointer flex items-center justify-between transition-colors duration-300 select-none scroll-mt-28 md:scroll-mt-36"
                 id="menu-cha-row-<?php echo esc_attr($cha_id); ?>"
                 data-cha-id="<?php echo esc_attr($cha_id); ?>">
                
                <div class="transition-transform duration-300 group-hover:translate-x-2">
                    <!-- Số thứ tự: 01, 02, 03... -->
                    <span class="block text-[#caa875]/70 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1.5 sm:mb-2">
                        <?php echo esc_html($cha['num'] ?? sprintf('%02d', $cha_idx + 1)); ?>
                    </span>

                    <!-- Tiêu đề Menu Cha: BESPOKE COCKTAIL, CLASSIC COCKTAIL, SHOTS... -->
                    <h2 class="menu-accordion-title text-[#caa875] text-4xl sm:text-5xl md:text-6xl lg:text-7xl uppercase group-hover:text-white transition-colors duration-300">
                        <?php echo esc_html($cha_display_title); ?>
                    </h2>
                </div>

                <!-- Biểu tượng mũi tên mở rộng xoay 180 độ khi mở -->
                <div class="shrink-0 pl-4 text-[#caa875]/70 group-hover:text-white transition-all duration-300">
                    <svg class="menu-accordion-arrow w-7 h-7 sm:w-9 sm:h-9 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>

            </div>

            <!-- BẢNG CHI TIẾT BUNG RA NGAY DƯỚI DÒNG MENU KHI CLICK (XỔ XUỐNG) -->
            <div class="menu-accordion-panel pb-14 md:pb-20 transition-all duration-500 hidden"
                 id="menu-panel-<?php echo esc_attr($cha_id); ?>"
                 data-cha-panel="<?php echo esc_attr($cha_id); ?>">
                
                <!-- Mô tả ngắn của Menu Cha (nếu có) -->
                <?php if (!empty($cha_display_desc)): ?>
                    <p class="text-[#caa875]/75 text-xs sm:text-sm md:text-base leading-relaxed max-w-2xl mb-8 font-sans font-light">
                        <?php echo esc_html($cha_display_desc); ?>
                    </p>
                <?php endif; ?>

                <!-- THANH XỔ TAB CÁC MENU CON (NẾU CÓ TỪ 2 MENU CON TRỞ LÊN) -->
                <?php if (!empty($children) && count($children) > 1): ?>
                    <div class="menu-con-tabs-container mb-8 sm:mb-10 select-none">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <span class="text-xs uppercase tracking-[0.2em] text-[#caa875]/60 mr-2"><?php echo esc_html( otr_t('✦ PHÂN LOẠI:', '✦ CATEGORY:') ); ?></span>
                            <?php 
                            $sub_i = 0;
                            foreach ($children as $con_id => $con): 
                                $is_sub_active = ($sub_i === 0);
                                $con_tab_title = function_exists('otr_t_menu') ? otr_t_menu($con, 'title') : $con['title'];
                            ?>
                                <button type="button" 
                                        class="menu-con-subtab-btn btn-liquid-glass px-5 sm:px-7 py-2.5 sm:py-3 text-[11px] sm:text-xs tracking-[0.18em] uppercase transition-all duration-300 cursor-pointer <?php echo $is_sub_active ? '!border-[#caa875] is-active' : ''; ?>"
                                        data-parent-cha="<?php echo esc_attr($cha_id); ?>"
                                        data-con-target="<?php echo esc_attr($con_id); ?>">
                                    <span class="btn-roll-wrap">
                                        <span class="btn-roll-text">
                                            <span><?php echo esc_html($con_tab_title); ?></span>
                                            <span aria-hidden="true"><?php echo esc_html($con_tab_title); ?></span>
                                        </span>
                                    </span>
                                </button>
                            <?php 
                                $sub_i++;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- NỘI DUNG TỪNG MENU CON THEO BỐ CỤC ĐÃ CHỌN (KIỂU 1, 2, 3) -->
                <?php if (!empty($children)): ?>
                    <div class="menu-con-contents-wrap">
                        <?php 
                        $sub_i = 0;
                        foreach ($children as $con_id => $con): 
                            $is_sub_visible = ($sub_i === 0);
                            $con_layout = !empty($con['layout']) ? $con['layout'] : (!empty($cha['layout']) ? $cha['layout'] : 'layout_3');
                        ?>
                            <div class="menu-con-view-panel <?php echo $is_sub_visible ? '' : 'hidden'; ?>"
                                 data-parent-cha="<?php echo esc_attr($cha_id); ?>"
                                 data-con-view="<?php echo esc_attr($con_id); ?>">
                                <?php 
                                switch ($con_layout) {
                                    case 'layout_1':
                                        get_template_part('template-parts/sections/menu/layout-1-showcase', null, array('con' => $con, 'cha' => $cha));
                                        break;
                                    case 'layout_2':
                                        get_template_part('template-parts/sections/menu/layout-2-sidebar', null, array('con' => $con, 'cha' => $cha));
                                        break;
                                    case 'layout_3':
                                    default:
                                        get_template_part('template-parts/sections/menu/layout-3-columns', null, array('con' => $con, 'cha' => $cha));
                                        break;
                                }
                                ?>
                            </div>
                        <?php 
                            $sub_i++;
                        endforeach; 
                        ?>
                    </div>
                <?php else: ?>
                    <div class="py-10 text-center border border-dashed border-[#caa875]/20 rounded">
                        <p class="text-xs text-[#caa875]/60 italic font-sans">
                            ✦ Mục thực đơn này đang được cập nhật thêm món. Quý khách vui lòng chọn các mục khác!
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        <?php 
            $cha_idx++;
        endforeach; 
        ?>
        <!-- Đường kẻ nét đứt kết thúc phân mục cuối cùng -->
        <div class="w-full border-t border-dashed border-[#caa875]/30"></div>
    </div>

    <!-- MODAL CHI TIẾT MÓN ĂN / ĐỒ UỐNG DÀNH CHO KIỂU 2 & KIỂU 3 -->
    <?php get_template_part('template-parts/sections/menu/modal-item-detail'); ?>

</section>
