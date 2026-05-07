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

$order = $order ?? [];
$items = $items ?? [];
$status = $status ?? null;
$message = $message ?? '';

$currentStatus = (string)($order['TrangThai'] ?? '');
$nextStatus = nextOrderStatus($currentStatus);
?>

<main class="ml-64 min-h-screen bg-surface p-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-widest">Order Detail</p>
                <h1 class="font-headline text-4xl font-black text-on-surface mt-2">
                    Chi tiết đơn hàng #<?= e($order['MaDonHang'] ?? '') ?>
                </h1>
                <p class="text-on-surface-variant mt-2">
                    Xem thông tin đơn, sản phẩm, thanh toán, vận chuyển và cập nhật trạng thái.
                </p>
            </div>

            <a
                href="index.php?url=admin/orders"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-surface-container text-primary rounded-xl font-bold hover:bg-surface-variant transition-colors"
            >
                <span class="material-symbols-outlined">arrow_back</span>
                Quay lại đơn hàng
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="rounded-xl p-4 <?= $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="font-headline text-2xl font-black text-on-surface">
                            Thông tin đơn hàng
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-1">
                            Ngày đặt: <?= formatDateVN($order['NgayDat'] ?? '') ?>
                        </p>
                    </div>

                    <span class="inline-flex w-fit px-4 py-2 rounded-full text-sm font-bold <?= orderStatusClass($currentStatus) ?>">
                        <?= orderStatusText($currentStatus) ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Mã đơn</p>
                        <p class="font-bold text-on-surface">#<?= e($order['MaDonHang'] ?? '') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Mã user</p>
                        <p class="font-bold text-on-surface"><?= e($order['MaNguoiDung'] ?? '—') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Người nhận</p>
                        <p class="font-bold text-on-surface"><?= e($order['TenNguoiNhan'] ?: $order['HoTen'] ?: '—') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Số điện thoại</p>
                        <p class="font-bold text-on-surface"><?= e($order['SDTNguoiNhan'] ?: $order['SoDienThoai'] ?: '—') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4 md:col-span-2">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Địa chỉ giao hàng</p>
                        <p class="font-bold text-on-surface"><?= e($order['DiaChiGiaoHang'] ?? '—') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Thanh toán</p>
                        <p class="font-bold text-on-surface"><?= e($order['TenPTTT'] ?? 'Chưa có') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Vận chuyển</p>
                        <p class="font-bold text-on-surface"><?= e($order['TenPTVC'] ?? 'Chưa có') ?></p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Mã giảm giá</p>
                        <p class="font-bold text-on-surface">
                            <?= e($order['MaCode'] ?? 'Không dùng') ?>
                            <?php if (!empty($order['PhamTramGiam'])): ?>
                                <span class="text-xs text-primary">(<?= (int)$order['PhamTramGiam'] ?>%)</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs uppercase font-bold text-on-surface-variant mb-1">Email user</p>
                        <p class="font-bold text-on-surface"><?= e($order['Email'] ?? '—') ?></p>
                    </div>
                </div>
            </div>

            <aside class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20 h-fit">
                <h2 class="font-headline text-2xl font-black text-on-surface mb-6">
                    Cập nhật trạng thái
                </h2>

                <div class="space-y-3">
                    <?php if ($nextStatus !== null): ?>
                        <form method="POST" action="index.php?url=admin/orders/update-status">
                            <input type="hidden" name="order_id" value="<?= e($order['MaDonHang'] ?? '') ?>">
                            <input type="hidden" name="new_status" value="<?= e($nextStatus) ?>">
                            <input type="hidden" name="redirect" value="detail">

                            <button
                                type="submit"
                                class="w-full px-5 py-3 bg-primary text-white rounded-xl font-bold hover:opacity-90 transition-opacity"
                            >
                                Chuyển sang: <?= orderStatusText($nextStatus) ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($currentStatus !== '3' && $currentStatus !== '4'): ?>
                        <form
                            method="POST"
                            action="index.php?url=admin/orders/update-status"
                            onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này? Hủy đơn sẽ hoàn kho tự động.');"
                        >
                            <input type="hidden" name="order_id" value="<?= e($order['MaDonHang'] ?? '') ?>">
                            <input type="hidden" name="new_status" value="4">
                            <input type="hidden" name="redirect" value="detail">

                            <button
                                type="submit"
                                class="w-full px-5 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors"
                            >
                                Hủy đơn và hoàn kho
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($currentStatus === '3'): ?>
                        <div class="rounded-xl bg-green-100 text-green-800 p-4 text-sm font-semibold">
                            Đơn đã hoàn thành, không cần cập nhật thêm.
                        </div>
                    <?php endif; ?>

                    <?php if ($currentStatus === '4'): ?>
                        <div class="rounded-xl bg-red-100 text-red-800 p-4 text-sm font-semibold">
                            Đơn đã hủy. Hệ thống đã chặn cập nhật tiếp để tránh hoàn kho lặp.
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/20">
                <h2 class="font-headline text-2xl font-black text-on-surface">Sản phẩm trong đơn</h2>
                <p class="text-sm text-on-surface-variant mt-1">
                    Dữ liệu từ bảng chitietdonhang, bienthesanpham và sanpham.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Sản phẩm</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Biến thể</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Số lượng</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Đơn giá</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Thành tiền</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-on-surface-variant">Tồn hiện tại</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-outline-variant/20">
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <?php
                                $image = $item['HinhAnh'] ?? '';
                                $imageSrc = $image !== '' ? 'public/images/Products/' . $image : '';
                                $lineTotal = (float)$item['SoLuong'] * (float)$item['DonGia'];
                                ?>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 rounded-xl bg-surface-container overflow-hidden flex items-center justify-center">
                                                <?php if ($imageSrc !== ''): ?>
                                                    <img src="<?= e($imageSrc) ?>" alt="<?= e($item['TenSanPham'] ?? '') ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <span class="material-symbols-outlined text-on-surface-variant">image</span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <p class="font-bold text-on-surface">
                                                    <?= e($item['TenSanPham'] ?? 'Sản phẩm không rõ') ?>
                                                </p>
                                                <p class="text-xs text-on-surface-variant">
                                                    Mã SP: <?= e($item['MaSanPham'] ?? '—') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-bold text-primary"><?= e($item['MaBienThe'] ?? '') ?></p>
                                        <p class="text-xs text-on-surface-variant">
                                            Size: <?= e($item['KichThuoc'] ?? '—') ?>
                                        </p>
                                        <p class="text-xs text-on-surface-variant">
                                            Màu: <?= e($item['MauSac'] ?? '—') ?>
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 font-bold">
                                        <?= (int)$item['SoLuong'] ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?= formatMoneyVND($item['DonGia']) ?>
                                    </td>

                                    <td class="px-6 py-4 font-black">
                                        <?= formatMoneyVND($lineTotal) ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-surface-container text-on-surface">
                                            <?= (int)($item['SoLuongTon'] ?? 0) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                    Đơn hàng chưa có chi tiết sản phẩm.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-start-3 bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                <h2 class="font-headline text-2xl font-black text-on-surface mb-6">
                    Tổng kết thanh toán
                </h2>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-on-surface-variant">Tạm tính</span>
                        <span class="font-bold"><?= formatMoneyVND($order['TongTien'] ?? 0) ?></span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-on-surface-variant">Phí vận chuyển</span>
                        <span class="font-bold"><?= formatMoneyVND($order['PhiVanChuyen'] ?? 0) ?></span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-on-surface-variant">Giảm giá</span>
                        <span class="font-bold text-red-600">-<?= formatMoneyVND($order['SoTienGiam'] ?? 0) ?></span>
                    </div>

                    <div class="border-t border-outline-variant/20 pt-4 flex justify-between">
                        <span class="font-black text-on-surface">Thành tiền cuối</span>
                        <span class="font-headline text-2xl font-black text-primary">
                            <?= formatMoneyVND($order['ThanhTienCuoi'] ?? 0) ?>
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>