<?php
/**
 * Section: Contact Info & Form
 * Bố cục: Thông tin liên hệ (Trái) + Form Liên hệ (Phải)
 */
?>
<section class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-50 mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Contact Information -->
        <div>
            <span class="text-xs uppercase font-extrabold text-lc-blue tracking-wider block mb-2">Liên hệ</span>
            <h2 class="text-2xl md:text-4xl font-black text-gray-800 mb-6 leading-tight">
                Liên Hệ Với Chúng Tôi<br><span class="text-lc-blue">Để Được Hỗ Trợ Nhanh Nhất</span>
            </h2>
            <p class="text-sm md:text-base text-gray-500 mb-8 leading-relaxed">
                Quý khách có bất cứ câu hỏi nào về sản phẩm, dịch vụ, đơn hàng hay góp ý chất lượng phục vụ? Đừng ngần ngại liên hệ với chúng tôi qua các kênh dưới đây hoặc gửi tin nhắn trực tiếp qua form.
            </p>
            
            <div class="space-y-6">
                <!-- Phone -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-lc-blue flex items-center justify-center shrink-0">
                        <?php echo get_svg_icon('phone', 'w-5 h-5'); ?>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-800 text-sm">Điện thoại / Hotline</h4>
                        <p class="text-xs text-gray-500 mt-1">1800 6928 (Miễn phí cuộc gọi - Hỗ trợ 24/7)</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-lc-orange flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-800 text-sm">Email hỗ trợ</h4>
                        <p class="text-xs text-gray-500 mt-1">support@ecommerce-theme.com</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-gray-800 text-sm">Địa chỉ trụ sở chính</h4>
                        <p class="text-xs text-gray-500 mt-1">372-374 Trần Hưng Đạo, Quận 5, TP. Hồ Chí Minh</p>
                    </div>
                </div>
            </div>
            
            <!-- Map Placeholder -->
            <div class="mt-8 rounded-2xl overflow-hidden h-44 bg-gray-100 relative flex items-center justify-center border border-gray-100">
                <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&q=80&w=800');"></div>
                <div class="relative z-10 bg-white/95 px-4 py-2 rounded-xl text-xs font-bold text-gray-700 shadow flex items-center gap-1.5 backdrop-blur-sm">
                    <i data-lucide="map" class="w-4 h-4 text-lc-blue"></i> Bản đồ Long Châu - TP.HCM
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-gray-50/50 p-6 md:p-8 rounded-3xl border border-gray-100/50">
            <h3 class="font-black text-gray-800 text-lg md:text-xl mb-6">Gửi tin nhắn trực tiếp</h3>
            
            <form id="theme-contact-form" class="space-y-4">
                <div>
                    <label for="contact-name" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase">Họ và tên *</label>
                    <input type="text" id="contact-name" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-lc-blue transition" placeholder="Nguyễn Văn A">
                </div>

                <div>
                    <label for="contact-email" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase">Địa chỉ Email *</label>
                    <input type="email" id="contact-email" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-lc-blue transition" placeholder="nguyenvana@gmail.com">
                </div>

                <div>
                    <label for="contact-phone" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase">Số điện thoại</label>
                    <input type="tel" id="contact-phone" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-lc-blue transition" placeholder="0901234567">
                </div>

                <div>
                    <label for="contact-message" class="block text-xs font-bold text-gray-500 mb-1.5 uppercase">Nội dung liên hệ *</label>
                    <textarea id="contact-message" rows="4" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-lc-blue transition" placeholder="Tôi cần được tư vấn về thuốc bảo vệ xương khớp..."></textarea>
                </div>

                <button type="submit" class="w-full bg-lc-blue hover:bg-lc-darkblue text-white font-extrabold py-3.5 rounded-xl transition duration-200 shadow-md shadow-blue-500/10">
                    Gửi Liên Hệ
                </button>
            </form>
        </div>
    </div>
</section>
