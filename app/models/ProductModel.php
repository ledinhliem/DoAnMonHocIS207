<?php

class ProductModel extends Model
{
    public function getAll(array $filters = []): array
    {
        $where = ['sp.TrangThai = 1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $where[] = '(sp.TenSanPham LIKE :keyword OR sp.MoTa LIKE :keyword OR sp.NguonGoc LIKE :keyword)';
            $params[':keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category'])) {
            $where[] = 'sp.MaDanhMuc = :category';
            $params[':category'] = $filters['category'];
        }

        if (!empty($filters['impact'])) {
            $where[] = 'sp.TacDongMoiTruong LIKE :impact';
            $params[':impact'] = '%' . $filters['impact'] . '%';
        }

        if (isset($filters['price_max']) && $filters['price_max'] !== '') {
            $where[] = 'COALESCE(v.min_price, 0) <= :price_max';
            $params[':price_max'] = (float)$filters['price_max'];
        }

        $orderBy = match ($filters['sort'] ?? '') {
            'price_asc' => 'v.min_price ASC, sp.MaSanPham ASC',
            'price_desc' => 'v.min_price DESC, sp.MaSanPham ASC',
            'impact_desc' => 'sp.DiemXanh DESC, sp.MaSanPham ASC',
            default => 'sp.MaSanPham ASC',
        };

        $sql = "
            SELECT
                sp.MaSanPham AS id,
                sp.MaSanPham AS MaSanPham,
                sp.TenSanPham AS name,
                sp.TenSanPham AS TenSanPham,
                sp.MaDanhMuc AS category,
                dm.TenDanhMuc AS category_name,
                dm.TenDanhMuc AS TenDanhMuc,
                sp.DiemXanh AS eco_score,
                sp.TacDongMoiTruong AS eco_tag,
                sp.TacDongMoiTruong AS TacDongMoiTruong,
                COALESCE(v.min_price, 0) AS min_price,
                COALESCE(v.max_price, 0) AS max_price,
                COALESCE(v.min_price, 0) AS price,
                COALESCE(v.min_price, 0) AS GiaTien,
                COALESCE(v.total_stock, 0) AS TongTon,
                v.default_variant AS MaBienTheMacDinh,
                img.DuongDan AS image
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN (
                SELECT
                    MaSanPham,
                    MIN(GiaTien) AS min_price,
                    MAX(GiaTien) AS max_price,
                    SUM(SoLuongTon) AS total_stock,
                    MIN(MaBienThe) AS default_variant
                FROM bienthesanpham
                GROUP BY MaSanPham
            ) v ON v.MaSanPham = sp.MaSanPham
            LEFT JOIN (
                SELECT MaSanPham, MIN(DuongDan) AS DuongDan
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ) img ON img.MaSanPham = sp.MaSanPham
            WHERE " . implode(' AND ', $where) . "
            ORDER BY {$orderBy}
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['image'] = $this->formatImageUrl($product['image'] ?? '');
        }

        return $products;
    }

    public function getById(string $id): ?array
    {
        $id = $this->normalizeProductId($id);

        $stmt = $this->db->prepare("
            SELECT
                sp.*,
                dm.TenDanhMuc,
                th.TenThuongHieu,
                vl.TenVatLieu,
                vl.MoTa AS MoTaVatLieu
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            LEFT JOIN vatlieu vl ON vl.MaVatLieu = sp.MaVatLieu
            WHERE sp.MaSanPham = ? AND sp.TrangThai = 1
            LIMIT 1
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: null;
    }

    public function getImages(string $productId): array
    {
        $productId = $this->normalizeProductId($productId);

        $stmt = $this->db->prepare("
            SELECT MaHinhAnh, DuongDan
            FROM hinhanhsanpham
            WHERE MaSanPham = ?
            ORDER BY MaHinhAnh ASC
        ");
        $stmt->execute([$productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVariants(string $productId): array
    {
        $productId = $this->normalizeProductId($productId);

        $stmt = $this->db->prepare("
            SELECT MaBienThe, MaSanPham, KichThuoc, MauSac, GiaTien, SoLuongTon
            FROM bienthesanpham
            WHERE MaSanPham = ?
            ORDER BY MaBienThe ASC
        ");
        $stmt->execute([$productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviews(string $productId): array
    {
        $productId = $this->normalizeProductId($productId);

        $stmt = $this->db->prepare("
            SELECT dg.MaDanhGia, dg.SoSao, dg.NoiDung, dg.NgayDanhGia, nd.HoTen
            FROM danhgia dg
            LEFT JOIN nguoidung nd ON nd.MaNguoiDung = dg.MaNguoiDung
            WHERE dg.MaSanPham = ? AND dg.TrangThai = 1
            ORDER BY dg.NgayDanhGia DESC
        ");
        $stmt->execute([$productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories(): array
    {
        $stmt = $this->db->query("SELECT MaDanhMuc, TenDanhMuc FROM danhmuc ORDER BY MaDanhMuc ASC");
        $categories = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $categories[$row['MaDanhMuc']] = $row['TenDanhMuc'];
        }

        return $categories;
    }

    public function getImpacts(): array
    {
        return [
            'thuần chay' => 'Thuần chay',
            'phân hủy' => 'Tự phân hủy sinh học',
            'tái chế' => 'Tái chế',
            'không' => 'Không nhựa / không độc hại',
        ];
    }

    public function search(string $keyword): array
    {
        return $this->getAll(['keyword' => $keyword]);
    }

    public function checkStock(string $variantId, int $qty): bool
    {
        $stmt = $this->db->prepare("SELECT SoLuongTon FROM bienthesanpham WHERE MaBienThe = ? LIMIT 1");
        $stmt->execute([$variantId]);
        $stock = $stmt->fetchColumn();

        return $stock !== false && (int)$stock >= $qty;
    }

    public function decrementStock(string $variantId, int $qty): void
    {
        $stmt = $this->db->prepare("
            UPDATE bienthesanpham
            SET SoLuongTon = SoLuongTon - ?
            WHERE MaBienThe = ? AND SoLuongTon >= ?
        ");
        $stmt->execute([$qty, $variantId, $qty]);
    }

    public function getVariantById(string $variantId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                bt.*,
                sp.TenSanPham,
                img.DuongDan AS image
            FROM bienthesanpham bt
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            LEFT JOIN (
                SELECT MaSanPham, MIN(DuongDan) AS DuongDan
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ) img ON img.MaSanPham = bt.MaSanPham
            WHERE bt.MaBienThe = ?
            LIMIT 1
        ");
        $stmt->execute([$variantId]);
        $variant = $stmt->fetch(PDO::FETCH_ASSOC);

        return $variant ?: null;
    }

    private function normalizeProductId(string $id): string
    {
        $id = trim($id);

        if ($id !== '' && ctype_digit($id)) {
            return 'P' . str_pad($id, 3, '0', STR_PAD_LEFT);
        }

        return $id;
    }

    private function formatImageUrl(string $path): string
    {
        return product_image_url($path);
    }
}
