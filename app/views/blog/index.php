<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="max-w-6xl mx-auto px-8 py-12">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
        <div>
            <h1 class="text-4xl font-black font-headline text-primary mb-3">Our Journal</h1>
            <p class="text-on-surface-variant">Blog list và subscribe button đã hoạt động.</p>
        </div>

        <form method="POST" action="?url=blog/subscribe" class="flex gap-3">
            <input
                type="email"
                name="email"
                required
                placeholder="Your email"
                class="rounded-xl border border-outline-variant bg-white"
            >
            <button type="submit" class="px-5 py-3 rounded-xl bg-primary text-white font-semibold">
                Subscribe
            </button>
        </form>
    </div>

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

    <?php if (!isset($blogs) || !is_array($blogs) || empty($blogs)): ?>
        <div class="bg-surface-container rounded-2xl p-8">
            Chưa có bài blog nào.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($blogs as $blog): ?>
                <article class="bg-white rounded-2xl overflow-hidden border border-outline-variant/30 shadow-sm">
                    <a href="?url=blog/detail&id=<?= $blog['id'] ?>" class="block aspect-[16/10] overflow-hidden">
                        <img
                            src="<?= htmlspecialchars($blog['image']) ?>"
                            alt="<?= htmlspecialchars($blog['title']) ?>"
                            class="w-full h-full object-cover hover:scale-105 transition duration-500"
                        >
                    </a>

                    <div class="p-6">
                        <div class="text-xs uppercase tracking-widest text-secondary mb-2">
                            <?= htmlspecialchars($blog['category']) ?>
                        </div>

                        <a href="?url=blog/detail&id=<?= $blog['id'] ?>" class="block text-2xl font-bold font-headline hover:text-primary">
                            <?= htmlspecialchars($blog['title']) ?>
                        </a>

                        <p class="text-on-surface-variant mt-3">
                            <?= htmlspecialchars($blog['excerpt']) ?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>