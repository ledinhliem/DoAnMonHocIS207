<?php
class OrderModel extends Model
{
    public function __construct() {
        parent::__construct(); 
    }

    // Lấy lịch sử đơn hàng theo User ID
    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT * FROM donhang WHERE MaNguoiDung = ? ORDER BY NgayDat DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 đơn hàng (Dùng cho Tracking)
    public function getOrderById($orderId, $userId)
    {
        $sql = "SELECT * FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function calculateDiscount($subtotal, $promoCode)
    {
        $promoCode = strtoupper(trim($promoCode));

        if ($promoCode === '') {
            return [
                'valid' => false,
                'message' => 'Vui lòng nhập mã giảm giá.',
                'discount' => 0,
                'code' => '',
            ];
        }

        $promos = [
            'SAVE10'   => ['type' => 'percent', 'value' => 10],
            'GREEN20'  => ['type' => 'percent', 'value' => 20],
            'FREESHIP' => ['type' => 'fixed',   'value' => 5],
        ];

        if (!isset($promos[$promoCode])) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá không hợp lệ.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        $promo = $promos[$promoCode];

        if ($promo['type'] === 'percent') {
            $discount = $subtotal * ($promo['value'] / 100);
        } else {
            $discount = $promo['value'];
        }

        $discount = min($discount, $subtotal);

        return [
            'valid' => true,
            'message' => 'Áp dụng mã ' . $promoCode . ' thành công.',
            'discount' => $discount,
            'code' => $promoCode,
        ];
    }

    public function validateCheckout($data)
    {
        $errors = [];

        if (trim($data['full_name'] ?? '') === '') {
            $errors['full_name'] = 'Vui lòng nhập họ tên.';
        }

        if (trim($data['phone'] ?? '') === '' || !preg_match('/^[0-9]{9,11}$/', $data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        if (trim($data['address'] ?? '') === '') {
            $errors['address'] = 'Vui lòng nhập địa chỉ.';
        }

        if (trim($data['delivery_method'] ?? '') === '') {
            $errors['delivery_method'] = 'Vui lòng chọn delivery method.';
        }

        if (trim($data['payment_method'] ?? '') === '') {
            $errors['payment_method'] = 'Vui lòng chọn payment method.';
        }

        return $errors;
    }

    public function validateCardPayment($data)
    {
        $errors = [];

        $name = trim($data['card_name'] ?? '');
        $number = preg_replace('/\s+/', '', $data['card_number'] ?? '');
        $expiry = trim($data['card_expiry'] ?? '');
        $cvv = trim($data['card_cvv'] ?? '');

        if ($name === '') {
            $errors['card_name'] = 'Vui lòng nhập tên trên thẻ.';
        }

        if ($number === '' || !preg_match('/^[0-9]{13,19}$/', $number)) {
            $errors['card_number'] = 'Số thẻ phải từ 13 đến 19 chữ số.';
        }

        if ($expiry === '' || !preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiry)) {
            $errors['card_expiry'] = 'Ngày hết hạn phải có dạng MM/YY.';
        }

        if ($cvv === '' || !preg_match('/^[0-9]{3,4}$/', $cvv)) {
            $errors['card_cvv'] = 'CVV phải gồm 3 hoặc 4 chữ số.';
        }

        return $errors;
    }

    public function validateFeedback($data)
    {
        $errors = [];

        if (empty($data['rating'])) {
            $errors['rating'] = 'Vui lòng chọn số sao.';
        }

        if (trim($data['message'] ?? '') === '') {
            $errors['message'] = 'Vui lòng nhập nội dung feedback.';
        } elseif (mb_strlen(trim($data['message'])) < 10) {
            $errors['message'] = 'Nội dung feedback tối thiểu 10 ký tự.';
        }

        return $errors;
    }

    public function saveOrder($orderData)
    {
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }

        $orderId = 'ORD' . str_pad((string)(count($_SESSION['orders']) + 1), 4, '0', STR_PAD_LEFT);

        $orderData['order_id'] = $orderId;
        $orderData['created_at'] = date('Y-m-d H:i:s');
        $orderData['status'] = 'Processing';

        $_SESSION['orders'][] = $orderData;
        $_SESSION['latest_order'] = $orderData;

        return $orderData;
    }

    public function getOrders()
    {
        return $_SESSION['orders'] ?? [];
    }

    public function getLatestOrder()
    {
        return $_SESSION['latest_order'] ?? null;
    }

    
}