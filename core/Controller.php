<?php
class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View không tồn tại: " . $viewPath;
        }
    }
}