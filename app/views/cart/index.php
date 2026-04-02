<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <h1>Giỏ hàng</h1>
    <p>Kiểm tra sản phẩm trước khi sang bước thanh toán.</p>

    <section style="margin-top: 24px;">
        <div style="border:1px solid #ccc; padding:16px; margin-bottom:16px;">
            <h3>Honed Stone Pitcher</h3>
            <p>Phân loại: Sandstone Grey</p>
            <p>Số lượng: 1</p>
            <p>Giá: $84.00</p>
        </div>

        <div style="border:1px solid #ccc; padding:16px; margin-bottom:16px;">
            <h3>Woven Linen Throw</h3>
            <p>Phân loại: Moss &amp; Earth</p>
            <p>Số lượng: 2</p>
            <p>Giá: $156.00</p>
        </div>
    </section>

    <section style="margin-top: 24px; border-top:1px solid #ccc; padding-top:16px;">
        <p><strong>Tạm tính:</strong> $240.00</p>
        <p><strong>Vận chuyển:</strong> Free</p>
        <p><strong>Tổng cộng:</strong> $240.00</p>
    </section>

    <div style="margin-top: 24px;">
        <a href="<?= BASE_URL ?>?url=order/checkout">Tiến hành thanh toán</a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>