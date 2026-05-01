<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
$base = defined('BASE_URL') ? BASE_URL : 'index.php'; 
$order = $data['order'] ?? null;

$statusMap = [
    '0' => 'Chờ xử lý', '1' => 'Đã xác nhận', '2' => 'Đang giao', '3' => 'Hoàn thành', '4' => 'Đã hủy'
];
?>

<main class="max-w-4xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Theo dõi tiến trình</h1>

    <?php if (empty($order)): ?>
        <div class="bg-surface-container rounded-2xl p-8 text-on-surface-variant font-medium">
            Không tìm thấy thông tin đơn hàng này hoặc bạn không có quyền xem.
        </div>
    <?php else: ?>
        <?php $st = (int)$order['TrangThai']; ?>
        <div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-outline-variant/20 pb-8">
                <div>
                    <div class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Mã đơn hàng</div>
                    <div class="text-xl font-bold text-primary"><?php echo htmlspecialchars($order['MaDonHang']); ?></div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Trạng thái</div>
                    <div class="text-xl font-bold"><?php echo $statusMap[$order['TrangThai']] ?? 'Không rõ'; ?></div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Ngày đặt hàng</div>
                    <div class="font-medium text-on-surface text-lg"><?php echo date('d/m/Y H:i', strtotime($order['NgayDat'])); ?></div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Địa chỉ nhận hàng</div>
                    <div class="font-medium text-on-surface text-lg"><?php echo htmlspecialchars($order['DiaChiGiaoHang']); ?></div>
                </div>
            </div>

            <div class="rounded-2xl bg-surface-container-lowest border border-outline-variant/10 p-6">
                <div class="font-bold text-lg mb-4 text-primary uppercase tracking-widest text-sm">Timeline Giao Hàng</div>
                
                <?php if ($st == 4): ?>
                    <div class="text-red-600 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined">cancel</span> Đơn hàng này đã bị hủy.
                    </div>
                <?php else: ?>
                    <ul class="space-y-4 font-medium text-on-surface-variant">
                        <li class="flex items-center gap-3 <?php echo ($st >= 0) ? 'text-primary' : ''; ?>">
                            <span class="material-symbols-outlined">check_circle</span>
                            Đã đặt hàng & Chờ xử lý
                        </li>
                        <li class="flex items-center gap-3 <?php echo ($st >= 1) ? 'text-primary' : ''; ?>">
                            <span class="material-symbols-outlined"><?php echo ($st >= 1) ? 'check_circle' : 'radio_button_unchecked'; ?></span>
                            Đã xác nhận & Đang đóng gói
                        </li>
                        <li class="flex items-center gap-3 <?php echo ($st >= 2) ? 'text-primary' : ''; ?>">
                            <span class="material-symbols-outlined"><?php echo ($st >= 2) ? 'local_shipping' : 'radio_button_unchecked'; ?></span>
                            Đơn hàng đang được giao
                        </li>
                        <li class="flex items-center gap-3 <?php echo ($st == 3) ? 'text-green-600' : ''; ?>">
                            <span class="material-symbols-outlined"><?php echo ($st == 3) ? 'task_alt' : 'radio_button_unchecked'; ?></span>
                            Giao hàng thành công
                        </li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?php echo $base; ?>?url=order/history" class="px-6 py-3 rounded-xl border-2 border-outline-variant font-semibold hover:bg-surface-container transition-colors text-on-surface">
                    Quay lại lịch sử
                </a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>