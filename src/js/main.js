import { createIcons, icons } from 'lucide';

// Expose globally for dynamic components & alerts
window.lucide = {
    createIcons: (options = {}) => createIcons({ icons, ...options }),
    icons
};

// Khởi tạo các thư viện dùng chung cho toàn site
document.addEventListener('DOMContentLoaded', () => {
    // Đảm bảo các trang không có màn hình loading (#loader) luôn có class .is-loaded để cuộn và hiển thị bình thường
    if (!document.getElementById('loader')) {
        document.body.classList.add('is-loaded');
    }

    // 1. Tự động tìm tất cả thẻ có data-lucide và chèn icon SVG tương ứng
    createIcons({ icons });

    // 2. Logic Menu di động (Mobile Menu Toggle & Drawer)
    const mobileMenuBtn = document.getElementById('mobile-nav-toggle') || document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-nav-menu') || document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        const iconMenu = mobileMenuBtn.querySelector('.mobile-icon-menu');
        const iconClose = mobileMenuBtn.querySelector('.mobile-icon-close');

        const toggleMenu = (open) => {
            const shouldOpen = typeof open === 'boolean' ? open : mobileMenu.classList.contains('hidden');
            if (shouldOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                if (iconMenu) iconMenu.classList.add('hidden');
                if (iconClose) iconClose.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                if (iconMenu) iconMenu.classList.remove('hidden');
                if (iconClose) iconClose.classList.add('hidden');
            }
        };

        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            toggleMenu();
        });

        // Đóng menu khi click ra ngoài
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                toggleMenu(false);
            }
        });

        // Đóng menu khi click bất kỳ link nào trong drawer
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                toggleMenu(false);
            });
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

    // 5. Header: Hiệu ứng Liquid Glass toàn diện khi Scroll
    const header = document.getElementById('site-header') || document.querySelector('.site-header');
    if (header) {
        const onHeaderScroll = () => {
            if (window.scrollY > 20) {
                header.classList.add('is-scrolled', 'liquid-glass');
            } else {
                header.classList.remove('is-scrolled', 'liquid-glass');
            }
        };
        window.addEventListener('scroll', onHeaderScroll, { passive: true });
        onHeaderScroll();
    }

    // 6. Hiệu ứng Liquid Glass & Dual Text Roll-up cho Button
    function initLiquidGlassButtons() {
        const buttons = document.querySelectorAll('.btn-liquid-glass');
        buttons.forEach(btn => {
            if (btn.querySelector('.btn-roll-wrap')) return;

            const childNodes = Array.from(btn.childNodes);
            let textNode = null;

            for (const node of childNodes) {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim().length > 0) {
                    textNode = node;
                    break;
                }
            }

            if (textNode) {
                const text = textNode.textContent.trim();
                const rollWrap = document.createElement('span');
                rollWrap.className = 'btn-roll-wrap';
                rollWrap.innerHTML = `
                    <span class="btn-roll-text">
                        <span>${text}</span>
                        <span aria-hidden="true">${text}</span>
                    </span>
                `;
                btn.replaceChild(rollWrap, textNode);
            }
        });
    }

    initLiquidGlassButtons();

    console.log('On The Rock Header & Global Javascript Loaded!');
});
