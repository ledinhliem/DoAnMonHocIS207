<footer class="w-full pt-16 pb-8 bg-surface-container text-primary font-body border-t border-outline-variant/10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-12 px-8 max-w-7xl mx-auto">

        <div class="col-span-2 md:col-span-1">
            <div class="text-xl font-bold text-primary mb-6 font-headline tracking-widest uppercase">
                Zentro
            </div>

            <p class="text-on-surface-variant/70 leading-relaxed mb-6 text-sm">
                Sống xanh đơn giản hơn. Chúng tôi tập hợp các thương hiệu có trách nhiệm tại một nơi.
            </p>

            <div class="flex gap-4">
                <a class="material-symbols-outlined hover:opacity-70 transition-opacity"
                    href="<?= BASE_URL ?>?url=sustainability"
                    title="Cam kết bền vững">
                    public
                </a>

                <a class="material-symbols-outlined hover:opacity-70 transition-opacity"
                    href="<?= BASE_URL ?>?url=product&impact=tái%20chế"
                    title="Sản phẩm tái chế">
                    nest_eco_leaf
                </a>

                <a class="material-symbols-outlined hover:opacity-70 transition-opacity"
                    href="<?= BASE_URL ?>?url=ourstory"
                    title="Câu chuyện Zentro">
                    volunteer_activism
                </a>
            </div>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">
                Cửa hàng
            </h4>

            <ul class="space-y-4 text-sm text-on-surface-variant/80">
                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=product&category=C002">
                        Trang trí nhà cửa
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=product&category=C004">
                        Chăm sóc da
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=product&category=C003">
                        Thời trang
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=product&category=C001">
                        Không rác thải
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">
                About Us
            </h4>

            <ul class="space-y-4 text-sm text-on-surface-variant/80">
                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=ourstory">
                        Our Story
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=sustainability">
                        Sustainability
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="<?= BASE_URL ?>?url=blog">
                        Blog
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-primary mb-6 uppercase text-xs tracking-widest">
                Contact
            </h4>

            <ul class="space-y-4 text-sm text-on-surface-variant/80">
                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="mailto:zentroshop359@gmail.com">
                        Email: zentroshop359@gmail.com
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="tel:0909090090">
                        Tel: 0909 090 090 (8:00 – 21:30)
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="https://www.instagram.com/daiu.laz?igsh=dndlc2d6N3Q0YzQz&utm_source=qr"
                        target="_blank">
                        Instagram
                    </a>
                </li>

                <li>
                    <a class="hover:underline underline-offset-4 decoration-primary/30"
                        href="https://www.facebook.com/profile.php?id=61589733862899"
                        target="_blank">
                        Facebook
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 mt-16 pt-8 border-t border-primary/10
                flex flex-col md:flex-row justify-between gap-4
                text-xs text-on-surface-variant/60">
        <div>
            © <?php echo date('Y'); ?> Zentro Sustainable Living. Xây dựng vì Trái Đất.
        </div>

        <div class="flex gap-6">
            <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>?url=terms">Terms</a>
            <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>?url=privacy">Privacy</a>
            <a class="hover:text-primary transition-colors" href="<?= BASE_URL ?>?url=cookies">Cookies</a>
        </div>
    </div>
</footer>


<?php if (!empty($_SESSION['game_result_popup'])): ?>
    <script type="application/json" id="game-result-popup-data">
        <?= json_encode($_SESSION['game_result_popup'], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>
    </script>
    <?php unset($_SESSION['game_result_popup']); ?>
<?php endif; ?>

<script src="public/assets/js/auth.js"></script>
<script src="public/assets/js/order-notification.js"></script>
<script src="public/assets/js/gamification.js"></script>
