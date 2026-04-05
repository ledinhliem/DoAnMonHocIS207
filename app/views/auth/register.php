<?php include 'app/views/layouts/header.php'; ?>

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 md:py-24">
    <div class="mb-4 text-center">
        <h1 class="font-headline text-4xl font-extrabold text-primary tracking-widest uppercase mb-2">Zentro</h1>
        <p class="text-on-surface-variant font-medium tracking-tight">Sustainable Living, Simplified.</p>
    </div>

    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="hidden lg:flex flex-col space-y-8 pr-12">
            <div class="relative w-full aspect-[4/5] rounded-xl overflow-hidden">
                <img class="object-cover w-full h-full shadow-sm"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAL8_Ihjd93Ex_qRatVsDihmF2ZAU00LTGcxRB6y6AThEv_qBCqTCCe6LyICr1W26Vdeu2IOA0y0HapegECMfZXqfBPZ7iIleVrFdvBPKCKHo62Ph7aOPMAAHOo75sjAsCZSRL-EsmuFkH6E_Jg1UG2otHzUUumjUJSQnPx_9Ly6iL93w4YLnMPpGLOKYFq6js5P1bjTdhqRjGfehWpqoXa6WbTNlMDQYrqCjX225KAZ1RU47143Vpp_GcCu4XS4vTiNi4A1YGfyyw" 
                    alt="Lush green fern leaves" />
                <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
            </div>
            <div class="space-y-4">
                <h2 class="font-headline text-4xl font-extrabold text-primary leading-tight">Nurture your space, naturally.</h2>
                <p class="text-body text-lg text-on-surface-variant max-w-md">Join a community dedicated to sustainable living and conscious curation of the things that surround you.</p>
            </div>
        </div>

        <div class="w-full max-w-md mx-auto">
            <div class="bg-surface-container-low p-8 md:p-10 rounded-xl shadow-flat">
                <div class="mb-10">
                    <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">Create Account</h2>
                    <p class="text-on-surface-variant font-body">Begin your journey toward a sustainable lifestyle.</p>
                </div>

                <form action="index.php?mod=auth&act=postRegister" method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block font-label text-sm font-semibold text-on-surface-variant ml-1">Full Name</label>
                        <input name="fullname" required
                            class="w-full px-5 py-4 rounded-lg bg-surface-container-high border-none focus:ring-2 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all duration-300 placeholder:text-outline"
                            placeholder="Arlo Thorne" type="text" />
                    </div>

                    <div class="space-y-2">
                        <label class="block font-label text-sm font-semibold text-on-surface-variant ml-1">Email Address</label>
                        <input name="email" required
                            class="w-full px-5 py-4 rounded-lg bg-surface-container-high border-none focus:ring-2 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all duration-300 placeholder:text-outline"
                            placeholder="hello@zentro.com" type="email" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block font-label text-sm font-semibold text-on-surface-variant ml-1">Password</label>
                            <input name="password" required
                                class="w-full px-5 py-4 rounded-lg bg-surface-container-high border-none focus:ring-2 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all duration-300 placeholder:text-outline"
                                placeholder="••••••••" type="password" />
                        </div>
                        <div class="space-y-2">
                            <label class="block font-label text-sm font-semibold text-on-surface-variant ml-1">Confirm</label>
                            <input name="confirm_password" required
                                class="w-full px-5 py-4 rounded-lg bg-surface-container-high border-none focus:ring-2 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all duration-300 placeholder:text-outline"
                                placeholder="••••••••" type="password" />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-5 bg-primary text-on-primary font-headline font-bold rounded-lg shadow-sm hover:opacity-90 transition-all duration-300 mt-4">
                        Join Zentro
                    </button>

                    <div class="relative flex items-center py-4">
                        <div class="flex-grow border-t border-outline-variant/30"></div>
                        <span class="flex-shrink mx-4 text-sm font-label text-outline uppercase tracking-widest text-on-surface-variant/50">or</span>
                        <div class="flex-grow border-t border-outline-variant/30"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" class="flex items-center justify-center gap-2 py-4 px-4 bg-surface-container-lowest rounded-lg hover:bg-surface-container-high transition-colors duration-200">
                            <span class="material-symbols-outlined text-[20px]">cloud</span>
                            <span class="font-label text-sm font-medium">Google</span>
                        </button>
                        <button type="button" class="flex items-center justify-center gap-2 py-4 px-4 bg-surface-container-lowest rounded-lg hover:bg-surface-container-high transition-colors duration-200">
                            <span class="material-symbols-outlined text-[20px]">brand_awareness</span>
                            <span class="font-label text-sm font-medium">Apple</span>
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-on-surface-variant font-body">
                        Already have an account? 
                        <a class="text-primary font-bold hover:underline transition-all underline-offset-4 decoration-primary/30"
                           href="index.php?mod=auth&act=login">
                           Sign In
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="fixed bottom-0 left-0 w-full h-48 -z-20 opacity-20 pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPnWAociNieVlxiRuRMr0OaGgXkuxiC_JksDaiFam77hYuE58MST_Cjht8R1pZ1NXGLXt53qrxTb9oYwAO_nx_OM9CCvb1FZJQJrLvua1CMyPmsvkcF37cx7dakZw-SB-mB5DN38TB2fjvrPD6U5Q1648v23AmzoalVP3aP93hN5MG-1c6wXOq39KyiPDHh4jpdv-5JME2uJhA99qBTzvWbMoHLKiQ1_4sq9EPsNs2UcKnvaQ5VPajMkiEwHJPTMbcHJLvtvAs8JM" alt="river stone texture" />
</div>

<?php include 'app/views/layouts/footer.php'; ?>