<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin'; ?></title>
</head>
<body>
    <h1><?= $title ?? ''; ?></h1>
    <p><?= $message ?? ''; ?></p>

    <a href="<?= BASE_URL; ?>/index.php?url=home/index">Quay lại trang chủ</a>
</body>
</html>