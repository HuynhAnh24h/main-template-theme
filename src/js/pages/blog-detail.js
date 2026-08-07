// JS dành riêng cho trang Chi tiết Tin tức (Blog Detail Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Blog Detail Page Script Loaded!');

    // Ví dụ: Thanh tiến trình đọc bài viết (Reading Progress Bar)
    const progressBar = document.getElementById('reading-progress');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const article = document.querySelector('article');
            if (article) {
                const articleHeight = article.offsetHeight;
                const articleTop = article.offsetTop;
                const scrollPos = window.scrollY - articleTop;
                const windowHeight = window.innerHeight;
                
                let progress = 0;
                if (scrollPos > 0) {
                    progress = (scrollPos / (articleHeight - windowHeight)) * 100;
                }
                
                progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
            }
        });
    }
});
