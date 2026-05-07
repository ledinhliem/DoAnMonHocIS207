<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

$category = $category ?? [];
$isEdit = $isEdit ?? false;
$status = $status ?? null;
$message = $message ?? null;
$actionUrl = $isEdit ? 'index.php?url=admin/categories/edit&id=' . urlencode($category['MaDanhMuc'] ?? '') : 'index.php?url=admin/categories/create';
?>

<main class="ml-64 p-8 lg:p-12">
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-primary tracking-tighter mb-2">
                <?= $isEdit ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' ?>
            </h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">
                <?= $isEdit ? 'Cập nhật thông tin danh mục để nhóm sản phẩm rõ ràng hơn.' : 'Tạo danh mục mới để quản lý sản phẩm theo chủ đề và phân loại.' ?>
            </p>
        </div>

        <a href="index.php?url=admin/categories"
            class="bg-surface-container-high text-on-surface px-6 py-3 rounded-lg font-bold hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Quay lại danh sách
        </a>
    </header>

    <?php if ($status): ?>
        <div
            class="mb-6 rounded-xl p-5 <?= $status === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?> shadow-sm">
            <p class="font-semibold mb-1"><?= $status === 'success' ? 'Hoàn tất' : 'Lỗi' ?></p>
            <p class="text-sm"><?= e($message) ?></p>
        </div>
    <?php endif; ?>

    <section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
        <form action="<?= e($actionUrl) ?>" method="POST" class="space-y-6">
            <input type="hidden" name="action" value="<?= $isEdit ? 'update_category' : 'create_category' ?>">

            <?php if ($isEdit): ?>
                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Mã danh mục</label>
                    <input type="text" readonly value="<?= e($category['MaDanhMuc'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                    <input type="hidden" name="MaDanhMuc" value="<?= e($category['MaDanhMuc'] ?? '') ?>">
                </div>
            <?php endif; ?>

            <div class="grid gap-3">
                <label class="text-sm font-semibold">Tên danh mục</label>
                <input name="TenDanhMuc" type="text" value="<?= e($category['TenDanhMuc'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                    required>
            </div>

            <div class="grid gap-3">
                <label class="text-sm font-semibold">Ảnh danh mục (tên file đã upload)</label>
                <input name="HinhAnh" type="text" value="<?= e($category['HinhAnh'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                    placeholder="Ví dụ: c001-zen-kitchen.jpg">
                <p class="text-sm text-on-surface-variant"> Nhập tên ảnh nếu muốn quản lý hình đại diện. File cần nằm
                    trong public/assets/images/categories/.</p>
            </div>

            <?php if ($isEdit): ?>
                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Trạng thái</label>
                    <label
                        class="flex items-center gap-3 rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest">
                        <input type="checkbox" name="TrangThai" value="1" <?= isset($category['TrangThai']) && $category['TrangThai'] == 1 ? 'checked' : '' ?> class="w-5 h-5 text-primary">
                        <span>Hiển thị danh mục (tắt = ẩn khỏi website)</span>
                    </label>
                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                <button type="submit"
                    class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:bg-primary-container transition-colors">
                    <?= $isEdit ? 'Cập nhật danh mục' : 'Tạo danh mục' ?>
                </button>
                <a href="index.php?url=admin/categories" class="text-sm text-on-surface-variant hover:text-primary">Hủy
                    bỏ</a>
            </div>
        </form>
    </section>
</main>

<footer
    class="ml-64 flex flex-col md:flex-row justify-between items-center px-12 py-12 mt-20 border-t border-[#c5c8ba]/10 bg-surface-container-low text-primary">
    <div class="mb-6 md:mb-0">
        <h4 class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</h4>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2026 Zentro Sustainable
            Living. Admin panel.</p>
    </div>
    <div class="flex gap-8">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Chính sách bảo mật</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100"
            href="#">Điều khoản dịch vụ</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>