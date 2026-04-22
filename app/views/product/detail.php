<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-10">
        <a href="?url=" class="hover:text-primary">Home</a>
        <span>/</span>
        <a href="?url=product" class="hover:text-primary">Shop</a>
        <span>/</span>
        <span class="text-primary font-semibold"><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <div class="rounded-3xl overflow-hidden bg-surface-container">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
        </div>

        <div>
            <div class="text-sm uppercase tracking-widest text-secondary mb-3">
                <?= htmlspecialchars($product['category']) ?>
            </div>

            <h1 class="text-4xl font-black font-headline text-primary mb-4">
                <?= htmlspecialchars($product['name']) ?>
            </h1>

            <div class="text-3xl font-bold mb-4">
                $<?= number_format($product['price'], 2) ?>
            </div>

            <p class="text-on-surface-variant leading-relaxed mb-8">
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <form method="POST" action="?url=cart/add" class="space-y-5">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div>
                    <label class="block text-sm font-semibold mb-2">Quantity</label>
                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        value="1"
                        class="w-32 rounded-xl border border-outline-variant bg-white"
                    >
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-4 rounded-2xl bg-primary text-white font-semibold">
                        Add to Cart
                    </button>

                    <a href="?url=cart" class="px-6 py-4 rounded-2xl border border-outline-variant font-semibold">
                        View Cart
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>