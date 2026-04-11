<?php
class AdminController extends Controller
{
    public function dashboard()
    {
        $this->view('admin/dashboard', ['title' => 'Admin Dashboard']);
    }

    public function products()
    {
        $this->view('admin/products', ['title' => 'Quản lý sản phẩm']);
    }

    public function orders()
    {
        $this->view('admin/orders', ['title' => 'Quản lý đơn hàng']);
    }

    public function inventory()
    {
        $this->view('admin/inventory', ['title' => 'Quản lý kho']);
    }

    public function reviews()
    {
        $this->view('admin/reviews', ['title' => 'Quản lý đánh giá']);
    }

    public function blog()
    {
        $this->view('admin/blog', ['title' => 'Quản lý blog']);
    }
}