<?php include __DIR__ . '/../../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../../layouts/admin_sidebar.php'; ?>

<main class="ml-64 min-h-screen px-8 py-8">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-semibold text-primary uppercase tracking-widest">Admin / Users</p>
            <h1 class="font-['Epilogue'] text-4xl font-black text-[#384e21] mt-2">Quản lý người dùng</h1>
            <p class="mt-2 text-on-surface-variant">Tìm kiếm, xem chi tiết và cập nhật quyền tài khoản.</p>
        </div>

        <form action="<?= BASE_URL ?>index.php" method="GET" class="flex w-full max-w-md gap-2">
            <input type="hidden" name="url" value="admin/users">
            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Tìm tên, email, số điện thoại..."
                class="min-w-0 flex-1 rounded-xl border border-outline-variant bg-white px-4 py-3 text-sm focus:border-primary focus:ring-primary/20">
            <button type="submit" class="rounded-xl bg-[#384e21] px-5 py-3 text-sm font-bold text-white transition-opacity hover:opacity-90">
                Tìm kiếm
            </button>
        </form>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="mb-5 rounded-xl bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
            <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
            <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <section class="overflow-hidden rounded-xl border border-outline-variant/40 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-surface-container">
                <tr class="text-left text-xs uppercase tracking-widest text-on-surface-variant">
                    <th class="px-5 py-4">Mã ND</th>
                    <th class="px-5 py-4">Họ tên</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Quyền hiện tại</th>
                    <th class="px-5 py-4 text-center">Trạng thái</th>
                    <th class="px-5 py-4 text-right">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-surface-container-low">
                            <td class="px-5 py-4 font-semibold text-primary"><?= htmlspecialchars($user['MaNguoiDung'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-5 py-4"><?= htmlspecialchars($user['HoTen'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-5 py-4"><?= htmlspecialchars($user['Email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-5 py-4">
                                <form action="<?= BASE_URL ?>index.php?url=admin/users/update-role" method="POST">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($user['MaNguoiDung'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <select name="roleId" onchange="this.form.submit()" class="w-36 rounded-lg border border-outline-variant bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary/20">
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= htmlspecialchars($role['MaQuyen'], ENT_QUOTES, 'UTF-8') ?>" <?= ($user['MaQuyen'] ?? '') == $role['MaQuyen'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($role['TenQuyen'], ENT_QUOTES, 'UTF-8') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <?php if (!isset($user['TrangThai']) || (int)$user['TrangThai'] === 1): ?>
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">Hoạt động</span>
                                <?php else: ?>
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">Bị khóa</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="<?= BASE_URL ?>index.php?url=admin/users/detail&id=<?= urlencode($user['MaNguoiDung'] ?? '') ?>" class="font-bold text-primary hover:underline">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center text-on-surface-variant">
                            Không tìm thấy người dùng phù hợp.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include __DIR__ . '/../../layouts/admin_footer.php'; ?>
