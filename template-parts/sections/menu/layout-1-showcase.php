<?php
/**
 * Menu Layout 1: Interactive Showcase Card & Slider Ảnh
 * Description: Bảng ghi chú nốt vị cocktail, nền rượu, độ cồn và slider ảnh khổ lớn.
 * Hỗ trợ nạp dữ liệu động từ Menu TheRocks (Level 2: Menu Con).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$single_con = $args['con'] ?? null;
$parent_cha = $args['cha'] ?? null;

// ================= CHẾ ĐỘ 1: RENDER TRỰC TIẾP CHO 1 MENU CON ================= //
if ( ! empty( $single_con ) ) {
    $con_title   = $single_con['title'] ?? 'Cocktail';
    $con_tag     = !empty($single_con['tag']) ? $single_con['tag'] : $con_title;
    $con_price   = !empty($single_con['price']) ? $single_con['price'] : '320k';
    $con_alcohol = !empty($single_con['alcohol']) ? $single_con['alcohol'] : 'Medium';
    
    // Nền rượu (Spirits)
    $spirits = !empty($single_con['spirits']) && is_array($single_con['spirits']) ? $single_con['spirits'] : array(
        'Base:'    => 'Single Malt Scotch',
        'Infuse:'  => 'Toasted Cinnamon Bark',
        'Bitters:' => 'Black Walnut Bitters',
        'Sweet:'   => 'Smoked Honey Syrup',
        'Citrus:'  => 'Dehydrated Blood Orange',
        'Glass:'   => 'Hand-carved Rock Crystal',
    );

    // Nốt hương vị (Flavors)
    $flavors = !empty($single_con['flavors']) && is_array($single_con['flavors']) ? $single_con['flavors'] : array(
        'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
        'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
    );

    // Hình ảnh Slider
    $images = !empty($single_con['images']) && is_array($single_con['images']) ? $single_con['images'] : array();
    if (empty($images) && !empty($parent_cha['image'])) {
        $images[] = $parent_cha['image'];
    }
    if (empty($images)) {
        $images = array(
            'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
        );
    }

    // Danh sách món con (nếu có từ Menu Con Con)
    $sub_items = array();
    if (!empty($single_con['sub_children']) && is_array($single_con['sub_children'])) {
        foreach ($single_con['sub_children'] as $concon) {
            if (!empty($concon['items']) && is_array($concon['items'])) {
                foreach ($concon['items'] as $it) {
                    $sub_items[] = $it;
                }
            }
        }
    }
    ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 border border-[#caa875]/25 shadow-2xl bg-[#140e08]">
        
        <!-- CỘT TRÁI: BẢNG TRA CỨU HƯƠNG VỊ & NỀN RƯỢU -->
        <div class="lg:col-span-5 bg-[#26180a] p-6 sm:p-8 md:p-9 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-[#caa875]/20">
            
            <!-- Header tên nhóm & Giá tiền -->
            <div class="flex items-baseline justify-between border-b border-[#caa875]/25 pb-3 mb-6">
                <div>
                    <h3 class="font-serif font-light text-[#caa875] text-2xl sm:text-3xl tracking-[0.04em] uppercase">
                        <?php echo esc_html( $con_tag ); ?>
                    </h3>
                    <?php if (!empty($single_con['desc'])): ?>
                        <p class="text-[#caa875]/60 text-xs mt-1 font-sans font-light">
                            <?php echo esc_html($single_con['desc']); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <span class="font-serif text-[#caa875] text-lg sm:text-xl tracking-wider font-medium shrink-0 ml-3">
                    <?php echo esc_html( $con_price ); ?>
                </span>
            </div>

            <!-- Khối 1: Chọn nền rượu / Spirits -->
            <div class="mb-6">
                <h4 class="text-[#caa875]/80 text-xs sm:text-[13px] font-normal tracking-[0.06em] mb-2.5">
                    Chọn nền rượu / Flavor Combinations
                </h4>
                <div class="border border-[#caa875]/20 divide-y divide-[#caa875]/15 text-xs sm:text-[13px]">
                    <?php foreach ( $spirits as $base => $brand ) : ?>
                        <div class="flex items-center py-2 px-3 justify-between">
                            <span class="text-[#caa875]/70 w-24 shrink-0"><?php echo esc_html( $base ); ?></span>
                            <span class="text-[#caa875] text-right font-medium"><?php echo esc_html( $brand ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Khối 2: Kết hợp các vị / Flavors -->
            <div class="mb-6">
                <h4 class="text-[#caa875]/80 text-xs sm:text-[13px] font-normal tracking-[0.06em] mb-2.5">
                    Kết hợp các vị / Flavor Combinations
                </h4>
                <div class="grid grid-cols-2 border border-[#caa875]/20 divide-x divide-y divide-[#caa875]/15 text-xs text-center">
                    <?php 
                    $f_count = count($flavors);
                    foreach ( $flavors as $f_idx => $flavor ) : 
                        $is_last_single = ($f_idx === $f_count - 1 && $f_count % 2 !== 0);
                    ?>
                        <div class="flavor-tag-pill py-2 px-2 cursor-pointer hover:bg-[#caa875]/15 transition-colors select-none text-[#caa875] <?php echo $is_last_single ? 'col-span-2' : ''; ?>">
                            <?php echo esc_html( $flavor ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Khối 3: Độ cồn / Alcohol level -->
            <div>
                <h4 class="text-[#caa875]/80 text-xs sm:text-[13px] font-normal tracking-[0.06em] text-center mb-2.5">
                    Độ cồn / Alcohol level
                </h4>
                <div class="alcohol-level-group grid grid-cols-3 border border-[#caa875]/20 divide-x divide-[#caa875]/15 text-xs text-center">
                    <?php 
                    $levels = array('Low', 'Medium', 'High');
                    foreach ( $levels as $lvl ) :
                        $isActive = (strcasecmp($lvl, $con_alcohol) === 0);
                    ?>
                        <button type="button" class="alcohol-level-pill py-2.5 transition-colors cursor-pointer select-none <?php echo $isActive ? 'bg-[#caa875] text-[#171009] font-bold' : 'text-[#caa875] hover:bg-[#caa875]/10'; ?>">
                            <?php echo esc_html( $lvl ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Danh sách món chi tiết (nếu có từ Menu Con Con) -->
            <?php if (!empty($sub_items)): ?>
                <div class="mt-6 pt-5 border-t border-[#caa875]/20">
                    <h4 class="text-[#caa875]/80 text-xs uppercase tracking-[0.12em] mb-3 font-serif">
                        ✦ Danh sách ly đề xuất:
                    </h4>
                    <div class="divide-y divide-[#caa875]/10 border-t border-b border-[#caa875]/10">
                        <?php foreach ($sub_items as $it): ?>
                            <div class="py-2 flex items-baseline justify-between text-xs">
                                <div>
                                    <span class="text-[#d8c19d] font-medium"><?php echo esc_html($it['name']); ?></span>
                                    <?php if (!empty($it['desc'])): ?>
                                        <div class="text-[#caa875]/50 text-[11px]"><?php echo esc_html($it['desc']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <span class="text-[#caa875] font-serif font-medium ml-3 shrink-0"><?php echo esc_html($it['price']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- CỘT PHẢI: SLIDER TRÌNH DIỄN HÌNH ẢNH COCKTAIL KHỔ LỚN -->
        <div class="lg:col-span-7 relative flex items-center justify-center bg-gradient-to-br from-[#120b06] via-[#1c120a] to-[#0a0704] p-6 sm:p-10 md:p-12 min-h-[460px] lg:min-h-[580px] overflow-hidden cocktail-slider-wrap">
            
            <!-- Danh sách hình ảnh Cocktail chuyển động -->
            <div class="relative w-full h-full max-w-lg aspect-square flex items-center justify-center">
                <?php foreach ( $images as $img_idx => $c_img ) : ?>
                    <div class="cocktail-slide absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out <?php echo ($img_idx === 0) ? 'opacity-100 scale-100' : 'opacity-0 pointer-events-none scale-95'; ?>">
                        <img src="<?php echo esc_url( $c_img ); ?>" 
                             alt="<?php echo esc_attr( $con_title ); ?>" 
                             class="max-w-full max-h-full object-contain drop-shadow-[0_20px_40px_rgba(0,0,0,0.85)] filter brightness-[0.95]">
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($images) > 1): ?>
                <!-- Nút chuyển Slide bên trái (←) -->
                <button type="button" 
                        class="otr-slider-btn otr-slider-btn-prev slider-btn-prev"
                        aria-label="Ảnh trước">
                    <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <!-- Nút chuyển Slide bên phải (→) -->
                <button type="button" 
                        class="otr-slider-btn otr-slider-btn-next slider-btn-next"
                        aria-label="Ảnh kế tiếp">
                    <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>

                <!-- Thanh chỉ báo Slide (Dots) phong cách Luxury Lounge -->
                <div class="otr-slider-dots">
                    <?php foreach ($images as $img_idx => $c_img): ?>
                        <button type="button" 
                                class="otr-slider-dot <?php echo ($img_idx === 0) ? 'is-active' : ''; ?>" 
                                data-slide-index="<?php echo $img_idx; ?>" 
                                aria-label="Xem ảnh <?php echo $img_idx + 1; ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
    <?php
    return;
}

// ================= CHẾ ĐỘ 2: FULL TREE THEO KIỂU 1 (KHI GỌI RIÊNG LẺ) ================= //
$tree = function_exists('otr_get_therocks_menu_tree') ? otr_get_therocks_menu_tree() : array();
?>

<div class="menu-layout-1-wrapper">
    <?php foreach ( $tree as $cha_id => $cat ) : ?>
        <div class="w-full border-t border-dashed border-[#caa875]/25"></div>

        <div class="menu-category-row group py-8 sm:py-10 md:py-12 cursor-pointer flex items-center justify-between transition-colors duration-300 select-none scroll-mt-28 md:scroll-mt-36" 
             id="menu-cat-row-<?php echo esc_attr( $cha_id ); ?>"
             data-category-id="<?php echo esc_attr( $cha_id ); ?>">
            <div>
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1.5 sm:mb-2">
                    <?php echo esc_html( $cat['num'] ); ?>
                </span>
                <h2 class="font-serif font-light text-[#caa875] text-3xl sm:text-4xl md:text-5xl lg:text-6xl uppercase tracking-[0.03em] group-hover:text-white group-hover:translate-x-3 transition-all duration-300">
                    <?php echo esc_html( $cat['title'] ); ?>
                </h2>
            </div>

            <div class="shrink-0 pl-4 text-[#caa875]/70 group-hover:text-white transition-colors duration-300">
                <svg class="menu-row-arrow w-6 h-6 sm:w-8 sm:h-8 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        <div class="menu-category-panel pb-14 md:pb-20 transition-all duration-500 overflow-hidden scroll-mt-28 md:scroll-mt-36 hidden" 
             data-category-id="<?php echo esc_attr( $cha_id ); ?>">
            
            <?php if ( !empty($cat['children']) && count( $cat['children'] ) > 1 ) : ?>
            <div class="flex flex-wrap items-center gap-2 mb-6 sm:mb-8 select-none">
                <?php $sub_i = 0; foreach ( $cat['children'] as $con_id => $sub ) : ?>
                    <button type="button" 
                            class="menu-subtab-btn px-5 sm:px-7 py-2.5 sm:py-3 text-[11px] sm:text-xs tracking-[0.15em] uppercase transition-all duration-300 cursor-pointer border border-[#caa875]/35 <?php echo ( $sub_i === 0 ) ? 'bg-[#c8a773] text-[#1a120b] font-semibold border-[#c8a773]' : 'bg-transparent text-[#caa875] border-dashed hover:border-[#caa875]'; ?>"
                            data-subtab="<?php echo esc_attr( $con_id ); ?>">
                        <?php echo esc_html( $sub['title'] ); ?>
                    </button>
                <?php $sub_i++; endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($cat['children'])): ?>
                <?php $sub_i = 0; foreach ( $cat['children'] as $con_id => $sub ) : ?>
                    <div class="subtab-content-view <?php echo ( $sub_i === 0 ) ? '' : 'hidden'; ?>" data-subtab-view="<?php echo esc_attr( $con_id ); ?>">
                        <?php get_template_part('template-parts/sections/menu/layout-1-showcase', null, array('con' => $sub, 'cha' => $cat)); ?>
                    </div>
                <?php $sub_i++; endforeach; ?>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
    <div class="w-full border-t border-dashed border-[#caa875]/25"></div>
</div>
