<!DOCTYPE html>
<html class="light" lang="vn">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?? 'Zentro - Sustainable Living' ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800&amp;family=Be+Vietnam+Pro:wght@300;400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary": "#474845",
                        "on-surface-variant": "#44483e",
                        "secondary": "#775839",
                        "surface": "#f9faf2",
                        "tertiary-container": "#5e605c",
                        "surface-bright": "#f9faf2",
                        "outline-variant": "#c5c8ba",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e7e9e1",
                        "on-primary-fixed": "#0f2000",
                        "error": "#ba1a1a",
                        "on-primary-fixed-variant": "#374d20",
                        "inverse-primary": "#b5cf95",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#c6c7c2",
                        "secondary-fixed-dim": "#e8bf98",
                        "primary-fixed-dim": "#b5cf95",
                        "primary-fixed": "#d0ecaf",
                        "on-primary-container": "#c7e3a7",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#5d4123",
                        "on-error-container": "#93000a",
                        "on-primary": "#ffffff",
                        "background": "#f9faf2",
                        "surface-tint": "#4e6535",
                        "surface-variant": "#e1e3dc",
                        "primary-container": "#4f6636",
                        "outline": "#75796d",
                        "surface-dim": "#d9dbd3",
                        "on-secondary-fixed": "#2c1701",
                        "on-background": "#191c18",
                        "inverse-on-surface": "#f0f1ea",
                        "surface-container-highest": "#e1e3dc",
                        "surface-container-low": "#f3f4ed",
                        "inverse-surface": "#2e312c",
                        "on-surface": "#191c18",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#454744",
                        "surface-container": "#edefe7",
                        "on-tertiary-container": "#dadad6",
                        "on-tertiary-fixed": "#1a1c19",
                        "tertiary-fixed": "#e3e3de",
                        "primary": "#384e21",
                        "on-secondary-container": "#7a5b3b",
                        "secondary-container": "#ffd5ae",
                        "secondary-fixed": "#ffdcbd"
                    },
                    fontFamily: {
                        "headline": ["Epilogue"],
                        "body": ["Be Vietnam Pro"],
                        "label": ["Be Vietnam Pro"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(249, 250, 242, 0.8);
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed">
    <!-- Header -->
    <header class="w-full sticky top-0 z-50 glass-nav shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)]">
        <div class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">
            <div class="text-2xl font-bold text-[#384e21] dark:text-[#b5cf95] uppercase tracking-widest font-headline">Zentro</div>
            <nav class="hidden md:flex gap-8 items-center">
                <a class="text-[#384e21] dark:text-[#b5cf95] border-b-2 border-[#384e21] pb-1 font-['Epilogue'] tracking-tight transition-colors duration-300" href="<?= BASE_URL ?>">Shop</a>
                <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="<?= BASE_URL ?>?url=product">Categories</a>
                <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="<?= BASE_URL ?>?url=blog">Blog</a>
                <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="<?= BASE_URL ?>?url=order/history">History</a>
            </nav>
            <div class="flex items-center gap-6">
                <div class="relative">

    <!-- ICON -->
    <button onclick="toggleSearch()" 
        class="material-symbols-outlined text-[#384e21] active:scale-95 transition-transform">
        search
    </button>

    <!-- FORM ẨN -->
    <form id="searchBox" action="<?= BASE_URL ?>" method="GET"
        class="hidden absolute right-0 top-10 bg-white p-2 rounded shadow">

        <input type="hidden" name="url" value="product/search">

        <input 
            type="text"
            name="keyword"
            placeholder="Search..."
            class="border px-3 py-1 rounded"
        >
    </form>

</div>
                <button class="material-symbols-outlined text-[#384e21] scale-95 active:opacity-80 transition-transform">account_circle</button>
                <div class="relative">
                    <button class="material-symbols-outlined text-[#384e21] scale-95 active:opacity-80 transition-transform">shopping_cart</button>
                    <span class="absolute -top-2 -right-2 bg-secondary text-on-secondary text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
                </div>
                <button class="md:hidden material-symbols-outlined text-[#384e21]">menu</button>
            </div>
        </div>
        <script>
function toggleSearch() {
    const box = document.getElementById('searchBox');
    box.classList.toggle('hidden');

    if (!box.classList.contains('hidden')) {
        box.querySelector('input').focus();
    }
}
</script>
    </header>