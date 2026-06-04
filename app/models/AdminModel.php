<?php

class AdminModel extends Model
{
    private const LOW_STOCK_THRESHOLD = 5;
    private const CANCELLED_ORDER_STATUS = '4';
    public const PRODUCT_DETAIL_IMAGE_LIMIT = 8;

    /* =========================================================
       DASHBOARD + ORDERS — Phúc
       ========================================================= */

    public function getDashboardStats()
    {
        $stats = [
            'todayRevenue' => 0,
            'monthRevenue' => 0,
            'totalRevenue' => 0,
            'totalOrders' => 0,
            'newOrders' => 0,
            'totalUsers' => 0,
            'completedOrders' => 0,
            'cancelledOrders' => 0,
            'preparingOrders' => 0,
            'shippingOrders' => 0,
            'totalProducts' => 0,
            'activeProducts' => 0,
            'totalCategories' => 0,
            'lowStockProducts' => 0,
            'lowStockItems' => 0,
            'outOfStockItems' => 0,
            'completionRate' => 0,
            'publishedPosts' => 0,
            'pendingReviews' => 0,
            'totalReviews' => 0,
            'lowStockThreshold' => self::LOW_STOCK_THRESHOLD,
        ];

        if ($this->tableExists('donhang')) {
            $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));
            $todayStart = $now->format('Y-m-d 00:00:00');
            $todayEnd = $now->format('Y-m-d 23:59:59');
            $monthStart = $now->format('Y-m-01 00:00:00');

            $stmt = $this->db->prepare("
                SELECT
                    COALESCE(SUM(CASE WHEN TrangThai = :completedStatus THEN ThanhTienCuoi ELSE 0 END), 0) AS totalRevenue,
                    COALESCE(SUM(CASE WHEN TrangThai = :completedStatus AND NgayDat BETWEEN :todayStart AND :todayEnd THEN ThanhTienCuoi ELSE 0 END), 0) AS todayRevenue,
                    COALESCE(SUM(CASE WHEN TrangThai = :completedStatus AND NgayDat >= :monthStart THEN ThanhTienCuoi ELSE 0 END), 0) AS monthRevenue,
                    COUNT(*) AS totalOrders,
                    SUM(CASE WHEN TrangThai = '0' THEN 1 ELSE 0 END) AS newOrders,
                    SUM(CASE WHEN TrangThai = '1' THEN 1 ELSE 0 END) AS preparingOrders,
                    SUM(CASE WHEN TrangThai = '2' THEN 1 ELSE 0 END) AS shippingOrders,
                    SUM(CASE WHEN TrangThai = '3' THEN 1 ELSE 0 END) AS completedOrders,
                    SUM(CASE WHEN TrangThai = '4' THEN 1 ELSE 0 END) AS cancelledOrders
                FROM donhang
            ");
            $stmt->bindValue(':cancelledStatus', self::CANCELLED_ORDER_STATUS);
            $stmt->bindValue(':completedStatus', '3');
            $stmt->bindValue(':todayStart', $todayStart);
            $stmt->bindValue(':todayEnd', $todayEnd);
            $stmt->bindValue(':monthStart', $monthStart);
            $stmt->execute();
            $orderStats = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($orderStats) {
                foreach ($orderStats as $key => $value) {
                    $stats[$key] = in_array($key, ['totalRevenue', 'todayRevenue', 'monthRevenue'], true)
                        ? (float)$value
                        : (int)$value;
                }
            }

            $stats['completionRate'] = $stats['totalOrders'] > 0
                ? round(($stats['completedOrders'] / $stats['totalOrders']) * 100)
                : 0;
        }

        if ($this->tableExists('nguoidung')) {
            $stats['totalUsers'] = (int)$this->db->query("SELECT COUNT(*) FROM nguoidung")->fetchColumn();
        }

        if ($this->tableExists('sanpham')) {
            $stats['totalProducts'] = (int)$this->db->query("SELECT COUNT(*) FROM sanpham")->fetchColumn();
            $stats['activeProducts'] = $this->hasColumn('sanpham', 'TrangThai')
                ? (int)$this->db->query("SELECT COUNT(*) FROM sanpham WHERE TrangThai = 1")->fetchColumn()
                : $stats['totalProducts'];
        }

        if ($this->tableExists('danhmuc')) {
            $stats['totalCategories'] = (int)$this->db->query("SELECT COUNT(*) FROM danhmuc")->fetchColumn();
        }

        if ($this->tableExists('bienthesanpham')) {
            $threshold = self::LOW_STOCK_THRESHOLD;
            $stats['lowStockItems'] = (int)$this->db->query("
                SELECT COUNT(*) FROM bienthesanpham
                WHERE SoLuongTon > 0 AND SoLuongTon <= {$threshold}
            ")->fetchColumn();
            $stats['outOfStockItems'] = (int)$this->db->query("
                SELECT COUNT(*) FROM bienthesanpham
                WHERE SoLuongTon = 0
            ")->fetchColumn();
            $stats['lowStockProducts'] = (int)$this->db->query("
                SELECT COUNT(*)
                FROM (
                    SELECT MaSanPham, COALESCE(SUM(SoLuongTon), 0) AS total_stock
                    FROM bienthesanpham
                    GROUP BY MaSanPham
                ) stock_summary
                WHERE total_stock > 0 AND total_stock <= {$threshold}
            ")->fetchColumn();
        }

        if ($this->tableExists('baiviet')) {
            $stats['publishedPosts'] = (int)$this->db->query("SELECT COUNT(*) FROM baiviet WHERE COALESCE(TrangThai, 1) = 1")->fetchColumn();
        }

        if ($this->tableExists('danhgia')) {
            $stats['pendingReviews'] = $this->hasColumn('danhgia', 'TrangThai')
                ? (int)$this->db->query("SELECT COUNT(*) FROM danhgia WHERE TrangThai = 0")->fetchColumn()
                : 0;
            $stats['totalReviews'] = (int)$this->db->query("SELECT COUNT(*) FROM danhgia")->fetchColumn();
        }

        return $stats;
    }

    public function getRevenueLast7Days(): array
    {
        $labels = [];
        $valuesByDate = [];
        $now = new DateTimeImmutable('now', new DateTimeZone('Asia/Bangkok'));

        for ($i = 6; $i >= 0; $i--) {
            $day = $now->modify("-{$i} days");
            $date = $day->format('Y-m-d');
            $labels[] = $day->format('d/m');
            $valuesByDate[$date] = 0;
        }

        if (!$this->tableExists('donhang')) {
            return [
                'labels' => $labels,
                'values' => array_values($valuesByDate),
                'total' => 0
            ];
        }

        $startDate = array_key_first($valuesByDate);
        $endDate = array_key_last($valuesByDate);

        $stmt = $this->db->prepare("
            SELECT DATE(NgayDat) AS order_date, COALESCE(SUM(ThanhTienCuoi), 0) AS revenue
            FROM donhang
            WHERE TrangThai = :completedStatus
              AND DATE(NgayDat) BETWEEN :startDate AND :endDate
            GROUP BY DATE(NgayDat)
            ORDER BY order_date ASC
        ");
        $stmt->execute([
            ':startDate' => $startDate,
            ':endDate' => $endDate,
            ':completedStatus' => '3'
        ]);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $date = (string)($row['order_date'] ?? '');
            if (array_key_exists($date, $valuesByDate)) {
                $valuesByDate[$date] = (float)$row['revenue'];
            }
        }

        return [
            'labels' => $labels,
            'values' => array_values($valuesByDate),
            'total' => array_sum($valuesByDate)
        ];
    }

    public function getOrderStatusStats(): array
    {
        if (!$this->tableExists('donhang')) {
            return [
                'labels' => [],
                'values' => [],
                'total' => 0
            ];
        }

        $statusLabels = [
            '0' => 'Chờ xử lý',
            '1' => 'Đang chuẩn bị',
            '2' => 'Đang giao',
            '3' => 'Hoàn thành',
            '4' => 'Đã hủy'
        ];

        $stmt = $this->db->query("
            SELECT COALESCE(TrangThai, '') AS status, COUNT(*) AS total
            FROM donhang
            GROUP BY TrangThai
            ORDER BY TrangThai ASC
        ");

        $labels = [];
        $values = [];
        $total = 0;

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $status = (string)($row['status'] ?? '');
            $count = (int)($row['total'] ?? 0);
            $labels[] = $statusLabels[$status] ?? ($status !== '' ? $status : 'Không rõ');
            $values[] = $count;
            $total += $count;
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'total' => $total
        ];
    }

    public function getInventoryStockStats(): array
    {
        $labels = ['Còn hàng', 'Sắp hết', 'Hết hàng'];

        if (!$this->tableExists('bienthesanpham')) {
            return [
                'labels' => $labels,
                'values' => [0, 0, 0],
                'total' => 0
            ];
        }

        $threshold = self::LOW_STOCK_THRESHOLD;
        $stmt = $this->db->query("
            SELECT
                SUM(CASE WHEN SoLuongTon > {$threshold} THEN 1 ELSE 0 END) AS in_stock,
                SUM(CASE WHEN SoLuongTon > 0 AND SoLuongTon <= {$threshold} THEN 1 ELSE 0 END) AS low_stock,
                SUM(CASE WHEN SoLuongTon = 0 THEN 1 ELSE 0 END) AS out_of_stock
            FROM bienthesanpham
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $values = [
            (int)($row['in_stock'] ?? 0),
            (int)($row['low_stock'] ?? 0),
            (int)($row['out_of_stock'] ?? 0),
        ];

        return [
            'labels' => $labels,
            'values' => $values,
            'total' => array_sum($values)
        ];
    }

    public function getRecentOrders($limit = 5)
    {
        if (!$this->tableExists('donhang')) {
            return [];
        }

        $limit = max(1, (int)$limit);
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

    public function getLowStockItems($limit = 5): array
    {
        if (!$this->tableExists('bienthesanpham')) {
            return [];
        }

        $limit = max(1, (int)$limit);
        $threshold = self::LOW_STOCK_THRESHOLD;
        $productJoin = $this->tableExists('sanpham')
            ? 'LEFT JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham'
            : '';
        $productNameSelect = $this->tableExists('sanpham')
            ? 'sp.TenSanPham'
            : "bt.MaSanPham AS TenSanPham";

        $sql = "
            SELECT
                bt.MaBienThe,
                bt.MaSanPham,
                {$productNameSelect},
                bt.MauSac,
                bt.KichThuoc,
                bt.SoLuongTon,
                bt.GiaTien
            FROM bienthesanpham bt
            {$productJoin}
            WHERE bt.SoLuongTon > 0 AND bt.SoLuongTon <= :threshold
            ORDER BY bt.SoLuongTon ASC, bt.MaBienThe ASC
            LIMIT {$limit}
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopSellingProducts($limit = 5): array
    {
        if (!$this->tableExists('chitietdonhang') || !$this->tableExists('bienthesanpham')) {
            return [];
        }

        $limit = max(1, (int)$limit);
        $orderJoin = $this->tableExists('donhang')
            ? "LEFT JOIN donhang dh ON dh.MaDonHang = ct.MaDonHang"
            : '';
        $orderWhere = $this->tableExists('donhang')
            ? "WHERE dh.TrangThai = '3'"
            : '';
        $productJoin = $this->tableExists('sanpham')
            ? 'LEFT JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham'
            : '';
        $productNameSelect = $this->tableExists('sanpham')
            ? 'sp.TenSanPham'
            : "bt.MaSanPham AS TenSanPham";
        $productGroupBy = $this->tableExists('sanpham')
            ? 'bt.MaSanPham, sp.TenSanPham'
            : 'bt.MaSanPham';

        $sql = "
            SELECT
                bt.MaSanPham,
                {$productNameSelect},
                SUM(ct.SoLuong) AS total_sold,
                SUM(ct.SoLuong * ct.DonGia) AS revenue
            FROM chitietdonhang ct
            LEFT JOIN bienthesanpham bt ON bt.MaBienThe = ct.MaBienThe
            {$productJoin}
            {$orderJoin}
            {$orderWhere}
            GROUP BY {$productGroupBy}
            ORDER BY total_sold DESC, revenue DESC
            LIMIT {$limit}
        ";
        $stmt = $this->db->prepare($sql);
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
        $activeVariantWhere = $this->hasColumn('bienthesanpham', 'TrangThai') ? 'WHERE TrangThai = 1' : '';
        $imageStatsJoin = $this->productImageRoleColumnsExist()
            ? "
        LEFT JOIN (
            SELECT
                MaSanPham,
                COALESCE(MIN(CASE WHEN LoaiAnh = 'cover' THEN DuongDan END), MIN(DuongDan)) AS DuongDan,
                COUNT(*) AS image_count,
                CASE WHEN SUM(CASE WHEN LoaiAnh = 'cover' THEN 1 ELSE 0 END) > 0 THEN 1 WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS cover_count,
                CASE WHEN SUM(CASE WHEN LoaiAnh = 'cover' THEN 1 ELSE 0 END) > 0 THEN SUM(CASE WHEN LoaiAnh = 'detail' THEN 1 ELSE 0 END) ELSE GREATEST(COUNT(*) - 1, 0) END AS detail_count
            FROM hinhanhsanpham
            GROUP BY MaSanPham
        ) img ON img.MaSanPham = sp.MaSanPham"
            : "
        LEFT JOIN (
            SELECT
                MaSanPham,
                MIN(DuongDan) AS DuongDan,
                COUNT(*) AS image_count,
                CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS cover_count,
                GREATEST(COUNT(*) - 1, 0) AS detail_count
            FROM hinhanhsanpham
            GROUP BY MaSanPham
        ) img ON img.MaSanPham = sp.MaSanPham";

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
            COALESCE(v.max_price, 0) AS max_price,
            COALESCE(v.total_stock, 0) AS stock,
            COALESCE(img.DuongDan, '') AS image,
            COALESCE(img.image_count, 0) AS image_count,
            COALESCE(img.cover_count, 0) AS cover_image_count,
            COALESCE(img.detail_count, 0) AS detail_image_count,
            COALESCE(v.variant_count, 0) AS variant_count
        FROM sanpham sp
        LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
        LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
        LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
        LEFT JOIN (
            SELECT MaSanPham, MIN(GiaTien) AS min_price, MAX(GiaTien) AS max_price, SUM(SoLuongTon) AS total_stock, COUNT(*) AS variant_count
            FROM bienthesanpham
            {$activeVariantWhere}
            GROUP BY MaSanPham
        ) v ON v.MaSanPham = sp.MaSanPham
        {$imageStatsJoin}
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
        $activeVariantWhere = $this->hasColumn('bienthesanpham', 'TrangThai') ? 'WHERE b.TrangThai = 1' : '';
        $imageStatsJoin = $this->productImageRoleColumnsExist()
            ? "
            LEFT JOIN (
                SELECT
                    MaSanPham,
                    COUNT(*) AS image_count,
                    CASE WHEN SUM(CASE WHEN LoaiAnh = 'cover' THEN 1 ELSE 0 END) > 0 THEN 1 WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS cover_count,
                    CASE WHEN SUM(CASE WHEN LoaiAnh = 'cover' THEN 1 ELSE 0 END) > 0 THEN SUM(CASE WHEN LoaiAnh = 'detail' THEN 1 ELSE 0 END) ELSE GREATEST(COUNT(*) - 1, 0) END AS detail_count
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ) img ON img.MaSanPham = sp.MaSanPham"
            : "
            LEFT JOIN (
                SELECT
                    MaSanPham,
                    COUNT(*) AS image_count,
                    CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS cover_count,
                    GREATEST(COUNT(*) - 1, 0) AS detail_count
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ) img ON img.MaSanPham = sp.MaSanPham";

        $stmt = $this->db->prepare("
            SELECT
                sp.*,
                dm.TenDanhMuc AS category_name,
                th.TenThuongHieu AS brand_name,
                vl.TenVatLieu AS material_name,
                COALESCE(img.image_count, 0) AS image_count,
                COALESCE(img.cover_count, 0) AS cover_image_count,
                COALESCE(img.detail_count, 0) AS detail_image_count,
                COALESCE(v.variant_count, 0) AS variant_count,
                COALESCE(v.min_price, 0) AS min_price,
                COALESCE(v.primary_price, v.min_price, 0) AS GiaTien,
                COALESCE(v.primary_size, '') AS KichThuoc,
                COALESCE(v.primary_color, '') AS MauSac,
                COALESCE(v.total_stock, 0) AS total_stock
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
            LEFT JOIN (
                SELECT
                    b.MaSanPham,
                    COUNT(*) AS variant_count,
                    MIN(b.GiaTien) AS min_price,
                    SUM(b.SoLuongTon) AS total_stock,
                    SUBSTRING_INDEX(GROUP_CONCAT(b.GiaTien ORDER BY b.MaBienThe ASC), ',', 1) AS primary_price,
                    SUBSTRING_INDEX(GROUP_CONCAT(COALESCE(b.KichThuoc, '') ORDER BY b.MaBienThe ASC SEPARATOR '||'), '||', 1) AS primary_size,
                    SUBSTRING_INDEX(GROUP_CONCAT(COALESCE(b.MauSac, '') ORDER BY b.MaBienThe ASC SEPARATOR '||'), '||', 1) AS primary_color
                FROM bienthesanpham b
                {$activeVariantWhere}
                GROUP BY b.MaSanPham
            ) v ON v.MaSanPham = sp.MaSanPham
            {$imageStatsJoin}
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

    public function categoryExists(string $id): bool
    {
        if ($id === '') {
            return false;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM danhmuc WHERE MaDanhMuc = ?');
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function brandExists(string $id): bool
    {
        if ($id === '') {
            return true;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM thuonghieu WHERE MaThuongHieu = ?');
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function createBrand(string $name, string $origin = ''): ?string
    {
        $name = trim($name);
        $origin = trim($origin);

        if ($name === '') {
            return null;
        }

        $stmt = $this->db->prepare('SELECT MaThuongHieu FROM thuonghieu WHERE LOWER(TenThuongHieu) = LOWER(?) LIMIT 1');
        $stmt->execute([$name]);
        $existingId = $stmt->fetchColumn();
        if ($existingId) {
            return (string)$existingId;
        }

        $brandId = $this->generateNewId('thuonghieu', 'MaThuongHieu', 'B');
        $insert = $this->db->prepare('INSERT INTO thuonghieu (MaThuongHieu, TenThuongHieu, XuatXu) VALUES (?, ?, ?)');

        return $insert->execute([$brandId, $name, $origin ?: null]) ? $brandId : null;
    }

    public function materialExists(string $id): bool
    {
        if ($id === '') {
            return true;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM vatlieu WHERE MaVatLieu = ?');
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function findMaterialByName(string $name): ?string
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $stmt = $this->db->prepare('SELECT MaVatLieu FROM vatlieu WHERE LOWER(TenVatLieu) = LOWER(?) LIMIT 1');
        $stmt->execute([$name]);
        $materialId = $stmt->fetchColumn();
        return $materialId ? (string)$materialId : null;
    }

    public function createMaterial(string $name): ?string
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $existingId = $this->findMaterialByName($name);
        if ($existingId) {
            return $existingId;
        }

        $materialId = $this->generateNewId('vatlieu', 'MaVatLieu', 'M');
        $stmt = $this->db->prepare('INSERT INTO vatlieu (MaVatLieu, TenVatLieu, MoTa) VALUES (?, ?, NULL)');
        return $stmt->execute([$materialId, $name]) ? $materialId : null;
    }

    public function resolveMaterialId(string $name): ?string
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        return $this->findMaterialByName($name) ?: $this->createMaterial($name);
    }

    public function isFashionCategory(string $categoryId): bool
    {
        if ($categoryId === '') {
            return false;
        }

        $stmt = $this->db->prepare('SELECT TenDanhMuc FROM danhmuc WHERE MaDanhMuc = ? LIMIT 1');
        $stmt->execute([$categoryId]);
        $name = strtolower((string)$stmt->fetchColumn());
        return str_contains($name, 'fashion');
    }

    public function getVariantSuggestionsByCategory(string $categoryId): array
    {
        $name = '';
        if ($categoryId !== '') {
            $stmt = $this->db->prepare('SELECT TenDanhMuc FROM danhmuc WHERE MaDanhMuc = ? LIMIT 1');
            $stmt->execute([$categoryId]);
            $name = strtolower((string)$stmt->fetchColumn());
        }

        if (str_contains($name, 'fashion')) {
            return ['Size', 'Màu sắc'];
        }

        if (str_contains($name, 'care')) {
            return ['Dung tích', 'Mùi hương', 'Loại/kiểu'];
        }

        if (str_contains($name, 'kitchen')) {
            return ['Dung tích', 'Kích thước', 'Màu sắc'];
        }

        if (str_contains($name, 'decor')) {
            return ['Kích thước', 'Màu sắc', 'Mùi hương', 'Họa tiết'];
        }

        return ['Kích thước', 'Màu sắc', 'Loại/kiểu'];
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

    public function upsertPrimaryVariant(string $productId, float $price, string $size = '', string $type = '', ?int $stock = null): bool
    {
        $stmt = $this->db->prepare('SELECT MaBienThe FROM bienthesanpham WHERE MaSanPham = ? ORDER BY MaBienThe ASC LIMIT 1');
        $stmt->execute([$productId]);
        $variantId = $stmt->fetchColumn();

        if ($variantId) {
            $stockSql = $stock !== null ? ', SoLuongTon = ?' : '';
            $update = $this->db->prepare("
                UPDATE bienthesanpham
                SET GiaTien = ?, KichThuoc = CASE WHEN ? != '' THEN ? ELSE KichThuoc END,
                    MauSac = CASE WHEN ? != '' THEN ? ELSE MauSac END
                    {$stockSql}
                WHERE MaBienThe = ?
            ");
            $params = [$price, $size, $size, $type, $type];
            if ($stock !== null) {
                $params[] = max(0, $stock);
            }
            $params[] = $variantId;
            return $update->execute($params);
        }

        $variantId = $this->generateNewId('bienthesanpham', 'MaBienThe', 'V');
        $insert = $this->db->prepare('
            INSERT INTO bienthesanpham (MaBienThe, MaSanPham, KichThuoc, MauSac, GiaTien, SoLuongTon)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        return $insert->execute([$variantId, $productId, $size ?: null, $type ?: null, $price, max(0, (int)($stock ?? 0))]);
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

    public function setCategoryStatus(string $id, int $status): bool
    {
        if (!$this->hasColumn('danhmuc', 'TrangThai')) {
            return true;
        }

        $stmt = $this->db->prepare('UPDATE danhmuc SET TrangThai = ? WHERE MaDanhMuc = ?');
        return $stmt->execute([$status === 1 ? 1 : 0, $id]);
    }

    public function categoryHasProducts(string $id): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM sanpham WHERE MaDanhMuc = ?');
        $stmt->execute([$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function productCanBeVisible(string $productId): bool
    {
        $statusSql = $this->hasColumn('bienthesanpham', 'TrangThai') ? ' AND TrangThai = 1' : '';
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM bienthesanpham WHERE MaSanPham = ? AND GiaTien > 0 AND SoLuongTon > 0' . $statusSql);
        $stmt->execute([$productId]);
        if ((int)$stmt->fetchColumn() === 0) {
            return false;
        }

        return $this->countProductImages($productId, 'cover') > 0;
    }

    public function addProductImage(string $productId, string $imageFileName, string $type = 'detail'): bool
    {
        $imageId = $this->generateImageId();
        $type = $type === 'cover' ? 'cover' : 'detail';

        if ($this->productImageRoleColumnsExist()) {
            $stmt = $this->db->prepare('
                INSERT INTO hinhanhsanpham (MaHinhAnh, MaSanPham, DuongDan, LoaiAnh, ThuTu)
                VALUES (:MaHinhAnh, :MaSanPham, :DuongDan, :LoaiAnh, :ThuTu)
            ');
            return $stmt->execute([
                ':MaHinhAnh' => $imageId,
                ':MaSanPham' => $productId,
                ':DuongDan' => $imageFileName,
                ':LoaiAnh' => $type,
                ':ThuTu' => $type === 'cover' ? 0 : $this->countProductImages($productId, 'detail') + 1
            ]);
        }

        $stmt = $this->db->prepare('INSERT INTO hinhanhsanpham (MaHinhAnh, MaSanPham, DuongDan) VALUES (:MaHinhAnh, :MaSanPham, :DuongDan)');
        return $stmt->execute([
            ':MaHinhAnh' => $imageId,
            ':MaSanPham' => $productId,
            ':DuongDan' => $imageFileName
        ]);
    }

    public function countProductImages(string $productId, ?string $type = null): int
    {
        if ($productId === '') {
            return 0;
        }

        if ($this->productImageRoleColumnsExist() && in_array($type, ['cover', 'detail'], true)) {
            $stmt = $this->db->prepare("
                SELECT
                    COUNT(*) AS total_count,
                    SUM(CASE WHEN LoaiAnh = 'cover' THEN 1 ELSE 0 END) AS cover_count,
                    SUM(CASE WHEN LoaiAnh = 'detail' THEN 1 ELSE 0 END) AS detail_count
                FROM hinhanhsanpham
                WHERE MaSanPham = ?
            ");
            $stmt->execute([$productId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
            $total = (int)($row['total_count'] ?? 0);
            $cover = (int)($row['cover_count'] ?? 0);
            $detail = (int)($row['detail_count'] ?? 0);

            if ($type === 'cover') {
                return $cover > 0 ? 1 : ($total > 0 ? 1 : 0);
            }

            return $cover > 0 ? $detail : max(0, $total - 1);
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM hinhanhsanpham WHERE MaSanPham = ?');
        $stmt->execute([$productId]);
        $total = (int)$stmt->fetchColumn();

        if ($type === 'cover') {
            return $total > 0 ? 1 : 0;
        }

        if ($type === 'detail') {
            return max(0, $total - 1);
        }

        return $total;
    }

    public function getProductImageSummary(string $productId): array
    {
        return [
            'cover_count' => $this->countProductImages($productId, 'cover'),
            'detail_count' => $this->countProductImages($productId, 'detail'),
            'detail_limit' => self::PRODUCT_DETAIL_IMAGE_LIMIT,
        ];
    }

    public function replaceProductCoverImage(string $productId, string $imageFileName): bool
    {
        if (!$this->productImageRoleColumnsExist()) {
            return $this->addProductImage($productId, $imageFileName);
        }

        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("SELECT MaHinhAnh, DuongDan FROM hinhanhsanpham WHERE MaSanPham = ? AND LoaiAnh = 'cover'");
            $stmt->execute([$productId]);
            $oldImages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $delete = $this->db->prepare("DELETE FROM hinhanhsanpham WHERE MaSanPham = ? AND LoaiAnh = 'cover'");
            $delete->execute([$productId]);

            if (!$this->addProductImage($productId, $imageFileName, 'cover')) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();

            foreach ($oldImages as $oldImage) {
                $this->deleteProductImageFile((string)($oldImage['DuongDan'] ?? ''));
            }

            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
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

    public function getInventory(string $keyword = '', string $stockStatus = ''): array
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

        if ($stockStatus === 'in_stock') {
            $sql .= " AND bt.SoLuongTon > 5";
        } elseif ($stockStatus === 'low_stock') {
            $sql .= " AND bt.SoLuongTon BETWEEN 1 AND 5";
        } elseif ($stockStatus === 'out_of_stock') {
            $sql .= " AND bt.SoLuongTon = 0";
        }

        $sql .= " ORDER BY sp.TenSanPham ASC, bt.MaBienThe ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStock(string $maBienThe, int $soLuong): bool
    {
        if ($soLuong < 0) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE bienthesanpham SET SoLuongTon = ? WHERE MaBienThe = ?");
        return $stmt->execute([$soLuong, $maBienThe]);
    }

    public function variantExists(string $maBienThe, ?string $excludeSku = null): bool
    {
        if ($maBienThe === '') {
            return false;
        }

        $sql = 'SELECT COUNT(*) FROM bienthesanpham WHERE MaBienThe = ?';
        $params = [$maBienThe];
        if ($excludeSku !== null && $excludeSku !== '') {
            $sql .= ' AND MaBienThe <> ?';
            $params[] = $excludeSku;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function generateVariantCode(): string
    {
        return $this->generateNewId('bienthesanpham', 'MaBienThe', 'BT');
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

    public function getImportReceipts(string $status = ''): array
    {
        if (!$this->tableExists('phieunhap')) {
            return [];
        }

        $where = '';
        $params = [];
        $statusColumn = '';

        if ($this->hasColumn('phieunhap', 'TrangThai')) {
            $statusColumn = 'pn.TrangThai';
        } elseif ($this->hasColumn('phieunhap', 'status')) {
            $statusColumn = 'pn.status';
        }

        if ($status !== '') {
            if ($statusColumn !== '') {
                $where = "WHERE {$statusColumn} = :status";
                $params[':status'] = $status;
            } elseif ($status !== 'verified') {
                return [];
            }
        }

        $statusSelect = $statusColumn !== '' ? "{$statusColumn} AS receipt_status" : "'verified' AS receipt_status";
        $sql = "
            SELECT pn.*, ncc.TenNCC, {$statusSelect}
            FROM phieunhap pn
            LEFT JOIN nhacungcap ncc ON pn.MaNCC = ncc.MaNCC
            {$where}
            ORDER BY pn.NgayNhap DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
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

    public function addImportReceipt(string $maBienThe, int $quantity, string $note = '', ?string $supplierId = null): bool
    {
        if (!$this->tableExists('phieunhap') || !$this->tableExists('chitietphieunhap') || $quantity <= 0 || !$this->variantExists($maBienThe)) {
            return false;
        }

        $priceStmt = $this->db->prepare('SELECT GiaTien FROM bienthesanpham WHERE MaBienThe = ? LIMIT 1');
        $priceStmt->execute([$maBienThe]);
        $price = (float)$priceStmt->fetchColumn();
        $receiptId = $this->generateNewId('phieunhap', 'MaPhieuNhap', 'R');
        $supplierId = $supplierId ?: null;

        try {
            $this->db->beginTransaction();

            $receipt = $this->db->prepare('INSERT INTO phieunhap (MaPhieuNhap, MaNCC, TongTienNhap) VALUES (?, ?, ?)');
            $receipt->execute([$receiptId, $supplierId, $price * $quantity]);

            $detail = $this->db->prepare('INSERT INTO chitietphieunhap (MaPhieuNhap, MaBienThe, SoLuongNhap, GiaNhap) VALUES (?, ?, ?, ?)');
            $detail->execute([$receiptId, $maBienThe, $quantity, $price]);

            $stock = $this->db->prepare('UPDATE bienthesanpham SET SoLuongTon = SoLuongTon + ? WHERE MaBienThe = ?');
            $stock->execute([$quantity, $maBienThe]);

            return $this->db->commit();
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function getVariantsByProduct(string $maSanPham, bool $activeOnly = false): array
    {
        $statusSql = $activeOnly && $this->hasColumn('bienthesanpham', 'TrangThai')
            ? ' AND bt.TrangThai = 1'
            : '';

        $stmt = $this->db->prepare("
            SELECT bt.*, sp.TenSanPham
            FROM bienthesanpham bt
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE bt.MaSanPham = ?
            {$statusSql}
            ORDER BY bt.MaBienThe ASC
        ");
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVariant(string $maSanPham, string $mauSac, string $kichThuoc, float $giaTien, int $soLuong): bool
    {
        $maBienThe = $this->generateVariantCode();

        $stmt = $this->db->prepare("
            INSERT INTO bienthesanpham (MaBienThe, MaSanPham, MauSac, KichThuoc, GiaTien, SoLuongTon)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$maBienThe, $maSanPham, $mauSac, $kichThuoc, $giaTien, $soLuong]);
    }

    public function saveProductVariants(string $productId, array $variants): bool
    {
        $usedSkus = [];
        foreach ($variants as $variant) {
            $sku = trim((string)($variant['sku'] ?? ''));
            if ($sku === '') {
                $sku = $this->generateUniqueVariantCode($usedSkus);
            }
            $usedSkus[] = $sku;

            $attributesJson = $variant['attributes_json'] ?? null;
            if (is_array($attributesJson)) {
                $attributesJson = json_encode($attributesJson, JSON_UNESCAPED_UNICODE);
            }

            $fields = ['MaBienThe', 'MaSanPham', 'KichThuoc', 'MauSac', 'GiaTien', 'SoLuongTon'];
            $placeholders = ['?', '?', '?', '?', '?', '?'];
            $values = [
                $sku,
                $productId,
                $variant['kich_thuoc'] ?: null,
                $variant['mau_sac'] ?: null,
                (float)$variant['price'],
                max(0, (int)$variant['stock']),
            ];

            if ($this->hasColumn('bienthesanpham', 'TenBienThe')) {
                $fields[] = 'TenBienThe';
                $placeholders[] = '?';
                $values[] = $variant['name'] ?: null;
            }

            if ($this->hasColumn('bienthesanpham', 'ThuocTinhJson')) {
                $fields[] = 'ThuocTinhJson';
                $placeholders[] = '?';
                $values[] = $attributesJson ?: null;
            }

            if ($this->hasColumn('bienthesanpham', 'TrangThai')) {
                $fields[] = 'TrangThai';
                $placeholders[] = '?';
                $values[] = isset($variant['status']) ? (int)$variant['status'] : 1;
            }

            $stmt = $this->db->prepare(sprintf(
                'INSERT INTO bienthesanpham (%s) VALUES (%s)',
                implode(', ', $fields),
                implode(', ', $placeholders)
            ));

            if (!$stmt->execute($values)) {
                return false;
            }
        }

        return true;
    }

    public function replaceProductVariants(string $productId, array $variants): bool
    {
        $existing = $this->getVariantsByProduct($productId);
        $submittedSkus = array_values(array_filter(array_map(
            fn($variant) => trim((string)($variant['sku'] ?? '')),
            $variants
        )));

        foreach ($existing as $oldVariant) {
            $oldSku = (string)($oldVariant['MaBienThe'] ?? '');
            if ($oldSku === '' || in_array($oldSku, $submittedSkus, true)) {
                continue;
            }

            if ($this->hasColumn('bienthesanpham', 'TrangThai')) {
                $stmt = $this->db->prepare('UPDATE bienthesanpham SET TrangThai = 0, SoLuongTon = 0 WHERE MaBienThe = ?');
                if (!$stmt->execute([$oldSku])) {
                    return false;
                }
                continue;
            }

            if ($this->variantHasOrders($oldSku)) {
                if (!$this->updateStock($oldSku, 0)) {
                    return false;
                }
            } elseif (!$this->deleteVariant($oldSku)) {
                return false;
            }
        }

        $usedSkus = [];
        foreach ($variants as $variant) {
            $sku = trim((string)($variant['sku'] ?? ''));
            if ($sku === '') {
                $sku = $this->generateUniqueVariantCode($usedSkus);
            }
            $usedSkus[] = $sku;

            $attributesJson = $variant['attributes_json'] ?? null;
            if (is_array($attributesJson)) {
                $attributesJson = json_encode($attributesJson, JSON_UNESCAPED_UNICODE);
            }

            if ($this->variantExists($sku)) {
                $set = ['KichThuoc = ?', 'MauSac = ?', 'GiaTien = ?', 'SoLuongTon = ?'];
                $values = [
                    $variant['kich_thuoc'] ?: null,
                    $variant['mau_sac'] ?: null,
                    (float)$variant['price'],
                    max(0, (int)$variant['stock']),
                ];

                if ($this->hasColumn('bienthesanpham', 'TenBienThe')) {
                    $set[] = 'TenBienThe = ?';
                    $values[] = $variant['name'] ?: null;
                }
                if ($this->hasColumn('bienthesanpham', 'ThuocTinhJson')) {
                    $set[] = 'ThuocTinhJson = ?';
                    $values[] = $attributesJson ?: null;
                }
                if ($this->hasColumn('bienthesanpham', 'TrangThai')) {
                    $set[] = 'TrangThai = ?';
                    $values[] = isset($variant['status']) ? (int)$variant['status'] : 1;
                }

                $values[] = $sku;
                $values[] = $productId;
                $stmt = $this->db->prepare('UPDATE bienthesanpham SET ' . implode(', ', $set) . ' WHERE MaBienThe = ? AND MaSanPham = ?');
                if (!$stmt->execute($values)) {
                    return false;
                }
            } else {
                $variant['sku'] = $sku;
                if (!$this->saveProductVariants($productId, [$variant])) {
                    return false;
                }
            }
        }

        return true;
    }

    private function generateUniqueVariantCode(array $usedSkus = []): string
    {
        do {
            $sku = $this->generateVariantCode();
            if (!$this->variantExists($sku) && !in_array($sku, $usedSkus, true)) {
                return $sku;
            }

            $max = (int)preg_replace('/\D+/', '', $sku);
            do {
                $max++;
                $sku = 'BT' . str_pad($max, 3, '0', STR_PAD_LEFT);
            } while ($this->variantExists($sku) || in_array($sku, $usedSkus, true));

            return $sku;
        } while (true);
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

    public function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->db->commit();
    }

    public function rollBack(): bool
    {
        return $this->db->inTransaction() ? $this->db->rollBack() : true;
    }

    public function getGallery(string $maSanPham): array
    {
        $roleSelect = $this->productImageRoleColumnsExist()
            ? "CASE
                    WHEN h.LoaiAnh = 'cover'
                        OR (
                            NOT EXISTS (
                                SELECT 1 FROM hinhanhsanpham hc
                                WHERE hc.MaSanPham = h.MaSanPham AND hc.LoaiAnh = 'cover'
                            )
                            AND h.MaHinhAnh = (
                                SELECT MIN(h2.MaHinhAnh)
                                FROM hinhanhsanpham h2
                                WHERE h2.MaSanPham = h.MaSanPham
                            )
                        )
                    THEN 'cover'
                    ELSE 'detail'
                END AS LoaiAnh,
                COALESCE(h.ThuTu, 1) AS ThuTu"
            : "CASE WHEN h.MaHinhAnh = (
                    SELECT MIN(h2.MaHinhAnh)
                    FROM hinhanhsanpham h2
                    WHERE h2.MaSanPham = h.MaSanPham
                ) THEN 'cover' ELSE 'detail' END AS LoaiAnh,
                1 AS ThuTu";
        $roleOrder = $this->productImageRoleColumnsExist()
            ? "FIELD(LoaiAnh, 'cover', 'detail'), COALESCE(h.ThuTu, 99), h.MaHinhAnh ASC"
            : "h.MaHinhAnh ASC";

        $stmt = $this->db->prepare("
            SELECT h.MaHinhAnh, h.MaSanPham, h.DuongDan, {$roleSelect}, sp.TenSanPham
            FROM hinhanhsanpham h
            LEFT JOIN sanpham sp ON h.MaSanPham = sp.MaSanPham
            WHERE h.MaSanPham = ?
            ORDER BY {$roleOrder}
        ");
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function uploadGalleryImage(string $maSanPham, array $file, string $type = 'detail'): bool
    {
        $type = $type === 'cover' ? 'cover' : 'detail';
        if ($type === 'detail' && $this->countProductImages($maSanPham, 'detail') >= self::PRODUCT_DETAIL_IMAGE_LIMIT) {
            return false;
        }

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

        $saved = $type === 'cover'
            ? $this->replaceProductCoverImage($maSanPham, $filename)
            : $this->addProductImage($maSanPham, $filename, 'detail');

        if (!$saved) {
            @unlink($dest);
        }

        return $saved;
    }

    public function deleteGalleryImage(string $maAnh): bool
    {
        $stmt = $this->db->prepare("SELECT DuongDan FROM hinhanhsanpham WHERE MaHinhAnh = ?");
        $stmt->execute([$maAnh]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->deleteProductImageFile((string)$row['DuongDan']);
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
                   COALESCE(bv.TrangThai, 1) AS TrangThai,
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
            SELECT MaBaiViet, TieuDe, NoiDung, HinhAnhBia, NgayDang, MaNguoiDung,
                   COALESCE(TrangThai, 1) AS TrangThai
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
            INSERT INTO baiviet (MaBaiViet, TieuDe, NoiDung, HinhAnhBia, NgayDang, MaNguoiDung, TrangThai)
            VALUES (?, ?, ?, ?, NOW(), ?, ?)
        ");
        return $stmt->execute([$postId, $data['TieuDe'], $data['NoiDung'], $data['HinhAnhBia'], $data['MaNguoiDung'], $data['TrangThai'] ?? 1]);
    }

    public function updatePost($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE baiviet
            SET TieuDe = ?, NoiDung = ?, HinhAnhBia = ?, TrangThai = ?
            WHERE MaBaiViet = ?
        ");
        return $stmt->execute([$data['TieuDe'], $data['NoiDung'], $data['HinhAnhBia'], $data['TrangThai'] ?? 1, $id]);
    }

    public function deletePost($id)
    {
        $stmt = $this->db->prepare("DELETE FROM baiviet WHERE MaBaiViet = ?");
        return $stmt->execute([$id]);
    }

    public function getAllPromos()
    {
        $stmt = $this->db->prepare("
            SELECT MaCode AS MaGiamGia, MaCode, PhamTramGiam, SoLuong, NgayHetHan,
                   COALESCE(TrangThai, 1) AS TrangThai,
                   COALESCE(min_order_value, 0) AS min_order_value,
                   COALESCE(max_discount_value, 0) AS max_discount_value
            FROM magiamgia
            ORDER BY NgayHetHan DESC, MaCode DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupportQuestions(string $keyword = '', string $tab = 'all'): array
    {
        if (!$this->tableExists('hotrokhachhang')) {
            return [];
        }

        $where = [];
        $params = [];

        if ($tab === 'pending') {
            $where[] = 'ht.TrangThai = 0';
        } elseif ($tab === 'answered') {
            $where[] = 'ht.TrangThai = 1';
        }

        if ($keyword !== '') {
            $where[] = "(
                ht.MaHoTro LIKE :keyword
                OR ht.TieuDe LIKE :keyword
                OR ht.CauHoi LIKE :keyword
                OR ht.CauTraLoi LIKE :keyword
                OR nd.HoTen LIKE :keyword
                OR nd.Email LIKE :keyword
            )";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $stmt = $this->db->prepare("
            SELECT
                ht.MaHoTro, ht.MaNguoiDung, ht.TieuDe, ht.CauHoi, ht.CauTraLoi,
                ht.TrangThai, ht.NgayGui, ht.NgayTraLoi, ht.MaAdmin,
                nd.HoTen, nd.Email, nd.SoDienThoai,
                admin.HoTen AS TenAdmin
            FROM hotrokhachhang ht
            LEFT JOIN nguoidung nd ON nd.MaNguoiDung = ht.MaNguoiDung
            LEFT JOIN nguoidung admin ON admin.MaNguoiDung = ht.MaAdmin
            {$whereSql}
            ORDER BY ht.TrangThai ASC, ht.NgayGui DESC, ht.MaHoTro DESC
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupportStats(): array
    {
        $stats = ['total' => 0, 'pending' => 0, 'answered' => 0];

        if (!$this->tableExists('hotrokhachhang')) {
            return $stats;
        }

        $stmt = $this->db->query("
            SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN TrangThai = 0 THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN TrangThai = 1 THEN 1 ELSE 0 END) AS answered
            FROM hotrokhachhang
        ");
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'total' => (int)($row['total'] ?? 0),
            'pending' => (int)($row['pending'] ?? 0),
            'answered' => (int)($row['answered'] ?? 0),
        ];
    }

    public function replySupportQuestion(string $supportId, string $reply, string $adminId): bool
    {
        if (!$this->tableExists('hotrokhachhang')) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE hotrokhachhang
            SET CauTraLoi = ?, TrangThai = 1, NgayTraLoi = NOW(), MaAdmin = ?
            WHERE MaHoTro = ?
        ");

        return $stmt->execute([$reply, $adminId, $supportId]);
    }

    public function getPromoById($id)
    {
        $stmt = $this->db->prepare("
            SELECT MaCode AS MaGiamGia, MaCode, PhamTramGiam, SoLuong, NgayHetHan,
                   COALESCE(TrangThai, 1) AS TrangThai,
                   COALESCE(min_order_value, 0) AS min_order_value,
                   COALESCE(max_discount_value, 0) AS max_discount_value
            FROM magiamgia
            WHERE MaCode = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPromo($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO magiamgia (MaCode, PhamTramGiam, SoLuong, NgayHetHan, min_order_value, max_discount_value, TrangThai)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['MaCode'],
            $data['PhamTramGiam'],
            $data['SoLuong'],
            $data['NgayHetHan'],
            $data['min_order_value'] ?? 0,
            $data['max_discount_value'] ?? 0,
            $data['TrangThai'] ?? 1,
        ]);
    }

    public function updatePromo($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE magiamgia
            SET MaCode = ?, PhamTramGiam = ?, SoLuong = ?, NgayHetHan = ?,
                min_order_value = ?, max_discount_value = ?, TrangThai = ?
            WHERE MaCode = ?
        ");
        return $stmt->execute([
            $data['MaCode'],
            $data['PhamTramGiam'],
            $data['SoLuong'],
            $data['NgayHetHan'],
            $data['min_order_value'] ?? 0,
            $data['max_discount_value'] ?? 0,
            $data['TrangThai'] ?? 1,
            $id,
        ]);
    }

    public function deletePromo($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM magiamgia WHERE MaCode = ?");
            return [
                'success' => $stmt->execute([$id]),
                'soft_deleted' => false,
            ];
        } catch (PDOException $e) {
            if ($e->getCode() !== '23000') {
                return [
                    'success' => false,
                    'soft_deleted' => false,
                ];
            }

            $stmt = $this->db->prepare("UPDATE magiamgia SET TrangThai = 0 WHERE MaCode = ?");
            return [
                'success' => $stmt->execute([$id]),
                'soft_deleted' => true,
            ];
        }
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

    private function productImageRoleColumnsExist(): bool
    {
        return $this->hasColumn('hinhanhsanpham', 'LoaiAnh')
            && $this->hasColumn('hinhanhsanpham', 'ThuTu');
    }

    private function deleteProductImageFile(string $path): void
    {
        $fileName = basename($path);
        if ($fileName === '') {
            return;
        }

        $fullPath = ROOT_PATH . '/public/assets/images/products/' . $fileName;
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    private function formatImageUrl(string $path): string
    {
        return product_image_url($path);
    }
}
