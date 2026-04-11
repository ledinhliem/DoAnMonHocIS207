document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (!mainImage || thumbnails.length === 0) return;

    thumbnails.forEach(thumb => {
        const img = thumb.querySelector('img');
        const fullSrc = img.getAttribute('data-full');

        // 1. Xử lý Click để đổi ảnh
        thumb.addEventListener('click', function() {
            // Đổi src ảnh chính
            mainImage.src = fullSrc;

            // Cập nhật Border cho thumbnail đang chọn
            thumbnails.forEach(item => item.classList.remove('border-primary'));
            thumbnails.forEach(item => item.classList.add('border-transparent'));
            this.classList.remove('border-transparent');
            this.classList.add('border-primary');
        });

        // 2. Hiệu ứng Hover (Tùy chọn: đổi ảnh tạm thời hoặc chỉ hiệu ứng border)
        thumb.addEventListener('mouseenter', function() {
            this.style.opacity = "0.8";
        });

        thumb.addEventListener('mouseleave', function() {
            this.style.opacity = "1";
        });
    });

    // 3. Hiệu ứng Zoom nhẹ khi hover vào ảnh chính (đã thêm qua Tailwind class group-hover:scale-105)
    // Nếu bạn muốn làm kính lúp (Zoom chi tiết), cần thêm thư viện hoặc code phức tạp hơn.
});