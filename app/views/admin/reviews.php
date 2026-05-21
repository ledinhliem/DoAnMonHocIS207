<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<?php
$keyword = $_GET['keyword'] ?? '';
$tab = $_GET['tab'] ?? 'all';

$reviewList = [];
if (isset($reviews) && is_array($reviews)) {
    $reviewList = $reviews;
} elseif (isset($data['reviews']) && is_array($data['reviews'])) {
    $reviewList = $data['reviews'];
}

$flashStatus = $status ?? null;
$flashMessage = $message ?? '';

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
        return $status === 'approved'
            ? 'bg-green-100 text-green-700'
            : 'bg-primary-container text-on-primary-container';
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
$ratingSum = 0;
$ratingCount = 0;

foreach ($reviewList as $review) {
    $trangThai = (int)reviewValue($review, ['TrangThai'], 0);
    $rating = (float)reviewValue($review, ['SoSao', 'rating'], 0);

    if ($trangThai === 0) {
        $pendingCount++;
    }

    if ($rating > 0) {
        $ratingSum += $rating;
        $ratingCount++;
    }
}

$averageRating = $ratingCount > 0 ? round($ratingSum / $ratingCount, 1) : 0;
?>

<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="ml-64 p-12 min-h-screen">
    <?php if (!empty($flashStatus)): ?>
        <div class="mb-8 px-6 py-4 rounded-2xl font-medium text-sm flex items-center gap-3
            <?= $flashStatus === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <span class="material-symbols-outlined">
                <?= $flashStatus === 'success' ? 'check_circle' : 'error' ?>
            </span>
            <?= e($flashMessage) ?>
        </div>
    <?php endif; ?>

    <header class="mb-12 flex flex-col xl:flex-row justify-between gap-6 xl:items-end">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant text-sm mb-4">
                <span>Admin</span>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-medium">Đánh giá</span>
            </nav>
            <h2 class="text-5xl font-black tracking-tighter text-primary">Quản lý đánh giá</h2>
            <p class="text-on-surface-variant mt-2 text-lg">Duyệt, ẩn, xóa và phản hồi đánh giá của khách hàng.</p>
        </div>

        <div class="flex gap-4 flex-wrap">
            <div class="bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3">
                <span class="text-primary font-bold text-2xl"><?= $averageRating > 0 ? e($averageRating) : '-' ?></span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <div>
                    <div class="flex text-primary">
                        <?= $averageRating > 0 ? renderStars((int)round($averageRating)) : '' ?>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Điểm trung bình</p>
                </div>
            </div>

            <div class="bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3">
                <span class="text-primary font-bold text-2xl"><?= e($pendingCount) ?></span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider leading-tight">Chờ<br>Duyệt</p>
            </div>
        </div>
    </header>

    <section class="space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex gap-2 flex-wrap">
                <a href="<?= BASE_URL ?>index.php?url=admin/reviews&tab=all"
                   class="px-4 py-2 <?= $tab === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                    Tất cả
                </a>
                <a href="<?= BASE_URL ?>index.php?url=admin/reviews&tab=pending"
                   class="px-4 py-2 <?= $tab === 'pending' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                    Chờ duyệt
                </a>
                <a href="<?= BASE_URL ?>index.php?url=admin/reviews&tab=approved"
                   class="px-4 py-2 <?= $tab === 'approved' ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant' ?> rounded-full text-sm font-medium transition-colors">
                    Đã duyệt
                </a>
            </div>

            <form method="GET" action="<?= BASE_URL ?>index.php" class="relative">
                <input type="hidden" name="url" value="admin/reviews">
                <input type="hidden" name="tab" value="<?= e($tab) ?>">
                <input
                    class="bg-surface-container-high border-none rounded-full pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 w-64 transition-all"
                    placeholder="Tìm khách hàng, sản phẩm, nội dung..."
                    type="text"
                    name="keyword"
                    value="<?= e($keyword) ?>"
                >
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            </form>
        </div>

        <div class="space-y-4">
            <?php if (!empty($reviewList)): ?>
                <?php foreach ($reviewList as $review): ?>
                    <?php
                    $maDanhGia = reviewValue($review, ['MaDanhGia'], '');
                    $customerName = reviewValue($review, ['TenNguoiDung', 'HoTen', 'customer_name'], 'Ẩn danh');
                    $productName = reviewValue($review, ['TenSanPham', 'product_name'], 'Sản phẩm');
                    $content = reviewValue($review, ['NoiDung', 'content'], '');
                    $rating = (int)reviewValue($review, ['SoSao', 'rating'], 0);
                    $trangThai = (int)reviewValue($review, ['TrangThai'], 0);
                    $statusName = $trangThai === 1 ? 'approved' : 'pending';
                    $createdAt = reviewValue($review, ['NgayDanhGia', 'created_at'], '-');
                    $tagText = $trangThai === 1 ? 'Đã duyệt' : 'Chờ duyệt';
                    $response = reviewValue($review, ['PhanHoiAdmin', 'response'], '');
                    $avatar = reviewValue($review, ['avatar', 'avatar_url'], '');
                    ?>

                    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-1.5 h-full bg-primary-fixed-dim opacity-0 group-hover:opacity-100 transition-opacity"></div>

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
                            <p class="text-on-surface-variant leading-relaxed text-sm">
                                <?= e($content !== '' ? $content : 'Chưa có nội dung đánh giá.') ?>
                            </p>
                        </div>

                        <?php if ($response !== ''): ?>
                            <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/10">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="material-symbols-outlined text-primary text-sm">subdirectory_arrow_right</span>
                                    <span class="text-[10px] font-black uppercase text-primary tracking-widest">Phản hồi admin</span>
                                </div>
                                <p class="text-sm text-on-surface"><?= e($response) ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between pt-6 <?= $response !== '' ? 'mt-6' : '' ?> border-t border-outline-variant/10">
                            <div class="flex gap-3 flex-wrap">
                                <?php if ($trangThai === 0): ?>
                                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/reviews">
                                        <input type="hidden" name="action" value="approve">
                                        <input type="hidden" name="ma_danh_gia" value="<?= e($maDanhGia) ?>">
                                        <button type="submit" class="flex items-center gap-2 text-primary text-sm font-bold hover:underline underline-offset-4">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            Duyệt
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/reviews">
                                        <input type="hidden" name="action" value="hide">
                                        <input type="hidden" name="ma_danh_gia" value="<?= e($maDanhGia) ?>">
                                        <button type="submit" class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4">
                                            <span class="material-symbols-outlined text-sm">visibility_off</span>
                                            Ẩn
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/reviews"
                                      onsubmit="return confirm('Xác nhận xóa đánh giá này?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="ma_danh_gia" value="<?= e($maDanhGia) ?>">
                                    <button type="submit" class="flex items-center gap-2 text-error text-sm font-bold hover:underline underline-offset-4">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                        Xóa
                                    </button>
                                </form>

                                <button type="button"
                                        onclick="toggleReply('reply-<?= e($maDanhGia) ?>')"
                                        class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4">
                                    <span class="material-symbols-outlined text-sm">reply</span>
                                    Phản hồi
                                </button>
                            </div>

                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= reviewStatusBadge($statusName) ?>">
                                <?= e($tagText) ?>
                            </span>
                        </div>

                        <div id="reply-<?= e($maDanhGia) ?>" class="hidden mt-4 pt-4 border-t border-outline-variant/10">
                            <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/reviews">
                                <input type="hidden" name="action" value="reply">
                                <input type="hidden" name="ma_danh_gia" value="<?= e($maDanhGia) ?>">
                                <textarea
                                    name="reply_content"
                                    rows="3"
                                    placeholder="Nhập phản hồi của bạn..."
                                    class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-primary/30 transition-all resize-none"
                                ><?= e($response) ?></textarea>
                                <div class="flex gap-3 mt-3">
                                    <button type="submit" class="bg-primary text-on-primary px-5 py-2 rounded-lg text-sm font-bold hover:opacity-90 transition-all">
                                        Lưu phản hồi
                                    </button>
                                    <button type="button" onclick="toggleReply('reply-<?= e($maDanhGia) ?>')" class="text-on-surface-variant text-sm hover:underline">
                                        Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bg-surface-container-lowest p-12 rounded-2xl shadow-sm text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant/50">
                        <span class="material-symbols-outlined text-3xl">rate_review</span>
                    </div>
                    <h3 class="text-2xl font-bold text-on-surface mb-2">Không tìm thấy đánh giá</h3>
                    <p class="text-on-surface-variant">
                        Chưa có đánh giá nào, hoặc bộ lọc hiện tại không có kết quả.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
function toggleReply(id) {
    const el = document.getElementById(id);
    if (el) el.classList.toggle('hidden');
}
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
