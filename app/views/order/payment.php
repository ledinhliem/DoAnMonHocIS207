<?php $title = 'Card Payment'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-4xl mx-auto px-6 md:px-8 py-12 md:py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-8 md:p-10">
        <div class="mb-8">
            <h1 class="text-4xl font-headline font-extrabold text-primary mb-3">Card Payment</h1>
            <p class="text-on-surface-variant">Mock payment form for frontend flow testing.</p>
        </div>

        <form action="<?= BASE_URL ?>?url=order/success" method="get" class="space-y-6">
            <input type="hidden" name="url" value="order/success">

            <div>
                <label class="block text-sm font-bold mb-2">Cardholder Name</label>
                <input type="text" class="w-full px-4 py-4 rounded-lg bg-surface-container border border-outline-variant/20" placeholder="Nguyen Van A">
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Card Number</label>
                <input type="text" class="w-full px-4 py-4 rounded-lg bg-surface-container border border-outline-variant/20" placeholder="4111 1111 1111 1111">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Expiry Date</label>
                    <input type="text" class="w-full px-4 py-4 rounded-lg bg-surface-container border border-outline-variant/20" placeholder="12/28">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">CVV</label>
                    <input type="text" class="w-full px-4 py-4 rounded-lg bg-surface-container border border-outline-variant/20" placeholder="123">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="<?= BASE_URL ?>?url=checkout" class="text-center flex-1 px-6 py-4 rounded-lg border border-outline-variant/30 font-bold">
                    Back to Checkout
                </a>
                <button type="submit" class="flex-1 bg-primary text-white px-6 py-4 rounded-lg font-bold hover:opacity-90">
                    Pay Now
                </button>
            </div>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>