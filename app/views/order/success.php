<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <h1>Đặt hàng thành công</h1>
    <p>Đơn hàng <strong>#ZN-884210</strong> đã được xác nhận.</p>
    <p>Cảm ơn bạn đã lựa chọn lối sống bền vững hơn.</p>

    <section style="margin-top: 24px; border:1px solid #ccc; padding:16px;">
        <h3>Thông tin chuyển khoản</h3>
        <p><strong>Mã tham chiếu:</strong> ZN-REF-884210</p>
        <p><strong>Tên tài khoản:</strong> Zentro Sustainable Goods</p>
        <p><strong>Ngân hàng:</strong> EcoTrust Bank</p>
        <p><strong>Số tài khoản:</strong> 1234-5678-9012</p>
        <p><strong>Swift/BIC:</strong> ECOZUS33</p>
    </section>

    <div style="margin-top: 24px;">
        <a href="<?= BASE_URL ?>?url=order/tracking">Theo dõi đơn hàng</a>
        |
        <a href="<?= BASE_URL ?>?url=product">Tiếp tục mua sắm</a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>