<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $products = $products ?? []; ?>
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
    <?= $keyword ?? 'Search' ?>
</h1>
          <p class="text-lg text-on-surface-variant font-medium">Showing <?= count($products ?? []) ?> results</p>
        </div>
        <!-- Lọc và sắp xếp -->
        <div class="flex items-center space-x-3">
          <button class="filter-btn flex items-center space-x-2 bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined text-lg">tune</span>
            <span>Filter</span>
          </button>
          <select class="sort-select bg-surface-container text-primary font-semibold px-5 py-3 rounded-xl border-none focus:ring-primary/20 cursor-pointer">
            <option>Relevance</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
            <option>Newest</option>
            <option>Rating</option>
          </select>
        </div>
      </div>
    </section>
    <!-- Danh sách sản phẩm -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
     <?php if (!empty($products)): ?>
    
    <?php foreach ($products ?? [] as $p): ?>

    <div class="group flex flex-col space-y-4 cursor-pointer"
         onclick="window.location.href='<?= BASE_URL ?>?url=product/detail&id=<?= $p['id'] ?>'">

        <div class="relative aspect-[4/5] overflow-hidden rounded-xl bg-surface-container-low">
            <img class="w-full h-full object-cover"
                 src="https://via.placeholder.com/300"
                 alt="<?= $p['name'] ?>" />

            <button onclick="event.stopPropagation(); addToCart(<?= $p['id'] ?>)"
                    class="absolute bottom-4 right-4 bg-white/90 p-3 rounded-full">
                <span class="material-symbols-outlined">add_shopping_cart</span>
            </button>
        </div>

        <div>
            <h3 class="font-headline font-bold text-xl">
                <?= $p['name'] ?>
            </h3>
        </div>

    </div>

    <?php endforeach; ?>

<?php else: ?>
    <p class="text-center text-gray-500 mt-10">Không tìm thấy sản phẩm</p>
<?php endif; ?>
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
    <?php if (empty($products)): ?>
    <p class="text-center text-gray-500 mt-10">Không tìm thấy sản phẩm</p>
<?php endif; ?>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>