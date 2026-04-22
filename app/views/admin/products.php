<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$keyword  = $_GET['keyword'] ?? '';
$category = $_GET['category'] ?? '';
$brand    = $_GET['brand'] ?? '';

$productList = [];
if (isset($products) && is_array($products)) {
    $productList = $products;
} elseif (isset($data['products']) && is_array($data['products'])) {
    $productList = $data['products'];
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('productValue')) {
    function productValue($product, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($product[$key]) && $product[$key] !== '') {
                return $product[$key];
            }
        }
        return $default;
    }
}
?>

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-40">
    <div class="px-6 mb-10">
        <a href="/is207/index.php?url=admin/dashboard" class="block">
            <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
            <p class="text-xs text-[#191c18]/60 mt-1 uppercase tracking-widest font-bold">Eco-Management Suite</p>
        </a>
    </div>

    <nav class="flex-1 space-y-1">
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Dashboard</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Inventory</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/suppliers">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Suppliers</span>
        </a>

        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform"
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

    <div class="px-6 pt-6 border-t border-[#c5c8ba]/20 mt-auto">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">AZ</div>
            <div>
                <p class="text-sm font-bold text-[#384e21]">Admin User</p>
                <p class="text-xs text-on-surface-variant">Super Admin</p>
            </div>
        </div>
        <button class="w-full bg-secondary-container text-on-secondary-container px-4 py-2 rounded-lg text-sm font-bold hover:opacity-90 transition-opacity">
            Export Reports
        </button>
    </div>
</aside>

<!-- Main Content -->
<main class="ml-64 p-8 lg:p-12">
    <!-- Header Section -->
    <header class="flex flex-col xl:flex-row justify-between items-start xl:items-end gap-6 mb-10">
        <div>
            <h2 class="text-5xl font-black text-primary tracking-tighter mb-2">Products</h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">
                Manage your catalog, review stock, and prepare product actions from one place.
            </p>
        </div>

        <a href="/is207/index.php?url=product/create"
           class="flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-container transition-colors shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">add</span>
            Add New Product
        </a>
    </header>

    <!-- Search & Filter Controls -->
    <section class="bg-surface-container-low rounded-xl p-6 mb-8 shadow-sm">
        <form method="GET" action="" class="flex flex-col lg:flex-row gap-6 items-center">
            <div class="relative w-full lg:flex-1">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input
                    class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-outline/60"
                    placeholder="Search by name, SKU, or keyword..."
                    type="text"
                    name="keyword"
                    value="<?= e($keyword) ?>"
                />
            </div>

            <div class="flex flex-wrap gap-4 w-full lg:w-auto">
                <div class="relative min-w-[180px]">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">CATEGORY</label>
                    <select name="category" class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer">
                        <option value="">All Categories</option>
                        <option value="Kitchenware" <?= $category === 'Kitchenware' ? 'selected' : '' ?>>Kitchenware</option>
                        <option value="Personal Care" <?= $category === 'Personal Care' ? 'selected' : '' ?>>Personal Care</option>
                        <option value="Home Decor" <?= $category === 'Home Decor' ? 'selected' : '' ?>>Home Decor</option>
                        <option value="Textiles" <?= $category === 'Textiles' ? 'selected' : '' ?>>Textiles</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                </div>

                <div class="relative min-w-[180px]">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">BRAND</label>
                    <select name="brand" class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer">
                        <option value="">All Brands</option>
                        <option value="EcoLife" <?= $brand === 'EcoLife' ? 'selected' : '' ?>>EcoLife</option>
                        <option value="BambooWay" <?= $brand === 'BambooWay' ? 'selected' : '' ?>>BambooWay</option>
                        <option value="PureEarth" <?= $brand === 'PureEarth' ? 'selected' : '' ?>>PureEarth</option>
                        <option value="Zentro Basics" <?= $brand === 'Zentro Basics' ? 'selected' : '' ?>>Zentro Basics</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                </div>

                <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-primary-container transition-colors">
                    <span class="material-symbols-outlined">filter_alt</span>
                    Apply
                </button>

                <a href="/is207/index.php?url=admin/products" class="bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-surface-variant transition-colors">
                    <span class="material-symbols-outlined">restart_alt</span>
                    Reset
                </a>
            </div>
        </form>
    </section>

    <!-- Summary -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Displayed Products</p>
            <p class="text-3xl font-black text-primary"><?= count($productList) ?></p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Search Keyword</p>
            <p class="text-lg font-bold text-on-surface"><?= $keyword !== '' ? e($keyword) : '—' ?></p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <p class="text-sm text-on-surface-variant mb-2">Current Filters</p>
            <p class="text-lg font-bold text-on-surface">
                <?= ($category !== '' || $brand !== '') ? e(trim(($category ?: 'All categories') . ' / ' . ($brand ?: 'All brands'))) : 'None' ?>
            </p>
        </div>
    </section>

    <!-- Product Table -->
    <section class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1080px]">
                <thead class="bg-surface-container-low text-left">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Image</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Product</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Brand</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Category</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Price</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">Stock</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline">SKU</th>
                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-outline text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($productList)): ?>
                        <?php foreach ($productList as $product): ?>
                            <?php
                            $id = productValue($product, ['id'], null);
                            $name = productValue($product, ['name', 'product_name', 'title'], 'Unnamed product');
                            $brandName = productValue($product, ['brand', 'brand_name'], '—');
                            $categoryName = productValue($product, ['category', 'category_name'], '—');
                            $price = productValue($product, ['price'], 0);
                            $stock = productValue($product, ['stock', 'quantity'], '—');
                            $sku = productValue($product, ['sku'], '—');
                            $image = productValue($product, ['image', 'image_url', 'thumbnail'], '');
                            ?>

                            <tr class="border-t border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-4">
                                    <?php if ($image !== ''): ?>
                                        <img src="<?= e($image) ?>" alt="<?= e($name) ?>" class="w-14 h-14 rounded-lg object-cover border border-outline-variant/20">
                                    <?php else: ?>
                                        <div class="w-14 h-14 rounded-lg bg-surface-container-high flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined">image</span>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-bold text-on-surface"><?= e($name) ?></p>
                                    <?php if ($id !== null): ?>
                                        <p class="text-xs text-on-surface-variant mt-1">ID: <?= e($id) ?></p>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-on-surface"><?= e($brandName) ?></td>
                                <td class="px-6 py-4 text-on-surface"><?= e($categoryName) ?></td>
                                <td class="px-6 py-4 text-on-surface font-bold">
                                    <?= is_numeric($price) ? number_format((float)$price, 0, ',', '.') . ' đ' : e($price) ?>
                                </td>

                                <td class="px-6 py-4">
                                    <?php if (is_numeric($stock)): ?>
                                        <?php
                                        $stockNum = (int)$stock;
                                        $stockClass = $stockNum <= 10 ? 'text-red-600 bg-red-50' : 'text-green-700 bg-green-50';
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $stockClass ?>">
                                            <?= $stockNum <= 10 ? 'Low stock: ' . $stockNum : 'In stock: ' . $stockNum ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-on-surface"><?= e($stock) ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 text-on-surface"><?= e($sku) ?></td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <?php if ($id !== null): ?>
                                            <a href="/is207/index.php?url=product/edit/<?= urlencode((string)$id) ?>"
                                               class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface text-sm font-medium transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                Edit
                                            </a>

                                            <a href="/is207/index.php?url=product/delete/<?= urlencode((string)$id) ?>"
                                               onclick="return confirm('Delete this product?')"
                                               class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                Delete
                                            </a>
                                        <?php else: ?>
                                            <button type="button" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-surface-container-high text-on-surface text-sm font-medium transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                Edit
                                            </button>

                                            <button type="button" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 text-red-700 text-sm font-medium transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                Delete
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="border-t border-outline-variant/10">
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-outline">
                                        <span class="material-symbols-outlined text-3xl">inventory_2</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-on-surface mb-2">No products found</h3>
                                    <p class="text-on-surface-variant mb-6">
                                        There is no product data to display yet, or your current filter returned no results.
                                    </p>
                                    <a href="/is207/index.php?url=product/create"
                                       class="inline-flex items-center gap-2 bg-primary text-on-primary px-5 py-3 rounded-lg font-bold hover:bg-primary-container transition-colors">
                                        <span class="material-symbols-outlined">add</span>
                                        Add New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Pagination Placeholder -->
    <div class="mt-10 flex justify-center">
        <nav class="inline-flex items-center gap-1 bg-surface-container rounded-full px-2 py-2">
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-on-primary font-bold text-sm">1</button>
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant">2</button>
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant">3</button>
            <button type="button" class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </nav>
    </div>
</main>

<!-- Footer -->
<footer class="ml-64 flex flex-col md:flex-row justify-between items-center px-12 py-12 mt-20 border-t border-[#c5c8ba]/10 bg-surface-container-low text-primary">
    <div class="mb-6 md:mb-0">
        <h4 class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</h4>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2024 Zentro Sustainable Living. Admin panel.</p>
    </div>
    <div class="flex gap-8">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Privacy Policy</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Terms of Service</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Contact Us</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>