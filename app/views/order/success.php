<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-4xl mx-auto px-8 py-16">
    <div class="bg-white rounded-3xl border border-outline-variant/30 p-10 text-center">
        <div class="w-20 h-20 rounded-full bg-green-100 mx-auto flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-green-700 text-4xl">check</span>
        </div>

        <h1 class="text-4xl font-black font-headline text-primary mb-4">
            Đặt hàng thành công
        </h1>

        <?php if (!empty($success)): ?>
            <p class="mb-4 text-green-700">
                <?= htmlspecialchars($success) ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($order)): ?>
            <p class="text-on-surface-variant mb-3">
                Đơn hàng của bạn đã được tạo thành công.
            </p>

            <div class="bg-surface-container rounded-2xl p-6 text-left max-w-xl mx-auto mb-8">
                <div class="flex justify-between py-2">
                    <span>Mã đơn hàng</span>
                    <strong class="text-primary">
                        <?= htmlspecialchars($order['order_id'] ?? $order['MaDonHang'] ?? '') ?>
                    </strong>
                </div>

                <div class="flex justify-between py-2">
                    <span>Ngày đặt</span>
                    <span>
                        <?= htmlspecialchars($order['created_at'] ?? $order['NgayDat'] ?? date('Y-m-d H:i:s')) ?>
                    </span>
                </div>

                <div class="flex justify-between py-2">
                    <span>Tổng tiền</span>
                    <strong>
                        <?= number_format($order['summary']['total'] ?? $order['ThanhTienCuoi'] ?? 0, 0, ',', '.') ?>₫
                    </strong>
                </div>

                <div class="flex justify-between py-2">
                    <span>Trạng thái</span>
                    <span>Chờ xác nhận</span>
                </div>
            </div>
        <?php else: ?>
            <p class="text-on-surface-variant mb-8">
                Không tìm thấy thông tin đơn hàng mới nhất.
            </p>
        <?php endif; ?>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="?url=order/tracking"
               class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                Theo dõi đơn hàng
            </a>

            <a href="?url=order/history"
               class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                Lịch sử đơn hàng
            </a>

            <a href="?url=product"
               class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>