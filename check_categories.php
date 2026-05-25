<?php
require_once 'config/config.php';
require_once 'config/database.php';

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT MaDanhMuc, TenDanhMuc FROM danhmuc ORDER BY TenDanhMuc ASC';
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total categories: " . count($categories) . "\n";
echo "---\n";

$nameCounts = [];
foreach ($categories as $cat) {
    echo $cat['MaDanhMuc'] . ' | ' . $cat['TenDanhMuc'] . "\n";
    
    if (!isset($nameCounts[$cat['TenDanhMuc']])) {
        $nameCounts[$cat['TenDanhMuc']] = [];
    }
    $nameCounts[$cat['TenDanhMuc']][] = $cat['MaDanhMuc'];
}

echo "\n---\nDuplicates:\n";
foreach ($nameCounts as $name => $ids) {
    if (count($ids) > 1) {
        echo "Name: '$name' - IDs: " . implode(', ', $ids) . "\n";
    }
}
?>
