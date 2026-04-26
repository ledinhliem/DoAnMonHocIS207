<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $filters = [
            'keyword'   => $_GET['keyword'] ?? '',
            'category'  => $_GET['category'] ?? '',
            'impact'    => $_GET['impact'] ?? '',
            'price_max' => $_GET['price_max'] ?? '',
            'sort'      => $_GET['sort'] ?? '',
        ];

        $products = $this->productModel->getAll($filters);

        $this->view('product/index', [
            'title'      => 'Sản phẩm',
            'products'   => $products,
            'filters'    => $filters,
            'categories' => $this->productModel->getCategories(),
            'impacts'    => $this->productModel->getImpacts(),
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 1;
        $product = $this->productModel->getById($id);

        if (!$product) {
            echo 'Không tìm thấy sản phẩm';
            return;
        }

        $this->view('product/detail', [
            'title' => 'Chi tiết sản phẩm',
            'product' => $product,
        ]);
    }

    public function search()
    {
        $this->index();
    }
}