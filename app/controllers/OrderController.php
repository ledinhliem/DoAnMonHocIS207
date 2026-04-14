<?php
class OrderController extends Controller
{
    public function checkout()
    {
        $this->view('order/checkout', ['title' => 'Thanh toán']);
    }

    public function payment()
    {
        $this->view('order/payment', ['title' => 'Thanh toán thẻ']);
    }

    public function transfer()
    {
        $this->view('order/transfer', ['title' => 'Chuyển khoản']);
    }

    public function feedback()
    {
        $this->view('order/feedback', ['title' => 'Phản hồi đơn hàng']);
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