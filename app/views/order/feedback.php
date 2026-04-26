<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-3xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Order Feedback</h1>

    <?php if (!empty($success)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-outline-variant/30 p-6">
        <?php if (!empty($order)): ?>
            <div class="mb-6 text-sm text-on-surface-variant">
                Feedback for order: <span class="font-semibold text-primary"><?= htmlspecialchars($order['order_id']) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=order/submit-feedback" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold mb-2">Rating</label>
                <select name="rating" class="w-full rounded-xl border border-outline-variant bg-white">
                    <option value="">Choose rating</option>
                    <option value="5" <?= (($old['rating'] ?? '') === '5') ? 'selected' : '' ?>>5 stars</option>
                    <option value="4" <?= (($old['rating'] ?? '') === '4') ? 'selected' : '' ?>>4 stars</option>
                    <option value="3" <?= (($old['rating'] ?? '') === '3') ? 'selected' : '' ?>>3 stars</option>
                    <option value="2" <?= (($old['rating'] ?? '') === '2') ? 'selected' : '' ?>>2 stars</option>
                    <option value="1" <?= (($old['rating'] ?? '') === '1') ? 'selected' : '' ?>>1 star</option>
                </select>
                <?php if (!empty($errors['rating'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['rating']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Your feedback</label>
                <textarea
                    name="message"
                    rows="5"
                    class="w-full rounded-xl border border-outline-variant bg-white"
                    placeholder="Tell us about your experience..."
                ><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                <?php if (!empty($errors['message'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['message']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                Submit Feedback
            </button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>