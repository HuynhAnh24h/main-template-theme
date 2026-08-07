<?php
/**
 * Section: About Us
 * Bố cục: Story section + Statistics Counters (được kích hoạt bởi about.js)
 */
?>
<section id="about-us" class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-50 mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Story -->
        <div>
            <span class="text-xs uppercase font-extrabold text-lc-blue tracking-wider block mb-2">Về chúng tôi</span>
            <h2 class="text-2xl md:text-4xl font-black text-gray-800 mb-6 leading-tight">
                Chặng Đường Mang Lại<br><span class="text-lc-blue">Sức Khỏe Cho Cộng Đồng</span>
            </h2>
            <p class="text-sm md:text-base text-gray-500 mb-6 leading-relaxed">
                Được thành lập từ những năm 2015, hệ thống của chúng tôi đã không ngừng nỗ lực nâng cao chất lượng dịch vụ, mở rộng hệ thống nhà thuốc trên khắp cả nước nhằm đưa các sản phẩm dược phẩm, thực phẩm chức năng và thiết bị y tế chất lượng cao nhất tới tay người dân.
            </p>
            <p class="text-sm md:text-base text-gray-500 mb-6 leading-relaxed">
                Đội ngũ dược sĩ giàu kinh nghiệm, chu đáo và tận tụy luôn sẵn sàng đồng hành tư vấn thuốc chính xác cho người bệnh vào bất cứ thời điểm nào.
            </p>
            
            <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                <div class="flex -space-x-4">
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-lc-blue text-white flex items-center justify-center font-bold text-xs">DS</div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-lc-orange text-white flex items-center justify-center font-bold text-xs">YT</div>
                    <div class="w-10 h-10 rounded-full border-2 border-white bg-green-500 text-white flex items-center justify-center font-bold text-xs">BS</div>
                </div>
                <div>
                    <h4 class="font-extrabold text-gray-800 text-xs md:text-sm">Hơn 500+ Dược Sĩ & Bác Sĩ</h4>
                    <p class="text-[11px] text-gray-400">Luôn túc trực tư vấn chuyên môn 24/7</p>
                </div>
            </div>
        </div>

        <!-- Stats Counters -->
        <div class="about-stats-section grid grid-cols-2 gap-6">
            <!-- Stat 1 -->
            <div class="bg-blue-50/50 p-6 md:p-8 rounded-2xl text-center border border-blue-50/20 group hover:bg-lc-blue transition duration-300">
                <div class="text-2xl md:text-4xl font-black text-lc-blue mb-2 group-hover:text-white transition">
                    <span class="stat-counter" data-target="10">0</span>+
                </div>
                <div class="text-xs font-bold text-gray-600 group-hover:text-blue-100 transition">Năm Hoạt Động</div>
            </div>

            <!-- Stat 2 -->
            <div class="bg-orange-50/50 p-6 md:p-8 rounded-2xl text-center border border-orange-50/20 group hover:bg-lc-orange transition duration-300">
                <div class="text-2xl md:text-4xl font-black text-lc-orange mb-2 group-hover:text-white transition">
                    <span class="stat-counter" data-target="50">0</span>+
                </div>
                <div class="text-xs font-bold text-gray-600 group-hover:text-orange-100 transition">Cơ Sở Toàn Quốc</div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-green-50/50 p-6 md:p-8 rounded-2xl text-center border border-green-50/20 group hover:bg-green-600 transition duration-300">
                <div class="text-2xl md:text-4xl font-black text-green-600 mb-2 group-hover:text-white transition">
                    <span class="stat-counter" data-target="10000">0</span>+
                </div>
                <div class="text-xs font-bold text-gray-600 group-hover:text-green-100 transition">Khách Hàng Hài Lòng</div>
            </div>

            <!-- Stat 4 -->
            <div class="bg-purple-50/50 p-6 md:p-8 rounded-2xl text-center border border-purple-50/20 group hover:bg-purple-600 transition duration-300">
                <div class="text-2xl md:text-4xl font-black text-purple-600 mb-2 group-hover:text-white transition">
                    <span class="stat-counter" data-target="5000">0</span>+
                </div>
                <div class="text-xs font-bold text-gray-600 group-hover:text-purple-100 transition">Sản Phẩm Đăng Ký</div>
            </div>
        </div>
    </div>
</section>
