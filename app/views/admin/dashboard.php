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

$stats = $stats ?? [];
$recentOrders = $recentOrders ?? [];
$status = $status ?? null;
$message = $message ?? '';

$totalRevenue = $stats['totalRevenue'] ?? 0;
$totalOrders = $stats['totalOrders'] ?? 0;
$newOrders = $stats['newOrders'] ?? 0;
$totalUsers = $stats['totalUsers'] ?? 0;
$completedOrders = $stats['completedOrders'] ?? 0;
$cancelledOrders = $stats['cancelledOrders'] ?? 0;
$preparingOrders = $stats['preparingOrders'] ?? 0;
$shippingOrders = $stats['shippingOrders'] ?? 0;
?>

<main class="ml-64 min-h-screen bg-surface p-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-widest">Admin Dashboard</p>
                <h1 class="font-headline text-4xl font-black text-on-surface mt-2">
                    Bảng điều khiển
                </h1>
                <p class="text-on-surface-variant mt-2">
                    Tổng quan doanh thu, đơn hàng mới và tình trạng xử lý đơn.
                </p>
            </div>

            <a
                href="index.php?url=admin/orders"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-opacity"
            >
                <span class="material-symbols-outlined">receipt_long</span>
                Quản lý đơn hàng
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="rounded-xl p-4 <?= $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-on-surface-variant font-medium">Tổng doanh thu</p>
                        <h2 class="font-headline text-3xl font-black text-primary mt-2">
                            <?= formatMoneyVND($totalRevenue) ?>
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant mt-4">
                    Tính theo đơn hoàn thành, trạng thái = 3.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-on-surface-variant font-medium">Tổng đơn hàng</p>
                        <h2 class="font-headline text-3xl font-black text-primary mt-2">
                            <?= (int)$totalOrders ?>
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                        <span class="material-symbols-outlined">shopping_basket</span>
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant mt-4">
                    Toàn bộ đơn trong bảng donhang.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-on-surface-variant font-medium">Đơn mới</p>
                        <h2 class="font-headline text-3xl font-black text-primary mt-2">
                            <?= (int)$newOrders ?>
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-700 flex items-center justify-center">
                        <span class="material-symbols-outlined">notifications_active</span>
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant mt-4">
                    Đơn có trạng thái = 0, cần xác nhận.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-on-surface-variant font-medium">Tổng user</p>
                        <h2 class="font-headline text-3xl font-black text-primary mt-2">
                            <?= (int)$totalUsers ?>
                        </h2>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant mt-4">
                    Tổng tài khoản trong bảng nguoidung.
                </p>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">Chờ xác nhận</p>
                <p class="text-3xl font-black font-headline text-yellow-700 mt-2"><?= (int)$newOrders ?></p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">Đang chuẩn bị</p>
                <p class="text-3xl font-black font-headline text-blue-700 mt-2"><?= (int)$preparingOrders ?></p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">Đang giao</p>
                <p class="text-3xl font-black font-headline text-purple-700 mt-2"><?= (int)$shippingOrders ?></p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <p class="text-sm text-on-surface-variant">Hoàn thành / Hủy</p>
                <p class="text-3xl font-black font-headline text-primary mt-2">
                    <?= (int)$completedOrders ?> / <?= (int)$cancelledOrders ?>
                </p>
            </div>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between">
                <div>
                    <h2 class="font-headline text-2xl font-black text-on-surface">Đơn hàng gần đây</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Hiển thị 5 đơn mới nhất.</p>
                </div>
                <a href="index.php?url=admin/orders" class="text-primary font-bold text-sm hover:underline">
                    Xem tất cả
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Mã đơn</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Khách hàng</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Ngày đặt</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Tổng tiền</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Trạng thái</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        <?php if (!empty($recentOrders)): ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-6 py-4 font-bold text-primary">
                                        #<?= e($order['MaDonHang']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-on-surface"><?= e($order['TenNguoiNhan'] ?: $order['HoTen'] ?: '—') ?></p>
                                        <p class="text-xs text-on-surface-variant"><?= e($order['Email'] ?? '') ?></p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-on-surface-variant">
                                        <?= formatDateVN($order['NgayDat']) ?>
                                    </td>
                                    <td class="px-6 py-4 font-bold">
                                        <?= formatMoneyVND($order['ThanhTienCuoi']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= orderStatusClass($order['TrangThai']) ?>">
                                            <?= orderStatusText($order['TrangThai']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href="index.php?url=admin/orders/detail&id=<?= urlencode($order['MaDonHang']) ?>"
                                            class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline"
                                        >
                                            Chi tiết
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                    Chưa có đơn hàng nào.
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