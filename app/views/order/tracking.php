<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-4xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Theo dõi đơn hàng</h1>

    <?php if (!empty($helpMessage)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4"><?= htmlspecialchars($helpMessage) ?></div>
    <?php endif; ?>

    <?php if (empty($order)): ?>
        <div class="bg-surface-container rounded-2xl p-8">
            Chưa có đơn hàng nào để tracking.
        </div>
    <?php else: ?>
        <div class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-on-surface-variant">Mã đơn hàng</div>
                    <div class="font-bold text-primary"><?= htmlspecialchars($order['order_id']) ?></div>
                </div>
                <div>
                    <div class="text-sm text-on-surface-variant">Status</div>
                    <div class="font-bold"><?= htmlspecialchars($order['status']) ?></div>
                </div>
                <div>
                    <div class="text-sm text-on-surface-variant">Ngày tạo</div>
                    <div><?= htmlspecialchars($order['created_at']) ?></div>
                </div>
                <div>
                    <div class="text-sm text-on-surface-variant">Thanh toán</div>
                    <div><?= htmlspecialchars($order['payment_method']) ?></div>
                </div>
            </div>

            <div class="rounded-2xl bg-surface-container p-5">
                <div class="font-semibold mb-3">Timeline</div>
                <ul class="space-y-2 text-sm">
                    <li>✓ Đã đặt hàng</li>
                    <li>✓ Thanh toán confirmed / waiting COD</li>
                    <li>• Preparing shipment</li>
                    <li>• Out for delivery</li>
                </ul>
            </div>

            <div class="flex gap-4">
                <a href="<?= BASE_URL ?>?url=order/help" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                    Cần hỗ trợ đơn hàng
                </a>
                <a href="<?= BASE_URL ?>?url=order/history" class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                    Xem lịch sử
                </a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>