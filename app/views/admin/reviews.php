<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$keyword = $_GET['keyword'] ?? '';
$tab     = $_GET['tab'] ?? 'all';

$reviewList = [];
if (isset($reviews) && is_array($reviews)) {
    $reviewList = $reviews;
} elseif (isset($data['reviews']) && is_array($data['reviews'])) {
    $reviewList = $data['reviews'];
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('reviewValue')) {
    function reviewValue($review, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($review[$key]) && $review[$key] !== '') {
                return $review[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('reviewStatusBadge')) {
    function reviewStatusBadge($status) {
        $status = strtolower(trim((string)$status));

        switch ($status) {
            case 'pending':
                return 'bg-primary-container text-on-primary-container';
            case 'flagged':
                return 'bg-red-100 text-red-700';
            case 'approved':
                return 'bg-green-100 text-green-700';
            case 'replied':
                return 'bg-surface-variant text-on-surface-variant';
            default:
                return 'bg-surface-container-high text-on-surface';
        }
    }
}

if (!function_exists('renderStars')) {
    function renderStars($rating) {
        $rating = max(0, min(5, (int)$rating));
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $fill = $i <= $rating ? 1 : 0;
            $html .= '<span class="material-symbols-outlined" style="font-variation-settings:\'FILL\' ' . $fill . ';">star</span>';
        }
        return $html;
    }
}

$totalReviews = count($reviewList);
$pendingCount = 0;
$flaggedCount = 0;
$ratingSum = 0;
$ratingCount = 0;

foreach ($reviewList as $review) {
    $status = strtolower((string) reviewValue($review, ['status'], ''));
    $rating = (float) reviewValue($review, ['rating'], 0);

    if ($status === 'pending') {
        $pendingCount++;
    }
    if ($status === 'flagged') {
        $flaggedCount++;
    }
    if ($rating > 0) {
        $ratingSum += $rating;
        $ratingCount++;
    }
}

$averageRating = $ratingCount > 0 ? round($ratingSum / $ratingCount, 1) : 0;
?>

<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-40">
    <div class="px-6 mb-10">
        <a href="/is207/index.php?url=admin/dashboard" class="block">
            <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro</h1>
            <p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant font-bold mt-1">Eco-Management Suite</p>
        </a>
    </div>

    <nav class="flex-1 space-y-1">
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-medium text-sm">Inventory</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/suppliers">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-medium text-sm">Suppliers</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/products">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-medium text-sm">Products</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/orders">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-medium text-sm">Orders</span>
        </a>

        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform"
           href="/is207/index.php?url=admin/reviews">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">rate_review</span>
            <span class="font-medium text-sm">Reviews</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/blog">
            <span class="material-symbols-outlined">article</span>
            <span class="font-medium text-sm">Blog</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200"
           href="/is207/index.php?url=admin/settings">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-medium text-sm">Settings</span>
        </a>
    </nav>

    <div class="px-6 mt-auto pt-8 border-t border-[#c5c8ba]/20">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold overflow-hidden">
                <img alt="Admin User Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBk3wfsUs_cn9X2dz9ylSjH798GLpVQ4waoMNV5Q7SPLluIYbZ0oHkka8LAM6HjNSLSnT-GkUBATd2Kg8lS-8a70XDw929VOP2QwxmiM24Espy7DKKDm2kdzD0OS6b5v11IjZIi8uw2azekhfMcLBjFwdFlAGUKqQp4wCKpFFZEr4GqqPXpaQiJLp3aZpdpFpBHlfVCPWejIs3AMdf25XiM1Pm1NALeMf-VnmWtoigU6cWnrmhhXnn7K7hqTDgolZiAEjiaUBZjVw"/>
            </div>
            <div>
                <p class="text-xs font-bold text-on-surface">Zentro Admin</p>
                <p class="text-[10px] text-on-surface-variant">Review Moderator</p>
            </div>
        </div>

        <button class="w-full bg-secondary-container text-on-secondary-container py-2.5 rounded-lg text-xs font-bold hover:bg-opacity-90 transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm">file_download</span>
            Export Reports
        </button>
    </div>
</aside>

<main class="ml-64 p-12 min-h-screen">
    <header class="mb-12 flex flex-col xl:flex-row justify-between gap-6 xl:items-end">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant text-sm mb-4">
                <span>Admin</span>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-medium">REVIEWS</span>
            </nav>
            <h2 class="text-5xl font-black tracking-tighter text-primary">Review Moderation</h2>
            <p class="text-on-surface-variant mt-2 text-lg">Maintain the integrity of the community experience.</p>
        </div>

        <div class="flex gap-4 flex-wrap">
            <div class="bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3">
                <span class="text-primary font-bold text-2xl"><?= $averageRating > 0 ? e($averageRating) : '—' ?></span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <div>
                    <div class="flex text-primary">
                        <?= $averageRating > 0 ? renderStars((int) round($averageRating)) : '' ?>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Average Rating</p>
                </div>
            </div>

            <div class="bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3">
                <span class="text-primary font-bold text-2xl"><?= $pendingCount ?></span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider leading-tight">Pending<br/>Moderation</p>
            </div>
        </div>
    </header>

    <section class="grid grid-cols-12 gap-8">
        <div class="col-span-12 lg:col-span-8 space-y-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
                <div class="flex gap-2 flex-wrap">
                    <a href="?tab=all"
                       class="px-4 py-2 <?= $tab === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                        All Reviews
                    </a>
                    <a href="?tab=pending"
                       class="px-4 py-2 <?= $tab === 'pending' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                        Pending
                    </a>
                    <a href="?tab=flagged"
                       class="px-4 py-2 <?= $tab === 'flagged' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                        Flagged
                    </a>
                </div>

                <form method="GET" action="" class="relative">
                    <input type="hidden" name="tab" value="<?= e($tab) ?>">
                    <input
                        class="bg-surface-container-high border-none rounded-full pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 w-64 transition-all"
                        placeholder="Search customer or content..."
                        type="text"
                        name="keyword"
                        value="<?= e($keyword) ?>"
                    />
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                </form>
            </div>

            <div class="space-y-4">
                <?php if (!empty($reviewList)): ?>
                    <?php foreach ($reviewList as $review): ?>
                        <?php
                        $customerName = reviewValue($review, ['customer_name', 'customer', 'user_name', 'full_name'], 'Customer');
                        $productName = reviewValue($review, ['product_name', 'product', 'title'], 'Product');
                        $content = reviewValue($review, ['content', 'comment', 'review_text', 'message'], '');
                        $rating = (int) reviewValue($review, ['rating'], 0);
                        $status = reviewValue($review, ['status'], 'pending');
                        $createdAt = reviewValue($review, ['created_at', 'time', 'date'], 'Recently');
                        $tagText = reviewValue($review, ['tag', 'label'], ucfirst($status));
                        $response = reviewValue($review, ['response', 'admin_response', 'reply'], '');
                        $avatar = reviewValue($review, ['avatar', 'avatar_url', 'image'], '');
                        ?>
                        <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-1.5 h-full <?= strtolower($status) === 'flagged' ? 'bg-error/20 opacity-100' : 'bg-primary-fixed-dim opacity-0 group-hover:opacity-100' ?> transition-opacity"></div>

                            <div class="flex justify-between items-start mb-6 gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container">
                                        <?php if ($avatar !== ''): ?>
                                            <img alt="<?= e($customerName) ?>" class="w-full h-full object-cover" src="<?= e($avatar) ?>">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                                                <span class="material-symbols-outlined">person</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg text-on-surface"><?= e($customerName) ?></h4>
                                        <p class="text-xs text-on-surface-variant"><?= e($createdAt) ?></p>
                                    </div>
                                </div>

                                <div class="flex text-[#4e6535]">
                                    <?= renderStars($rating) ?>
                                </div>
                            </div>

                            <div class="mb-6">
                                <p class="font-bold text-primary mb-2"><?= e($productName) ?></p>

                                <?php if (strtolower($status) === 'flagged'): ?>
                                    <p class="text-error bg-error-container/30 p-4 rounded-xl text-sm italic mb-4">
                                        Flagged review content requires moderation before publishing.
                                    </p>
                                <?php endif; ?>

                                <p class="text-on-surface-variant leading-relaxed text-sm">
                                    <?= e($content !== '' ? $content : 'No review content available.') ?>
                                </p>
                            </div>

                            <?php if ($response !== ''): ?>
                                <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/10">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="material-symbols-outlined text-primary text-sm">subdirectory_arrow_right</span>
                                        <span class="text-[10px] font-black uppercase text-primary tracking-widest">Admin Response</span>
                                    </div>
                                    <p class="text-sm text-on-surface"><?= e($response) ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center justify-between pt-6 <?= $response !== '' ? 'mt-6' : '' ?> border-t border-outline-variant/10">
                                <div class="flex gap-4 flex-wrap">
                                    <button type="button" class="flex items-center gap-2 text-primary text-sm font-bold hover:underline underline-offset-4">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Approve
                                    </button>
                                    <button type="button" class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4">
                                        <span class="material-symbols-outlined text-sm">reply</span>
                                        Reply
                                    </button>
                                    <button type="button" class="flex items-center gap-2 text-error text-sm font-bold hover:underline underline-offset-4">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                        Delete
                                    </button>
                                </div>

                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= reviewStatusBadge($status) ?>">
                                    <?= e($tagText) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-surface-container-lowest p-12 rounded-2xl shadow-sm text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant/50">
                            <span class="material-symbols-outlined text-3xl">rate_review</span>
                        </div>
                        <h3 class="text-2xl font-bold text-on-surface mb-2">No reviews found</h3>
                        <p class="text-on-surface-variant">
                            There is no review data to display yet, or your current search/filter returned no results.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <aside class="col-span-12 lg:col-span-4 space-y-8">
            <div class="bg-surface-container-high p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-primary mb-6">Moderation Stats</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-2">
                            <span>Pending Reviews</span>
                            <span><?= $totalReviews > 0 ? round(($pendingCount / $totalReviews) * 100) : 0 ?>%</span>
                        </div>
                        <div class="w-full h-2 bg-surface rounded-full overflow-hidden">
                            <div class="bg-primary h-full" style="width: <?= $totalReviews > 0 ? round(($pendingCount / $totalReviews) * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-2">
                            <span>Flagged Reviews</span>
                            <span><?= $totalReviews > 0 ? round(($flaggedCount / $totalReviews) * 100) : 0 ?>%</span>
                        </div>
                        <div class="w-full h-2 bg-surface rounded-full overflow-hidden">
                            <div class="bg-primary-container h-full" style="width: <?= $totalReviews > 0 ? round(($flaggedCount / $totalReviews) * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-outline-variant/20 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-black text-primary"><?= $totalReviews ?></p>
                        <p class="text-[10px] font-bold uppercase text-on-surface-variant tracking-wider">Total Reviews</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-primary"><?= $flaggedCount ?></p>
                        <p class="text-[10px] font-bold uppercase text-on-surface-variant tracking-wider">Flagged</p>
                    </div>
                </div>
            </div>

            <div class="bg-primary p-8 rounded-3xl text-on-primary">
                <h3 class="text-xl font-bold mb-4">Moderation Policy</h3>
                <p class="text-sm opacity-80 leading-relaxed mb-6">
                    Use this space to display policy, moderation notes, or guidance for the admin team when backend content is added later.
                </p>
                <button class="w-full py-3 bg-white/10 hover:bg-white/20 transition-colors border border-white/20 rounded-xl font-bold text-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">menu_book</span>
                    Read Full Guidelines
                </button>
            </div>

            <div class="bg-surface-container p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-primary mb-6">Current Filters</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Tab</span>
                        <span class="font-bold text-on-surface"><?= e(ucfirst($tab)) ?></span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Keyword</span>
                        <span class="font-bold text-on-surface"><?= $keyword !== '' ? e($keyword) : '—' ?></span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-on-surface-variant">Average Rating</span>
                        <span class="font-bold text-on-surface"><?= $averageRating > 0 ? e($averageRating) : '—' ?></span>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</main>

<footer class="ml-64 bg-[#f3f4ed] dark:bg-stone-900 border-t border-[#c5c8ba]/10 py-12 px-12 flex flex-col md:flex-row justify-between items-center mt-auto">
    <div class="mb-6 md:mb-0">
        <h3 class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</h3>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2026 Zentro Sustainable Living. Admin panel.</p>
    </div>
    <div class="flex gap-8">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Privacy Policy</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Terms of Service</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-all" href="#">Support</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
