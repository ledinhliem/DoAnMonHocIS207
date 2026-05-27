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

if (!function_exists('formatNumberVN')) {
    function formatNumberVN($value) {
        return number_format((float)$value, 0, ',', '.');
    }
}

if (!function_exists('formatDateVN')) {
    function formatDateVN($date) {
        $timestamp = !empty($date) ? strtotime((string)$date) : false;
        return $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
    }
}

if (!function_exists('orderStatusText')) {
    function orderStatusText($status) {
        $map = [
            '0' => 'Chờ xử lý',
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
            '0' => 'bg-amber-100 text-amber-800',
            '1' => 'bg-blue-100 text-blue-800',
            '2' => 'bg-indigo-100 text-indigo-800',
            '3' => 'bg-green-100 text-green-800',
            '4' => 'bg-red-100 text-red-800'
        ];
        return $map[(string)$status] ?? 'bg-surface-container-high text-on-surface-variant';
    }
}

if (!function_exists('stockStatusText')) {
    function stockStatusText($quantity, $threshold) {
        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            return 'Hết hàng';
        }
        return $quantity <= (int)$threshold ? 'Sắp hết' : 'Còn hàng';
    }
}

if (!function_exists('stockStatusClass')) {
    function stockStatusClass($quantity, $threshold) {
        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            return 'bg-red-100 text-red-700';
        }
        return $quantity <= (int)$threshold ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800';
    }
}

$stats = $stats ?? [];
$recentOrders = $recentOrders ?? [];
$lowStockItems = $lowStockItems ?? [];
$topSellingProducts = $topSellingProducts ?? [];
$revenueLast7Days = $revenueLast7Days ?? ['labels' => [], 'values' => [], 'total' => 0];
$orderStatusStats = $orderStatusStats ?? ['labels' => [], 'values' => [], 'total' => 0];
$inventoryStockStats = $inventoryStockStats ?? ['labels' => [], 'values' => [], 'total' => 0];
$status = $status ?? null;
$message = $message ?? '';

$lowStockThreshold = (int)($stats['lowStockThreshold'] ?? 5);
$completionRate = (int)($stats['completionRate'] ?? 0);

$kpiCards = [
    [
        'title' => 'Doanh thu hôm nay',
        'value' => formatMoneyVND($stats['todayRevenue'] ?? 0),
        'note' => 'Đơn hợp lệ trong ngày, không tính đơn hủy',
        'icon' => 'today',
        'tone' => 'bg-green-100 text-green-800'
    ],
    [
        'title' => 'Doanh thu tháng này',
        'value' => formatMoneyVND($stats['monthRevenue'] ?? 0),
        'note' => 'Từ đầu tháng, không tính đơn hủy',
        'icon' => 'calendar_month',
        'tone' => 'bg-emerald-100 text-emerald-800'
    ],
    [
        'title' => 'Tổng đơn hàng',
        'value' => formatNumberVN($stats['totalOrders'] ?? 0),
        'note' => 'Toàn bộ đơn trong hệ thống',
        'icon' => 'receipt_long',
        'tone' => 'bg-blue-100 text-blue-800'
    ],
    [
        'title' => 'Đơn chờ xử lý',
        'value' => formatNumberVN($stats['newOrders'] ?? 0),
        'note' => 'Trạng thái đơn = 0',
        'icon' => 'pending_actions',
        'tone' => 'bg-amber-100 text-amber-800'
    ],
    [
        'title' => 'Tỷ lệ hoàn thành',
        'value' => $completionRate . '%',
        'note' => 'Đơn hoàn thành / tổng đơn',
        'icon' => 'task_alt',
        'tone' => 'bg-lime-100 text-lime-800'
    ],
    [
        'title' => 'Sản phẩm đang bán',
        'value' => formatNumberVN($stats['activeProducts'] ?? 0),
        'note' => 'Sản phẩm đang hiển thị',
        'icon' => 'inventory_2',
        'tone' => 'bg-teal-100 text-teal-800'
    ],
    [
        'title' => 'Sắp hết hàng',
        'value' => formatNumberVN($stats['lowStockItems'] ?? 0),
        'note' => 'Biến thể tồn kho 1-' . $lowStockThreshold,
        'icon' => 'production_quantity_limits',
        'tone' => 'bg-orange-100 text-orange-800'
    ],
    [
        'title' => 'Hết hàng',
        'value' => formatNumberVN($stats['outOfStockItems'] ?? 0),
        'note' => 'Biến thể tồn kho = 0',
        'icon' => 'remove_shopping_cart',
        'tone' => 'bg-red-100 text-red-800'
    ],
];

$hasRevenueData = array_sum(array_map('floatval', $revenueLast7Days['values'] ?? [])) > 0;
$hasOrderStatusData = (int)($orderStatusStats['total'] ?? 0) > 0;
$hasInventoryData = (int)($inventoryStockStats['total'] ?? 0) > 0;

$chartPayload = [
    'revenue' => $revenueLast7Days,
    'orderStatus' => $orderStatusStats,
    'inventory' => $inventoryStockStats
];
?>

<main class="ml-64 min-h-screen bg-[#f7f8ef] p-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <header class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
            <div>
                <p class="text-xs font-black text-primary uppercase tracking-[0.22em]">Zentro Admin</p>
                <h1 class="font-headline text-4xl font-black text-primary mt-3">Bảng điều khiển</h1>
                <p class="text-on-surface-variant mt-2 max-w-2xl">
                    Tổng quan doanh thu, trạng thái đơn hàng và cảnh báo tồn kho từ dữ liệu thật của hệ thống.
                </p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="index.php?url=admin/orders" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white shadow-sm hover:opacity-90 transition">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                    Xem đơn hàng
                </a>
                <a href="index.php?url=admin/products" class="inline-flex items-center gap-2 rounded-xl bg-surface-container-high px-5 py-3 text-sm font-bold text-primary hover:bg-surface-container-highest transition">
                    <span class="material-symbols-outlined text-xl">eco</span>
                    Quản lý sản phẩm
                </a>
            </div>
        </header>

        <?php if (!empty($message)): ?>
            <div class="rounded-xl p-4 <?= $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <?php foreach ($kpiCards as $card): ?>
                <article class="rounded-2xl bg-white p-5 shadow-sm border border-outline-variant/20">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-on-surface-variant"><?= e($card['title']) ?></p>
                            <p class="font-headline text-3xl font-black text-primary mt-2 break-words"><?= e($card['value']) ?></p>
                        </div>
                        <div class="w-11 h-11 rounded-xl <?= e($card['tone']) ?> flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-xl"><?= e($card['icon']) ?></span>
                        </div>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-4"><?= e($card['note']) ?></p>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <article class="xl:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-outline-variant/20">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h2 class="font-headline text-2xl font-black text-primary">Doanh thu 7 ngày gần nhất</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Tính đơn hợp lệ, không tính đơn đã hủy.</p>
                    </div>
                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-800">
                        <?= formatMoneyVND($revenueLast7Days['total'] ?? 0) ?>
                    </span>
                </div>
                <div class="h-80 relative">
                    <canvas id="revenueChart" class="<?= $hasRevenueData ? '' : 'hidden' ?>"></canvas>
                    <?php if (!$hasRevenueData): ?>
                        <div class="absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                            <span class="material-symbols-outlined text-4xl text-primary">query_stats</span>
                            <p class="font-bold text-on-surface mt-3">Chưa có doanh thu 7 ngày gần nhất</p>
                            <p class="text-sm text-on-surface-variant mt-1">Biểu đồ vẫn giữ đủ 7 ngày với giá trị 0.</p>
                        </div>
                    <?php endif; ?>
                    <div data-chart-fallback class="hidden absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                        <span class="material-symbols-outlined text-4xl text-primary">wifi_off</span>
                        <p class="font-bold text-on-surface mt-3">Không tải được Chart.js</p>
                        <p class="text-sm text-on-surface-variant mt-1">KPI và bảng dữ liệu vẫn hiển thị bình thường.</p>
                    </div>
                </div>
            </article>

            <article class="rounded-2xl bg-white p-6 shadow-sm border border-outline-variant/20">
                <div class="mb-5">
                    <h2 class="font-headline text-2xl font-black text-primary">Trạng thái đơn hàng</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Phân bổ theo trạng thái hiện có.</p>
                </div>
                <div class="h-80 relative">
                    <canvas id="orderStatusChart" class="<?= $hasOrderStatusData ? '' : 'hidden' ?>"></canvas>
                    <?php if (!$hasOrderStatusData): ?>
                        <div class="absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                            <span class="material-symbols-outlined text-4xl text-primary">donut_large</span>
                            <p class="font-bold text-on-surface mt-3">Chưa có đơn hàng</p>
                            <p class="text-sm text-on-surface-variant mt-1">Biểu đồ sẽ xuất hiện khi có dữ liệu.</p>
                        </div>
                    <?php endif; ?>
                    <div data-chart-fallback class="hidden absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                        <span class="material-symbols-outlined text-4xl text-primary">wifi_off</span>
                        <p class="font-bold text-on-surface mt-3">Không tải được Chart.js</p>
                        <p class="text-sm text-on-surface-variant mt-1">KPI và bảng dữ liệu vẫn hiển thị bình thường.</p>
                    </div>
                </div>
            </article>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <article class="rounded-2xl bg-white p-6 shadow-sm border border-outline-variant/20">
                <div class="mb-5">
                    <h2 class="font-headline text-2xl font-black text-primary">Tồn kho theo nhóm</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Còn hàng, sắp hết và hết hàng.</p>
                </div>
                <div class="h-72 relative">
                    <canvas id="inventoryChart" class="<?= $hasInventoryData ? '' : 'hidden' ?>"></canvas>
                    <?php if (!$hasInventoryData): ?>
                        <div class="absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                            <span class="material-symbols-outlined text-4xl text-primary">inventory</span>
                            <p class="font-bold text-on-surface mt-3">Chưa có dữ liệu tồn kho</p>
                            <p class="text-sm text-on-surface-variant mt-1">Chưa tìm thấy biến thể để thống kê.</p>
                        </div>
                    <?php endif; ?>
                    <div data-chart-fallback class="hidden absolute inset-0 flex flex-col items-center justify-center rounded-xl bg-surface-container-low text-center p-6">
                        <span class="material-symbols-outlined text-4xl text-primary">wifi_off</span>
                        <p class="font-bold text-on-surface mt-3">Không tải được Chart.js</p>
                        <p class="text-sm text-on-surface-variant mt-1">KPI và bảng dữ liệu vẫn hiển thị bình thường.</p>
                    </div>
                </div>
            </article>

            <article class="xl:col-span-2 rounded-2xl bg-white shadow-sm border border-outline-variant/20 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-headline text-2xl font-black text-primary">Cảnh báo tồn kho thấp</h2>
                        <p class="text-sm text-on-surface-variant mt-1">5 biến thể có tồn kho thấp nhất.</p>
                    </div>
                    <a href="index.php?url=admin/products" class="text-primary font-bold text-sm hover:underline whitespace-nowrap">Đến sản phẩm</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[620px]">
                        <thead class="bg-surface-container">
                            <tr class="text-xs font-black uppercase tracking-widest text-on-surface-variant">
                                <th class="px-6 py-4">Mã</th>
                                <th class="px-6 py-4">Sản phẩm</th>
                                <th class="px-6 py-4">Phân loại</th>
                                <th class="px-6 py-4">Tồn</th>
                                <th class="px-6 py-4">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            <?php if (!empty($lowStockItems)): ?>
                                <?php foreach ($lowStockItems as $item): ?>
                                    <?php
                                        $stockQty = (int)($item['SoLuongTon'] ?? 0);
                                        $variantMeta = trim((string)($item['MauSac'] ?? '') . ' ' . (string)($item['KichThuoc'] ?? ''));
                                    ?>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="px-6 py-4 font-black text-primary"><?= e($item['MaBienThe'] ?? '') ?></td>
                                        <td class="px-6 py-4 font-bold max-w-[220px] truncate"><?= e($item['TenSanPham'] ?? $item['MaSanPham'] ?? '') ?></td>
                                        <td class="px-6 py-4 text-sm text-on-surface-variant"><?= e($variantMeta !== '' ? $variantMeta : '-') ?></td>
                                        <td class="px-6 py-4 font-black text-amber-700"><?= formatNumberVN($stockQty) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold <?= stockStatusClass($stockQty, $lowStockThreshold) ?>">
                                                <?= e(stockStatusText($stockQty, $lowStockThreshold)) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="font-bold text-on-surface">Kho đang ổn</p>
                                        <p class="text-sm text-on-surface-variant mt-1">Chưa có biến thể nào chạm ngưỡng cảnh báo.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <article class="xl:col-span-2 rounded-2xl bg-white shadow-sm border border-outline-variant/20 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-headline text-2xl font-black text-primary">Đơn hàng gần đây</h2>
                        <p class="text-sm text-on-surface-variant mt-1">5 đơn mới nhất trong hệ thống.</p>
                    </div>
                    <a href="index.php?url=admin/orders" class="text-primary font-bold text-sm hover:underline whitespace-nowrap">Xem tất cả</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[760px]">
                        <thead class="bg-surface-container">
                            <tr class="text-xs font-black uppercase tracking-widest text-on-surface-variant">
                                <th class="px-6 py-4">Mã đơn</th>
                                <th class="px-6 py-4">Khách hàng</th>
                                <th class="px-6 py-4">Ngày đặt</th>
                                <th class="px-6 py-4">Tổng tiền</th>
                                <th class="px-6 py-4">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            <?php if (!empty($recentOrders)): ?>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="px-6 py-4 font-black text-primary">#<?= e($order['MaDonHang'] ?? '') ?></td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-on-surface"><?= e(($order['TenNguoiNhan'] ?? '') ?: ($order['HoTen'] ?? 'Khách hàng')) ?></p>
                                            <p class="text-xs text-on-surface-variant"><?= e($order['Email'] ?? '') ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-on-surface-variant"><?= formatDateVN($order['NgayDat'] ?? '') ?></td>
                                        <td class="px-6 py-4 font-bold"><?= formatMoneyVND($order['ThanhTienCuoi'] ?? $order['TongTien'] ?? 0) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold <?= orderStatusClass($order['TrangThai'] ?? '') ?>">
                                                <?= e(orderStatusText($order['TrangThai'] ?? '')) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="font-bold text-on-surface">Chưa có đơn hàng</p>
                                        <p class="text-sm text-on-surface-variant mt-1">Khi có đơn mới, danh sách tóm tắt sẽ hiện tại đây.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-2xl bg-white shadow-sm border border-outline-variant/20 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/20">
                    <h2 class="font-headline text-2xl font-black text-primary">Top 5 sản phẩm bán chạy</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Theo số lượng trong đơn hợp lệ, không tính đơn hủy.</p>
                </div>
                <div class="p-6 space-y-4">
                    <?php if (!empty($topSellingProducts)): ?>
                        <?php foreach ($topSellingProducts as $index => $product): ?>
                            <div class="flex items-center gap-4 rounded-xl bg-surface-container-low p-4">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-black"><?= $index + 1 ?></div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-on-surface truncate"><?= e($product['TenSanPham'] ?? $product['MaSanPham'] ?? 'Sản phẩm') ?></p>
                                    <p class="text-xs text-on-surface-variant"><?= e($product['MaSanPham'] ?? '') ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-primary"><?= formatNumberVN($product['total_sold'] ?? 0) ?></p>
                                    <p class="text-xs text-on-surface-variant">đã bán</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-12 text-center">
                            <div class="w-14 h-14 mx-auto rounded-2xl bg-surface-container-high flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">leaderboard</span>
                            </div>
                            <p class="font-bold text-on-surface mt-4">Chưa có dữ liệu bán chạy</p>
                            <p class="text-sm text-on-surface-variant mt-1">Dữ liệu sẽ xuất hiện khi có đơn hoàn thành.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        </section>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dashboardCharts = <?= json_encode($chartPayload, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK) ?>;

    function formatVnd(value) {
        return new Intl.NumberFormat('vi-VN').format(Number(value || 0)) + ' đ';
    }

    function renderDashboardCharts() {
        if (!window.Chart) {
            document.querySelectorAll('[data-chart-fallback]').forEach((fallback) => {
                const canvas = fallback.parentElement.querySelector('canvas');
                if (canvas && !canvas.classList.contains('hidden')) {
                    fallback.classList.remove('hidden');
                }
            });
            document.querySelectorAll('canvas').forEach((canvas) => canvas.classList.add('hidden'));
            return;
        }

        Chart.defaults.font.family = 'Inter, Arial, sans-serif';
        Chart.defaults.color = '#66705f';

        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas && !revenueCanvas.classList.contains('hidden')) {
            new Chart(revenueCanvas, {
                type: 'line',
                data: {
                    labels: dashboardCharts.revenue.labels || [],
                    datasets: [{
                        label: 'Doanh thu',
                        data: dashboardCharts.revenue.values || [],
                        borderColor: '#35551f',
                        backgroundColor: 'rgba(53, 85, 31, 0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointBackgroundColor: '#35551f'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (context) => formatVnd(context.parsed.y)
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            ticks: { callback: (value) => formatVnd(value) }
                        }
                    }
                }
            });
        }

        const orderCanvas = document.getElementById('orderStatusChart');
        if (orderCanvas && !orderCanvas.classList.contains('hidden')) {
            new Chart(orderCanvas, {
                type: 'doughnut',
                data: {
                    labels: dashboardCharts.orderStatus.labels || [],
                    datasets: [{
                        data: dashboardCharts.orderStatus.values || [],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#6366f1', '#22c55e', '#ef4444', '#94a3b8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '66%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
                    }
                }
            });
        }

        const inventoryCanvas = document.getElementById('inventoryChart');
        if (inventoryCanvas && !inventoryCanvas.classList.contains('hidden')) {
            new Chart(inventoryCanvas, {
                type: 'bar',
                data: {
                    labels: dashboardCharts.inventory.labels || [],
                    datasets: [{
                        label: 'Biến thể',
                        data: dashboardCharts.inventory.values || [],
                        backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                        borderRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', renderDashboardCharts);
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
