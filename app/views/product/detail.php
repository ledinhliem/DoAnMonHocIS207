<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
    $mainImage = '';

    if (!empty($images)) {
        $mainImage = $images[0]['DuongDan'] ?? '';
    }

    if (!empty($mainImage) && !str_starts_with($mainImage, 'http')) {
        if (!str_contains($mainImage, 'public/images/products/')) {
            $mainImage = BASE_URL . 'public/images/products/' . $mainImage;
        } else {
            $mainImage = BASE_URL . $mainImage;
        }
    }

    $firstVariant = $variants[0] ?? null;
?>

<main class="min-h-screen bg-[#FAFAF2] px-8 py-14">
    <section class="max-w-6xl mx-auto">

        <a href="?url=product"
           class="inline-block mb-8 text-[#2F512A] font-semibold">
            ← Quay lại cửa hàng
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

            <div class="bg-white rounded-3xl border border-[#E5E7D8] p-6">
                <?php if (!empty($mainImage)): ?>
                    <img src="<?= htmlspecialchars($mainImage) ?>"
                         alt="<?= htmlspecialchars($product['TenSanPham']) ?>"
                         class="w-full h-[420px] object-cover rounded-2xl">
                <?php else: ?>
                    <div class="w-full h-[420px] rounded-2xl bg-[#EEF1E7] flex items-center justify-center text-gray-500">
                        Chưa có ảnh
                    </div>
                <?php endif; ?>

                <?php if (!empty($images)): ?>
                    <div class="grid grid-cols-4 gap-3 mt-4">
                        <?php foreach ($images as $image): ?>
                            <?php
                                $thumb = $image['DuongDan'] ?? '';

                                if (!empty($thumb) && !str_starts_with($thumb, 'http')) {
                                    if (!str_contains($thumb, 'public/images/products/')) {
                                        $thumb = BASE_URL . 'public/images/products/' . $thumb;
                                    } else {
                                        $thumb = BASE_URL . $thumb;
                                    }
                                }
                            ?>

                            <?php if (!empty($thumb)): ?>
                                <img src="<?= htmlspecialchars($thumb) ?>"
                                     alt="<?= htmlspecialchars($product['TenSanPham']) ?>"
                                     class="w-full h-24 object-cover rounded-xl border border-[#E5E7D8]">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <p class="text-sm uppercase tracking-widest text-[#6B7C61] font-bold mb-3">
                    <?= htmlspecialchars($product['TenDanhMuc'] ?? 'Zentro Product') ?>
                </p>

                <h1 class="text-4xl md:text-5xl font-black text-[#2F512A] mb-5">
                    <?= htmlspecialchars($product['TenSanPham']) ?>
                </h1>

                <?php if (!empty($product['TenThuongHieu'])): ?>
                    <p class="text-gray-600 mb-2">
                        Thương hiệu:
                        <strong><?= htmlspecialchars($product['TenThuongHieu']) ?></strong>
                    </p>
                <?php endif; ?>

                <?php if (!empty($product['TenVatLieu'])): ?>
                    <p class="text-gray-600 mb-2">
                        Vật liệu:
                        <strong><?= htmlspecialchars($product['TenVatLieu']) ?></strong>
                    </p>
                <?php endif; ?>

                <?php if (isset($product['DiemXanh'])): ?>
                    <p class="text-gray-600 mb-6">
                        Điểm xanh:
                        <strong><?= (int)$product['DiemXanh'] ?>/100</strong>
                    </p>
                <?php endif; ?>

                <?php if ($firstVariant): ?>
                    <p id="variantPrice" class="text-3xl font-black text-[#2F512A] mb-6">
                        <?= number_format((float)$firstVariant['GiaTien'], 0, ',', '.') ?>₫
                    </p>
                <?php endif; ?>

                <form method="POST"
                      action="?url=cart/add"
                      class="bg-white rounded-3xl border border-[#E5E7D8] p-6 space-y-5">

                    <input type="hidden"
                           name="MaSanPham"
                           value="<?= htmlspecialchars($product['MaSanPham']) ?>">

                    <div>
                        <label class="block text-sm font-bold mb-2 text-[#2F512A]">
                            Chọn biến thể
                        </label>

                        <?php if (empty($variants)): ?>
                            <div class="rounded-xl bg-red-50 text-red-700 px-4 py-3">
                                Sản phẩm này chưa có biến thể, chưa thể thêm vào giỏ.
                            </div>
                        <?php else: ?>
                            <select id="variantSelect"
                                    name="MaBienThe"
                                    required
                                    class="w-full rounded-xl border border-[#D8DDCB] bg-white px-4 py-3">
                                <?php foreach ($variants as $variant): ?>
                                    <?php
                                        $variantText = trim(
                                            ($variant['KichThuoc'] ?? '') .
                                            (!empty($variant['MauSac']) ? ' - ' . $variant['MauSac'] : '')
                                        );
                                    ?>

                                    <option value="<?= htmlspecialchars($variant['MaBienThe']) ?>"
                                            data-price="<?= (float)$variant['GiaTien'] ?>"
                                            data-stock="<?= (int)$variant['SoLuongTon'] ?>">
                                        <?= htmlspecialchars($variantText ?: $variant['MaBienThe']) ?>
                                        - <?= number_format((float)$variant['GiaTien'], 0, ',', '.') ?>₫
                                        - còn <?= (int)$variant['SoLuongTon'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 text-[#2F512A]">
                            Số lượng
                        </label>

                        <input id="quantityInput"
                               type="number"
                               name="SoLuong"
                               value="1"
                               min="1"
                               class="w-32 rounded-xl border border-[#D8DDCB] bg-white px-4 py-3">
                    </div>

                    <button type="submit"
                            <?= empty($variants) ? 'disabled' : '' ?>
                            class="w-full px-6 py-4 rounded-2xl bg-[#2F512A] text-white font-bold disabled:opacity-50">
                        Thêm vào giỏ hàng
                    </button>
                </form>

                <div class="mt-8 bg-white rounded-3xl border border-[#E5E7D8] p-6">
                    <h2 class="text-2xl font-bold text-[#2F512A] mb-4">
                        Mô tả sản phẩm
                    </h2>

                    <p class="text-gray-700 leading-7">
                        <?= nl2br(htmlspecialchars($product['MoTa'] ?? 'Chưa có mô tả.')) ?>
                    </p>

                    <?php if (!empty($product['TacDongMoiTruong'])): ?>
                        <h3 class="text-xl font-bold text-[#2F512A] mt-6 mb-2">
                            Tác động môi trường
                        </h3>

                        <p class="text-gray-700 leading-7">
                            <?= nl2br(htmlspecialchars($product['TacDongMoiTruong'])) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="mt-8 bg-white rounded-3xl border border-[#E5E7D8] p-6">
                    <h2 class="text-2xl font-bold text-[#2F512A] mb-4">
                        Đánh giá
                    </h2>

                    <?php if (empty($reviews)): ?>
                        <p class="text-gray-600">
                            Chưa có đánh giá hiển thị cho sản phẩm này.
                        </p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($reviews as $review): ?>
                                <div class="border-b border-[#E5E7D8] pb-4 last:border-b-0">
                                    <div class="flex justify-between mb-2">
                                        <strong class="text-[#2F512A]">
                                            <?= htmlspecialchars($review['HoTen'] ?? 'Khách hàng') ?>
                                        </strong>

                                        <span>
                                            <?= str_repeat('★', (int)($review['SoSao'] ?? 5)) ?>
                                        </span>
                                    </div>

                                    <p class="text-gray-700">
                                        <?= htmlspecialchars($review['NoiDung'] ?? '') ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    const variantSelect = document.getElementById('variantSelect');
    const variantPrice = document.getElementById('variantPrice');
    const quantityInput = document.getElementById('quantityInput');

    function formatVND(value) {
        return new Intl.NumberFormat('vi-VN').format(value) + '₫';
    }

    if (variantSelect) {
        function syncVariantInfo() {
            const selected = variantSelect.options[variantSelect.selectedIndex];
            const price = Number(selected.dataset.price || 0);
            const stock = Number(selected.dataset.stock || 1);

            if (variantPrice) {
                variantPrice.textContent = formatVND(price);
            }

            if (quantityInput) {
                quantityInput.max = stock;
                if (Number(quantityInput.value) > stock) {
                    quantityInput.value = stock;
                }
            }
        }

        variantSelect.addEventListener('change', syncVariantInfo);
        syncVariantInfo();
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>