<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
// ── Helpers ────────────────────────────────────────────────
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

// ── Dữ liệu từ Controller (AdminController::gallery()) ─────
// $gallery      = array of rows từ hinhanhsanpham
// $ma_san_pham  = mã sản phẩm hiện tại
// $status       = 'success' | 'error' | null
// $message      = string thông báo

$gallery     = $gallery     ?? [];
$maSanPham   = $ma_san_pham ?? '';
$productName = '';

// Lấy tên sản phẩm từ row đầu tiên (controller nên join TenSanPham)
if (!empty($gallery) && isset($gallery[0]['TenSanPham'])) {
    $productName = $gallery[0]['TenSanPham'];
} elseif ($maSanPham !== '') {
    $productName = 'Sản phẩm ' . e($maSanPham);
}

$totalImages = count($gallery);
?>

<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="ml-64 p-8 lg:p-12 min-h-screen bg-[#f9faf2]">

    <!-- ── Flash message ─────────────────────────────────── -->
    <?php if (!empty($status)): ?>
    <div id="flash-msg" class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl border text-sm font-semibold
        <?= $status === 'success'
            ? 'bg-[#d0ecaf]/60 border-[#384e21]/20 text-[#384e21]'
            : 'bg-[#ffdad6]/60 border-[#ba1a1a]/20 text-[#ba1a1a]' ?>">
        <span class="material-symbols-outlined">
            <?= $status === 'success' ? 'check_circle' : 'error' ?>
        </span>
        <?= e($message ?? '') ?>
    </div>
    <?php endif; ?>

    <!-- ── Header ────────────────────────────────────────── -->
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="/is207/index.php?url=admin/products"
                   class="text-[#384e21] hover:opacity-70 flex items-center transition-opacity">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span class="text-sm font-bold ml-1 uppercase tracking-tighter">Quay lại danh sách</span>
                </a>
            </div>
            <h2 class="text-5xl font-black text-[#384e21] tracking-tighter mb-2">Thư viện ảnh</h2>
            <?php if ($productName): ?>
            <p class="text-[#44483e] text-lg">
                Sản phẩm: <span class="font-bold text-[#384e21]"><?= e($productName) ?></span>
            </p>
            <?php endif; ?>
        </div>

        <div class="text-right">
            <p class="text-sm text-[#44483e]">
                Tổng số ảnh: <span class="font-bold text-[#384e21]"><?= $totalImages ?></span>
            </p>
        </div>
    </header>

    <!-- ── Upload form ───────────────────────────────────── -->
    <section class="mb-12">
        <form method="POST"
              action="/is207/index.php?url=admin/products/gallery&id=<?= urlencode($maSanPham) ?>"
              enctype="multipart/form-data"
              id="upload-form">
            <input type="hidden" name="action" value="upload_image">

            <label for="image-input"
                   class="w-full h-64 border-2 border-dashed border-[#c5c8ba] bg-white rounded-2xl
                          flex flex-col items-center justify-center group hover:border-[#384e21]
                          transition-all cursor-pointer block">
                <div class="bg-[#d0ecaf] p-6 rounded-full mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[#384e21] text-4xl">cloud_upload</span>
                </div>
                <p class="font-['Be_Vietnam_Pro'] text-[#191c18] font-bold text-lg" id="upload-label">
                    Kéo thả ảnh vào đây hoặc click để chọn
                </p>
                <p class="text-[#44483e] text-sm mt-1">Hỗ trợ JPG, PNG, WEBP (Tối đa 10MB)</p>
            </label>

            <input type="file" id="image-input" name="image"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="hidden">

            <div id="upload-preview" class="hidden mt-4 flex items-center gap-4 p-4 bg-white border border-[#c5c8ba]/30 rounded-2xl">
                <img id="preview-img" src="" alt="preview" class="w-20 h-20 object-cover rounded-xl">
                <div class="flex-1">
                    <p id="preview-name" class="font-bold text-[#191c18] text-sm"></p>
                    <p id="preview-size" class="text-xs text-[#44483e] mt-1"></p>
                </div>
                <button type="submit" class="zentro-button !w-auto px-8 flex items-center gap-2">
                    <span class="material-symbols-outlined">upload</span>
                    Tải lên
                </button>
            </div>
        </form>
    </section>

    <!-- ── Gallery grid ──────────────────────────────────── -->
    <section>
        <div class="flex items-center justify-between mb-8">
            <h3 class="font-['Epilogue'] text-2xl font-bold text-[#191c18]">
                Tất cả hình ảnh
                <span class="ml-2 text-sm font-medium text-[#44483e]">(<?= $totalImages ?>)</span>
            </h3>
        </div>

        <?php if ($totalImages > 0): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($gallery as $index => $img): ?>
            <?php
                // Controller join field "DuongDan" từ hinhanhsanpham
                $src    = e($img['DuongDan'] ?? '');
                $maAnh  = e($img['MaHinhAnh'] ?? '');
                $isFirst = ($index === 0);
            ?>
            <div class="relative group aspect-square rounded-2xl overflow-hidden bg-white shadow-sm
                        hover:shadow-md transition-all border
                        <?= $isFirst ? 'ring-4 ring-[#384e21] border-transparent' : 'border-[#c5c8ba]/30' ?>">

                <img src="/is207/<?= $src ?>"
                     alt="Ảnh sản phẩm <?= $maAnh ?>"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     onerror="this.src='/is207/public/images/placeholder.png'">

                <!-- Badge thumbnail cho ảnh đầu tiên -->
                <?php if ($isFirst): ?>
                <div class="absolute top-3 left-3 bg-[#384e21] text-white text-[10px]
                            uppercase tracking-widest font-black px-2 py-1 rounded-lg">
                    Thumbnail
                </div>
                <?php endif; ?>

                <!-- Nút xóa -->
                <form method="POST"
                      action="/is207/index.php?url=admin/products/gallery&id=<?= urlencode($maSanPham) ?>"
                      onsubmit="return confirm('Xóa ảnh này?')"
                      class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <input type="hidden" name="action"  value="delete_image">
                    <input type="hidden" name="ma_anh"  value="<?= $maAnh ?>">
                    <button type="submit"
                            class="h-8 w-8 bg-red-500 hover:bg-red-600 text-white rounded-full
                                   flex items-center justify-center transition-colors shadow">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </form>

                <!-- Hover overlay: đặt làm thumbnail (ảnh đầu tiên DB — cần thêm action nếu muốn) -->
                <?php if (!$isFirst): ?>
                <div class="absolute inset-0 bg-[#384e21]/20 opacity-0 group-hover:opacity-100
                            transition-opacity flex items-end justify-center pb-4 px-4">
                    <span class="text-white text-[10px] font-bold bg-black/30 px-2 py-1 rounded-lg">
                        <?= $maAnh ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl
                    border border-[#c5c8ba]/20">
            <div class="w-20 h-20 rounded-full bg-[#edefe7] flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[#384e21] text-3xl">image_not_supported</span>
            </div>
            <p class="font-bold text-[#191c18] text-lg mb-1">Chưa có hình ảnh nào</p>
            <p class="text-[#44483e] text-sm">Tải ảnh lên bằng ô phía trên để bắt đầu.</p>
        </div>
        <?php endif; ?>
    </section>

    <!-- ── Footer info bar ───────────────────────────────── -->
    <div class="mt-20 flex flex-wrap gap-4 items-center justify-center p-8
                bg-[#edefe7]/50 rounded-2xl border border-[#c5c8ba]/20">
        <div class="flex items-center gap-3 px-6 py-3 bg-white rounded-full
                    border border-[#c5c8ba]/20 shadow-sm">
            <span class="material-symbols-outlined text-[#384e21]">eco</span>
            <span class="text-sm font-bold text-[#384e21]">Tối ưu dung lượng ảnh</span>
        </div>
        <div class="flex items-center gap-3 px-6 py-3 bg-white rounded-full
                    border border-[#c5c8ba]/20 shadow-sm">
            <span class="material-symbols-outlined text-[#384e21]">speed</span>
            <span class="text-sm font-bold text-[#384e21]">Tự động tạo WebP</span>
        </div>
    </div>
</main>

<!-- JS riêng cho trang gallery -->
<script src="/is207/public/js/products-gallery.js"></script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>