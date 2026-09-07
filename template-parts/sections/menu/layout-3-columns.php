<?php
/**
 * Menu Layout 3: Danh sách cột theo nhóm rượu (Classic Spirit Columns)
 * Description: Khớp 100% theo hình ảnh người dùng tải lên (media_1788577150765.png).
 * Hỗ trợ nạp dữ liệu động từ Menu TheRocks (Level 2: Menu Con -> Level 3: Cột -> Món).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$single_con = $args['con'] ?? null;
$parent_cha = $args['cha'] ?? null;

// ================= CHẾ ĐỘ 1: RENDER TRỰC TIẾP CHO 1 MENU CON ================= //
if ( ! empty( $single_con ) ) {
    $con_title = $single_con['title'] ?? 'CLASSIC COCKTAIL';
    $columns = array();

    if (!empty($single_con['sub_children']) && is_array($single_con['sub_children'])) {
        foreach ($single_con['sub_children'] as $concon) {
            $columns[] = array(
                'spirit' => $concon['title'] ?? 'SPIRIT',
                'drinks' => !empty($concon['items']) && is_array($concon['items']) ? $concon['items'] : array(),
            );
        }
    }
    ?>
    <div class="layout3-content-wrapper">
        <!-- Tiêu đề phụ căn giữa -->
        <div class="text-center mb-8">
            <h3 class="text-[#caa875] text-xs sm:text-sm tracking-[0.25em] uppercase font-medium">
                ✦ <?php echo esc_html( $con_title ); ?> ✦
            </h3>
            <div class="w-full border-t border-[#caa875]/20 mt-4 mb-8"></div>
        </div>

        <?php if (empty($columns)): ?>
            <div class="text-center text-[#caa875]/60 text-sm py-8 italic">
                Chưa có danh sách cột rượu cho mục này.
            </div>
        <?php else: ?>
            <!-- Lưới 2 cột (hoặc responsive theo số cột) theo từng loại rượu (WHISKY, GIN, RUM...) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-14 lg:gap-16">
                <?php foreach ( $columns as $col ) : ?>
                    <div>
                        <!-- Tên loại rượu (WHISKY, GIN,...) -->
                        <h4 class="font-serif font-light text-[#caa875] text-2xl sm:text-3xl uppercase tracking-[0.05em] mb-6">
                            <?php echo esc_html( $col['spirit'] ); ?>
                        </h4>

                        <!-- Danh sách món & Giá -->
                        <div class="divide-y divide-[#caa875]/10 border-t border-b border-[#caa875]/10">
                            <?php if (empty($col['drinks'])): ?>
                                <div class="py-3 text-xs text-[#caa875]/50 italic">Đang cập nhật đồ uống...</div>
                            <?php else: ?>
                                <?php foreach ( $col['drinks'] as $drink ) : ?>
                                    <div class="flex items-center justify-between py-3 sm:py-3.5 group hover:bg-[#caa875]/5 px-1 sm:px-2 rounded transition-colors duration-200">
                                        <div>
                                            <span class="text-[#d8c19d] text-sm sm:text-[15px] font-normal tracking-wide group-hover:text-white transition-colors">
                                                <?php echo esc_html( $drink['name'] ); ?>
                                            </span>
                                            <?php if (!empty($drink['desc'])): ?>
                                                <div class="text-[#caa875]/55 text-xs mt-0.5"><?php echo esc_html($drink['desc']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-[#caa875] text-xs sm:text-sm tracking-wider font-medium font-serif shrink-0 ml-4">
                                            <?php echo esc_html( $drink['price'] ); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return;
}

// ================= CHẾ ĐỘ 2: FULL TREE (KHI GỌI RIÊNG LẺ) ================= //
$tree = function_exists('otr_get_therocks_menu_tree') ? otr_get_therocks_menu_tree() : array();
?>

<div class="menu-layout-3-wrapper space-y-16 md:space-y-24">
    <?php foreach ( $tree as $cha_id => $cat ) : ?>
        <div class="menu-cat-block scroll-mt-28 md:scroll-mt-32" id="menu-cat-<?php echo esc_attr( $cha_id ); ?>">
            
            <div class="mb-8 md:mb-10">
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1">
                    <?php echo esc_html( $cat['num'] ); ?>
                </span>
                <h2 class="font-serif font-light text-[#caa875] text-4xl sm:text-5xl md:text-6xl uppercase tracking-[0.03em]">
                    <?php echo esc_html( $cat['title'] ); ?>
                </h2>
            </div>

            <?php if (!empty($cat['children'])): ?>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                    
                    <!-- Nhóm Tab Subcategory (Bên trái) -->
                    <div class="lg:col-span-3 flex flex-col gap-2.5 sm:gap-3 select-none">
                        <?php 
                        $t_idx = 0;
                        foreach ( $cat['children'] as $sub_key => $sub ) : 
                            $isActiveTab = ($t_idx === 0);
                        ?>
                            <button type="button" 
                                    class="menu-layout3-tab-btn px-5 sm:px-6 py-3.5 text-xs sm:text-[13px] tracking-[0.14em] uppercase text-left transition-all duration-300 cursor-pointer <?php echo $isActiveTab ? 'bg-[#c8a773] text-[#1a120b] font-semibold border border-[#c8a773] shadow-lg' : 'bg-[#211508]/80 text-[#caa875] border border-dashed border-[#caa875]/30 hover:border-[#caa875]'; ?>"
                                    data-target-group="<?php echo esc_attr( $cha_id ); ?>"
                                    data-target-subtab="<?php echo esc_attr( $sub_key ); ?>">
                                <?php echo esc_html( $sub['title'] ); ?>
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
                        foreach ( $cat['children'] as $sub_key => $sub ) : 
                            $isVisible = ($v_idx === 0);
                        ?>
                            <div class="layout3-subtab-view <?php echo $isVisible ? '' : 'hidden'; ?>" 
                                 data-group="<?php echo esc_attr( $cha_id ); ?>"
                                 data-subtab-view="<?php echo esc_attr( $sub_key ); ?>">
                                <?php get_template_part('template-parts/sections/menu/layout-3-columns', null, array('con' => $sub, 'cha' => $cat)); ?>
                            </div>
                        <?php 
                            $v_idx++;
                        endforeach; 
                        ?>
                    </div>

                </div>
            <?php endif; ?>

            <div class="w-full border-t border-dashed border-[#caa875]/20 mt-14 md:mt-20"></div>
        </div>
    <?php endforeach; ?>
</div>
