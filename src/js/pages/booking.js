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

    // Helper Modal Transition Functions
    const openModal = (modalEl) => {
        if (!modalEl) return;
        modalEl.classList.remove('opacity-0', 'pointer-events-none');
        modalEl.classList.add('opacity-100');
        const card = modalEl.querySelector('div');
        if (card) {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }
    };

    const closeModal = (modalEl) => {
        if (!modalEl) return;
        modalEl.classList.remove('opacity-100');
        modalEl.classList.add('opacity-0', 'pointer-events-none');
        const card = modalEl.querySelector('div');
        if (card) {
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
    };

    // 2. Xử lý Popup Chọn Số Lượng Khách (Khớp 100% Mockup)
    const guestsWrapper = document.getElementById('booking_guests_wrapper');
    const guestsDisplay = document.getElementById('booking_guests_display');
    const guestsHiddenInput = document.getElementById('booking_guests');
    const guestsModal = document.getElementById('otr-guests-modal');
    const guestOptions = document.querySelectorAll('.otr-guest-option');

    if (guestsWrapper && guestsModal) {
        guestsWrapper.addEventListener('click', (e) => {
            e.stopPropagation();
            closeModal(calendarModal);
            openModal(guestsModal);
        });

        guestOptions.forEach(opt => {
            opt.addEventListener('click', (e) => {
                e.stopPropagation();
                const chosen = opt.getAttribute('data-guests');
                if (chosen) {
                    if (guestsDisplay) guestsDisplay.value = chosen;
                    if (guestsHiddenInput) guestsHiddenInput.value = chosen;

                    // Cập nhật trạng thái active
                    guestOptions.forEach(o => {
                        o.classList.remove('text-[#f5efe6]', 'font-normal');
                        o.classList.add('text-[#d8cebe]', 'font-light');
                    });
                    opt.classList.remove('text-[#d8cebe]', 'font-light');
                    opt.classList.add('text-[#f5efe6]', 'font-normal');
                }
                closeModal(guestsModal);
            });
        });

        guestsModal.addEventListener('click', (e) => {
            if (e.target === guestsModal) {
                closeModal(guestsModal);
            }
        });
    }

    // 3. Xử lý Popup Lịch Chọn Ngày (Custom Calendar Date Picker Khớp 100% Mockup)
    const dateWrapper = document.getElementById('booking_date_wrapper');
    const dateDisplay = document.getElementById('booking_date_display');
    const datePicker = document.getElementById('booking_date_picker');
    const calendarModal = document.getElementById('otr-calendar-modal');
    const calMonthYear = document.getElementById('cal-month-year');
    const calDaysGrid = document.getElementById('cal-days-grid');
    const calPrevBtn = document.getElementById('cal-prev-month');
    const calNextBtn = document.getElementById('cal-next-month');

    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    const today = new Date();
    const todayZero = new Date(today.getFullYear(), today.getMonth(), today.getDate());

    let selectedDate = new Date(todayZero);
    let viewYear = selectedDate.getFullYear();
    let viewMonth = selectedDate.getMonth();

    const renderCalendar = () => {
        if (!calMonthYear || !calDaysGrid) return;

        // Cập nhật tiêu đề tháng & năm (VD: "August, 2026")
        calMonthYear.textContent = `${monthNames[viewMonth]}, ${viewYear}`;

        // Kiểm tra nút Prev (không cho lùi về trước tháng hiện tại)
        if (calPrevBtn) {
            const isCurrentMonthOrPast = (viewYear < today.getFullYear()) || 
                (viewYear === today.getFullYear() && viewMonth <= today.getMonth());
            if (isCurrentMonthOrPast) {
                calPrevBtn.classList.add('opacity-20', 'pointer-events-none');
            } else {
                calPrevBtn.classList.remove('opacity-20', 'pointer-events-none');
            }
        }

        calDaysGrid.innerHTML = '';

        // Tính ngày bắt đầu trong tuần (Thứ Hai làm ngày đầu tiên: Mo=0, Tu=1... Su=6)
        const firstDayOfWeek = new Date(viewYear, viewMonth, 1).getDay();
        const startOffset = (firstDayOfWeek + 6) % 7;

        // Các ô trống trước ngày 1
        for (let i = 0; i < startOffset; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'w-8 h-8 sm:w-9 sm:h-9';
            calDaysGrid.appendChild(emptyCell);
        }

        // Tổng số ngày trong tháng
        const totalDays = new Date(viewYear, viewMonth + 1, 0).getDate();

        for (let d = 1; d <= totalDays; d++) {
            const dPadded = String(d).padStart(2, '0');
            const cellDate = new Date(viewYear, viewMonth, d);
            cellDate.setHours(0, 0, 0, 0);

            const isPast = cellDate < todayZero;
            const isSelected = selectedDate && (cellDate.getTime() === selectedDate.getTime());

            if (isSelected) {
                // Ngày đang được chọn: Badge tròn nền sáng, chữ tối (y hệt mẫu ngày 12 trong mockup)
                const selBadge = document.createElement('div');
                selBadge.className = 'w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#f4efe8] text-[#1a140e] font-bold flex items-center justify-center mx-auto shadow-md select-none text-xs sm:text-sm';
                selBadge.textContent = dPadded;
                calDaysGrid.appendChild(selBadge);
            } else if (isPast) {
                // Ngày đã qua trong quá khứ: Làm mờ, không bấm được
                const pastCell = document.createElement('div');
                pastCell.className = 'w-8 h-8 sm:w-9 sm:h-9 text-neutral-600 opacity-25 flex items-center justify-center mx-auto font-light pointer-events-none select-none text-xs sm:text-sm';
                pastCell.textContent = dPadded;
                calDaysGrid.appendChild(pastCell);
            } else {
                // Ngày có thể chọn trong tương lai
                const dayBtn = document.createElement('button');
                dayBtn.type = 'button';
                dayBtn.className = 'cal-day-btn w-8 h-8 sm:w-9 sm:h-9 rounded-full text-[#d8cebe] hover:bg-[#caa875]/20 hover:text-white flex items-center justify-center mx-auto transition-all cursor-pointer font-light select-none text-xs sm:text-sm';
                dayBtn.textContent = dPadded;
                dayBtn.setAttribute('data-day', d);

                dayBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    selectedDate = new Date(viewYear, viewMonth, d);
                    selectedDate.setHours(0, 0, 0, 0);

                    const dayStr = String(d).padStart(2, '0');
                    const monthStr = String(viewMonth + 1).padStart(2, '0');
                    const yyyy = viewYear;

                    // Cập nhật input hiển thị
                    if (dateDisplay) {
                        if (selectedDate.getTime() === todayZero.getTime()) {
                            dateDisplay.value = `${dayStr}/${monthStr}/${yyyy} ( hôm nay )`;
                        } else {
                            dateDisplay.value = `${dayStr}/${monthStr}/${yyyy}`;
                        }
                    }

                    // Cập nhật hidden input gửi AJAX
                    if (datePicker) {
                        datePicker.value = `${yyyy}-${monthStr}-${dayStr}`;
                    }

                    renderCalendar();
                    setTimeout(() => closeModal(calendarModal), 120);
                });

                calDaysGrid.appendChild(dayBtn);
            }
        }
    };

    if (dateWrapper && calendarModal) {
        dateWrapper.addEventListener('click', (e) => {
            e.stopPropagation();
            closeModal(guestsModal);
            // Đồng bộ lại view tháng theo ngày đã chọn
            if (selectedDate) {
                viewYear = selectedDate.getFullYear();
                viewMonth = selectedDate.getMonth();
            }
            renderCalendar();
            openModal(calendarModal);
        });

        if (calPrevBtn) {
            calPrevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderCalendar();
            });
        }

        if (calNextBtn) {
            calNextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderCalendar();
            });
        }

        calendarModal.addEventListener('click', (e) => {
            if (e.target === calendarModal) {
                closeModal(calendarModal);
            }
        });
    }

    // Đóng bất kỳ modal nào khi bấm phím Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal(guestsModal);
            closeModal(calendarModal);
            closeModal(successModal);
        }
    });

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
        const iconName = isSuccess ? 'check-circle' : 'alert-circle';
        const iconColor = isSuccess ? 'text-emerald-400' : 'text-red-400';
        alertBox.innerHTML = `
            <div class="flex items-center gap-3">
                <i data-lucide="${iconName}" class="w-5 h-5 shrink-0 ${iconColor}"></i>
                <div class="text-sm leading-relaxed">${msg}</div>
            </div>
        `;
        alertBox.className = isSuccess 
            ? 'p-4 rounded-xl text-sm leading-relaxed border border-emerald-500/40 bg-emerald-950/40 text-emerald-200 block transition-all duration-300'
            : 'p-4 rounded-xl text-sm leading-relaxed border border-red-500/40 bg-red-950/40 text-red-200 block transition-all duration-300';
        if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons();
        }
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
                <div class="flex justify-between items-center border-b border-[#caa875]/20 py-2">
                    <span class="text-[#caa875] flex items-center gap-2 text-xs uppercase tracking-wider font-sans">
                        <i data-lucide="user" class="w-4 h-4 text-[#caa875]"></i>
                        Khách hàng:
                    </span>
                    <span class="text-white font-medium font-sans">${escapeHtml(data.name)}</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#caa875]/20 py-2">
                    <span class="text-[#caa875] flex items-center gap-2 text-xs uppercase tracking-wider font-sans">
                        <i data-lucide="phone" class="w-4 h-4 text-[#caa875]"></i>
                        Số điện thoại:
                    </span>
                    <span class="text-white font-medium font-sans">${escapeHtml(data.phone)}</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#caa875]/20 py-2">
                    <span class="text-[#caa875] flex items-center gap-2 text-xs uppercase tracking-wider font-sans">
                        <i data-lucide="users" class="w-4 h-4 text-[#caa875]"></i>
                        Số lượng khách:
                    </span>
                    <span class="text-white font-medium font-sans">${escapeHtml(data.guests)}</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#caa875]/20 py-2">
                    <span class="text-[#caa875] flex items-center gap-2 text-xs uppercase tracking-wider font-sans">
                        <i data-lucide="calendar" class="w-4 h-4 text-[#caa875]"></i>
                        Khung giờ:
                    </span>
                    <span class="text-[#caa875] font-bold font-sans">${escapeHtml(data.time)} • ${escapeHtml(data.date)}</span>
                </div>
                ${data.message ? `
                <div class="pt-2 text-neutral-300 italic flex items-start gap-2 text-xs font-sans">
                    <i data-lucide="message-square" class="w-4 h-4 text-[#caa875] shrink-0 mt-0.5"></i>
                    <span>"${escapeHtml(data.message)}"</span>
                </div>` : ''}
            `;
            if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
            }
        }

        successModal.classList.remove('opacity-0', 'pointer-events-none');
        const dialog = successModal.querySelector('div');
        if (dialog) {
            dialog.classList.remove('scale-95');
            dialog.classList.add('scale-100');
        }
    }

    function closeSuccessModal() {
        if (!successModal) return;
        closeModal(successModal);
    }

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', closeSuccessModal);
    }
    if (successModal) {
        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) {
                closeSuccessModal();
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

        const updateBtnText = (txt) => {
            if (!btnText) return;
            const spans = btnText.querySelectorAll('.btn-roll-text span');
            if (spans.length > 0) {
                spans.forEach(s => { s.textContent = txt; });
            } else {
                btnText.textContent = txt;
            }
        };

        // Bật trạng thái gửi
        if (submitBtn) {
            submitBtn.disabled = true;
            updateBtnText('ĐANG GỬI THÔNG TIN...');
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
                updateBtnText('ĐẶT BÀN');
                if (btnSpinner) btnSpinner.classList.add('hidden');
            }
        }
    });
});
