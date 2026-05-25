<?php
$items = $items ?? [];
$summary = $summary ?? [];
$checkoutData = $checkoutData ?? [];
$availablePromos = $availablePromos ?? [];
$errors = $errors ?? [];
$success = $success ?? '';
$error = $error ?? '';
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

            <form method="POST" action="?url=order/apply-promo" id="promo-form" class="bg-white rounded-2xl border border-outline-variant/30 p-6 shadow-sm">
                
                <input type="hidden" name="promo_code" id="actual_promo_code" value="">

                <div class="flex justify-between items-end mb-4">
                    <h2 class="text-xl font-bold">🎟️ Mã dành riêng cho bạn</h2>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php 
                    $appliedCode = $summary['promo']['code'] ?? '';
                    if (!empty($availablePromos)): 
                        foreach($availablePromos as $p): 
                            $code = $p['MaGiamGia'] ?? '';
                            $desc = $p['MoTa'] ?? 'Mã giảm giá áp dụng';
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

            <form method="POST"
                  action="?url=order/payment"
                  class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5 shadow-sm">

                <h2 class="text-xl font-bold">Thông tin nhận hàng</h2>

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
                    <label class="block text-sm font-semibold mb-2">Địa chỉ giao hàng</label>
                    <textarea name="address"
                              rows="3"
                              class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3"><?= htmlspecialchars($checkoutData['address'] ?? '') ?></textarea>

                    <?php if (!empty($errors['address'])): ?>
                        <p class="text-red-600 text-sm mt-1">
                            <?= htmlspecialchars($errors['address']) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Phương thức giao hàng</label>
                    <select name="delivery_method"
                            class="w-full rounded-xl border border-outline-variant bg-white px-4 py-3">
                        <option value="standard" <?= (($checkoutData['delivery_method'] ?? 'standard') === 'standard') ? 'selected' : '' ?>>
                            Giao hàng tiêu chuẩn - 15.000₫
                        </option>
                        <option value="express" <?= (($checkoutData['delivery_method'] ?? '') === 'express') ? 'selected' : '' ?>>
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
                        <option value="card" <?= (($checkoutData['payment_method'] ?? 'card') === 'card') ? 'selected' : '' ?>>
                            Thanh toán bằng thẻ tín dụng
                        </option>
                        <option value="cod" <?= (($checkoutData['payment_method'] ?? '') === 'cod') ? 'selected' : '' ?>>
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

        <div class="bg-surface-container rounded-2xl p-6 h-fit shadow-sm">
            <h2 class="text-xl font-bold mb-4">Tóm tắt đơn hàng</h2>

            <div class="space-y-3 mb-6">
                <?php foreach ($items as $item): ?>
                    <?php
                        $name = $item['name'] ?? 'Sản phẩm';
                        $variant = $item['variant'] ?? '';
                        $price = (float)($item['price'] ?? 0);
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
                    <span><?= number_format($summary['subtotal'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between text-green-700">
                    <span>Giảm giá</span>
                    <span>- <?= number_format($summary['discount'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span><?= number_format($summary['shipping'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between font-bold text-primary text-xl pt-4 border-t border-outline-variant/30 mt-2">
                    <span>Tổng cộng</span>
                    <span><?= number_format($summary['total'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>