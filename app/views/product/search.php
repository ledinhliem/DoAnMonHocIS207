<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $products = $products ?? []; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <section class="mb-16">
        <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-6">
            <a href="<?= BASE_URL ?>" class="hover:text-primary">Trang chủ</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="font-medium text-primary">Kết quả tìm kiếm</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight mb-4 leading-tight">
                    <?= htmlspecialchars($keyword ?? 'Tìm kiếm') ?>
                </h1>
                <p class="text-lg text-on-surface-variant font-medium">
                    Tìm thấy <?= count($products) ?> sản phẩm
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <button type="button" class="filter-btn flex items-center space-x-2 bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-lg">tune</span>
                    <span>Bộ lọc</span>
                </button>
                <select class="sort-select bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl border-none focus:ring-primary/20 cursor-pointer">
                    <option>Phù hợp nhất</option>
                    <option>Giá: Thấp đến cao</option>
                    <option>Giá: Cao xuống thấp</option>
                    <option>Mới nhất</option>
                    <option>Đánh giá</option>
                </select>
            </div>
        </div>
    </section>

    <?php if (!empty($products)): ?>
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            <?php foreach ($products as $p): ?>
                <div class="group flex flex-col space-y-4 cursor-pointer"
                     onclick="window.location.href='<?= BASE_URL ?>?url=product/detail&id=<?= htmlspecialchars($p['id']) ?>'">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low">
                        <img class="w-full h-full object-cover"
                             src="<?= htmlspecialchars($p['image'] ?? 'https://via.placeholder.com/300') ?>"
                             alt="<?= htmlspecialchars($p['name']) ?>" />

                        <form method="POST" action="<?= BASE_URL ?>?url=cart/add" class="absolute bottom-4 right-4" onclick="event.stopPropagation()">
                            <input type="hidden" name="ma_san_pham" value="<?= htmlspecialchars($p['id']) ?>">
                            <input type="hidden" name="so_luong" value="1">
                            <button type="submit" class="bg-white/90 p-3 rounded-full">
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                            </button>
                        </form>
                    </div>

                    <div>
                        <h3 class="font-headline font-bold text-xl">
                            <?= htmlspecialchars($p['name']) ?>
                        </h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p class="text-center text-gray-500 mt-10">Không tìm thấy sản phẩm</p>
    <?php endif; ?>

    <section class="mt-24 pt-16 border-t border-outline-variant/10">
        <h2 class="font-headline text-2xl font-bold text-primary mb-8 tracking-tight">Gợi ý tìm kiếm liên quan</h2>
        <div class="flex flex-wrap gap-4">
            <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
               href="<?= BASE_URL ?>?url=product">Vải cotton hữu cơ</a>
            <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
               href="<?= BASE_URL ?>?url=product">Đồ trang trí tiết kiệm năng lượng</a>
            <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
               href="<?= BASE_URL ?>?url=product">Đồ thủy tinh tái chế</a>
            <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
               href="<?= BASE_URL ?>?url=product">Sợi gai dầu</a>
            <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
               href="<?= BASE_URL ?>?url=product">Xà phòng phân hủy sinh học</a>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
