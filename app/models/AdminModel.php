<?php

class AdminModel extends Model
{
    public function getDashboardStats()
    {
        $stats = [
            'totalRevenue' => 0,
            'totalOrders' => 0,
            'newOrders' => 0,
            'totalUsers' => 0,
            'completedOrders' => 0,
            'cancelledOrders' => 0,
            'preparingOrders' => 0,
            'shippingOrders' => 0,
        ];

        $sql = "
            SELECT
                COALESCE(SUM(CASE WHEN TrangThai = '3' THEN ThanhTienCuoi ELSE 0 END), 0) AS totalRevenue,
                COUNT(*) AS totalOrders,
                SUM(CASE WHEN TrangThai = '0' THEN 1 ELSE 0 END) AS newOrders,
                SUM(CASE WHEN TrangThai = '1' THEN 1 ELSE 0 END) AS preparingOrders,
                SUM(CASE WHEN TrangThai = '2' THEN 1 ELSE 0 END) AS shippingOrders,
                SUM(CASE WHEN TrangThai = '3' THEN 1 ELSE 0 END) AS completedOrders,
                SUM(CASE WHEN TrangThai = '4' THEN 1 ELSE 0 END) AS cancelledOrders
            FROM donhang
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $orderStats = $stmt->fetch();

        if ($orderStats) {
            $stats['totalRevenue'] = (float)($orderStats['totalRevenue'] ?? 0);
            $stats['totalOrders'] = (int)($orderStats['totalOrders'] ?? 0);
            $stats['newOrders'] = (int)($orderStats['newOrders'] ?? 0);
            $stats['preparingOrders'] = (int)($orderStats['preparingOrders'] ?? 0);
            $stats['shippingOrders'] = (int)($orderStats['shippingOrders'] ?? 0);
            $stats['completedOrders'] = (int)($orderStats['completedOrders'] ?? 0);
            $stats['cancelledOrders'] = (int)($orderStats['cancelledOrders'] ?? 0);
        }

        $userStmt = $this->db->prepare("SELECT COUNT(*) AS totalUsers FROM nguoidung");
        $userStmt->execute();
        $userStats = $userStmt->fetch();

        if ($userStats) {
            $stats['totalUsers'] = (int)($userStats['totalUsers'] ?? 0);
        }

        return $stats;
    }

    public function getRecentOrders($limit = 5)
    {
        $sql = "
            SELECT
                dh.MaDonHang,
                dh.MaNguoiDung,
                dh.NgayDat,
                dh.TongTien,
                dh.TrangThai,
                dh.DiaChiGiaoHang,
                dh.TenNguoiNhan,
                dh.SDTNguoiNhan,
                dh.SoTienGiam,
                dh.PhiVanChuyen,
                dh.ThanhTienCuoi,
                nd.HoTen,
                nd.Email,
                nd.SoDienThoai,
                mg.MaCode,
                mg.PhamTramGiam,
                pttt.TenPTTT,
                ptvc.TenPTVC,
                COUNT(ct.MaBienThe) AS TongLoaiSanPham,
                COALESCE(SUM(ct.SoLuong), 0) AS TongSoLuong
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            LEFT JOIN chitietdonhang ct ON dh.MaDonHang = ct.MaDonHang
            GROUP BY
                dh.MaDonHang,
                dh.MaNguoiDung,
                dh.NgayDat,
                dh.TongTien,
                dh.TrangThai,
                dh.DiaChiGiaoHang,
                dh.TenNguoiNhan,
                dh.SDTNguoiNhan,
                dh.SoTienGiam,
                dh.PhiVanChuyen,
                dh.ThanhTienCuoi,
                nd.HoTen,
                nd.Email,
                nd.SoDienThoai,
                mg.MaCode,
                mg.PhamTramGiam,
                pttt.TenPTTT,
                ptvc.TenPTVC
            ORDER BY dh.NgayDat DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getAllOrders($keyword = '', $status = '')
    {
        $where = [];
        $params = [];

        if ($keyword !== '') {
            $where[] = "(
                dh.MaDonHang LIKE :keyword
                OR dh.TenNguoiNhan LIKE :keyword
                OR dh.SDTNguoiNhan LIKE :keyword
                OR nd.HoTen LIKE :keyword
                OR nd.Email LIKE :keyword
            )";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($status !== '' && in_array((string)$status, ['0', '1', '2', '3', '4'], true)) {
            $where[] = "dh.TrangThai = :status";
            $params[':status'] = (string)$status;
        }

        $whereSql = '';
        if (!empty($where)) {
            $whereSql = 'WHERE ' . implode(' AND ', $where);
        }

        $sql = "
            SELECT
                dh.MaDonHang,
                dh.MaNguoiDung,
                dh.NgayDat,
                dh.TongTien,
                dh.TrangThai,
                dh.DiaChiGiaoHang,
                dh.MaPTTT,
                dh.MaPTVC,
                dh.MaCode,
                dh.MaDiaChi,
                dh.TenNguoiNhan,
                dh.SDTNguoiNhan,
                dh.SoTienGiam,
                dh.PhiVanChuyen,
                dh.ThanhTienCuoi,
                nd.HoTen,
                nd.Email,
                nd.SoDienThoai,
                mg.PhamTramGiam,
                pttt.TenPTTT,
                ptvc.TenPTVC,
                COUNT(ct.MaBienThe) AS TongLoaiSanPham,
                COALESCE(SUM(ct.SoLuong), 0) AS TongSoLuong
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            LEFT JOIN chitietdonhang ct ON dh.MaDonHang = ct.MaDonHang
            $whereSql
            GROUP BY
                dh.MaDonHang,
                dh.MaNguoiDung,
                dh.NgayDat,
                dh.TongTien,
                dh.TrangThai,
                dh.DiaChiGiaoHang,
                dh.MaPTTT,
                dh.MaPTVC,
                dh.MaCode,
                dh.MaDiaChi,
                dh.TenNguoiNhan,
                dh.SDTNguoiNhan,
                dh.SoTienGiam,
                dh.PhiVanChuyen,
                dh.ThanhTienCuoi,
                nd.HoTen,
                nd.Email,
                nd.SoDienThoai,
                mg.PhamTramGiam,
                pttt.TenPTTT,
                ptvc.TenPTVC
            ORDER BY dh.NgayDat DESC, dh.MaDonHang DESC
        ";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getOrderById($orderId)
    {
        $sql = "
            SELECT
                dh.MaDonHang,
                dh.MaNguoiDung,
                dh.NgayDat,
                dh.TongTien,
                dh.TrangThai,
                dh.DiaChiGiaoHang,
                dh.MaPTTT,
                dh.MaPTVC,
                dh.MaCode,
                dh.MaDiaChi,
                dh.TenNguoiNhan,
                dh.SDTNguoiNhan,
                dh.SoTienGiam,
                dh.PhiVanChuyen,
                dh.ThanhTienCuoi,
                nd.HoTen,
                nd.Email,
                nd.SoDienThoai,
                mg.PhamTramGiam,
                mg.NgayHetHan,
                pttt.TenPTTT,
                ptvc.TenPTVC,
                ptvc.GiaCuoc
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            WHERE dh.MaDonHang = :orderId
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getOrderItems($orderId)
    {
        $sql = "
            SELECT
                ct.MaDonHang,
                ct.MaBienThe,
                ct.SoLuong,
                ct.DonGia,
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
                    ORDER BY ha.MaHinhAnh ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM chitietdonhang ct
            LEFT JOIN bienthesanpham bt ON ct.MaBienThe = bt.MaBienThe
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE ct.MaDonHang = :orderId
            ORDER BY ct.MaBienThe ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getOrderStatus($orderId)
    {
        $stmt = $this->db->prepare("SELECT TrangThai FROM donhang WHERE MaDonHang = :orderId LIMIT 1");
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();

        $order = $stmt->fetch();

        return $order ? (string)$order['TrangThai'] : null;
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $newStatus = (string)$newStatus;

        if (!in_array($newStatus, ['0', '1', '2', '3', '4'], true)) {
            return [
                'success' => false,
                'message' => 'Trạng thái đơn hàng không hợp lệ.'
            ];
        }

        try {
            $this->db->beginTransaction();

            $currentStatus = $this->getOrderStatus($orderId);

            if ($currentStatus === null) {
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng.'
                ];
            }

            if ($currentStatus === '4') {
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Đơn hàng đã hủy rồi, không thể cập nhật tiếp để tránh sai tồn kho.'
                ];
            }

            if ($currentStatus === $newStatus) {
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Đơn hàng đang ở trạng thái này rồi.'
                ];
            }

            if ((int)$newStatus < (int)$currentStatus && $newStatus !== '4') {
                $this->db->rollBack();
                return [
                    'success' => false,
                    'message' => 'Không thể lùi trạng thái đơn hàng.'
                ];
            }

            if ($newStatus === '4') {
                $this->restoreStockForOrder($orderId);
            }

            $stmt = $this->db->prepare("
                UPDATE donhang
                SET TrangThai = :newStatus
                WHERE MaDonHang = :orderId
            ");

            $stmt->bindValue(':newStatus', $newStatus);
            $stmt->bindValue(':orderId', $orderId);
            $stmt->execute();

            $this->db->commit();

            return [
                'success' => true,
                'message' => $newStatus === '4'
                    ? 'Đã hủy đơn hàng và hoàn kho thành công.'
                    : 'Cập nhật trạng thái đơn hàng thành công.'
            ];
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return [
                'success' => false,
                'message' => 'Lỗi cập nhật đơn hàng: ' . $e->getMessage()
            ];
        }
    }

    private function restoreStockForOrder($orderId)
    {
        $items = $this->getOrderItems($orderId);

        foreach ($items as $item) {
            if (empty($item['MaBienThe'])) {
                continue;
            }

            $stmt = $this->db->prepare("
                UPDATE bienthesanpham
                SET SoLuongTon = SoLuongTon + :quantity
                WHERE MaBienThe = :variantId
            ");

            $stmt->bindValue(':quantity', (int)$item['SoLuong'], PDO::PARAM_INT);
            $stmt->bindValue(':variantId', $item['MaBienThe']);
            $stmt->execute();
        }
    }
}