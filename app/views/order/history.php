<?php $title = 'Purchase History'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <header class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="max-w-2xl">
            <h1 class="text-5xl md:text-7xl font-headline font-extrabold text-on-surface tracking-tighter mb-4">
                Your conscious journey.
            </h1>
            <p class="text-on-surface-variant max-w-lg leading-relaxed">
                Review your past choices and their positive impact on the planet. Each order is a step towards a zero-waste lifestyle.
            </p>
        </div>

        <div class="bg-primary-container p-8 rounded-xl shadow-sm text-on-primary-container flex flex-col justify-between min-w-[320px] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
                <span class="material-symbols-outlined text-9xl">eco</span>
            </div>
            <div>
                <span class="bg-surface-tint/20 px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase mb-4 inline-block">
                    Impact Summary
                </span>
                <h2 class="text-3xl font-headline font-bold mb-2">You've saved 4kg of plastic so far!</h2>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <span class="material-symbols-outlined">trending_up</span>
                <span class="text-sm font-medium">Top 15% of community savers</span>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <aside class="lg:col-span-3 space-y-8">
            <div class="bg-surface-container-low p-6 rounded-xl space-y-6">
                <h3 class="font-headline font-bold text-lg">Filter Orders</h3>
                <div class="space-y-4">
                    <button class="w-full flex justify-between items-center group">
                        <span class="text-primary font-bold">All Purchases</span>
                        <span class="text-xs bg-primary text-on-primary px-2 py-0.5 rounded-full">12</span>
                    </button>
                    <button class="w-full flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors">
                        <span>In-Transit</span>
                        <span class="text-xs bg-surface-variant px-2 py-0.5 rounded-full">1</span>
                    </button>
                    <button class="w-full flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors">
                        <span>Delivered</span>
                        <span class="text-xs bg-surface-variant px-2 py-0.5 rounded-full">11</span>
                    </button>
                </div>
            </div>

            <div class="bg-secondary-container/30 p-6 rounded-xl">
                <h3 class="font-headline font-bold text-secondary text-lg mb-2">Sustainable Points</h3>
                <p class="text-4xl font-headline font-extrabold text-secondary">840</p>
                <p class="text-xs text-on-secondary-container mt-2">160 more to your next carbon-offset reward.</p>
            </div>
        </aside>

        <section class="lg:col-span-9 space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row gap-6 items-start md:items-center transition-all hover:bg-surface-container-low border border-outline-variant/5">
                <div class="w-full md:w-24 h-24 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                    <img class="w-full h-full object-cover"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdspvspYmf0Ap8mfiqUgR61Sxjjnx8egxnscvIFEHNaBkdCvCcyp1Z8ws4Mt2QEIVJDfrNtp1YsL2EgLy_DrwK6Ko40RjhwIM95OY6PYISM0RXLKIqFm1N_kyivkm7IGyCzUuDIXIfXuSFuu8BsWsQE1-inP3X7zOp3tcI1VZHAy_fvpdwxAdSyZtZ0YTtR1lPKzvhrVQw0hwSG2QE4mHforUkWgTNnti22Ipeg4ybm7bzm37Rn2fRCYGryt4TuN-pX5urLcW-icM"
                         alt="Order item">
                </div>

                <div class="flex-grow">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <span class="font-headline font-bold text-lg">Order #ZN-9042</span>
                        <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">local_shipping</span>
                            In-Transit
                        </span>
                    </div>
                    <p class="text-sm text-on-surface-variant mb-2">Placed on October 24, 2024</p>
                    <p class="text-xs font-medium text-tertiary">Bamboo Home Starter Kit, Refillable Dish Soap</p>
                </div>

                <div class="text-left md:text-right w-full md:w-auto">
                    <p class="text-2xl font-headline font-bold text-on-surface mb-4">$64.50</p>
                    <div class="flex md:flex-col gap-2">
                        <a href="<?= BASE_URL ?>?url=order/tracking"
                           class="flex-1 bg-surface-container-high text-on-surface px-6 py-2 rounded-lg font-bold text-sm hover:bg-surface-variant transition-colors text-center block">
                            Track Order
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row gap-6 items-start md:items-center transition-all hover:bg-surface-container-low border border-outline-variant/5">
                <div class="w-full md:w-24 h-24 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                    <img class="w-full h-full object-cover"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFWgF9H8vW4pXEp4NDQ84b7hFLUINSLlTDgTM-imGMlWGN4j1BZo3KYFnIuGy9hoc1-iGCVIGRvneCCvd6N9mrYcJmqeaGHsaSwSWwyb1uKoQd5fqCXqcvTsXIfd1tNEkei8ItvjhiyS2NMlKPaWAKEPYN4LSuDmO_wvfYCmBMva5kj1JYAHp8b98LmoB9tDlUupEChjTkepV8ye00320a4m8OMtZYKhirRvuXF7PLIWTD2qudD7pT6XdBAB6lQLQLE7IhsqcyIac"
                         alt="Order item">
                </div>

                <div class="flex-grow">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <span class="font-headline font-bold text-lg">Order #ZN-8810</span>
                        <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold uppercase tracking-widest rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Delivered
                        </span>
                    </div>
                    <p class="text-sm text-on-surface-variant mb-2">Placed on September 12, 2024</p>
                    <p class="text-xs font-medium text-tertiary">Organic Cotton Towel Set, Beechwood Spa Brush</p>
                </div>

                <div class="text-left md:text-right w-full md:w-auto">
                    <p class="text-2xl font-headline font-bold text-on-surface mb-4">$128.00</p>
                    <div class="flex md:flex-col gap-2">
                        <button class="flex-1 bg-primary text-on-primary px-6 py-2 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">replay</span>
                            Reorder
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col md:flex-row gap-6 items-start md:items-center transition-all hover:bg-surface-container-low border border-outline-variant/5">
                <div class="w-full md:w-24 h-24 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                    <img class="w-full h-full object-cover"
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgTDCViCZ4SvNTVkxjJevdlKtzPlKziO6qaVjbixzES8oyDiSbgqFx0sUU9pv6xg4QW3tGEL02t24Y-z5spWMrGa9inlFYphoFEMzlFMV0AqiLBurz-TyFegX3XG8jVXQ8HxZWsqVm9IKNPNezbHTihvWBFTQc2VEjczStlI02l0DBdBVGv79LxOl3546q-_jJzvJbrrdI1DjUhbl7AsnQPiPFE0xhSgZoxXrDvYyE1Y9jFsPGTRSOaBQqzCg7c9olYqW80-9WVo4"
                         alt="Order item">
                </div>

                <div class="flex-grow">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <span class="font-headline font-bold text-lg">Order #ZN-8754</span>
                        <span class="px-3 py-1 bg-surface-container-high text-on-surface-variant text-[10px] font-bold uppercase tracking-widest rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Delivered
                        </span>
                    </div>
                    <p class="text-sm text-on-surface-variant mb-2">Placed on August 30, 2024</p>
                    <p class="text-xs font-medium text-tertiary">Ceramic Coffee Cup (Dusk), Stainless Straw Set</p>
                </div>

                <div class="text-left md:text-right w-full md:w-auto">
                    <p class="text-2xl font-headline font-bold text-on-surface mb-4">$42.25</p>
                    <div class="flex md:flex-col gap-2">
                        <button class="flex-1 bg-primary text-on-primary px-6 py-2 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">replay</span>
                            Reorder
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-center pt-8">
                <button class="text-primary font-bold hover:underline underline-offset-8 transition-all flex items-center gap-2">
                    View older purchases
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>