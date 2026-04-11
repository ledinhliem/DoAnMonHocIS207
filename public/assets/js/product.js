// Product page JavaScript
document.addEventListener('DOMContentLoaded', function () {
    console.log('Product page loaded');

    const clickableItems = document.querySelectorAll('[onclick*="window.location.href"]');

    clickableItems.forEach(item => {
        item.addEventListener('click', function (e) {
            if (e.target.closest('button')) return;

            const onclickValue = this.getAttribute('onclick');

            if (onclickValue) {
                const match = onclickValue.match(/'(.*?)'/);
                if (match && match[1]) {
                    window.location.href = match[1];
                }
            }
        });
    });

    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            this.classList.toggle('active');
            console.log('Filter toggled:', this.textContent);
            updateProductDisplay();
        });
    });

    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            console.log('Sort changed to:', this.value);
            updateProductDisplay();
        });
    }

    const priceRange = document.querySelector('.price-range');
    if (priceRange) {
        priceRange.addEventListener('input', function () {
            console.log('Price range changed to:', this.value);
            updateProductDisplay();
        });
    }
});

function addToCart(productId) {
    console.log('Adding product to cart:', productId);
    alert('Product added to cart! (Mock functionality)');
}

function updateProductDisplay() {
    console.log('Updating product display based on filters');
}