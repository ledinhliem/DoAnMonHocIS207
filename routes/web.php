<?php

$url = $_GET['url'] ?? 'home';

switch ($url) {

    case 'home':
        require_once "app/controllers/HomeController.php";
        break;

    default:
        echo "404 Not Found";
}