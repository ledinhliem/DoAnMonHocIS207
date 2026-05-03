<?php

class HomeController extends Controller
{
    public function index()
    {
        // Khởi tạo Model nếu bạn muốn lấy dữ liệu user (tùy chọn)
        // $userModel = $this->model('User');
        // $users = $userModel->getAllUsers();

        $data = [
            'title' => 'Trang chủ - Zentro',
            'message' => 'MVC core đã chạy thành công.'
        ];

        $this->view('home/index', $data);
    }
}