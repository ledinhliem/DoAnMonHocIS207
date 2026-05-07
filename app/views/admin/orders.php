<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('formatMoneyVND')) {
    function formatMoneyVND($value) {
        return number_format((float)$value, 0, ',', '.') . ' đ';
    }
}

if (!function_exists('formatDateVN')) {
    function formatDateVN($date) {
        if (empty($date)) return '—';
        return date('d/m/Y H:i', strtotime($date));
    }
}

if (!function_exists('orderStatusText')) {
    function orderStatusText($status) {
        $map = [
            '0' => 'Chờ xác nhận',
            '1' => 'Đang chuẩn bị',
            '2' => 'Đang giao',
            '3' => 'Hoàn thành',
            '4' => 'Đã hủy'
        ];

        return $map[(string)$status] ?? 'Không rõ';
    }
}

if (!function_exists('orderStatusClass')) {
    function orderStatusClass($status) {
        $map = [
            '0' => 'bg-yellow-100 text-yellow-800',
            '1' => 'bg-blue-100 text-blue-800',
            '2' => 'bg-purple-100 text-purple-800',
            '3' => 'bg-green-100 text-green-800',
            '4' => 'bg-red-100 text-red-800'
        ];

        return $map[(string)$status] ?? 'bg-gray-100 text-gray-700';
    }
}

if (!function_exists('nextOrderStatus')) {
    function nextOrderStatus($status) {
        $status = (string)$status;

        $nextMap = [
            '0' => '1',
            '1' => '2',
            '2' => '3'
        ];

        return $nextMap[$status] ?? null;
    }
}

$orders = $orders ?? [];
$stats = $stats ?? [];
$keyword = $keyword ?? '';
$filterStatus = $filterStatus ?? '';
$status = $status ?? null;
$message = $message ?? '';
?>

<main class="ml-64 min-h-screen bg-surface p-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-widest">Admin Orders</p>
                <h1 class="font-headline text-4xl font-black text-on-surface mt-2">
                    Quản lý đơn hàng
                </h1>
                <p class="text-on-surface-variant mt-2">
                    Xem danh sách đơn, cập nhật trạng thái và hủy đơn có hoàn kho.
                </p>
            </div>

            <a
                href="index.php?url=admin/dashboard"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-surface-container text-primary rounded-xl font-bold hover:bg-surface-variant transition-colors"
            >
                <span class="material-symbols-outlined">dashboard</span>
                Về dashboard
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="rounded-xl p-4 <?= $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Tổng đơn</p>
                <p class="font-headline text-3xl font-black text-primary mt-2"><?= (int)($stats['totalOrders'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Chờ xác nhận</p>
                <p class="font-headline text-3xl font-black text-yellow-700 mt-2"><?= (int)($stats['newOrders'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Đang giao</p>
                <p class="font-headline text-3xl font-black text-purple-700 mt-2"><?= (int)($stats['shippingOrders'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Hoàn thành</p>
                <p class="font-headline text-3xl font-black text-green-700 mt-2"><?= (int)($stats['completedOrders'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Đã hủy</p>
                <p class="font-headline text-3xl font-black text-red-700 mt-2"><?= (int)($stats['cancelledOrders'] ?? 0) ?></p>
            </div>
        </section>

        <section class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
            <form method="GET" action="index.php" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <input type="hidden" name="url" value="admin/orders">

                <div class="md:col-span-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        Tìm kiếm
                    </label>
                    <input
                        type="text"
                        name="keyword"
                        value="<?= e($keyword) ?>"
                        placeholder="Nhập mã đơn, tên khách, email, SĐT..."
                        class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary"
                    >
                </div>

                <div class="md:col-span-4">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        Trạng thái
                    </label>
                    <select
                        name="status"
                        class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary"
                    >
                        <option value="">Tất cả trạng thái</option>
                        <option value="0" <?= $filterStatus === '0' ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="1" <?= $filterStatus === '1' ? 'selected' : '' ?>>Đang chuẩn bị</option>
                        <option value="2" <?= $filterStatus === '2' ? 'selected' : '' ?>>Đang giao</option>
                        <option value="3" <?= $filterStatus === '3' ? 'selected' : '' ?>>Hoàn thành</option>
                        <option value="4" <?= $filterStatus === '4' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button
                        type="submit"
                        class="w-full px-5 py-3 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-opacity"
                    >
                        Lọc
                    </button>
                </div>
            </form>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/20">
                <h2 class="font-headline text-2xl font-black text-on-surface">Danh sách đơn hàng</h2>
                <p class="text-sm text-on-surface-variant mt-1">
                    Có <?= count($orders) ?> đơn đang hiển thị.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Mã đơn</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Khách hàng</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Ngày đặt</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">SL SP</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Tổng thanh toán</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Trạng thái</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant text-right">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-outline-variant/20">
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <?php
                                $currentStatus = (string)$order['TrangThai'];
                                $nextStatus = nextOrderStatus($currentStatus);
                                ?>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-6 py-4">
                                        <a
                                            href="index.php?url=admin/orders/detail&id=<?= urlencode($order['MaDonHang']) ?>"
                                            class="font-black text-primary hover:underline"
                                        >
                                            #<?= e($order['MaDonHang']) ?>
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-bold text-on-surface">
                                            <?= e($order['TenNguoiNhan'] ?: $order['HoTen'] ?: '—') ?>
                                        </p>
                                        <p class="text-xs text-on-surface-variant">
                                            <?= e($order['SDTNguoiNhan'] ?: $order['SoDienThoai'] ?: '') ?>
                                        </p>
                                        <p class="text-xs text-on-surface-variant">
                                            <?= e($order['Email'] ?? '') ?>
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-on-surface-variant">
                                        <?= formatDateVN($order['NgayDat']) ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-bold"><?= (int)$order['TongSoLuong'] ?></p>
                                        <p class="text-xs text-on-surface-variant">
                                            <?= (int)$order['TongLoaiSanPham'] ?> loại
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 font-black">
                                        <?= formatMoneyVND($order['ThanhTienCuoi']) ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= orderStatusClass($currentStatus) ?>">
                                            <?= orderStatusText($currentStatus) ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            <a
                                                href="index.php?url=admin/orders/detail&id=<?= urlencode($order['MaDonHang']) ?>"
                                                class="px-3 py-2 rounded-lg bg-surface-container text-primary font-bold text-xs hover:bg-surface-variant transition-colors"
                                            >
                                                Chi tiết
                                            </a>

                                            <?php if ($nextStatus !== null): ?>
                                                <form method="POST" action="index.php?url=admin/orders/update-status">
                                                    <input type="hidden" name="order_id" value="<?= e($order['MaDonHang']) ?>">
                                                    <input type="hidden" name="new_status" value="<?= e($nextStatus) ?>">
                                                    <input type="hidden" name="redirect" value="orders">
                                                    <button
                                                        type="submit"
                                                        class="px-3 py-2 rounded-lg bg-primary text-white font-bold text-xs hover:opacity-90 transition-opacity"
                                                    >
                                                        Chuyển sang: <?= orderStatusText($nextStatus) ?>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($currentStatus !== '3' && $currentStatus !== '4'): ?>
                                                <form
                                                    method="POST"
                                                    action="index.php?url=admin/orders/update-status"
                                                    onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn <?= e($order['MaDonHang']) ?>? Hủy đơn sẽ hoàn kho tự động.');"
                                                >
                                                    <input type="hidden" name="order_id" value="<?= e($order['MaDonHang']) ?>">
                                                    <input type="hidden" name="new_status" value="4">
                                                    <input type="hidden" name="redirect" value="orders">
                                                    <button
                                                        type="submit"
                                                        class="px-3 py-2 rounded-lg bg-red-600 text-white font-bold text-xs hover:bg-red-700 transition-colors"
                                                    >
                                                        Hủy đơn
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-3xl">search_off</span>
                                    </div>
                                    <h3 class="font-headline text-2xl font-black text-on-surface mb-2">
                                        Không tìm thấy đơn hàng
                                    </h3>
                                    <p class="text-on-surface-variant">
                                        Thử đổi từ khóa tìm kiếm hoặc bộ lọc trạng thái.
                                    </p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>