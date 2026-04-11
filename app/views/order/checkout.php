<?php $title = 'Checkout'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-7xl mx-auto px-6 md:px-8 py-12 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-7 space-y-10">
            <div>
                <h1 class="text-4xl md:text-5xl font-headline font-extrabold text-primary mb-3">Shipping Details</h1>
                <p class="text-on-surface-variant max-w-xl">
                    Complete your purchase with our carbon-neutral delivery partners.
                </p>
            </div>

            <form class="space-y-8">
                <section class="space-y-4">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">mail</span>
                        Contact Information
                    </h2>
                    <div class="space-y-4">
                        <input class="w-full px-6 py-4 rounded-lg bg-surface-container-high border-none focus:ring-2 focus:ring-primary/20" placeholder="Email Address" type="email" />
                        <label class="flex items-center gap-3 px-2">
                            <input class="rounded text-primary focus:ring-primary" type="checkbox" />
                            <span class="text-sm text-on-surface-variant">Keep me updated on sustainable living tips and offers.</span>
                        </label>
                    </div>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        Shipping Address
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input class="px-6 py-4 rounded-lg bg-surface-container-high border-none" placeholder="First Name" type="text" />
                        <input class="px-6 py-4 rounded-lg bg-surface-container-high border-none" placeholder="Last Name" type="text" />
                        <input class="md:col-span-2 px-6 py-4 rounded-lg bg-surface-container-high border-none" placeholder="Street Address" type="text" />
                        <input class="px-6 py-4 rounded-lg bg-surface-container-high border-none" placeholder="City" type="text" />
                        <input class="px-6 py-4 rounded-lg bg-surface-container-high border-none" placeholder="Postal Code" type="text" />
                    </div>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">eco</span>
                        Delivery Method
                    </h2>

                    <div class="space-y-4">
                        <label class="flex items-center justify-between p-6 rounded-xl bg-surface-container border-2 border-primary">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-primary p-2 bg-primary/10 rounded-full">wind_power</span>
                                <div>
                                    <p class="font-bold">Carbon Neutral Standard</p>
                                    <p class="text-sm text-on-surface-variant">Delivered in 3-5 business days via EV fleet</p>
                                </div>
                            </div>
                            <span class="font-bold text-primary">Free</span>
                        </label>

                        <label class="flex items-center justify-between p-6 rounded-xl bg-surface-container border border-outline-variant/20">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-secondary p-2 bg-secondary/10 rounded-full">cycle</span>
                                <div>
                                    <p class="font-bold">Zero-Waste Express</p>
                                    <p class="text-sm text-on-surface-variant">Next-day delivery in reusable packaging</p>
                                </div>
                            </div>
                            <span class="font-bold text-primary">$12.00</span>
                        </label>
                    </div>
                </section>
            </form>
        </div>

        <aside class="lg:col-span-5">
            <div class="sticky top-28 p-8 rounded-xl bg-surface-container-low shadow-soft space-y-8">
                <h3 class="text-2xl font-bold tracking-tight font-headline">Order Summary</h3>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDahNG9D2_Ct4PIJbBxMhT3JhZMZIqXnmdinLezL9fOqI2gdE-QP_cPYjSwi2UA-C93Jxau8HXl1n94mNx5jg-riJRzAvKElatMBWtXXQ6C62sW1ys6P1EJhjFE_u54tYJL5ZUJrhbULcrLrR5hG5-qH-BKO_J59_FLyVvt3ro9g0wyfuDbokhFf3p2QM6eGMbxbdJrQBchYHI7VFXIORoDOIJuK0CCU5yln5Y1e5N3fKM9ItzmgZS0Do_eBNIQe6vJwsAK6z3ajE" alt="Product 1" />
                        </div>
                        <div class="flex-1">
                            <p class="font-bold">Woven Moss Throw</p>
                            <p class="text-sm text-on-surface-variant">Organic Cotton · Sage</p>
                            <p class="text-sm font-medium mt-1">Qty: 1</p>
                        </div>
                        <span class="font-bold text-primary">$85.00</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDU-kYrzEDR0WTGmx-kwllKARO_X5H50SAJvGUtBGt7pFP49b_5AE-KkQzypAGYCxnHmHG9RY7tiKUXThRZxowWssn4llLVnJjc-1z1ktttlccWoFZFrzww_Skr-QkqES6KMsLNsF52onptaVlgOnB5HbSr6l8jGadtl1c6DBlP1rlKbic4kG-j2QNE1X5CaRHsA3ygtUOLF0_29CnQfNwwni1LXB8H7pX_CAdOaHg7_YeFILvArJim6m8ZEKR9EobU2GaivF6qEhg" alt="Product 2" />
                        </div>
                        <div class="flex-1">
                            <p class="font-bold">Recycled Glass Jar</p>
                            <p class="text-sm text-on-surface-variant">Hand-blown · 500ml</p>
                            <p class="text-sm font-medium mt-1">Qty: 2</p>
                        </div>
                        <span class="font-bold text-primary">$48.00</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <input class="flex-1 px-4 py-3 rounded-lg bg-surface-container-highest border-none" placeholder="Promo Code" type="text" />
                    <button class="px-6 py-3 bg-secondary-container text-on-secondary-container rounded-lg font-bold">Apply</button>
                </div>

                <div class="space-y-4 pt-6 border-t border-outline-variant/30">
                    <div class="flex justify-between text-on-surface-variant">
                        <span>Subtotal</span>
                        <span>$133.00</span>
                    </div>
                    <div class="flex justify-between text-on-surface-variant">
                        <span>Shipping</span>
                        <span class="text-primary font-medium">Free</span>
                    </div>
                    <div class="flex justify-between text-on-surface-variant">
                        <span>Estimated Tax</span>
                        <span>$10.64</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold pt-4 font-headline">
                        <span>Total</span>
                        <span>$143.64</span>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>?url=order/success" class="block w-full text-center px-12 py-5 bg-primary text-on-primary rounded-full font-bold text-lg hover:bg-primary-container transition-all shadow-lg">
                    Continue to Payment
                </a>
            </div>
        </aside>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>