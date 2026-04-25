<aside class="h-screen w-64 fixed left-0 top-0 bg-[#edefe7] dark:bg-stone-800 border-r border-[#c5c8ba]/20 shadow-[40px_0_40px_-15px_rgba(25,28,24,0.04)] z-50 flex flex-col py-8">
    <div class="px-6 mb-10">
        <h1 class="font-['Epilogue'] font-black text-[#384e21] text-2xl tracking-tighter">Zentro Admin</h1>
        <p class="font-['Be_Vietnam_Pro'] font-medium text-xs text-[#191c18]/60 mt-1 uppercase tracking-widest">Eco-Management Suite</p>
    </div>

    <nav class="flex-grow space-y-1">
        <a
            class="<?= ($currentPage ?? '') === 'dashboard'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/dashboard"
        >
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Dashboard</span>
        </a>

        <a
            class="<?= ($currentPage ?? '') === 'inventory'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/inventory"
        >
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Inventory</span>
        </a>


        <a
            class="<?= ($currentPage ?? '') === 'products'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/products"
        >
            <span class="material-symbols-outlined">eco</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Products</span>
        </a>

        <a
            class="<?= ($currentPage ?? '') === 'orders'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/orders"
        >
            <span class="material-symbols-outlined">shopping_basket</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Orders</span>
        </a>

        <a
            class="<?= ($currentPage ?? '') === 'reviews'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/reviews"
        >
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Reviews</span>
        </a>

        <a
            class="<?= ($currentPage ?? '') === 'blog'
                ? 'bg-[#384e21] text-white rounded-lg mx-2 my-1 px-4 py-3 flex items-center gap-3 active:scale-98 transition-transform'
                : 'text-[#191c18]/60 hover:bg-[#e1e3dc] dark:hover:bg-stone-700 mx-2 my-1 px-4 py-3 rounded-lg flex items-center gap-3 transition-all hover:translate-x-1 duration-200' ?>"
            href="index.php?url=admin/blog"
        >
            <span class="material-symbols-outlined">article</span>
            <span class="font-['Be_Vietnam_Pro'] font-medium text-sm">Blog</span>
        </a>

       
    </nav>

    <div class="mt-auto px-4">
        <button class="w-full bg-[#384e21] text-white font-['Be_Vietnam_Pro'] text-sm py-3 rounded-xl flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-sm">file_download</span>
            Export Reports
        </button>

        <div class="mt-6 pt-6 border-t border-[#c5c8ba]/20 flex items-center gap-3">
            <img
                alt="Admin User Profile"
                class="w-10 h-10 rounded-full object-cover"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBHj8WjA85h2VKvKdvD0SDS54AdgTjITIopx2DbFYWK104WA1Bl5YVypsu6fAlmPMLPzXcywOmxD382ZlwVQJsLW6O_8L3KAlobzWq5jNxoAqmdODb-xPvvyWmgFIqUYiSkvJNSP1gaohhlagJaGPbV_kavopHdbsjAA8W2HaeUpF-AXnJZFh8pKumU1HPvnMPdLn4GC8lF1WCSP9qhDwFXC2ZkIThnRgeRdp9OXtb9aNjBu3HhhOi6B54fMcD0L6DN1bdyJuguBI4"
            />
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-[#384e21] truncate">Julian Reed</p>
                <p class="text-[10px] text-[#191c18]/50 truncate">Senior Editor</p>
            </div>
        </div>
    </div>
</aside>