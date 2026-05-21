<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php
$u = !empty($old) ? array_merge($user ?? [], $old) : ($user ?? []);
?>

<main class="max-w-4xl mx-auto px-6 md:px-12 py-12 md:py-20">
    <div class="mb-10">
        <span class="text-primary font-semibold tracking-wider text-xs uppercase mb-2 block">Tài khoản</span>
        <h1 class="text-4xl font-bold text-on-surface tracking-tight">Sửa thông tin cá nhân</h1>
    </div>

    <?php if (!empty($error)): ?>
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-5 py-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?url=profile/update" method="POST" class="bg-surface-container-lowest border border-outline-variant/20 rounded-xl p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Họ và tên</label>
                <input
                    type="text"
                    name="HoTen"
                    value="<?= htmlspecialchars($u['HoTen'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                    required
                >
                <?php if (!empty($errors['HoTen'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['HoTen']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Email</label>
                <input
                    type="email"
                    value="<?= htmlspecialchars($u['Email'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline-variant bg-surface-container px-4 py-3 text-on-surface-variant"
                    disabled
                >
                <p class="text-xs text-on-surface-variant mt-1">Email dùng để đăng nhập nên không đổi tại đây.</p>
            </div>

            <div>
                <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Số điện thoại</label>
                <input
                    type="text"
                    name="SoDienThoai"
                    value="<?= htmlspecialchars($u['SoDienThoai'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                    placeholder="0900000000"
                >
                <?php if (!empty($errors['SoDienThoai'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['SoDienThoai']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border-t border-outline-variant/20 pt-6">
            <h2 class="text-xl font-bold text-on-surface mb-5">Địa chỉ giao hàng mặc định</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Số nhà, đường</label>
                    <input
                        type="text"
                        name="SoNha_Duong"
                        value="<?= htmlspecialchars($u['SoNha_Duong'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                        placeholder="123 Nguyễn Trãi"
                    >
                </div>

                <div>
                    <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Phường/Xã</label>
                    <input
                        type="text"
                        name="PhuongXa"
                        value="<?= htmlspecialchars($u['PhuongXa'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                    >
                </div>

                <div>
                    <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Quận/Huyện</label>
                    <input
                        type="text"
                        name="QuanHuyen"
                        value="<?= htmlspecialchars($u['QuanHuyen'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                    >
                </div>

                <div>
                    <label class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest block mb-2">Tỉnh/Thành</label>
                    <input
                        type="text"
                        name="TinhThanh"
                        value="<?= htmlspecialchars($u['TinhThanh'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"
                    >
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white font-semibold">
                Lưu thay đổi
            </button>
            <a href="index.php?url=profile" class="px-6 py-3 rounded-xl border border-outline-variant text-primary font-semibold">
                Hủy bỏ
            </a>
        </div>
    </form>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
