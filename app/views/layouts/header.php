<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo htmlspecialchars($pageTitle ?? 'Zentro - Sustainable Living'); ?></title>

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
            background-color: rgba(249, 250, 242, 0.85);
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body">
<?php
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)($item['quantity'] ?? 0);
    }
}
?>

<header class="w-full sticky top-0 z-50 glass-nav shadow-sm border-b border-outline-variant/30">
    <div class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">
        <a href="?url=" class="text-2xl font-bold text-primary uppercase tracking-widest font-headline">
            ZENTRO
        </a>

        <nav class="hidden md:flex gap-8 items-center font-headline">
            <a class="text-on-surface/70 hover:text-primary transition-all" href="?url=product">Shop</a>
            <a class="text-on-surface/70 hover:text-primary transition-all" href="?url=product">Categories</a>
            <a class="text-on-surface/70 hover:text-primary transition-all" href="?url=blog">Blog</a>
            <a class="text-on-surface/70 hover:text-primary transition-all" href="?url=order/history">History</a>
        </nav>

        <div class="flex items-center gap-6">
            <a href="?url=product/search" class="material-symbols-outlined text-primary hover:scale-110 transition-transform">
                search
            </a>

            <a href="?url=login" class="material-symbols-outlined text-primary hover:scale-110 transition-transform">
                account_circle
            </a>

            <a href="?url=cart" class="relative inline-flex items-center justify-center">
                <span class="material-symbols-outlined text-primary hover:scale-110 transition-transform">
                    shopping_cart
                </span>

                <?php if ($cartCount > 0): ?>
                    <span class="absolute -top-2 -right-2 bg-secondary text-white text-[10px] min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center font-bold">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</header>