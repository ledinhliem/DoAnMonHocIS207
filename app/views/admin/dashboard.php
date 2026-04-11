<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-50">
    <div class="px-6 mb-10">
        <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
        <p class="font-['Be_Vietnam_Pro'] font-medium text-xs text-[#191c18]/60 uppercase tracking-widest mt-1">Eco-Management Suite</p>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto">
        <!-- Dashboard (Active) -->
        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform" href="#">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Dashboard</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Inventory</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Suppliers</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="eco">eco</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Products</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="shopping_basket">shopping_basket</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Orders</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="rate_review">rate_review</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Reviews</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="article">article</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Blog</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined" data-icon="settings">settings</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Settings</span>
        </a>
    </nav>

    <div class="px-4 mt-auto">
        <button class="w-full py-3 bg-primary text-white rounded-lg font-['Be_Vietnam_Pro'] font-semibold text-sm shadow-md hover:bg-primary-container transition-colors duration-300">
            Export Reports
        </button>
        <div class="flex items-center gap-3 mt-8 p-2 border-t border-[#c5c8ba]/20 pt-6">
            <div class="w-10 h-10 rounded-full bg-primary-fixed-dim overflow-hidden">
                <img alt="Admin User Profile" class="w-full h-full object-cover" data-alt="close up professional headshot of a mature man with graying hair and a warm smile in high key studio lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbrN5cn3E-UDob9IZLUL-pFCzI7o9aPZF722Ex9MNz87g_SvNUGb039acifN8MLJ_zvHrnzbDluplhUeITFatUS9howejDSmYSZVnIHt9CorW7WMNv9sSUdSG9ISO8e2QwKaMEkoU6gAjO462zbkE5NULTjcqkiysttrbr0igUQypVlcXLQGtu_TWTLIcggduuHzXONKgWKUOvQykcb33wzYDZ0-D70Kn_4JemtZOdLnHnU6Eb87vXE4d0ntWezfAG5Y9rAjFoHYQ"/>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface">Alex River</p>
                <p class="text-xs text-on-surface/50">Chief Sustainability Officer</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content Area -->
<main class="ml-64 p-12 max-w-[1400px]">
    <!-- Header Section -->
    <header class="mb-16">
        <h2 class="font-headline text-5xl font-black text-primary tracking-tight mb-4">Sustainability Overview</h2>
        <p class="text-lg text-on-surface/70 max-w-2xl leading-relaxed">
            Welcome back, Alex. Your eco-impact initiatives are driving a 12% increase in conscious consumerism this quarter.
        </p>
    </header>

    <!-- Stats Bento Grid -->
    <div class="grid grid-cols-12 gap-8 mb-12">
        <!-- Revenue Line Chart Card -->
        <div class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <p class="text-on-surface/50 font-medium text-sm mb-1">Total Revenue (USD)</p>
                    <h3 class="text-4xl font-headline font-bold text-primary">$142,850.00</h3>
                </div>
                <div class="flex gap-4">
                    <span class="flex items-center text-primary font-bold text-sm bg-primary-fixed-dim/20 px-3 py-1 rounded-full">
                        <span class="material-symbols-outlined text-sm mr-1" data-icon="trending_up">trending_up</span>
                        +18.4%
                    </span>
                </div>
            </div>

            <!-- Mockup Line Chart -->
            <div class="h-64 flex items-end justify-between gap-2 pt-4 relative">
                <!-- Subtle Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none border-b border-outline-variant/10">
                    <div class="w-full border-t border-outline-variant/5"></div>
                    <div class="w-full border-t border-outline-variant/5"></div>
                    <div class="w-full border-t border-outline-variant/5"></div>
                </div>

                <!-- Decorative Chart Path -->
                <svg class="absolute inset-0 w-full h-full" preserveaspectratio="none">
                    <path d="M0,200 Q100,180 200,120 T400,140 T600,60 T800,40" fill="none" stroke="#384e21" stroke-linecap="round" stroke-width="4"></path>
                    <lineargradient id="grad1" x1="0%" x2="0%" y1="0%" y2="100%">
                        <stop offset="0%" style="stop-color:rgba(56, 78, 33, 0.2);stop-opacity:1"></stop>
                        <stop offset="100%" style="stop-color:rgba(56, 78, 33, 0);stop-opacity:0"></stop>
                    </lineargradient>
                    <path d="M0,200 Q100,180 200,120 T400,140 T600,60 T800,40 L800,250 L0,250 Z" fill="url(#grad1)"></path>
                </svg>

                <!-- Labels -->
                <div class="absolute bottom-[-2rem] left-0 right-0 flex justify-between text-xs text-on-surface/40 font-medium">
                    <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span>
                </div>
            </div>
        </div>

        <!-- Number of Orders Card -->
        <div class="col-span-12 lg:col-span-4 bg-primary text-white rounded-xl p-8 relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10">
                <p class="text-white/70 font-medium text-sm mb-1">Active Orders</p>
                <h3 class="text-5xl font-headline font-black mb-4">1,284</h3>
                <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg border border-white/10">
                    <span class="material-symbols-outlined mr-2" data-icon="package_2">package_2</span>
                    <span class="text-xs font-semibold">98% ON-TIME DELIVERY</span>
                </div>
            </div>

            <!-- Decorative Graphic -->
            <div class="absolute bottom-[-20px] right-[-20px] opacity-10">
                <span class="material-symbols-outlined text-[12rem]" data-icon="shopping_bag">shopping_bag</span>
            </div>

            <div class="mt-8 pt-8 border-t border-white/10">
                <p class="text-xs text-white/50 mb-3">Live Fleet Status</p>
                <div class="flex -space-x-2">
                    <img alt="Driver 1" class="w-8 h-8 rounded-full border-2 border-primary" data-alt="close up portrait of a male delivery driver wearing a green polo shirt with a friendly expression" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCR0Be6D51pcml8vQx4Wz34W2QZQSON9SqET5GnrKeP865Xrk0FDg0neRBhZ1nIDCWOVAF8v43EgDYhV_IYiT9vDLWqdAm-Vffd5KZIhFHdoOOBzj5L9uzNYjCCXTahMECgyPF6nX0eDQT2rqDScOV4inrCpsBJ7R3SFFztvwHqZLQkMDmfXUC3KYWxiFeMV-9wG4qrbzht90-65P6TCtCfEMaJwY7TeM3Y-O5sPh_W-el8dXI717vj1JneuK_xrGqMUwXIIYy68Ms"/>
                    <img alt="Driver 2" class="w-8 h-8 rounded-full border-2 border-primary" data-alt="portrait of a young female logistics manager with a confident look in soft natural lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAelQ_vQQBH9ZGtLHBc-iEAcJJwfQwvhikpHyLBXUeNwuhhSfjLScRF6gTY8BPWDX2M5HRCO5Qz5G6jt0OK6690BTo6uveLOHwPG1WYpJTY86Bz8dKWL58J3Tf_GSxSW-KUXDNKmtGKtKcrRpRroQXpzC8XjivkRbZajaqIzkZ6WQVkEFVUN9Yv3iv1T0iOQzBtTEaDLJYYbeOS3SU9aclgCxMQNJ26V6jirOlm2DRESB07LqXrzYE-V2NOaDdjhoY_mXNKSeX0GJU"/>
                    <img alt="Driver 3" class="w-8 h-8 rounded-full border-2 border-primary" data-alt="headshot of a man with spectacles looking thoughtful in an office environment with neutral tones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMwm_rUOiAWYYlIGNct4pqZwv-MBuj4Ic5TihOb2G5sweyUBmFe4YX6gHMSM_1hD3ca3GAPXIDwNBIsuvQc1-Y6o7iFN_YNcPhaap66sYp_OwourwyBNf-Akk1-si9if-L6TzKnrRya6HVeWy6aRzAi5cjSB0lJSSWDyOcv6bsD4GKk01OCZMSNsiNOhzkXbhjFz3nzu0tknVZwAaaVitjtlDjW_D7zc_vd30N7Tm1v2YiWMtTV9D2Ng_IgTsp5JkyHvAi0YwW5LI"/>
                    <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-primary flex items-center justify-center text-[10px] font-bold">+12</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Section: Discount Management -->
    <section class="mt-20">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h4 class="font-headline text-3xl font-bold text-primary mb-2">Promotion Management</h4>
                <p class="text-on-surface/60">Drive seasonal growth through conscious consumption rewards.</p>
            </div>
            <button class="flex items-center gap-2 bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-on-secondary-container transition-all">
                <span class="material-symbols-outlined" data-icon="add">add</span>
                Create New Discount
            </button>
        </div>

        <!-- Promotion Bento/Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Promo Card 1 -->
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all group">
                <div class="flex justify-between items-start mb-6">
                    <div class="bg-primary-fixed-dim/30 p-3 rounded-lg text-primary">
                        <span class="material-symbols-outlined text-3xl" data-icon="redeem">redeem</span>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded">ACTIVE</span>
                </div>
                <h5 class="text-xl font-headline font-bold mb-1">EARTHDAY24</h5>
                <p class="text-sm text-on-surface/50 mb-6">25% Off sitewide for sustainable items.</p>
                <div class="flex justify-between items-center py-4 border-t border-outline-variant/10">
                    <div>
                        <p class="text-[10px] text-on-surface/40 uppercase font-bold tracking-tighter">Usage</p>
                        <p class="font-bold text-on-surface">452 / 1000</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 text-on-surface/60 hover:text-primary"><span class="material-symbols-outlined" data-icon="edit">edit</span></button>
                        <button class="p-2 text-on-surface/60 hover:text-error"><span class="material-symbols-outlined" data-icon="delete">delete</span></button>
                    </div>
                </div>
            </div>

            <!-- Promo Card 2 -->
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="bg-secondary-fixed/30 p-3 rounded-lg text-secondary">
                        <span class="material-symbols-outlined text-3xl" data-icon="eco">eco</span>
                    </div>
                    <span class="text-[10px] font-bold tracking-widest text-on-surface/40 bg-surface-variant px-2 py-1 rounded uppercase">Scheduled</span>
                </div>
                <h5 class="text-xl font-headline font-bold mb-1">NEWRECYCLE</h5>
                <p class="text-sm text-on-surface/50 mb-6">$10 Credit for recycling old items.</p>
                <div class="flex justify-between items-center py-4 border-t border-outline-variant/10">
                    <div>
                        <p class="text-[10px] text-on-surface/40 uppercase font-bold tracking-tighter">Starts</p>
                        <p class="font-bold text-on-surface">Sept 12, 2024</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 text-on-surface/60 hover:text-primary"><span class="material-symbols-outlined" data-icon="edit">edit</span></button>
                        <button class="p-2 text-on-surface/60 hover:text-error"><span class="material-symbols-outlined" data-icon="delete">delete</span></button>
                    </div>
                </div>
            </div>

            <!-- Promo Card 3 (Bento Visual Filler) -->
            <div class="bg-surface-container-highest rounded-xl p-8 flex flex-col items-center justify-center text-center border-2 border-dashed border-outline-variant">
                <span class="material-symbols-outlined text-5xl text-outline-variant mb-4" data-icon="loyalty">loyalty</span>
                <p class="font-headline font-bold text-on-surface/40">Launch a loyalty tier to increase retention by up to 30%</p>
                <button class="mt-6 text-sm font-bold text-primary underline underline-offset-4">Explore Loyalty Suite</button>
            </div>
        </div>
    </section>

    <!-- Footer Section (Internal) -->
    <footer class="flex flex-col md:flex-row justify-between items-center px-0 py-16 mt-20 border-t border-[#c5c8ba]/10">
        <div class="mb-4 md:mb-0">
            <span class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</span>
            <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2024 Zentro Sustainable Living. Crafted for the conscious.</p>
        </div>
        <div class="flex gap-8">
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Privacy Policy</a>
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Terms of Service</a>
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Contact Us</a>
        </div>
    </footer>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>