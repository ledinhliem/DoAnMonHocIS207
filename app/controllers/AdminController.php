<?php

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'message' => 'Trang quản trị mẫu tuần 1.'
        ];

        $this->view('admin/dashboard', $data);
    }
}