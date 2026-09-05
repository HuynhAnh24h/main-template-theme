<?php
/**
 * Custom Post Type: Menu Items & Taxonomy for On The Rock Bar
 * Description: Quản trị danh mục thực đơn và danh sách món động, không giới hạn số lượng món,
 * cho phép người dùng tự do thêm/sửa/xóa phân mục và từng món trực tiếp trong WordPress Admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Đăng ký Custom Post Type 'otr_menu_item' và Taxonomy 'otr_menu_cat'
 */
function otr_register_menu_cpt() {
    
    // Đăng ký Phân loại Danh Mục Menu (Taxonomy)
    $cat_labels = array(
        'name'              => 'Danh Mục Menu',
        'singular_name'     => 'Danh Mục Menu',
        'search_items'      => 'Tìm danh mục',
        'all_items'         => 'Tất cả danh mục',
        'parent_item'       => 'Danh mục cha',
        'parent_item_colon' => 'Danh mục cha:',
        'edit_item'         => 'Sửa danh mục',
        'update_item'       => 'Cập nhật danh mục',
        'add_new_item'      => 'Thêm danh mục mới',
        'new_item_name'     => 'Tên danh mục mới',
        'menu_name'         => 'Danh Mục Menu',
    );

    register_taxonomy('otr_menu_cat', array('otr_menu_item'), array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'menu-category'),
    ));

    // Đăng ký Custom Post Type Món Thực Đơn
    $item_labels = array(
        'name'               => 'Thực Đơn Bar',
        'singular_name'      => 'Món Thực Đơn',
        'menu_name'          => 'Thực Đơn (Menu Bar)',
        'all_items'          => 'Tất cả món thực đơn',
        'add_new'            => 'Thêm món mới',
        'add_new_item'       => 'Thêm món thực đơn mới',
        'edit_item'          => 'Sửa món thực đơn',
        'new_item'           => 'Món mới',
        'view_item'          => 'Xem món',
        'search_items'       => 'Tìm món thực đơn',
        'not_found'          => 'Không tìm thấy món nào',
        'not_found_in_trash' => 'Không có món nào trong thùng rác',
    );

    register_post_type('otr_menu_item', array(
        'labels'             => $item_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'bar-menu'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-beer',
        'supports'           => array('title', 'thumbnail', 'page-attributes', 'editor'),
        'show_in_rest'       => true,
    ));
}
add_action('init', 'otr_register_menu_cpt');

/**
 * 2. Tùy biến cột hiển thị trong danh sách Món Thực Đơn (Admin Columns)
 */
function otr_menu_item_columns($columns) {
    $new_columns = array(
        'cb'          => $columns['cb'],
        'thumb'       => 'Ảnh',
        'title'       => 'Tên Món',
        'price'       => 'Giá Tiền',
        'spirit'      => 'Nền Rượu / Cột',
        'subtab'      => 'Phân Nhóm Tab',
        'taxonomy-otr_menu_cat' => 'Danh Mục',
        'order'       => 'Thứ Tự',
        'date'        => 'Ngày Tạo',
    );
    return $new_columns;
}
add_filter('manage_otr_menu_item_posts_columns', 'otr_menu_item_columns');

function otr_menu_item_custom_column($column, $post_id) {
    switch ($column) {
        case 'thumb':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(45, 45), array('class' => 'rounded border border-gray-300'));
            } else {
                echo '<span class="text-gray-400">—</span>';
            }
            break;
        case 'price':
            $price = get_post_meta($post_id, 'item_price', true);
            echo $price ? '<strong>' . esc_html($price) . '</strong>' : '<span class="text-gray-400">—</span>';
            break;
        case 'spirit':
            $spirit = get_post_meta($post_id, 'item_spirit', true);
            echo $spirit ? esc_html($spirit) : '<span class="text-gray-400">—</span>';
            break;
        case 'subtab':
            $subtab = get_post_meta($post_id, 'item_subtab', true);
            echo $subtab ? esc_html($subtab) : '<span class="text-gray-400">—</span>';
            break;
        case 'order':
            $post = get_post($post_id);
            echo esc_html($post->menu_order);
            break;
    }
}
add_action('manage_otr_menu_item_posts_custom_column', 'otr_menu_item_custom_column', 10, 2);

/**
 * 3. Hàm truy vấn dữ liệu Thực đơn động (Dynamic Menu Query)
 * Tự động gom nhóm dữ liệu theo Danh Mục -> Nhóm Tab -> Nền Rượu / Cột để cung cấp cho cả 3 Layout.
 */
function otr_get_menu_data() {
    // 1. Lấy tất cả danh mục menu (taxonomy terms)
    $categories = get_terms(array(
        'taxonomy'   => 'otr_menu_cat',
        'hide_empty' => false,
        'orderby'    => 'meta_value_num',
        'meta_key'   => 'cat_number',
        'order'      => 'ASC',
    ));

    // Nếu không có sắp xếp theo cat_number, lấy theo ID hoặc name
    if (empty($categories) || is_wp_error($categories)) {
        $categories = get_terms(array(
            'taxonomy'   => 'otr_menu_cat',
            'hide_empty' => false,
        ));
    }

    $menu_data = array();

    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $cat) {
            $cat_number = get_term_meta($cat->term_id, 'cat_number', true) ?: sprintf('%02d', count($menu_data) + 1);
            $cat_img_id = get_term_meta($cat->term_id, 'cat_image', true);
            $cat_image  = '';
            if (is_array($cat_img_id) && !empty($cat_img_id['url'])) {
                $cat_image = $cat_img_id['url'];
            } elseif (is_numeric($cat_img_id)) {
                $cat_image = wp_get_attachment_image_url($cat_img_id, 'large');
            }

            // Lấy danh sách món thuộc danh mục này
            $query = new WP_Query(array(
                'post_type'      => 'otr_menu_item',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'otr_menu_cat',
                        'field'    => 'term_id',
                        'terms'    => $cat->term_id,
                    ),
                ),
                'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
            ));

            $items_list = array();
            $subtabs_map = array();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $p_id = get_the_ID();

                    $price   = get_post_meta($p_id, 'item_price', true) ?: '199k';
                    $spirit  = get_post_meta($p_id, 'item_spirit', true) ?: 'WHISKY';
                    $subtab  = get_post_meta($p_id, 'item_subtab', true) ?: $cat->name;
                    $desc    = get_post_meta($p_id, 'item_desc', true) ?: get_the_excerpt();
                    $alcohol = get_post_meta($p_id, 'item_alcohol', true) ?: 'Medium';
                    $flavors = get_post_meta($p_id, 'item_flavors', true) ?: '';
                    $image   = get_the_post_thumbnail_url($p_id, 'large');

                    $item_entry = array(
                        'id'      => $p_id,
                        'name'    => get_the_title(),
                        'price'   => $price,
                        'spirit'  => $spirit,
                        'subtab'  => $subtab,
                        'desc'    => $desc,
                        'alcohol' => $alcohol,
                        'flavors' => $flavors ? array_map('trim', explode(',', $flavors)) : array('Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter'),
                        'image'   => $image,
                    );

                    $items_list[] = $item_entry;

                    // Gom nhóm vào subtabs và cột rượu cho Kiểu 3 & Kiểu 1
                    $subtab_slug = sanitize_title($subtab);
                    if (!isset($subtabs_map[$subtab_slug])) {
                        $subtabs_map[$subtab_slug] = array(
                            'key'      => $subtab_slug,
                            'name'     => $subtab,
                            'tab_name' => $subtab,
                            'header'   => $subtab,
                            'tag'      => $subtab,
                            'price'    => $price,
                            'alcohol'  => $alcohol,
                            'flavors'  => array('Ngọt / Sweet', 'Chua / Sour', 'Đắng / Bitter', 'Mặn / Salty', 'Cay / Spicy', 'Thảo mộc / Herbal', 'Khói / Smoky', 'Béo / Creamy', 'Trái cây / Fruity'),
                            'spirits'  => array(),
                            'images'   => array(),
                            'columns'  => array(),
                        );
                    }

                    // Tích lũy danh sách spirits & images cho Kiểu 1
                    if (count($subtabs_map[$subtab_slug]['spirits']) < 6) {
                        $subtabs_map[$subtab_slug]['spirits'][$spirit . ':'] = get_the_title();
                    }
                    if (!empty($image) && !in_array($image, $subtabs_map[$subtab_slug]['images'], true)) {
                        $subtabs_map[$subtab_slug]['images'][] = $image;
                    }

                    $spirit_key = sanitize_title($spirit);
                    if (!isset($subtabs_map[$subtab_slug]['columns'][$spirit_key])) {
                        $subtabs_map[$subtab_slug]['columns'][$spirit_key] = array(
                            'spirit' => strtoupper($spirit),
                            'drinks' => array(),
                        );
                    }

                    $subtabs_map[$subtab_slug]['columns'][$spirit_key]['drinks'][] = array(
                        'name'  => get_the_title(),
                        'price' => $price,
                        'desc'  => $desc,
                    );
                }
                wp_reset_postdata();
            }

            // Chuẩn hóa columns và ảnh fallback
            $normalized_subtabs = array();
            foreach ($subtabs_map as $s_slug => $s_data) {
                $s_data['columns'] = array_values($s_data['columns']);
                if (empty($s_data['images'])) {
                    $s_data['images'] = array(
                        'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
                    );
                }
                $normalized_subtabs[] = $s_data;
            }

            $menu_data[$cat->slug] = array(
                'id'       => $cat_number,
                'term_id'  => $cat->term_id,
                'slug'     => $cat->slug,
                'num'      => $cat_number,
                'title'    => $cat->name,
                'name'     => $cat->name,
                'desc'     => $cat->description ?: 'Bộ sưu tập đồ uống tuyển chọn của On The Rock Bar.',
                'image'    => $cat_image ?: 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
                'items'    => $items_list,
                'subtabs'  => $normalized_subtabs,
            );
        }
    }

    return $menu_data;
}

/**
 * 4. Tự động khởi tạo dữ liệu mẫu ban đầu (Auto Seed) nếu website chưa có món nào
 * Giúp người dùng ngay khi vào Admin đã thấy sẵn các món theo hình ảnh và dễ dàng thêm mới.
 */
function otr_auto_seed_sample_menu() {
    // Chỉ chạy nếu trong cơ sở dữ liệu chưa có bài viết nào thuộc post_type 'otr_menu_item'
    $existing = get_posts(array(
        'post_type'      => 'otr_menu_item',
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ));

    if (!empty($existing)) {
        return; // Đã có dữ liệu, không tạo thêm
    }

    // Danh sách 4 Phân mục mẫu
    $sample_cats = array(
        '01-bespoke' => array(
            'name'   => 'BESPOKE COCKTAIL',
            'number' => '01',
            'desc'   => 'Những ly cocktail mang tính độc bản, phối trộn riêng theo cá tính và khẩu vị của từng vị khách.',
            'image'  => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1000&auto=format&fit=crop',
            'items'  => array(
                array('title' => 'Artisanal Smoked Old Fashioned', 'price' => '320k', 'spirit' => 'HERBAL & FLORAL', 'subtab' => 'SIGNATURE CRAFT', 'desc' => 'Peated Highland Malt, Toasted Cinnamon, Smoked Honey'),
                array('title' => 'Dalat Pine Needle Negroni',      'price' => '340k', 'spirit' => 'HERBAL & FLORAL', 'subtab' => 'SIGNATURE CRAFT', 'desc' => 'Artisanal Dalat Gin, Campari Infused Pine, Sweet Vermouth'),
                array('title' => 'Truffle Velvet Boulevardier',     'price' => '360k', 'spirit' => 'BARREL AGED & SMOKED', 'subtab' => 'CUSTOM PALATE', 'desc' => 'Bourbon Reserve, Black Truffle Bitter, Sweet Vermouth'),
                array('title' => 'Yuzu Blossom Sour',              'price' => '310k', 'spirit' => 'BARREL AGED & SMOKED', 'subtab' => 'CUSTOM PALATE', 'desc' => 'Japanese Gin, Yuzu Acid, Egg White Foam, Gold Flakes'),
            ),
        ),
        '02-classic' => array(
            'name'   => 'CLASSIC COCKTAIL',
            'number' => '02',
            'desc'   => 'Những huyền thoại bất hủ vượt thời gian, định hình nên văn hóa cocktail toàn cầu.',
            'image'  => 'https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=1000&auto=format&fit=crop',
            'items'  => array(
                // Cột WHISKY (Theo hình ảnh mới nhất)
                array('title' => 'Boulevardier',       'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Bourbon, Campari, Sweet Vermouth, Orange Twist'),
                array('title' => 'Godfather',          'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Scotch Whisky, Amaretto Liqueur, Giant Clear Ice'),
                array('title' => 'Highball',           'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Japanese Whisky, Premium Soda, Lemon Zest'),
                array('title' => 'Manhattan',          'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Rye Whiskey, Sweet Vermouth, Angostura Bitters'),
                array('title' => 'Morning Glory Fizz', 'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Scotch Whisky, Absinthe, Lemon, Egg White, Soda'),
                array('title' => 'New York Sour',      'price' => '199k', 'spirit' => 'WHISKY', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Bourbon, Lemon Juice, Sugar, Red Wine Float'),
                // Cột GIN (Theo hình ảnh mới nhất)
                array('title' => 'Clover Club',        'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Dry Gin, Raspberry Syrup, Lemon Juice, Egg White'),
                array('title' => 'Dry Martini',        'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'London Dry Gin, Dry Vermouth, Spanish Olive'),
                array('title' => 'Gimlet',             'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Botanical Gin, House Lime Cordial, Lime Wheel'),
                array('title' => 'Gin Fizz',           'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Dry Gin, Lemon Juice, Simple Syrup, Soda Water'),
                array('title' => 'Gin Tonic',          'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Artisanal Gin, Mediterranean Tonic, Rosemary'),
                array('title' => 'James Bond',         'price' => '199k', 'spirit' => 'GIN', 'subtab' => 'CLASSIC COCKTAIL', 'desc' => 'Gordon Gin, Vodka, Kina Lillet, Lemon Peel'),
                // Nhóm Tab: CLASSIC PREMIUM
                array('title' => 'Zacapa Old Fashioned', 'price' => '280k', 'spirit' => 'RUM & TEQUILA', 'subtab' => 'CLASSIC PREMIUM', 'desc' => 'Zacapa 23 Centenario, Bitters, Orange Peel'),
                array('title' => 'Smoked Paloma',        'price' => '260k', 'spirit' => 'RUM & TEQUILA', 'subtab' => 'CLASSIC PREMIUM', 'desc' => 'Mezcal, Grapefruit Soda, Smoked Salt'),
                array('title' => 'Macallan Rob Roy',     'price' => '350k', 'spirit' => 'SINGLE MALT & COGNAC', 'subtab' => 'CLASSIC PREMIUM', 'desc' => 'Macallan 12, Sweet Vermouth, Bitters'),
                array('title' => 'Sazerac XO',           'price' => '320k', 'spirit' => 'SINGLE MALT & COGNAC', 'subtab' => 'CLASSIC PREMIUM', 'desc' => 'Hennessy XO, Absinthe Mist, Peychaud'),
            ),
        ),
        '03-signature' => array(
            'name'   => 'SIGNATURE COCKTAIL',
            'number' => '03',
            'desc'   => 'Những sáng tạo độc quyền của On The Rock Bar, kể lại câu chuyện núi rừng và sương mù Đà Lạt.',
            'image'  => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
            'items'  => array(
                array('title' => 'Foggy Dalat Valley',    'price' => '299k', 'spirit' => 'REFRESHING & CITRUS', 'subtab' => 'HOUSE SIGNATURES', 'desc' => 'Wild Herb Dalat Gin, Elderflower, Dry Vermouth, Pine Mist'),
                array('title' => 'Sunset Over Truc Lam',  'price' => '299k', 'spirit' => 'REFRESHING & CITRUS', 'subtab' => 'HOUSE SIGNATURES', 'desc' => 'Campari, Passion Fruit, Wild Honey, Sparkling Wine'),
                array('title' => 'Langbiang Golden Hour', 'price' => '319k', 'spirit' => 'COMPLEX & RICH', 'subtab' => 'HOUSE SIGNATURES', 'desc' => 'Aged Dark Rum, Dalat Coffee Liqueur, Cocoa Bitter'),
                array('title' => 'Midnight In The Rocks', 'price' => '329k', 'spirit' => 'COMPLEX & RICH', 'subtab' => 'HOUSE SIGNATURES', 'desc' => 'Islay Peated Malt, Black Walnut Bitters, Smoked Rosemary'),
            ),
        ),
        '04-food' => array(
            'name'   => 'FOOD & BAR BITES',
            'number' => '04',
            'desc'   => 'Các món ăn nhẹ và món khai vị cao cấp hoàn hảo để nhâm nhi cùng cocktail.',
            'image'  => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1000&auto=format&fit=crop',
            'items'  => array(
                array('title' => 'Ibérico Cold Cut Platter', 'price' => '380k', 'spirit' => 'GOURMET BITES', 'subtab' => 'GOURMET BITES', 'desc' => 'Ibérico Ham 36 Months, Chorizo, Salami, Dalat Sourdough'),
                array('title' => 'Artisanal Cheese Board',   'price' => '320k', 'spirit' => 'GOURMET BITES', 'subtab' => 'GOURMET BITES', 'desc' => 'Truffle Brie, Aged Gouda, Blue Cheese, Fig Jam, Walnuts'),
                array('title' => 'Wagyu Beef Tartare Tart',  'price' => '280k', 'spirit' => 'GOURMET BITES', 'subtab' => 'GOURMET BITES', 'desc' => 'Wagyu A5, Quail Egg, Truffle Aioli, Crispy Brioche'),
                array('title' => 'Hokkaido Scallop Ceviche', 'price' => '260k', 'spirit' => 'GOURMET BITES', 'subtab' => 'GOURMET BITES', 'desc' => 'Fresh Scallop, Citrus Ponzu, Passion Fruit Pearls'),
            ),
        ),
    );

    foreach ($sample_cats as $slug => $c_data) {
        $term = term_exists($c_data['name'], 'otr_menu_cat');
        if (!$term) {
            $term = wp_insert_term($c_data['name'], 'otr_menu_cat', array(
                'slug'        => $slug,
                'description' => $c_data['desc'],
            ));
        }

        $term_id = is_array($term) ? $term['term_id'] : $term;
        if ($term_id) {
            update_term_meta($term_id, 'cat_number', $c_data['number']);

            $order = 1;
            foreach ($c_data['items'] as $item) {
                $post_id = wp_insert_post(array(
                    'post_title'   => $item['title'],
                    'post_content' => $item['desc'],
                    'post_status'  => 'publish',
                    'post_type'    => 'otr_menu_item',
                    'menu_order'   => $order++,
                ));

                if ($post_id && !is_wp_error($post_id)) {
                    wp_set_post_terms($post_id, array($term_id), 'otr_menu_cat');
                    update_post_meta($post_id, 'item_price', $item['price']);
                    update_post_meta($post_id, 'item_spirit', $item['spirit']);
                    update_post_meta($post_id, 'item_subtab', $item['subtab']);
                    update_post_meta($post_id, 'item_desc', $item['desc']);
                    update_post_meta($post_id, 'item_alcohol', 'Medium');
                }
            }
        }
    }
}
add_action('admin_init', 'otr_auto_seed_sample_menu');
