<?php $currentPage = 'inventory'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="p-8 min-h-screen">
    <header class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-4xl font-extrabold font-headline tracking-tight text-primary">Inventory Logistics</h2>
            <p class="text-on-surface-variant mt-2 max-w-lg">
                Manage your sustainable supply chain ecosystem. Track warehouse entries and supplier relations with precision.
            </p>
        </div>
        <div class="flex gap-4">
            <button
                type="button"
                onclick="alert('Filter mock UI')"
                class="bg-surface-container-high px-6 py-3 rounded-xl font-bold text-primary flex items-center gap-2 hover:bg-surface-container-highest transition-colors"
            >
                <span class="material-symbols-outlined text-xl">filter_list</span>
                Filter
            </button>
            <button
                type="button"
                onclick="document.getElementById('supplier-form-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                class="bg-secondary-container text-on-secondary-container px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-sm"
            >
                <span class="material-symbols-outlined text-xl">add</span>
                New Entry
            </button>
        </div>
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-headline text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">list_alt</span>
                        Warehouse Entry Records (PHIEUNHAP)
                    </h3>
                    <span class="text-xs font-semibold bg-primary/10 text-primary px-3 py-1 rounded-full uppercase tracking-wider">Live Logs</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">
                                <th class="pb-2 px-4">Entry ID</th>
                                <th class="pb-2 px-4">Date Arrival</th>
                                <th class="pb-2 px-4">Supplier</th>
                                <th class="pb-2 px-4">Total Value</th>
                                <th class="pb-2 px-4">Status</th>
                                <th class="pb-2 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors group">
                                <td class="py-4 px-4 rounded-l-2xl font-bold text-primary">#PN-8821</td>
                                <td class="py-4 px-4 text-sm">Oct 24, 2023</td>
                                <td class="py-4 px-4 font-medium">Bamboo Collective</td>
                                <td class="py-4 px-4 font-bold">$4,250.00</td>
                                <td class="py-4 px-4">
                                    <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Verified</span>
                                </td>
                                <td class="py-4 px-4 rounded-r-2xl text-right">
                                    <div class="relative inline-block text-left">
                                        <button
                                            type="button"
                                            class="text-primary opacity-100 transition-opacity p-1 rounded hover:bg-surface-container-high"
                                            onclick="toggleInventoryMenu(this)"
                                        >
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </button>

                                        <div class="hidden absolute right-0 top-10 bg-white border border-[#c5c8ba]/40 rounded-xl shadow-lg min-w-[140px] z-30 inventory-action-menu">
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('View #PN-8821')">
                                                View
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('Edit #PN-8821')">
                                                Edit
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-[#fdf2f2]" onclick="inventoryAction('Delete #PN-8821')">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors group">
                                <td class="py-4 px-4 rounded-l-2xl font-bold text-primary">#PN-8822</td>
                                <td class="py-4 px-4 text-sm">Oct 25, 2023</td>
                                <td class="py-4 px-4 font-medium">EcoFabric Co.</td>
                                <td class="py-4 px-4 font-bold">$12,800.00</td>
                                <td class="py-4 px-4">
                                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Pending</span>
                                </td>
                                <td class="py-4 px-4 rounded-r-2xl text-right">
                                    <div class="relative inline-block text-left">
                                        <button
                                            type="button"
                                            class="text-primary opacity-100 transition-opacity p-1 rounded hover:bg-surface-container-high"
                                            onclick="toggleInventoryMenu(this)"
                                        >
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </button>

                                        <div class="hidden absolute right-0 top-10 bg-white border border-[#c5c8ba]/40 rounded-xl shadow-lg min-w-[140px] z-30 inventory-action-menu">
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('View #PN-8822')">
                                                View
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('Edit #PN-8822')">
                                                Edit
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-[#fdf2f2]" onclick="inventoryAction('Delete #PN-8822')">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors group">
                                <td class="py-4 px-4 rounded-l-2xl font-bold text-primary">#PN-8823</td>
                                <td class="py-4 px-4 text-sm">Oct 26, 2023</td>
                                <td class="py-4 px-4 font-medium">Organic Threads</td>
                                <td class="py-4 px-4 font-bold">$2,100.00</td>
                                <td class="py-4 px-4">
                                    <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Verified</span>
                                </td>
                                <td class="py-4 px-4 rounded-r-2xl text-right">
                                    <div class="relative inline-block text-left">
                                        <button
                                            type="button"
                                            class="text-primary opacity-100 transition-opacity p-1 rounded hover:bg-surface-container-high"
                                            onclick="toggleInventoryMenu(this)"
                                        >
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </button>

                                        <div class="hidden absolute right-0 top-10 bg-white border border-[#c5c8ba]/40 rounded-xl shadow-lg min-w-[140px] z-30 inventory-action-menu">
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('View #PN-8823')">
                                                View
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm hover:bg-[#f3f4ed]" onclick="inventoryAction('Edit #PN-8823')">
                                                Edit
                                            </button>
                                            <button type="button" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-[#fdf2f2]" onclick="inventoryAction('Delete #PN-8823')">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="supplier-form-section" class="bg-surface-container-low rounded-3xl p-8 border border-outline-variant/10">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">add_business</span>
                    Register New Supplier (NHACUNGCAP)
                </h3>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6" onsubmit="event.preventDefault(); alert('Register supplier mock submitted');">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Supplier Name</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="e.g. Nordic Timber Ltd." type="text"/>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">VAT/Tax ID</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="VAT-99230-22" type="text"/>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Primary Category</label>
                        <select class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                            <option>Sustainable Textiles</option>
                            <option>Raw Materials</option>
                            <option>Packaging</option>
                            <option>Renewable Energy Parts</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Location</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="City, Country" type="text"/>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold shadow-md hover:scale-[1.02] active:scale-95 transition-all w-full md:w-auto" type="submit">
                            Confirm &amp; Register Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <h3 class="text-xl font-bold font-headline text-primary mb-6">Supplier Network</h3>

                <div class="space-y-6">
                    <button type="button" onclick="openSupplierDetail('Bamboo Collective')" class="w-full flex items-center justify-between group text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold">BC</div>
                            <div>
                                <p class="font-bold text-sm">Bamboo Collective</p>
                                <p class="text-xs text-on-surface-variant">Hanoi, Vietnam</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                    </button>

                    <button type="button" onclick="openSupplierDetail('EcoFabric Co.')" class="w-full flex items-center justify-between group text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold">EF</div>
                            <div>
                                <p class="font-bold text-sm">EcoFabric Co.</p>
                                <p class="text-xs text-on-surface-variant">Porto, Portugal</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                    </button>

                    <button type="button" onclick="openSupplierDetail('Organic Threads')" class="w-full flex items-center justify-between group text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold">OT</div>
                            <div>
                                <p class="font-bold text-sm">Organic Threads</p>
                                <p class="text-xs text-on-surface-variant">Portland, USA</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                    </button>
                </div>

                <button
                    type="button"
                    onclick="alert('View all suppliers mock page')"
                    class="w-full mt-8 py-3 rounded-xl border border-outline-variant/30 text-sm font-bold text-on-surface-variant hover:bg-surface-container-low transition-colors"
                >
                    View All Suppliers
                </button>
            </div>

            <button
                type="button"
                onclick="openHubStatus()"
                class="relative rounded-3xl overflow-hidden aspect-square shadow-xl group w-full text-left"
            >
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAuRh_Ft0B79j_1kS_g6t-Y2Ixb_n7pTJk45ldA8yAlgEQEgpAxhgZIbo7IHuoWvvF9rF0DbRN5SHWK9fop0y_E7QU8XMKOdJgNNHAXdgkTzD5BzFMOMUDevZcu-H_3f68hendL0nG_Qtg0QRMGQ8_4R9RTFjNzspQ5OVYUHi-fVi3ZUDNZYb0Gxh2m6_au6M3bNZmiOBmzWdvK4qCey40nmPNOwspGEFjjCY0iD099jtyUrIEcsPCYG9JnIcUc8cz6vNfmXaCcLhU" alt="Warehouse"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8">
                    <h4 class="text-white font-headline font-bold text-xl">Main Hub Status</h4>
                    <div class="mt-4 flex gap-4">
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Capacity</span>
                            <span class="text-white font-black text-lg">84%</span>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Daily Thru</span>
                            <span class="text-white font-black text-lg">1.2k</span>
                        </div>
                    </div>
                </div>
            </button>

            <div class="bg-primary text-on-primary p-8 rounded-3xl shadow-lg relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary-container/20 rounded-full blur-2xl"></div>
                <h4 class="text-lg font-bold font-headline mb-2">Inventory Alert</h4>
                <p class="text-sm text-on-primary/80 leading-relaxed">
                    3 items from 'EcoFabric Co.' are currently below safety stock levels. We recommend generating a new warehouse entry record today.
                </p>
                <button
                    type="button"
                    onclick="resolveInventoryAlert()"
                    class="mt-6 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-xs font-bold transition-all flex items-center gap-2"
                >
                    Resolve Now
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>