<?php include 'app/views/layouts/header.php'; ?>

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 md:py-24 relative z-10">
    <div class="w-full max-w-md bg-surface-container-lowest p-8 md:p-12 rounded-xl shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)] border border-outline-variant/10">
        
        <div class="text-center mb-8">
            <span class="material-symbols-outlined text-5xl text-primary mb-4 bg-primary-container p-4 rounded-full">key</span>
            <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">New Password</h2>
            <p class="text-on-surface-variant text-sm">Please create a new secure password for your account.</p>
        </div>

        <form action="index.php?url=reset-password" method="POST" class="space-y-6 auth-form">
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">New Password</label>
                <div class="relative">
                    <input id="reset_pass" name="password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reset_pass">visibility</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Confirm New Password</label>
                <div class="relative">
                    <input id="reset_conf" name="confirm_password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reset_conf">visibility</span>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-primary text-on-primary font-bold py-4 rounded-lg hover:bg-primary-container transition-all">
                Update Password
            </button>
        </form>
    </div>
</main>

<div class="fixed bottom-0 left-0 w-full h-60 -z-20 opacity-20 pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPnWAociNieVlxiRuRMr0OaGgXkuxiC_JksDaiFam77hYuE58MST_Cjht8R1pZ1NXGLXt53qrxTb9oYwAO_nx_OM9CCvb1FZJQJrLvua1CMyPmsvkcF37cx7dakZw-SB-mB5DN38TB2fjvrPD6U5Q1648v23AmzoalVP3aP93hN5MG-1c6wXOq39KyiPDHh4jpdv-5JME2uJhA99qBTzvWbMoHLKiQ1_4sq9EPsNs2UcKnvaQ5VPajMkiEwHJPTMbcHJLvtvAs8JM" alt="river stone texture" />
</div>

<?php include 'app/views/layouts/footer.php'; ?>