// JS dành riêng cho trang Giới thiệu (About Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('About Page Script Loaded!');

    // Ví dụ: Hiệu ứng số chạy tăng dần (Counter Up Animation)
    const counters = document.querySelectorAll('.stat-counter');
    if (counters.length > 0) {
        const runCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target') || 0;
                let count = 0;
                const speed = target / 50; // Tốc độ chạy

                const updateCount = () => {
                    count += speed;
                    if (count < target) {
                        counter.innerText = Math.floor(count);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        };

        // Kích hoạt khi cuộn đến section (Sử dụng IntersectionObserver)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    runCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.about-stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    }
});
