/**
 * Script xử lý trang Đặt Bàn (Booking Page) On The Rock Bar
 * Description: Xử lý chọn 16 khung giờ, chọn ngày, và gửi AJAX đặt bàn hiển thị popup sang trọng.
 */

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('otr-booking-form');
    if (!form) return;

    // 1. Xử lý chọn 16 Khung Giờ (Time Slot Pills)
    const slotButtons = document.querySelectorAll('.otr-time-slot-btn');
    const timeSlotInput = document.getElementById('otr_time_slot_input');

    const activeClasses = ['bg-[#caa875]', 'text-[#080604]', 'font-bold', 'border-[#caa875]', 'shadow-[0_0_15px_rgba(202,168,117,0.3)]'];
    const inactiveClasses = ['bg-[#181818]', 'text-neutral-400', 'hover:text-white', 'hover:bg-[#252525]', 'border-transparent'];

    slotButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Xóa active khỏi tất cả
            slotButtons.forEach(b => {
                b.classList.remove(...activeClasses);
                b.classList.add(...inactiveClasses);
            });

            // Gán active cho button vừa click
            btn.classList.remove(...inactiveClasses);
            btn.classList.add(...activeClasses);

            const selectedTime = btn.getAttribute('data-time');
            if (timeSlotInput && selectedTime) {
                timeSlotInput.value = selectedTime;
            }
        });
    });

    // 2. Xử lý đồng bộ Ngày Đặt Bàn
    const datePicker = document.getElementById('booking_date_picker');
    const dateDisplay = document.getElementById('booking_date_display');

    if (datePicker && dateDisplay) {
        datePicker.addEventListener('change', (e) => {
            const rawVal = e.target.value; // YYYY-MM-DD
            if (rawVal) {
                const parts = rawVal.split('-');
                if (parts.length === 3) {
                    const selectedFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
                    
                    const now = new Date();
                    const todayFormatted = `${String(now.getDate()).padStart(2, '0')}/${String(now.getMonth() + 1).padStart(2, '0')}/${now.getFullYear()}`;
                    
                    if (selectedFormatted === todayFormatted) {
                        dateDisplay.value = `${selectedFormatted} ( hôm nay )`;
                    } else {
                        dateDisplay.value = selectedFormatted;
                    }
                }
            }
        });
    }

    // 3. Xử lý Submit Form qua AJAX
    const submitBtn = document.getElementById('otr_booking_submit_btn');
    const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
    const btnSpinner = submitBtn ? submitBtn.querySelector('.btn-spinner') : null;
    const alertBox = document.getElementById('otr_booking_alert');

    // Modal elements
    const successModal = document.getElementById('otr-success-modal');
    const modalSummary = document.getElementById('modal-booking-summary');
    const modalCloseBtn = document.getElementById('modal-close-btn');

    function showAlert(msg, isSuccess = false) {
        if (!alertBox) return;
        alertBox.innerHTML = msg;
        alertBox.className = isSuccess 
            ? 'p-4 rounded-xl text-sm leading-relaxed border border-green-500/40 bg-green-950/40 text-green-200 block'
            : 'p-4 rounded-xl text-sm leading-relaxed border border-red-500/40 bg-red-950/40 text-red-200 block';
    }

    function hideAlert() {
        if (alertBox) {
            alertBox.className = 'hidden';
            alertBox.innerHTML = '';
        }
    }

    function showModal(data) {
        if (!successModal) return;
        
        if (modalSummary) {
            modalSummary.innerHTML = `
                <div class="flex justify-between border-b border-[#caa875]/20 pb-1.5">
                    <span class="text-[#caa875]">👤 Khách hàng:</span>
                    <span class="text-white font-medium">${escapeHtml(data.name)}</span>
                </div>
                <div class="flex justify-between border-b border-[#caa875]/20 pb-1.5">
                    <span class="text-[#caa875]">📞 Số điện thoại:</span>
                    <span class="text-white font-medium">${escapeHtml(data.phone)}</span>
                </div>
                <div class="flex justify-between border-b border-[#caa875]/20 pb-1.5">
                    <span class="text-[#caa875]">👥 Số lượng khách:</span>
                    <span class="text-white font-medium">${escapeHtml(data.guests)}</span>
                </div>
                <div class="flex justify-between border-b border-[#caa875]/20 pb-1.5">
                    <span class="text-[#caa875]">⏰ Khung giờ:</span>
                    <span class="text-[#caa875] font-bold">${escapeHtml(data.time)} ngày ${escapeHtml(data.date)}</span>
                </div>
                ${data.message ? `
                <div class="pt-1 text-neutral-300 italic">
                    "${escapeHtml(data.message)}"
                </div>` : ''}
            `;
        }

        successModal.classList.remove('opacity-0', 'pointer-events-none');
        const dialog = successModal.querySelector('div');
        if (dialog) {
            dialog.classList.remove('scale-95');
            dialog.classList.add('scale-100');
        }
    }

    function closeModal() {
        if (!successModal) return;
        successModal.classList.add('opacity-0', 'pointer-events-none');
        const dialog = successModal.querySelector('div');
        if (dialog) {
            dialog.classList.remove('scale-100');
            dialog.classList.add('scale-95');
        }
    }

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', closeModal);
    }
    if (successModal) {
        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) {
                closeModal();
            }
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideAlert();

        const nameInput = document.getElementById('booking_name');
        const phoneInput = document.getElementById('booking_phone');
        const guestsInput = document.getElementById('booking_guests');
        const messageInput = document.getElementById('booking_message');

        const name = nameInput ? nameInput.value.trim() : '';
        const phone = phoneInput ? phoneInput.value.trim() : '';
        const guests = guestsInput ? guestsInput.value : '2 khách';
        const date = dateDisplay ? dateDisplay.value.replace(' ( hôm nay )', '').trim() : '';
        const time = timeSlotInput ? timeSlotInput.value : '18:30';
        const message = messageInput ? messageInput.value.trim() : '';

        // Kiểm tra hợp lệ cơ bản
        if (!name) {
            showAlert('Vui lòng nhập họ và tên của bạn.');
            nameInput.focus();
            return;
        }

        if (!phone || phone.length < 9) {
            showAlert('Vui lòng nhập số điện thoại hợp lệ để quán liên hệ xác nhận bàn.');
            phoneInput.focus();
            return;
        }

        if (!time) {
            showAlert('Vui lòng chọn khung giờ đặt bàn.');
            return;
        }

        // Bật trạng thái gửi
        if (submitBtn) {
            submitBtn.disabled = true;
            if (btnText) btnText.textContent = 'ĐANG GỬI THÔNG TIN...';
            if (btnSpinner) btnSpinner.classList.remove('hidden');
        }

        const ajaxUrl = (window.otrBookingData && window.otrBookingData.ajax_url) 
            ? window.otrBookingData.ajax_url 
            : '/ecommerce-theme/wp-admin/admin-ajax.php';

        const formData = new FormData();
        formData.append('action', 'otr_submit_booking');
        formData.append('full_name', name);
        formData.append('phone', phone);
        formData.append('guests', guests);
        formData.append('booking_date', date);
        formData.append('time_slot', time);
        formData.append('message', message);

        try {
            const response = await fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
            });

            const res = await response.json();

            if (res.success) {
                // Hiển thị modal popup thành công
                showModal({
                    name,
                    phone,
                    guests,
                    date,
                    time,
                    message,
                });

                // Reset form
                form.reset();
                if (timeSlotInput) timeSlotInput.value = '18:30';
                slotButtons.forEach((b, idx) => {
                    if (idx === 0) {
                        b.classList.remove(...inactiveClasses);
                        b.classList.add(...activeClasses);
                    } else {
                        b.classList.remove(...activeClasses);
                        b.classList.add(...inactiveClasses);
                    }
                });
                if (dateDisplay && datePicker) {
                    const now = new Date();
                    dateDisplay.value = `${String(now.getDate()).padStart(2, '0')}/${String(now.getMonth() + 1).padStart(2, '0')}/${now.getFullYear()} ( hôm nay )`;
                }
            } else {
                showAlert(res.data && res.data.message ? res.data.message : 'Có lỗi xảy ra trong quá trình gửi. Vui lòng thử lại hoặc gọi hotline.');
            }
        } catch (err) {
            console.error('Booking submission error:', err);
            showAlert('Không thể kết nối đến máy chủ. Vui lòng liên hệ trực tiếp hotline để đặt bàn nhanh.');
        } finally {
            // Tắt trạng thái gửi
            if (submitBtn) {
                submitBtn.disabled = false;
                if (btnText) btnText.textContent = 'ĐẶT BÀN';
                if (btnSpinner) btnSpinner.classList.add('hidden');
            }
        }
    });
});
