<?php $title = 'Track Your Order'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-screen-2xl mx-auto px-6 md:px-8 py-12 md:py-20">
    <section class="mb-16">
        <h1 class="font-headline text-5xl md:text-7xl font-extrabold text-primary tracking-tight mb-4 leading-tight">
            Your package is <br /><span class="text-primary/70">en route to you.</span>
        </h1>

        <div class="flex flex-wrap items-center gap-4 text-on-surface-variant font-medium">
            <span class="bg-surface-container px-4 py-2 rounded-full border border-outline-variant/30">Order #ZN-884210</span>
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">eco</span>
                Carbon-Neutral Shipping Verified
            </span>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-surface-container-lowest p-8 md:p-12 rounded-xl border border-outline-variant/20">
                <h2 class="font-headline text-2xl font-bold mb-12">Journey Status</h2>

                <div class="relative">
                    <div class="absolute top-4 left-4 right-4 h-1 bg-surface-container-high rounded-full">
                        <div class="absolute top-0 left-0 w-2/3 h-full bg-primary rounded-full"></div>
                    </div>

                    <div class="relative flex justify-between">
                        <div class="flex flex-col items-center gap-4 text-center group">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white z-10 transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface text-sm">Consciously Packed</p>
                                <p class="text-on-surface-variant text-xs mt-1">Oct 12, 09:15 AM</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-4 text-center group">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white z-10 transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface text-sm">Sorted & Ready</p>
                                <p class="text-on-surface-variant text-xs mt-1">Oct 13, 11:30 AM</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-4 text-center group">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white z-10 transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined text-sm">local_shipping</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface text-sm">In Transit</p>
                                <p class="text-primary font-semibold text-xs mt-1">Arriving Tomorrow</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-4 text-center group opacity-40">
                            <div class="w-8 h-8 rounded-full bg-surface-container-highest border border-outline-variant flex items-center justify-center text-on-surface-variant z-10">
                                <span class="material-symbols-outlined text-sm">potted_plant</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface text-sm">Carbon-Neutral Delivery</p>
                                <p class="text-on-surface-variant text-xs mt-1">Estimated Oct 15</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-24 max-w-4xl">
                <h2 class="font-headline text-3xl font-bold mb-12">Detailed History</h2>

                <div class="space-y-0 relative border-l-2 border-surface-container-high ml-4 pl-12">
                    <div class="relative pb-12">
                        <div class="absolute -left-[57px] top-0 w-4 h-4 rounded-full bg-primary ring-8 ring-background"></div>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest">Oct 14, 02:40 AM</p>
                        <p class="text-lg font-bold mt-1">Departed regional sorting facility</p>
                        <p class="text-on-surface-variant text-sm mt-1">Boulder Logistics Hub, CO</p>
                    </div>

                    <div class="relative pb-12">
                        <div class="absolute -left-[57px] top-0 w-4 h-4 rounded-full bg-surface-container-highest ring-8 ring-background border border-outline"></div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Oct 13, 08:15 PM</p>
                        <p class="text-lg font-bold mt-1">Arrived at sorting facility</p>
                        <p class="text-on-surface-variant text-sm mt-1">Denver Hub, CO</p>
                    </div>

                    <div class="relative pb-12">
                        <div class="absolute -left-[57px] top-0 w-4 h-4 rounded-full bg-surface-container-highest ring-8 ring-background border border-outline"></div>
                        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Oct 12, 11:30 AM</p>
                        <p class="text-lg font-bold mt-1">Order processed & packaging verified</p>
                        <p class="text-on-surface-variant text-sm mt-1">Fulfillment Center, OR</p>
                    </div>
                </div>
            </section>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="bg-primary text-white p-8 rounded-xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <span class="material-symbols-outlined text-[160px]">eco</span>
                </div>

                <h3 class="font-headline text-xl font-bold mb-6">Your Positive Impact</h3>

                <div class="space-y-6">
                    <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium opacity-80">CO2 Offset</span>
                            <span class="bg-primary-fixed-dim text-primary text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Verified</span>
                        </div>
                        <p class="text-3xl font-headline font-extrabold">12.4 kg</p>
                        <p class="text-xs mt-1 opacity-70">Equivalent to planting 1 tree</p>
                    </div>

                    <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium opacity-80">Plastic Avoided</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">recycling</span>
                        </div>
                        <p class="text-3xl font-headline font-extrabold">450 g</p>
                        <p class="text-xs mt-1 opacity-70">100% compostable mycelium packaging</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low p-8 rounded-xl border border-outline-variant/10">
                <h3 class="font-headline text-lg font-bold mb-6 text-on-surface">Delivery Details</h3>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-secondary">location_on</span>
                        <div>
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Shipping To</p>
                            <p class="text-sm mt-1 leading-relaxed">
                                Alex Rivera<br />
                                1420 Pine Street, Apt 4C<br />
                                San Francisco, CA 94109
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-secondary">inventory_2</span>
                        <div>
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">In This Package</p>
                            <ul class="text-sm mt-1 space-y-1">
                                <li>Hemp Cotton Duvet Cover × 1</li>
                                <li>Bamboo Pillowcase Set × 2</li>
                            </ul>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-outline-variant/30">
                        <button class="w-full bg-secondary text-white py-4 rounded-lg font-bold hover:bg-secondary/90 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">support_agent</span>
                            Help with Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>