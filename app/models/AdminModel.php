<?php

class AdminModel extends Model
{
    public function getProductsList(array $filters = []): array
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
        $stmt = $this->db->prepare("SELECT
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
            WHERE sp.MaSanPham = ?");

        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product['image'] = $this->formatImageUrl($product['image'] ?? '');
        }

        return $product ?: null;
    }

    public function getCategoriesList(): array
    {
        $hasStatus = $this->hasColumn('danhmuc', 'TrangThai');

        $selectStatus = $hasStatus
            ? 'COALESCE(dm.TrangThai, 1) AS TrangThai,'
            : '1 AS TrangThai,';

        $where = $hasStatus ? 'WHERE dm.TrangThai = 1' : '';

        $sql = "SELECT
    dm.MaDanhMuc,
    dm.TenDanhMuc,
    dm.HinhAnh,
    1 AS TrangThai,
    (SELECT COUNT(*) FROM sanpham sp WHERE sp.MaDanhMuc = dm.MaDanhMuc) AS product_count
FROM danhmuc dm
ORDER BY dm.MaDanhMuc ASC";
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
        $sql = "INSERT INTO sanpham (MaSanPham, TenSanPham, MaDanhMuc, MaThuongHieu, MaVatLieu, MoTa, DiemXanh, NguonGoc, TacDongMoiTruong, CoTaiChe, ThanThienMoiTruong, TrangThai)
            VALUES (:MaSanPham, :TenSanPham, :MaDanhMuc, :MaThuongHieu, :MaVatLieu, :MoTa, :DiemXanh, :NguonGoc, :TacDongMoiTruong, :CoTaiChe, :ThanThienMoiTruong, :TrangThai)";

        $stmt = $this->db->prepare($sql);
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
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    public function updateProduct(string $id, array $data): bool
    {
        if (isset($data['TrangThai']) && $data['TrangThai'] == 1 && !$this->productCanBeVisible($id)) {
            $data['TrangThai'] = 0;
        }

        $sql = "UPDATE sanpham SET
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
            WHERE MaSanPham = :MaSanPham";

        $stmt = $this->db->prepare($sql);
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

    public function deleteProduct(string $id): bool
    {
        $stmt = $this->db->prepare('UPDATE sanpham SET TrangThai = 0 WHERE MaSanPham = ?');
        return $stmt->execute([$id]);
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

        $sql = sprintf('INSERT INTO danhmuc (%s) VALUES (%s)', implode(', ', $fields), implode(', ', $placeholders));
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function updateCategory(string $id, array $data): bool
    {
        $set = ['TenDanhMuc = :TenDanhMuc', 'HinhAnh = :HinhAnh'];
        $values = [':TenDanhMuc' => $data['TenDanhMuc'], ':HinhAnh' => $data['HinhAnh'] ?: null, ':MaDanhMuc' => $id];

        if ($this->hasColumn('danhmuc', 'TrangThai')) {
            $set[] = 'TrangThai = :TrangThai';
            $values[':TrangThai'] = $data['TrangThai'] ?? 1;
        }

        $sql = sprintf('UPDATE danhmuc SET %s WHERE MaDanhMuc = :MaDanhMuc', implode(', ', $set));
        $stmt = $this->db->prepare($sql);
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
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM sanpham WHERE MaDanhMuc = ? AND TrangThai = 1');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function productCanBeVisible(string $productId): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM bienthesanpham WHERE MaSanPham = ? AND GiaTien > 0 AND SoLuongTon > 0');
        $stmt->execute([$productId]);
        $variants = (int) $stmt->fetchColumn();
        if ($variants === 0) {
            return false;
        }

        $stmt = $this->db->prepare('SELECT COUNT(*) FROM hinhanhsanpham WHERE MaSanPham = ?');
        $stmt->execute([$productId]);
        return (int) $stmt->fetchColumn() > 0;
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

    private function generateNewId(string $table, string $column, string $prefix): string
    {
        $sql = "SELECT MAX(CAST(SUBSTRING($column, LENGTH(:prefix) + 1) AS UNSIGNED)) AS max_id FROM $table WHERE $column LIKE CONCAT(:prefix, '%')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':prefix' => $prefix]);
        $last = (int) $stmt->fetchColumn();
        return $prefix . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }

    private function hasColumn(string $table, string $column): bool
    {
        $stmt = $this->db->prepare('SHOW COLUMNS FROM ' . $table . ' LIKE ?');
        $stmt->execute([$column]);
        return (bool) $stmt->fetch();
    }

    private function formatImageUrl(string $path): string
    {
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return BASE_URL . 'public/images/Products/' . ltrim($path, '/');
    }
}
