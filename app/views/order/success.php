<?php $title = 'Order Success'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-5xl mx-auto px-6 md:px-8 py-16 md:py-24">
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-10 md:p-16 text-center">
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-primary rounded-full flex items-center justify-center text-white shadow-xl">
                <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">eco</span>
            </div>
        </div>

        <h1 class="font-headline text-4xl md:text-5xl font-extrabold text-primary mb-6">Order Successful!</h1>

        <div class="space-y-4 mb-10 max-w-xl mx-auto">
            <p class="text-on-surface text-lg font-medium">
                Your order <span class="text-primary font-bold">#ZN-884210</span> is confirmed.
            </p>
            <p class="text-on-surface-variant leading-relaxed">
                We received your order successfully. Thank you for choosing a more sustainable shopping experience.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-xl mx-auto">
            <a href="<?= BASE_URL ?>?url=order/tracking" class="flex-1 bg-primary text-white py-4 px-8 rounded-lg font-bold hover:opacity-90 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-xl">local_shipping</span>
                Track Order
            </a>
            <a href="<?= BASE_URL ?>" class="flex-1 bg-secondary-container text-on-secondary-container py-4 px-8 rounded-lg font-bold hover:opacity-90 transition-all flex items-center justify-center gap-2">
                Continue Shopping
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>