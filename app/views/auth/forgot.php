<?php include 'app/views/layouts/header.php'; ?>

<main class="flex-grow flex items-center justify-center px-6 py-20 relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-fixed-dim/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[35%] h-[35%] bg-secondary-container/30 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="mb-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface-container mb-8">
                <span class="material-symbols-outlined text-primary text-3xl">potted_plant</span>
            </div>
            <h1 class="text-4xl font-extrabold text-primary tracking-tight mb-4">Reset Password</h1>
            <p class="text-on-surface-variant leading-relaxed">
                Enter the email associated with your Zentro account and we'll send a recovery link to restore access.
            </p>
        </div>

        <div class="bg-surface-container-low rounded-[2rem] p-10 shadow-sm border border-outline-variant/10">
            <form action="index.php?mod=auth&act=postForgot" method="POST" class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-on-surface ml-1" for="email">Email Address</label>
                    <div class="relative group">
                        <input
                            class="w-full px-5 py-4 bg-surface-container-high rounded-xl border-none text-on-surface placeholder:text-outline focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all duration-300 outline-none"
                            id="email" name="email" placeholder="name@example.com" required type="email" />
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">
                            mail
                        </span>
                    </div>
                </div>

                <a href="index.php?url=reset-password" 
                     class="w-full bg-primary text-on-primary font-bold py-4 rounded-lg hover:bg-primary-container transition-all flex justify-center items-center gap-2 group">
                     Send Recovery Link
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </form>

            <div class="mt-10 pt-8 border-t border-outline-variant/30 flex flex-col items-center gap-4">
                <a class="group flex items-center gap-2 text-sm font-medium text-on-surface-variant hover:text-primary transition-colors"
                  href="index.php?url=login">
                    <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">chevron_left</span>
                    Back to login
                </a>
            </div>
        </div>

        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container rounded-full border border-outline-variant/10">
                <span class="w-2 h-2 rounded-full bg-primary-fixed-dim"></span>
                <span class="text-xs font-medium text-on-surface-variant tracking-wider uppercase">Conscious Security</span>
            </div>
        </div>
    </div>
</main>

<div class="fixed bottom-0 left-0 w-full h-48 -z-20 opacity-20 pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPnWAociNieVlxiRuRMr0OaGgXkuxiC_JksDaiFam77hYuE58MST_Cjht8R1pZ1NXGLXt53qrxTb9oYwAO_nx_OM9CCvb1FZJQJrLvua1CMyPmsvkcF37cx7dakZw-SB-mB5DN38TB2fjvrPD6U5Q1648v23AmzoalVP3aP93hN5MG-1c6wXOq39KyiPDHh4jpdv-5JME2uJhA99qBTzvWbMoHLKiQ1_4sq9EPsNs2UcKnvaQ5VPajMkiEwHJPTMbcHJLvtvAs8JM" alt="river stone texture" />
</div>

<?php include 'app/views/layouts/footer.php'; ?>