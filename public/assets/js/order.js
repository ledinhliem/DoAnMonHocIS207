document.addEventListener('DOMContentLoaded', function () {
    const checkoutForm = document.querySelector('#checkout-form');
    const subtotalEl = document.querySelector('[data-checkout-subtotal]');
    const shippingEl = document.querySelector('[data-checkout-shipping]');
    const taxEl = document.querySelector('[data-checkout-tax]');
    const totalEl = document.querySelector('[data-checkout-total]');

    function parseMoney(text) {
        return parseFloat(String(text).replace('$', '').replace(',', '').trim()) || 0;
    }

    function formatMoney(value) {
        return '$' + value.toFixed(2);
    }

    function updateSelectedCardUI(groupName, cardClass) {
        document.querySelectorAll('.' + cardClass).forEach(card => {
            card.classList.remove('border-primary', 'ring-2', 'ring-primary/20');
            card.classList.add('border-outline-variant/20');
        });

        const selected = document.querySelector(`input[name="${groupName}"]:checked`);
        if (selected) {
            const card = selected.closest('.' + cardClass);
            if (card) {
                card.classList.remove('border-outline-variant/20');
                card.classList.add('border-primary', 'ring-2', 'ring-primary/20');
            }
        }
    }

    function updateTotals() {
        const subtotal = subtotalEl ? parseMoney(subtotalEl.textContent) : 0;
        const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
        const shipping = selectedShipping ? parseFloat(selectedShipping.dataset.cost || '0') : 0;
        const tax = subtotal * 0.08;
        const total = subtotal + shipping + tax;

        if (shippingEl) shippingEl.textContent = shipping === 0 ? 'Free' : formatMoney(shipping);
        if (taxEl) taxEl.textContent = formatMoney(tax);
        if (totalEl) totalEl.textContent = formatMoney(total);
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.field-input-error').forEach(el => {
            el.classList.remove('field-input-error', 'ring-2', 'ring-red-400');
        });
    }

    function showError(input, message) {
        input.classList.add('field-input-error', 'ring-2', 'ring-red-400');
        const error = document.createElement('p');
        error.className = 'field-error text-red-500 text-sm mt-2';
        error.textContent = message;
        input.parentNode.appendChild(error);
    }

    function validateCheckoutForm() {
        if (!checkoutForm) return true;

        clearErrors();
        let valid = true;

        const requiredFields = checkoutForm.querySelectorAll('[data-required="true"]');
        requiredFields.forEach(input => {
            const value = input.value.trim();

            if (!value) {
                showError(input, 'Vui lòng nhập thông tin này');
                valid = false;
                return;
            }

            if (input.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    showError(input, 'Email không hợp lệ');
                    valid = false;
                }
            }
        });

        if (!document.querySelector('input[name="shipping_method"]:checked')) {
            alert('Vui lòng chọn phương thức vận chuyển');
            valid = false;
        }

        if (!document.querySelector('input[name="payment_method"]:checked')) {
            alert('Vui lòng chọn phương thức thanh toán');
            valid = false;
        }

        return valid;
    }

    document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
        input.addEventListener('change', function () {
            updateSelectedCardUI('shipping_method', 'shipping-card');
            updateTotals();
        });
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function () {
            updateSelectedCardUI('payment_method', 'payment-card');
        });
    });

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!validateCheckoutForm()) return;

            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            const nextUrl = selectedPayment ? selectedPayment.dataset.next : null;

            if (nextUrl) {
                window.location.href = nextUrl;
            }
        });
    }

    updateSelectedCardUI('shipping_method', 'shipping-card');
    updateSelectedCardUI('payment_method', 'payment-card');
    updateTotals();
});