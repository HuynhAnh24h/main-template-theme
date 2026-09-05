<?php
/**
 * Menu Layout 3: Danh sách cột theo nhóm rượu (Classic Spirit Columns)
 * Description: Khớp 100% theo hình ảnh người dùng tải lên (media_1788577150765.png).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$categories_data = array(
    '02' => array(
        'num'   => '02',
        'title' => 'CLASSIC COCKTAIL',
        'subtabs' => array(
            'classic_standard' => array(
                'tab_name' => 'CLASSIC COCKTAIL',
                'header'   => 'CLASSIC COCKTAIL',
                'columns'  => array(
                    array(
                        'spirit' => 'WHISKY',
                        'drinks' => array(
                            array('name' => 'Boulevardier',       'price' => '199k'),
                            array('name' => 'Godfather',          'price' => '199k'),
                            array('name' => 'Highball',           'price' => '199k'),
                            array('name' => 'Manhattan',          'price' => '199k'),
                            array('name' => 'Morning Glory Fizz', 'price' => '199k'),
                            array('name' => 'New York Sour',      'price' => '199k'),
                        ),
                    ),
                    array(
                        'spirit' => 'GIN',
                        'drinks' => array(
                            array('name' => 'Clover Club',        'price' => '199k'),
                            array('name' => 'Dry Martini',        'price' => '199k'),
                            array('name' => 'Gimlet',             'price' => '199k'),
                            array('name' => 'Gin Fizz',           'price' => '199k'),
                            array('name' => 'Gin Tonic',          'price' => '199k'),
                            array('name' => 'James Bond',         'price' => '199k'),
                        ),
                    ),
                ),
            ),
            'classic_premium' => array(
                'tab_name' => 'CLASSIC PREMIUM',
                'header'   => 'CLASSIC PREMIUM',
                'columns'  => array(
                    array(
                        'spirit' => 'RUM & TEQUILA',
                        'drinks' => array(
                            array('name' => 'Zacapa Old Fashioned', 'price' => '280k'),
                            array('name' => 'Smoked Paloma',        'price' => '260k'),
                            array('name' => 'Dark & Stormy Reserve','price' => '250k'),
                            array('name' => 'Tommy\'s Margarita',   'price' => '250k'),
                            array('name' => 'Mai Tai Plantation',   'price' => '270k'),
                            array('name' => 'Anejo Manhattan',      'price' => '290k'),
                        ),
                    ),
                    array(
                        'spirit' => 'SINGLE MALT & COGNAC',
                        'drinks' => array(
                            array('name' => 'Macallan Rob Roy',     'price' => '350k'),
                            array('name' => 'Sazerac XO',           'price' => '320k'),
                            array('name' => 'Sidecar Rare Cask',    'price' => '310k'),
                            array('name' => 'Vieux Carré Heritage', 'price' => '340k'),
                            array('name' => 'Penicillin Islay Peat','price' => '290k'),
                            array('name' => 'Blood and Sand',       'price' => '280k'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    '01' => array(
        'num'   => '01',
        'title' => 'BESPOKE COCKTAIL',
        'subtabs' => array(
            'bespoke_all' => array(
                'tab_name' => 'BESPOKE ARTISAN',
                'header'   => 'BESPOKE COCKTAIL COLLECTION',
                'columns'  => array(
                    array(
                        'spirit' => 'HERBAL & FLORAL',
                        'drinks' => array(
                            array('name' => 'Dalat Pine Mist',      'price' => '320k'),
                            array('name' => 'Artisanal Rosemary',   'price' => '290k'),
                            array('name' => 'Lavender Smoke Sour',  'price' => '310k'),
                            array('name' => 'Chamomile Highball',   'price' => '280k'),
                        ),
                    ),
                    array(
                        'spirit' => 'BARREL AGED & SMOKED',
                        'drinks' => array(
                            array('name' => 'Smoked Honey Negroni', 'price' => '340k'),
                            array('name' => 'Cinnamon Apple Sazerac','price' => '350k'),
                            array('name' => 'Leather & Cigar Peat', 'price' => '380k'),
                            array('name' => 'Dark Truffle Boulevard','price' => '360k'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    '03' => array(
        'num'   => '03',
        'title' => 'SIGNATURE COCKTAIL',
        'subtabs' => array(
            'signature_all' => array(
                'tab_name' => 'HOUSE SIGNATURES',
                'header'   => 'ON THE ROCK HOUSE SIGNATURES',
                'columns'  => array(
                    array(
                        'spirit' => 'REFRESHING & CITRUS',
                        'drinks' => array(
                            array('name' => 'Foggy Dalat Valley',   'price' => '299k'),
                            array('name' => 'Sunset Over Truc Lam', 'price' => '299k'),
                            array('name' => 'Langbiang Golden Hour','price' => '319k'),
                        ),
                    ),
                    array(
                        'spirit' => 'COMPLEX & RICH',
                        'drinks' => array(
                            array('name' => 'Midnight In The Rocks','price' => '329k'),
                            array('name' => 'The Alchemist Secret', 'price' => '349k'),
                            array('name' => 'Golden Velvet Dreams', 'price' => '329k'),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

// Nạp dữ liệu động từ Custom Post Type & Taxonomy (Nếu có)
$dynamic_data = function_exists('otr_get_menu_data') ? otr_get_menu_data() : array();
if ( ! empty( $dynamic_data ) ) {
    $categories_data = $dynamic_data;
}
?>

<div class="menu-layout-3-wrapper space-y-16 md:space-y-24">
    
    <?php foreach ( $categories_data as $cat_key => $cat ) : ?>
        <div class="menu-cat-block scroll-mt-28 md:scroll-mt-32" id="menu-cat-<?php echo esc_attr( $cat_key ); ?>">
            
            <!-- Tiêu đề phân mục lớn -->
            <div class="mb-8 md:mb-10">
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1">
                    <?php echo esc_html( $cat['num'] ); ?>
                </span>
                <h2 class="font-serif font-light text-[#caa875] text-4xl sm:text-5xl md:text-6xl uppercase tracking-[0.03em]">
                    <?php echo esc_html( $cat['title'] ); ?>
                </h2>
            </div>

            <!-- Khung bao gồm Tabs bên trái và 2 cột thực đơn bên phải -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Nhóm Tab Subcategory (Bên trái) -->
                <div class="lg:col-span-3 flex flex-col gap-2.5 sm:gap-3 select-none">
                    <?php 
                    $t_idx = 0;
                    foreach ( $cat['subtabs'] as $sub_key => $sub ) : 
                        $isActiveTab = ($t_idx === 0);
                    ?>
                        <button type="button" 
                                class="menu-layout3-tab-btn px-5 sm:px-6 py-3.5 text-xs sm:text-[13px] tracking-[0.14em] uppercase text-left transition-all duration-300 cursor-pointer <?php echo $isActiveTab ? 'bg-[#c8a773] text-[#1a120b] font-semibold border border-[#c8a773] shadow-lg' : 'bg-[#211508]/80 text-[#caa875] border border-dashed border-[#caa875]/30 hover:border-[#caa875]'; ?>"
                                data-target-group="<?php echo esc_attr( $cat_key ); ?>"
                                data-target-subtab="<?php echo esc_attr( $sub_key ); ?>">
                            <?php echo esc_html( $sub['tab_name'] ); ?>
                        </button>
                    <?php 
                        $t_idx++;
                    endforeach; 
                    ?>
                </div>

                <!-- Bảng thực đơn 2 cột (Bên phải) -->
                <div class="lg:col-span-9">
                    
                    <?php 
                    $v_idx = 0;
                    foreach ( $cat['subtabs'] as $sub_key => $sub ) : 
                        $isVisible = ($v_idx === 0);
                    ?>
                        <div class="layout3-subtab-view <?php echo $isVisible ? '' : 'hidden'; ?>" 
                             data-group="<?php echo esc_attr( $cat_key ); ?>"
                             data-subtab-view="<?php echo esc_attr( $sub_key ); ?>">
                            
                            <!-- Tiêu đề phụ căn giữa -->
                            <div class="text-center mb-6">
                                <h3 class="text-[#caa875] text-xs sm:text-sm tracking-[0.25em] uppercase font-medium">
                                    <?php echo esc_html( $sub['header'] ); ?>
                                </h3>
                                <div class="w-full border-t border-[#caa875]/20 mt-4 mb-8"></div>
                            </div>

                            <!-- Lưới 2 cột theo từng loại rượu (WHISKY & GIN) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-14 lg:gap-16">
                                
                                <?php foreach ( $sub['columns'] as $col ) : ?>
                                    <div>
                                        <!-- Tên loại rượu (WHISKY, GIN,...) -->
                                        <h4 class="font-serif font-light text-[#caa875] text-2xl sm:text-3xl uppercase tracking-[0.05em] mb-6">
                                            <?php echo esc_html( $col['spirit'] ); ?>
                                        </h4>

                                        <!-- Danh sách món & Giá -->
                                        <div class="divide-y divide-[#caa875]/10 border-t border-b border-[#caa875]/10">
                                            <?php foreach ( $col['drinks'] as $drink ) : ?>
                                                <div class="flex items-center justify-between py-3 sm:py-3.5 group hover:bg-[#caa875]/5 px-1 sm:px-2 rounded transition-colors duration-200">
                                                    <span class="text-[#d8c19d] text-sm sm:text-[15px] font-normal tracking-wide group-hover:text-white transition-colors">
                                                        <?php echo esc_html( $drink['name'] ); ?>
                                                    </span>
                                                    <span class="text-[#caa875] text-xs sm:text-sm tracking-wider font-medium font-serif shrink-0 ml-4">
                                                        <?php echo esc_html( $drink['price'] ); ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    <?php 
                        $v_idx++;
                    endforeach; 
                    ?>

                </div>

            </div>

            <!-- Đường kẻ nét đứt ngăn cách các phân mục -->
            <div class="w-full border-t border-dashed border-[#caa875]/20 mt-14 md:mt-20"></div>

        </div>
    <?php endforeach; ?>

</div>
