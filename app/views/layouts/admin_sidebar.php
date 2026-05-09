<?php
$adminName = $_SESSION['HoTen'] ?? $_SESSION['user_name'] ?? 'Zentro Admin';
$adminInitial = function_exists('mb_substr') ? mb_substr($adminName, 0, 1, 'UTF-8') : substr($adminName, 0, 1);
$activePage = $currentPage ?? '';
$navItemClass = function (string $page) use ($activePage): string {
    $base = "mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all font-['Be_Vietnam_Pro']";
    if ($activePage === $page) {
        return "bg-[#384e21] text-white $base";
    }

    return "text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 hover:translate-x-1 $base";
};
?>

<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] z-50 flex flex-col py-8">
    <div class="px-6 mb-10">
        <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
        <p class="font-['Be_Vietnam_Pro'] font-medium text-xs text-[#191c18]/60 mt-1 uppercase tracking-widest">Bộ quản trị xanh</p>
    </div>

    <nav class="flex-grow space-y-1">
        <a class="<?= $navItemClass('dashboard') ?>" href="<?= BASE_URL ?>index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium text-sm">Bảng điều khiển</span>
        </a>

        <a class="<?= $navItemClass('products') ?>" href="<?= BASE_URL ?>index.php?url=admin/products">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-medium text-sm">Sản phẩm</span>
        </a>

        <a class="<?= $navItemClass('categories') ?>" href="<?= BASE_URL ?>index.php?url=admin/categories">
            <span class="material-symbols-outlined">category</span>
            <span class="font-medium text-sm">Danh mục</span>
        </a>

        <a class="<?= $navItemClass('inventory') ?>" href="<?= BASE_URL ?>index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-medium text-sm">Kho hàng</span>
        </a>

        <a class="<?= $navItemClass('orders') ?>" href="<?= BASE_URL ?>index.php?url=admin/orders">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-medium text-sm">Đơn hàng</span>
        </a>

        <a class="<?= $navItemClass('reviews') ?>" href="<?= BASE_URL ?>index.php?url=admin/reviews">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-medium text-sm">Đánh giá</span>
        </a>

        <a class="<?= $navItemClass('users') ?>" href="<?= BASE_URL ?>index.php?url=admin/users">
            <span class="material-symbols-outlined">group</span>
            <span class="font-medium text-sm">Người dùng</span>
        </a>

        <a class="<?= $navItemClass('blog') ?>" href="<?= BASE_URL ?>index.php?url=admin/blog">
            <span class="material-symbols-outlined">article</span>
            <span class="font-medium text-sm">Blog</span>
        </a>

        <a class="<?= $navItemClass('promo') ?>" href="<?= BASE_URL ?>index.php?url=admin/promo">
            <span class="material-symbols-outlined">confirmation_number</span>
            <span class="font-medium text-sm">Mã giảm giá</span>
        </a>
    </nav>

    <div class="mt-auto px-4 pt-6 border-t border-[#c5c8ba]/20 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-[#384e21] text-white flex items-center justify-center font-bold">
            <?= htmlspecialchars(strtoupper($adminInitial), ENT_QUOTES, 'UTF-8') ?>
        </div>
        <div class="min-w-0 flex-1 overflow-hidden">
            <p class="text-xs font-bold text-[#384e21] truncate"><?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="text-[10px] text-[#191c18]/50 truncate">Quản trị viên</p>
        </div>
        <a
            href="<?= BASE_URL ?>index.php?url=logout"
            title="Đăng xuất"
            aria-label="Đăng xuất"
            class="w-9 h-9 rounded-lg flex items-center justify-center text-[#191c18]/50 hover:bg-red-50 hover:text-red-700 transition-colors"
        >
            <span class="material-symbols-outlined text-[20px]">logout</span>
        </a>
    </div>
</aside>
