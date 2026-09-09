// Interactive Blog & Event JavaScript (On The Rock Cocktail Bar)
// Xử lý bộ lọc chuyên mục (Tabs) tức thì với hiệu ứng so le Zig-Zag mượt mà & Nút Xem Thêm.

function initBlogPage() {
  const tabButtons = document.querySelectorAll('.blog-tab-btn');
  const postItems = Array.from(document.querySelectorAll('.blog-post-card, .blog-post-item'));
  const loadMoreBtn = document.getElementById('blog-load-more-btn');
  const postsContainer = document.getElementById('blog-posts-container');

  if (!postsContainer || postItems.length === 0) return;

  const checkEmpty = () => {
    const visibleCount = postItems.filter(item => !item.classList.contains('hidden')).length;
    let emptyNotice = document.getElementById('blog-no-posts-notice');
    if (visibleCount === 0) {
      if (!emptyNotice) {
        emptyNotice = document.createElement('div');
        emptyNotice.id = 'blog-no-posts-notice';
        emptyNotice.className = 'text-center py-16 text-[#caa875]/60 font-sans italic text-sm sm:text-base';
        emptyNotice.textContent = 'Chưa có bài viết hoặc sự kiện nào trong chuyên mục này.';
        postsContainer.appendChild(emptyNotice);
      }
      emptyNotice.classList.remove('hidden');
      if (loadMoreBtn) loadMoreBtn.parentElement.classList.add('hidden');
    } else {
      if (emptyNotice) emptyNotice.classList.add('hidden');
      if (loadMoreBtn) loadMoreBtn.parentElement.classList.remove('hidden');
    }
  };

  // 1. Xử lý chuyển đổi Tab chuyên mục (Client-side Filter tức thì)
  if (tabButtons.length > 0) {
    tabButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const targetSlug = btn.getAttribute('data-cat-slug') || 'all';

        // Cập nhật trạng thái active của buttons
        tabButtons.forEach((b) => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        // Lọc bài viết với animation mượt
        postItems.forEach((item) => {
          const itemCat = item.getAttribute('data-post-cat') || '';
          const shouldShow = (targetSlug === 'all' || itemCat === targetSlug);

          if (shouldShow) {
            item.classList.remove('hidden');
            item.style.opacity = '0';
            item.style.transform = 'translateY(12px)';
            setTimeout(() => {
              item.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
              item.style.opacity = '1';
              item.style.transform = 'translateY(0)';
            }, 50);
          } else {
            item.classList.add('hidden');
          }
        });

        checkEmpty();
      });
    });
  }

  // 2. Xử lý nút Xem Thêm (Load More)
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
      const originalText = loadMoreBtn.innerHTML;
      loadMoreBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-[#caa875] inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg> Đang tải thêm...
      `;
      loadMoreBtn.disabled = true;

      setTimeout(() => {
        loadMoreBtn.innerHTML = 'Đã hiển thị toàn bộ bài viết';
        loadMoreBtn.classList.add('opacity-60', 'pointer-events-none');
      }, 700);
    });
  }

  // Khởi tạo kiểm tra ban đầu
  checkEmpty();
}

if (document.readyState !== 'loading') {
  initBlogPage();
} else {
  document.addEventListener('DOMContentLoaded', initBlogPage);
}
