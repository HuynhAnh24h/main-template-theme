<?php
/**
 * Admin Module: Menu TheRocks CRUD Management
 * Description: Trang quản trị Thực Đơn riêng biệt "Menu TheRocks" trong WordPress Admin.
 * Hỗ trợ CRUD phân cấp 3 tầng: Menu Cha -> Menu Con (chọn Kiểu 1, 2, 3) -> Menu Con Con -> Danh sách Món.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Khởi tạo dữ liệu mặc định ban đầu cho Menu TheRocks (Đầy đủ 3 cấp và 3 kiểu hiển thị)
 */
function otr_get_default_menu_tree() {
    return array(
        'cha_01' => array(
            'id'    => 'cha_01',
            'num'   => '01',
            'title' => 'BESPOKE COCKTAIL',
            'desc'  => 'Những ly cocktail mang tính độc bản, phối trộn riêng theo cá tính và khẩu vị của từng vị khách.',
            'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
            'layout' => 'layout_1', // Mặc định Kiểu 1
            'children' => array(
                'con_01_01' => array(
                    'id'       => 'con_01_01',
                    'title'    => 'SIGNATURE CRAFT',
                    'tag'      => 'BESPOKE',
                    'price'    => '320k',
                    'alcohol'  => 'High',
                    'layout'   => 'layout_1',
                    'desc'     => 'Peated Highland Malt, Toasted Cinnamon, Smoked Honey',
                    'spirits'  => array(
                        'Base:'    => 'Single Malt Scotch',
                        'Infuse:'  => 'Toasted Cinnamon Bark',
                        'Bitters:' => 'Black Walnut Bitters',
                        'Sweet:'   => 'Smoked Honey Syrup',
                        'Citrus:'  => 'Dehydrated Blood Orange',
                        'Glass:'   => 'Hand-carved Rock Crystal',
                    ),
                    'flavors'  => array('Ngọt / Sweet', 'Chua / Sour', 'Khói / Smoky', 'Thảo mộc / Herbal'),
                    'images'   => array(
                        'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
                    ),
                    'sub_children' => array(
                        'concon_01_01' => array(
                            'id'    => 'concon_01_01',
                            'title' => 'HERBAL & FLORAL',
                            'items' => array(
                                array('id' => 'm1', 'name' => 'Artisanal Smoked Old Fashioned', 'price' => '320k', 'desc' => 'Peated Highland Malt, Toasted Cinnamon, Smoked Honey'),
                                array('id' => 'm2', 'name' => 'Dalat Pine Needle Negroni',      'price' => '340k', 'desc' => 'Artisanal Dalat Gin, Campari Infused Pine, Sweet Vermouth'),
                            ),
                        ),
                    ),
                ),
                'con_01_02' => array(
                    'id'       => 'con_01_02',
                    'title'    => 'CUSTOM PALATE',
                    'tag'      => 'BESPOKE',
                    'price'    => '340k',
                    'alcohol'  => 'Medium',
                    'layout'   => 'layout_1',
                    'desc'     => 'Mezcal Artisanal, Fresh Rosemary Smoke, Yuzu Acid',
                    'spirits'  => array(
                        'Base:'    => 'Mezcal Artisanal',
                        'Herbal:'  => 'Fresh Rosemary Smoke',
                        'Cordial:' => 'Hibiscus Agave Cordial',
                        'Acid:'    => 'Yuzu Acid Solution',
                        'Mist:'    => 'Absinthe Atomizer Mist',
                    ),
                    'flavors'  => array('Ngọt / Sweet', 'Chua / Sour', 'Cay / Spicy', 'Trái cây / Fruity'),
                    'images'   => array(
                        'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop',
                    ),
                    'sub_children' => array(
                        'concon_01_02' => array(
                            'id'    => 'concon_01_02',
                            'title' => 'BARREL AGED & SMOKED',
                            'items' => array(
                                array('id' => 'm3', 'name' => 'Truffle Velvet Boulevardier', 'price' => '360k', 'desc' => 'Bourbon Reserve, Black Truffle Bitter, Sweet Vermouth'),
                                array('id' => 'm4', 'name' => 'Yuzu Blossom Sour',          'price' => '310k', 'desc' => 'Japanese Gin, Yuzu Acid, Egg White Foam, Gold Flakes'),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'cha_02' => array(
            'id'    => 'cha_02',
            'num'   => '02',
            'title' => 'CLASSIC COCKTAIL',
            'desc'  => 'Những huyền thoại bất hủ vượt thời gian, định hình nên văn hóa cocktail toàn cầu.',
            'image' => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
            'layout' => 'layout_3', // Mặc định Kiểu 3 (2 cột kinh điển)
            'children' => array(
                'con_02_01' => array(
                    'id'       => 'con_02_01',
                    'title'    => 'CLASSIC COCKTAIL',
                    'layout'   => 'layout_3',
                    'sub_children' => array(
                        'concon_02_whisky' => array(
                            'id'    => 'concon_02_whisky',
                            'title' => 'WHISKY',
                            'items' => array(
                                array('id' => 'm5', 'name' => 'Boulevardier',       'price' => '199k', 'desc' => 'Bourbon, Campari, Sweet Vermouth, Orange Twist'),
                                array('id' => 'm6', 'name' => 'Godfather',          'price' => '199k', 'desc' => 'Scotch Whisky, Amaretto Liqueur, Giant Clear Ice'),
                                array('id' => 'm7', 'name' => 'Highball',           'price' => '199k', 'desc' => 'Japanese Whisky, Premium Soda, Lemon Zest'),
                                array('id' => 'm8', 'name' => 'Manhattan',          'price' => '199k', 'desc' => 'Rye Whiskey, Sweet Vermouth, Angostura Bitters'),
                                array('id' => 'm9', 'name' => 'Morning Glory Fizz', 'price' => '199k', 'desc' => 'Scotch Whisky, Absinthe, Lemon, Egg White, Soda'),
                                array('id' => 'm10','name' => 'New York Sour',      'price' => '199k', 'desc' => 'Bourbon, Lemon Juice, Sugar, Red Wine Float'),
                            ),
                        ),
                        'concon_02_gin' => array(
                            'id'    => 'concon_02_gin',
                            'title' => 'GIN',
                            'items' => array(
                                array('id' => 'm11', 'name' => 'Clover Club',  'price' => '199k', 'desc' => 'Dry Gin, Raspberry Syrup, Lemon Juice, Egg White'),
                                array('id' => 'm12', 'name' => 'Dry Martini',  'price' => '199k', 'desc' => 'London Dry Gin, Dry Vermouth, Spanish Olive'),
                                array('id' => 'm13', 'name' => 'Gimlet',       'price' => '199k', 'desc' => 'Botanical Gin, House Lime Cordial, Lime Wheel'),
                                array('id' => 'm14', 'name' => 'Gin Fizz',     'price' => '199k', 'desc' => 'Dry Gin, Lemon Juice, Simple Syrup, Soda Water'),
                                array('id' => 'm15', 'name' => 'Gin Tonic',    'price' => '199k', 'desc' => 'Artisanal Gin, Mediterranean Tonic, Rosemary'),
                                array('id' => 'm16', 'name' => 'James Bond',   'price' => '199k', 'desc' => 'Gordon Gin, Vodka, Kina Lillet, Lemon Peel'),
                            ),
                        ),
                    ),
                ),
                'con_02_02' => array(
                    'id'       => 'con_02_02',
                    'title'    => 'CLASSIC PREMIUM',
                    'layout'   => 'layout_3',
                    'sub_children' => array(
                        'concon_02_rum' => array(
                            'id'    => 'concon_02_rum',
                            'title' => 'RUM & TEQUILA',
                            'items' => array(
                                array('id' => 'm17', 'name' => 'Zacapa Old Fashioned', 'price' => '280k', 'desc' => 'Zacapa 23 Centenario, Bitters, Orange Peel'),
                                array('id' => 'm18', 'name' => 'Smoked Paloma',        'price' => '260k', 'desc' => 'Mezcal, Grapefruit Soda, Smoked Salt'),
                                array('id' => 'm19', 'name' => 'Dark & Stormy Reserve','price' => '250k', 'desc' => 'Goslings Black Seal Rum, Ginger Beer'),
                                array('id' => 'm20', 'name' => 'Tommy\'s Margarita',   'price' => '250k', 'desc' => 'Reposado Tequila, Agave Nectar, Fresh Lime'),
                                array(
                                    'id'    => 'm_rosita',
                                    'name'  => 'Rosita',
                                    'price' => '240k',
                                    'desc'  => "Jose Cuervo Reposado, Cinzano Rosso & Extra Dry, Campari, Aromatic Bitters, Lime zest\n– Mang mùi hương quyến rũ từ hương nồng cay nhẹ từ tequila và hương thơm của tinh dầu từ vỏ chanh\n– Vị cay nhẹ của rượu nền tequila xen lẫn với vị đắng, ngọt của Campari và Rosso, chút khô từ Dry vermouth, vị đắng có chiều sâu hơn nhờ sự cân bằng tuyệt đối",
                                    'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                                ),
                            ),
                        ),
                        'concon_02_malt' => array(
                            'id'    => 'concon_02_malt',
                            'title' => 'SINGLE MALT & COGNAC',
                            'items' => array(
                                array('id' => 'm21', 'name' => 'Macallan Rob Roy',     'price' => '350k', 'desc' => 'Macallan 12, Sweet Vermouth, Bitters'),
                                array('id' => 'm22', 'name' => 'Sazerac XO',           'price' => '320k', 'desc' => 'Hennessy XO, Absinthe Mist, Peychaud'),
                                array('id' => 'm23', 'name' => 'Sidecar Rare Cask',    'price' => '310k', 'desc' => 'Cognac VSOP, Cointreau, Lemon Juice'),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'cha_03' => array(
            'id'    => 'cha_03',
            'num'   => '03',
            'title' => 'SHOTS',
            'desc'  => 'Những ly shots bùng nổ hương vị, đánh thức mọi giác quan tại On The Rock.',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
            'layout' => 'layout_2', // Mặc định Kiểu 2 (Sticky Sidebar)
            'children' => array(
                'con_03_01' => array(
                    'id'       => 'con_03_01',
                    'title'    => 'HOUSE SIGNATURES',
                    'layout'   => 'layout_2',
                    'sub_children' => array(
                        'concon_03_citrus' => array(
                            'id'    => 'concon_03_citrus',
                            'title' => 'REFRESHING & CITRUS',
                            'items' => array(
                                array(
                                    'id'    => 'm24',
                                    'name'  => 'Foggy Dalat Valley',
                                    'price' => '299k',
                                    'desc'  => "Wild Herb Dalat Gin, Elderflower, Dry Vermouth, Pine Mist\n– Hương thơm tươi mới từ sương mai và tinh dầu lá thông rừng nhiệt đới Đà Lạt\n– Vị chua thanh thanh từ thảo mộc kết hợp hậu vị ngọt dịu tao nhã của hoa cơm cháy",
                                    'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
                                ),
                                array(
                                    'id'    => 'm25',
                                    'name'  => 'Sunset Over Truc Lam',
                                    'price' => '299k',
                                    'desc'  => "Campari, Passion Fruit, Wild Honey, Sparkling Wine\n– Hương thơm quyến rũ từ chanh dây tươi và mật ong hoa rừng cao nguyên\n– Sự bùng nổ sảng khoái của bọt sủi tăm cùng vị đắng nhẹ tinh tế đặc trưng của Campari",
                                    'image' => 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop',
                                ),
                            ),
                        ),
                        'concon_03_complex' => array(
                            'id'    => 'concon_03_complex',
                            'title' => 'COMPLEX & RICH',
                            'items' => array(
                                array('id' => 'm26', 'name' => 'Langbiang Golden Hour', 'price' => '319k', 'desc' => 'Aged Dark Rum, Dalat Coffee Liqueur, Cocoa Bitter'),
                                array('id' => 'm27', 'name' => 'Midnight In The Rocks', 'price' => '329k', 'desc' => 'Islay Peated Malt, Black Walnut Bitters, Smoked Rosemary'),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'cha_04' => array(
            'id'    => 'cha_04',
            'num'   => '04',
            'title' => 'FOOD & BAR BITES',
            'desc'  => 'Các món ăn nhẹ và món khai vị cao cấp hoàn hảo để nhâm nhi cùng cocktail.',
            'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1000&auto=format&fit=crop',
            'layout' => 'layout_2',
            'children' => array(
                'con_04_01' => array(
                    'id'       => 'con_04_01',
                    'title'    => 'GOURMET BITES',
                    'layout'   => 'layout_2',
                    'sub_children' => array(
                        'concon_04_all' => array(
                            'id'    => 'concon_04_all',
                            'title' => 'MÓN KHAI VỊ CAO CẤP',
                            'items' => array(
                                array('id' => 'm28', 'name' => 'Ibérico Cold Cut Platter', 'price' => '380k', 'desc' => 'Ibérico Ham 36 Months, Chorizo, Salami, Dalat Sourdough'),
                                array('id' => 'm29', 'name' => 'Artisanal Cheese Board',   'price' => '320k', 'desc' => 'Truffle Brie, Aged Gouda, Blue Cheese, Fig Jam, Walnuts'),
                                array('id' => 'm30', 'name' => 'Wagyu Beef Tartare Tart',  'price' => '280k', 'desc' => 'Wagyu A5, Quail Egg, Truffle Aioli, Crispy Brioche'),
                                array('id' => 'm31', 'name' => 'Hokkaido Scallop Ceviche', 'price' => '260k', 'desc' => 'Fresh Scallop, Citrus Ponzu, Passion Fruit Pearls'),
                            ),
                        ),
                        'concon_04_mains' => array(
                            'id'    => 'concon_04_mains',
                            'title' => 'MÓN NƯỚNG & MÓN CHÍNH',
                            'items' => array(
                                array('id' => 'm32', 'name' => 'Wagyu Ribeye Steak A5',    'price' => '890k', 'desc' => 'Wagyu Nhật A5, Muối Khói Đen, Bơ Thảo Mộc, Măng Tây'),
                                array('id' => 'm33', 'name' => 'Smoked Lamb Rack Dalat',   'price' => '550k', 'desc' => 'Sườn Cừu Nướng Lá Hương Thảo, Sốt Mận Rừng, Khoai Nghiền'),
                                array('id' => 'm34', 'name' => 'Pan-seared Foie Gras',     'price' => '420k', 'desc' => 'Gan Ngỗng Pháp Áp Chảo, Bánh Mì Brioche, Mứt Sung Mỹ'),
                                array('id' => 'm35', 'name' => 'Grilled Rock Lobster',     'price' => '680k', 'desc' => 'Tôm Hùm Nướng Bơ Tỏi Rượu Vang Trắng, Rau Củ Đà Lạt'),
                            ),
                        ),
                        'concon_04_finger' => array(
                            'id'    => 'concon_04_finger',
                            'title' => 'BITES & FINGER FOOD',
                            'items' => array(
                                array('id' => 'm36', 'name' => 'Truffle Parmesan Fries',   'price' => '150k', 'desc' => 'Khoai Tây Chiên Nấm Truffle, Phô Mai Parmesan, Xốt Aioli'),
                                array('id' => 'm37', 'name' => 'Crispy Calamari Rings',    'price' => '180k', 'desc' => 'Mực Ống Chiên Giòn Kiểu Địa Trung Hải, Sốt Tartar Cay'),
                                array('id' => 'm38', 'name' => 'Ibérico Croquetas',        'price' => '190k', 'desc' => 'Bánh Viên Thịt Heo Ibérico Chiên Xù Giòn Rụm'),
                                array('id' => 'm39', 'name' => 'Smoked Salmon Toast',      'price' => '220k', 'desc' => 'Cá Hồi Xông Khói, Phô Mai Ricotta, Bánh Mì Men Tự Nhiên'),
                            ),
                        ),
                        'concon_04_dessert' => array(
                            'id'    => 'concon_04_dessert',
                            'title' => 'TRÁNG MIỆNG & DESSERT',
                            'items' => array(
                                array('id' => 'm40', 'name' => 'Bourbon Infused Tiramisu', 'price' => '160k', 'desc' => 'Tiramisu Cà Phê Cầu Đất Đậm Vị, Rượu Bourbon Reserve'),
                                array('id' => 'm41', 'name' => 'Lava Dark Chocolate Cake', 'price' => '150k', 'desc' => 'Bánh Sô-cô-la Tan Chảy 70%, Kem Vani Madagascar'),
                                array('id' => 'm42', 'name' => 'Dalat Wild Berry Sorbet',  'price' => '120k', 'desc' => 'Kem Tuyết Dâu Tằm & Phúc Bồn Tử Rừng Đà Lạt'),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
}

/**
 * 2. Lấy dữ liệu cây thực đơn Menu TheRocks (Từ CSDL, fallback sang dữ liệu mặc định)
 */
function otr_get_therocks_menu_tree() {
    $tree = get_option('otr_menu_therocks_tree');
    if (empty($tree) || !is_array($tree)) {
        $tree = otr_get_default_menu_tree();
        update_option('otr_menu_therocks_tree', $tree);
    }

    // Đảm bảo có món Rosita trong nhóm concon_02_rum để kiểm tra giao diện Modal chuẩn theo ảnh mẫu
    if (isset($tree['cha_02']['children']['con_02_02']['sub_children']['concon_02_rum']['items'])) {
        $has_rosita = false;
        foreach ($tree['cha_02']['children']['con_02_02']['sub_children']['concon_02_rum']['items'] as $it) {
            if (!empty($it['name']) && strtolower(trim($it['name'])) === 'rosita') {
                $has_rosita = true;
                break;
            }
        }
        if (!$has_rosita) {
            $tree['cha_02']['children']['con_02_02']['sub_children']['concon_02_rum']['items'][] = array(
                'id'    => 'm_rosita',
                'name'  => 'Rosita',
                'price' => '240k',
                'desc'  => "Jose Cuervo Reposado, Cinzano Rosso & Extra Dry, Campari, Aromatic Bitters, Lime zest\n– Mang mùi hương quyến rũ từ hương nồng cay nhẹ từ tequila và hương thơm của tinh dầu từ vỏ chanh\n– Vị cay nhẹ của rượu nền tequila xen lẫn với vị đắng, ngọt của Campari và Rosso, chút khô từ Dry vermouth, vị đắng có chiều sâu hơn nhờ sự cân bằng tuyệt đối",
                'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
            );
            update_option('otr_menu_therocks_tree', $tree);
        }
    }

    // Tự động bổ sung nốt hương vị đặc trưng cho toàn bộ các món trong thực đơn
    if (otr_enrich_tree_tasting_notes($tree)) {
        update_option('otr_menu_therocks_tree', $tree);
    }

    return $tree;
}

/**
 * 2.a Bổ sung tự động thành phần & mô tả hương vị đặc trưng cho từng món trong thực đơn
 */
function otr_enrich_tree_tasting_notes(&$tree) {
    $tasting_map = array(
        'Boulevardier' => "– Vị nồng nàn của rượu Bourbon hòa quyện cùng nốt đắng thanh tao từ Campari\n– Hậu vị ngọt êm của vang Vermouth đỏ kết hợp tinh dầu vỏ cam khơi dậy mọi giác quan",
        'Godfather' => "– Vị khói êm dịu của whisky mạch nha Scotland hòa cùng hương hạnh nhân ngọt bùi quyến rũ\n– Rót qua khối băng pha lê nguyên khối tạo nên trải nghiệm nhâm nhi sâu lắng và quyền lực",
        'Highball' => "– Nốt hương thanh khiết, giòn tan từ bọt sủi tăm của dòng soda cao cấp hòa cùng whisky Nhật Bản\n– Hậu vị sảng khoái, tươi mát điểm xuyết tinh dầu vỏ chanh vàng đánh thức vị giác",
        'Manhattan' => "– Vị cay nồng đặc trưng của lúa mạch đen Rye cân bằng hoàn hảo với nốt ngọt mượt mà của Vermouth\n– Tầng hương thảo mộc phức hợp từ giọt đắng Angostura lưu lại hậu vị quý phái, trường tồn",
        'Morning Glory Fizz' => "– Lớp bọt kem mịn như nhung mang hương hoa hồi huyền bí từ những giọt absinthe thượng hạng\n– Vị chua thanh thoát từ nước cốt chanh tươi kết hợp cùng nốt khói dịu của rượu nền whisky",
        'New York Sour' => "– Tầng vang đỏ mượt mà nổi bật trên nền chua ngọt tươi tắn của nước cốt chanh và đường mía\n– Hương gỗ sồi và vani từ rượu bourbon tạo nên sự chuyển tiếp hương vị đa tầng đầy mê hoặc",
        'Clover Club' => "– Sắc hồng quyến rũ cùng hương thơm ngọt ngào của quả mâm xôi chín mọng tự nhiên\n– Lớp bọt mịn màng như tơ, vị chua thanh thoát hòa quyện cùng nốt thảo mộc tươi mát từ Gin",
        'Dry Martini' => "– Sự tinh khiết tối thượng với hương bách xù sắc nét và độ khô thanh tao kinh điển\n– Nốt mặn nhẹ từ quả ô liu Tây Ban Nha tôn vinh trọn vẹn bản sắc của ly cocktail huyền thoại",
        'Gimlet' => "– Vị chua ngọt bùng nổ cân bằng hoàn hảo nhờ siro chanh thủ công do quán tự chưng cất\n– Tầng hương hoa cỏ thảo mộc thanh thoát, mang lại cảm giác giải nhiệt và sảng khoái tức thì",
        'Gin Fizz' => "– Sự bùng nổ sảng khoái của dòng sủi bọt soda kết hợp vị chua sắc nét của chanh vàng\n– Hậu vị thanh khiết, nhẹ nhàng, là thức uống khai vị hoàn hảo cho một buổi tối thư giãn",
        'Gin Tonic' => "– Sự cộng hưởng tươi mát giữa vị đắng nhẹ của tonic Địa Trung Hải và tinh dầu lá hương thảo đốt\n– Dòng sủi bọt rực rỡ mang đến cảm giác thư thái, khoáng đạt giữa không gian đêm",
        'James Bond' => "– Công thức kinh điển Vesper Martini kết hợp cả Gin và Vodka cùng chút rượu khai vị Kina Lillet\n– Vị rượu lạnh buốt, mạnh mẽ và dứt khoát đúng phong thái quý ông điệp viên lịch lãm",
        'Zacapa Old Fashioned' => "– Vị ngọt sâu của mật mía ủ trên mây từ Guatemala với nốt mật ong, caramen và hạnh nhân\n– Hương thơm ấm áp của gỗ sồi già và tinh dầu cam nướng tạo nên ly cocktail đẳng cấp thượng thừa",
        'Smoked Paloma' => "– Nốt khói đặc trưng của dòng rượu thủ công Mezcal vùng Oaxaca hòa cùng nước bưởi hồng tươi\n– Viền muối hun khói trên miệng ly kích thích vị giác, mang đến dư vị mặn ngọt cay nồng độc đáo",
        'Dark & Stormy Reserve' => "– Vị cay nồng bùng nổ của bia gừng thủ công quyện trong dòng rum đen Goslings đậm đà\n– Một sự kết hợp hoang dã, phóng khoáng như cơn bão giữa biển khơi nhiệt đới",
        'Tommy\'s Margarita' => "– Nốt ngọt tự nhiên từ mật cây thùa agave làm mềm độ cay hăng của rượu tequila ủ sồi\n– Vị chua giòn giã của chanh tươi tạo nên cảm giác tròn đầy, mượt mà khó quên",
        'Macallan Rob Roy' => "– Hương thơm quả khô, gia vị gỗ sồi sherry danh tiếng của Macallan 12 hòa cùng Vermouth Ý\n– Cấu trúc rượu đầm ấm, sâu lắng với hậu vị kéo dài mang phong thái quý tộc Scotland",
        'Sazerac XO' => "– Dòng cognac Hennessy XO đắt giá điểm xuyết sương mù rượu ngải cứu Absinthe đầy ma mị\n– Nốt đắng thanh lịch từ thảo mộc Peychaud làm thăng hoa trải nghiệm thưởng thức đỉnh cao",
        'Sidecar Rare Cask' => "– Sự hòa quyện hoàn hảo giữa rượu mạnh Cognac hảo hạng và hương cam ngọt ngào của Cointreau\n– Viền đường mịn trên miệng ly mang đến sự tương phản ngọt ngào đầy mê hoặc",
        'Foggy Dalat Valley' => "– Hương thơm tươi mới từ sương mai và tinh dầu lá thông rừng nhiệt đới Đà Lạt\n– Vị chua thanh thanh từ thảo mộc kết hợp hậu vị ngọt dịu tao nhã của hoa cơm cháy",
        'Sunset Over Truc Lam' => "– Hương thơm quyến rũ từ chanh dây tươi và mật ong hoa rừng cao nguyên\n– Sự bùng nổ sảng khoái của bọt sủi tăm cùng vị đắng nhẹ tinh tế đặc trưng của Campari",
        'Langbiang Golden Hour' => "– Hương thơm nồng nàn của cà phê Arabica Cầu Đất hòa quyện cùng rum lâu năm và nốt ca cao đậm đà\n– Vị ngọt đắng êm dịu như hoàng hôn buông trên đỉnh Langbiang huyền thoại",
        'Midnight In The Rocks' => "– Nốt khói than bùn biển đảo Scotland bùng nổ cùng vị đắng bùi của hạt óc chó đen\n– Khói lá hương thảo tỏa ngát tạo nên trải nghiệm thưởng thức đầy bí ẩn và quyền lực",
    );

    $updated = false;
    if (!empty($tree) && is_array($tree)) {
        foreach ($tree as &$cha) {
            if (!empty($cha['children']) && is_array($cha['children'])) {
                foreach ($cha['children'] as &$con) {
                    if (!empty($con['sub_children']) && is_array($con['sub_children'])) {
                        foreach ($con['sub_children'] as &$concon) {
                            if (!empty($concon['items']) && is_array($concon['items'])) {
                                foreach ($concon['items'] as &$it) {
                                    $name = trim($it['name'] ?? '');
                                    if (isset($tasting_map[$name])) {
                                        if (empty($it['desc']) || (strpos($it['desc'], '–') === false && strpos($it['desc'], '-') === false)) {
                                            $base_ing = !empty($it['desc']) ? trim($it['desc']) : $name;
                                            $it['desc'] = $base_ing . "\n" . $tasting_map[$name];
                                            $updated = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $updated;
}

/**
 * 2.b Lấy ảnh đồ uống chất lượng cao cho Modal Chi Tiết Món Ăn / Đồ Uống
 */
function otr_get_drink_modal_image($drink, $fallback = '') {
    if (!empty($drink['image'])) {
        return $drink['image'];
    }
    if (!empty($fallback)) {
        return $fallback;
    }
    $pool = array(
        'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop', // Rosita ruby noir with orange peel
        'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop', // Amber whiskey on rock ice
        'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop', // Smoked cocktail glass
        'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1000&auto=format&fit=crop', // Negroni ruby clear ice
        'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1000&auto=format&fit=crop', // Old fashioned on volcanic stone
        'https://images.unsplash.com/photo-1536935338788-846bb9981813?q=80&w=1000&auto=format&fit=crop', // Highball luxury garnish
        'https://images.unsplash.com/photo-1582878826629-29b7ad1cdc43?q=80&w=1000&auto=format&fit=crop', // Dark cocktail gold rim
        'https://images.unsplash.com/photo-1609951651556-5334e2706168?q=80&w=1000&auto=format&fit=crop', // Martini luxury noir
    );
    $name = !empty($drink['name']) ? $drink['name'] : 'cocktail';
    $idx = abs(crc32($name)) % count($pool);
    return $pool[$idx];
}

/**
 * 3. Lưu toàn bộ cây thực đơn Menu TheRocks
 */
function otr_save_therocks_menu_tree($tree) {
    return update_option('otr_menu_therocks_tree', $tree);
}

/**
 * 4. Đăng ký Menu Admin "Menu TheRocks" & Nạp thư viện WordPress Media
 */
add_action('admin_menu', 'otr_register_menu_therocks_admin');
function otr_register_menu_therocks_admin() {
    add_menu_page(
        'Menu TheRocks',
        'Menu TheRocks',
        'manage_options',
        'menu-therocks',
        'otr_render_menu_therocks_page',
        'dashicons-food',
        21
    );
}

/**
 * Nạp thư viện WordPress Media Uploader (wp.media) cho trang quản trị Menu TheRocks
 */
add_action('admin_enqueue_scripts', 'otr_menu_therocks_admin_scripts');
function otr_menu_therocks_admin_scripts($hook) {
    if (isset($_GET['page']) && $_GET['page'] === 'menu-therocks') {
        wp_enqueue_media();
    }
}

/**
 * 5. Xử lý Form POST CRUD trực tiếp
 */
add_action('admin_init', 'otr_handle_menu_therocks_crud');
function otr_handle_menu_therocks_crud() {
    if (!isset($_POST['otr_menu_action']) || !check_admin_referer('otr_menu_therocks_nonce', 'otr_nonce')) {
        return;
    }

    if (!current_user_can('manage_options')) {
        wp_die('Bạn không có quyền thực hiện thao tác này.');
    }

    $tree = otr_get_therocks_menu_tree();
    $action = sanitize_text_field($_POST['otr_menu_action']);

    // A. Thêm hoặc Sửa Menu Cha
    if ($action === 'save_cha') {
        $cha_id = sanitize_text_field($_POST['cha_id'] ?: 'cha_' . time());
        $title  = sanitize_text_field($_POST['cha_title']);
        $num    = sanitize_text_field($_POST['cha_num']);
        $desc   = sanitize_textarea_field($_POST['cha_desc']);
        $image  = esc_url_raw($_POST['cha_image']);
        $layout = in_array($_POST['cha_layout'], array('layout_1', 'layout_2', 'layout_3')) ? $_POST['cha_layout'] : 'layout_3';

        if (!isset($tree[$cha_id])) {
            $tree[$cha_id] = array(
                'id'       => $cha_id,
                'children' => array(),
            );
        }
        $tree[$cha_id]['id']     = $cha_id;
        $tree[$cha_id]['title']  = $title ?: 'Menu Mới';
        $tree[$cha_id]['num']    = $num ?: sprintf('%02d', count($tree));
        $tree[$cha_id]['desc']   = $desc;
        $tree[$cha_id]['image']  = $image;
        $tree[$cha_id]['layout'] = $layout;

        otr_save_therocks_menu_tree($tree);
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=saved_cha'));
        exit;
    }

    // B. Xóa Menu Cha
    if ($action === 'delete_cha') {
        $cha_id = sanitize_text_field($_POST['cha_id']);
        if (isset($tree[$cha_id])) {
            unset($tree[$cha_id]);
            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=deleted_cha'));
        exit;
    }

    // C. Thêm hoặc Sửa Menu Con
    if ($action === 'save_con') {
        $cha_id = sanitize_text_field($_POST['parent_cha_id']);
        $con_id = sanitize_text_field($_POST['con_id'] ?: 'con_' . time());
        $title  = sanitize_text_field($_POST['con_title']);
        $layout = in_array($_POST['con_layout'], array('layout_1', 'layout_2', 'layout_3')) ? $_POST['con_layout'] : 'layout_3';
        $desc   = sanitize_textarea_field($_POST['con_desc']);
        $tag    = sanitize_text_field($_POST['con_tag']);
        $price  = sanitize_text_field($_POST['con_price']);
        $image  = isset($_POST['con_image']) ? esc_url_raw($_POST['con_image']) : '';

        if (isset($tree[$cha_id])) {
            if (!isset($tree[$cha_id]['children'])) {
                $tree[$cha_id]['children'] = array();
            }
            if (!isset($tree[$cha_id]['children'][$con_id])) {
                $tree[$cha_id]['children'][$con_id] = array(
                    'id'           => $con_id,
                    'sub_children' => array(),
                );
            }
            $tree[$cha_id]['children'][$con_id]['id']     = $con_id;
            $tree[$cha_id]['children'][$con_id]['title']  = $title ?: 'Menu Con Mới';
            $tree[$cha_id]['children'][$con_id]['layout'] = $layout;
            $tree[$cha_id]['children'][$con_id]['desc']   = $desc;
            $tree[$cha_id]['children'][$con_id]['tag']    = $tag;
            $tree[$cha_id]['children'][$con_id]['price']  = $price;
            $tree[$cha_id]['children'][$con_id]['image']  = $image;
            if ($image) {
                if (empty($tree[$cha_id]['children'][$con_id]['images'])) {
                    $tree[$cha_id]['children'][$con_id]['images'] = array($image);
                } else {
                    $tree[$cha_id]['children'][$con_id]['images'][0] = $image;
                }
            }

            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=saved_con'));
        exit;
    }

    // D. Xóa Menu Con
    if ($action === 'delete_con') {
        $cha_id = sanitize_text_field($_POST['parent_cha_id']);
        $con_id = sanitize_text_field($_POST['con_id']);
        if (isset($tree[$cha_id]['children'][$con_id])) {
            unset($tree[$cha_id]['children'][$con_id]);
            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=deleted_con'));
        exit;
    }

    // E. Thêm hoặc Sửa Menu Con Con (Phân nhóm cột)
    if ($action === 'save_concon') {
        $cha_id    = sanitize_text_field($_POST['parent_cha_id']);
        $con_id    = sanitize_text_field($_POST['parent_con_id']);
        $concon_id = sanitize_text_field($_POST['concon_id'] ?: 'concon_' . time());
        $title     = sanitize_text_field($_POST['concon_title']);

        if (isset($tree[$cha_id]['children'][$con_id])) {
            if (!isset($tree[$cha_id]['children'][$con_id]['sub_children'])) {
                $tree[$cha_id]['children'][$con_id]['sub_children'] = array();
            }
            if (!isset($tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id])) {
                $tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id] = array(
                    'id'    => $concon_id,
                    'items' => array(),
                );
            }
            $tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id]['id']    = $concon_id;
            $tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id]['title'] = $title ?: 'Nhóm Cột Mới';

            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=saved_concon'));
        exit;
    }

    // F. Xóa Menu Con Con
    if ($action === 'delete_concon') {
        $cha_id    = sanitize_text_field($_POST['parent_cha_id']);
        $con_id    = sanitize_text_field($_POST['parent_con_id']);
        $concon_id = sanitize_text_field($_POST['concon_id']);
        if (isset($tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id])) {
            unset($tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id]);
            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=deleted_concon'));
        exit;
    }

    // G. Thêm hoặc Sửa Món
    if ($action === 'save_item') {
        $cha_id    = sanitize_text_field($_POST['parent_cha_id']);
        $con_id    = sanitize_text_field($_POST['parent_con_id']);
        $concon_id = sanitize_text_field($_POST['parent_concon_id']);
        $item_id   = sanitize_text_field($_POST['item_id'] ?: 'item_' . time());
        $name      = sanitize_text_field($_POST['item_name']);
        $price     = sanitize_text_field($_POST['item_price']);
        $desc      = sanitize_textarea_field($_POST['item_desc']);
        $image     = esc_url_raw($_POST['item_image']);

        if (isset($tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id])) {
            $items = &$tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id]['items'];
            if (!is_array($items)) {
                $items = array();
            }

            $found = false;
            foreach ($items as &$it) {
                if ($it['id'] === $item_id) {
                    $it['name']  = $name ?: 'Món mới';
                    $it['price'] = $price ?: '199k';
                    $it['desc']  = $desc;
                    $it['image'] = $image;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $items[] = array(
                    'id'    => $item_id,
                    'name'  => $name ?: 'Món mới',
                    'price' => $price ?: '199k',
                    'desc'  => $desc,
                    'image' => $image,
                );
            }

            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=saved_item'));
        exit;
    }

    // H. Xóa Món
    if ($action === 'delete_item') {
        $cha_id    = sanitize_text_field($_POST['parent_cha_id']);
        $con_id    = sanitize_text_field($_POST['parent_con_id']);
        $concon_id = sanitize_text_field($_POST['parent_concon_id']);
        $item_id   = sanitize_text_field($_POST['item_id']);

        if (isset($tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id])) {
            $items = &$tree[$cha_id]['children'][$con_id]['sub_children'][$concon_id]['items'];
            foreach ($items as $k => $it) {
                if ($it['id'] === $item_id) {
                    unset($items[$k]);
                    $items = array_values($items); // re-index
                    break;
                }
            }
            otr_save_therocks_menu_tree($tree);
        }
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=deleted_item'));
        exit;
    }

    // I. Khôi phục dữ liệu gốc
    if ($action === 'reset_default') {
        otr_save_therocks_menu_tree(otr_get_default_menu_tree());
        wp_redirect(admin_url('admin.php?page=menu-therocks&msg=reset'));
        exit;
    }
}

/**
 * 6. Giao diện trang quản trị "Menu TheRocks"
 */
function otr_render_menu_therocks_page() {
    $tree = otr_get_therocks_menu_tree();
    $total_cha = count($tree);
    $total_con = 0;
    $total_concon = 0;
    $total_items = 0;

    foreach ($tree as $cha) {
        if (!empty($cha['children'])) {
            $total_con += count($cha['children']);
            foreach ($cha['children'] as $con) {
                if (!empty($con['sub_children'])) {
                    $total_concon += count($con['sub_children']);
                    foreach ($con['sub_children'] as $concon) {
                        if (!empty($concon['items'])) {
                            $total_items += count($concon['items']);
                        }
                    }
                }
            }
        }
    }

    $msg = isset($_GET['msg']) ? sanitize_text_field($_GET['msg']) : '';
    ?>
    <div class="wrap" style="max-width: 1400px; margin-top: 20px;">
        
        <!-- Header Thanh Quản Trị -->
        <div style="background: linear-gradient(135deg, #18110b 0%, #0a0805 100%); border: 1px solid #caa875; border-radius: 8px; padding: 24px 30px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 style="color: #caa875; font-size: 28px; font-weight: 700; margin: 0; font-family: Georgia, serif; letter-spacing: 0.05em;">
                    ✦ MENU THEROCKS - QUẢN LÝ THỰC ĐƠN ĐA CẤP
                </h1>
                <p style="color: #d8c19d; margin: 6px 0 0; font-size: 13px;">
                    Hệ thống quản trị 3 tầng: <strong>Menu Cha</strong> &rarr; <strong>Menu Con</strong> (Tùy chọn Kiểu 1, 2, 3) &rarr; <strong>Menu Con Con (Cột)</strong> &rarr; <strong>Món</strong>.
                </p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="otrOpenDemoModal()" class="button" style="background: #221911; border-color: #caa875; color: #caa875; font-weight: 700; padding: 6px 18px; height: auto; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <span class="dashicons dashicons-visibility" style="margin-top:-2px;"></span> XEM DEMO 3 KIỂU MENU
                </button>
                <button type="button" onclick="otrOpenAddCha()" class="button button-primary" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 700; padding: 6px 18px; height: auto; font-size: 14px;">
                    + THÊM MENU CHA MỚI
                </button>
                <form method="post" onsubmit="return confirm('Bạn có chắc muốn khôi phục về thực đơn mẫu gốc của quán?');" style="display:inline;">
                    <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                    <input type="hidden" name="otr_menu_action" value="reset_default">
                    <button type="submit" class="button" style="color: #ff8888; border-color: #552222; background: rgba(50,10,10,0.5); padding: 6px 14px; height: auto;">
                        ↺ Khôi Phục Mẫu
                    </button>
                </form>
            </div>
        </div>

        <?php if ($msg) : ?>
            <div class="notice notice-success is-dismissible" style="border-left-color: #caa875;">
                <p style="font-weight: 600;">
                    <?php 
                    switch ($msg) {
                        case 'saved_cha':   echo 'Đã lưu thông tin Menu Cha thành công!'; break;
                        case 'deleted_cha': echo 'Đã xóa Menu Cha!'; break;
                        case 'saved_con':   echo 'Đã lưu Menu Con thành công!'; break;
                        case 'deleted_con': echo 'Đã xóa Menu Con!'; break;
                        case 'saved_concon':echo 'Đã lưu Menu Con Con (Nhóm Cột) thành công!'; break;
                        case 'deleted_concon': echo 'Đã xóa Menu Con Con!'; break;
                        case 'saved_item':  echo 'Đã lưu món thực đơn thành công!'; break;
                        case 'deleted_item':echo 'Đã xóa món!'; break;
                        case 'reset':       echo 'Đã khôi phục thực đơn gốc của On The Rock thành công!'; break;
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- ================= BẢNG HƯỚNG DẪN THÊM VÀO MENU ================= -->
        <div id="otr-guide-card" style="background: #ffffff; border: 1px solid #caa875; border-left: 5px solid #caa875; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
            <!-- Tiêu đề có nút thu gọn / mở rộng -->
            <div style="padding: 16px 22px; background: #fffcf7; display: flex; justify-content: space-between; align-items: center; cursor: pointer; user-select: none;" onclick="otrToggleGuide();">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span class="dashicons dashicons-book-alt" style="font-size: 22px; color: #caa875; width: 22px; height: 22px;"></span>
                    <div>
                        <strong style="color: #18110b; font-size: 15px; font-weight: 700; letter-spacing: 0.02em;">
                            HƯỚNG DẪN THÊM VÀO MENU & QUẢN TRỊ THỰC ĐƠN ON THE ROCK
                        </strong>
                        <span style="display: inline-block; margin-left: 8px; background: rgba(202, 168, 117, 0.15); color: #8c5e2a; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600;">
                            Tích hợp Thư viện Media WordPress
                        </span>
                    </div>
                </div>
                <div>
                    <button type="button" id="otr-guide-toggle-btn" class="button button-small" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 600; color: #b8860b;">
                        <span class="dashicons dashicons-arrow-up-alt2" id="otr-guide-arrow"></span>
                        <span id="otr-guide-toggle-text">Thu gọn</span>
                    </button>
                </div>
            </div>

            <!-- Nội dung hướng dẫn -->
            <div id="otr-guide-body" style="padding: 22px 26px; border-top: 1px solid #f2e9dc; display: block;">
                
                <!-- 4 BƯỚC THỰC HIỆN NHANH -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 22px;">
                    <div style="background: #faf8f5; border: 1px solid #e8dfd3; border-radius: 6px; padding: 15px 18px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span style="background: #caa875; color: #18110b; font-weight: 800; width: 22px; height: 22px; line-height: 22px; border-radius: 50%; text-align: center; font-size: 12px; display: inline-block;">1</span>
                            <strong style="color: #18110b; font-size: 13px;">Tạo / Sửa Menu Cha</strong>
                        </div>
                        <p style="margin: 0; font-size: 12px; color: #555; line-height: 1.6;">
                            Bấm nút <strong>"+ THÊM MENU CHA MỚI"</strong> ở góc trên bên phải. Nhập tên (VD: <em>01 BESPOKE COCKTAIL</em>), số thứ tự, mô tả và bấm <strong>"Chọn từ Thư viện Media"</strong> để lấy ảnh bìa.
                        </p>
                    </div>

                    <div style="background: #faf8f5; border: 1px solid #e8dfd3; border-radius: 6px; padding: 15px 18px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span style="background: #2271b1; color: #fff; font-weight: 800; width: 22px; height: 22px; line-height: 22px; border-radius: 50%; text-align: center; font-size: 12px; display: inline-block;">2</span>
                            <strong style="color: #18110b; font-size: 13px;">Tạo Menu Con (Tabs)</strong>
                        </div>
                        <p style="margin: 0; font-size: 12px; color: #555; line-height: 1.6;">
                            Bấm <strong>"+ Thêm Menu Con"</strong> tại Menu Cha tương ứng. Điền tên Tab và lựa chọn 1 trong 3 Kiểu hiển thị (<em>Showcase Card</em>, <em>Sticky Sidebar</em>, hoặc <em>Danh Sách Cột</em>).
                        </p>
                    </div>

                    <div style="background: #faf8f5; border: 1px solid #e8dfd3; border-radius: 6px; padding: 15px 18px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span style="background: #135e96; color: #fff; font-weight: 800; width: 22px; height: 22px; line-height: 22px; border-radius: 50%; text-align: center; font-size: 12px; display: inline-block;">3</span>
                            <strong style="color: #18110b; font-size: 13px;">Tạo Nhóm Cột (Cột Rượu)</strong>
                        </div>
                        <p style="margin: 0; font-size: 12px; color: #555; line-height: 1.6;">
                            Bấm <strong>"+ Thêm Cột / Nhóm"</strong> để chia nhóm theo nền rượu hoặc phân loại món (VD: Cột <em>WHISKY</em>, Cột <em>GIN</em>, Cột <em>MÓN ĂN NHẸ</em>,...).
                        </p>
                    </div>

                    <div style="background: #faf8f5; border: 1px solid #e8dfd3; border-radius: 6px; padding: 15px 18px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span style="background: #46b450; color: #fff; font-weight: 800; width: 22px; height: 22px; line-height: 22px; border-radius: 50%; text-align: center; font-size: 12px; display: inline-block;">4</span>
                            <strong style="color: #18110b; font-size: 13px;">Thêm Món & Chọn Ảnh Media</strong>
                        </div>
                        <p style="margin: 0; font-size: 12px; color: #555; line-height: 1.6;">
                            Bấm <strong>"+ Món"</strong> trong cột tương ứng. Nhập Tên món, Giá tiền (VD: <em>199k</em> hoặc <em>250.000đ</em>), Thành phần và bấm nút <strong>"Chọn từ Thư viện Media"</strong> để lấy ảnh tải lên.
                        </p>
                    </div>
                </div>

                <!-- GIẢI THÍCH 3 KIỂU GIAO DIỆN & TÍNH NĂNG MEDIA -->
                <div style="background: #f4f6f8; border-radius: 6px; padding: 16px 20px; font-size: 12.5px; line-height: 1.7; color: #2c3338; display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <strong style="color: #b8860b; font-size: 13px;">★ Chi tiết 3 Kiểu hiển thị (Layout) của Menu Con:</strong>
                        <ul style="margin: 6px 0 0 18px; padding: 0; list-style-type: disc;">
                            <li><strong>Kiểu 1 (Showcase Card & Slider Ảnh):</strong> Thiết kế card nốt vị tương tác (Ngọt, Chua, Đắng, Khói,...), bảng thành phần nền rượu và trình chiếu ảnh lớn bên cạnh. Rất thích hợp cho dòng Signature Cocktail cao cấp.</li>
                            <li><strong>Kiểu 2 (Sticky Sidebar):</strong> Cột danh mục tab bám dính (sticky) ở mép trái khi người dùng cuộn xem từng nhóm thực đơn trên trang.</li>
                            <li><strong>Kiểu 3 (Danh Sách Cột Theo Rượu - Classic 2-3 Cột):</strong> Bố cục kinh điển tinh tế, phân tách thành các cột gọn gàng theo nền rượu (Whisky, Gin, Rum,...), hiển thị rõ tên món, giá tiền và thành phần.</li>
                        </ul>
                    </div>
                    <div style="border-top: 1px dashed #dcdcde; padding-top: 10px;">
                        <strong style="color: #2271b1; font-size: 13px;">★ Cách chọn hình ảnh từ Thư viện Media WordPress:</strong>
                        <p style="margin: 4px 0 0;">
                            Tại bất kỳ ô nhập ảnh nào (Menu Cha, Menu Con, hoặc Món), bạn chỉ cần bấm nút <strong><span class="dashicons dashicons-admin-media" style="vertical-align: middle;"></span> Chọn từ Thư viện Media</strong>. Cửa sổ Thư viện Media chuẩn của WordPress sẽ mở ra — bạn có thể chọn ảnh có sẵn sắc nét trong thư viện hoặc kéo thả ảnh mới từ máy tính của mình. Sau khi bấm <em>"Sử dụng ảnh này"</em>, ảnh sẽ tự động được gán vào thực đơn kèm ảnh xem trước tức thì!
                        </p>
                    </div>
                </div>

                <!-- Callout Xem Demo Trực Quan -->
                <div style="margin-top: 16px; padding: 14px 18px; background: #fffcf7; border: 1px solid #caa875; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="dashicons dashicons-visibility" style="color: #b8860b; font-size: 24px; width: 24px; height: 24px;"></span>
                        <div>
                            <strong style="color: #18110b; font-size: 13.5px;">BẠN CHƯA RÕ NÊN CHỌN KIỂU HIỂN THỊ NÀO?</strong>
                            <div style="color: #666; font-size: 12px; margin-top: 2px;">
                                Xem ngay bản demo trực quan có hình ảnh mô phỏng thực tế của cả 3 Kiểu để dễ dàng chọn kiểu ưng ý!
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="otrOpenDemoModal()" class="button button-primary" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 700; padding: 6px 16px;">
                        👁 MỞ BẢNG DEMO & SO SÁNH 3 KIỂU
                    </button>
                </div>

            </div>
        </div>

        <!-- Thẻ Thống Kê Số Lượng -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
            <div style="background: #fff; padding: 16px 20px; border-radius: 6px; border-left: 4px solid #caa875; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; text-transform: uppercase; color: #888; font-weight: 700;">Menu Cha (Cấp 1)</div>
                <div style="font-size: 26px; font-weight: 700; color: #18110b;"><?php echo $total_cha; ?></div>
            </div>
            <div style="background: #fff; padding: 16px 20px; border-radius: 6px; border-left: 4px solid #2271b1; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; text-transform: uppercase; color: #888; font-weight: 700;">Menu Con (Cấp 2 - Tab)</div>
                <div style="font-size: 26px; font-weight: 700; color: #2271b1;"><?php echo $total_con; ?></div>
            </div>
            <div style="background: #fff; padding: 16px 20px; border-radius: 6px; border-left: 4px solid #135e96; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; text-transform: uppercase; color: #888; font-weight: 700;">Menu Con Con (Cấp 3 - Cột)</div>
                <div style="font-size: 26px; font-weight: 700; color: #135e96;"><?php echo $total_concon; ?></div>
            </div>
            <div style="background: #fff; padding: 16px 20px; border-radius: 6px; border-left: 4px solid #46b450; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                <div style="font-size: 11px; text-transform: uppercase; color: #888; font-weight: 700;">Tổng Số Món Đang Có</div>
                <div style="font-size: 26px; font-weight: 700; color: #46b450;"><?php echo $total_items; ?></div>
            </div>
        </div>

        <!-- DANH SÁCH MENU THEO CẤU TRÚC CÂY PHÂN CẤP -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($tree as $cha_id => $cha) : 
                $cha_layout_name = ($cha['layout'] === 'layout_1') ? 'Kiểu 1: Showcase Card & Slider' : (($cha['layout'] === 'layout_2') ? 'Kiểu 2: Sticky Sidebar' : 'Kiểu 3: Danh Sách Cột Theo Rượu');
            ?>
                <div style="background: #ffffff; border: 1px solid #e2e4e7; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    
                    <!-- DÒNG MENU CHA (LEVEL 1) -->
                    <div style="background: #1e1710; color: #caa875; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <?php if (!empty($cha['image'])) : ?>
                                <img src="<?php echo esc_url($cha['image']); ?>" style="width: 42px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #caa875;" alt="<?php echo esc_attr($cha['title']); ?>">
                            <?php endif; ?>
                            <span style="background: #caa875; color: #18110b; font-weight: 800; font-size: 13px; padding: 3px 10px; border-radius: 4px;">
                                CẤP 1 (CHA): <?php echo esc_html($cha['num']); ?>
                            </span>
                            <h2 style="color: #fff; margin: 0; font-size: 20px; font-weight: 700; font-family: Georgia, serif;">
                                <?php echo esc_html($cha['title']); ?>
                            </h2>
                            <span style="background: rgba(202, 168, 117, 0.2); color: #e5cdab; font-size: 12px; padding: 3px 10px; border-radius: 12px; border: 1px solid rgba(202, 168, 117, 0.4);">
                                ⚙ <?php echo esc_html($cha_layout_name); ?>
                            </span>
                        </div>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <button type="button" onclick="otrEditCha('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($cha['title']); ?>', '<?php echo esc_js($cha['num']); ?>', '<?php echo esc_js($cha['desc']); ?>', '<?php echo esc_js($cha['image'] ?? ''); ?>', '<?php echo esc_js($cha['layout']); ?>')" class="button button-small" style="background: #33261a; color: #caa875; border-color: #caa875;">
                                ✎ Sửa Menu Cha
                            </button>
                            <button type="button" onclick="otrOpenAddCon('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($cha['title']); ?>')" class="button button-primary button-small" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 600;">
                                + Thêm Menu Con
                            </button>
                            <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa Menu Cha này và toàn bộ các Menu Con bên trong?');" style="display:inline;">
                                <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                                <input type="hidden" name="otr_menu_action" value="delete_cha">
                                <input type="hidden" name="cha_id" value="<?php echo esc_attr($cha_id); ?>">
                                <button type="submit" class="button button-small" style="color: #ff5555; border-color: #ff5555; background: transparent;">
                                    ✕ Xóa
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- KHỐI CÁC MENU CON (LEVEL 2) -->
                    <div style="padding: 20px 24px; background: #fafafa;">
                        <?php if (empty($cha['children'])) : ?>
                            <div style="padding: 20px; text-align: center; color: #888; font-style: italic; background: #fff; border: 1px dashed #ccc; border-radius: 6px;">
                                Chưa có Menu Con nào trong mục này. Bấm <strong>"+ Thêm Menu Con"</strong> ở trên để tạo tab con và chọn Kiểu 1, Kiểu 2, hoặc Kiểu 3!
                            </div>
                        <?php else : ?>
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <?php foreach ($cha['children'] as $con_id => $con) : 
                                    $con_layout_name = ($con['layout'] === 'layout_1') ? 'Kiểu 1: Showcase Card & Slider' : (($con['layout'] === 'layout_2') ? 'Kiểu 2: Sticky Sidebar' : 'Kiểu 3: Cột Theo Nền Rượu');
                                    $badge_color = ($con['layout'] === 'layout_1') ? '#8c5e2a' : (($con['layout'] === 'layout_2') ? '#2e6b9e' : '#1f7a4d');
                                    $con_img = !empty($con['image']) ? $con['image'] : (!empty($con['images'][0]) ? $con['images'][0] : '');
                                ?>
                                    <div style="background: #fff; border: 1px solid #dcdcde; border-radius: 6px; padding: 16px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                                        
                                        <!-- Header Menu Con -->
                                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; padding-bottom: 12px; border-bottom: 1px dashed #e0e0e0; margin-bottom: 14px;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <?php if (!empty($con_img)) : ?>
                                                    <img src="<?php echo esc_url($con_img); ?>" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid #2271b1;" alt="<?php echo esc_attr($con['title']); ?>">
                                                <?php endif; ?>
                                                <span style="background: #2271b1; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 3px;">
                                                    CẤP 2 (CON)
                                                </span>
                                                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #18110b;">
                                                    <?php echo esc_html($con['title']); ?>
                                                </h3>
                                                <span style="background: <?php echo esc_attr($badge_color); ?>; color: #fff; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 10px;">
                                                    ★ <?php echo esc_html($con_layout_name); ?>
                                                </span>
                                            </div>
                                            <div style="display: flex; gap: 6px;">
                                                <button type="button" onclick="otrEditCon('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($con_id); ?>', '<?php echo esc_js($con['title']); ?>', '<?php echo esc_js($con['layout']); ?>', '<?php echo esc_js($con['desc'] ?? ''); ?>', '<?php echo esc_js($con['tag'] ?? ''); ?>', '<?php echo esc_js($con['price'] ?? ''); ?>', '<?php echo esc_js($con_img); ?>')" class="button button-small">
                                                    ✎ Sửa
                                                </button>
                                                <button type="button" onclick="otrOpenAddConCon('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($con_id); ?>', '<?php echo esc_js($con['title']); ?>')" class="button button-small button-primary" style="background: #2271b1;">
                                                    + Thêm Cột / Nhóm
                                                </button>
                                                <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa Menu Con này?');" style="display:inline;">
                                                    <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                                                    <input type="hidden" name="otr_menu_action" value="delete_con">
                                                    <input type="hidden" name="parent_cha_id" value="<?php echo esc_attr($cha_id); ?>">
                                                    <input type="hidden" name="con_id" value="<?php echo esc_attr($con_id); ?>">
                                                    <button type="submit" class="button button-small" style="color: #cc1818;">✕ Xóa</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- KHỐI CÁC MENU CON CON (LEVEL 3 / CỘT RƯỢU) -->
                                        <div>
                                            <?php if (empty($con['sub_children'])) : ?>
                                                <div style="padding: 10px; color: #999; font-size: 13px; font-style: italic;">
                                                    Chưa có Nhóm Cột (Menu Con Con) nào. Bấm <strong>"+ Thêm Cột / Nhóm"</strong> để chia cột món (VD: Cột WHISKY, Cột GIN,...).
                                                </div>
                                            <?php else : ?>
                                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                                                    <?php foreach ($con['sub_children'] as $concon_id => $concon) : ?>
                                                        <div style="background: #fdfdfd; border: 1px solid #e5e5e5; border-radius: 5px; padding: 12px 14px;">
                                                            
                                                            <!-- Header Menu Con Con -->
                                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #eee;">
                                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                                    <span style="background: #e5e5e5; color: #555; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 3px;">
                                                                        CẤP 3
                                                                    </span>
                                                                    <strong style="color: #b8860b; font-size: 13px; text-transform: uppercase;">
                                                                        <?php echo esc_html($concon['title']); ?>
                                                                    </strong>
                                                                </div>
                                                                <div style="display: flex; gap: 4px;">
                                                                    <button type="button" onclick="otrOpenAddItem('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($con_id); ?>', '<?php echo esc_js($concon_id); ?>', '<?php echo esc_js($concon['title']); ?>')" class="button button-small" style="font-size: 11px; padding: 0 6px; height: 24px; line-height: 22px; color: #2271b1;">
                                                                        + Món
                                                                    </button>
                                                                    <form method="post" onsubmit="return confirm('Xóa nhóm này và tất cả món bên trong?');" style="display:inline;">
                                                                        <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                                                                        <input type="hidden" name="otr_menu_action" value="delete_concon">
                                                                        <input type="hidden" name="parent_cha_id" value="<?php echo esc_attr($cha_id); ?>">
                                                                        <input type="hidden" name="parent_con_id" value="<?php echo esc_attr($con_id); ?>">
                                                                        <input type="hidden" name="concon_id" value="<?php echo esc_attr($concon_id); ?>">
                                                                        <button type="submit" class="button button-small" style="color: #999; padding: 0 4px; height: 24px; line-height: 22px;">✕</button>
                                                                    </form>
                                                                </div>
                                                            </div>

                                                            <!-- DANH SÁCH CÁC MÓN -->
                                                            <?php if (empty($concon['items'])) : ?>
                                                                <div style="color: #aaa; font-size: 12px; font-style: italic; padding: 6px 0;">Chưa có món nào. Bấm <strong>+ Món</strong> để thêm.</div>
                                                            <?php else : ?>
                                                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                                                    <?php foreach ($concon['items'] as $it) : ?>
                                                                        <div style="display: flex; justify-content: space-between; align-items: center; background: #fff; border: 1px solid #f0f0f0; border-radius: 4px; padding: 6px 10px; font-size: 13px;">
                                                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                                                <?php if (!empty($it['image'])) : ?>
                                                                                    <img src="<?php echo esc_url($it['image']); ?>" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; flex-shrink: 0;" alt="<?php echo esc_attr($it['name']); ?>">
                                                                                <?php endif; ?>
                                                                                <div>
                                                                                    <strong style="color: #222;"><?php echo esc_html($it['name']); ?></strong>
                                                                                    <span style="color: #b8860b; font-weight: 600; margin-left: 6px;"><?php echo esc_html($it['price']); ?></span>
                                                                                    <?php if (!empty($it['desc'])) : ?>
                                                                                        <div style="color: #777; font-size: 11px;"><?php echo esc_html($it['desc']); ?></div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div style="display: flex; gap: 4px; shrink-0; margin-left: 8px;">
                                                                                <button type="button" onclick="otrEditItem('<?php echo esc_js($cha_id); ?>', '<?php echo esc_js($con_id); ?>', '<?php echo esc_js($concon_id); ?>', '<?php echo esc_js($it['id']); ?>', '<?php echo esc_js($it['name']); ?>', '<?php echo esc_js($it['price']); ?>', '<?php echo esc_js($it['desc'] ?? ''); ?>', '<?php echo esc_js($it['image'] ?? ''); ?>')" class="button button-small" style="padding: 0 5px; height: 22px; line-height: 20px; font-size: 10px;">✎</button>
                                                                                <form method="post" onsubmit="return confirm('Xóa món này?');" style="display:inline;">
                                                                                    <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                                                                                    <input type="hidden" name="otr_menu_action" value="delete_item">
                                                                                    <input type="hidden" name="parent_cha_id" value="<?php echo esc_attr($cha_id); ?>">
                                                                                    <input type="hidden" name="parent_con_id" value="<?php echo esc_attr($con_id); ?>">
                                                                                    <input type="hidden" name="parent_concon_id" value="<?php echo esc_attr($concon_id); ?>">
                                                                                    <input type="hidden" name="item_id" value="<?php echo esc_attr($it['id']); ?>">
                                                                                    <button type="submit" class="button button-small" style="color: #cc1818; padding: 0 4px; height: 22px; line-height: 20px; font-size: 10px;">✕</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- ================= MODALS CHO THÊM & SỬA ================= -->

    <!-- Modal 1: Thêm/Sửa Menu Cha -->
    <div id="modal-add-cha" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 100000; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 520px; max-width: 90%; border-radius: 8px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); position: relative; max-height: 90vh; overflow-y: auto;">
            <h3 id="modal-cha-title" style="margin-top: 0; font-size: 18px; color: #18110b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                Thêm Menu Cha (Cấp 1)
            </h3>
            <form method="post">
                <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                <input type="hidden" name="otr_menu_action" value="save_cha">
                <input type="hidden" name="cha_id" id="input_cha_id" value="">
                
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Tên Menu Cha *</label>
                    <input type="text" name="cha_title" id="input_cha_title" required class="widefat" placeholder="VD: 02 CLASSIC COCKTAIL">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Số thứ tự hiển thị (VD: 01, 02)</label>
                    <input type="text" name="cha_num" id="input_cha_num" class="widefat" placeholder="01">
                </div>
                <div style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label style="display:block; font-weight: 600; margin: 0;">Kiểu hiển thị mặc định của Menu Cha</label>
                        <a href="javascript:void(0)" onclick="otrOpenDemoModal('input_cha_layout')" style="font-size: 11.5px; color: #2271b1; text-decoration: underline; font-weight: 600; display: inline-flex; align-items: center; gap: 3px;">
                            <span class="dashicons dashicons-visibility" style="font-size: 14px; width: 14px; height: 14px;"></span> Chưa rõ? Xem Demo 3 Kiểu
                        </a>
                    </div>
                    <select name="cha_layout" id="input_cha_layout" class="widefat">
                        <option value="layout_3">Kiểu 3: Danh Sách Cột Theo Nền Rượu (Classic 2 Cột - Mockup chuẩn)</option>
                        <option value="layout_1">Kiểu 1: Showcase Card & Slider Ảnh (Card tương tác nốt vị)</option>
                        <option value="layout_2">Kiểu 2: Sidebar Cố Định Cuộn Trang (Sticky Sidebar)</option>
                    </select>
                </div>
                
                <!-- Chọn hình ảnh qua Media Library -->
                <div style="margin-bottom: 14px; background: #fafafa; border: 1px solid #e5e5e5; border-radius: 6px; padding: 12px 14px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 6px;">Ảnh bìa / Banner Menu Cha</label>
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px; flex-wrap: wrap;">
                        <button type="button" class="button button-secondary otr-upload-media-btn" data-target-input="input_cha_image" data-target-preview="preview_cha_image" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 600;">
                            <span class="dashicons dashicons-admin-media" style="vertical-align: middle; margin-top:-2px;"></span> Chọn từ Thư viện Media
                        </button>
                        <button type="button" class="button otr-remove-media-btn" data-target-input="input_cha_image" data-target-preview="preview_cha_image" style="color: #cc1818;">
                            ✕ Xóa ảnh
                        </button>
                    </div>
                    <div id="preview_cha_image" style="min-height: 20px; margin-bottom: 8px;"></div>
                    <input type="text" name="cha_image" id="input_cha_image" class="widefat" placeholder="Đường dẫn ảnh từ Thư viện WordPress..." readonly style="background: #f6f7f7; color: #555; font-size: 12px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Mô tả ngắn</label>
                    <textarea name="cha_desc" id="input_cha_desc" rows="3" class="widefat" placeholder="Mô tả phong cách đồ uống của nhóm này..."></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="otrCloseModal('modal-add-cha')" class="button">Hủy</button>
                    <button type="submit" class="button button-primary">Lưu Menu Cha</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Thêm/Sửa Menu Con -->
    <div id="modal-add-con" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 100000; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 540px; max-width: 90%; border-radius: 8px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); position: relative; max-height: 90vh; overflow-y: auto;">
            <h3 id="modal-con-heading" style="margin-top: 0; font-size: 18px; color: #18110b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                Thêm Menu Con (Cấp 2)
            </h3>
            <form method="post">
                <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                <input type="hidden" name="otr_menu_action" value="save_con">
                <input type="hidden" name="parent_cha_id" id="input_con_parent_cha" value="">
                <input type="hidden" name="con_id" id="input_con_id" value="">
                
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Tên Menu Con (Tên Tab) *</label>
                    <input type="text" name="con_title" id="input_con_title" required class="widefat" placeholder="VD: CLASSIC COCKTAIL hoặc SIGNATURE CRAFT">
                </div>
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label style="display:block; font-weight: 700; color: #b8860b; margin: 0;">
                            ★ CHỌN KIỂU HIỂN THỊ CHO MENU CON NÀY:
                        </label>
                        <a href="javascript:void(0)" onclick="otrOpenDemoModal('input_con_layout')" style="font-size: 11.5px; color: #2271b1; text-decoration: underline; font-weight: 600; display: inline-flex; align-items: center; gap: 3px;">
                            <span class="dashicons dashicons-visibility" style="font-size: 14px; width: 14px; height: 14px;"></span> Chưa rõ? Xem Demo 3 Kiểu
                        </a>
                    </div>
                    <select name="con_layout" id="input_con_layout" class="widefat" style="font-weight: 600; padding: 6px;">
                        <option value="layout_3">Kiểu 3: Danh Sách Cột Theo Nền Rượu (Classic 2 Cột kinh điển)</option>
                        <option value="layout_1">Kiểu 1: Showcase Card & Slider Ảnh (Card hương vị & Slider)</option>
                        <option value="layout_2">Kiểu 2: Sidebar Cố Định Cuộn Trang (Sticky Sidebar bám cuộn)</option>
                    </select>
                </div>
                <div style="margin-bottom: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display:block; font-weight: 600; margin-bottom: 4px;">Tag danh mục (Kiểu 1)</label>
                        <input type="text" name="con_tag" id="input_con_tag" class="widefat" placeholder="VD: BESPOKE">
                    </div>
                    <div>
                        <label style="display:block; font-weight: 600; margin-bottom: 4px;">Giá tham chiếu (Kiểu 1)</label>
                        <input type="text" name="con_price" id="input_con_price" class="widefat" placeholder="VD: 320k">
                    </div>
                </div>

                <!-- Chọn hình ảnh qua Media Library cho Menu Con -->
                <div style="margin-bottom: 14px; background: #fafafa; border: 1px solid #e5e5e5; border-radius: 6px; padding: 12px 14px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 6px;">Ảnh đại diện / Slider Menu Con (Tùy chọn)</label>
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px; flex-wrap: wrap;">
                        <button type="button" class="button button-secondary otr-upload-media-btn" data-target-input="input_con_image" data-target-preview="preview_con_image" style="background: #2271b1; border-color: #135e96; color: #fff; font-weight: 600;">
                            <span class="dashicons dashicons-admin-media" style="vertical-align: middle; margin-top:-2px;"></span> Chọn từ Thư viện Media
                        </button>
                        <button type="button" class="button otr-remove-media-btn" data-target-input="input_con_image" data-target-preview="preview_con_image" style="color: #cc1818;">
                            ✕ Xóa ảnh
                        </button>
                    </div>
                    <div id="preview_con_image" style="min-height: 20px; margin-bottom: 8px;"></div>
                    <input type="text" name="con_image" id="input_con_image" class="widefat" placeholder="Đường dẫn ảnh từ Thư viện WordPress..." readonly style="background: #f6f7f7; color: #555; font-size: 12px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Mô tả chi tiết</label>
                    <textarea name="con_desc" id="input_con_desc" rows="2" class="widefat" placeholder="Mô tả cho tab này..."></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="otrCloseModal('modal-add-con')" class="button">Hủy</button>
                    <button type="submit" class="button button-primary">Lưu Menu Con</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Thêm/Sửa Menu Con Con (Nhóm Cột) -->
    <div id="modal-add-concon" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 100000; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 460px; max-width: 90%; border-radius: 8px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); position: relative;">
            <h3 id="modal-concon-heading" style="margin-top: 0; font-size: 18px; color: #18110b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                Thêm Nhóm Cột / Menu Con Con (Cấp 3)
            </h3>
            <form method="post">
                <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                <input type="hidden" name="otr_menu_action" value="save_concon">
                <input type="hidden" name="parent_cha_id" id="input_concon_parent_cha" value="">
                <input type="hidden" name="parent_con_id" id="input_concon_parent_con" value="">
                <input type="hidden" name="concon_id" id="input_concon_id" value="">
                
                <div style="margin-bottom: 16px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Tên Nền Rượu / Nhóm Cột (Menu Con Con) *</label>
                    <input type="text" name="concon_title" id="input_concon_title" required class="widefat" placeholder="VD: WHISKY, GIN, RUM & TEQUILA,...">
                    <p style="font-size: 12px; color: #777; margin: 4px 0 0;">Trong Kiểu 3, tên này sẽ là tiêu đề của từng cột thực đơn.</p>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="otrCloseModal('modal-add-concon')" class="button">Hủy</button>
                    <button type="submit" class="button button-primary">Lưu Nhóm Cột</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 4: Thêm/Sửa Món -->
    <div id="modal-add-item" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 100000; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 500px; max-width: 90%; border-radius: 8px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); position: relative; max-height: 90vh; overflow-y: auto;">
            <h3 id="modal-item-heading" style="margin-top: 0; font-size: 18px; color: #18110b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                Thêm Món Mới
            </h3>
            <form method="post">
                <?php wp_nonce_field('otr_menu_therocks_nonce', 'otr_nonce'); ?>
                <input type="hidden" name="otr_menu_action" value="save_item">
                <input type="hidden" name="parent_cha_id" id="input_item_parent_cha" value="">
                <input type="hidden" name="parent_con_id" id="input_item_parent_con" value="">
                <input type="hidden" name="parent_concon_id" id="input_item_parent_concon" value="">
                <input type="hidden" name="item_id" id="input_item_id" value="">
                
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Tên Món Ăn / Đồ Uống *</label>
                    <input type="text" name="item_name" id="input_item_name" required class="widefat" placeholder="VD: Boulevardier">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Giá tiền *</label>
                    <input type="text" name="item_price" id="input_item_price" required class="widefat" placeholder="VD: 199k hoặc 250.000đ">
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 4px;">Thành phần / Mô tả hương vị</label>
                    <textarea name="item_desc" id="input_item_desc" rows="2" class="widefat" placeholder="VD: Bourbon, Campari, Sweet Vermouth, Orange Twist"></textarea>
                </div>

                <!-- Chọn hình ảnh món ăn qua Media Library -->
                <div style="margin-bottom: 16px; background: #fafafa; border: 1px solid #e5e5e5; border-radius: 6px; padding: 12px 14px;">
                    <label style="display:block; font-weight: 600; margin-bottom: 6px;">Ảnh món / Đồ uống (Tùy chọn)</label>
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px; flex-wrap: wrap;">
                        <button type="button" class="button button-secondary otr-upload-media-btn" data-target-input="input_item_image" data-target-preview="preview_item_image" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 600;">
                            <span class="dashicons dashicons-admin-media" style="vertical-align: middle; margin-top:-2px;"></span> Chọn từ Thư viện Media
                        </button>
                        <button type="button" class="button otr-remove-media-btn" data-target-input="input_item_image" data-target-preview="preview_item_image" style="color: #cc1818;">
                            ✕ Xóa ảnh
                        </button>
                    </div>
                    <div id="preview_item_image" style="min-height: 20px; margin-bottom: 8px;"></div>
                    <input type="text" name="item_image" id="input_item_image" class="widefat" placeholder="Đường dẫn ảnh từ Thư viện WordPress..." readonly style="background: #f6f7f7; color: #555; font-size: 12px;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="otrCloseModal('modal-add-item')" class="button">Hủy</button>
                    <button type="submit" class="button button-primary">Lưu Món</button>
                </div>
            </form>
        </div>
    </div>


    <!-- ================= MODAL 5: XEM DEMO & SO SÁNH 3 KIỂU MENU ================= -->
    <div id="modal-menu-demo" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 100001; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: #ffffff; width: 1080px; max-width: 95%; border-radius: 12px; box-shadow: 0 25px 70px rgba(0,0,0,0.5); position: relative; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #caa875;">
            
            <!-- Header Modal Demo -->
            <div style="background: linear-gradient(135deg, #1e1710 0%, #120d08 100%); color: #caa875; padding: 20px 28px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(202,168,117,0.4);">
                <div>
                    <div style="font-size: 11px; letter-spacing: 3px; color: #caa875; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">
                        ✦ ON THE ROCK BAR - HƯỚNG DẪN TRỰC QUAN GIAO DIỆN
                    </div>
                    <h2 style="color: #ffffff; margin: 0; font-size: 21px; font-weight: 700; font-family: Georgia, serif; letter-spacing: 0.02em;">
                        DEMO & SO SÁNH 3 KIỂU HIỂN THỊ MENU THEROCKS
                    </h2>
                    <p style="color: #d8c19d; margin: 4px 0 0; font-size: 12.5px;">
                        Xem trước bản vẽ bố cục, ưu điểm và chọn ngay kiểu hiển thị thích hợp nhất cho từng nhóm đồ uống.
                    </p>
                </div>
                <button type="button" onclick="otrCloseModal('modal-menu-demo')" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(202,168,117,0.3); color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">✕</button>
            </div>

            <!-- Thanh Tabs Chuyển Đổi Kiểu Demo -->
            <div style="background: #faf8f5; border-bottom: 1px solid #e8dfd3; padding: 10px 24px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <button type="button" class="otr-demo-tab-btn button" data-tab="demo-tab-1" onclick="otrSwitchDemoTab('demo-tab-1')" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 700; padding: 6px 16px;">
                    ★ Kiểu 1: Showcase Card & Slider Ảnh
                </button>
                <button type="button" class="otr-demo-tab-btn button" data-tab="demo-tab-2" onclick="otrSwitchDemoTab('demo-tab-2')" style="background: #fff; color: #333; font-weight: 600; padding: 6px 16px;">
                    ★ Kiểu 2: Sticky Sidebar (Bám Dính)
                </button>
                <button type="button" class="otr-demo-tab-btn button" data-tab="demo-tab-3" onclick="otrSwitchDemoTab('demo-tab-3')" style="background: #fff; color: #333; font-weight: 600; padding: 6px 16px;">
                    ★ Kiểu 3: Danh Sách Cột Theo Rượu (Classic)
                </button>
                <button type="button" class="otr-demo-tab-btn button" data-tab="demo-tab-matrix" onclick="otrSwitchDemoTab('demo-tab-matrix')" style="background: #221911; color: #caa875; border-color: #caa875; font-weight: 600; padding: 6px 16px; margin-left: auto;">
                    📊 Bảng So Sánh 3 Kiểu
                </button>
            </div>

            <!-- Khung Nội Dung Cuộn (Scroll Area) -->
            <div style="padding: 24px 28px; overflow-y: auto; flex: 1; background: #fdfdfd;">
                
                <!-- ================= PANEL 1: KIỂU 1 SHOWCASE ================= -->
                <div id="demo-tab-1" class="otr-demo-panel" style="display: block;">
                    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; align-items: start;">
                        
                        <!-- Cột Trái: Bản vẽ Mockup trực quan Kiểu 1 -->
                        <div style="background: #0d0b08; border: 1px solid #caa875; border-radius: 8px; padding: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                            <div style="font-size: 11px; color: #caa875; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; margin-bottom: 12px; border-bottom: 1px dashed rgba(202,168,117,0.3); padding-bottom: 6px; display: flex; justify-content: space-between;">
                                <span>MÔ PHỎNG GIAO DIỆN TRÊN WEBSITE</span>
                                <span style="color: #888;">KIỂU 1</span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <!-- Nửa Trái: Card nốt vị & nền rượu -->
                                <div style="background: #19120b; border: 1px solid rgba(202,168,117,0.4); border-radius: 6px; padding: 14px; color: #f4ede4;">
                                    <div style="font-size: 10px; color: #caa875; letter-spacing: 1px; text-transform: uppercase;">BESPOKE CRAFT</div>
                                    <div style="font-size: 14px; font-weight: bold; color: #fff; margin: 4px 0;">Artisanal Smoked Old Fashioned</div>
                                    <div style="font-size: 12px; color: #caa875; font-weight: 700; margin-bottom: 8px;">320.000đ</div>
                                    
                                    <div style="font-size: 10px; color: #aaa; margin-bottom: 4px;">NỐT HƯƠNG VỊ (TƯƠNG TÁC):</div>
                                    <div style="display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 10px;">
                                        <span style="background: #caa875; color: #18110b; font-size: 9px; padding: 2px 6px; border-radius: 10px; font-weight: 700;">Ngọt</span>
                                        <span style="background: rgba(202,168,117,0.2); color: #caa875; font-size: 9px; padding: 2px 6px; border-radius: 10px;">Chua</span>
                                        <span style="background: #caa875; color: #18110b; font-size: 9px; padding: 2px 6px; border-radius: 10px; font-weight: 700;">Khói</span>
                                        <span style="background: rgba(202,168,117,0.2); color: #caa875; font-size: 9px; padding: 2px 6px; border-radius: 10px;">Thảo mộc</span>
                                    </div>

                                    <div style="font-size: 10px; color: #aaa; margin-bottom: 2px;">THÀNH PHẦN NỀN RƯỢU:</div>
                                    <div style="font-size: 10px; color: #ddd; line-height: 1.4;">
                                        • Base: Single Malt Scotch<br>
                                        • Infuse: Cinnamon Bark<br>
                                        • Bitters: Walnut Bitters
                                    </div>
                                </div>

                                <!-- Nửa Phải: Slider ảnh khổ lớn -->
                                <div style="background: #201912; border: 1px solid rgba(202,168,117,0.3); border-radius: 6px; overflow: hidden; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px; text-align: center; min-height: 170px;">
                                    <span class="dashicons dashicons-format-image" style="font-size: 40px; width: 40px; height: 40px; color: #caa875;"></span>
                                    <div style="font-size: 11px; color: #caa875; font-weight: 700; margin-top: 6px;">SLIDER ẢNH KHỔ LỚN</div>
                                    <div style="font-size: 9px; color: #888; margin-top: 2px;">Trình chiếu hình ảnh ly cocktail nghệ thuật, kèm nút chuyển slide &lt; &gt;</div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải: Phân tích chi tiết & Nút chọn -->
                        <div>
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <span style="background: #caa875; color: #18110b; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">KIỂU 1</span>
                                <span style="background: #e8f5e9; color: #2e7d32; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px;">ĐỈNH CAO TRẢI NGHIỆM</span>
                            </div>

                            <h3 style="margin: 0 0 10px; font-size: 18px; color: #18110b;">
                                Showcase Card & Slider Ảnh
                            </h3>
                            
                            <p style="font-size: 13px; color: #555; line-height: 1.6; margin: 0 0 14px;">
                                Bố cục dạng <strong>thẻ giới thiệu 2 nửa tương tác</strong>: Cột bên trái hiển thị hồ sơ chi tiết nốt vị (Ngọt, Chua, Đắng, Khói,...), bảng thành phần nền rượu, độ cồn; Cột bên phải là slider trình chiếu hình ảnh đồ uống sắc nét khổ lớn.
                            </p>

                            <div style="background: #fff8eb; border-left: 3px solid #caa875; padding: 10px 14px; margin-bottom: 14px; font-size: 12px; line-height: 1.6;">
                                <strong style="color: #b8860b;">★ Khi nào bạn nên chọn Kiểu 1?</strong><br>
                                • Dùng cho dòng <strong>Signature Cocktails</strong> độc bản hoặc các món đắt tiền.<br>
                                • Khi bạn muốn khách hàng biết rõ nốt vị (ngọt, chua, khói...) và nhìn ngắm hình ảnh ly cocktail trước khi gọi.<br>
                                • Quán có hình ảnh chụp đồ uống đẹp, chuyên nghiệp.
                            </div>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <button type="button" onclick="otrSelectLayoutFromDemo('layout_1')" class="button button-primary" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: 700; padding: 6px 18px;">
                                    ✓ CHỌN KIỂU 1 CHO MENU
                                </button>
                                <a href="<?php echo esc_url(home_url('/menu/')); ?>" target="_blank" class="button" style="display: inline-flex; align-items: center; gap: 4px;">
                                    ↗ Xem Thực Tế Trên Website
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= PANEL 2: KIỂU 2 STICKY SIDEBAR ================= -->
                <div id="demo-tab-2" class="otr-demo-panel" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; align-items: start;">
                        
                        <!-- Cột Trái: Bản vẽ Mockup trực quan Kiểu 2 -->
                        <div style="background: #0d0b08; border: 1px solid #2271b1; border-radius: 8px; padding: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                            <div style="font-size: 11px; color: #2271b1; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; margin-bottom: 12px; border-bottom: 1px dashed rgba(34,113,177,0.3); padding-bottom: 6px; display: flex; justify-content: space-between;">
                                <span>MÔ PHỎNG GIAO DIỆN TRÊN WEBSITE</span>
                                <span style="color: #888;">KIỂU 2</span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 0.8fr 1.2fr; gap: 12px;">
                                <!-- Cột Trái: Sticky Sidebar Menu -->
                                <div style="background: #141416; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 12px; font-size: 10px; color: #aaa;">
                                    <div style="font-weight: 700; color: #caa875; margin-bottom: 8px; font-size: 9px; text-transform: uppercase;">STICKY SIDEBAR:</div>
                                    <div style="padding: 4px 6px; background: rgba(34,113,177,0.25); color: #fff; border-left: 2px solid #2271b1; margin-bottom: 4px; font-weight: bold;">01. REFRESHING</div>
                                    <div style="padding: 4px 6px; margin-bottom: 4px;">02. COMPLEX</div>
                                    <div style="padding: 4px 6px; margin-bottom: 4px;">03. SWEET DESSERT</div>
                                    <div style="padding: 4px 6px; margin-bottom: 4px;">04. BOTANICAL</div>
                                    <div style="margin-top: 10px; font-size: 8.5px; color: #777; font-style: italic;">(Bám cố định khi cuộn trang)</div>
                                </div>

                                <!-- Cột Phải: Danh sách cuộn món ăn -->
                                <div style="background: #19120b; border: 1px solid rgba(202,168,117,0.3); border-radius: 6px; padding: 12px; color: #fff; font-size: 11px;">
                                    <div style="font-size: 13px; font-weight: bold; color: #caa875; margin-bottom: 6px;">REFRESHING & CITRUS</div>
                                    <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px; margin-bottom: 6px;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <strong>Foggy Dalat Valley</strong>
                                            <span style="color: #caa875;">299k</span>
                                        </div>
                                        <div style="font-size: 9px; color: #888;">Wild Herb Dalat Gin, Elderflower, Pine Mist</div>
                                    </div>
                                    <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px; margin-bottom: 6px;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <strong>Sunset Over Truc Lam</strong>
                                            <span style="color: #caa875;">299k</span>
                                        </div>
                                        <div style="font-size: 9px; color: #888;">Campari, Passion Fruit, Wild Honey</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải: Phân tích chi tiết & Nút chọn -->
                        <div>
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <span style="background: #2271b1; color: #fff; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">KIỂU 2</span>
                                <span style="background: #e3f2fd; color: #1565c0; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px;">TIỆN LỢI CUỘN TRANG</span>
                            </div>

                            <h3 style="margin: 0 0 10px; font-size: 18px; color: #18110b;">
                                Sticky Sidebar (Thanh Danh Mục Cố Định)
                            </h3>
                            
                            <p style="font-size: 13px; color: #555; line-height: 1.6; margin: 0 0 14px;">
                                Bố cục chia đôi: <strong>Thanh danh mục bên trái bám dính (sticky)</strong> cố định trên màn hình khi khách cuộn chuột xuống dưới. Bấm vào danh mục nào sẽ tự động cuộn mượt đến ngay nhóm món đó.
                            </p>

                            <div style="background: #f0f7ff; border-left: 3px solid #2271b1; padding: 10px 14px; margin-bottom: 14px; font-size: 12px; line-height: 1.6;">
                                <strong style="color: #1565c0;">★ Khi nào bạn nên chọn Kiểu 2?</strong><br>
                                • Khi nhóm thực đơn có <strong>nhiều món hoặc nhiều tiểu mục</strong> (VD: Danh mục Shots, Mocktail, Trái cây, Đồ ăn vặt, Rượu vang).<br>
                                • Muốn khách hàng dễ dàng chuyển qua lại giữa các nhóm mà không bị trôi trang mất dấu.<br>
                                • Bố cục tối ưu rất tốt trên cả máy tính lẫn máy tính bảng.
                            </div>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <button type="button" onclick="otrSelectLayoutFromDemo('layout_2')" class="button button-primary" style="background: #2271b1; border-color: #135e96; color: #fff; font-weight: 700; padding: 6px 18px;">
                                    ✓ CHỌN KIỂU 2 CHO MENU
                                </button>
                                <a href="<?php echo esc_url(home_url('/menu/')); ?>" target="_blank" class="button" style="display: inline-flex; align-items: center; gap: 4px;">
                                    ↗ Xem Thực Tế Trên Website
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= PANEL 3: KIỂU 3 CLASSIC COLUMNS ================= -->
                <div id="demo-tab-3" class="otr-demo-panel" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; align-items: start;">
                        
                        <!-- Cột Trái: Bản vẽ Mockup trực quan Kiểu 3 -->
                        <div style="background: #0d0b08; border: 1px solid #caa875; border-radius: 8px; padding: 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                            <div style="font-size: 11px; color: #caa875; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; margin-bottom: 12px; border-bottom: 1px dashed rgba(202,168,117,0.3); padding-bottom: 6px; display: flex; justify-content: space-between;">
                                <span>MÔ PHỎNG GIAO DIỆN TRÊN WEBSITE</span>
                                <span style="color: #888;">KIỂU 3</span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                <!-- Cột 1: WHISKY -->
                                <div style="background: #140e08; border: 1px solid rgba(202,168,117,0.3); border-radius: 6px; padding: 12px;">
                                    <div style="font-size: 11px; font-weight: 800; color: #caa875; letter-spacing: 1.5px; text-transform: uppercase; border-bottom: 1px solid rgba(202,168,117,0.2); padding-bottom: 4px; margin-bottom: 8px;">
                                        CỘT: WHISKY
                                    </div>
                                    <div style="margin-bottom: 6px; font-size: 10.5px;">
                                        <div style="display:flex; justify-content:space-between; color:#fff;">
                                            <strong>Boulevardier</strong>
                                            <span style="color:#caa875; font-weight:bold;">199k</span>
                                        </div>
                                        <div style="font-size: 9px; color:#888;">Bourbon, Campari, Sweet Vermouth</div>
                                    </div>
                                    <div style="margin-bottom: 6px; font-size: 10.5px;">
                                        <div style="display:flex; justify-content:space-between; color:#fff;">
                                            <strong>Godfather</strong>
                                            <span style="color:#caa875; font-weight:bold;">199k</span>
                                        </div>
                                        <div style="font-size: 9px; color:#888;">Scotch Whisky, Amaretto Liqueur</div>
                                    </div>
                                </div>

                                <!-- Cột 2: GIN & BOTANICAL -->
                                <div style="background: #140e08; border: 1px solid rgba(202,168,117,0.3); border-radius: 6px; padding: 12px;">
                                    <div style="font-size: 11px; font-weight: 800; color: #caa875; letter-spacing: 1.5px; text-transform: uppercase; border-bottom: 1px solid rgba(202,168,117,0.2); padding-bottom: 4px; margin-bottom: 8px;">
                                        CỘT: GIN
                                    </div>
                                    <div style="margin-bottom: 6px; font-size: 10.5px;">
                                        <div style="display:flex; justify-content:space-between; color:#fff;">
                                            <strong>Clover Club</strong>
                                            <span style="color:#caa875; font-weight:bold;">199k</span>
                                        </div>
                                        <div style="font-size: 9px; color:#888;">Dry Gin, Raspberry Syrup, Lemon</div>
                                    </div>
                                    <div style="margin-bottom: 6px; font-size: 10.5px;">
                                        <div style="display:flex; justify-content:space-between; color:#fff;">
                                            <strong>Dry Martini</strong>
                                            <span style="color:#caa875; font-weight:bold;">199k</span>
                                        </div>
                                        <div style="font-size: 9px; color:#888;">London Dry Gin, Dry Vermouth, Olive</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cột Phải: Phân tích chi tiết & Nút chọn -->
                        <div>
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <span style="background: #1f7a4d; color: #fff; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 12px;">KIỂU 3</span>
                                <span style="background: #e8f5e9; color: #2e7d32; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px;">CHUẨN COCKTAIL BAR QUỐC TẾ</span>
                            </div>

                            <h3 style="margin: 0 0 10px; font-size: 18px; color: #18110b;">
                                Danh Sách Cột Theo Rượu (Classic Columns)
                            </h3>
                            
                            <p style="font-size: 13px; color: #555; line-height: 1.6; margin: 0 0 14px;">
                                Bố cục <strong>chia 2 hoặc 3 cột song song theo từng nền rượu</strong> (Whisky, Gin, Rum, Tequila, Vodka,...). Đây là kiểu menu kinh điển, sang trọng và phổ biến nhất tại các Cocktail Bar danh tiếng trên thế giới.
                            </p>

                            <div style="background: #f0fdf4; border-left: 3px solid #1f7a4d; padding: 10px 14px; margin-bottom: 14px; font-size: 12px; line-height: 1.6;">
                                <strong style="color: #1f7a4d;">★ Khi nào bạn nên chọn Kiểu 3?</strong><br>
                                • Dùng cho toàn bộ dòng <strong>Classic Cocktails</strong> bất hủ (Old Fashioned, Negroni, Margarita, Manhattan,...).<br>
                                • Dùng cho danh mục Rượu Mạnh (Spirits list), Rượu Vang theo chai, Bia thủ công.<br>
                                • Khi muốn khách dễ dàng so sánh giá và thành phần của nhiều món trong cùng một tầm mắt mà không cần xem ảnh lớn.
                            </div>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <button type="button" onclick="otrSelectLayoutFromDemo('layout_3')" class="button button-primary" style="background: #1f7a4d; border-color: #175d3a; color: #fff; font-weight: 700; padding: 6px 18px;">
                                    ✓ CHỌN KIỂU 3 CHO MENU
                                </button>
                                <a href="<?php echo esc_url(home_url('/menu/')); ?>" target="_blank" class="button" style="display: inline-flex; align-items: center; gap: 4px;">
                                    ↗ Xem Thực Tế Trên Website
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= PANEL 4: BẢNG SO SÁNH TỔNG QUAN ================= -->
                <div id="demo-tab-matrix" class="otr-demo-panel" style="display: none;">
                    <h3 style="margin-top: 0; font-size: 17px; color: #18110b; margin-bottom: 14px;">
                        Bảng So Sánh Chi Tiết 3 Kiểu Hiển Thị Thực Đơn TheRocks
                    </h3>
                    
                    <table class="widefat striped" style="border: 1px solid #ddd; border-radius: 6px; overflow: hidden; font-size: 13px;">
                        <thead>
                            <tr style="background: #f6f7f7;">
                                <th style="width: 20%; font-weight: 700;">Tiêu chí so sánh</th>
                                <th style="width: 26%; font-weight: 700; color: #8c5e2a;">Kiểu 1: Showcase Card & Slider</th>
                                <th style="width: 26%; font-weight: 700; color: #1565c0;">Kiểu 2: Sticky Sidebar</th>
                                <th style="width: 28%; font-weight: 700; color: #1f7a4d;">Kiểu 3: Danh Sách Cột Theo Rượu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Phong cách trải nghiệm</strong></td>
                                <td>Trực quan, thị giác cao cấp, kể câu chuyện hương vị</td>
                                <td>Hiện đại, tiện dụng, cuộn bám dính thông minh</td>
                                <td>Kinh điển, quý phái, chuẩn phong cách Bar quốc tế</td>
                            </tr>
                            <tr>
                                <td><strong>Bố cục trên màn hình</strong></td>
                                <td>Chia 2 nửa: Card nốt vị tương tác + Slider ảnh lớn</td>
                                <td>Menu tab bám mép trái + Nội dung cuộn bên phải</td>
                                <td>2 hoặc 3 cột song song chia theo nền rượu</td>
                            </tr>
                            <tr>
                                <td><strong>Nhóm đồ uống phù hợp nhất</strong></td>
                                <td><span style="background:#fff3e0; color:#e65100; padding:2px 6px; border-radius:3px; font-weight:600;">Signature Cocktails</span>, Món đắt tiền, Best-seller độc bản</td>
                                <td><span style="background:#e3f2fd; color:#0d47a1; padding:2px 6px; border-radius:3px; font-weight:600;">Menu dài</span>, Shots, Mocktail, Đồ ăn vặt, Nước giải khát</td>
                                <td><span style="background:#e8f5e9; color:#1b5e20; padding:2px 6px; border-radius:3px; font-weight:600;">Classic Cocktails</span>, Rượu mạnh theo ly/chai, Rượu vang, Bia</td>
                            </tr>
                            <tr>
                                <td><strong>Yêu cầu hình ảnh</strong></td>
                                <td><strong>Rất cần</strong> ảnh đẹp, chất lượng cao để hiển thị vào slider</td>
                                <td>Tùy chọn ảnh banner nhóm hoặc icon danh mục</td>
                                <td>Không bắt buộc ảnh (chỉ cần tên món & thành phần)</td>
                            </tr>
                            <tr>
                                <td><strong>Thao tác nhanh</strong></td>
                                <td><button type="button" onclick="otrSelectLayoutFromDemo('layout_1')" class="button button-small" style="background:#caa875; border-color:#b8935c; color:#18110b; font-weight:600;">Chọn Kiểu 1</button></td>
                                <td><button type="button" onclick="otrSelectLayoutFromDemo('layout_2')" class="button button-small button-primary" style="background:#2271b1;">Chọn Kiểu 2</button></td>
                                <td><button type="button" onclick="otrSelectLayoutFromDemo('layout_3')" class="button button-small" style="background:#1f7a4d; border-color:#175d3a; color:#fff; font-weight:600;">Chọn Kiểu 3</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Footer Modal Demo -->
            <div style="background: #f6f7f7; border-top: 1px solid #e0e0e0; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-size: 12px; color: #666;">
                    💡 <em>Gợi ý: Mỗi Menu Con có thể chọn 1 kiểu hiển thị riêng biệt để thực đơn đa dạng và sinh động nhất!</em>
                </div>
                <button type="button" onclick="otrCloseModal('modal-menu-demo')" class="button">Đóng Cửa Sổ</button>
            </div>

        </div>
    </div>
    <!-- JAVASCRIPT ĐIỀU KHIỂN MODAL, MEDIA LIBRARY & HƯỚNG DẪN -->
    <script>
    // 8. Quản lý Modal Xem Demo Các Kiểu Menu
    window.otrTargetLayoutInput = null;

    function otrOpenDemoModal(targetSelectId) {
        window.otrTargetLayoutInput = targetSelectId || null;
        otrSwitchDemoTab('demo-tab-1');
        otrOpenModal('modal-menu-demo');
    }

    function otrSwitchDemoTab(tabId) {
        // Ẩn tất cả panel
        var panels = document.querySelectorAll('.otr-demo-panel');
        panels.forEach(function(p) { p.style.display = 'none'; });

        // Hiển thị panel tương ứng
        var targetPanel = document.getElementById(tabId);
        if (targetPanel) targetPanel.style.display = 'block';

        // Đổi màu active tab
        var tabBtns = document.querySelectorAll('.otr-demo-tab-btn');
        tabBtns.forEach(function(btn) {
            if (btn.getAttribute('data-tab') === tabId) {
                btn.style.background = '#caa875';
                btn.style.color = '#18110b';
                btn.style.borderColor = '#b8935c';
                btn.style.fontWeight = '700';
            } else {
                btn.style.background = '#ffffff';
                btn.style.color = '#333333';
                btn.style.borderColor = '#cccccc';
                btn.style.fontWeight = '600';
            }
        });
    }

    function otrSelectLayoutFromDemo(layoutKey) {
        if (window.otrTargetLayoutInput) {
            var el = document.getElementById(window.otrTargetLayoutInput);
            if (el) {
                el.value = layoutKey;
                // Hiệu ứng highlight nhẹ
                el.style.outline = '2px solid #caa875';
                setTimeout(function() { el.style.outline = ''; }, 1500);
            }
        }
        otrCloseModal('modal-menu-demo');
    }

    // 1. Quản lý trạng thái đóng mở Hướng dẫn
    function otrToggleGuide() {
        var body = document.getElementById('otr-guide-body');
        var text = document.getElementById('otr-guide-toggle-text');
        var arrow = document.getElementById('otr-guide-arrow');
        if (!body) return;

        if (body.style.display === 'none') {
            body.style.display = 'block';
            if (text) text.textContent = 'Thu gọn';
            if (arrow) arrow.className = 'dashicons dashicons-arrow-up-alt2';
            try { localStorage.setItem('otr_guide_visible', '1'); } catch(e) {}
        } else {
            body.style.display = 'none';
            if (text) text.textContent = 'Xem hướng dẫn';
            if (arrow) arrow.className = 'dashicons dashicons-arrow-down-alt2';
            try { localStorage.setItem('otr_guide_visible', '0'); } catch(e) {}
        }
    }

    // Khôi phục trạng thái Hướng dẫn khi tải trang
    document.addEventListener('DOMContentLoaded', function() {
        try {
            if (localStorage.getItem('otr_guide_visible') === '0') {
                var body = document.getElementById('otr-guide-body');
                var text = document.getElementById('otr-guide-toggle-text');
                var arrow = document.getElementById('otr-guide-arrow');
                if (body) body.style.display = 'none';
                if (text) text.textContent = 'Xem hướng dẫn';
                if (arrow) arrow.className = 'dashicons dashicons-arrow-down-alt2';
            }
        } catch(e) {}
    });

    // 2. Quản lý Modal
    function otrOpenModal(modalId) {
        var el = document.getElementById(modalId);
        if (el) el.style.display = 'flex';
    }
    function otrCloseModal(modalId) {
        var el = document.getElementById(modalId);
        if (el) el.style.display = 'none';
    }

    function renderImagePreview(containerId, url) {
        var el = document.getElementById(containerId);
        if (!el) return;
        if (url) {
            el.innerHTML = '<div style="display:inline-block; position:relative;"><img src="' + url + '" style="max-height:80px; max-width:140px; border-radius:4px; border:1px solid #caa875; object-fit:cover; display:block;"></div>';
        } else {
            el.innerHTML = '<div style="font-size:12px; color:#888; font-style:italic;">Chưa chọn ảnh (sẽ hiển thị mặc định hoặc không có ảnh)</div>';
        }
    }

    // 3. Mở Modal Thêm/Sửa Menu Cha
    function otrOpenAddCha() {
        document.getElementById('modal-cha-title').textContent = 'Thêm Menu Cha Mới (Cấp 1)';
        document.getElementById('input_cha_id').value = '';
        document.getElementById('input_cha_title').value = '';
        document.getElementById('input_cha_num').value = '';
        document.getElementById('input_cha_desc').value = '';
        document.getElementById('input_cha_image').value = '';
        document.getElementById('input_cha_layout').value = 'layout_3';
        renderImagePreview('preview_cha_image', '');
        otrOpenModal('modal-add-cha');
    }

    function otrEditCha(id, title, num, desc, image, layout) {
        document.getElementById('modal-cha-title').textContent = 'Sửa Menu Cha: ' + title;
        document.getElementById('input_cha_id').value = id;
        document.getElementById('input_cha_title').value = title;
        document.getElementById('input_cha_num').value = num;
        document.getElementById('input_cha_desc').value = desc;
        document.getElementById('input_cha_image').value = image || '';
        document.getElementById('input_cha_layout').value = layout;
        renderImagePreview('preview_cha_image', image);
        otrOpenModal('modal-add-cha');
    }

    // 4. Mở Modal Thêm/Sửa Menu Con
    function otrOpenAddCon(chaId, chaTitle) {
        document.getElementById('modal-con-heading').textContent = 'Thêm Menu Con vào: ' + chaTitle;
        document.getElementById('input_con_parent_cha').value = chaId;
        document.getElementById('input_con_id').value = '';
        document.getElementById('input_con_title').value = '';
        document.getElementById('input_con_layout').value = 'layout_3';
        document.getElementById('input_con_desc').value = '';
        document.getElementById('input_con_tag').value = '';
        document.getElementById('input_con_price').value = '';
        document.getElementById('input_con_image').value = '';
        renderImagePreview('preview_con_image', '');
        otrOpenModal('modal-add-con');
    }

    function otrEditCon(chaId, conId, title, layout, desc, tag, price, image) {
        document.getElementById('modal-con-heading').textContent = 'Sửa Menu Con: ' + title;
        document.getElementById('input_con_parent_cha').value = chaId;
        document.getElementById('input_con_id').value = conId;
        document.getElementById('input_con_title').value = title;
        document.getElementById('input_con_layout').value = layout;
        document.getElementById('input_con_desc').value = desc;
        document.getElementById('input_con_tag').value = tag;
        document.getElementById('input_con_price').value = price;
        document.getElementById('input_con_image').value = image || '';
        renderImagePreview('preview_con_image', image);
        otrOpenModal('modal-add-con');
    }

    // 5. Mở Modal Thêm/Sửa Menu Con Con (Nhóm Cột)
    function otrOpenAddConCon(chaId, conId, conTitle) {
        document.getElementById('modal-concon-heading').textContent = 'Thêm Nhóm Cột vào: ' + conTitle;
        document.getElementById('input_concon_parent_cha').value = chaId;
        document.getElementById('input_concon_parent_con').value = conId;
        document.getElementById('input_concon_id').value = '';
        document.getElementById('input_concon_title').value = '';
        otrOpenModal('modal-add-concon');
    }

    // 6. Mở Modal Thêm/Sửa Món
    function otrOpenAddItem(chaId, conId, conconId, conconTitle) {
        document.getElementById('modal-item-heading').textContent = 'Thêm Món vào nhóm: ' + conconTitle;
        document.getElementById('input_item_parent_cha').value = chaId;
        document.getElementById('input_item_parent_con').value = conId;
        document.getElementById('input_item_parent_concon').value = conconId;
        document.getElementById('input_item_id').value = '';
        document.getElementById('input_item_name').value = '';
        document.getElementById('input_item_price').value = '199k';
        document.getElementById('input_item_desc').value = '';
        document.getElementById('input_item_image').value = '';
        renderImagePreview('preview_item_image', '');
        otrOpenModal('modal-add-item');
    }

    function otrEditItem(chaId, conId, conconId, itemId, name, price, desc, image) {
        document.getElementById('modal-item-heading').textContent = 'Sửa Món: ' + name;
        document.getElementById('input_item_parent_cha').value = chaId;
        document.getElementById('input_item_parent_con').value = conId;
        document.getElementById('input_item_parent_concon').value = conconId;
        document.getElementById('input_item_id').value = itemId;
        document.getElementById('input_item_name').value = name;
        document.getElementById('input_item_price').value = price;
        document.getElementById('input_item_desc').value = desc;
        document.getElementById('input_item_image').value = image || '';
        renderImagePreview('preview_item_image', image);
        otrOpenModal('modal-add-item');
    }

    // 7. Tích hợp WordPress Media Library Uploader (wp.media)
    jQuery(document).ready(function($) {
        $(document).on('click', '.otr-upload-media-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInputId = btn.data('target-input');
            var targetPreviewId = btn.data('target-preview');

            var customUploader = wp.media({
                title: 'Chọn ảnh cho Thực Đơn On The Rock',
                button: {
                    text: 'Sử dụng ảnh này'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                var imgUrl = attachment.url;
                $('#' + targetInputId).val(imgUrl);
                renderImagePreview(targetPreviewId, imgUrl);
            });

            customUploader.open();
        });

        $(document).on('click', '.otr-remove-media-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInputId = btn.data('target-input');
            var targetPreviewId = btn.data('target-preview');
            $('#' + targetInputId).val('');
            renderImagePreview(targetPreviewId, '');
        });
    });
    </script>
    <?php
}
