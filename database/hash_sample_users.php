<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This script can only be run from CLI.');
}

require_once __DIR__ . '/../config/database.php';

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    DB_HOST,
    DB_PORT,
    DB_NAME,
    DB_CHARSET
);

$pdo = new PDO($dsn, DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$sampleUserIds = ['U001', 'U002', 'U003', 'U004', 'U005'];
$defaultPassword = '123456';

$select = $pdo->prepare('SELECT MatKhau FROM nguoidung WHERE MaNguoiDung = ? LIMIT 1');
$update = $pdo->prepare('UPDATE nguoidung SET MatKhau = ? WHERE MaNguoiDung = ?');

foreach ($sampleUserIds as $userId) {
    $select->execute([$userId]);
    $currentHash = $select->fetchColumn();

    if ($currentHash === false) {
        echo $userId . ": not found\n";
        continue;
    }

    if (password_verify($defaultPassword, $currentHash)) {
        echo $userId . ": already hashed\n";
        continue;
    }

    $update->execute([password_hash($defaultPassword, PASSWORD_DEFAULT), $userId]);
    echo $userId . ": hashed\n";
}
