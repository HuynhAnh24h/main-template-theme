<?php
/**
 * Template Part: Section Booking Form
 * Description: Form đặt bàn trực tuyến On The Rock Bar (100% khớp giao diện mẫu).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id   = get_the_ID();
$title     = function_exists('get_field') ? (get_field('booking_form_title', $post_id) ?: 'ĐẶT BÀN TRƯỚC') : 'ĐẶT BÀN TRƯỚC';
$subtitle  = function_exists('get_field') ? (get_field('booking_form_subtitle', $post_id) ?: "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.") : "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.";

$time_slots = array(
    '18:30', '19:00', '19:30', '20:00',
    '20:30', '21:00', '21:30', '22:00',
    '22:30', '23:00', '23:30', '00:00',
    '00:30', '01:00', '01:30', '02:00',
);

$today_display = date_i18n('d/m/Y') . ' ( hôm nay )';
$today_value   = date_i18n('Y-m-d');
?>

<section class="otr-booking-section relative bg-[#080604] text-white pt-28 md:pt-36 pb-16 md:pb-24 px-4 sm:px-6 overflow-hidden">
    <!-- Hiệu ứng ánh sáng nền mờ ảo luxury -->
    <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-[#caa875]/5 rounded-full blur-[140px]"></div>

    <div class="max-w-[720px] mx-auto relative z-10">
        
        <!-- Tiêu đề & Lời nhắn giới thiệu -->
        <div class="text-center mb-10 md:mb-14">
            <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-[#caa875] tracking-[0.18em] uppercase font-normal leading-tight mb-4">
                <?php echo esc_html($title); ?>
            </h1>
            <p class="text-[#caa875]/80 text-xs sm:text-sm md:text-base font-light leading-relaxed max-w-md mx-auto">
                <?php echo nl2br(esc_html($subtitle)); ?>
            </p>
        </div>

        <!-- Form Đặt Bàn -->
        <form id="otr-booking-form" method="post" class="space-y-6">
            
            <!-- Hàng 1: Họ tên & Số điện thoại -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking_name" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        Họ tên người đặt bàn <span class="text-[#caa875]">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="booking_name" 
                        name="full_name" 
                        required 
                        placeholder="Giáng Ly" 
                        class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base"
                    >
                </div>

                <div>
                    <label for="booking_phone" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        Số điện thoại <span class="text-[#caa875]">*</span>
                    </label>
                    <input 
                        type="tel" 
                        id="booking_phone" 
                        name="phone" 
                        required 
                        placeholder="Nhập số điện thoại" 
                        class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base"
                    >
                </div>
            </div>

            <!-- Hàng 2: Số lượng khách & Ngày đặt bàn -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking_guests" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        Số lượng khách
                    </label>
                    <div class="relative">
                        <select 
                            id="booking_guests" 
                            name="guests" 
                            class="w-full bg-[#1b1b1b] text-neutral-200 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none appearance-none transition-all duration-200 text-sm md:text-base cursor-pointer pr-14"
                        >
                            <option value="1 khách">1 khách</option>
                            <option value="2 khách" selected>2 khách</option>
                            <option value="3 khách">3 khách</option>
                            <option value="4 khách">4 khách</option>
                            <option value="5 khách">5 khách</option>
                            <option value="6 - 8 khách">6 - 8 khách (Nhóm vừa)</option>
                            <option value="8 - 12 khách">8 - 12 khách (Nhóm lớn)</option>
                            <option value="12+ khách">12+ khách (Tiệc riêng / Event)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6 text-neutral-400">
                            <!-- Icon 2 người / Users -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="booking_date_display" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        Ngày đặt bàn
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="booking_date_display" 
                            readonly 
                            value="<?php echo esc_attr($today_display); ?>" 
                            class="w-full bg-[#1b1b1b] text-neutral-200 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base cursor-pointer pr-14 select-none"
                        >
                        <input 
                            type="date" 
                            id="booking_date_picker" 
                            name="booking_date" 
                            value="<?php echo esc_attr($today_value); ?>" 
                            min="<?php echo esc_attr($today_value); ?>"
                            class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                        >
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6 text-neutral-400">
                            <!-- Icon Lịch / Calendar -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng 3: Khung chọn 16 giờ đặt bàn (4x4 Grid) -->
            <div>
                <label class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-3 font-medium">
                    Chọn giờ đặt bàn còn chỗ:
                </label>
                
                <input type="hidden" name="time_slot" id="otr_time_slot_input" value="18:30" required>

                <div class="grid grid-cols-4 gap-2.5 sm:gap-3.5">
                    <?php foreach ($time_slots as $idx => $slot): 
                        $is_default = ($idx === 0);
                    ?>
                        <button 
                            type="button" 
                            data-time="<?php echo esc_attr($slot); ?>" 
                            class="otr-time-slot-btn py-3 px-1 sm:px-2 rounded-full text-center text-xs sm:text-sm transition-all duration-200 select-none <?php echo $is_default ? 'bg-[#caa875] text-[#080604] font-bold border-[#caa875] shadow-[0_0_15px_rgba(202,168,117,0.3)]' : 'bg-[#181818] text-neutral-400 hover:text-white hover:bg-[#252525] border border-transparent'; ?>"
                        >
                            <?php echo esc_html($slot); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Hàng 4: Lời nhắn -->
            <div>
                <label for="booking_message" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                    Lời nhắn
                </label>
                <textarea 
                    id="booking_message" 
                    name="message" 
                    rows="4" 
                    placeholder="Viết lời nhắn của bạn tại đây..." 
                    class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-2xl p-5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base resize-none"
                ></textarea>
            </div>

            <!-- Khung thông báo trạng thái gửi -->
            <div id="otr_booking_alert" class="hidden p-4 rounded-xl text-sm leading-relaxed border transition-all duration-300"></div>

            <!-- Nút Submit Đặt Bàn -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    id="otr_booking_submit_btn" 
                    class="btn-liquid-glass w-full py-4 px-8 rounded-full font-serif tracking-[0.25em] text-sm md:text-base uppercase bg-[#1e1710] text-[#caa875] border border-[#caa875]/60 shadow-[0_4px_25px_rgba(0,0,0,0.6)] flex items-center justify-center gap-3 cursor-pointer group"
                >
                    <span class="btn-text btn-roll-wrap font-medium">
                        <span class="btn-roll-text">
                            <span>ĐẶT BÀN</span>
                            <span aria-hidden="true">ĐẶT BÀN</span>
                        </span>
                    </span>
                    <span class="btn-spinner hidden">
                        <svg class="animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>

        </form>

    </div>
</section>

<!-- Luxury Modal Thông Báo Đặt Bàn Thành Công -->
<div id="otr-success-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="relative w-full max-w-lg bg-[#140e08] border border-[#caa875]/80 rounded-2xl p-7 sm:p-9 text-center shadow-[0_25px_60px_rgba(0,0,0,0.9)] transform scale-95 transition-transform duration-300">
        
        <!-- Icon Monogram OTR & Gold Badge Check -->
        <div class="mx-auto w-16 h-16 rounded-full border border-[#caa875] bg-[#caa875]/10 flex items-center justify-center mb-5 text-[#caa875]">
            <i data-lucide="badge-check" class="w-8 h-8 text-[#caa875]"></i>
        </div>

        <div class="font-serif text-xs tracking-[0.3em] uppercase text-[#caa875]/70 mb-1">
            ON THE ROCKS COCKTAIL BAR
        </div>
        <h3 class="font-serif text-2xl sm:text-3xl text-[#caa875] tracking-wide mb-3 font-normal">
            YÊU CẦU ĐÃ ĐƯỢC GỬI!
        </h3>
        
        <p class="text-neutral-300 text-sm leading-relaxed mb-6 font-light">
            Cảm ơn bạn đã lựa chọn <strong>On The Rock</strong>.<br>
            Chúng mình đã nhận được thông tin và sẽ gọi điện xác nhận lại chỗ ngồi cho bạn trong ít phút.
        </p>

        <!-- Khung tóm tắt thông tin đã đặt -->
        <div id="modal-booking-summary" class="bg-[#1b130a] border border-[#caa875]/30 rounded-xl p-4 mb-6 text-left text-xs sm:text-sm space-y-2 text-neutral-300">
            <!-- Nội dung tóm tắt chèn bằng JS -->
        </div>

        <button 
            type="button" 
            id="modal-close-btn" 
            class="btn-liquid-glass btn-liquid-gold w-full py-3.5 px-6 rounded-full font-serif tracking-[0.2em] text-xs sm:text-sm uppercase bg-[#caa875] text-[#080604] font-bold cursor-pointer shadow-lg"
        >
            <span class="btn-roll-wrap">
                <span class="btn-roll-text">
                    <span>ĐÓNG CỬA SỔ</span>
                    <span aria-hidden="true">ĐÓNG CỬA SỔ</span>
                </span>
            </span>
        </button>

    </div>
</div>
