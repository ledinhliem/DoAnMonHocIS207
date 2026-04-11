<?php $base = BASE_URL; ?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Order Confirmed | Zentro</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800&amp;family=Be+Vietnam+Pro:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "error-container": "#ffdad6",
                        "surface-dim": "#d9dbd3",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#edefe7",
                        "primary": "#384e21",
                        "background": "#f9faf2",
                        "tertiary-fixed-dim": "#c6c7c2",
                        "on-error-container": "#93000a",
                        "surface-bright": "#f9faf2",
                        "on-primary-fixed": "#0f2000",
                        "on-primary": "#ffffff",
                        "surface-container-high": "#e7e9e1",
                        "on-tertiary-fixed-variant": "#454744",
                        "surface": "#f9faf2",
                        "on-tertiary-container": "#dadad6",
                        "on-tertiary-fixed": "#1a1c19",
                        "secondary-fixed": "#ffdcbd",
                        "secondary-fixed-dim": "#e8bf98",
                        "secondary-container": "#ffd5ae",
                        "surface-container-low": "#f3f4ed",
                        "inverse-primary": "#b5cf95",
                        "surface-tint": "#4e6535",
                        "outline": "#75796d",
                        "tertiary-fixed": "#e3e3de",
                        "surface-variant": "#e1e3dc",
                        "outline-variant": "#c5c8ba",
                        "on-background": "#191c18",
                        "secondary": "#775839",
                        "tertiary": "#474845",
                        "inverse-on-surface": "#f0f1ea",
                        "primary-fixed-dim": "#b5cf95",
                        "on-primary-container": "#c7e3a7",
                        "on-secondary-fixed": "#2c1701",
                        "tertiary-container": "#5e605c",
                        "on-secondary-fixed-variant": "#5d4123",
                        "on-surface": "#191c18",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#374d20",
                        "primary-fixed": "#d0ecaf",
                        "primary-container": "#4f6636",
                        "on-secondary-container": "#7a5b3b",
                        "error": "#ba1a1a",
                        "surface-container-highest": "#e1e3dc",
                        "on-surface-variant": "#44483e",
                        "inverse-surface": "#2e312c",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff"
                    },
                    fontFamily: {
                        "headline": ["Epilogue"],
                        "body": ["Be Vietnam Pro"],
                        "label": ["Be Vietnam Pro"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .eco-glass {
            background: rgba(249, 250, 242, 0.85);
            backdrop-filter: blur(12px);
        }
        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(249, 250, 242, 0.8);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body selection:bg-primary-fixed-dim selection:text-on-primary-fixed">
  <header class="w-full sticky top-0 z-50 glass-nav shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)]">
    <div class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">
      <div class="text-2xl font-bold text-[#384e21] dark:text-[#b5cf95] uppercase tracking-widest font-headline">Zentro</div>

      <nav class="hidden md:flex gap-8 items-center">
        <a class="text-[#384e21] dark:text-[#b5cf95] border-b-2 border-[#384e21] pb-1 font-['Epilogue'] tracking-tight transition-colors duration-300" href="<?= $base ?>">Shop</a>
        <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="#">Categories</a>
        <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="<?= $base ?>?url=blog">Blog</a>
        <a class="text-[#191c18]/70 dark:text-stone-400 font-['Epilogue'] tracking-tight hover:text-[#4f6636] transition-colors duration-300" href="<?= $base ?>?url=order/history">History</a>
      </nav>

      <div class="flex items-center gap-6">
        <button class="material-symbols-outlined text-[#384e21] active:scale-95 transition-transform" data-icon="search">search</button>
        <a href="<?= $base ?>?url=profile" class="material-symbols-outlined text-[#384e21] scale-95 active:opacity-80 transition-transform">account_circle</a>
        <div class="relative">
          <a href="<?= $base ?>?url=cart" class="material-symbols-outlined text-[#384e21] scale-95 active:opacity-80 transition-transform">shopping_cart</a>
          <span class="absolute -top-2 -right-2 bg-secondary text-on-secondary text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
        </div>
        <button class="md:hidden material-symbols-outlined text-[#384e21]">menu</button>
      </div>
    </div>
  </header>

  <div class="fixed inset-0 z-50 flex items-center justify-center px-6">
    <div class="absolute inset-0 bg-on-surface/10 backdrop-blur-sm"></div>
    <div class="relative eco-glass w-full max-w-xl rounded-xl overflow-hidden shadow-2xl shadow-on-surface/5 flex flex-col items-center text-center p-10 md:p-16">
      <div class="absolute -top-12 -right-12 w-48 h-48 opacity-10 rotate-12 pointer-events-none">
        <img class="w-full h-full object-cover rounded-full" data-alt="lush green leaves of a tropical plant with soft sunlight filtering through in a minimal natural setting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCvruZUxMv4xcg5sPx1P03AQQqmFYERxqKhhXsD-fDCv-0g-o5-Z9NbGtdMtOzCyAhBYvbAUfXe0UyzNvtQCbazilDAxhQUr0_h3-7ReN-UJDJeHadBunWlM7CxPsTFljSx5KjI3QOQEcR8Hqp53Q3ETjcjaUNW1yd4iJbDOLex-ZS2AdHyvCk7Fk5dlK-tBf358qVMRCKRVsYAVDXUhYUK5teLfQv_56ozACguGmByYCq6eu5Bu94LKqeOSZxGN-eXgsPb74HaXI4" />
      </div>

      <div class="mb-8 relative">
        <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-on-primary shadow-xl shadow-primary/20">
          <span class="material-symbols-outlined text-5xl" data-icon="eco" style="font-variation-settings: 'FILL' 1;">eco</span>
        </div>
        <div class="absolute -bottom-2 -right-2 bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase">
          Success
        </div>
      </div>

      <h1 class="font-headline text-4xl md:text-5xl font-extrabold text-primary mb-6 tracking-tighter">Order Successful!</h1>
      <div class="space-y-4 mb-10 max-w-sm">
        <p class="text-on-surface text-lg font-medium">
          Your order <span class="text-primary font-bold">#ZN-884210</span> is confirmed.
        </p>
        <p class="text-on-surface-variant leading-relaxed">
          We are planting a tree for you today! Your conscious choice helps restore forest ecosystems in South America.
        </p>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 w-full">
        <a href="<?= $base ?>?url=order/tracking" class="flex-1 bg-primary text-on-primary py-4 px-8 rounded-lg font-bold hover:opacity-90 transition-all duration-300 scale-95 hover:scale-100 flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-xl" data-icon="local_shipping">local_shipping</span>
          Track Order
        </a>
        <a href="<?= $base ?>" class="flex-1 bg-secondary-container text-on-secondary-container py-4 px-8 rounded-lg font-bold hover:opacity-90 transition-all duration-300 scale-95 hover:scale-100 flex items-center justify-center gap-2">
          Continue Shopping
        </a>
      </div>
    </div>
  </div>

  <main class="flex-grow relative z-10 max-w-5xl mx-auto w-full px-6 py-12 md:py-20">
    <div class="mb-16">
      <h1 class="font-headline text-5xl md:text-6xl font-extrabold text-primary tracking-tighter mb-6 leading-tight">
        Secure Bank Transfer.
      </h1>
      <p class="text-on-surface-variant text-lg md:text-xl max-w-2xl leading-relaxed">
        Thank you for choosing a more sustainable path. Please complete your transaction using the bank details provided below.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
      <div class="lg:col-span-7 space-y-8">
        <div class="bg-surface-container p-8 rounded-xl relative overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
          <p class="text-sm font-semibold uppercase tracking-widest text-primary/70 mb-2 font-label">Unique Reference</p>
          <div class="flex items-baseline gap-4">
            <span class="text-3xl md:text-4xl font-headline font-bold text-primary tracking-tight">ZN-REF-884210</span>
            <button class="material-symbols-outlined text-primary hover:scale-110 transition-transform cursor-pointer" title="Copy Reference">content_copy</button>
          </div>
          <p class="mt-4 text-sm text-on-surface-variant italic">Please include this reference in your bank transfer memo to ensure faster processing.</p>
        </div>

        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm space-y-6">
          <h3 class="font-headline text-xl font-bold text-primary border-b border-outline-variant/30 pb-4">Beneficiary Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
              <label class="text-xs font-bold uppercase tracking-wider text-outline mb-1 block">Account Name</label>
              <p class="text-on-surface font-semibold text-lg">Zentro Sustainable Goods</p>
            </div>
            <div>
              <label class="text-xs font-bold uppercase tracking-wider text-outline mb-1 block">Bank Name</label>
              <p class="text-on-surface font-semibold text-lg">EcoTrust Bank</p>
            </div>
            <div>
              <label class="text-xs font-bold uppercase tracking-wider text-outline mb-1 block">Account Number</label>
              <div class="flex items-center gap-2">
                <p class="text-on-surface font-semibold text-lg">1234-5678-9012</p>
                <button class="material-symbols-outlined text-outline text-sm">content_copy</button>
              </div>
            </div>
            <div>
              <label class="text-xs font-bold uppercase tracking-wider text-outline mb-1 block">Swift / BIC</label>
              <p class="text-on-surface font-semibold text-lg">ECOZUS33</p>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-5 space-y-8">
        <div class="bg-surface-container-high p-8 rounded-xl">
          <h3 class="font-headline text-xl font-bold text-primary mb-8">How to complete</h3>
          <div class="space-y-10">
            <div class="flex gap-6">
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm shadow-md">1</div>
              <div>
                <h4 class="font-bold text-on-surface mb-1">Open bank app</h4>
                <p class="text-sm text-on-surface-variant leading-relaxed">Log in to your preferred mobile banking app or web portal.</p>
              </div>
            </div>
            <div class="flex gap-6">
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm shadow-md">2</div>
              <div>
                <h4 class="font-bold text-on-surface mb-1">Enter details</h4>
                <p class="text-sm text-on-surface-variant leading-relaxed">Copy the account details and reference number exactly as shown.</p>
              </div>
            </div>
            <div class="flex gap-6">
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm shadow-md">3</div>
              <div>
                <h4 class="font-bold text-on-surface mb-1">Upload receipt</h4>
                <p class="text-sm text-on-surface-variant leading-relaxed">Once finished, upload a screenshot or PDF of the transaction confirmation.</p>
              </div>
            </div>
          </div>
          <div class="mt-12 pt-8 border-t border-outline-variant/30">
            <button class="w-full bg-primary text-on-primary py-4 px-6 rounded-lg font-bold flex items-center justify-center gap-3 hover:bg-primary-container hover:text-on-primary-container transition-all shadow-lg active:scale-95 group">
              <span class="material-symbols-outlined group-hover:bounce">cloud_upload</span>
              Upload Receipt
            </button>
            <p class="text-center text-xs text-on-surface-variant mt-4 opacity-70">Accepted formats: JPG, PNG, PDF (Max 5MB)</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="w-full pt-16 pb-8 bg-[#edefe7] dark:bg-stone-800 text-[#384e21] dark:text-[#b5cf95] font-['Be_Vietnam_Pro'] text-sm">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-12 px-8 max-w-7xl mx-auto">
      <div class="col-span-2 md:col-span-1">
        <div class="text-xl font-bold text-[#384e21] mb-6 font-headline tracking-widest uppercase">Zentro</div>
        <p class="text-[#191c18]/60 leading-relaxed mb-6">Sustainable living, simplified. We bring together the world's most ethical brands in one place.</p>
        <div class="flex gap-4">
          <a class="material-symbols-outlined opacity-100 hover:opacity-80 transition-opacity" href="#">public</a>
          <a class="material-symbols-outlined opacity-100 hover:opacity-80 transition-opacity" href="#">nest_eco_leaf</a>
          <a class="material-symbols-outlined opacity-100 hover:opacity-80 transition-opacity" href="#">volunteer_activism</a>
        </div>
      </div>
      <div>
        <h4 class="font-bold text-[#384e21] mb-6">The Shop</h4>
        <ul class="space-y-4">
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="<?= $base ?>">Home Decor</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Skincare</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Fashion</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Zero Waste</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-[#384e21] mb-6">About Us</h4>
        <ul class="space-y-4">
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Our Story</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Sustainability</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="<?= $base ?>?url=blog">Blog</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Careers</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-[#384e21] mb-6">Contact</h4>
        <ul class="space-y-4">
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Shipping</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Privacy Policy</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">Instagram</a></li>
          <li><a class="text-[#191c18]/60 hover:underline decoration-[#384e21]/30 underline-offset-4" href="#">LinkedIn</a></li>
        </ul>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-8 mt-16 pt-8 border-t border-primary/10 flex flex-col md:flex-row justify-between gap-4">
      <div class="text-[#191c18]/60">© 2024 Zentro Sustainable Living. Built for the Earth.</div>
      <div class="flex gap-6">
        <a class="text-[#191c18]/60 hover:text-primary transition-colors" href="#">Terms</a>
        <a class="text-[#191c18]/60 hover:text-primary transition-colors" href="#">Privacy</a>
        <a class="text-[#191c18]/60 hover:text-primary transition-colors" href="#">Cookies</a>
      </div>
    </div>
  </footer>
</body>
</html>