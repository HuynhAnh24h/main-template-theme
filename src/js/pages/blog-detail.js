/**
 * Script dành riêng cho Trang Chi Tiết Bài Viết (Single Blog Post) - On The Rock
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Thanh tiến trình đọc bài viết (Reading Progress Bar)
    const progressBar = document.getElementById('reading-progress');
    const article = document.querySelector('article');

    if (progressBar && article) {
        const updateProgress = () => {
            const articleRect = article.getBoundingClientRect();
            const articleTop = articleRect.top + window.scrollY;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const currentScroll = window.scrollY;

            // Bắt đầu tính từ khi cuộn đến bài viết
            const startScroll = articleTop - 120;
            const endScroll = articleTop + articleHeight - windowHeight;
            const totalScrollable = endScroll - startScroll;

            if (totalScrollable > 0) {
                const scrolled = currentScroll - startScroll;
                const percent = Math.min(100, Math.max(0, (scrolled / totalScrollable) * 100));
                progressBar.style.width = percent + '%';
            } else {
                progressBar.style.width = '0%';
            }
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        window.addEventListener('resize', updateProgress, { passive: true });
        updateProgress();
    }

    // 2. Toast thông báo (Toast Notification Helper)
    const showToast = (message) => {
        let toast = document.getElementById('otr-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'otr-toast';
            toast.className = 'fixed bottom-8 left-1/2 -translate-x-1/2 z-50 bg-[#1c1611]/95 text-[#caa875] border border-[#caa875]/40 px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2.5 text-xs sm:text-sm font-medium transition-all duration-300 opacity-0 translate-y-4 pointer-events-none backdrop-blur-md';
            document.body.appendChild(toast);
        }

        toast.innerHTML = `
            <svg class="w-4 h-4 text-[#caa875] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>${message}</span>
        `;

        toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
        toast.classList.add('opacity-100', 'translate-y-0');

        clearTimeout(toast._timer);
        toast._timer = setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
        }, 2500);
    };

    // 3. Nút sao chép liên kết bài viết (Copy Link)
    const copyBtns = document.querySelectorAll('[data-share="copy"]');
    copyBtns.forEach((btn) => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const currentUrl = window.location.href;
            let copied = false;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(currentUrl);
                    copied = true;
                }
            } catch (err) {
                // Ignore and try fallback
            }

            if (!copied) {
                try {
                    const tempInput = document.createElement('textarea');
                    tempInput.value = currentUrl;
                    tempInput.style.position = 'fixed';
                    tempInput.style.opacity = '0';
                    document.body.appendChild(tempInput);
                    tempInput.focus();
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    copied = true;
                } catch (e2) {
                    copied = false;
                }
            }

            showToast('Đã sao chép liên kết bài viết!');
        });
    });


    // 4. Mở cửa sổ chia sẻ mạng xã hội (Social Share Popups)
    const shareBtns = document.querySelectorAll('[data-share]:not([data-share="copy"])');
    shareBtns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const type = btn.getAttribute('data-share');
            const pageUrl = encodeURIComponent(window.location.href);
            const pageTitle = encodeURIComponent(document.title);
            let shareUrl = '';

            if (type === 'facebook') {
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
            } else if (type === 'twitter' || type === 'x') {
                shareUrl = `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`;
            } else if (type === 'zalo') {
                shareUrl = `https://sp.zalo.me/share_inline?url=${pageUrl}`;
            } else if (type === 'telegram') {
                shareUrl = `https://t.me/share/url?url=${pageUrl}&text=${pageTitle}`;
            }

            if (shareUrl) {
                const width = 600;
                const height = 480;
                const left = window.innerWidth / 2 - width / 2;
                const top = window.innerHeight / 2 - height / 2;
                window.open(shareUrl, '_blank', `width=${width},height=${height},left=${left},top=${top},menubar=no,status=no,toolbar=no`);
            }
        });
    });
});
