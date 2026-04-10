<?php
class AuthController extends Controller
{
    public function login()
    {
        $this->view('auth/login', ['title' => 'Đăng nhập']);
    }

    public function register()
    {
        $this->view('auth/register', ['title' => 'Đăng ký']);
    }

    public function forgot()
    {
        $this->view('auth/forgot', ['title' => 'Quên mật khẩu']);
    }

    public function reset()
    {
        $this->view('auth/reset', ['title' => 'Đặt lại mật khẩu']);
    }
}