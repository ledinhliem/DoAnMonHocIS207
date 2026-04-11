document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (!mainImage || thumbnails.length === 0) return;

    thumbnails.forEach(thumb => {
        const img = thumb.querySelector('img');
        const fullSrc = img.getAttribute('data-full');

        // Xử lý Click để đổi ảnh
        thumb.addEventListener('click', function () {
            // Đổi src ảnh chính
            mainImage.src = fullSrc;

            // Cập nhật Border cho thumbnail đang chọn
            thumbnails.forEach(item => item.classList.remove('border-primary'));
            thumbnails.forEach(item => item.classList.add('border-transparent'));
            this.classList.remove('border-transparent');
            this.classList.add('border-primary');
        });

        // Hiệu ứng Hover (Tùy chọn: đổi ảnh tạm thời hoặc chỉ hiệu ứng border)
        thumb.addEventListener('mouseenter', function () {
            this.style.opacity = "0.8";
        });

        thumb.addEventListener('mouseleave', function () {
            this.style.opacity = "1";
        });
    });

    // XỬ LÝ CHUYỂN TAB MÔ TẢ / ĐÁNH GIÁ
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Lấy id của tab cần hiển thị (description hoặc reviews)
            const target = btn.getAttribute('data-tab');

            // Xử lý đổi trạng thái Active của Button
            tabBtns.forEach(b => {
                // Xóa trạng thái active cũ
                b.classList.remove('border-primary', 'text-primary');
                b.classList.add('border-transparent', 'text-outline');
            });
            // Thêm trạng thái active cho nút vừa click
            btn.classList.add('border-primary', 'text-primary');
            btn.classList.remove('border-transparent', 'text-outline');

            //Xử lý ẩn/hiện nội dung Tab
            tabContents.forEach(content => {
                if (content.id === target) {
                    content.classList.remove('hidden');
                    content.classList.add('block');
                } else {
                    content.classList.remove('block');
                    content.classList.add('hidden');
                }
            });
        });
    });
});