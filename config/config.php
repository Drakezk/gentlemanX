<?php
/**
 * File cấu hình chính của ứng dụng E-Commerce
 * Chứa các thông số kết nối database, đường dẫn, và các cấu hình khác
 */

// Cấu hình Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'base_test');
define('DB_USER', 'root');
define('DB_PASS', 'khointt3925');
define('DB_CHARSET', 'utf8mb4');

// Cấu hình đường dẫn
define('BASE_URL', 'http://test2.test/');
define('ROOT_PATH', dirname(__DIR__) . '/');
define('UPLOAD_PATH', ROOT_PATH . 'assets/uploads/');
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

// Cấu hình ứng dụng
define('APP_NAME', 'Gentleman-X');
define('APP_VERSION', '1.0.0');
define('DEFAULT_CONTROLLER', 'Home');
define('DEFAULT_ACTION', 'index');

// Cấu hình Admin
define('ADMIN_PREFIX', 'admin');

// Cấu hình bảo mật
define('HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_LIFETIME', 3600); // 1 hour

// Cấu hình phân trang
define('PRODUCTS_PER_PAGE', 12);
define('ORDERS_PER_PAGE', 20);

// Cấu hình upload
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
