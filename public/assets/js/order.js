document.addEventListener('DOMContentLoaded', function () {
    const checkoutForm = document.querySelector('#checkout-form');
    const subtotalEl = document.querySelector('[data-checkout-subtotal]');
    const shippingEl = document.querySelector('[data-checkout-shipping]');
    const totalEl = document.querySelector('[data-checkout-total]');
    const discountEl = document.querySelector('[data-checkout-discount]');

    // Parse số tiền VNĐ từ text (vd: "130.000₫" → 130000)
    function parseMoney(text) {
        return parseFloat(String(text).replace(/[^\d]/g, '')) || 0;
    }

    // Format số tiền VNĐ (vd: 30000 → "30.000₫")
    function formatMoney(value) {
        return value.toLocaleString('vi-VN') + '₫';
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
        const discount = discountEl ? parseMoney(discountEl.textContent) : 0;

        // Hỗ trợ cả radio button lẫn <select> dropdown cho shipping
        let shipping = 0;
        const shippingRadio = document.querySelector('input[name="shipping_method"]:checked');
        const shippingSelect = document.querySelector('select[name="delivery_method"]');

        if (shippingRadio) {
            shipping = parseFloat(shippingRadio.dataset.cost || '0');
        } else if (shippingSelect) {
            const opt = shippingSelect.options[shippingSelect.selectedIndex];
            shipping = parseFloat(opt?.dataset.cost || '0');
            console.log('shipping cost:', shipping, 'data-cost:', opt?.dataset.cost);
        }

        const total = Math.max(0, subtotal - discount + shipping);

        if (shippingEl) shippingEl.textContent = formatMoney(shipping);
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

        // Kiểm tra shipping: hỗ trợ cả radio lẫn select
        const hasShippingRadio = document.querySelector('input[name="shipping_method"]');
        const hasShippingSelect = document.querySelector('select[name="delivery_method"]');
        if (hasShippingRadio && !document.querySelector('input[name="shipping_method"]:checked')) {
            alert('Vui lòng chọn phương thức vận chuyển');
            valid = false;
        }
        // select luôn có giá trị nên không cần check thêm

        // Kiểm tra payment: hỗ trợ cả radio lẫn select
        const hasPaymentRadio = document.querySelector('input[name="payment_method"]');
        if (hasPaymentRadio && !document.querySelector('input[name="payment_method"]:checked')) {
            alert('Vui lòng chọn phương thức thanh toán');
            valid = false;
        }

        return valid;
    }

    // Radio buttons cho shipping
    document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
        input.addEventListener('change', function () {
            updateSelectedCardUI('shipping_method', 'shipping-card');
            updateTotals();
        });
    });

    // Select dropdown cho shipping — cập nhật tổng tiền khi đổi
    const shippingSelect = document.querySelector('select[name="delivery_method"]');
    if (shippingSelect) {
        shippingSelect.addEventListener('change', updateTotals);
    }

    // Radio buttons cho payment
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function () {
            updateSelectedCardUI('payment_method', 'payment-card');
        });
    });

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
            if (!validateCheckoutForm()) {
                e.preventDefault();
                return;
            }
            // Để form POST lên server bình thường — server tự điều hướng theo payment_method
        });
    }

    updateSelectedCardUI('shipping_method', 'shipping-card');
    updateSelectedCardUI('payment_method', 'payment-card');
    updateTotals();
});