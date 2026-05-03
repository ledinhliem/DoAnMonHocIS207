<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-6xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-10">
            Giỏ hàng
        </h1>

        <?php if (!empty($success)): ?>
            <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-6 py-4">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="mb-6 rounded-2xl bg-red-100 text-red-800 px-6 py-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <div class="bg-white rounded-2xl border border-[#E5E7D8] p-8">
                <p class="text-lg">
                    Giỏ hàng đang trống.
                    <a href="?url=product" class="text-[#2F512A] font-bold">
                        Đi mua ngay
                    </a>
                </p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-5">
                    <?php foreach ($items as $item): ?>
                        <?php
                            $maBienThe = $item['MaBienThe'] ?? '';
                            $name = $item['name'] ?? 'Sản phẩm';
                            $variant = $item['variant'] ?? '';
                            $image = $item['image'] ?? '';
                            $price = (float)($item['price'] ?? 0);
                            $quantity = (int)($item['quantity'] ?? 1);
                            $stock = (int)($item['stock'] ?? 0);
                            $lineTotal = $price * $quantity;
                        ?>

                        <div class="bg-white rounded-2xl border border-[#E5E7D8] p-5 flex flex-col md:flex-row gap-5">
                            <?php if (!empty($image)): ?>
                                <img src="<?= htmlspecialchars($image) ?>"
                                     alt="<?= htmlspecialchars($name) ?>"
                                     class="w-full md:w-28 h-28 rounded-xl object-cover">
                            <?php else: ?>
                                <div class="w-full md:w-28 h-28 rounded-xl bg-[#EEF1E7] flex items-center justify-center text-gray-500">
                                    No image
                                </div>
                            <?php endif; ?>

                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-[#2F512A]">
                                    <?= htmlspecialchars($name) ?>
                                </h3>

                                <?php if (!empty($variant)): ?>
                                    <p class="text-gray-600 mt-1">
                                        Phân loại: <?= htmlspecialchars($variant) ?>
                                    </p>
                                <?php endif; ?>

                                <p class="text-gray-600 mt-1">
                                    Mã biến thể: <?= htmlspecialchars($maBienThe) ?>
                                </p>

                                <p class="text-gray-600 mt-1">
                                    Giá: <?= number_format($price, 0, ',', '.') ?>₫
                                </p>

                                <p class="text-gray-600 mt-1">
                                    Tồn kho: <?= $stock ?>
                                </p>

                                <div class="flex items-center gap-3 mt-4">
                                    <form method="POST" action="?url=cart/update">
                                        <input type="hidden" name="MaBienThe" value="<?= htmlspecialchars($maBienThe) ?>">
                                        <input type="hidden" name="SoLuong" value="<?= max(0, $quantity - 1) ?>">
                                        <button type="submit"
                                                class="w-10 h-10 rounded-xl border border-[#D8DDCB] font-bold">
                                            -
                                        </button>
                                    </form>

                                    <span class="w-12 text-center font-bold">
                                        <?= $quantity ?>
                                    </span>

                                    <form method="POST" action="?url=cart/update">
                                        <input type="hidden" name="MaBienThe" value="<?= htmlspecialchars($maBienThe) ?>">
                                        <input type="hidden" name="SoLuong" value="<?= $quantity + 1 ?>">
                                        <button type="submit"
                                                class="w-10 h-10 rounded-xl border border-[#D8DDCB] font-bold">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex md:flex-col justify-between md:items-end gap-4">
                                <p class="font-black text-[#2F512A] text-lg">
                                    <?= number_format($lineTotal, 0, ',', '.') ?>₫
                                </p>

                                <a href="?url=cart/remove&MaBienThe=<?= urlencode($maBienThe) ?>"
                                   class="px-4 py-2 rounded-xl border border-red-300 text-red-600 font-semibold">
                                    Xóa
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-white rounded-2xl border border-[#E5E7D8] p-6 h-fit">
                    <h2 class="text-2xl font-bold text-[#2F512A] mb-5">
                        Tóm tắt giỏ hàng
                    </h2>

                    <div class="flex justify-between mb-4">
                        <span>Tạm tính</span>
                        <strong><?= number_format($subtotal, 0, ',', '.') ?>₫</strong>
                    </div>

                    <a href="?url=checkout"
                       class="block w-full text-center px-6 py-4 rounded-2xl bg-[#2F512A] text-white font-bold">
                        Tiếp tục thanh toán
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>