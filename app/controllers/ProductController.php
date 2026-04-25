<?php
class ProductController extends Controller
{
    public function index()
{
    $productModel = $this->model('ProductModel');

    $category = $_GET['category'] ?? ''; // home / beauty / fashion
    $filter   = $_GET['filter'] ?? '';   // 1 / 2 / 3 / 4
    $sort     = $_GET['sort'] ?? '';

    $products = $productModel->getProducts($filter, $sort);

    $this->view('product/index', [
        'title' => 'Sản phẩm',
        'category' => $category,
        'filter' => $filter,
        'sort' => $sort,
        'products' => $products
    ]);
}
    public function detail($id)
    {
        $productModel = $this->model('ProductModel');

        $product = $productModel->getProductById($id);
        if (!$product) {
            // Xử lý khi không tìm thấy sản phẩm
            header("Location: " . BASE_URL . "?url=product");
            exit;
        }

        $variants = $productModel->getVariants($id);
        $images = $productModel->getProductImages($id);
        $reviews = $productModel->getReviews($id);

        $this->view('product/detail', [
            'title' => $product['TenSanPham'],
            'product' => $product,
            'variants' => $variants,
            'images' => $images,
            'reviews' => $reviews // Truyền biến reviews sang view
        ]);
    }

    public function search()
    {
        $keyword = trim($_GET['keyword'] ?? '');

        // DATA GIẢ (mock)
        $products = [
            ['id' => 1, 'name' => 'Bamboo Brush'],
            ['id' => 2, 'name' => 'Bamboo Towel'],
            ['id' => 3, 'name' => 'Cutlery Set'],
            ['id' => 4, 'name' => 'Laptop Stand']
        ];

        // FILTER
        $results = array_values(array_filter($products, function ($p) use ($keyword) {
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