<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$status = $status ?? null;
$message = $message ?? null;
?>

<main class="ml-64 p-8 lg:p-12">
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-primary tracking-tighter mb-2">Danh mục sản phẩm</h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">Quản lý danh mục sản phẩm, ẩn/hiện khi cần và cập nhật thông tin cơ bản.</p>
        </div>

        <a href="index.php?url=admin/categories/create" class="flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-container transition-colors shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">add</span>
            Thêm danh mục mới
        </a>
    </header>

    <?php if ($status): ?>
        <div class="mb-6 rounded-xl p-5 <?= $status === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?> shadow-sm">
            <p class="font-semibold mb-1"><?= $status === 'success' ? 'Hoàn tất' : 'Lỗi' ?></p>
            <p class="text-sm"><?= e($message) ?></p>
        </div>
    <?php endif; ?>

    <section class="bg-surface-container-lowest rounded-xl p-6 shadow-sm overflow-x-auto">
        <table class="w-full min-w-[900px] text-left">
            <thead class="bg-surface-container-high">
                <tr>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Mã</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Tên danh mục</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Ảnh</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Sản phẩm</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Trạng thái</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr class="border-t border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                            <td class="px-6 py-4 text-on-surface font-bold"><?= e($category['MaDanhMuc']) ?></td>
                            <td class="px-6 py-4 text-on-surface"><?= e($category['TenDanhMuc']) ?></td>
                            <td class="px-6 py-4">
                                <?php
                                    $categoryImage = trim((string)($category['HinhAnh'] ?? ''));
                                    $categoryImageName = $categoryImage !== '' ? basename(str_replace('\\', '/', $categoryImage)) : '';
                                    $categoryImagePath = $categoryImageName !== '' ? ROOT_PATH . '/public/assets/images/categories/' . $categoryImageName : '';
                                ?>
                                <?php if ($categoryImageName !== '' && is_file($categoryImagePath)): ?>
                                    <img src="<?= e(BASE_URL . 'public/assets/images/categories/' . $categoryImageName) ?>" alt="<?= e($category['TenDanhMuc']) ?>" class="w-16 h-16 rounded-lg object-cover border border-outline-variant/20">
                                <?php else: ?>
                                    <div class="w-16 h-16 rounded-lg bg-surface-container-high flex items-center justify-center text-outline">
                                        <span class="material-symbols-outlined">category</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-on-surface"><?= e($category['product_count'] ?? 0) ?></td>
                            <td class="px-6 py-4">
                                <?php if (($category['TrangThai'] ?? 1) == 1): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">Hiển thị</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="index.php?url=admin/categories/edit&id=<?= urlencode($category['MaDanhMuc']) ?>" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface text-sm font-medium transition-colors">
                                    <span class="material-symbols-outlined">edit</span>
                                    Sửa
                                </a>
                                <?php if (($category['TrangThai'] ?? 1) == 1): ?>
                                    <a href="index.php?url=admin/categories/hide&id=<?= urlencode($category['MaDanhMuc']) ?>" onclick="return confirm('Danh mục có thể đang chứa sản phẩm. Bạn có chắc muốn ẩn?')" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined">visibility_off</span>
                                        Ẩn
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?url=admin/categories/show&id=<?= urlencode($category['MaDanhMuc']) ?>" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                        Hiện
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-on-surface-variant">
                            Chưa có danh mục nào. Hãy tạo danh mục mới để phân loại sản phẩm.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
