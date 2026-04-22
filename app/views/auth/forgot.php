<?php include 'app/views/layouts/header.php'; ?>

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 md:py-24 relative z-10">
    <div class="w-full max-w-md bg-surface-container-lowest p-8 md:p-12 rounded-xl shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)] border border-outline-variant/10">
        
        <div class="text-center mb-8">
            <span class="material-symbols-outlined text-5xl text-primary mb-4 bg-primary-container p-4 rounded-full">lock_reset</span>
            <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">Reset Password</h2>
            <p class="text-on-surface-variant text-sm">Enter your registered email address and we'll send you a link to reset your password.</p>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="mb-6 p-4 bg-primary/10 border border-primary/20 rounded-lg text-primary text-sm text-center animate-pulse">
                <p class="font-bold mb-1 underline">Yêu cầu thành công!</p>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm text-center font-bold">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=forgot-password" method="POST" class="space-y-6 auth-form">
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Email Address</label>
                <input name="email" required class="w-full bg-surface-container-high border-none rounded-lg p-4 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="nature@zentro.com" type="email" />
            </div>
            
            <button type="submit" class="w-full bg-primary text-on-primary font-bold py-4 rounded-lg hover:bg-primary-container transition-all shadow-lg shadow-primary/20">
                Send Reset Link
            </button>

            <div class="text-center pt-4">
                <a href="index.php?url=login" class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Sign In
                </a>
            </div>
        </form>
    </div>
</main>

<div class="fixed bottom-0 left-0 w-full h-60 -z-20 opacity-10 pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPnWAociNieVlxiRuRMr0OaGgXkuxiC_JksDaiFam77hYuE58MST_Cjht8R1pZ1NXGLXt53qrxTb9oYwAO_nx_OM9CCvb1FZJQJrLvua1CMyPmsvkcF37cx7dakZw-SB-mB5DN38TB2fjvrPD6U5Q1648v23AmzoalVP3aP93hN5MG-1c6wXOq39KyiPDHh4jpdv-5JME2uJhA99qBTzvWbMoHLKiQ1_4sq9EPsNs2UcKnvaQ5VPajMkiEwHJPTMbcHJLvtvAs8JM" alt="texture" />
</div>

<?php include 'app/views/layouts/footer.php'; ?>