<?php
/**
 * Menu Layout 2: Sidebar cố định cuộn trang (Sticky Sidebar Scroll)
 * Description: Thanh sidebar bên trái ghim cố định (sticky) khi cuộn chuột, tự động bám theo và dừng lại khi hết menu.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$sidebar_categories = array(
    'cat-bespoke' => array(
        'num'   => '01',
        'name'  => 'BESPOKE COCKTAIL',
        'desc'  => 'Những ly cocktail mang tính độc bản, phối trộn riêng theo cá tính và khẩu vị của từng vị khách.',
        'items' => array(
            array('name' => 'Artisanal Smoked Old Fashioned', 'price' => '320k', 'desc' => 'Peated Highland Malt, Toasted Cinnamon, Smoked Honey'),
            array('name' => 'Dalat Pine Needle Negroni',      'price' => '340k', 'desc' => 'Artisanal Dalat Gin, Campari Infused Pine, Sweet Vermouth'),
            array('name' => 'Truffle Velvet Boulevardier',     'price' => '360k', 'desc' => 'Bourbon Reserve, Black Truffle Bitter, Sweet Vermouth'),
            array('name' => 'Yuzu Blossom Sour',              'price' => '310k', 'desc' => 'Japanese Gin, Yuzu Acid, Egg White Foam, Gold Flakes'),
        ),
        'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
    ),
    'cat-classic' => array(
        'num'   => '02',
        'name'  => 'CLASSIC COCKTAIL',
        'desc'  => 'Những huyền thoại bất hủ vượt thời gian, định hình nên văn hóa cocktail toàn cầu.',
        'items' => array(
            array('name' => 'Boulevardier',      'price' => '199k', 'desc' => 'Bourbon, Campari, Sweet Vermouth, Orange Twist'),
            array('name' => 'Godfather',         'price' => '199k', 'desc' => 'Scotch Whisky, Amaretto Liqueur, Giant Clear Ice'),
            array('name' => 'Highball Reserve',  'price' => '199k', 'desc' => 'Japanese Whisky, Premium Soda, Lemon Zest'),
            array('name' => 'Clover Club',       'price' => '199k', 'desc' => 'Dry Gin, Raspberry Syrup, Lemon Juice, Egg White'),
            array('name' => 'Dry Martini',       'price' => '199k', 'desc' => 'London Dry Gin, Dry Vermouth, Spanish Olive'),
            array('name' => 'Gimlet',            'price' => '199k', 'desc' => 'Botanical Gin, House Lime Cordial, Lime Wheel'),
        ),
        'image' => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
    ),
    'cat-signature' => array(
        'num'   => '03',
        'name'  => 'SIGNATURE COCKTAIL',
        'desc'  => 'Những sáng tạo độc quyền của On The Rock Bar, kể lại câu chuyện núi rừng và sương mù Đà Lạt.',
        'items' => array(
            array('name' => 'Foggy Dalat Valley',    'price' => '299k', 'desc' => 'Wild Herb Dalat Gin, Elderflower, Dry Vermouth, Pine Mist'),
            array('name' => 'Sunset Over Truc Lam',  'price' => '299k', 'desc' => 'Campari, Passion Fruit, Wild Honey, Sparkling Wine'),
            array('name' => 'Langbiang Golden Hour', 'price' => '319k', 'desc' => 'Aged Dark Rum, Dalat Coffee Liqueur, Cocoa Bitter'),
            array('name' => 'Midnight In The Rocks', 'price' => '329k', 'desc' => 'Islay Peated Malt, Black Walnut Bitters, Smoked Rosemary'),
        ),
        'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
    ),
    'cat-food' => array(
        'num'   => '04',
        'name'  => 'FOOD & BAR BITES',
        'desc'  => 'Các món ăn nhẹ và món khai vị cao cấp hoàn hảo để nhâm nhi cùng cocktail.',
        'items' => array(
            array('name' => 'Ibérico Cold Cut Platter', 'price' => '380k', 'desc' => 'Ibérico Ham 36 Months, Chorizo, Salami, Dalat Sourdough'),
            array('name' => 'Artisanal Cheese Board',   'price' => '320k', 'desc' => 'Truffle Brie, Aged Gouda, Blue Cheese, Fig Jam, Walnuts'),
            array('name' => 'Wagyu Beef Tartare Tart',  'price' => '280k', 'desc' => 'Wagyu A5, Quail Egg, Truffle Aioli, Crispy Brioche'),
            array('name' => 'Hokkaido Scallop Ceviche', 'price' => '260k', 'desc' => 'Fresh Scallop, Citrus Ponzu, Passion Fruit Pearls'),
        ),
    ),
);

// Nạp dữ liệu động từ Custom Post Type & Taxonomy (Nếu có)
$dynamic_data = function_exists('otr_get_menu_data') ? otr_get_menu_data() : array();
if ( ! empty( $dynamic_data ) ) {
    $sidebar_categories = $dynamic_data;
}
?>

<div class="menu-layout-2-wrapper grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start relative">
    
    <!-- 1. CỘT TRÁI: SIDEBAR CỐ ĐỊNH KHI SCROLL (Sticky Sidebar) -->
    <aside class="lg:col-span-4 self-start z-20 select-none bg-[#140e08]/95 p-6 sm:p-8 border border-[#caa875]/25 shadow-2xl backdrop-blur-md rounded-sm menu-sticky-sidebar"
           style="position: -webkit-sticky; position: sticky; top: 110px;">
        <h3 class="text-xs tracking-[0.25em] text-[#caa875]/60 uppercase font-medium mb-6 pb-3 border-b border-[#caa875]/20">
            MỤC LỤC THỰC ĐƠN
        </h3>
        
        <nav class="flex flex-col gap-4 font-serif">
            <?php 
            $s_idx = 0;
            foreach ( $sidebar_categories as $key => $cat ) : 
                $isActive = ($s_idx === 0);
            ?>
                <a href="#<?php echo esc_attr( $key ); ?>" 
                   class="sidebar-nav-item flex items-baseline gap-3 py-2 px-3 rounded transition-all duration-300 group <?php echo $isActive ? 'bg-[#caa875]/20 text-white font-semibold' : 'text-[#caa875]/75 hover:text-white hover:bg-[#caa875]/10'; ?>"
                   data-nav-target="<?php echo esc_attr( $key ); ?>">
                    <span class="text-xs text-[#caa875]/60 font-mono tracking-wider">
                        <?php echo esc_html( $cat['num'] ); ?>
                    </span>
                    <span class="text-sm tracking-wide uppercase transition-transform group-hover:translate-x-1">
                        <?php echo esc_html( $cat['name'] ); ?>
                    </span>
                </a>
            <?php 
                $s_idx++;
            endforeach; 
            ?>
        </nav>

        <div class="mt-8 pt-6 border-t border-[#caa875]/15 text-[11px] text-[#caa875]/60 leading-relaxed font-sans">
            ✦ Cuộn trang để khám phá toàn bộ thực đơn. Thanh sidebar sẽ đồng hành và ghim cố định suốt quá trình trải nghiệm.
        </div>
    </aside>

    <!-- 2. CỘT PHẢI: NỘI DUNG CHI TIẾT CÁC PHÂN MỤC -->
    <div class="lg:col-span-8 space-y-16 lg:space-y-24">
        
        <?php foreach ( $sidebar_categories as $key => $cat ) : ?>
            <section id="<?php echo esc_attr( $key ); ?>" class="sidebar-content-section scroll-mt-28 md:scroll-mt-32 pb-8 border-b border-dashed border-[#caa875]/25 last:border-b-0">
                
                <!-- Tiêu đề phân mục -->
                <div class="mb-6 md:mb-8">
                    <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1.5">
                        <?php echo esc_html( $cat['num'] ); ?>
                    </span>
                    <h2 class="font-serif font-light text-[#caa875] text-3xl sm:text-4xl md:text-5xl uppercase tracking-[0.03em] mb-3">
                        <?php echo esc_html( $cat['name'] ); ?>
                    </h2>
                    <p class="text-[#caa875]/70 text-xs sm:text-sm leading-relaxed max-w-xl font-normal">
                        <?php echo esc_html( $cat['desc'] ); ?>
                    </p>
                </div>

                <!-- Ảnh minh họa phân mục -->
                <div class="relative aspect-[21/9] sm:aspect-[24/9] rounded-sm overflow-hidden mb-8 border border-[#caa875]/20 shadow-xl">
                    <img src="<?php echo esc_url( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" class="w-full h-full object-cover brightness-[0.85] hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
                </div>

                <!-- Danh sách món & Bảng giá -->
                <div class="divide-y divide-[#caa875]/15 border-t border-b border-[#caa875]/15">
                    <?php foreach ( $cat['items'] as $item ) : ?>
                        <div class="py-4 sm:py-5 flex items-start justify-between gap-4 group hover:bg-[#caa875]/5 px-2 rounded transition-colors duration-200">
                            <div>
                                <h4 class="text-base sm:text-lg font-serif text-[#f4efe8] group-hover:text-[#caa875] transition-colors">
                                    <?php echo esc_html( $item['name'] ); ?>
                                </h4>
                                <p class="text-xs sm:text-[13px] text-[#caa875]/60 font-sans mt-1">
                                    <?php echo esc_html( $item['desc'] ); ?>
                                </p>
                            </div>
                            <span class="text-sm sm:text-base font-serif text-[#caa875] font-medium shrink-0 pt-0.5">
                                <?php echo esc_html( $item['price'] ); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

            </section>
        <?php endforeach; ?>

    </div>

</div>
