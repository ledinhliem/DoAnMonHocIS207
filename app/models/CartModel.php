<?php

class CartModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add($maSanPham, $maBienThe, $quantity = 1)
    {
        $maSanPham = trim((string)$maSanPham);
        $maBienThe = trim((string)$maBienThe);
        $quantity = max(1, (int)$quantity);

        /*
         * Trường hợp nút add nhanh ở product list chỉ gửi MaSanPham,
         * backend tự lấy biến thể đầu tiên của sản phẩm đó.
         */
        if ($maSanPham !== '' && $maBienThe === '') {
            $maBienThe = $this->getFirstVariantByProductId($maSanPham) ?: '';
        }

        if ($maSanPham === '' || $maBienThe === '') {
            return [
                'success' => false,
                'message' => 'Thiếu MaSanPham hoặc MaBienThe.'
            ];
        }

        $variant = $this->getVariantForCart($maSanPham, $maBienThe);

        if (!$variant) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy biến thể sản phẩm trong database.'
            ];
        }

        $stock = (int)$variant['SoLuongTon'];
        $currentQty = (int)($_SESSION['cart'][$maBienThe]['quantity'] ?? 0);

        if ($stock <= 0) {
            return [
                'success' => false,
                'message' => 'Sản phẩm đã hết hàng.'
            ];
        }

        if ($currentQty + $quantity > $stock) {
            return [
                'success' => false,
                'message' => 'Không đủ tồn kho. Hiện còn ' . $stock . ' sản phẩm.'
            ];
        }

        $_SESSION['cart'][$maBienThe] = [
            'MaSanPham' => $variant['MaSanPham'],
            'MaBienThe' => $variant['MaBienThe'],
            'name' => $variant['TenSanPham'],
            'variant' => trim(($variant['KichThuoc'] ?? '') . ' ' . ($variant['MauSac'] ?? '')),
            'price' => (float)$variant['GiaTien'],
            'stock' => $stock,
            'image' => !empty($variant['HinhAnh'])
                ? BASE_URL . 'public/images/products/' . basename($variant['HinhAnh'])
                : '',
            'quantity' => $currentQty + $quantity,
        ];

        return [
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.'
        ];
    }

    public function update($maBienThe, $quantity)
    {
        $maBienThe = trim((string)$maBienThe);
        $quantity = (int)$quantity;

        if ($maBienThe === '' || !isset($_SESSION['cart'][$maBienThe])) {
            return [
                'success' => false,
                'message' => 'Sản phẩm không có trong giỏ.'
            ];
        }

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$maBienThe]);

            return [
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ.'
            ];
        }

        $stmt = $this->db->prepare("
            SELECT SoLuongTon
            FROM bienthesanpham
            WHERE MaBienThe = ?
            LIMIT 1
        ");

        $stmt->execute([$maBienThe]);
        $stock = $stmt->fetchColumn();

        if ($stock === false) {
            unset($_SESSION['cart'][$maBienThe]);

            return [
                'success' => false,
                'message' => 'Không tìm thấy biến thể sản phẩm. Đã xóa khỏi giỏ.'
            ];
        }

        $stock = (int)$stock;

        if ($stock <= 0) {
            unset($_SESSION['cart'][$maBienThe]);

            return [
                'success' => false,
                'message' => 'Sản phẩm đã hết hàng. Đã xóa khỏi giỏ.'
            ];
        }

        if ($quantity > $stock) {
            return [
                'success' => false,
                'message' => 'Không đủ tồn kho. Hiện còn ' . $stock . ' sản phẩm.'
            ];
        }

        $_SESSION['cart'][$maBienThe]['quantity'] = $quantity;
        $_SESSION['cart'][$maBienThe]['stock'] = $stock;

        return [
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công.'
        ];
    }

    public function remove($maBienThe)
    {
        $maBienThe = trim((string)$maBienThe);

        if ($maBienThe !== '') {
            unset($_SESSION['cart'][$maBienThe]);
        }

        return [
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ.'
        ];
    }

    public function getItems()
    {
        return array_values($_SESSION['cart'] ?? []);
    }

    public function getSubtotal()
    {
        $subtotal = 0;

        foreach ($_SESSION['cart'] ?? [] as $item) {
            $subtotal += (float)$item['price'] * (int)$item['quantity'];
        }

        return $subtotal;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }

    private function getVariantForCart($maSanPham, $maBienThe)
    {
        $sql = "
            SELECT 
                bt.MaBienThe,
                bt.MaSanPham,
                bt.KichThuoc,
                bt.MauSac,
                bt.GiaTien,
                bt.SoLuongTon,
                sp.TenSanPham,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSanPham = sp.MaSanPham
                    LIMIT 1
                ) AS HinhAnh
            FROM bienthesanpham bt
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            WHERE bt.MaSanPham = ?
            AND bt.MaBienThe = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maSanPham, $maBienThe]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getFirstVariantByProductId($maSanPham)
    {
        $stmt = $this->db->prepare("
            SELECT MaBienThe
            FROM bienthesanpham
            WHERE MaSanPham = ?
            ORDER BY MaBienThe ASC
            LIMIT 1
        ");

        $stmt->execute([$maSanPham]);

        return $stmt->fetchColumn();
    }
}