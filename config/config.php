<?php


define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'sustainable_shop');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_PATH', __DIR__ . '/../app/');
define('CORE_PATH', __DIR__ . '/../core/');
define('ROOT_PATH', __DIR__ . '/..');

define('BASE_URL', 'http://localhost:8080/is207/');
// SMTP Gmail config
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);

// Gmail dùng để gửi mail
define('SMTP_USERNAME', 'zentroshop359@gmail.com');

if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

if (!defined('SMTP_PASSWORD')) {
    define('SMTP_PASSWORD', '');
}

if (!defined('SEPAY_MERCHANT_ID')) {
    define('SEPAY_MERCHANT_ID', '');
}

if (!defined('SEPAY_SECRET_KEY')) {
    define('SEPAY_SECRET_KEY', '');
}

if (!defined('GOOGLE_CLIENT_ID')) {
    define('GOOGLE_CLIENT_ID', '');
}

if (!defined('GOOGLE_CLIENT_SECRET')) {
    define('GOOGLE_CLIENT_SECRET', '');
}

if (!defined('GOOGLE_REDIRECT_URI')) {
    define('GOOGLE_REDIRECT_URI', BASE_URL . 'index.php?url=auth/google/callback');
}

define('SMTP_FROM_EMAIL', 'zentroshop359@gmail.com');
define('SMTP_FROM_NAME', 'Zentro');

// Mail admin nhận thông báo khi có người đăng ký newsletter
define('NEWSLETTER_ADMIN_EMAIL', 'dinhliem1911@gmail.com');
