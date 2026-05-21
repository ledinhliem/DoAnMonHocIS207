// Home page JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Add any home-specific functionality here
    console.log('Home page loaded');

    // Handle banner CTA clicks
    const bannerButtons = document.querySelectorAll('.banner-cta');
    bannerButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });
    });

    // Handle product card clicks
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function (e) {
            if (!e.target.closest('.add-to-cart-btn')) {
                const productId = this.getAttribute('data-product-id');
                if (productId) {
                    window.location.href = `index.php?url=product/detail&id=${productId}`;
                }
            }
        });
    });
});

// Function to add product to cart
function addToCart(productId) {
    // Mock add to cart functionality
    console.log('Adding product to cart:', productId);
    // You can implement actual cart functionality here
    alert('Product added to cart! (Mock functionality)');
}