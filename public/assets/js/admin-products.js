    let currentProductPage = 1;

    function filterProducts() {
        const keyword = document.getElementById('product-search').value.toLowerCase().trim();
        const category = document.getElementById('product-category-filter').value;
        const brand = document.getElementById('product-brand-filter').value;
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const sku = card.dataset.sku.toLowerCase();
            const cardCategory = card.dataset.category;
            const cardBrand = card.dataset.brand;

            const matchKeyword = name.includes(keyword) || sku.includes(keyword);
            const matchCategory = category === 'all' || cardCategory === category;
            const matchBrand = brand === 'all' || cardBrand === brand;

            if (matchKeyword && matchCategory && matchBrand) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function setProductPage(page) {
        currentProductPage = page;
        document.querySelectorAll('.product-page-btn').forEach(btn => {
            btn.classList.remove('bg-primary', 'text-on-primary');
            btn.classList.add('text-on-surface');
        });

        const targetBtn = Array.from(document.querySelectorAll('.product-page-btn')).find(btn => btn.textContent.trim() == page);
        if (targetBtn) {
            targetBtn.classList.remove('text-on-surface');
            targetBtn.classList.add('bg-primary', 'text-on-primary');
        }

        alert('Switched to page ' + page + ' (mock pagination)');
    }

    function changeProductPage(direction) {
        if (direction === 'prev' && currentProductPage > 1) {
            setProductPage(currentProductPage - 1);
        } else if (direction === 'next' && currentProductPage < 12) {
            setProductPage(currentProductPage + 1);
        } else {
            alert('No more pages');
        }
    }