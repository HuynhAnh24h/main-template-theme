import { createIcons, icons } from 'lucide';

// Khởi tạo các thư viện dùng chung cho toàn site
document.addEventListener('DOMContentLoaded', () => {
    // 1. Tự động tìm tất cả thẻ có data-lucide và chèn icon SVG tương ứng
    createIcons({ icons });

    // 2. Logic Menu di động (Mobile Menu Toggle & Drawer)
    const mobileMenuBtn = document.getElementById('mobile-nav-toggle') || document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-nav-menu') || document.getElementById('mobile-menu');

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

    // 3. Logic Cuộn mượt cho Contact nếu đang ở Trang Chủ
    const contactLinks = document.querySelectorAll('a[href*="#contact"]');
    contactLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const contactSection = document.getElementById('contact');
            if (contactSection) {
                e.preventDefault();
                contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Đóng mobile menu nếu đang mở
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });

    // 4. Logic Nút cuộn lên đầu trang (Back to Top)
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

    // 5. Header: Đảm bảo luôn cố định chắc chắn & hiệu ứng scroll
    const header = document.getElementById('site-header') || document.querySelector('.site-header');
    if (header) {
        const onHeaderScroll = () => {
            if (window.scrollY > 20) {
                header.classList.add('shadow-[0_8px_30px_rgba(0,0,0,0.9)]');
            } else {
                header.classList.remove('shadow-[0_8px_30px_rgba(0,0,0,0.9)]');
            }
        };
        window.addEventListener('scroll', onHeaderScroll, { passive: true });
        onHeaderScroll();
    }

    console.log('On The Rock Header & Global Javascript Loaded!');
});
