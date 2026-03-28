<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global.css">
</head>
<body>

<header>
    <h2>Admin Panel</h2>
    <nav>
        <a href="<?= BASE_URL ?>?url=admin">Dashboard</a>
        <a href="<?= BASE_URL ?>?url=admin/products">Products</a>
        <a href="<?= BASE_URL ?>?url=admin/orders">Orders</a>
        <a href="<?= BASE_URL ?>?url=admin/inventory">Inventory</a>
        <a href="<?= BASE_URL ?>?url=admin/reviews">Reviews</a>
        <a href="<?= BASE_URL ?>?url=admin/blog">Blog</a>
    </nav>
    <hr>
</header>