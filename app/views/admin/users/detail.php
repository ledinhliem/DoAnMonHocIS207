<?php include __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<main class="ml-64 min-h-screen px-8 py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-semibold text-primary uppercase tracking-widest">Admin / Users</p>
            <h1 class="font-['Epilogue'] text-4xl font-black text-[#384e21] mt-2">Chi tiết người dùng</h1>
        </div>

        <a href="<?= BASE_URL ?>index.php?url=admin/users" class="inline-flex items-center gap-2 rounded-xl bg-surface-container px-5 py-3 text-sm font-bold text-primary transition-colors hover:bg-surface-container-high">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Quay lại danh sách
        </a>
    </div>

    <?php if (empty($user)): ?>
        <section class="rounded-xl border border-outline-variant/40 bg-white px-6 py-14 text-center shadow-sm">
            <h2 class="font-['Epilogue'] text-2xl font-bold text-[#384e21]">Không tìm thấy người dùng</h2>
            <p class="mt-2 text-on-surface-variant">Tài khoản này có thể đã bị xóa hoặc mã người dùng không hợp lệ.</p>
        </section>
    <?php else: ?>
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-xl border border-outline-variant/40 bg-white p-6 shadow-sm">
                <h2 class="mb-5 border-b border-outline-variant/30 pb-3 text-lg font-bold text-[#384e21]">Thông tin tài khoản</h2>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold text-on-surface-variant">Họ tên:</span> <?= htmlspecialchars($user['HoTen'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <p><span class="font-semibold text-on-surface-variant">Mã người dùng:</span> <?= htmlspecialchars($user['MaNguoiDung'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <p><span class="font-semibold text-on-surface-variant">Email:</span> <?= htmlspecialchars($user['Email'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <p><span class="font-semibold text-on-surface-variant">Số điện thoại:</span> <?= htmlspecialchars($user['SoDienThoai'] ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8') ?></p>
                    <p><span class="font-semibold text-on-surface-variant">Ngày tạo:</span> <?= isset($user['NgayTao']) ? date('d/m/Y', strtotime($user['NgayTao'])) : 'N/A' ?></p>
                </div>
            </div>

            <div class="rounded-xl border border-outline-variant/40 bg-white p-6 shadow-sm">
                <h2 class="mb-5 border-b border-outline-variant/30 pb-3 text-lg font-bold text-[#384e21]">Địa chỉ mặc định</h2>
                <div class="space-y-3 text-sm">
                    <?php if (!empty($user['TinhThanh'])): ?>
                        <p><span class="font-semibold text-on-surface-variant">Số nhà / Đường:</span> <?= htmlspecialchars($user['SoNha_Duong'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                        <p><span class="font-semibold text-on-surface-variant">Phường / Xã:</span> <?= htmlspecialchars($user['PhuongXa'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                        <p><span class="font-semibold text-on-surface-variant">Quận / Huyện:</span> <?= htmlspecialchars($user['QuanHuyen'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                        <p><span class="font-semibold text-on-surface-variant">Tỉnh / Thành phố:</span> <?= htmlspecialchars($user['TinhThanh'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <?php else: ?>
                        <p class="text-on-surface-variant">Người dùng chưa có địa chỉ.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="rounded-xl border border-outline-variant/40 bg-white p-6 shadow-sm">
                <h2 class="mb-5 border-b border-outline-variant/30 pb-3 text-lg font-bold text-[#384e21]">Trạng thái hệ thống</h2>
                <div class="space-y-5 text-sm">
                    <div>
                        <span class="mb-2 block font-semibold text-on-surface-variant">Nhóm quyền hiện tại</span>
                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">
                            <?= ((int)($user['MaQuyen'] ?? 0) === 1) ? 'Quản trị viên' : 'Khách hàng' ?>
                        </span>
                    </div>
                    <div>
                        <span class="mb-2 block font-semibold text-on-surface-variant">Tình trạng tài khoản</span>
                        <?php if (isset($user['TrangThai']) && (int)$user['TrangThai'] === 0): ?>
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">Đang bị khóa</span>
                        <?php else: ?>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">Đang hoạt động</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>
