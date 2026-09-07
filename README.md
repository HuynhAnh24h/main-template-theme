# On The Rock — Luxury Cocktail Bar & Lounge WordPress Theme

Mã nguồn theme WordPress cao cấp dành riêng cho **On The Rock Cocktail Bar & Lounge**. Thiết kế theo phong cách sang trọng **Noir & Champagne Gold**, tối ưu hóa trải nghiệm thị giác với hiệu ứng chuyển động mượt mà, bộ công cụ build siêu tốc **Vite**, **Tailwind CSS v4**, hệ thống quản lý thực đơn đa tầng **Menu TheRocks**, tính năng đặt bàn trực tuyến gửi email chuẩn bảo mật cao và tích hợp bộ font chữ đặc trưng **MRCH-NewYork** & **SVN-Gilroy**.

---

## 1. Hướng Dẫn Sử Dụng Font Chữ Mới (Custom Typography)

Theme đã được tích hợp sẵn 2 bộ font chữ chuẩn định dạng vector sắc nét, hỗ trợ tiếng Việt đầy đủ. Các tệp font được lưu trữ tại `assets/fonts/` và tự động tối ưu hóa khi build qua Vite.

### A. Danh Sách Các Class CSS Sẵn Có

| Tên Class CSS | Độ dày (Font Weight) | Kiểu chữ & Đặc điểm | Vị trí khuyên dùng |
| :--- | :---: | :--- | :--- |
| **`.MRCH-NewYork`** *(hoặc `.mrch-newyork`)* | **400 (Regular)** | Font nghệ thuật Serif cổ điển sang trọng, các nét uốn lượn phong cách Editorial | Tiêu đề lớn, Tên quán, Tên dòng Signature Cocktails |
| **`.SVN-Gilroy-Light`** *(hoặc `.SVN-Gilroy`)* | **300 (Light)** | Nét mảnh thanh lịch, hiện đại, hỗ trợ tiếng Việt có dấu đầy đủ | Đoạn văn mô tả, thực đơn, lời giới thiệu |
| **`.SVN-Gilroy-Medium`** | **500 (Medium)** | Nét vừa vặn, độ tương phản cao, dễ đọc trên di động | Nhãn thông tin, thành phần cocktail |
| **`.SVN-Gilroy-SemiBold`** | **600 (SemiBold)** | Nét đậm vừa tinh tế | Tiêu đề danh mục, nút bấm, giá tiền |
| **`.SVN-Gilroy-Bold`** | **800 (Heavy)** | Nét đậm dày ấn tượng, dứt khoát | Tiêu đề phụ, số thứ tự, nút hành động chính |

> **Mẹo hữu ích**: Nếu bạn vô tình viết có dấu cách như `class="SVN-Gilroy Light"`, hệ thống đã hỗ trợ sẵn class `.SVN-Gilroy` nên chữ vẫn nhận đúng font!

### B. Cách Sử Dụng Trong HTML / PHP

Chỉ cần gán class tương ứng vào bất kỳ thẻ HTML nào:

```html
<!-- Sử dụng font nghệ thuật MRCH-NewYork cho tiêu đề -->
<h1 class="MRCH-NewYork text-4xl text-[#caa875] tracking-wide">
    ON THE ROCKS COCKTAIL BAR
</h1>

<!-- Sử dụng font SVN-Gilroy Light (nét mảnh) cho đoạn văn -->
<p class="SVN-Gilroy-Light text-sm text-[#caa875]/80 leading-relaxed">
    Thưởng thức những ly cocktail thủ công trong không gian ấm cúng và đầy cảm hứng.
</p>

<!-- Sử dụng font SVN-Gilroy SemiBold cho giá tiền hoặc nút bấm -->
<span class="SVN-Gilroy-SemiBold text-lg text-[#caa875]">320.000đ</span>
```

### C. Sử Dụng Qua Tailwind CSS v4

Theme cũng đã đăng ký biến font trong `@theme` tại `src/css/main.css`:
* `font-mrch`: Áp dụng font MRCH-NewYork (`--font-mrch`)
* `font-gilroy`: Áp dụng họ font SVN-Gilroy (`--font-gilroy`)

---

## 2. Cấu Trúc Thư Mục (Directory Structure)

```text
on-the-rock-theme/
├── assets/                       # Thư mục tài nguyên tĩnh
│   ├── dist/                     # [TỰ ĐỘNG SINH BỞI VITE] Chứa CSS, JS & Fonts đã biên dịch
│   │   ├── assets/               # Các tệp font đã được Vite hash và đóng gói
│   │   ├── css/style.css         # CSS nén cuối cùng
│   │   └── js/                   # JS riêng biệt cho từng trang
│   ├── fonts/                    # Nguồn font gốc (MRCH-NewYork.ttf, SVN-Gilroy bộ các độ dày)
│   ├── icons/                    # Icon SVG hệ thống
│   └── images/                   # Hình ảnh tĩnh và icon email Retina PNG
│
├── inc/                          # Module tính năng mở rộng của Theme
│   ├── admin-menu-therocks.php   # Quản trị Menu TheRocks: 4 bước hướng dẫn, WP Media, Demo 3 kiểu
│   ├── cpt-booking.php           # CPT Đặt Bàn, Mailer thông báo khách đặt, template thiệp VIP
│   └── smtp-mailer.php           # Cấu hình SMTP gửi mail thực tế qua Gmail/Hosting
│
├── src/                          # THƯ MỤC MÃ NGUỒN CHƯA BIÊN DỊCH (DEVELOPMENT)
│   ├── css/main.css              # File CSS nguồn: @font-face, Tailwind v4, Liquid Glass, Slider CSS
│   └── js/                       # Mã nguồn JavaScript (ES Modules)
│       ├── main.js               # Khởi tạo toàn cục, Header scroll, Liquid Glass
│       └── pages/
│           ├── home.js           # Xử lý Wander Loader, Parallax, Testimonials
│           ├── menu.js           # Xử lý Accordion, Tabs, Slider ảnh Kiểu 1, Sticky Sidebar Kiểu 2
│           └── booking.js        # Xử lý tương tác form đặt bàn trực tuyến & AJAX
│
├── template-parts/               # Các phân đoạn giao diện PHP tái sử dụng
│   ├── components/               # Header, Footer, Nút bấm
│   │   ├── site-header.php       # Thanh điều hướng cố định kính mờ (Liquid Glass)
│   │   ├── site-footer.php       # Chân trang sang trọng
│   │   └── button.php            # Nút bấm hiệu ứng kính lỏng
│   └── sections/
│       ├── home/                 # Các khối Trang Chủ (Hero, Wander Loading, Moments, Team, Testimonials)
│       ├── menu/                 # Các khối Trang Menu
│       │   ├── section-menu-page.php     # Hero 2 ảnh & Accordion danh mục
│       │   ├── layout-1-showcase.php     # Kiểu 1: Showcase Card, Nốt vị, Nền rượu & Slider ảnh
│       │   ├── layout-2-sidebar.php      # Kiểu 2: Sticky Sidebar bám theo màn hình
│       │   └── layout-3-columns.php      # Kiểu 3: Danh sách cột theo dòng rượu Classic
│       └── booking/              # Form đặt bàn và không gian Lounge
│
├── theme-pages/                  # Page Templates WordPress
│   ├── front-page.php            # Template Trang Chủ chính thức
│   ├── page-menu.php             # Template Trang Thực Đơn
│   ├── page-booking.php          # Template Trang Đặt Bàn
│   ├── page-contact.php          # Template Trang Liên Hệ
│   └── 404.php                   # Trang thông báo 404
│
├── screenshot.png                # Ảnh đại diện chính thức của theme trong WP Admin (1200x900)
├── screenshot.jpg                # Phiên bản JPG dự phòng
├── functions.php                 # Enqueue scripts/styles, Theme support, Auto Module Loader
├── style.css                     # Metadata khai báo theme On The Rock
├── vite.config.js                # Cấu hình Vite với base: './'
└── watcher.js                    # File watcher cho môi trường Windows
```

---

## 3. Các Tính Năng Nổi Bật Của Theme

### A. Hệ Thống Quản Lý Thực Đơn "Menu TheRocks" (`inc/admin-menu-therocks.php`)
* **Cấu trúc 3 cấp linh hoạt**: Menu Cha (Level 1) &rarr; Menu Con (Level 2) &rarr; Món ăn/Đồ uống (Level 3).
* **Tích hợp WordPress Media Library**: Nút *Chọn từ Thư viện Media* có sẵn cho cả Menu Cha, Menu Con và từng Món, hỗ trợ chọn ảnh trực quan hoặc tải lên từ máy tính.
* **Trình xem Demo 3 Kiểu trực quan**: Xem trước wireframe đồ họa mô phỏng thực tế của cả 3 kiểu hiển thị:
  * **Kiểu 1**: Showcase Card & Slider Ảnh lớn (Cocktail Signature).
  * **Kiểu 2**: Sticky Sidebar bám dính khi cuộn trang (Menu nhiều nhóm món).
  * **Kiểu 3**: Danh sách cột chia theo dòng rượu Classic (Bảng giá rượu vang/spirits).
* **Auto-Select thông minh**: Bấm chọn kiểu ngay trong Modal Demo sẽ tự động điền vào form đang mở và phát sáng viền vàng xác nhận.

### B. Hệ Thống Đặt Bàn & Gửi Email Chuẩn VIP Lounge (`inc/cpt-booking.php`)
* **CPT Đặt Bàn**: Quản lý toàn bộ danh sách khách đặt bàn, trạng thái *Chờ duyệt / Đã xác nhận / Hoàn thành / Hủy*.
* **Bảo vệ toàn vẹn dữ liệu**: Vô hiệu hóa tính năng tạo đơn thủ công trong admin (`create_posts => do_not_allow`), đảm bảo 100% đơn đặt đều đến từ khách hàng thật ngoài website.
* **Email Thông Báo Tức Thì (SMTP)**:
  * Phối màu **Noir & Champagne Gold** cao cấp như một bức thiệp mời VIP.
  * **Khắc phục triệt để lỗi ô vuông rỗng `□`**: Sử dụng icon PNG Retina độ phân giải cao (`assets/images/email-icons/`), tương thích 100% với Gmail, Outlook, Apple Mail.
  * Tích hợp nút **Gọi cho khách ngay** và nút **Xem trong Dashboard** tiện dụng.

### C. Trình Diễn Slider Ảnh Cocktail Khổ Lớn (Layout 1)
* Hai nút điều hướng **Prev (`<`)** và **Next (`>`)** căn giữa hoàn hảo theo chiều dọc (`top: 50%`, `transform: translateY(-50%)`).
* Thiết kế nút tròn kính đen mờ `44px x 44px` viền vàng sâm panh, hiệu ứng hover phóng to phát sáng êm dịu.
* Thanh **Dots capsule chỉ báo vị trí ảnh** ở góc dưới.
* Hỗ trợ **cảm ứng vuốt (Swipe Touch)** trên màn hình điện thoại.

---

## 4. Quy Trình Khởi Chạy & Biên Dịch (Workflow)

Yêu cầu môi trường: **Node.js v18+** (Khuyên dùng Node v20 trở lên) và **XAMPP / LocalWP**.

### Bước 1: Cài đặt thư viện
```bash
npm install
```

### Bước 2: Chạy chế độ Watch khi lập trình (Development)
```bash
npm run watch
# Hoặc: npm run dev
```

### Bước 3: Biên dịch sản phẩm (Production Build)
```bash
npm run build
```
*Vite sẽ tự động tối ưu hóa CSS, đóng gói JavaScript theo trang và đưa toàn bộ font vào thư mục `assets/dist/`.*

---

## 5. Tối Ưu Hóa Hiệu Năng & SEO
1. **Font Display Swap**: Mọi font chữ tùy biến đều sử dụng `font-display: swap` để tránh hiện tượng chặn hiển thị văn bản (FOIT).
2. **ES Modules & Asynchronous Loading**: Toàn bộ script theme được tải với thuộc tính `type="module"` và `defer="defer"`, không gây nghẽn tiến trình phân tích HTML.
3. **Lazy Loading & Async Image Decoding**: Mọi ảnh hiển thị trên website đều tự động được bổ sung thuộc tính `loading="lazy"` và `decoding="async"`.

---

© Bản quyền giao diện thuộc về **On The Rock Cocktail Bar & Lounge** — Được xây dựng và phát triển bởi **Huỳnh Anh**.