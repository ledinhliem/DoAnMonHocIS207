<?php
$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += (int)($item['quantity'] ?? 0);
    }
}

$currentUrl = trim($_GET['url'] ?? '', '/');
$navItems = [
    [
        'label' => 'Cửa hàng',
        'url' => 'product',
        'matches' => ['product', 'product/shop', 'product/detail', 'product/search'],
    ],
    [
        'label' => 'Blog',
        'url' => 'blog',
        'matches' => ['blog', 'blog/detail'],
    ],
    [
        'label' => 'Lịch sử',
        'url' => 'order/history',
        'matches' => ['order/history', 'order/tracking'],
    ],
];

$isNavActive = static function (array $item) use ($currentUrl): bool {
    return in_array($currentUrl, $item['matches'] ?? [], true);
};

$navItemClass = static function (bool $active, string $mode = 'desktop'): string {
    $base = 'font-headline text-sm font-bold uppercase tracking-tight transition-all';
    $state = $active ? 'text-primary' : 'text-on-surface/70 hover:text-primary';

    if ($mode === 'mobile') {
        return $base . ' ' . $state . ' whitespace-nowrap px-2 py-2 border-b-2 '
            . ($active ? 'border-primary' : 'border-transparent');
    }

    return $base . ' ' . $state
        . ' relative after:absolute after:left-0 after:-bottom-2 after:h-0.5 after:bg-primary after:transition-all '
        . ($active ? 'after:w-full' : 'after:w-0 hover:after:w-full');
};
?>
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

<header class="w-full sticky top-0 z-50 glass-nav shadow-sm border-b border-outline-variant/30">
    <div class="grid grid-cols-[auto_1fr_auto] items-center gap-5 px-5 sm:px-8 py-5 max-w-7xl mx-auto">
        <a href="index.php?url=" class="text-2xl font-bold text-primary uppercase tracking-widest font-headline">
            ZENTRO
        </a>

        <nav class="hidden md:flex justify-center gap-10 items-center" aria-label="Điều hướng chính">
            <?php foreach ($navItems as $item): ?>
                <?php $active = $isNavActive($item); ?>
                <a class="<?= $navItemClass($active) ?>"
                   href="index.php?url=<?= htmlspecialchars($item['url']) ?>"
                   <?= $active ? 'aria-current="page"' : '' ?>>
                    <?= htmlspecialchars($item['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="flex items-center justify-end gap-4 sm:gap-6">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?url=profile" class="flex items-center gap-2 group" aria-label="Tài khoản">
                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">
                        account_circle
                    </span>
                    <span class="text-xs font-bold text-primary hidden lg:block uppercase">
                        Hi, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'User')[0]) ?>
                    </span>
                </a>
            <?php else: ?>
                <a href="index.php?url=login" class="material-symbols-outlined text-primary hover:scale-110 transition-transform" aria-label="Đăng nhập">
                    account_circle
                </a>
            <?php endif; ?>

            <a href="index.php?url=cart" class="relative inline-flex items-center justify-center" aria-label="Giỏ hàng">
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

    <nav class="md:hidden flex justify-center gap-7 px-5 pb-4 overflow-x-auto" aria-label="Điều hướng chính trên mobile">
        <?php foreach ($navItems as $item): ?>
            <?php $active = $isNavActive($item); ?>
            <a class="<?= $navItemClass($active, 'mobile') ?>"
               href="index.php?url=<?= htmlspecialchars($item['url']) ?>"
               <?= $active ? 'aria-current="page"' : '' ?>>
                <?= htmlspecialchars($item['label']) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</header>
