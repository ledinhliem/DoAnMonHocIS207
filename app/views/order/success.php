<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-4xl mx-auto px-8 py-16">
    <div class="bg-white rounded-3xl border border-outline-variant/30 p-10 text-center">
        <div class="w-20 h-20 rounded-full bg-green-100 mx-auto flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-green-700 text-4xl">check</span>
        </div>

        <h1 class="text-4xl font-black font-headline text-primary mb-4">Đặt hàng thành công</h1>

        <?php if (!empty($success)): ?>
            <p class="mb-4 text-green-700"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if (!empty($order)): ?>
            <p class="text-on-surface-variant mb-3">
                Your order has been created successfully.
            </p>

            <p class="text-lg mb-8">
                Mã đơn hàng: <strong class="text-primary"><?= htmlspecialchars($order['order_id']) ?></strong>
            </p>
        <?php endif; ?>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="?url=order/tracking" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                Theo dõi đơn hàng
            </a>
            <a href="?url=order/feedback" class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                Gửi phản hồi
            </a>
            <a href="?url=order/history" class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                Lịch sử đơn hàng
            </a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>