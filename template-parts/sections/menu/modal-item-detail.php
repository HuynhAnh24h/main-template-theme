<?php
/**
 * Template Part: Modal Item Detail (On The Rock Luxury Noir & iOS Liquid Glass)
 * Description: Popup chi tiết món ăn / đồ uống khi click vào bất kỳ món nào ở Kiểu 2 & Kiểu 3.
 * Hiển thị hình ảnh nghệ thuật, nốt hương vị, thành phần nguyên liệu, giá và nút đặt bàn nhanh.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<!-- KHUNG MODAL TOÀN MÀN HÌNH (BACKDROP KÍNH MỜ APPLE GLASS) -->
<div id="menu-item-modal" 
     class="fixed inset-0 z-[99999] flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-xl opacity-0 pointer-events-none transition-all duration-300 select-none"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="menu-modal-title">

    <!-- THẺ CARD HÌNH CHỮ NHẬT SANG TRỌNG (LUXURY RECTANGULAR PLACARD) -->
    <div class="menu-modal-card relative w-full max-w-[480px] bg-[#0d0905] border border-[#caa875]/50 shadow-[0_25px_80px_rgba(0,0,0,0.98),0_0_50px_rgba(202,168,117,0.15)] overflow-hidden transform scale-95 translate-y-3 transition-all duration-300 max-h-[92vh] flex flex-col">
        
        <!-- Khung viền chỉ đôi tinh xảo phong cách Menu Thượng Hạng -->
        <div class="absolute inset-[3px] border border-[#caa875]/20 pointer-events-none z-20"></div>

        <!-- 1. HÌNH ẢNH NGHỆ THUẬT DẠNG HÌNH CHỮ NHẬT (RECTANGULAR HERO IMAGE) -->
        <div class="relative w-full h-56 sm:h-64 md:h-72 shrink-0 overflow-hidden bg-[#060402] border-b border-[#caa875]/30">
            <img id="menu-modal-img" 
                 src="" 
                 alt="Cocktail Detail" 
                 class="w-full h-full object-cover object-center brightness-[0.92] transition-transform duration-700 ease-out">
            
            <!-- Lớp phủ Gradient điện ảnh: Chìm dần màu vào nền mun phía dưới -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0905] via-[#0d0905]/30 to-black/20 pointer-events-none"></div>

            <!-- Huy hiệu Phân loại hình chữ nhật sắc sảo góc trên trái -->
            <div class="absolute top-4 left-4 z-30">
                <span id="menu-modal-category" 
                      class="inline-block px-3 py-1 text-[10px] tracking-[0.25em] uppercase font-semibold text-[#caa875] bg-black/80 backdrop-blur-md border border-[#caa875]/40 shadow-lg">
                    ✦ COCKTAIL
                </span>
            </div>

            <!-- Nút đóng hình chữ nhật / vuông thanh lịch góc trên phải -->
            <div class="absolute top-4 right-4 z-30">
                <button type="button" 
                        class="menu-modal-close-btn w-8 h-8 sm:w-9 sm:h-9 bg-black/80 hover:bg-[#caa875]/25 border border-[#caa875]/40 text-[#caa875] hover:text-white backdrop-blur-md flex items-center justify-center transition-all duration-200 cursor-pointer shadow-lg" 
                        aria-label="Đóng cửa sổ">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- 2. NỘI DUNG CHI TIẾT MÓN (CONTENT & TASTING NOTES AREA) -->
        <div class="p-6 sm:p-7 overflow-y-auto space-y-3.5 custom-scrollbar text-[#caa875] flex-1 z-10">
            
            <!-- Hàng Tiêu Đề & Giá Tiền (Header Row) -->
            <div class="flex items-baseline justify-between gap-4 border-b border-[#caa875]/25 pb-3">
                <h3 id="menu-modal-title" 
                    class="font-serif text-2xl sm:text-3xl md:text-4xl tracking-wide font-normal text-[#caa875] uppercase leading-tight">
                    Rosita
                </h3>
                <span id="menu-modal-price" 
                      class="font-serif text-xl sm:text-2xl text-[#f3e3cb] font-light shrink-0 tracking-wider">
                    240k
                </span>
            </div>

            <!-- MỤC 1: THÀNH PHẦN NGUYÊN LIỆU -->
            <div id="menu-modal-ingredients-section" class="p-3.5 sm:p-4 bg-[#140e08]/90 border border-[#caa875]/25">
                <div class="text-[11px] uppercase tracking-[0.25em] text-[#caa875] font-semibold mb-2 flex items-center gap-2">
                    <span class="text-[#caa875]">✦</span> THÀNH PHẦN NGUYÊN LIỆU
                </div>
                <div id="menu-modal-ingredients" 
                     class="text-xs sm:text-[13.5px] text-[#f5ebd8] font-sans italic font-light leading-relaxed tracking-wide">
                    Jose Cuervo Reposado, Cinzano Rosso & Extra Dry, Campari, Aromatic Bitters, Lime zest
                </div>
            </div>

            <!-- MỤC 2: MÔ TẢ HƯƠNG VỊ ĐẶC TRƯNG -->
            <div id="menu-modal-tasting-section" class="p-3.5 sm:p-4 bg-[#140e08]/90 border border-[#caa875]/25">
                <div class="text-[11px] uppercase tracking-[0.25em] text-[#caa875] font-semibold mb-2 flex items-center gap-2">
                    <span class="text-[#caa875]">✦</span> MÔ TẢ HƯƠNG VỊ ĐẶC TRƯNG
                </div>
                <div id="menu-modal-content" class="space-y-2 text-xs sm:text-[13px] text-[#caa875]/90 font-sans font-light leading-relaxed">
                    <!-- Sẽ được nạp tự động qua JavaScript -->
                </div>
            </div>

            <!-- Dấu mộc đáy sang trọng chuẩn Menu Noir -->
            <div class="pt-3 border-t border-[#caa875]/20 flex items-center justify-between text-[10px] tracking-[0.25em] text-[#caa875]/50 uppercase font-sans">
                <span>✦ ON THE ROCK DALAT</span>
                <span>FINE COCKTAIL BAR</span>
            </div>

        </div>

    </div>

</div>
