<?php

require_once __DIR__ . '/../models/BlogModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class BlogController extends Controller
{
    private $blogModel;
    private $productModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->blogModel = new BlogModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $blogs = $this->blogModel->getAll();

        $this->view('blog/index', [
            'title' => 'Blog',
            'blogs' => $blogs,
            'success' => $_SESSION['success'] ?? '',
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function detail($id = null)
    {
        // Hỗ trợ cả 2 dạng link:
        // ?url=blog/detail&id=BL004
        // ?url=blog/detail/BL004
        $id = $id ?? ($_GET['id'] ?? '');

        if ($id === '') {
            echo 'Thiếu mã bài viết.';
            return;
        }

        $blog = $this->blogModel->getById($id);

        if (!$blog) {
            echo 'Không tìm thấy bài viết.';
            return;
        }

        $relatedData = $this->getRelatedProductsForBlog($blog, $id);

        $this->view('blog/detail', [
            'title' => $blog['title'] ?? 'Blog',
            'blog' => $blog,
            'products' => $relatedData['products'],
            'relatedTitle' => $relatedData['title'],
            'relatedDescription' => $relatedData['description'],
            'relatedCollectionUrl' => $relatedData['collectionUrl'],
        ]);
    }

    private function getRelatedProductsForBlog(array $blog, string $blogId): array
    {
        /*
            ID blog thực tế trong web hiện tại:
            BL004 = Limloop tái sinh rác thải nhựa
            BL003 = Tẩy da chết thuần chay
            BL002 = Công nghệ vải sợi cà phê
            BL001 = Hành trình Zero Waste

            Sản phẩm vẫn lấy từ cửa hàng bằng ProductModel->getAll().
            Ở đây chỉ chọn đúng mã sản phẩm phù hợp với từng blog.
        */

        $productIds = [];
        $relatedTitle = 'Sản phẩm sống xanh liên quan';
        $relatedDescription = 'Các sản phẩm được lấy trực tiếp từ cửa hàng Zentro và chọn theo chủ đề bài viết.';
        $collectionUrl = '?url=product';

        if ($blogId === 'BL004') {
            // Limloop: rác thải nhựa, tái chế, thủ công
            // Chọn sản phẩm liên quan trực tiếp đến tái chế, giảm nhựa, upcycling.
            $productIds = ['P007', 'P010', 'P003', 'P008'];

            $relatedTitle = 'Sản phẩm tái chế và giảm nhựa';
            $relatedDescription = 'Gợi ý các sản phẩm trong cửa hàng phù hợp với tinh thần tái sinh vật liệu, giảm rác thải nhựa và kéo dài vòng đời sản phẩm như câu chuyện Limloop.';
            $collectionUrl = '?url=product&impact=tái%20chế';
        } elseif ($blogId === 'BL003') {
            // Tẩy da chết thuần chay: skincare, mỹ phẩm, hạt vi nhựa
            $productIds = ['P001', 'P002', 'P028', 'P029'];

            $relatedTitle = 'Sản phẩm chăm sóc cá nhân xanh';
            $relatedDescription = 'Gợi ý các sản phẩm chăm sóc cá nhân trong cửa hàng, phù hợp với chủ đề thuần chay, lành tính và hạn chế hạt vi nhựa.';
            $collectionUrl = '?url=product&category=C004';
        } elseif ($blogId === 'BL002') {
            // Vải sợi cà phê: thời trang tuần hoàn, chất liệu mới
            $productIds = ['P005', 'P006', 'P020', 'P022'];

            $relatedTitle = 'Sản phẩm thời trang bền vững';
            $relatedDescription = 'Gợi ý các sản phẩm thời trang trong cửa hàng, phù hợp với chủ đề vải sợi cà phê, vật liệu tái chế và thời trang tuần hoàn.';
            $collectionUrl = '?url=product&category=C003';
        } elseif ($blogId === 'BL001') {
            // Hành trình Zero Waste: đồ dùng hằng ngày, giảm rác
            $productIds = ['P003', 'P004', 'P008', 'P011'];

            $relatedTitle = 'Sản phẩm zero-waste cho thói quen hằng ngày';
            $relatedDescription = 'Gợi ý các sản phẩm trong cửa hàng giúp giảm nhựa dùng một lần, thay thế đồ dùng khó phân hủy và bắt đầu lối sống zero-waste.';
            $collectionUrl = '?url=product&category=C001';
        }

        $products = $this->getProductsByIdsFromStore($productIds);

        return [
            'products' => $products,
            'title' => $relatedTitle,
            'description' => $relatedDescription,
            'collectionUrl' => $collectionUrl,
        ];
    }

    private function getProductsByIdsFromStore(array $ids): array
    {
        $allProducts = $this->productModel->getAll();
        $productMap = [];

        foreach ($allProducts as $product) {
            $productId = $product['MaSanPham'] ?? $product['id'] ?? '';

            if ($productId !== '') {
                $productMap[$productId] = $product;
            }
        }

        $selectedProducts = [];

        foreach ($ids as $id) {
            if (isset($productMap[$id])) {
                $selectedProducts[] = $productMap[$id];
            }
        }

        return $selectedProducts;
    }
}