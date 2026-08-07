// JS dành riêng cho trang Tổng hợp Danh mục (All Categories Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('All Categories Page Script Loaded!');

    // Ví dụ: Tìm kiếm nhanh danh mục (Instant Category Filter)
    const filterInput = document.getElementById('category-search-input');
    const categoryCards = document.querySelectorAll('.category-grid-item');

    if (filterInput && categoryCards.length > 0) {
        filterInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();

            categoryCards.forEach(card => {
                const title = card.querySelector('.category-title').textContent.toLowerCase();
                if (title.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
