// JS dành riêng cho trang Tin tức / Blog (Blog Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Blog Listing Script Loaded!');

    // Ví dụ: Load More AJAX tin tức
    const loadMoreBtn = document.getElementById('blog-load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            loadMoreBtn.innerHTML = 'Đang tải...';
            loadMoreBtn.disabled = true;

            setTimeout(() => {
                console.log('Ajax loaded next posts');
                // Đoạn này sẽ thực tế gửi ajax wp_ajax_load_more_posts
                loadMoreBtn.innerHTML = 'Xem thêm bài viết';
                loadMoreBtn.disabled = false;
                alert('Chức năng tải thêm bài viết sẽ hoạt động khi kết nối với WordPress API.');
            }, 1000);
        });
    }
});
