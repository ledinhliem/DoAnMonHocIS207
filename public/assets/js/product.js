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

    // XỬ LÝ CHỌN BIẾN THỂ (SIZE/MÀU) 
    const variants = window.productVariants || [];

    let selectedColor = variants.length > 0 ? variants[0].MauSac : null;
    let selectedSize = variants.length > 0 ? variants[0].KichThuoc : null;

    const variantBtns = document.querySelectorAll('.variant-btn');
    const priceDisplay = document.getElementById('display-price');
    const variantInput = document.getElementById('selected-variant-id');

    function updateVariantUI() {
        // B1: Cập nhật trạng thái hiển thị của các nút bấm
        variantBtns.forEach(btn => {
            const type = btn.getAttribute('data-type');
            const val = btn.getAttribute('data-value');
            
            // Highlight nút nếu khớp với giá trị đang chọn
            if ((type === 'MauSac' && val === selectedColor) || (type === 'KichThuoc' && val === selectedSize)) {
                btn.classList.add('bg-primary', 'text-white', 'border-primary');
                btn.classList.remove('border-outline-variant');
            } else {
                btn.classList.remove('bg-primary', 'text-white', 'border-primary');
                btn.classList.add('border-outline-variant');
            }
        });

        // B2: Tìm biến thể khớp với cả Màu và Size đã chọn trong mảng dữ liệu
        const match = variants.find(v => v.MauSac === selectedColor && v.KichThuoc === selectedSize);
        
        if (match) {
            // Cập nhật giá hiển thị trên giao diện
            if (priceDisplay) {
                const formattedPrice = new Intl.NumberFormat('vi-VN').format(match.GiaTien);
                priceDisplay.innerText = `${formattedPrice} VNĐ`;
            }
            
            // Cập nhật mã biến thể vào input ẩn để gửi đi khi thêm vào giỏ hàng
            if (variantInput) {
                variantInput.value = match.MaBienThe;
            }
        }
    }

    // Gán sự kiện click cho tất cả các nút Màu và Size
    variantBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const value = this.getAttribute('data-value');

            if (type === 'MauSac') selectedColor = value;
            if (type === 'KichThuoc') selectedSize = value;

            updateVariantUI();
        });
    });

    // Gọi hàm lần đầu để thiết lập trạng thái mặc định
    if (variants.length > 0) {
        updateVariantUI();
    }
});