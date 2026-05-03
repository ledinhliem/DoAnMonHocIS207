<?php

class ProductModel extends Model
{
    public function getAll($filters = [])
    {
        $sql = "
            SELECT
                sp.MaSanPham,
                sp.TenSanPham,
                sp.MaDanhMuc,
                sp.MoTa,
                sp.DiemXanh,
                sp.TacDongMoiTruong,
                sp.CoTaiChe,
                sp.ThanThienMoiTruong,
                dm.TenDanhMuc,
                MIN(bt.GiaTien) AS GiaTien,
                SUM(bt.SoLuongTon) AS TongTon,
                (
                    SELECT bt2.MaBienThe
                    FROM bienthesanpham bt2
                    WHERE bt2.MaSanPham = sp.MaSanPham
                    ORDER BY bt2.MaBienThe ASC
                    LIMIT 1
                ) AS MaBienTheMacDinh,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSanPham = sp.MaSanPham
                    LIMIT 1
                ) AS HinhAnh
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN bienthesanpham bt ON bt.MaSanPham = sp.MaSanPham
            WHERE sp.TrangThai = 1
        ";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (sp.TenSanPham LIKE ? OR sp.MoTa LIKE ?)";
            $keyword = '%' . trim($filters['keyword']) . '%';
            $params[] = $keyword;
            $params[] = $keyword;
        }

        if (!empty($filters['category'])) {
            $sql .= " AND sp.MaDanhMuc = ?";
            $params[] = $filters['category'];
        }

        if (!empty($filters['impact'])) {
            if ($filters['impact'] === 'recycle') {
                $sql .= " AND sp.CoTaiChe = 1";
            } elseif ($filters['impact'] === 'eco') {
                $sql .= " AND sp.ThanThienMoiTruong = 1";
            } elseif ($filters['impact'] === 'high-score') {
                $sql .= " AND sp.DiemXanh >= 90";
            }
        }

        $sql .= "
            GROUP BY
                sp.MaSanPham,
                sp.TenSanPham,
                sp.MaDanhMuc,
                sp.MoTa,
                sp.DiemXanh,
                sp.TacDongMoiTruong,
                sp.CoTaiChe,
                sp.ThanThienMoiTruong,
                dm.TenDanhMuc
        ";

        if (isset($filters['price_max']) && $filters['price_max'] !== '') {
            $sql .= " HAVING GiaTien <= ?";
            $params[] = (float)$filters['price_max'];
        }

        if (($filters['sort'] ?? '') === 'price_asc') {
            $sql .= " ORDER BY GiaTien ASC";
        } elseif (($filters['sort'] ?? '') === 'price_desc') {
            $sql .= " ORDER BY GiaTien DESC";
        } elseif (($filters['sort'] ?? '') === 'impact_desc') {
            $sql .= " ORDER BY sp.DiemXanh DESC";
        } else {
            $sql .= " ORDER BY sp.MaSanPham ASC";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($rows as $row) {
            $products[] = [
                'id' => $row['MaSanPham'],
                'name' => $row['TenSanPham'],
                'price' => (float)$row['GiaTien'],
                'category' => $row['MaDanhMuc'],
                'impact' => $row['TacDongMoiTruong'] ?? '',
                'rating' => ((int)$row['DiemXanh']) / 20,
                'image' => $this->imageUrl($row['HinhAnh'] ?? ''),
                'description' => $row['MoTa'] ?? '',
                'eco_tag' => $this->getEcoTag($row),
                'is_bestseller' => ((int)$row['DiemXanh'] >= 95),

                'MaSanPham' => $row['MaSanPham'],
                'TenSanPham' => $row['TenSanPham'],
                'MaDanhMuc' => $row['MaDanhMuc'],
                'TenDanhMuc' => $row['TenDanhMuc'] ?? '',
                'GiaTien' => (float)$row['GiaTien'],
                'DiemXanh' => (int)$row['DiemXanh'],
                'MaBienTheMacDinh' => $row['MaBienTheMacDinh'] ?? '',
                'TongTon' => (int)($row['TongTon'] ?? 0),
            ];
        }

        return $products;
    }

    public function getById($id)
    {
        return $this->getProductById($id);
    }

    public function getProductById($id)
    {
        $sql = "
            SELECT 
                sp.*,
                dm.TenDanhMuc,
                th.TenThuongHieu,
                vl.TenVatLieu
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
            WHERE sp.MaSanPham = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVariantsByProductId($id)
    {
        $sql = "
            SELECT *
            FROM bienthesanpham
            WHERE MaSanPham = ?
            ORDER BY MaBienThe ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesByProductId($id)
    {
        $sql = "
            SELECT
                MaHinhAnh,
                MaSanPham,
                DuongDan
            FROM hinhanhsanpham
            WHERE MaSanPham = ?
            ORDER BY MaHinhAnh ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewsByProductId($id)
    {
        $sql = "
            SELECT 
                dg.*,
                nd.HoTen
            FROM danhgia dg
            LEFT JOIN nguoidung nd ON nd.MaNguoiDung = dg.MaNguoiDung
            WHERE dg.MaSanPham = ?
            AND dg.TrangThai = 1
            ORDER BY dg.NgayDanhGia DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories()
    {
        $stmt = $this->db->query("
            SELECT MaDanhMuc, TenDanhMuc
            FROM danhmuc
            ORDER BY MaDanhMuc ASC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];

        foreach ($rows as $row) {
            $categories[$row['MaDanhMuc']] = $row['TenDanhMuc'];
        }

        return $categories;
    }

    public function getImpacts()
    {
        return [
            'high-score' => 'Điểm xanh cao',
            'recycle' => 'Có thể tái chế',
            'eco' => 'Thân thiện môi trường',
        ];
    }

    private function imageUrl($fileName)
    {
        if (empty($fileName)) {
            return BASE_URL . 'public/images/products/default.jpg';
        }

        if (preg_match('/^https?:\/\//', $fileName)) {
            return $fileName;
        }

        $fileName = basename($fileName);

        return BASE_URL . 'public/images/products/' . $fileName;
    }

    private function getEcoTag($row)
    {
        if ((int)($row['DiemXanh'] ?? 0) >= 95) {
            return 'ĐIỂM XANH CAO';
        }

        if (!empty($row['CoTaiChe'])) {
            return 'CÓ THỂ TÁI CHẾ';
        }

        return 'THÂN THIỆN MÔI TRƯỜNG';
    }
}