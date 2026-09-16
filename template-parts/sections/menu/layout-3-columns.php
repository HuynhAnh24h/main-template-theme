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
    $con_title = function_exists('otr_t_menu') ? otr_t_menu($single_con, 'title') : ($single_con['title'] ?? 'CLASSIC COCKTAIL');
    $columns = array();

    if (!empty($single_con['sub_children']) && is_array($single_con['sub_children'])) {
        foreach ($single_con['sub_children'] as $concon) {
            $columns[] = array(
                'spirit' => function_exists('otr_t_menu') ? otr_t_menu($concon, 'title') : ($concon['title'] ?? 'SPIRIT'),
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
                <?php echo esc_html(function_exists('otr_t') ? otr_t('Chưa có danh sách cột rượu cho mục này.', 'No spirit columns available for this section.') : 'Chưa có danh sách cột rượu cho mục này.'); ?>
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
                                <div class="py-3 text-xs text-[#caa875]/50 italic"><?php echo esc_html(function_exists('otr_t') ? otr_t('Đang cập nhật đồ uống...', 'Updating drinks...') : 'Đang cập nhật đồ uống...'); ?></div>
                            <?php else: ?>
                                <?php foreach ( $col['drinks'] as $drink ) : 
                                    $drink_name = function_exists('otr_t_menu') ? otr_t_menu($drink, 'name') : $drink['name'];
                                    $drink_desc = function_exists('otr_t_menu') ? otr_t_menu($drink, 'desc') : ($drink['desc'] ?? '');
                                    $drink_img = function_exists('otr_get_drink_modal_image') ? otr_get_drink_modal_image($drink, $single_con['image'] ?? ($parent_cha['image'] ?? '')) : ($drink['image'] ?? '');
                                ?>
                                    <div class="menu-item-clickable group cursor-pointer flex items-center justify-between py-3 sm:py-3.5 hover:bg-[#caa875]/10 px-2 sm:px-3 rounded-lg border-b border-[#caa875]/10 hover:border-[#caa875]/30 transition-all duration-300"
                                         data-name="<?php echo esc_attr( $drink_name ); ?>"
                                         data-price="<?php echo esc_attr( $drink['price'] ); ?>"
                                         data-desc="<?php echo esc_attr( $drink_desc ); ?>"
                                         data-image="<?php echo esc_url( $drink_img ); ?>"
                                         data-category="<?php echo esc_attr( $col['spirit'] ?? $con_title ); ?>">
                                         <div class="pr-2 flex items-center gap-2">
                                             <span class="text-[#d8c19d] text-sm sm:text-[15px] font-normal tracking-wide group-hover:text-white transition-colors">
                                                 <?php echo esc_html( $drink_name ); ?>
                                             </span>
                                             <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 text-[#caa875] text-xs transform -translate-x-1 group-hover:translate-x-0">✦</span>
                                         </div>
                                        <div class="flex items-center gap-2 shrink-0 ml-4">
                                            <span class="text-[#caa875] text-xs sm:text-sm tracking-wider font-medium font-serif">
                                                <?php echo esc_html( $drink['price'] ); ?>
                                            </span>
                                            <svg class="w-3.5 h-3.5 text-[#caa875]/40 group-hover:text-[#caa875] group-hover:translate-x-0.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </div>
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
    <?php foreach ( $tree as $cha_id => $cat ) : 
        $cat_title = function_exists('otr_t_menu') ? otr_t_menu($cat, 'title') : $cat['title'];
    ?>
        <div class="menu-cat-block scroll-mt-28 md:scroll-mt-32" id="menu-cat-<?php echo esc_attr( $cha_id ); ?>">
            
            <div class="mb-8 md:mb-10">
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1">
                    <?php echo esc_html( $cat['num'] ); ?>
                </span>
                <h2 class="font-serif font-light text-[#caa875] text-4xl sm:text-5xl md:text-6xl uppercase tracking-[0.03em]">
                    <?php echo esc_html( $cat_title ); ?>
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
                            $sub_title = function_exists('otr_t_menu') ? otr_t_menu($sub, 'title') : $sub['title'];
                        ?>
                            <button type="button" 
                                    class="menu-layout3-tab-btn px-5 sm:px-6 py-3.5 text-xs sm:text-[13px] tracking-[0.14em] uppercase text-left transition-all duration-300 cursor-pointer <?php echo $isActiveTab ? 'bg-[#c8a773] text-[#472B08] font-semibold border border-[#c8a773] shadow-lg' : 'bg-[#472B08]/80 text-[#caa875] border border-dashed border-[#caa875]/30 hover:border-[#caa875]'; ?>"
                                    data-target-group="<?php echo esc_attr( $cha_id ); ?>"
                                    data-target-subtab="<?php echo esc_attr( $sub_key ); ?>">
                                <?php echo esc_html( $sub_title ); ?>
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
