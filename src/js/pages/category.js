// JS dành riêng cho trang Danh mục Sản phẩm (Product Category Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Product Category Page Script Loaded!');

    // Ví dụ: Ajax lọc sản phẩm hoặc xử lý sidebar filter
    const sortDropdown = document.getElementById('category-sort-select');
    if (sortDropdown) {
        sortDropdown.addEventListener('change', (e) => {
            console.log('Category sorting changed to:', e.target.value);
            // Có thể reload page với tham số URL: ?orderby=price
            // window.location.href = window.location.pathname + '?orderby=' + e.target.value;
        });
    }
});
