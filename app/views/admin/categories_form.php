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
$categoryImage = trim((string)($category['HinhAnh'] ?? ''));
$categoryImageName = $categoryImage !== '' ? basename(str_replace('\\', '/', $categoryImage)) : '';
$categoryImagePath = $categoryImageName !== '' ? ROOT_PATH . '/public/assets/images/categories/' . $categoryImageName : '';
$hasCategoryImage = $categoryImageName !== '' && is_file($categoryImagePath);
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
        <form action="<?= e($actionUrl) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="action" value="<?= $isEdit ? 'update_category' : 'create_category' ?>">
            <input type="hidden" name="current_image" value="<?= e($category['HinhAnh'] ?? '') ?>">

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
                <label class="text-sm font-semibold">Ảnh danh mục</label>
                <input name="category_image" type="file" accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                <p class="text-sm text-on-surface-variant">Chỉ chấp nhận jpg, jpeg, png, webp. Khi sửa, nếu không chọn ảnh mới thì giữ ảnh cũ.</p>

                <?php if ($isEdit): ?>
                    <div class="flex items-center gap-4">
                        <?php if ($hasCategoryImage): ?>
                            <img src="<?= e(BASE_URL . 'public/assets/images/categories/' . $categoryImageName) ?>" alt="<?= e($category['TenDanhMuc'] ?? '') ?>" class="w-20 h-20 rounded-xl object-cover border border-outline-variant/30">
                        <?php else: ?>
                            <div class="w-20 h-20 rounded-xl bg-surface-container-high flex items-center justify-center text-outline border border-outline-variant/30">
                                <span class="material-symbols-outlined">category</span>
                            </div>
                        <?php endif; ?>
                        <div class="text-sm text-on-surface-variant">
                            <p><?= $categoryImageName !== '' ? e($categoryImageName) : 'Chưa có ảnh danh mục' ?></p>
                            <?php if ($categoryImageName !== '' && !$hasCategoryImage): ?>
                                <p class="text-xs text-red-700">Không tìm thấy file ảnh trong public/assets/images/categories/.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
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

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
