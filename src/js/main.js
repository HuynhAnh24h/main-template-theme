import { 
    createIcons, 
    BadgeCheck, 
    CheckCircle, 
    AlertCircle, 
    User, 
    Phone, 
    Users, 
    Calendar, 
    MessageSquare, 
    ArrowRight,
    ChevronLeft,
    ChevronRight,
    ChevronDown,
    ChevronUp,
    Search,
    Home,
    Menu,
    X,
    Check,
    Star,
    Clock,
    MapPin,
    Mail,
    PhoneCall,
    Sparkles,
    ShoppingCart
} from 'lucide';

const icons = {
    BadgeCheck,
    CheckCircle,
    AlertCircle,
    User,
    Phone,
    Users,
    Calendar,
    MessageSquare,
    ArrowRight,
    ChevronLeft,
    ChevronRight,
    ChevronDown,
    ChevronUp,
    Search,
    Home,
    Menu,
    X,
    Check,
    Star,
    Clock,
    MapPin,
    Mail,
    PhoneCall,
    Sparkles,
    ShoppingCart
};

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
        const buttons = document.querySelectorAll('.btn-liquid-glass, .otr-btn-glass, .otr-btn');
        buttons.forEach(btn => {
            if (btn.querySelector('.btn-roll-wrap')) return;

            const childNodes = Array.from(btn.childNodes);
            let targetNode = null;
            let text = '';

            for (const node of childNodes) {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim().length > 0) {
                    targetNode = node;
                    text = node.textContent.trim();
                    break;
                } else if (node.nodeType === Node.ELEMENT_NODE && !node.querySelector('svg') && !node.classList.contains('btn-spinner') && node.textContent.trim().length > 0 && node.children.length === 0) {
                    targetNode = node;
                    text = node.textContent.trim();
                    break;
                }
            }

            if (targetNode && text) {
                const rollWrap = document.createElement('span');
                rollWrap.className = 'btn-roll-wrap';
                rollWrap.innerHTML = `
                    <span class="btn-roll-text">
                        <span>${text}</span>
                        <span aria-hidden="true">${text}</span>
                    </span>
                `;
                btn.replaceChild(rollWrap, targetNode);
            }
        });
    }

    window.initLiquidGlassButtons = initLiquidGlassButtons;
    initLiquidGlassButtons();

    // 7. Logic Dropdown Ngôn ngữ [ VN ⌵ ] (Desktop & Mobile)
    function initLanguageDropdown() {
        const dropdowns = document.querySelectorAll('.otr-lang-dropdown');
        if (!dropdowns.length) return;

        dropdowns.forEach(dropdown => {
            const btn = dropdown.querySelector('.otr-lang-dropdown__btn');
            const menu = dropdown.querySelector('.otr-lang-dropdown__menu');
            const chevron = dropdown.querySelector('.otr-dropdown-chevron');

            if (!btn || !menu) return;

            const toggle = (forceOpen) => {
                const isOpen = typeof forceOpen === 'boolean' ? forceOpen : menu.classList.contains('hidden');
                if (isOpen) {
                    // Close other dropdowns
                    dropdowns.forEach(other => {
                        if (other !== dropdown) {
                            const oMenu = other.querySelector('.otr-lang-dropdown__menu');
                            const oChev = other.querySelector('.otr-dropdown-chevron');
                            const oBtn = other.querySelector('.otr-lang-dropdown__btn');
                            if (oMenu) oMenu.classList.add('hidden');
                            if (oChev) oChev.classList.remove('rotate-180');
                            if (oBtn) oBtn.setAttribute('aria-expanded', 'false');
                        }
                    });
                    menu.classList.remove('hidden');
                    btn.setAttribute('aria-expanded', 'true');
                    if (chevron) chevron.classList.add('rotate-180');
                } else {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            };

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                toggle();
            });

            // Hover effect on desktop screens (>= 768px)
            dropdown.addEventListener('mouseenter', () => {
                if (window.innerWidth >= 768) {
                    toggle(true);
                }
            });
            dropdown.addEventListener('mouseleave', () => {
                if (window.innerWidth >= 768) {
                    toggle(false);
                }
            });
        });

        // Click outside to close dropdowns
        document.addEventListener('click', (e) => {
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    const menu = dropdown.querySelector('.otr-lang-dropdown__menu');
                    const chevron = dropdown.querySelector('.otr-dropdown-chevron');
                    const btn = dropdown.querySelector('.otr-lang-dropdown__btn');
                    if (menu && !menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                        if (btn) btn.setAttribute('aria-expanded', 'false');
                        if (chevron) chevron.classList.remove('rotate-180');
                    }
                }
            });
        });
    }

    initLanguageDropdown();

    console.log('On The Rock Header & Global Javascript Loaded!');
});
