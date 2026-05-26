<?php

class AdminModel extends Model
{
    /* =========================================================
       DASHBOARD + ORDERS — Phúc
       ========================================================= */

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
            'totalProducts' => 0,
            'publishedPosts' => 0,
            'pendingReviews' => 0,
            'totalReviews' => 0,
        ];

        $stmt = $this->db->prepare("
            SELECT
                COALESCE(SUM(CASE WHEN TrangThai = '3' THEN ThanhTienCuoi ELSE 0 END), 0) AS totalRevenue,
                COUNT(*) AS totalOrders,
                SUM(CASE WHEN TrangThai = '0' THEN 1 ELSE 0 END) AS newOrders,
                SUM(CASE WHEN TrangThai = '1' THEN 1 ELSE 0 END) AS preparingOrders,
                SUM(CASE WHEN TrangThai = '2' THEN 1 ELSE 0 END) AS shippingOrders,
                SUM(CASE WHEN TrangThai = '3' THEN 1 ELSE 0 END) AS completedOrders,
                SUM(CASE WHEN TrangThai = '4' THEN 1 ELSE 0 END) AS cancelledOrders
            FROM donhang
        ");
        $stmt->execute();
        $orderStats = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($orderStats) {
            foreach ($orderStats as $key => $value) {
                $stats[$key] = $key === 'totalRevenue' ? (float)$value : (int)$value;
            }
        }

        $stats['totalUsers'] = (int)$this->db->query("SELECT COUNT(*) FROM nguoidung")->fetchColumn();
        $stats['totalProducts'] = (int)$this->db->query("SELECT COUNT(*) FROM sanpham")->fetchColumn();
        $stats['publishedPosts'] = (int)$this->db->query("SELECT COUNT(*) FROM baiviet")->fetchColumn();
        $stats['pendingReviews'] = (int)$this->db->query("SELECT COUNT(*) FROM danhgia WHERE TrangThai = 0")->fetchColumn();
        $stats['totalReviews'] = (int)$this->db->query("SELECT COUNT(*) FROM danhgia")->fetchColumn();

        return $stats;
    }

    public function getRecentOrders($limit = 5)
    {
        $sql = "
            SELECT
                dh.MaDonHang, dh.MaNguoiDung, dh.NgayDat, dh.TongTien, dh.TrangThai,
                dh.DiaChiGiaoHang, dh.TenNguoiNhan, dh.SDTNguoiNhan,
                dh.SoTienGiam, dh.PhiVanChuyen, dh.ThanhTienCuoi,
                nd.HoTen, nd.Email, nd.SoDienThoai,
                mg.MaCode, mg.PhamTramGiam,
                pttt.TenPTTT, ptvc.TenPTVC,
                COUNT(ct.MaBienThe) AS TongLoaiSanPham,
                COALESCE(SUM(ct.SoLuong), 0) AS TongSoLuong
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            LEFT JOIN chitietdonhang ct ON dh.MaDonHang = ct.MaDonHang
            GROUP BY dh.MaDonHang
            ORDER BY dh.NgayDat DESC
            LIMIT :limit
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        $whereSql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT
                dh.MaDonHang, dh.MaNguoiDung, dh.NgayDat, dh.TongTien, dh.TrangThai,
                dh.DiaChiGiaoHang, dh.MaPTTT, dh.MaPTVC, dh.MaCode, dh.MaDiaChi,
                dh.TenNguoiNhan, dh.SDTNguoiNhan, dh.SoTienGiam, dh.PhiVanChuyen, dh.ThanhTienCuoi,
                nd.HoTen, nd.Email, nd.SoDienThoai,
                mg.PhamTramGiam,
                pttt.TenPTTT, ptvc.TenPTVC,
                COUNT(ct.MaBienThe) AS TongLoaiSanPham,
                COALESCE(SUM(ct.SoLuong), 0) AS TongSoLuong
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            LEFT JOIN chitietdonhang ct ON dh.MaDonHang = ct.MaDonHang
            $whereSql
            GROUP BY dh.MaDonHang
            ORDER BY dh.NgayDat DESC, dh.MaDonHang DESC
        ";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT
                dh.MaDonHang, dh.MaNguoiDung, dh.NgayDat, dh.TongTien, dh.TrangThai,
                dh.DiaChiGiaoHang, dh.MaPTTT, dh.MaPTVC, dh.MaCode, dh.MaDiaChi,
                dh.TenNguoiNhan, dh.SDTNguoiNhan, dh.SoTienGiam, dh.PhiVanChuyen, dh.ThanhTienCuoi,
                nd.HoTen, nd.Email, nd.SoDienThoai,
                mg.PhamTramGiam, mg.NgayHetHan,
                pttt.TenPTTT,
                ptvc.TenPTVC, ptvc.GiaCuoc
            FROM donhang dh
            LEFT JOIN nguoidung nd ON dh.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN magiamgia mg ON dh.MaCode = mg.MaCode
            LEFT JOIN ptthanhtoan pttt ON dh.MaPTTT = pttt.MaPTTT
            LEFT JOIN ptvanchuyen ptvc ON dh.MaPTVC = ptvc.MaPTVC
            WHERE dh.MaDonHang = :orderId
            LIMIT 1
        ");
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT
                ct.MaDonHang, ct.MaBienThe, ct.SoLuong, ct.DonGia,
                bt.MaSanPham, bt.KichThuoc, bt.MauSac, bt.GiaTien, bt.SoLuongTon,
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
        ");
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderStatus($orderId)
    {
        $stmt = $this->db->prepare("SELECT TrangThai FROM donhang WHERE MaDonHang = :orderId LIMIT 1");
        $stmt->bindValue(':orderId', $orderId);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order ? (string)$order['TrangThai'] : null;
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $newStatus = (string)$newStatus;

        if (!in_array($newStatus, ['0', '1', '2', '3', '4'], true)) {
            return ['success' => false, 'message' => 'Trạng thái đơn hàng không hợp lệ.'];
        }

        try {
            $this->db->beginTransaction();

            $currentStatus = $this->getOrderStatus($orderId);

            if ($currentStatus === null) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Không tìm thấy đơn hàng.'];
            }

            if ($currentStatus === '4') {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Đơn hàng đã hủy rồi, không thể cập nhật tiếp để tránh sai tồn kho.'];
            }

            if ($currentStatus === $newStatus) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Đơn hàng đang ở trạng thái này rồi.'];
            }

            if ((int)$newStatus < (int)$currentStatus && $newStatus !== '4') {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Không thể lùi trạng thái đơn hàng.'];
            }

            if ($newStatus === '4') {
                $this->restoreStockForOrder($orderId);
            }

            $stmt = $this->db->prepare("UPDATE donhang SET TrangThai = :newStatus WHERE MaDonHang = :orderId");
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
            return ['success' => false, 'message' => 'Lỗi cập nhật đơn hàng: ' . $e->getMessage()];
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

    /* =========================================================
       PRODUCTS + CATEGORIES — Ái Linh
       ========================================================= */

    public function countProductsList(array $filters = []): int
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $where[] = '(sp.TenSanPham LIKE :keyword OR sp.MoTa LIKE :keyword OR sp.NguonGoc LIKE :keyword)';
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category'])) {
            $where[] = 'sp.MaDanhMuc = :category';
            $params[':category'] = $filters['category'];
        }

        if (!empty($filters['brand'])) {
            $where[] = 'sp.MaThuongHieu = :brand';
            $params[':brand'] = $filters['brand'];
        }

        $sql = "
        SELECT COUNT(*)
        FROM sanpham sp
        WHERE " . implode(' AND ', $where) . "
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    public function getProductsList(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $where[] = '(sp.TenSanPham LIKE :keyword OR sp.MoTa LIKE :keyword OR sp.NguonGoc LIKE :keyword)';
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category'])) {
            $where[] = 'sp.MaDanhMuc = :category';
            $params[':category'] = $filters['category'];
        }

        if (!empty($filters['brand'])) {
            $where[] = 'sp.MaThuongHieu = :brand';
            $params[':brand'] = $filters['brand'];
        }

        $limit = max(1, (int)$limit);
        $offset = max(0, (int)$offset);

        $sql = "
        SELECT
            sp.MaSanPham AS id,
            sp.TenSanPham AS name,
            sp.TrangThai AS status,
            sp.DiemXanh AS eco_score,
            sp.MaDanhMuc AS category_id,
            dm.TenDanhMuc AS category_name,
            sp.MaThuongHieu AS brand_id,
            th.TenThuongHieu AS brand_name,
            sp.MaVatLieu AS material_id,
            vl.TenVatLieu AS material_name,
            COALESCE(v.min_price, 0) AS price,
            COALESCE(v.total_stock, 0) AS stock,
            COALESCE(img.DuongDan, '') AS image,
            COALESCE(img.image_count, 0) AS image_count,
            COALESCE(v.variant_count, 0) AS variant_count
        FROM sanpham sp
        LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
        LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
        LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
        LEFT JOIN (
            SELECT MaSanPham, MIN(GiaTien) AS min_price, SUM(SoLuongTon) AS total_stock, COUNT(*) AS variant_count
            FROM bienthesanpham
            GROUP BY MaSanPham
        ) v ON v.MaSanPham = sp.MaSanPham
        LEFT JOIN (
            SELECT MaSanPham, MIN(DuongDan) AS DuongDan, COUNT(*) AS image_count
            FROM hinhanhsanpham
            GROUP BY MaSanPham
        ) img ON img.MaSanPham = sp.MaSanPham
        WHERE " . implode(' AND ', $where) . "
        ORDER BY sp.MaSanPham ASC
        LIMIT {$limit} OFFSET {$offset}
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['image'] = $this->formatImageUrl($product['image'] ?? '');
        }

        return $products;
    }

    public function getProductById(string $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                sp.*,
                dm.TenDanhMuc AS category_name,
                th.TenThuongHieu AS brand_name,
                vl.TenVatLieu AS material_name,
                COALESCE(img.image_count, 0) AS image_count,
                COALESCE(v.variant_count, 0) AS variant_count,
                COALESCE(v.min_price, 0) AS min_price,
                COALESCE(v.total_stock, 0) AS total_stock
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
            LEFT JOIN (
                SELECT MaSanPham, COUNT(*) AS variant_count, MIN(GiaTien) AS min_price, SUM(SoLuongTon) AS total_stock
                FROM bienthesanpham
                GROUP BY MaSanPham
            ) v ON v.MaSanPham = sp.MaSanPham
            LEFT JOIN (
                SELECT MaSanPham, COUNT(*) AS image_count
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ) img ON img.MaSanPham = sp.MaSanPham
            WHERE sp.MaSanPham = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getCategoriesList(): array
    {
        $sql = "
            SELECT
                dm.MaDanhMuc,
                dm.TenDanhMuc,
                dm.HinhAnh,
                " . ($this->hasColumn('danhmuc', 'TrangThai') ? "COALESCE(dm.TrangThai, 1)" : "1") . " AS TrangThai,
                (SELECT COUNT(*) FROM sanpham sp WHERE sp.MaDanhMuc = dm.MaDanhMuc) AS product_count
            FROM danhmuc dm
            ORDER BY dm.MaDanhMuc ASC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById(string $id): ?array
    {
        if ($this->hasColumn('danhmuc', 'TrangThai')) {
            $stmt = $this->db->prepare("SELECT dm.*, COALESCE(dm.TrangThai, 1) AS TrangThai FROM danhmuc dm WHERE dm.MaDanhMuc = ? LIMIT 1");
        } else {
            $stmt = $this->db->prepare("SELECT dm.*, 1 AS TrangThai FROM danhmuc dm WHERE dm.MaDanhMuc = ? LIMIT 1");
        }
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getBrands(): array
    {
        $stmt = $this->db->query('SELECT MaThuongHieu, TenThuongHieu FROM thuonghieu ORDER BY MaThuongHieu ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaterials(): array
    {
        $stmt = $this->db->query('SELECT MaVatLieu, TenVatLieu FROM vatlieu ORDER BY MaVatLieu ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO sanpham
                (MaSanPham, TenSanPham, MaDanhMuc, MaThuongHieu, MaVatLieu, MoTa, DiemXanh, NguonGoc, TacDongMoiTruong, CoTaiChe, ThanThienMoiTruong, TrangThai)
            VALUES
                (:MaSanPham, :TenSanPham, :MaDanhMuc, :MaThuongHieu, :MaVatLieu, :MoTa, :DiemXanh, :NguonGoc, :TacDongMoiTruong, :CoTaiChe, :ThanThienMoiTruong, :TrangThai)
        ");

        return $stmt->execute([
            ':MaSanPham' => $data['MaSanPham'],
            ':TenSanPham' => $data['TenSanPham'],
            ':MaDanhMuc' => $data['MaDanhMuc'],
            ':MaThuongHieu' => $data['MaThuongHieu'] ?: null,
            ':MaVatLieu' => $data['MaVatLieu'] ?: null,
            ':MoTa' => $data['MoTa'],
            ':DiemXanh' => $data['DiemXanh'],
            ':NguonGoc' => $data['NguonGoc'],
            ':TacDongMoiTruong' => $data['TacDongMoiTruong'],
            ':CoTaiChe' => $data['CoTaiChe'],
            ':ThanThienMoiTruong' => $data['ThanThienMoiTruong'],
            ':TrangThai' => 0
        ]);
    }

    public function updateProduct(string $id, array $data): bool
    {
        if (isset($data['TrangThai']) && (int)$data['TrangThai'] === 1 && !$this->productCanBeVisible($id)) {
            $data['TrangThai'] = 0;
        }

        $stmt = $this->db->prepare("
            UPDATE sanpham SET
                TenSanPham = :TenSanPham,
                MaDanhMuc = :MaDanhMuc,
                MaThuongHieu = :MaThuongHieu,
                MaVatLieu = :MaVatLieu,
                MoTa = :MoTa,
                DiemXanh = :DiemXanh,
                NguonGoc = :NguonGoc,
                TacDongMoiTruong = :TacDongMoiTruong,
                CoTaiChe = :CoTaiChe,
                ThanThienMoiTruong = :ThanThienMoiTruong,
                TrangThai = :TrangThai
            WHERE MaSanPham = :MaSanPham
        ");

        return $stmt->execute([
            ':TenSanPham' => $data['TenSanPham'],
            ':MaDanhMuc' => $data['MaDanhMuc'],
            ':MaThuongHieu' => $data['MaThuongHieu'] ?: null,
            ':MaVatLieu' => $data['MaVatLieu'] ?: null,
            ':MoTa' => $data['MoTa'],
            ':DiemXanh' => $data['DiemXanh'],
            ':NguonGoc' => $data['NguonGoc'],
            ':TacDongMoiTruong' => $data['TacDongMoiTruong'],
            ':CoTaiChe' => $data['CoTaiChe'],
            ':ThanThienMoiTruong' => $data['ThanThienMoiTruong'],
            ':TrangThai' => $data['TrangThai'],
            ':MaSanPham' => $id
        ]);
    }

    public function hideProduct(string $id): bool
    {
        $stmt = $this->db->prepare('UPDATE sanpham SET TrangThai = 0 WHERE MaSanPham = ?');
        return $stmt->execute([$id]);
    }

    public function showProduct(string $id): bool
    {
        if (!$this->productCanBeVisible($id)) {
            return false;
        }

        $stmt = $this->db->prepare('UPDATE sanpham SET TrangThai = 1 WHERE MaSanPham = ?');
        return $stmt->execute([$id]);
    }

    public function productHasOrders(string $id): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM chitietdonhang ct
            INNER JOIN bienthesanpham bt ON bt.MaBienThe = ct.MaBienThe
            WHERE bt.MaSanPham = ?
        ");
        $stmt->execute([$id]);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function deleteProduct(string $id): bool
    {
        if ($this->productHasOrders($id)) {
            return false;
        }

        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare('DELETE FROM yeuthich WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $stmt = $this->db->prepare('DELETE FROM sanpham_chungnhan WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $stmt = $this->db->prepare('DELETE FROM danhgia WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $stmt = $this->db->prepare('DELETE FROM hinhanhsanpham WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $stmt = $this->db->prepare('DELETE FROM bienthesanpham WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $stmt = $this->db->prepare('DELETE FROM sanpham WHERE MaSanPham = ?');
            $stmt->execute([$id]);

            $this->db->commit();

            return $stmt->rowCount() > 0;
        } catch (Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function createCategory(array $data): bool
    {
        $fields = ['MaDanhMuc', 'TenDanhMuc', 'HinhAnh'];
        $placeholders = [':MaDanhMuc', ':TenDanhMuc', ':HinhAnh'];
        $values = [
            ':MaDanhMuc' => $data['MaDanhMuc'],
            ':TenDanhMuc' => $data['TenDanhMuc'],
            ':HinhAnh' => $data['HinhAnh'] ?: null
        ];

        if ($this->hasColumn('danhmuc', 'TrangThai')) {
            $fields[] = 'TrangThai';
            $placeholders[] = ':TrangThai';
            $values[':TrangThai'] = $data['TrangThai'] ?? 1;
        }

        $stmt = $this->db->prepare(sprintf('INSERT INTO danhmuc (%s) VALUES (%s)', implode(', ', $fields), implode(', ', $placeholders)));
        return $stmt->execute($values);
    }

    public function updateCategory(string $id, array $data): bool
    {
        $set = ['TenDanhMuc = :TenDanhMuc', 'HinhAnh = :HinhAnh'];
        $values = [
            ':TenDanhMuc' => $data['TenDanhMuc'],
            ':HinhAnh' => $data['HinhAnh'] ?: null,
            ':MaDanhMuc' => $id
        ];

        if ($this->hasColumn('danhmuc', 'TrangThai')) {
            $set[] = 'TrangThai = :TrangThai';
            $values[':TrangThai'] = $data['TrangThai'] ?? 1;
        }

        $stmt = $this->db->prepare(sprintf('UPDATE danhmuc SET %s WHERE MaDanhMuc = :MaDanhMuc', implode(', ', $set)));
        return $stmt->execute($values);
    }

    public function softDeleteCategory(string $id): bool
    {
        if (!$this->hasColumn('danhmuc', 'TrangThai')) {
            return true;
        }
        $stmt = $this->db->prepare('UPDATE danhmuc SET TrangThai = 0 WHERE MaDanhMuc = ?');
        return $stmt->execute([$id]);
    }

    public function categoryHasProducts(string $id): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM sanpham WHERE MaDanhMuc = ?');
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function productCanBeVisible(string $productId): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM bienthesanpham WHERE MaSanPham = ? AND GiaTien > 0 AND SoLuongTon > 0');
        $stmt->execute([$productId]);
        if ((int)$stmt->fetchColumn() === 0) {
            return false;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM hinhanhsanpham WHERE MaSanPham = ?');
        $stmt->execute([$productId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function addProductImage(string $productId, string $imageFileName): bool
    {
        $imageId = $this->generateImageId();
        $stmt = $this->db->prepare('INSERT INTO hinhanhsanpham (MaHinhAnh, MaSanPham, DuongDan) VALUES (:MaHinhAnh, :MaSanPham, :DuongDan)');
        return $stmt->execute([
            ':MaHinhAnh' => $imageId,
            ':MaSanPham' => $productId,
            ':DuongDan' => $imageFileName
        ]);
    }

    public function generateProductId(): string
    {
        return $this->generateNewId('sanpham', 'MaSanPham', 'P');
    }

    public function generateCategoryId(): string
    {
        return $this->generateNewId('danhmuc', 'MaDanhMuc', 'C');
    }

    private function generateImageId(): string
    {
        return $this->generateNewId('hinhanhsanpham', 'MaHinhAnh', 'IMG');
    }

    /* =========================================================
       VARIANTS + GALLERY + INVENTORY + REVIEWS — Yến Linh
       ========================================================= */

    public function getReviews(string $keyword = '', string $tab = 'all'): array
    {
        $sql = "
            SELECT dg.*, nd.HoTen AS TenNguoiDung, sp.TenSanPham
            FROM danhgia dg
            LEFT JOIN nguoidung nd ON dg.MaNguoiDung = nd.MaNguoiDung
            LEFT JOIN sanpham sp ON dg.MaSanPham = sp.MaSanPham
            WHERE 1=1
        ";
        $params = [];

        if ($tab === 'pending') {
            $sql .= " AND dg.TrangThai = 0";
        } elseif ($tab === 'approved') {
            $sql .= " AND dg.TrangThai = 1";
        }

        if ($keyword !== '') {
            $sql .= " AND (nd.HoTen LIKE :kw OR sp.TenSanPham LIKE :kw2 OR dg.NoiDung LIKE :kw3)";
            $params[':kw'] = "%$keyword%";
            $params[':kw2'] = "%$keyword%";
            $params[':kw3'] = "%$keyword%";
        }

        $sql .= " ORDER BY dg.NgayDanhGia DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare("UPDATE danhgia SET TrangThai = 1 WHERE MaDanhGia = ?");
        return $stmt->execute([$maDanhGia]);
    }

    public function hideReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare("UPDATE danhgia SET TrangThai = 0 WHERE MaDanhGia = ?");
        return $stmt->execute([$maDanhGia]);
    }

    public function deleteReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare("DELETE FROM danhgia WHERE MaDanhGia = ?");
        return $stmt->execute([$maDanhGia]);
    }

    public function saveAdminReply(string $maDanhGia, string $reply): bool
    {
        if (!$this->hasColumn('danhgia', 'PhanHoiAdmin')) {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE danhgia SET PhanHoiAdmin = ? WHERE MaDanhGia = ?");
        return $stmt->execute([trim($reply), $maDanhGia]);
    }

    public function getInventory(string $keyword = ''): array
    {
        $sql = "
            SELECT bt.*, sp.TenSanPham
            FROM bienthesanpham bt
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE 1=1
        ";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (sp.TenSanPham LIKE :kw OR bt.MauSac LIKE :kw2 OR bt.KichThuoc LIKE :kw3)";
            $params[':kw'] = "%$keyword%";
            $params[':kw2'] = "%$keyword%";
            $params[':kw3'] = "%$keyword%";
        }

        $sql .= " ORDER BY sp.TenSanPham ASC, bt.MaBienThe ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStock(string $maBienThe, int $soLuong): bool
    {
        $stmt = $this->db->prepare("UPDATE bienthesanpham SET SoLuongTon = ? WHERE MaBienThe = ?");
        return $stmt->execute([$soLuong, $maBienThe]);
    }

    public function variantHasOrders(string $maBienThe): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM chitietdonhang WHERE MaBienThe = ?");
        $stmt->execute([$maBienThe]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function deleteVariant(string $maBienThe): bool
    {
        $stmt = $this->db->prepare("DELETE FROM bienthesanpham WHERE MaBienThe = ?");
        return $stmt->execute([$maBienThe]);
    }

    public function getSuppliers(): array
    {
        if (!$this->tableExists('nhacungcap')) {
            return [];
        }
        $stmt = $this->db->query("SELECT * FROM nhacungcap ORDER BY TenNCC ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImportReceipts(): array
    {
        if (!$this->tableExists('phieunhap')) {
            return [];
        }
        $sql = "
            SELECT pn.*, ncc.TenNCC
            FROM phieunhap pn
            LEFT JOIN nhacungcap ncc ON pn.MaNCC = ncc.MaNCC
            ORDER BY pn.NgayNhap DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSupplier(string $tenNCC, string $soDienThoai, string $diaChi): bool
    {
        if (!$this->tableExists('nhacungcap')) {
            return false;
        }

        $count = (int)$this->db->query("SELECT COUNT(*) FROM nhacungcap")->fetchColumn() + 1;
        $maNCC = 'NCC' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $stmt = $this->db->prepare("INSERT INTO nhacungcap (MaNCC, TenNCC, SoDienThoai, DiaChi) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$maNCC, $tenNCC, $soDienThoai, $diaChi]);
    }

    public function getVariantsByProduct(string $maSanPham): array
    {
        $stmt = $this->db->prepare("
            SELECT bt.*, sp.TenSanPham
            FROM bienthesanpham bt
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE bt.MaSanPham = ?
            ORDER BY bt.MaBienThe ASC
        ");
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVariant(string $maSanPham, string $mauSac, string $kichThuoc, float $giaTien, int $soLuong): bool
    {
        $maBienThe = $this->generateNewId('bienthesanpham', 'MaBienThe', 'BT');

        $stmt = $this->db->prepare("
            INSERT INTO bienthesanpham (MaBienThe, MaSanPham, MauSac, KichThuoc, GiaTien, SoLuongTon)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$maBienThe, $maSanPham, $mauSac, $kichThuoc, $giaTien, $soLuong]);
    }

    public function updateVariant(string $maBienThe, string $mauSac, string $kichThuoc, float $giaTien, int $soLuong): bool
    {
        $stmt = $this->db->prepare("
            UPDATE bienthesanpham
            SET MauSac = ?, KichThuoc = ?, GiaTien = ?, SoLuongTon = ?
            WHERE MaBienThe = ?
        ");
        return $stmt->execute([$mauSac, $kichThuoc, $giaTien, $soLuong, $maBienThe]);
    }

    public function getGallery(string $maSanPham): array
    {
        $stmt = $this->db->prepare("
            SELECT h.*, sp.TenSanPham
            FROM hinhanhsanpham h
            LEFT JOIN sanpham sp ON h.MaSanPham = sp.MaSanPham
            WHERE h.MaSanPham = ?
            ORDER BY h.MaHinhAnh ASC
        ");
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function uploadGalleryImage(string $maSanPham, array $file): bool
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            return false;
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $uploadDir = ROOT_PATH . '/public/assets/images/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = $maSanPham . '_gallery_' . time() . '_' . uniqid() . '.' . $ext;
        $dest = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return false;
        }

        return $this->addProductImage($maSanPham, $filename);
    }

    public function deleteGalleryImage(string $maAnh): bool
    {
        $stmt = $this->db->prepare("SELECT DuongDan FROM hinhanhsanpham WHERE MaHinhAnh = ?");
        $stmt->execute([$maAnh]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $path = $row['DuongDan'];
            $fullPaths = [
                ROOT_PATH . '/public/assets/images/products/' . ltrim($path, '/'),
                ROOT_PATH . '/' . ltrim($path, '/'),
            ];

            foreach ($fullPaths as $fullPath) {
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                    break;
                }
            }
        }

        $stmt = $this->db->prepare("DELETE FROM hinhanhsanpham WHERE MaHinhAnh = ?");
        return $stmt->execute([$maAnh]);
    }

    /* =========================================================
       BLOG + PROMO — Long
       ========================================================= */

    public function getAllPosts()
    {
        $stmt = $this->db->prepare("
            SELECT bv.MaBaiViet, bv.TieuDe, bv.NoiDung, bv.HinhAnhBia, bv.NgayDang, bv.MaNguoiDung,
                   nd.HoTen AS TenTacGia
            FROM baiviet bv
            LEFT JOIN nguoidung nd ON bv.MaNguoiDung = nd.MaNguoiDung
            ORDER BY bv.NgayDang DESC, bv.MaBaiViet DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $stmt = $this->db->prepare("
            SELECT MaBaiViet, TieuDe, NoiDung, HinhAnhBia, NgayDang, MaNguoiDung
            FROM baiviet
            WHERE MaBaiViet = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($data)
    {
        $postId = $this->generatePostId();
        $stmt = $this->db->prepare("
            INSERT INTO baiviet (MaBaiViet, TieuDe, NoiDung, HinhAnhBia, NgayDang, MaNguoiDung)
            VALUES (?, ?, ?, ?, NOW(), ?)
        ");
        return $stmt->execute([$postId, $data['TieuDe'], $data['NoiDung'], $data['HinhAnhBia'], $data['MaNguoiDung']]);
    }

    public function updatePost($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE baiviet
            SET TieuDe = ?, NoiDung = ?, HinhAnhBia = ?
            WHERE MaBaiViet = ?
        ");
        return $stmt->execute([$data['TieuDe'], $data['NoiDung'], $data['HinhAnhBia'], $id]);
    }

    public function deletePost($id)
    {
        $stmt = $this->db->prepare("DELETE FROM baiviet WHERE MaBaiViet = ?");
        return $stmt->execute([$id]);
    }

    public function getAllPromos()
    {
        $stmt = $this->db->prepare("
            SELECT MaCode AS MaGiamGia, MaCode, PhamTramGiam, SoLuong, NgayHetHan
            FROM magiamgia
            ORDER BY NgayHetHan DESC, MaCode DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPromoById($id)
    {
        $stmt = $this->db->prepare("
            SELECT MaCode AS MaGiamGia, MaCode, PhamTramGiam, SoLuong, NgayHetHan
            FROM magiamgia
            WHERE MaCode = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPromo($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO magiamgia (MaCode, PhamTramGiam, SoLuong, NgayHetHan)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$data['MaCode'], $data['PhamTramGiam'], $data['SoLuong'], $data['NgayHetHan']]);
    }

    public function updatePromo($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE magiamgia
            SET MaCode = ?, PhamTramGiam = ?, SoLuong = ?, NgayHetHan = ?
            WHERE MaCode = ?
        ");
        return $stmt->execute([$data['MaCode'], $data['PhamTramGiam'], $data['SoLuong'], $data['NgayHetHan'], $id]);
    }

    public function deletePromo($id)
    {
        $stmt = $this->db->prepare("DELETE FROM magiamgia WHERE MaCode = ?");
        return $stmt->execute([$id]);
    }

    public function promoCodeExists($code, $ignoreId = null)
    {
        if ($ignoreId) {
            $stmt = $this->db->prepare("SELECT MaCode FROM magiamgia WHERE MaCode = ? AND MaCode != ?");
            $stmt->execute([$code, $ignoreId]);
        } else {
            $stmt = $this->db->prepare("SELECT MaCode FROM magiamgia WHERE MaCode = ?");
            $stmt->execute([$code]);
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getGameRewards()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, reward_key, label, voucher_code, weight, sort_order, status
                FROM game_rewards
                ORDER BY sort_order ASC, id ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }

    public function updateGameRewards(array $rewards): bool
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("
                UPDATE game_rewards
                SET label = ?, voucher_code = ?, weight = ?, status = ?
                WHERE id = ?
            ");

            foreach ($rewards as $reward) {
                $stmt->execute([
                    trim((string)($reward['label'] ?? '')),
                    trim((string)($reward['voucher_code'] ?? '')) ?: null,
                    max(1, (int)($reward['weight'] ?? 1)),
                    !empty($reward['status']) ? 1 : 0,
                    (int)($reward['id'] ?? 0),
                ]);
            }

            return $this->db->commit();
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function getFlashSales()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT fs.*, sp.TenSanPham
                FROM flash_sales fs
                LEFT JOIN sanpham sp ON sp.MaSanPham = fs.product_id
                ORDER BY fs.created_at DESC, fs.id DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }

    public function getProductsForFlashSale()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT MaSanPham, TenSanPham
                FROM sanpham
                ORDER BY TenSanPham ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }

    public function createFlashSale(array $data): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO flash_sales
                (product_id, variant_id, sale_price, start_time, end_time, stock_limit, sold_count, status)
                VALUES (?, NULL, ?, ?, ?, ?, 0, ?)
            ");
            return $stmt->execute([
                $data['product_id'],
                $data['sale_price'],
                $data['start_time'],
                $data['end_time'],
                $data['stock_limit'],
                $data['status'],
            ]);
        } catch (Throwable $e) {
            return false;
        }
    }

    public function deleteFlashSale($id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM flash_sales WHERE id = ?");
            return $stmt->execute([(int)$id]);
        } catch (Throwable $e) {
            return false;
        }
    }

    /* =========================================================
       HELPERS
       ========================================================= */

    private function generateNewId(string $table, string $column, string $prefix): string
    {
        $stmt = $this->db->prepare("
            SELECT MAX(CAST(SUBSTRING($column, LENGTH(:prefix) + 1) AS UNSIGNED)) AS max_id
            FROM $table
            WHERE $column LIKE CONCAT(:prefix, '%')
        ");
        $stmt->execute([':prefix' => $prefix]);
        $last = (int)$stmt->fetchColumn();
        return $prefix . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }

    private function generatePostId(): string
    {
        return $this->generateNewId('baiviet', 'MaBaiViet', 'BL');
    }

    private function hasColumn(string $table, string $column): bool
    {
        $stmt = $this->db->prepare('SHOW COLUMNS FROM ' . $table . ' LIKE ?');
        $stmt->execute([$column]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function tableExists(string $table): bool
    {
        $stmt = $this->db->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$table]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function formatImageUrl(string $path): string
    {
        return product_image_url($path);
    }
}
