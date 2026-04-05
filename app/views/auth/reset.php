<?php include 'app/views/layouts/header.php'; ?>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    "primary": "#384e21",
                    "primary-container": "#4f6636",
                    "primary-fixed": "#d0ecaf",
                    "primary-fixed-dim": "#b5cf95",
                    "surface": "#f9faf2",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f3f4ed",
                    "surface-container-high": "#e7e9e1",
                    "on-surface": "#191c18",
                    "on-surface-variant": "#44483e",
                    "outline-variant": "#c5c8ba",
                    "secondary-container": "#ffd5ae",
                    "on-secondary-container": "#7a5b3b",
                }
            }
        }
    }
</script>

<main class="flex-grow w-full flex flex-col items-center justify-center px-6 py-12 md:py-20 relative min-h-[85vh]">
    
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#d0ecaf]/20 rounded-full blur-[120px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[35%] h-[35%] bg-[#ffd5ae]/30 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="w-full max-w-2xl text-center mb-10">
        <h1 class="font-headline font-bold text-4xl md:text-5xl tracking-tight text-primary mb-4">Reset Password</h1>
        <p class="text-on-surface-variant text-lg max-w-md mx-auto leading-relaxed">
            Secure your Zentro account by verifying your identity and choosing a new password.
        </p>
    </div>

    <div class="w-full max-w-2xl bg-white rounded-[2rem] shadow-sm p-8 md:p-12 space-y-10 border border-outline-variant/10 relative z-10">
        
        <form action="index.php?url=login" method="POST" class="space-y-10">
            
            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="bg-primary-fixed w-10 h-10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">verified_user</span>
                    </div>
                    <h2 class="font-headline font-bold text-2xl text-on-surface">Verify Your Identity</h2>
                </div>
                <p class="text-on-surface-variant">Enter the 6-digit verification code sent to your email.</p>
                
                <div class="flex justify-between gap-2 md:gap-4">
                    <?php for($i=0; $i<6; $i++): ?>
                    <input name="otp[]"
                        class="w-full h-14 md:h-16 text-center text-2xl font-bold bg-surface-container-high border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                        maxlength="1" placeholder="•" type="text" required />
                    <?php endfor; ?>
                </div>
                
                <div class="flex justify-center">
                    <a href="index.php?url=forgot-password" class="text-primary font-semibold hover:underline text-sm">Resend code</a>
                </div>
            </section>

            <div class="h-px bg-outline-variant/20 w-full"></div>

            <section class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="bg-secondary-container w-10 h-10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-secondary-container">lock_reset</span>
                    </div>
                    <h2 class="font-headline font-bold text-2xl text-on-surface">Set New Password</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface-variant ml-1">New Password</label>
                        <div class="relative">
                            <input name="password"
                                class="w-full p-4 bg-surface-container-high border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                                placeholder="••••••••" type="password" required />
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors">visibility</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface-variant ml-1">Confirm New Password</label>
                        <div class="relative">
                            <input name="confirm_password"
                                class="w-full p-4 bg-surface-container-high border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                                placeholder="••••••••" type="password" required />
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors">visibility</span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-5 bg-primary text-white font-bold rounded-xl text-lg shadow-lg hover:shadow-xl hover:bg-primary-container transition-all active:scale-[0.98] duration-200">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <a class="mt-8 flex items-center gap-2 text-primary hover:gap-3 transition-all font-bold" href="index.php?url=login">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        <span>Back to Sign In</span>
    </a>
</main>

<?php include 'app/views/layouts/footer.php'; ?>