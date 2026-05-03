<?php

class OrderModel extends Model
{
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

        $stmt = $this->db->prepare("
            SELECT MaCode, PhamTramGiam, SoLuong, NgayHetHan
            FROM magiamgia
            WHERE MaCode = ?
            LIMIT 1
        ");

        $stmt->execute([$promoCode]);
        $promo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promo) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá không hợp lệ.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        if ((int)$promo['SoLuong'] <= 0) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá đã hết lượt dùng.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        if (!empty($promo['NgayHetHan']) && $promo['NgayHetHan'] < date('Y-m-d')) {
            return [
                'valid' => false,
                'message' => 'Mã giảm giá đã hết hạn.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        $discount = (float)$subtotal * ((int)$promo['PhamTramGiam'] / 100);
        $discount = min($discount, (float)$subtotal);

        return [
            'valid' => true,
            'message' => 'Áp dụng mã ' . $promoCode . ' thành công.',
            'discount' => $discount,
            'code' => $promoCode,
            'percent' => (int)$promo['PhamTramGiam'],
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
            $errors['delivery_method'] = 'Vui lòng chọn phương thức giao hàng.';
        }

        if (trim($data['payment_method'] ?? '') === '') {
            $errors['payment_method'] = 'Vui lòng chọn phương thức thanh toán.';
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
        }

        return $errors;
    }

    public function saveOrder($orderData)
    {
        $items = $orderData['items'] ?? [];
        $summary = $orderData['summary'] ?? [];
        $customer = $orderData['customer'] ?? [];

        if (empty($items)) {
            throw new Exception('Giỏ hàng đang trống.');
        }

        $stockCheck = $this->checkStock($items);

        if (!$stockCheck['ok']) {
            throw new Exception($stockCheck['message']);
        }

        $this->db->beginTransaction();

        try {
            $orderId = $this->generateOrderId();

            $paymentMethod = $orderData['payment_method'] ?? ($customer['payment_method'] ?? 'cod');
            $deliveryMethod = $customer['delivery_method'] ?? 'standard';
            $promoCode = $summary['promo']['code'] ?? null;

            $stmt = $this->db->prepare("
                INSERT INTO donhang
                (
                    MaDonHang,
                    MaNguoiDung,
                    NgayDat,
                    TongTien,
                    TrangThai,
                    DiaChiGiaoHang,
                    MaPTTT,
                    MaPTVC,
                    MaCode,
                    MaDiaChi,
                    TenNguoiNhan,
                    SDTNguoiNhan,
                    SoTienGiam,
                    PhiVanChuyen,
                    ThanhTienCuoi
                )
                VALUES
                (?, ?, NOW(), ?, 0, ?, ?, ?, ?, NULL, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $orderId,
                $this->getCurrentUserId(),
                (float)($summary['subtotal'] ?? 0),
                $customer['address'] ?? '',
                $this->mapPaymentMethod($paymentMethod),
                $this->mapShippingMethod($deliveryMethod),
                $promoCode,
                $customer['full_name'] ?? '',
                $customer['phone'] ?? '',
                (float)($summary['discount'] ?? 0),
                (float)($summary['shipping'] ?? 0),
                (float)($summary['total'] ?? 0),
            ]);

            $detailStmt = $this->db->prepare("
                INSERT INTO chitietdonhang
                (MaDonHang, MaBienThe, SoLuong, DonGia)
                VALUES (?, ?, ?, ?)
            ");

            $stockStmt = $this->db->prepare("
                UPDATE bienthesanpham
                SET SoLuongTon = SoLuongTon - ?
                WHERE MaBienThe = ?
                AND SoLuongTon >= ?
            ");

            foreach ($items as $item) {
                $qty = (int)$item['quantity'];

                $detailStmt->execute([
                    $orderId,
                    $item['MaBienThe'],
                    $qty,
                    (float)$item['price'],
                ]);

                $stockStmt->execute([
                    $qty,
                    $item['MaBienThe'],
                    $qty,
                ]);

                if ($stockStmt->rowCount() === 0) {
                    throw new Exception('Không thể trừ tồn kho cho biến thể ' . $item['MaBienThe'] . '.');
                }
            }

            if ($promoCode) {
                $promoStmt = $this->db->prepare("
                    UPDATE magiamgia
                    SET SoLuong = SoLuong - 1
                    WHERE MaCode = ?
                    AND SoLuong > 0
                ");

                $promoStmt->execute([$promoCode]);
            }

            $this->db->commit();

            $_SESSION['latest_order_id'] = $orderId;

            return $this->getOrderById($orderId);
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }

    public function checkStock($items)
    {
        foreach ($items as $item) {
            $stmt = $this->db->prepare("
                SELECT SoLuongTon
                FROM bienthesanpham
                WHERE MaBienThe = ?
                LIMIT 1
            ");

            $stmt->execute([$item['MaBienThe']]);
            $stock = $stmt->fetchColumn();

            if ($stock === false) {
                return [
                    'ok' => false,
                    'message' => 'Không tìm thấy biến thể ' . $item['MaBienThe'] . '.'
                ];
            }

            if ((int)$stock < (int)$item['quantity']) {
                return [
                    'ok' => false,
                    'message' => 'Sản phẩm ' . $item['name'] . ' không đủ tồn kho. Còn ' . (int)$stock . ', cần ' . (int)$item['quantity'] . '.'
                ];
            }
        }

        return [
            'ok' => true,
            'message' => 'OK'
        ];
    }

    public function getOrders()
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM donhang
            WHERE MaNguoiDung = ?
            ORDER BY NgayDat DESC, MaDonHang DESC
        ");

        $stmt->execute([$this->getCurrentUserId()]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $order['items'] = $this->getOrderItems($order['MaDonHang']);
        }

        return $orders;
    }

    public function getOrderById($orderId)
    {
        $orderId = trim((string)$orderId);

        if ($orderId === '') {
            return null;
        }

        $stmt = $this->db->prepare("
            SELECT *
            FROM donhang
            WHERE MaDonHang = ?
            AND MaNguoiDung = ?
            LIMIT 1
        ");

        $stmt->execute([
            $orderId,
            $this->getCurrentUserId()
        ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null;
        }

        $order['items'] = $this->getOrderItems($orderId);

        return $order;
    }

    public function getLatestOrder()
    {
        $stmt = $this->db->prepare("
            SELECT MaDonHang
            FROM donhang
            WHERE MaNguoiDung = ?
            ORDER BY NgayDat DESC, MaDonHang DESC
            LIMIT 1
        ");

        $stmt->execute([$this->getCurrentUserId()]);
        $orderId = $stmt->fetchColumn();

        if (!$orderId) {
            return null;
        }

        return $this->getOrderById($orderId);
    }

    private function getOrderItems($orderId)
    {
        $detailStmt = $this->db->prepare("
            SELECT 
                ctdh.MaDonHang,
                ctdh.MaBienThe,
                ctdh.SoLuong,
                ctdh.DonGia,
                bt.MaSanPham,
                bt.KichThuoc,
                bt.MauSac,
                sp.TenSanPham,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSanPham = sp.MaSanPham
                    LIMIT 1
                ) AS HinhAnh
            FROM chitietdonhang ctdh
            JOIN bienthesanpham bt ON bt.MaBienThe = ctdh.MaBienThe
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            WHERE ctdh.MaDonHang = ?
            ORDER BY ctdh.MaBienThe ASC
        ");

        $detailStmt->execute([$orderId]);

        return $detailStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generateOrderId()
    {
        $stmt = $this->db->query("
            SELECT MaDonHang
            FROM donhang
            WHERE MaDonHang LIKE 'O%'
            ORDER BY CAST(SUBSTRING(MaDonHang, 2) AS UNSIGNED) DESC
            LIMIT 1
        ");

        $last = $stmt->fetchColumn();
        $num = $last ? ((int)preg_replace('/\D/', '', $last) + 1) : 1;

        return 'O' . str_pad((string)$num, 3, '0', STR_PAD_LEFT);
    }

    private function getCurrentUserId()
    {
        return $_SESSION['user']['MaNguoiDung']
            ?? $_SESSION['user']['id']
            ?? $_SESSION['MaNguoiDung']
            ?? $_SESSION['user_id']
            ?? 'U002';
    }

    private function mapPaymentMethod($method)
    {
        $method = strtolower((string)$method);

        if ($method === 'cod') {
            return '1';
        }

        if ($method === 'transfer') {
            return '2';
        }

        if ($method === 'card') {
            return '3';
        }

        return '1';
    }

    private function mapShippingMethod($method)
    {
        return strtolower((string)$method) === 'express' ? '2' : '1';
    }
}