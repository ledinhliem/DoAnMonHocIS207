<?php
require_once __DIR__ . '/FlashSaleModel.php';

class ProductModel extends Model
{
    private ?FlashSaleModel $flashSaleModel = null;

    public function __construct()
    {
        parent::__construct();
        $this->flashSaleModel = new FlashSaleModel();
    }

    public function getAll(array $filters = []): array
    {
        [$where, $params] = $this->buildProductFilters($filters);

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

        $this->attachFlashSales($products);

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

        if ($product) {
            $singleProduct = [$product];
            $this->attachFlashSales($singleProduct);
            $product = $singleProduct[0];
        }

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

        $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($variants as &$variant) {
            $sale = $this->flashSaleModel?->getActiveSaleForVariant(
                (string)($variant['MaSanPham'] ?? ''),
                (string)($variant['MaBienThe'] ?? '')
            );

            if ($sale) {
                $variant['flash_sale'] = $sale;
                $variant['is_flash_sale'] = true;
                $variant['GiaGoc'] = (float)($variant['GiaTien'] ?? 0);
                $variant['GiaSale'] = (float)$sale['sale_price'];
            }
        }

        return $variants;
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

    public function resolveCategoryId(string $category): string
    {
        $category = trim($category);

        if ($category === '') {
            return '';
        }

        $categories = $this->getCategories();

        if (isset($categories[$category])) {
            return $category;
        }

        $normalizedInput = $this->normalizeKeyword(str_replace(['-', '_'], ' ', $category));

        foreach ($categories as $categoryId => $categoryName) {
            if ($this->normalizeKeyword($categoryName) === $normalizedInput) {
                return $categoryId;
            }
        }

        return '__invalid_category__';
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
        return $this->getAll(['keyword' => trim($keyword)]);
    }

    public function getSuggestions(string $keyword, int $limit = 8): array
    {
        // Lấy từ khóa từ keyword để tìm sản phẩm liên quan
        $keywords = array_filter(array_map('trim', explode(' ', strtolower($keyword))));

        if (empty($keywords)) {
            // Nếu không có từ khóa, trả về sản phẩm ngẫu nhiên
            $sql = "
                SELECT
                    sp.MaSanPham AS id,
                    sp.TenSanPham AS name,
                    dm.TenDanhMuc AS category_name,
                    v.min_price AS price,
                    v.default_variant AS MaBienTheMacDinh,
                    v.total_stock AS TongTon,
                    img.DuongDan AS image
                FROM sanpham sp
                LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
                LEFT JOIN (
                    SELECT
                        MaSanPham,
                        MIN(GiaTien) AS min_price,
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
                WHERE sp.TrangThai = 1
                ORDER BY RAND()
                LIMIT ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
        } else {
            // Tìm sản phẩm có các từ khóa tương tự trong tên, mô tả, hoặc danh mục
            $likeConditions = [];
            $params = [];
            foreach ($keywords as $kw) {
                $likeConditions[] = "(sp.TenSanPham LIKE ? OR sp.MoTa LIKE ?)";
                $params[] = "%$kw%";
                $params[] = "%$kw%";
            }

            $whereClause = implode(' OR ', $likeConditions);

            $sql = "
                SELECT
                    sp.MaSanPham AS id,
                    sp.TenSanPham AS name,
                    dm.TenDanhMuc AS category_name,
                    v.min_price AS price,
                    v.default_variant AS MaBienTheMacDinh,
                    v.total_stock AS TongTon,
                    img.DuongDan AS image
                FROM sanpham sp
                LEFT JOIN danhmuc dm ON dm.MaDanhMuc = sp.MaDanhMuc
                LEFT JOIN (
                    SELECT
                        MaSanPham,
                        MIN(GiaTien) AS min_price,
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
                WHERE sp.TrangThai = 1 AND ($whereClause)
                ORDER BY RAND()
                LIMIT ?
            ";
            $params[] = $limit;
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        }

        $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($suggestions as &$item) {
            $item['image'] = $this->formatImageUrl($item['image'] ?? '');
        }
        $this->attachFlashSales($suggestions);
        return $suggestions;
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

    private function attachFlashSales(array &$products): void
    {
        if (empty($products)) {
            return;
        }

        $productIds = array_map(
            fn($product) => $product['MaSanPham'] ?? $product['id'] ?? '',
            $products
        );
        $sales = $this->flashSaleModel?->getActiveSalesForProducts($productIds) ?? [];

        foreach ($products as &$product) {
            $productId = $product['MaSanPham'] ?? $product['id'] ?? '';
            if ($productId !== '' && isset($sales[$productId])) {
                $sale = $sales[$productId];
                $product['flash_sale'] = $sale;
                $product['is_flash_sale'] = true;
                $product['original_price'] = (float)($product['GiaTien'] ?? $product['price'] ?? 0);
                $product['sale_price'] = (float)$sale['sale_price'];
                $product['GiaSale'] = (float)$sale['sale_price'];
            }
        }
    }

    private function buildProductFilters(array $filters): array
    {
        $where = ['sp.TrangThai = 1'];
        $params = [];

        if (!empty($filters['keyword'])) {
            $this->addKeywordFilter($where, $params, $filters['keyword']);
        }

        if (!empty($filters['category'])) {
            $where[] = 'sp.MaDanhMuc = :categoryId';
            $params[':categoryId'] = $filters['category'];
        }

        if (!empty($filters['impact'])) {
            $where[] = 'sp.TacDongMoiTruong LIKE :impact';
            $params[':impact'] = '%' . trim($filters['impact']) . '%';
        }

        if (isset($filters['price_max']) && trim((string)$filters['price_max']) !== '') {
            $where[] = 'COALESCE(v.min_price, 0) <= :price_max';
            $params[':price_max'] = (float)$filters['price_max'];
        }

        return [$where, $params];
    }

    private function addKeywordFilter(array &$where, array &$params, string $keyword): void
    {
        $keyword = trim($keyword);

        if ($keyword === '') {
            return;
        }

        $searchTerms = $this->expandKeywordTerms($keyword);
        $conditions = [];

        foreach ($searchTerms as $index => $term) {
            $param = ':keyword_' . $index;
            $conditions[] = "(
                sp.TenSanPham LIKE {$param}
                OR sp.MoTa LIKE {$param}
                OR sp.NguonGoc LIKE {$param}
                OR sp.TacDongMoiTruong LIKE {$param}
                OR dm.TenDanhMuc LIKE {$param}
            )";
            $params[$param] = '%' . $term . '%';
        }

        $normalized = $this->normalizeKeyword($keyword);
        $semanticConditions = [
            'san pham xanh' => ['sp.ThanThienMoiTruong = 1', 'sp.DiemXanh >= 85'],
            'eco living' => ['sp.ThanThienMoiTruong = 1', 'sp.DiemXanh >= 85'],
            'do tai che' => ['sp.CoTaiChe = 1', "sp.TacDongMoiTruong LIKE '%tái chế%'", "sp.TacDongMoiTruong LIKE '%tái sử dụng%'"],
            'khong nhua' => ["sp.TacDongMoiTruong LIKE '%không%nhựa%'", "sp.TacDongMoiTruong LIKE '%giảm%nhựa%'", "sp.TacDongMoiTruong LIKE '%chai nhựa%'", 'sp.CoTaiChe = 1'],
            'thoi trang ben vung' => ["sp.MaDanhMuc = 'C003'", "dm.TenDanhMuc LIKE '%Fashion%'"],
            'cham soc da thien nhien' => ["sp.MaDanhMuc = 'C004'", "dm.TenDanhMuc LIKE '%Care%'", "sp.MoTa LIKE '%da%'", "sp.TacDongMoiTruong LIKE '%thuần chay%'"],
            'nha bep ben vung' => ["sp.MaDanhMuc = 'C001'", "dm.TenDanhMuc LIKE '%Kitchen%'"],
        ];

        if (isset($semanticConditions[$normalized])) {
            $conditions = array_merge($conditions, $semanticConditions[$normalized]);
        }

        $where[] = '(' . implode(' OR ', $conditions) . ')';
    }

    private function expandKeywordTerms(string $keyword): array
    {
        $aliases = [
            'Sản phẩm xanh' => ['xanh', 'thân thiện', 'DiemXanh', 'bền vững', 'môi trường'],
            'Đồ tái chế' => ['tái chế', 'tái sử dụng', 'refill', 'rác thải'],
            'Không nhựa' => ['không nhựa', 'giảm nhựa', 'chai nhựa', 'nhựa dùng một lần'],
            'Eco living' => ['eco', 'living', 'bền vững', 'thân thiện', 'môi trường'],
            'Thời trang bền vững' => ['thời trang', 'fashion', 'bamboo', 'tre', 'sợi', 'vải'],
            'Chăm sóc da thiên nhiên' => ['chăm sóc', 'da', 'care', 'thiên nhiên', 'thuần chay'],
            'Nhà bếp bền vững' => ['nhà bếp', 'kitchen', 'ống hút', 'dao', 'muỗng', 'nĩa', 'găng tay'],
        ];

        $terms = [$keyword];
        $normalized = $this->normalizeKeyword($keyword);

        foreach ($aliases as $label => $labelAliases) {
            if ($this->normalizeKeyword($label) === $normalized) {
                $terms = array_merge($terms, $labelAliases);
                break;
            }
        }

        return array_values(array_unique(array_filter(array_map('trim', $terms))));
    }

    private function normalizeKeyword(string $keyword): string
    {
        $keyword = mb_strtolower(trim($keyword), 'UTF-8');
        $from = ['á','à','ả','ã','ạ','ă','ắ','ằ','ẳ','ẵ','ặ','â','ấ','ầ','ẩ','ẫ','ậ','đ','é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ','í','ì','ỉ','ĩ','ị','ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ','ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự','ý','ỳ','ỷ','ỹ','ỵ'];
        $to = ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','d','e','e','e','e','e','e','e','e','e','e','e','i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y'];

        return preg_replace('/\s+/', ' ', str_replace($from, $to, $keyword));
    }
}
