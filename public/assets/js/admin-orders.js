    function switchOrderTab(tab, button) {
        const cards = document.querySelectorAll('.order-card');
        const buttons = document.querySelectorAll('.order-tab-btn');

        buttons.forEach(btn => {
            btn.classList.remove('bg-primary', 'text-on-primary');
            btn.classList.add('bg-surface-container', 'text-on-surface-variant');
        });

        button.classList.remove('bg-surface-container', 'text-on-surface-variant');
        button.classList.add('bg-primary', 'text-on-primary');

        cards.forEach(card => {
            if (tab === 'active') {
                card.style.display = card.dataset.status === 'active' ? 'block' : 'none';
            } else {
                card.style.display = card.dataset.status === 'archived' ? 'block' : 'none';
            }
        });
    }

    function filterOrders() {
        const keyword = document.getElementById('order-search').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.order-card');

        cards.forEach(card => {
            const orderId = card.dataset.orderId.toLowerCase();
            const customer = card.dataset.customer.toLowerCase();

            if (orderId.includes(keyword) || customer.includes(keyword)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }