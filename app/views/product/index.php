<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
$pagination = $pagination ?? [
    'currentPage' => 1,
    'totalPages' => 1,
    'perPage' => 9,
    'totalProducts' => count($products ?? []),
    'from' => count($products ?? []) > 0 ? 1 : 0,
    'to' => count($products ?? []),
];

$currentPage = (int)($pagination['currentPage'] ?? 1);
$totalPages = (int)($pagination['totalPages'] ?? 1);
$totalProducts = (int)($pagination['totalProducts'] ?? count($products ?? []));
$from = (int)($pagination['from'] ?? 0);
$to = (int)($pagination['to'] ?? count($products ?? []));

function product_page_url(int $page, array $filters): string
{
    $params = [
        'url' => 'product',
        'keyword' => $filters['keyword'] ?? '',
        'category' => $filters['category'] ?? '',
        'impact' => $filters['impact'] ?? '',
        'price_max' => $filters['price_max'] ?? '',
        'sort' => $filters['sort'] ?? '',
        'page' => $page,
    ];

    $params = array_filter($params, function ($value) {
        return $value !== '' && $value !== null;
    });

    return '?' . http_build_query($params);
}
?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            <!-- FILTER SIDEBAR -->
            <aside class="lg:col-span-1">
                <form method="GET" action="">
                    <input type="hidden" name="url" value="product">

                    <div class="bg-[#FAFAF2] rounded-2xl p-4 sticky top-28">
                        <h2 class="text-2xl font-bold text-[#2F512A] mb-6">
                            Tìm kiếm
                        </h2>

                        <div class="relative mb-8">
                            <input type="text"
                                   name="keyword"
                                   value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>"
                                   placeholder="Tên sản phẩm..."
                                   class="w-full rounded-xl border border-[#D8DDCB] bg-white px-10 py-3">

                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#8B8F7A]">
                                search
                            </span>
                        </div>

                        <hr class="my-8 border-[#E0E3D5]">

                        <h2 class="text-2xl font-bold text-[#2F512A] mb-6">
                            Danh mục
                        </h2>

                        <label class="flex items-center gap-3 mb-4 cursor-pointer">
                            <input type="radio"
                                   name="category"
                                   value=""
                                   <?= empty($filters['category']) ? 'checked' : '' ?>>
                            <span>Tất cả</span>
                        </label>

                        <?php foreach (($categories ?? []) as $categoryId => $categoryName): ?>
                            <label class="flex items-center gap-3 mb-4 cursor-pointer">
                                <input type="radio"
                                       name="category"
                                       value="<?= htmlspecialchars($categoryId) ?>"
                                       <?= (($filters['category'] ?? '') === $categoryId) ? 'checked' : '' ?>>
                                <span><?= htmlspecialchars($categoryName) ?></span>
                            </label>
                        <?php endforeach; ?>

                        <hr class="my-8 border-[#E0E3D5]">

                           <div class="mb-8">
    <div class="flex items-center justify-between mb-3">
        <span class="font-semibold text-[#2F512A]">
            Giá tối đa
        </span>

        <span id="priceDisplay" class="text-sm text-gray-600">
            <?= !empty($filters['price_max'])
                ? number_format((int)$filters['price_max'], 0, ',', '.') . '₫'
                : 'Không giới hạn'
            ?>
        </span>
    </div>

    <input type="range"
           id="priceRange"
           name="price_max"
           min="0"
           max="5000000"
           step="50000"
           value="<?= !empty($filters['price_max']) ? (int)$filters['price_max'] : 5000000 ?>"
           class="w-full accent-[#2F512A] cursor-pointer">
</div>

                        <hr class="my-8 border-[#E0E3D5]">

                        <h2 class="text-2xl font-bold text-[#2F512A] mb-6">
                            Tác động môi trường
                        </h2>

<label class="flex items-center gap-3 mb-4 cursor-pointer">
    <input type="radio"
           name="impact"
           value=""
           <?= empty($filters['impact']) ? 'checked' : '' ?>>
    <span>Tất cả tác động</span>
</label>

<?php foreach (($impacts ?? []) as $impactId => $impactName): ?>
    <label class="flex items-center gap-3 mb-4 cursor-pointer">
        <input type="radio"
               name="impact"
               value="<?= htmlspecialchars($impactId) ?>"
               <?= (($filters['impact'] ?? '') === $impactId) ? 'checked' : '' ?>>
        <span><?= htmlspecialchars($impactName) ?></span>
    </label>
<?php endforeach; ?>

                        <button type="submit"
                                class="w-full rounded-xl bg-[#2F512A] text-white font-bold py-3 hover:bg-[#244020] transition">
                            Lọc sản phẩm
                        </button>
                    </div>
                </form>
            </aside>

            <!-- PRODUCT LIST -->
            <section class="lg:col-span-3">
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-4">
                        Cửa hàng
                    </h1>

                    <p class="text-gray-700 max-w-3xl leading-7">
                        Khám phá các sản phẩm xanh được tuyển chọn kỹ lưỡng vì tính bền vững và vẻ đẹp vượt thời gian.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <p class="font-semibold text-[#6B4C2F]">
                        <?php if ($totalProducts > 0): ?>
                            Hiển thị <?= $from ?> - <?= $to ?> trong <?= $totalProducts ?> sản phẩm
                        <?php else: ?>
                            Tìm thấy 0 sản phẩm
                        <?php endif; ?>
                    </p>

                    <form method="GET" action="" class="flex items-center gap-3">
                        <input type="hidden" name="url" value="product">
                        <input type="hidden" name="keyword" value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                        <input type="hidden" name="category" value="<?= htmlspecialchars($filters['category'] ?? '') ?>">
                        <input type="hidden" name="impact" value="<?= htmlspecialchars($filters['impact'] ?? '') ?>">
                        <input type="hidden" name="price_max" value="<?= htmlspecialchars($filters['price_max'] ?? '') ?>">
                        <input type="hidden" name="page" value="1">

                        <label class="font-semibold">Sắp xếp:</label>

                        <select name="sort"
                                onchange="this.form.submit()"
                                class="rounded-xl border border-[#D8DDCB] bg-white px-4 py-3">
                            <option value="" <?= empty($filters['sort']) ? 'selected' : '' ?>>
                                Hàng mới về
                            </option>

                            <option value="price_asc" <?= (($filters['sort'] ?? '') === 'price_asc') ? 'selected' : '' ?>>
                                Giá tăng dần
                            </option>

                            <option value="price_desc" <?= (($filters['sort'] ?? '') === 'price_desc') ? 'selected' : '' ?>>
                                Giá giảm dần
                            </option>

                            <option value="impact_desc" <?= (($filters['sort'] ?? '') === 'impact_desc') ? 'selected' : '' ?>>
                                Điểm xanh cao
                            </option>
                        </select>
                    </form>
                </div>

                <?php if (empty($products)): ?>
                   <div class="bg-white rounded-2xl border border-[#E5E7D8] p-12 text-center">
    <h3 class="text-2xl font-bold text-[#2F512A] mb-3">
        Không tìm thấy sản phẩm
    </h3>

    <p class="text-gray-600 mb-6">
        Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm.
    </p>

    <a href="?url=product"
       class="inline-block bg-[#2F512A] text-white px-6 py-3 rounded-xl hover:bg-[#244020] transition">
        Xem tất cả sản phẩm
    </a>
</div>
                    <div class="mt-20">
    <h2 class="text-2xl font-bold text-[#2F512A] mb-6">
        Gợi ý tìm kiếm liên quan
    </h2>

    <div class="flex flex-wrap gap-4">

        <?php
        $suggestions = [
            'Sản phẩm xanh',
            'Đồ tái chế',
            'Không nhựa',
            'Eco living',
            'Thời trang bền vững',
            'Chăm sóc da thiên nhiên',
            'Nhà bếp bền vững'
        ];
        ?>

        <?php foreach ($suggestions as $item): ?>
            <a href="?url=product&keyword=<?= urlencode($item) ?>"
               class="px-5 py-3 rounded-full border border-[#D8DDCB]
                      hover:bg-[#2F512A]
                      hover:text-white
                      transition">

                <?= htmlspecialchars($item) ?>
            </a>
        <?php endforeach; ?>

    </div>
</div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        <?php foreach ($products as $product): ?>
                            <?php
                            $maSanPham = $product['MaSanPham'] ?? $product['id'] ?? '';
                            $maBienThe = $product['MaBienTheMacDinh'] ?? '';
                            $image = $product['image'] ?? '';
                            $name = $product['TenSanPham'] ?? $product['name'] ?? 'Sản phẩm';
                            $category = $product['TenDanhMuc'] ?? '';
                            $price = (float)($product['GiaTien'] ?? $product['price'] ?? 0);
                            $isFlashSale = !empty($product['is_flash_sale']);
                            $salePrice = (float)($product['sale_price'] ?? 0);
                            $flashSale = $product['flash_sale'] ?? [];
                            $ecoTag = $product['eco_tag'] ?? 'ĐIỂM XANH CAO';
                            $stock = (int)($product['TongTon'] ?? 0);
                            ?>

                            <article class="group">
                                <div class="relative rounded-2xl overflow-hidden bg-[#EEF1E7] border border-[#E5E7D8] h-[300px]">
                                    <a href="?url=product/detail&id=<?= urlencode($maSanPham) ?>">
                                        <?php if (!empty($image)): ?>
                                            <img src="<?= htmlspecialchars(product_image_url($image)) ?>"
                                                 alt="<?= htmlspecialchars($name) ?>"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                No image
                                            </div>
                                        <?php endif; ?>
                                    </a>

                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 pointer-events-none"></div>

                                    <?php if (!empty($product['is_bestseller'])): ?>
                                        <span class="absolute top-5 left-5 rounded-full bg-[#FFD9A8] px-4 py-2 text-xs font-bold tracking-wider z-10">
                                            BÁN CHẠY
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($isFlashSale): ?>
                                        <span class="absolute top-5 right-5 rounded-full bg-red-600 text-white px-4 py-2 text-xs font-black tracking-wider z-10">
                                            FLASH SALE
                                        </span>
                                    <?php endif; ?>

                                    <form method="POST" action="?url=cart/add">
                                        <input type="hidden"
                                               name="MaSanPham"
                                               value="<?= htmlspecialchars($maSanPham) ?>">

                                        <input type="hidden"
                                               name="MaBienThe"
                                               value="<?= htmlspecialchars($maBienThe) ?>">

                                        <input type="hidden"
                                               name="SoLuong"
                                               value="1">

                                        <button type="submit"
                                                title="Thêm vào giỏ"
                                                <?= (empty($maSanPham) || empty($maBienThe) || $stock <= 0) ? 'disabled' : '' ?>
                                                class="absolute bottom-4 right-4 z-10 w-14 h-14 rounded-full bg-[#2F512A] text-white flex items-center justify-center shadow-lg
                                                opacity-0 translate-y-3 pointer-events-none
                                                group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto
                                                hover:bg-[#244020] transition-all duration-300
                                                disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span class="material-symbols-outlined">shopping_cart</span>
                                        </button>
                                    </form>
                                </div>

                                <div class="pt-5">
                                    <p class="text-xs tracking-widest uppercase font-bold text-[#8B5E34] mb-2">
                                        <?= htmlspecialchars($category) ?>
                                    </p>

                                    <a href="?url=product/detail&id=<?= urlencode($maSanPham) ?>">
                                        <h3 class="text-xl font-black text-black leading-snug mb-3 hover:text-[#2F512A] transition">
                                            <?= htmlspecialchars($name) ?>
                                        </h3>
                                    </a>

                                    <div class="flex items-center justify-between gap-4 mb-4">
                                        <?php if ($isFlashSale && $salePrice > 0): ?>
                                            <div>
                                                <p class="text-sm text-gray-400 line-through"><?= number_format($price, 0, ',', '.') ?>₫</p>
                                                <p class="text-xl font-black text-red-600"><?= number_format($salePrice, 0, ',', '.') ?>₫</p>
                                            </div>
                                        <?php else: ?>
                                        <p class="text-xl font-bold text-[#8B5E34]">
                                            <?= number_format($price, 0, ',', '.') ?>₫
                                        </p>

                                        <?php endif; ?>

                                        <p class="text-sm text-gray-500">
                                            Còn: <?= $stock ?>
                                        </p>
                                    </div>

                                    <p class="text-xs font-bold text-[#2F512A] flex items-center gap-2">
                                        <span>●</span>
                                        <?= htmlspecialchars($ecoTag) ?>
                                    </p>

                                    <?php if ($isFlashSale): ?>
                                        <p class="mt-3 text-xs font-bold text-red-600">
                                            Còn <?= (int)($flashSale['remaining'] ?? 0) ?> suất ·
                                            sale
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($totalPages > 1): ?>
                        <div class="mt-12 flex flex-wrap items-center justify-center gap-3">
                            <?php if ($currentPage > 1): ?>
                                <a href="<?= htmlspecialchars(product_page_url($currentPage - 1, $filters)) ?>"
                                   class="min-w-11 h-11 px-4 rounded-xl border border-[#D8DDCB] bg-white text-[#2F512A] font-bold flex items-center justify-center hover:bg-[#EEF1E7] transition">
                                    Trước
                                </a>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                <a href="<?= htmlspecialchars(product_page_url($page, $filters)) ?>"
                                   class="min-w-11 h-11 px-4 rounded-xl border font-bold flex items-center justify-center transition
                                   <?= $page === $currentPage
                                       ? 'bg-[#2F512A] text-white border-[#2F512A]'
                                       : 'bg-white text-[#2F512A] border-[#D8DDCB] hover:bg-[#EEF1E7]' ?>">
                                    <?= $page ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="<?= htmlspecialchars(product_page_url($currentPage + 1, $filters)) ?>"
                                   class="min-w-11 h-11 px-4 rounded-xl border border-[#D8DDCB] bg-white text-[#2F512A] font-bold flex items-center justify-center hover:bg-[#EEF1E7] transition">
                                    Sau
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </section>
</main>
<script>
const priceRange = document.getElementById('priceRange');
const priceDisplay = document.getElementById('priceDisplay');

if (priceRange && priceDisplay) {
    function updatePrice() {
        const value = parseInt(priceRange.value);

        if (value >= 5000000) {
            priceDisplay.innerText = 'Không giới hạn';
        } else {
            priceDisplay.innerText =
                value.toLocaleString('vi-VN') + '₫';
        }
    }

    updatePrice();

    priceRange.addEventListener('input', updatePrice);
}
</script>
<script src="<?= BASE_URL ?>public/assets/js/flash-sale.js"></script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
