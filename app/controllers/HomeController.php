<?php

class HomeController extends Controller
{
    public function index()
    {
        // Khởi tạo Model nếu bạn muốn lấy dữ liệu user (tùy chọn)
        // $userModel = $this->model('User');
        // $users = $userModel->getAllUsers();

       $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->getAll();

        $data = [
            'title' => 'Trang chủ - Zentro',
            'categories' => $categories
        ];

        $this->view('home/index', $data);
    }
}