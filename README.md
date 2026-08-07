# Bộ Mã Nguồn WordPress Theme Chuẩn Chỉnh (Tailwind CSS v4 & Vite & Lucide Icons)

Mã nguồn này được thiết kế và cấu trúc theo các tiêu chuẩn lập trình hiện đại. Dự án tích hợp bộ build công cụ siêu tốc **Vite** để quản lý assets, tự động biên dịch **Tailwind CSS v4**, phân tách JavaScript riêng biệt cho từng trang để tối ưu hóa hiệu suất tải trang, và tích hợp thư viện **Lucide Icons** linh hoạt ở cả Server-side (PHP) lẫn Client-side (JS).

---

## 1. Cấu trúc thư mục (Directory Structure)

Thư mục theme được chia thành các phần phân cấp rõ ràng để bất kỳ ai đọc vào cũng có thể nắm bắt và triển khai ngay lập tức:

```text
theme-ecommerce-store/
├── assets/                       # Thư mục tài nguyên tĩnh
│   ├── dist/                     # [TỰ ĐỘNG SINH BỞI VITE] Chứa CSS & JS sau khi biên dịch
│   │   ├── css/
│   │   │   └── style.css         # CSS cuối đã tối ưu hóa và nén
│   │   └── js/
│   │       ├── main.js           # JS chạy chung cho toàn site (chứa Lucide core)
│   │       ├── home.js           # JS riêng cho Trang chủ (front-page)
│   │       ├── about.js          # JS riêng cho Trang Giới thiệu
│   │       ├── contact.js        # JS riêng cho Trang Liên hệ
│   │       ├── category-all.js   # JS riêng cho Trang Tổng hợp danh mục
│   │       ├── category.js       # JS riêng cho Trang danh mục sản phẩm (WooCommerce)
│   │       ├── product.js        # JS riêng cho Trang cửa hàng (WooCommerce)
│   │       ├── product-detail.js # JS riêng cho Chi tiết sản phẩm (WooCommerce)
│   │       ├── blog.js           # JS riêng cho Trang tin tức (Blog index)
│   │       ├── category-blog.js  # JS riêng cho Danh mục tin tức (Category blog)
│   │       ├── blog-detail.js    # JS riêng cho Chi tiết bài viết (Single post)
│   │       ├── cart.js           # JS riêng cho Giỏ hàng (WooCommerce Cart)
│   │       ├── checkout.js       # JS riêng cho Thanh toán (WooCommerce Checkout)
│   │       ├── my-account.js     # JS riêng cho Tài khoản (WooCommerce Account)
│   │       ├── search.js         # JS riêng cho Trang Tìm kiếm
│   │       └── page.js           # JS riêng cho các trang mặc định
│   ├── icons/                    # Thư mục chứa các icon SVG tải server-side (PHP)
│   └── images/                   # Hình ảnh tĩnh của dự án
│
├── src/                          # THƯ MỤC NGUỒN CHƯA BIÊN DỊCH (DEVELOPMENT)
│   ├── css/
│   │   └── main.css              # File CSS chính, cấu hình Tailwind v4 & theme colors
│   └── js/
│       ├── main.js               # JS chính khởi tạo Lucide và logic toàn trang
│       └── pages/                # Từng tệp tương tác riêng biệt cho mỗi page
│           ├── home.js
│           ├── about.js
│           ├── contact.js
│           ├── category-all.js
│           ├── category.js
│           ├── product.js
│           ├── product-detail.js
│           ├── blog.js
│           ├── category-blog.js
│           ├── blog-detail.js
│           ├── cart.js
│           ├── checkout.js
│           ├── my-account.js
│           ├── search.js
│           └── page.js
│
├── template-parts/               # Các phần giao diện PHP chia nhỏ tái sử dụng
│   ├── components/               # Components nhỏ (Thẻ sản phẩm, tin tức,...)
│   │   ├── product-card.php
│   │   ├── blog-card.php
│   │   └── breadcrumb.php
│   └── sections/                 # Các khối giao diện lớn (Hero, Flash Sale,...)
│       ├── section-hero.php
│       ├── section-flash-sale.php
│       ├── section-about.php
│       ├── section-contact.php
│       └── section-blog-grid.php
│
├── theme-pages/                  # Thư mục gom toàn bộ các tệp giao diện (theme pages)
│   ├── page-about.php            # Giao diện Giới thiệu
│   ├── page-contact.php          # Giao diện Liên hệ
│   ├── page-category-all.php     # Giao diện Tổng hợp danh mục
│   ├── page-cart.php             # Giao diện Giỏ hàng WooCommerce
│   ├── page-checkout.php         # Giao diện Thanh toán WooCommerce
│   ├── page-my-account.php       # Giao diện Tài khoản WooCommerce
│   ├── front-page.php            # Template Trang chủ chính thức
│   ├── archive-product.php       # Template trang Cửa hàng (WooCommerce Shop)
│   ├── single-product.php        # Template trang Chi tiết sản phẩm (WooCommerce Single)
│   ├── taxonomy-product_cat.php  # Template trang Danh mục sản phẩm (WooCommerce Category)
│   ├── home.php                  # Template trang Danh sách tin tức Blog
│   ├── category.php              # Template trang Danh mục Blog
│   ├── single.php                # Template trang Chi tiết bài viết Blog
│   ├── page.php                  # Template trang thông tin tĩnh mặc định (General Page)
│   ├── 404.php                   # Template trang lỗi 404
│   └── search.php                # Template trang kết quả tìm kiếm
│
├── index.php                     # Mẫu trang dự phòng chính (Fallback, Bắt buộc ở Root)
├── header.php                    # Đầu trang dùng chung (Sticky header, Bắt buộc ở Root)
├── footer.php                    # Chân trang dùng chung (Multi-column, Bắt buộc ở Root)
├── functions.php                 # File cấu hình WordPress (Enqueue & Custom Loader, Bắt buộc ở Root)
├── style.css                     # File metadata khai báo theme (Bắt buộc ở Root)
│
├── package.json                  # Node Scripts & Dependencies
├── vite.config.js                # Cấu hình Vite (định nghĩa entrypoints map)
└── watcher.js                    # File watcher tùy biến tránh lỗi treo trên Windows
```

---

## 2. Hướng dẫn khởi chạy và phát triển (Development Workflow)

Để bắt đầu làm việc với theme, hãy mở terminal tại thư mục theme và thực hiện các bước sau:

### Bước 1: Cài đặt thư viện
```bash
npm install
```

### Bước 2: Chạy chế độ theo dõi phát triển (Watch / Development Mode)
Lệnh này sẽ khởi chạy bộ theo dõi tệp tự động được viết tối ưu bằng Node.js (`watcher.js`). Nó sẽ lắng nghe các thay đổi trong thư mục `src/` và tự động kích hoạt tiến trình biên dịch lại siêu tốc bằng Vite chỉ trong ~300ms, giúp tránh mọi hiện tượng treo cứng của Watcher mặc định trên môi trường Windows:
```bash
npm run watch
```
*(Hoặc dùng `npm run dev` nếu bạn muốn chạy máy chủ phát triển Vite).*

### Bước 3: Biên dịch sản phẩm (Production Build)
Trước khi đưa website lên môi trường thực tế (Staging/Production), hãy chạy lệnh này để tối ưu hóa tối đa, nén CSS/JS và dọn dẹp các mã dư thừa:
```bash
npm run build
```

---

## 3. Cơ chế hoạt động của Bản đồ JS (JS Map System)

Để tối ưu hóa hiệu năng, website chỉ tải đúng tệp JavaScript cần thiết cho trang đó. Cơ chế này hoạt động tự động thông qua hai phần:

1. **Đăng ký đầu vào trong `vite.config.js`**:
   Toàn bộ các tệp trong `src/js/pages/` được đăng ký làm các cổng vào độc lập (`input`). Khi build, Vite sẽ tách chúng thành từng tệp riêng trong `assets/dist/js/`.
2. **Nhúng thông minh trong `functions.php`**:
   Mã nguồn sử dụng cấu trúc điều kiện của WordPress để dò tìm trang hiện hành (ví dụ: `is_front_page()`, `is_page_template()`, `is_singular('product')`,...) và thực hiện nhúng (enqueue) tệp JS tương ứng:
   ```php
   if (is_front_page()) {
       $page_script = 'home';
   } elseif (is_page_template('templates/page-about.php')) {
       $page_script = 'about';
   }
   // Tự động nhúng tệp '/assets/dist/js/home.js' nếu có sự ăn khớp
   ```

**Cách thêm trang có JS riêng:**
1. Tạo tệp JS mới trong `src/js/pages/ten-trang.js`.
2. Khai báo tệp này trong đối tượng `input` tại `vite.config.js`.
3. Trong `functions.php` (hàm `theme_scripts()`), thêm một điều kiện `elseif` để gán `$page_script = 'ten-trang'`.

---

## 4. Tái sử dụng Components & Sections trong PHP

### A. Nhúng Components nhỏ (truyền biến tùy biến)
WordPress hỗ trợ truyền tham số cho các tệp giao diện con. Bạn có thể tái sử dụng thẻ sản phẩm ở bất kỳ đâu như sau:
```php
// Nhúng sản phẩm mặc định
get_template_part('template-parts/components/product-card');

// Nhúng sản phẩm cụ thể và truyền thêm class Tailwind
get_template_part('template-parts/components/product-card', null, [
    'product_id' => 45,
    'class'      => 'shadow-lg border-blue-200'
]);
```

### B. Nhúng các Sections lớn
```php
// Nhúng khối Flash Sale ở trang chủ hoặc trang khuyến mãi
get_template_part('template-parts/sections/section-flash-sale');

// Nhúng khối Blog nổi bật
get_template_part('template-parts/sections/section-blog-grid');
```

---

## 5. Hướng dẫn sử dụng Icon (Lucide Icons)

Bạn có hai giải pháp sử dụng icon cực kỳ thuận tiện:

### Giải pháp 1: Server-side Rendering (Tốt nhất cho SEO & Tốc độ tải)
Sử dụng hàm Helper PHP `get_svg_icon()` đã được khai báo sẵn trong `functions.php`. Hàm này sẽ đọc trực tiếp mã SVG từ thư mục `assets/icons/` và nhúng inline vào mã HTML:
```php
<?php echo get_svg_icon('shopping-cart', 'w-5 h-5 text-lc-blue hover:scale-110 transition'); ?>
```
*Để sử dụng thêm icon mới ở server-side, chỉ cần lên trang chủ [lucide.dev](https://lucide.dev/), tải tệp SVG của icon đó về và bỏ vào thư mục `assets/icons/`.*

### Giải pháp 2: Client-side Rendering (Nhanh chóng & Tiện lợi)
Bạn chỉ cần viết thẻ HTML trống với thuộc tính `data-lucide`. Khi trang web tải xong, thư viện Lucide JS khởi tạo trong `src/js/main.js` sẽ tự động tìm và thay thế thành mã SVG:
```html
<i data-lucide="phone" class="w-6 h-6 text-lc-orange"></i>
<i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
```

---

## 6. Tùy chỉnh màu sắc và cấu hình Tailwind CSS v4

Trong Tailwind CSS v4, chúng ta **không sử dụng `tailwind.config.js` làm nơi lưu cấu hình chính** nữa. Thay vào đó, toàn bộ cấu hình màu sắc, font chữ và các biến theme được định nghĩa trực tiếp trong tệp CSS nguồn bằng các biến CSS chuẩn:

Mở tệp `src/css/main.css`:
```css
@import "tailwindcss";

@theme {
  --color-lc-blue: #0052cc;     /* Xanh chủ đạo Long Châu */
  --color-lc-darkblue: #003b99;
  --color-lc-orange: #f58220;   /* Màu cam */
  --color-lc-red: #e11b22;      /* Màu giá giảm */
  --color-lc-bg: #f0f2f5;       /* Nền xám nhạt */
}
```
Sau đó, bạn có thể thoải mái sử dụng các class Tailwind bình thường trên giao diện như: `bg-lc-blue`, `text-lc-orange`, `border-lc-red`, `bg-lc-bg`. Khi chạy `npm run build`, Vite sẽ tự biên dịch và nén chúng vào tệp `assets/dist/css/style.css`.

---

## 7. Hướng dẫn cài đặt và thiết lập Theme trên WordPress

Để cài đặt và cấu hình thành công theme **24hCoding** trên website WordPress của bạn, hãy làm theo các bước hướng dẫn chi tiết dưới đây:

### Bước 1: Chuẩn bị tệp cài đặt (Theme Package)
1. Hãy chắc chắn rằng bạn đã chạy biên dịch production assets ít nhất một lần để tạo thư mục `/assets/dist/`:
   ```bash
   npm run build
   ```
2. Nén toàn bộ thư mục theme `theme-ecommerce-store` thành tệp tin định dạng `.zip` (ví dụ: `theme-ecommerce-store.zip`). *Lưu ý: Bạn có thể loại bỏ thư mục `node_modules/` và tệp `package-lock.json` trước khi nén để giảm dung lượng file nén.*

### Bước 2: Tải lên và Kích hoạt Theme
1. Đăng nhập vào trang quản trị WordPress (Admin Dashboard).
2. Đi tới mục **Giao diện (Appearance)** -> **Giao diện (Themes)**.
3. Nhấp vào nút **Thêm mới (Add New)** ở phía trên, sau đó chọn **Tải giao diện lên (Upload Theme)**.
4. Chọn tệp nén `.zip` bạn vừa chuẩn bị ở Bước 1 và nhấn **Cài đặt ngay (Install Now)**.
5. Sau khi cài đặt hoàn tất, nhấp vào liên kết **Kích hoạt (Activate)** để bắt đầu sử dụng theme.

### Bước 3: Cấu hình Menu điều hướng (Navigation Menu)
1. Trong Admin Dashboard, đi tới **Giao diện (Appearance)** -> **Menu**.
2. Nhấp vào liên kết **Tạo menu mới (Create a new menu)**, đặt tên cho menu (ví dụ: *Primary Menu*) và thêm các liên kết trang bạn muốn hiển thị.
3. Ở cuối trang cấu hình menu, trong phần **Vị trí hiển thị (Display location)**, hãy tích chọn vào mục **Primary Menu (Header)**.
4. Nhấn **Lưu menu (Save Menu)**.

### Bước 4: Thiết lập các Trang WooCommerce chính (Nếu sử dụng WooCommerce)
Theme đã được thiết kế sẵn các Page Templates tùy biến gọn gàng để tối ưu trải nghiệm WooCommerce. Hãy gán các trang này trong trang quản trị:
1. Tạo 3 trang tĩnh mới lần lượt đặt tên: *Giỏ hàng (Cart)*, *Thanh toán (Checkout)*, *Tài khoản của tôi (My Account)*.
2. Tại cột bên phải cấu hình trang (Page Attributes -> Template), hãy chọn đúng mẫu giao diện tương ứng:
   * Trang Giỏ hàng -> Chọn template **Cart Page Template** (nhận từ file `theme-pages/page-cart.php`).
   * Trang Thanh toán -> Chọn template **Checkout Page Template** (nhận từ file `theme-pages/page-checkout.php`).
   * Trang Tài khoản -> Chọn template **My Account Page Template** (nhận từ file `theme-pages/page-my-account.php`).
3. Đi tới **WooCommerce** -> **Cài đặt (Settings)** -> Tab **Nâng cao (Advanced)**, chọn đúng các trang tĩnh bạn vừa tạo trên cho các mục tương ứng và nhấn Lưu.

---

## 8. Các kỹ thuật tối ưu hóa hiệu năng (Performance Optimizations)

Theme được tích hợp sẵn các kỹ thuật tối ưu hóa tải trang sâu trong nhân (core) giúp đạt điểm số xanh trên Google PageSpeed Insights (Lighthouse):

### 1. Tải trễ hình ảnh (Image Lazy Loading & Async Decoding)
* **Lazy Loading**: Hệ thống tự động lọc nội dung các bài viết, sản phẩm và áp thuộc tính `loading="lazy"` cho mọi thẻ `<img>`. Trình duyệt sẽ chỉ tải hình ảnh khi người dùng cuộn đến gần, tiết kiệm băng thông và tăng tốc FCP (First Contentful Paint).
* **Async Decoding**: Mọi hình ảnh đính kèm (WordPress Attachments) và hình ảnh chèn tay được gắn thêm thuộc tính `decoding="async"`. Trình duyệt sẽ xử lý giải mã hình ảnh bất đồng bộ ở luồng phụ (background thread) giúp luồng chính (main thread) không bị gián đoạn, tránh giật lag khi cuộn trang.

### 2. Tải bất đồng bộ JavaScript (Defer JavaScript)
* Bộ lọc `script_loader_tag` tự động chuyển đổi tất cả các thẻ script tải tài nguyên của theme, WooCommerce và các thư viện bên ngoài thành dạng `defer="defer"`.
* Điều này đảm bảo toàn bộ cấu trúc HTML được tải và hiển thị hoàn chỉnh trước khi JS được thực thi, cải thiện chỉ số **TBT (Total Blocking Time)** và **LCP (Largest Contentful Paint)**.

### 3. DNS Prefetch & Preconnect các tài nguyên ngoài
* Để giảm độ trễ DNS của các thư viện dùng chung, hệ thống tự động chèn các chỉ thị kết nối sớm (`preconnect` và `dns-prefetch`) cho các máy chủ lưu trữ font chữ và CDN phổ biến:
  * Google Fonts (`fonts.googleapis.com`, `fonts.gstatic.com`)
  * CDNs (`unpkg.com`)
* Trình duyệt sẽ thực hiện phân giải DNS và thiết lập bắt tay TLS với các server này trước khi tải file, giảm thời gian chờ tải tài nguyên bổ sung.
