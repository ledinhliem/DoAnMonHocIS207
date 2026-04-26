<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-10">
        <a href="?url=" class="hover:text-primary">Home</a>
        <span>/</span>
        <a href="?url=blog" class="hover:text-primary">Blog</a>
        <span>/</span>
        <span class="text-primary font-semibold"><?= htmlspecialchars($blog['title']) ?></span>
    </nav>

    <article class="mb-16">
        <div class="rounded-3xl overflow-hidden mb-8">
            <img
                src="<?= htmlspecialchars($blog['image']) ?>"
                alt="<?= htmlspecialchars($blog['title']) ?>"
                class="w-full h-[420px] object-cover"
            >
        </div>

        <div class="max-w-3xl">
            <div class="text-sm uppercase tracking-widest text-secondary mb-3">
                <?= htmlspecialchars($blog['category']) ?>
            </div>

            <h1 class="text-5xl font-black font-headline text-primary mb-5">
                <?= htmlspecialchars($blog['title']) ?>
            </h1>

            <p class="text-lg text-on-surface-variant leading-relaxed">
                <?= htmlspecialchars($blog['excerpt']) ?> Bài viết này giới thiệu cách chọn vật liệu, đồ nội thất và sản phẩm sống xanh để tạo nên không gian vừa đẹp vừa bền vững.
            </p>
        </div>
    </article>

    <section>
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-sm uppercase tracking-widest text-secondary">Curated Living</span>
                <h2 class="text-4xl font-black font-headline text-primary mt-2">Shop the Look</h2>
            </div>
            <a href="?url=product" class="font-semibold text-primary">View Collection</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $product): ?>
                <div class="group bg-white rounded-2xl overflow-hidden border border-outline-variant/30 shadow-sm">
                    <div class="relative">
                        <a href="?url=product/detail&id=<?= $product['id'] ?>" class="block aspect-[3/4] overflow-hidden">
                            <img
                                src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            >
                        </a>

                        <form method="POST" action="?url=cart/add" class="absolute bottom-4 right-4">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </form>
                    </div>

                    <div class="p-5">
                        <a href="?url=product/detail&id=<?= $product['id'] ?>" class="block text-lg font-bold font-headline hover:text-primary">
                            <?= htmlspecialchars($product['name']) ?>
                        </a>
                        <p class="text-on-surface-variant mt-2">$<?= number_format($product['price'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>