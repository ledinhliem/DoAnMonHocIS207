<footer class="w-full pt-16 pb-8 bg-surface-container text-primary font-body border-t border-outline-variant/10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 px-8 max-w-7xl mx-auto">
            
            <div class="col-span-2 md:col-span-1">
                <div class="text-xl font-bold text-primary mb-6 font-headline tracking-widest uppercase">Zentro</div>
                <p class="text-on-surface-variant/70 leading-relaxed mb-6 text-sm">
                    Sustainable living, simplified. We bring together the world's most ethical brands in one place.
                </p>
                <div class="flex gap-4">
                    <a class="material-symbols-outlined hover:opacity-70 transition-opacity" href="#">public</a>
                    <a class="material-symbols-outlined hover:opacity-70 transition-opacity" href="#">nest_eco_leaf</a>
                    <a class="material-symbols-outlined hover:opacity-70 transition-opacity" href="#">volunteer_activism</a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">The Shop</h4>
                <ul class="space-y-4 text-sm text-on-surface-variant/80">
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Home Decor</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Skincare</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Fashion</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Zero Waste</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">About Us</h4>
                <ul class="space-y-4 text-sm text-on-surface-variant/80">
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Our Story</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Sustainability</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Blog</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Careers</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">Contact</h4>
                <ul class="space-y-4 text-sm text-on-surface-variant/80">
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Shipping</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Privacy Policy</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">Instagram</a></li>
                    <li><a class="hover:underline underline-offset-4 decoration-primary/30" href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-8 mt-16 pt-8 border-t border-primary/10 flex flex-col md:flex-row justify-between gap-4 text-xs text-on-surface-variant/60">
            <div>© <?php echo date('Y'); ?> Zentro Sustainable Living. Built for the Earth.</div>
            <div class="flex gap-6">
                <a class="hover:text-primary transition-colors" href="#">Terms</a>
                <a class="hover:text-primary transition-colors" href="#">Privacy</a>
                <a class="hover:text-primary transition-colors" href="#">Cookies</a>
            </div>
        </div>
    </footer>

    <!-- Load page-specific JavaScript -->
    <?php
    $currentUrl = $_GET['url'] ?? '';
    $jsFile = '';

    if ($currentUrl === '' || $currentUrl === 'home') {
        $jsFile = 'home.js';
    } elseif (strpos($currentUrl, 'product') === 0) {
        $jsFile = 'product.js';
    } elseif (strpos($currentUrl, 'blog') === 0) {
        $jsFile = 'blog.js';
    }

    if ($jsFile && file_exists(__DIR__ . '/../../public/assets/js/' . $jsFile)) {
        echo '<script src="' . BASE_URL . '/public/assets/js/' . $jsFile . '"></script>';
    }
    ?>
</body>
</html>