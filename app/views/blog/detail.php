<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
$relatedTitle = $relatedTitle ?? 'Sản phẩm liên quan đến bài viết';
$relatedDescription = $relatedDescription ?? 'Các sản phẩm được chọn từ cửa hàng Zentro.';
$relatedCollectionUrl = $relatedCollectionUrl ?? '?url=product';
$products = $products ?? [];
?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-10">
        <a href="?url=" class="hover:text-primary">Trang chủ</a>
        <span>/</span>
        <a href="?url=blog" class="hover:text-primary">Blog</a>
        <span>/</span>
        <span class="text-primary font-semibold">
            <?= htmlspecialchars($blog['title'] ?? 'Bài viết') ?>
        </span>
    </nav>

    <article class="mb-16">
        <div class="rounded-3xl overflow-hidden mb-8 bg-surface-container">
            <img
                src="<?= htmlspecialchars($blog['image'] ?? '') ?>"
                alt="<?= htmlspecialchars($blog['title'] ?? 'Blog') ?>"
                class="w-full h-[420px] object-cover"
            >
        </div>

        <div class="max-w-3xl">
            <div class="text-sm uppercase tracking-widest text-secondary mb-3">
                <?= htmlspecialchars($blog['category'] ?? 'Sustainability') ?>
            </div>

            <h1 class="text-5xl font-black font-headline text-primary mb-5 leading-tight">
                <?= htmlspecialchars($blog['title'] ?? 'Bài viết') ?>
            </h1>

            <p class="text-sm text-on-surface-variant mb-8">
                Ngày đăng:
                <?= !empty($blog['created_at']) ? date('d/m/Y', strtotime($blog['created_at'])) : 'Đang cập nhật' ?>
            </p>

            <div class="text-lg text-on-surface-variant leading-relaxed whitespace-pre-line">
                <?= nl2br(htmlspecialchars($blog['content'] ?? '')) ?>
            </div>
        </div>
    </article>

    <section class="bg-surface-container-low rounded-3xl p-8 md:p-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
                <span class="text-sm uppercase tracking-widest text-secondary">
                    Gợi ý theo chủ đề bài viết
                </span>

                <h2 class="text-3xl md:text-4xl font-black font-headline text-primary mt-2">
                    <?= htmlspecialchars($relatedTitle) ?>
                </h2>

                <p class="text-on-surface-variant mt-3 max-w-2xl">
                    <?= htmlspecialchars($relatedDescription) ?>
                </p>
            </div>

            <a href="<?= htmlspecialchars($relatedCollectionUrl) ?>"
                class="inline-flex items-center gap-2 font-semibold text-primary hover:underline underline-offset-4">
                Xem bộ sưu tập liên quan
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>

        <?php if (empty($products)): ?>
            <div class="bg-white rounded-2xl border border-outline-variant/30 p-8 text-on-surface-variant">
                Hiện chưa có sản phẩm phù hợp cho bài viết này.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($products as $product): ?>
                    <?php
                    $productId = $product['MaSanPham'] ?? $product['id'] ?? '';
                    $variantId = $product['MaBienTheMacDinh'] ?? '';
                    $productName = $product['TenSanPham'] ?? $product['name'] ?? 'Sản phẩm';
                    $productImage = $product['image'] ?? '';
                    $productPrice = (float)($product['GiaTien'] ?? $product['price'] ?? 0);
                    $productCategory = $product['TenDanhMuc'] ?? $product['category_name'] ?? '';
                    $ecoTag = $product['eco_tag'] ?? $product['TacDongMoiTruong'] ?? 'Sản phẩm sống xanh';
                    $stock = (int)($product['TongTon'] ?? 0);
                    ?>

                    <div class="group bg-white rounded-2xl overflow-hidden border border-outline-variant/30 shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <a href="?url=product/detail&id=<?= urlencode($productId) ?>"
                                class="block aspect-[3/4] overflow-hidden bg-surface-container">
                                <?php if (!empty($productImage)): ?>
                                    <img
                                        src="<?= htmlspecialchars($productImage) ?>"
                                        alt="<?= htmlspecialchars($productName) ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    >
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                                        No image
                                    </div>
                                <?php endif; ?>
                            </a>

                            <form method="POST" action="?url=cart/add" class="absolute bottom-4 right-4">
                                <input type="hidden" name="MaSanPham" value="<?= htmlspecialchars($productId) ?>">
                                <input type="hidden" name="MaBienThe" value="<?= htmlspecialchars($variantId) ?>">
                                <input type="hidden" name="SoLuong" value="1">

                                <button type="submit"
                                    <?= (empty($productId) || empty($variantId) || $stock <= 0) ? 'disabled' : '' ?>
                                    class="w-12 h-12 rounded-full bg-white shadow flex items-center justify-center text-primary hover:bg-primary hover:text-white transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    title="Thêm vào giỏ">
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </form>
                        </div>

                        <div class="p-5">
                            <?php if (!empty($productCategory)): ?>
                                <p class="text-xs tracking-widest uppercase font-bold text-secondary mb-2">
                                    <?= htmlspecialchars($productCategory) ?>
                                </p>
                            <?php endif; ?>

                            <a href="?url=product/detail&id=<?= urlencode($productId) ?>"
                                class="block text-lg font-bold font-headline hover:text-primary leading-snug">
                                <?= htmlspecialchars($productName) ?>
                            </a>

                            <p class="text-on-surface-variant mt-2 font-semibold">
                                <?= number_format($productPrice, 0, ',', '.') ?>₫
                            </p>

                            <p class="text-xs font-bold text-primary flex items-center gap-2 mt-3 line-clamp-2">
                                <span>●</span>
                                <?= htmlspecialchars($ecoTag) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>