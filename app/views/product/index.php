<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <!-- Đường dẫn điều hướng -->
    <nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-sm text-on-surface-variant mb-12">
      <a class="hover:text-primary" href="<?= BASE_URL ?>">Home</a>
      <span class="material-symbols-outlined text-xs">chevron_right</span>
      <a class="hover:text-primary" href="<?= BASE_URL ?>?url=product">Shop</a>
      <span class="material-symbols-outlined text-xs">chevron_right</span>
      <span class="font-semibold text-primary">Sustainable Home</span>
    </nav>
    <div class="flex flex-col md:flex-row gap-16">
      <!-- Lọc sản phẩm -->
      <aside class="w-full md:w-64 space-y-12">
        <!-- Lọc theo loại sản phẩm -->
        <div>
          <h3 class="text-xl font-bold mb-6 text-primary">Categories</h3>
          <ul class="space-y-4">
            <li class="flex items-center justify-between group cursor-pointer">
              <span class="text-on-surface-variant group-hover:text-primary transition-colors">Kitchenware</span>
              <span class="bg-surface-container text-xs px-2 py-1 rounded-full text-on-surface-variant">24</span>
            </li>
            <li class="flex items-center justify-between group cursor-pointer font-semibold text-primary">
              <span>Living Room</span>
              <span class="bg-primary-container text-on-primary-container text-xs px-2 py-1 rounded-full">18</span>
            </li>
            <li class="flex items-center justify-between group cursor-pointer">
              <span>Bedroom</span>
              <span class="bg-surface-container text-xs px-2 py-1 rounded-full text-on-surface-variant">12</span>
            </li>
            <li class="flex items-center justify-between group cursor-pointer">
              <span>Wellness</span>
              <span class="bg-surface-container text-xs px-2 py-1 rounded-full text-on-surface-variant">31</span>
            </li>
          </ul>
        </div>
        <!-- Lọc theo giá tiền -->
        <div class="h-px bg-outline-variant/20"></div>
        <div>
          <h3 class="text-xl font-bold mb-6 text-primary">Price Range</h3>
          <div class="space-y-4">
            <input
              class="w-full accent-primary bg-surface-container-high h-1.5 rounded-lg appearance-none cursor-pointer"
              max="500" min="0" type="range" />
            <div class="flex justify-between text-sm font-medium text-secondary">
              <span>$0</span>
              <span>$500+</span>
            </div>
          </div>
        </div>
        <!-- Lọc chứng nhận liên quan đến môi trường -->
        <div class="h-px bg-outline-variant/20"></div>
        <div>
          <h3 class="text-xl font-bold mb-6 text-primary">Eco-Impact</h3>
          <div class="space-y-3">
            <label class="flex items-center space-x-3 cursor-pointer group">
              <div
                class="w-5 h-5 rounded border-2 border-outline group-hover:border-primary transition-colors flex items-center justify-center">
                <div class="w-2.5 h-2.5 bg-primary rounded-sm opacity-0 group-aria-checked:opacity-100"></div>
              </div>
              <span class="text-on-surface-variant group-hover:text-on-surface">Carbon Neutral</span>
            </label>
            <label class="flex items-center space-x-3 cursor-pointer group">
              <div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary text-xs"
                  style="font-variation-settings: 'wght' 700;">check</span>
              </div>
              <span class="text-on-surface font-medium">Plastic Free</span>
            </label>
            <label class="flex items-center space-x-3 cursor-pointer group">
              <div
                class="w-5 h-5 rounded border-2 border-outline group-hover:border-primary transition-colors flex items-center justify-center">
              </div>
              <span class="text-on-surface-variant group-hover:text-on-surface">Upcycled Materials</span>
            </label>
          </div>
        </div>
      </aside>
      <!-- Danh sách sản phẩm -->
      <section class="flex-1">
        <header class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
          <!-- Thông tin tiêu đề -->
          <div>
            <h1 class="text-5xl font-extrabold text-primary mb-4 tracking-tight">Sustainable Living</h1>
            <p class="text-on-surface-variant max-w-lg leading-relaxed">Curated essentials for a conscious home. Each
              piece is selected for its environmental integrity and timeless aesthetic.</p>
          </div>
          <!-- Lọc theo thứ tự:  Giá, Ngày bán, Điểm đánh giá-->
          <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-on-surface-variant">Sort by:</span>
            <select
              class="bg-surface-container-high border-none rounded-lg text-sm font-semibold text-primary focus:ring-primary/20 cursor-pointer py-2 pl-4 pr-10">
              <option>Newest Arrivals</option>
              <option>Price: Low to High</option>
              <option>Impact Rating</option>
            </select>
          </div>
        </header>

        <!-- Danh mục sản phẩm -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
          <!-- Sản phẩm 1 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <!-- Ảnh sản phẩm -->
              <img alt="Artisan Ceramic Vase"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="Minimalist handcrafted ceramic vase on a raw wooden table with soft morning sunlight casting organic shadows"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDqlscwvuEWY7f0mxUdWJHnX5Mdim_-jOgGbl9EXgA68CmGDqEHQ4J_Z1qrXDt7-z-WMVU40kmotZKLaU5QfZ08DRO9KtaHTB_0S2kev8tNzvXNxljvDW1Uxg-L_VJl09MhuZYeF_PuggPMafHFC866Z4a2m9bK3Bhyn1aUG3UffiP8Uk3gXbUsKTjnGF3uYlAyMh4H1Ls8YcoCE3jCoixX_dGfyvsw6cYTW5EOpDaI-8_ywQhnFk-Ja3sjOrUDmL697Jr7C6oSEC8" />
              <!-- Nhãn đánh dấu (Sản phẩm giới hạn, giảm giá, Best Seller...) -->
              <div class="absolute top-4 left-4">
                <span
                  class="bg-surface-container-lowest/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">Limited
                  Edition</span>
              </div>
              <!-- CTA thêm giỏ hàng -->
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <!-- Tên sản phẩm -->
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Terra Ceramic
                Vase</h3>
              <!-- Giá tiền -->
                <span class="text-secondary font-bold text-lg">$84.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <!-- Chứng nhận môi trường -->
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                CARBON NEUTRAL
              </div>
            </div>
          </div>
          <!-- Sản phẩm 2 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <img alt="Linen Cushion Set"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="Handwoven organic linen cushions in earth tones arranged on a sustainable cork bench in a bright minimalist room"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3d37Lblu6zQC_Pzm05qHjofM_rWGxFrHeUpBjzLiioBiGxbj7MprwVJ-5Tee-b1TH_jOo94L_u3ssZgrBeF99lbF6gjaPIStCkVnxsz2525_u0HEnKwRYKPQWBeVGPUmoY-Wiqqy24aprFb1YbHQdR7ziy4gz2IeTQnRNE3c6sMup6Wukx2RHZyOgFcF-KPp36ensxFy1L9_vO25u2QgxPcCp6Fj4wWKSE4pjTh5ecsUQ39r-rEW6mheBQ8jOCojUmJaKkOM9fBQ" />
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Raw Linen Cushion
                Set</h3>
              <span class="text-secondary font-bold text-lg">$120.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                BIODEGRADABLE
              </div>
            </div>
          </div>
          <!-- Sản phẩm 3 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <img alt="Organic Cotton Towels"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="A stack of folded organic cotton towels in sage green and cream colors on a stone shelf with a small eucalyptus branch"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAN8rGTSgawcW2iLdoNb19UMbi1MbYd1seInyTpaL07CV3EdfSmHRBgolhrftWd-BrXBsKxJanujtu-rwY8lCI-nN5WDON1iRfFw1O-fDWoWIFZMb1RsLyM2VurZlTmIjdjDxeKMymj6pGPPwtpqszyhRsXYTuEtmFhsllbDI2_nUbJTxee-loLqTHsK8nSoceCuCZsJZRC8n0R8e6nCm5Wjb1fZC2wmjEYMfSJJsWflp8i7F4JHuZKhBBpQBFohFkDDUtwEV4tAFc" />
              <div class="absolute top-4 left-4">
                <span
                  class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase">Best
                  Seller</span>
              </div>
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Cloud Cotton Bath
                Set</h3>
              <span class="text-secondary font-bold text-lg">$65.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                GOTS CERTIFIED
              </div>
            </div>
          </div>
          <!-- Sản phẩm 4 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <img alt="Recycled Glass Carafe"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="Modern recycled glass carafe and tumblers with a subtle green tint standing on a textured limestone surface"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUhY1QhlHwwqBj9UM-TQtnrdo7d6LNuAvqv09lZmwTR4RkN-yGDKqxvUJRaUU7V3lCRsL5Gg-AHkxB3aPyewjGsMlXtEbxEh4mw8sI5sFX_0ro3-x5wz-8Cf50MMXF--7GqeTShSTqdrEeHeKFRdDwFxD1w2ZjflhPxoXwUvd89vid7wnHZbLc4wFFdvfhAcusoO-HKL55w_kIKre8XAJ4I0M4DjOdY28uaYY_OM_05OTfJZkV7L4NAh_ckOBi5t1aQq4L3HdK8pM" />
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Fluted Glass
                Carafe</h3>
              <span class="text-secondary font-bold text-lg">$42.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                RECYCLED
              </div>
            </div>
          </div>
          <!-- Sản phẩm 5 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <img alt="Bamboo Cutlery Set"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="Sleek bamboo cutlery set and reusable straw in a woven pouch on a dark green mossy background"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhL8uNtyQLZGfCsvxLBjtTJSLPsIP6ytnjHgeFynYKr4c-l_Zh3Fs-M1wQQqSm-1n34iNcnlbjp0QjLGu2jPswa4lBkAuvHaafCfvx0L_nx9CqeePX83I54TXO-s31FwLvj2n56N-AA71Lwao93bt4BG8cPY6TN9JvbwGBcSh4r1p1Mq-3vW2vyY-0v1UfBuhfNZ597EG5XmISpJV4S37iJVlrJM4AL_0JoPMwRpx5XdFFlxyZoCyBvPkXngkVJO4dr-X4yxjLGaE" />
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Nomad Bamboo Set
              </h3>
              <span class="text-secondary font-bold text-lg">$28.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                PLASTIC FREE
              </div>
            </div>
          </div>
          <!-- Sản phẩm 6 -->
          <div class="group">
            <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-xl bg-surface-container">
              <img alt="Soy Wax Candle"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                data-alt="Hand-poured soy wax candle in a dark amber glass jar with a wooden wick sitting on an old book"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-wNBQvp43CSW_oMvhyv3TDEKYovhnheL7CvtNRx85OZTqRAHqKsDL1mvEsqkXr9l0nmUCsW5Xz1_YP6lkTjWWExzXvmvA-Aih-qYi_cHtvxBpDMBZZJ3AiE6jo8KtDEYw7JdGTu6pxSdgd6i7Z41nJdFtqFHSsX009OWQn1MBUvDnXcPRtbJWQBzkgImjTYgTQ0kF1rhgHz4gEjDzuRU3Q6UBulkwYRsjVOJGexdOI463YtuEkybNrHjFo-o8Ms2N1zbHBkAv4Nk" />
              <button
                class="absolute bottom-4 right-4 bg-primary text-on-primary p-3 rounded-full shadow-lg opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
                <span class="material-symbols-outlined">add_shopping_cart</span>
              </button>
            </div>
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors">Cedar &amp; Moss
                Candle</h3>
              <span class="text-secondary font-bold text-lg">$36.00</span>
            </div>
            <div class="flex items-center gap-2 mb-4">
              <div
                class="flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-tint/10 text-primary-container text-[10px] font-bold">
                <span class="material-symbols-outlined text-[12px]"
                  style="font-variation-settings: 'FILL' 1;">eco</span>
                VEGAN SOURCED
              </div>
            </div>
          </div>
        </div>
        <!-- Nút điều hướng chỉnh trang -->
        <div class="mt-20 flex justify-center items-center gap-4">
          <!-- Nút quay lại -->
          <button
            class="w-12 h-12 rounded-full flex items-center justify-center border border-outline-variant hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
          </button>
          <!-- Số trang -->
          <div class="flex gap-2">
            <!-- Trang hiện tại -->
            <button class="w-12 h-12 rounded-full bg-primary text-on-primary font-bold">1</button>
            <button
              class="w-12 h-12 rounded-full hover:bg-surface-container-high font-bold transition-colors">2</button>
            <button
              class="w-12 h-12 rounded-full hover:bg-surface-container-high font-bold transition-colors">3</button>
          </div>
          <!-- Nút chuyển trang tiếp theo -->
          <button
            class="w-12 h-12 rounded-full flex items-center justify-center border border-outline-variant hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined">arrow_forward</span>
          </button>
        </div>
      </section>
    </div>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>