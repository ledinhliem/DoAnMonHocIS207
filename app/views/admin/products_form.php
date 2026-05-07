<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$product = $product ?? [];
$isEdit = $isEdit ?? false;
$canShow = $canShow ?? false;
$status = $status ?? null;
$message = $message ?? null;
$created = $created ?? false;
$actionUrl = $isEdit ? 'index.php?url=admin/products/edit&id=' . urlencode($product['MaSanPham'] ?? '') : 'index.php?url=admin/products/create';
?>

<main class="ml-64 p-8 lg:p-12">
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-primary tracking-tighter mb-2"><?= $isEdit ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' ?></h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">
                <?= $isEdit ? 'Cập nhật thông tin sản phẩm và trạng thái hiển thị.' : 'Tạo sản phẩm mới. SP mới sẽ mặc định ẩn đến khi hoàn chỉnh thông tin.' ?>
            </p>
        </div>

        <a href="index.php?url=admin/products" class="bg-surface-container-high text-on-surface px-6 py-3 rounded-lg font-bold hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Quay lại danh sách
        </a>
    </header>

    <?php if ($status || $created): ?>
        <div class="mb-6 rounded-xl p-5 <?= $status === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?> shadow-sm">
            <p class="font-semibold mb-1"><?= $status === 'success' ? 'Hoàn tất' : 'Lỗi' ?></p>
            <p class="text-sm">
                <?= e($message ?: ($created ? 'Sản phẩm đã khởi tạo. Vui lòng hoàn thiện biến thể và ảnh trước khi bật hiển thị.' : '')) ?>
            </p>
        </div>
    <?php endif; ?>

    <section class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-8">
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <form action="<?= e($actionUrl) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="<?= $isEdit ? 'update_product' : 'create_product' ?>">

                <?php if ($isEdit): ?>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold">Mã sản phẩm</label>
                        <input type="text" readonly value="<?= e($product['MaSanPham'] ?? '') ?>" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                        <input type="hidden" name="MaSanPham" value="<?= e($product['MaSanPham'] ?? '') ?>">
                    </div>
                <?php endif; ?>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Tên sản phẩm</label>
                    <input name="TenSanPham" type="text" value="<?= e($product['TenSanPham'] ?? '') ?>" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface" required>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Danh mục</label>
                        <select name="MaDanhMuc" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= e($category['MaDanhMuc']) ?>" <?= isset($product['MaDanhMuc']) && $product['MaDanhMuc'] === $category['MaDanhMuc'] ? 'selected' : '' ?>><?= e($category['TenDanhMuc']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Thương hiệu</label>
                        <select name="MaThuongHieu" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                            <option value="">Chọn thương hiệu</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= e($brand['MaThuongHieu']) ?>" <?= isset($product['MaThuongHieu']) && $product['MaThuongHieu'] === $brand['MaThuongHieu'] ? 'selected' : '' ?>><?= e($brand['TenThuongHieu']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Vật liệu</label>
                        <select name="MaVatLieu" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                            <option value="">Chọn vật liệu</option>
                            <?php foreach ($materials as $material): ?>
                                <option value="<?= e($material['MaVatLieu']) ?>" <?= isset($product['MaVatLieu']) && $product['MaVatLieu'] === $material['MaVatLieu'] ? 'selected' : '' ?>><?= e($material['TenVatLieu']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Điểm xanh</label>
                        <input name="DiemXanh" type="number" min="0" max="100" value="<?= e($product['DiemXanh'] ?? 10) ?>" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                    </div>
                </div>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Mô tả</label>
                    <textarea name="MoTa" rows="5" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"><?= e($product['MoTa'] ?? '') ?></textarea>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Nguồn gốc</label>
                        <input name="NguonGoc" type="text" value="<?= e($product['NguonGoc'] ?? '') ?>" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Tác động môi trường</label>
                        <input name="TacDongMoiTruong" type="text" value="<?= e($product['TacDongMoiTruong'] ?? '') ?>" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                    </div>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-4 bg-surface-container-lowest cursor-pointer">
                        <input type="checkbox" name="CoTaiChe" value="1" <?= isset($product['CoTaiChe']) && $product['CoTaiChe'] == 1 ? 'checked' : '' ?> class="w-5 h-5 text-primary">
                        <span>Có tái chế</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-4 bg-surface-container-lowest cursor-pointer">
                        <input type="checkbox" name="ThanThienMoiTruong" value="1" <?= isset($product['ThanThienMoiTruong']) && $product['ThanThienMoiTruong'] == 1 ? 'checked' : '' ?> class="w-5 h-5 text-primary">
                        <span>Thân thiện môi trường</span>
                    </label>
                </div>

                <?php if ($isEdit): ?>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold">Trạng thái hiển thị</label>
                        <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest">
                            <input type="checkbox" name="TrangThai" value="1" <?= isset($product['TrangThai']) && $product['TrangThai'] == 1 ? 'checked' : '' ?> <?= $canShow ? '' : 'disabled' ?> class="w-5 h-5 text-primary">
                            <span><?= $canShow ? 'Có thể hiển thị' : 'Không thể bật hiển thị vì thiếu biến thể, giá hoặc ảnh' ?></span>
                        </label>
                        <?php if (!$canShow): ?>
                            <p class="text-sm text-red-700">Sản phẩm cần <p class="text-sm text-red-700">Sản phẩm cần có ít nhất 1 biến thể hợp lệ (có giá, tồn kho) và ảnh sản phẩm để bật hiển thị.</p> ít nhất 1 biến thể hợp lệ và ảnh sản phẩm để bật hiển thị.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Ảnh chính sản phẩm</label>
                    <input type="file" name="product_image" accept="image/jpeg,image/png,image/webp" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                    <?php if ($isEdit): ?>
                        <p class="text-sm text-on-surface-variant">Số ảnh hiện tại: <?= e($product['image_count'] ?? 0) ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                    <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:bg-primary-container transition-colors">
                        <?= $isEdit ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm' ?>
                    </button>
                    <a href="index.php?url=admin/products" class="text-sm text-on-surface-variant hover:text-primary">Hủy bỏ</a>
                </div>
            </form>
        </div>

        <aside class="space-y-6">
            <div class="rounded-xl bg-surface-container-lowest p-6 shadow-sm">
                <h3 class="font-bold text-lg mb-3">Luồng quản lý</h3>
                <p class="text-sm text-on-surface-variant leading-7">Sản phẩm mới tạo sẽ mặc định ẩn. Sau khi thêm ảnh và biến thể hợp lệ, bạn có thể bật trạng thái hiển thị.</p>
            </div>

            <?php if ($isEdit): ?>
                <div class="rounded-xl bg-surface-container-lowest p-6 shadow-sm">
                    <h3 class="font-bold text-lg mb-3">Thông tin nhanh</h3>
                    <p class="text-sm text-on-surface"><strong>Mã sản phẩm:</strong> <?= e($product['MaSanPham'] ?? '') ?></p>
                    <p class="text-sm text-on-surface"><strong>Ảnh:</strong> <?= e($product['image_count'] ?? 0) ?></p>
                    <p class="text-sm text-on-surface"><strong>Biến thể:</strong> <?= e($product['variant_count'] ?? 0) ?></p>
                    <p class="text-sm text-on-surface"><strong>Tồn kho ước tính:</strong> <?= e($product['total_stock'] ?? 0) ?></p>
                </div>
            <?php endif; ?>
        </aside>
    </section>
</main>

<footer class="ml-64 flex flex-col md:flex-row justify-between items-center px-12 py-12 mt-20 border-t border-[#c5c8ba]/10 bg-surface-container-low text-primary">
    <div class="mb-6 md:mb-0">
        <h4 class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</h4>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2026 Zentro Sustainable Living. Admin panel.</p>
    </div>
    <div class="flex gap-8">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Chính sách bảo mật</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Điều khoản dịch vụ</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>