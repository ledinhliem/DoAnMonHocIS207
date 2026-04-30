<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Lịch sử đơn hàng</h1>

    <?php if (empty($orders)): ?>
        <div class="bg-surface-container rounded-2xl p-8">
            Chưa có đơn hàng nào.
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach (array_reverse($orders) as $order): ?>
                <div class="bg-white rounded-2xl border border-outline-variant/30 p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="text-sm text-on-surface-variant">Mã đơn hàng</div>
                            <div class="font-bold text-primary"><?= htmlspecialchars($order['order_id']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant">Ngày tạo</div>
                            <div><?= htmlspecialchars($order['created_at']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant">Status</div>
                            <div><?= htmlspecialchars($order['status']) ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant">Tổng cộng</div>
                            <div class="font-bold">$<?= number_format($order['summary']['total'] ?? 0, 2) ?></div>
                        </div>
                        <div>
                            <a href="<?= BASE_URL ?>?url=order/tracking" class="px-4 py-2 rounded-xl bg-primary text-white text-sm">Theo dõi</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>