<?php

// 1. Hiển thị lỗi để dễ debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Khởi tạo session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Nạp cấu hình (Chỉ nạp 1 lần duy nhất)
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// 4. Nạp các lớp hệ thống (Core)
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Router.php';

// Lưu ý: Nếu dự án của bạn dùng App.php thay vì Router.php thì dùng cái dưới, 
// nhưng theo các lỗi trước đó thì bạn đang dùng Router.
// require_once __DIR__ . '/core/App.php'; 

// 5. Chạy ứng dụng
$router = new Router();
$router->dispatch();