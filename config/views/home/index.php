<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Trang chủ'; ?></title>
</head>
<body>
    <h1><?= $title ?? ''; ?></h1>
    <p><?= $message ?? ''; ?></p>

    <h2>Danh sách người dùng</h2>

    <?php if (!empty($users)): ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <?= htmlspecialchars($user['HoTen'] ?? 'Không có tên'); ?>
                    - <?= htmlspecialchars($user['Email'] ?? 'Không có email'); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Chưa có dữ liệu người dùng.</p>
    <?php endif; ?>

    <p>
        <a href="<?= BASE_URL; ?>/index.php?url=admin/dashboard">Admin Dashboard</a>
    </p>
</body>
</html>