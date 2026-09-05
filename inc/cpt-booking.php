<?php
/**
 * Custom Post Type: Bookings (Đặt Bàn) & Email Notification System
 * Description: Quản lý danh sách đặt bàn tại On The Rock Bar trong WordPress Dashboard,
 * xử lý gửi form AJAX và gửi email thông báo với template HTML sang trọng tới nhiều email người nhận.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Đăng ký Custom Post Type 'otr_booking'
 */
function otr_register_booking_cpt() {
    $labels = array(
        'name'               => 'Đặt Bàn',
        'singular_name'      => 'Đơn Đặt Bàn',
        'menu_name'          => 'Đặt Bàn (Bookings)',
        'all_items'          => 'Tất cả đơn đặt bàn',
        'add_new'            => 'Thêm đơn mới',
        'add_new_item'       => 'Thêm đơn đặt bàn mới',
        'edit_item'          => 'Chi tiết đơn đặt bàn',
        'new_item'           => 'Đơn mới',
        'view_item'          => 'Xem đơn đặt bàn',
        'search_items'       => 'Tìm kiếm đơn đặt bàn',
        'not_found'          => 'Không có đơn đặt bàn nào',
        'not_found_in_trash' => 'Không có đơn nào trong thùng rác',
    );

    register_post_type('otr_booking', array(
        'labels'             => $labels,
        'public'             => false, // Không hiển thị ra ngoài website dưới dạng bài viết
        'publicly_queryable' => false,
        'show_ui'            => true,  // Hiển thị trong WP Dashboard
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title'),
    ));
}
add_action('init', 'otr_register_booking_cpt');

/**
 * 2. Tùy biến cột hiển thị trong danh sách Đặt Bàn (Dashboard Columns)
 */
function otr_booking_columns($columns) {
    return array(
        'cb'             => $columns['cb'],
        'title'          => 'Mã Đơn / Khách Hàng',
        'phone'          => 'Số Điện Thoại',
        'guests'         => 'Số Khách',
        'booking_time'   => 'Ngày & Giờ Đặt',
        'status'         => 'Trạng Thái',
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
                echo '<a href="tel:' . esc_attr($phone) . '" style="font-weight:600; color:#0073aa;">' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;

        case 'guests':
            $guests = get_post_meta($post_id, 'booking_guests', true) ?: '2 khách';
            echo '<span style="display:inline-block; padding:3px 8px; background:#f0f0f1; border-radius:12px; font-weight:600; font-size:12px;">' . esc_html($guests) . '</span>';
            break;

        case 'booking_time':
            $date = get_post_meta($post_id, 'booking_date', true) ?: '—';
            $time = get_post_meta($post_id, 'booking_time', true) ?: '—';
            echo '<div style="font-weight:600; color:#1d2327;">' . esc_html($date) . '</div>';
            echo '<span style="display:inline-block; margin-top:3px; padding:2px 7px; background:#caa875; color:#140e08; font-weight:700; border-radius:4px; font-size:11px;">' . esc_html($time) . '</span>';
            break;

        case 'status':
            $status = get_post_meta($post_id, 'booking_status', true) ?: 'pending';
            if ($status === 'confirmed') {
                echo '<span style="background:#e6f4ea; color:#137333; font-weight:700; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-block;">✓ Đã xác nhận</span>';
            } elseif ($status === 'cancelled') {
                echo '<span style="background:#fce8e6; color:#c5221f; font-weight:700; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-block;">✕ Đã hủy</span>';
            } else {
                echo '<span style="background:#fef7e0; color:#b06000; font-weight:700; padding:4px 9px; border-radius:12px; font-size:11px; display:inline-block;">⏳ Chờ xác nhận</span>';
            }
            break;

        case 'message':
            $msg = get_post_meta($post_id, 'booking_message', true);
            if ($msg) {
                echo '<span title="' . esc_attr($msg) . '">' . esc_html(wp_trim_words($msg, 8, '...')) . '</span>';
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

    $name    = get_post_meta($post->ID, 'booking_name', true) ?: $post->post_title;
    $phone   = get_post_meta($post->ID, 'booking_phone', true);
    $guests  = get_post_meta($post->ID, 'booking_guests', true);
    $date    = get_post_meta($post->ID, 'booking_date', true);
    $time    = get_post_meta($post->ID, 'booking_time', true);
    $msg     = get_post_meta($post->ID, 'booking_message', true);
    $status  = get_post_meta($post->ID, 'booking_status', true) ?: 'pending';
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; padding:10px 0;">
        <div>
            <p><strong style="color:#555;">Họ tên khách hàng:</strong><br>
                <input type="text" name="booking_name" value="<?php echo esc_attr($name); ?>" class="widefat" style="margin-top:4px; font-weight:600;">
            </p>
            <p><strong style="color:#555;">Số điện thoại:</strong><br>
                <input type="text" name="booking_phone" value="<?php echo esc_attr($phone); ?>" class="widefat" style="margin-top:4px;">
                <?php if ($phone) : ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="button button-secondary" style="margin-top:6px;">📞 Gọi trực tiếp cho khách</a>
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
                <select name="booking_status" style="width:100%; margin-top:4px; padding:5px; font-weight:600;">
                    <option value="pending" <?php selected($status, 'pending'); ?>>⏳ Chờ xác nhận (Pending)</option>
                    <option value="confirmed" <?php selected($status, 'confirmed'); ?>>✓ Đã xác nhận chỗ (Confirmed)</option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>>✕ Đã hủy (Cancelled)</option>
                </select>
            </p>
        </div>
    </div>
    <div style="margin-top:10px; border-top:1px solid #eee; pt-10;">
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

    // 3. Gửi Email thông báo với Template sang trọng On The Rock
    otr_send_booking_notification_email(array(
        'id'      => $booking_id,
        'name'    => $name,
        'phone'   => $phone,
        'guests'  => $guests,
        'date'    => $date,
        'time'    => $time,
        'message' => $message,
    ));

    wp_send_json_success(array(
        'message' => 'Yêu cầu đặt bàn của bạn đã được gửi thành công! On The Rock sẽ liên hệ qua điện thoại để xác nhận trong ít phút.',
        'booking_id' => $booking_id,
    ));
}
add_action('wp_ajax_otr_submit_booking', 'otr_handle_booking_submission');
add_action('wp_ajax_nopriv_otr_submit_booking', 'otr_handle_booking_submission');

/**
 * 5. Mẫu HTML Email sang trọng On The Rock gửi đến danh sách Email người nhận
 */
function otr_send_booking_notification_email($data) {
    // 1. Lấy danh sách email nhận thông báo từ ACF / Option
    $front_page_id = get_option('page_on_front');
    $menu_page     = get_page_by_path('booking');
    $booking_page_id = $menu_page ? $menu_page->ID : $front_page_id;

    $raw_emails = get_field('booking_notification_emails', $booking_page_id) 
               ?: (get_field('booking_notification_emails', $front_page_id) 
               ?: get_option('otr_booking_notification_emails'));

    $recipients = array();
    if (!empty($raw_emails)) {
        // Tách email theo dấu phẩy, chấm phẩy hoặc xuống dòng
        $split = preg_split('/[,\n\r;]+/', $raw_emails);
        foreach ($split as $em) {
            $em = sanitize_email(trim($em));
            if (is_email($em)) {
                $recipients[] = $em;
            }
        }
    }

    // Nếu chưa cấu hình email nào, lấy mặc định email Quản trị WordPress
    if (empty($recipients)) {
        $recipients[] = get_option('admin_email');
    }

    $admin_edit_url = admin_url('post.php?post=' . $data['id'] . '&action=edit');
    $admin_list_url = admin_url('edit.php?post_type=otr_booking');

    // 2. Tiêu đề thư
    $subject = sprintf('[ON THE ROCK] Yêu cầu đặt bàn mới: %s - %s ngày %s', $data['name'], $data['time'], $data['date']);

    // 3. Nội dung HTML Template Email On The Rock (Luxury Black & Champagne Gold)
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title><?php echo esc_html($subject); ?></title>
    </head>
    <body style="margin:0; padding:0; background-color:#080604; font-family:'Helvetica Neue', Arial, sans-serif; color:#f4efe8;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#080604; padding:40px 15px;">
            <tr>
                <td align="center">
                    
                    <!-- Khung thiệp sang trọng -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width:620px; background-color:#140e08; border:1px solid #caa875; border-radius:4px; overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.8);">
                        
                        <!-- Header có Logo OTR -->
                        <tr>
                            <td align="center" style="padding:36px 25px 20px; border-bottom:1px solid rgba(202,168,117,0.25); background:linear-gradient(to bottom, #1a120b, #140e08);">
                                <div style="font-family:Georgia, serif; font-size:11px; letter-spacing:4px; color:#caa875; text-transform:uppercase; margin-bottom:6px;">
                                    ON THE ROCKS COCKTAIL BAR
                                </div>
                                <div style="font-family:Georgia, serif; font-size:26px; font-weight:normal; letter-spacing:2px; color:#caa875; text-transform:uppercase;">
                                    THÔNG BÁO ĐẶT BÀN MỚI
                                </div>
                                <div style="font-size:12px; color:rgba(202,168,117,0.7); margin-top:8px;">
                                    Website vừa nhận được một yêu cầu giữ chỗ từ khách hàng
                                </div>
                            </td>
                        </tr>

                        <!-- Nội dung bảng chi tiết -->
                        <tr>
                            <td style="padding:30px 35px 25px;">
                                
                                <p style="font-size:14px; color:#caa875; margin:0 0 20px; line-height:1.6;">
                                    Xin chào ban quản lý <strong>On The Rock Bar</strong>,<br>
                                    Dưới đây là thông tin chi tiết của khách hàng vừa đặt bàn:
                                </p>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid rgba(202,168,117,0.2); border-collapse:collapse;">
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.15);">
                                        <td width="38%" style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px;">
                                            👤 Khách hàng:
                                        </td>
                                        <td style="padding:12px 16px; color:#ffffff; font-size:15px; font-weight:bold;">
                                            <?php echo esc_html($data['name']); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.15);">
                                        <td style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px;">
                                            📞 Số điện thoại:
                                        </td>
                                        <td style="padding:12px 16px; font-size:15px; font-weight:bold;">
                                            <a href="tel:<?php echo esc_attr($data['phone']); ?>" style="color:#caa875; text-decoration:none;">
                                                <?php echo esc_html($data['phone']); ?> (Bấm gọi)
                                            </a>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.15);">
                                        <td style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px;">
                                            👥 Số lượng khách:
                                        </td>
                                        <td style="padding:12px 16px; color:#ffffff; font-size:14px; font-weight:bold;">
                                            <?php echo esc_html($data['guests']); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.15);">
                                        <td style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px;">
                                            📅 Ngày đặt bàn:
                                        </td>
                                        <td style="padding:12px 16px; color:#ffffff; font-size:14px; font-weight:bold;">
                                            <?php echo esc_html($data['date']); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom:1px solid rgba(202,168,117,0.15);">
                                        <td style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px;">
                                            ⏰ Khung giờ:
                                        </td>
                                        <td style="padding:12px 16px;">
                                            <span style="display:inline-block; padding:4px 12px; background-color:#caa875; color:#140e08; font-weight:bold; font-size:13px; border-radius:12px;">
                                                <?php echo esc_html($data['time']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:12px 16px; background-color:#1a130c; color:rgba(202,168,117,0.8); font-size:13px; vertical-align:top;">
                                            💬 Lời nhắn của khách:
                                        </td>
                                        <td style="padding:12px 16px; color:#f4efe8; font-size:13px; line-height:1.5;">
                                            <?php echo !empty($data['message']) ? nl2br(esc_html($data['message'])) : '<em>(Không có ghi chú thêm)</em>'; ?>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Nút Xem Trong Dashboard -->
                                <div style="text-align:center; margin-top:30px; margin-bottom:10px;">
                                    <a href="<?php echo esc_url($admin_edit_url); ?>" 
                                       style="display:inline-block; padding:14px 32px; background-color:#caa875; color:#140e08; font-size:13px; font-weight:bold; text-decoration:none; text-transform:uppercase; letter-spacing:2px; border-radius:50px; box-shadow:0 6px 20px rgba(202,168,117,0.35);">
                                        XEM & XÁC NHẬN TRONG DASHBOARD
                                    </a>
                                </div>

                            </td>
                        </tr>

                        <!-- Footer Email -->
                        <tr>
                            <td align="center" style="padding:20px; background-color:#0f0a05; border-top:1px solid rgba(202,168,117,0.15); font-size:11px; color:rgba(202,168,117,0.6); line-height:1.6;">
                                Email này được gửi tự động từ hệ thống Đặt bàn On The Rock Bar.<br>
                                Hotline hỗ trợ: <strong>070 297 0268</strong> | Địa chỉ: Đà Lạt, Việt Nam
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
        'From: On The Rock Bar <' . get_option('admin_email') . '>',
    );

    // Gửi đến tất cả các email người liên quan
    foreach ($recipients as $recipient) {
        wp_mail($recipient, $subject, $email_body, $headers);
    }
}

/**
 * 6. Trang Quản trị Cấu hình Nhận Email Thông báo (Admin Settings Page)
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
    $message = '';
    $message_type = 'success';

    if (isset($_POST['otr_save_booking_settings']) && check_admin_referer('otr_booking_settings_nonce')) {
        $raw_emails = isset($_POST['otr_booking_notification_emails']) ? sanitize_textarea_field(wp_unslash($_POST['otr_booking_notification_emails'])) : '';
        update_option('otr_booking_notification_emails', $raw_emails);
        
        // Đồng bộ vào ACF Booking page nếu có
        $booking_page = get_page_by_path('booking');
        if ($booking_page && function_exists('update_field')) {
            update_field('booking_notification_emails', $raw_emails, $booking_page->ID);
        }

        $message = 'Đã lưu cấu hình danh sách Email nhận thông báo thành công!';
    } elseif (isset($_POST['otr_send_test_email']) && check_admin_referer('otr_booking_settings_nonce')) {
        // Gửi thử nghiệm
        otr_send_booking_notification_email(array(
            'id'      => 0,
            'name'    => 'Khách Mẫu (Test)',
            'phone'   => '0901234567',
            'guests'  => '2 khách',
            'date'    => wp_date('d/m/Y'),
            'time'    => '20:30',
            'message' => 'Đây là tin nhắn đặt bàn thử nghiệm từ trang Quản trị On The Rock Bar.',
        ));
        $message = 'Đã gửi email thử nghiệm! Vui lòng kiểm tra hộp thư đến (Inbox / Spam) của danh sách email đã cấu hình.';
    }

    $emails = get_option('otr_booking_notification_emails');
    if (empty($emails)) {
        $booking_page = get_page_by_path('booking');
        if ($booking_page && function_exists('get_field')) {
            $emails = get_field('booking_notification_emails', $booking_page->ID);
        }
    }
    if (empty($emails)) {
        $emails = get_option('admin_email');
    }
    ?>
    <div class="wrap">
        <h1 style="display:flex; align-items:center; gap:10px; font-weight:600;">
            <span class="dashicons dashicons-email-alt" style="font-size:28px; width:28px; height:28px; color:#c59b27;"></span>
            Cấu hình Nhận Email Đặt Bàn - On The Rock Bar
        </h1>

        <?php if (!empty($message)): ?>
            <div class="notice notice-<?php echo esc_attr($message_type); ?> is-dismissible">
                <p><strong><?php echo esc_html($message); ?></strong></p>
            </div>
        <?php endif; ?>

        <div style="background:#ffffff; border:1px solid #ccd0d4; border-radius:8px; padding:25px; max-width:800px; margin-top:20px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
            <form method="post" action="">
                <?php wp_nonce_field('otr_booking_settings_nonce'); ?>
                
                <h2 style="margin-top:0; font-size:16px; border-bottom:1px solid #eee; padding-bottom:12px; color:#1d2327;">
                    Danh sách Email người nhận thông báo
                </h2>
                
                <p class="description" style="margin-bottom:12px; font-size:13px; line-height:1.6;">
                    Nhập các địa chỉ email của bạn và những người liên quan (chủ quán, quản lý, tiếp tân, thu ngân) sẽ nhận được thông báo ngay khi có khách gửi form đặt bàn từ website.<br>
                    <strong>Quy cách:</strong> Các email phân cách nhau bằng dấu phẩy <code>,</code> hoặc mỗi email trên một dòng.
                </p>

                <textarea name="otr_booking_notification_emails" rows="5" class="large-text code" style="padding:10px; font-family:monospace; border-radius:4px;"><?php echo esc_textarea($emails); ?></textarea>

                <p style="margin-top:8px; color:#646970; font-size:12px;">
                    Ví dụ: <code>manager@ontherock.vn, booking@ontherock.vn, admin@gmail.com</code>
                </p>

                <div style="margin-top:25px; display:flex; align-items:center; gap:15px; border-top:1px solid #eee; padding-top:20px;">
                    <button type="submit" name="otr_save_booking_settings" class="button button-primary button-large" style="background:#c59b27; border-color:#b48c1e; text-shadow:none; font-weight:600;">
                        Lưu Cấu Hình
                    </button>

                    <button type="submit" name="otr_send_test_email" class="button button-secondary button-large" onclick="return confirm('Bạn có muốn gửi một email thử nghiệm đến danh sách email này ngay bây giờ?');">
                        ✉ Gửi Thử Email Thông Báo
                    </button>
                </div>
            </form>
        </div>

        <div style="background:#f6f7f7; border:1px dashed #c3c4c7; border-radius:8px; padding:18px; max-width:800px; margin-top:25px;">
            <h3 style="margin-top:0; font-size:14px;">💡 Hướng dẫn & Lưu ý:</h3>
            <ul style="margin:0; padding-left:20px; color:#50575e; font-size:13px; line-height:1.6;">
                <li>Mỗi khi có khách bấm <strong>"ĐẶT BÀN"</strong> tại trang <code>/booking/</code>, hệ thống sẽ tự động tạo một đơn đặt bàn mới trong mục <strong><a href="<?php echo esc_url(admin_url('edit.php?post_type=otr_booking')); ?>">Tất cả đơn đặt bàn</a></strong>.</li>
                <li>Đồng thời, hệ thống lập tức gửi một thư HTML sang trọng với thông tin Họ tên, SĐT (bấm gọi được), Số khách, Ngày giờ và Lời nhắn đến tất cả các email bạn đã nhập ở trên.</li>
                <li>Nếu không điền email nào, hệ thống sẽ gửi về email quản trị mặc định: <code><?php echo esc_html(get_option('admin_email')); ?></code>.</li>
            </ul>
        </div>
    </div>
    <?php
}

