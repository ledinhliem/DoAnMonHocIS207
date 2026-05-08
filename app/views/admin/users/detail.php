<?php include 'app/views/layouts/admin_header.php'; ?>

<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Chi tiết người dùng: <span class="text-green-600"><?= $user['HoTen'] ?></span></h1>
        <a href="index.php?url=admin/users" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Thông tin tài khoản</h3>
            <div class="space-y-3">
                <p><span class="font-medium text-gray-600">Mã người dùng:</span> <?= $user['MaNguoiDung'] ?></p>
                <p><span class="font-medium text-gray-600">Email:</span> <?= $user['Email'] ?></p>
                <p><span class="font-medium text-gray-600">Số điện thoại:</span> <?= $user['SoDienThoai'] ?? '<span class="text-gray-400">Chưa cập nhật</span>' ?></p>
                <p><span class="font-medium text-gray-600">Ngày tạo:</span> <?= isset($user['NgayTao']) ? date('d/m/Y', strtotime($user['NgayTao'])) : 'N/A' ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Địa chỉ mặc định</h3>
            <div class="space-y-3">
                <?php if (!empty($user['TinhThanh'])): ?>
                    <p><span class="font-medium text-gray-600">Số nhà / Đường:</span> <?= $user['SoNha_Duong'] ?></p>
                    <p><span class="font-medium text-gray-600">Phường / Xã:</span> <?= $user['PhuongXa'] ?></p>
                    <p><span class="font-medium text-gray-600">Quận / Huyện:</span> <?= $user['QuanHuyen'] ?></p>
                    <p><span class="font-medium text-gray-600">Tỉnh / Thành phố:</span> <?= $user['TinhThanh'] ?></p>
                <?php else: ?>
                    <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                        <i class="fas fa-map-marker-alt text-3xl mb-2"></i>
                        <p>Người dùng chưa có địa chỉ.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Trạng thái hệ thống</h3>
            <div class="space-y-4">
                <div>
                    <span class="block font-medium text-gray-600 mb-1">Nhóm quyền hiện tại:</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                        <?= $user['MaQuyen'] == 1 ? 'Quản trị viên' : 'Khách hàng' ?>
                    </span>
                </div>
                <div>
                    <span class="block font-medium text-gray-600 mb-1">Tình trạng tài khoản:</span>
                    <?php if (isset($user['TrangThai']) && $user['TrangThai'] == 0): ?>
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">Đang bị khóa</span>
                    <?php else: ?>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">Đang hoạt động</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/admin_footer.php'; ?>