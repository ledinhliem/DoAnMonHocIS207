<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-6xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-10">
            Lịch sử đơn hàng
        </h1>

        <?php if (!empty($orderMessage)): ?>
            <div class="mb-6 rounded-2xl px-5 py-4 font-semibold <?= ($orderMessageStatus ?? '') === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($orderMessage) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-8">
                <p class="text-lg text-gray-700 mb-4">
                    Bạn chưa có đơn hàng nào.
                </p>

                <a href="?url=product"
                   class="inline-block px-6 py-3 rounded-xl bg-[#2F512A] text-white font-semibold">
                    Tiếp tục mua sắm
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($orders as $order): ?>
                    <?php
                        $orderId = $order['MaDonHang'] ?? '';
                        $createdAt = $order['NgayDat'] ?? '';
                        $status = $order['TrangThai'] ?? 0;
                        $total = $order['ThanhTienCuoi'] ?? 0;
                        $items = $order['items'] ?? [];

                        $statusMap = [
                            0 => 'Chờ xác nhận',
                            1 => 'Đang chuẩn bị',
                            2 => 'Đang giao',
                            3 => 'Hoàn thành',
                            4 => 'Đã hủy',
                            '0' => 'Chờ xác nhận',
                            '1' => 'Đang chuẩn bị',
                            '2' => 'Đang giao',
                            '3' => 'Hoàn thành',
                            '4' => 'Đã hủy',
                        ];

                        $statusText = $statusMap[$status] ?? 'Không xác định';
                    ?>

                    <div class="bg-white rounded-2xl border border-[#E5E7D8] p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-5">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Mã đơn hàng</p>
                                <p class="font-bold text-[#2F512A]">
                                    <?= htmlspecialchars($orderId) ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 mb-1">Ngày tạo</p>
                                <p class="font-semibold">
                                    <?= htmlspecialchars($createdAt) ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 mb-1">Trạng thái</p>
                                <p class="font-semibold">
                                    <?= htmlspecialchars($statusText) ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tổng tiền</p>
                                <p class="font-bold text-[#2F512A]">
                                    <?= number_format((float)$total, 0, ',', '.') ?>₫
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($items)): ?>
                            <div class="border-t border-[#E5E7D8] pt-5">
                                <h3 class="font-bold text-[#2F512A] mb-4">
                                    Sản phẩm trong đơn
                                </h3>

                                <div class="space-y-4">
                                    <?php foreach ($items as $item): ?>
                                        <?php
                                            $productName = $item['TenSanPham'] ?? 'Sản phẩm';
                                            $productId = $item['MaSanPham'] ?? '';
                                            $variantText = trim(($item['KichThuoc'] ?? '') . ' ' . ($item['MauSac'] ?? ''));
                                            $quantity = (int)($item['SoLuong'] ?? 0);
                                            $price = (float)($item['DonGia'] ?? 0);
                                            $image = $item['HinhAnh'] ?? '';
                                            if (!empty($image)) {
                                                $imageUrl = str_starts_with($image, 'public/')
                                                    ? BASE_URL . ltrim($image, '/')
                                                    : BASE_URL . 'public/images/Products/' . basename($image);
                                            } else {
                                                $imageUrl = '';
                                            }
                                        ?>

                                        <div class="flex items-center gap-4">
                                            <?php if (!empty($imageUrl)): ?>
                                                <img src="<?= htmlspecialchars($imageUrl) ?>"
                                                     alt="<?= htmlspecialchars($productName) ?>"
                                                     class="w-20 h-20 rounded-xl object-cover border border-[#E5E7D8]">
                                            <?php else: ?>
                                                <div class="w-20 h-20 rounded-xl bg-[#EEF1E7] flex items-center justify-center text-xs text-gray-500">
                                                    No image
                                                </div>
                                            <?php endif; ?>

                                            <div class="flex-1">
                                                <p class="font-bold text-[#2F512A]">
                                                    <?= htmlspecialchars($productName) ?>
                                                </p>

                                                <?php if (!empty($variantText)): ?>
                                                    <p class="text-sm text-gray-500">
                                                        Phân loại: <?= htmlspecialchars($variantText) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <p class="text-sm text-gray-500">
                                                    Số lượng: <?= $quantity ?>
                                                </p>

                                                <?php if ((string)$status === '3' && $productId !== ''): ?>
                                                    <a href="?url=order/feedback&id=<?= urlencode($orderId) ?>&product=<?= urlencode($productId) ?>"
                                                       class="inline-block mt-3 px-4 py-2 rounded-lg bg-[#2F512A] text-white text-sm font-semibold">
                                                        Đánh giá
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                            <div class="text-right">
                                                <p class="font-semibold">
                                                    <?= number_format($price, 0, ',', '.') ?>₫
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    Tổng: <?= number_format($price * $quantity, 0, ',', '.') ?>₫
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="?url=order/tracking&id=<?= urlencode($orderId) ?>"
                               class="inline-block px-5 py-3 rounded-xl border border-[#2F512A] text-[#2F512A] font-semibold">
                                Theo dõi đơn
                            </a>

                            <?php if ((string)$status === '0'): ?>
                                <form method="POST"
                                      action="?url=order/cancel"
                                      class="js-cancel-order-form"
                                      data-order-id="<?= htmlspecialchars($orderId, ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="MaDonHang" value="<?= htmlspecialchars($orderId, ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="redirect" value="history">
                                    <button type="submit"
                                            class="px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors">
                                        Hủy đơn hàng
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<div id="cancelOrderModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-[#E5E7D8]">
        <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-[#2F512A] mb-2">Bạn chắc chắn muốn hủy đơn?</h2>
        <p class="text-gray-600 leading-relaxed">
            Đơn <span id="cancelOrderIdText" class="font-bold text-[#2F512A]"></span> vẫn có thể được tiếp tục xử lý. Nếu bạn chỉ muốn đổi thông tin giao hàng, hãy giữ đơn và liên hệ hỗ trợ.
        </p>
        <p class="mt-3 text-sm text-red-600 font-semibold">
            Sau khi hủy, đơn hàng sẽ không thể tiếp tục xử lý.
        </p>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <button type="button" id="keepOrderBtn" class="px-5 py-3 rounded-xl border border-[#2F512A] text-[#2F512A] font-bold hover:bg-[#F3F6EF] transition-colors">
                Tiếp tục giữ đơn
            </button>
            <button type="button" id="confirmCancelOrderBtn" class="px-5 py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition-colors">
                Xác nhận hủy
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('cancelOrderModal');
    const orderText = document.getElementById('cancelOrderIdText');
    const keepBtn = document.getElementById('keepOrderBtn');
    const confirmBtn = document.getElementById('confirmCancelOrderBtn');
    let pendingForm = null;

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        pendingForm = null;
    }

    document.querySelectorAll('.js-cancel-order-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            pendingForm = form;
            orderText.textContent = form.dataset.orderId || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    keepBtn?.addEventListener('click', closeModal);
    modal?.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });
    confirmBtn?.addEventListener('click', function () {
        if (pendingForm) pendingForm.submit();
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
