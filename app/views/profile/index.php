<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php 
$base = defined('BASE_URL') ? BASE_URL : 'index.php'; 
$u = $data['user'] ?? [];

// Nối chuỗi địa chỉ từ DB
$diaChiDayDu = 'Bạn chưa cập nhật địa chỉ giao hàng.';
if (!empty($u['SoNha_Duong'])) {
    $diaChiDayDu = $u['SoNha_Duong'] . ', ' . $u['PhuongXa'] . ', ' . $u['QuanHuyen'] . ', ' . $u['TinhThanh'];
}
?>

<main class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-20">
  <div class="flex flex-col md:flex-row gap-16">
    <aside class="w-full md:w-64 flex flex-col gap-2">
      <div class="mb-8">
        <div class="w-20 h-20 rounded-xl overflow-hidden mb-4 bg-surface-container-high border border-outline-variant/20 flex items-center justify-center">
            <span class="text-3xl font-bold text-primary uppercase">
                <?php echo mb_substr($u['HoTen'] ?? 'U', 0, 1, "UTF-8"); ?>
            </span>
        </div>
        <h2 class="text-xl font-bold text-on-surface"><?php echo htmlspecialchars($u['HoTen'] ?? 'Khách hàng'); ?></h2>
        <p class="text-on-surface-variant text-sm truncate"><?php echo htmlspecialchars($u['Email'] ?? ''); ?></p>
      </div>

      <nav class="flex flex-col gap-1">
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary text-on-primary" href="<?php echo $base; ?>?url=profile">
          <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
          <span class="font-medium">Thông tin cá nhân</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-colors" href="<?php echo $base; ?>?url=order/history">
          <span class="material-symbols-outlined">shopping_basket</span>
          <span class="font-medium">Lịch sử đơn hàng</span>
        </a>
        <hr class="my-2 border-outline-variant/20">
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors" 
          href="index.php?url=logout"> <span class="material-symbols-outlined">logout</span>
          <span class="font-medium">Đăng xuất</span>
        </a>
      </nav>
    </aside>

    <section class="flex-1 space-y-16">
      <div class="space-y-8">
        <div class="flex justify-between items-end">
          <div>
            <span class="text-primary font-semibold tracking-wider text-xs uppercase mb-2 block">Chi tiết tài khoản</span>
            <h1 class="text-4xl font-bold text-on-surface tracking-tight">Thông tin cá nhân</h1>
          </div>
          <button class="px-6 py-2 rounded-full border border-outline-variant text-primary font-medium hover:bg-surface-container transition-colors">
            Sửa Profile
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="p-8 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
            <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-1">Họ và Tên</label>
            <p class="text-lg font-medium text-on-surface"><?php echo htmlspecialchars($u['HoTen'] ?? 'Chưa cập nhật'); ?></p>
          </div>
          <div class="p-8 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
            <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-1">Địa chỉ email</label>
            <p class="text-lg font-medium text-on-surface"><?php echo htmlspecialchars($u['Email'] ?? 'Chưa cập nhật'); ?></p>
          </div>
          <div class="p-8 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
            <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-1">Số điện thoại</label>
            <p class="text-lg font-medium text-on-surface"><?php echo htmlspecialchars(!empty($u['SoDienThoai']) ? $u['SoDienThoai'] : 'Chưa cập nhật'); ?></p>
          </div>
          <div class="p-8 rounded-xl bg-surface-container-lowest border border-outline-variant/10">
            <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-1">Ngày tham gia</label>
            <p class="text-lg font-medium text-on-surface"><?php echo date('d/m/Y', strtotime($u['NgayTao'])); ?></p>
          </div>
        </div>
      </div>

      <div class="space-y-8">
        <h2 class="text-3xl font-bold text-on-surface tracking-tight">Địa chỉ giao hàng (Mặc định)</h2>
        <div class="grid grid-cols-1 gap-8">
          <div class="p-10 rounded-xl bg-surface-container-lowest border border-outline-variant/20 shadow-sm">
            <address class="not-italic text-lg text-on-surface-variant leading-relaxed">
                <?php echo htmlspecialchars($diaChiDayDu); ?>
            </address>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>