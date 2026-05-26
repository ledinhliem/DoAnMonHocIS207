<?php
require_once 'config/config.php';
require_once 'config/database.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Delete duplicate Zentro Kitchen categories (C005 and C006), keep C001
$idsToDelete = ['C005', 'C006'];

foreach ($idsToDelete as $id) {
    $sql = 'DELETE FROM danhmuc WHERE MaDanhMuc = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    echo "Đã xóa danh mục: $id\n";
}

// Verify result
echo "\n--- Danh mục còn lại ---\n";
$sql = 'SELECT MaDanhMuc, TenDanhMuc FROM danhmuc ORDER BY TenDanhMuc ASC';
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $cat) {
    echo $cat['MaDanhMuc'] . ' | ' . $cat['TenDanhMuc'] . "\n";
}

echo "\nHoàn tất! Đã xóa 2 mục Zentro Kitchen bị trùng.";
?>
