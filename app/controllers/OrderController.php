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

    private function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập trước khi thanh toán.';
            header('Location: ?url=login');
            exit;
        }
    }

    /**
     * API endpoint: trả về JSON thông tin đơn hàng hoàn thành
     * chưa được thông báo cho user đang đăng nhập.
     * Route: ?url=order/pending-notification  (GET, không cần login guard
     * riêng vì trả về null khi chưa đăng nhập)
     */
    public function pendingNotification()
    {
        header('Content-Type: application/json');
 
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['order' => null]);
            exit;
        }
 
        $pending = $this->orderModel->getPendingDeliveryNotification($userId);
        echo json_encode(['order' => $pending]);
        exit;
    }
 
    /**
     * API endpoint: đánh dấu đơn hàng đã thông báo.
     * Route: ?url=order/mark-notified  (POST)
     * Body: MaDonHang (string)
     */
    public function markNotified()
    {
        header('Content-Type: application/json');
 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
 
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Unauthenticated']);
            exit;
        }
 
        $orderId = trim($_POST['MaDonHang'] ?? '');
        if ($orderId === '') {
            echo json_encode(['success' => false, 'message' => 'Thiếu MaDonHang']);
            exit;
        }
 
        $result = $this->orderModel->markOrderAsNotified($orderId, $userId);
        echo json_encode(['success' => $result]);
        exit;
    }

    // Lấy tóm tắt đơn hàng (tối ưu tính phí ship chuẩn MVC)
    private function getCheckoutSummary()
    {
        $subtotal = $this->cartModel->getSubtotal();
        $discount = $_SESSION['promo']['discount'] ?? 0;
        $deliveryMethod = $_SESSION['checkout_data']['delivery_method'] ?? 'standard';
        $shipping = $this->orderModel->getShippingFee($deliveryMethod);
        $total = max(0, $subtotal - $discount + $shipping);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'promo' => $_SESSION['promo'] ?? null,
        ];
    }

    // Hàm dùng chung để lưu đơn hàng vào SQL và dọn dẹp Session
    private function completeOrder($paymentMethod, $extraData = [])
    {
        try {
            $orderData = [
                'customer' => $_SESSION['checkout_data'] ?? [],
                'items' => $this->cartModel->getItems(),
                'summary' => $this->getCheckoutSummary(),
                'payment_method' => $paymentMethod,
            ];
            
            // Gộp thêm dữ liệu phụ (như 4 số cuối thẻ)
            $orderData = array_merge($orderData, $extraData);

            $order = $this->orderModel->saveOrder($orderData);

            // Xóa giỏ hàng và dữ liệu tạm
            $this->cartModel->clear();
            unset(
                $_SESSION['promo'],
                $_SESSION['payment_old'],
                $_SESSION['payment_errors'],
                $_SESSION['checkout_data']
            );

            // Lưu ID đơn hàng mới nhất để trang success hiển thị đúng
            $_SESSION['latest_order_id'] = $order['MaDonHang'] ?? '';
            $_SESSION['success'] = 'Đơn hàng đã được tạo thành công.';

            header('Location: ?url=order/success');
            exit;
        } catch (Throwable $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?url=checkout');
            exit;
        }
    }

    public function checkout()
    {
        $this->requireLogin();

        $items = $this->cartModel->getItems();

        if (empty($items)) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        $checkoutData = $_SESSION['checkout_data'] ?? [
            'full_name' => '',
            'email' => '',
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
        $this->requireLogin();

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
        $this->requireLogin();

        if (empty($this->cartModel->getItems())) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $checkoutData = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'delivery_method' => trim($_POST['delivery_method'] ?? 'standard'),
                'payment_method' => trim($_POST['payment_method'] ?? 'card'),
            ];

            $_SESSION['checkout_data'] = $checkoutData;
            $errors = $this->orderModel->validateCheckout($checkoutData);

            if (!empty($errors)) {
                $_SESSION['checkout_errors'] = $errors;
                header('Location: ?url=checkout');
                exit;
            }

            // Điều hướng theo phương thức thanh toán
            if ($checkoutData['payment_method'] === 'cod') {
                $this->completeOrder('COD');
            } elseif ($checkoutData['payment_method'] === 'transfer') {
                header('Location: ?url=order/transfer');
                exit;
            } else {
                // card: redirect sang trang nhập thông tin thẻ
                header('Location: ?url=order/payment');
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
        $this->requireLogin();

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

        $last4 = substr(preg_replace('/\D/', '', $paymentData['card_number']), -4);
        $this->completeOrder('Card', ['card_last4' => $last4]);
    }

    public function transfer()
    {
        $this->requireLogin();

        if (empty($this->cartModel->getItems())) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->completeOrder('Transfer');
        }

        $this->view('order/transfer', [
            'title' => 'Chuyển khoản',
            'summary' => $this->getCheckoutSummary(),
        ]);
    }

    public function success()
    {
        $orderId = $_SESSION['latest_order_id'] ?? '';
        $userId = $_SESSION['user_id'] ?? null;
        $order = ($orderId !== '' && $userId)
            ? $this->orderModel->getOrderById($orderId, $userId)
            : $this->orderModel->getLatestOrder();

        $this->view('order/success', [
            'title' => 'Đặt hàng thành công',
            'order' => $order,
            'success' => $_SESSION['success'] ?? '',
        ]);

        unset($_SESSION['success'], $_SESSION['latest_order_id']);
    }

    public function history() 
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user_id']); 

        $this->view('order/history', [
            'title' => 'Lịch sử đơn hàng',
            'orders' => $orders,
        ]);
    }

    public function tracking()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=login');
            exit;
        }

        $maDonHang = $_GET['id'] ?? null;
        if (!$maDonHang) {
            header('Location: ?url=order/history');
            exit;
        }

        $order = $this->orderModel->getOrderById($maDonHang, $_SESSION['user_id']);
        if (!$order) {
            die("Không tìm thấy đơn hàng, hoặc bạn không có quyền xem đơn này!");
        }

        $this->view('order/tracking', [
            'title' => 'Theo dõi đơn hàng',
            'order' => $order,
            'helpMessage' => $_SESSION['help_message'] ?? '',
            'reviewMessage' => $_SESSION['review_message'] ?? '',
        ]);

        unset($_SESSION['help_message'], $_SESSION['review_message']);
    }

    public function help()
    {
        $_SESSION['help_message'] = 'Yêu cầu hỗ trợ đã được ghi nhận. CSKH sẽ liên hệ sớm.';
        $orderId = $_POST['MaDonHang'] ?? $_GET['id'] ?? '';
        header('Location: ?url=order/tracking' . ($orderId ? '&id=' . $orderId : ''));
        exit;
    }

    public function feedback()
    {
        $this->requireLogin();

        $orderId = trim($_GET['id'] ?? '');
        $productId = trim($_GET['product'] ?? '');
        $userId = $_SESSION['user_id'];
        $reviewProduct = null;
        $pageError = '';

        if ($orderId === '' || $productId === '') {
            $pageError = 'Vui lòng chọn sản phẩm trong đơn hàng đã hoàn thành để đánh giá.';
        } else {
            $reviewProduct = $this->orderModel->getReviewableProduct($orderId, $productId, $userId);

            if (!$reviewProduct) {
                $pageError = 'Chỉ có thể đánh giá sản phẩm thuộc đơn hàng đã hoàn thành.';
            } elseif ($this->orderModel->hasUserReviewedProduct($userId, $productId)) {
                $pageError = 'Bạn đã đánh giá sản phẩm này rồi.';
            }
        }

        $this->view('order/feedback', [
            'title' => 'Feedback',
            'order' => ['MaDonHang' => $orderId],
            'product' => $reviewProduct,
            'pageError' => $pageError,
            'errors' => $_SESSION['feedback_errors'] ?? [],
            'success' => $_SESSION['success'] ?? '',
            'old' => $_SESSION['feedback_old'] ?? [],
        ]);
        unset($_SESSION['feedback_errors'], $_SESSION['success'], $_SESSION['feedback_old']);
        return;
    }

    public function submitFeedback()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=order/feedback');
            exit;
        }

        $orderId = trim($_POST['order_id'] ?? '');
        $productId = trim($_POST['product_id'] ?? '');
        $userId = $_SESSION['user_id'];

        $data = [
            'rating' => $_POST['rating'] ?? '',
            'message' => trim($_POST['message'] ?? ''),
        ];
        $_SESSION['feedback_old'] = $data;
        $errors = $this->orderModel->validateFeedback($data);

        if ($orderId === '' || $productId === '') {
            $errors['general'] = 'Thiếu thông tin đơn hàng hoặc sản phẩm.';
        } elseif (!$this->orderModel->getReviewableProduct($orderId, $productId, $userId)) {
            $errors['general'] = 'Chỉ có thể đánh giá sản phẩm thuộc đơn hàng đã hoàn thành.';
        } elseif ($this->orderModel->hasUserReviewedProduct($userId, $productId)) {
            $errors['general'] = 'Bạn đã đánh giá sản phẩm này rồi.';
        }

        if (!empty($errors)) {
            $_SESSION['feedback_errors'] = $errors;
            header('Location: ?url=order/feedback&id=' . urlencode($orderId) . '&product=' . urlencode($productId));
            exit;
        }

        $saved = $this->orderModel->saveProductReview(
            $userId,
            $productId,
            $data['rating'],
            $data['message']
        );

        $_SESSION['review_message'] = $saved
            ? 'Cảm ơn bạn đã đánh giá. Đánh giá đang chờ admin duyệt.'
            : 'Không thể lưu đánh giá, vui lòng thử lại.';

        unset($_SESSION['feedback_old']);
        header('Location: ?url=order/tracking&id=' . urlencode($orderId));
        exit;
    }
}