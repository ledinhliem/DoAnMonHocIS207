<?php $title = 'Your Cart'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-7xl mx-auto px-6 md:px-8 py-12 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-7 space-y-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-headline font-extrabold text-primary mb-3">Your Cart</h1>
                <p class="text-on-surface-variant max-w-2xl">
                    Review your selected sustainable products before checkout.
                </p>
            </div>

            <div class="space-y-5">
                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft border border-outline-variant/10 flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-28 h-32 rounded-xl overflow-hidden bg-surface-container">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhYM7wtj_wh_zAwSBThWSoA_1vsCFEc5Oh5mD6CSv2ZjhThmH2T2RxaW1RQz_N6w2rrJvZJvg-d4VgiPZAMxYQp_bZUli1kUE0G64COZm6hL81JijRr8hlIF_hI89TVnwD3zpWm_GyvvxGHhya3-FVoq16_E0ihLB1EjikiQypHjXmvBgef7a7IGfzr8mzIPAcTSXuMua_WS7N-HJLzYwk6D4btpMzNeIoPv4rtv4_Q9GVyfcgm_H9-FvL-38vscSIV32f-tnF6Wg" alt="Stone Pitcher">
                    </div>
                    <div class="flex-1 flex flex-col justify-between gap-4">
                        <div>
                            <h3 class="font-headline text-xl font-bold">Honed Stone Pitcher</h3>
                            <p class="text-on-surface-variant text-sm">Sandstone Grey</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 bg-surface-container-high px-4 py-2 rounded-full">
                                <button><span class="material-symbols-outlined text-sm">remove</span></button>
                                <span class="font-bold">1</span>
                                <button><span class="material-symbols-outlined text-sm">add</span></button>
                            </div>
                            <span class="font-headline text-xl font-bold">$84.00</span>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft border border-outline-variant/10 flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-28 h-32 rounded-xl overflow-hidden bg-surface-container">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvf1UikCqv-CIE3bpN0vrQOgZH6QUXkssQbO95wr49O-z5FBpZyOKBcivfWKtJwE7kYmvhTkepRYqzb5GtbWDsXoe9oZeK9csMkMsfHv0OFL-AjcUfSvoyepTdUtrTesjX6yPCkm8zoH9_5LmRN3sDHoWg5cnY-oliyZWSNpcM0N3m8qlPn30lDh-3IwfN_7Lm7zUKw9VtoIXaw7upIO0FecwJC2GvYDvduwQ2WEORRe8fSc-OjJjSrAfjVYZt3P39Ql7XKo0BMao" alt="Woven Linen Throw">
                    </div>
                    <div class="flex-1 flex flex-col justify-between gap-4">
                        <div>
                            <h3 class="font-headline text-xl font-bold">Woven Linen Throw</h3>
                            <p class="text-on-surface-variant text-sm">Moss & Earth</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 bg-surface-container-high px-4 py-2 rounded-full">
                                <button><span class="material-symbols-outlined text-sm">remove</span></button>
                                <span class="font-bold">2</span>
                                <button><span class="material-symbols-outlined text-sm">add</span></button>
                            </div>
                            <span class="font-headline text-xl font-bold">$156.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-primary-container/10 border border-primary/10 rounded-xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">eco</span>
                    <h4 class="font-headline font-bold text-primary">Your Eco-Impact</h4>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold">Plastic Saved</p>
                        <p class="font-headline text-2xl font-bold text-primary">2.4kg</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-on-surface-variant font-bold">Trees Planted</p>
                        <p class="font-headline text-2xl font-bold text-primary">3</p>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-span-5">
            <div class="bg-surface-container-low rounded-xl p-8 shadow-soft sticky top-28">
                <h3 class="text-2xl font-headline font-bold mb-6">Summary</h3>

                <div class="space-y-3 text-on-surface-variant">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>$240.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Carbon-Neutral Shipping</span>
                        <span class="text-primary font-medium">Free</span>
                    </div>
                    <div class="flex justify-between pt-4 text-on-surface text-xl font-headline font-bold border-t border-outline-variant/20">
                        <span>Total</span>
                        <span>$240.00</span>
                    </div>
                </div>

                <div class="mt-8 space-y-3">
                    <a href="<?= BASE_URL ?>?url=order/checkout" class="block w-full text-center bg-secondary hover:bg-[#5d4123] text-on-secondary py-4 rounded-lg font-headline font-bold transition-all">
                        Checkout
                    </a>
                    <a href="<?= BASE_URL ?>" class="block w-full text-center text-on-surface-variant hover:text-primary py-2 text-sm font-medium transition-colors">
                        Keep Shopping
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>