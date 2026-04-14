<?php

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        require_once "app/controllers/HomeController.php";
        // Khởi tạo đối tượng và gọi hàm hiển thị giao diện
        $controller = new HomeController();
        $controller->index();
        break;
    default:
        echo "404 Not Found";
}