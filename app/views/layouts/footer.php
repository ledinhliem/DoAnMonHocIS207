<?php $base = BASE_URL; ?>
</main>

<footer class="w-full pt-16 pb-8 bg-surface-container text-on-surface text-sm border-t border-outline-variant/20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-10 px-6 md:px-8 max-w-7xl mx-auto">
        <div class="col-span-2 md:col-span-1">
            <div class="text-xl font-bold text-primary mb-4 font-headline tracking-widest uppercase">Zentro</div>
            <p class="text-on-surface-variant leading-relaxed mb-5">
                Sustainable living, simplified. We bring together more thoughtful products in one place.
            </p>
            <div class="flex gap-4">
                <a class="material-symbols-outlined hover:text-primary transition-colors" href="#">public</a>
                <a class="material-symbols-outlined hover:text-primary transition-colors" href="#">nest_eco_leaf</a>
                <a class="material-symbols-outlined hover:text-primary transition-colors" href="#">volunteer_activism</a>
            </div>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-4">Shop</h4>
            <ul class="space-y-3">
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>">Home</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>?url=product">Products</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>?url=cart">Cart</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>?url=profile">Profile</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-4">Support</h4>
            <ul class="space-y-3">
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>?url=order/history">Order History</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="<?= $base ?>?url=order/tracking">Track Order</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Shipping</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-4">Contact</h4>
            <ul class="space-y-3">
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Instagram</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="#">LinkedIn</a></li>
                <li><a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Email Us</a></li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-8 mt-12 pt-6 border-t border-outline-variant/20 flex flex-col md:flex-row justify-between gap-4 text-on-surface-variant">
        <div>© 2024 Zentro Sustainable Living. Built for the Earth.</div>
        <div class="flex gap-6">
            <a class="hover:text-primary transition-colors" href="#">Terms</a>
            <a class="hover:text-primary transition-colors" href="#">Privacy</a>
            <a class="hover:text-primary transition-colors" href="#">Cookies</a>
        </div>
    </div>
</footer>
</body>
</html>