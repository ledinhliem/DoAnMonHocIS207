<?php
$items = $items ?? [];
$summary = $summary ?? [];
$checkoutData = $checkoutData ?? [];
$availablePromos = $availablePromos ?? [];
$errors = $errors ?? [];
$success = $success ?? '';
$error = $error ?? '';
$appliedPromoCode = $summary['promo']['code'] ?? '';

// Kiểm tra xem user đã có đủ thông tin nhận hàng cơ bản chưa
$hasFullInfo = (
    !empty($checkoutData['full_name']) &&
    !empty($checkoutData['phone']) &&
    !empty($checkoutData['address']) &&
    !empty($checkoutData['email']) &&
    filter_var($checkoutData['email'], FILTER_VALIDATE_EMAIL)
);
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <h1 class="text-4xl font-black font-headline text-primary mb-8">Thanh toán</h1>

    <?php if (!empty($success)): ?>
        <div class="mb-6 rounded-2xl bg-green-100 text-green-800 px-5 py-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="mb-6 rounded-2xl bg-red-100 text-red-800 px-5 py-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden">
                <button type="button" id="openVoucherModal" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left hover:bg-surface-container transition-colors">
                    <span class="text-xl font-bold text-on-surface">Voucher của Shop</span>
                    <span class="flex items-center gap-2 text-on-surface-variant">
                        <?php if (!empty($summary['promo']['code'])): ?>
                            <span class="rounded-lg bg-primary/10 px-3 py-1 text-sm font-bold text-primary">
                                <?= htmlspecialchars($summary['promo']['code']) ?>
                            </span>
                        <?php else: ?>
                            <span class="text-lg text-on-surface-variant/70">Chọn hoặc nhập mã</span>
                        <?php endif; ?>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </span>
                </button>
            </div>

            <div id="voucherModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-4 py-8">
                <form method="POST" action="?url=order/apply-promo" id="promo-form" class="w-full max-w-3xl max-h-[86vh] overflow-y-auto bg-white rounded-3xl border border-outline-variant/30 p-6 shadow-2xl">
                
                <input type="hidden" name="promo_code" id="actual_promo_code" value="">

                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <h2 class="text-2xl font-black text-primary">Voucher của Shop</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Chọn voucher có sẵn hoặc nhập mã riêng của bạn.</p>
                    </div>
                    <button type="button" id="closeVoucherModal" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center hover:bg-surface-container-high transition-colors" aria-label="Đóng">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="flex justify-between items-end mb-4">
                    <h3 class="text-xl font-bold">🎟️ Mã dành riêng cho bạn</h3>
                    <?php if (!empty($summary['promo']['code'])): ?>
                        <button type="button" onclick="document.getElementById('actual_promo_code').value=''; document.getElementById('promo-form').submit();" class="text-sm text-red-500 font-bold hover:underline">
                            ❌ Hủy mã đang dùng
                        </button>
                    <?php endif; ?>
                </div>

                <?php if (!empty($summary['promo']['code'])): ?>
                    <div class="mb-5 p-3 bg-green-50 rounded-xl flex items-center gap-2 text-green-700 border border-green-200 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm">
                            Đang áp dụng thành công mã:
                            <strong class="text-lg"><?= htmlspecialchars($summary['promo']['code']) ?></strong>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (empty($availablePromos)): ?>
                    <div class="mb-5 p-4 bg-yellow-50 rounded-xl border border-yellow-200 text-yellow-800">
                        Chưa có voucher phù hợp. Bạn có thể quay lại giỏ hàng hoặc trang chủ để chơi game nhận mã.
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php 
                    $appliedCode = $appliedPromoCode;
                    if (!empty($availablePromos)): 
                        foreach($availablePromos as $p): 
                            $code = $p['MaGiamGia'] ?? '';
                            $desc = $p['MoTa'] ?? 'Mã giảm giá áp dụng';
                            if ($code === 'FREESHIP') {
                                $desc = 'Miễn phí vận chuyển';
                            }
                            $exp = isset($p['NgayHetHan']) ? date('d/m/Y', strtotime($p['NgayHetHan'])) : '';
                            $isApplied = ($appliedCode === $code);
                    ?>
                        <div class="relative bg-white border-2 <?= $isApplied ? 'border-[#2b4c2b] bg-green-50' : 'border-dashed border-outline-variant hover:border-[#2b4c2b]' ?> rounded-xl p-4 flex flex-col justify-between transition-all duration-300 hover:shadow-md overflow-hidden group">
                            
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-gray-50 rounded-full border-r-2 border-dashed <?= $isApplied ? 'border-[#2b4c2b]' : 'border-outline-variant group-hover:border-[#2b4c2b]' ?> z-10 transition-colors"></div>
                            <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-gray-50 rounded-full border-l-2 border-dashed <?= $isApplied ? 'border-[#2b4c2b]' : 'border-outline-variant group-hover:border-[#2b4c2b]' ?> z-10 transition-colors"></div>

                            <div class="pl-3 relative z-20">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-[#2b4c2b]/10 text-[#2b4c2b] px-3 py-1 rounded-md text-sm font-extrabold uppercase tracking-wider">
                                        <?= htmlspecialchars($code) ?>
                                    </span>
                                </div>
                                <p class="text-sm font-bold text-gray-800 mb-1 leading-snug"><?= htmlspecialchars($desc) ?></p>
                                <p class="text-xs text-on-surface-variant font-medium mb-4">HSD: <?= htmlspecialchars($exp) ?></p>
                            </div>

                            <?php if ($isApplied): ?>
                                <button type="button" disabled class="relative z-20 w-full py-2.5 rounded-lg text-sm font-bold bg-[#2b4c2b] text-white cursor-not-allowed shadow-inner transition-colors">
                                    Đang sử dụng ✔
                                </button>
                            <?php else: ?>
                                <button type="button" onclick="document.getElementById('actual_promo_code').value='<?= htmlspecialchars($code) ?>'; document.getElementById('promo-form').submit();" class="relative z-20 w-full py-2.5 rounded-lg text-sm font-bold bg-[#2b4c2b]/10 text-[#2b4c2b] hover:bg-[#2b4c2b] hover:text-white transition-colors">
                                    Dùng ngay
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <p class="text-sm text-gray-500 italic col-span-2">Hiện chưa có mã giảm giá nào dành cho bạn.</p>
                    <?php endif; ?>
                </div>

                <div class="mt-6 pt-4 border-t border-outline-variant/30">
                    <p class="text-xs text-gray-500 mb-2">Bạn có mã giảm giá khác?</p>
                    <div class="flex gap-2">
                        <input type="text" id="manual_code" placeholder="Nhập mã vào đây..." class="flex-1 rounded-lg border border-outline-variant px-3 py-2 text-sm outline-none focus:border-primary uppercase">
                        <button type="button" onclick="document.getElementById('actual_promo_code').value = document.getElementById('manual_code').value; document.getElementById('promo-form').submit();" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-300 transition-colors">Áp dụng</button>
                    </div>
                </div>
                </form>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const voucherModal = document.getElementById('voucherModal');
                const openVoucherModal = document.getElementById('openVoucherModal');
                const closeVoucherModal = document.getElementById('closeVoucherModal');

                function openModal() {
                    voucherModal.classList.remove('hidden');
                    voucherModal.classList.add('flex');
                }

                function closeModal() {
                    voucherModal.classList.add('hidden');
                    voucherModal.classList.remove('flex');
                }

                openVoucherModal?.addEventListener('click', openModal);
                closeVoucherModal?.addEventListener('click', closeModal);
                voucherModal?.addEventListener('click', function (event) {
                    if (event.target === voucherModal) closeModal();
                });
            });
            </script>

            <form id="checkoutForm"
                  method="POST"
                  action="?url=order/payment"
                  class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5 shadow-sm">

                <h2 class="text-xl font-bold">Thông tin nhận hàng</h2>

                <?php if ($hasFullInfo): ?>
                    <div class="bg-green-50/50 rounded-xl border border-green-200 p-5">
                        <div class="space-y-3 text-sm">
                            <p><span class="font-semibold w-28 inline-block">Người nhận:</span> <?= htmlspecialchars($checkoutData['full_name']) ?></p>
                            <p><span class="font-semibold w-28 inline-block">Số điện thoại:</span> <?= htmlspecialchars($checkoutData['phone']) ?></p>
                            <p><span class="font-semibold w-28 inline-block">Email:</span> <?= htmlspecialchars($checkoutData['email'] ?? 'Không có') ?></p>
                            <p class="flex">
                                <span class="font-semibold w-28 shrink-0">Địa chỉ:</span> 
                                <span><?= htmlspecialchars($checkoutData['address']) ?></span>
                            </p>
                        </div>
                        
                        <input type="hidden" name="full_name" value="<?= htmlspecialchars($checkoutData['full_name']) ?>">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($checkoutData['email'] ?? '') ?>">
                        <input type="hidden" name="phone" value="<?= htmlspecialchars($checkoutData['phone']) ?>">
                        <input type="hidden" name="address" value="<?= htmlspecialchars($checkoutData['address']) ?>">
                        
                        <div class="mt-4 pt-4 border-t border-green-200/60">
                            <a href="?url=profile" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                Thay đổi thông tin trong Hồ sơ
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-4 mb-4">
                        <p class="text-sm text-yellow-800">Bạn chưa cập nhật đầy đủ thông tin giao hàng. Vui lòng điền phía dưới!</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Họ và tên</label>
                        <input type="text"
                               name="full_name"
                               value="<?= htmlspecialchars($checkoutData['full_name'] ?? '') ?>"
                               class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">

                        <?php if (!empty($errors['full_name'])): ?>
                            <p class="text-red-600 text-sm mt-1">
                                <?= htmlspecialchars($errors['full_name']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email"
                               name="email"
                               value="<?= htmlspecialchars($checkoutData['email'] ?? '') ?>"
                               class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">

                        <?php if (!empty($errors['email'])): ?>
                            <p class="text-red-600 text-sm mt-1">
                                <?= htmlspecialchars($errors['email']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Số điện thoại</label>
                        <input type="text"
                               name="phone"
                               value="<?= htmlspecialchars($checkoutData['phone'] ?? '') ?>"
                               class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">

                        <?php if (!empty($errors['phone'])): ?>
                            <p class="text-red-600 text-sm mt-1">
                                <?= htmlspecialchars($errors['phone']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Địa chỉ giao hàng (Số nhà, Phường/Xã, Quận/Huyện, Tỉnh/Thành)</label>
                        <textarea name="address"
                                  rows="3"
                                  class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"><?= htmlspecialchars($checkoutData['address'] ?? '') ?></textarea>

                        <?php if (!empty($errors['address'])): ?>
                            <p class="text-red-600 text-sm mt-1">
                                <?= htmlspecialchars($errors['address']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <hr class="border-outline-variant/30 my-6">

                <div>
                    <label class="block text-sm font-semibold mb-2">Phương thức giao hàng</label>
                    <select name="delivery_method"
                            class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">
                        <option value="standard" data-cost="15000" <?= (($checkoutData['delivery_method'] ?? 'standard') === 'standard') ? 'selected' : '' ?>>
                            Giao hàng tiêu chuẩn - 15.000₫
                        </option>
                        <option value="express" data-cost="30000" <?= (($checkoutData['delivery_method'] ?? '') === 'express') ? 'selected' : '' ?>>
                            Giao hàng nhanh - 30.000₫
                        </option>
                    </select>

                    <?php if (!empty($errors['delivery_method'])): ?>
                        <p class="text-red-600 text-sm mt-1">
                            <?= htmlspecialchars($errors['delivery_method']) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Phương thức thanh toán</label>
                    <select name="payment_method"
                            class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">
                        <option value="cod" <?= (($checkoutData['payment_method'] ?? 'cod') === 'cod') ? 'selected' : '' ?>>
                            Thanh toán khi nhận hàng
                        </option>
                        <option value="transfer" <?= (($checkoutData['payment_method'] ?? '') === 'transfer') ? 'selected' : '' ?>>
                            Chuyển khoản ngân hàng
                        </option>
                    </select>

                    <?php if (!empty($errors['payment_method'])): ?>
                        <p class="text-red-600 text-sm mt-1">
                            <?= htmlspecialchars($errors['payment_method']) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-outline-variant/30 items-center justify-between">
                    <a href="?url=cart"
                       class="text-on-surface-variant font-semibold hover:text-primary transition-colors order-2 sm:order-1">
                        &larr; Quay lại giỏ hàng
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-[#2b4c2b] to-[#407540] text-white font-bold text-lg hover:shadow-lg hover:-translate-y-1 transition-all duration-300 order-1 sm:order-2">
                        Tiếp tục thanh toán
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-surface-container rounded-2xl p-6 h-fit sticky top-6 shadow-sm">
            <h2 class="text-xl font-bold mb-4">Tóm tắt đơn hàng</h2>

            <div class="space-y-3 mb-6">
                <?php foreach ($items as $item): ?>
                    <?php
                        $name = $item['name'] ?? 'Sản phẩm';
                        $variant = $item['variant'] ?? '';
                        $price = (float)($item['price'] ?? 0);
                        $isFlashSale = !empty($item['is_flash_sale']);
                        $quantity = (int)($item['quantity'] ?? 1);
                    ?>

                    <div class="flex justify-between gap-4 text-sm">
                        <span>
                            <?= htmlspecialchars($name) ?> x <?= $quantity ?>
                            <?php if (!empty($variant)): ?>
                                <br>
                                <small class="text-on-surface-variant">
                                    <?= htmlspecialchars($variant) ?>
                                </small>
                            <?php endif; ?>
                        </span>

                        <span>
                            <?= number_format($price * $quantity, 0, ',', '.') ?>₫
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="space-y-2 border-t border-outline-variant/30 pt-4">
                <div class="flex justify-between">
                    <span>Tạm tính</span>
                    <span data-checkout-subtotal><?= number_format($summary['subtotal'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <?php if (!empty($appliedPromoCode)): ?>
                    <div class="flex justify-between">
                        <span>Mã giảm giá đã dùng</span>
                        <span class="font-semibold text-primary"><?= htmlspecialchars($appliedPromoCode) ?></span>
                    </div>
                <?php endif; ?>

                <div class="flex justify-between text-green-700">
                    <span>Giảm giá</span>
                    <span>- <span data-checkout-discount><?= number_format($summary['discount'] ?? 0, 0, ',', '.') ?>₫</span></span>
                </div>

                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span data-checkout-shipping data-free-shipping="<?= !empty($summary['promo']['free_shipping']) ? '1' : '0' ?>"><?= number_format($summary['shipping'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between font-bold text-primary text-xl pt-4 border-t border-outline-variant/30 mt-2">
                    <span>Tổng cộng</span>
                    <span data-checkout-total><?= number_format($summary['total'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>
            </div>

        </div>
    </div>
</main>
<script src="<?= BASE_URL ?>public/assets/js/order.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
