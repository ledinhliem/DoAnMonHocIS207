<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-10">
        <a class="hover:text-primary" href="?url=">Home</a>
        <span>/</span>
        <span class="font-semibold text-primary">Shop</span>
    </nav>

    <div class="flex flex-col md:flex-row gap-10">
        <aside class="w-full md:w-72">
            <form method="GET" action="" class="space-y-6 bg-surface-container rounded-2xl p-6">
                <input type="hidden" name="url" value="product">

                <div>
                    <label class="block text-sm font-semibold mb-2">Search</label>
                    <input
                        type="text"
                        name="keyword"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white"
                        placeholder="Search products..."
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Category</label>
                    <select name="category" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="">All categories</option>
                        <?php foreach ($categories as $key => $label): ?>
                            <option value="<?= $key ?>" <?= (($filters['category'] ?? '') === $key) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Eco-Impact</label>
                    <select name="impact" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="">All impacts</option>
                        <?php foreach ($impacts as $key => $label): ?>
                            <option value="<?= $key ?>" <?= (($filters['impact'] ?? '') === $key) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Max Price ($)</label>
                    <input
                        type="number"
                        name="price_max"
                        min="0"
                        value="<?= htmlspecialchars($filters['price_max'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white"
                        placeholder="e.g. 200"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Sort by</label>
                    <select name="sort" class="w-full rounded-xl border border-outline-variant bg-white">
                        <option value="">Newest Arrivals</option>
                        <option value="price_asc" <?= (($filters['sort'] ?? '') === 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= (($filters['sort'] ?? '') === 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="impact_desc" <?= (($filters['sort'] ?? '') === 'impact_desc') ? 'selected' : '' ?>>Impact Rating</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button class="px-4 py-3 rounded-xl bg-primary text-white font-semibold w-full" type="submit">
                        Apply
                    </button>
                    <a class="px-4 py-3 rounded-xl border border-outline-variant text-center w-full" href="?url=product">
                        Reset
                    </a>
                </div>
            </form>
        </aside>

        <section class="flex-1">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-extrabold text-primary mb-2">Sustainable Living</h1>
                    <p class="text-on-surface-variant">Filter và sort đã hoạt động theo lựa chọn của bạn.</p>
                </div>
                <div class="text-sm text-on-surface-variant">
                    <?= count($products) ?> sản phẩm
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="bg-surface-container rounded-2xl p-8">
                    Không tìm thấy sản phẩm phù hợp.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($products as $product): ?>
                        <div class="group bg-white rounded-2xl overflow-hidden border border-outline-variant/30 shadow-sm">
                            <a href="?url=product/detail&id=<?= $product['id'] ?>" class="block aspect-[4/5] overflow-hidden">
                                <img
                                    src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                >
                            </a>

                            <div class="p-5">
                                <div class="text-xs uppercase tracking-widest text-secondary mb-2">
                                    <?= htmlspecialchars($categories[$product['category']] ?? $product['category']) ?>
                                </div>

                                <a href="?url=product/detail&id=<?= $product['id'] ?>" class="block text-xl font-bold font-headline hover:text-primary mb-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>

                                <p class="text-sm text-on-surface-variant mt-2 line-clamp-2">
                                    <?= htmlspecialchars($product['description']) ?>
                                </p>

                                <div class="flex items-center justify-between mt-4">
                                    <div>
                                        <div class="font-bold text-primary">$<?= number_format($product['price'], 2) ?></div>
                                        <div class="text-xs text-on-surface-variant">Rating <?= $product['rating'] ?>/5</div>
                                    </div>

                                    <form method="POST" action="?url=cart/add">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold">
                                            Add to cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>