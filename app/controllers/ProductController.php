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

        $categories = $this->productModel->getCategories();
        $sanPham = [
            'MaSanPham' => $product['id'],
            'TenSanPham' => $product['name'],
            'TenDanhMuc' => $categories[$product['category']] ?? 'Sản phẩm',
            'TenVatLieu' => 'Vật liệu thân thiện môi trường',
            'NguonGoc' => 'Zentro',
            'TacDongMoiTruong' => $product['impact'],
            'DiemXanh' => (int) round(($product['rating'] / 5) * 100),
            'CoTaiChe' => $product['impact'] === 'upcycled',
            'ThanThienMoiTruong' => true,
            'MoTa' => $product['description'],
        ];

        $hinhAnh = [
            ['DuongDan' => $product['image']],
        ];

        $bienThe = [
            [
                'MaBienThe' => $product['id'],
                'MauSac' => 'Tự nhiên',
                'KichThuoc' => 'Tiêu chuẩn',
                'GiaTien' => $product['price'],
                'SoLuongTon' => 99,
            ],
        ];

        $this->view('product/detail', [
            'title' => 'Chi tiết sản phẩm',
            'product' => $sanPham,
            'images' => $hinhAnh,
            'variants' => $bienThe,
            'reviews' => [],
        ]);
    }

    public function search()
    {
        $this->index();
    }
}
