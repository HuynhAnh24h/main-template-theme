<?php
/**
 * Section: Hero Section
 * Bố cục: Main Banner (Trái) + Benefit Cards (Phải)
 */
?>
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Main Banner (Trái 2/3) -->
    <div class="lg:col-span-2 bg-gradient-to-r from-lc-blue via-blue-600 to-lc-darkblue rounded-3xl overflow-hidden shadow-md relative group h-80 md:h-96 flex items-center justify-start text-white p-8 md:p-12">
        <!-- Trang trí nền -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.1),transparent_50%)]"></div>
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition duration-1000"></div>

        <div class="relative z-10 max-w-lg">
            <span class="inline-flex items-center gap-1.5 bg-lc-orange text-white text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                <?php echo get_svg_icon('shield', 'w-3.5 h-3.5'); ?> Cam kết chính hãng 100%
            </span>
            <h1 class="text-3xl md:text-5xl font-black mt-4 mb-4 leading-tight">
                Chăm Sóc Sức Khỏe<br><span class="text-lc-orange">Cho Cả Gia Đình</span>
            </h1>
            <p class="text-sm md:text-base text-blue-100 mb-6 leading-relaxed">
                Hệ thống nhà thuốc đạt chuẩn GPP. Hỗ trợ giao hàng nhanh trong 1 giờ. Tư vấn dược sĩ 24/7.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="bg-lc-orange hover:bg-orange-600 text-white font-extrabold px-6 py-3 rounded-2xl transition duration-200 shadow-lg shadow-orange-500/20 transform hover:-translate-y-0.5">
                    Mua hàng ngay
                </a>
                <a href="#about-us" class="bg-white/15 hover:bg-white/25 text-white font-bold px-6 py-3 rounded-2xl transition duration-200 backdrop-blur-sm">
                    Tìm hiểu thêm
                </a>
            </div>
        </div>
    </div>

    <!-- Side Benefits (Phải 1/3) -->
    <div class="flex flex-col justify-between gap-4">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-lc-blue flex items-center justify-center shrink-0 group-hover:bg-lc-blue group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('phone', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Thuốc Theo Đơn</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Chụp ảnh đơn thuốc gửi qua Zalo, nhận tư vấn và báo giá trong 5 phút.</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-orange-50 text-lc-orange flex items-center justify-center shrink-0 group-hover:bg-lc-orange group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('truck', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Freeship Siêu Tốc</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Miễn phí vận chuyển cho các đơn hàng từ 150k trong phạm vi 5km.</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-50 flex items-center gap-5 group">
            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shrink-0 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                <?php echo get_svg_icon('shield', 'w-6 h-6'); ?>
            </div>
            <div>
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Đổi Trả Dễ Dàng</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Đổi trả thuốc trong vòng 30 ngày nếu còn nguyên bao bì nhãn mác.</p>
            </div>
        </div>
    </div>
</section>