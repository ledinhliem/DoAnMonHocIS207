<?php
class ProductController extends Controller
{
    public function index()
    {
        $this->view('product/index', ['title' => 'Sản phẩm']);
    }

    public function detail()
    {
        $this->view('product/detail', ['title' => 'Chi tiết sản phẩm']);
    }

    public function search()
    {
        $this->view('product/search', ['title' => 'Tìm kiếm']);
    }
}