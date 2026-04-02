<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <h1>Hồ sơ cá nhân</h1>
    <p>Quản lý thông tin tài khoản và địa chỉ đã lưu.</p>

    <section style="margin-top:24px; border:1px solid #ccc; padding:16px; margin-bottom:24px;">
        <h2>Thông tin cá nhân</h2>
        <p><strong>Họ tên:</strong> Elena Green</p>
        <p><strong>Email:</strong> elena.green@zentroliving.com</p>
        <p><strong>Số điện thoại:</strong> +1 (555) 234-8910</p>
        <p><strong>Huy hiệu bền vững:</strong> Eco-Guardian</p>
    </section>

    <section style="margin-top:24px; border:1px solid #ccc; padding:16px; margin-bottom:24px;">
        <h2>Địa chỉ đã lưu</h2>
        <div style="margin-bottom:16px;">
            <h3>Home Sanctuary</h3>
            <p>1248 Oakwood Avenue, Sustainable Meadows, OR 97205, United States</p>
        </div>

        <div>
            <h3>Zentro Workshop</h3>
            <p>45 Design Quarter St., Loft 4B, Portland, OR 97209, United States</p>
        </div>
    </section>

    <div style="margin-top: 24px;">
        <a href="<?= BASE_URL ?>?url=order/history">Xem lịch sử đơn hàng</a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>