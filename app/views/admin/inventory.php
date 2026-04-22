<?php $currentPage = 'inventory'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="p-8 min-h-screen">
    <?php if (isset($_GET['status'])): ?>
        <div id="status-alert" class="mb-6 p-4 rounded-2xl flex items-center gap-3 <?php echo $_GET['status'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> transition-all animate-pulse">
            <span class="material-symbols-outlined"><?php echo $_GET['status'] === 'success' ? 'check_circle' : 'error'; ?></span>
            <span class="font-bold"><?php echo $_GET['message'] ?? 'Thao tác thành công!'; ?></span>
        </div>
        <script>setTimeout(() => document.getElementById('status-alert').remove(), 3000);</script>
    <?php endif; ?>

    <header class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-4xl font-extrabold font-headline tracking-tight text-primary">Inventory Logistics</h2>
            <p class="text-on-surface-variant mt-2 max-w-lg">Manage your sustainable supply chain ecosystem.</p>
        </div>
        <div class="flex gap-4">
            <form action="" method="GET" class="flex gap-4">
                <input type="hidden" name="url" value="admin/inventory">
                <button type="submit" class="bg-surface-container-high px-6 py-3 rounded-xl font-bold text-primary flex items-center gap-2 hover:bg-surface-container-highest transition-colors">
                    <span class="material-symbols-outlined text-xl">filter_list</span> Filter
                </button>
            </form>
            <button type="button" onclick="document.getElementById('supplier-form-section')?.scrollIntoView({ behavior: 'smooth' })" class="bg-secondary-container text-on-secondary-container px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-xl">add</span> New Entry
            </button>
        </div>
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">list_alt</span> Warehouse Entry Records
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <tbody>
                            <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors group">
                                <td class="py-4 px-4 rounded-l-2xl font-bold text-primary">#PN-8821</td>
                                <td class="py-4 px-4">Oct 24, 2023</td>
                                <td class="py-4 px-4">Bamboo Collective</td>
                                <td class="py-4 px-4 font-bold">$4,250.00</td>
                                <td class="py-4 px-4"><span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Verified</span></td>
                                <td class="py-4 px-4 rounded-r-2xl text-right relative">
                                    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-primary p-1 rounded hover:bg-surface-container-high">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                    <div class="hidden absolute right-0 top-10 bg-white border border-outline-variant/40 rounded-xl shadow-lg min-w-[140px] z-30 overflow-hidden">
                                        <form action="" method="POST">
                                            <input type="hidden" name="entry_id" value="8821">
                                            <button type="submit" name="action" value="view" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50">View</button>
                                            <button type="submit" name="action" value="edit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Edit</button>
                                            <button type="submit" name="action" value="delete" onclick="return confirm('Xóa phiếu này?')" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="supplier-form-section" class="bg-surface-container-low rounded-3xl p-8 border border-outline-variant/10">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">add_business</span> Register New Supplier
                </h3>

                <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase px-1">Supplier Name *</label>
                        <input name="supplier_name" required type="text" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="e.g. Nordic Timber Ltd." />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase px-1">VAT/Tax ID *</label>
                        <input name="tax_id" required type="text" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="VAT-99230-22" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase px-1">Primary Category</label>
                        <select name="category" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 outline-none">
                            <option value="textiles">Sustainable Textiles</option>
                            <option value="raw">Raw Materials</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase px-1">Location</label>
                        <input name="location" type="text" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 outline-none" placeholder="City, Country" />
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button type="submit" name="action" value="add_supplier" class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold shadow-md hover:scale-[1.02] active:scale-95 transition-all">
                            Confirm & Register Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </section>
</div>