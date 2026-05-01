<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
    $orderId = $order['MaDonHang'] ?? '';
    $createdAt = $order['NgayDat'] ?? '';
    $status = $order['TrangThai'] ?? 0;
    $total = $order['ThanhTienCuoi'] ?? 0;
    $items = $order['items'] ?? [];

    $receiverName = $order['TenNguoiNhan'] ?? '';
    $receiverPhone = $order['SDTNguoiNhan'] ?? '';
    $receiverAddress = $order['DiaChiGiaoHang'] ?? '';

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

    $steps = [
        0 => 'Chờ xác nhận',
        1 => 'Đang chuẩn bị',
        2 => 'Đang giao',
        3 => 'Hoàn thành',
    ];

    $currentStatus = (int)$status;
?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-5xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-10">
            Theo dõi đơn hàng
        </h1>

        <?php if (!empty($helpMessage)): ?>
            <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4">
                <?= htmlspecialchars($helpMessage) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($order)): ?>
            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-8">
                <p class="text-lg text-gray-700 mb-4">
                    Chưa có đơn hàng để theo dõi.
                </p>

                <a href="?url=product"
                   class="inline-block px-6 py-3 rounded-xl bg-[#2F512A] text-white font-semibold">
                    Tiếp tục mua sắm
                </a>
            </div>
        <?php else: ?>

            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Mã đơn hàng</p>
                        <p class="font-bold text-[#2F512A]">
                            <?= htmlspecialchars($orderId) ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">Ngày đặt</p>
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
            </div>

            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-8 mb-6">
                <h2 class="text-2xl font-bold text-[#2F512A] mb-8">
                    Tiến trình đơn hàng
                </h2>

                <?php if ((int)$status === 4): ?>
                    <div class="rounded-2xl bg-red-50 text-red-700 px-5 py-4 font-semibold">
                        Đơn hàng này đã bị hủy.
                    </div>
                <?php else: ?>
                    <div class="space-y-5">
                        <?php foreach ($steps as $stepNumber => $stepLabel): ?>
                            <?php
                                $isDone = $stepNumber <= $currentStatus;
                                $circleClass = $isDone
                                    ? 'bg-[#2F512A] text-white'
                                    : 'bg-gray-200 text-gray-500';

                                $textClass = $isDone
                                    ? 'text-[#2F512A] font-bold'
                                    : 'text-gray-500';
                            ?>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center <?= $circleClass ?>">
                                    <?= $isDone ? '✓' : ($stepNumber + 1) ?>
                                </div>

                                <div>
                                    <p class="<?= $textClass ?>">
                                        <?= htmlspecialchars($stepLabel) ?>
                                    </p>

                                    <?php if ($stepNumber === $currentStatus): ?>
                                        <p class="text-sm text-gray-500">
                                            Trạng thái hiện tại của đơn hàng.
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-6 mb-6">
                <h2 class="text-2xl font-bold text-[#2F512A] mb-5">
                    Sản phẩm trong đơn
                </h2>

                <?php if (empty($items)): ?>
                    <p class="text-gray-600">
                        Chưa có chi tiết sản phẩm cho đơn hàng này.
                    </p>
                <?php else: ?>
                    <div class="space-y-5">
                        <?php foreach ($items as $item): ?>
                            <?php
                                $productName = $item['TenSanPham'] ?? 'Sản phẩm';
                                $maBienThe = $item['MaBienThe'] ?? '';
                                $variantText = trim(($item['KichThuoc'] ?? '') . ' ' . ($item['MauSac'] ?? ''));
                                $quantity = (int)($item['SoLuong'] ?? 0);
                                $price = (float)($item['DonGia'] ?? 0);
                                $image = $item['HinhAnh'] ?? '';
                                $imageUrl = !empty($image)
                                    ? BASE_URL . 'public/images/products/' . basename($image)
                                    : '';
                            ?>

                            <div class="flex items-center gap-4 border-b border-[#E5E7D8] pb-5 last:border-b-0">
                                <?php if (!empty($imageUrl)): ?>
                                    <img src="<?= htmlspecialchars($imageUrl) ?>"
                                         alt="<?= htmlspecialchars($productName) ?>"
                                         class="w-24 h-24 rounded-xl object-cover border border-[#E5E7D8]">
                                <?php else: ?>
                                    <div class="w-24 h-24 rounded-xl bg-[#EEF1E7] flex items-center justify-center text-xs text-gray-500">
                                        No image
                                    </div>
                                <?php endif; ?>

                                <div class="flex-1">
                                    <p class="font-bold text-[#2F512A] text-lg">
                                        <?= htmlspecialchars($productName) ?>
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Mã biến thể: <?= htmlspecialchars($maBienThe) ?>
                                    </p>

                                    <?php if (!empty($variantText)): ?>
                                        <p class="text-sm text-gray-500">
                                            Phân loại: <?= htmlspecialchars($variantText) ?>
                                        </p>
                                    <?php endif; ?>

                                    <p class="text-sm text-gray-500">
                                        Số lượng: <?= $quantity ?>
                                    </p>
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
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-6 mb-6">
                <h2 class="text-2xl font-bold text-[#2F512A] mb-4">
                    Thông tin nhận hàng
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <p class="text-sm text-gray-500">Người nhận</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($receiverName ?: 'Chưa có thông tin') ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Số điện thoại</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($receiverPhone ?: 'Chưa có thông tin') ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Địa chỉ</p>
                        <p class="font-semibold">
                            <?= htmlspecialchars($receiverAddress ?: 'Chưa có thông tin') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <a href="?url=order/history"
                   class="px-5 py-3 rounded-xl border border-[#2F512A] text-[#2F512A] font-semibold">
                    Quay lại lịch sử
                </a>

                <a href="?url=product"
                   class="px-5 py-3 rounded-xl bg-[#2F512A] text-white font-semibold">
                    Tiếp tục mua sắm
                </a>
            </div>

        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>