<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-4xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Thanh toán thẻ</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <form id="paymentForm"
              method="POST"
              action="?url=order/process-payment"
              class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5">

            <div>
                <label class="block text-sm font-semibold mb-2">Tên trên thẻ</label>
                <input id="card_name"
                       type="text"
                       name="card_name"
                       value="<?= htmlspecialchars($old['card_name'] ?? '') ?>"
                       class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                       placeholder="NGUYEN VAN A">

                <?php if (!empty($errors['card_name'])): ?>
                    <p class="text-red-600 text-sm mt-1">
                        <?= htmlspecialchars($errors['card_name']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Số thẻ</label>
                <input id="card_number"
                       type="text"
                       name="card_number"
                       value="<?= htmlspecialchars($old['card_number'] ?? '') ?>"
                       class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                       placeholder="4242424242424242">

                <?php if (!empty($errors['card_number'])): ?>
                    <p class="text-red-600 text-sm mt-1">
                        <?= htmlspecialchars($errors['card_number']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Ngày hết hạn</label>
                    <input id="card_expiry"
                           type="text"
                           name="card_expiry"
                           value="<?= htmlspecialchars($old['card_expiry'] ?? '') ?>"
                           class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                           placeholder="MM/YY">

                    <?php if (!empty($errors['card_expiry'])): ?>
                        <p class="text-red-600 text-sm mt-1">
                            <?= htmlspecialchars($errors['card_expiry']) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">CVV</label>
                    <input id="card_cvv"
                           type="password"
                           name="card_cvv"
                           value="<?= htmlspecialchars($old['card_cvv'] ?? '') ?>"
                           class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                           placeholder="123">

                    <?php if (!empty($errors['card_cvv'])): ?>
                        <p class="text-red-600 text-sm mt-1">
                            <?= htmlspecialchars($errors['card_cvv']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-surface-container rounded-xl p-4 text-sm text-on-surface-variant">
                Đây là thanh toán mô phỏng. Có thể test bằng:
                <strong>4242424242424242</strong>, hạn thẻ <strong>12/30</strong>, CVV <strong>123</strong>.
            </div>

            <div class="flex gap-4 pt-3">
                <a href="?url=checkout"
                   class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                    Quay lại checkout
                </a>

                <button id="payNowBtn"
                        type="submit"
                        class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                    Thanh toán ngay
                </button>
            </div>
        </form>

        <div class="bg-surface-container rounded-2xl p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Tóm tắt thanh toán</h2>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Tạm tính</span>
                    <span><?= number_format($summary['subtotal'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between">
                    <span>Giảm giá</span>
                    <span>- <?= number_format($summary['discount'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span><?= number_format($summary['shipping'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between font-bold text-primary text-lg pt-2">
                    <span>Tổng cộng</span>
                    <span><?= number_format($summary['total'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const paymentForm = document.getElementById('paymentForm');
    const payNowBtn = document.getElementById('payNowBtn');

    paymentForm.addEventListener('submit', function () {
        payNowBtn.disabled = true;
        payNowBtn.textContent = 'Đang xử lý...';
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>