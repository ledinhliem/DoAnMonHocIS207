<?php
class CartController extends Controller
{
    public function index()
    {
        $this->view('cart/index', ['title' => 'Giỏ hàng']);
    }

    //YL thêm cái này để ấy cái ajax thêm vào giỏ hàng
    public function add()
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!']);
        exit;
    }
}