<?php include __DIR__ . '/../layouts/admin_header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="ml-64 flex-1 p-8 lg:p-12 overflow-y-auto">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
        <div class="max-w-2xl">
            <h2 class="font-headline text-5xl font-extrabold tracking-tight text-primary leading-none mb-4">Blog Management</h2>
            <p class="font-body text-lg text-on-surface-variant leading-relaxed opacity-80">
                Curate your brand's voice and manage environmental impact stories. Refine BAIVIET drafts or launch global sustainability campaigns.
            </p>
        </div>
        <div class="flex gap-4">
            <button class="bg-surface-container-high text-primary font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined">history</span>
                Revision History
            </button>
            <button class="bg-primary text-white font-bold px-8 py-3 rounded-xl flex items-center gap-2 hover:opacity-95 shadow-lg shadow-primary/10 transition-all">
                <span class="material-symbols-outlined">add</span>
                Create New Post
            </button>
        </div>
    </header>

    <!-- Stats Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary text-3xl">visibility</span>
            <div>
                <p class="text-4xl font-headline font-black text-primary">12.4k</p>
                <p class="text-xs font-label uppercase tracking-widest text-on-surface-variant mt-1">Total Article Reads</p>
            </div>
        </div>
        <div class="bg-primary text-on-primary p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-white text-3xl">verified</span>
            <div>
                <p class="text-4xl font-headline font-black text-white">48</p>
                <p class="text-xs font-label uppercase tracking-widest text-white/70 mt-1">Published Posts</p>
            </div>
        </div>
        <div class="bg-secondary-container p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-on-secondary-container text-3xl">edit_note</span>
            <div>
                <p class="text-4xl font-headline font-black text-on-secondary-container">12</p>
                <p class="text-xs font-label uppercase tracking-widest text-on-secondary-container opacity-70 mt-1">Drafts In Review</p>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between h-40">
            <span class="material-symbols-outlined text-primary text-3xl">campaign</span>
            <div>
                <p class="text-4xl font-headline font-black text-primary">03</p>
                <p class="text-xs font-label uppercase tracking-widest text-on-surface-variant mt-1">Active Campaigns</p>
            </div>
        </div>
    </div>

    <!-- Editorial Split Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-12 items-start">
        <!-- List Section (2/3) -->
        <div class="xl:col-span-2">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-headline text-2xl font-bold text-primary">BAIVIET Directory</h3>
                <div class="flex gap-2 bg-surface-container rounded-full p-1">
                    <button class="bg-surface-container-lowest text-primary text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">All</button>
                    <button class="text-on-surface-variant text-xs font-bold px-4 py-1.5 rounded-full hover:bg-surface-container-high">Published</button>
                    <button class="text-on-surface-variant text-xs font-bold px-4 py-1.5 rounded-full hover:bg-surface-container-high">Drafts</button>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Post Card 1 -->
                <div class="group bg-surface-container-lowest hover:bg-surface p-5 rounded-2xl flex items-center gap-6 transition-all border border-transparent hover:border-outline-variant/20">
                    <img alt="Recycling process" class="w-24 h-24 rounded-xl object-cover" data-alt="vibrant overhead shot of assorted recycling materials including paper and glass organized in minimalist containers" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCiEQ5_3xI0ckGL88nzZWdqkaH_Ovhyvu_wjQXIgF9wpIwFgLaxttMR1M16svs5UEzD9gbaJE-TrB5OTPDJ-5w1Slpl7QLNDcruLnOeItb1jtTxl9ewKWM0HlIRhhUsqicOf3WCbCXV_JFGzxrc1rmSygNpIuZLYa8qlMLtoA64FDQYvPVR-HAy928q5CrWLKVZ3E4ZEllWxIK1Mv3MXEpJzH5o25cZ7knwpqC--8mgXIp3oNj6xGJ4-7oXu7v4hRqdeERdrkJfHus"/>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">Published</span>
                            <span class="text-[10px] text-on-surface-variant/60 font-label">Oct 24, 2024</span>
                        </div>
                        <h4 class="font-headline text-xl font-bold text-primary mb-1">The Future of Circular Textiles</h4>
                        <p class="text-sm text-on-surface-variant line-clamp-1 opacity-70">Exploring how Zentro is pioneering a closed-loop fashion ecosystem.</p>
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-lg"><span class="material-symbols-outlined">edit</span></button>
                        <button class="p-2 text-on-surface-variant hover:bg-surface-variant rounded-lg"><span class="material-symbols-outlined">more_vert</span></button>
                    </div>
                </div>

                <!-- Post Card 2 -->
                <div class="group bg-surface-container-lowest hover:bg-surface p-5 rounded-2xl flex items-center gap-6 transition-all border border-transparent hover:border-outline-variant/20">
                    <img alt="Sustainable gardening" class="w-24 h-24 rounded-xl object-cover" data-alt="sunlit garden with lush green vegetables and herbs growing in raised wooden beds in a serene backyard setting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDA87YdlhtSI4kN3Gtd8jrF38QuC8oUaJghngKc5L1zYN5XdqTD2k2FOuW7aj1rx7Olvip7CjFToMf82fODfy1dqsXVgoJWdBoW88jExSDZMY9MIpaligbc1GNcjCaMgaksapEyndK0alEj15j4kYpk7QLHs64UcBGu-3vADcS_vIT6LT7Bms_wYRHEKkLvYcqBfpRhFIKAqpHrDaVu2pT_FL6-OsD99DCo84tXwpwbtDmFw1JhKORBgvGuoP0kyN4-AQFTXvi0zP8"/>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="bg-secondary-container text-on-secondary-container text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">Draft</span>
                            <span class="text-[10px] text-on-surface-variant/60 font-label">Modified 2h ago</span>
                        </div>
                        <h4 class="font-headline text-xl font-bold text-primary mb-1">Permaculture in Modern Living</h4>
                        <p class="text-sm text-on-surface-variant line-clamp-1 opacity-70">A guide to integrating regenerative agriculture into urban balcony spaces.</p>
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-lg"><span class="material-symbols-outlined">edit</span></button>
                        <button class="p-2 text-on-surface-variant hover:bg-surface-variant rounded-lg"><span class="material-symbols-outlined">more_vert</span></button>
                    </div>
                </div>

                <!-- Post Card 3 -->
                <div class="group bg-surface-container-lowest hover:bg-surface p-5 rounded-2xl flex items-center gap-6 transition-all border border-transparent hover:border-outline-variant/20">
                    <img alt="Mountain landscape" class="w-24 h-24 rounded-xl object-cover" data-alt="cinematic aerial view of misty mountain range during blue hour with soft cool lighting and depth of field" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-qH_gdEEYxvRf4w6ILkD6a217LIG0llBCeBzKgj9iIFOM4IFzGbaQegKWuLHPtjxGPquHWzX9N2s1Oh8358YAicos469rUqCo010UF0EJtu6JGvBBQe2GuxbP11eLPKxW0NhcPnY3cU0TN-I0Cefy-78EBnFMlerXNcyZHH5AR8pM81LcgxKX4ujaiM1TtqAEy1Xe-rNJVQQ3GMaHL7GGjMXMtVe2xWLTiItAkPBSujuNUD80koSmtiMo8jGsEclRrXxHp46OKXU"/>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-tighter">Published</span>
                            <span class="text-[10px] text-on-surface-variant/60 font-label">Oct 12, 2024</span>
                        </div>
                        <h4 class="font-headline text-xl font-bold text-primary mb-1">Reforestation Beyond Saplings</h4>
                        <p class="text-sm text-on-surface-variant line-clamp-1 opacity-70">Why biodiversity matters more than just the number of trees planted.</p>
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="p-2 text-primary hover:bg-primary/10 rounded-lg"><span class="material-symbols-outlined">edit</span></button>
                        <button class="p-2 text-on-surface-variant hover:bg-surface-variant rounded-lg"><span class="material-symbols-outlined">more_vert</span></button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-10 flex items-center justify-between border-t border-outline-variant/20 pt-8">
                <p class="text-sm text-on-surface-variant opacity-60">Showing 1 to 10 of 60 articles</p>
                <div class="flex gap-4">
                    <button class="text-sm font-bold text-primary opacity-50 cursor-not-allowed">Previous</button>
                    <button class="text-sm font-bold text-primary">Next</button>
                </div>
            </div>
        </div>

        <!-- Campaign & Editor Preview (1/3) -->
        <div class="space-y-8">
            <!-- Campaign Updates Section -->
            <section class="bg-surface-container rounded-3xl p-8 border-l-8 border-primary">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-headline text-xl font-bold text-primary">Active Campaigns</h3>
                    <span class="material-symbols-outlined text-primary">campaign</span>
                </div>
                <div class="space-y-6">
                    <div class="relative pl-6 border-l-2 border-outline-variant">
                        <div class="absolute -left-1.5 top-0 w-3 h-3 bg-primary rounded-full"></div>
                        <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">Urgent Update</p>
                        <h5 class="text-sm font-bold text-on-surface mb-2">Zero Plastic October</h5>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Engagement up 40%. New assets needed for the final week wrap-up blog post.</p>
                    </div>
                    <div class="relative pl-6 border-l-2 border-outline-variant">
                        <div class="absolute -left-1.5 top-0 w-3 h-3 bg-outline-variant rounded-full"></div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-1">Scheduled</p>
                        <h5 class="text-sm font-bold text-on-surface mb-2">Ocean Cleanup Drive</h5>
                        <p class="text-xs text-on-surface-variant leading-relaxed">Launch set for Nov 15. Draft content is currently with the legal team.</p>
                    </div>
                </div>
                <button class="w-full mt-8 py-3 bg-surface-container-highest text-primary text-xs font-bold rounded-xl hover:bg-surface-variant transition-colors">
                    Manage Campaigns
                </button>
            </section>

            <!-- Editorial Quick Tips -->
            <section class="bg-surface-container-low rounded-3xl p-8">
                <h3 class="font-headline text-lg font-bold text-primary mb-4">Editorial Quality</h3>
                <ul class="space-y-4">
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs text-on-surface-variant">All BAIVIET must include at least 3 high-res organic visuals.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span class="text-xs text-on-surface-variant">Verify all sustainability metrics with the science team before publish.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-outline-variant">check_circle</span>
                        <span class="text-xs text-on-surface-variant opacity-60">SEO meta descriptions should be under 160 characters.</span>
                    </li>
                </ul>
            </section>

            <!-- Featured Draft Card -->
            <div class="bg-primary-container/20 rounded-3xl p-1 overflow-hidden">
                <div class="bg-surface-container-lowest rounded-[1.4rem] p-6">
                    <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-4">Focus Draft</p>
                    <img alt="Solar farm" class="w-full h-40 object-cover rounded-xl mb-4" data-alt="vast field of modern solar panels reflecting the clear blue sky in a wide valley with distant rolling hills" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAE_hoHZiYe_edqSEA2utBGaV6i529colBZsE-TPGfh6DaysrU-RqsDy4Wb7OP-yNXiccL7SoRXImZ6YXOlGk4rSo5-P27LXLUzQhl0ZFnbjlSKD76PfAkGZBUYsmcXytWnDRORfRWsiCHWZxt_Yb_D2VDieXcFanYPiw0b_89VddFF1kx2CWjAMx9tkibRoCaH9aoTJHq9Qlx9K2mWJZ-ayGmea5THXDtkSop7O1Kw8ARPg-4CCM0t9LS5pMfkKlQeL8Lv-btv4FY"/>
                    <h4 class="font-headline text-lg font-bold text-primary mb-2 leading-tight">Solar Grid: The Heart of Zentro's Operations</h4>
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex -space-x-2">
                            <img alt="User" class="w-6 h-6 rounded-full border-2 border-surface-container-lowest" data-alt="close-up portrait of a woman with natural features and soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB963J8eTD0uG9_u0FToGzrFOLmY5LWukKpe9kEdmCWBlV4I1tpqkywOMlDMr4fPEQL52Ohv0kSpmORFiF8LfR8Wz37_ijsAhs-Um9Clc553m76pgLRPzpodquXIhf1LbkyrjHPi6NWh0kEDz2B7e93Pmn2PHm8USzrUubwdBnrgFJfbPDP1qxZGA7CXJ98e_xvTGvtnS55LZvQiCm-m3aoVXIv3QgJaXtB1dnHXy8CQNKxSrTF_WjDTD45YPXnurzd4FKCShLDSGw"/>
                            <img alt="User" class="w-6 h-6 rounded-full border-2 border-surface-container-lowest" data-alt="portrait of a man with minimalist glasses and calm expression" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAN5UnF3lF1QD-eAQeooTa374ngsJVy046p11QpuAQuMNsc1L7XtYNBNIXubB5lwSc72q0Unbc07tKVwitJSLLvD6yPvB_orzguEYYxF58qhn1Lo6DIRbJCjsZ0LSzNvW3PPe4wYip-g1ospEJLa-LAi1mUI79QQMt4VEToa5tNU18_2cHgbNfSn-aUJob0LU8s1ddM4w0RVCAzrDM2xBR-dXNCaMRa6YW360mea-H0Ib2UwbbN6CDiooOUF93SvExdVw2kG8TZsEY"/>
                        </div>
                        <span class="text-[10px] font-medium text-on-surface-variant">2 Authors Collaborating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Bottom Action Bar (Floating for Focus) -->
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