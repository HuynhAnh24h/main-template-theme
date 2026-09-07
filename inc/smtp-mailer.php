<?php
/**
 * Module: SMTP Mailer Engine (Gửi Email Thật qua SMTP Xác Thực)
 * Description: Tích hợp cấu hình SMTP (Gmail, Brevo, SendGrid, Hostinger, ...) vào PHPMailer của WordPress,
 * giải quyết triệt để lỗi không gửi được mail trên máy chủ XAMPP localhost và hosting.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Cấu hình PHPMailer gửi thư qua SMTP xác thực
 */
function otr_configure_smtp_mailer( $phpmailer ) {
    $smtp_enabled = get_option( 'otr_smtp_enabled', '1' );
    $username     = trim( get_option( 'otr_smtp_username', '' ) );

    // Nếu tắt SMTP hoặc chưa cấu hình tài khoản thì không can thiệp
    if ( $smtp_enabled !== '1' || empty( $username ) ) {
        return;
    }

    $host       = get_option( 'otr_smtp_host', 'smtp.gmail.com' );
    $port       = (int) get_option( 'otr_smtp_port', '587' );
    $encryption = get_option( 'otr_smtp_encryption', 'tls' );
    $password   = get_option( 'otr_smtp_password', '' );
    $from_name  = get_option( 'otr_smtp_from_name', 'On The Rock Cocktail Bar' );
    $from_email = get_option( 'otr_smtp_from_email', $username );

    // Chuyển PHPMailer sang phương thức SMTP
    $phpmailer->isSMTP();
    $phpmailer->Host       = $host;
    $phpmailer->Port       = $port;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Username   = $username;
    $phpmailer->Password   = $password;

    // Thiết lập giao thức mã hóa
    if ( $encryption === 'ssl' ) {
        $phpmailer->SMTPSecure = 'ssl';
    } elseif ( $encryption === 'tls' ) {
        $phpmailer->SMTPSecure = 'tls';
    } else {
        $phpmailer->SMTPSecure = '';
        $phpmailer->SMTPAutoTLS = false;
    }

    // Thiết lập tùy chọn SSL bỏ qua kiểm tra chứng chỉ tự ký trên môi trường Localhost (Windows XAMPP)
    $phpmailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ),
    );

    // Thời gian chờ kết nối tối đa (giây)
    $phpmailer->Timeout = 15;

    // Thiết lập bảng mã UTF-8 và Base64 Encoding đảm bảo không bao giờ lỗi font tiếng Việt
    $phpmailer->CharSet  = 'UTF-8';
    $phpmailer->Encoding = 'base64';

    // Chuẩn hóa người gửi From Name và From Email
    if ( ! empty( $from_email ) && is_email( $from_email ) ) {
        $phpmailer->From   = $from_email;
        $phpmailer->Sender = $from_email;
    }
    if ( ! empty( $from_name ) ) {
        $phpmailer->FromName = $from_name;
    }
}
add_action( 'phpmailer_init', 'otr_configure_smtp_mailer', 999 );

/**
 * 2. Bộ lọc chuẩn hóa From Email & From Name của WordPress
 * Ngăn ngừa lỗi "Invalid address: (From): wordpress@localhost" trên Localhost / XAMPP
 */
function otr_custom_mail_from( $original_from ) {
    $from_email = get_option( 'otr_smtp_from_email' );
    if ( ! empty( $from_email ) && is_email( $from_email ) ) {
        return $from_email;
    }

    $smtp_user = get_option( 'otr_smtp_username' );
    if ( ! empty( $smtp_user ) && is_email( $smtp_user ) ) {
        return $smtp_user;
    }

    $admin_email = get_option( 'admin_email' );
    if ( ! empty( $admin_email ) && is_email( $admin_email ) ) {
        return $admin_email;
    }

    return $original_from;
}
add_filter( 'wp_mail_from', 'otr_custom_mail_from', 999 );

function otr_custom_mail_from_name( $original_name ) {
    $from_name = get_option( 'otr_smtp_from_name' );
    if ( ! empty( $from_name ) ) {
        return $from_name;
    }
    return 'On The Rock Cocktail Bar';
}
add_filter( 'wp_mail_from_name', 'otr_custom_mail_from_name', 999 );

/**
 * 3. Hàm gửi thử nghiệm kiểm tra kết nối SMTP (Test Connection)
 */
function otr_test_smtp_mail( $to_email ) {
    if ( ! is_email( $to_email ) ) {
        return array(
            'success' => false,
            'message' => 'Địa chỉ email nhận thử không hợp lệ: ' . esc_html( $to_email ),
        );
    }

    $last_error = '';
    $error_callback = function( $wp_error ) use ( &$last_error ) {
        if ( is_wp_error( $wp_error ) ) {
            $last_error = $wp_error->get_error_message();
        }
    };
    add_action( 'wp_mail_failed', $error_callback );

    $host       = get_option( 'otr_smtp_host', 'smtp.gmail.com' );
    $port       = get_option( 'otr_smtp_port', '587' );
    $encryption = strtoupper( get_option( 'otr_smtp_encryption', 'tls' ) );
    $username   = get_option( 'otr_smtp_username', '' );

    $subject = '[ON THE ROCK] Thư thử nghiệm kết nối SMTP thành công!';
    $message = '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thử nghiệm SMTP On The Rock</title>
        <!--[if mso]>
        <style type="text/css">
            body, table, td, p, a, span { font-family: Arial, sans-serif !important; }
        </style>
        <![endif]-->
        <style type="text/css">
            body {
                margin: 0 !important;
                padding: 0 !important;
                background-color: #0c0a08 !important;
                font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif !important;
                -webkit-font-smoothing: antialiased;
            }
        </style>
    </head>
    <body style="margin:0; padding:0; background-color:#0c0a08; font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; color:#f4ede4;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:35px 12px; background-color:#0c0a08;">
            <tr>
                <td align="center">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width:580px; background-color:#17130e; border:1px solid #caa875; border-radius:8px; overflow:hidden; box-shadow:0 18px 45px rgba(0,0,0,0.85);">
                        <tr>
                            <td align="center" style="padding:32px 25px 20px; border-bottom:1px solid rgba(202,168,117,0.3); background:linear-gradient(180deg, #241c14 0%, #17130e 100%);">
                                <div style="font-family:\'Playfair Display\', \'Times New Roman\', Georgia, serif; font-size:11px; letter-spacing:4px; color:#caa875; text-transform:uppercase; margin-bottom:6px; font-weight:600;">
                                    ✦ ON THE ROCKS COCKTAIL BAR ✦
                                </div>
                                <div style="font-family:\'Playfair Display\', \'Times New Roman\', Georgia, serif; font-size:22px; color:#f4ede4; text-transform:uppercase; letter-spacing:2px;">
                                    KẾT NỐI SMTP THÀNH CÔNG!
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:28px 30px 22px;">
                                <p style="font-size:14px; color:#d5cdc3; line-height:1.6; margin:0 0 20px; font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">
                                    Xin chào! Đây là email thử nghiệm được gửi trực tiếp từ hệ thống Đặt Bàn của <strong>On The Rock Bar</strong>.
                                </p>
                                <div style="background:#1f1913; border:1px solid rgba(202,168,117,0.3); border-radius:6px; padding:16px 20px; margin-bottom:20px; font-size:13px; line-height:1.8; font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">
                                    <div style="color:#caa875; font-weight:bold; margin-bottom:8px; letter-spacing:0.5px; font-size:12px; text-transform:uppercase;">THÔNG SỐ KẾT NỐI SMTP HIỆN TẠI:</div>
                                    <div style="color:#ffffff; margin-bottom:4px;">• Máy chủ SMTP: <strong>' . esc_html( $host ) . '</strong></div>
                                    <div style="color:#ffffff; margin-bottom:4px;">• Cổng: <strong>' . esc_html( $port ) . '</strong> (' . esc_html( $encryption ) . ')</div>
                                    <div style="color:#ffffff; margin-bottom:4px;">• Tài khoản gửi: <strong>' . esc_html( $username ) . '</strong></div>
                                    <div style="color:#ffffff;">• Thời điểm kiểm tra: <strong>' . wp_date( 'd/m/Y - H:i:s' ) . '</strong></div>
                                </div>
                                <p style="font-size:13px; color:#a3988b; line-height:1.6; margin:0; font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">
                                    Máy chủ email đã sẵn sàng hoạt động hoàn hảo. Khi khách hàng đặt bàn trên website, thông tin chi tiết sẽ được tự động gửi đến toàn bộ ban quản lý ngay lập tức!
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding:18px 20px; background-color:#110d09; border-top:1px solid rgba(202,168,117,0.18); font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; text-align:center;">
                                <div style="font-size:11px; letter-spacing:2px; color:#caa875; text-transform:uppercase; font-weight:600; margin-bottom:4px;">
                                    ON THE ROCKS COCKTAIL BAR & LOUNGE
                                </div>
                                <div style="font-size:11px; color:#8a8175;">
                                    Hotline: <strong style="color:#caa875;">070 297 0268</strong> • Đà Lạt, Việt Nam
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
    );

    $sent = wp_mail( $to_email, $subject, $message, $headers );

    remove_action( 'wp_mail_failed', $error_callback );

    if ( $sent ) {
        return array(
            'success' => true,
            'message' => 'Đã gửi email thử nghiệm THÀNH CÔNG đến: ' . esc_html( $to_email ) . '! Hãy kiểm tra hộp thư đến (Inbox) hoặc Hộp thư rác (Spam).',
        );
    } else {
        $err_text = ! empty( $last_error ) ? $last_error : 'Không thể kết nối đến máy chủ SMTP.';
        return array(
            'success' => false,
            'message' => 'Gửi email thử nghiệm thất bại: ' . esc_html( $err_text ),
            'raw_error' => $err_text,
        );
    }
}