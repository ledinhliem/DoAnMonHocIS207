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

        $this->view('product/index', [
            'title'      => 'Sản phẩm',
            'products'   => $this->productModel->getAll($filters),
            'filters'    => $filters,
            'categories' => $this->productModel->getCategories(),
            'impacts'    => $this->productModel->getImpacts(),
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? '';

        if ($id === '') {
            echo 'Thiếu mã sản phẩm';
            return;
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo 'Không tìm thấy sản phẩm';
            return;
        }

        $variants = $this->productModel->getVariantsByProductId($id);
        $images = $this->productModel->getImagesByProductId($id);
        $reviews = $this->productModel->getReviewsByProductId($id);

        $this->view('product/detail', [
            'title' => $product['TenSanPham'],
            'product' => $product,
            'variants' => $variants,
            'images' => $images,
            'reviews' => $reviews,
        ]);
    }

    public function search()
    {
        $this->index();
    }
}