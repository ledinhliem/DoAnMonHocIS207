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

        $maSanPham = $_POST['ma_san_pham'] ?? 0;
        $soLuong = $_POST['so_luong'] ?? 1;
        $laAjax = !empty($_POST['ma_bien_the']);

        $product = $this->productModel->getById($maSanPham);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm để thêm vào giỏ.';

            if ($laAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $_SESSION['error']]);
                exit;
            }

            header('Location: ?url=product');
            exit;
        }

        $this->cartModel->add($product, $soLuong);

        $_SESSION['success'] = 'Đã thêm "' . $product['name'] . '" vào giỏ hàng.';

        if ($laAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => $_SESSION['success']]);
            exit;
        }

        header('Location: ?url=cart');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=cart');
            exit;
        }

        $maSanPham = $_POST['ma_san_pham'] ?? 0;
        $soLuong = $_POST['so_luong'] ?? 1;

        $this->cartModel->update($maSanPham, $soLuong);
        $_SESSION['success'] = 'Cập nhật giỏ hàng thành công.';

        header('Location: ?url=cart');
        exit;
    }

    public function remove()
    {
        $maSanPham = $_GET['ma_san_pham'] ?? 0;
        $this->cartModel->remove($maSanPham);

        $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ.';
        header('Location: ?url=cart');
        exit;
    }
}
