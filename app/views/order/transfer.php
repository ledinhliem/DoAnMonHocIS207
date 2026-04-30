<?php $title = 'Chuyển khoản ngân hàng'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-5xl mx-auto px-6 md:px-8 py-12 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl p-8 border border-outline-variant/20">
            <h1 class="text-4xl font-headline font-extrabold text-primary mb-4">Chuyển khoản ngân hàng</h1>
            <p class="text-on-surface-variant mb-8">Vui lòng chuyển khoản theo thông tin bên dưới.</p>

            <div class="space-y-5">
                <div>
                    <p class="text-sm text-on-surface-variant">Bank</p>
                    <p class="font-bold text-lg">Vietcombank</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant">Account Name</p>
                    <p class="font-bold text-lg">ZENTRO SUSTAINABLE SHOP</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant">Account Number</p>
                    <p class="font-bold text-lg">0123456789</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant">Nội dung chuyển khoản</p>
                    <p class="font-bold text-lg">ZN884210</p>
                </div>
                <div>
                    <p class="text-sm text-on-surface-variant">Amount</p>
                    <p class="font-bold text-lg text-primary">$143.64</p>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-low rounded-2xl p-8 border border-outline-variant/20">
            <h2 class="text-2xl font-headline font-bold mb-4">Sau khi chuyển khoản</h2>
            <p class="text-on-surface-variant mb-6">Sau khi chuyển khoản xong, hãy tiếp tục để xác nhận phản hồi.</p>

            <div class="space-y-4">
                <a href="<?= BASE_URL ?>?url=order/feedback" class="block text-center bg-primary text-white px-6 py-4 rounded-lg font-bold">
                    Tôi đã chuyển khoản
                </a>
                <a href="<?= BASE_URL ?>?url=checkout" class="block text-center border border-outline-variant/30 px-6 py-4 rounded-lg font-bold">
                    Quay lại thanh toán
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>