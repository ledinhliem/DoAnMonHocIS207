<?php $base = BASE_URL; ?>
<!DOCTYPE html>
<html lang="vi" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sustainable Shop' ?></title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        tertiary: "#474845",
                        "on-surface-variant": "#44483e",
                        secondary: "#775839",
                        surface: "#f9faf2",
                        "tertiary-container": "#5e605c",
                        "surface-bright": "#f9faf2",
                        "outline-variant": "#c5c8ba",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e7e9e1",
                        "on-primary-fixed": "#0f2000",
                        error: "#ba1a1a",
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
                        background: "#f9faf2",
                        "surface-tint": "#4e6535",
                        "surface-variant": "#e1e3dc",
                        "primary-container": "#4f6636",
                        outline: "#75796d",
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
                        primary: "#384e21",
                        "on-secondary-container": "#7a5b3b",
                        "secondary-container": "#ffd5ae",
                        "secondary-fixed": "#ffdcbd"
                    },
                    fontFamily: {
                        headline: ["Epilogue"],
                        body: ["Be Vietnam Pro"],
                        label: ["Be Vietnam Pro"]
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    boxShadow: {
                        soft: "0 20px 40px rgba(25,28,24,0.06)"
                    }
                }
            }
        };
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            vertical-align: middle;
            white-space: nowrap;
        }
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }
        .font-headline {
            font-family: 'Epilogue', sans-serif;
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(249, 250, 242, 0.82);
        }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">

<header class="w-full sticky top-0 z-50 glass-nav shadow-[0_20px_40px_rgba(25,28,24,0.04)] border-b border-outline-variant/20">
    <div class="max-w-7xl mx-auto px-6 md:px-8 py-5 flex items-center justify-between gap-6">
        <a href="<?= $base ?>" class="text-2xl font-bold tracking-widest uppercase text-primary font-headline">
            Zentro
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="<?= $base ?>" class="text-on-surface hover:text-primary transition-colors">Home</a>
            <a href="<?= $base ?>?url=product" class="text-on-surface hover:text-primary transition-colors">Products</a>
            <a href="<?= $base ?>?url=blog" class="text-on-surface hover:text-primary transition-colors">Blog</a>
            <a href="<?= $base ?>?url=order/history" class="text-on-surface hover:text-primary transition-colors">History</a>
        </nav>

        <div class="flex items-center gap-4 md:gap-5">
            <a href="<?= $base ?>?url=profile" class="text-primary hover:opacity-80 transition-opacity">
                <span class="material-symbols-outlined">account_circle</span>
            </a>

            <a href="<?= $base ?>?url=cart" class="relative text-primary hover:opacity-80 transition-opacity">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span class="absolute -top-2 -right-2 bg-secondary text-on-secondary text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
            </a>
        </div>
    </div>
</header>

<main class="min-h-screen">