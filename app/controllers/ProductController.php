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
   $keyword = trim($_GET['keyword'] ?? '');

    // DATA GIẢ (mock)
    $products = [
        ['id'=>1,'name'=>'Bamboo Brush'],
        ['id'=>2,'name'=>'Bamboo Towel'],
        ['id'=>3,'name'=>'Cutlery Set'],
        ['id'=>4,'name'=>'Laptop Stand']
    ];

    // FILTER
    $results = array_values(array_filter($products, function($p) use ($keyword) {
    return stripos(strtolower($p['name']), strtolower($keyword)) !== false;
}));
    // TRUYỀN QUA VIEW
    $this->view('product/search', [
        'title' => 'Tìm kiếm',
        'keyword' => $keyword,
        'products' => $results
    ]);
}
}