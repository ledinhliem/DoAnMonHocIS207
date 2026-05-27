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
        $imageAggregateSql = $this->productImageAggregateSql();

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
            LEFT JOIN ({$imageAggregateSql}) img ON img.MaSanPham = sp.MaSanPham
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
        $orderBy = $this->hasColumn('hinhanhsanpham', 'LoaiAnh')
            ? "FIELD(LoaiAnh, 'cover', 'detail'), COALESCE(ThuTu, 99), MaHinhAnh ASC"
            : "MaHinhAnh ASC";

        $stmt = $this->db->prepare("
            SELECT MaHinhAnh, DuongDan
            FROM hinhanhsanpham
            WHERE MaSanPham = ?
            ORDER BY {$orderBy}
        ");
        $stmt->execute([$productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVariants(string $productId): array
    {
        $productId = $this->normalizeProductId($productId);
        $extraColumns = [];
        foreach (['TenBienThe', 'ThuocTinhJson', 'TrangThai'] as $column) {
            if ($this->hasColumn('bienthesanpham', $column)) {
                $extraColumns[] = $column;
            }
        }
        $extraSelect = $extraColumns ? ', ' . implode(', ', $extraColumns) : '';
        $statusSql = in_array('TrangThai', $extraColumns, true) ? ' AND TrangThai = 1' : '';

        $stmt = $this->db->prepare("
            SELECT MaBienThe, MaSanPham, KichThuoc, MauSac, GiaTien, SoLuongTon{$extraSelect}
            FROM bienthesanpham
            WHERE MaSanPham = ?{$statusSql}
            ORDER BY MaBienThe ASC
        ");
        $stmt->execute([$productId]);

        $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $product = $this->getById($productId) ?? [];
        foreach ($variants as &$variant) {
            $variant['attributes'] = $this->normalizeVariantAttributes($variant, $product);
            $variant['TenBienThe'] = $variant['TenBienThe'] ?? $this->buildVariantName($variant['attributes']);

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

    public function groupVariantOptions(array $variants, array $product): array
    {
        $groups = [];
        foreach ($variants as $variant) {
            $attributes = $variant['attributes'] ?? $this->normalizeVariantAttributes($variant, $product);
            foreach ($attributes as $label => $value) {
                $label = trim((string)$label);
                $value = trim((string)$value);
                if ($label === '' || $value === '') {
                    continue;
                }

                if (!isset($groups[$label])) {
                    $groups[$label] = [];
                }
                $groups[$label][$value] = $value;
            }
        }

        $preferredOrder = ['Size', 'Màu sắc', 'Dung tích', 'Mùi hương', 'Khối lượng', 'Họa tiết', 'Chất liệu', 'Quy cách', 'Loại da', 'Loại/kiểu', 'Kích thước'];
        uksort($groups, function ($a, $b) use ($preferredOrder) {
            $posA = array_search($a, $preferredOrder, true);
            $posB = array_search($b, $preferredOrder, true);
            $posA = $posA === false ? 999 : $posA;
            $posB = $posB === false ? 999 : $posB;
            return $posA <=> $posB ?: strcmp((string)$a, (string)$b);
        });

        return array_map(fn($values) => array_values($values), $groups);
    }

    public function normalizeVariantAttributes(array $variant, array $product = []): array
    {
        $rawJson = $variant['ThuocTinhJson'] ?? $variant['attributes_json'] ?? '';
        if (is_string($rawJson) && trim($rawJson) !== '') {
            $decoded = json_decode($rawJson, true);
            if (is_array($decoded)) {
                return $this->cleanAttributes($decoded);
            }
        } elseif (is_array($rawJson)) {
            return $this->cleanAttributes($rawJson);
        }

        $categoryName = (string)($product['TenDanhMuc'] ?? $product['category_name'] ?? '');
        $productName = (string)($product['TenSanPham'] ?? $product['name'] ?? '');
        $attributes = [];

        foreach (['MauSac' => ($variant['MauSac'] ?? ''), 'KichThuoc' => ($variant['KichThuoc'] ?? '')] as $field => $value) {
            $value = trim((string)$value);
            if ($value === '') {
                continue;
            }
            $label = $this->inferAttributeLabel($value, $categoryName, $productName, $field);
            $cleanValue = $label === 'Họa tiết' ? preg_replace('/^họa\s*tiết\s*/iu', '', $value) : $value;
            $attributes[$label] = trim((string)$cleanValue);
        }

        return $attributes;
    }

    public function inferAttributeLabel(string $value, string $categoryName = '', string $productName = '', string $fieldName = ''): string
    {
        $value = trim($value);
        $haystack = mb_strtolower($categoryName . ' ' . $productName . ' ' . $value, 'UTF-8');
        $fieldName = trim($fieldName);

        if ($fieldName === 'MauSac') {
            if (preg_match('/họa\s*tiết/iu', $value) || preg_match('/chăn|gối|quạt/iu', $haystack)) {
                return 'Họa tiết';
            }
            if (preg_match('/lemon|lavender|ginger|sả|gừng|hoa|hương|mùi/iu', $value) || preg_match('/nến|care|xà phòng|dầu gội|sữa rửa mặt/iu', $haystack)) {
                return 'Mùi hương';
            }
            return 'Màu sắc';
        }

        if ($fieldName === 'KichThuoc') {
            if (preg_match('/fashion|áo|quần|giày|size/iu', $haystack)
                && preg_match('/^(size\s*)?(EU\s*)?(XS|S|M|L|XL|XXL|3XL|[3-4][0-9])$/iu', $value)
            ) {
                return 'Size';
            }
            if (preg_match('/\b\d+(\.\d+)?\s*(ml|l)\b/iu', $value)) {
                return 'Dung tích';
            }
            if (preg_match('/\b\d+(\.\d+)?\s*(g|kg|gram)\b/iu', $value)) {
                return 'Khối lượng';
            }
            if (preg_match('/họa\s*tiết/iu', $value)) {
                return 'Họa tiết';
            }
            if (preg_match('/bộ\s*\d+|\d+\s*cái|hộp|combo|set/iu', $value) || preg_match('/kitchen/iu', $haystack)) {
                return 'Quy cách';
            }
        }

        return 'Kích thước';
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
        $imageAggregateSql = $this->productImageAggregateSql();
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
                LEFT JOIN ({$imageAggregateSql}) img ON img.MaSanPham = sp.MaSanPham
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
                LEFT JOIN ({$imageAggregateSql}) img ON img.MaSanPham = sp.MaSanPham
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
        $imageAggregateSql = $this->productImageAggregateSql();
        $stmt = $this->db->prepare("
            SELECT
                bt.*,
                sp.TenSanPham,
                img.DuongDan AS image
            FROM bienthesanpham bt
            JOIN sanpham sp ON sp.MaSanPham = bt.MaSanPham
            LEFT JOIN ({$imageAggregateSql}) img ON img.MaSanPham = bt.MaSanPham
            WHERE bt.MaBienThe = ?
            LIMIT 1
        ");
        $stmt->execute([$variantId]);
        $variant = $stmt->fetch(PDO::FETCH_ASSOC);

        return $variant ?: null;
    }

    private function productImageAggregateSql(): string
    {
        if ($this->hasColumn('hinhanhsanpham', 'LoaiAnh')) {
            return "
                SELECT
                    MaSanPham,
                    COALESCE(MIN(CASE WHEN LoaiAnh = 'cover' THEN DuongDan END), MIN(DuongDan)) AS DuongDan
                FROM hinhanhsanpham
                GROUP BY MaSanPham
            ";
        }

        return "
            SELECT MaSanPham, MIN(DuongDan) AS DuongDan
            FROM hinhanhsanpham
            GROUP BY MaSanPham
        ";
    }

    private function hasColumn(string $table, string $column): bool
    {
        $stmt = $this->db->prepare('SHOW COLUMNS FROM ' . $table . ' LIKE ?');
        $stmt->execute([$column]);
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function normalizeProductId(string $id): string
    {
        $id = trim($id);

        if ($id !== '' && ctype_digit($id)) {
            return 'P' . str_pad($id, 3, '0', STR_PAD_LEFT);
        }

        return $id;
    }

    private function cleanAttributes(array $attributes): array
    {
        $clean = [];
        foreach ($attributes as $label => $value) {
            $label = trim((string)$label);
            $value = trim((string)$value);
            if ($label !== '' && $value !== '' && $value !== '0') {
                $clean[$label] = $value;
            }
        }
        return $clean;
    }

    private function buildVariantName(array $attributes): string
    {
        return implode(' / ', array_values($attributes));
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
