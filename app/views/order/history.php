<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-7xl mx-auto px-8 py-12">
    <h1>Lịch sử đơn hàng</h1>
    <p>Xem lại các đơn hàng đã mua trước đây.</p>

    <section style="margin-top:24px;">
        <div style="border:1px solid #ccc; padding:16px; margin-bottom:16px;">
            <h3>Order #ZN-9042</h3>
            <p>Trạng thái: In-Transit</p>
            <p>Ngày đặt: October 24, 2024</p>
            <p>Tổng tiền: $64.50</p>
            <a href="<?= BASE_URL ?>?url=order/tracking">Track Order</a>
        </div>

        <div style="border:1px solid #ccc; padding:16px; margin-bottom:16px;">
            <h3>Order #ZN-8810</h3>
            <p>Trạng thái: Delivered</p>
            <p>Ngày đặt: September 12, 2024</p>
            <p>Tổng tiền: $128.00</p>
            <a href="<?= BASE_URL ?>?url=order/tracking">View Tracking</a>
        </div>

        <div style="border:1px solid #ccc; padding:16px; margin-bottom:16px;">
            <h3>Order #ZN-8754</h3>
            <p>Trạng thái: Delivered</p>
            <p>Ngày đặt: August 30, 2024</p>
            <p>Tổng tiền: $42.25</p>
            <a href="<?= BASE_URL ?>?url=order/tracking">View Tracking</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>