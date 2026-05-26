<?php

require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/GameModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';

class HomeController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel();
        $gameModel = new GameModel();
        $voucherModel = new VoucherModel();

        // Lấy danh mục để các link ở Home lọc đúng danh mục sản phẩm
        $categories = $productModel->getCategories();

        // Sản phẩm nổi bật trên Home.
        // Ưu tiên P020 vì trong database mới có sản phẩm P020-P029 do Phúc bổ sung.
        $featuredProduct = $productModel->getById('P020');

        // Nếu máy nào chưa import P020 thì lấy tạm 1 sản phẩm Fashion làm fallback
        if (!$featuredProduct) {
            $fashionProducts = $productModel->getAll(['category' => 'C003']);
            $featuredProduct = $fashionProducts[0] ?? null;
        }

        $featuredImages = [];
        $featuredVariants = [];
        $todayPlay = !empty($_SESSION['user_id'])
            ? $gameModel->getTodayPlay((string)$_SESSION['user_id'])
            : null;
        $userVouchers = !empty($_SESSION['user_id'])
            ? $voucherModel->getUserVouchers((string)$_SESSION['user_id'])
            : [];

        if ($featuredProduct && !empty($featuredProduct['MaSanPham'])) {
            $featuredImages = $productModel->getImages($featuredProduct['MaSanPham']);
            $featuredVariants = $productModel->getVariants($featuredProduct['MaSanPham']);
        }

        $this->view('home/index', [
            'title' => 'Trang chủ - Zentro',
            'categories' => $categories,
            'featuredProduct' => $featuredProduct,
            'featuredImages' => $featuredImages,
            'featuredVariants' => $featuredVariants,
            'todayPlay' => $todayPlay,
            'userVouchers' => $userVouchers,
        ]);
    }
}
