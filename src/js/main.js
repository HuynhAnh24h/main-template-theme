import { createIcons, icons } from 'lucide';

// Khởi tạo các thư viện dùng chung cho toàn site
document.addEventListener('DOMContentLoaded', () => {
    // 1. Tự động tìm tất cả thẻ có data-lucide và chèn icon SVG tương ứng
    createIcons({ icons });

    // 2. Logic Menu di động (Mobile Menu Hamburger)
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });

        // Đóng menu khi click ra ngoài
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // 3. Logic Nút cuộn lên đầu trang (Back to Top)
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100');
            } else {
                backToTopBtn.classList.remove('opacity-100');
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    console.log('Global Javascript Loaded!');
});
