<?php

class OrderModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOrdersByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE MaNguoiDung = ? ORDER BY NgayDat DESC");
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId, $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ?");
        $stmt->execute([$orderId, $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function calculateDiscount($subtotal, $promoCode)
    {
        $promoCode = strtoupper(trim($promoCode));

        if ($promoCode === '') {
            return [
                'valid' => false,
                'message' => 'Vui long nhap ma giam gia.',
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
                'message' => 'Ma giam gia khong hop le.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        if ((int)$promo['SoLuong'] <= 0) {
            return [
                'valid' => false,
                'message' => 'Ma giam gia da het luot su dung.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        if (!empty($promo['NgayHetHan']) && strtotime($promo['NgayHetHan']) < strtotime(date('Y-m-d'))) {
            return [
                'valid' => false,
                'message' => 'Ma giam gia da het han.',
                'discount' => 0,
                'code' => $promoCode,
            ];
        }

        $percent = (int)$promo['PhamTramGiam'];
        $discount = min((float)$subtotal, (float)$subtotal * ($percent / 100));

        return [
            'valid' => true,
            'message' => 'Ap dung ma ' . $promoCode . ' thanh cong.',
            'discount' => $discount,
            'code' => $promoCode,
            'percent' => $percent,
        ];
    }

    public function validateCheckout($data)
    {
        $errors = [];

        if (trim($data['full_name'] ?? '') === '') {
            $errors['full_name'] = 'Vui long nhap ho ten.';
        }

        if (trim($data['phone'] ?? '') === '' || !preg_match('/^[0-9]{9,11}$/', $data['phone'])) {
            $errors['phone'] = 'So dien thoai khong hop le.';
        }

        if (trim($data['address'] ?? '') === '') {
            $errors['address'] = 'Vui long nhap dia chi.';
        }

        if (trim($data['delivery_method'] ?? '') === '') {
            $errors['delivery_method'] = 'Vui long chon phuong thuc giao hang.';
        }

        if (trim($data['payment_method'] ?? '') === '') {
            $errors['payment_method'] = 'Vui long chon phuong thuc thanh toan.';
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
            $errors['card_name'] = 'Vui long nhap ten tren the.';
        }

        if ($number === '' || !preg_match('/^[0-9]{13,19}$/', $number)) {
            $errors['card_number'] = 'So the phai tu 13 den 19 chu so.';
        }

        if ($expiry === '' || !preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiry)) {
            $errors['card_expiry'] = 'Ngay het han phai co dang MM/YY.';
        }

        if ($cvv === '' || !preg_match('/^[0-9]{3,4}$/', $cvv)) {
            $errors['card_cvv'] = 'CVV phai gom 3 hoac 4 chu so.';
        }

        return $errors;
    }

    public function validateFeedback($data)
    {
        $errors = [];

        if (empty($data['rating'])) {
            $errors['rating'] = 'Vui long chon so sao.';
        }

        if (trim($data['message'] ?? '') === '') {
            $errors['message'] = 'Vui long nhap noi dung feedback.';
        } elseif (mb_strlen(trim($data['message'])) < 10) {
            $errors['message'] = 'Noi dung feedback toi thieu 10 ky tu.';
        }

        return $errors;
    }

    public function getShippingFee($deliveryMethod)
    {
        $stmt = $this->db->prepare("SELECT GiaCuoc FROM ptvanchuyen WHERE MaPTVC = ? LIMIT 1");
        $stmt->execute([$this->mapDeliveryMethod($deliveryMethod)]);
        $fee = $stmt->fetchColumn();

        return $fee === false ? 0 : (float)$fee;
    }

    public function saveOrder($orderData)
    {
        $items = $orderData['items'] ?? [];
        $summary = $orderData['summary'] ?? [];
        $customer = $orderData['customer'] ?? [];

        if (empty($items)) {
            throw new RuntimeException('Gio hang dang trong.');
        }

        $this->db->beginTransaction();

        try {
            $orderId = $this->generateOrderId();
            $promoCode = $summary['promo']['code'] ?? null;

            $this->assertStockAvailable($items);

            $stmt = $this->db->prepare("
                INSERT INTO donhang (
                    MaDonHang, MaNguoiDung, TongTien, TrangThai, DiaChiGiaoHang,
                    MaPTTT, MaPTVC, MaCode, TenNguoiNhan, SDTNguoiNhan,
                    SoTienGiam, PhiVanChuyen, ThanhTienCuoi
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $orderId,
                $_SESSION['user_id'] ?? null,
                (float)($summary['subtotal'] ?? 0),
                '0',
                $customer['address'] ?? '',
                $this->mapPaymentMethod($orderData['payment_method'] ?? $customer['payment_method'] ?? ''),
                $this->mapDeliveryMethod($customer['delivery_method'] ?? 'standard'),
                $promoCode ?: null,
                $customer['full_name'] ?? '',
                $customer['phone'] ?? '',
                (float)($summary['discount'] ?? 0),
                (float)($summary['shipping'] ?? 0),
                (float)($summary['total'] ?? 0),
            ]);

            $insertItem = $this->db->prepare("
                INSERT INTO chitietdonhang (MaDonHang, MaBienThe, SoLuong, DonGia)
                VALUES (?, ?, ?, ?)
            ");

            $updateStock = $this->db->prepare("
                UPDATE bienthesanpham
                SET SoLuongTon = SoLuongTon - ?
                WHERE MaBienThe = ? AND SoLuongTon >= ?
            ");

            foreach ($items as $item) {
                $maBienThe = $item['MaBienThe'] ?? $item['variant_id'] ?? '';
                $quantity = (int)($item['quantity'] ?? 0);
                $price = (float)($item['price'] ?? 0);

                $insertItem->execute([$orderId, $maBienThe, $quantity, $price]);
                $updateStock->execute([$quantity, $maBienThe, $quantity]);

                if ($updateStock->rowCount() !== 1) {
                    throw new RuntimeException('Ton kho khong du cho bien the ' . $maBienThe . '.');
                }
            }

            if ($promoCode) {
                $promoStmt = $this->db->prepare("
                    UPDATE magiamgia
                    SET SoLuong = SoLuong - 1
                    WHERE MaCode = ? AND SoLuong > 0
                ");
                $promoStmt->execute([$promoCode]);
            }

            $this->db->commit();
            $_SESSION['latest_order_id'] = $orderId;

            return $this->getOrderByIdForSession($orderId);
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }

    public function getOrders()
    {
        return [];
    }

    public function getLatestOrder()
    {
        $orderId = $_SESSION['latest_order_id'] ?? null;

        if (!$orderId) {
            return null;
        }

        return $this->getOrderByIdForSession($orderId);
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

        $lastId = $stmt->fetchColumn();
        $nextNumber = $lastId ? ((int)substr($lastId, 1) + 1) : 1;

        return 'O' . str_pad((string)$nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function assertStockAvailable($items)
    {
        $stmt = $this->db->prepare("
            SELECT bt.MaBienThe, bt.SoLuongTon, sp.TenSanPham
            FROM bienthesanpham bt
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            WHERE bt.MaBienThe = ?
            LIMIT 1
            FOR UPDATE
        ");

        foreach ($items as $item) {
            $maBienThe = $item['MaBienThe'] ?? $item['variant_id'] ?? '';
            $quantity = (int)($item['quantity'] ?? 0);

            if ($maBienThe === '' || $quantity <= 0) {
                throw new RuntimeException('Du lieu gio hang khong hop le.');
            }

            $stmt->execute([$maBienThe]);
            $variant = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$variant) {
                throw new RuntimeException('Khong tim thay bien the ' . $maBienThe . '.');
            }

            if ((int)$variant['SoLuongTon'] < $quantity) {
                throw new RuntimeException(
                    'San pham "' . $variant['TenSanPham'] . '" khong du ton kho. Hien con ' . (int)$variant['SoLuongTon'] . '.'
                );
            }
        }
    }

    private function getOrderByIdForSession($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE MaDonHang = ? LIMIT 1");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        return $order ?: null;
    }

    private function mapPaymentMethod($paymentMethod)
    {
        return match (strtolower((string)$paymentMethod)) {
            'cod' => '1',
            'transfer' => '2',
            default => '3',
        };
    }

    private function mapDeliveryMethod($deliveryMethod)
    {
        return $deliveryMethod === 'express' ? '2' : '1';
    }
}
