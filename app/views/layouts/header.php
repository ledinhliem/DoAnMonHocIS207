<?php
$currentUrl = $_GET['url'] ?? '';

function navClass($isActive)
{
    return $isActive
        ? 'text-primary border-b-2 border-primary pb-1 tracking-tight transition-all'
        : 'text-on-surface/70 hover:text-primary tracking-tight transition-all';
}

$cartActive = in_array($currentUrl, [
    'cart',
    'checkout',
    'order/payment',
    'order/transfer',
    'order/feedback',
    'order/success'
]);

$accountActive = in_array($currentUrl, [
    'login',
    'register',
    'forgot-password',
    'reset-password',
    'profile'
]);
?>
<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo $title ?? 'Zentro - Sustainable Living'; ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#384e21",
                        "on-primary": "#ffffff",
                        "primary-container": "#4f6636",
                        "on-primary-container": "#c7e3a7",
                        "secondary": "#775839",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#ffd5ae",
                        "surface": "#f9faf2",
                        "on-surface": "#191c18",
                        "surface-container": "#edefe7",
                        "surface-container-high": "#e7e9e1",
                        "surface-container-low": "#f3f4ed",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#e1e3dc",
                        "on-surface-variant": "#44483e",
                        "outline-variant": "#c5c8ba",
                    },
                    fontFamily: {
                        "headline": ["Epilogue", "sans-serif"],
                        "body": ["Be Vietnam Pro", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(249, 250, 242, 0.8);
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body">
<header class="w-full sticky top-0 z-50 glass-nav shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)]">
    <div class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">

        <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-primary uppercase tracking-widest font-headline">
            Zentro
        </a>

        <nav class="hidden md:flex gap-8 items-center font-headline">
            <a class="<?= navClass($currentUrl === '') ?>" href="<?= BASE_URL ?>">
                Shop
            </a>

            <a class="<?= navClass($currentUrl === 'product' || $currentUrl === 'product/detail' || $currentUrl === 'product/search') ?>"
               href="<?= BASE_URL ?>?url=product">
                Categories
            </a>

            <a class="<?= navClass($currentUrl === 'blog' || $currentUrl === 'blog/detail') ?>"
               href="<?= BASE_URL ?>?url=blog">
                Blog
            </a>

            <a class="<?= navClass($currentUrl === 'order/history' || $currentUrl === 'order/tracking') ?>"
               href="<?= BASE_URL ?>?url=order/history">
                History
            </a>
        </nav>

        <div class="flex items-center gap-6">
            <button class="material-symbols-outlined text-on-surface/70 hover:text-primary hover:scale-110 transition-transform">
                search
            </button>

            <a href="<?= BASE_URL ?>?url=login"
               class="material-symbols-outlined transition-transform <?= $accountActive ? 'text-primary scale-110' : 'text-on-surface/70 hover:text-primary hover:scale-110' ?>">
                account_circle
            </a>

            <div class="relative">
                <a href="<?= BASE_URL ?>?url=cart"
                   class="material-symbols-outlined transition-transform <?= $cartActive ? 'text-primary scale-110' : 'text-on-surface/70 hover:text-primary hover:scale-110' ?>">
                    shopping_cart
                </a>
                <span class="absolute -top-2 -right-2 bg-secondary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                    2
                </span>
            </div>

            <button class="md:hidden material-symbols-outlined text-primary">
                menu
            </button>
        </div>
    </div>
</header>