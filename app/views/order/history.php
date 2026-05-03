<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-6xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-10">
            Lịch sử đơn hàng
        </h1>

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
                                            $maBienThe = $item['MaBienThe'] ?? '';
                                            $variantText = trim(($item['KichThuoc'] ?? '') . ' ' . ($item['MauSac'] ?? ''));
                                            $quantity = (int)($item['SoLuong'] ?? 0);
                                            $price = (float)($item['DonGia'] ?? 0);
                                            $image = $item['HinhAnh'] ?? '';
                                            $imageUrl = !empty($image)
                                                ? BASE_URL . 'public/images/products/' . basename($image)
                                                : '';
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

                                                <p class="text-sm text-gray-500">
                                                    Mã: <?= htmlspecialchars($maBienThe) ?>
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
                            </div>
                        <?php endif; ?>

                        <div class="mt-5">
                            <a href="?url=order/tracking&id=<?= urlencode($orderId) ?>"
                               class="inline-block px-5 py-3 rounded-xl border border-[#2F512A] text-[#2F512A] font-semibold">
                                Theo dõi đơn
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>