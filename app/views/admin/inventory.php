<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$keyword = $_GET['keyword'] ?? '';
$status  = $_GET['status'] ?? '';

$inventoryList = [];
if (isset($inventory) && is_array($inventory)) {
    $inventoryList = $inventory;
} elseif (isset($data['inventory']) && is_array($data['inventory'])) {
    $inventoryList = $data['inventory'];
} elseif (isset($entries) && is_array($entries)) {
    $inventoryList = $entries;
} elseif (isset($data['entries']) && is_array($data['entries'])) {
    $inventoryList = $data['entries'];
}

$supplierList = [];
if (isset($suppliers) && is_array($suppliers)) {
    $supplierList = $suppliers;
} elseif (isset($data['suppliers']) && is_array($data['suppliers'])) {
    $supplierList = $data['suppliers'];
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('inventoryValue')) {
    function inventoryValue($item, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($item[$key]) && $item[$key] !== '') {
                return $item[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('inventoryStatusBadge')) {
    function inventoryStatusBadge($status) {
        $status = strtolower(trim((string)$status));
        switch ($status) {
            case 'verified':
            case 'completed':
            case 'approved':
                return 'bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            case 'pending':
            case 'in_review':
                return 'bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            case 'cancelled':
            case 'rejected':
                return 'bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase';
            default:
                return 'bg-surface-container-high text-on-surface-variant text-[10px] font-bold px-2 py-1 rounded-md uppercase';
        }
    }
}

if (!function_exists('formatMoneyVND')) {
    function formatMoneyVND($value) {
        if (!is_numeric($value)) return e($value);
        return number_format((float)$value, 0, ',', '.') . ' đ';
    }
}

$totalEntries = count($inventoryList);
$totalSuppliers = count($supplierList);
$verifiedCount = 0;
$pendingCount = 0;
$totalInventoryValue = 0;

foreach ($inventoryList as $entry) {
    $entryStatus = strtolower((string) inventoryValue($entry, ['status'], ''));
    $entryValue = inventoryValue($entry, ['total_value', 'value', 'amount', 'total'], 0);

    if (in_array($entryStatus, ['verified', 'completed', 'approved'], true)) {
        $verifiedCount++;
    }
    if (in_array($entryStatus, ['pending', 'in_review'], true)) {
        $pendingCount++;
    }
    if (is_numeric($entryValue)) {
        $totalInventoryValue += (float)$entryValue;
    }
}
?>

<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-40">
    <div class="px-6 mb-10">
        <a href="/is207/index.php?url=admin/dashboard" class="block">
            <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
            <p class="text-xs text-on-surface-variant font-medium mt-1">Eco-Management Suite</p>
        </a>
    </div>

    <nav class="flex-grow space-y-1">
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Dashboard</span>
        </a>
        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 shadow-md"
           href="/is207/index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Inventory</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/suppliers">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Suppliers</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/products">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Products</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/orders">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Orders</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/reviews">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Reviews</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/blog">
            <span class="material-symbols-outlined">article</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Blog</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/settings">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Settings</span>
        </a>
    </nav>

    <div class="px-6 pt-6 mt-6 border-t border-[#c5c8ba]/20">
        <button class="w-full bg-primary text-on-primary py-3 rounded-xl font-semibold text-sm hover:opacity-90 transition-all active:scale-95">
            Export Reports
        </button>
        <div class="flex items-center gap-3 mt-8 px-2">
            <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAdy62X4L7pZJTyiB1DnC-YJcaaqPlaBrxSCjxJ4ZBOi3JdwPNsaEXEvkkNpCxYOeQYdlMEJ9S6lsy2zFsOtRPDHB9G-XPA1lUilucWwrAdRKuowtDOnUL_zdgBgFCkRyvLAFeppQIb72ikw8o-Y_sfi0vWz-m7CGjhUVIkFTCQoB-_ZKWMG2Bg3UShZ7Ir8Ufs0W-Q8lrZKrHgm-7F-X895CcudzKpSTKDbfQffIL-6BrioTEtMHidVQy6LpC0JNy8klba1s4G3wg"/>
            <div>
                <p class="text-xs font-bold text-[#384e21]">Admin User</p>
                <p class="text-[10px] text-on-surface-variant">Supply Chain Lead</p>
            </div>
        </div>
    </div>
</aside>

<main class="ml-64 p-8 min-h-screen">
    <header class="flex flex-col xl:flex-row justify-between gap-6 xl:items-end mb-12">
        <div>
            <h2 class="text-4xl font-extrabold font-headline tracking-tight text-primary">Inventory Logistics</h2>
            <p class="text-on-surface-variant mt-2 max-w-lg">
                Manage inventory records, warehouse entries, and supplier information from one place.
            </p>
        </div>
        <div class="flex gap-4 flex-wrap">
            <form method="GET" action="" class="flex gap-3 flex-wrap">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="keyword"
                        value="<?= e($keyword) ?>"
                        placeholder="Search entry or supplier..."
                        class="bg-surface-container-high border-none rounded-xl pl-10 pr-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all"
                    />
                </div>

                <select name="status" class="bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all">
                    <option value="">All Status</option>
                    <option value="verified" <?= $status === 'verified' ? 'selected' : '' ?>>Verified</option>
                    <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $status === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>

                <button class="bg-surface-container-high px-6 py-3 rounded-xl font-bold text-primary flex items-center gap-2 hover:bg-surface-container-highest transition-colors" type="submit">
                    <span class="material-symbols-outlined text-xl">filter_list</span>
                    Filter
                </button>
            </form>

            <a href="/is207/index.php?url=inventory/create"
               class="bg-secondary-container text-on-secondary-container px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-sm">
                <span class="material-symbols-outlined text-xl">add</span>
                New Entry
            </a>
        </div>
    </header>

    <!-- Stats -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Total Entries</p>
            <p class="text-3xl font-black text-primary"><?= number_format($totalEntries) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Verified</p>
            <p class="text-3xl font-black text-primary"><?= number_format($verifiedCount) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Pending</p>
            <p class="text-3xl font-black text-primary"><?= number_format($pendingCount) ?></p>
        </div>
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
            <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-2">Total Value</p>
            <p class="text-3xl font-black text-primary"><?= formatMoneyVND($totalInventoryValue) ?></p>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold font-headline text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">list_alt</span>
                        Warehouse Entry Records
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
                            <?php if (!empty($inventoryList)): ?>
                                <?php foreach ($inventoryList as $entry): ?>
                                    <?php
                                    $entryId = inventoryValue($entry, ['entry_id', 'code', 'id'], '—');
                                    $arrivalDate = inventoryValue($entry, ['arrival_date', 'date', 'created_at'], '—');
                                    $supplier = inventoryValue($entry, ['supplier_name', 'supplier', 'vendor'], '—');
                                    $value = inventoryValue($entry, ['total_value', 'value', 'amount', 'total'], 0);
                                    $entryStatus = inventoryValue($entry, ['status'], 'pending');
                                    $id = inventoryValue($entry, ['id'], null);
                                    ?>
                                    <tr class="bg-surface-container-low/50 hover:bg-surface-container-low transition-colors group">
                                        <td class="py-4 px-4 rounded-l-2xl font-bold text-primary">#<?= e($entryId) ?></td>
                                        <td class="py-4 px-4 text-sm"><?= e($arrivalDate) ?></td>
                                        <td class="py-4 px-4 font-medium"><?= e($supplier) ?></td>
                                        <td class="py-4 px-4 font-bold"><?= formatMoneyVND($value) ?></td>
                                        <td class="py-4 px-4">
                                            <span class="<?= inventoryStatusBadge($entryStatus) ?>"><?= e($entryStatus) ?></span>
                                        </td>
                                        <td class="py-4 px-4 rounded-r-2xl text-right">
                                            <?php if ($id !== null): ?>
                                                <a href="/is207/index.php?url=inventory/edit/<?= urlencode((string)$id) ?>" class="text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="text-primary opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-10 px-4 text-center text-on-surface-variant">
                                        No inventory records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-surface-container-low rounded-3xl p-8 border border-outline-variant/10">
                <h3 class="text-xl font-bold font-headline text-primary mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">add_business</span>
                    Register New Supplier
                </h3>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6" method="POST" action="/is207/index.php?url=supplier/create">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Supplier Name</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="e.g. Nordic Timber Ltd." type="text" name="supplier_name"/>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">VAT/Tax ID</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="VAT-99230-22" type="text" name="tax_id"/>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Primary Category</label>
                        <select class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" name="category">
                            <option value="Sustainable Textiles">Sustainable Textiles</option>
                            <option value="Raw Materials">Raw Materials</option>
                            <option value="Packaging">Packaging</option>
                            <option value="Renewable Energy Parts">Renewable Energy Parts</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider px-1">Location</label>
                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" placeholder="City, Country" type="text" name="location"/>
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
                    <?php if (!empty($supplierList)): ?>
                        <?php foreach ($supplierList as $supplier): ?>
                            <?php
                            $supplierName = inventoryValue($supplier, ['name', 'supplier_name'], 'Supplier');
                            $supplierLocation = inventoryValue($supplier, ['location', 'address', 'city'], '—');
                            $supplierId = inventoryValue($supplier, ['id'], null);

                            $words = preg_split('/\s+/', trim((string)$supplierName));
                            $initials = '';
                            foreach (array_slice($words, 0, 2) as $word) {
                                $initials .= strtoupper(mb_substr($word, 0, 1));
                            }
                            $initials = $initials !== '' ? $initials : 'SP';
                            ?>
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold"><?= e($initials) ?></div>
                                    <div>
                                        <p class="font-bold text-sm"><?= e($supplierName) ?></p>
                                        <p class="text-xs text-on-surface-variant"><?= e($supplierLocation) ?></p>
                                    </div>
                                </div>
                                <?php if ($supplierId !== null): ?>
                                    <a href="/is207/index.php?url=supplier/detail/<?= urlencode((string)$supplierId) ?>" class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors cursor-pointer">chevron_right</a>
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors cursor-pointer">chevron_right</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-on-surface-variant">No supplier data available.</p>
                    <?php endif; ?>
                </div>

                <a href="/is207/index.php?url=admin/suppliers" class="block w-full mt-8 py-3 rounded-xl border border-outline-variant/30 text-sm font-bold text-on-surface-variant hover:bg-surface-container-low transition-colors text-center">
                    View All Suppliers
                </a>
            </div>

            <div class="relative rounded-3xl overflow-hidden aspect-square shadow-xl group">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAuRh_Ft0B79j_1kS_g6t-Y2Ixb_n7pTJk45ldA8yAlgEQEgpAxhgZIbo7IHuoWvvF9rF0DbRN5SHWK9fop0y_E7QU8XMKOdJgNNHAXdgkTzD5BzFMOMUDevZcu-H_3f68hendL0nG_Qtg0QRMGQ8_4R9RTFjNzspQ5OVYUHi-fVi3ZUDNZYb0Gxh2m6_au6M3bNZmiOBmzWdvK4qCey40nmPNOwspGEFjjCY0iD099jtyUrIEcsPCYG9JnIcUc8cz6vNfmXaCcLhU"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8">
                    <h4 class="text-white font-headline font-bold text-xl">Main Hub Status</h4>
                    <div class="mt-4 flex gap-4">
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Entries</span>
                            <span class="text-white font-black text-lg"><?= number_format($totalEntries) ?></span>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="flex flex-col">
                            <span class="text-white/60 text-[10px] uppercase font-bold">Suppliers</span>
                            <span class="text-white font-black text-lg"><?= number_format($totalSuppliers) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-primary text-on-primary p-8 rounded-3xl shadow-lg relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary-container/20 rounded-full blur-2xl"></div>
                <h4 class="text-lg font-bold font-headline mb-2">Inventory Alert</h4>
                <p class="text-sm text-on-primary/80 leading-relaxed">
                    <?= $pendingCount > 0
                        ? e($pendingCount) . ' inventory record(s) are currently pending verification.'
                        : 'No pending inventory alerts at the moment.' ?>
                </p>
                <button class="mt-6 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-xs font-bold transition-all flex items-center gap-2">
                    Resolve Now
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>
    </section>
</main>

<footer class="ml-64 bg-[#f3f4ed] dark:bg-stone-900 border-t border-[#c5c8ba]/10 flex flex-col md:flex-row justify-between items-center px-12 py-16 mt-20">
    <div class="mb-8 md:mb-0">
        <h5 class="font-['Epilogue'] font-bold text-[#384e21] text-xl mb-2">Zentro</h5>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50">© 2024 Zentro Sustainable Living. Admin panel.</p>
    </div>
    <div class="flex flex-wrap gap-8 justify-center">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all opacity-80 hover:opacity-100" href="#">Privacy Policy</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all opacity-80 hover:opacity-100" href="#">Terms of Service</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all opacity-80 hover:opacity-100" href="#">Shipping &amp; Returns</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all opacity-80 hover:opacity-100" href="#">Contact Us</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>