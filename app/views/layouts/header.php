<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sustainable Shop' ?></title>
</head>
<body>

<header>
    <h2>HEADER CHUNG</h2>
    <nav>
        <a href="<?= BASE_URL ?>">Home</a> |
        <a href="<?= BASE_URL ?>?url=product">Products</a> |
        <a href="<?= BASE_URL ?>?url=blog">Blog</a> |
        <a href="<?= BASE_URL ?>?url=cart">Cart</a> |
        <a href="<?= BASE_URL ?>?url=login">Login</a> |
        <a href="<?= BASE_URL ?>?url=register">Register</a> |
        <a href="<?= BASE_URL ?>?url=profile">Profile</a> |
        <a href="<?= BASE_URL ?>?url=admin">Admin</a>
    </nav>
    <hr>
</header>