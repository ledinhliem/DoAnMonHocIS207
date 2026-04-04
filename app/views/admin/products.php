<?php include __DIR__ . '/../layouts/admin_header.php'; ?>

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] flex flex-col py-8 z-40">
    <div class="px-6 mb-10">
        <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
        <p class="text-xs text-[#191c18]/60 mt-1 uppercase tracking-widest font-bold">Eco-Management Suite</p>
    </div>

    <nav class="flex-1 space-y-1">
        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Dashboard</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Inventory</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Suppliers</span>
        </a>

        <a class="bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform" href="#">
            <span class="material-symbols-outlined">eco</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Products</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Orders</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Reviews</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">article</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Blog</span>
        </a>

        <a class="text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200" href="#">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Settings</span>
        </a>
    </nav>

    <div class="px-6 pt-6 border-t border-[#c5c8ba]/20 mt-auto">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">AZ</div>
            <div>
                <p class="text-sm font-bold text-[#384e21]">Admin User</p>
                <p class="text-xs text-on-surface-variant">Super Admin</p>
            </div>
        </div>
        <button class="w-full bg-secondary-container text-on-secondary-container px-4 py-2 rounded-lg text-sm font-bold hover:opacity-90 transition-opacity">
            Export Reports
        </button>
    </div>
</aside>

<!-- Main Content -->
<main class="ml-64 p-8 lg:p-12">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
        <div>
            <h2 class="text-5xl font-black text-primary tracking-tighter mb-2">Products</h2>
            <p class="text-on-surface-variant text-lg max-w-xl">Manage your sustainable catalog. Track inventory levels, refine categories, and update product details.</p>
        </div>
        <button class="flex items-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-container transition-colors shadow-lg shadow-primary/10">
            <span class="material-symbols-outlined">add</span>
            Add New Product
        </button>
    </header>

    <!-- Search & Filter Controls -->
    <section class="bg-surface-container-low rounded-xl p-6 mb-10 flex flex-col lg:flex-row gap-6 items-center shadow-sm">
        <div class="relative w-full lg:flex-1">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-outline/60" placeholder="Search by name, SKU, or keyword..." type="text"/>
        </div>

        <div class="flex flex-wrap gap-4 w-full lg:w-auto">
            <div class="relative group min-w-[180px]">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">DANHMUC</label>
                <select class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer">
                    <option>All Categories</option>
                    <option>Kitchenware</option>
                    <option>Personal Care</option>
                    <option>Home Decor</option>
                    <option>Textiles</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
            </div>

            <div class="relative group min-w-[180px]">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest absolute top-2 left-4 z-10">THUONGHIEU</label>
                <select class="w-full pt-6 pb-2 px-4 bg-surface-container-lowest border-none rounded-lg focus:ring-2 focus:ring-primary/20 appearance-none text-on-surface font-medium cursor-pointer">
                    <option>All Brands</option>
                    <option>EcoLife</option>
                    <option>BambooWay</option>
                    <option>PureEarth</option>
                    <option>Zentro Basics</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
            </div>

            <button class="bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-lg flex items-center gap-2 hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">tune</span>
                Advanced
            </button>
        </div>
    </section>

    <!-- Product Grid (Asymmetric Bento Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Featured Product Card (Large) -->
        <article class="col-span-1 md:col-span-2 bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex flex-col lg:flex-row h-full">
                <div class="lg:w-2/5 relative h-64 lg:h-auto overflow-hidden">
                    <img alt="Premium Ceramic Set" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Modern organic ceramic vase set on a textured beige surface with soft natural shadows and minimal aesthetic" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAgQToHppMJ63_0BTRPQFKS5pWO6Tckfg6GO6hYdmb6bQzIkXP6WGqRm-aBrsDPHaNwZkBSzv4GsanUggF5Tw9ARComH5SdiS7ZbMRQrwJAXA_APNy2tr9d7PJ8wkxzniRsb2PzUR7dMo9-J7jfEQWKz5Id5hoA2O5OwZERcZFqccxciccK6UPqPe1DAppuOKqidYMQAdOM3vi4EThPdo7rSHkhm6OFWhAlmjDISrKRe94ykX00oefrQRF6WMp5eShs5ssyv5P2gBg"/>
                    <div class="absolute top-4 left-4 bg-primary text-on-primary text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest">Featured</div>
                </div>

                <div class="lg:w-3/5 p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-sm font-bold text-secondary tracking-wide">THUONGHIEU: PureEarth</span>
                            <div class="flex gap-2">
                                <button class="p-2 text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-xl">edit</span></button>
                                <button class="p-2 text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-xl">delete</span></button>
                            </div>
                        </div>

                        <h3 class="text-3xl font-bold text-on-surface mb-2 leading-tight">Handcrafted Artisan Stoneware Set</h3>
                        <p class="text-on-surface-variant mb-6 leading-relaxed">Sustainably sourced clay with lead-free glazing. Each piece is unique and carbon-neutral in production.</p>

                        <div class="flex items-center gap-4">
                            <div class="bg-surface-tint/10 px-4 py-2 rounded-full flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">inventory</span>
                                <span class="text-sm font-bold text-primary">42 in stock</span>
                            </div>
                            <span class="text-2xl font-black text-primary">$185.00</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-outline-variant/20 flex gap-4">
                        <span class="bg-surface-container-high px-3 py-1 rounded-md text-[10px] font-bold text-outline uppercase tracking-wider">DANHMUC: Home Decor</span>
                        <span class="bg-surface-container-high px-3 py-1 rounded-md text-[10px] font-bold text-outline uppercase tracking-wider">SKU: STN-992-H</span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Standard Product Card 1 -->
        <article class="bg-surface-container-lowest rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
            <div class="relative h-48 rounded-lg overflow-hidden mb-6">
                <img alt="Organic Linen" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Folded natural linen bedding in soft olive green and cream colors arranged neatly on a wooden shelf" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0u96TsaHprBbvKbmqjBKcsT2eqGiKNrT3JJvJQdmzlrpsJM8dhCH6csIMJFpAbc31ZYllaa62f9qERmlpMt-EtyiL8cYxBESbDLIoWlE54j9BB-h6fTxw-rGEz0MfzTXA6qeHZ3qyzXPXuyRbRh55Nstg7nQe_JT5fmIPsy33ihHdTiiiAimu-gA1fwgYkDf40NBPxzfneOjqj23lQF9fhVrxgfDcuU4g4XdWlrPJxK9mUbXlRjcTma8blMCwsUBJ-cQexrawHWY"/>
                <div class="absolute top-3 right-3 flex flex-col gap-2">
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <span class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">THUONGHIEU: EcoLife</span>
                <h3 class="text-xl font-bold text-on-surface mb-2">French Linen Pillowcases</h3>
                <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">Pre-washed for extra softness. Naturally hypoallergenic and moisture-wicking.</p>
                <div class="mt-auto flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">DANHMUC: Textiles</p>
                        <p class="text-2xl font-black text-primary">$45.00</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-error uppercase mb-1">Low Stock</span>
                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                            <div class="bg-error w-1/4 h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Standard Product Card 2 -->
        <article class="bg-surface-container-lowest rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
            <div class="relative h-48 rounded-lg overflow-hidden mb-6">
                <img alt="Bamboo Kits" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Assortment of bamboo toothbrushes and organic cotton pads in a minimalist glass jar on a white marble background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNrOz17zPq_2prQQ92fW3_0yTXSyoLDt8cNMDgE8WSLuexJAblpIU1DKC_5p2yw_t1tKhrm7LaB6mgHMaH7G2pv1lmkchwjFtQgnOkBq_Ia6BETA5gS4NE2Rh2bpjElYxCOhaDDF-kNbt9QQqBJLMEbVxK9cPkPhdOyTfItHu9jwyUU3DAXgUaxOz_gsiL7GuRmX-DxkzdIXnFIZy_vD6BmJb7hFHshGp9GElpVGAoAwi-Ms0RfDvlFms8AMpyOlNKiTsKSzS4wM0"/>
                <div class="absolute top-3 right-3 flex flex-col gap-2">
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <span class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">THUONGHIEU: BambooWay</span>
                <h3 class="text-xl font-bold text-on-surface mb-2">Zero-Waste Bathroom Kit</h3>
                <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">Complete set for a plastic-free morning routine. Biodegradable materials.</p>
                <div class="mt-auto flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">DANHMUC: Personal Care</p>
                        <p class="text-2xl font-black text-primary">$29.00</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-primary uppercase mb-1">128 Units</span>
                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                            <div class="bg-primary w-3/4 h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Standard Product Card 3 -->
        <article class="bg-surface-container-lowest rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
            <div class="relative h-48 rounded-lg overflow-hidden mb-6">
                <img alt="Storage Containers" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Modern eco-friendly restaurant kitchen showing reusable storage containers and bamboo utensils in soft bright lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAXSg-1jLCyhf6K5tqYzl77k8cQStCjgXIEvwvpo21lLK3AdZFcFxw3aFNdr0_FHgDhBbRLYzG9__YUKJ0Zm2n9pny6QOcfO08JKxDJi-jzkqTUXzBBueSNthpqnHjW63FjvBJKeGT42VfgJYK70ic0YLIJPV5P4MoRFRk7AIsSzlBIBK2nHxJ-G5RUxcDgGFPGGBics4TcpOkBKgVLfAE2vE4d1OV_vY-9rvcv5_HrEH7IzaS9Bf8XHOFvxcwnav2QwHuijEbu2XA"/>
                <div class="absolute top-3 right-3 flex flex-col gap-2">
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <span class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">THUONGHIEU: Zentro Basics</span>
                <h3 class="text-xl font-bold text-on-surface mb-2">Borosilicate Glass Jars</h3>
                <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">Heat-resistant glass with FSC certified acacia wood lids. Airtight seal.</p>
                <div class="mt-auto flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">DANHMUC: Kitchenware</p>
                        <p class="text-2xl font-black text-primary">$18.00</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-primary uppercase mb-1">In Stock</span>
                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                            <div class="bg-primary w-full h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Standard Product Card 4 -->
        <article class="bg-surface-container-lowest rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
            <div class="relative h-48 rounded-lg overflow-hidden mb-6">
                <img alt="Shopping Bags" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Reusable shopping bags made of natural organic cotton hanging on a wooden hook against a white textured wall" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWWeng4jf7e9NMwtXVI7ZmHztbmZ5VXuEBdkv0KGuPv-oYjVWDP_2arwfcbRewZTYP_sCC3aSa57EgY7zy9JyOR-TrBDU5yEqFYppzVSeiitPiStwnk6USGFSBZ3budPh-ehhWp_OcRKRUm-71jtrqmZPkS6ZmsvwwPHHQEtWXMf9ML6XxWz4M_1lja8_i28HGvx0mSmfGOmpfFm0gd_4o1bRvxdOhb_Kh_SkTsY8sCDc1gf0ArAPasdFfLLlJPAx6zo2XEW4-WnI"/>
                <div class="absolute top-3 right-3 flex flex-col gap-2">
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-primary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                    <button class="bg-white/90 backdrop-blur-md p-2 rounded-full shadow-sm text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <span class="text-[10px] font-bold text-secondary uppercase tracking-widest mb-1">THUONGHIEU: PureEarth</span>
                <h3 class="text-xl font-bold text-on-surface mb-2">Organic Canvas Tote</h3>
                <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">Heavyweight cotton canvas with reinforced handles. Machine washable.</p>
                <div class="mt-auto flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-outline uppercase tracking-wider mb-1">DANHMUC: Textiles</p>
                        <p class="text-2xl font-black text-primary">$22.00</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-primary uppercase mb-1">In Stock</span>
                        <div class="w-24 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
                            <div class="bg-primary w-full h-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <!-- Pagination -->
    <div class="mt-16 flex justify-center">
        <nav class="inline-flex items-center gap-1 bg-surface-container rounded-full px-2 py-2">
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-on-primary font-bold text-sm">1</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant">2</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant">3</button>
            <span class="px-2 text-outline">...</span>
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface font-bold text-sm hover:bg-surface-variant">12</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-full text-outline hover:bg-surface-variant transition-colors">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </nav>
    </div>
</main>

<!-- Footer -->
<footer class="ml-64 flex flex-col md:flex-row justify-between items-center px-12 py-12 mt-20 border-t border-[#c5c8ba]/10 bg-surface-container-low text-primary">
    <div class="mb-6 md:mb-0">
        <h4 class="font-['Epilogue'] font-bold text-[#384e21] text-xl">Zentro</h4>
        <p class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 mt-1">© 2024 Zentro Sustainable Living. Crafted for the conscious.</p>
    </div>
    <div class="flex gap-8">
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Privacy Policy</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Terms of Service</a>
        <a class="font-['Be_Vietnam_Pro'] text-sm tracking-wide text-[#191c18]/50 hover:text-[#384e21] underline underline-offset-4 transition-opacity opacity-80 hover:opacity-100" href="#">Contact Us</a>
    </div>
</footer>

<?php include __DIR__ . '/../layouts/admin_footer.php'; ?>