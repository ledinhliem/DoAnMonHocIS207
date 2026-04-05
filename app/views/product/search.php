<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <!-- Search Header -->
    <section class="mb-16">
      <!-- Thanh điều hướng -->
      <nav class="flex items-center space-x-2 text-sm text-on-surface-variant mb-6">
        <a href="<?= BASE_URL ?>" class="hover:text-primary">Home</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="font-medium text-primary">Search Results</span>
      </nav>
      <!-- Tiêu đề -->
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
          <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight mb-4 leading-tight">
    <?= $_GET['keyword'] ?? 'Search' ?>
</h1>
          <p class="text-lg text-on-surface-variant font-medium">Showing 12 results for your sustainable search</p>
        </div>
        <!-- Lọc và sắp xếp -->
        <div class="flex items-center space-x-3">
          <button
            class="flex items-center space-x-2 bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined text-lg">tune</span>
            <span>Filter</span>
          </button>
          <button
            class="flex items-center space-x-2 bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl hover:bg-surface-container-high transition-colors">
            <span>Sort by: Relevance</span>
            <span class="material-symbols-outlined text-lg">expand_more</span>
          </button>
        </div>
      </div>
    </section>
    <!-- Danh sách sản phẩm -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
      <!-- Product Card 1 -->
      <div class="group flex flex-col space-y-4">
        <div
          class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low transition-all group-hover:shadow-xl group-hover:shadow-primary/5">
          <!-- Ảnh sản phẩm -->
          <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            data-alt="Premium sustainable bamboo toothbrush set on a smooth river stone with soft natural morning light"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRQQH7izrEYeS5FJb-zfYoYx8Bt1q5surQMKKvljctGfr67a9gfDL8L1De7a4R8-uYHSMv-Ve3mIutlqaJy9uvGLDyEuE4-k3x3PFJa6gchqrtfwA4cTKuJM3keMzETiv57EMxHmVKa7UJ4xuTyWvj0eSdpAI9ITVlon5QHxHjqVr6Y5Chd8iyd7TudEFQ9zmquALqId00EERBQB7gHe6X8nDXlQmKx1nqYTeTUJnRPu1lYipGTzgeJDZXC6r2v-OaSr63n1VH3mA" />
          <div
            class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full text-xs font-bold tracking-wider">
            ECO-CHOICE</div>
          <button
            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur text-primary p-3 rounded-full opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
            <span class="material-symbols-outlined">add_shopping_cart</span>
          </button>
        </div>
        <div class="flex flex-col space-y-1">
          <h3 class="font-headline font-bold text-xl tracking-tight text-on-surface">Artisan Bamboo Brush</h3>
          <p class="text-on-surface-variant text-sm font-medium">Biodegradable • Family Pack</p>
          <span class="text-primary font-bold mt-2 text-lg">$24.00</span>
        </div>
      </div>
      <!-- 2 -->
      <div class="group flex flex-col space-y-4">
        <div
          class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low transition-all group-hover:shadow-xl group-hover:shadow-primary/5">
          <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            data-alt="Minimalist bamboo fiber bath towels stacked neatly in a sunlit bathroom with wooden accents"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAtISvNAM08Rulpf5czFCnb9arbo4lfgmsmxZPp4_A2pDZ7cZsXgMhc0Doh9ZwR-5EZMFckQ_1RbHNsn7ZGee1ICyYe_S_qZbC_FWBYhPomaAGWaHqEWPKpMnk_xzPHDbYVlkA5NZH-Cr5D9QZ0b7Et0NBEbGjZ595oZ0zPdUYMswetWhx2KTrY4tJfVc2ajmo1XkNej-4nKmRcep4_x0w9yvEHsQqRvsnqclcELddwsdNCNy4b_wWLCfoKTWF1KJdklKz1seivPk0" />
          <button
            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur text-primary p-3 rounded-full opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
            <span class="material-symbols-outlined">add_shopping_cart</span>
          </button>
        </div>
        <div class="flex flex-col space-y-1">
          <h3 class="font-headline font-bold text-xl tracking-tight text-on-surface">Luxury Bamboo Towel</h3>
          <p class="text-on-surface-variant text-sm font-medium">Antibacterial • Ultra Soft</p>
          <span class="text-primary font-bold mt-2 text-lg">$42.00</span>
        </div>
      </div>
      <!-- 3 -->
      <div class="group flex flex-col space-y-4">
        <div
          class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low transition-all group-hover:shadow-xl group-hover:shadow-primary/5">
          <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            data-alt="Eco-friendly bamboo cutlery set wrapped in organic linen on a rustic wooden table"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD00lEGbKkvFWFer_3vIpNShzJr64kQb3w0DNuOmJM0Ja7TLisGkl_zW1EvnbfLQLy3wHMq4qca-Ze0f3d0fiXUgexs5LAlX-hFcldEqEyw51b3WP4WRBsZdw_1htHQBDS8-QkSpmUzg6BI3jWOcVIhS9JjoafjEy0Bk7vE-xKiJ6pWEUGC9kzvoXGff_I7oGcqE1Rb6ZZ7HHUhfzgllbFlykYIWQJWv0O-fL3Ph6ECdgRAK8tLlTtUHU618mgnt5abPVG5Fes_dmU" />
          <div
            class="absolute top-4 left-4 bg-secondary text-on-secondary px-3 py-1 rounded-full text-xs font-bold tracking-wider">
            BESTSELLER</div>
          <button
            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur text-primary p-3 rounded-full opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
            <span class="material-symbols-outlined">add_shopping_cart</span>
          </button>
        </div>
        <div class="flex flex-col space-y-1">
          <h3 class="font-headline font-bold text-xl tracking-tight text-on-surface">Travel Cultery Set</h3>
          <p class="text-on-surface-variant text-sm font-medium">Hand-finished • Zero Waste</p>
          <span class="text-primary font-bold mt-2 text-lg">$18.00</span>
        </div>
      </div>
      <!-- 4 -->
      <div class="group flex flex-col space-y-4">
        <div
          class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low transition-all group-hover:shadow-xl group-hover:shadow-primary/5">
          <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            data-alt="Sleek bamboo laptop stand in a modern workspace with lush green plants in the background"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmEsyytB9nTu97LH3RC7coDZiaLRqhbRR89AT7TZlv4NIgdaeI-KvDybVewQ4lhkKwEsz8TNO3tPJWEWSqmdAKyrluuYnYcpfqIPXWdDvuKmbhGHwcLcoVoBHUCwI98tU1gJIH_1Vlid0eQmtZrhnBr7cNfWwftsZV8YAA5LsX51bbJoVFKL1BpZJ69-4T3H3kCNYSDpQbUo_8TTCxCUnEQLx3DNu0kugT_R0IKIHpeViJQct6pi3eINNtY-n_A9u9rYbjzljgHXQ" />
          <button
            class="absolute bottom-4 right-4 bg-white/90 backdrop-blur text-primary p-3 rounded-full opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">
            <span class="material-symbols-outlined">add_shopping_cart</span>
          </button>
        </div>
        <div class="flex flex-col space-y-1">
          <h3 class="font-headline font-bold text-xl tracking-tight text-on-surface">Ergonomic Laptop Stand</h3>
          <p class="text-on-surface-variant text-sm font-medium">Sustainable Oak &amp; Bamboo</p>
          <span class="text-primary font-bold mt-2 text-lg">$65.00</span>
        </div>
      </div>
    </section>
    <!-- Tìm kiếm liên quan -->
    <section class="mt-24 pt-16 border-t border-outline-variant/10">
      <h2 class="font-headline text-2xl font-bold text-primary mb-8 tracking-tight">Expand Your Sustainable Journey</h2>
      <div class="flex flex-wrap gap-4">
        <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
          href="<?= BASE_URL ?>?url=product">Organic Cotton Linens</a>
        <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
          href="<?= BASE_URL ?>?url=product">Solar Powered Decor</a>
        <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
          href="<?= BASE_URL ?>?url=product">Recycled Glassware</a>
        <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
          href="<?= BASE_URL ?>?url=product">Hemp Fiber Clothing</a>
        <a class="px-6 py-3 bg-surface-container-low hover:bg-surface-container-high rounded-full border border-outline-variant/30 text-primary font-medium transition-all"
          href="<?= BASE_URL ?>?url=product">Biodegradable Soap</a>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>