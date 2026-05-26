<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$promos = isset($promos) && is_array($promos) ? $promos : [];
$editingPromo = isset($editingPromo) && is_array($editingPromo) ? $editingPromo : null;
$gameRewards = isset($gameRewards) && is_array($gameRewards) ? $gameRewards : [];
$flashSales = isset($flashSales) && is_array($flashSales) ? $flashSales : [];
$flashProducts = isset($flashProducts) && is_array($flashProducts) ? $flashProducts : [];

$isEditing = $editingPromo !== null;

$formAction = $isEditing ? 'update_promo' : 'create_promo';
$formTitle = $isEditing ? 'Sửa mã giảm giá' : 'Tạo mã giảm giá mới';

$promoId = $editingPromo['MaGiamGia'] ?? '';
$code = $editingPromo['MaCode'] ?? '';
$percent = $editingPromo['PhamTramGiam'] ?? '';
$quantity = $editingPromo['SoLuong'] ?? '';
$expiredDate = $editingPromo['NgayHetHan'] ?? '';

$today = date('Y-m-d');
$totalPromos = count($promos);
$activePromos = count(array_filter($promos, function ($promo) use ($today) {
    return !empty($promo['NgayHetHan']) && $promo['NgayHetHan'] >= $today && (int)$promo['SoLuong'] > 0;
}));
$expiredPromos = count(array_filter($promos, function ($promo) use ($today) {
    return !empty($promo['NgayHetHan']) && $promo['NgayHetHan'] < $today;
}));
?>

<main class="ml-64 flex-1 p-8 lg:p-12 overflow-y-auto">
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h2 class="font-headline text-5xl font-extrabold tracking-tight text-primary leading-none mb-4">
                Quản lý mã giảm giá
            </h2>
            <p class="font-body text-lg text-on-surface-variant leading-relaxed opacity-80">
                Tạo, sửa, xóa mã giảm giá và kiểm soát ngày hết hạn hợp lệ.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="index.php?url=admin/blog"
               class="bg-surface-container-high text-primary font-bold px-6 py-3 rounded-xl hover:bg-surface-container-highest transition-colors">
                Quản lý Blog
            </a>
            <a href="index.php?url=admin/promo"
               class="bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors">
                Mã giảm giá
            </a>
        </div>
    </header>

    <?php if (!empty($status) && !empty($message)): ?>
        <div class="mb-8 rounded-2xl px-6 py-4 font-bold
            <?= $status === 'success'
                ? 'bg-green-100 text-green-700 border border-green-200'
                : 'bg-red-100 text-red-700 border border-red-200' ?>">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
        <section class="xl:col-span-1 bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/20">
            <h3 class="font-headline text-2xl font-bold text-primary mb-6">
                <?= e($formTitle) ?>
            </h3>

            <form method="POST" action="index.php?url=admin/promo" class="space-y-5">
                <input type="hidden" name="action" value="<?= e($formAction) ?>">
                <input type="hidden" name="promo_id" value="<?= e($promoId) ?>">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Mã code
                    </label>
                    <input
                        type="text"
                        name="code"
                        value="<?= e($code) ?>"
                        placeholder="VD: GREEN10"
                        class="w-full uppercase rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Phần trăm giảm
                    </label>
                    <input
                        type="number"
                        name="percent"
                        value="<?= e($percent) ?>"
                        min="1"
                        max="100"
                        placeholder="VD: 10"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Số lượng
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        value="<?= e($quantity) ?>"
                        min="1"
                        placeholder="VD: 100"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Ngày hết hạn
                    </label>
                    <input
                        type="date"
                        name="expired_date"
                        value="<?= e($expiredDate) ?>"
                        min="<?= e($today) ?>"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    >
                    <p class="text-xs text-on-surface-variant mt-2">
                        Ngày hết hạn không được nhỏ hơn ngày hiện tại.
                    </p>
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors"
                    >
                        <?= $isEditing ? 'Cập nhật mã' : 'Tạo mã' ?>
                    </button>

                    <?php if ($isEditing): ?>
                        <a href="index.php?url=admin/promo"
                           class="px-6 py-3 rounded-xl bg-surface-container-high text-primary font-bold">
                            Hủy
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <section class="xl:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-surface-container-low p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-4">confirmation_number</span>
                    <p class="text-4xl font-headline font-black text-primary"><?= $totalPromos ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mt-1">
                        Tổng mã
                    </p>
                </div>

                <div class="bg-primary text-white p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-white text-3xl mb-4">verified</span>
                    <p class="text-4xl font-headline font-black"><?= $activePromos ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest text-white/70 mt-1">
                        Còn hiệu lực
                    </p>
                </div>

                <div class="bg-red-100 text-red-700 p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-red-700 text-3xl mb-4">event_busy</span>
                    <p class="text-4xl font-headline font-black"><?= $expiredPromos ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest mt-1">
                        Đã hết hạn
                    </p>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/20 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between">
                    <h3 class="font-headline text-2xl font-bold text-primary">
                        Danh sách mã giảm giá
                    </h3>
                    <span class="text-sm text-on-surface-variant">
                        <?= $totalPromos ?> mã
                    </span>
                </div>

                <?php if (!empty($promos)): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-surface-container-low">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary">Mã</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary">Giảm</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary">Số lượng</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary">Ngày hết hạn</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary">Trạng thái</th>
                                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-primary text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <?php foreach ($promos as $promo): ?>
                                    <?php
                                    $id = $promo['MaGiamGia'] ?? '';
                                    $promoCode = $promo['MaCode'] ?? '';
                                    $promoPercent = (int)($promo['PhamTramGiam'] ?? 0);
                                    $promoQuantity = (int)($promo['SoLuong'] ?? 0);
                                    $promoExpiredDate = $promo['NgayHetHan'] ?? '';

                                    $isExpired = $promoExpiredDate !== '' && $promoExpiredDate < $today;
                                    $isOutOfStock = $promoQuantity <= 0;
                                    $isActive = !$isExpired && !$isOutOfStock;
                                    ?>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="px-6 py-5">
                                            <span class="font-headline text-lg font-bold text-primary">
                                                <?= e($promoCode) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="font-bold text-primary">
                                                <?= $promoPercent ?>%
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-on-surface-variant">
                                            <?= $promoQuantity ?>
                                        </td>
                                        <td class="px-6 py-5 text-on-surface-variant">
                                            <?= e($promoExpiredDate) ?>
                                        </td>
                                        <td class="px-6 py-5">
                                            <?php if ($isActive): ?>
                                                <span class="text-xs font-bold bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                                    Còn hiệu lực
                                                </span>
                                            <?php elseif ($isExpired): ?>
                                                <span class="text-xs font-bold bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                                    Hết hạn
                                                </span>
                                            <?php else: ?>
                                                <span class="text-xs font-bold bg-amber-100 text-amber-700 px-3 py-1 rounded-full">
                                                    Hết số lượng
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end gap-2">
                                                <a
                                                    href="index.php?url=admin/promo/edit/<?= urlencode((string)$id) ?>"
                                                    class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-surface-container-high text-primary font-bold hover:bg-surface-container-highest"
                                                >
                                                    Sửa
                                                </a>
                                                <a
                                                    href="index.php?url=admin/promo/delete/<?= urlencode((string)$id) ?>"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa mã giảm giá này?')"
                                                    class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-red-100 text-red-700 font-bold hover:bg-red-200"
                                                >
                                                    Xóa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-3xl">confirmation_number</span>
                        </div>
                        <h4 class="font-headline text-2xl font-bold text-primary mb-2">
                            Chưa có mã giảm giá
                        </h4>
                        <p class="text-on-surface-variant">
                            Hãy tạo mã giảm giá đầu tiên bằng form bên trái.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <section class="mt-10 bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">
                    Gamification
                </p>
                <h3 class="font-headline text-3xl font-bold text-primary">
                    Cấu hình 10 ô vòng quay
                </h3>
            </div>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Voucher code phải tồn tại trong danh sách mã giảm giá phía trên. Ô không trúng thì để trống voucher code.
            </p>
        </div>

        <?php if (!empty($gameRewards)): ?>
            <form method="POST" action="index.php?url=admin/promo">
                <input type="hidden" name="action" value="update_game_rewards">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-primary">Ô</th>
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-primary">Tên hiển thị</th>
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-primary">Voucher</th>
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-primary">Tỉ lệ</th>
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-widest text-primary">Bật</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <?php foreach ($gameRewards as $index => $reward): ?>
                                <tr>
                                    <td class="px-4 py-4 font-bold text-primary">
                                        <?= (int)($reward['sort_order'] ?? ($index + 1)) ?>
                                        <input type="hidden" name="rewards[<?= $index ?>][id]" value="<?= e($reward['id'] ?? '') ?>">
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="text" name="rewards[<?= $index ?>][label]" value="<?= e($reward['label'] ?? '') ?>" class="w-full rounded-xl border border-outline-variant/30 bg-white px-3 py-2" required>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="text" name="rewards[<?= $index ?>][voucher_code]" value="<?= e($reward['voucher_code'] ?? '') ?>" placeholder="GAME5" class="w-full uppercase rounded-xl border border-outline-variant/30 bg-white px-3 py-2">
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="number" name="rewards[<?= $index ?>][weight]" value="<?= e($reward['weight'] ?? 1) ?>" min="1" class="w-24 rounded-xl border border-outline-variant/30 bg-white px-3 py-2" required>
                                    </td>
                                    <td class="px-4 py-4">
                                        <label class="inline-flex items-center gap-2 font-bold text-primary">
                                            <input type="checkbox" name="rewards[<?= $index ?>][status]" value="1" <?= !empty($reward['status']) ? 'checked' : '' ?>>
                                            Bật
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="mt-6 bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors">
                    Lưu vòng quay
                </button>
            </form>
        <?php else: ?>
            <div class="rounded-2xl bg-amber-100 text-amber-800 px-5 py-4 font-bold">
                Chưa có bảng game_rewards. Hãy import phần SQL marketing trước khi cấu hình vòng quay.
            </div>
        <?php endif; ?>
    </section>

    <section class="mt-10 bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">
                    Flash sale
                </p>
                <h3 class="font-headline text-3xl font-bold text-primary">
                    Countdown và số lượng giới hạn
                </h3>
            </div>
            <span class="text-sm text-on-surface-variant">
                <?= count($flashSales) ?> chương trình
            </span>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
            <form method="POST" action="index.php?url=admin/promo" class="xl:col-span-1 space-y-4 bg-surface-container-low rounded-2xl p-6">
                <input type="hidden" name="action" value="create_flash_sale">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">Sản phẩm</label>
                    <select name="product_id" class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3" required>
                        <option value="">Chọn sản phẩm</option>
                        <?php foreach ($flashProducts as $product): ?>
                            <option value="<?= e($product['MaSanPham'] ?? '') ?>">
                                <?= e(($product['MaSanPham'] ?? '') . ' - ' . ($product['TenSanPham'] ?? '')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">Giá sale</label>
                    <input type="number" name="sale_price" min="1000" step="1000" placeholder="VD: 299000" class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">Số suất sale</label>
                    <input type="number" name="stock_limit" min="1" placeholder="VD: 20" class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">Bắt đầu</label>
                    <input type="datetime-local" name="start_time" class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">Kết thúc</label>
                    <input type="datetime-local" name="end_time" class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3" required>
                </div>
                <label class="inline-flex items-center gap-2 font-bold text-primary">
                    <input type="checkbox" name="status" value="1" checked>
                    Bật flash sale
                </label>
                <button type="submit" class="w-full bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors">
                    Tạo flash sale
                </button>
            </form>

            <div class="xl:col-span-2 overflow-x-auto rounded-2xl border border-outline-variant/20">
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low">
                        <tr>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary">Sản phẩm</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary">Giá sale</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary">Thời gian</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary">Số lượng</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary">Trạng thái</th>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-widest text-primary text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        <?php foreach ($flashSales as $sale): ?>
                            <?php
                            $now = date('Y-m-d H:i:s');
                            $isLive = !empty($sale['status']) && ($sale['start_time'] ?? '') <= $now && ($sale['end_time'] ?? '') > $now && (int)($sale['sold_count'] ?? 0) < (int)($sale['stock_limit'] ?? 0);
                            ?>
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="font-bold text-primary"><?= e($sale['product_id'] ?? '') ?></p>
                                    <p class="text-sm text-on-surface-variant"><?= e($sale['TenSanPham'] ?? '') ?></p>
                                </td>
                                <td class="px-5 py-4 font-bold text-primary">
                                    <?= number_format((float)($sale['sale_price'] ?? 0), 0, ',', '.') ?>đ
                                </td>
                                <td class="px-5 py-4 text-sm text-on-surface-variant">
                                    <?= e($sale['start_time'] ?? '') ?><br>
                                    <?= e($sale['end_time'] ?? '') ?>
                                </td>
                                <td class="px-5 py-4 text-on-surface-variant">
                                    <?= (int)($sale['sold_count'] ?? 0) ?>/<?= (int)($sale['stock_limit'] ?? 0) ?>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-bold <?= $isLive ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?> px-3 py-1 rounded-full">
                                        <?= $isLive ? 'Đang chạy' : 'Chưa chạy/hết hạn' ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="index.php?url=admin/promo/flash-delete/<?= urlencode((string)($sale['id'] ?? '')) ?>"
                                       onclick="return confirm('Bạn chắc chắn muốn xóa flash sale này?')"
                                       class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-red-100 text-red-700 font-bold hover:bg-red-200">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($flashSales)): ?>
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-on-surface-variant">
                                    Chưa có flash sale nào.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
