// JS dành riêng cho trang Chi tiết Sản phẩm (Product Detail Page)
document.addEventListener('DOMContentLoaded', () => {
    console.log('Product Detail Page Script Loaded!');

    // 1. Tăng giảm số lượng sản phẩm (Quantity Selector)
    const qtyInput = document.querySelector('.quantity-input');
    const qtyMinus = document.querySelector('.quantity-minus');
    const qtyPlus = document.querySelector('.quantity-plus');

    if (qtyInput && qtyMinus && qtyPlus) {
        qtyMinus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        });

        qtyPlus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            qtyInput.value = val + 1;
        });
    }

    // 2. Chuyển đổi các Tab chi tiết (Mô tả, Đánh giá, Thông số)
    const tabButtons = document.querySelectorAll('.product-tab-btn');
    const tabPanels = document.querySelectorAll('.product-tab-panel');

    if (tabButtons.length > 0 && tabPanels.length > 0) {
        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-tab');

                // Active button
                tabButtons.forEach(b => b.classList.remove('border-lc-blue', 'text-lc-blue', 'font-bold'));
                btn.addCls = btn.classList.add('border-lc-blue', 'text-lc-blue', 'font-bold');

                // Show panel
                tabPanels.forEach(panel => {
                    if (panel.id === `tab-panel-${targetTab}`) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                });
            });
        });
    }

    // 3. Đổi ảnh Gallery thu nhỏ (Thumbnail Selector)
    const mainImg = document.getElementById('product-main-image');
    const thumbs = document.querySelectorAll('.product-thumb-item');

    if (mainImg && thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                const newSrc = thumb.getAttribute('data-large-src');
                if (newSrc) {
                    mainImg.src = newSrc;
                    // Active thumb
                    thumbs.forEach(t => t.classList.remove('border-lc-blue'));
                    thumb.classList.add('border-lc-blue');
                }
            });
        });
    }
});
