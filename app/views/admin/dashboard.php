<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$totalRevenue = $data['totalRevenue'] ?? $total_revenue ?? 0;
$activeOrders = $data['activeOrders'] ?? $active_orders ?? 0;
$totalProducts = $data['totalProducts'] ?? $total_products ?? 0;
$totalReviews = $data['totalReviews'] ?? $total_reviews ?? 0;
$publishedPosts = $data['publishedPosts'] ?? $published_posts ?? 0;
$pendingReviews = $data['pendingReviews'] ?? $pending_reviews ?? 0;

$promotions = [];
if (isset($data['promotions']) && is_array($data['promotions'])) {
    $promotions = $data['promotions'];
} elseif (isset($promotions) && is_array($promotions)) {
    $promotions = $promotions;
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('promotionValue')) {
    function promotionValue($promotion, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($promotion[$key]) && $promotion[$key] !== '') {
                return $promotion[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('formatMoneyVND')) {
    function formatMoneyVND($value) {
        if (!is_numeric($value)) return e($value);
        return number_format((float)$value, 0, ',', '.') . ' đ';
    }
}

if (!function_exists('promotionStatusBadge')) {
    function promotionStatusBadge($status) {
        $status = strtolower(trim((string)$status));
        switch ($status) {
            case 'active':
                return 'text-[10px] font-bold tracking-widest text-primary bg-primary-fixed-dim/20 px-2 py-1 rounded uppercase';
            case 'scheduled':
                return 'text-[10px] font-bold tracking-widest text-on-surface/40 bg-surface-variant px-2 py-1 rounded uppercase';
            case 'expired':
                return 'text-[10px] font-bold tracking-widest text-red-700 bg-red-100 px-2 py-1 rounded uppercase';
            default:
                return 'text-[10px] font-bold tracking-widest text-on-surface/40 bg-surface-variant px-2 py-1 rounded uppercase';
        }
    }
}
?>

<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-50">
    <div class="px-6 mb-10">
        <a href="/is207/index.php?url=admin/dashboard" class="block">
            <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
            <p class="font-['Be_Vietnam_Pro'] font-medium text-xs text-[#191c18]/60 uppercase tracking-widest mt-1">Bộ quản trị xanh</p>
        </a>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto">
        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform"
           href="/is207/index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Bảng điều khiển</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Kho hàng</span>
        </a>
      
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/products">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Sản phẩm</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/orders">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Đơn hàng</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/reviews">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Đánh giá</span>
        </a>
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/blog">
            <span class="material-symbols-outlined">article</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Blog</span>
        </a>
     
    </nav>

    <div class="px-4 mt-auto">
        <button class="w-full py-3 bg-primary text-white rounded-lg font-['Be_Vietnam_Pro'] font-semibold text-sm shadow-md hover:bg-primary-container transition-colors duration-300">
            Xuất báo cáo
        </button>
        <div class="flex items-center gap-3 mt-8 p-2 border-t border-[#c5c8ba]/20 pt-6">
            <div class="w-10 h-10 rounded-full bg-primary-fixed-dim overflow-hidden">
                <img alt="Admin User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbrN5cn3E-UDob9IZLUL-pFCzI7o9aPZF722Ex9MNz87g_SvNUGb039acifN8MLJ_zvHrnzbDluplhUeITFatUS9howejDSmYSZVnIHt9CorW7WMNv9sSUdSG9ISO8e2QwKaMEkoU6gAjO462zbkE5NULTjcqkiysttrbr0igUQypVlcXLQGtu_TWTLIcggduuHzXONKgWKUOvQykcb33wzYDZ0-D70Kn_4JemtZOdLnHnU6Eb87vXE4d0ntWezfAG5Y9rAjFoHYQ"/>
            </div>
            <div>
                <p class="text-sm font-bold text-on-surface">Alex River</p>
                <p class="text-xs text-on-surface/50">Chief Sustainability Officer</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content Area -->
<main class="ml-64 p-12 max-w-[1400px]">
    <header class="mb-16">
        <h2 class="font-headline text-5xl font-black text-primary tracking-tight mb-4">Sustainability Overview</h2>
        <p class="text-lg text-on-surface/70 max-w-2xl leading-relaxed">
            Welcome back. This dashboard now uses admin data blocks instead of fixed demo values.
        </p>
    </header>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <p class="text-on-surface/50 font-medium text-sm mb-2">Tổng doanh thu</p>
            <h3 class="text-4xl font-headline font-bold text-primary mb-3"><?= formatMoneyVND($totalRevenue) ?></h3>
            <div class="inline-flex items-center text-primary font-bold text-sm bg-primary-fixed-dim/20 px-3 py-1 rounded-full">
                <span class="material-symbols-outlined text-sm mr-1">payments</span>
                Tổng quan doanh thu
            </div>
        </div>

        <div class="bg-primary text-white rounded-xl p-8 shadow-sm">
            <p class="text-white/70 font-medium text-sm mb-2">Đang xử lý Đơn hàng</p>
            <h3 class="text-5xl font-headline font-black mb-3"><?= number_format((int)$activeOrders) ?></h3>
            <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg border border-white/10">
                <span class="material-symbols-outlined mr-2">shopping_bag</span>
                <span class="text-xs font-semibold">ĐƠN ĐANG XỬ LÝ</span>
            </div>
        </div>

        <div class="bg-secondary-container rounded-xl p-8 shadow-sm">
            <p class="text-on-secondary-container/70 font-medium text-sm mb-2">Sản phẩm</p>
            <h3 class="text-5xl font-headline font-black text-on-secondary-container mb-3"><?= number_format((int)$totalProducts) ?></h3>
            <div class="inline-flex items-center bg-white/20 px-4 py-2 rounded-lg">
                <span class="material-symbols-outlined mr-2">inventory_2</span>
                <span class="text-xs font-semibold">QUY MÔ DANH MỤC</span>
            </div>
        </div>

        <div class="bg-surface-container-low rounded-xl p-8 shadow-sm">
            <p class="text-on-surface/50 font-medium text-sm mb-2">Bài viết đã xuất bản</p>
            <h3 class="text-5xl font-headline font-black text-primary mb-3"><?= number_format((int)$publishedPosts) ?></h3>
            <div class="inline-flex items-center bg-primary-fixed-dim/20 text-primary px-4 py-2 rounded-lg">
                <span class="material-symbols-outlined mr-2">article</span>
                <span class="text-xs font-semibold">TRẠNG THÁI NỘI DUNG</span>
            </div>
        </div>
    </div>

    <!-- Secondary Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-16">
        <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/10">
            <h4 class="font-headline text-2xl font-bold text-primary mb-3">Hàng đợi đánh giá</h4>
            <p class="text-on-surface/60 mb-5">Đánh giá currently pending moderation.</p>
            <p class="text-4xl font-headline font-black text-primary"><?= number_format((int)$pendingReviews) ?></p>
        </div>

        <div class="bg-surface-container-low rounded-xl p-8 border border-outline-variant/10">
            <h4 class="font-headline text-2xl font-bold text-primary mb-3">Tổng cộng Đánh giá</h4>
            <p class="text-on-surface/60 mb-5">All reviews collected from customers.</p>
            <p class="text-4xl font-headline font-black text-primary"><?= number_format((int)$totalReviews) ?></p>
        </div>

        <div class="bg-surface-container-highest rounded-xl p-8 border-2 border-dashed border-outline-variant">
            <h4 class="font-headline text-2xl font-bold text-primary mb-3">Bảng điều khiển Note</h4>
            <p class="text-on-surface/60 leading-relaxed">
                You can later replace this block with real KPI charts, top-selling products, latest orders, or moderation alerts.
            </p>
        </div>
    </div>

    <!-- Quản lý khuyến mãi -->
    <section class="mt-12">
        <div class="flex justify-between items-center mb-10 flex-wrap gap-4">
            <div>
                <h4 class="font-headline text-3xl font-bold text-primary mb-2">Quản lý khuyến mãi</h4>
                <p class="text-on-surface/60">Xem dữ liệu khuyến mãi và chuẩn bị thao tác chiến dịch.</p>
            </div>
            <a href="/is207/index.php?url=promotion/create"
               class="flex items-center gap-2 bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-on-secondary-container transition-all">
                <span class="material-symbols-outlined">add</span>
                Tạo khuyến mãi mới
            </a>
        </div>

        <?php if (!empty($promotions)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($promotions as $promotion): ?>
                    <?php
                    $id = promotionValue($promotion, ['id'], null);
                    $code = promotionValue($promotion, ['code', 'name', 'title'], 'PROMO');
                    $description = promotionValue($promotion, ['description', 'summary'], 'Chưa có mô tả khuyến mãi.');
                    $status = promotionValue($promotion, ['status'], 'scheduled');
                    $usage = promotionValue($promotion, ['usage', 'used'], '0');
                    $limit = promotionValue($promotion, ['limit', 'max_usage'], '—');
                    $startDate = promotionValue($promotion, ['start_date', 'starts_at'], '');
                    ?>
                    <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/20 hover:border-primary/30 transition-all group">
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-primary-fixed-dim/30 p-3 rounded-lg text-primary">
                                <span class="material-symbols-outlined text-3xl">redeem</span>
                            </div>
                            <span class="<?= promotionStatusBadge($status) ?>"><?= e($status) ?></span>
                        </div>

                        <h5 class="text-xl font-headline font-bold mb-1"><?= e($code) ?></h5>
                        <p class="text-sm text-on-surface/50 mb-6"><?= e($description) ?></p>

                        <div class="flex justify-between items-center py-4 border-t border-outline-variant/10">
                            <div>
                                <?php if ($startDate !== ''): ?>
                                    <p class="text-[10px] text-on-surface/40 uppercase font-bold tracking-tighter">Bắt đầu</p>
                                    <p class="font-bold text-on-surface"><?= e($startDate) ?></p>
                                <?php else: ?>
                                    <p class="text-[10px] text-on-surface/40 uppercase font-bold tracking-tighter">Lượt dùng</p>
                                    <p class="font-bold text-on-surface"><?= e($usage) ?><?= $limit !== '—' ? ' / ' . e($limit) : '' ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="flex gap-2">
                                <?php if ($id !== null): ?>
                                    <a href="/is207/index.php?url=promotion/edit/<?= urlencode((string)$id) ?>" class="p-2 text-on-surface/60 hover:text-primary">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="/is207/index.php?url=promotion/delete/<?= urlencode((string)$id) ?>" onclick="return confirm('Xóa khuyến mãi này?')" class="p-2 text-on-surface/60 hover:text-error">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                <?php else: ?>
                                    <button type="button" class="p-2 text-on-surface/60 hover:text-primary">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button type="button" class="p-2 text-on-surface/60 hover:text-error">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-surface-container-low rounded-xl p-12 text-center border border-outline-variant/20">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-outline-variant">
                    <span class="material-symbols-outlined text-3xl">local_offer</span>
                </div>
                <h5 class="text-2xl font-headline font-bold text-primary mb-2">Không tìm thấy khuyến mãi</h5>
                <p class="text-on-surface/60">There is no promotion data to display yet.</p>
            </div>
        <?php endif; ?>
    </section>

    <footer class="flex flex-col md:flex-row justify-between items-center px-0 py-16 mt-20 border-t border-[#c5c8ba]/10">
        <div class="mb-4 md:mb-0">
            <span class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</span>
            <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2026 Zentro Sustainable Living. Admin panel.</p>
        </div>
        <div class="flex gap-8">
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Chính sách bảo mật</a>
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Điều khoản dịch vụ</a>
            <a class="text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity font-['Be_Vietnam_Pro'] text-sm tracking-wide" href="#">Liên hệ</a>
        </div>
    </footer>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>

