<?php

class HomeController extends Controller
{
    public function index()
    {
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();

        $data = [
            'title' => 'Trang chủ',
            'message' => 'MVC core đã chạy thành công.',
            'users' => $users
        ];

        $this->view('home/index', $data);
    }
}