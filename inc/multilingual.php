<?php
/**
 * Module: Multilingual System (Bilingual VI / EN)
 * Description: Hệ thống đa ngôn ngữ độc lập, hiệu năng cao cho On The Rock Cocktail Bar.
 * Quản lý ngôn ngữ qua Cookie & Query String (?lang=vi|en),
 * Cung cấp Meta Box song ngữ cho Bài viết/Trang trong WP Admin,
 * và Bộ chuyển đổi ngôn ngữ (Language Switcher) chuẩn Liquid Glass.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Khởi tạo & Xử lý Ngôn ngữ Hiện hành
 */
function otr_init_language() {
    $allowed_langs = array( 'vi', 'en' );
    $current_lang  = 'vi';

    // 1.1 Kiểm tra tham số trên URL (?lang=en hoặc ?lang=vi)
    if ( isset( $_GET['lang'] ) ) {
        $requested_lang = sanitize_text_field( strtolower( $_GET['lang'] ) );
        if ( in_array( $requested_lang, $allowed_langs, true ) ) {
            $current_lang = $requested_lang;
            // Lưu Cookie trong 30 ngày
            if ( ! headers_sent() ) {
                setcookie( 'otr_lang', $current_lang, time() + ( 30 * DAY_IN_SECONDS ), COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), false );
            }
            $_COOKIE['otr_lang'] = $current_lang;
        }
    } elseif ( isset( $_COOKIE['otr_lang'] ) ) {
        $cookie_lang = sanitize_text_field( strtolower( $_COOKIE['otr_lang'] ) );
        if ( in_array( $cookie_lang, $allowed_langs, true ) ) {
            $current_lang = $cookie_lang;
        }
    }

    $GLOBALS['otr_current_lang'] = $current_lang;
}
add_action( 'init', 'otr_init_language', 1 );

/**
 * 2. Các hàm Helper Ngôn ngữ Toàn cục
 */

/**
 * Lấy mã ngôn ngữ hiện tại ('vi' hoặc 'en')
 */
function otr_get_current_lang() {
    if ( isset( $_GET['lang'] ) && in_array( strtolower( $_GET['lang'] ), array( 'vi', 'en' ), true ) ) {
        return strtolower( $_GET['lang'] );
    }
    if ( isset( $GLOBALS['otr_current_lang'] ) ) {
        return $GLOBALS['otr_current_lang'];
    }
    if ( isset( $_COOKIE['otr_lang'] ) && in_array( $_COOKIE['otr_lang'], array( 'vi', 'en' ), true ) ) {
        return $_COOKIE['otr_lang'];
    }
    return 'vi';
}

function otr_set_current_lang( $lang ) {
    if ( in_array( $lang, array( 'vi', 'en' ), true ) ) {
        $GLOBALS['otr_current_lang'] = $lang;
        $_COOKIE['otr_lang'] = $lang;
    }
}

/**
 * Kiểm tra xem có đang ở chế độ Tiếng Anh hay không
 */
function otr_is_en() {
    return otr_get_current_lang() === 'en';
}

/**
 * Dịch nhanh chuỗi văn bản: trả về bản Tiếng Anh nếu đang chọn EN, ngược lại trả về Tiếng Việt
 */
function otr_t( $vi, $en = '' ) {
    if ( otr_is_en() && ! empty( $en ) ) {
        return $en;
    }
    return $vi;
}

/**
 * Từ điển các cụm từ chuẩn trên giao diện để tự động fallback sang English khi chưa nhập ACF _en
 */
function otr_translate_standard_string( $text ) {
    if ( ! is_string( $text ) || empty( $text ) ) {
        return $text;
    }

    static $dict = null;
    if ( $dict === null ) {
        $dict = array(
            'ĐẶT BÀN TRƯỚC' => 'RESERVATION',
            'XEM MENU' => 'VIEW MENU',
            'MENU' => 'MENU',
            'TRANG MENU' => 'MENU PAGE',
            'LIÊN HỆ' => 'CONTACT',
            'TRANG LIÊN HỆ' => 'CONTACT PAGE',
            'BÀI VIẾT' => 'BLOG',
            'DANH MỤC' => 'NAVIGATION',
            'MẠNG XÃ HỘI' => 'SOCIAL NETWORKS',
            'ĐẾN VÀ TRẢI NGHIỆM' => 'VISIT & EXPERIENCE',
            'THỨ HAI – CHỦ NHẬT' => 'MONDAY – SUNDAY',
            '18H30 – 2H' => '6:30 PM – 2:00 AM',
            'TẦNG HẦM 69' => 'BASEMENT 69',
            'TRƯƠNG CÔNG ĐỊNH, PHƯỜNG 01, ĐÀ LẠT' => 'TRUONG CONG DINH ST., WARD 01, DA LAT',
            'CẢM NHẬN TỪ KHÁCH HÀNG' => 'CUSTOMER REVIEWS',
            'THƯỞNG THỨC, LƯU LẠI KHOẢNH KHẮC' => 'SAVOR, CAPTURE THE MOMENT',
            'VÀ GẮN THẺ @ONTHEROCK.' => 'AND TAG @ONTHEROCK.',
            'MEET THE ON THE ROCK TEAM' => 'MEET THE ON THE ROCK TEAM',
            'Họ và tên' => 'Full Name',
            'Số điện thoại' => 'Phone Number',
            'Số lượng khách' => 'Number of Guests',
            'Ngày đặt bàn' => 'Reservation Date',
            'Khung giờ' => 'Time Slot',
            'Lời nhắn đặc biệt (nếu có)' => 'Special Requests (if any)',
            'XÁC NHẬN ĐẶT BÀN' => 'CONFIRM RESERVATION',
            'Đang xử lý...' => 'Processing...',
            'Chọn số lượng khách' => 'Select Number of Guests',
            'Đóng' => 'Close',
            'Xác nhận' => 'Confirm',
            'ĐẶT BÀN THÀNH CÔNG!' => 'RESERVATION SUCCESSFUL!',
            'XEM THÊM' => 'LOAD MORE',
            'Tất cả' => 'All',
            'Sự kiện' => 'Events',
            'Đọc tiếp' => 'Read more',
            'EVENT VÀ BÀI VIẾT KHÁC' => 'OTHER EVENTS & ARTICLES',
            'CHIA SẺ BÀI VIẾT' => 'SHARE ARTICLE',
            'SAO CHÉP LIÊN KẾT' => 'COPY LINK',
            'ĐÃ SAO CHÉP!' => 'COPIED!',
        );
    }

    $trimmed = trim( $text );
    if ( isset( $dict[ $trimmed ] ) ) {
        return $dict[ $trimmed ];
    }

    if ( strpos( $trimmed, 'Một quán cocktail bar ở Đà Lạt' ) !== false ) {
        return "A cocktail bar in Da Lat,\ncrafted by locals, for those seeking\nan authentic Da Lat experience.";
    }

    return $text;
}

/**
 * Lấy giá trị trường ACF hoặc Option hỗ trợ tự động tìm trường _en khi bật English
 */
function otr_get_field( $selector, $post_id = false, $default = '' ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $val = function_exists( 'get_field' ) ? get_field( $selector, $post_id ) : '';

    if ( otr_is_en() ) {
        // 1. Kiểm tra trường _en trong ACF (nếu người dùng đã nhập bản dịch riêng)
        $val_en = function_exists( 'get_field' ) ? get_field( $selector . '_en', $post_id ) : '';
        if ( ! empty( $val_en ) ) {
            return $val_en;
        }

        // 2. Nếu $default truyền vào là bản dịch chuyên biệt (hoặc khác với giá trị tiếng Việt hiện tại)
        if ( ! empty( $default ) && ( empty( $val ) || $default !== $val ) ) {
            return $default;
        }

        // 3. Tự động dịch các chuỗi mẫu chuẩn trong hệ thống nếu chưa có ACF _en
        if ( ! empty( $val ) && is_string( $val ) ) {
            $translated = otr_translate_standard_string( $val );
            if ( $translated !== $val ) {
                return $translated;
            }
        }
    }

    if ( ! empty( $val ) ) {
        return $val;
    }

    return $default;
}

/**
 * Lấy dữ liệu Menu TheRocks hỗ trợ song ngữ
 */
function otr_t_menu( $item, $field = 'title', $default = '' ) {
    if ( ! is_array( $item ) ) {
        return $default;
    }

    if ( otr_is_en() ) {
        $field_en = $field . '_en';
        if ( ! empty( $item[ $field_en ] ) ) {
            return $item[ $field_en ];
        }
    }

    if ( ! empty( $item[ $field ] ) ) {
        return $item[ $field ];
    }

    return $default;
}

/**
 * Tạo URL chuyển đổi ngôn ngữ giữ nguyên toàn bộ query param và URL hiện tại
 */
function otr_get_lang_switch_url( $lang ) {
    $current_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
    
    // Giữ lại các query parameters hiện có
    if ( ! empty( $_GET ) ) {
        $query_params = $_GET;
        $query_params['lang'] = $lang;
        return add_query_arg( $query_params, $current_url );
    }

    return add_query_arg( 'lang', $lang, $current_url );
}

/**
 * 3. Component Language Switcher UI [ VI | EN ]
 */
function otr_language_switcher( $custom_class = '' ) {
    $current = otr_get_current_lang();
    $vi_url  = esc_url( otr_get_lang_switch_url( 'vi' ) );
    $en_url  = esc_url( otr_get_lang_switch_url( 'en' ) );

    $vi_active = ( $current === 'vi' ) ? 'is-active text-[#18110a] bg-[#caa875] font-bold shadow-sm' : 'text-[#caa875]/70 hover:text-[#caa875]';
    $en_active = ( $current === 'en' ) ? 'is-active text-[#18110a] bg-[#caa875] font-bold shadow-sm' : 'text-[#caa875]/70 hover:text-[#caa875]';

    ob_start();
    ?>
    <div class="otr-lang-switcher inline-flex items-center rounded-full p-0.5 border border-[#caa875]/35 bg-[#120d09]/90 backdrop-blur-md select-none transition-all duration-300 hover:border-[#caa875]/70 <?php echo esc_attr( $custom_class ); ?>">
        <a 
            href="<?php echo $vi_url; ?>" 
            class="lang-btn otr-lang-switcher__item px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-sans tracking-wider rounded-full transition-all duration-300 inline-block leading-none <?php echo $vi_active; ?>"
            title="Chuyển sang Tiếng Việt"
            aria-label="Tiếng Việt"
        >
            VI
        </a>
        <a 
            href="<?php echo $en_url; ?>" 
            class="lang-btn otr-lang-switcher__item px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-sans tracking-wider rounded-full transition-all duration-300 inline-block leading-none <?php echo $en_active; ?>"
            title="Switch to English"
            aria-label="English"
        >
            EN
        </a>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 3.1 Component Language Dropdown UI [ VN ⌵ ]
 * Thiết kế chuẩn mockup: Nút chữ VN/EN kèm mũi tên chevron down, mở menu thả xuống sang trọng phong cách Liquid Glass
 */
function otr_language_dropdown( $custom_class = '' ) {
    $current = otr_get_current_lang();
    $current_label = ( $current === 'en' ) ? 'EN' : 'VN';
    $vi_url  = esc_url( otr_get_lang_switch_url( 'vi' ) );
    $en_url  = esc_url( otr_get_lang_switch_url( 'en' ) );

    ob_start();
    ?>
    <div class="otr-lang-dropdown relative inline-block text-left select-none <?php echo esc_attr( $custom_class ); ?>">
        <button 
            type="button" 
            class="otr-lang-dropdown__btn inline-flex items-center gap-1.5 py-1.5 px-2 rounded-lg text-xs md:text-[13px] font-sans font-medium tracking-[0.14em] text-[#caa875] hover:text-[#f7ebd8] transition-colors focus:outline-none cursor-pointer" 
            aria-expanded="false" 
            aria-haspopup="true"
        >
            <span class="otr-current-lang-code font-semibold tracking-wider"><?php echo esc_html( $current_label ); ?></span>
            <svg class="w-3 h-3 transition-transform duration-300 transform otr-dropdown-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div class="otr-lang-dropdown__menu hidden absolute right-0 mt-1 min-w-[100px] rounded-xl bg-[#160f0a]/98 backdrop-blur-2xl border border-[#caa875]/35 shadow-[0_15px_35px_rgba(0,0,0,0.85)] py-1.5 z-[99999] overflow-hidden">
            <a 
                href="<?php echo $vi_url; ?>" 
                class="flex items-center justify-between px-3.5 py-2 text-xs font-sans tracking-wider transition-all duration-200 <?php echo ( $current === 'vi' ) ? 'text-[#caa875] font-bold bg-[#caa875]/15' : 'text-[#caa875]/75 hover:text-[#f7ebd8] hover:bg-[#caa875]/10'; ?>"
            >
                <span>VN</span>
                <?php if ( $current === 'vi' ): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#caa875] shadow-[0_0_6px_#caa875]"></span>
                <?php endif; ?>
            </a>
            <a 
                href="<?php echo $en_url; ?>" 
                class="flex items-center justify-between px-3.5 py-2 text-xs font-sans tracking-wider transition-all duration-200 <?php echo ( $current === 'en' ) ? 'text-[#caa875] font-bold bg-[#caa875]/15' : 'text-[#caa875]/75 hover:text-[#f7ebd8] hover:bg-[#caa875]/10'; ?>"
            >
                <span>EN</span>
                <?php if ( $current === 'en' ): ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#caa875] shadow-[0_0_6px_#caa875]"></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 4. Quản lý Meta Box Dịch Tiếng Anh cho Bài Viết (Blog Post) & Trang Tĩnh (Page)
 */
add_action( 'add_meta_boxes', 'otr_register_multilingual_metabox' );
function otr_register_multilingual_metabox() {
    $screens = array( 'post', 'page' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'otr_multilingual_box',
            '🌐 Bản Dịch Tiếng Anh / English Version (Bilingual Content)',
            'otr_render_multilingual_metabox',
            $screen,
            'normal',
            'high'
        );
    }
}

/**
 * Render Giao Diện Tab Song Ngữ Trong Admin WordPress
 */
function otr_render_multilingual_metabox( $post ) {
    wp_nonce_field( 'otr_save_multilingual_meta', 'otr_multilingual_nonce' );

    $title_en   = get_post_meta( $post->ID, '_otr_title_en', true );
    $excerpt_en = get_post_meta( $post->ID, '_otr_excerpt_en', true );
    $content_en = get_post_meta( $post->ID, '_otr_content_en', true );
    ?>
    <div class="otr-bilingual-admin-box" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <!-- Thanh điều hướng Tab trực quan -->
        <div style="display: flex; gap: 8px; border-bottom: 2px solid #caa875; padding-bottom: 8px; margin-bottom: 16px;">
            <button type="button" onclick="otrAdminSwitchLangTab('tab_en')" id="btn_tab_en" class="button button-primary" style="background: #caa875; border-color: #b8935c; color: #18110b; font-weight: bold;">
                🇬🇧 Nội dung Tiếng Anh (English Content)
            </button>
            <button type="button" onclick="otrAdminSwitchLangTab('tab_vi_notice')" id="btn_tab_vi_notice" class="button" style="font-weight: 600;">
                🇻🇳 Tiếng Việt (Nhập tại giao diện chuẩn WP)
            </button>
        </div>

        <!-- Khung Tab Tiếng Anh -->
        <div id="otr_admin_tab_en" style="display: block;">
            <div style="background: #fffdf9; border: 1px solid #e2d3be; border-radius: 8px; padding: 16px 20px; margin-bottom: 18px;">
                <div style="font-size: 13px; color: #735427; margin-bottom: 14px; font-style: italic;">
                    ✦ Nhập bản dịch tiếng Anh bên dưới. Khi khách hàng bấm chọn [EN] ngoài website, hệ thống sẽ tự động hiển thị các nội dung này thay thế cho bản tiếng Việt.
                </div>

                <!-- 1. Tiêu đề Tiếng Anh -->
                <div style="margin-bottom: 16px;">
                    <label for="otr_title_en" style="display: block; font-weight: 700; color: #18110b; font-size: 13px; margin-bottom: 6px;">
                        Tiêu đề Tiếng Anh (English Title):
                    </label>
                    <input 
                        type="text" 
                        id="otr_title_en" 
                        name="otr_title_en" 
                        value="<?php echo esc_attr( $title_en ); ?>" 
                        class="widefat" 
                        placeholder="Enter English Title here..." 
                        style="padding: 8px 12px; font-size: 15px; border-radius: 4px; border: 1px solid #ccd0d4;"
                    >
                </div>

                <!-- 2. Tóm tắt Tiếng Anh -->
                <div style="margin-bottom: 18px;">
                    <label for="otr_excerpt_en" style="display: block; font-weight: 700; color: #18110b; font-size: 13px; margin-bottom: 6px;">
                        Tóm tắt ngắn Tiếng Anh (English Excerpt):
                    </label>
                    <textarea 
                        id="otr_excerpt_en" 
                        name="otr_excerpt_en" 
                        rows="3" 
                        class="widefat" 
                        placeholder="Brief summary in English for blog cards & search results..." 
                        style="padding: 8px 12px; font-size: 13px; border-radius: 4px; border: 1px solid #ccd0d4;"
                    ><?php echo esc_textarea( $excerpt_en ); ?></textarea>
                </div>

                <!-- 3. Nội dung Tiếng Anh với Trình soạn thảo WYSIWYG -->
                <div>
                    <label style="display: block; font-weight: 700; color: #18110b; font-size: 13px; margin-bottom: 6px;">
                        Nội dung chi tiết Tiếng Anh (English Full Content):
                    </label>
                    <?php
                    $editor_settings = array(
                        'textarea_name' => 'otr_content_en',
                        'textarea_rows' => 12,
                        'media_buttons' => true,
                        'teeny'         => false,
                        'quicktags'     => true,
                    );
                    wp_editor( $content_en, 'otr_content_en', $editor_settings );
                    ?>
                </div>
            </div>
        </div>

        <!-- Khung Tab Thông Báo Tiếng Việt -->
        <div id="otr_admin_tab_vi_notice" style="display: none; background: #f0f6fc; border-left: 4px solid #2271b1; padding: 14px 18px; border-radius: 4px;">
            <h4 style="margin: 0 0 8px; color: #1d2327;">🇻🇳 Hướng dẫn quản trị Tiếng Việt:</h4>
            <p style="margin: 0; color: #50575e; font-size: 13px; line-height: 1.6;">
                Nội dung <strong>Tiếng Việt</strong> mặc định vẫn được soạn thảo trực tiếp ở các ô <strong>Tiêu đề</strong>, <strong>Nội dung bài viết</strong> và <strong>Tóm tắt</strong> chuẩn của WordPress ở phía trên màn hình. Bạn không cần nhập thêm bất cứ ô nào khác!
            </p>
        </div>
    </div>

    <script>
    function otrAdminSwitchLangTab(tab) {
        var tabEn = document.getElementById('otr_admin_tab_en');
        var tabVi = document.getElementById('otr_admin_tab_vi_notice');
        var btnEn = document.getElementById('btn_tab_en');
        var btnVi = document.getElementById('btn_tab_vi_notice');

        if (tab === 'tab_en') {
            tabEn.style.display = 'block';
            tabVi.style.display = 'none';
            btnEn.className = 'button button-primary';
            btnEn.style.background = '#caa875';
            btnEn.style.borderColor = '#b8935c';
            btnEn.style.color = '#18110b';
            btnVi.className = 'button';
            btnVi.style.background = '';
            btnVi.style.color = '';
        } else {
            tabEn.style.display = 'none';
            tabVi.style.display = 'block';
            btnVi.className = 'button button-primary';
            btnVi.style.background = '#2271b1';
            btnVi.style.borderColor = '#135e96';
            btnVi.style.color = '#fff';
            btnEn.className = 'button';
            btnEn.style.background = '';
            btnEn.style.color = '';
        }
    }
    </script>
    <?php
}

/**
 * 5. Lưu dữ liệu Bản Dịch Tiếng Anh khi Update Post / Page
 */
add_action( 'save_post', 'otr_save_multilingual_meta' );
function otr_save_multilingual_meta( $post_id ) {
    if ( ! isset( $_POST['otr_multilingual_nonce'] ) || ! wp_verify_nonce( $_POST['otr_multilingual_nonce'], 'otr_save_multilingual_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Lưu Tiêu đề Tiếng Anh
    if ( isset( $_POST['otr_title_en'] ) ) {
        update_post_meta( $post_id, '_otr_title_en', sanitize_text_field( $_POST['otr_title_en'] ) );
    }

    // Lưu Tóm tắt Tiếng Anh
    if ( isset( $_POST['otr_excerpt_en'] ) ) {
        update_post_meta( $post_id, '_otr_excerpt_en', sanitize_textarea_field( $_POST['otr_excerpt_en'] ) );
    }

    // Lưu Nội dung chi tiết Tiếng Anh (cho phép thẻ HTML phong phú)
    if ( isset( $_POST['otr_content_en'] ) ) {
        update_post_meta( $post_id, '_otr_content_en', wp_kses_post( $_POST['otr_content_en'] ) );
    }
}

/**
 * 6. Bộ lọc Tự Động Phía Frontend (Filters)
 * Khi khách hàng đang duyệt ngôn ngữ EN, tự động ưu tiên hiển thị bản dịch
 */

// 6.1 Lọc Tiêu đề
add_filter( 'the_title', function ( $title, $id = null ) {
    if ( is_admin() || ! otr_is_en() || ! $id ) {
        return $title;
    }
    $title_en = get_post_meta( $id, '_otr_title_en', true );
    if ( ! empty( $title_en ) ) {
        return $title_en;
    }
    return $title;
}, 10, 2 );

// 6.2 Lọc Tóm tắt bài viết
add_filter( 'get_the_excerpt', function ( $excerpt, $post = null ) {
    if ( is_admin() || ! otr_is_en() ) {
        return $excerpt;
    }
    $post_id = $post ? $post->ID : get_the_ID();
    if ( $post_id ) {
        $excerpt_en = get_post_meta( $post_id, '_otr_excerpt_en', true );
        if ( ! empty( $excerpt_en ) ) {
            return $excerpt_en;
        }
    }
    return $excerpt;
}, 10, 2 );

// 6.3 Lọc Nội dung bài viết
add_filter( 'the_content', function ( $content ) {
    if ( is_admin() || ! otr_is_en() ) {
        return $content;
    }
    $post_id = get_the_ID();
    if ( $post_id ) {
        $content_en = get_post_meta( $post_id, '_otr_content_en', true );
        if ( ! empty( $content_en ) ) {
            return $content_en;
        }
    }
    return $content;
}, 10 );
