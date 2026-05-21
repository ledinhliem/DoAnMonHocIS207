<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
$keyword = $keyword ?? ($_GET['keyword'] ?? '');
$category = $category ?? ($_GET['category'] ?? '');
$brand = $brand ?? ($_GET['brand'] ?? '');

$categories = $categories ?? [];
$brands = $brands ?? [];

$productList = [];
if (isset($products) && is_array($products)) {
    $productList = $products;
} elseif (isset($data['products']) && is_array($data['products'])) {
    $productList = $data['products'];
}

$pagination = $pagination ?? [
    'currentPage' => 1,
    'totalPages' => 1,
    'perPage' => 10,
    'totalItems' => count($productList)
];

$currentPageNumber = (int)($pagination['currentPage'] ?? 1);
$totalPages = (int)($pagination['totalPages'] ?? 1);
$totalProducts = (int)($pagination['totalItems'] ?? count($productList));

if (!function_exists('adminProductPageUrl')) {
    function adminProductPageUrl($page)
    {
        $params = $_GET;
        $params['url'] = 'admin/products';
        $params['page'] = $page;

        return BASE_URL . 'index.php?' . http_build_query($params);
    }
}

if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('productValue')) {
    function productValue($product, $keys, $default = '')
    {
        foreach ((array) $keys as $key) {
            if (isset($product[$key]) && $product[$key] !== '') {
                return $product[$key];
            }
        }

        return $default;
    }
}
?>

<!-- Main Content -->
<main class="ml-64 p-8 lg:p-12">
    <!-- Header Section -->
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 mb-10">
        <div>
            <h2 class="text-5xl font-black text-primary tracking-tighter mb-2">Sản phẩm</h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">
                Quản lý danh mục, kiểm tra tồn kho và chuẩn bị thao tác sản phẩm từ một nơi.
            </p>
        </div>

        <a href="<?= BASE_URL ?>index.php?url=admin/products/create"
            class="flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-container transition-colors shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">add</span>
            Thêm sản phẩm mới
        </a>
    </header>

    <!-- Tìm kiếm & Bộ lọc Controls -->
    <section class="bg-surface-container-low rounded-xl p-6 mb-8 shadow-sm">
        <form method="GET" action="<?= BASE_URL ?>index.php" class="flex flex-col lg:flex-row gap-6 items-center">
            <input type="hidden" name="url" value="admin/products">

            <div class="relative w-full lg:flex-1">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">
                    search
                </span>

                <input
                    class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-outline/60"
                    placeholder="Tìm theo tên, SKU hoặc từ khóa..."
                    type="text"
                    name="keyword"
                    value="<?= e($keyword) ?>"
                />
            </div>

            <div class="flex flex-wrap gap-4 w-full lg:w-auto">
                <div class="relative min-w-[180px]">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">
                        CATEGORY
                    </label>

                    <select
                        name="category"
                        class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer"
                    >
                        <option value="">Tất cả danh mục</option>

                        <?php foreach ($categories as $categoryItem): ?>
                            <option
                                value="<?= e($categoryItem['MaDanhMuc'] ?? '') ?>"
                                <?= $category === ($categoryItem['MaDanhMuc'] ?? '') ? 'selected' : '' ?>
                            >
                                <?= e($categoryItem['TenDanhMuc'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">
                        expand_more
                    </span>
                </div>

                <div class="relative min-w-[180px]">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">
                        BRAND
                    </label>

                    <select
                        name="brand"
                        class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer"
                    >
                        <option value="">Tất cả thương hiệu</option>

                        <?php foreach ($brands as $brandItem): ?>
                            <option
                                value="<?= e($brandItem['MaThuongHieu'] ?? '') ?>"
                                <?= $brand === ($brandItem['MaThuongHieu'] ?? '') ? 'selected' : '' ?>
                            >
                                <?= e($brandItem['TenThuongHieu'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">
                        expand_more
                    </span>
                </div>

                <button
                    type="submit"
                    class="bg-primary text-on-primary px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-primary-container transition-colors"
                >
                    <span class="material-symbols-outlined">filter_alt</span>
                    Áp dụng
                </button>

                <a
                    href="<?= BASE_URL ?>index.php?url=admin/products"
                    class="bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-surface-variant transition-colors"
                >
                    <span class="material-symbols-outlined">restart_alt</span>
                    Reset
                </a>
            </div>
        </form>
    </section>

    <!-- Tóm tắt -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Tổng số sản phẩm</p>
            <p class="text-3xl font-black text-primary"><?= $totalProducts ?></p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Từ khóa tìm kiếm</p>
            <p class="text-lg font-bold text-on-surface">
                <?= $keyword !== '' ? e($keyword) : '—' ?>
            </p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Bộ lọc hiện tại</p>
            <p class="text-lg font-bold text-on-surface">
                <?= ($category !== '' || $brand !== '') ? e(trim(($category ?: 'Tất cả danh mục') . ' / ' . ($brand ?: 'Tất cả thương hiệu'))) : 'Không có' ?>
            </p>
        </div>
    </section>

    <!-- Bảng sản phẩm -->
    <section class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1080px]">
                <thead class="bg-surface-container-low text-left">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Hình ảnh</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Sản phẩm</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Thương hiệu</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Danh mục</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Giá</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Tồn kho</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">SKU</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline text-right">
                            Thao tác
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($productList)): ?>
                        <?php foreach ($productList as $product): ?>
                            <?php
                            $id = productValue($product, ['id'], null);
                            $name = productValue($product, ['name', 'product_name', 'title'], 'Unnamed product');
                            $brandName = productValue($product, ['brand', 'brand_name'], '—');
                            $categoryName = productValue($product, ['category', 'category_name'], '—');
                            $price = productValue($product, ['price'], 0);
                            $stock = productValue($product, ['stock', 'quantity'], '—');
                            $sku = productValue($product, ['sku'], '—');
                            $image = productValue($product, ['image', 'image_url', 'thumbnail'], '');
                            ?>

                            <tr class="border-t border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-4">
                                    <?php if ($image !== ''): ?>
                                        <img
                                            src="<?= e($image) ?>"
                                            alt="<?= e($name) ?>"
                                            class="w-14 h-14 rounded-lg object-cover border border-outline-variant/20"
                                        >
                                    <?php else: ?>
                                        <div class="w-14 h-14 rounded-lg bg-surface-container-high flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined">image</span>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-bold text-on-surface"><?= e($name) ?></p>

                                    <?php if ($id !== null): ?>
                                        <p class="text-xs text-on-surface-variant mt-1">
                                            ID: <?= e($id) ?>
                                        </p>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-on-surface"><?= e($brandName) ?></td>
                                <td class="px-6 py-4 text-on-surface"><?= e($categoryName) ?></td>

                                <td class="px-6 py-4 text-on-surface font-bold">
                                    <?= is_numeric($price) ? number_format((float) $price, 0, ',', '.') . ' đ' : e($price) ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?php if (is_numeric($stock)): ?>
                                        <?php
                                        $stockNum = (int) $stock;
                                        $stockClass = $stockNum <= 10 ? 'text-red-600 bg-red-50' : 'text-green-700 bg-green-50';
                                        ?>

                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $stockClass ?>">
                                            <?= $stockNum <= 10 ? 'Low stock: ' . $stockNum : 'In stock: ' . $stockNum ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-on-surface"><?= e($stock) ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-on-surface"><?= e($sku) ?></td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2 flex-wrap">
                                        <?php if ($id !== null): ?>
                                            <a
                                                href="<?= BASE_URL ?>index.php?url=admin/products/variants&id=<?= urlencode((string) $id) ?>"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">tune</span>
                                                Biến thể
                                            </a>

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=admin/products/gallery&id=<?= urlencode((string) $id) ?>"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">photo_library</span>
                                                Ảnh
                                            </a>

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=admin/products/edit&id=<?= urlencode((string) $id) ?>"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                Sửa
                                            </a>

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=admin/products/delete&id=<?= urlencode((string) $id) ?>"
                                                onclick="return confirm('Ẩn sản phẩm này?')"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                Xóa
                                            </a>
                                        <?php else: ?>
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-high text-on-surface text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                Sửa
                                            </button>

                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 text-red-700 text-sm font-medium transition-colors"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                Xóa
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="border-t border-outline-variant/10">
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-outline">
                                        <span class="material-symbols-outlined text-3xl">inventory_2</span>
                                    </div>

                                    <h3 class="text-xl font-bold text-on-surface mb-2">Không tìm thấy sản phẩm</h3>

                                    <p class="text-on-surface-variant mb-6">
                                        Chưa có dữ liệu sản phẩm để hiển thị hoặc bộ lọc hiện tại không có kết quả.
                                    </p>

                                    <a
                                        href="<?= BASE_URL ?>index.php?url=admin/products/create"
                                        class="inline-flex items-center gap-2 bg-primary text-on-primary px-5 py-3 rounded-lg font-bold hover:bg-primary-container transition-colors"
                                    >
                                        <span class="material-symbols-outlined">add</span>
                                        Thêm sản phẩm mới
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php if ($totalPages > 1): ?>
        <div class="mt-10 flex flex-col items-center gap-3">
            <p class="text-sm text-on-surface-variant">
                Trang <?= $currentPageNumber ?> / <?= $totalPages ?>
            </p>

            <nav class="inline-flex items-center gap-1 bg-surface-container rounded-full px-2 py-2">
                <?php if ($currentPageNumber > 1): ?>
                    <a
                        href="<?= e(adminProductPageUrl($currentPageNumber - 1)) ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors"
                    >
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                <?php else: ?>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full text-outline opacity-40">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </span>
                <?php endif; ?>

                <?php
                $startPage = max(1, $currentPageNumber - 2);
                $endPage = min($totalPages, $currentPageNumber + 2);
                ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i === $currentPageNumber): ?>
                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-on-primary font-bold text-sm">
                            <?= $i ?>
                        </span>
                    <?php else: ?>
                        <a
                            href="<?= e(adminProductPageUrl($i)) ?>"
                            class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant"
                        >
                            <?= $i ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPageNumber < $totalPages): ?>
                    <a
                        href="<?= e(adminProductPageUrl($currentPageNumber + 1)) ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors"
                    >
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php else: ?>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full text-outline opacity-40">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </span>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</main>

<!-- Footer -->
<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>