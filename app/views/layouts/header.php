<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo $pageTitle ?? 'Zentro - Sustainable Living'; ?></title>

    <link
        href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

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
            background-color: rgba(249, 250, 242, 0.8);
        }

        .hero-gradient {
            background: linear-gradient(to right, #384e21, #4f6636);
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">

<header class="w-full sticky top-0 z-50 glass-nav shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)]">
    <div class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-primary uppercase tracking-widest font-headline">
            Zentro
        </a>

        <!-- MENU -->
        <nav class="hidden md:flex gap-8 items-center font-headline">
            <a class="text-primary border-b-2 border-primary pb-1 tracking-tight transition-all"
                href="<?= BASE_URL ?>?url=product">Shop</a>

            <a class="text-on-surface/70 hover:text-primary tracking-tight transition-all"
                href="<?= BASE_URL ?>?url=product">Categories</a>

            <a class="text-on-surface/70 hover:text-primary tracking-tight transition-all"
                href="<?= BASE_URL ?>?url=blog">Blog</a>

            <a class="text-on-surface/70 hover:text-primary tracking-tight transition-all"
                href="<?= BASE_URL ?>?url=order">History</a>
        </nav>

        <!-- RIGHT -->
        <div class="flex items-center gap-6">

            <!-- SEARCH -->
            <form action="index.php" method="GET" class="hidden md:flex items-center gap-2">
                <input type="hidden" name="url" value="product/search">

                <input type="text" name="keyword" placeholder="Search products..."
                    class="px-3 py-1 text-sm bg-surface-container rounded-lg" />

                <button type="submit" class="material-symbols-outlined">
                    search
                </button>
            </form>

            <!-- MOBILE SEARCH -->
            <button class="md:hidden material-symbols-outlined text-primary hover:scale-110 transition-transform"
                onclick="toggleMobileSearch()">search</button>

            <!-- ACCOUNT -->
            <a href="<?= BASE_URL ?>?url=login"
                class="material-symbols-outlined text-primary hover:scale-110 transition-transform">
                account_circle
            </a>

            <!-- CART -->
            <div class="relative">
                <button class="material-symbols-outlined text-primary hover:scale-110 transition-transform">
                    shopping_cart
                </button>
                <span
                    class="absolute -top-2 -right-2 bg-secondary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                    2
                </span>
            </div>

            <button class="md:hidden material-symbols-outlined text-primary">menu</button>
        </div>
    </div>

    <!-- MOBILE SEARCH -->
    <div id="mobile-search" class="hidden md:hidden px-8 pb-4">
        <form action="index.php" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="url" value="product/search">

            <input type="text" name="keyword" placeholder="Search products..."
                class="flex-1 px-3 py-2 text-sm bg-surface-container rounded-lg" />

            <button type="submit" class="material-symbols-outlined text-primary">
                search
            </button>
        </form>
    </div>
</header>

<!-- SEARCH JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        const input = form.querySelector('input[name="keyword"]');

        if (input) {
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                const keyword = input.value.trim();

                if (keyword !== "") {
                    window.location.href =
                        "index.php?url=product/search&keyword=" + encodeURIComponent(keyword);
                }
            });
        }
    });
});
</script>

<script>
function toggleMobileSearch() {
    document.getElementById('mobile-search').classList.toggle('hidden');
}
</script>