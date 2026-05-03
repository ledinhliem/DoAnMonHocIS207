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

    // ─── LIST / FILTER ───────────────────────────────────────────────────────
    public function index(): void
    {
        $filters = [
            'keyword'   => trim($_GET['keyword']   ?? ''),
            'category'  => trim($_GET['category']  ?? ''),
            'impact'    => trim($_GET['impact']     ?? ''),
            'price_max' => trim($_GET['price_max']  ?? ''),
            'sort'      => trim($_GET['sort']       ?? ''),
        ];

        $products   = $this->model->getAll($filters);
        $categories = $this->model->getCategories();
        $impacts    = $this->model->getImpacts();

        $this->view('product/index', compact('products', 'filters', 'categories', 'impacts'));
    }

    // ─── DETAIL ──────────────────────────────────────────────────────────────
    public function detail(): void
    {
        $id = $_GET['id'] ?? '';
        if (!$id) { $this->redirect404(); return; }

        $product  = $this->model->getById($id);
        if (!$product) { $this->redirect404(); return; }

        $images   = $this->model->getImages($id);
        $variants = $this->model->getVariants($id);
        $reviews  = $this->model->getReviews($id);

        $this->view('product/detail', compact('product', 'images', 'variants', 'reviews'));
    }

    // ─── SEARCH ──────────────────────────────────────────────────────────────
    public function search(): void
    {
        $keyword  = trim($_GET['q'] ?? $_GET['keyword'] ?? '');
        $products = $keyword ? $this->model->search($keyword) : [];

        $this->view('product/search', compact('products', 'keyword'));
    }

    // ─── CART: ADD ────────────────────────────────────────────────────────────
    public function addToCart(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?url=product');
            exit;
        }

        session_start_if_needed();

        $variantId = trim($_POST['MaBienThe']  ?? '');
        $productId = trim($_POST['MaSanPham']  ?? '');
        $qty       = max(1, (int)($_POST['SoLuong'] ?? 1));

        // Resolve variantId: if not provided, pick first variant of product
        if (!$variantId && $productId) {
            $variants  = $this->model->getVariants($productId);
            $variantId = $variants[0]['MaBienThe'] ?? '';
        }

        if (!$variantId) {
            $_SESSION['cart_error'] = 'Không tìm thấy biến thể sản phẩm.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=product'));
            exit;
        }

        // Stock check
        if (!$this->model->checkStock($variantId, $qty)) {
            $_SESSION['cart_error'] = 'Sản phẩm không đủ tồn kho.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=product'));
            exit;
        }

        // Add to session cart
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $cart = &$_SESSION['cart'];

        if (isset($cart[$variantId])) {
            $newQty = $cart[$variantId]['quantity'] + $qty;
            // Re-check stock for accumulated qty
            if (!$this->model->checkStock($variantId, $newQty)) {
                $newQty = $cart[$variantId]['quantity']; // cap at current
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
                'variant_id'  => $variantId,
                'product_id'  => $variant['MaSanPham'],
                'name'        => $variant['TenSanPham'],
                'size'        => $variant['KichThuoc'],
                'color'       => $variant['MauSac'],
                'price'       => (float)$variant['GiaTien'],
                'image'       => $variant['image'] ?? '',
                'quantity'    => $qty,
                'stock'       => (int)$variant['SoLuongTon'],
            ];
        }

        $_SESSION['cart_success'] = 'Đã thêm vào giỏ hàng!';

        // BUG FIX: Trả JSON cho AJAX fetch từ product.js (showToast cần data.success + data.message)
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
               || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!']);
            exit;
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . '?url=cart'));
        exit;
    }

    // ─── CART: VIEW ───────────────────────────────────────────────────────────
    public function cart(): void
    {
        session_start_if_needed();
        $cart  = $_SESSION['cart'] ?? [];
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $this->view('cart/index', compact('cart', 'total'));
    }

    // ─── CART: UPDATE QTY ────────────────────────────────────────────────────
    public function updateCart(): void
    {
        session_start_if_needed();
        $variantId = $_POST['variant_id'] ?? '';
        $qty       = (int)($_POST['quantity'] ?? 1);

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

    // ─── CART: REMOVE ────────────────────────────────────────────────────────
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
    if (session_status() === PHP_SESSION_NONE) session_start();
}