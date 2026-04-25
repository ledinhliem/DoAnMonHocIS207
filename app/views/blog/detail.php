<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-12 md:py-20">
    <!-- Nội dung sản phẩm -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
      
      <!-- Ảnh sản phẩm (chia ra có thumbnail và preview) -->
      <div class="lg:col-span-7 grid grid-cols-2 gap-4 md:gap-6">
        <div class="col-span-2 space-y-4">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $index => $img): ?>
                <div class="thumbnail-item cursor-pointer aspect-square overflow-hidden rounded-lg border-2 <?= $index === 0 ? 'border-primary' : 'border-transparent' ?> hover:border-primary transition-all bg-surface-container-low">
                    <img class="w-full h-full object-cover" 
                         src="<?= BASE_URL . $img['DuongDan'] ?>" 
                         data-full="<?= BASE_URL . $img['DuongDan'] ?>"
                         alt="Thumbnail <?= $index ?>">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-span-10">
        <div class="main-preview aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low group relative">
            <?php if (!empty($images)): ?>
                <img id="main-image" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                     src="<?= BASE_URL . $images[0]['DuongDan'] ?>" 
                     alt="<?= $product['TenSanPham'] ?>" />
            <?php else: ?>
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">No Image</div>
            <?php endif; ?>
        </div>
    </div>
      </div>

      <!-- Chi  sản phẩm (chia ra 5 column) -->
      <!-- Thanh điều hướng -->
      <div class="lg:col-span-5 sticky top-32">
        <nav class="flex gap-2 text-xs font-label uppercase tracking-widest text-outline mb-6">
          <a class="hover:text-primary" href="#"><?= $product['TenDanhMuc'] ?? 'Sản phẩm' ?></a>
          <span>/</span>
          <span class="text-on-surface"><?= $product['TenSanPham'] ?></span>
        </nav>

        <!-- Tên + giá -->
        <h1 class="text-5xl md:text-6xl font-headline font-bold text-primary leading-tight mb-4">
            <?= $product['TenSanPham'] ?>
        </h1>
        <p id="display-price" class="text-2xl font-body font-medium text-on-surface-variant mb-8">
          <?= number_format($variants[0]['GiaTien'] ?? 0, 0, ',', '.') ?> VNĐ
        </p>

        <div class="space-y-10">
          <?php 
            $colors = array_unique(array_column($variants, 'MauSac'));
            $sizes = array_unique(array_column($variants, 'KichThuoc'));
          ?>

          <!--Chọn màu -->
          <?php if(!empty($colors[0])): ?>
          <div>
            <span class="block text-sm font-label font-bold text-on-surface mb-4 uppercase tracking-wider">Màu sắc</span>
            <div class="flex gap-3">
              <?php foreach($colors as $color): ?>
                <button type="button" 
                  class="variant-btn px-4 py-2 border rounded-md transition-all border-outline-variant hover:border-primary"
                  data-type="MauSac" 
                  data-value="<?= $color ?>">
                  <?= $color ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- Chọn size -->
          <div>
            <span class="block text-sm font-label font-bold text-on-surface mb-4 uppercase tracking-wider">Kích thước</span>
            <div class="flex gap-3">
              <?php foreach($sizes as $size): ?>
                <button type="button" 
                  class="variant-btn px-6 py-3 rounded-lg border border-outline-variant text-sm font-medium transition-all hover:border-primary"
                  data-type="KichThuoc" 
                  data-value="<?= $size ?>">
                  <?= $size ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Nút thêm giỏ -->
          <div class="pt-4 flex flex-col gap-4">
            <form id="cart-form" action="<?= BASE_URL ?>?url=cart/add" method="POST">
              <input type="hidden" name="ma_san_pham" value="<?= $product['MaSanPham'] ?>">
              <input type="hidden" name="ma_bien_the" id="selected-variant-id" value="<?= $variants[0]['MaBienThe'] ?? '' ?>">
 
              <!-- Số lượng -->
              <div class="flex items-center gap-4 mb-4">
                <span class="text-sm font-label font-bold text-on-surface uppercase tracking-wider">Số lượng</span>
                <div class="flex items-center border border-outline-variant rounded-lg overflow-hidden">
                  <button type="button" id="qty-minus"
                    class="px-4 py-2 text-xl font-bold text-primary hover:bg-surface-container transition-colors">&#8722;</button>
                  <input type="number" name="so_luong" id="quantity"
                          value="1" min="1" max="<?= $variants[0]['SoLuongTon'] ?? 99 ?>"
                          class="[&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-14 text-center border-none outline-none font-bold text-on-surface bg-transparent py-2">

                  <button type="button" id="qty-plus"
                    class="px-4 py-2 text-xl font-bold text-primary hover:bg-surface-container transition-colors">+</button>
                </div>
              </div>
 
              <button type="submit" id="btn-add-cart"
                class="w-full bg-primary text-on-primary font-bold py-4 px-8 rounded-xl hover:opacity-90 active:scale-95 transition-all text-base tracking-wide">
                Thêm vào giỏ hàng
              </button>
            </form>
 
            <!-- Thông báo lỗi nếu chưa chọn variant -->
            <p id="variant-error" class="hidden text-red-500 text-sm text-center font-medium">
              &#9888;&#65039; Vui lòng chọn đầy đủ màu sắc và kích thước trước khi thêm vào giỏ.
            </p>
          </div>

          <!-- Mô tả chi tiết -->
          <div class="border-t border-outline-variant/20 pt-8 space-y-6">
            <div>
              <h3 class="font-headline font-bold text-primary text-xl mb-3">Vật liệu & Nguồn gốc</h3>
              <p class="text-on-surface-variant leading-relaxed font-body">
                Sản phẩm làm từ <strong><?= $product['TenVatLieu'] ?></strong>. Nguồn gốc: <?= $product['NguonGoc'] ?>.
              </p>
            </div>
            <div>
              <h3 class="font-headline font-bold text-primary text-xl mb-3">Tác động môi trường</h3>
              <p class="text-on-surface-variant leading-relaxed font-body">
                <?= $product['TacDongMoiTruong'] ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mô tả ảnh hưởng -->
    <section class="mt-32 p-12 bg-surface-container rounded-xl">
      <div class="max-w-4xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-headline font-bold text-primary mb-4">Chỉ số xanh: <?= $product['DiemXanh'] ?>/100</h2>
        <p class="text-on-surface-variant font-body text-lg">Mỗi sản phẩm bạn chọn đều góp phần bảo vệ hành tinh.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
         <div class="bg-surface-container-lowest p-8 rounded-xl">
            <div class="text-4xl font-headline font-black text-primary mb-2"><?= $product['CoTaiChe'] ? 'Có' : 'Không' ?></div>
            <div class="text-sm font-label uppercase tracking-widest text-outline">Khả năng tái chế</div>
         </div>
         <div class="bg-surface-container-lowest p-8 rounded-xl">
            <div class="text-4xl font-headline font-black text-primary mb-2"><?= $product['ThanThienMoiTruong'] ? 'Cao' : 'Trung bình' ?></div>
            <div class="text-sm font-label uppercase tracking-widest text-outline">Thân thiện môi trường</div>
         </div>
         <div class="bg-surface-container-lowest p-8 rounded-xl">
            <div class="text-4xl font-headline font-black text-primary mb-2">100%</div>
            <div class="text-sm font-label uppercase tracking-widest text-outline">Chính hãng</div>
         </div>
      </div>
    </section>

  <!-- Tab Mô Tả, Đánh giá -->
  <section class="mt-20 border-t border-outline-variant/20 pt-16">
    <div class="flex justify-center gap-12 mb-12">
        <button class="tab-btn active text-2xl font-headline font-bold pb-2 border-b-2 border-primary transition-all" data-tab="description">
            Mô tả sản phẩm
        </button>
        <button class="tab-btn text-2xl font-headline font-bold pb-2 border-b-2 border-transparent text-outline hover:text-primary transition-all" data-tab="reviews">
            Đánh giá khách hàng
        </button>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Tab: Mô tả sản phẩm -->
        <div id="description" class="tab-content animate-fadeIn">
          <div class="prose prose-lg max-w-none text-on-surface-variant font-body leading-relaxed space-y-4">
            <p><?= nl2br($product['MoTa'] ?? 'Chưa có mô tả cho sản phẩm này.') ?></p>
            <?php if (!empty($product['TenVatLieu'])): ?>
              <p><strong>Vật liệu:</strong> <?= $product['TenVatLieu'] ?></p>
            <?php endif; ?>
            <?php if (!empty($product['NguonGoc'])): ?>
              <p><strong>Nguồn gốc:</strong> <?= $product['NguonGoc'] ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Tab: Đánh giá -->
        <div id="reviews" class="tab-content hidden animate-fadeIn">
          <div class="space-y-6">
            <?php if (!empty($reviews)): ?>
              <?php foreach ($reviews as $review): ?>
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-primary"><?= $review['HoTen'] ?></h4>
                            <div class="flex text-yellow-500 text-sm">
                                <?= str_repeat('★', $review['SoSao']) ?><?= str_repeat('☆', 5 - $review['SoSao']) ?>
                            </div>
                        </div>
                        <span class="text-xs text-outline"><?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?></span>
                    </div>
                    <p class="text-on-surface-variant font-body"><?= nl2br($review['NoiDung']) ?></p>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center py-10">
                <p class="text-on-surface-variant italic mb-4">Chưa có đánh giá nào cho sản phẩm này.</p>
                <button class="bg-secondary text-on-secondary px-8 py-3 rounded-full font-bold hover:opacity-90">
                    Viết đánh giá đầu tiên
                </button>
              </div>

              <div id="review-form" class="hidden mt-4">
                <textarea id="review-content"
                  placeholder="Nhập đánh giá của bạn..."
                  class="w-full border rounded-lg p-3 mb-3"></textarea>

                <button id="submit-review"
                  class="bg-green-700 text-white px-4 py-2 rounded-lg">
                  Gửi đánh giá
                </button>
              </div>
            <?php endif; ?>
          </div>
        </div>
    </div>
    </section>
  </main>
  
  <script>
    window.productVariants = <?= json_encode($variants) ?>;
  </script>

  <script src="<?= BASE_URL ?>public/assets/js/product.js"></script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>