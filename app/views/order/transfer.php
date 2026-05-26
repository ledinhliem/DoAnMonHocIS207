<?php $title = 'Chuyển khoản ngân hàng'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="max-w-7xl mx-auto px-6 md:px-8 py-12 md:py-16">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-3xl p-8 lg:p-12 border border-outline-variant/20 shadow-sm">
            <h1 class="text-4xl font-headline font-extrabold text-primary mb-4">Chuyển khoản ngân hàng</h1>
            <p class="text-on-surface-variant mb-10 text-lg">Vui lòng quét mã QR hoặc chuyển khoản thủ công theo thông tin bên dưới.</p>

            <div class="flex flex-col md:flex-row gap-12 items-center">
                <div class="space-y-6 flex-1 w-full">
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Ngân hàng (Bank)</p>
                        <p class="font-bold text-xl">MBBank</p>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Chủ tài khoản (Account Name)</p>
                        <p class="font-bold text-xl">NGUY TRONG PHUC</p>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Số tài khoản (Account Number)</p>
                        <p class="font-bold text-2xl text-gray-800">0769509303</p>
                    </div>
                    <div>
                        <p class="text-sm text-on-surface-variant mb-1">Nội dung (Message)</p>
                        <p class="font-bold text-2xl text-gray-800"><?= htmlspecialchars($orderCode ?? 'ZN884210') ?></p>
                    </div>
                    <div class="pt-2">
                        <p class="text-sm text-on-surface-variant mb-1">Số tiền (Amount)</p>
                        <p class="font-bold text-4xl text-primary"><?= number_format($totalAmount ?? 0, 0, ',', '.') ?> ₫</p>
                    </div>
                </div>

                <div class="flex-1 w-full flex flex-col items-center justify-center p-6 border-t md:border-t-0 md:border-l border-outline-variant/20">
                    <p class="text-base font-bold text-on-surface-variant mb-6 text-center">Quét mã để thanh toán nhanh</p>

                    <img src="<?= htmlspecialchars($qrUrl ?? '') ?>"
                        alt="Mã QR VietQR"
                        class="w-64 lg:w-80 h-auto object-contain p-2 bg-white rounded-2xl shadow-md border border-outline-variant/20">

                    <p class="mt-6 text-sm text-gray-500 text-center">Mã QR được tự động tạo theo đơn hàng của bạn.</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 bg-surface-container-low rounded-3xl p-8 border border-outline-variant/20 h-fit shadow-sm">
            <h2 class="text-2xl font-headline font-bold mb-4">Sau khi chuyển khoản</h2>
            <p class="text-on-surface-variant mb-8 leading-relaxed">Sau khi chuyển khoản xong, hãy tiếp tục để hệ thống xác nhận đơn hàng của bạn.</p>

            <div class="space-y-4">
                <a href="<?= BASE_URL ?? '' ?>?url=order/feedback" class="block text-center bg-primary text-white px-6 py-4 rounded-xl font-bold hover:bg-[#1e361e] transition-colors hover:shadow-lg hover:-translate-y-0.5 duration-300">
                    Tôi đã chuyển khoản
                </a>
                <a href="<?= BASE_URL ?? '' ?>?url=checkout" class="block text-center border-2 border-outline-variant/30 px-6 py-4 rounded-xl font-bold hover:bg-white transition-colors duration-300">
                    Quay lại thanh toán
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>