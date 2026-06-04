<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('formatSupportDate')) {
    function formatSupportDate($date) {
        return !empty($date) ? date('d/m/Y H:i', strtotime($date)) : 'Đang chờ';
    }
}

$faqs = $faqs ?? [];
$questions = $questions ?? [];
$errors = $errors ?? [];
$old = $old ?? [];
$isLoggedIn = !empty($_SESSION['user_id']);
?>

<main class="min-h-screen bg-surface px-6 py-12">
    <section class="max-w-6xl mx-auto space-y-10">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-secondary">Customer Support</p>
                <h1 class="font-headline text-4xl md:text-5xl font-black text-primary mt-2">
                    Hỗ trợ khách hàng
                </h1>
                <p class="text-on-surface-variant mt-3 max-w-2xl">
                    Xem nhanh các câu hỏi thường gặp hoặc gửi câu hỏi riêng để admin phản hồi trực tiếp tại đây.
                </p>
            </div>

            <?php if (!$isLoggedIn): ?>
                <a href="index.php?url=login" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary text-white font-bold">
                    <span class="material-symbols-outlined">login</span>
                    Đăng nhập để gửi câu hỏi
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($success)): ?>
            <div class="rounded-xl bg-green-100 text-green-800 px-5 py-4 font-medium">
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="rounded-xl bg-red-100 text-red-800 px-5 py-4 font-medium">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-8">
            <div class="bg-white rounded-2xl border border-outline-variant/30 p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">quiz</span>
                    <h2 class="font-headline text-2xl font-black text-on-surface">FAQ gợi ý</h2>
                </div>

                <div class="space-y-3">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <details class="group rounded-xl border border-outline-variant/30 bg-surface-container-low p-4">
                            <summary class="cursor-pointer list-none flex items-center justify-between gap-4 font-bold text-primary">
                                <span><?= e($faq['question'] ?? '') ?></span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <p class="mt-3 text-sm leading-6 text-on-surface-variant">
                                <?= e($faq['answer'] ?? '') ?>
                            </p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-outline-variant/30 p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">contact_support</span>
                    <h2 class="font-headline text-2xl font-black text-on-surface">Gửi câu hỏi riêng</h2>
                </div>

                <?php if ($isLoggedIn): ?>
                    <form method="POST" action="index.php?url=support/submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Tiêu đề</label>
                            <input
                                type="text"
                                name="title"
                                value="<?= e($old['title'] ?? '') ?>"
                                placeholder="Ví dụ: Cần hỗ trợ đổi địa chỉ giao hàng"
                                class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary"
                            >
                            <?php if (!empty($errors['title'])): ?>
                                <p class="text-sm text-red-700 mt-2"><?= e($errors['title']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Câu hỏi</label>
                            <textarea
                                name="question"
                                rows="6"
                                required
                                placeholder="Nhập nội dung cần admin hỗ trợ..."
                                class="w-full rounded-xl border-outline-variant focus:border-primary focus:ring-primary resize-none"
                            ><?= e($old['question'] ?? '') ?></textarea>
                            <?php if (!empty($errors['question'])): ?>
                                <p class="text-sm text-red-700 mt-2"><?= e($errors['question']) ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary text-white font-bold hover:opacity-90 transition-opacity">
                            <span class="material-symbols-outlined">send</span>
                            Gửi câu hỏi
                        </button>
                    </form>
                <?php else: ?>
                    <div class="rounded-xl bg-surface-container-low p-5 text-on-surface-variant">
                        Bạn cần đăng nhập để gửi câu hỏi riêng và xem phản hồi của admin.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php if ($isLoggedIn): ?>
            <section class="bg-white rounded-2xl border border-outline-variant/30 p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="font-headline text-2xl font-black text-on-surface">Câu hỏi của tôi</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Theo dõi trạng thái và câu trả lời từ admin.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-bold">
                        <?= count($questions) ?> câu hỏi
                    </span>
                </div>

                <?php if (empty($questions)): ?>
                    <div class="rounded-xl bg-surface-container-low p-6 text-center text-on-surface-variant">
                        Bạn chưa gửi câu hỏi hỗ trợ nào.
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($questions as $question): ?>
                            <?php $answered = (int)($question['TrangThai'] ?? 0) === 1; ?>
                            <article class="rounded-xl border border-outline-variant/30 p-5">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">
                                            <?= e($question['MaHoTro'] ?? '') ?> • <?= e(formatSupportDate($question['NgayGui'] ?? '')) ?>
                                        </p>
                                        <h3 class="font-bold text-primary mt-2">
                                            <?= e(($question['TieuDe'] ?? '') !== '' ? $question['TieuDe'] : 'Câu hỏi hỗ trợ') ?>
                                        </h3>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $answered ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= $answered ? 'Đã trả lời' : 'Chưa trả lời' ?>
                                    </span>
                                </div>

                                <p class="mt-4 text-sm leading-6 text-on-surface-variant"><?= e($question['CauHoi'] ?? '') ?></p>

                                <?php if ($answered): ?>
                                    <div class="mt-4 rounded-xl bg-surface-container-low p-4 border border-outline-variant/20">
                                        <p class="text-xs font-black uppercase tracking-widest text-primary mb-2">
                                            Phản hồi admin • <?= e(formatSupportDate($question['NgayTraLoi'] ?? '')) ?>
                                        </p>
                                        <p class="text-sm leading-6 text-on-surface"><?= e($question['CauTraLoi'] ?? '') ?></p>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
