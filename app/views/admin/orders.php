<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$keyword = $_GET['keyword'] ?? '';
$status  = $_GET['status'] ?? '';
$tab     = $_GET['tab'] ?? 'active';

$orderList = [];
if (isset($orders) && is_array($orders)) {
    $orderList = $orders;
} elseif (isset($data['orders']) && is_array($data['orders'])) {
    $orderList = $data['orders'];
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('orderValue')) {
    function orderValue($order, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($order[$key]) && $order[$key] !== '') {
                return $order[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('orderStatusBadge')) {
    function orderStatusBadge($status) {
        $status = strtolower(trim((string)$status));

        switch ($status) {
            case 'processing':
                return 'bg-secondary-container text-on-secondary-container';
            case 'pending':
                return 'bg-primary-container text-on-primary-container';
            case 'shipped':
                return 'bg-surface-container-highest text-on-surface-variant';
            case 'completed':
            case 'delivered':
                return 'bg-green-100 text-green-700';
            case 'cancelled':
            case 'canceled':
                return 'bg-red-100 text-red-700';
            default:
                return 'bg-surface-container-high text-on-surface';
        }
    }
}

$activeCount = 0;
$archivedCount = 0;

foreach ($orderList as $order) {
    $itemStatus = strtolower((string) orderValue($order, ['status'], ''));
    if (in_array($itemStatus, ['archived', 'completed', 'delivered', 'cancelled', 'canceled'], true)) {
        $archivedCount++;
    } else {
        $activeCount++;
    }
}
?>

<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] flex flex-col py-8 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] z-50">
    <div class="px-6 mb-10">
        <a href="/is207/index.php?url=admin/dashboard" class="block">
            <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
            <p class="text-xs text-[#191c18]/60 mt-1 uppercase tracking-widest font-semibold">Bộ quản trị xanh</p>
        </a>
    </div>

    <nav class="flex-grow space-y-1">
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1"
           href="/is207/index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium text-sm">Bảng điều khiển</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1"
           href="/is207/index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-medium text-sm">Kho hàng</span>
        </a>
    
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1"
           href="/is207/index.php?url=admin/products">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-medium text-sm">Sản phẩm</span>
        </a>
        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform"
           href="/is207/index.php?url=admin/orders">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-medium text-sm">Đơn hàng</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1"
           href="/is207/index.php?url=admin/reviews">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-medium text-sm">Đánh giá</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1"
           href="/is207/index.php?url=admin/blog">
            <span class="material-symbols-outlined">article</span>
            <span class="font-medium text-sm">Blog</span>
        </a>
      
    </nav>

    <div class="px-4 mt-auto">
        <button class="w-full bg-primary text-on-primary py-3 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity">
            Xuất báo cáo
        </button>
        <div class="mt-6 flex items-center gap-3 px-2">
            <img alt="Admin User Profile" class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCjjxf0bpVd1PEy-plVsvJuJYFgGGrAoI7qv2sZ8irZHnaLsAaFQ9n99Pcn6x9xlaF1PeCT8q_xAC-ZpAtXTUkXP-avaZ65A_DoAcu-Jh9F9IayrnQEFxulcpk4uZKs0nMeRzXvKdmaS-c_6olS1abOW3cgVrjlnE-l6IZjt7qKXTKgakIQAfPTAr_-Mte1lwyF6shvgZcaG6znrFLWB1n9VEfvuk2fPzDXKRihq6bG2SpDEZ-YPqkSDzTlfrEtFUd7ZU-LEgm_PZY"/>
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate">Alex Rivier</p>
                <p class="text-xs text-on-surface-variant/70 truncate">Quản lý vận hành</p>
            </div>
        </div>
    </div>
</aside>

<main class="ml-64 p-12 min-h-screen">
    <header class="mb-10">
        <div class="flex flex-col xl:flex-row justify-between gap-6 xl:items-end">
            <div>
                <h2 class="text-5xl font-black font-headline tracking-tighter text-primary mb-4">Hàng đợi đơn hàng</h2>
                <p class="text-lg text-on-surface-variant max-w-xl leading-relaxed">
                    Quản lý đơn hàng, theo dõi xử lý và chuẩn bị thao tác đơn hàng từ trang quản trị.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full xl:w-auto">
                <div class="bg-surface-container px-6 py-4 rounded-xl">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/50 mb-1">Displayed Đơn hàng</p>
                    <p class="text-2xl font-black font-headline text-primary"><?= count($orderList) ?></p>
                </div>
                <div class="bg-surface-container px-6 py-4 rounded-xl">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/50 mb-1">Đang xử lý</p>
                    <p class="text-2xl font-black font-headline text-primary"><?= $activeCount ?></p>
                </div>
                <div class="bg-surface-container px-6 py-4 rounded-xl">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/50 mb-1">Archived</p>
                    <p class="text-2xl font-black font-headline text-primary"><?= $archivedCount ?></p>
                </div>
            </div>
        </div>
    </header>

    <section class="grid grid-cols-12 gap-8 mb-12">
        <div class="col-span-12 lg:col-span-8">
            <section class="bg-surface-container-low rounded-xl p-6 mb-6 shadow-sm">
                <form method="GET" action="" class="flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
                    <div class="flex flex-wrap gap-3">
                        <a href="?tab=active"
                           class="px-6 py-2 <?= $tab === 'active' ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant' ?> rounded-full text-sm font-semibold transition-colors">
                            Đang xử lý Đơn hàng (<?= $activeCount ?>)
                        </a>

                        <a href="?tab=archived"
                           class="px-6 py-2 <?= $tab === 'archived' ? 'bg-primary text-on-primary' : 'bg-surface-container text-on-surface-variant' ?> rounded-full text-sm font-semibold transition-colors">
                            Archived (<?= $archivedCount ?>)
                        </a>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/40">search</span>
                            <input
                                class="pl-10 pr-4 py-2 bg-surface-container border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20 w-full sm:w-72 transition-all"
                                placeholder="Tìm kiếm order ID or customer..."
                                type="text"
                                name="keyword"
                                value="<?= e($keyword) ?>"
                            />
                        </div>

                        <select name="status" class="px-4 py-2 bg-surface-container border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20">
                            <option value="">All Status</option>
                            <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $status === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>

                        <input type="hidden" name="tab" value="<?= e($tab) ?>">

                        <button type="submit" class="px-5 py-2 bg-primary text-on-primary rounded-lg text-sm font-bold hover:opacity-90 transition-opacity">
                            Áp dụng
                        </button>
                    </div>
                </form>
            </section>

            <div class="space-y-4">
                <?php if (!empty($orderList)): ?>
                    <?php foreach ($orderList as $order): ?>
                        <?php
                        $orderId = orderValue($order, ['order_code', 'code', 'order_id', 'id'], '—');
                        $orderStatus = orderValue($order, ['status'], 'Pending');
                        $productName = orderValue($order, ['product_name', 'title', 'name'], 'Order item');
                        $customerName = orderValue($order, ['customer_name', 'customer', 'buyer_name', 'full_name'], 'Customer');
                        $itemCount = orderValue($order, ['item_count', 'quantity', 'items'], '—');
                        $amount = orderValue($order, ['total', 'amount', 'price'], 0);
                        $tracking = orderValue($order, ['tracking_code', 'tracking'], '');
                        $image = orderValue($order, ['image', 'image_url', 'thumbnail'], '');
                        ?>

                        <div class="bg-surface-container-lowest p-6 rounded-xl group transition-all hover:bg-white border border-transparent hover:border-outline-variant/20 shadow-sm">
                            <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6">
                                <div class="flex gap-6">
                                    <div class="w-20 h-20 bg-surface-container rounded-lg overflow-hidden flex-shrink-0">
                                        <?php if ($image !== ''): ?>
                                            <img alt="<?= e($productName) ?>" class="w-full h-full object-cover" src="<?= e($image) ?>">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/40">
                                                <span class="material-symbols-outlined text-3xl">shopping_bag</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-3 mb-1">
                                            <span class="text-[10px] font-bold tracking-widest text-on-surface-variant/40 uppercase">
                                                #<?= e($orderId) ?>
                                            </span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase <?= orderStatusBadge($orderStatus) ?>">
                                                <?= e($orderStatus) ?>
                                            </span>
                                        </div>
                                        <h3 class="text-xl font-bold font-headline text-on-surface"><?= e($productName) ?></h3>
                                        <p class="text-sm text-on-surface-variant mt-1">
                                            Ordered by <span class="font-semibold text-primary"><?= e($customerName) ?></span>
                                            <?php if ($itemCount !== '—'): ?>
                                                • <?= e($itemCount) ?> item(s)
                                            <?php endif; ?>
                                        </p>
                                        <?php if ($tracking !== ''): ?>
                                            <p class="text-xs text-on-surface-variant mt-2">Theo dõiing: <?= e($tracking) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-xl font-bold font-headline mb-2">
                                        <?= is_numeric($amount) ? number_format((float)$amount, 0, ',', '.') . ' đ' : e($amount) ?>
                                    </p>
                                    <div class="flex gap-2 justify-end">
                                        <button type="button" class="p-2 text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors">
                                            <span class="material-symbols-outlined">print</span>
                                        </button>
                                        <button type="button" class="bg-primary px-4 py-2 text-on-primary rounded-lg text-sm font-bold flex items-center gap-2 hover:opacity-90">
                                            Update Status <span class="material-symbols-outlined text-sm">arrow_forward_ios</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-surface-container-lowest p-12 rounded-xl shadow-sm text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant/50">
                            <span class="material-symbols-outlined text-3xl">shopping_basket</span>
                        </div>
                        <h3 class="text-2xl font-bold text-on-surface mb-2">Không tìm thấy đơn hàng</h3>
                        <p class="text-on-surface-variant">
                            There is no order data to display yet, or your current search/filter returned no results.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <aside class="col-span-12 lg:col-span-4 space-y-8">
            <div class="bg-surface-container p-8 rounded-2xl">
                <h4 class="font-headline font-bold text-xl mb-6">Fulfillment Overview</h4>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-medium">Order Visibility</span>
                            <span class="font-bold"><?= count($orderList) > 0 ? '100%' : '0%' ?></span>
                        </div>
                        <div class="h-2 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: <?= count($orderList) > 0 ? '100%' : '0%' ?>;"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-surface-container-lowest p-4 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant/50 mb-1 tracking-widest">Pending / Processing</p>
                            <p class="text-2xl font-black font-headline text-primary">
                                <?=
                                count(array_filter($orderList, function ($order) {
                                    $s = strtolower((string) orderValue($order, ['status'], ''));
                                    return in_array($s, ['pending', 'processing'], true);
                                }))
                                ?>
                            </p>
                        </div>
                        <div class="bg-surface-container-lowest p-4 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-on-surface-variant/50 mb-1 tracking-widest">Completed / Archived</p>
                            <p class="text-2xl font-black font-headline text-primary"><?= $archivedCount ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-primary text-on-primary p-8 rounded-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-headline font-bold text-xl mb-2">Order Note</h4>
                    <p class="text-sm opacity-80 mb-6 leading-relaxed">
                        Use this panel later for stock warnings, delivery alerts, or quick fulfillment actions when backend logic is added.
                    </p>
                    <button class="w-full bg-surface-container-lowest text-primary py-3 rounded-xl font-bold text-sm hover:scale-105 transition-transform">
                        Review Đơn hàng
                    </button>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-10">
                    <span class="material-symbols-outlined text-9xl">receipt_long</span>
                </div>
            </div>

            <div class="p-6 border border-outline-variant/30 rounded-2xl">
                <h4 class="font-headline font-bold text-lg mb-4">Bộ lọc hiện tại</h4>
                <ul class="space-y-4">
                    <li class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Tab</span>
                        <span class="font-bold text-on-surface"><?= e(ucfirst($tab)) ?></span>
                    </li>
                    <li class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Keyword</span>
                        <span class="font-bold text-on-surface"><?= $keyword !== '' ? e($keyword) : '—' ?></span>
                    </li>
                    <li class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Status</span>
                        <span class="font-bold text-on-surface"><?= $status !== '' ? e(ucfirst($status)) : 'All' ?></span>
                    </li>
                </ul>
            </div>
        </aside>
    </section>

    <footer class="mt-20 pt-16 border-t border-[#c5c8ba]/10 flex flex-col md:flex-row justify-between items-center px-4 pb-12">
        <div class="mb-4 md:mb-0">
            <span class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</span>
            <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-2">
                © 2026 Zentro Sustainable Living. Admin panel.
            </p>
        </div>
        <div class="flex gap-8">
            <a class="text-[#191c18]/50 text-sm hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Chính sách bảo mật</a>
            <a class="text-[#191c18]/50 text-sm hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Điều khoản dịch vụ</a>
            <a class="text-[#191c18]/50 text-sm hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Phí vận chuyển &amp; Returns</a>
            <a class="text-[#191c18]/50 text-sm hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Liên hệ</a>
        </div>
    </footer>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>

