<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<?php
if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

$posts = isset($posts) && is_array($posts) ? $posts : [];
$editingPost = isset($editingPost) && is_array($editingPost) ? $editingPost : null;

$isEditing = $editingPost !== null;

$formAction = $isEditing ? 'update_post' : 'create_post';
$formTitle = $isEditing ? 'Sửa bài viết' : 'Thêm bài viết mới';

$postId = $editingPost['MaBaiViet'] ?? '';
$postTitle = $editingPost['TieuDe'] ?? '';
$postContent = $editingPost['NoiDung'] ?? '';
$postImage = $editingPost['HinhAnhBia'] ?? '';

$totalPosts = count($posts);
?>

<main class="ml-64 flex-1 p-8 lg:p-12 overflow-y-auto">
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h2 class="font-headline text-5xl font-extrabold tracking-tight text-primary leading-none mb-4">
                Quản lý Blog
            </h2>
            <p class="font-body text-lg text-on-surface-variant leading-relaxed opacity-80">
                Thêm, sửa, xóa bài viết blog và quản lý ảnh bìa bài viết.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="index.php?url=admin/blog"
               class="bg-surface-container-high text-primary font-bold px-6 py-3 rounded-xl hover:bg-surface-container-highest transition-colors">
                Danh sách blog
            </a>
            <a href="index.php?url=admin/promo"
               class="bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors">
                Quản lý mã giảm giá
            </a>
        </div>
    </header>

    <?php if (!empty($status) && !empty($message)): ?>
        <div class="mb-8 rounded-2xl px-6 py-4 font-bold
            <?= $status === 'success'
                ? 'bg-green-100 text-green-700 border border-green-200'
                : 'bg-red-100 text-red-700 border border-red-200' ?>">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
        <section class="xl:col-span-1 bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/20">
            <h3 class="font-headline text-2xl font-bold text-primary mb-6">
                <?= e($formTitle) ?>
            </h3>

            <form method="POST" action="index.php?url=admin/blog" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="action" value="<?= e($formAction) ?>">
                <input type="hidden" name="post_id" value="<?= e($postId) ?>">
                <input type="hidden" name="current_image" value="<?= e($postImage) ?>">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Tiêu đề
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="<?= e($postTitle) ?>"
                        placeholder="Nhập tiêu đề bài viết"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Nội dung
                    </label>
                    <textarea
                        name="content"
                        rows="8"
                        placeholder="Nhập nội dung bài viết"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:outline-none"
                        required
                    ><?= e($postContent) ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-primary mb-2">
                        Ảnh bìa
                    </label>
                    <input
                        type="file"
                        name="cover_image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="w-full rounded-xl border border-outline-variant/30 bg-white px-4 py-3"
                    >

                    <?php if ($postImage !== ''): ?>
                        <div class="mt-4">
                            <p class="text-xs text-on-surface-variant mb-2">Ảnh hiện tại:</p>
                            <img src="<?= e($postImage) ?>" alt="<?= e($postTitle) ?>" class="w-full h-40 object-cover rounded-xl border">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-primary text-white font-bold px-6 py-3 rounded-xl hover:opacity-95 transition-colors"
                    >
                        <?= $isEditing ? 'Cập nhật bài viết' : 'Thêm bài viết' ?>
                    </button>

                    <?php if ($isEditing): ?>
                        <a href="index.php?url=admin/blog"
                           class="px-6 py-3 rounded-xl bg-surface-container-high text-primary font-bold">
                            Hủy
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <section class="xl:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-surface-container-low p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-4">article</span>
                    <p class="text-4xl font-headline font-black text-primary"><?= $totalPosts ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mt-1">
                        Tổng bài viết
                    </p>
                </div>

                <div class="bg-primary text-white p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-white text-3xl mb-4">edit_note</span>
                    <p class="text-4xl font-headline font-black"><?= $totalPosts ?></p>
                    <p class="text-xs font-bold uppercase tracking-widest text-white/70 mt-1">
                        Bài đang quản lý
                    </p>
                </div>

                <div class="bg-surface-container-low p-6 rounded-2xl">
                    <span class="material-symbols-outlined text-primary text-3xl mb-4">image</span>
                    <p class="text-4xl font-headline font-black text-primary">
                        <?= count(array_filter($posts, function ($post) {
                            return !empty($post['HinhAnhBia']);
                        })) ?>
                    </p>
                    <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mt-1">
                        Có ảnh bìa
                    </p>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/20 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/20 flex items-center justify-between">
                    <h3 class="font-headline text-2xl font-bold text-primary">
                        Danh sách bài viết
                    </h3>
                    <span class="text-sm text-on-surface-variant">
                        <?= $totalPosts ?> bài viết
                    </span>
                </div>

                <?php if (!empty($posts)): ?>
                    <div class="divide-y divide-outline-variant/10">
                        <?php foreach ($posts as $post): ?>
                            <?php
                            $id = $post['MaBaiViet'] ?? '';
                            $titleText = $post['TieuDe'] ?? 'Không có tiêu đề';
                            $contentText = $post['NoiDung'] ?? '';
                            $image = $post['HinhAnhBia'] ?? '';
                            $date = $post['NgayDang'] ?? '';
                            $author = $post['TenTacGia'] ?? 'Admin';
                            ?>
                            <article class="p-6 flex flex-col md:flex-row gap-5 hover:bg-surface-container-low transition-colors">
                                <div class="w-full md:w-32 h-28 flex-shrink-0">
                                    <?php if ($image !== ''): ?>
                                        <img
                                            src="<?= e($image) ?>"
                                            alt="<?= e($titleText) ?>"
                                            class="w-full h-full object-cover rounded-xl border"
                                        >
                                    <?php else: ?>
                                        <div class="w-full h-full rounded-xl bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined text-4xl">article</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 flex-wrap mb-2">
                                        <span class="text-[10px] font-bold uppercase tracking-widest bg-primary/10 text-primary px-3 py-1 rounded-full">
                                            Blog
                                        </span>
                                        <span class="text-xs text-on-surface-variant">
                                            <?= e($date) ?>
                                        </span>
                                        <span class="text-xs text-on-surface-variant">
                                            Tác giả: <?= e($author) ?>
                                        </span>
                                    </div>

                                    <h4 class="font-headline text-xl font-bold text-primary mb-2">
                                        <?= e($titleText) ?>
                                    </h4>

                                    <p class="text-sm text-on-surface-variant line-clamp-2">
                                        <?= e(mb_strimwidth(strip_tags($contentText), 0, 160, '...')) ?>
                                    </p>
                                </div>

                                <div class="flex md:flex-col gap-2">
                                    <a
                                        href="index.php?url=admin/blog/edit/<?= urlencode((string)$id) ?>"
                                        class="inline-flex items-center justify-center gap-1 px-4 py-2 rounded-xl bg-surface-container-high text-primary font-bold hover:bg-surface-container-highest"
                                    >
                                        <span class="material-symbols-outlined text-base">edit</span>
                                        Sửa
                                    </a>

                                    <a
                                        href="index.php?url=admin/blog/delete/<?= urlencode((string)$id) ?>"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?')"
                                        class="inline-flex items-center justify-center gap-1 px-4 py-2 rounded-xl bg-red-100 text-red-700 font-bold hover:bg-red-200"
                                    >
                                        <span class="material-symbols-outlined text-base">delete</span>
                                        Xóa
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-3xl">article</span>
                        </div>
                        <h4 class="font-headline text-2xl font-bold text-primary mb-2">
                            Chưa có bài viết
                        </h4>
                        <p class="text-on-surface-variant">
                            Hãy thêm bài viết đầu tiên bằng form bên trái.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>