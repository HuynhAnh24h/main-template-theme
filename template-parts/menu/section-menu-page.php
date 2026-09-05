<?php
/**
 * Template Part: Section Menu Page
 * Description: Giao diện trang Menu với Hero 2 ảnh nghệ thuật, thanh chuyển đổi Bố cục (Layout 1, 2, 3) 
 * và nạp động template tương ứng theo ACF / URL parameter.
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
$hero_title = get_field('menu_page_title', $current_id) ?: (get_field('menu_page_title', $front_page_id) ?: 'MENU');
$hero_desc  = get_field('menu_page_desc', $current_id) ?: (get_field('menu_page_desc', $front_page_id) ?: 'Thưởng thức những ly cocktail thủ công và các món ăn được chế biến tinh tế trong một không gian đầy cảm hứng.');

$photo_dish     = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop';
$photo_cocktail = 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=800&auto=format&fit=crop';

// 2. Xác định kiểu hiển thị Menu (ACF Custom Field)
$layout_choice = 'layout_3'; // Mặc định là Kiểu 3 (Classic Cocktail)

// Ưu tiên đọc cấu hình lưu từ ACF của trang Menu
$acf_layout = get_field( 'menu_display_layout', $current_id );
if ( empty( $acf_layout ) && ! empty( $front_page_id ) ) {
    $acf_layout = get_field( 'menu_display_layout', $front_page_id );
}
if ( ! empty( $acf_layout ) ) {
    $layout_choice = $acf_layout;
}

// Hỗ trợ tham số URL bí mật ?layout=1|2|3 nếu có truyền vào
if ( isset( $_GET['layout'] ) ) {
    $param_layout = sanitize_text_field( wp_unslash( $_GET['layout'] ) );
    if ( in_array( $param_layout, array( '1', '2', '3', 'layout_1', 'layout_2', 'layout_3' ), true ) ) {
        $layout_choice = ( strpos( $param_layout, 'layout_' ) === 0 ) ? $param_layout : 'layout_' . $param_layout;
    }
}
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
                    <img src="<?php echo esc_url( $photo_dish ); ?>" alt="On The Rock Gourmet Food" class="w-full h-full object-cover brightness-[0.9] group-hover:scale-105 group-hover:brightness-100 transition-all duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                </div>

                <!-- Ảnh 2: Ly cocktail hổ phách bên không gian sang trọng -->
                <div class="relative aspect-[4/3] rounded-sm overflow-hidden border border-[#caa875]/20 shadow-2xl group">
                    <img src="<?php echo esc_url( $photo_cocktail ); ?>" alt="On The Rock Cocktail Bar" class="w-full h-full object-cover brightness-[0.9] group-hover:scale-105 group-hover:brightness-100 transition-all duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                </div>

            </div>

        </div>
    </div>

    <!-- NẠP BỐ CỤC THEO CẤU HÌNH TRONG ADMIN -->
    <div class="max-w-[1440px] mx-auto px-6 sm:px-10 md:px-14 lg:px-16">
        <?php 
        switch ( $layout_choice ) {
            case 'layout_1':
                get_template_part( 'template-parts/menu/layout-1-showcase' );
                break;
            case 'layout_2':
                get_template_part( 'template-parts/menu/layout-2-sidebar' );
                break;
            case 'layout_3':
            default:
                get_template_part( 'template-parts/menu/layout-3-columns' );
                break;
        }
        ?>
    </div>

</section>
