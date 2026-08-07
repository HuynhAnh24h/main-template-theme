// JS dành riêng cho trang chủ (Home Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Home Page Script Loaded!');

    // Ví dụ: Logic Slider Banner chính
    const sliderContainer = document.querySelector('.hero-slider');
    if (sliderContainer) {
        // Có thể khởi tạo Swiper hoặc Splide ở đây
        // import Swiper from 'swiper';
        // new Swiper(sliderContainer, { ... });
        console.log('Hero Slider Component detected and ready for Swiper/Splide initialization.');
    }

    // Ví dụ: Logic bộ đếm ngược Flash Sale
    const countdownElement = document.getElementById('flash-sale-countdown');
    if (countdownElement) {
        let timeLeft = 3 * 60 * 60; // 3 tiếng
        const interval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(interval);
                countdownElement.innerHTML = "Đã hết hạn!";
                return;
            }
            timeLeft--;
            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;
            countdownElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }
});
