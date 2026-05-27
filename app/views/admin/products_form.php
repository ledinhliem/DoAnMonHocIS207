<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$product = $product ?? [];
$isEdit = $isEdit ?? false;
$canShow = $canShow ?? false;
$status = $status ?? null;
$message = $message ?? null;
$created = $created ?? false;

$categories = $categories ?? [];
$brands = $brands ?? [];
$materials = $materials ?? [];
$productVariants = $productVariants ?? [];
$selectedCategoryId = $product['MaDanhMuc'] ?? '';
$selectedCategoryName = '';
foreach ($categories as $categoryItem) {
    if (($categoryItem['MaDanhMuc'] ?? '') === $selectedCategoryId) {
        $selectedCategoryName = $categoryItem['TenDanhMuc'] ?? '';
        break;
    }
}
$isFashionSelected = stripos($selectedCategoryName, 'fashion') !== false;
$selectedFashionType = $product['fashion_type'] ?? ($product['MauSac'] ?? '');
$selectedFashionSize = $product['fashion_size'] ?? ($product['KichThuoc'] ?? '');
$selectedFashionSize = trim(str_ireplace(['Size EU', 'Size'], '', (string)$selectedFashionSize));
$knownFashionTypes = ['clothes', 'underwear', 'shoes'];
$selectedCustomType = $product['fashion_custom_type'] ?? '';
$selectedCustomSize = $product['fashion_custom_size'] ?? '';
if ($selectedFashionType !== '' && !in_array((string)$selectedFashionType, $knownFashionTypes, true)) {
    $selectedCustomType = $selectedCustomType ?: $selectedFashionType;
    $selectedCustomSize = $selectedCustomSize ?: $selectedFashionSize;
    $selectedFashionType = 'other';
}
if ($selectedFashionType === '' && $selectedFashionSize !== '') {
    $selectedFashionType = in_array((string)$selectedFashionSize, ['39', '40', '41', '42'], true) ? 'shoes' : 'clothes';
}
$materialName = $product['TenVatLieu'] ?? $product['material_name'] ?? '';
$selectedBrandId = $product['MaThuongHieu'] ?? '';
$newBrandName = $product['new_brand_name'] ?? '';
$coverImageCount = min(1, (int)($product['cover_image_count'] ?? ($product['image_count'] ?? 0)));
$detailImageCount = (int)($product['detail_image_count'] ?? max(0, ((int)($product['image_count'] ?? 0)) - $coverImageCount));
$detailImageLimit = 8;
$remainingDetailSlots = max(0, $detailImageLimit - $detailImageCount);

$actionUrl = $isEdit
    ? 'index.php?url=admin/products/edit&id=' . urlencode($product['MaSanPham'] ?? '')
    : 'index.php?url=admin/products/create';

$initialVariants = [];
foreach ($productVariants as $variant) {
    $attributes = [];
    $rawAttributes = $variant['ThuocTinhJson'] ?? $variant['attributes_json'] ?? '';
    if (is_string($rawAttributes) && $rawAttributes !== '') {
        $decodedAttributes = json_decode($rawAttributes, true);
        if (is_array($decodedAttributes)) {
            $attributes = $decodedAttributes;
        }
    } elseif (is_array($rawAttributes)) {
        $attributes = $rawAttributes;
    }
    if (empty($attributes)) {
        if (!empty($variant['KichThuoc'] ?? $variant['kich_thuoc'] ?? '')) {
            $attributes['Kích thước'] = $variant['KichThuoc'] ?? $variant['kich_thuoc'];
        }
        if (!empty($variant['MauSac'] ?? $variant['mau_sac'] ?? '')) {
            $attributes['Màu sắc'] = $variant['MauSac'] ?? $variant['mau_sac'];
        }
    }
    $variantName = $variant['TenBienThe'] ?? $variant['name'] ?? '';
    if ($variantName === '' && !empty($attributes)) {
        $variantName = implode(' / ', array_values($attributes));
    }
    $initialVariants[] = [
        'sku' => $variant['MaBienThe'] ?? $variant['sku'] ?? '',
        'name' => $variantName,
        'attributes' => $attributes,
        'kich_thuoc' => $variant['KichThuoc'] ?? $variant['kich_thuoc'] ?? '',
        'mau_sac' => $variant['MauSac'] ?? $variant['mau_sac'] ?? '',
        'price' => $variant['GiaTien'] ?? $variant['price'] ?? '',
        'stock' => $variant['SoLuongTon'] ?? $variant['stock'] ?? '',
    ];
}
?>

<main class="ml-64 p-8 lg:p-12">
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-primary tracking-tighter mb-2">
                <?= $isEdit ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' ?>
            </h2>
            <p class="text-on-surface-variant text-lg max-w-2xl">
                <?= $isEdit ? 'Cập nhật thông tin sản phẩm và trạng thái hiển thị.' : 'Tạo sản phẩm mới. Sản phẩm mới sẽ mặc định ẩn đến khi hoàn chỉnh thông tin.' ?>
            </p>
        </div>

        <a href="index.php?url=admin/products" class="bg-surface-container-high text-on-surface px-6 py-3 rounded-lg font-bold hover:bg-surface-variant transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Quay lại danh sách
        </a>
    </header>

    <?php if ($status || $created): ?>
        <div class="mb-6 rounded-xl p-5 <?= $status === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?> shadow-sm">
            <p class="font-semibold mb-1">
                <?= $status === 'success' ? 'Hoàn tất' : 'Thông báo' ?>
            </p>
            <p class="text-sm">
                <?= e($message ?: ($created ? 'Sản phẩm đã khởi tạo. Vui lòng hoàn thiện biến thể và ảnh trước khi bật hiển thị.' : '')) ?>
            </p>
        </div>
    <?php endif; ?>

    <section class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-8">
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <form action="<?= e($actionUrl) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="<?= $isEdit ? 'update_product' : 'create_product' ?>">

                <?php if ($isEdit): ?>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold">Mã sản phẩm</label>
                        <input 
                            type="text" 
                            readonly 
                            value="<?= e($product['MaSanPham'] ?? '') ?>" 
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                        >
                        <input type="hidden" name="MaSanPham" value="<?= e($product['MaSanPham'] ?? '') ?>">
                    </div>
                <?php endif; ?>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Tên sản phẩm</label>
                    <input 
                        name="TenSanPham" 
                        type="text" 
                        value="<?= e($product['TenSanPham'] ?? '') ?>" 
                        class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface" 
                        required
                    >
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Danh mục</label>
                        <select name="MaDanhMuc" id="category-select" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option 
                                    value="<?= e($category['MaDanhMuc'] ?? '') ?>"
                                    data-fashion="<?= stripos((string)($category['TenDanhMuc'] ?? ''), 'fashion') !== false ? '1' : '0' ?>"
                                    data-category-name="<?= e($category['TenDanhMuc'] ?? '') ?>"
                                    <?= (($product['MaDanhMuc'] ?? '') === ($category['MaDanhMuc'] ?? '')) ? 'selected' : '' ?>
                                >
                                    <?= e($category['TenDanhMuc'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Thương hiệu</label>
                        <select name="MaThuongHieu" id="brand-select" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface">
                            <option value="">Chọn thương hiệu</option>
                            <?php foreach ($brands as $brand): ?>
                                <option 
                                    value="<?= e($brand['MaThuongHieu'] ?? '') ?>"
                                    <?= ($selectedBrandId === ($brand['MaThuongHieu'] ?? '')) ? 'selected' : '' ?>
                                >
                                    <?= e($brand['TenThuongHieu'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                            <option value="__new__" <?= $selectedBrandId === '__new__' ? 'selected' : '' ?>>Khác / thêm thương hiệu mới</option>
                        </select>
                    </div>
                </div>

                <div id="new-brand-fields" class="grid gap-3 <?= $selectedBrandId === '__new__' ? '' : 'hidden' ?>">
                    <div>
                        <label class="text-sm font-semibold">Tên thương hiệu mới</label>
                        <input
                            name="new_brand_name"
                            type="text"
                            value="<?= e($newBrandName) ?>"
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                            placeholder="VD: Green Choice"
                        >
                    </div>
                </div>

                <section class="rounded-xl border border-outline px-5 py-5 bg-surface-container-lowest space-y-4">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Phân loại / Biến thể sản phẩm</h3>
                            <p class="text-sm text-on-surface-variant mt-1">
                                Chọn nhóm biến thể, nhập giá trị cách nhau bằng dấu phẩy rồi tạo bảng biến thể. Nhập 0 cho nhóm không áp dụng, giá trị 0 sẽ không hiển thị ở trang user.
                            </p>
                        </div>
                        <button type="button" id="toggle-variant-builder" class="bg-surface-container-high text-on-surface px-4 py-2 rounded-lg font-bold hover:bg-surface-variant">
                            Chọn biến thể
                        </button>
                    </div>

                    <div id="variant-builder" class="space-y-4 hidden">
                        <div id="variant-option-groups" class="grid gap-3 md:grid-cols-2"></div>
                        <button type="button" id="generate-variants" class="bg-primary text-on-primary px-5 py-3 rounded-xl font-bold hover:bg-primary-container">
                            Tạo bảng biến thể
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-outline/40">
                        <table class="w-full min-w-[900px]">
                            <thead class="bg-surface-container-low">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-black uppercase text-outline">SKU / Mã biến thể</th>
                                    <th class="px-4 py-3 text-left text-xs font-black uppercase text-outline">Tên biến thể</th>
                                    <th class="px-4 py-3 text-left text-xs font-black uppercase text-outline">Thuộc tính</th>
                                    <th class="px-4 py-3 text-left text-xs font-black uppercase text-outline">Giá</th>
                                    <th class="px-4 py-3 text-left text-xs font-black uppercase text-outline">Tồn kho</th>
                                    <th class="px-4 py-3 text-right text-xs font-black uppercase text-outline">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="variant-table-body"></tbody>
                        </table>
                    </div>
                    <p id="variant-empty-note" class="text-sm text-red-700 hidden">Sản phẩm phải có ít nhất 1 biến thể.</p>
                </section>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Vật liệu</label>
                        <input
                            name="TenVatLieu"
                            type="text"
                            value="<?= e($materialName) ?>"
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                            placeholder="VD: Sợi tre hữu cơ, Chai nhôm tái sử dụng"
                            required
                        >
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Điểm xanh</label>
                        <input 
                            name="DiemXanh" 
                            type="number" 
                            min="0" 
                            max="100" 
                            value="<?= e($product['DiemXanh'] ?? 10) ?>" 
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                        >
                    </div>
                </div>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Mô tả</label>
                    <textarea name="MoTa" rows="5" class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"><?= e($product['MoTa'] ?? '') ?></textarea>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Nguồn gốc</label>
                        <input 
                            name="NguonGoc" 
                            type="text" 
                            value="<?= e($product['NguonGoc'] ?? '') ?>" 
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Tác động môi trường</label>
                        <input 
                            name="TacDongMoiTruong" 
                            type="text" 
                            value="<?= e($product['TacDongMoiTruong'] ?? '') ?>" 
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                        >
                    </div>
                </div>

                <div class="grid gap-3 lg:grid-cols-2">
                    <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-4 bg-surface-container-lowest cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="CoTaiChe" 
                            value="1" 
                            <?= (($product['CoTaiChe'] ?? 0) == 1) ? 'checked' : '' ?> 
                            class="w-5 h-5 text-primary"
                        >
                        <span>Có tái chế</span>
                    </label>

                    <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-4 bg-surface-container-lowest cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="ThanThienMoiTruong" 
                            value="1" 
                            <?= (($product['ThanThienMoiTruong'] ?? 0) == 1) ? 'checked' : '' ?> 
                            class="w-5 h-5 text-primary"
                        >
                        <span>Thân thiện môi trường</span>
                    </label>
                </div>

                <?php if ($isEdit): ?>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold">Trạng thái hiển thị</label>
                        <label class="flex items-center gap-3 rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest">
                            <input 
                                type="checkbox" 
                                name="TrangThai" 
                                value="1" 
                                <?= (($product['TrangThai'] ?? 0) == 1) ? 'checked' : '' ?> 
                                <?= $canShow ? '' : 'disabled' ?> 
                                class="w-5 h-5 text-primary"
                            >
                            <span>
                                <?= $canShow ? 'Có thể hiển thị' : 'Không thể bật hiển thị vì thiếu biến thể, giá hoặc ảnh' ?>
                            </span>
                        </label>

                        <?php if (!$canShow): ?>
                            <p class="text-sm text-red-700">
                                Sản phẩm cần có ít nhất 1 biến thể hợp lệ có giá, tồn kho và ảnh sản phẩm để bật hiển thị.
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="grid gap-3">
                    <label class="text-sm font-semibold">Ảnh bìa sản phẩm</label>
                    <input 
                        type="file" 
                        name="product_image" 
                        accept="image/jpeg,image/png,image/webp" 
                        data-product-image-input
                        data-image-role="cover"
                        class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                        <?= $isEdit ? '' : 'required' ?>
                    >
                    <p class="text-sm text-on-surface-variant">
                        Khuyến nghị ảnh 2400 x 2700 px để hiển thị đẹp. Chỉ nhận jpg, jpeg, png hoặc webp. Upload ảnh mới sẽ thay ảnh bìa hiện tại.
                    </p>

                    <p
                        id="cover-image-count"
                        data-saved-count="<?= e($coverImageCount) ?>"
                        class="text-sm font-semibold <?= $coverImageCount ? 'text-green-700' : 'text-amber-700' ?>"
                    >
                        Ảnh bìa: <?= e($coverImageCount) ?>/1
                    </p>
                </div>

                <?php if (!$isEdit): ?>
                    <div class="grid gap-3">
                        <label class="text-sm font-semibold">Ảnh chi tiết sản phẩm</label>
                        <input
                            type="file"
                            name="detail_images[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            data-product-image-input
                            data-image-role="detail"
                            data-max-files="<?= e($remainingDetailSlots) ?>"
                            class="w-full rounded-xl border border-outline px-4 py-3 bg-surface-container-lowest text-on-surface"
                            <?= $remainingDetailSlots > 0 ? '' : 'disabled' ?>
                        >
                        <p class="text-sm text-on-surface-variant">
                            Có thể chọn nhiều ảnh cùng lúc. Tối đa <?= e($detailImageLimit) ?> ảnh chi tiết. Khuyến nghị ảnh 2400 x 2700 px.
                        </p>
                        <p
                            id="detail-image-count"
                            data-saved-count="<?= e($detailImageCount) ?>"
                            data-limit="<?= e($detailImageLimit) ?>"
                            class="text-sm font-semibold <?= $detailImageCount >= $detailImageLimit ? 'text-amber-700' : 'text-on-surface-variant' ?>"
                        >
                            Ảnh chi tiết: <?= e($detailImageCount) ?>/<?= e($detailImageLimit) ?>
                            <?php if ($remainingDetailSlots > 0): ?>
                                · còn <?= e($remainingDetailSlots) ?> ảnh
                            <?php else: ?>
                                · đã đủ ảnh
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="grid gap-3 rounded-xl border border-outline px-4 py-4 bg-surface-container-lowest">
                        <p class="text-sm font-semibold text-on-surface">
                            Ảnh chi tiết: <?= e($detailImageCount) ?>/<?= e($detailImageLimit) ?>
                        </p>
                        <p class="text-sm text-on-surface-variant">
                            Ảnh chi tiết của sản phẩm có sẵn quản lý ở trang thư viện ảnh.
                        </p>
                        <a
                            href="index.php?url=admin/products/gallery&id=<?= urlencode((string)($product['MaSanPham'] ?? '')) ?>"
                            class="text-sm font-bold text-primary hover:underline"
                        >
                            Mở thư viện ảnh
                        </a>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                    <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:bg-primary-container transition-colors">
                        <?= $isEdit ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm' ?>
                    </button>

                    <a href="index.php?url=admin/products" class="text-sm text-on-surface-variant hover:text-primary">
                        Hủy bỏ
                    </a>
                </div>
            </form>
        </div>

        <aside class="space-y-6">
            <div class="rounded-xl bg-surface-container-lowest p-6 shadow-sm">
                <h3 class="font-bold text-lg mb-3">Luồng quản lý</h3>
                <p class="text-sm text-on-surface-variant leading-7">
                    Sản phẩm mới tạo sẽ mặc định ẩn. Sau khi thêm ảnh và biến thể hợp lệ, bạn có thể bật trạng thái hiển thị.
                </p>
            </div>

            <?php if ($isEdit): ?>
                <div class="rounded-xl bg-surface-container-lowest p-6 shadow-sm">
                    <h3 class="font-bold text-lg mb-3">Thông tin nhanh</h3>
                    <p class="text-sm text-on-surface">
                        <strong>Mã sản phẩm:</strong> <?= e($product['MaSanPham'] ?? '') ?>
                    </p>
                    <p class="text-sm text-on-surface">
                        <strong>Ảnh bìa:</strong> <?= e($coverImageCount) ?>/1
                    </p>
                    <p class="text-sm text-on-surface">
                        <strong>Ảnh chi tiết:</strong> <?= e($detailImageCount) ?>/8
                    </p>
                    <p class="text-sm text-on-surface">
                        <strong>Biến thể:</strong> <?= e($product['variant_count'] ?? 0) ?>
                    </p>
                    <p class="text-sm text-on-surface">
                        <strong>Tồn kho ước tính:</strong> <?= e($product['total_stock'] ?? 0) ?>
                    </p>
                </div>
            <?php endif; ?>
        </aside>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('category-select');
    const brandSelect = document.getElementById('brand-select');
    const newBrandFields = document.getElementById('new-brand-fields');
    const fashionFields = document.getElementById('fashion-fields');
    const fashionType = document.getElementById('fashion-type');
    const fashionSize = document.getElementById('fashion-size');
    const fashionSizeWrap = document.getElementById('fashion-size-wrap');
    const fashionCustomTypeWrap = document.getElementById('fashion-custom-type-wrap');
    const fashionCustomSizeWrap = document.getElementById('fashion-custom-size-wrap');
    const generalFields = document.getElementById('general-variant-fields');
    const variantSizeLabel = document.getElementById('variant-size-label');
    const variantLabelLabel = document.getElementById('variant-label-label');
    const variantSize = document.getElementById('variant-size');
    const variantLabel = document.getElementById('variant-label');
    const sizes = {
        clothes: ['M', 'L', 'XL'],
        underwear: ['M', 'L', 'XL'],
        shoes: ['39', '40', '41', '42']
    };

    function renderSizes() {
        const isOther = fashionType.value === 'other';
        fashionSizeWrap.classList.toggle('hidden', isOther);
        fashionCustomTypeWrap.classList.toggle('hidden', !isOther);
        fashionCustomSizeWrap.classList.toggle('hidden', !isOther);
        if (isOther) {
            fashionSize.innerHTML = '<option value="">Không dùng size cố định</option>';
            return;
        }

        const selected = fashionSize.dataset.selected || '';
        const options = sizes[fashionType.value] || [];
        fashionSize.innerHTML = '<option value="">Chọn size</option>';
        options.forEach(function (size) {
            const option = document.createElement('option');
            option.value = size;
            option.textContent = size;
            option.selected = selected === size;
            fashionSize.appendChild(option);
        });
    }

    function syncFashionFields() {
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const isFashion = selectedOption && selectedOption.dataset.fashion === '1';
        const categoryName = (selectedOption?.dataset.categoryName || '').toLowerCase();
        fashionFields.classList.toggle('hidden', !isFashion);
        generalFields.classList.toggle('hidden', isFashion);
        if (!isFashion) {
            fashionType.value = '';
            fashionSize.innerHTML = '<option value="">Chọn size</option>';
            if (categoryName.includes('kitchen')) {
                variantSizeLabel.textContent = 'Quy cách / dung tích';
                variantLabelLabel.textContent = 'Phân loại / mùi / chất liệu';
                variantSize.placeholder = 'VD: 30 cái/hộp, 500ml, bộ 3';
                variantLabel.placeholder = 'VD: Lemon, Inox, bã cà phê';
            } else if (categoryName.includes('decor')) {
                variantSizeLabel.textContent = 'Kích thước';
                variantLabelLabel.textContent = 'Màu sắc / chất liệu';
                variantSize.placeholder = 'VD: 120 x 120 cm, 16 x 26 cm';
                variantLabel.placeholder = 'VD: Tre tự nhiên, Hồng xám, Đen đỏ';
            } else if (categoryName.includes('care')) {
                variantSizeLabel.textContent = 'Dung tích / trọng lượng';
                variantLabelLabel.textContent = 'Loại da / mùi hương';
                variantSize.placeholder = 'VD: 200ml, 1000ml, 230g';
                variantLabel.placeholder = 'VD: Da dầu, Lavender, Không mùi';
            } else {
                variantSizeLabel.textContent = 'Quy cách / kích thước';
                variantLabelLabel.textContent = 'Phân loại / màu / mùi';
                variantSize.placeholder = 'VD: 500ml, 30 cái/hộp, 120 x 120 cm';
                variantLabel.placeholder = 'VD: Lemon, Đen, Tre tự nhiên';
            }
            return;
        }
        renderSizes();
    }

    if (categorySelect && fashionFields && fashionType && fashionSize) {
        categorySelect.addEventListener('change', syncFashionFields);
        fashionType.addEventListener('change', function () {
            fashionSize.dataset.selected = '';
            renderSizes();
        });
        syncFashionFields();
    }

    if (brandSelect && newBrandFields) {
        const syncBrandFields = function () {
            newBrandFields.classList.toggle('hidden', brandSelect.value !== '__new__');
        };
        brandSelect.addEventListener('change', syncBrandFields);
        syncBrandFields();
    }

    const variantSuggestions = {
        fashion: ['Size', 'Màu sắc'],
        care: ['Dung tích', 'Mùi hương', 'Loại da', 'Loại/kiểu'],
        kitchen: ['Quy cách', 'Dung tích', 'Kích thước', 'Màu sắc'],
        decor: ['Họa tiết', 'Chất liệu', 'Kích thước', 'Khối lượng', 'Mùi hương', 'Màu sắc'],
        default: ['Kích thước', 'Màu sắc', 'Loại/kiểu']
    };
    const initialVariants = <?= json_encode($initialVariants, JSON_UNESCAPED_UNICODE) ?>;
    const variantBuilder = document.getElementById('variant-builder');
    const variantOptionGroups = document.getElementById('variant-option-groups');
    const variantTableBody = document.getElementById('variant-table-body');
    const variantEmptyNote = document.getElementById('variant-empty-note');
    const toggleVariantBuilder = document.getElementById('toggle-variant-builder');
    const generateVariantsButton = document.getElementById('generate-variants');

    function getCurrentVariantGroups() {
        const selectedOption = categorySelect?.options[categorySelect.selectedIndex];
        const name = (selectedOption?.dataset.categoryName || '').toLowerCase();
        if (name.includes('fashion')) return variantSuggestions.fashion;
        if (name.includes('care')) return variantSuggestions.care;
        if (name.includes('kitchen')) return variantSuggestions.kitchen;
        if (name.includes('decor')) return variantSuggestions.decor;
        return variantSuggestions.default;
    }

    function renderVariantGroupOptions() {
        if (!variantOptionGroups) return;
        const groups = getCurrentVariantGroups();
        variantOptionGroups.innerHTML = groups.map(function (group, index) {
            return `
                <div class="rounded-xl border border-outline/50 p-4 bg-white" data-variant-group-card>
                    <label class="flex items-center gap-2 font-semibold text-sm">
                        <input type="checkbox" class="variant-group-check" data-group="${escapeHtml(group)}" ${index < 1 ? 'checked' : ''}>
                        ${escapeHtml(group)}
                    </label>
                    <input type="text" class="variant-group-values mt-3 w-full rounded-lg border border-outline px-3 py-2 text-sm" data-group="${escapeHtml(group)}" placeholder="VD: ${group === 'Size' ? 'S, M, L' : group === 'Màu sắc' ? 'Đen, Trắng' : '500ml, 700ml'}">
                </div>
            `;
        }).join('');

        variantOptionGroups.querySelectorAll('.variant-group-values').forEach(function (input) {
            input.addEventListener('input', function () {
                const checkbox = input.closest('[data-variant-group-card]')?.querySelector('.variant-group-check');
                if (checkbox && input.value.trim() !== '') {
                    checkbox.checked = true;
                }
            });
        });
    }

    function generateCombinations(groups) {
        return groups.reduce(function (acc, group) {
            const next = [];
            acc.forEach(function (combo) {
                group.values.forEach(function (value) {
                    next.push({ ...combo, [group.name]: value });
                });
            });
            return next;
        }, [{}]);
    }

    function createVariantsFromBuilder() {
        const groups = [];
        document.querySelectorAll('[data-variant-group-card]').forEach(function (card) {
            const checkbox = card.querySelector('.variant-group-check');
            const input = card.querySelector('.variant-group-values');
            const groupName = checkbox?.dataset.group || '';
            const values = parseVariantValues(input?.value || '', groupName);

            if (values.length && checkbox) {
                checkbox.checked = true;
            }

            if ((checkbox?.checked || values.length) && values.length) {
                groups.push({ name: groupName, values: values });
            }
        });

        if (!groups.length) {
            alert('Vui lòng chọn nhóm biến thể và nhập giá trị.');
            return;
        }

        const combinations = generateCombinations(groups);
        const newVariants = combinations.map(function (attributes) {
            const name = Object.values(attributes).join(' / ');
            return {
                sku: '',
                name: name,
                attributes: attributes,
                kich_thuoc: resolveVariantSize(attributes),
                mau_sac: resolveVariantColor(attributes),
                price: '',
                stock: ''
            };
        });

        const existingVariants = getCurrentVariantRows().filter(function (variant) {
            return !isBlankDefaultVariant(variant);
        });
        const existingKeys = new Set(existingVariants.map(function (variant) {
            return variantCombinationKey(variant.attributes || {}, variant.name || '');
        }));
        const variantsToAppend = newVariants.filter(function (variant) {
            const key = variantCombinationKey(variant.attributes || {}, variant.name || '');
            if (existingKeys.has(key)) {
                return false;
            }
            existingKeys.add(key);
            return true;
        });

        if (!variantsToAppend.length) {
            alert('Biến thể này đã có trong bảng.');
            return;
        }

        renderVariantRows(existingVariants.concat(variantsToAppend));
    }

    function parseVariantValues(rawValue, groupName) {
        const normalized = String(rawValue || '').replace(/[;\n\r|]+/g, ',');
        let values = normalized.split(',').map(function (value) {
            return value.trim();
        }).filter(Boolean);

        if (values.length === 1 && /^(size)$/i.test(groupName)) {
            values = values[0].split(/\s+/).map(function (value) {
                return value.trim();
            }).filter(Boolean);
        }

        return Array.from(new Set(values));
    }

    function resolveVariantSize(attributes) {
        return attributes['Size']
            || attributes['Dung tích']
            || attributes['Quy cách']
            || attributes['Kích thước']
            || attributes['Khối lượng']
            || attributes['Loại/kiểu']
            || Object.values(attributes)[0]
            || '';
    }

    function resolveVariantColor(attributes) {
        return attributes['Màu sắc']
            || attributes['Mùi hương']
            || attributes['Họa tiết']
            || attributes['Chất liệu']
            || '';
    }

    function renderVariantRows(variants) {
        if (!variantTableBody) return;
        variantTableBody.innerHTML = '';
        variants.forEach(function (variant, index) {
            appendVariantRow(variant, index);
        });
        if (variantEmptyNote) {
            variantEmptyNote.classList.toggle('hidden', variants.length > 0);
        }
    }

    function appendVariantRow(variant, index) {
        const attributes = variant.attributes || {};
        const attributesText = Object.entries(attributes).map(function ([key, value]) {
            return key + ': ' + value;
        }).join(', ');
        const tr = document.createElement('tr');
        tr.className = 'border-t border-outline/20';
        tr.innerHTML = `
            <td class="px-4 py-3">
                <input name="variants[${index}][sku]" value="${escapeHtml(variant.sku || '')}" class="w-full rounded-lg border border-outline px-3 py-2 text-sm" placeholder="Bỏ trống để tự sinh">
            </td>
            <td class="px-4 py-3">
                <input name="variants[${index}][name]" value="${escapeHtml(variant.name || '')}" class="w-full rounded-lg border border-outline px-3 py-2 text-sm" required>
            </td>
            <td class="px-4 py-3 text-sm text-on-surface-variant">
                ${escapeHtml(attributesText || variant.name || '')}
                <input type="hidden" name="variants[${index}][attributes_json]" value="${escapeHtml(JSON.stringify(attributes))}">
                <input type="hidden" name="variants[${index}][kich_thuoc]" value="${escapeHtml(variant.kich_thuoc || '')}">
                <input type="hidden" name="variants[${index}][mau_sac]" value="${escapeHtml(variant.mau_sac || '')}">
            </td>
            <td class="px-4 py-3">
                <input type="number" min="0" step="1000" name="variants[${index}][price]" value="${escapeHtml(variant.price || '')}" class="w-full rounded-lg border border-outline px-3 py-2 text-sm" required>
            </td>
            <td class="px-4 py-3">
                <input type="number" min="0" step="1" name="variants[${index}][stock]" value="${escapeHtml(variant.stock || '')}" class="w-full rounded-lg border border-outline px-3 py-2 text-sm" required>
            </td>
            <td class="px-4 py-3 text-right">
                <button type="button" class="remove-variant-row text-red-700 text-sm font-bold">Xóa</button>
            </td>
        `;
        tr.querySelector('.remove-variant-row').addEventListener('click', function () {
            tr.remove();
            reindexVariantRows();
        });
        variantTableBody.appendChild(tr);
    }

    function getCurrentVariantRows() {
        if (!variantTableBody) return [];
        return Array.from(variantTableBody.querySelectorAll('tr')).map(function (row) {
            const getInputValue = function (suffix) {
                return row.querySelector(`[name$="[${suffix}]"]`)?.value || '';
            };
            let attributes = {};
            const rawAttributes = getInputValue('attributes_json');
            if (rawAttributes) {
                try {
                    const decoded = JSON.parse(rawAttributes);
                    if (decoded && typeof decoded === 'object' && !Array.isArray(decoded)) {
                        attributes = decoded;
                    }
                } catch (error) {
                    attributes = {};
                }
            }

            return {
                sku: getInputValue('sku'),
                name: getInputValue('name'),
                attributes: attributes,
                kich_thuoc: getInputValue('kich_thuoc'),
                mau_sac: getInputValue('mau_sac'),
                price: getInputValue('price'),
                stock: getInputValue('stock')
            };
        });
    }

    function isBlankDefaultVariant(variant) {
        const attributes = variant.attributes || {};
        return (variant.sku || '') === ''
            && (variant.price || '') === ''
            && (variant.stock || '') === ''
            && (variant.name || '') === 'Mặc định'
            && Object.keys(attributes).length === 1
            && attributes['Loại/kiểu'] === 'Mặc định';
    }

    function variantCombinationKey(attributes, fallbackName) {
        const sorted = {};
        Object.keys(attributes || {}).sort().forEach(function (key) {
            sorted[key] = attributes[key];
        });
        const encoded = JSON.stringify(sorted);
        return encoded && encoded !== '{}' ? encoded : String(fallbackName || '').trim().toLowerCase();
    }

    function reindexVariantRows() {
        Array.from(variantTableBody.querySelectorAll('tr')).forEach(function (row, index) {
            row.querySelectorAll('[name^="variants["]').forEach(function (input) {
                input.name = input.name.replace(/variants\[\d+\]/, 'variants[' + index + ']');
            });
        });
        if (variantEmptyNote) {
            variantEmptyNote.classList.toggle('hidden', variantTableBody.querySelectorAll('tr').length > 0);
        }
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
        });
    }

    function cssEscape(value) {
        return String(value).replace(/"/g, '\\"');
    }

    if (variantBuilder && toggleVariantBuilder) {
        toggleVariantBuilder.addEventListener('click', function () {
            variantBuilder.classList.toggle('hidden');
        });
    }
    if (generateVariantsButton) {
        generateVariantsButton.addEventListener('click', createVariantsFromBuilder);
    }
    if (categorySelect) {
        categorySelect.addEventListener('change', renderVariantGroupOptions);
    }
    renderVariantGroupOptions();
    renderVariantRows(initialVariants.length ? initialVariants : [{
        sku: '',
        name: 'Mặc định',
        attributes: { 'Loại/kiểu': 'Mặc định' },
        kich_thuoc: 'Mặc định',
        mau_sac: '',
        price: '',
        stock: ''
    }]);

    document.querySelectorAll('[data-product-image-input]').forEach(function (input) {
        input.addEventListener('change', function () {
            const files = Array.from(input.files || []);
            if (!files.length) {
                updateSelectedImageCount(input, 0);
                return;
            }

            const maxFiles = Number(input.dataset.maxFiles || files.length);
            if (files.length > maxFiles) {
                alert('Chỉ có thể chọn thêm tối đa ' + maxFiles + ' ảnh chi tiết.');
                input.value = '';
                updateSelectedImageCount(input, 0);
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const invalidType = files.find(function (file) {
                return !allowedTypes.includes(file.type);
            });

            if (invalidType) {
                alert('Ảnh sản phẩm chỉ nhận jpg, jpeg, png hoặc webp.');
                input.value = '';
                updateSelectedImageCount(input, 0);
                return;
            }

            updateSelectedImageCount(input, files.length);
        });
    });

    function updateSelectedImageCount(input, selectedCount) {
        const role = input.dataset.imageRole;

        if (role === 'cover') {
            const coverCounter = document.getElementById('cover-image-count');
            if (!coverCounter) return;

            const savedCount = Number(coverCounter.dataset.savedCount || 0);
            const displayCount = selectedCount > 0 ? 1 : savedCount;
            coverCounter.textContent = 'Ảnh bìa: ' + displayCount + '/1';
            coverCounter.classList.toggle('text-green-700', displayCount > 0);
            coverCounter.classList.toggle('text-amber-700', displayCount === 0);
            return;
        }

        if (role === 'detail') {
            const detailCounter = document.getElementById('detail-image-count');
            if (!detailCounter) return;

            const savedCount = Number(detailCounter.dataset.savedCount || 0);
            const limit = Number(detailCounter.dataset.limit || 8);
            const displayCount = Math.min(limit, savedCount + selectedCount);
            const remaining = Math.max(0, limit - displayCount);
            detailCounter.textContent = 'Ảnh chi tiết: ' + displayCount + '/' + limit + (remaining > 0 ? ' · còn ' + remaining + ' ảnh' : ' · đã đủ ảnh');
        }
    }
});
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
