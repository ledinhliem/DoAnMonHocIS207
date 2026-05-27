<?php
// controllers/ProductController.php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController extends Controller
{
    private ProductModel $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    // ─── LIST / FILTER / PAGINATION ─────────────────────────────────────────
    public function index(): void
    {
        $categoryInput = trim($_GET['category_id'] ?? $_GET['category'] ?? '');

        $filters = [
            'keyword'   => trim($_GET['keyword'] ?? ''),
            'category'  => $this->model->resolveCategoryId($categoryInput),
            'impact'    => trim($_GET['impact'] ?? ''),
            'price_max' => trim($_GET['price_max'] ?? ''),
            'sort'      => trim($_GET['sort'] ?? ''),
        ];

        // Lấy toàn bộ sản phẩm đã lọc từ model
        $allProducts = $this->model->getAll($filters);

        // Phân trang ở controller để không phải sửa ProductModel quá nhiều
        $perPage = 9;
        $totalProducts = count($allProducts);
        $totalPages = max(1, (int)ceil($totalProducts / $perPage));

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, min($currentPage, $totalPages));

        $offset = ($currentPage - 1) * $perPage;
        $products = array_slice($allProducts, $offset, $perPage);

        $categories = $this->model->getCategories();
        $impacts = $this->model->getImpacts();

        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'totalProducts' => $totalProducts,
            'from' => $totalProducts > 0 ? $offset + 1 : 0,
            'to' => min($offset + $perPage, $totalProducts),
        ];

        $this->view('product/index', compact(
            'products',
            'filters',
            'categories',
            'impacts',
            'pagination'
        ));
    }

    // ─── DETAIL ──────────────────────────────────────────────────────────────
    public function detail(): void
    {
        $id = $_GET['id'] ?? '';

        if (!$id) {
            $this->redirect404();
            return;
        }

        $product = $this->model->getById($id);

        if (!$product) {
            $this->redirect404();
            return;
        }

        $images = $this->model->getImages($id);
        $variants = $this->model->getVariants($id);
        $variantGroups = $this->model->groupVariantOptions($variants, $product);
        $reviews = $this->model->getReviews($id);

        $this->view('product/detail', compact('product', 'images', 'variants', 'variantGroups', 'reviews'));
    }

    // ─── SEARCH ──────────────────────────────────────────────────────────────
    public function search(): void
    {
        $keyword = trim($_GET['q'] ?? $_GET['keyword'] ?? '');
        $products = $keyword ? $this->model->search($keyword) : [];

        // Lấy các sản phẩm gợi ý nếu không tìm thấy kết quả
        $suggestions = [];
        if (empty($products) && !empty($keyword)) {
            $suggestions = $this->model->getSuggestions($keyword, 8);
        } else if (empty($keyword)) {
            // Nếu không có từ khóa, hiển thị các sản phẩm gợi ý
            $suggestions = $this->model->getSuggestions('', 8);
        }

        $this->view('product/search', compact('products', 'keyword', 'suggestions'));
    }

    // ─── CART: ADD ───────────────────────────────────────────────────────────
    public function addToCart(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?url=product');
            exit;
        }

        session_start_if_needed();

        $variantId = trim($_POST['MaBienThe'] ?? '');
        $productId = trim($_POST['MaSanPham'] ?? '');
        $qty = max(1, (int)($_POST['SoLuong'] ?? 1));

        // Nếu chưa truyền biến thể thì lấy biến thể đầu tiên của sản phẩm
        if (!$variantId && $productId) {
            $variants = $this->model->getVariants($productId);
            $variantId = $variants[0]['MaBienThe'] ?? '';
        }

        if (!$variantId) {
            $_SESSION['cart_error'] = 'Không tìm thấy biến thể sản phẩm.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=product'));
            exit;
        }

        if (!$this->model->checkStock($variantId, $qty)) {
            $_SESSION['cart_error'] = 'Sản phẩm không đủ tồn kho.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=product'));
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $cart = &$_SESSION['cart'];

        if (isset($cart[$variantId])) {
            $newQty = $cart[$variantId]['quantity'] + $qty;

            if (!$this->model->checkStock($variantId, $newQty)) {
                $newQty = $cart[$variantId]['quantity'];
                $_SESSION['cart_warning'] = 'Đã đạt giới hạn tồn kho.';
            }

            $cart[$variantId]['quantity'] = $newQty;
        } else {
            $variant = $this->model->getVariantById($variantId);

            if (!$variant) {
                $_SESSION['cart_error'] = 'Biến thể không hợp lệ.';
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=product'));
                exit;
            }

            $cart[$variantId] = [
                'variant_id' => $variantId,
                'product_id' => $variant['MaSanPham'],
                'name' => $variant['TenSanPham'],
                'size' => $variant['KichThuoc'],
                'color' => $variant['MauSac'],
                'price' => (float)$variant['GiaTien'],
                'image' => $variant['image'] ?? '',
                'quantity' => $qty,
                'stock' => (int)$variant['SoLuongTon'],
            ];
        }

        $_SESSION['cart_success'] = 'Đã thêm vào giỏ hàng!';

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng!'
            ]);
            exit;
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=cart'));
        exit;
    }

    // ─── CART: VIEW ──────────────────────────────────────────────────────────
    public function cart(): void
    {
        session_start_if_needed();

        $cart = $_SESSION['cart'] ?? [];
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        $this->view('cart/index', compact('cart', 'total'));
    }

    // ─── CART: UPDATE QTY ───────────────────────────────────────────────────
    public function updateCart(): void
    {
        session_start_if_needed();

        $variantId = $_POST['variant_id'] ?? '';
        $qty = (int)($_POST['quantity'] ?? 1);

        if (isset($_SESSION['cart'][$variantId])) {
            if ($qty <= 0) {
                unset($_SESSION['cart'][$variantId]);
            } else {
                if ($this->model->checkStock($variantId, $qty)) {
                    $_SESSION['cart'][$variantId]['quantity'] = $qty;
                } else {
                    $_SESSION['cart_error'] = 'Không đủ tồn kho.';
                }
            }
        }

        header('Location: ' . BASE_URL . '?url=cart');
        exit;
    }

    // ─── CART: REMOVE ───────────────────────────────────────────────────────
    public function removeFromCart(): void
    {
        session_start_if_needed();

        $variantId = $_POST['variant_id'] ?? $_GET['vid'] ?? '';

        if ($variantId && isset($_SESSION['cart'][$variantId])) {
            unset($_SESSION['cart'][$variantId]);
        }

        header('Location: ' . BASE_URL . '?url=cart');
        exit;
    }

    private function redirect404(): void
    {
        http_response_code(404);
        echo '<h1>404 – Không tìm thấy sản phẩm</h1>';
    }
}

// Helper
function session_start_if_needed(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
