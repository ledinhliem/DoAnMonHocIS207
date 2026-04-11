// Blog page JavaScript
document.addEventListener('DOMContentLoaded', function () {
    console.log('Blog page loaded');

    // Handle blog card clicks
    const blogCards = document.querySelectorAll('.blog-card');
    blogCards.forEach(card => {
        card.addEventListener('click', function (e) {
            const blogId = this.getAttribute('data-blog-id');
            if (blogId) {
                window.location.href = `<?= BASE_URL ?>?url=blog/detail&id=${blogId}`;
            }
        });
    });

    // Handle category filter buttons
    const categoryButtons = document.querySelectorAll('.category-btn');
    categoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const category = this.getAttribute('data-category');
            console.log('Category filter:', category);
            // Mock category filter functionality
            filterBlogsByCategory(category);
        });
    });
});

// Mock function to filter blogs by category
function filterBlogsByCategory(category) {
    console.log('Filtering blogs by category:', category);
    // In a real implementation, this would fetch filtered blogs from the server
    // For now, it's just a placeholder
}