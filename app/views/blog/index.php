<?php include __DIR__ . '/../layouts/header.php'; ?>

  <!-- Blog Content -->
  <main class="max-w-7xl mx-auto px-8 py-12">
    <!-- Header -->
    <header class="mb-16">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="max-w-2xl">
          <span class="text-primary font-bold tracking-widest text-xs uppercase mb-4 block">Our Journal</span>
          <h1 class="text-5xl md:text-7xl font-extrabold text-primary leading-tight tracking-tight">Living in <span
              class="text-primary/40 italic">Balance.</span></h1>
        </div>
        <p class="text-on-surface-variant max-w-xs font-body text-lg leading-relaxed">
          Thoughtful perspectives on sustainability, craftsmanship, and the art of slowing down.
        </p>
      </div>
    </header>

    <!-- Lọc theo chủ đề -->
    <section class="mb-12 overflow-x-auto">
      <div class="flex space-x-4 pb-4">
        <button
          class="px-6 py-2 rounded-full bg-primary text-on-primary font-medium text-sm transition-all shadow-sm">All
          Stories</button>
        <button
          class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface-variant font-medium text-sm hover:bg-surface-variant transition-all">Sustainable
          Living</button>
        <button
          class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface-variant font-medium text-sm hover:bg-surface-variant transition-all">Eco-Tips</button>
        <button
          class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface-variant font-medium text-sm hover:bg-surface-variant transition-all">Brand
          Stories</button>
        <button
          class="px-6 py-2 rounded-full bg-surface-container-high text-on-surface-variant font-medium text-sm hover:bg-surface-variant transition-all">Materials</button>
      </div>
    </section>
    <!-- Bài viết nổi bật -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-24 items-center">
      <div class="lg:col-span-7 relative group">
        <div class="overflow-hidden rounded-xl bg-surface-container">
          <!-- Ảnh minh họa -->
          <img class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-700"
            data-alt="Modern minimalist living room with large windows overlooking a lush green forest, sunbeams filtering through leaves onto recycled wood furniture."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCd5CG8_s0WOt9MYX25AOsPh5108ADjUa9qnir3yJUa-AFFH3cKSoC_J3oqsrVp-FAtzT5muFTKeGhGAckOngr-PoFSzO12E0iVLeWURRZXTzUVgn42RAVcGX_OVxnATuyBC-wfHYgWaKZAB53210eQ7fS2eVcZ_hOBDVl4716Qbj-95MWQtVxwzXxtbzW3xuCSdcRvLs8Uoxt2Q7BE1muxaQvAro1xtBTArIy9x8zvT8wacStqwqYjVZsYVFciuIYgEfHqg5Hx0LM" />
        </div>
        <div
          class="absolute -bottom-6 -right-6 hidden md:block bg-secondary-container p-8 rounded-xl max-w-xs shadow-xl">
          <p class="text-on-secondary-container font-headline font-bold text-xl leading-snug">
            "Design is not just what it looks like, but how it treats the planet."
          </p>
        </div>
      </div>
      <div class="lg:col-span-5 flex flex-col justify-center space-y-6">
        <div class="flex items-center space-x-3">
          <div class="h-[1px] w-8 bg-outline"></div>
          <span class="text-xs font-bold uppercase tracking-widest text-primary">Featured Story</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-on-surface leading-tight">The Architecture of Conscious Living.
        </h2>
        <p class="text-on-surface-variant text-lg leading-relaxed">
          How we chose the materials for our latest collection by tracing every fiber back to its organic origin. A deep
          dive into regenerative design and circular manufacturing.
        </p>
        <div class="pt-4">
          <a href="<?= BASE_URL ?>?url=blog/detail" class="flex items-center space-x-3 text-primary font-bold group">
            <span class="border-b-2 border-primary pb-1 group-hover:pr-4 transition-all">Read Full Article</span>
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
          </a>
        </div>
      </div>
    </section>
    <!-- Article Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16 mb-24">
      <!-- 1 -->
      <article class="flex flex-col space-y-5 cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?url=blog/detail&id=1'">
        <div class="overflow-hidden rounded-xl bg-surface-container-low aspect-square">
          <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
            data-alt="Overhead view of a lush vegetable garden with vibrant green leaves and dark soil, soft natural daylight highlighting textures."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDN-xx0Dtqthg44tzDbX6xLpmK0lhLTFTeVVs1fNOT6KV6C7vSyQgMJrJbv4GTdqO-C1ePHpsfeI3l0raHge0_kv0lg8WEwM-cauTXZ4Mje646GpYR765_6tdjcrfbbheOEy4AdqH1Ks6w5Sil_lPEHgkyK-2dKXs_-RaX_Op5_vw7NdTt21UiAx3a0jzC4xNavMdf7Q1-biohtTnAhWotdIN2BY0dwaBdCvIOQe6s7DnJypqdMHRCL3MQM1f-pfw_Xq8F_8NiD7aY" />
        </div>
        <div class="space-y-3">
          <div
            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">
            <span>Eco-Tips</span>
            <span>5 Min Read</span>
          </div>
          <h3 class="text-2xl font-bold text-on-surface leading-snug">10 Ways to Reduce Plastic in the Kitchen.</h3>
          <p class="text-on-surface-variant line-clamp-2">Practical steps to transition your home into a zero-waste
            sanctuary without sacrificing style.</p>
        </div>
      </article>
      <!-- 2 -->
      <article class="flex flex-col space-y-5 cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?url=blog/detail&id=2'">
        <div class="overflow-hidden rounded-xl bg-surface-container-low aspect-square">
          <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
            data-alt="Close-up of high-quality organic linen fabric in a warm beige tone, showcasing the natural weave and tactile texture."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDrtVi3xJ0YeNKFY1fnyDExeu2Ho37Lv8CDhVXNAb2yaUZPwl9lazML2tc3Ch9CsQWxqVRchDR2CzlXtpU2xkpaC9C0of8CmI9E-b9jdywCOe2O-m7ktL4oa8hxDXEJb4ssdITXMJak6AqC5buhE7G8idWYlan0SHvq3BDLwvm-P9XrO2OU_uFBcqXUoFqASylXzUkSN-blB3iv-5wHHkuNSc6aUpYOXvzai6DLOBdW4MOEKzVuQXNfh60irtbjQn4nu-domxG3mws" />
        </div>
        <div class="space-y-3">
          <div
            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">
            <span>Materials</span>
            <span>8 Min Read</span>
          </div>
          <h3 class="text-2xl font-bold text-on-surface leading-snug">Why Linen is the Future of Textiles.</h3>
          <p class="text-on-surface-variant line-clamp-2">Understanding the low environmental impact and timeless
            durability of one of history's oldest fabrics.</p>
        </div>
      </article>
      <!-- 3 -->
      <article class="flex flex-col space-y-5 cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?url=blog/detail&id=3'">
        <div class="overflow-hidden rounded-xl bg-surface-container-low aspect-square">
          <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
            data-alt="Artisanal ceramic cups on a rustic stone table with soft morning shadows and a small green sprig in the background."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC52oqmmu0W-YvMcPTY8Vs76WpFOIQvv1Wyy0eRQIrztB_l6xmbGRq1_aG9fkXFl4X_6GXxnaNeklu9tMrS1-irIEfj_JS2tCnjYyi19ufXwrYmPpndT-J5t8vWBTR7allmcBWm-2o73ZYwxYVZiiRXt12Wugl2lz_0Mt5Q3WdPS0sLOFw9sx7bBZt0mIzUHNt_uqwqkbTaUfE956HIpl8ge1Pba0ijJI7x2bCwLK8KTtr9HuXmXTR9RGMB6qSQ34bJ-eHDRHBRlDY" />
        </div>
        <div class="space-y-3">
          <div
            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">
            <span>Brand Stories</span>
            <span>12 Min Read</span>
          </div>
          <h3 class="text-2xl font-bold text-on-surface leading-snug">Meet the Makers: Heritage Pottery.</h3>
          <p class="text-on-surface-variant line-clamp-2">A conversation with the third-generation artisans who craft
            our Zentro signature ceramics.</p>
        </div>
      </article>
    </section>
    <!-- Đăng ký nhận tin -->
    <section class="bg-surface-container rounded-3xl p-12 md:p-20 relative overflow-hidden">
      <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
      <div class="max-w-xl relative z-10">
        <h2 class="text-4xl font-bold text-primary mb-6">Slow News. <br />Sent Weekly.</h2>
        <p class="text-on-surface-variant mb-8 text-lg">Join 15,000+ conscious readers receiving our curated thoughts on
          ethical living and exclusive early access to new collections.</p>
        <form class="flex flex-col sm:flex-row gap-4">
          <input
            class="flex-grow bg-surface-container-lowest border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-on-surface-variant/40"
            placeholder="Your email address" type="email" />
          <button
            class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold hover:shadow-lg transition-shadow">Subscribe</button>
        </form>
        <p class="text-[10px] text-on-surface-variant/60 mt-4 uppercase tracking-widest">We value your privacy.
          Unsubscribe anytime.</p>
      </div>
    </section>
    <!-- Second Row of Articles -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-24">
      <!-- Horizontal Card Pattern -->
      <div class="flex flex-col md:flex-row gap-6 items-center cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?url=blog/detail&id=4'">
        <div class="w-full md:w-1/2 aspect-video overflow-hidden rounded-xl">
          <img class="w-full h-full object-cover"
            data-alt="Sunlight hitting a glass bottle filled with clear water next to a green houseplant, creating beautiful caustic reflections."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIaTibx3nZDh0JZOWDI51T8xumHwTntMO7JffTqkkdcgg9JGD1VY_oWiIFESqRM9wA9Y9w8r2RmT5U1Q3bLkVWG_lX_UOF5hdlVikw40od1vZ-bUplQ8OkUmSkRauKQB672an7kEmGbc9iZsRr-Wsmrz2t3D1a4bTiyvSlq0PwPbKBPGD0ezwWf9JgfGQFuoJBZBkjmdWfrmGuGFPGaZScjwGZHsvK5gxj94RdEYP-hqkVPCAU3j_Fo46_rCRhAb-wsEiGVyWWDFA" />
        </div>
        <div class="w-full md:w-1/2 space-y-2">
          <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Sustainability</span>
          <h4 class="text-xl font-bold text-on-surface">The Truth About Water Scarcity.</h4>
          <p class="text-on-surface-variant text-sm line-clamp-2">How conscious consumption starts with the most vital
            resource on our planet.</p>
        </div>
      </div>
      <div class="flex flex-col md:flex-row gap-6 items-center cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?url=blog/detail&id=5'">
        <div class="w-full md:w-1/2 aspect-video overflow-hidden rounded-xl">
          <img class="w-full h-full object-cover"
            data-alt="Hand holding a small green sprout with soil, symbolizing growth and renewal in a minimalist composition."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDivdndEipZ7z33KSPMtpukPpgHyjlZ5svMFx4sFiwuUsd_aoVrMf51TH2UrraImqjy1s1YuZ9R9nQyk4ZRFYzpwNtrSCd62c59UAy_JiYyhGUI3XyRQXSkTCMCctdxIi2K4tR9MrvL8ZvVTXH3fGXv_sIKRlMftNN7wuFanryJGVj5tNqmsz6Ym3oyQMJGksKX2dpHUC8gWGoYPOGCM4dF66M0SPB9EqurPzArB4_xUWwOcgyMNjb_qsfbaASpK5zDk3rCpmeF00w" />
        </div>
        <div class="w-full md:w-1/2 space-y-2">
          <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Brand Stories</span>
          <h4 class="text-xl font-bold text-on-surface">One Tree Per Order: Our Impact.</h4>
          <p class="text-on-surface-variant text-sm line-clamp-2">A look at the reforestation projects we've supported
            in 2024 through your purchases.</p>
        </div>
      </div>
    </section>
  </main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>