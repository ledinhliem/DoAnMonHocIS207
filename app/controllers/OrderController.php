<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController extends Controller
{
    private $cartModel;
    private $orderModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
    }

    private function getCheckoutSummary()
    {
        $subtotal = $this->cartModel->getSubtotal();
        $discount = $_SESSION['promo']['discount'] ?? 0;
        $shipping = 5;
        $total = max(0, $subtotal - $discount + $shipping);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'promo' => $_SESSION['promo'] ?? null,
        ];
    }

    public function checkout()
    {
        $items = $this->cartModel->getItems();

        if (empty($items)) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        $checkoutData = $_SESSION['checkout_data'] ?? [
            'full_name' => '',
            'phone' => '',
            'address' => '',
            'delivery_method' => 'standard',
            'payment_method' => 'card',
        ];

        $this->view('order/checkout', [
            'title' => 'Thanh toán',
            'items' => $items,
            'summary' => $this->getCheckoutSummary(),
            'checkoutData' => $checkoutData,
            'errors' => $_SESSION['checkout_errors'] ?? [],
            'success' => $_SESSION['success'] ?? '',
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['checkout_errors'], $_SESSION['success'], $_SESSION['error']);
    }

    public function applyPromo()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=checkout');
            exit;
        }

        $result = $this->orderModel->calculateDiscount(
            $this->cartModel->getSubtotal(),
            $_POST['promo_code'] ?? ''
        );

        if ($result['valid']) {
            $_SESSION['promo'] = $result;
            $_SESSION['success'] = $result['message'];
            unset($_SESSION['error']);
        } else {
            unset($_SESSION['promo']);
            $_SESSION['error'] = $result['message'];
            unset($_SESSION['success']);
        }

        header('Location: ?url=checkout');
        exit;
    }

    public function payment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $checkoutData = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'delivery_method' => trim($_POST['delivery_method'] ?? ''),
                'payment_method' => trim($_POST['payment_method'] ?? ''),
            ];

            $_SESSION['checkout_data'] = $checkoutData;
            $errors = $this->orderModel->validateCheckout($checkoutData);

            if (!empty($errors)) {
                $_SESSION['checkout_errors'] = $errors;
                header('Location: ?url=checkout');
                exit;
            }

            if ($checkoutData['payment_method'] === 'cod') {
                $this->orderModel->saveOrder([
                    'customer' => $checkoutData,
                    'items' => $this->cartModel->getItems(),
                    'summary' => $this->getCheckoutSummary(),
                    'payment_method' => 'COD',
                ]);

                $this->cartModel->clear();
                unset($_SESSION['promo']);

                header('Location: ?url=order/success');
                exit;
            }
        }

        $this->view('order/payment', [
            'title' => 'Thanh toán thẻ',
            'summary' => $this->getCheckoutSummary(),
            'checkoutData' => $_SESSION['checkout_data'] ?? [],
            'errors' => $_SESSION['payment_errors'] ?? [],
            'old' => $_SESSION['payment_old'] ?? [],
        ]);

        unset($_SESSION['payment_errors'], $_SESSION['payment_old']);
    }

    public function processPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=order/payment');
            exit;
        }

        if (empty($this->cartModel->getItems())) {
            $_SESSION['error'] = 'Không có sản phẩm nào để thanh toán.';
            header('Location: ?url=product');
            exit;
        }

        $paymentData = [
            'card_name' => trim($_POST['card_name'] ?? ''),
            'card_number' => trim($_POST['card_number'] ?? ''),
            'card_expiry' => trim($_POST['card_expiry'] ?? ''),
            'card_cvv' => trim($_POST['card_cvv'] ?? ''),
        ];

        $_SESSION['payment_old'] = $paymentData;
        $errors = $this->orderModel->validateCardPayment($paymentData);

        if (!empty($errors)) {
            $_SESSION['payment_errors'] = $errors;
            header('Location: ?url=order/payment');
            exit;
        }

        $this->orderModel->saveOrder([
            'customer' => $_SESSION['checkout_data'] ?? [],
            'items' => $this->cartModel->getItems(),
            'summary' => $this->getCheckoutSummary(),
            'payment_method' => 'Card',
            'card_last4' => substr(preg_replace('/\D/', '', $paymentData['card_number']), -4),
        ]);

        $this->cartModel->clear();
        unset($_SESSION['promo'], $_SESSION['payment_old'], $_SESSION['payment_errors']);

        header('Location: ?url=order/success');
        exit;
    }

    public function transfer()
    {
        $this->view('order/transfer', [
            'title' => 'Chuyển khoản',
            'summary' => $this->getCheckoutSummary(),
        ]);
    }

    public function feedback()
    {
        $this->view('order/feedback', [
            'title' => 'Feedback',
            'order' => $this->orderModel->getLatestOrder(),
            'errors' => $_SESSION['feedback_errors'] ?? [],
            'success' => $_SESSION['success'] ?? '',
            'old' => $_SESSION['feedback_old'] ?? [],
        ]);

        unset($_SESSION['feedback_errors'], $_SESSION['success'], $_SESSION['feedback_old']);
    }

    public function submitFeedback()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=order/feedback');
            exit;
        }

        $data = [
            'rating' => $_POST['rating'] ?? '',
            'message' => trim($_POST['message'] ?? ''),
        ];

        $_SESSION['feedback_old'] = $data;
        $errors = $this->orderModel->validateFeedback($data);

        if (!empty($errors)) {
            $_SESSION['feedback_errors'] = $errors;
            header('Location: ?url=order/feedback');
            exit;
        }

        $_SESSION['success'] = 'Cảm ơn bạn đã gửi feedback.';
        $_SESSION['last_feedback'] = $data;

        header('Location: ?url=order/success');
        exit;
    }

    public function success()
    {
        $this->view('order/success', [
            'title' => 'Đặt hàng thành công',
            'order' => $this->orderModel->getLatestOrder(),
            'success' => $_SESSION['success'] ?? '',
        ]);

        unset($_SESSION['success']);
    }

    public function history()
    {
        $this->view('order/history', [
            'title' => 'Lịch sử đơn hàng',
            'orders' => $this->orderModel->getOrders(),
        ]);
    }

    public function tracking()
    {
        $this->view('order/tracking', [
            'title' => 'Theo dõi đơn hàng',
            'order' => $this->orderModel->getLatestOrder(),
            'helpMessage' => $_SESSION['help_message'] ?? '',
        ]);

        unset($_SESSION['help_message']);
    }

    public function help()
    {
        $_SESSION['help_message'] = 'Yêu cầu hỗ trợ đơn hàng đã được ghi nhận. Bộ phận CSKH sẽ liên hệ sớm.';
        header('Location: ?url=order/tracking');
        exit;
    }
}
