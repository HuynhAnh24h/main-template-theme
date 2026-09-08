<?php
/**
 * Menu Layout 2: Sidebar cố định cuộn trang (Sticky Sidebar Scroll)
 * Description: Thanh sidebar bên trái ghim cố định (sticky) khi cuộn chuột, tự động bám theo và dừng lại khi hết menu.
 * Hỗ trợ nạp dữ liệu động từ Menu TheRocks (Level 2: Menu Con).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$single_con = $args['con'] ?? null;
$parent_cha = $args['cha'] ?? null;

// ================= CHẾ ĐỘ 1: RENDER CHO 1 MENU CON ================= //
if ( ! empty( $single_con ) ) {
    $con_title = $single_con['title'] ?? 'GOURMET';
    $sub_categories = array();

    if (!empty($single_con['sub_children']) && is_array($single_con['sub_children'])) {
        $sub_num = 1;
        foreach ($single_con['sub_children'] as $concon_id => $concon) {
            $sub_categories[$concon_id] = array(
                'num'   => sprintf('%02d', $sub_num++),
                'name'  => $concon['title'] ?? 'Món',
                'desc'  => '',
                'items' => !empty($concon['items']) && is_array($concon['items']) ? $concon['items'] : array(),
                'image' => !empty($single_con['image']) ? $single_con['image'] : ($parent_cha['image'] ?? ''),
            );
        }
    }
    ?>
    <div class="menu-layout-2-wrapper grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 relative">
        
        <!-- 1. CỘT TRÁI: CỘT CHỨA SIDEBAR CỐ ĐỊNH KHI SCROLL (Sticky Sidebar) -->
        <div class="lg:col-span-4 relative">
            <aside class="menu-sticky-sidebar z-20 select-none bg-[#140e08]/95 p-6 sm:p-8 border border-[#caa875]/25 shadow-2xl backdrop-blur-md rounded-sm sticky top-[100px] lg:top-[115px] max-h-[calc(100vh-140px)] overflow-y-auto"
                   style="position: -webkit-sticky; position: sticky; top: 115px;">
                <h3 class="text-xs tracking-[0.25em] text-[#caa875]/60 uppercase font-medium mb-6 pb-3 border-b border-[#caa875]/20">
                    MỤC LỤC THỰC ĐƠN
                </h3>
                
                <nav class="flex flex-col gap-3 font-serif">
                    <?php 
                    $s_idx = 0;
                    foreach ( $sub_categories as $key => $cat ) : 
                        $isActive = ($s_idx === 0);
                    ?>
                        <a href="#subcat-<?php echo esc_attr( $key ); ?>" 
                           class="sidebar-nav-item flex items-baseline gap-3 py-2.5 px-3 rounded transition-all duration-300 group <?php echo $isActive ? 'bg-[#caa875]/20 text-white font-semibold' : 'text-[#caa875]/75 hover:text-white hover:bg-[#caa875]/10'; ?>"
                           data-nav-target="subcat-<?php echo esc_attr( $key ); ?>">
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
                    ✦ Cuộn trang để khám phá toàn bộ món. Thanh sidebar sẽ ghim cố định và đồng hành cùng trải nghiệm.
                </div>
            </aside>
        </div>

        <!-- 2. CỘT PHẢI: NỘI DUNG CHI TIẾT CÁC PHÂN MỤC -->
        <div class="lg:col-span-8 space-y-14">
            <?php foreach ( $sub_categories as $key => $cat ) : ?>
                <section id="subcat-<?php echo esc_attr( $key ); ?>" class="sidebar-content-section scroll-mt-28 md:scroll-mt-36 pb-8 border-b border-dashed border-[#caa875]/25 last:border-b-0">
                    
                    <div class="mb-6">
                        <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1">
                            <?php echo esc_html( $cat['num'] ); ?>
                        </span>
                        <h3 class="font-serif font-light text-[#caa875] text-3xl sm:text-4xl uppercase tracking-[0.03em] mb-2">
                            <?php echo esc_html( $cat['name'] ); ?>
                        </h3>
                    </div>

                    <?php if (empty($cat['items'])): ?>
                        <p class="text-xs text-[#caa875]/50 italic">Chưa có món trong nhóm này.</p>
                    <?php else: ?>
                        <div class="grid grid-cols-1 gap-4">
                            <?php foreach ( $cat['items'] as $drink ) : 
                                $drink_img = function_exists('otr_get_drink_modal_image') ? otr_get_drink_modal_image($drink, $cat['image'] ?? '') : ($drink['image'] ?? '');
                            ?>
                                <div class="menu-item-clickable group cursor-pointer flex items-center justify-between py-3.5 px-3 rounded-xl hover:bg-[#caa875]/10 border-b border-[#caa875]/10 hover:border-[#caa875]/30 transition-all duration-300"
                                     data-name="<?php echo esc_attr( $drink['name'] ); ?>"
                                     data-price="<?php echo esc_attr( $drink['price'] ); ?>"
                                     data-desc="<?php echo esc_attr( $drink['desc'] ?? '' ); ?>"
                                     data-image="<?php echo esc_url( $drink_img ); ?>"
                                     data-category="<?php echo esc_attr( $cat['name'] ?? $con_title ); ?>">
                                    <div class="pr-3 flex items-center gap-2">
                                        <h4 class="font-serif text-[#d8c19d] text-base font-normal tracking-wide group-hover:text-white transition-colors">
                                            <?php echo esc_html( $drink['name'] ); ?>
                                        </h4>
                                        <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 text-[#caa875] text-xs transform -translate-x-1 group-hover:translate-x-0">✦</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 shrink-0 ml-4">
                                        <span class="font-serif text-[#caa875] text-sm sm:text-base font-medium">
                                            <?php echo esc_html( $drink['price'] ); ?>
                                        </span>
                                        <div class="w-6 h-6 rounded-full bg-white/0 group-hover:bg-[#caa875]/15 border border-transparent group-hover:border-[#caa875]/30 flex items-center justify-center transition-all duration-300">
                                            <svg class="w-3.5 h-3.5 text-[#caa875]/40 group-hover:text-[#caa875] group-hover:translate-x-0.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </section>
            <?php endforeach; ?>
        </div>

    </div>
    <?php
    return;
}

// ================= CHẾ ĐỘ 2: FULL TREE (KHI GỌI RIÊNG LẺ) ================= //
$tree = function_exists('otr_get_therocks_menu_tree') ? otr_get_therocks_menu_tree() : array();
?>

<div class="menu-layout-2-wrapper grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 relative">
    <div class="lg:col-span-4 relative">
        <aside class="menu-sticky-sidebar z-20 select-none bg-[#140e08]/95 p-6 sm:p-8 border border-[#caa875]/25 shadow-2xl backdrop-blur-md rounded-sm sticky top-[100px] lg:top-[115px] max-h-[calc(100vh-140px)] overflow-y-auto"
               style="position: -webkit-sticky; position: sticky; top: 115px;">
            <h3 class="text-xs tracking-[0.25em] text-[#caa875]/60 uppercase font-medium mb-6 pb-3 border-b border-[#caa875]/20">
                MỤC LỤC THỰC ĐƠN
            </h3>
            <nav class="flex flex-col gap-3 font-serif">
                <?php $s_i = 0; foreach ($tree as $cha_id => $cha) : ?>
                    <a href="#section-<?php echo esc_attr($cha_id); ?>" 
                       class="sidebar-nav-item flex items-baseline gap-3 py-2 px-3 rounded transition-all duration-300 <?php echo ($s_i === 0) ? 'bg-[#caa875]/20 text-white font-semibold' : 'text-[#caa875]/75 hover:text-white hover:bg-[#caa875]/10'; ?>"
                       data-nav-target="section-<?php echo esc_attr($cha_id); ?>">
                        <span class="text-xs text-[#caa875]/60 font-mono"><?php echo esc_html($cha['num']); ?></span>
                        <span class="text-sm tracking-wide uppercase"><?php echo esc_html($cha['title']); ?></span>
                    </a>
                <?php $s_i++; endforeach; ?>
            </nav>
        </aside>
    </div>

    <div class="lg:col-span-8 space-y-16">
        <?php foreach ($tree as $cha_id => $cha) : ?>
            <section id="section-<?php echo esc_attr($cha_id); ?>" class="sidebar-content-section scroll-mt-28 md:scroll-mt-36 pb-8 border-b border-dashed border-[#caa875]/25 last:border-b-0">
                <span class="block text-[#caa875]/60 text-xs sm:text-sm tracking-[0.2em] font-normal mb-1.5"><?php echo esc_html($cha['num']); ?></span>
                <h2 class="font-serif font-light text-[#caa875] text-3xl sm:text-4xl md:text-5xl uppercase tracking-[0.03em] mb-3"><?php echo esc_html($cha['title']); ?></h2>
                <?php if (!empty($cha['desc'])): ?>
                    <p class="text-[#caa875]/70 text-xs sm:text-sm leading-relaxed max-w-xl mb-8"><?php echo esc_html($cha['desc']); ?></p>
                <?php endif; ?>

                <?php if (!empty($cha['children'])): ?>
                    <?php foreach ($cha['children'] as $con): ?>
                        <div class="mb-8">
                            <h3 class="text-[#caa875] text-lg uppercase tracking-wider mb-4 border-b border-[#caa875]/20 pb-2"><?php echo esc_html($con['title']); ?></h3>
                            <?php if (!empty($con['sub_children'])): ?>
                                <?php foreach ($con['sub_children'] as $concon): ?>
                                    <div class="mb-4">
                                        <h4 class="text-xs uppercase text-[#caa875]/60 mb-2"><?php echo esc_html($concon['title']); ?></h4>
                                        <?php if (!empty($concon['items'])): ?>
                                            <div class="grid grid-cols-1 gap-3">
                                                 <?php foreach ($concon['items'] as $it): 
                                                     $it_img = function_exists('otr_get_drink_modal_image') ? otr_get_drink_modal_image($it, $con['image'] ?? ($cha['image'] ?? '')) : ($it['image'] ?? '');
                                                 ?>
                                                      <div class="menu-item-clickable group cursor-pointer flex items-center justify-between py-2.5 px-2.5 rounded-lg hover:bg-[#caa875]/10 border-b border-[#caa875]/10 hover:border-[#caa875]/30 transition-all duration-300"
                                                           data-name="<?php echo esc_attr($it['name']); ?>"
                                                           data-price="<?php echo esc_attr($it['price']); ?>"
                                                           data-desc="<?php echo esc_attr($it['desc'] ?? ''); ?>"
                                                           data-image="<?php echo esc_url($it_img); ?>"
                                                           data-category="<?php echo esc_attr($concon['title'] ?? $con['title']); ?>">
                                                          <div class="pr-2 flex items-center gap-2">
                                                              <div class="text-[#d8c19d] text-sm group-hover:text-white transition-colors"><?php echo esc_html($it['name']); ?></div>
                                                              <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 text-[#caa875] text-xs">✦</span>
                                                          </div>
                                                         <div class="flex items-center gap-2 shrink-0 ml-4">
                                                             <span class="text-[#caa875] font-serif text-sm"><?php echo esc_html($it['price']); ?></span>
                                                             <svg class="w-3.5 h-3.5 text-[#caa875]/40 group-hover:text-[#caa875] group-hover:translate-x-0.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                             </svg>
                                                         </div>
                                                     </div>
                                                 <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>
