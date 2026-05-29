<?php include 'app/views/layouts/header.php'; ?>

<style>
    /* Ẩn con mắt mặc định của Edge */
    input::-ms-reveal,
    input::-ms-clear {
        display: none !important;
    }

    /* Ẩn icon chìa khóa/mắt mặc định của Chrome/Safari */
    input::-webkit-contacts-auto-fill-button,
    input::-webkit-credentials-auto-fill-button {
        visibility: hidden !important;
        display: none !important;
        pointer-events: none !important;
    }
</style>

<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 md:py-24">
    <div class="mb-12 text-center">
        <h1 class="font-headline text-4xl font-extrabold text-primary tracking-widest uppercase mb-2">Zentro</h1>
        <p class="text-on-surface-variant font-medium tracking-tight">Sống xanh đơn giản hơn.</p>
    </div>

    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
        <section class="bg-surface-container-lowest p-8 md:p-12 rounded-xl shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)] border border-outline-variant/10">
            
            <div class="flex border-b border-outline-variant/20 mb-8">
                <a href="index.php?url=login" class="flex-1 py-3 text-center text-sm font-bold uppercase tracking-widest text-primary border-b-2 border-primary">
                    Sign In
                </a>
                <a href="index.php?url=register" class="flex-1 py-3 text-center text-sm font-bold uppercase tracking-widest text-on-surface-variant/40 hover:text-primary transition-colors border-b-2 border-transparent">
                    Join Zentro
                </a>
            </div>

            <div class="mb-8">
                <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">Chào mừng trở lại</h2>
                <p class="text-on-surface-variant text-sm">Enter your details to access your conscious collection.</p>
            </div>

            <?php if (isset($data['error']) && !empty($data['error'])): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-sm font-medium text-red-600 mt-0.5"><?php echo $data['error']; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['auth_message'])): ?>
                <div class="mb-6 p-4 rounded-lg bg-primary/10 border border-primary/20 flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    <p class="text-sm font-medium text-primary mt-0.5"><?php echo htmlspecialchars($_SESSION['auth_message']); ?></p>
                </div>
                <?php unset($_SESSION['auth_message']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['auth_error'])): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-sm font-medium text-red-600 mt-0.5"><?php echo htmlspecialchars($_SESSION['auth_error']); ?></p>
                </div>
                <?php unset($_SESSION['auth_error']); ?>
            <?php endif; ?>

            <form id="loginForm" action="index.php?url=login" method="POST" class="space-y-6 auth-form">
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Địa chỉ email</label>
                    <input name="email" required class="w-full bg-surface-container-high border-none rounded-lg p-4 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="nature@zentro.com" type="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-primary">Password</label>
                        <a class="text-xs text-secondary font-semibold hover:underline" href="index.php?url=forgot-password">Quên mật khẩu?</a>
                    </div>
                    <div class="relative flex items-center">
                        <input id="login_pass" name="password" required 
                            class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" 
                            placeholder="••••••••" type="password" />
    
                        <button type="button" style="z-index: 30;"
                            onclick="const input = document.getElementById('login_pass'); const icon = this.querySelector('span'); if(input.type === 'password'){ input.type = 'text'; icon.textContent = 'visibility'; this.classList.add('text-primary'); this.classList.remove('text-outline-variant'); } else { input.type = 'password'; icon.textContent = 'visibility_off'; this.classList.remove('text-primary'); this.classList.add('text-outline-variant'); }"
                            class="absolute right-2 w-10 h-10 flex items-center justify-center cursor-pointer text-outline-variant hover:text-primary transition-colors select-none">
                            <span class="material-symbols-outlined pointer-events-none">visibility_off</span>
                        </button>
                    </div>
                </div>

                <button id="submitBtn" type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-lg hover:bg-primary-container transition-all flex justify-center items-center gap-2 group">
                    <span id="btnText">Sign In</span>
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <div class="my-6 flex items-center gap-4">
                <span class="h-px flex-1 bg-outline-variant/30"></span>
                <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60">Hoặc</span>
                <span class="h-px flex-1 bg-outline-variant/30"></span>
            </div>

            <a href="index.php?url=auth/google" class="w-full border border-outline-variant/40 bg-white text-on-surface font-bold py-4 rounded-lg hover:border-primary hover:text-primary transition-all flex justify-center items-center gap-3">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white border border-outline-variant/30 text-sm font-black text-primary">G</span>
                <span>Đăng nhập bằng Google</span>
            </a>

        </section>

        <section class="hidden md:flex flex-col justify-between bg-primary-container text-white p-12 rounded-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="relative z-10">
                <span class="material-symbols-outlined text-4xl mb-6">eco</span>
                <h3 class="font-headline text-4xl font-bold leading-tight mb-6">"Earth provides enough to satisfy every man's needs, but not every man's greed."</h3>
                <p class="text-white/80 text-lg italic">— Mahatma Gandhi</p>
            </div>
        </section>
    </div>
</main>

<?php include 'app/views/layouts/footer.php'; ?>
