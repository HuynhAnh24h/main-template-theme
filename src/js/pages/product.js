// JS dành riêng cho trang Cửa hàng (Shop Page / Product Catalog)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Product Shop Catalog Script Loaded!');

    // Ví dụ: Toggle Grid / List View
    const gridBtn = document.getElementById('view-grid-btn');
    const listBtn = document.getElementById('view-list-btn');
    const productContainer = document.getElementById('shop-product-grid');

    if (gridBtn && listBtn && productContainer) {
        gridBtn.addEventListener('click', () => {
            productContainer.classList.remove('grid-cols-1', 'md:grid-cols-2');
            productContainer.classList.add('grid-cols-2', 'md:grid-cols-4');
            gridBtn.classList.add('text-lc-blue');
            listBtn.classList.remove('text-lc-blue');
        });

        listBtn.addEventListener('click', () => {
            productContainer.classList.remove('grid-cols-2', 'md:grid-cols-4');
            productContainer.classList.add('grid-cols-1', 'md:grid-cols-2');
            listBtn.classList.add('text-lc-blue');
            gridBtn.classList.remove('text-lc-blue');
        });
    }
});
