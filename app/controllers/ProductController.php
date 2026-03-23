<?php

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductModel');
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();

        $data = [
            'title' => 'Danh sách sản phẩm bền vững',
            'products' => $products
        ];

        $this->view('product/index', $data);
    }

    public function detail($id = null)
    {
        if (!$id || !is_numeric($id)) {
            echo "Mã sản phẩm không hợp lệ.";
            return;
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        $images = $this->productModel->getProductImages($id);
        $variants = $this->productModel->getProductVariants($id);
        $certificates = $this->productModel->getProductCertificates($id);

        $data = [
            'title' => 'Chi tiết sản phẩm',
            'product' => $product,
            'images' => $images,
            'variants' => $variants,
            'certificates' => $certificates
        ];

        $this->view('product/detail', $data);
    }
}