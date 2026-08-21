<?php
/**
 * ACF Custom Fields Loader
 * Description: Tự động nạp (autoload) tất cả các tệp PHP cấu hình Custom Fields trong thư mục custom-fields/.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Thoát nếu truy cập trực tiếp
}

// Lấy đường dẫn tuyệt đối của thư mục custom-fields/
$custom_fields_dir = dirname(__FILE__);

// Quét toàn bộ các tệp tin có tiền tố 'acf-' và kết thúc bằng '.php'
$acf_files = glob($custom_fields_dir . '/acf-*.php');

if (!empty($acf_files) && is_array($acf_files)) {
    foreach ($acf_files as $file) {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
