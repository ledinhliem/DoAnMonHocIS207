<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
$base = defined('BASE_URL') ? BASE_URL : 'index.php'; 
$orders = $data['orders'] ?? [];

// Map số trong DB ra chữ cho người dùng hiểu
$statusMap = [
    '0' => ['text' => 'Chờ xử lý', 'color' => 'text-orange-600 bg-orange-50'],
    '1' => ['text' => 'Đã xác nhận', 'color' => 'text-blue-600 bg-blue-50'],
    '2' => ['text' => 'Đang giao', 'color' => 'text-indigo-600 bg-indigo-50'],
    '3' => ['text' => 'Hoàn thành', 'color' => 'text-green-600 bg-green-50'],
    '4' => ['text' => 'Đã hủy', 'color' => 'text-red-600 bg-red-50']
];
?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Lịch sử đơn hàng</h1>

    <?php if (empty($orders)): ?>
        <div class="bg-surface-container rounded-2xl p-8 text-on-surface-variant font-medium">
            Bạn chưa có đơn hàng nào trong lịch sử.
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($orders as $order): ?>
                <?php 
                    $st = $order['TrangThai'];
                    $statusText = $statusMap[$st]['text'] ?? 'Không rõ';
                    $statusColor = $statusMap[$st]['color'] ?? 'text-gray-600 bg-gray-50';
                ?>
                <div class="bg-white rounded-2xl border border-outline-variant/30 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="text-sm text-on-surface-variant uppercase tracking-wide">Mã đơn hàng</div>
                            <div class="font-bold text-primary"><?php echo htmlspecialchars($order['MaDonHang']); ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant uppercase tracking-wide">Ngày đặt</div>
                            <div class="font-medium"><?php echo date('d/m/Y', strtotime($order['NgayDat'])); ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant uppercase tracking-wide">Trạng thái</div>
                            <div class="font-medium">
                                <span class="<?php echo $statusColor; ?> px-3 py-1 rounded-md font-semibold text-sm">
                                    <?php echo $statusText; ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-on-surface-variant uppercase tracking-wide">Tổng tiền</div>
                            <div class="font-bold text-lg"><?php echo number_format($order['ThanhTienCuoi'], 0, ',', '.'); ?> ₫</div>
                        </div>
                        <div>
                            <a href="<?php echo $base; ?>?url=order/tracking&id=<?php echo $order['MaDonHang']; ?>" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-container text-white font-medium text-sm transition-colors block text-center shadow-sm">
                                Theo dõi đơn
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>