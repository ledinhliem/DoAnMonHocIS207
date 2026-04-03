<?php
class OrderController extends Controller
{
    public function checkout()
    {
        $this->view('order/checkout', ['title' => 'Thanh toán']);
    }

    public function success()
    {
        $this->view('order/success', ['title' => 'Đặt hàng thành công']);
    }

    public function history()
    {
        $this->view('order/history', ['title' => 'Lịch sử đơn hàng']);
    }

    public function tracking()
    {
        $this->view('order/tracking', ['title' => 'Theo dõi đơn hàng']);
    }
}