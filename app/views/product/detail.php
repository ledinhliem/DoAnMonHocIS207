<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-12 md:py-20">
    <!-- Nội dung sản phẩm -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
      <!-- Ảnh sản phẩm (chia ra 8 column) -->
      <div class="lg:col-span-7 grid grid-cols-2 gap-4 md:gap-6">
        <div class="col-span-2 aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low">
          <img alt="Honed Stone Pitcher Large" class="w-full h-full object-cover"
            data-alt="Minimalist artisanal ceramic pitcher in a soft matte moss green finish sitting on a textured linen cloth with soft morning sunlight"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZvPnPOyFET2ax_Joigkqg5fABbBnKoCkiI6siUpjHvq-T3dl6SaHJge0OWvQxU7CvLYUJsurq2l_1_RCnK5ZF810qAFXi48RPEj1CUBslWWNnGuhX2eKtRrRd2AGS7dggeWe8Ggk_AG5Bg1_cdfMm0obBNKguJueXOPqJdtsbFro4TlEPv9Bi2gLL5IhfA8diK1AtGrDn2oOCRLdLL-vNY3krwrnWwAV71LRAnf5ygDnX3tQujqPFkcYkdDDB17KVijl2d9mC1V0" />
        </div>
        <div class="aspect-square overflow-hidden rounded-xl bg-surface-container-low">
          <img alt="Honed Stone Detail" class="w-full h-full object-cover"
            data-alt="Close up of a textured ceramic surface showing organic speckles and a soft matte finish in earth tones"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCjn8aGOch4Df_WNq_v22j8_LJsvoBFlVde5Zk1sZwTnsSdhfzouAl2oXeSEIecfjiWnI2j67W7wrNaZOEYA1UMOIQO4iq7v11WhL-gSnkL1XAbJyq6fTJIw8Je6cQlO2lbNphwNSD5ri3mmX9VUg4purUIsgGQ3s4jVdHBhYcXMdHuWmesHvw8WNvC8ITP7PlB2YEdI1wpj9guG1rv1-MjSVFBgqlGv7Eza6GViE9OFslkW9Ww4BBKZrygBd-SMBUmhLuEGVs9LPY" />
        </div>
        <div class="aspect-square overflow-hidden rounded-xl bg-surface-container-low">
          <img alt="Artisan Process" class="w-full h-full object-cover"
            data-alt="Hands of a ceramicist working with dark wet clay on a pottery wheel in a sun-drenched rustic studio"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCARY1sKrG4FeaO34q0qEcUOYHJBLZ7YPw9wtqQEpAJZ5F5_yw-v6ulMp9fZyrqbmseGLIjARlLqMrf14gIyquVXixrlkwv7aHgX5MY7PLNJ5843SKiLiJEFgu-LpVsZHl9uN5wqowsIduLsHoF4BLWDCD5phcGfAO4fHBeSeYZkcA4kCQfKJtQsHth-liPXqBTXzjHLI4FLnASPwpriXjIzFOT2r8TDNL_TUUzh3GNABGpaQJi0AjIwONTpYfmam54zdceRvH_Igc" />
        </div>
      </div>
      <!-- Chi  sản phẩm (chia ra 5 column) -->
      <!-- Thanh điều hướng -->
      <div class="lg:col-span-5 sticky top-32">
        <nav class="flex gap-2 text-xs font-label uppercase tracking-widest text-outline mb-6">
          <a class="hover:text-primary" href="<?= BASE_URL ?>?url=product">Tableware</a>
          <span>/</span>
          <a class="text-on-surface" href="<?= BASE_URL ?>?url=product">Pitchers</a>
        </nav>
        <!-- Tên + giá -->
        <h1 class="text-5xl md:text-6xl font-headline font-bold text-primary leading-tight mb-4">Honed Stone Pitcher
        </h1>
        <p class="text-2xl font-body font-medium text-on-surface-variant mb-8">$84.00</p>
        <div class="space-y-10">
          <!--Chọn màu -->
          <div>
            <span class="block text-sm font-label font-bold text-on-surface mb-4 uppercase tracking-wider">Color: <span
                class="text-outline font-normal">Moss</span></span>
            <div class="flex gap-3">
              <button
                class="w-10 h-10 rounded-full bg-[#384e21] ring-2 ring-primary ring-offset-2 border-2 border-surface"></button>
              <button class="w-10 h-10 rounded-full bg-[#e8bf98] border-2 border-surface"></button>
              <button class="w-10 h-10 rounded-full bg-[#7a5b3b] border-2 border-surface"></button>
            </div>
          </div>
          <!-- Chọn size -->
          <div>
            <span class="block text-sm font-label font-bold text-on-surface mb-4 uppercase tracking-wider">Size</span>
            <div class="flex gap-3">
              <button
                class="px-6 py-3 rounded-lg border border-outline-variant text-sm font-medium hover:border-primary transition-colors">S</button>
              <button
                class="px-6 py-3 rounded-lg border-2 border-primary bg-primary-fixed text-primary text-sm font-bold">M</button>
              <button
                class="px-6 py-3 rounded-lg border border-outline-variant text-sm font-medium hover:border-primary transition-colors">L</button>
            </div>
          </div>
          <!-- Nút thêm giỏ -->
          <div class="pt-4 flex flex-col gap-4">
            <button
              class="w-full bg-primary text-on-primary py-5 rounded-lg font-bold text-lg hover:bg-primary-container transition-all active:scale-95" onclick="window.location.href='<?= BASE_URL ?>?url=cart'">
              Add to Cart
            </button>
            <p class="text-center text-sm text-outline font-body italic">Each piece is uniquely handcrafted; slight
              variations may occur.</p>
          </div>
          <!-- Mô tả chi tiết -->
          <div class="border-t border-outline-variant/20 pt-8 space-y-6">
            <div>
              <h3 class="font-headline font-bold text-primary text-xl mb-3">The Material</h3>
              <p class="text-on-surface-variant leading-relaxed font-body">
                Sourced from the volcanic plains of Central Java, our honed stone is reclaimed from architectural
                salvage and hand-carved by master artisans. It features a naturally porous surface that keeps water cool
                and develops a rich patina over time.
              </p>
            </div>
            <div>
              <h3 class="font-headline font-bold text-primary text-xl mb-3">Artisan Origin</h3>
              <p class="text-on-surface-variant leading-relaxed font-body">
                Crafted in collaboration with the Dharma Collective, a small group of third-generation stonemasons
                dedicated to preserving traditional carving techniques while ensuring fair-trade wages and
                carbon-neutral workshop practices.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Mô tả ảnh hưởng -->
    <section class="mt-32 p-12 bg-surface-container rounded-xl">
      <div class="max-w-4xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-headline font-bold text-primary mb-4">The Zentro Impact</h2>
        <p class="text-on-surface-variant font-body text-lg">Your purchase directly contributes to restorative ecology
          projects worldwide. We measure what matters.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- 1 -->
        <div class="bg-surface-container-lowest p-8 rounded-xl flex flex-col items-center text-center">
          <div class="w-16 h-16 bg-primary-fixed-dim/20 rounded-full flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-primary text-3xl" data-icon="eco">eco</span>
          </div>
          <div class="text-4xl font-headline font-black text-primary mb-2">12.5kg</div>
          <div class="text-sm font-label uppercase tracking-widest text-outline">Plastic Saved</div>
          <p class="mt-4 text-sm text-on-surface-variant leading-relaxed">By choosing stone over synthetic alternatives,
            you've reduced micro-plastic runoff into our oceans.</p>
        </div>
        <!-- 2 -->
        <div class="bg-surface-container-lowest p-8 rounded-xl flex flex-col items-center text-center">
          <div class="w-16 h-16 bg-primary-fixed-dim/20 rounded-full flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-primary text-3xl" data-icon="forest">forest</span>
          </div>
          <div class="text-4xl font-headline font-black text-primary mb-2">3 Trees</div>
          <div class="text-sm font-label uppercase tracking-widest text-outline">Planted</div>
          <p class="mt-4 text-sm text-on-surface-variant leading-relaxed">For every stone product sold, we fund the
            reforestation of native teak forests in Indonesia.</p>
        </div>
        <!-- 3 -->
        <div class="bg-surface-container-lowest p-8 rounded-xl flex flex-col items-center text-center">
          <div class="w-16 h-16 bg-primary-fixed-dim/20 rounded-full flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-primary text-3xl" data-icon="water_drop">water_drop</span>
          </div>
          <div class="text-4xl font-headline font-black text-primary mb-2">100%</div>
          <div class="text-sm font-label uppercase tracking-widest text-outline">Water Recycled</div>
          <p class="mt-4 text-sm text-on-surface-variant leading-relaxed">Our stone honing process uses a closed-loop
            water filtration system, wasting zero drops.</p>
        </div>
      </div>
    </section>
    <!-- Chứng nhận -->
    <div class="mt-12 flex justify-center">
      <div class="bg-surface-tint/10 px-8 py-3 rounded-full flex items-center gap-3 border border-primary/10">
        <span class="material-symbols-outlined text-primary text-sm" data-icon="verified">verified</span>
        <span class="text-sm font-label font-bold text-primary tracking-tight">Certified Carbon Neutral Product
          2024</span>
      </div>
    </div>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>