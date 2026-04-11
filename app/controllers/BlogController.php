<?php
class BlogController extends Controller
{
    public function index()
    {
        $blogs = [
            ['id'=>1,'title'=>'10 Ways to Reduce Plastic in the Kitchen'],
            ['id'=>2,'title'=>'Why Linen is the Future of Textiles'],
            ['id'=>3,'title'=>'Meet the Makers: Heritage Pottery'],
            ['id'=>4,'title'=>'The Truth About Water Scarcity'],
            ['id'=>5,'title'=>'One Tree Per Order: Our Impact'],
        ];

        $this->view('blog/index', [
            'title' => 'Blog',
            'blogs' => $blogs
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 1;

        $blogs = [
            1 => ['title'=>'10 Ways to Reduce Plastic in the Kitchen'],
            2 => ['title'=>'Why Linen is the Future of Textiles'],
            3 => ['title'=>'Meet the Makers: Heritage Pottery'],
            4 => ['title'=>'The Truth About Water Scarcity'],
            5 => ['title'=>'One Tree Per Order: Our Impact'],
        ];

        $blog = $blogs[$id] ?? $blogs[1];

        $this->view('blog/detail', [
            'title' => $blog['title'],
            'blog' => $blog
        ]);
    }
}