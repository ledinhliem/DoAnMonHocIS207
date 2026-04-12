<?php $currentPage = 'orders'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="p-12 min-h-screen">
    <header class="mb-12">
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-5xl font-black font-headline tracking-tighter text-primary mb-4">Order Queue</h2>
                <p class="text-lg text-on-surface-variant max-w-xl leading-relaxed">
                    Manage your sustainable product fulfillment. Review incoming requests, coordinate eco-packaging, and track global carbon-neutral shipping.
                </p>
            </div>
            <div class="flex gap-4">
                <button
                    type="button"
                    onclick="alert('Pending Carbon Offset: 1,240 kg')"
                    class="bg-surface-container px-6 py-3 rounded-xl flex items-center gap-4 hover:bg-surface-container-high transition-colors"
                >
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/50">Pending Carbon Offset</p>
                        <p class="text-xl font-bold font-headline text-primary">1,240 kg</p>
                    </div>
                    <span class="material-symbols-outlined text-primary-container text-3xl">cloud_done</span>
                </button>
            </div>
        </div>
    </header>

    <section class="grid grid-cols-12 gap-8 mb-12">
        <div class="col-span-12 lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <div class="flex gap-4">
                    <button
                        type="button"
                        onclick="switchOrderTab('active', this)"
                        class="order-tab-btn px-6 py-2 bg-primary text-on-primary rounded-full text-sm font-semibold"
                    >
                        Active Orders (14)
                    </button>
                    <button
                        type="button"
                        onclick="switchOrderTab('archived', this)"
                        class="order-tab-btn px-6 py-2 bg-surface-container text-on-surface-variant rounded-full text-sm font-semibold hover:bg-surface-container-high transition-colors"
                    >
                        Archived
                    </button>
                </div>

                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/40">search</span>
                    <input
                        id="order-search"
                        oninput="filterOrders()"
                        class="pl-10 pr-4 py-2 bg-surface-container border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20 w-64 transition-all"
                        placeholder="Search order ID or customer..."
                        type="text"
                    />
                </div>
            </div>

            <div id="order-list" class="space-y-4">
                <div class="order-card bg-surface-container-lowest p-6 rounded-xl group transition-all hover:bg-white border border-transparent hover:border-outline-variant/20 shadow-sm"
                     data-order-id="ZN-49201"
                     data-customer="Elena Gilbert"
                     data-status="active">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-6">
                            <div class="w-20 h-20 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                                <img alt="Eco Bamboo Set" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDD-gNyLNjUnSB4VuSyA2b4OIlIz1SfWHbBepT-12aGiGMB9M5m5Q-hBSs7aaMXUh7vN-gLppTul0NpX8ljfJU5ocJFC78AqtFzEm6fZ8eYT8bRxV8v7AJN60IQY8oflxACzyKbbqp3NLG42pRjUcJ1JTyt_j8FR53uZa0S0fRHr-enyWhN6RThM--Y6TQiYqPK04prx7Of0DYQAlihpfzI9Q0ercPCFQnR4ps64Yp7tQp2Kxyp5CEGccX--TxN3EFHOeEVM_zTrVY"/>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-[10px] font-bold tracking-widest text-on-surface-variant/40 uppercase">#ZN-49201</span>
                                    <span class="bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded text-[10px] font-bold uppercase">Processing</span>
                                </div>
                                <h3 class="text-xl font-bold font-headline text-on-surface">Artisan Bamboo Dining Set</h3>
                                <p class="text-sm text-on-surface-variant mt-1">
                                    Ordered by <span class="font-semibold text-primary">Elena Gilbert</span> • 2 items
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xl font-bold font-headline mb-2">$84.50</p>
                            <div class="flex gap-2 justify-end">
                                <button
                                    type="button"
                                    onclick="alert('Print invoice for #ZN-49201')"
                                    class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors"
                                >
                                    <span class="material-symbols-outlined">print</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="alert('Update status for #ZN-49201')"
                                    class="bg-primary px-4 py-2 text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 hover:opacity-90"
                                >
                                    Update Status <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card bg-surface-container-lowest p-6 rounded-xl group transition-all hover:bg-white border border-transparent hover:border-outline-variant/20 shadow-sm"
                     data-order-id="ZN-49188"
                     data-customer="Marcus Thorne"
                     data-status="active">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-6">
                            <div class="w-20 h-20 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                                <img alt="Recycled Glass Vases" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBG3oJgsID_ax6IPNGd4AeeJOmS8ctRPZfDA7za8EI17W7szFgul6ZTuX-y37t28oW6nWkNAC5wi7HVHgSLw8gyrVK38b5FPysrd8oaDMMkoxrbI8j7w-rM8HgeNAxtOjtqKNpSnVcj574ZGVUCrd9mjm9Np5Ey7--YOqH2-ppd4a_fKfj6DwvsHk8enFkyzpG8us0aKji-unAimEdvIKmFt8zobTEgS359IfzuUVqc43o_MiuvRcegttiXYUedrCBNpazOUsdZsJo"/>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-[10px] font-bold tracking-widest text-on-surface-variant/40 uppercase">#ZN-49188</span>
                                    <span class="bg-primary-container text-on-primary-container px-2 py-0.5 rounded text-[10px] font-bold uppercase">Pending</span>
                                </div>
                                <h3 class="text-xl font-bold font-headline text-on-surface">Recycled Sea-Glass Collection</h3>
                                <p class="text-sm text-on-surface-variant mt-1">
                                    Ordered by <span class="font-semibold text-primary">Marcus Thorne</span> • 1 item
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xl font-bold font-headline mb-2">$142.00</p>
                            <div class="flex gap-2 justify-end">
                                <button
                                    type="button"
                                    onclick="alert('Print invoice for #ZN-49188')"
                                    class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors"
                                >
                                    <span class="material-symbols-outlined">print</span>
                                </button>
                                <button
                                    type="button"
                                    onclick="alert('Update status for #ZN-49188')"
                                    class="bg-primary px-4 py-2 text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 hover:opacity-90"
                                >
                                    Update Status <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card bg-surface-container-lowest p-6 rounded-xl group transition-all hover:bg-white border border-transparent hover:border-outline-variant/20 shadow-sm opacity-60"
                     data-order-id="ZN-49185"
                     data-customer="Sarah Jenkins"
                     data-status="archived">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-6">
                            <div class="w-20 h-20 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                                <img alt="Hemp Yoga Mat" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBZf2eNUiEGKM5C9O-2yl3X0PWN_YSaXCSlKT6DgGIF58yadGLceigrlx0mlxGW9apuZWmDVbgSZnQIHq_jIXTQHQkeaaagKZMzmWZDU90JqIhFE4f8o8gb2tmlqUrcQSf82H_Xre6SvU8rFMVB5DAsKw0kaBXFy7zDIlrxGAxAlJri2xdEgMn55jJUvGFMtyZi6iUWcRv4poyEUd13OIPhAs7ZRRpExbF3g2VW8-Vw3Dk2U5vv2WfJljUbhG9Ze9exGwM7aMMg_RE"/>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-[10px] font-bold tracking-widest text-on-surface-variant/40 uppercase">#ZN-49185</span>
                                    <span class="bg-surface-container-highest text-on-surface-variant px-2 py-0.5 rounded text-[10px] font-bold uppercase">Shipped</span>
                                </div>
                                <h3 class="text-xl font-bold font-headline text-on-surface">Organic Hemp Yoga Mat</h3>
                                <p class="text-sm text-on-surface-variant mt-1">
                                    Ordered by <span class="font-semibold text-primary">Sarah Jenkins</span> • 1 item
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xl font-bold font-headline mb-2">$65.00</p>
                            <div class="flex gap-2 justify-end">
                                <span class="text-xs font-semibold text-on-surface-variant/60">Tracking: #ZT99281X</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <aside class="col-span-12 lg:col-span-4 space-y-8">
            <button
                type="button"
                onclick="alert('Fulfillment Health\\n\\nPackaging Workflow: 78%\\nAvg. Prep Time: 4.2h\\nRecycled Ratio: 94%')"
                class="bg-surface-container p-8 rounded-2xl w-full text-left hover:bg-surface-container-high transition-colors"
            >
                <h4 class="font-headline font-bold text-xl mb-6">Fulfillment Health</h4>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Packaging Workflow</span>
                            <span class="font-bold">78%</span>
                        </div>
                        <div class="h-2 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary w-[78%]"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-surface-container-lowest p-4 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant/50 mb-1 tracking-widest">Avg. Prep Time</p>
                            <p class="text-2xl font-black font-headline text-primary">4.2h</p>
                        </div>
                        <div class="bg-surface-container-lowest p-4 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant/50 mb-1 tracking-widest">Recycled Ratio</p>
                            <p class="text-2xl font-black font-headline text-primary">94%</p>
                        </div>
                    </div>
                </div>
            </button>

            <div class="bg-primary text-on-primary p-8 rounded-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-headline font-bold text-xl mb-2">Inventory Alert</h4>
                    <p class="text-sm opacity-80 mb-6 leading-relaxed">
                        Sustainable beeswax wraps are running low. 12 orders currently pending restock.
                    </p>
                    <button
                        type="button"
                        onclick="alert('Reorder stock mock action')"
                        class="w-full bg-surface-container-lowest text-primary py-3 rounded-xl font-bold text-sm hover:scale-105 transition-transform"
                    >
                        Reorder Stock
                    </button>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-10">
                    <span class="material-symbols-outlined text-9xl">warning</span>
                </div>
            </div>

            <div class="p-6 border border-outline-variant/30 rounded-2xl">
                <h4 class="font-headline font-bold text-lg mb-4">Recent Logistics Log</h4>
                <ul class="space-y-4">
                    <li>
                        <button
                            type="button"
                            onclick="alert('DHL Carbon-Neutral pickup\\nConfirmed for 14:00 today')"
                            class="w-full flex gap-4 text-left"
                        >
                            <div class="w-2 h-2 rounded-full bg-primary mt-2"></div>
                            <div>
                                <p class="text-sm font-bold">DHL Carbon-Neutral pickup</p>
                                <p class="text-xs text-on-surface-variant">Confirmed for 14:00 today</p>
                            </div>
                        </button>
                    </li>
                    <li>
                        <button
                            type="button"
                            onclick="alert('New Shipping Route\\nPort of Oslo route optimized')"
                            class="w-full flex gap-4 text-left"
                        >
                            <div class="w-2 h-2 rounded-full bg-secondary mt-2"></div>
                            <div>
                                <p class="text-sm font-bold">New Shipping Route</p>
                                <p class="text-xs text-on-surface-variant">Port of Oslo route optimized</p>
                            </div>
                        </button>
                    </li>
                </ul>
            </div>
        </aside>
    </section>
</div>

<script>
    function switchOrderTab(tab, button) {
        const cards = document.querySelectorAll('.order-card');
        const buttons = document.querySelectorAll('.order-tab-btn');

        buttons.forEach(btn => {
            btn.classList.remove('bg-primary', 'text-on-primary');
            btn.classList.add('bg-surface-container', 'text-on-surface-variant');
        });

        button.classList.remove('bg-surface-container', 'text-on-surface-variant');
        button.classList.add('bg-primary', 'text-on-primary');

        cards.forEach(card => {
            if (tab === 'active') {
                card.style.display = card.dataset.status === 'active' ? 'block' : 'none';
            } else {
                card.style.display = card.dataset.status === 'archived' ? 'block' : 'none';
            }
        });
    }

    function filterOrders() {
        const keyword = document.getElementById('order-search').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.order-card');

        cards.forEach(card => {
            const orderId = card.dataset.orderId.toLowerCase();
            const customer = card.dataset.customer.toLowerCase();

            if (orderId.includes(keyword) || customer.includes(keyword)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>