<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('admin_product_image_src')) {
    function admin_product_image_src(string $path): string
    {
        if ($path === '') {
            return BASE_URL . 'public/images/placeholder.png';
        }

        if (function_exists('product_image_url')) {
            return product_image_url($path);
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (str_starts_with($path, 'public/')) {
            return BASE_URL . ltrim($path, '/');
        }

        return BASE_URL . 'public/assets/images/products/' . basename($path);
    }
}

$gallery = $gallery ?? [];
$maSanPham = $ma_san_pham ?? '';
$status = $status ?? null;
$message = $message ?? '';

$coverImages = array_values(array_filter($gallery, fn($img) => ($img['LoaiAnh'] ?? 'detail') === 'cover'));
$detailImages = array_values(array_filter($gallery, fn($img) => ($img['LoaiAnh'] ?? 'detail') !== 'cover'));
$coverImage = $coverImages[0] ?? null;
$coverCount = $coverImage ? 1 : 0;
$detailCount = (int)($imageSummary['detail_count'] ?? count($detailImages));
$detailLimit = (int)($imageSummary['detail_limit'] ?? 8);

$productName = '';
if (!empty($gallery) && isset($gallery[0]['TenSanPham'])) {
    $productName = $gallery[0]['TenSanPham'];
} elseif ($maSanPham !== '') {
    $productName = 'Sản phẩm ' . $maSanPham;
}
?>

<main class="ml-64 p-8 lg:p-12 min-h-screen bg-[#f9faf2]">
    <?php if (!empty($status)): ?>
        <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl border text-sm font-semibold
            <?= $status === 'success'
                ? 'bg-[#d0ecaf]/60 border-[#384e21]/20 text-[#384e21]'
                : 'bg-[#ffdad6]/60 border-[#ba1a1a]/20 text-[#ba1a1a]' ?>">
            <span class="material-symbols-outlined">
                <?= $status === 'success' ? 'check_circle' : 'error' ?>
            </span>
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 mb-10">
        <div>
            <a href="<?= BASE_URL ?>index.php?url=admin/products"
               class="text-[#384e21] hover:opacity-70 inline-flex items-center transition-opacity mb-3">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span class="text-sm font-bold ml-1 uppercase tracking-tighter">Quay lại danh sách</span>
            </a>
            <h2 class="text-5xl font-black text-[#384e21] tracking-tighter mb-2">Quản lý ảnh sản phẩm</h2>
            <?php if ($productName): ?>
                <p class="text-[#44483e] text-lg">
                    Sản phẩm: <span class="font-bold text-[#384e21]"><?= e($productName) ?></span>
                </p>
            <?php endif; ?>
        </div>

        <div class="text-right bg-white rounded-2xl px-5 py-4 border border-[#c5c8ba]/30">
            <p class="text-sm text-[#44483e]">
                Ảnh bìa: <span class="font-bold text-[#384e21]"><?= $coverCount ?>/1</span>
            </p>
            <p class="text-sm text-[#44483e] mt-1">
                Ảnh chi tiết: <span class="font-bold text-[#384e21]"><?= $detailCount ?>/<?= $detailLimit ?></span>
            </p>
        </div>
    </header>

    <section class="grid grid-cols-1 xl:grid-cols-[360px_1fr] gap-8 mb-10">
        <div class="bg-white rounded-2xl border border-[#c5c8ba]/20 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-black text-[#384e21]">Ảnh bìa</h3>
                <span class="text-xs font-bold px-3 py-1 rounded-full <?= $coverCount ? 'bg-[#d0ecaf] text-[#384e21]' : 'bg-[#ffdad6] text-[#ba1a1a]' ?>">
                    <?= $coverCount ?>/1
                </span>
            </div>

            <?php if ($coverImage): ?>
                <div class="aspect-[8/9] rounded-2xl overflow-hidden bg-[#edefe7] border border-[#c5c8ba]/30">
                    <img
                        src="<?= e(admin_product_image_src($coverImage['DuongDan'] ?? '')) ?>"
                        alt="Ảnh bìa sản phẩm"
                        class="w-full h-full object-cover"
                        onerror="this.src='<?= BASE_URL ?>public/images/placeholder.png'"
                    >
                </div>
                <p class="text-xs text-[#44483e] mt-3 break-all"><?= e($coverImage['DuongDan'] ?? '') ?></p>
            <?php else: ?>
                <div class="aspect-[8/9] rounded-2xl bg-[#edefe7] border border-dashed border-[#c5c8ba] flex items-center justify-center text-[#44483e]">
                    Chưa có ảnh bìa
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl border border-[#c5c8ba]/20 p-6 shadow-sm flex flex-col justify-center">
            <h3 class="text-xl font-black text-[#384e21] mb-3">Ảnh chi tiết đã có</h3>
            <p class="text-sm text-[#44483e] leading-6">
                Sản phẩm có sẵn chỉ xem và xóa ảnh chi tiết tại đây. Ảnh chi tiết mới được thêm khi tạo sản phẩm mới.
            </p>
            <p class="mt-4 text-sm font-bold text-[#384e21]">
                Hiện có <?= $detailCount ?>/<?= $detailLimit ?> ảnh chi tiết.
            </p>
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-[#c5c8ba]/20 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-black text-[#384e21]">Ảnh chi tiết</h3>
            <span class="text-sm font-bold text-[#44483e]"><?= $detailCount ?>/<?= $detailLimit ?></span>
        </div>

        <?php if (!empty($detailImages)): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php foreach ($detailImages as $img): ?>
                    <?php $maAnh = e($img['MaHinhAnh'] ?? ''); ?>
                    <div class="relative group aspect-[8/9] rounded-2xl overflow-hidden bg-[#edefe7] border border-[#c5c8ba]/30">
                        <img
                            src="<?= e(admin_product_image_src($img['DuongDan'] ?? '')) ?>"
                            alt="Ảnh chi tiết <?= $maAnh ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.src='<?= BASE_URL ?>public/images/placeholder.png'"
                        >

                        <form method="POST"
                              action="<?= BASE_URL ?>index.php?url=admin/products/gallery&id=<?= urlencode($maSanPham) ?>"
                              onsubmit="return confirm('Xóa ảnh chi tiết này?')"
                              class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <input type="hidden" name="action" value="delete_image">
                            <input type="hidden" name="ma_anh" value="<?= $maAnh ?>">
                            <button type="submit" class="h-9 w-9 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>

                        <div class="absolute left-3 bottom-3 bg-black/50 text-white text-[10px] font-bold px-2 py-1 rounded-lg">
                            <?= $maAnh ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-20 bg-[#f9faf2] rounded-2xl border border-dashed border-[#c5c8ba]">
                <span class="material-symbols-outlined text-[#384e21] text-4xl mb-3">image_not_supported</span>
                <p class="font-bold text-[#191c18] text-lg mb-1">Chưa có ảnh chi tiết</p>
                <p class="text-[#44483e] text-sm">Ảnh chi tiết chỉ thêm ở bước tạo sản phẩm mới.</p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
