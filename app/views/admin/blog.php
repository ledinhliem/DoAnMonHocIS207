<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
$keyword = $_GET['keyword'] ?? '';
$tab     = $_GET['tab'] ?? 'all';

$postList = [];
if (isset($posts) && is_array($posts)) {
    $postList = $posts;
} elseif (isset($blogs) && is_array($blogs)) {
    $postList = $blogs;
} elseif (isset($data['posts']) && is_array($data['posts'])) {
    $postList = $data['posts'];
} elseif (isset($data['blogs']) && is_array($data['blogs'])) {
    $postList = $data['blogs'];
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('postValue')) {
    function postValue($post, $keys, $default = '') {
        foreach ((array)$keys as $key) {
            if (isset($post[$key]) && $post[$key] !== '') {
                return $post[$key];
            }
        }
        return $default;
    }
}

if (!function_exists('postStatusBadge')) {
    function postStatusBadge($status) {
        $status = strtolower(trim((string)$status));

        switch ($status) {
            case 'published':
                return 'bg-primary/10 text-primary';
            case 'draft':
                return 'bg-secondary-container text-on-secondary-container';
            case 'review':
            case 'pending':
                return 'bg-amber-100 text-amber-700';
            default:
                return 'bg-surface-container-high text-on-surface-variant';
        }
    }
}

$totalPosts = count($postList);
$publishedCount = 0;
$draftCount = 0;
$totalViews = 0;

foreach ($postList as $post) {
    $status = strtolower((string) postValue($post, ['status'], 'draft'));
    $views = (int) postValue($post, ['views', 'read_count', 'total_views'], 0);

    if ($status === 'published') {
        $publishedCount++;
    }
    if ($status === 'draft') {
        $draftCount++;
    }

    $totalViews += $views;
}
?>

<main class="ml-64 flex-1 p-8 lg:p-12 overflow-y-auto">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="max-w-2xl">
            <h2 class="font-headline text-5xl font-extrabold tracking-tight text-primary leading-none mb-4">Blog Management</h2>
            <p class="font-body text-lg text-on-surface-variant leading-relaxed opacity-80">
                Manage blog posts, track publishing status, and prepare article actions from one admin view.
            </p>
        </div>
        <div class="flex gap-4 flex-wrap">
            <button type="button" class="bg-surface-container-high text-primary font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined">history</span>
                Revision History
            </button>
            <a href="/is207/index.php?url=blog/create"
               class="bg-primary text-white font-bold px-8 py-3 rounded-xl flex items-center gap-2 hover:opacity-95 shadow-lg shadow-primary/10 transition-all">
                <span class="material-symbols-outlined">add</span>
                Create New Post
            </a>
        </div>
    </header>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary text-3xl">visibility</span>
            <div>
                <p class="text-4xl font-headline font-black text-primary"><?= number_format($totalViews) ?></p>
                <p class="text-xs font-label uppercase tracking-widest text-on-surface-variant mt-1">Total Article Reads</p>
            </div>
        </div>

        <div class="bg-primary text-on-primary p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-white text-3xl">verified</span>
            <div>
                <p class="text-4xl font-headline font-black text-white"><?= $publishedCount ?></p>
                <p class="text-xs font-label uppercase tracking-widest text-white/70 mt-1">Published Posts</p>
            </div>
        </div>

        <div class="bg-secondary-container p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-on-secondary-container text-3xl">edit_note</span>
            <div>
                <p class="text-4xl font-headline font-black text-on-secondary-container"><?= $draftCount ?></p>
                <p class="text-xs font-label uppercase tracking-widest text-on-secondary-container opacity-70 mt-1">Drafts</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary text-3xl">article</span>
            <div>
                <p class="text-4xl font-headline font-black text-primary"><?= $totalPosts ?></p>
                <p class="text-xs font-label uppercase tracking-widest text-on-surface-variant mt-1">Total Posts</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-12 items-start">
        <!-- List Section -->
        <div class="xl:col-span-2">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                <h3 class="font-headline text-2xl font-bold text-primary">Post Directory</h3>

                <div class="flex flex-wrap gap-3">
                    <div class="flex gap-2 bg-surface-container rounded-full p-1">
                        <a href="?tab=all"
                           class="<?= $tab === 'all' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?> text-xs font-bold px-4 py-1.5 rounded-full transition-colors">
                            All
                        </a>
                        <a href="?tab=published"
                           class="<?= $tab === 'published' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?> text-xs font-bold px-4 py-1.5 rounded-full transition-colors">
                            Published
                        </a>
                        <a href="?tab=draft"
                           class="<?= $tab === 'draft' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-high' ?> text-xs font-bold px-4 py-1.5 rounded-full transition-colors">
                            Drafts
                        </a>
                    </div>

                    <form method="GET" action="" class="flex items-center gap-2">
                        <input type="hidden" name="tab" value="<?= e($tab) ?>">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                            <input
                                type="text"
                                name="keyword"
                                value="<?= e($keyword) ?>"
                                placeholder="Search posts..."
                                class="bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 w-60"
                            />
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-4">
                <?php if (!empty($postList)): ?>
                    <?php foreach ($postList as $post): ?>
                        <?php
                        $id = postValue($post, ['id'], null);
                        $title = postValue($post, ['title', 'name'], 'Untitled post');
                        $excerpt = postValue($post, ['excerpt', 'summary', 'description', 'content'], 'No description available.');
                        $status = postValue($post, ['status'], 'draft');
                        $date = postValue($post, ['published_at', 'updated_at', 'created_at', 'date'], 'Recently');
                        $image = postValue($post, ['image', 'image_url', 'thumbnail'], '');
                        $views = (int) postValue($post, ['views', 'read_count', 'total_views'], 0);
                        ?>
                        <div class="group bg-surface-container-lowest hover:bg-surface p-5 rounded-2xl flex items-center gap-6 transition-all border border-transparent hover:border-outline-variant/20">
                            <?php if ($image !== ''): ?>
                                <img alt="<?= e($title) ?>" class="w-24 h-24 rounded-xl object-cover" src="<?= e($image) ?>">
                            <?php else: ?>
                                <div class="w-24 h-24 rounded-xl bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-3xl">article</span>
                                </div>
                            <?php endif; ?>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1 flex-wrap">
                                    <span class="<?= postStatusBadge($status) ?> text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">
                                        <?= e(ucfirst($status)) ?>
                                    </span>
                                    <span class="text-[10px] text-on-surface-variant/60 font-label"><?= e($date) ?></span>
                                    <span class="text-[10px] text-on-surface-variant/60 font-label"><?= number_format($views) ?> views</span>
                                </div>
                                <h4 class="font-headline text-xl font-bold text-primary mb-1 truncate"><?= e($title) ?></h4>
                                <p class="text-sm text-on-surface-variant line-clamp-2 opacity-70">
                                    <?= e(mb_strimwidth(strip_tags((string)$excerpt), 0, 140, '...')) ?>
                                </p>
                            </div>

                            <div class="flex gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                <?php if ($id !== null): ?>
                                    <a href="/is207/index.php?url=blog/edit/<?= urlencode((string)$id) ?>"
                                       class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="/is207/index.php?url=blog/delete/<?= urlencode((string)$id) ?>"
                                       onclick="return confirm('Delete this post?')"
                                       class="p-2 text-error hover:bg-red-50 rounded-lg">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                <?php else: ?>
                                    <button type="button" class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button type="button" class="p-2 text-on-surface-variant hover:bg-surface-variant rounded-lg">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-surface-container-lowest rounded-2xl p-12 text-center border border-outline-variant/10">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-3xl">article</span>
                        </div>
                        <h4 class="font-headline text-2xl font-bold text-primary mb-2">No blog posts found</h4>
                        <p class="text-on-surface-variant">
                            There is no blog data to display yet, or your current search/filter returned no results.
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-10 flex items-center justify-between border-t border-outline-variant/20 pt-8">
                <p class="text-sm text-on-surface-variant opacity-60">Showing available posts from current data source</p>
                <div class="flex gap-4">
                    <button type="button" class="text-sm font-bold text-primary opacity-50 cursor-not-allowed">Previous</button>
                    <button type="button" class="text-sm font-bold text-primary">Next</button>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="space-y-8">
            <section class="bg-surface-container rounded-3xl p-8 border-l-8 border-primary">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-headline text-xl font-bold text-primary">Publishing Summary</h3>
                    <span class="material-symbols-outlined text-primary">campaign</span>
                </div>
                <div class="space-y-6">
                    <div class="relative pl-6 border-l-2 border-outline-variant">
                        <div class="absolute -left-1.5 top-0 w-3 h-3 bg-primary rounded-full"></div>
                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">Published</p>
                        <h5 class="text-sm font-bold text-on-surface mb-2"><?= $publishedCount ?> live article(s)</h5>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Posts currently visible to readers.</p>
                    </div>
                    <div class="relative pl-6 border-l-2 border-outline-variant">
                        <div class="absolute -left-1.5 top-0 w-3 h-3 bg-outline-variant rounded-full"></div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Drafts</p>
                        <h5 class="text-sm font-bold text-on-surface mb-2"><?= $draftCount ?> draft post(s)</h5>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Posts still being reviewed or edited.</p>
                    </div>
                </div>
                <button class="w-full mt-8 py-3 bg-surface-container-highest text-primary text-xs font-bold rounded-xl hover:bg-surface-variant transition-colors">
                    Manage Content
                </button>
            </section>

            <section class="bg-surface-container-low rounded-3xl p-8">
                <h3 class="font-headline text-lg font-bold text-primary mb-4">Editorial Quality</h3>
                <ul class="space-y-4">
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs text-on-surface-variant">Use this panel later for actual editorial rules from backend content.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs text-on-surface-variant">Verify titles, excerpts, and publishing status before going live.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-outline-variant">check_circle</span>
                        <span class="text-xs text-on-surface-variant opacity-60">Track views and draft count from real post data.</span>
                    </li>
                </ul>
            </section>

            <div class="bg-primary-container/20 rounded-3xl p-1 overflow-hidden">
                <div class="bg-surface-container-lowest rounded-[1.4rem] p-6">
                    <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-4">Focus Post</p>

                    <?php if (!empty($postList)): ?>
                        <?php
                        $focusPost = $postList[0];
                        $focusTitle = postValue($focusPost, ['title', 'name'], 'Untitled post');
                        $focusImage = postValue($focusPost, ['image', 'image_url', 'thumbnail'], '');
                        $focusStatus = postValue($focusPost, ['status'], 'draft');
                        ?>
                        <?php if ($focusImage !== ''): ?>
                            <img alt="<?= e($focusTitle) ?>" class="w-full h-40 object-cover rounded-xl mb-4" src="<?= e($focusImage) ?>">
                        <?php else: ?>
                            <div class="w-full h-40 bg-surface-container-high rounded-xl mb-4 flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl">article</span>
                            </div>
                        <?php endif; ?>

                        <h4 class="font-headline text-lg font-bold text-primary mb-2 leading-tight"><?= e($focusTitle) ?></h4>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-[10px] font-bold uppercase tracking-wider <?= postStatusBadge($focusStatus) ?> px-3 py-1 rounded-full">
                                <?= e(ucfirst($focusStatus)) ?>
                            </span>
                            <span class="text-[10px] font-medium text-on-surface-variant"><?= number_format((int) postValue($focusPost, ['views', 'read_count', 'total_views'], 0)) ?> views</span>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-40 bg-surface-container-high rounded-xl mb-4 flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl">article</span>
                        </div>
                        <h4 class="font-headline text-lg font-bold text-primary mb-2 leading-tight">No focus post available</h4>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-[10px] font-medium text-on-surface-variant">Waiting for blog data</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="fixed bottom-8 right-8 z-[60] flex gap-3">
    <button class="p-4 bg-surface-container-lowest text-primary rounded-full shadow-2xl border border-outline-variant/10 hover:scale-105 transition-transform">
        <span class="material-symbols-outlined">search</span>
    </button>
    <button class="p-4 bg-primary text-on-primary rounded-full shadow-2xl hover:scale-105 transition-transform flex items-center gap-2 px-6">
        <span class="material-symbols-outlined">edit_square</span>
        <span class="font-bold text-sm">Quick Editor</span>
    </button>
</div>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>