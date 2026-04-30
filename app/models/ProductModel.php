<?php
// models/ProductModel.php
require_once __DIR__ . '/../../core/Database.php';

class ProductModel
{
    // ─── PRODUCT LIST (with filters) ────────────────────────────────────────
    public function getAll(array $filters = []): array
    {
        $where  = ['sp.TrangThai = 1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $where[]          = '(sp.TenSanPham LIKE :kw OR sp.MoTa LIKE :kw2)';
            $params[':kw']    = '%' . $filters['keyword'] . '%';
            $params[':kw2']   = '%' . $filters['keyword'] . '%';
        }
        if (!empty($filters['category'])) {
            $where[]            = 'sp.MaDanhMuc = :cat';
            $params[':cat']     = $filters['category'];
        }
        if (!empty($filters['impact'])) {
            // impact maps to TacDongMoiTruong keyword search
            $where[]            = 'sp.TacDongMoiTruong LIKE :imp';
            $params[':imp']     = '%' . $filters['impact'] . '%';
        }
        if (isset($filters['price_max']) && $filters['price_max'] !== '') {
            $where[]            = '(SELECT MIN(bt.GiaTien) FROM bienthesanpham bt WHERE bt.MaSanPham = sp.MaSanPham) <= :pmax';
            $params[':pmax']    = (float)$filters['price_max'];
        }

        $orderBy = match ($filters['sort'] ?? '') {
            'price_asc'    => 'min_price ASC',
            'price_desc'   => 'min_price DESC',
            'impact_desc'  => 'sp.DiemXanh DESC',
            default        => 'sp.MaSanPham ASC',
        };

        $sql = "
            SELECT
                sp.MaSanPham        AS id,
                sp.TenSanPham       AS name,
                sp.MaDanhMuc        AS category,
                sp.DiemXanh         AS eco_score,
                sp.TacDongMoiTruong AS eco_tag,
                dm.TenDanhMuc       AS category_name,
                th.TenThuongHieu    AS brand,
                (SELECT MIN(bt.GiaTien) FROM bienthesanpham bt WHERE bt.MaSanPham = sp.MaSanPham) AS min_price,
                (SELECT MAX(bt.GiaTien) FROM bienthesanpham bt WHERE bt.MaSanPham = sp.MaSanPham) AS max_price,
                (SELECT ha.DuongDan  FROM hinhanhsanpham ha  WHERE ha.MaSanPham = sp.MaSanPham LIMIT 1) AS image
            FROM sanpham sp
            LEFT JOIN danhmuc   dm ON dm.MaDanhMuc    = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            WHERE " . implode(' AND ', $where) . "
            ORDER BY $orderBy
        ";

        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // ─── SINGLE PRODUCT DETAIL ───────────────────────────────────────────────
    public function getById(string $id): ?array
    {
        $sql = "
            SELECT
                sp.*,
                dm.TenDanhMuc,
                th.TenThuongHieu,
                vl.TenVatLieu,
                vl.MoTa AS MoTaVatLieu
            FROM sanpham sp
            LEFT JOIN danhmuc    dm ON dm.MaDanhMuc    = sp.MaDanhMuc
            LEFT JOIN thuonghieu th ON th.MaThuongHieu = sp.MaThuongHieu
            LEFT JOIN vatlieu    vl ON vl.MaVatLieu    = sp.MaVatLieu
            WHERE sp.MaSanPham = :id AND sp.TrangThai = 1
            LIMIT 1
        ";
        $stmt = db()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    // ─── IMAGES ─────────────────────────────────────────────────────────────
    public function getImages(string $productId): array
    {
        $stmt = db()->prepare(
            "SELECT MaHinhAnh, DuongDan FROM hinhanhsanpham WHERE MaSanPham = :id ORDER BY MaHinhAnh"
        );
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll();
    }

    // ─── VARIANTS ────────────────────────────────────────────────────────────
    public function getVariants(string $productId): array
    {
        $stmt = db()->prepare(
            "SELECT MaBienThe, MaSanPham, KichThuoc, MauSac, GiaTien, SoLuongTon
             FROM bienthesanpham
             WHERE MaSanPham = :id
             ORDER BY MaBienThe"
        );
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll();
    }

    // ─── REVIEWS ────────────────────────────────────────────────────────────
    public function getReviews(string $productId): array
    {
        $stmt = db()->prepare(
            "SELECT dg.MaDanhGia, dg.SoSao, dg.NoiDung, dg.NgayDanhGia,
                    nd.HoTen
             FROM danhgia dg
             LEFT JOIN nguoidung nd ON nd.MaNguoiDung = dg.MaNguoiDung
             WHERE dg.MaSanPham = :id AND dg.TrangThai = 1
             ORDER BY dg.NgayDanhGia DESC"
        );
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll();
    }

    // ─── CATEGORIES / IMPACTS (for filter sidebar) ──────────────────────────
    public function getCategories(): array
    {
        $stmt = db()->query("SELECT MaDanhMuc, TenDanhMuc FROM danhmuc ORDER BY MaDanhMuc");
        $rows = $stmt->fetchAll();
        $out  = [];
        foreach ($rows as $r) {
            $out[$r['MaDanhMuc']] = $r['TenDanhMuc'];
        }
        return $out;
    }

    public function getImpacts(): array
    {
        // Static mapping matching TacDongMoiTruong keywords
        return [
            'thuần chay'    => 'Thuần chay / Vegan',
            'phân hủy'      => 'Tự phân hủy sinh học',
            'tái chế'       => 'Vật liệu tái chế',
            'không nhựa'    => 'Không nhựa',
        ];
    }

    // ─── SEARCH ─────────────────────────────────────────────────────────────
    public function search(string $keyword): array
    {
        return $this->getAll(['keyword' => $keyword]);
    }

    // ─── STOCK CHECK & DECREMENT ─────────────────────────────────────────────
    public function checkStock(string $variantId, int $qty): bool
    {
        $stmt = db()->prepare(
            "SELECT SoLuongTon FROM bienthesanpham WHERE MaBienThe = :vid LIMIT 1"
        );
        $stmt->execute([':vid' => $variantId]);
        $row = $stmt->fetch();
        return $row && (int)$row['SoLuongTon'] >= $qty;
    }

    public function decrementStock(string $variantId, int $qty): void
    {
        $pdo  = db();
        $stmt = $pdo->prepare(
            "UPDATE bienthesanpham
             SET SoLuongTon = SoLuongTon - :qty
             WHERE MaBienThe = :vid AND SoLuongTon >= :qty2"
        );
        $stmt->execute([':qty' => $qty, ':vid' => $variantId, ':qty2' => $qty]);
    }

    // ─── VARIANT BY ID ───────────────────────────────────────────────────────
    public function getVariantById(string $variantId): ?array
    {
        $stmt = db()->prepare(
            "SELECT bt.*, sp.TenSanPham,
                    (SELECT ha.DuongDan FROM hinhanhsanpham ha WHERE ha.MaSanPham = bt.MaSanPham LIMIT 1) AS image
             FROM bienthesanpham bt
             LEFT JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
             WHERE bt.MaBienThe = :vid LIMIT 1"
        );
        $stmt->execute([':vid' => $variantId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}