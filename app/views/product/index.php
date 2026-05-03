<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
// Xử lý tiêu đề theo danh mục (Giả lập logic từ Controller)
$categoryTitle = 'Tất cả sản phẩm';
$categoriesList = [];

if (!empty($data['categories'])) {
  foreach ($data['categories'] as $item) {
    $categoriesList[$item['MaDanhMuc']] = $item['TenDanhMuc'];
  }
}
if (!empty($data['filters']['category']) && isset($categoriesList[$data['filters']['category']])) {
  $categoryTitle = $categoriesList[$data['filters']['category']];
}
?>

<main class="max-w-7xl mx-auto px-6 md:px-8 py-12">
  <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-sm text-on-surface-variant mb-12">
    <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>">Trang chủ</a>
    <span class="material-symbols-outlined text-xs">chevron_right</span>
    <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>?url=product">Sản phẩm</a>
    <span class="material-symbols-outlined text-xs">chevron_right</span>
    <span class="font-semibold text-primary"><?= htmlspecialchars($categoryTitle) ?></span>
  </nav>

  <div class="flex flex-col md:flex-row gap-12 lg:gap-16">
    <aside class="w-full md:w-64 flex-shrink-0 space-y-10">
      <form id="filter-form" method="GET" action="<?= BASE_URL ?>">
        <input type="hidden" name="url" value="product">

        <div>
          <h3 class="text-xl font-bold mb-4 text-primary">Tìm kiếm</h3>
          <div class="relative">
            <input type="text" name="keyword" value="<?= htmlspecialchars($data['filters']['keyword'] ?? '') ?>"
              class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 pl-10 focus:border-primary outline-none transition-colors"
              placeholder="Tên sản phẩm..." onkeypress="if(event.key==='Enter'){this.form.submit();}">
            <span class="material-symbols-outlined absolute left-3 top-3.5 text-outline">search</span>
          </div>
        </div>

        <div class="h-px bg-outline-variant/20 my-8"></div>

        <div>
          <h3 class="text-xl font-bold mb-6 text-primary">Danh mục</h3>
          <ul class="space-y-4">
            <li class="flex items-center justify-between group">
              <label class="flex items-center gap-3 cursor-pointer w-full">
                <input type="radio" name="category" value="" onchange="this.form.submit()"
                  class="accent-primary w-4 h-4" <?= empty($data['filters']['category']) ? 'checked' : '' ?>>
                <span class="text-on-surface-variant group-hover:text-primary transition-colors">Tất cả</span>
              </label>
            </li>
            <?php foreach ($categoriesList as $key => $label): ?>
              <li class="flex items-center justify-between group">
                <label class="flex items-center gap-3 cursor-pointer w-full">
                  <input type="radio" name="category" value="<?= htmlspecialchars($key) ?>" onchange="this.form.submit()"
                    class="accent-primary w-4 h-4" <?= (($data['filters']['category'] ?? '') == $key) ? 'checked' : '' ?>>
                  <span class="text-on-surface-variant group-hover:text-primary transition-colors">
                    <?= htmlspecialchars($label) ?>
                  </span>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="h-px bg-outline-variant/20 my-8"></div>

        <div>
          <h3 class="text-xl font-bold mb-4 text-primary">Mức giá tối đa</h3>
          <div class="relative">
            <span class="absolute left-4 top-3 text-on-surface-variant font-bold">₫</span>
            <input type="number" name="price_max" min="0" step="1"
              class="w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 pl-8 focus:border-primary outline-none transition-colors"
              placeholder="Không giới hạn" value="<?= htmlspecialchars($data['filters']['price_max'] ?? '') ?>"
              onchange="this.form.submit()" />
          </div>
        </div>

        <div class="h-px bg-outline-variant/20 my-8"></div>

        <div>
          <h3 class="text-xl font-bold mb-6 text-primary">Tác động môi trường</h3>
          <div class="space-y-4">
            <?php
            $impacts = $data['impacts'] ?? ['carbon-neutral' => 'Trung hòa carbon', 'plastic-free' => 'Không nhựa', 'upcycled' => 'Vật liệu tái chế nâng cấp'];
            foreach ($impacts as $key => $label):
              ?>
              <label class="flex items-center space-x-3 cursor-pointer group">
                <input type="radio" name="impact" value="<?= htmlspecialchars($key) ?>" onchange="this.form.submit()"
                  class="accent-primary w-4 h-4" <?= (($data['filters']['impact'] ?? '') === $key) ? 'checked' : '' ?>>
                <span class="text-on-surface-variant group-hover:text-primary transition-colors font-medium">
                  <?= htmlspecialchars($label) ?>
                </span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mt-8">
          <a href="<?= BASE_URL ?>?url=product"
            class="block w-full text-center px-4 py-3 rounded-xl border-2 border-outline-variant text-on-surface hover:border-primary hover:text-primary transition-all font-bold">
            Xóa bộ lọc
          </a>
        </div>
      </form>
    </aside>

    <section class="flex-1 min-w-0">
      <header class="flex flex-col xl:flex-row xl:items-end justify-between mb-12 gap-6">
        <div>
          <h1 class="text-4xl md:text-5xl font-extrabold text-primary mb-4 tracking-tight">
            <?= htmlspecialchars($categoryTitle) ?>
          </h1>
          <p class="text-on-surface-variant max-w-lg leading-relaxed mb-2">
            Những vật dụng thiết yếu cho một không gian sống xanh. Được tuyển chọn kỹ lưỡng vì tính bền vững và vẻ đẹp
            vượt thời gian.
          </p>
          <p class="text-sm font-bold text-secondary">
            Tìm thấy <?= count($data['products'] ?? []) ?> sản phẩm
          </p>
        </div>

        <div
          class="flex items-center gap-4 bg-surface-container-lowest border border-outline-variant/50 p-2 rounded-xl">
          <span class="text-sm font-bold text-on-surface-variant pl-2">Sắp xếp:</span>
          <select name="sort" form="filter-form" onchange="document.getElementById('filter-form').submit()"
            class="bg-transparent border-none outline-none text-sm font-semibold text-primary cursor-pointer pr-2">
            <option value="">Hàng mới về</option>
            <option value="price_asc" <?= (($data['filters']['sort'] ?? '') == 'price_asc') ? 'selected' : '' ?>>Giá: Thấp
              đến Cao
            </option>
            <option value="price_desc" <?= (($data['filters']['sort'] ?? '') == 'price_desc') ? 'selected' : '' ?>>Giá: Cao
              xuống
              Thấp</option>
            <option value="impact_desc" <?= (($data['filters']['sort'] ?? '') == 'impact_desc') ? 'selected' : '' ?>>Đánh
              giá tác
              động xanh</option>
          </select>
        </div>
      </header>

      <?php if (empty($data['products'])): ?>
        <div
          class="bg-surface-container-low border-2 border-dashed border-outline-variant rounded-3xl p-12 text-center flex flex-col items-center justify-center">
          <span class="material-symbols-outlined text-6xl text-outline mb-4">search_off</span>
          <h3 class="text-2xl font-bold text-primary mb-2">Không tìm thấy sản phẩm</h3>
          <p class="text-on-surface-variant">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm của bạn.</p>
          <a href="<?= BASE_URL ?>?url=product"
            class="mt-6 px-6 py-3 bg-primary text-on-primary rounded-xl font-bold hover:opacity-90 transition-opacity">Khám
            phá tất cả</a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
          <?php foreach ($data['products'] as $product): ?>
            <div class="group flex flex-col">
              <div
                class="relative aspect-[4/5] mb-5 overflow-hidden rounded-2xl bg-surface-container shadow-sm border border-outline-variant/20">
                <a href="<?= BASE_URL ?>?url=product/detail&id=<?= htmlspecialchars($product['MaSanPham']) ?>"
                  class="block h-full">

                  <img alt="<?= htmlspecialchars($product['TenSanPham']) ?>"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="<?= !empty($product['HinhAnh'])
                      ? BASE_URL . 'public/images/Products/' . $product['HinhAnh']
                      : BASE_URL . 'public/images/default.jpg' ?>" </a>
                  <?php if (!empty($product['is_bestseller'])): ?>
                    <div class="absolute top-4 left-4 pointer-events-none">
                      <span
                        class="bg-secondary-container text-on-secondary-container px-3 py-1.5 rounded-full text-[10px] font-black tracking-widest uppercase shadow-sm">
                        Bán chạy
                      </span>
                    </div>
                  <?php endif; ?>

                  <form method="POST" action="<?= BASE_URL ?>?url=cart/add" class="absolute bottom-4 right-4">
                    <input type="hidden" name="ma_san_pham" value="<?= htmlspecialchars($product['MaSanPham']) ?>">
                    <input type="hidden" name="so_luong" value="1">

                    <button type="submit"
                      class="bg-primary text-on-primary p-3.5 rounded-full shadow-xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hover:scale-110 active:scale-95">
                      <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                    </button>
                  </form>
              </div>

              <div class="flex flex-col flex-grow">
                <div class="text-[10px] font-black uppercase tracking-widest text-secondary mb-1.5">
                  <?= htmlspecialchars($categoriesList[$product['MaDanhMuc']] ?? 'Sản phẩm') ?>
                </div>

                <div class="flex justify-between items-start gap-4 mb-3">
                  <a href="<?= BASE_URL ?>?url=product/detail&id=<?= htmlspecialchars($product['MaSanPham']) ?>"
                    class="block">
                    <h3
                      class="text-lg font-bold font-headline text-on-surface group-hover:text-primary transition-colors line-clamp-2">
                      <?= htmlspecialchars($product['TenSanPham']) ?>
                    </h3>
                  </a>
                  <span
                    class="text-secondary font-black text-lg whitespace-nowrap"><?= number_format($product['Gia']) ?>đ</span>
                </div>

                <div class="mt-auto">
                  <div
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-black uppercase">
                    <span class="material-symbols-outlined text-[14px]"
                      style="font-variation-settings: 'FILL' 1;">eco</span>
                    <?= htmlspecialchars($product['eco_tag'] ?? 'THÂN THIỆN MÔI TRƯỜNG') ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-20 flex justify-center items-center gap-3">
          <button
            class="w-12 h-12 rounded-full flex items-center justify-center border-2 border-outline-variant hover:border-primary hover:text-primary transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
          </button>
          <div class="flex gap-2">
            <button class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold shadow-md">1</button>
            <button
              class="w-12 h-12 rounded-full hover:bg-surface-container-high font-bold transition-colors text-on-surface-variant">2</button>
            <button
              class="w-12 h-12 rounded-full hover:bg-surface-container-high font-bold transition-colors text-on-surface-variant">3</button>
          </div>
          <button
            class="w-12 h-12 rounded-full flex items-center justify-center border-2 border-outline-variant hover:border-primary hover:text-primary transition-all">
            <span class="material-symbols-outlined">arrow_forward</span>
          </button>
        </div>
      <?php endif; ?>
    </section>
  </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>