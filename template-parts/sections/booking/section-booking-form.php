<?php
/**
 * Template Part: Section Booking Form
 * Description: Form đặt bàn trực tuyến On The Rock Bar (100% khớp giao diện mẫu).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id   = get_the_ID();
$title     = function_exists('otr_get_field') ? otr_get_field('booking_form_title', $post_id, function_exists('otr_t') ? otr_t('ĐẶT BÀN TRƯỚC', 'TABLE RESERVATION') : 'ĐẶT BÀN TRƯỚC') : 'ĐẶT BÀN TRƯỚC';
$subtitle  = function_exists('otr_get_field') ? otr_get_field('booking_form_subtitle', $post_id, function_exists('otr_t') ? otr_t("Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.", "Select your booking details, and we will\nreserve the finest table for your evening.") : "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.") : "Chọn thông tin đặt bàn, chúng mình sẽ\nsắp xếp chỗ ngồi phù hợp nhất dành cho bạn.";

$time_slots = array(
    '18:30', '19:00', '19:30', '20:00',
    '20:30', '21:00', '21:30', '22:00',
    '22:30', '23:00', '23:30', '00:00',
    '00:30', '01:00', '01:30', '02:00',
);

$today_label = function_exists('otr_t') ? otr_t(' ( hôm nay )', ' ( today )') : ' ( hôm nay )';
$today_display = date_i18n('d/m/Y') . $today_label;
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
                        <?php echo esc_html(function_exists('otr_t') ? otr_t('Họ tên người đặt bàn', 'Full Name') : 'Họ tên người đặt bàn'); ?> <span class="text-[#caa875]">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="booking_name" 
                        name="full_name" 
                        required 
                        placeholder="<?php echo esc_attr(function_exists('otr_t') ? otr_t('Giáng Ly', 'Your Full Name') : 'Giáng Ly'); ?>" 
                        class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base"
                    >
                </div>

                <div>
                    <label for="booking_phone" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        <?php echo esc_html(function_exists('otr_t') ? otr_t('Số điện thoại', 'Phone Number') : 'Số điện thoại'); ?> <span class="text-[#caa875]">*</span>
                    </label>
                    <input 
                        type="tel" 
                        id="booking_phone" 
                        name="phone" 
                        required 
                        placeholder="<?php echo esc_attr(function_exists('otr_t') ? otr_t('Nhập số điện thoại', 'Your phone number') : 'Nhập số điện thoại'); ?>" 
                        class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base"
                    >
                </div>
            </div>

            <!-- Hàng 2: Số lượng khách & Ngày đặt bàn -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking_guests_display" class="block text-xs uppercase tracking-wider text-[#caa875]/90 mb-2 font-medium">
                        <?php echo esc_html(function_exists('otr_t') ? otr_t('Số lượng khách', 'Number of Guests') : 'Số lượng khách'); ?>
                    </label>
                    <div class="relative cursor-pointer" id="booking_guests_wrapper">
                        <?php $default_guest = function_exists('otr_t') ? otr_t('2 khách', '2 guests') : '2 khách'; ?>
                        <input 
                            type="text" 
                            id="booking_guests_display" 
                            readonly 
                            value="<?php echo esc_attr($default_guest); ?>" 
                            class="w-full bg-[#1b1b1b] text-neutral-200 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base cursor-pointer pr-14 select-none"
                        >
                        <input type="hidden" id="booking_guests" name="guests" value="<?php echo esc_attr($default_guest); ?>">
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
                        <?php echo esc_html(function_exists('otr_t') ? otr_t('Ngày đặt bàn', 'Reservation Date') : 'Ngày đặt bàn'); ?>
                    </label>
                    <div class="relative cursor-pointer" id="booking_date_wrapper">
                        <input 
                            type="text" 
                            id="booking_date_display" 
                            readonly 
                            value="<?php echo esc_attr($today_display); ?>" 
                            class="w-full bg-[#1b1b1b] text-neutral-200 rounded-full px-6 py-3.5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base cursor-pointer pr-14 select-none"
                        >
                        <input 
                            type="hidden" 
                            id="booking_date_picker" 
                            name="booking_date" 
                            value="<?php echo esc_attr($today_value); ?>" 
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
                    <?php echo esc_html(function_exists('otr_t') ? otr_t('Chọn giờ đặt bàn còn chỗ:', 'Available Time Slots:') : 'Chọn giờ đặt bàn còn chỗ:'); ?>
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
                    <?php echo esc_html(function_exists('otr_t') ? otr_t('Lời nhắn', 'Special Requests / Notes') : 'Lời nhắn'); ?>
                </label>
                <textarea 
                    id="booking_message" 
                    name="message" 
                    rows="4" 
                    placeholder="<?php echo esc_attr(function_exists('otr_t') ? otr_t('Viết lời nhắn của bạn tại đây...', 'Any special requests or preferences...') : 'Viết lời nhắn của bạn tại đây...'); ?>" 
                    class="w-full bg-[#1b1b1b] text-neutral-100 placeholder-neutral-500 rounded-2xl p-5 border border-[#2d2d2d] focus:border-[#caa875] focus:bg-[#222222] focus:outline-none transition-all duration-200 text-sm md:text-base resize-none"
                ></textarea>
            </div>

            <!-- Khung thông báo trạng thái gửi -->
            <div id="otr_booking_alert" class="hidden p-4 rounded-xl text-sm leading-relaxed border transition-all duration-300"></div>

            <!-- Nút Submit Đặt Bàn -->
            <div class="pt-2">
                <?php $submit_btn_text = function_exists('otr_t') ? otr_t('ĐẶT BÀN', 'CONFIRM RESERVATION') : 'ĐẶT BÀN'; ?>
                <button 
                    type="submit" 
                    id="otr_booking_submit_btn" 
                    class="btn-liquid-glass w-full py-4 px-8 rounded-full font-serif tracking-[0.25em] text-sm md:text-base uppercase flex items-center justify-center gap-3 cursor-pointer group"
                >
                    <span class="btn-text btn-roll-wrap font-medium">
                        <span class="btn-roll-text">
                            <span><?php echo esc_html($submit_btn_text); ?></span>
                            <span aria-hidden="true"><?php echo esc_html($submit_btn_text); ?></span>
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

<!-- Custom Guest Count Modal (Khớp 100% Mockup) -->
<div id="otr-guests-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/65 backdrop-blur-[2px] opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative w-full max-w-[320px] bg-[#18130e] border border-[#caa875]/20 rounded-[24px] py-6 px-4 text-center shadow-[0_25px_60px_rgba(0,0,0,0.95)] transform scale-95 transition-all duration-300 select-none">
        <div class="flex flex-col space-y-1">
            <?php 
            $guests_opts = array(
                array('val' => '1', 'vi' => '1 khách', 'en' => '1 guest'),
                array('val' => '2', 'vi' => '2 khách', 'en' => '2 guests'),
                array('val' => '3', 'vi' => '3 khách', 'en' => '3 guests'),
                array('val' => '4', 'vi' => '4 khách', 'en' => '4 guests'),
                array('val' => '5', 'vi' => '5 khách', 'en' => '5 guests'),
                array('val' => '6', 'vi' => '6 khách', 'en' => '6 guests'),
                array('val' => '7+', 'vi' => '7+ khách (Nhóm lớn)', 'en' => '7+ guests (Large Group)'),
            );
            foreach ($guests_opts as $g_opt):
                $g_label = function_exists('otr_t') ? otr_t($g_opt['vi'], $g_opt['en']) : $g_opt['vi'];
            ?>
                <button type="button" data-guests="<?php echo esc_attr($g_label); ?>" class="otr-guest-option w-full py-2.5 px-3 text-[#d8cebe] text-lg font-light tracking-wide rounded-xl hover:text-white hover:bg-white/5 transition-all cursor-pointer">
                    <?php echo esc_html($g_label); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Custom Calendar Date Picker Modal (Khớp 100% Mockup) -->
<div id="otr-calendar-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/65 backdrop-blur-[2px] opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative w-full max-w-[340px] bg-[#18130e] border border-[#caa875]/20 rounded-[24px] p-6 shadow-[0_25px_60px_rgba(0,0,0,0.95)] transform scale-95 transition-all duration-300 select-none">
        
        <!-- Header: Prev Button, Month Year, Next Button -->
        <div class="flex items-center justify-between mb-5 px-1">
            <button type="button" id="cal-prev-month" class="w-8 h-8 flex items-center justify-center text-[#d8cebe] hover:text-[#caa875] transition-colors rounded-full hover:bg-white/5 cursor-pointer" aria-label="<?php echo esc_attr(function_exists('otr_t') ? otr_t('Tháng trước', 'Previous month') : 'Tháng trước'); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <div id="cal-month-year" class="font-sans font-medium text-base text-[#f5efe6] tracking-wide">
                August, 2026
            </div>
            <button type="button" id="cal-next-month" class="w-8 h-8 flex items-center justify-center text-[#d8cebe] hover:text-[#caa875] transition-colors rounded-full hover:bg-white/5 cursor-pointer" aria-label="<?php echo esc_attr(function_exists('otr_t') ? otr_t('Tháng sau', 'Next month') : 'Tháng sau'); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Day Names Row (Mo Tu We Th Fr Sa Su) -->
        <div class="grid grid-cols-7 gap-1 text-center mb-4">
            <span class="text-xs font-medium text-[#e8ded1]">Mo</span>
            <span class="text-xs font-medium text-[#e8ded1]">Tu</span>
            <span class="text-xs font-medium text-[#e8ded1]">We</span>
            <span class="text-xs font-medium text-[#e8ded1]">Th</span>
            <span class="text-xs font-medium text-[#e8ded1]">Fr</span>
            <span class="text-xs font-medium text-[#e8ded1]">Sa</span>
            <span class="text-xs font-medium text-[#e8ded1]">Su</span>
        </div>

        <!-- Days Grid (01, 02, ... 31) -->
        <div id="cal-days-grid" class="grid grid-cols-7 gap-y-3 gap-x-1 text-center text-xs sm:text-sm">
            <!-- Dynamic days rendered by JS -->
        </div>

    </div>
</div>

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
            <?php echo esc_html(function_exists('otr_t') ? otr_t('YÊU CẦU ĐÃ ĐƯỢC GỬI!', 'RESERVATION SENT!') : 'YÊU CẦU ĐÃ ĐƯỢC GỬI!'); ?>
        </h3>
        
        <p class="text-neutral-300 text-sm leading-relaxed mb-6 font-light">
            <?php echo wp_kses_post(function_exists('otr_t') ? otr_t('Cảm ơn bạn đã lựa chọn <strong>On The Rock</strong>.<br>Chúng mình đã nhận được thông tin và sẽ gọi điện xác nhận lại chỗ ngồi cho bạn trong ít phút.', 'Thank you for choosing <strong>On The Rock</strong>.<br>We have received your reservation request and will contact you shortly to confirm.') : 'Cảm ơn bạn đã lựa chọn <strong>On The Rock</strong>.<br>Chúng mình đã nhận được thông tin và sẽ gọi điện xác nhận lại chỗ ngồi cho bạn trong ít phút.'); ?>
        </p>

        <!-- Khung tóm tắt thông tin đã đặt -->
        <div id="modal-booking-summary" class="bg-[#1b130a] border border-[#caa875]/30 rounded-xl p-4 mb-6 text-left text-xs sm:text-sm space-y-2 text-neutral-300">
            <!-- Nội dung tóm tắt chèn bằng JS -->
        </div>

        <?php $close_modal_text = function_exists('otr_t') ? otr_t('ĐÓNG CỬA SỔ', 'CLOSE') : 'ĐÓNG CỬA SỔ'; ?>
        <button 
            type="button" 
            id="modal-close-btn" 
            class="btn-liquid-glass w-full py-3.5 px-6 rounded-full font-serif tracking-[0.2em] text-xs sm:text-sm uppercase cursor-pointer"
        >
            <span class="btn-roll-wrap font-medium">
                <span class="btn-roll-text">
                    <span><?php echo esc_html($close_modal_text); ?></span>
                    <span aria-hidden="true"><?php echo esc_html($close_modal_text); ?></span>
                </span>
            </span>
        </button>

    </div>
</div>
