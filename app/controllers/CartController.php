<?php
require_once __DIR__ . '/../models/CartModel.php';

class CartController extends Controller
{
    private $cartModel;

    public function __construct()
    {
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

        $maSanPham = $_POST['MaSanPham']
            ?? $_POST['ma_san_pham']
            ?? $_POST['product_id']
            ?? $_POST['id']
            ?? '';

        $maBienThe = $_POST['MaBienThe']
            ?? $_POST['ma_bien_the']
            ?? $_POST['variant_id']
            ?? $_POST['variant']
            ?? '';

        $soLuong = $_POST['SoLuong']
            ?? $_POST['so_luong']
            ?? $_POST['quantity']
            ?? 1;

        $result = $this->cartModel->add($maSanPham, $maBienThe, $soLuong);

        $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];

        header('Location: ?url=cart');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=cart');
            exit;
        }

        $maBienThe = $_POST['MaBienThe']
            ?? $_POST['ma_bien_the']
            ?? $_POST['variant_id']
            ?? '';

        $soLuong = $_POST['SoLuong']
            ?? $_POST['so_luong']
            ?? $_POST['quantity']
            ?? 1;

        $result = $this->cartModel->update($maBienThe, $soLuong);

        $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];

        header('Location: ?url=cart');
        exit;
    }

    public function remove()
    {
        $maBienThe = $_GET['MaBienThe']
            ?? $_GET['ma_bien_the']
            ?? $_GET['variant_id']
            ?? '';

        $this->cartModel->remove($maBienThe);

        $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ.';
        header('Location: ?url=cart');
        exit;
    }
}