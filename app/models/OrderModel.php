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

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as &$order) {
            $order['items'] = $this->getOrderItems($order['MaDonHang']);
        }

        return $orders;
    }

    public function getOrderById($orderId, $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM donhang WHERE MaDonHang = ? AND MaNguoiDung = ?");
        $stmt->execute([$orderId, $userId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $order['items'] = $this->getOrderItems($orderId);
        }

        return $order ?: null;
    }

    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT
                ct.MaDonHang,
                ct.MaBienThe,
                ct.SoLuong,
                ct.DonGia,
                bt.MaSanPham,
                bt.KichThuoc,
                bt.MauSac,
                sp.TenSanPham,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSanPham = sp.MaSanPham
                    ORDER BY ha.MaHinhAnh ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM chitietdonhang ct
            LEFT JOIN bienthesanpham bt ON ct.MaBienThe = bt.MaBienThe
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE ct.MaDonHang = ?
            ORDER BY ct.MaBienThe ASC
        ");
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function calculateDiscount($items, $promoCode)
    {
        $promoCode = strtoupper(trim($promoCode));

        if ($promoCode === '') {
            return ['valid' => false, 'message' => 'Vui lòng nhập mã giảm giá.', 'discount' => 0, 'code' => ''];
        }

        // Lấy thông tin mã từ DB
        $stmt = $this->db->prepare("
        SELECT MaCode, PhamTramGiam, SoLuong, NgayHetHan, MaDanhMuc
        FROM magiamgia
        WHERE MaCode = ? LIMIT 1
    ");
        $stmt->execute([$promoCode]);
        $promo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mã tồn tại, hết hạn, hết số lượng
        if (!$promo) {
            return ['valid' => false, 'message' => 'Mã không hợp lệ.', 'discount' => 0, 'code' => $promoCode];
        }
        if ((int)$promo['SoLuong'] <= 0) {
            return ['valid' => false, 'message' => 'Mã đã hết lượt dùng.', 'discount' => 0, 'code' => $promoCode];
        }
        if (!empty($promo['NgayHetHan']) && strtotime($promo['NgayHetHan']) < strtotime(date('Y-m-d'))) {
            return ['valid' => false, 'message' => 'Mã đã hết hạn.', 'discount' => 0, 'code' => $promoCode];
        }

        $maDanhMucYeuCau = $promo['MaDanhMuc']; // Đây là giá trị lấy từ DB (NULL hoặc C001, C003...)
        $subtotalApDung = 0;
        $hasValidProduct = false;

        // --- LOGIC MỚI: Kiểm tra danh mục ---
        // Nếu MaDanhMuc là NULL (áp dụng toàn bộ) -> Bỏ qua check danh mục
        if ($maDanhMucYeuCau === null || $maDanhMucYeuCau === '') {
            $hasValidProduct = true;
            foreach ($items as $item) {
                $price = (float)($item['price'] ?? $item['DonGia'] ?? 0);
                $quantity = (int)($item['quantity'] ?? $item['SoLuong'] ?? 1);
                $subtotalApDung += ($price * $quantity);
            }
        } else {
            // Nếu có mã danh mục -> Mới check từng sản phẩm
            $checkCatStmt = $this->db->prepare("
            SELECT s.MaDanhMuc 
            FROM bienthesanpham b 
            JOIN sanpham s ON b.MaSanPham = s.MaSanPham 
            WHERE b.MaBienThe = ?
        ");

            foreach ($items as $item) {
                $maBienThe = $item['MaBienThe'] ?? $item['variant_id'] ?? '';
                $checkCatStmt->execute([$maBienThe]);
                $cate = $checkCatStmt->fetchColumn();

                if ($cate === $maDanhMucYeuCau) {
                    $hasValidProduct = true;
                    $price = (float)($item['price'] ?? $item['DonGia'] ?? 0);
                    $quantity = (int)($item['quantity'] ?? $item['SoLuong'] ?? 1);
                    $subtotalApDung += ($price * $quantity);
                }
            }
        }

        if (!$hasValidProduct) {
            return ['valid' => false, 'message' => 'Mã không áp dụng cho sản phẩm này.', 'discount' => 0, 'code' => $promoCode];
        }

        $percent = (int)$promo['PhamTramGiam'];
        $discount = $subtotalApDung * ($percent / 100);

        return [
            'valid' => true,
            'message' => 'Áp dụng mã ' . $promoCode . ' thành công.',
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

        if (trim($data['email'] ?? '') === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email khong hop le.';
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

        $rating = (int)($data['rating'] ?? 0);

        if ($rating < 1 || $rating > 5) {
            $errors['rating'] = 'Vui long chon so sao.';
        }

        if (trim($data['message'] ?? '') === '') {
            $errors['message'] = 'Vui long nhap noi dung feedback.';
        } elseif (mb_strlen(trim($data['message'])) < 10) {
            $errors['message'] = 'Noi dung feedback toi thieu 10 ky tu.';
        }

        return $errors;
    }

    public function getReviewableProduct($orderId, $productId, $userId)
    {
        $stmt = $this->db->prepare("
            SELECT
                dh.MaDonHang,
                dh.TrangThai,
                bt.MaSanPham,
                sp.TenSanPham,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSanPham = sp.MaSanPham
                    ORDER BY ha.MaHinhAnh ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM donhang dh
            JOIN chitietdonhang ct ON ct.MaDonHang = dh.MaDonHang
            JOIN bienthesanpham bt ON bt.MaBienThe = ct.MaBienThe
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            WHERE dh.MaDonHang = ?
              AND dh.MaNguoiDung = ?
              AND bt.MaSanPham = ?
              AND dh.TrangThai = '3'
            LIMIT 1
        ");
        $stmt->execute([$orderId, $userId, $productId]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function hasUserReviewedProduct($userId, $productId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM danhgia
            WHERE MaNguoiDung = ? AND MaSanPham = ?
        ");
        $stmt->execute([$userId, $productId]);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function saveProductReview($userId, $productId, $rating, $message)
    {
        $stmt = $this->db->prepare("
            INSERT INTO danhgia (MaDanhGia, MaNguoiDung, MaSanPham, SoSao, NoiDung, TrangThai)
            VALUES (?, ?, ?, ?, ?, 0)
        ");

        return $stmt->execute([
            $this->generateReviewId(),
            $userId,
            $productId,
            max(1, min(5, (int)$rating)),
            trim($message),
        ]);
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

    /**
     * Lấy đơn hàng hoàn thành (TrangThai = '3') chưa hiển thị pop-up
     * thông báo cho người dùng hiện tại.
     *
     * Trả về mảng chứa MaDonHang và MaSanPham của sản phẩm đầu tiên
     * trong đơn (để link sang trang feedback), hoặc null nếu không có.
     */
    public function getPendingDeliveryNotification(string $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                dh.MaDonHang,
                bt.MaSanPham
            FROM donhang dh
            JOIN chitietdonhang ct  ON ct.MaDonHang  = dh.MaDonHang
            JOIN bienthesanpham bt  ON bt.MaBienThe  = ct.MaBienThe
            WHERE dh.MaNguoiDung = ?
              AND dh.TrangThai   = '3'
              AND dh.DaThongBao  = 0
            ORDER BY dh.NgayDat DESC
            LIMIT 1
        ");
        $stmt->execute([$userId]);
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
 
    /**
     * Đánh dấu đơn hàng đã được thông báo (DaThongBao = 1).
     * Chỉ cập nhật khi đơn thuộc về đúng userId để tránh IDOR.
     */
    public function markOrderAsNotified(string $orderId, string $userId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE donhang
            SET    DaThongBao = 1
            WHERE  MaDonHang   = ?
              AND  MaNguoiDung = ?
              AND  TrangThai   = '3'
              AND  DaThongBao  = 0
        ");
        $stmt->execute([$orderId, $userId]);
 
        return $stmt->rowCount() > 0;
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

    private function generateReviewId()
    {
        $stmt = $this->db->query("
            SELECT MaDanhGia
            FROM danhgia
            WHERE MaDanhGia LIKE 'RV%'
            ORDER BY CAST(SUBSTRING(MaDanhGia, 3) AS UNSIGNED) DESC
            LIMIT 1
        ");

        $lastId = $stmt->fetchColumn();
        $nextNumber = $lastId ? ((int)substr($lastId, 2) + 1) : 1;

        return 'RV' . str_pad((string)$nextNumber, 3, '0', STR_PAD_LEFT);
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

        if ($order) {
            $order['items'] = $this->getOrderItems($orderId);
        }

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
<<<<<<< HEAD
}
=======

    public function getAvailablePromos()
    {
        try {
            // Nối chuỗi để hiển thị rành mạch: "Giảm 15% (Chỉ Zentro Kitchen)"
            $sql = "SELECT 
                        m.MaCode AS MaGiamGia, 
                        CONCAT('Giảm ', m.PhamTramGiam, '%', IF(m.MaDanhMuc IS NOT NULL, CONCAT(' (Chỉ ', d.TenDanhMuc, ')'), ' (Toàn Shop)')) AS MoTa, 
                        m.NgayHetHan 
                    FROM magiamgia m
                    LEFT JOIN danhmuc d ON m.MaDanhMuc = d.MaDanhMuc
                    WHERE m.NgayHetHan >= CURDATE() AND m.SoLuong > 0";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }

    // Thêm hàm này vào class OrderModel trong app/models/OrderModel.php
   /**
     * Tự động sinh link mã QR VietQR động (Task 5c)
     */
    public function generateVietQRUrl($totalAmount, $orderCode) {
        $accountNo = "0769509303"; // Đổi thành STK thật của ông nếu cần
        $accountName = "NGUY TRONG PHUC"; // Tên thật của shop
        
        // Gọi API của VietQR với định dạng compact2 (gọn đẹp)
        return "https://img.vietqr.io/image/mbbank-" . $accountNo . "-compact2.png?" . 
               "amount=" . (int)$totalAmount . 
               "&addInfo=" . urlencode($orderCode) . 
               "&accountName=" . urlencode($accountName);
    }
}
>>>>>>> phuc-fix-task-5-10
