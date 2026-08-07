// JS dành riêng cho trang Liên hệ (Contact Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Contact Page Script Loaded!');

    // Ví dụ: Form validation và xử lý submit bằng Ajax
    const contactForm = document.getElementById('theme-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = document.getElementById('contact-name');
            const email = document.getElementById('contact-email');
            const message = document.getElementById('contact-message');
            let hasError = false;

            // Simple validation
            [name, email, message].forEach(input => {
                if (input && !input.value.trim()) {
                    input.classList.add('border-red-500');
                    hasError = true;
                } else if (input) {
                    input.classList.remove('border-red-500');
                }
            });

            if (hasError) {
                alert('Vui lòng điền đầy đủ các thông tin bắt buộc.');
                return;
            }

            // Gửi dữ liệu qua WordPress AJAX hoặc REST API
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Đang gửi...';
            submitBtn.disabled = true;

            setTimeout(() => {
                alert('Cảm ơn bạn! Thông điệp của bạn đã được gửi thành công.');
                contactForm.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }
});
