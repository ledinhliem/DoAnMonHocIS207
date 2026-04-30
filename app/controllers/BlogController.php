<?php
require_once __DIR__ . '/../models/BlogModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class BlogController extends Controller
{
    private $blogModel;
    private $productModel;

    public function __construct()
    {
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

    public function detail()
    {
        $id = $_GET['id'] ?? 1;
        $blog = $this->blogModel->getById($id);

        if (!$blog) {
            echo 'Không tìm thấy bài viết';
            return;
        }

        $products = $this->productModel->getAll();

        $this->view('blog/detail', [
            'title' => $blog['title'],
            'blog' => $blog,
            'products' => array_slice($products, 0, 4),
        ]);
    }

    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=blog');
            exit;
        }

        $email = trim($_POST['email'] ?? '');

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ.';
            header('Location: ?url=blog');
            exit;
        }

        $_SESSION['success'] = 'Đăng ký thành công.';
        header('Location: ?url=blog');
        exit;
    }
}
