<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('formatSupportAdminDate')) {
    function formatSupportAdminDate($date) {
        return !empty($date) ? date('d/m/Y H:i', strtotime($date)) : '—';
    }
}

$questions = $questions ?? [];
$stats = $stats ?? ['total' => 0, 'pending' => 0, 'answered' => 0];
$keyword = $keyword ?? '';
$tab = $tab ?? 'all';
$status = $status ?? null;
$message = $message ?? '';
?>

<main class="ml-64 min-h-screen bg-surface p-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-widest">Admin Support</p>
                <h1 class="font-headline text-4xl font-black text-on-surface mt-2">
                    Hỗ trợ khách hàng
                </h1>
                <p class="text-on-surface-variant mt-2">
                    Xem câu hỏi user gửi, phân biệt chưa trả lời và lưu phản hồi cho khách hàng.
                </p>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="rounded-xl p-4 <?= $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Tổng câu hỏi</p>
                <p class="font-headline text-3xl font-black text-primary mt-2"><?= (int)($stats['total'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Chưa trả lời</p>
                <p class="font-headline text-3xl font-black text-yellow-700 mt-2"><?= (int)($stats['pending'] ?? 0) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
                <p class="text-xs uppercase font-bold text-on-surface-variant">Đã trả lời</p>
                <p class="font-headline text-3xl font-black text-green-700 mt-2"><?= (int)($stats['answered'] ?? 0) ?></p>
            </div>
        </section>

        <section class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
            <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4">
                <div class="flex gap-2 flex-wrap">
                    <a href="index.php?url=admin/support&tab=all"
                       class="px-4 py-2 rounded-full text-sm font-bold <?= $tab === 'all' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant' ?>">
                        Tất cả
                    </a>
                    <a href="index.php?url=admin/support&tab=pending"
                       class="px-4 py-2 rounded-full text-sm font-bold <?= $tab === 'pending' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant' ?>">
                        Chưa trả lời
                    </a>
                    <a href="index.php?url=admin/support&tab=answered"
                       class="px-4 py-2 rounded-full text-sm font-bold <?= $tab === 'answered' ? 'bg-primary text-white' : 'bg-surface-container text-on-surface-variant' ?>">
                        Đã trả lời
                    </a>
                </div>

                <form method="GET" action="index.php" class="flex flex-col sm:flex-row gap-3">
                    <input type="hidden" name="url" value="admin/support">
                    <input type="hidden" name="tab" value="<?= e($tab) ?>">
                    <input
                        type="text"
                        name="keyword"
                        value="<?= e($keyword) ?>"
                        placeholder="Tìm mã, user, email, nội dung..."
                        class="w-full sm:w-80 rounded-xl border-outline-variant focus:border-primary focus:ring-primary"
                    >
                    <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-bold">
                        Lọc
                    </button>
                </form>
            </div>
        </section>

        <section class="space-y-4">
            <?php if (empty($questions)): ?>
                <div class="bg-white rounded-2xl p-12 shadow-sm border border-outline-variant/20 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-3xl">support_agent</span>
                    </div>
                    <h2 class="font-headline text-2xl font-black text-on-surface mb-2">Chưa có câu hỏi phù hợp</h2>
                    <p class="text-on-surface-variant">Thử đổi bộ lọc hoặc từ khóa tìm kiếm.</p>
                </div>
            <?php else: ?>
                <?php foreach ($questions as $question): ?>
                    <?php $answered = (int)($question['TrangThai'] ?? 0) === 1; ?>
                    <article class="bg-white rounded-2xl p-6 shadow-sm border border-outline-variant/20">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="font-black text-primary">#<?= e($question['MaHoTro'] ?? '') ?></span>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $answered ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= $answered ? 'Đã trả lời' : 'Chưa trả lời' ?>
                                    </span>
                                </div>
                                <h2 class="font-headline text-2xl font-black text-on-surface mt-3">
                                    <?= e(($question['TieuDe'] ?? '') !== '' ? $question['TieuDe'] : 'Câu hỏi hỗ trợ') ?>
                                </h2>
                                <p class="text-sm text-on-surface-variant mt-2">
                                    <?= e($question['HoTen'] ?? 'Khách hàng') ?> • <?= e($question['Email'] ?? '') ?> • gửi lúc <?= e(formatSupportAdminDate($question['NgayGui'] ?? '')) ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-xl bg-surface-container-low p-5">
                            <p class="text-xs font-black uppercase tracking-widest text-primary mb-2">Câu hỏi</p>
                            <p class="text-sm leading-6 text-on-surface"><?= e($question['CauHoi'] ?? '') ?></p>
                        </div>

                        <?php if ($answered): ?>
                            <div class="mt-4 rounded-xl bg-green-50 border border-green-100 p-5">
                                <p class="text-xs font-black uppercase tracking-widest text-green-800 mb-2">
                                    Phản hồi đã lưu • <?= e(formatSupportAdminDate($question['NgayTraLoi'] ?? '')) ?>
                                </p>
                                <p class="text-sm leading-6 text-on-surface"><?= e($question['CauTraLoi'] ?? '') ?></p>
                                <?php if (!empty($question['TenAdmin'])): ?>
                                    <p class="text-xs text-on-surface-variant mt-3">Admin: <?= e($question['TenAdmin']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?url=admin/support" class="mt-5">
                            <input type="hidden" name="support_id" value="<?= e($question['MaHoTro'] ?? '') ?>">
                            <label class="block text-sm font-bold text-on-surface mb-2">
                                <?= $answered ? 'Cập nhật câu trả lời' : 'Nhập câu trả lời' ?>
                            </label>
                            <textarea
                                name="reply_content"
                                rows="4"
                                required
                                class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary resize-none"
                                placeholder="Nhập phản hồi cho khách hàng..."
                            ><?= e($question['CauTraLoi'] ?? '') ?></textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary text-white font-bold hover:opacity-90 transition-opacity">
                                    <span class="material-symbols-outlined">reply</span>
                                    Lưu câu trả lời
                                </button>
                            </div>
                        </form>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>
