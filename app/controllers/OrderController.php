<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';
use SePay\SePayClient;
use SePay\Builders\CheckoutBuilder;

class OrderController extends Controller
{
    private $cartModel;
    private $orderModel;
    private $userModel;
    private $voucherModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->voucherModel = new VoucherModel();
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

    //Lọc danh sách sản phẩm ĐÃ ĐƯỢC CHỌN từ giỏ hàng để mang đi thanh toán
    private function getFilteredCartItems()
    {
        $allItems = $this->cartModel->getItems() ?? [];
        $selectedKeys = $_SESSION['selected_cart_keys'] ?? [];

        // Nếu không tìm thấy vết session đã chọn (ví dụ user F5 hoặc vào trực tiếp link), mặc định chọn cả giỏ hàng
        if (empty($selectedKeys)) {
            return $allItems;
        }

        $filtered = [];
        foreach ($allItems as $key => $item) {
            // Kiểm tra khớp theo mã key mảng hoặc thuộc tính ID sản phẩm gửi lên
            $cartKey = (string)$key;
            $variantId = (string)($item['MaBienThe'] ?? $item['variant_id'] ?? '');
            $itemId = (string)($item['id'] ?? '');

            if (
                in_array($cartKey, $selectedKeys, true) ||
                ($variantId !== '' && in_array($variantId, $selectedKeys, true)) ||
                ($itemId !== '' && in_array($itemId, $selectedKeys, true))
            ) {
                $filtered[$key] = $item;
            }
        }
        return !empty($filtered) ? $filtered : $allItems;
    }

    // Tối ưu hàm tính toán hóa đơn: nhận danh sách món đã lọc để tính tiền chính xác
    private function getCheckoutSummary(?array $items = null)
    {
        $items = $items ?? $this->getFilteredCartItems();
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        if (!empty($_SESSION['promo']['code'])) {
            $promoResult = $this->orderModel->calculateDiscount($items, (string)$_SESSION['promo']['code']);
            if (!empty($promoResult['valid'])) {
                $_SESSION['promo'] = $promoResult;
            } else {
                unset($_SESSION['promo']);
            }
        }

        $discount = max(0, min((float)($_SESSION['promo']['discount'] ?? 0), $subtotal));
        $deliveryMethod = $_SESSION['checkout_data']['delivery_method'] ?? 'standard';
        $shipping = $this->orderModel->getShippingFee($deliveryMethod);
        if (!empty($_SESSION['promo']['free_shipping'])) {
            $shipping = 0;
        }
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
    private function buildCheckoutDataFromUser(array $user): array
    {
        $fullAddress = '';
        if (!empty($user['SoNha_Duong'])) {
            $addressParts = array_filter([
                $user['SoNha_Duong'] ?? '',
                $user['PhuongXa'] ?? '',
                $user['QuanHuyen'] ?? '',
                $user['TinhThanh'] ?? '',
            ]);
            $fullAddress = implode(', ', $addressParts);
        }

        return [
            'full_name' => $user['HoTen'] ?? '',
            'email' => $user['Email'] ?? '',
            'phone' => $user['SoDienThoai'] ?? '',
            'address' => $fullAddress,
            'delivery_method' => 'standard',
            'payment_method' => 'cod',
        ];
    }

    private function completeOrder($paymentMethod, $extraData = [])
    {
        try {
            $items = $this->getFilteredCartItems();
            if (empty($items)) {
                throw new RuntimeException('Giỏ hàng thanh toán đang trống.');
            }

            $orderData = [
                'customer' => $_SESSION['checkout_data'] ?? [],
                'items' => $items,
                'summary' => $this->getCheckoutSummary($items),
                'payment_method' => $paymentMethod,
            ];

            // Gộp thêm dữ liệu phụ (như 4 số cuối thẻ)
            $orderData = array_merge($orderData, $extraData);

            $order = $this->orderModel->saveOrder($orderData);

            // 🌟 CHỈ XÓA CÁC SẢN PHẨM ĐÃ THANH TOÁN KHỎI GIỎ HÀNG
            foreach ($items as $key => $item) {
                $cartKey = $item['MaBienThe'] ?? $item['variant_id'] ?? $key;
                if (method_exists($this->cartModel, 'removeItem')) {
                    $this->cartModel->removeItem($cartKey);
                } elseif (method_exists($this->cartModel, 'delete')) {
                    $this->cartModel->delete($cartKey);
                } elseif (method_exists($this->cartModel, 'remove')) {
                    $this->cartModel->remove($cartKey);
                } else {
                    unset($_SESSION['cart'][$cartKey]);
                }
            }

            unset(
                $_SESSION['promo'],
                $_SESSION['payment_old'],
                $_SESSION['payment_errors'],
                $_SESSION['checkout_data'],
                $_SESSION['pending_transfer_order_code'],
                $_SESSION['pending_transfer_token'],
                $_SESSION['selected_cart_keys'] // Xóa lịch sử ghi nhớ tích chọn sản phẩm
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

    // Hứng danh sách sản phẩm được chọn từ giỏ hàng.
    // Sau khi nhận POST thì redirect sang GET để tránh lỗi Confirm Form Resubmission.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_items'])) {
        $_SESSION['selected_cart_keys'] = $_POST['selected_items'];

        header('Location: ?url=order/checkout');
        exit;
    }

    $items = $this->getFilteredCartItems();

    if (empty($items)) {
        $_SESSION['error'] = 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.';
        header('Location: ?url=cart');
        exit;
    }

    // Lấy thông tin user từ database
    $userId = $_SESSION['user_id'];
    $user = $this->userModel->getUserInfo($userId);

    $profileCheckoutData = $this->buildCheckoutDataFromUser($user ?: []);
    $sessionCheckoutData = $_SESSION['checkout_data'] ?? [];
    $checkoutData = $profileCheckoutData;
    $checkoutData['delivery_method'] = $sessionCheckoutData['delivery_method'] ?? $profileCheckoutData['delivery_method'];
    $checkoutData['payment_method'] = $sessionCheckoutData['payment_method'] ?? $profileCheckoutData['payment_method'];

    // Lấy danh sách Voucher từ DB để View render "Ví Voucher"
    $availablePromos = $this->orderModel->getAvailablePromos();
    $userVouchers = $this->voucherModel->getUserVouchers((string)($_SESSION['user_id'] ?? ''));
    $gameOnlyCodes = ['GAME5', 'GAME10', 'FREESHIP'];
    $availablePromos = array_values(array_filter($availablePromos, function ($promo) use ($gameOnlyCodes) {
        return !in_array((string)($promo['MaGiamGia'] ?? ''), $gameOnlyCodes, true);
    }));

    if (!empty($userVouchers)) {
        $availablePromos = array_merge($userVouchers, $availablePromos);
    }

    $availablePromos = $this->uniquePromosByCode($availablePromos);

    $this->view('order/checkout', [
        'title' => 'Thanh toán',
        'items' => $items,
        'summary' => $this->getCheckoutSummary($items),
        'checkoutData' => $checkoutData,
        'availablePromos' => $availablePromos,
        'userVouchers' => $userVouchers,
        'errors' => $_SESSION['checkout_errors'] ?? [],
        'success' => $_SESSION['success'] ?? '',
        'error' => $_SESSION['error'] ?? '',
    ]);

    unset($_SESSION['checkout_errors'], $_SESSION['success'], $_SESSION['error']);
}

    // --- 2. HÀM ÁP MÃ GIẢM GIÁ: Đã fix Voucher thông minh và Hủy mã ---
    public function applyPromo()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=checkout');
            exit;
        }

        $promoCode = trim($_POST['promo_code'] ?? '');

        if ($promoCode === '') {
            unset($_SESSION['promo']);
            $_SESSION['success'] = 'Đã hủy áp dụng mã giảm giá.';
            unset($_SESSION['error']);
            header('Location: ?url=checkout');
            exit;
        }

        // Truyền $this->cartModel->getItems() để check Danh Mục
        $items = $this->getFilteredCartItems();
        if ($this->isGameOnlyPromo($promoCode) && !$this->userOwnsVoucher($promoCode)) {
            unset($_SESSION['promo']);
            $_SESSION['error'] = 'Mã này chỉ dùng khi bạn trúng từ vòng quay xanh.';
            unset($_SESSION['success']);
            header('Location: ?url=checkout');
            exit;
        }

        $result = $this->orderModel->calculateDiscount(
            $items,
            $promoCode
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

    private function isGameOnlyPromo(string $code): bool
    {
        return in_array(strtoupper(trim($code)), ['GAME5', 'GAME10', 'FREESHIP'], true);
    }

    private function userOwnsVoucher(string $code): bool
    {
        $code = strtoupper(trim($code));
        $userVouchers = $this->voucherModel->getUserVouchers((string)($_SESSION['user_id'] ?? ''));

        foreach ($userVouchers as $voucher) {
            if (($voucher['MaGiamGia'] ?? '') === $code) {
                return true;
            }
        }

        return false;
    }

    private function uniquePromosByCode(array $promos): array
    {
        $seen = [];
        $unique = [];

        foreach ($promos as $promo) {
            $code = (string)($promo['MaGiamGia'] ?? '');
            if ($code === '' || isset($seen[$code])) {
                continue;
            }

            $seen[$code] = true;
            $unique[] = $promo;
        }

        return $unique;
    }

    public function payment()
    {
        $this->requireLogin();
        $items = $this->getFilteredCartItems();

        if (empty($items)) {
            $_SESSION['error'] = 'Giỏ hàng thanh toán đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->getUserInfo($_SESSION['user_id']);
            $profileCheckoutData = $this->buildCheckoutDataFromUser($user ?: []);

            $checkoutData = [
                'full_name' => trim($_POST['full_name'] ?? $profileCheckoutData['full_name'] ?? ''),
                'email' => trim($_POST['email'] ?? $profileCheckoutData['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? $profileCheckoutData['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? $profileCheckoutData['address'] ?? ''),
                'delivery_method' => trim($_POST['delivery_method'] ?? 'standard'),
                'payment_method' => trim($_POST['payment_method'] ?? 'cod'),
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
                $_SESSION['checkout_errors'] = [
                    'payment_method' => 'Phuong thuc thanh toan khong hop le.'
                ];
                header('Location: ?url=checkout');
                exit;
            }
        }

        header('Location: ?url=checkout');
        exit;

    }

    public function processPayment()
    {
        $this->requireLogin();

        $_SESSION['error'] = 'Phuong thuc thanh toan the tin dung da duoc tat.';
        header('Location: ?url=checkout');
        exit;
    }

    // --- 3. HÀM TRANSFER (Chuyển hướng qua cổng SePay bằng SDK chuẩn) ---
    public function transfer()
    {
        $this->requireLogin();
        $items = $this->getFilteredCartItems();

        if (empty($items)) {
            $_SESSION['error'] = 'Giỏ hàng đang trống.';
            header('Location: ?url=cart');
            exit;
        }

        $summary = $this->getCheckoutSummary();
        $totalAmount = (int)($summary['total'] ?? 0);

        // Tạo và giữ mã thanh toán trong session để khi SePay trả về còn hoàn tất được đơn.
        $orderCode = $_SESSION['pending_transfer_order_code'] ?? ('ZN' . rand(100000, 999999));
        $_SESSION['pending_transfer_order_code'] = $orderCode;
        $paymentToken = $_SESSION['pending_transfer_token'] ?? bin2hex(random_bytes(16));
        $_SESSION['pending_transfer_token'] = $paymentToken;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->completeOrder('Transfer', ['transfer_code' => $orderCode]);
        }

        if (
            !class_exists(SePayClient::class) ||
            !class_exists(CheckoutBuilder::class) ||
            !defined('SEPAY_MERCHANT_ID') ||
            !defined('SEPAY_SECRET_KEY') ||
            SEPAY_MERCHANT_ID === '' ||
            SEPAY_SECRET_KEY === ''
        ) {
            $this->view('order/transfer', [
                'title' => 'Chuyển khoản',
                'summary' => $summary,
                'totalAmount' => $totalAmount,
                'orderCode' => $orderCode,
                'qrUrl' => $this->orderModel->generateVietQRUrl($totalAmount, $orderCode),
            ]);
            return;
        }

        // 1. Khởi tạo SePay Client (Cần lấy 2 tham số này trên my.sepay.vn)
        $merchantId = SEPAY_MERCHANT_ID;
        $secretKey = SEPAY_SECRET_KEY;
        
        $sepayClient = new SePayClient(
            $merchantId, 
            $secretKey,
            SePayClient::ENVIRONMENT_PRODUCTION
        );

        // 2. Sử dụng CheckoutBuilder đúng cú pháp của SePay SDK
        $checkoutData = CheckoutBuilder::make()
            ->currency('VND')
            ->orderAmount($totalAmount)
            ->operation('PURCHASE')
            ->orderDescription('Thanh toan don hang ' . $orderCode) // Viết không dấu cho an toàn
            ->orderInvoiceNumber($orderCode)
            ->successUrl(BASE_URL . '?url=order/success&payment_token=' . urlencode($paymentToken)) // Link trả về khi thanh toán thành công
            ->cancelUrl(BASE_URL . '?url=checkout')       // Link trả về nếu khách bấm hủy
            ->build();

        try {
            // SDK sinh ra form HTML chứa mã hóa
            $formHtml = $sepayClient->checkout()->generateFormHtml($checkoutData);
            
            // Xây dựng màn hình chờ "ảo ma" và dùng Javascript tự động submit form
            echo '<!DOCTYPE html>
            <html lang="vi">
            <head>
                <meta charset="UTF-8">
                <title>Đang chuyển hướng thanh toán...</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body { font-family: "Segoe UI", Arial, sans-serif; text-align: center; margin-top: 15vh; background-color: #f8f9fa; color: #333; }
                    .loader { border: 4px solid #e2e8f0; border-top: 4px solid #2b4c2b; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px; }
                    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                    h2 { font-size: 24px; margin-bottom: 10px; color: #1e361e; }
                    p { font-size: 16px; color: #666; }
                </style>
            </head>
            <body>
                <div class="loader"></div>
                <h2>Đang kết nối cổng thanh toán bảo mật SePay...</h2>
                <p>Vui lòng không đóng trình duyệt trong lúc này.</p>
                
                <div style="display: none;">
                    ' . $formHtml . '
                </div>
                
                <script>
                    window.onload = function() {
                        document.forms[0].submit();
                    };
                </script>
            </body>
            </html>';
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi kết nối cổng thanh toán: ' . $e->getMessage();
            header('Location: ?url=checkout');
            exit;
        }
    }

    public function success()
    {
        $pendingPaymentMethod = $_SESSION['checkout_data']['payment_method'] ?? '';
        $expectedToken = $_SESSION['pending_transfer_token'] ?? '';
        $actualToken = $_GET['payment_token'] ?? '';
        $isVerifiedTransferReturn = $pendingPaymentMethod === 'transfer'
            && $expectedToken !== ''
            && hash_equals((string)$expectedToken, (string)$actualToken);

        if ($isVerifiedTransferReturn && !empty($this->getFilteredCartItems()) && empty($_SESSION['latest_order_id'])) {
            $this->completeOrder(
                'Transfer',
                ['transfer_code' => $_SESSION['pending_transfer_order_code'] ?? null]
            );
        }

        $orderId = $_SESSION['latest_order_id'] ?? '';
        $userId = $_SESSION['user_id'] ?? null;
        $order = ($orderId !== '' && $userId)
            ? $this->orderModel->getOrderById($orderId, $userId)
            : null;

        if (!$order) {
            $_SESSION['error'] = 'Khong tim thay don hang vua thanh toan. Vui long quay lai gio hang hoac lich su don hang.';
            header('Location: ?url=checkout');
            exit;
        }

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
            'orderMessage' => $_SESSION['order_message'] ?? '',
            'orderMessageStatus' => $_SESSION['order_message_status'] ?? '',
        ]);
        unset($_SESSION['order_message'], $_SESSION['order_message_status']);
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
            'orderMessage' => $_SESSION['order_message'] ?? '',
            'orderMessageStatus' => $_SESSION['order_message_status'] ?? '',
        ]);

        unset($_SESSION['help_message'], $_SESSION['review_message'], $_SESSION['order_message'], $_SESSION['order_message_status']);
    }

    public function cancel()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=order/history');
            exit;
        }

        $orderId = trim($_POST['MaDonHang'] ?? '');
        $redirect = trim($_POST['redirect'] ?? 'history');

        if ($orderId === '') {
            $_SESSION['order_message_status'] = 'error';
            $_SESSION['order_message'] = 'Thiếu mã đơn hàng cần hủy.';
            header('Location: ?url=order/history');
            exit;
        }

        $result = $this->orderModel->cancelOrderByUser($orderId, (string)$_SESSION['user_id']);
        $_SESSION['order_message_status'] = $result['success'] ? 'success' : 'error';
        $_SESSION['order_message'] = $result['message'];

        if ($redirect === 'tracking') {
            header('Location: ?url=order/tracking&id=' . urlencode($orderId));
            exit;
        }

        header('Location: ?url=order/history');
        exit;
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
