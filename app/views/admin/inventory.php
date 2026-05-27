<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
// ── Helper functions phải định nghĩa TRƯỚC khi dùng ──────────────────────────
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('inventoryValue')) {
    function inventoryValue($item, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($item[$key]) && $item[$key] !== '') {
                return $item[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('inventoryStatusBadge')) {
    function inventoryStatusBadge($status) {
        $status = strtolower(trim((string)$status));
        switch ($status) {
            case 'verified':
            case 'completed':
            case 'approved':
                return 'bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            case 'pending':
            case 'in_review':
                return 'bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            case 'cancelled':
            case 'rejected':
                return 'bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            default:
                return 'bg-surface-container-high text-on-surface-variant text-[10px] font-bold px-2 py-1 rounded-md uppercase';
        }
    }
}

if (!function_exists('formatMoneyVND')) {
    function formatMoneyVND($value) {
        if (!is_numeric($value)) return e($value);
        return number_format((float)$value, 0, ',', '.') . ' đ';
    }
}
// ─────────────────────────────────────────────────────────────────────────────

$keyword = $_GET['keyword'] ?? '';
$selectedStatus = $filterStatus ?? ($_GET['status'] ?? '');

// Nhận dữ liệu thật từ AdminController
$inventoryList = [];
if (isset($inventory) && is_array($inventory)) {
    $inventoryList = $inventory;         // bienthesanpham + TenSanPham
} elseif (isset($data['inventory']) && is_array($data['inventory'])) {
    $inventoryList = $data['inventory'];
}

$supplierList = [];
if (isset($suppliers) && is_array($suppliers)) {
    $supplierList = $suppliers;
} elseif (isset($data['suppliers']) && is_array($data['suppliers'])) {
    $supplierList = $data['suppliers'];
}

$receiptList = [];
if (isset($entries) && is_array($entries)) {
    $receiptList = $entries;             // phieunhap + TenNCC
} elseif (isset($data['entries']) && is_array($data['entries'])) {
    $receiptList = $data['entries'];
}

// Thông báo flash từ controller
$flashStatus  = $status ?? null;
$flashMessage = $message ?? '';

// Tính thống kê tồn kho từ bienthesanpham
$totalVariants    = count($inventoryList);
$lowStockCount    = 0;
$outOfStockCount  = 0;
$totalUnits       = 0;

foreach ($inventoryList as $item) {
    $qty = (int) inventoryValue($item, ['SoLuongTon', 'so_luong_ton'], 0);
    $totalUnits += $qty;
    if ($qty === 0)      $outOfStockCount++;
    elseif ($qty <= 5)   $lowStockCount++;
}

// Giữ backward compat cho stats block dưới
$totalEntries        = count($receiptList);
$totalSuppliers      = count($supplierList);
$verifiedCount       = 0;
$pendingCount        = $lowStockCount;
$totalInventoryValue = 0;
foreach ($receiptList as $r) {
    $v = inventoryValue($r, ['TongTienNhap', 'total_value'], 0);
    if (is_numeric($v)) $totalInventoryValue += (float)$v;
}

if (!function_exists('formatMoneyVND')) {
    function formatMoneyVND($value) {
        if (!is_numeric($value)) return e($value);
        return number_format((float)$value, 0, ',', '.') . ' đ';
    }
}

$totalEntries = count($receiptList);
$totalSuppliers = count($supplierList);
?>


<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="ml-64 p-8 min-h-screen">

    <?php if (!empty($flashStatus)): ?>
    <div class="mb-8 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3
        <?= $flashStatus === 'success' ? 'bg-green-100 text-green-800' : ($flashStatus === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
        <span class="material-symbols-outlined">
            <?= $flashStatus === 'success' ? 'check_circle' : ($flashStatus === 'warning' ? 'warning' : 'error') ?>
        </span>
        <?= e($flashMessage) ?>
    </div>
    <?php endif; ?>

    <header class="flex flex-col xl:flex-row justify-between gap-6 xl:items-end mb-12">
        <div>
            <h2 class="text-4xl font-extrabold font-headline tracking-tight text-primary">Quản lý kho</h2>
            <p class="text-on-surface-variant mt-2 max-w-lg">
                Quản lý tồn kho, nhập kho và thông tin nhà cung cấp từ một nơi.
            </p>
        </div>
        <div class="flex gap-4 flex-wrap">
            <form method="GET" action="<?= BASE_URL ?>index.php" class="flex gap-3 flex-wrap">
                <input type="hidden" name="url" value="admin/inventory">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="keyword"
                        value="<?= e($keyword) ?>"
                        placeholder="Tìm sản phẩm, màu sắc hoặc kích thước..."
                        class="bg-surface-container-high border-none rounded-xl pl-10 pr-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all"
                    />
                </div>

                <select name="status" class="bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                    <option value="">Tất cả trạng thái</option>
                    <option value="in_stock" <?= $selectedStatus === 'in_stock' ? 'selected' : '' ?>>Còn hàng</option>
                    <option value="low_stock" <?= $selectedStatus === 'low_stock' ? 'selected' : '' ?>>Sắp hết</option>
                    <option value="out_of_stock" <?= $selectedStatus === 'out_of_stock' ? 'selected' : '' ?>>Hết hàng</option>
                </select>

                <button class="bg-surface-container-high px-6 py-3 rounded-xl font-bold text-primary flex items-center gap-2 hover:bg-surface-container-highest transition-colors" type="submit">
                    <span class="material-symbols-outlined text-xl">filter_list</span>
                    Bộ lọc
                </button>
            </form>

            <a href="#import-form"
               class="bg-secondary-container text-on-secondary-container px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-sm">
                <span class="material-symbols-outlined text-xl">add</span>
                Thêm phiếu nhập
            </a>
        </div>
    </header>

    <!-- Stats -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Tổng biến thể</p>
            <p class="text-3xl font-black text-primary"><?= number_format($totalVariants) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Tổng đơn vị tồn</p>
            <p class="text-3xl font-black text-primary"><?= number_format($totalUnits) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Sắp hết hàng (≤5)</p>
            <p class="text-3xl font-black <?= $lowStockCount > 0 ? 'text-yellow-600' : 'text-primary' ?>"><?= number_format($lowStockCount) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Hết hàng</p>
            <p class="text-3xl font-black <?= $outOfStockCount > 0 ? 'text-red-600' : 'text-primary' ?>"><?= number_format($outOfStockCount) ?></p>
        </div>
    </section>

    <!-- Bảng tồn kho biến thể thật -->
    <section class="mb-12">
        <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
            <h3 class="text-xl font-bold font-headline text-primary flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined">inventory_2</span>
                Tồn kho theo biến thể sản phẩm
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">
                            <th class="pb-2 px-3">Mã biến thể</th>
                            <th class="pb-2 px-3">Sản phẩm</th>
                            <th class="pb-2 px-3">Màu sắc</th>
                            <th class="pb-2 px-3">Kích thước</th>
                            <th class="pb-2 px-3">Giá (đ)</th>
                            <th class="pb-2 px-3">Tồn kho</th>
                            <th class="pb-2 px-3">Trạng thái</th>
                            <th class="pb-2 px-3">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($inventoryList)): ?>
                        <?php foreach ($inventoryList as $item):
                            $maBienThe  = inventoryValue($item, ['MaBienThe'], '—');
                            $tenSP      = inventoryValue($item, ['TenSanPham'], '—');
                            $mauSac     = inventoryValue($item, ['MauSac'], '—');
                            $kichThuoc  = inventoryValue($item, ['KichThuoc'], '—');
                            $giaTien    = inventoryValue($item, ['GiaTien'], 0);
                            $soLuong    = (int) inventoryValue($item, ['SoLuongTon'], 0);
                            $stockClass = $soLuong === 0
                                ? 'bg-red-100 text-red-700'
                                : ($soLuong <= 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-800');
                            $stockLabel = $soLuong === 0 ? 'Hết hàng' : ($soLuong <= 5 ? 'Sắp hết' : 'Còn hàng');
                        ?>
                        <tr class="bg-surface-container-low/40 hover:bg-surface-container-low transition-colors group"
                            id="row-<?= e($maBienThe) ?>">
                            <td class="py-3 px-3 rounded-l-xl font-bold text-primary text-sm"><?= e($maBienThe) ?></td>
                            <td class="py-3 px-3 text-sm font-medium max-w-[200px] truncate"><?= e($tenSP) ?></td>
                            <td class="py-3 px-3 text-sm"><?= e($mauSac) ?></td>
                            <td class="py-3 px-3 text-sm"><?= e($kichThuoc) ?></td>
                            <td class="py-3 px-3 text-sm font-bold"><?= formatMoneyVND($giaTien) ?></td>
                            <td class="py-3 px-3 text-sm font-black text-primary"><?= $soLuong ?></td>
                            <td class="py-3 px-3">
                                <span class="text-[10px] font-bold px-2 py-1 rounded-md uppercase <?= $stockClass ?>">
                                    <?= $stockLabel ?>
                                </span>
                            </td>
                            <td class="py-3 px-3 rounded-r-xl">
                                <div class="flex gap-2 items-center">
                                    <!-- Inline edit tồn kho -->
                                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/inventory"
                                          class="flex items-center gap-2">
                                        <input type="hidden" name="action" value="update_stock">
                                        <input type="hidden" name="ma_bien_the" value="<?= e($maBienThe) ?>">
                                        <input type="number" name="so_luong_ton" value="<?= $soLuong ?>" min="0"
                                               class="w-20 bg-surface-container-high border-none rounded-lg px-2 py-1 text-sm text-center focus:ring-1 focus:ring-primary/30"/>
                                        <button type="submit"
                                                class="text-primary text-xs font-bold hover:underline">Lưu</button>
                                    </form>
                                    <!-- Xóa biến thể -->
                                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/inventory"
                                          onsubmit="return confirm('Xóa biến thể <?= e($maBienThe) ?>?')">
                                        <input type="hidden" name="action" value="delete_variant">
                                        <input type="hidden" name="ma_bien_the" value="<?= e($maBienThe) ?>">
                                        <button type="submit"
                                                class="text-error text-xs font-bold hover:underline">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-10 px-4 text-center text-on-surface-variant">
                                Chưa có dữ liệu tồn kho.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 space-y-8">
            <div id="import-form" class="bg-surface-container-low rounded-3xl p-8 border border-outline-variant/10 scroll-mt-8">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">add_box</span>
                    Thêm phiếu nhập kho
                </h3>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6" method="POST" action="<?= BASE_URL ?>index.php?url=admin/inventory">
                    <input type="hidden" name="action" value="add_import_receipt">

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Sản phẩm / biến thể *</label>
                        <select name="ma_bien_the" required class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                            <option value="">Chọn biến thể</option>
                            <?php foreach ($inventoryList as $item): ?>
                                <?php
                                    $variantId = inventoryValue($item, ['MaBienThe'], '');
                                    $productName = inventoryValue($item, ['TenSanPham'], '');
                                    $size = inventoryValue($item, ['KichThuoc'], '');
                                    $color = inventoryValue($item, ['MauSac'], '');
                                ?>
                                <option value="<?= e($variantId) ?>">
                                    <?= e($productName . ' - ' . $variantId . (($size || $color) ? ' (' . trim($size . ' ' . $color) . ')' : '')) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Số lượng nhập *</label>
                        <input type="number" name="quantity" min="1" required class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Nhà cung cấp</label>
                        <select name="supplier_id" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                            <option value="">Không chọn</option>
                            <?php foreach ($supplierList as $supplier): ?>
                                <option value="<?= e($supplier['MaNCC'] ?? '') ?>"><?= e($supplier['TenNCC'] ?? '') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Ghi chú</label>
                        <input type="text" name="note" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="Ghi chú nội bộ nếu có">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold shadow-md hover:scale-[1.02] active:scale-95 transition-all w-full md:w-auto" type="submit">
                            Tạo phiếu nhập và tăng tồn kho
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-headline text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">list_alt</span>
                        Danh sách phiếu nhập kho
                    </h3>
                    <span class="text-xs font-semibold bg-primary/10 text-primary px-3 py-1 rounded-full uppercase tracking-wider">Live Logs</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">
                                <th class="pb-2 px-4">Mã phiếu</th>
                                <th class="pb-2 px-4">Ngày nhập</th>
                                <th class="pb-2 px-4">Nhà cung cấp</th>
                                <th class="pb-2 px-4">Tổng tiền nhập</th>
                                <th class="pb-2 px-4">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($receiptList)): ?>
                                <?php foreach ($receiptList as $entry):
                                    $entryId     = inventoryValue($entry, ['MaPhieuNhap'], '—');
                                    $arrivalDate = inventoryValue($entry, ['NgayNhap'], '—');
                                    $supplier    = inventoryValue($entry, ['TenNCC'], '—');
                                    $value       = inventoryValue($entry, ['TongTienNhap'], 0);
                                    $entryStatus = inventoryValue($entry, ['receipt_status', 'TrangThai', 'status'], 'verified');
                                    $entryStatusLabels = [
                                        'verified' => 'Đã xác minh',
                                        'pending' => 'Đang chờ',
                                        'approved' => 'Đã duyệt',
                                        'cancelled' => 'Đã hủy',
                                    ];
                                ?>
                                    <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors">
                                        <td class="py-4 px-4 rounded-l-2xl font-bold text-primary"><?= e($entryId) ?></td>
                                        <td class="py-4 px-4 text-sm"><?= e($arrivalDate) ?></td>
                                        <td class="py-4 px-4 font-medium"><?= e($supplier) ?></td>
                                        <td class="py-4 px-4 font-bold"><?= formatMoneyVND($value) ?></td>
                                        <td class="py-4 px-4 rounded-r-2xl">
                                            <span class="<?= inventoryStatusBadge($entryStatus) ?>">
                                                <?= e($entryStatusLabels[$entryStatus] ?? $entryStatus) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-10 px-4 text-center text-on-surface-variant">
                                        Không có phiếu nhập kho phù hợp với bộ lọc hiện tại.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="supplier-form" class="bg-surface-container-low rounded-3xl p-8 border border-outline-variant/10 scroll-mt-8">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">add_business</span>
                    Đăng ký nhà cung cấp mới
                </h3>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6" method="POST" action="<?= BASE_URL ?>index.php?url=admin/inventory">
                    <input type="hidden" name="action" value="add_supplier">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Tên nhà cung cấp *</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="VD: Công ty TNHH Nordic Timber" type="text" name="supplier_name" required/>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Số điện thoại</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="0901 234 567" type="text" name="tax_id"/>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Địa chỉ</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="Số nhà, đường, tỉnh/thành phố" type="text" name="location"/>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold shadow-md hover:scale-[1.02] active:scale-95 transition-all w-full md:w-auto" type="submit">
                            Xác nhận đăng ký nhà cung cấp
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <h3 class="text-xl font-bold font-headline text-primary mb-6">Mạng lưới nhà cung cấp</h3>
                <div class="space-y-6">
                    <?php if (!empty($supplierList)): ?>
                        <?php foreach ($supplierList as $supplier): ?>
                            <?php
                            $supplierName     = inventoryValue($supplier, ['TenNCC', 'name', 'supplier_name'], 'Nhà cung cấp');
                            $supplierLocation = inventoryValue($supplier, ['DiaChi', 'location', 'address'], '—');
                            $supplierId       = inventoryValue($supplier, ['MaNCC', 'id'], null);

                            $words = preg_split('/\s+/', trim((string)$supplierName));
                            $initials = '';
                            foreach (array_slice($words, 0, 2) as $word) {
                                $initials .= strtoupper(mb_substr($word, 0, 1));
                            }
                            $initials = $initials !== '' ? $initials : 'SP';
                            ?>
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold"><?= e($initials) ?></div>
                                    <div>
                                        <p class="font-bold text-sm"><?= e($supplierName) ?></p>
                                        <p class="text-xs text-on-surface-variant"><?= e($supplierLocation) ?></p>
                                    </div>
                                </div>
                                <?php if ($supplierId !== null): ?>
                                    <a href="<?= BASE_URL ?>index.php?url=supplier/detail/<?= urlencode((string)$supplierId) ?>" class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors cursor-pointer">chevron_right</a>
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors cursor-pointer">chevron_right</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-on-surface-variant">Chưa có dữ liệu nhà cung cấp.</p>
                    <?php endif; ?>
                </div>

                <a href="<?= BASE_URL ?>index.php?url=admin/suppliers" class="block w-full mt-8 py-3 rounded-xl border border-outline-variant/30 text-sm font-bold text-on-surface-variant hover:bg-surface-container-low transition-colors text-center">
                    View All Nhà cung cấp
                </a>
            </div>

            <div class="relative rounded-3xl overflow-hidden aspect-square shadow-xl group">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAuRh_Ft0B79j_1kS_g6t-Y2Ixb_n7pTJk45ldA8yAlgEQEgpAxhgZIbo7IHuoWvvF9rF0DbRN5SHWK9fop0y_E7QU8XMKOdJgNNHAXdgkTzD5BzFMOMUDevZcu-H_3f68hendL0nG_Qtg0QRMGQ8_4R9RTFjNzspQ5OVYUHi-fVi3ZUDNZYb0Gxh2m6_au6M3bNZmiOBmzWdvK4qCey40nmPNOwspGEFjjCY0iD099jtyUrIEcsPCYG9JnIcUc8cz6vNfmXaCcLhU"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8">
                    <h4 class="text-white font-headline font-bold text-xl">Main Hub Status</h4>
                    <div class="mt-4 flex gap-4">
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Phiếu nhập</span>
                            <span class="text-white font-black text-lg"><?= number_format($totalEntries) ?></span>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Nhà cung cấp</span>
                            <span class="text-white font-black text-lg"><?= number_format($totalSuppliers) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-primary text-on-primary p-8 rounded-3xl shadow-lg relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary-container/20 rounded-full blur-2xl"></div>
                <h4 class="text-lg font-bold font-headline mb-2">Cảnh báo kho hàng</h4>
                <p class="text-sm text-on-primary/80 leading-relaxed">
                    <?= $pendingCount > 0
                        ? e($pendingCount) . ' biến thể đang sắp hết hàng.'
                        : 'Hiện chưa có cảnh báo tồn kho cần xử lý.' ?>
                </p>
                <button class="mt-6 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-xs font-bold transition-all flex items-center gap-2">
                    Xử lý ngay
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
