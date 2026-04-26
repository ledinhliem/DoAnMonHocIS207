<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-4xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Card Payment</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <form id="paymentForm" method="POST" action="?url=order/process-payment" class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold mb-2">Name on card</label>
                <input
                    id="card_name"
                    type="text"
                    name="card_name"
                    value="<?= htmlspecialchars($old['card_name'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline-variant bg-white"
                >
                <?php if (!empty($errors['card_name'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['card_name']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Card number</label>
                <input
                    id="card_number"
                    type="text"
                    name="card_number"
                    value="<?= htmlspecialchars($old['card_number'] ?? '') ?>"
                    class="w-full rounded-xl border border-outline-variant bg-white"
                    placeholder="4242424242424242"
                >
                <?php if (!empty($errors['card_number'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['card_number']) ?></p>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Expiry</label>
                    <input
                        id="card_expiry"
                        type="text"
                        name="card_expiry"
                        value="<?= htmlspecialchars($old['card_expiry'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white"
                        placeholder="MM/YY"
                    >
                    <?php if (!empty($errors['card_expiry'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['card_expiry']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">CVV</label>
                    <input
                        id="card_cvv"
                        type="password"
                        name="card_cvv"
                        value="<?= htmlspecialchars($old['card_cvv'] ?? '') ?>"
                        class="w-full rounded-xl border border-outline-variant bg-white"
                        placeholder="123"
                    >
                    <?php if (!empty($errors['card_cvv'])): ?>
                        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($errors['card_cvv']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex gap-4 pt-3">
                <a href="?url=checkout" class="px-5 py-3 rounded-xl border border-outline-variant font-semibold">
                    Back to Checkout
                </a>

                <button
                    id="payNowBtn"
                    type="submit"
                    disabled
                    class="px-5 py-3 rounded-xl bg-primary text-white font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Pay Now
                </button>
            </div>
        </form>

        <div class="bg-surface-container rounded-2xl p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Payment Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>$<?= number_format($summary['subtotal'], 2) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Discount</span>
                    <span>- $<?= number_format($summary['discount'], 2) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>$<?= number_format($summary['shipping'], 2) ?></span>
                </div>
                <div class="flex justify-between font-bold text-primary text-lg pt-2">
                    <span>Total</span>
                    <span>$<?= number_format($summary['total'], 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const paymentForm = document.getElementById('paymentForm');
    const payNowBtn = document.getElementById('payNowBtn');

    const cardName = document.getElementById('card_name');
    const cardNumber = document.getElementById('card_number');
    const cardExpiry = document.getElementById('card_expiry');
    const cardCvv = document.getElementById('card_cvv');

    function validatePaymentForm() {
        const nameValid = cardName.value.trim() !== '';
        const numberValid = /^[0-9]{13,19}$/.test(cardNumber.value.trim().replace(/\s+/g, ''));
        const expiryValid = /^(0[1-9]|1[0-2])\/([0-9]{2})$/.test(cardExpiry.value.trim());
        const cvvValid = /^[0-9]{3,4}$/.test(cardCvv.value.trim());

        payNowBtn.disabled = !(nameValid && numberValid && expiryValid && cvvValid);
    }

    [cardName, cardNumber, cardExpiry, cardCvv].forEach(input => {
        input.addEventListener('input', validatePaymentForm);
    });

    validatePaymentForm();

    paymentForm.addEventListener('submit', function () {
        payNowBtn.disabled = true;
        payNowBtn.textContent = 'Processing...';
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>