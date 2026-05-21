<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$orderCode = $order['MaDonHang'] ?? $order['order_id'] ?? '';
$product = $product ?? null;
$pageError = $pageError ?? '';
$productImage = '';
if (is_array($product) && !empty($product['HinhAnh'])) {
    $productImage = function_exists('product_image_url')
        ? product_image_url((string)$product['HinhAnh'])
        : BASE_URL . 'public/images/Products/' . basename((string)$product['HinhAnh']);
}
?>

<main class="max-w-3xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Đánh giá sản phẩm</h1>

    <?php if (!empty($success)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-outline-variant/30 p-6">
        <?php if (!empty($pageError)): ?>
            <div class="rounded-2xl bg-red-50 text-red-700 px-5 py-4 mb-6">
                <?= htmlspecialchars($pageError) ?>
            </div>

            <a href="?url=order/history" class="inline-block px-5 py-3 rounded-xl border border-primary text-primary font-semibold">
                Quay lại lịch sử đơn hàng
            </a>
        <?php else: ?>
            <div class="mb-6 text-sm text-on-surface-variant">
                Đánh giá cho đơn hàng:
                <span class="font-semibold text-primary"><?= htmlspecialchars($orderCode) ?></span>
            </div>

            <?php if (!empty($product)): ?>
                <div class="mb-6 flex items-center gap-4 rounded-2xl bg-surface-container p-4">
                    <?php if (!empty($productImage)): ?>
                        <img src="<?= htmlspecialchars($productImage) ?>"
                             alt="<?= htmlspecialchars($product['TenSanPham'] ?? 'Sản phẩm') ?>"
                             class="w-20 h-20 rounded-xl object-cover border border-outline-variant/30">
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-xl bg-white flex items-center justify-center text-outline">
                            <span class="material-symbols-outlined">image</span>
                        </div>
                    <?php endif; ?>

                    <div>
                        <p class="text-sm text-on-surface-variant">Sản phẩm</p>
                        <p class="font-bold text-primary"><?= htmlspecialchars($product['TenSanPham'] ?? 'Sản phẩm') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors['general'])): ?>
                <div class="rounded-2xl bg-red-50 text-red-700 px-5 py-4 mb-6">
                    <?= htmlspecialchars($errors['general']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="?url=order/submit-feedback" class="space-y-5">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderCode) ?>">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['MaSanPham'] ?? '') ?>">

                <div>
                    <label class="block text-sm font-semibold mb-2">Số sao</label>
                    <select name="rating" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="">Chọn số sao</option>
                        <option value="5" <?= (($old['rating'] ?? '') === '5') ? 'selected' : '' ?>>5 sao</option>
                        <option value="4" <?= (($old['rating'] ?? '') === '4') ? 'selected' : '' ?>>4 sao</option>
                        <option value="3" <?= (($old['rating'] ?? '') === '3') ? 'selected' : '' ?>>3 sao</option>
                        <option value="2" <?= (($old['rating'] ?? '') === '2') ? 'selected' : '' ?>>2 sao</option>
                        <option value="1" <?= (($old['rating'] ?? '') === '1') ? 'selected' : '' ?>>1 sao</option>
                    </select>
                    <?php if (!empty($errors['rating'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['rating']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Nội dung đánh giá</label>
                    <textarea
                        name="message"
                        rows="5"
                        class="w-full rounded-xl border border-outline-variant bg-white"
                        placeholder="Hãy chia sẻ trải nghiệm của bạn..."
                    ><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                    <?php if (!empty($errors['message'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['message']) ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                    Gửi đánh giá
                </button>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
