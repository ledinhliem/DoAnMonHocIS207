<?php include 'app/views/layouts/admin_header.php'; ?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Quản lý người dùng</h1>

    <form action="index.php" method="GET" class="mb-6 flex gap-2">
        <input type="hidden" name="url" value="admin/users">
        <input type="text" name="search" value="<?= $search ?? '' ?>" 
               placeholder="Tìm tên, email, sđt..." class="border p-2 rounded w-64">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Mã ND</th>
                <th class="border p-2">Họ tên</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Quyền hiện tại</th>
                <th class="border p-2 text-center">Trạng thái</th> <th class="border p-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td class="border p-2"><?= $user['MaNguoiDung'] ?></td>
                <td class="border p-2"><?= $user['HoTen'] ?></td>
                <td class="border p-2"><?= $user['Email'] ?></td>
                <td class="border p-2 text-center">
                    <form action="index.php?url=admin/users/update-role" method="POST">
                        <input type="hidden" name="userId" value="<?= $user['MaNguoiDung'] ?>">
                            <select name="roleId" onchange="this.form.submit()" class="border rounded-md px-3 py-1.5 text-sm bg-white cursor-pointer w-32 focus:outline-none focus:ring-2 focus:ring-green-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_0.5rem_center] bg-no-repeat pr-8">                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['MaQuyen'] ?>" <?= $user['MaQuyen'] == $role['MaQuyen'] ? 'selected' : '' ?>>
                                    <?= $role['TenQuyen'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td class="border p-2 text-center">
                    <?php if (isset($user['TrangThai']) && $user['TrangThai'] == 1): ?>
                        <span class="text-green-600 font-bold">Hoạt động</span>
                    <?php else: ?>
                        <span class="text-red-500 font-bold">Bị khóa</span>
                    <?php endif; ?>
                </td>
                <td class="border p-2 text-center">
                    <a href="index.php?url=admin/users/detail&id=<?= $user['MaNguoiDung'] ?>" class="text-blue-600">Chi tiết</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'app/views/layouts/admin_footer.php'; ?>