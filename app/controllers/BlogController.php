<?php
class BlogController extends Controller
{
    public function index()
    {
        $this->view('blog/index', ['title' => 'Blog']);
    }

    public function detail()
    {
        $this->view('blog/detail', ['title' => 'Chi tiết bài viết']);
    }
}