<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Shopping Cart</h1>

    <?php if (!empty($success)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="mb-6 rounded-2xl bg-red-100 text-red-800 px-5 py-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="bg-surface-container rounded-2xl p-8">
            Giỏ hàng đang trống. <a class="text-primary font-semibold" href="?url=product">Đi mua ngay</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <?php foreach ($items as $item): ?>
                    <div class="bg-white rounded-2xl border border-outline-variant/30 p-5 flex gap-4 items-center">
                        <img
                            src="<?= htmlspecialchars($item['image']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                            class="w-24 h-24 rounded-xl object-cover"
                        >

                        <div class="flex-1">
                            <h3 class="text-lg font-bold"><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="text-on-surface-variant">$<?= number_format($item['price'], 2) ?></p>

                            <div class="flex items-center gap-2 mt-3">
                                <!-- nút giảm -->
                                <form method="POST" action="?url=cart/update">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="quantity" value="<?= max(0, $item['quantity'] - 1) ?>">
                                    <button type="submit" class="w-10 h-10 rounded-xl border border-outline-variant text-lg font-bold">
                                        -
                                    </button>
                                </form>

                                <!-- số lượng hiện tại -->
                                <input
                                    type="number"
                                    value="<?= $item['quantity'] ?>"
                                    class="w-16 text-center rounded-xl border border-outline-variant bg-white"
                                    readonly
                                >

                                <!-- nút tăng -->
                                <form method="POST" action="?url=cart/update">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="quantity" value="<?= $item['quantity'] + 1 ?>">
                                    <button type="submit" class="w-10 h-10 rounded-xl border border-outline-variant text-lg font-bold">
                                        +
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-3">
                            <div class="font-semibold text-primary">
                                $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                            </div>

                            <a
                                href="?url=cart/remove&id=<?= $item['id'] ?>"
                                class="px-3 py-2 rounded-xl border border-red-300 text-red-600 text-sm"
                            >
                                Remove
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-surface-container rounded-2xl p-6 h-fit">
                <h2 class="text-xl font-bold mb-4">Summary</h2>

                <div class="flex justify-between mb-3">
                    <span>Subtotal</span>
                    <span>$<?= number_format($subtotal, 2) ?></span>
                </div>

                <div class="flex justify-between mb-6">
                    <span>Estimated total</span>
                    <span class="font-bold text-primary">$<?= number_format($subtotal, 2) ?></span>
                </div>

                <a href="?url=checkout" class="block w-full text-center px-5 py-4 rounded-2xl bg-primary text-white font-semibold">
                    Continue to Checkout
                </a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>