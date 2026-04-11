<?php
class ProductController extends Controller
{
    public function index()
    {
        $this->view('product/index', ['title' => 'Sản phẩm']);
    }

    public function detail($id) {
        $productModel = $this->model('ProductModel');
        
        $product = $productModel->getProductById($id);
        if (!$product) {
            // Xử lý khi không tìm thấy sản phẩm
            header("Location: " . BASE_URL . "?url=product");
            exit;
        }

        $variants = $productModel->getVariants($id);
        $images = $productModel->getProductImages($id);

        $this->view('product/detail', [
            'title' => $product['TenSanPham'],
            'product' => $product,
            'variants' => $variants,
            'images' => $images
        ]);
    }

    public function search()
    {
        $this->view('product/search', ['title' => 'Tìm kiếm']);
    }
}