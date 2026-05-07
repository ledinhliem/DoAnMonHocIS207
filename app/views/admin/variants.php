<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
// ── Helpers ────────────────────────────────────────────────
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

// ── Dữ liệu từ Controller (AdminController::variants()) ────
// $variants     = array of rows từ bienthesanpham JOIN sanpham
// $ma_san_pham  = mã sản phẩm hiện tại
// $status       = 'success' | 'error' | 'warning' | null
// $message      = string thông báo

$variants    = $variants    ?? [];
$maSanPham   = $ma_san_pham ?? '';
$productName = '';

if (!empty($variants) && isset($variants[0]['TenSanPham'])) {
    $productName = $variants[0]['TenSanPham'];
} elseif ($maSanPham !== '') {
    $productName = 'Sản phẩm ' . $maSanPham;
}

// ── Tính toán thống kê ──────────────────────────────────────
$totalStock   = array_sum(array_column($variants, 'SoLuongTon'));
$outOfStock   = count(array_filter($variants, fn($v) => (int)$v['SoLuongTon'] === 0));
$avgPrice     = count($variants)
    ? array_sum(array_column($variants, 'GiaTien')) / count($variants)
    : 0;
?>

<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="ml-64 p-8 lg:p-12 min-h-screen bg-[#f9faf2]">

    <!-- ── Flash message ─────────────────────────────────── -->
    <?php if (!empty($status)): ?>
    <?php
        $flashMap = [
            'success' => ['bg-[#d0ecaf]/60', 'border-[#384e21]/20', 'text-[#384e21]', 'check_circle'],
            'warning' => ['bg-[#ffd5ae]/60', 'border-[#7a5b3b]/20', 'text-[#7a5b3b]', 'warning'],
            'error'   => ['bg-[#ffdad6]/60', 'border-[#ba1a1a]/20', 'text-[#ba1a1a]', 'error'],
        ];
        [$bgCls, $borderCls, $textCls, $icon] = $flashMap[$status] ?? $flashMap['error'];
    ?>
    <div id="flash-msg"
         class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl border text-sm font-semibold
                <?= "$bgCls $borderCls $textCls" ?>">
        <span class="material-symbols-outlined"><?= $icon ?></span>
        <?= e($message ?? '') ?>
    </div>
    <?php endif; ?>

    <!-- ── Header ────────────────────────────────────────── -->
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 mb-12">
        <div>
            <div class="flex items-center gap-2 mb-4">
                <a href="/is207/index.php?url=admin/products"
                   class="text-[#384e21] hover:opacity-70 flex items-center transition-opacity">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span class="text-sm font-bold ml-1 uppercase tracking-tighter">Quay lại sản phẩm</span>
                </a>
            </div>
            <h2 class="text-5xl font-black text-[#384e21] tracking-tighter mb-3">Biến thể sản phẩm</h2>
            <?php if ($productName): ?>
            <p class="text-[#44483e] text-lg">
                Quản lý các lựa chọn cho:
                <span class="font-bold text-[#384e21]"><?= e($productName) ?></span>
            </p>
            <?php endif; ?>
        </div>

        <button onclick="openModal('modal-add')"
                class="zentro-button !w-auto px-8 flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            Thêm biến thể mới
        </button>
    </header>

    <!-- ── Table ─────────────────────────────────────────── -->
    <div class="bg-white rounded-3xl border border-[#c5c8ba]/30 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#edefe7]/50 border-b border-[#c5c8ba]/30">
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider">Mã BT</th>
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider">Màu sắc</th>
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider">Kích thước</th>
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider text-right">Giá bán</th>
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider text-center">Tồn kho</th>
                    <th class="px-6 py-5 font-['Epilogue'] font-bold text-[#384e21] text-sm uppercase tracking-wider text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#c5c8ba]/10">
                <?php if (!empty($variants)): ?>
                <?php foreach ($variants as $v): ?>
                <tr class="hover:bg-[#f9faf2]/50 transition-colors group">
                    <td class="px-6 py-4">
                        <code class="bg-[#e1e3dc] px-2 py-1 rounded text-xs font-mono text-[#44483e]">
                            <?= e($v['MaBienThe']) ?>
                        </code>
                    </td>
                    <td class="px-6 py-4 font-medium text-[#191c18]">
                        <?= e($v['MauSac'] ?: '—') ?>
                    </td>
                    <td class="px-6 py-4 text-[#191c18]">
                        <?= e($v['KichThuoc'] ?: '—') ?>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-[#384e21]">
                        <?= number_format((float)$v['GiaTien'], 0, ',', '.') ?>đ
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if ((int)$v['SoLuongTon'] > 0): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                         bg-[#d0ecaf] text-[#374d20] text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#384e21]"></span>
                                Còn <?= (int)$v['SoLuongTon'] ?> sp
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                         bg-[#ffdad6] text-[#93000a] text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ba1a1a]"></span>
                                Hết hàng
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <!-- Nút mở modal sửa -->
                            <button type="button"
                                    class="p-2 hover:bg-[#e1e3dc] rounded-full text-[#384e21] transition-colors"
                                    title="Chỉnh sửa"
                                    onclick='openEditModal(<?= json_encode([
                                        "ma"    => $v["MaBienThe"],
                                        "mau"   => $v["MauSac"],
                                        "size"  => $v["KichThuoc"],
                                        "gia"   => $v["GiaTien"],
                                        "sl"    => $v["SoLuongTon"],
                                    ]) ?>)'>
                                <span class="material-symbols-outlined text-xl">edit</span>
                            </button>

                            <!-- Nút xóa (form inline) -->
                            <form method="POST"
                                  action="/is207/index.php?url=admin/products/variants&id=<?= urlencode($maSanPham) ?>"
                                  onsubmit="return confirm('Xóa biến thể <?= e($v['MaBienThe']) ?>?')">
                                <input type="hidden" name="action"      value="delete_variant">
                                <input type="hidden" name="ma_bien_the" value="<?= e($v['MaBienThe']) ?>">
                                <button type="submit"
                                        class="p-2 hover:bg-[#ffdad6] rounded-full text-[#ba1a1a] transition-colors"
                                        title="Xóa">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#edefe7]
                                    flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#384e21] text-3xl">inventory_2</span>
                        </div>
                        <p class="font-bold text-[#191c18] text-lg mb-1">Chưa có biến thể nào</p>
                        <p class="text-[#44483e] text-sm">
                            Nhấn "Thêm biến thể mới" để bắt đầu.
                        </p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ── Stats cards ───────────────────────────────────── -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-[#384e21]/5 border border-[#384e21]/10 rounded-2xl">
            <span class="material-symbols-outlined text-[#384e21] mb-2 block">inventory</span>
            <h4 class="font-bold text-[#384e21]">Tổng tồn kho</h4>
            <p class="text-2xl font-black text-[#384e21]"><?= number_format($totalStock) ?> sp</p>
        </div>
        <div class="p-6 bg-[#775839]/5 border border-[#775839]/10 rounded-2xl">
            <span class="material-symbols-outlined text-[#775839] mb-2 block">sell</span>
            <h4 class="font-bold text-[#775839]">Giá trung bình</h4>
            <p class="text-2xl font-black text-[#775839]">
                <?= $avgPrice > 0 ? number_format($avgPrice, 0, ',', '.') . 'đ' : '—' ?>
            </p>
        </div>
        <div class="p-6 bg-[#ba1a1a]/5 border border-[#ba1a1a]/10 rounded-2xl">
            <span class="material-symbols-outlined text-[#ba1a1a] mb-2 block">warning</span>
            <h4 class="font-bold text-[#ba1a1a]">Hết hàng</h4>
            <p class="text-2xl font-black text-[#ba1a1a]"><?= $outOfStock ?> biến thể</p>
        </div>
    </div>
</main>

<!-- ══════════════════════════════════════════════════════════
     MODAL: Thêm biến thể
══════════════════════════════════════════════════════════ -->
<div id="modal-add"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-['Epilogue'] text-2xl font-black text-[#384e21]">Thêm biến thể</h3>
            <button onclick="closeModal('modal-add')"
                    class="p-2 hover:bg-[#edefe7] rounded-full transition-colors">
                <span class="material-symbols-outlined text-[#384e21]">close</span>
            </button>
        </div>

        <form method="POST"
              action="/is207/index.php?url=admin/products/variants&id=<?= urlencode($maSanPham) ?>">
            <input type="hidden" name="action" value="add_variant">

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Màu sắc
                    </label>
                    <input type="text" name="mau_sac" placeholder="VD: Xanh Navy"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Kích thước
                    </label>
                    <input type="text" name="kich_thuoc" placeholder="VD: Size M, 200ml…"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Giá bán (đ) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="gia_tien" min="0" step="1000" required
                           placeholder="VD: 250000"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Số lượng tồn kho <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="so_luong_ton" min="0" required
                           placeholder="VD: 10"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal('modal-add')"
                        class="zentro-button-outline !py-3 flex-1">
                    Hủy
                </button>
                <button type="submit" class="zentro-button !py-3 flex-1 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    Thêm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     MODAL: Sửa biến thể
══════════════════════════════════════════════════════════ -->
<div id="modal-edit"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-['Epilogue'] text-2xl font-black text-[#384e21]">Sửa biến thể</h3>
            <button onclick="closeModal('modal-edit')"
                    class="p-2 hover:bg-[#edefe7] rounded-full transition-colors">
                <span class="material-symbols-outlined text-[#384e21]">close</span>
            </button>
        </div>

        <form method="POST"
              action="/is207/index.php?url=admin/products/variants&id=<?= urlencode($maSanPham) ?>"
              id="form-edit">
            <input type="hidden" name="action"      value="update_variant">
            <input type="hidden" name="ma_bien_the" id="edit-ma">

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Mã biến thể
                    </label>
                    <p id="edit-ma-display"
                       class="px-4 py-3 bg-[#edefe7] rounded-xl text-sm font-mono text-[#44483e]"></p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Màu sắc
                    </label>
                    <input type="text" name="mau_sac" id="edit-mau"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Kích thước
                    </label>
                    <input type="text" name="kich_thuoc" id="edit-size"
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Giá bán (đ) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="gia_tien" id="edit-gia" min="0" step="1000" required
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#44483e] uppercase tracking-wider mb-1">
                        Số lượng tồn kho <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="so_luong_ton" id="edit-sl" min="0" required
                           class="zentro-input border border-[#c5c8ba]/30">
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal('modal-edit')"
                        class="zentro-button-outline !py-3 flex-1">
                    Hủy
                </button>
                <button type="submit"
                        class="zentro-button !py-3 flex-1 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS riêng cho trang variants -->
<script src="/is207/public/js/products-variant.js"></script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>