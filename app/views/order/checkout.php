<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <h1>Thanh toán</h1>
    <p>Nhập thông tin giao hàng và xác nhận đơn hàng.</p>

    <form style="margin-top:24px;">
        <fieldset style="margin-bottom:24px;">
            <legend><strong>Thông tin liên hệ</strong></legend>
            <p>Email</p>
            <input type="email" placeholder="Email Address" style="width:100%; padding:8px; margin-bottom:12px;">
        </fieldset>

        <fieldset style="margin-bottom:24px;">
            <legend><strong>Địa chỉ giao hàng</strong></legend>
            <input type="text" placeholder="First Name" style="width:100%; padding:8px; margin-bottom:12px;">
            <input type="text" placeholder="Last Name" style="width:100%; padding:8px; margin-bottom:12px;">
            <input type="text" placeholder="Street Address" style="width:100%; padding:8px; margin-bottom:12px;">
            <input type="text" placeholder="City" style="width:100%; padding:8px; margin-bottom:12px;">
            <input type="text" placeholder="Postal Code" style="width:100%; padding:8px; margin-bottom:12px;">
        </fieldset>

        <fieldset style="margin-bottom:24px;">
            <legend><strong>Phương thức giao hàng</strong></legend>
            <label>
                <input type="radio" name="shipping" checked>
                Carbon Neutral Standard - Free
            </label>
            <br>
            <label>
                <input type="radio" name="shipping">
                Zero-Waste Express - $12.00
            </label>
        </fieldset>
    </form>

    <section style="margin-top: 24px; border-top:1px solid #ccc; padding-top:16px;">
        <h3>Tóm tắt đơn hàng</h3>
        <p>Woven Moss Throw x1 - $85.00</p>
        <p>Recycled Glass Jar x2 - $48.00</p>
        <p><strong>Tổng cộng:</strong> $143.64</p>
    </section>

    <div style="margin-top: 24px;">
        <a href="<?= BASE_URL ?>?url=order/success">Tiếp tục thanh toán</a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>