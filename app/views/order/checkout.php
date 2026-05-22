<?php
$items = $items ?? [];
$summary = $summary ?? [];
$checkoutData = $checkoutData ?? [];
$errors = $errors ?? [];
$success = $success ?? '';
$error = $error ?? '';

// Kiểm tra xem user đã có đủ thông tin nhận hàng cơ bản chưa
$hasFullInfo = (!empty($checkoutData['full_name']) && !empty($checkoutData['phone']) && !empty($checkoutData['address']));
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
            <form method="POST"
                  action="?url=order/payment"
                  class="bg-white rounded-2xl border border-outline-variant/30 p-6 space-y-5">

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
                            Thanh toán bằng thẻ tín dụng/ghi nợ
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

                <div class="flex gap-4 pt-2">
                    <a href="?url=cart"
                       class="px-5 py-3 rounded-xl border border-outline-variant font-semibold hover:bg-gray-50 transition-colors">
                        Quay lại giỏ hàng
                    </a>

                    <button type="submit"
                            class="flex-1 px-5 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary/90 transition-colors text-center">
                        Tiếp tục thanh toán
                    </button>
                </div>
            </form>

            <form method="POST"
                  action="?url=order/apply-promo"
                  class="bg-white rounded-2xl border border-outline-variant/30 p-6">

                <h2 class="text-xl font-bold mb-4">Mã giảm giá</h2>

                <div class="flex gap-3">
                    <input type="text"
                           name="promo_code"
                           placeholder="VD: ZENTROGREEN, EARTHDAY26, SAVEPLANET"
                           value="<?= htmlspecialchars($summary['promo']['code'] ?? '') ?>"
                           class="flex-1 rounded-xl border border-outline-variant bg-white px-4 py-3">

                    <button type="submit"
                            class="px-5 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary/90 transition-colors">
                        Áp dụng
                    </button>
                </div>

                <?php if (!empty($summary['promo']['code'])): ?>
                    <p class="text-sm text-green-700 mt-3">
                        Đang áp dụng mã:
                        <strong><?= htmlspecialchars($summary['promo']['code']) ?></strong>
                    </p>
                <?php endif; ?>
            </form>
        </div>

        <div class="bg-surface-container rounded-2xl p-6 h-fit sticky top-6">
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

                <div class="flex justify-between">
                    <span>Giảm giá</span>
                    <span>- <?= number_format($summary['discount'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span><?= number_format($summary['shipping'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>

                <div class="flex justify-between font-bold text-primary text-lg pt-2">
                    <span>Tổng cộng</span>
                    <span><?= number_format($summary['total'] ?? 0, 0, ',', '.') ?>₫</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>