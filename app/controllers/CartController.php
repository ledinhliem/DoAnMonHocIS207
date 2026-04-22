<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class CartController extends Controller
{
    private $productModel;
    private $cartModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
    }

    public function index()
    {
        $this->view('cart/index', [
            'title' => 'Giỏ hàng',
            'items' => $this->cartModel->getItems(),
            'subtotal' => $this->cartModel->getSubtotal(),
            'success' => $_SESSION['success'] ?? '',
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=product');
            exit;
        }

        $productId = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;

        $product = $this->productModel->getById($productId);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm để thêm vào giỏ.';
            header('Location: ?url=product');
            exit;
        }

        $this->cartModel->add($product, $quantity);

        $_SESSION['success'] = 'Đã thêm "' . $product['name'] . '" vào giỏ hàng.';
        header('Location: ?url=cart');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=cart');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;

        $this->cartModel->update($id, $quantity);
        $_SESSION['success'] = 'Cập nhật giỏ hàng thành công.';

        header('Location: ?url=cart');
        exit;
    }

    public function remove()
    {
        $id = $_GET['id'] ?? 0;
        $this->cartModel->remove($id);

        $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ.';
        header('Location: ?url=cart');
        exit;
    }
}