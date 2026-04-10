<?php $title = 'Order Feedback'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-4xl mx-auto px-6 md:px-8 py-12 md:py-16">
    <div class="bg-white rounded-2xl p-8 md:p-10 border border-outline-variant/20">
        <h1 class="text-4xl font-headline font-extrabold text-primary mb-4">Transfer Confirmation</h1>
        <p class="text-on-surface-variant mb-8">
            This page is usable for flow testing. User can confirm transfer and leave a note.
        </p>

        <form action="<?= BASE_URL ?>?url=order/success" method="get" class="space-y-6">
            <input type="hidden" name="url" value="order/success">

            <div>
                <label class="block text-sm font-bold mb-2">Transfer Note</label>
                <textarea class="w-full min-h-[140px] px-4 py-4 rounded-lg bg-surface-container border border-outline-variant/20" placeholder="Tôi đã chuyển khoản lúc 10:30 sáng..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Receipt Upload (mock)</label>
                <input type="file" class="w-full px-4 py-3 rounded-lg bg-surface-container border border-outline-variant/20">
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="<?= BASE_URL ?>?url=order/transfer" class="text-center flex-1 px-6 py-4 rounded-lg border border-outline-variant/30 font-bold">
                    Back
                </a>
                <button type="submit" class="flex-1 bg-primary text-white px-6 py-4 rounded-lg font-bold hover:opacity-90">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>