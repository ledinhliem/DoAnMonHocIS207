<?php $currentPage = 'blog'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="flex-1 p-8 lg:p-12 overflow-y-auto">
    <?php if (isset($status)): ?>
        <div id="status-alert" class="mb-6 p-4 rounded-2xl flex items-center gap-3 <?php echo $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> animate-bounce">
            <span class="material-symbols-outlined"><?php echo $status === 'success' ? 'check_circle' : 'error'; ?></span>
            <span class="font-bold"><?php echo $message; ?></span>
        </div>
        <script>setTimeout(() => document.getElementById('status-alert').remove(), 3000);</script>
    <?php endif; ?>

    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
        <div class="max-w-2xl">
            <h2 class="font-headline text-5xl font-extrabold tracking-tight text-primary leading-none mb-4">Blog Management</h2>
            <p class="font-body text-lg text-on-surface-variant leading-relaxed opacity-80">
                Curate your brand's voice and manage environmental impact stories.
            </p>
        </div>
        <div class="flex gap-4">
            <button type="button" class="bg-surface-container-high text-primary font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined">history</span> Revision History
            </button>
            <button type="button" onclick="document.getElementById('modal-create-post').classList.remove('hidden')" class="bg-primary text-white font-bold px-8 py-3 rounded-xl flex items-center gap-2 hover:opacity-95 shadow-lg transition-all">
                <span class="material-symbols-outlined">add</span> Create New Post
            </button>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary text-3xl">visibility</span>
            <div>
                <p class="text-4xl font-headline font-black text-primary">12.4k</p>
                <p class="text-xs font-label uppercase tracking-widest text-on-surface-variant mt-1">Total Article Reads</p>
            </div>
        </div>
        </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-12 items-start">
        <div class="xl:col-span-2">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-headline text-2xl font-bold text-primary">BAIVIET Directory</h3>
                <div class="flex gap-2 bg-surface-container rounded-full p-1">
                    <button type="button" onclick="filterBlogPosts('all', this)" class="blog-filter-btn bg-surface-container-lowest text-primary text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">All</button>
                    <button type="button" onclick="filterBlogPosts('published', this)" class="blog-filter-btn text-on-surface-variant text-xs font-bold px-4 py-1.5 rounded-full hover:bg-surface-container-high">Published</button>
                    <button type="button" onclick="filterBlogPosts('draft', this)" class="blog-filter-btn text-on-surface-variant text-xs font-bold px-4 py-1.5 rounded-full hover:bg-surface-container-high">Drafts</button>
                </div>
            </div>

            <div id="blog-post-list" class="space-y-4">
                <div class="blog-post-card group bg-surface-container-lowest hover:bg-surface p-5 rounded-2xl flex items-center gap-6 transition-all border border-transparent hover:border-outline-variant/20" data-type="published">
                    <img alt="Thumbnail" class="w-24 h-24 rounded-xl object-cover" src="https://picsum.photos/200"/>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded uppercase">Published</span>
                            <span class="text-[10px] text-on-surface-variant/60 font-label">Oct 24, 2024</span>
                        </div>
                        <h4 class="font-headline text-xl font-bold text-primary mb-1">The Future of Circular Textiles</h4>
                        <p class="text-sm text-on-surface-variant line-clamp-1 opacity-70">Exploring closed-loop fashion ecosystem.</p>
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="" method="POST" class="flex gap-2">
                            <input type="hidden" name="post_id" value="101">
                            <button type="submit" name="action" value="edit" class="p-2 text-primary hover:bg-primary/10 rounded-lg">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button type="submit" name="action" value="delete" onclick="return confirm('Xóa bài viết này?')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            </div>
    </div>
</div>

<div id="modal-create-post" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-primary text-white">
            <h3 class="text-2xl font-bold font-headline">Launch New BAIVIET</h3>
            <button onclick="document.getElementById('modal-create-post').classList.add('hidden')" class="hover:rotate-90 transition-transform">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="action" value="create_post">
            
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Article Title *</label>
                <input name="title" required type="text" class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Enter a catchy headline...">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Category</label>
                    <select name="category" class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 outline-none">
                        <option value="sustainability">Sustainability</option>
                        <option value="innovation">Innovation</option>
                        <option value="community">Community</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Status</label>
                    <select name="status" class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 outline-none font-bold text-primary">
                        <option value="draft">Save as Draft</option>
                        <option value="published">Publish Now</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Content Summary *</label>
                <textarea name="summary" required rows="4" class="w-full bg-gray-50 border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="What is this story about?"></textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="flex-1 bg-primary text-white font-bold py-4 rounded-xl hover:opacity-90 transition-all shadow-lg">Launch Campaign</button>
                <button type="button" onclick="document.getElementById('modal-create-post').classList.add('hidden')" class="px-8 py-4 text-gray-500 font-bold border border-gray-200 rounded-xl hover:bg-gray-50">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Logic filter giữ nguyên như Lan đã viết vì nó hoạt động tốt
    function setBlogFilterButton(activeButton) {
        document.querySelectorAll('.blog-filter-btn').forEach(btn => {
            btn.classList.remove('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
            btn.classList.add('text-on-surface-variant');
        });
        if (activeButton) {
            activeButton.classList.remove('text-on-surface-variant');
            activeButton.classList.add('bg-surface-container-lowest', 'text-primary', 'shadow-sm');
        }
    }

    function filterBlogPosts(type, button = null) {
        const cards = document.querySelectorAll('.blog-post-card');
        if (button && button.classList.contains('blog-filter-btn')) {
            setBlogFilterButton(button);
        }
        cards.forEach(card => {
            if (type === 'all' || card.dataset.type === type) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>