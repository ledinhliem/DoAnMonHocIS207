<?php $currentPage = 'dashboard'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="p-12 max-w-[1400px] min-h-screen">
    <header class="mb-16">
        <h2 class="font-headline text-5xl font-black text-primary tracking-tight mb-4">Sustainability Overview</h2>
        <p class="text-lg text-on-surface/70 max-w-2xl leading-relaxed">
            Welcome back, Alex. Your eco-impact initiatives are driving a 12% increase in conscious consumerism this quarter.
        </p>
    </header>

    <div class="grid grid-cols-12 gap-8 mb-12">
        <button
            type="button"
            onclick="alert('Revenue overview mock chart')"
            class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-xl p-8 shadow-sm text-left hover:shadow-md transition-shadow"
        >
            <div class="flex justify-between items-end mb-8">
                <div>
                    <p class="text-on-surface/50 font-medium text-sm mb-1">Total Revenue (USD)</p>
                    <h3 class="text-4xl font-headline font-bold text-primary">$142,850.00</h3>
                </div>
                <div class="flex gap-4">
                    <span class="flex items-center text-primary font-bold text-sm bg-primary-fixed-dim/20 px-3 py-1 rounded-full">
                        <span class="material-symbols-outlined text-sm mr-1">trending_up</span>
                        +18.4%
                    </span>
                </div>
            </div>

            <div class="h-64 flex items-end justify-between gap-2 pt-4 relative">
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none border-b border-outline-variant/10">
                    <div class="w-full border-t border-outline-variant/5"></div>
                    <div class="w-full border-t border-outline-variant/5"></div>
                    <div class="w-full border-t border-outline-variant/5"></div>
                </div>

                <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none">
                    <path d="M0,200 Q100,180 200,120 T400,140 T600,60 T800,40" fill="none" stroke="#384e21" stroke-linecap="round" stroke-width="4"></path>
                    <linearGradient id="grad1" x1="0%" x2="0%" y1="0%" y2="100%">
                        <stop offset="0%" style="stop-color:rgba(56, 78, 33, 0.2);stop-opacity:1"></stop>
                        <stop offset="100%" style="stop-color:rgba(56, 78, 33, 0);stop-opacity:0"></stop>
                    </linearGradient>
                    <path d="M0,200 Q100,180 200,120 T400,140 T600,60 T800,40 L800,250 L0,250 Z" fill="url(#grad1)"></path>
                </svg>

                <div class="absolute bottom-[-2rem] left-0 right-0 flex justify-between text-xs text-on-surface/40 font-medium">
                    <span>JAN</span><span>FEB</span><span>MAR</span><span>APR</span><span>MAY</span><span>JUN</span><span>JUL</span>
                </div>
            </div>
        </button>

        <button
            type="button"
            onclick="window.location.href='index.php?url=admin/orders'"
            class="col-span-12 lg:col-span-4 bg-primary text-white rounded-xl p-8 relative overflow-hidden flex flex-col justify-between text-left hover:opacity-95 transition-opacity"
        >
            <div class="relative z-10">
                <p class="text-white/70 font-medium text-sm mb-1">Active Orders</p>
                <h3 class="text-5xl font-headline font-black mb-4">1,284</h3>
                <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg border border-white/10">
                    <span class="material-symbols-outlined mr-2">package_2</span>
                    <span class="text-xs font-semibold">98% ON-TIME DELIVERY</span>
                </div>
            </div>

            <div class="absolute bottom-[-20px] right-[-20px] opacity-10">
                <span class="material-symbols-outlined text-[12rem]">shopping_bag</span>
            </div>

            <div class="mt-8 pt-8 border-t border-white/10">
                <p class="text-xs text-white/50 mb-3">Live Fleet Status</p>
                <div class="flex -space-x-2">
                    <img alt="Driver 1" class="w-8 h-8 rounded-full border-2 border-primary" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCR0Be6D51pcml8vQx4Wz34W2QZQSON9SqET5GnrKeP865Xrk0FDg0neRBhZ1nIDCWOVAF8v43EgDYhV_IYiT9vDLWqdAm-Vffd5KZIhFHdoOOBzj5L9uzNYjCCXTahMECgyPF6nX0eDQT2rqDScOV4inrCpsBJ7R3SFFztvwHqZLQkMDmfXUC3KYWxiFeMV-9wG4qrbzht90-65P6TCtCfEMaJwY7TeM3Y-O5sPh_W-el8dXI717vj1JneuK_xrGqMUwXIIYy68Ms"/>
                    <img alt="Driver 2" class="w-8 h-8 rounded-full border-2 border-primary" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAelQ_vQQBH9ZGtLHBc-iEAcJJwfQwvhikpHyLBXUeNwuhhSfjLScRF6gTY8BPWDX2M5HRCO5Qz5G6jt0OK6690BTo6uveLOHwPG1WYpJTY86Bz8dKWL58J3Tf_GSxSW-KUXDNKmtGKtKcrRpRroQXpzC8XjivkRbZajaqIzkZ6WQVkEFVUN9Yv3iv1T0iOQzBtTEaDLJYYbeOS3SU9aclgCxMQNJ26V6jirOlm2DRESB07LqXrzYE-V2NOaDdjhoY_mXNKSeX0GJU"/>
                    <img alt="Driver 3" class="w-8 h-8 rounded-full border-2 border-primary" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMwm_rUOiAWYYlIGNct4pqZwv-MBuj4Ic5TihOb2G5sweyUBmFe4YX6gHMSM_1hD3ca3GAPXIDwNBIsuvQc1-Y6o7iFN_YNcPhaap66sYp_OwourwyBNf-Akk1-si9if-L6TzKnrRya6HVeWy6aRzAi5cjSB0lJSSWDyOcv6bsD4GKk01OCZMSNsiNOhzkXbhjFz3nzu0tknVZwAaaVitjtlDjW_D7zc_vd30N7Tm1v2YiWMtTV9D2Ng_IgTsp5JkyHvAi0YwW5LI"/>
                    <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-primary flex items-center justify-center text-[10px] font-bold">+12</div>
                </div>
            </div>
        </button>
    </div>

    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-20">
        <button
            type="button"
            onclick="window.location.href='index.php?url=admin/products'"
            class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all text-left"
        >
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">eco</span>
                <span class="text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded">GO</span>
            </div>
            <h4 class="text-xl font-headline font-bold text-primary mb-2">Products</h4>
            <p class="text-sm text-on-surface/60">Manage product catalog, edit items, and review stock labels.</p>
        </button>

        <button
            type="button"
            onclick="window.location.href='index.php?url=admin/inventory'"
            class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all text-left"
        >
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">inventory_2</span>
                <span class="text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded">GO</span>
            </div>
            <h4 class="text-xl font-headline font-bold text-primary mb-2">Inventory</h4>
            <p class="text-sm text-on-surface/60">Track warehouse entries, supplier flow, and stock alerts.</p>
        </button>

        <button
            type="button"
            onclick="window.location.href='index.php?url=admin/reviews'"
            class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all text-left"
        >
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">rate_review</span>
                <span class="text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded">GO</span>
            </div>
            <h4 class="text-xl font-headline font-bold text-primary mb-2">Reviews</h4>
            <p class="text-sm text-on-surface/60">Monitor customer feedback and review moderation UI.</p>
        </button>

        <button
            type="button"
            onclick="window.location.href='index.php?url=admin/blog'"
            class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all text-left"
        >
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">article</span>
                <span class="text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded">GO</span>
            </div>
            <h4 class="text-xl font-headline font-bold text-primary mb-2">Blog</h4>
            <p class="text-sm text-on-surface/60">Manage content publishing, post cards, and editorial flow.</p>
        </button>
    </section>

    <section class="mt-20">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h4 class="font-headline text-3xl font-bold text-primary mb-2">Promotion Management</h4>
                <p class="text-on-surface/60">Drive seasonal growth through conscious consumption rewards.</p>
            </div>
            <button
                type="button"
                onclick="alert('Create New Discount mock modal')"
                class="flex items-center gap-2 bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-on-secondary-container transition-all"
            >
                <span class="material-symbols-outlined">add</span>
                Create New Discount
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all group">
                <div class="flex justify-between items-start mb-6">
                    <div class="bg-primary-fixed-dim/30 p-3 rounded-lg text-primary">
                        <span class="material-symbols-outlined text-3xl">redeem</span>
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
                        <button type="button" onclick="alert('Edit promotion: EARTHDAY24')" class="p-2 text-on-surface/60 hover:text-primary">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                        <button type="button" onclick="alert('Delete promotion: EARTHDAY24')" class="p-2 text-on-surface/60 hover:text-error">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="bg-secondary-fixed/30 p-3 rounded-lg text-secondary">
                        <span class="material-symbols-outlined text-3xl">eco</span>
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
                        <button type="button" onclick="alert('Edit promotion: NEWRECYCLE')" class="p-2 text-on-surface/60 hover:text-primary">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                        <button type="button" onclick="alert('Delete promotion: NEWRECYCLE')" class="p-2 text-on-surface/60 hover:text-error">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-highest rounded-xl p-8 flex flex-col items-center justify-center text-center border-2 border-dashed border-outline-variant">
                <span class="material-symbols-outlined text-5xl text-outline-variant mb-4">loyalty</span>
                <p class="font-headline font-bold text-on-surface/40">Launch a loyalty tier to increase retention by up to 30%</p>
                <button
                    type="button"
                    onclick="alert('Explore Loyalty Suite mock page')"
                    class="mt-6 text-sm font-bold text-primary underline underline-offset-4"
                >
                    Explore Loyalty Suite
                </button>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>