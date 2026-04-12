<?php $currentPage = 'reviews'; ?>
<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="p-12 min-h-screen">
    <header class="mb-12 flex justify-between items-end">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant text-sm mb-4">
                <span>Admin</span>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-medium">DANHGIA</span>
            </nav>
            <h2 class="text-5xl font-black tracking-tighter text-primary">Review Moderation</h2>
            <p class="text-on-surface-variant mt-2 text-lg">Maintain the integrity of the Zentro community experience.</p>
        </div>

        <div class="flex gap-4">
            <button
                type="button"
                onclick="alert('Average Rating: 4.8 stars')"
                class="bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3 hover:bg-surface-container transition-colors"
            >
                <span class="text-primary font-bold text-2xl">4.8</span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <div>
                    <div class="flex text-primary">
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                    </div>
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Average Rating</p>
                </div>
            </button>

            <button
                type="button"
                onclick="filterReviewsByTab('pending', this)"
                class="review-tab-btn bg-surface-container-high px-6 py-3 rounded-xl flex items-center gap-3 hover:bg-surface-container transition-colors"
            >
                <span class="text-primary font-bold text-2xl">12</span>
                <div class="h-8 w-[1px] bg-outline-variant/30"></div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider leading-tight">Pending<br/>Moderation</p>
            </button>
        </div>
    </header>

    <section class="grid grid-cols-12 gap-8">
        <div class="col-span-12 lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex gap-2">
                    <button
                        type="button"
                        onclick="filterReviewsByTab('all', this)"
                        class="review-filter-btn px-4 py-2 bg-primary text-on-primary rounded-full text-sm font-medium"
                    >
                        All Reviews
                    </button>
                    <button
                        type="button"
                        onclick="filterReviewsByTab('pending', this)"
                        class="review-filter-btn px-4 py-2 bg-surface-container-high text-on-surface-variant rounded-full text-sm font-medium hover:bg-surface-variant transition-colors"
                    >
                        Pending
                    </button>
                    <button
                        type="button"
                        onclick="filterReviewsByTab('flagged', this)"
                        class="review-filter-btn px-4 py-2 bg-surface-container-high text-on-surface-variant rounded-full text-sm font-medium hover:bg-surface-variant transition-colors"
                    >
                        Flagged
                    </button>
                </div>

                <div class="relative">
                    <input
                        id="review-search"
                        oninput="filterReviewsSearch()"
                        class="bg-surface-container-high border-none rounded-full pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 w-64 transition-all"
                        placeholder="Search customer or content..."
                        type="text"
                    />
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                </div>
            </div>

            <div id="review-list" class="space-y-4">
                <div
                    class="review-card bg-surface-container-lowest p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group"
                    data-type="pending"
                    data-customer="Ethan Rivers"
                    data-content="Sustainable Bamboo Bedding Set Absolutely in love with the texture"
                >
                    <div class="absolute top-0 right-0 w-1.5 h-full bg-primary-fixed-dim opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                <img alt="Customer Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8BbBuEr3q0F2lLDlObnIR6Lgwc9jbsdodiWhyITD-1b0tAqqkWZa7n2O1hMeJ2cQX2vUXDpiZqKbX-lPpHCHmxddmHEbjhNOA0eyPmOsgxOlo7tmhR3hCrdKYdcb1Vie6aY1QcXJ65GDAb3WvXGygjDkPvt47lGNoS6kwnE92rdQn4fmgCKZHq0666egAw81Q_tur4SQl9OcZfbhRXhVFJV6h5zXchdfRPcKFImWsd4_RHJ3kUjp0pyTDxnk9siVMtsz7SCTwRdk"/>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-on-surface">Ethan Rivers</h4>
                                <p class="text-xs text-on-surface-variant">Verified Purchase • 2 hours ago</p>
                            </div>
                        </div>

                        <div class="flex text-[#4e6535]">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="font-bold text-primary mb-2">Sustainable Bamboo Bedding Set</p>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            Absolutely in love with the texture of this bedding. It's so much softer than I expected and knowing it's sustainably sourced makes sleep that much better. The packaging was also completely plastic-free which I really appreciate.
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-outline-variant/10">
                        <div class="flex gap-4">
                            <button
                                type="button"
                                onclick="alert('Approved review from Ethan Rivers')"
                                class="flex items-center gap-2 text-primary text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Approve
                            </button>
                            <button
                                type="button"
                                onclick="alert('Reply to Ethan Rivers')"
                                class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">reply</span>
                                Reply
                            </button>
                            <button
                                type="button"
                                onclick="alert('Delete review from Ethan Rivers')"
                                class="flex items-center gap-2 text-error text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Delete
                            </button>
                        </div>
                        <span class="bg-primary-fixed-dim/20 text-primary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">New Review</span>
                    </div>
                </div>

                <div
                    class="review-card bg-surface-container-lowest p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group"
                    data-type="flagged"
                    data-customer="Maya Chen"
                    data-content="Artisan Terracotta Vase Flagged Potential inappropriate language or spam"
                >
                    <div class="absolute top-0 right-0 w-1.5 h-full bg-error/20 opacity-100 transition-opacity"></div>

                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                <img alt="Customer Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC9QmvobrkCyik5qlP8cGj0NbZpgibAahm1fS9tqn7hmDMsEvqR6kgtDDaVxX-1x_iRQtIJ9Lhe6KN-yj5ETVJtRFhCx6Od9XCuKeArzFw3bfi6tjuJVyn4gzxeMdYWY21Ip7qFRkadM1bUrMmlbzu-DStcQvYPsy9Pxgow6P0_6EW3GM4xO2E3mCP-_SJ70bd4tKi_A8HovIyBUAL_iAeNiXNPUVKtV-2kLUz0S1k49_SURp4_Vbckb7m7ypqVO1AJYK97l4OXajo"/>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-on-surface">Maya Chen</h4>
                                <p class="text-xs text-on-surface-variant">Verified Purchase • 5 hours ago</p>
                            </div>
                        </div>

                        <div class="flex text-[#4e6535]">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                            <span class="material-symbols-outlined">star</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="font-bold text-primary mb-2">Artisan Terracotta Vase</p>
                        <p class="text-error bg-error-container/30 p-4 rounded-xl text-sm italic mb-4">
                            Flagged: Potential inappropriate language or spam content.
                        </p>
                        <p class="text-on-surface-variant leading-relaxed text-sm">
                            I received this item and it was broken. This is ridiculous, I want my money back immediately. [Filtered Content] is terrible service!
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-outline-variant/10">
                        <div class="flex gap-4">
                            <button
                                type="button"
                                onclick="alert('Approved flagged review from Maya Chen')"
                                class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Approve Anyway
                            </button>
                            <button
                                type="button"
                                onclick="alert('Contact customer: Maya Chen')"
                                class="flex items-center gap-2 text-primary text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">contact_support</span>
                                Contact Customer
                            </button>
                            <button
                                type="button"
                                onclick="alert('Delete permanently: Maya Chen review')"
                                class="flex items-center gap-2 text-error text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">delete_forever</span>
                                Delete Permanently
                            </button>
                        </div>
                        <span class="bg-error/10 text-error px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Flagged</span>
                    </div>
                </div>

                <div
                    class="review-card bg-surface-container-lowest p-8 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group"
                    data-type="replied"
                    data-customer="Lucas Thorne"
                    data-content="Recycled Glass Water Pitcher Elegant and functional"
                >
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                <img alt="Customer Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDDslEyvVa9eLCFK5Z4HowJPhRGryveqUsqdOir3MtJfqsCeQY_tUaaTHw7mKhnJdwnwegE_S_DtCq7Hej2UE_ZckjSr_YZsf2LyxtpC1Q2XlCnVivr2bNhsJRYKDUX9kCMYQaudWqu7Qngu6CgaczNTTW121T1yVz5sHiigwEKI73_Y-S9B_s3di1-IL1B-oASlfW83vESyLCQEjLPEcdmbSWmqVAD2-dRrOEE5-9_Un9N9F-z0aZh7LKo0HMFxEcpVkdUyn2_Zjc"/>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-on-surface">Lucas Thorne</h4>
                                <p class="text-xs text-on-surface-variant">Verified Purchase • Yesterday</p>
                            </div>
                        </div>

                        <div class="flex text-[#4e6535]">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined">star</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="font-bold text-primary mb-2">Recycled Glass Water Pitcher</p>
                        <p class="text-on-surface-variant leading-relaxed text-sm">Elegant and functional. Small bubble in the glass but it adds character. Great piece.</p>
                    </div>

                    <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/10">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-primary text-sm">subdirectory_arrow_right</span>
                            <span class="text-[10px] font-black uppercase text-primary tracking-widest">Zentro Team Response</span>
                        </div>
                        <p class="text-sm text-on-surface">
                            Hi Lucas, thank you for your feedback! The bubbles are indeed a natural signature of the hand-blown recycled glass process. We're glad you love it!
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-6 mt-6 border-t border-outline-variant/10">
                        <div class="flex gap-4">
                            <button
                                type="button"
                                onclick="alert('Edit response for Lucas Thorne')"
                                class="flex items-center gap-2 text-on-surface-variant text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit Response
                            </button>
                            <button
                                type="button"
                                onclick="alert('Delete response for Lucas Thorne')"
                                class="flex items-center gap-2 text-error text-sm font-bold hover:underline underline-offset-4"
                            >
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Delete
                            </button>
                        </div>
                        <span class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Replied</span>
                    </div>
                </div>
            </div>
        </div>

        <aside class="col-span-12 lg:col-span-4 space-y-8">
            <button
                type="button"
                onclick="alert('Moderation Stats\\n\\nApproval Rate: 92%\\nResponse Time: 4.2 hrs\\nTotal Reviews: 1.2k\\nResponse Rate: 85%')"
                class="bg-surface-container-high p-8 rounded-3xl w-full text-left hover:bg-surface-container transition-colors"
            >
                <h3 class="text-xl font-bold text-primary mb-6">Moderation Stats</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-2">
                            <span>Approval Rate</span>
                            <span>92%</span>
                        </div>
                        <div class="w-full h-2 bg-surface rounded-full overflow-hidden">
                            <div class="bg-primary h-full" style="width: 92%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-2">
                            <span>Response Time</span>
                            <span>4.2 hrs</span>
                        </div>
                        <div class="w-full h-2 bg-surface rounded-full overflow-hidden">
                            <div class="bg-primary-container h-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-outline-variant/20 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-black text-primary">1.2k</p>
                        <p class="text-[10px] font-bold uppercase text-on-surface-variant tracking-wider">Total Reviews</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-black text-primary">85%</p>
                        <p class="text-[10px] font-bold uppercase text-on-surface-variant tracking-wider">Response Rate</p>
                    </div>
                </div>
            </button>

            <div class="bg-primary p-8 rounded-3xl text-on-primary">
                <h3 class="text-xl font-bold mb-4">Moderation Policy</h3>
                <p class="text-sm opacity-80 leading-relaxed mb-6">
                    Always maintain a professional, helpful tone. Flag content that contains personal data, hate speech, or spam. Aim to respond to 3-star and below reviews within 24 hours.
                </p>
                <button
                    type="button"
                    onclick="alert('Read Full Guidelines mock')"
                    class="w-full py-3 bg-white/10 hover:bg-white/20 transition-colors border border-white/20 rounded-xl font-bold text-sm flex items-center justify-center gap-2"
                >
                    <span class="material-symbols-outlined">menu_book</span>
                    Read Full Guidelines
                </button>
            </div>

            <div class="bg-surface-container p-8 rounded-3xl">
                <h3 class="text-xl font-bold text-primary mb-6">Trending Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="fillReviewSearch('#FastShipping')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#FastShipping</button>
                    <button type="button" onclick="fillReviewSearch('#BambooTexture')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#BambooTexture</button>
                    <button type="button" onclick="fillReviewSearch('#GiftPackaging')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#GiftPackaging</button>
                    <button type="button" onclick="fillReviewSearch('#EcoFriendly')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#EcoFriendly</button>
                    <button type="button" onclick="fillReviewSearch('#ArrivedBroken')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#ArrivedBroken</button>
                    <button type="button" onclick="fillReviewSearch('#StitchingQuality')" class="px-3 py-1 bg-surface-container-lowest rounded-full text-xs font-medium text-on-surface">#StitchingQuality</button>
                </div>
            </div>
        </aside>
    </section>
</div>

<script>
    let currentReviewTab = 'all';

    function setReviewFilterButton(activeButton) {
        document.querySelectorAll('.review-filter-btn').forEach(btn => {
            btn.classList.remove('bg-primary', 'text-on-primary');
            btn.classList.add('bg-surface-container-high', 'text-on-surface-variant');
        });

        if (activeButton) {
            activeButton.classList.remove('bg-surface-container-high', 'text-on-surface-variant');
            activeButton.classList.add('bg-primary', 'text-on-primary');
        }
    }

    function filterReviewsByTab(tab, button = null) {
        currentReviewTab = tab;
        const cards = document.querySelectorAll('.review-card');

        if (button && button.classList.contains('review-filter-btn')) {
            setReviewFilterButton(button);
        }

        cards.forEach(card => {
            const type = card.dataset.type;
            const matchesTab = tab === 'all' || type === tab;
            const matchesSearch = matchesReviewSearch(card);

            card.style.display = (matchesTab && matchesSearch) ? 'block' : 'none';
        });
    }

    function matchesReviewSearch(card) {
        const keyword = document.getElementById('review-search').value.toLowerCase().trim();
        const customer = card.dataset.customer.toLowerCase();
        const content = card.dataset.content.toLowerCase();

        if (!keyword) return true;
        return customer.includes(keyword) || content.includes(keyword);
    }

    function filterReviewsSearch() {
        const cards = document.querySelectorAll('.review-card');

        cards.forEach(card => {
            const type = card.dataset.type;
            const matchesTab = currentReviewTab === 'all' || type === currentReviewTab;
            const matchesSearch = matchesReviewSearch(card);

            card.style.display = (matchesTab && matchesSearch) ? 'block' : 'none';
        });
    }

    function fillReviewSearch(tag) {
        const input = document.getElementById('review-search');
        if (input) {
            input.value = tag;
            filterReviewsSearch();
            alert('Tag selected: ' + tag);
        }
    }
</script>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>