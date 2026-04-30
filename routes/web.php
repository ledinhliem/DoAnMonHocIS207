<?php

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        require_once "app/controllers/HomeController.php";
        // Khởi tạo đối tượng và gọi hàm hiển thị giao diện
        $controller = new HomeController();
        $controller->index();
        break;
    case 'product':
        require_once "app/controllers/ProductController.php";
        $controller = new ProductController();
        $controller->index();
        break;

    case 'product/detail':
        require_once "app/controllers/ProductController.php";
        $controller = new ProductController();
        $controller->detail($_GET['id']);
        break;
    default:
        echo "404 Not Found";

}
