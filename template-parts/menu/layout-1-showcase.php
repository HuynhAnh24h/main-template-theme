<?php
/**
 * Menu Layout 1: Interactive Showcase Card & Slider Ảnh
 * Description: Danh sách phân mục dạng Accordion bung mở tại chỗ, kèm bảng ghi chú hương vị và Slider hình ảnh ly cocktail.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Dữ liệu các phân mục Menu cho Kiểu 1
$categories = array(
    array(
        'id'    => '01',
        'title' => 'BESPOKE COCKTAIL',
        'subtabs' => array(
            array(
                'key'   => 'bespoke_craft',
                'name'  => 'SIGNATURE CRAFT',
                'price' => '320k',
                'tag'   => 'BESPOKE',
                'spirits' => array(
                    'Base:'    => 'Single Malt Scotch',
                    'Infuse:'  => 'Toasted Cinnamon Bark',
                    'Bitters:' => 'Black Walnut Bitters',
                    'Sweet:'   => 'Smoked Honey Syrup',
                    'Citrus:'  => 'Dehydrated Blood Orange',
                    'Glass:'   => 'Hand-carved Rock Crystal',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'High',
                'images' => array(
                    'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
                )
            ),
            array(
                'key'   => 'bespoke_sour',
                'name'  => 'CUSTOM PALATE',
                'price' => '340k',
                'tag'   => 'BESPOKE',
                'spirits' => array(
                    'Base:'    => 'Mezcal Artisanal',
                    'Herbal:'  => 'Fresh Rosemary Smoke',
                    'Cordial:' => 'Hibiscus Agave Cordial',
                    'Acid:'    => 'Yuzu Acid Solution',
                    'Mist:'    => 'Absinthe Atomizer Mist',
                    'Ice:'     => 'Clear Block Ice Hand-Cut',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'Medium',
                'images' => array(
                    'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
                )
            ),
        ),
    ),
    array(
        'id'    => '02',
        'title' => 'CLASSIC COCKTAIL',
        'subtabs' => array(
            array(
                'key'   => 'classic',
                'name'  => 'CLASSIC COCKTAIL',
                'price' => '299k',
                'tag'   => 'CLASSIC',
                'spirits' => array(
                    'Gin:'     => 'Bulldog',
                    'Rum:'     => 'Mount Gay Eclipse',
                    'Vodka:'   => 'Riga Black',
                    'Tequila:' => 'Lunazul Blanco',
                    'Whiskey:' => 'JW Black Label',
                    'Bourbon:' => 'Evan Williams White',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'Medium',
                'images' => array(
                    'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                )
            ),
            array(
                'key'   => 'deluxe',
                'name'  => 'DELUXE COCKTAIL',
                'price' => '369k',
                'tag'   => 'DELUXE',
                'spirits' => array(
                    'Gin:'     => 'Hendrick\'s Orbium',
                    'Rum:'     => 'Zacapa 23 Centenario',
                    'Vodka:'   => 'Belvedere Pure',
                    'Tequila:' => 'Don Julio Reposado',
                    'Whiskey:' => 'Macallan 12 Double Cask',
                    'Bourbon:' => 'Woodford Reserve',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'High',
                'images' => array(
                    'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1541544741938-0af808871cc0?q=80&w=1000&auto=format&fit=crop',
                )
            ),
            array(
                'key'   => 'premium',
                'name'  => 'PREMIUM COCKTAIL',
                'price' => '450k',
                'tag'   => 'PREMIUM',
                'spirits' => array(
                    'Gin:'     => 'Monkey 47 Schwarzwald',
                    'Rum:'     => 'Diplomático Ambassador',
                    'Vodka:'   => 'Grey Goose VX',
                    'Tequila:' => 'Clase Azul Reposado',
                    'Whiskey:' => 'Hibiki Japanese Harmony',
                    'Cognac:'  => 'Hennessy XO Rare',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'High',
                'images' => array(
                    'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
                )
            ),
        ),
    ),
    array(
        'id'    => '03',
        'title' => 'SIGNATURE COCKTAIL',
        'subtabs' => array(
            array(
                'key'   => 'signature_special',
                'name'  => 'OTR SIGNATURES',
                'price' => '329k',
                'tag'   => 'SIGNATURE',
                'spirits' => array(
                    'Whiskey:' => 'Peated Highland Single Malt',
                    'Liqueur:' => 'Dalat Pine Needle Cordial',
                    'Tea:'     => 'Oolong Artisanal Coldbrew',
                    'Smoke:'   => 'Applewood Barrel Smoke',
                    'Garnish:' => 'Gold Flakes & Dried Fig',
                    'Finish:'  => 'Smoked Citrus Salt Rim',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'Medium',
                'images' => array(
                    'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                )
            ),
        ),
    ),
    array(
        'id'    => '04',
        'title' => 'FOOD & BAR BITES',
        'subtabs' => array(
            array(
                'key'   => 'food_delicacy',
                'name'  => 'GOURMET BITES',
                'price' => '189k - 380k',
                'tag'   => 'CUISINE',
                'spirits' => array(
                    'Cold Cut:' => 'Ibérico Ham 36 Months',
                    'Cheese:'   => 'Truffle Brie & Aged Gouda',
                    'Seafood:'  => 'Hokkaido Scallop Carpaccio',
                    'Beef:'     => 'Wagyu A5 Tartare Crisps',
                    'Bread:'    => 'Wild Yeast Dalat Sourdough',
                    'Dip:'      => 'Smoked Black Garlic Aioli',
                ),
                'flavors' => array(
                    'Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty',
                    'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'
                ),
                'alcohol' => 'Low',
                'images' => array(
                    'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1000&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop',
                ),
            ),
        ),
    ),
);

// Nạp dữ liệu động từ Custom Post Type & Taxonomy (Nếu có)
$dynamic_data = function_exists('otr_get_menu_data') ? otr_get_menu_data() : array();
if ( ! empty( $dynamic_data ) ) {
    $categories = array_values($dynamic_data);
}
?>

<div class="menu-layout-1-wrapper">
    <?php foreach ( $categories as $index => $cat ) : ?>
        
        <!-- Đường kẻ nét đứt ngăn cách -->
        <div class="w-full border-t border-dashed border-[#caa875]/25"></div>

        <!-- Hàng tiêu đề phân mục (Click để bung/gập, có scroll-mt chống bị che bởi header) -->
        <div class="menu-category-row group py-8 sm:py-10 md:py-12 cursor-pointer flex items-center justify-between transition-colors duration-300 select-none scroll-mt-28 md:scroll-mt-36 <?php echo ( $cat['id'] === '02' ) ? 'is-open' : ''; ?>" 
             id="menu-cat-row-<?php echo esc_attr( $cat['id'] ); ?>"
             data-category-id="<?php echo esc_attr( $cat['id'] ); ?>">
            <div>
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1.5 sm:mb-2">
                    <?php echo esc_html( $cat['id'] ); ?>
                </span>
                <h2 class="font-serif font-light text-[#caa875] text-3xl sm:text-4xl md:text-5xl lg:text-6xl uppercase tracking-[0.03em] group-hover:text-white group-hover:translate-x-3 transition-all duration-300">
                    <?php echo esc_html( $cat['title'] ); ?>
                </h2>
            </div>

            <!-- Biểu tượng mũi tên mở rộng -->
            <div class="shrink-0 pl-4 text-[#caa875]/70 group-hover:text-white transition-colors duration-300">
                <svg class="menu-row-arrow w-6 h-6 sm:w-8 sm:h-8 transition-transform duration-500 <?php echo ( $cat['id'] === '02' ) ? 'rotate-180' : ''; ?>" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        <!-- BẢNG CHI TIẾT BUNG RA NGAY DƯỚI DÒNG MENU KHI CLICK (Scroll-mt chống bị che) -->
        <div class="menu-category-panel pb-14 md:pb-20 transition-all duration-500 overflow-hidden scroll-mt-28 md:scroll-mt-36 <?php echo ( $cat['id'] === '02' ) ? '' : 'hidden'; ?>" 
             data-category-id="<?php echo esc_attr( $cat['id'] ); ?>">
            
            <!-- 1. Thanh Tab phân loại (Classic / Deluxe / Premium) -->
            <?php if ( count( $cat['subtabs'] ) > 1 ) : ?>
            <div class="flex flex-wrap items-center gap-0 mb-6 sm:mb-8 select-none">
                <?php foreach ( $cat['subtabs'] as $s_idx => $sub ) : ?>
                    <button type="button" 
                            class="menu-subtab-btn px-5 sm:px-7 py-2.5 sm:py-3 text-[11px] sm:text-xs tracking-[0.15em] uppercase transition-all duration-300 cursor-pointer border border-[#caa875]/35 <?php echo ( $s_idx === 0 ) ? 'bg-[#c8a773] text-[#1a120b] font-semibold border-[#c8a773]' : 'bg-transparent text-[#caa875] border-dashed hover:border-[#caa875]'; ?>"
                            data-subtab="<?php echo esc_attr( $sub['key'] ); ?>">
                        <?php echo esc_html( $sub['name'] ); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- 2. Nội dung chi tiết cho từng Tab -->
            <?php foreach ( $cat['subtabs'] as $s_idx => $sub ) : ?>
                <div class="subtab-content-view <?php echo ( $s_idx === 0 ) ? '' : 'hidden'; ?>" data-subtab-view="<?php echo esc_attr( $sub['key'] ); ?>">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 border border-[#caa875]/25 shadow-2xl bg-[#140e08]">
                        
                        <!-- CỘT TRÁI: BẢNG TRA CỨU HƯƠNG VỊ & NỀN RƯỢU -->
                        <div class="lg:col-span-5 bg-[#26180a] p-6 sm:p-8 md:p-9 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-[#caa875]/20">
                            
                            <!-- Header tên nhóm & Giá tiền -->
                            <div class="flex items-baseline justify-between border-b border-[#caa875]/25 pb-3 mb-6">
                                <h3 class="font-serif font-light text-[#caa875] text-2xl sm:text-3xl tracking-[0.04em] uppercase">
                                    <?php echo esc_html( $sub['tag'] ); ?>
                                </h3>
                                <span class="font-serif text-[#caa875] text-lg sm:text-xl tracking-wider font-medium">
                                    <?php echo esc_html( $sub['price'] ); ?>
                                </span>
                            </div>

                            <!-- Khối 1: Chọn nền rượu / Spirits -->
                            <div class="mb-6">
                                <h4 class="text-[#caa875]/80 text-xs sm:text-[13px] font-normal tracking-[0.06em] mb-2.5">
                                    Chọn nền rượu / Flavor Combinations
                                </h4>
                                <div class="border border-[#caa875]/20 divide-y divide-[#caa875]/15 text-xs sm:text-[13px]">
                                    <?php foreach ( $sub['spirits'] as $base => $brand ) : ?>
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
                                    $f_count = count($sub['flavors']);
                                    foreach ( $sub['flavors'] as $f_idx => $flavor ) : 
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
                                        $isActive = ($lvl === $sub['alcohol']);
                                    ?>
                                        <button type="button" class="alcohol-level-pill py-2.5 transition-colors cursor-pointer select-none <?php echo $isActive ? 'bg-[#caa875] text-[#171009] font-bold' : 'text-[#caa875] hover:bg-[#caa875]/10'; ?>">
                                            <?php echo esc_html( $lvl ); ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                        <!-- CỘT PHẢI: SLIDER TRÌNH DIỄN HÌNH ẢNH COCKTAIL KHỔ LỚN -->
                        <div class="lg:col-span-7 relative flex items-center justify-center bg-gradient-to-br from-[#120b06] via-[#1c120a] to-[#0a0704] p-6 sm:p-10 md:p-12 min-h-[460px] lg:min-h-[580px] overflow-hidden cocktail-slider-wrap">
                            
                            <!-- Danh sách hình ảnh Cocktail chuyển động -->
                            <div class="relative w-full h-full max-w-lg aspect-square flex items-center justify-center">
                                <?php foreach ( $sub['images'] as $img_idx => $c_img ) : ?>
                                    <div class="cocktail-slide absolute inset-0 flex items-center justify-center transition-all duration-700 ease-out <?php echo ($img_idx === 0) ? 'opacity-100 scale-100' : 'opacity-0 pointer-events-none scale-95'; ?>">
                                        <img src="<?php echo esc_url( $c_img ); ?>" 
                                             alt="Cocktail <?php echo esc_attr( $sub['name'] ); ?>" 
                                             class="max-w-full max-h-full object-contain drop-shadow-[0_20px_40px_rgba(0,0,0,0.85)] filter brightness-[0.95]">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Nút chuyển Slide bên trái (←) -->
                            <button type="button" 
                                    class="slider-btn-prev absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-black/60 border border-[#caa875]/40 text-[#caa875] flex items-center justify-center hover:bg-[#caa875] hover:text-black transition-all duration-300 shadow-2xl cursor-pointer z-10"
                                    aria-label="Previous Cocktail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                </svg>
                            </button>

                            <!-- Nút chuyển Slide bên phải (→) -->
                            <button type="button" 
                                    class="slider-btn-next absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-black/60 border border-[#caa875]/40 text-[#caa875] flex items-center justify-center hover:bg-[#caa875] hover:text-black transition-all duration-300 shadow-2xl cursor-pointer z-10"
                                    aria-label="Next Cocktail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </button>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endforeach; ?>

    <!-- Đường kẻ nét đứt kết thúc danh sách -->
    <div class="w-full border-t border-dashed border-[#caa875]/25"></div>
</div>
