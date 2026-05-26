<?php
$newsletterTitle = $newsletterTitle ?? 'Cùng Zentro thay đổi tương lai.';
$newsletterDescription = $newsletterDescription
    ?? 'Đăng ký nhận bản tin Journal để tìm hiểu thêm về lối sống bền vững và các bộ sưu tập mới nhất.';
$newsletterPlaceholder = $newsletterPlaceholder ?? 'Email của bạn...';
$newsletterButtonText = $newsletterButtonText ?? 'Tham Gia Ngay';
$newsletterOuterClass = trim($newsletterOuterClass ?? '');
$newsletterRedirect = $_SERVER['REQUEST_URI'] ?? '?url=';
$newsletterRedirect = strtok($newsletterRedirect, '#') . '#newsletter';
$newsletterSuccess = $_SESSION['newsletter_success'] ?? '';
$newsletterError = $_SESSION['newsletter_error'] ?? '';
unset($_SESSION['newsletter_success'], $_SESSION['newsletter_error']);

if (!function_exists('renderNewsletterCta')) {
    function renderNewsletterCta(
        string $title,
        string $description,
        string $placeholder,
        string $buttonText,
        string $redirect,
        string $success = '',
        string $error = ''
    ): void { ?>
        <section id="newsletter" data-newsletter class="rounded-xl overflow-hidden bg-primary p-12 md:p-24 text-center text-white relative">
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-bold font-headline mb-8">
                    <?= htmlspecialchars($title) ?>
                </h2>
                <p class="text-primary-fixed/80 text-lg mb-12 font-light">
                    <?= htmlspecialchars($description) ?>
                </p>
                <?php if ($success !== ''): ?>
                    <div class="mb-6 rounded-xl bg-white/15 border border-white/20 px-5 py-4 text-sm font-semibold">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php elseif ($error !== ''): ?>
                    <div class="mb-6 rounded-xl bg-red-100 text-red-800 px-5 py-4 text-sm font-semibold">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="?url=blog/subscribe" class="flex flex-col md:flex-row gap-4 justify-center">
                    <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirect) ?>">
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="<?= htmlspecialchars($placeholder) ?>"
                        class="bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl px-8 py-4
                               focus:ring-2 focus:ring-primary-fixed focus:outline-none w-full md:w-80"
                    >
                    <button type="submit" class="bg-secondary-container text-on-secondary-container font-bold px-10 py-4 rounded-xl
                                   hover:scale-105 transition-transform">
                        <?= htmlspecialchars($buttonText) ?>
                    </button>
                </form>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary-container rounded-full blur-[100px]
                        -mr-32 -mt-32 opacity-50 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary-fixed rounded-full blur-[100px]
                        -ml-32 -mb-32 opacity-30 pointer-events-none"></div>
        </section>
    <?php }
}

if ($newsletterOuterClass !== ''): ?>
    <section class="<?= htmlspecialchars($newsletterOuterClass) ?>">
        <?php renderNewsletterCta($newsletterTitle, $newsletterDescription, $newsletterPlaceholder, $newsletterButtonText, $newsletterRedirect, $newsletterSuccess, $newsletterError); ?>
    </section>
<?php else: ?>
    <?php renderNewsletterCta($newsletterTitle, $newsletterDescription, $newsletterPlaceholder, $newsletterButtonText, $newsletterRedirect, $newsletterSuccess, $newsletterError); ?>
<?php endif; ?>
