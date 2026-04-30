<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Thanh toán</h1>

    <?php if (!empty($success)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="mb-6 rounded-2xl bg-red-100 text-red-800 px-5 py-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <form method="POST" action="?url=order/payment" class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5">
                <h2 class="text-xl font-bold">Thông tin nhận hàng</h2>

                <div>
                    <label class="block text-sm font-semibold mb-2">Họ và tên</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($checkoutData['full_name'] ?? '') ?>" class="w-full rounded-xl border border-outline-variant bg-white">
                    <?php if (!empty($errors['full_name'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['full_name']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Số điện thoại</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($checkoutData['phone'] ?? '') ?>" class="w-full rounded-xl border border-outline-variant bg-white">
                    <?php if (!empty($errors['phone'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Địa chỉ</label>
                    <textarea name="address" rows="3" class="w-full rounded-xl border border-outline-variant bg-white"><?= htmlspecialchars($checkoutData['address'] ?? '') ?></textarea>
                    <?php if (!empty($errors['address'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['address']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Phương thức giao hàng</label>
                    <select name="delivery_method" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="standard" <?= (($checkoutData['delivery_method'] ?? '') === 'standard') ? 'selected' : '' ?>>Giao hàng tiêu chuẩn</option>
                        <option value="express" <?= (($checkoutData['delivery_method'] ?? '') === 'express') ? 'selected' : '' ?>>Giao hàng nhanh</option>
                    </select>
                    <?php if (!empty($errors['delivery_method'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['delivery_method']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Phương thức thanh toán</label>
                    <select name="payment_method" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="card" <?= (($checkoutData['payment_method'] ?? '') === 'card') ? 'selected' : '' ?>>Thanh toán thẻ</option>
                        <option value="cod" <?= (($checkoutData['payment_method'] ?? '') === 'cod') ? 'selected' : '' ?>>Thanh toán khi nhận hàng</option>
                    </select>
                    <?php if (!empty($errors['payment_method'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['payment_method']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex gap-4">
                    <a href="?url=cart" class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">Quay lại giỏ hàng</a>
                    <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">Tiếp tục thanh toán</button>
                </div>
            </form>

            <form method="POST" action="?url=order/apply-promo" class="bg-white rounded-2xl border border-outline-variant/30 p-6">
                <h2 class="text-xl font-bold mb-4">Mã giảm giá</h2>
                <div class="flex gap-3">
                    <input type="text" name="promo_code" placeholder="Nhập SAVE10, GREEN20 hoặc FREESHIP" class="flex-1 rounded-xl border border-outline-variant bg-white" value="<?= htmlspecialchars($summary['promo']['code'] ?? '') ?>">
                    <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">Áp dụng</button>
                </div>
            </form>
        </div>

        <div class="bg-surface-container rounded-2xl p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Tóm tắt đơn hàng</h2>

            <div class="space-y-3 mb-6">
                <?php foreach ($items as $item): ?>
                    <div class="flex justify-between gap-4 text-sm">
                        <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
                        <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="space-y-2 border-t border-outline-variant/30 pt-4">
                <div class="flex justify-between">
                    <span>Tạm tính</span>
                    <span>$<?= number_format($summary['subtotal'], 2) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Giảm giá</span>
                    <span>- $<?= number_format($summary['discount'], 2) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span>$<?= number_format($summary['shipping'], 2) ?></span>
                </div>
                <div class="flex justify-between font-bold text-primary text-lg pt-2">
                    <span>Tổng cộng</span>
                    <span>$<?= number_format($summary['total'], 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
