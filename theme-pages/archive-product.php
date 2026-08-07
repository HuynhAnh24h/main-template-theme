<?php
/**
 * Template Name: Product Archive / Shop
 * Description: Mẫu trang danh sách sản phẩm (Shop / Product Catalog).
 */

get_header();

// Nhúng Breadcrumb
get_template_part('template-parts/components/breadcrumb', null, [
    'title' => 'Cửa hàng sản phẩm'
]);
?>

<div class="bg-lc-bg min-h-screen pb-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar bộ lọc (Filters Sidebar) -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 space-y-6">
                    <h3 class="font-extrabold text-gray-800 text-base pb-3 border-b border-gray-100 flex items-center gap-1.5">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 text-lc-blue"></i> Bộ lọc tìm kiếm
                    </h3>
                    
                    <!-- Lọc theo danh mục -->
                    <div>
                        <h4 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Danh mục thuốc</h4>
                        <ul class="space-y-2.5 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-lc-blue font-semibold flex items-center justify-between">Dược phẩm <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded-full font-bold text-gray-400">12</span></a></li>
                            <li><a href="#" class="hover:text-lc-blue flex items-center justify-between">Thực phẩm chức năng <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded-full text-gray-400">8</span></a></li>
                            <li><a href="#" class="hover:text-lc-blue flex items-center justify-between">Dược mỹ phẩm <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded-full text-gray-400">15</span></a></li>
                            <li><a href="#" class="hover:text-lc-blue flex items-center justify-between">Thiết bị y tế <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded-full text-gray-400">4</span></a></li>
                        </ul>
                    </div>

                    <!-- Lọc theo giá -->
                    <div>
                        <h4 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Lọc theo giá</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded border-gray-300 text-lc-blue focus:ring-lc-blue">
                                Dưới 100.000đ
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded border-gray-300 text-lc-blue focus:ring-lc-blue">
                                100.000đ - 300.000đ
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="rounded border-gray-300 text-lc-blue focus:ring-lc-blue">
                                Trên 300.000đ
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Danh sách sản phẩm (Shop Content) -->
            <main class="lg:col-span-3">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-50">
                    
                    <!-- Sắp xếp & Thay đổi layout -->
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100">
                        <div class="text-xs text-gray-400 font-bold">
                            <?php if (have_posts()) : ?>
                                Hiển thị danh sách sản phẩm cửa hàng
                            <?php else : ?>
                                Hiển thị sản phẩm mẫu (Fallback)
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <!-- Dropdown sắp xếp -->
                            <select id="category-sort-select" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-lc-blue text-gray-600 font-semibold">
                                <option value="menu_order">Thứ tự mặc định</option>
                                <option value="popularity">Mức độ phổ biến</option>
                                <option value="rating">Điểm đánh giá</option>
                                <option value="date">Mới nhất</option>
                                <option value="price">Giá tăng dần</option>
                                <option value="price-desc">Giá giảm dần</option>
                            </select>

                            <!-- Nút Grid / List -->
                            <div class="flex items-center gap-1 border-l border-gray-100 pl-3">
                                <button id="view-grid-btn" class="p-1 hover:text-lc-blue text-lc-blue transition" title="Xem dạng lưới">
                                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                                </button>
                                <button id="view-list-btn" class="p-1 hover:text-lc-blue text-gray-300 transition" title="Xem dạng danh sách">
                                    <i data-lucide="list" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lưới sản phẩm -->
                    <div id="shop-product-grid" class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('template-parts/components/product-card', null, [
                                    'product_id' => get_the_ID()
                                ]);
                            endwhile;
                        else :
                            // Dummy Products nếu chưa có sản phẩm WooCommerce thực tế
                            for ($i = 1; $i <= 6; $i++) :
                                get_template_part('template-parts/components/product-card', null, [
                                    'product_id' => $i
                                ]);
                            endfor;
                        endif;
                        ?>
                    </div>

                    <!-- Phân trang (Pagination) -->
                    <div class="mt-12 flex justify-center gap-2">
                        <?php
                        echo paginate_links([
                            'type'      => 'list',
                            'class'     => 'pagination-list',
                            'prev_text' => '&larr;',
                            'next_text' => '&rarr;'
                        ]);
                        ?>
                        <!-- Fallback pagination styling if list empty -->
                        <?php if(!have_posts()): ?>
                            <nav class="flex items-center gap-1.5 text-xs font-bold text-gray-500">
                                <span class="w-9 h-9 rounded-xl bg-lc-blue text-white flex items-center justify-center">1</span>
                                <a href="#" class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center">2</a>
                                <a href="#" class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center">3</a>
                                <a href="#" class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center">&rarr;</a>
                            </nav>
                        <?php endif; ?>
                    </div>

                </div>
            </main>

        </div>
    </div>
</div>

<?php
get_footer();
