<?php
/**
 * views/product/detail.php
 * Requires: $product, $images, $variants, $reviews
 * All data comes from SQL via ProductModel + ProductController
 */
include __DIR__ . '/../layouts/header.php';

// ── Image URL helper ────────────────────────────────────────────────────────
if (!function_exists('productImageUrl')) {
    function productImageUrl(string $path): string {
        if (preg_match('/^https?:\/\//', $path)) return $path;
        return BASE_URL . 'public/images/' . ltrim($path, '/');
    }
}

// ── Compute display price range from real variants ──────────────────────────
$minPrice = PHP_INT_MAX;
$maxPrice = 0;
foreach ($variants as $v) {
    $p = (float)$v['GiaTien'];
    if ($p < $minPrice) $minPrice = $p;
    if ($p > $maxPrice) $maxPrice = $p;
}
if ($minPrice === PHP_INT_MAX) $minPrice = 0;
$priceDisplay = ($minPrice === $maxPrice)
    ? number_format($minPrice, 0, ',', '.') . ' ₫'
    : number_format($minPrice, 0, ',', '.') . ' – ' . number_format($maxPrice, 0, ',', '.') . ' ₫';

// ── Average rating ───────────────────────────────────────────────────────────
$avgRating = 0;
if (!empty($reviews)) {
    $avgRating = array_sum(array_column($reviews, 'SoSao')) / count($reviews);
}
?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-12 md:py-20">

  <!-- BREADCRUMB -->
  <nav class="flex flex-wrap gap-2 text-xs font-label uppercase tracking-widest text-outline mb-10 items-center">
    <a class="hover:text-primary" href="<?= BASE_URL ?>">Trang chủ</a>
    <span>/</span>
    <a class="hover:text-primary" href="<?= BASE_URL ?>?url=product">Sản phẩm</a>
    <span>/</span>
    <a class="hover:text-primary" href="<?= BASE_URL ?>?url=product&category=<?= htmlspecialchars($product['MaDanhMuc']) ?>">
      <?= htmlspecialchars($product['TenDanhMuc'] ?? 'Danh mục') ?>
    </a>
    <span>/</span>
    <span class="text-on-surface font-semibold line-clamp-1"><?= htmlspecialchars($product['TenSanPham']) ?></span>
  </nav>

  <!-- MAIN GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

    <!-- ── LEFT: IMAGE GALLERY ──────────────────────────────────────────── -->
    <div class="lg:col-span-7">
      <!-- Main image -->
      <div class="main-preview relative aspect-[4/5] overflow-hidden rounded-2xl bg-surface-container-low group mb-4">
        <?php if (!empty($images)): ?>
          <img id="main-image"
               class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
               src="<?= htmlspecialchars(productImageUrl($images[0]['DuongDan'])) ?>"
               alt="<?= htmlspecialchars($product['TenSanPham']) ?>" />
        <?php else: ?>
          <div class="w-full h-full flex items-center justify-center text-outline">
            <span class="material-symbols-outlined text-7xl">image</span>
          </div>
        <?php endif; ?>

        <!-- Eco score badge -->
        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
          <span class="material-symbols-outlined text-green-600 text-sm" style="font-variation-settings:'FILL' 1">eco</span>
          <span class="text-xs font-black text-green-700 uppercase tracking-wider">Điểm xanh: <?= (int)$product['DiemXanh'] ?>/100</span>
        </div>
      </div>

      <!-- Thumbnail strip -->
      <?php if (count($images) > 1): ?>
      <div class="flex gap-3 overflow-x-auto pb-2" id="thumb-strip">
        <?php foreach ($images as $idx => $img): ?>
          <button type="button"
            class="thumb-btn flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all
                   <?= $idx === 0 ? 'border-primary ring-2 ring-primary/30' : 'border-transparent hover:border-outline-variant' ?>"
            data-src="<?= htmlspecialchars(productImageUrl($img['DuongDan'])) ?>">
            <img class="w-full h-full object-cover"
                 src="<?= htmlspecialchars(productImageUrl($img['DuongDan'])) ?>"
                 alt="Ảnh <?= $idx + 1 ?>">
          </button>
        <?php endforeach; ?>
      </div>
      <!-- Thumbnail click handler (thiếu trong JS gốc) -->
      <script>
        document.getElementById('thumb-strip')?.addEventListener('click', function(e) {
          const btn = e.target.closest('.thumb-btn');
          if (!btn) return;
          const src = btn.dataset.src;
          const mainImg = document.getElementById('main-image');
          if (mainImg && src) mainImg.src = src;
          document.querySelectorAll('.thumb-btn').forEach(b => {
            b.classList.remove('border-primary', 'ring-2', 'ring-primary/30');
            b.classList.add('border-transparent');
          });
          btn.classList.add('border-primary', 'ring-2', 'ring-primary/30');
          btn.classList.remove('border-transparent');
        });
      </script>
      <?php endif; ?>
    </div>

    <!-- ── RIGHT: PRODUCT INFO ──────────────────────────────────────────── -->
    <div class="lg:col-span-5 sticky top-28 space-y-8">

      <!-- Brand + Category pill -->
      <div class="flex items-center gap-3 flex-wrap">
        <?php if (!empty($product['TenThuongHieu'])): ?>
          <span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-black uppercase tracking-widest rounded-full">
            <?= htmlspecialchars($product['TenThuongHieu']) ?>
          </span>
        <?php endif; ?>
        <?php if (!empty($product['TenDanhMuc'])): ?>
          <span class="px-3 py-1 bg-surface-container text-on-surface-variant text-xs font-medium rounded-full">
            <?= htmlspecialchars($product['TenDanhMuc']) ?>
          </span>
        <?php endif; ?>
      </div>

      <!-- Product name -->
      <h1 class="text-3xl md:text-4xl xl:text-5xl font-headline font-bold text-primary leading-tight">
        <?= htmlspecialchars($product['TenSanPham']) ?>
      </h1>

      <!-- Rating summary -->
      <?php if (!empty($reviews)): ?>
      <div class="flex items-center gap-3">
        <div class="flex text-yellow-500 text-lg">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <?= $i <= round($avgRating) ? '★' : '☆' ?>
          <?php endfor; ?>
        </div>
        <span class="text-sm text-on-surface-variant font-medium">
          <?= number_format($avgRating, 1) ?> · <?= count($reviews) ?> đánh giá
        </span>
      </div>
      <?php endif; ?>

      <!-- Price display (updates via JS when variant selected) -->
      <p id="display-price" class="text-2xl md:text-3xl font-bold text-on-surface">
        <?= $priceDisplay ?>
      </p>

      <!-- ── VARIANT SELECTION FORM ──────────────────────────────────── -->
      <form id="cart-form" action="<?= BASE_URL ?>?url=cart/add" method="POST" class="space-y-6">
        <input type="hidden" name="MaSanPham"   value="<?= htmlspecialchars($product['MaSanPham']) ?>">
        <input type="hidden" name="MaBienThe"   id="selected-variant-id" value="">

        <?php
          // Group variants: get unique colors and sizes
          $colors = array_values(array_unique(array_filter(array_column($variants, 'MauSac'))));
          $sizes  = array_values(array_unique(array_filter(array_column($variants, 'KichThuoc'))));
        ?>

        <!-- Color selector -->
        <?php if (!empty($colors)): ?>
        <div>
          <span class="block text-sm font-label font-bold text-on-surface mb-3 uppercase tracking-wider">
            Màu sắc: <span id="selected-color-label" class="text-primary normal-case font-semibold"></span>
          </span>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($colors as $color): ?>
              <button type="button"
                class="variant-btn color-btn px-4 py-2 border-2 rounded-lg text-sm font-medium transition-all
                       border-outline-variant hover:border-primary focus:outline-none"
                data-type="MauSac"
                data-value="<?= htmlspecialchars($color) ?>">
                <?= htmlspecialchars($color) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Size selector -->
        <?php if (!empty($sizes)): ?>
        <div>
          <span class="block text-sm font-label font-bold text-on-surface mb-3 uppercase tracking-wider">
            Kích thước: <span id="selected-size-label" class="text-primary normal-case font-semibold"></span>
          </span>
          <div class="flex flex-wrap gap-2">
            <?php foreach ($sizes as $size): ?>
              <button type="button"
                class="variant-btn size-btn px-5 py-2.5 border-2 rounded-lg text-sm font-medium transition-all
                       border-outline-variant hover:border-primary focus:outline-none"
                data-type="KichThuoc"
                data-value="<?= htmlspecialchars($size) ?>">
                <?= htmlspecialchars($size) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Stock indicator -->
        <p id="stock-info" class="text-sm text-on-surface-variant hidden">
          <span class="material-symbols-outlined text-sm align-middle text-green-600">inventory_2</span>
          Còn <strong id="stock-qty" class="text-green-700">--</strong> sản phẩm
        </p>

        <!-- Quantity -->
        <div>
          <span class="block text-sm font-label font-bold text-on-surface mb-3 uppercase tracking-wider">Số lượng</span>
          <div class="flex items-center gap-4">
            <div class="flex items-center border-2 border-outline-variant rounded-xl overflow-hidden">
              <button type="button" id="qty-minus"
                class="px-4 py-3 text-xl font-bold text-primary hover:bg-surface-container transition-colors">−</button>
              <input type="number" name="SoLuong" id="quantity"
                     value="1" min="1" max="99"
                     class="w-16 text-center border-none outline-none font-bold text-on-surface bg-transparent py-3
                            [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
              <button type="button" id="qty-plus"
                class="px-4 py-3 text-xl font-bold text-primary hover:bg-surface-container transition-colors">+</button>
            </div>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex gap-3 flex-col sm:flex-row">
          <button type="submit" id="btn-add-cart"
            class="flex-1 bg-primary text-on-primary font-bold py-4 px-6 rounded-xl
                   hover:opacity-90 active:scale-95 transition-all text-base tracking-wide">
            <span class="material-symbols-outlined align-middle mr-1 text-lg">add_shopping_cart</span>
            Thêm vào giỏ hàng
          </button>
          <a href="<?= BASE_URL ?>?url=cart"
            class="flex-1 border-2 border-outline-variant text-primary font-bold py-4 px-6 rounded-xl
                   hover:border-primary active:scale-95 transition-all text-base text-center flex items-center justify-center gap-1">
            <span class="material-symbols-outlined text-lg">shopping_cart</span>
            Xem giỏ hàng
          </a>
        </div>

        <!-- Error message -->
        <p id="variant-error" class="hidden text-red-500 text-sm font-medium bg-red-50 border border-red-200 rounded-lg px-4 py-3">
          ⚠️ Vui lòng chọn đầy đủ màu sắc và kích thước trước khi thêm vào giỏ.
        </p>
      </form>

      <!-- ── PRODUCT META ────────────────────────────────────────────── -->
      <div class="border-t border-outline-variant/20 pt-6 space-y-4">
        <?php if (!empty($product['TenVatLieu'])): ?>
        <div class="flex gap-3 items-start">
          <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings:'FILL' 1">science</span>
          <div>
            <p class="text-sm font-bold text-on-surface">Vật liệu</p>
            <p class="text-sm text-on-surface-variant"><?= htmlspecialchars($product['TenVatLieu']) ?></p>
          </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($product['NguonGoc'])): ?>
        <div class="flex gap-3 items-start">
          <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings:'FILL' 1">location_on</span>
          <div>
            <p class="text-sm font-bold text-on-surface">Nguồn gốc</p>
            <p class="text-sm text-on-surface-variant"><?= htmlspecialchars($product['NguonGoc']) ?></p>
          </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($product['TacDongMoiTruong'])): ?>
        <div class="flex gap-3 items-start">
          <span class="material-symbols-outlined text-green-600 mt-0.5" style="font-variation-settings:'FILL' 1">eco</span>
          <div>
            <p class="text-sm font-bold text-on-surface">Tác động môi trường</p>
            <p class="text-sm text-on-surface-variant"><?= htmlspecialchars($product['TacDongMoiTruong']) ?></p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- ── ECO STATS SECTION ──────────────────────────────────────────────── -->
  <section class="mt-20 p-8 md:p-12 bg-surface-container rounded-2xl">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-headline font-bold text-primary mb-2">
        Chỉ số xanh: <?= (int)$product['DiemXanh'] ?>/100
      </h2>
      <p class="text-on-surface-variant">Mỗi sản phẩm bạn chọn đều góp phần bảo vệ hành tinh.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
      <div class="bg-surface p-6 rounded-xl border border-outline-variant/10">
        <div class="text-3xl font-headline font-black text-primary mb-1">
          <?= !empty($product['CoTaiChe']) ? '✓ Có' : '✗ Không' ?>
        </div>
        <div class="text-xs font-label uppercase tracking-widest text-outline">Khả năng tái chế</div>
      </div>
      <div class="bg-surface p-6 rounded-xl border border-outline-variant/10">
        <div class="text-3xl font-headline font-black text-primary mb-1">
          <?= !empty($product['ThanThienMoiTruong']) ? 'Cao' : 'Trung bình' ?>
        </div>
        <div class="text-xs font-label uppercase tracking-widest text-outline">Thân thiện môi trường</div>
      </div>
      <div class="bg-surface p-6 rounded-xl border border-outline-variant/10">
        <div class="text-3xl font-headline font-black text-primary mb-1">100%</div>
        <div class="text-xs font-label uppercase tracking-widest text-outline">Chính hãng</div>
      </div>
    </div>
  </section>

  <!-- ── TABS: DESCRIPTION / REVIEWS ───────────────────────────────────── -->
  <section class="mt-16 border-t border-outline-variant/20 pt-12">
    <div class="flex gap-8 mb-10 border-b border-outline-variant/20">
      <button class="tab-btn pb-3 font-headline font-bold text-xl border-b-2 border-primary text-primary transition-all"
              data-tab="description">Mô tả sản phẩm</button>
      <button class="tab-btn pb-3 font-headline font-bold text-xl border-b-2 border-transparent text-outline hover:text-primary transition-all"
              data-tab="reviews">
        Đánh giá (<?= count($reviews) ?>)
      </button>
    </div>

    <div class="max-w-4xl mx-auto">

      <!-- BUG FIX #2: panels dùng class "tab-panel" để JS querySelectorAll(".tab-panel") tìm đúng -->
      <!-- Description tab -->
      <div id="tab-description" class="tab-panel">
        <div class="prose prose-lg max-w-none text-on-surface-variant leading-relaxed space-y-4">
          <p><?= nl2br(htmlspecialchars($product['MoTa'] ?? 'Chưa có mô tả cho sản phẩm này.')) ?></p>
          <?php if (!empty($product['TenVatLieu'])): ?>
            <p><strong>Vật liệu:</strong> <?= htmlspecialchars($product['TenVatLieu']) ?></p>
          <?php endif; ?>
          <?php if (!empty($product['MoTaVatLieu'])): ?>
            <p><?= nl2br(htmlspecialchars($product['MoTaVatLieu'])) ?></p>
          <?php endif; ?>
          <?php if (!empty($product['NguonGoc'])): ?>
            <p><strong>Nguồn gốc:</strong> <?= htmlspecialchars($product['NguonGoc']) ?></p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Reviews tab -->
      <div id="tab-reviews" class="tab-panel hidden">
        <?php if (!empty($reviews)): ?>
          <!-- Summary bar -->
          <div class="flex items-center gap-6 mb-8 p-6 bg-surface-container rounded-xl">
            <div class="text-center">
              <div class="text-5xl font-black text-primary"><?= number_format($avgRating, 1) ?></div>
              <div class="flex text-yellow-500 justify-center text-xl mt-1">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <?= $i <= round($avgRating) ? '★' : '☆' ?>
                <?php endfor; ?>
              </div>
              <div class="text-xs text-outline mt-1"><?= count($reviews) ?> đánh giá</div>
            </div>
          </div>

          <div class="space-y-4">
            <?php foreach ($reviews as $review): ?>
              <div class="bg-surface p-6 rounded-xl border border-outline-variant/10">
                <div class="flex justify-between items-start mb-3 flex-wrap gap-2">
                  <div>
                    <h4 class="font-bold text-on-surface"><?= htmlspecialchars($review['HoTen'] ?? 'Khách hàng') ?></h4>
                    <div class="flex text-yellow-500 text-sm mt-0.5">
                      <?= str_repeat('★', (int)$review['SoSao']) . str_repeat('☆', 5 - (int)$review['SoSao']) ?>
                    </div>
                  </div>
                  <span class="text-xs text-outline">
                    <?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?>
                  </span>
                </div>
                <p class="text-on-surface-variant text-sm leading-relaxed">
                  <?= nl2br(htmlspecialchars($review['NoiDung'])) ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-outline mb-4 block">rate_review</span>
            <p class="text-on-surface-variant italic mb-6 text-lg">Chưa có đánh giá nào cho sản phẩm này.</p>
            <p class="text-sm text-outline">Hãy là người đầu tiên chia sẻ trải nghiệm!</p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </section>

</main>

<!-- Pass variants data to JS -->
<script>
window.productVariants = <?= json_encode(array_values($variants), JSON_UNESCAPED_UNICODE) ?>;
window.hasColors = <?= json_encode(!empty($colors)) ?>;
window.hasSizes  = <?= json_encode(!empty($sizes)) ?>;
</script>
<script src="<?= BASE_URL ?>public/assets/js/product-detail.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>