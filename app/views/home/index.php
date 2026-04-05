<?php include __DIR__ . '/../layouts/header.php'; ?>

<main>
    <!-- Banner -->
    <section class="relative min-h-[870px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover" data-alt="Minimalist organic living space with sustainable wood furniture, linen textiles, and large potted plants in soft morning sunlight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAUGoBKKWXsaoAkJ3lJZuNLK3ZMyTRa084ZYj16vcMMpn8c-OfY835-A09tmcHOeZchkjlcRTtM_cCvrxx9IbtMV2geyWLT8YG-yNWTsJ2O7fmpkYRGwHZ1dpAmviwkYL3COlYltcMUhhkw0-3F3PRjeCx80zlQcN_GfI2D1pBs_RUdKewB_-uniAvwCqxzxGle16JkvIerttov9llfqkYn0TBuIxC5Zu1dup7cSgL520ceINOynU9PDJsgNNyd0HwykX5h4Y9HbmE" />
            <div class="absolute inset-0 bg-black/10"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
            <div class="max-w-2xl bg-surface/90 backdrop-blur-md p-10 md:p-16 rounded-xl border-l-8 border-primary shadow-xl">
                <span class="inline-block px-4 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-bold uppercase tracking-widest mb-6">Sustainable Excellence</span>
                <h1 class="font-headline text-5xl md:text-7xl font-extrabold text-on-background leading-[1.1] mb-6">Live with <span class="text-primary italic">Intent</span>.</h1>
                <p class="text-lg md:text-xl text-on-surface-variant mb-10 leading-relaxed max-w-lg">Curated essentials for a conscious home. Every product in our marketplace is vetted for ethical production and environmental impact.</p>
                <div class="flex flex-wrap gap-4">
                    <button class="px-8 py-4 bg-primary text-on-primary rounded-lg font-bold text-lg hover:hero-gradient transition-all duration-300 shadow-lg shadow-primary/20" onclick="window.location.href='<?= BASE_URL ?>?url=product'">Explore Shop</button>
                    <button class="px-8 py-4 bg-secondary-container text-on-secondary-container rounded-lg font-bold text-lg hover:opacity-90 transition-all duration-300">Our Mission</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Thanh chứng nhận -->
    <section class="bg-surface-container py-12">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-wrap justify-center md:justify-between items-center gap-8 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-primary">eco</span>
                    <span class="font-headline font-bold text-sm tracking-widest uppercase">Certified B Corp</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-primary">recycling</span>
                    <span class="font-headline font-bold text-sm tracking-widest uppercase">100% Recyclable</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-primary">vaping_rooms</span>
                    <span class="font-headline font-bold text-sm tracking-widest uppercase">Carbon Neutral</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-primary">verified_user</span>
                    <span class="font-headline font-bold text-sm tracking-widest uppercase">Fair Trade</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Giới thiệu sản phẩm + Thành tích -->
    <section class="py-24 max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <h2 class="font-headline text-4xl md:text-5xl font-extrabold text-on-background mb-4">Conscious Collections</h2>
                <p class="text-on-surface-variant text-lg">Curated categories designed to integrate sustainability seamlessly into your daily rituals.</p>
            </div>
            <a class="text-primary font-bold flex items-center gap-2 group border-b border-transparent hover:border-primary transition-all" href="<?= BASE_URL ?>?url=product">
                View All Categories <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 h-auto md:h-[800px]">
            <div class="md:col-span-8 relative group overflow-hidden rounded-xl bg-surface-container-low shadow-sm transition-transform duration-500 hover:-translate-y-2">
                <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Artisanal ceramic tableware and organic linen napkins on a reclaimed oak dining table with soft natural side lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNF-OikKQVeogdcyuOCyQHn16wMDiYJywnwaWRyxYI8NfCO8YZ-MyOcOil7rCpS6_zb9iXVNzMi7MWUXNrOGC-Bi_29AlNXBcWbk5HDb8LHcUXHfDWuii-p2ZWyVRMWjEVWR6cAkYjzL6heFodziA1wr2MuDXpMqNPMY9xWiJZOlrs4QGmiMN2fbVMJuIjgOcMb7emAkq8sOONxhRV2Mm1uchVWEYRRxkF42FFXJJCFcEMg8cINl2EofgHA8xZg3FAOCCSJjzXOCY" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-10">
                    <h3 class="font-headline text-3xl font-bold text-white mb-2">For the Home</h3>
                    <p class="text-white/80 mb-6 max-w-sm">Elevate your living space with timeless pieces built to last generations.</p>
                    <button class="px-6 py-3 bg-surface text-primary rounded-lg font-bold hover:bg-primary-fixed transition-colors" onclick="window.location.href='<?= BASE_URL ?>?url=product'">Shop Decor</button>
                </div>
            </div>
            <div class="md:col-span-4 relative group overflow-hidden rounded-xl bg-surface-container-low shadow-sm transition-transform duration-500 hover:-translate-y-2">
                <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Selection of organic skincare products in amber glass bottles on a smooth stone surface with water droplets and green leaves" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFo5ZWa_-O47TwdP0Jxbc_F73d4khw8Dzzjywjo21tP65Jq-CYbptNr4nlYZ5E9XoUUv4A0PcQ5Wm4Kni2uQMZYj8o_9LiKir4jT436qlC1AnMjPr90G-XrDm1eVHprHfUfumUf7QfbyKs6gcbOZWrokCJ3Nk80iDm4ulcKWkbFPHNkby_QAIe5S7lnq0sFdqSrGomwLAe4XK3zdE1YUj2-ILzbprocLV6Lrkr6j-pUSsYMzKEDox1uHQBEY9HMWNbEyjI6hh-Hp8" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8">
                    <h3 class="font-headline text-2xl font-bold text-white mb-2">Sustainable Skincare</h3>
                    <button class="text-white font-bold flex items-center gap-2 group" onclick="window.location.href='<?= BASE_URL ?>?url=product'">
                        Explore Beauty <span class="material-symbols-outlined text-sm">north_east</span>
                    </button>
                </div>
            </div>
            <div class="md:col-span-4 relative group overflow-hidden rounded-xl bg-surface-container-low shadow-sm transition-transform duration-500 hover:-translate-y-2">
                <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="High-quality organic cotton t-shirts in earth tones neatly folded on a wooden shelf with a single green branch" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtXqnnZIgWLJgrEmGEKW2r7SSYCXluRwPQ3FaDj-WhgzJOxG-oUMb8ycKFcdZPWfwm5yOFjp71BOQnL_xOeUsxuOPdSenBICTQ28QPmXmu_nRfuynj9hU34bbVufnvgRPDEDjxLSQGN79_uk-AEgkKI8hSsJZyqL0bQNVpLen57DUakSYrgzwDE8UCQAsVLogBS95r8tkO-p_Bn24CD2yRmT1PIIzVRSb6e2zl0480O38lP-x_4-GqtF9SUWnM1DNEkXKFqi2xqRs" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8">
                    <h3 class="font-headline text-2xl font-bold text-white mb-2">Ethical Fashion</h3>
                    <button class="text-white font-bold flex items-center gap-2 group" onclick="window.location.href='<?= BASE_URL ?>?url=product'">
                        Shop Apparel <span class="material-symbols-outlined text-sm">north_east</span>
                    </button>
                </div>
            </div>
            <div class="md:col-span-8 bg-surface-container-high p-12 rounded-xl flex flex-col justify-center border border-outline-variant/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">compost</span>
                    </div>
                    <span class="font-headline font-bold text-primary uppercase tracking-widest text-sm">Our Impact Last Year</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <div class="font-headline text-4xl font-extrabold text-primary mb-1">12k+</div>
                        <div class="text-on-surface-variant text-sm font-medium">Trees Planted</div>
                    </div>
                    <div>
                        <div class="font-headline text-4xl font-extrabold text-primary mb-1">45t</div>
                        <div class="text-on-surface-variant text-sm font-medium">Plastic Recovered</div>
                    </div>
                    <div>
                        <div class="font-headline text-4xl font-extrabold text-primary mb-1">100%</div>
                        <div class="text-on-surface-variant text-sm font-medium">Fair Wages</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sản phẩm nổi bật -->
    <section class="bg-surface-container-low py-24">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-tint/10 text-primary font-bold text-xs uppercase tracking-tighter mb-6">
                        <span class="material-symbols-outlined text-xs">auto_awesome</span> Featured Product
                    </div>
                    <h2 class="font-headline text-4xl md:text-5xl font-extrabold text-on-background mb-6">The Artisan Stoneware Set</h2>
                    <p class="text-on-surface-variant text-lg mb-8 leading-relaxed">
                        Handcrafted in small batches using local clay and natural glazes. Each piece is unique, reflecting the hands that made it and the earth it came from.
                    </p>
                    <div class="flex flex-col gap-4 mb-10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-medium">Lead-free, non-toxic glazes</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-medium">Sourced from regenerative clay mines</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-medium">Shipped in plastic-free packaging</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-8">
                        <button class="px-8 py-4 bg-primary text-on-primary rounded-lg font-bold shadow-lg hover:opacity-90 transition-opacity" onclick="window.location.href='<?= BASE_URL ?>?url=product/detail'">Pre-order Now</button>
                        <div class="text-2xl font-headline font-bold text-primary">$185.00</div>
                    </div>
                </div>
                <div class="order-1 md:order-2 relative">
                    <div class="absolute -top-6 -right-6 w-32 h-32 bg-secondary-fixed rounded-full z-0 opacity-50 blur-2xl"></div>
                    <img class="relative z-10 rounded-xl shadow-2xl w-full object-cover aspect-square" data-alt="Collection of handmade grey and white stoneware plates and bowls stacked artistically on a textured light background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAim6_rmHfmEvCbGZ0ZZb6CRq1REphbM1hUA7QZ1bS5Kx1oT9bBlpGE_cqF2dTM1bS8np2cnwLmbhUvASunqh1jXSMF2G_-dW9M0brl8p_-Q_kFiTFHlxTY_dUrSBhglwmPMSGkxTepxmDW6fcBMeFYpaQ1A8YaVz7DPWlRLS9skrvz9n8EwIbNndHoXP48j62Ag5grNRH9g3-y8WwLoZYd3v4TTDzv_3P0zYPhtFj2e86R8nPK8j9FjKgQBcVaQei7hCtAPOI10_s" />
                </div>
            </div>
        </div>
    </section>

    <!-- Liên hệ, CTA -->
    <section class="py-24 px-8">
        <div class="max-w-5xl mx-auto bg-primary text-on-primary rounded-2xl p-12 md:p-20 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary-container rounded-full -translate-y-1/2 translate-x-1/2 opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary-container rounded-full translate-y-1/2 -translate-x-1/2 opacity-20"></div>
            <h2 class="font-headline text-4xl md:text-5xl font-extrabold mb-6 relative z-10">Join the Circle.</h2>
            <p class="text-on-primary/80 text-lg mb-10 max-w-xl mx-auto relative z-10">Receive sustainable living tips, ethical shop updates, and 10% off your first order.</p>
            <form class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto relative z-10" method="post" action="#">
                <input class="flex-grow bg-white/10 border-transparent focus:border-white/40 focus:ring-0 rounded-lg px-6 py-4 text-white placeholder:text-white/50 transition-all" placeholder="Email Address" type="email" name="email" />
                <button class="bg-surface text-primary font-bold px-8 py-4 rounded-lg hover:bg-surface-bright transition-colors" type="submit">Subscribe</button>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>