<?php

class Controller
{
    // Hàm gọi Model
    public function model($model)
    {
        $modelFile = APP_PATH . 'models/' . $model . '.php';

        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }

        die("Model {$model} không tồn tại.");
    }

    // Hàm gọi View
    public function view($view, $data = [])
    {
        $viewFile = APP_PATH . 'views/' . $view . '.php';

        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            die("View {$view} không tồn tại tại đường dẫn: " . $viewFile);
        }
    }
}