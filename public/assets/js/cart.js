document.addEventListener('DOMContentLoaded', function () {
    const subtotalEl = document.querySelector('[data-cart-subtotal]');
    const shippingEl = document.querySelector('[data-cart-shipping]');
    const totalEl = document.querySelector('[data-cart-total]');
    const emptyCartEl = document.querySelector('[data-cart-empty]');
    const cartListEl = document.querySelector('[data-cart-list]');

    function formatMoney(value) {
        return '$' + value.toFixed(2);
    }

    function updateCartSummary() {
        let subtotal = 0;
        const items = document.querySelectorAll('.cart-item');

        items.forEach(item => {
            const qtyEl = item.querySelector('.cart-qty');
            const itemTotalEl = item.querySelector('.cart-item-total');
            const price = parseFloat(item.dataset.price || '0');
            const qty = parseInt(qtyEl.textContent.trim()) || 0;

            const itemTotal = price * qty;
            subtotal += itemTotal;

            if (itemTotalEl) {
                itemTotalEl.textContent = formatMoney(itemTotal);
            }
        });

        const shippingCost = 0;
        const total = subtotal + shippingCost;

        if (subtotalEl) subtotalEl.textContent = formatMoney(subtotal);
        if (shippingEl) shippingEl.textContent = shippingCost === 0 ? 'Free' : formatMoney(shippingCost);
        if (totalEl) totalEl.textContent = formatMoney(total);

        if (emptyCartEl && cartListEl) {
            if (items.length === 0) {
                emptyCartEl.classList.remove('hidden');
                cartListEl.classList.add('hidden');
            } else {
                emptyCartEl.classList.add('hidden');
                cartListEl.classList.remove('hidden');
            }
        }
    }

    document.addEventListener('click', function (e) {
        const minusBtn = e.target.closest('.btn-qty-minus');
        const plusBtn = e.target.closest('.btn-qty-plus');
        const removeBtn = e.target.closest('.btn-remove-item');

        if (minusBtn) {
            const item = minusBtn.closest('.cart-item');
            const qtyEl = item.querySelector('.cart-qty');
            let qty = parseInt(qtyEl.textContent.trim()) || 1;
            if (qty > 1) {
                qty--;
                qtyEl.textContent = qty;
                updateCartSummary();
            }
        }

        if (plusBtn) {
            const item = plusBtn.closest('.cart-item');
            const qtyEl = item.querySelector('.cart-qty');
            let qty = parseInt(qtyEl.textContent.trim()) || 1;
            qty++;
            qtyEl.textContent = qty;
            updateCartSummary();
        }

        if (removeBtn) {
            const item = removeBtn.closest('.cart-item');
            item.remove();
            updateCartSummary();
        }
    });

    updateCartSummary();
});