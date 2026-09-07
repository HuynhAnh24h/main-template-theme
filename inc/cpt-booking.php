<?php
/**
 * Custom Post Type: Bookings (Đặt Bàn) & Email Notification System
 * Description: Quản lý danh sách đặt bàn tại On The Rock Bar trong WordPress Dashboard,
 * xử lý gửi form AJAX và gửi email thông báo với template HTML sang trọng tới toàn bộ danh sách email người nhận qua SMTP xác thực.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 0. Nạp bộ gửi thư SMTP chuyên nghiệp
require_once get_template_directory() . '/inc/smtp-mailer.php';

/**
 * 1. Đăng ký Custom Post Type 'otr_booking'
 */
function otr_register_booking_cpt() {
    $labels = array(
        'name'               => 'Đặt Bàn',
        'singular_name'      => 'Đơn Đặt Bàn',
        'menu_name'          => 'Đặt Bàn',
        'all_items'          => 'Tất cả đơn đặt bàn',
        'edit_item'          => 'Chi tiết đơn đặt bàn',
        'view_item'          => 'Xem đơn đặt bàn',
        'search_items'       => 'Tìm kiếm đơn đặt bàn',
        'not_found'          => 'Không có đơn đặt bàn nào',
        'not_found_in_trash' => 'Không có đơn nào trong thùng rác',
    );

    register_post_type('otr_booking', array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'capabilities'       => array(
            'create_posts'   => 'do_not_allow', // Vô hiệu hóa nút tạo đơn mới thủ công trong Admin
        ),
        'map_meta_cap'       => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title'),
    ));
}
add_action('init', 'otr_register_booking_cpt');

/**
 * Xóa bỏ hoàn toàn liên kết "Thêm đơn mới" và chặn truy cập trang tạo đơn thủ công
 */
add_action('admin_menu', function() {
    remove_submenu_page('edit.php?post_type=otr_booking', 'post-new.php?post_type=otr_booking');
}, 999);

add_action('load-post-new.php', function() {
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'otr_booking') {
        wp_die('Tính năng thêm đơn đặt bàn mới thủ công trong trang quản trị đã được tắt. Mọi đơn đặt bàn sẽ được khách hàng gửi tự động từ giao diện website.');
    }
});

add_action('admin_head-edit.php', function() {
    global $typenow;
    if ($typenow === 'otr_booking') {
        echo '<style>.page-title-action, .wrap > a.page-title-action { display: none !important; }</style>';
    }
});

/**
 * 2. Tùy biến cột hiển thị trong danh sách Đặt Bàn (Dashboard Columns) - Dùng hoàn toàn Dashicons chuẩn
 */
function otr_booking_columns($columns) {
    return array(
        'cb'             => $columns['cb'],
        'title'          => 'Mã Đơn / Khách Hàng',
        'phone'          => 'Số Điện Thoại',
        'guests'         => 'Số Khách',
        'booking_time'   => 'Ngày & Giờ Đặt',
        'status'         => 'Trạng Thái',
        'email_status'   => 'Email Thông Báo',
        'message'        => 'Lời Nhắn',
        'date'           => 'Thời Gian Gửi',
    );
}
add_filter('manage_otr_booking_posts_columns', 'otr_booking_columns');

function otr_booking_custom_column($column, $post_id) {
    switch ($column) {
        case 'phone':
            $phone = get_post_meta($post_id, 'booking_phone', true);
            if ($phone) {
                echo '<a href="tel:' . esc_attr($phone) . '" style="font-weight:600; color:#2271b1; text-decoration:none; display:inline-flex; align-items:center; gap:3px;"><span class="dashicons dashicons-phone" style="font-size:15px; width:15px; height:15px;"></span> ' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;

        case 'guests':
            $guests = get_post_meta($post_id, 'booking_guests', true) ?: '2 khách';
            echo '<span style="display:inline-block; padding:3px 8px; background:#f0f0f1; border-radius:12px; font-weight:600; font-size:12px; color:#1d2327;">' . esc_html($guests) . '</span>';
            break;

        case 'booking_time':
            $date = get_post_meta($post_id, 'booking_date', true) ?: '—';
            $time = get_post_meta($post_id, 'booking_time', true) ?: '—';
            echo '<div style="font-weight:600; color:#1d2327;">' . esc_html($date) . '</div>';
            echo '<span style="display:inline-block; margin-top:3px; padding:2px 8px; background:#caa875; color:#140e08; font-weight:700; border-radius:4px; font-size:11px;">' . esc_html($time) . '</span>';
            break;

        case 'status':
            $status = get_post_meta($post_id, 'booking_status', true) ?: 'pending';
            if ($status === 'confirmed') {
                echo '<span style="background:#e6f4ea; color:#137333; font-weight:600; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-flex; align-items:center; gap:3px;"><span class="dashicons dashicons-yes-alt" style="font-size:14px; width:14px; height:14px;"></span> Đã xác nhận</span>';
            } elseif ($status === 'cancelled') {
                echo '<span style="background:#fce8e6; color:#c5221f; font-weight:600; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-flex; align-items:center; gap:3px;"><span class="dashicons dashicons-dismiss" style="font-size:14px; width:14px; height:14px;"></span> Đã hủy</span>';
            } else {
                echo '<span style="background:#fef7e0; color:#b06000; font-weight:600; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-flex; align-items:center; gap:3px;"><span class="dashicons dashicons-clock" style="font-size:14px; width:14px; height:14px;"></span> Chờ xác nhận</span>';
            }
            break;

        case 'email_status':
            $sent = get_post_meta($post_id, '_booking_email_sent', true);
            $time = get_post_meta($post_id, '_booking_email_time', true);
            if ($sent === '1') {
                echo '<span style="background:#e6f4ea; color:#137333; font-weight:600; padding:3px 8px; border-radius:12px; font-size:11px; display:inline-flex; align-items:center; gap:3px;"><span class="dashicons dashicons-yes-alt" style="font-size:14px; width:14px; height:14px;"></span> Đã gửi mail</span>';
                if ($time) {
                    $ts = strtotime($time);
                    if ($ts) {
                        echo '<div style="font-size:10px; color:#646970; margin-top:2px;">' . esc_html(wp_date('H:i - d/m', $ts)) . '</div>';
                    }
                }
            } else {
                $err = get_post_meta($post_id, '_booking_email_error', true);
                echo '<span style="background:#fce8e6; color:#c5221f; font-weight:600; padding:3px 8px; border-radius:12px; font-size:11px; display:inline-flex; align-items:center; gap:3px;" title="' . esc_attr($err) . '"><span class="dashicons dashicons-warning" style="font-size:14px; width:14px; height:14px;"></span> Chưa gửi</span>';
            }
            break;

        case 'message':
            $msg = get_post_meta($post_id, 'booking_message', true);
            if ($msg) {
                echo '<span title="' . esc_attr($msg) . '" style="color:#2c3338;">' . esc_html(wp_trim_words($msg, 7, '...')) . '</span>';
            } else {
                echo '<span style="color:#a7aaad;">Không có lời nhắn</span>';
            }
            break;
    }
}
add_action('manage_otr_booking_posts_custom_column', 'otr_booking_custom_column', 10, 2);

/**
 * 3. Hộp thông tin chi tiết & Đổi trạng thái trong màn hình sửa Đơn đặt bàn (Metabox)
 */
function otr_booking_meta_box() {
    add_meta_box(
        'otr_booking_details_box',
        'Thông Tin Chi Tiết Đặt Bàn & Trạng Thái',
        'otr_booking_details_callback',
        'otr_booking',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'otr_booking_meta_box');

function otr_booking_details_callback($post) {
    wp_nonce_field('otr_save_booking_meta', 'otr_booking_nonce');

    $name       = get_post_meta($post->ID, 'booking_name', true) ?: $post->post_title;
    $phone      = get_post_meta($post->ID, 'booking_phone', true);
    $guests     = get_post_meta($post->ID, 'booking_guests', true);
    $date       = get_post_meta($post->ID, 'booking_date', true);
    $time       = get_post_meta($post->ID, 'booking_time', true);
    $msg        = get_post_meta($post->ID, 'booking_message', true);
    $status     = get_post_meta($post->ID, 'booking_status', true) ?: 'pending';
    $email_sent = get_post_meta($post->ID, '_booking_email_sent', true);
    $email_time = get_post_meta($post->ID, '_booking_email_time', true);
    $email_err  = get_post_meta($post->ID, '_booking_email_error', true);
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; padding:10px 0;">
        <div>
            <p><strong style="color:#555;">Họ tên khách hàng:</strong><br>
                <input type="text" name="booking_name" value="<?php echo esc_attr($name); ?>" class="widefat" style="margin-top:4px; font-weight:600;">
            </p>
            <p><strong style="color:#555;">Số điện thoại:</strong><br>
                <input type="text" name="booking_phone" value="<?php echo esc_attr($phone); ?>" class="widefat" style="margin-top:4px;">
                <?php if ($phone) : ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="button button-secondary" style="margin-top:6px; display:inline-flex; align-items:center; gap:4px;">
                        <span class="dashicons dashicons-phone"></span> Gọi trực tiếp cho khách
                    </a>
                <?php endif; ?>
            </p>
            <p><strong style="color:#555;">Số lượng khách:</strong><br>
                <input type="text" name="booking_guests" value="<?php echo esc_attr($guests); ?>" class="widefat" style="margin-top:4px;">
            </p>
        </div>
        <div>
            <p><strong style="color:#555;">Ngày đặt bàn:</strong><br>
                <input type="text" name="booking_date" value="<?php echo esc_attr($date); ?>" class="widefat" style="margin-top:4px;">
            </p>
            <p><strong style="color:#555;">Khung giờ đặt bàn:</strong><br>
                <input type="text" name="booking_time" value="<?php echo esc_attr($time); ?>" class="widefat" style="margin-top:4px; font-weight:bold; color:#a37d3f;">
            </p>
            <p><strong style="color:#555;">Trạng thái đơn:</strong><br>
                <select name="booking_status" style="width:100%; margin-top:4px; padding:6px; font-weight:600;">
                    <option value="pending" <?php selected($status, 'pending'); ?>>Chờ xác nhận (Pending)</option>
                    <option value="confirmed" <?php selected($status, 'confirmed'); ?>>Đã xác nhận chỗ (Confirmed)</option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>>Đã hủy (Cancelled)</option>
                </select>
            </p>
        </div>
    </div>

    <!-- Khối Email thông báo trạng thái -->
    <div style="margin-top:15px; background:#f6f7f7; border:1px solid #dcdcde; border-radius:6px; padding:12px 16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <span class="dashicons dashicons-email-alt" style="color:#2271b1;"></span>
                <strong style="color:#1d2327;">Email thông báo:</strong>
                <?php if ($email_sent === '1'): ?>
                    <span style="color:#137333; font-weight:600; display:inline-flex; align-items:center; gap:3px;">
                        <span class="dashicons dashicons-yes-alt"></span> Đã gửi thành công
                    </span>
                    <?php if ($email_time): ?>
                        <span style="color:#646970; font-size:12px;">(Lúc: <?php echo esc_html($email_time); ?>)</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span style="color:#c5221f; font-weight:600; display:inline-flex; align-items:center; gap:3px;">
                        <span class="dashicons dashicons-warning"></span> Chưa gửi được
                    </span>
                    <?php if ($email_err): ?>
                        <span style="color:#646970; font-size:12px;">(Lỗi: <?php echo esc_html($email_err); ?>)</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div>
                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=otr_resend_booking_email&booking_id=' . $post->ID), 'otr_resend_email_' . $post->ID)); ?>" 
                   class="button button-secondary button-small"
                   style="display:inline-flex; align-items:center; gap:4px;"
                   onclick="return confirm('Bạn có muốn gửi lại email thông báo cho đơn đặt bàn này đến toàn bộ danh sách người nhận?');">
                    <span class="dashicons dashicons-email-alt"></span> Gửi lại Email thông báo
                </a>
            </div>
        </div>
    </div>

    <div style="margin-top:15px; border-top:1px solid #eee; padding-top:10px;">
        <p><strong style="color:#555;">Lời nhắn / Yêu cầu đặc biệt của khách:</strong><br>
            <textarea name="booking_message" rows="4" class="widefat" style="margin-top:4px;"><?php echo esc_textarea($msg); ?></textarea>
        </p>
    </div>
    <?php
}

function otr_save_booking_meta($post_id) {
    if (!isset($_POST['otr_booking_nonce']) || !wp_verify_nonce($_POST['otr_booking_nonce'], 'otr_save_booking_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('booking_name', 'booking_phone', 'booking_guests', 'booking_date', 'booking_time', 'booking_status', 'booking_message');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}
add_action('save_post_otr_booking', 'otr_save_booking_meta');

/**
 * Xử lý nút "Gửi lại email thông báo" từ trang chi tiết đơn
 */
function otr_handle_resend_booking_email() {
    $booking_id = isset($_GET['booking_id']) ? (int) $_GET['booking_id'] : 0;
    if (!$booking_id || !check_admin_referer('otr_resend_email_' . $booking_id)) {
        wp_die('Yêu cầu không hợp lệ.');
    }

    $name    = get_post_meta($booking_id, 'booking_name', true) ?: get_the_title($booking_id);
    $phone   = get_post_meta($booking_id, 'booking_phone', true);
    $guests  = get_post_meta($booking_id, 'booking_guests', true);
    $date    = get_post_meta($booking_id, 'booking_date', true);
    $time    = get_post_meta($booking_id, 'booking_time', true);
    $message = get_post_meta($booking_id, 'booking_message', true);

    $result = otr_send_booking_notification_email(array(
        'id'      => $booking_id,
        'name'    => $name,
        'phone'   => $phone,
        'guests'  => $guests,
        'date'    => $date,
        'time'    => $time,
        'message' => $message,
    ));

    if (!empty($result['success'])) {
        update_post_meta($booking_id, '_booking_email_sent', '1');
        update_post_meta($booking_id, '_booking_email_time', current_time('mysql'));
        delete_post_meta($booking_id, '_booking_email_error');
    } else {
        update_post_meta($booking_id, '_booking_email_sent', '0');
        update_post_meta($booking_id, '_booking_email_error', isset($result['message']) ? $result['message'] : 'Gửi thất bại');
    }

    wp_safe_redirect(admin_url('post.php?post=' . $booking_id . '&action=edit'));
    exit;
}
add_action('admin_post_otr_resend_booking_email', 'otr_handle_resend_booking_email');

/**
 * 4. Xử lý gửi Form Đặt Bàn qua AJAX (Frontend Submission)
 */
function otr_handle_booking_submission() {
    // 1. Nhận và lọc dữ liệu
    $name    = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
    $phone   = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $guests  = isset($_POST['guests']) ? sanitize_text_field(wp_unslash($_POST['guests'])) : '2 khách';
    $date    = isset($_POST['booking_date']) ? sanitize_text_field(wp_unslash($_POST['booking_date'])) : '';
    $time    = isset($_POST['time_slot']) ? sanitize_text_field(wp_unslash($_POST['time_slot'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    // Kiểm tra dữ liệu bắt buộc
    if (empty($name) || empty($phone)) {
        wp_send_json_error(array(
            'message' => 'Vui lòng điền đầy đủ Họ tên và Số điện thoại để chúng mình giữ chỗ cho bạn nhé.'
        ));
    }

    if (empty($time)) {
        wp_send_json_error(array(
            'message' => 'Vui lòng chọn một khung giờ đặt bàn còn chỗ.'
        ));
    }

    if (empty($date)) {
        $date = wp_date('d/m/Y');
    }

    // 2. Lưu vào WordPress Dashboard (Custom Post Type 'otr_booking')
    $post_title = $name . ' (' . $time . ' - ' . $date . ')';
    $booking_id = wp_insert_post(array(
        'post_title'   => $post_title,
        'post_status'  => 'publish',
        'post_type'    => 'otr_booking',
    ));

    if (!$booking_id || is_wp_error($booking_id)) {
        wp_send_json_error(array(
            'message' => 'Không thể tạo đơn đặt bàn. Vui lòng liên hệ trực tiếp hotline quán.'
        ));
    }

    // Lưu các trường dữ liệu chi tiết
    update_post_meta($booking_id, 'booking_name', $name);
    update_post_meta($booking_id, 'booking_phone', $phone);
    update_post_meta($booking_id, 'booking_guests', $guests);
    update_post_meta($booking_id, 'booking_date', $date);
    update_post_meta($booking_id, 'booking_time', $time);
    update_post_meta($booking_id, 'booking_message', $message);
    update_post_meta($booking_id, 'booking_status', 'pending');

    // 3. Gửi Email thông báo với Template sang trọng On The Rock đến TẤT CẢ email trong danh sách người nhận
    $email_result = otr_send_booking_notification_email(array(
        'id'      => $booking_id,
        'name'    => $name,
        'phone'   => $phone,
        'guests'  => $guests,
        'date'    => $date,
        'time'    => $time,
        'message' => $message,
    ));

    // Cập nhật trạng thái gửi thư vào đơn đặt bàn
    if (!empty($email_result['success'])) {
        update_post_meta($booking_id, '_booking_email_sent', '1');
        update_post_meta($booking_id, '_booking_email_time', current_time('mysql'));
        delete_post_meta($booking_id, '_booking_email_error');
    } else {
        update_post_meta($booking_id, '_booking_email_sent', '0');
        $err = !empty($email_result['message']) ? $email_result['message'] : 'Gửi email thất bại';
        update_post_meta($booking_id, '_booking_email_error', $err);
    }

    wp_send_json_success(array(
        'message'    => 'Yêu cầu đặt bàn của bạn đã được gửi thành công! On The Rock sẽ liên hệ qua điện thoại để xác nhận trong ít phút.',
        'booking_id' => $booking_id,
    ));
}
add_action('wp_ajax_otr_submit_booking', 'otr_handle_booking_submission');
add_action('wp_ajax_nopriv_otr_submit_booking', 'otr_handle_booking_submission');

/**
 * 5. Mẫu HTML Email sang trọng On The Rock gửi đến danh sách Email người nhận
 */
function otr_send_booking_notification_email($data) {
    // 1. Lấy danh sách email nhận thông báo từ Option / ACF
    $raw_emails = get_option('otr_booking_notification_emails');
    if (empty($raw_emails)) {
        $front_page_id   = get_option('page_on_front');
        $menu_page       = get_page_by_path('booking');
        $booking_page_id = $menu_page ? $menu_page->ID : $front_page_id;
        $raw_emails      = get_field('booking_notification_emails', $booking_page_id) 
                         ?: get_field('booking_notification_emails', $front_page_id);
    }

    $recipients = array();
    if (!empty($raw_emails)) {
        $split = preg_split('/[,\n\r;]+/', $raw_emails);
        foreach ($split as $em) {
            $em = sanitize_email(trim($em));
            if (is_email($em)) {
                $recipients[] = $em;
            }
        }
    }
    // Loại bỏ email trùng lặp
    $recipients = array_values(array_unique($recipients));

    // Nếu chưa cấu hình email nào, lấy mặc định email Quản trị WordPress
    if (empty($recipients)) {
        $admin_email = get_option('admin_email');
        if (is_email($admin_email)) {
            $recipients[] = $admin_email;
        }
    }

    $booking_id_formatted = !empty($data['id']) ? sprintf('#OTR-%04d', $data['id']) : '#OTR-TEST';
    $admin_edit_url       = !empty($data['id']) ? admin_url('post.php?post=' . $data['id'] . '&action=edit') : admin_url('edit.php?post_type=otr_booking');

    // 2. Tiêu đề thư
    $subject = sprintf('[ON THE ROCK] Yêu cầu đặt bàn mới: %s - %s ngày %s', $data['name'], $data['time'], $data['date']);

    // 3. Nội dung HTML Template Email On The Rock (Luxury Noir & Champagne Gold - Chuẩn Icon Đồ Họa 100% Không Lỗi Ô Vuông)
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo esc_html($subject); ?></title>
        <!--[if mso]>
        <style type="text/css">
            body, table, td, p, a, span { font-family: Arial, 'Segoe UI', sans-serif !important; }
        </style>
        <![endif]-->
        <style type="text/css">
            body {
                margin: 0 !important;
                padding: 0 !important;
                background-color: #0c0a08 !important;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
                -webkit-font-smoothing: antialiased;
            }
        </style>
    </head>
    <body style="margin:0; padding:0; background-color:#0c0a08; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#f4ede4;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#0c0a08; padding:35px 12px;">
            <tr>
                <td align="center">
                    
                    <!-- Khung thiệp sang trọng On The Rock -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width:600px; background-color:#17130e; border:1px solid #caa875; border-radius:8px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.85);">
                        
                        <!-- Header sang trọng có Logo OTR -->
                        <tr>
                            <td align="center" style="padding:34px 25px 22px; border-bottom:1px solid rgba(202,168,117,0.3); background:linear-gradient(180deg, #241c14 0%, #17130e 100%);">
                                <div style="font-family:'Playfair Display', 'Times New Roman', Georgia, serif; font-size:11px; letter-spacing:4px; color:#caa875; text-transform:uppercase; margin-bottom:6px; font-weight:600;">
                                    ✦ ON THE ROCKS COCKTAIL BAR ✦
                                </div>
                                <div style="font-family:'Playfair Display', 'Times New Roman', Georgia, serif; font-size:23px; font-weight:normal; letter-spacing:2px; color:#f4ede4; text-transform:uppercase;">
                                    THÔNG BÁO ĐẶT BÀN MỚI
                                </div>
                                <div style="display:inline-block; margin-top:12px; padding:4px 16px; background:#201811; border:1px solid rgba(202,168,117,0.45); border-radius:20px; font-size:12px; color:#caa875; font-family:monospace; letter-spacing:1px; font-weight:bold;">
                                    MÃ ĐƠN: <?php echo esc_html($booking_id_formatted); ?>
                                </div>
                            </td>
                        </tr>

                        <!-- Nội dung bảng chi tiết với Icon PNG sắc nét 100% không bị ô vuông -->
                        <tr>
                            <td style="padding:28px 30px 24px;">
                                
                                <p style="font-size:14px; color:#d5cdc3; margin:0 0 20px; line-height:1.6; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                    Kính gửi Ban Quản Lý <strong>On The Rock Bar</strong>,<br>
                                    Website vừa nhận được một yêu cầu giữ chỗ mới từ khách hàng với thông tin chi tiết:
                                </p>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid rgba(202,168,117,0.25); border-collapse:collapse; border-radius:6px; overflow:hidden; background-color:#1a1510;">
                                    
                                    <!-- Khách hàng -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td width="38%" style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/user.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Khách hàng:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; color:#ffffff; font-size:15px; font-weight:bold; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <?php echo esc_html($data['name']); ?>
                                        </td>
                                    </tr>

                                    <!-- Số điện thoại -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/phone.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Số điện thoại:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; font-size:15px; font-weight:bold; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <a href="tel:<?php echo esc_attr($data['phone']); ?>" style="color:#caa875; text-decoration:none;">
                                                <?php echo esc_html($data['phone']); ?>
                                            </a>
                                            <span style="display:inline-block; margin-left:8px; padding:2px 8px; background:rgba(202,168,117,0.15); border:1px solid rgba(202,168,117,0.35); border-radius:10px; font-size:11px; color:#caa875; font-weight:normal;">
                                                Bấm gọi ngay
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- Số lượng khách -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/conference-call.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Số lượng khách:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; color:#ffffff; font-size:14px; font-weight:bold; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <?php echo esc_html($data['guests']); ?>
                                        </td>
                                    </tr>

                                    <!-- Ngày đặt bàn -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/calendar.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Ngày đặt bàn:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; color:#ffffff; font-size:14px; font-weight:bold; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <?php echo esc_html($data['date']); ?>
                                        </td>
                                    </tr>

                                    <!-- Khung giờ -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/clock.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Khung giờ:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <span style="display:inline-block; padding:4px 14px; background-color:#caa875; color:#140e08; font-weight:bold; font-size:13px; border-radius:14px; letter-spacing:0.5px;">
                                                <?php echo esc_html($data['time']); ?>
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- Lời nhắn của khách -->
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.12);">
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; vertical-align:top; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/speech-bubble.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Lời nhắn của khách:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; color:#e6dfd5; font-size:13px; line-height:1.6; font-style:italic; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <?php echo !empty($data['message']) ? nl2br(esc_html($data['message'])) : '<em style="color:#8a8175;">(Không có ghi chú thêm)</em>'; ?>
                                        </td>
                                    </tr>

                                    <!-- Thời gian gửi -->
                                    <tr>
                                        <td style="padding:13px 16px; background-color:#201912; color:#caa875; font-size:13px; font-weight:500; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <img src="https://img.icons8.com/material-sharp/96/caa875/time.png" width="18" height="18" alt="" style="display:inline-block; vertical-align:middle; width:18px; height:18px; border:0; margin-right:8px;">
                                            Thời gian gửi:
                                        </td>
                                        <td style="padding:13px 16px; background-color:#17130e; color:#9e9488; font-size:12px; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <?php echo wp_date('d/m/Y - H:i:s'); ?>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Các nút Hành động nhanh (Được phối màu hài hòa, đẳng cấp) -->
                                <div style="margin-top:28px; text-align:center;">
                                    <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto;">
                                        <tr>
                                            <td style="padding:5px 6px;">
                                                <a href="tel:<?php echo esc_attr($data['phone']); ?>" 
                                                   style="display:inline-block; padding:12px 22px; background-color:#1e7039; border:1px solid #2ecc71; color:#ffffff; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size:12px; font-weight:bold; letter-spacing:0.5px; text-decoration:none; border-radius:30px; box-shadow:0 4px 15px rgba(30,112,57,0.35);">
                                                    <img src="https://img.icons8.com/material-sharp/96/ffffff/phone.png" width="14" height="14" alt="" style="display:inline-block; vertical-align:middle; width:14px; height:14px; border:0; margin-right:6px; margin-top:-2px;">
                                                    GỌI CHO KHÁCH NGAY
                                                </a>
                                            </td>
                                            <td style="padding:5px 6px;">
                                                <a href="<?php echo esc_url($admin_edit_url); ?>" 
                                                   style="display:inline-block; padding:12px 22px; background-color:#caa875; border:1px solid #dfbe8b; color:#140e08; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size:12px; font-weight:bold; letter-spacing:0.5px; text-decoration:none; border-radius:30px; box-shadow:0 4px 15px rgba(202,168,117,0.35);">
                                                    <img src="https://img.icons8.com/material-sharp/96/140e08/external-link.png" width="14" height="14" alt="" style="display:inline-block; vertical-align:middle; width:14px; height:14px; border:0; margin-right:6px; margin-top:-2px;">
                                                    XEM & DUYỆT TRONG DASHBOARD
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </td>
                        </tr>

                        <!-- Footer Email -->
                        <tr>
                            <td align="center" style="padding:22px 25px; background-color:#110d09; border-top:1px solid rgba(202,168,117,0.18); font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; text-align:center;">
                                <div style="font-size:11px; letter-spacing:2px; color:#caa875; text-transform:uppercase; font-weight:600; margin-bottom:4px;">
                                    ON THE ROCKS COCKTAIL BAR & LOUNGE
                                </div>
                                <div style="font-size:11px; color:#8a8175; line-height:1.6;">
                                    Hotline: <strong style="color:#caa875;">070 297 0268</strong> • Địa chỉ: Đà Lạt, Việt Nam<br>
                                    Email thông báo tự động từ hệ thống Đặt bàn website.
                                </div>
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
    </body>
    </html>
    <?php
    $email_body = ob_get_clean();

    // 4. Cấu hình Headers gửi dạng HTML
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
    );

    $last_error = '';
    $error_callback = function($wp_error) use (&$last_error) {
        if (is_wp_error($wp_error)) {
            $last_error = $wp_error->get_error_message();
        }
    };
    add_action('wp_mail_failed', $error_callback);

    $successful = array();
    $failed     = array();

    // Gửi lần lượt tới từng tài khoản trong danh sách người nhận
    foreach ($recipients as $recipient) {
        $last_error = '';
        $sent = wp_mail($recipient, $subject, $email_body, $headers);
        if ($sent) {
            $successful[] = $recipient;
        } else {
            $failed[$recipient] = !empty($last_error) ? $last_error : 'Không thể gửi qua mail server';
        }
    }

    remove_action('wp_mail_failed', $error_callback);

    return array(
        'success'    => (count($successful) > 0),
        'recipients' => $recipients,
        'successful' => $successful,
        'failed'     => $failed,
        'sent_count' => count($successful),
        'total'      => count($recipients),
        'message'    => !empty($failed) ? implode('; ', $failed) : 'Đã gửi thành công',
    );
}

/**
 * 6. Trang Quản trị Cấu hình Nhận Email Thông báo & SMTP (Admin Settings Page) - 100% Native Dashicons
 */
function otr_booking_admin_settings_menu() {
    add_submenu_page(
        'edit.php?post_type=otr_booking',
        'Cài đặt nhận Email',
        'Cài đặt nhận Email',
        'manage_options',
        'otr-booking-settings',
        'otr_render_booking_settings_page'
    );
}
add_action('admin_menu', 'otr_booking_admin_settings_menu');

function otr_render_booking_settings_page() {
    $notice_message = '';
    $notice_type    = 'success';

    // Xử lý Lưu cấu hình
    if (isset($_POST['otr_save_booking_settings']) && check_admin_referer('otr_booking_settings_nonce')) {
        // 1. Lưu danh sách email người nhận
        $raw_emails = isset($_POST['otr_booking_notification_emails']) ? sanitize_textarea_field(wp_unslash($_POST['otr_booking_notification_emails'])) : '';
        update_option('otr_booking_notification_emails', $raw_emails);
        
        $booking_page = get_page_by_path('booking');
        if ($booking_page && function_exists('update_field')) {
            update_field('booking_notification_emails', $raw_emails, $booking_page->ID);
        }

        // 2. Lưu cấu hình SMTP
        $smtp_enabled = isset($_POST['otr_smtp_enabled']) ? '1' : '0';
        update_option('otr_smtp_enabled', $smtp_enabled);

        $smtp_host = isset($_POST['otr_smtp_host']) ? sanitize_text_field(wp_unslash($_POST['otr_smtp_host'])) : 'smtp.gmail.com';
        update_option('otr_smtp_host', $smtp_host);

        $smtp_port = isset($_POST['otr_smtp_port']) ? (int)$_POST['otr_smtp_port'] : 587;
        update_option('otr_smtp_port', $smtp_port);

        $smtp_encryption = isset($_POST['otr_smtp_encryption']) ? sanitize_text_field(wp_unslash($_POST['otr_smtp_encryption'])) : 'tls';
        update_option('otr_smtp_encryption', $smtp_encryption);

        $smtp_username = isset($_POST['otr_smtp_username']) ? sanitize_email(wp_unslash($_POST['otr_smtp_username'])) : '';
        update_option('otr_smtp_username', $smtp_username);

        // Chỉ cập nhật mật khẩu nếu người dùng nhập mới
        if (!empty($_POST['otr_smtp_password'])) {
            $smtp_password = sanitize_text_field(wp_unslash($_POST['otr_smtp_password']));
            $smtp_password = str_replace(' ', '', $smtp_password);
            update_option('otr_smtp_password', $smtp_password);
        }

        $smtp_from_name = isset($_POST['otr_smtp_from_name']) ? sanitize_text_field(wp_unslash($_POST['otr_smtp_from_name'])) : 'On The Rock Cocktail Bar';
        update_option('otr_smtp_from_name', $smtp_from_name);

        $smtp_from_email = isset($_POST['otr_smtp_from_email']) ? sanitize_email(wp_unslash($_POST['otr_smtp_from_email'])) : $smtp_username;
        update_option('otr_smtp_from_email', $smtp_from_email);

        $notice_message = 'Đã lưu toàn bộ Cấu hình Email và Cài đặt SMTP thành công!';
        $notice_type    = 'success';
    } 
    // Xử lý Gửi email thử nghiệm đến toàn bộ danh sách người nhận thông báo
    elseif (isset($_POST['otr_send_test_email']) && check_admin_referer('otr_booking_settings_nonce')) {
        // Cập nhật danh sách email hiện tại nếu có chỉnh sửa trước khi bấm gửi thử
        if (isset($_POST['otr_booking_notification_emails'])) {
            $raw_emails = sanitize_textarea_field(wp_unslash($_POST['otr_booking_notification_emails']));
            update_option('otr_booking_notification_emails', $raw_emails);
        }

        $test_result = otr_send_booking_notification_email(array(
            'id'      => 0,
            'name'    => 'Khách Mẫu (Thử Nghiệm Hệ Thống)',
            'phone'   => '0901234567',
            'guests'  => '2 khách',
            'date'    => wp_date('d/m/Y'),
            'time'    => '20:30',
            'message' => 'Đây là thư thử nghiệm gửi tới toàn bộ danh sách người nhận thông báo của On The Rock Bar.',
        ));

        if (!empty($test_result['success'])) {
            $sent_list = !empty($test_result['successful']) ? implode(', ', $test_result['successful']) : '';
            $notice_message = sprintf('Đã gửi email thử nghiệm thành công tới %d địa chỉ: %s! Vui lòng kiểm tra hộp thư đến (Inbox) hoặc Hộp thư rác (Spam).', $test_result['sent_count'], $sent_list);
            $notice_type    = 'success';

            if (!empty($test_result['failed'])) {
                $failed_list = array();
                foreach ($test_result['failed'] as $f_email => $f_err) {
                    $failed_list[] = $f_email . ' (' . $f_err . ')';
                }
                $notice_message .= ' Tuy nhiên có lỗi ở: ' . implode('; ', $failed_list);
            }
        } else {
            $notice_message = 'Gửi email thử nghiệm thất bại: ' . (!empty($test_result['message']) ? $test_result['message'] : 'Không thể kết nối máy chủ SMTP.');
            $notice_type    = 'error';
        }
    }

    // Giá trị hiện tại
    $emails = get_option('otr_booking_notification_emails');
    if (empty($emails)) {
        $emails = get_option('admin_email');
    }

    $smtp_enabled    = get_option('otr_smtp_enabled', '1');
    $smtp_host       = get_option('otr_smtp_host', 'smtp.gmail.com');
    $smtp_port       = get_option('otr_smtp_port', '587');
    $smtp_encryption = get_option('otr_smtp_encryption', 'tls');
    $smtp_username   = get_option('otr_smtp_username', get_option('admin_email'));
    $smtp_password   = get_option('otr_smtp_password', '');
    $smtp_from_name  = get_option('otr_smtp_from_name', 'On The Rock Cocktail Bar');
    $smtp_from_email = get_option('otr_smtp_from_email', $smtp_username);
    ?>
    <div class="wrap" style="max-width:920px;">
        <h1 style="display:flex; align-items:center; gap:8px; font-weight:600; margin-bottom:15px;">
            <span class="dashicons dashicons-email-alt" style="font-size:30px; width:30px; height:30px; color:#2271b1;"></span>
            Cấu hình Gửi Email Thông Báo Đặt Bàn - On The Rock Bar
        </h1>

        <?php if (!empty($notice_message)): ?>
            <div class="notice notice-<?php echo esc_attr($notice_type); ?> is-dismissible" style="padding:12px 16px; margin:15px 0;">
                <p style="font-size:14px; margin:0;">
                    <span class="dashicons dashicons-<?php echo $notice_type === 'success' ? 'yes-alt' : 'warning'; ?>" style="vertical-align:text-bottom; margin-right:4px;"></span>
                    <strong><?php echo esc_html($notice_message); ?></strong>
                </p>
                <?php if ($notice_type === 'error'): ?>
                    <p style="margin:8px 0 0; font-size:12px; color:#646970;">
                        <span class="dashicons dashicons-info" style="vertical-align:text-bottom;"></span>
                        Gợi ý: Nếu dùng Gmail, hãy đảm bảo bạn dùng <strong>Mật khẩu ứng dụng (16 chữ cái)</strong> chứ không phải mật khẩu đăng nhập thông thường của Gmail. Xem hướng dẫn ở cuối trang.
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field('otr_booking_settings_nonce'); ?>

            <!-- KHỐI 1: DANH SÁCH EMAIL NHẬN THÔNG BÁO -->
            <div style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:22px; margin-top:20px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
                <h2 style="margin-top:0; font-size:16px; border-bottom:1px solid #eee; padding-bottom:10px; color:#1d2327; display:flex; align-items:center; gap:8px;">
                    <span class="dashicons dashicons-groups" style="color:#2271b1;"></span>
                    1. Danh sách Email Người Nhận Thông Báo (Chủ quán & Nhân viên)
                </h2>
                
                <p class="description" style="margin-bottom:10px; font-size:13px; line-height:1.6;">
                    Khi có khách gửi form đặt bàn tại <code>/booking/</code>, hệ thống sẽ gửi đồng thời một thư HTML sang trọng với đầy đủ thông tin tới <strong>tất cả các địa chỉ email</strong> trong danh sách này.<br>
                    <strong>Quy cách:</strong> Nhập các email phân cách nhau bằng dấu phẩy <code>,</code> hoặc mỗi email trên một dòng.
                </p>

                <textarea name="otr_booking_notification_emails" rows="4" class="large-text code" style="padding:10px; font-family:monospace; border-radius:4px; font-size:13px;"><?php echo esc_textarea($emails); ?></textarea>
                
                <p style="margin-top:6px; color:#646970; font-size:12px;">
                    Ví dụ: <code>anhdev24h@gmail.com, manager@ontherock.vn, booking@ontherock.vn</code>
                </p>
            </div>

            <!-- KHỐI 2: CẤU HÌNH SMTP GỬI MAIL THẬT -->
            <div style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:22px; margin-top:25px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
                <h2 style="margin-top:0; font-size:16px; border-bottom:1px solid #eee; padding-bottom:10px; color:#1d2327; display:flex; align-items:center; gap:8px;">
                    <span class="dashicons dashicons-admin-generic" style="color:#2271b1;"></span>
                    2. Cấu hình SMTP Gửi Email Thật (Real SMTP Mailer Engine)
                </h2>

                <p class="description" style="margin-bottom:15px; font-size:13px; line-height:1.6;">
                    Máy chủ localhost (XAMPP) và hosting thông thường chặn hàm mail mặc định. Việc cấu hình SMTP xác thực bên dưới đảm bảo <strong>100% email thông báo được gửi thật</strong> tới hộp thư của bạn.
                </p>

                <!-- Toggle Bật/Tắt SMTP -->
                <div style="margin-bottom:20px; padding:12px 15px; background:#f0f6fc; border-left:4px solid #72aee6; border-radius:4px;">
                    <label style="font-weight:600; font-size:14px; color:#1d2327; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <input type="checkbox" name="otr_smtp_enabled" value="1" <?php checked($smtp_enabled, '1'); ?>>
                        Kích hoạt Gửi Email qua SMTP Xác Thực (Khuyên Dùng)
                    </label>
                </div>

                <!-- Các nút Preset 1-Click với Dashicons chuẩn -->
                <div style="margin-bottom:20px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <span style="font-weight:600; font-size:13px; color:#50575e;">Điền nhanh thông số (Preset):</span>
                    <button type="button" class="button" onclick="otrApplyPreset('gmail')" style="display:inline-flex; align-items:center; gap:4px;">
                        <span class="dashicons dashicons-google"></span> Gmail
                    </button>
                    <button type="button" class="button" onclick="otrApplyPreset('brevo')" style="display:inline-flex; align-items:center; gap:4px;">
                        <span class="dashicons dashicons-cloud"></span> Brevo (Sendinblue)
                    </button>
                    <button type="button" class="button" onclick="otrApplyPreset('sendgrid')" style="display:inline-flex; align-items:center; gap:4px;">
                        <span class="dashicons dashicons-cloud"></span> SendGrid
                    </button>
                    <button type="button" class="button" onclick="otrApplyPreset('hostinger')" style="display:inline-flex; align-items:center; gap:4px;">
                        <span class="dashicons dashicons-networking"></span> Hostinger / cPanel
                    </button>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;">
                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Máy chủ SMTP (Host):
                        </label>
                        <input type="text" id="otr_smtp_host" name="otr_smtp_host" value="<?php echo esc_attr($smtp_host); ?>" class="widefat" placeholder="smtp.gmail.com" style="padding:6px 10px;">
                    </div>

                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Cổng kết nối (Port):
                        </label>
                        <input type="number" id="otr_smtp_port" name="otr_smtp_port" value="<?php echo esc_attr($smtp_port); ?>" class="widefat" placeholder="587" style="padding:6px 10px;">
                    </div>

                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Phương thức bảo mật (Encryption):
                        </label>
                        <select id="otr_smtp_encryption" name="otr_smtp_encryption" style="width:100%; padding:6px 10px;">
                            <option value="tls" <?php selected($smtp_encryption, 'tls'); ?>>TLS (Khuyên dùng cho cổng 587)</option>
                            <option value="ssl" <?php selected($smtp_encryption, 'ssl'); ?>>SSL (Khuyên dùng cho cổng 465)</option>
                            <option value="none" <?php selected($smtp_encryption, 'none'); ?>>Không mã hóa (None)</option>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Tài khoản SMTP (Email gửi đi):
                        </label>
                        <input type="email" id="otr_smtp_username" name="otr_smtp_username" value="<?php echo esc_attr($smtp_username); ?>" class="widefat" placeholder="yourname@gmail.com" style="padding:6px 10px;">
                    </div>

                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Mật khẩu ứng dụng SMTP (App Password):
                        </label>
                        <div style="position:relative;">
                            <input type="password" id="otr_smtp_password" name="otr_smtp_password" value="<?php echo esc_attr($smtp_password); ?>" class="widefat" placeholder="Nhập 16 ký tự mật khẩu ứng dụng" style="padding:6px 40px 6px 10px; font-family:monospace;">
                            <button type="button" id="otr_pwd_toggle_btn" onclick="otrTogglePassword()" style="position:absolute; right:6px; top:50%; transform:translateY(-50%); background:transparent; border:none; cursor:pointer; color:#50575e; padding:4px;" title="Hiện / Ẩn mật khẩu">
                                <span id="otr_pwd_icon" class="dashicons dashicons-visibility"></span>
                            </button>
                        </div>
                        <p style="margin:4px 0 0; font-size:11px; color:#646970;">
                            <?php if (!empty($smtp_password)): ?>
                                <span style="color:#137333; display:inline-flex; align-items:center; gap:2px;">
                                    <span class="dashicons dashicons-yes"></span> Đã lưu mật khẩu. Để trống nếu không muốn thay đổi.
                                </span>
                            <?php else: ?>
                                <span>Chưa lưu mật khẩu ứng dụng.</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div>
                        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                            Tên hiển thị người gửi (From Name):
                        </label>
                        <input type="text" name="otr_smtp_from_name" value="<?php echo esc_attr($smtp_from_name); ?>" class="widefat" placeholder="On The Rock Cocktail Bar" style="padding:6px 10px;">
                    </div>
                </div>

                <div style="margin-top:15px;">
                    <label style="display:block; font-weight:600; font-size:13px; margin-bottom:5px; color:#1d2327;">
                        Email hiển thị người gửi (From Email):
                    </label>
                    <input type="email" name="otr_smtp_from_email" value="<?php echo esc_attr($smtp_from_email); ?>" class="regular-text" placeholder="booking@ontherock.vn" style="padding:6px 10px;">
                    <span class="description" style="margin-left:10px; font-size:12px;">Nên trùng với tài khoản SMTP gửi đi để tránh rơi vào hộp thư rác.</span>
                </div>

                <!-- Nút Lưu cấu hình -->
                <div style="margin-top:25px; border-top:1px solid #eee; padding-top:18px;">
                    <button type="submit" name="otr_save_booking_settings" class="button button-primary button-large" style="background:#2271b1; border-color:#2271b1; text-shadow:none; font-weight:600; padding:4px 20px; display:inline-flex; align-items:center; gap:5px;">
                        <span class="dashicons dashicons-saved"></span> Lưu Cấu Hình SMTP & Email
                    </button>
                </div>
            </div>

            <!-- KHỐI 3: GỬI THỬ NGHIỆM ĐẾN TOÀN BỘ DANH SÁCH NGƯỜI NHẬN -->
            <div style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:22px; margin-top:25px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
                <h2 style="margin-top:0; font-size:16px; border-bottom:1px solid #eee; padding-bottom:10px; color:#1d2327; display:flex; align-items:center; gap:8px;">
                    <span class="dashicons dashicons-controls-play" style="color:#2271b1;"></span>
                    3. Kiểm Tra & Gửi Thử Email Đến Toàn Bộ Danh Sách Người Nhận
                </h2>

                <p class="description" style="margin-bottom:15px; font-size:13px; line-height:1.6;">
                    Bấm nút bên dưới để hệ thống lập tức gửi một email mẫu đặt bàn tới <strong>tất cả các địa chỉ email có trong Danh sách Người nhận thông báo (Khối 1)</strong>. Bạn sẽ biết ngay email nào nhận thành công hoặc lỗi chi tiết nếu có.
                </p>

                <div>
                    <button type="submit" name="otr_send_test_email" class="button button-secondary button-large" style="font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <span class="dashicons dashicons-email-alt"></span> Gửi Thử Email Đến Danh Sách Người Nhận
                    </button>
                </div>
            </div>

        </form>

        <!-- KHỐI 4: HƯỚNG DẪN 5 BƯỚC LẤY MẬT KHẨU ỨNG DỤNG GMAIL (30 GIÂY) -->
        <div style="background:#fcf9f2; border:1px solid #e2d1a6; border-radius:8px; padding:20px 22px; margin-top:25px; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
            <h3 style="margin-top:0; font-size:15px; color:#856404; display:flex; align-items:center; gap:8px;">
                <span class="dashicons dashicons-lightbulb" style="color:#c59b27; font-size:20px;"></span>
                Hướng Dẫn Lấy "Mật Khẩu Ứng Dụng Gmail" (Google App Password) trong 30 giây:
            </h3>
            
            <p style="font-size:13px; color:#6d5308; line-height:1.6; margin-bottom:12px;">
                Để bảo mật, Google không cho phép ứng dụng đăng nhập bằng mật khẩu Gmail thông thường mà bắt buộc dùng <strong>Mật khẩu ứng dụng 16 ký tự</strong>:
            </p>

            <ol style="margin:0; padding-left:22px; color:#50575e; font-size:13px; line-height:1.8;">
                <li>
                    Truy cập trang bảo mật tài khoản Google của bạn tại: 
                    <a href="https://myaccount.google.com/security" target="_blank" rel="noopener" style="font-weight:bold; color:#2271b1; text-decoration:none;">
                        myaccount.google.com/security <span class="dashicons dashicons-external" style="font-size:14px; width:14px; height:14px; vertical-align:middle;"></span>
                    </a>
                </li>
                <li>
                    Đảm bảo bạn đã bật <strong>"Xác minh 2 bước" (2-Step Verification)</strong>.
                </li>
                <li>
                    Truy cập trực tiếp vào mục tạo mật khẩu: 
                    <a href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener" style="font-weight:bold; color:#2271b1; text-decoration:none;">
                        myaccount.google.com/apppasswords <span class="dashicons dashicons-external" style="font-size:14px; width:14px; height:14px; vertical-align:middle;"></span>
                    </a>
                </li>
                <li>
                    Tại ô <em>Tên ứng dụng</em>, gõ: <code>On The Rock Booking</code> rồi bấm <strong>Tạo</strong> (Create).
                </li>
                <li>
                    Google sẽ hiện ra một ô màu vàng chứa <strong>16 chữ cái</strong> (Ví dụ: <code>abcd efgh ijkl mnop</code>). Hãy copy 16 chữ này dán vào ô <strong>Mật khẩu ứng dụng SMTP</strong> bên trên và bấm <strong>Lưu Cấu Hình</strong>!
                </li>
            </ol>
        </div>

    </div>

    <script>
    function otrApplyPreset(type) {
        var host = document.getElementById('otr_smtp_host');
        var port = document.getElementById('otr_smtp_port');
        var enc  = document.getElementById('otr_smtp_encryption');

        if (type === 'gmail') {
            host.value = 'smtp.gmail.com';
            port.value = '587';
            enc.value  = 'tls';
        } else if (type === 'brevo') {
            host.value = 'smtp-relay.brevo.com';
            port.value = '587';
            enc.value  = 'tls';
        } else if (type === 'sendgrid') {
            host.value = 'smtp.sendgrid.net';
            port.value = '587';
            enc.value  = 'tls';
        } else if (type === 'hostinger') {
            host.value = 'smtp.hostinger.com';
            port.value = '465';
            enc.value  = 'ssl';
        }
    }

    function otrTogglePassword() {
        var pwd  = document.getElementById('otr_smtp_password');
        var icon = document.getElementById('otr_pwd_icon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.remove('dashicons-visibility');
            icon.classList.add('dashicons-hidden');
        } else {
            pwd.type = 'password';
            icon.classList.remove('dashicons-hidden');
            icon.classList.add('dashicons-visibility');
        }
    }
    </script>
    <?php
}