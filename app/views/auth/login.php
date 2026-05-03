<?php include 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

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

            <form id="loginForm" action="index.php?url=login" method="POST" class="space-y-6 auth-form">
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Địa chỉ email</label>
                    <input name="email" required class="w-full bg-surface-container-high border-none rounded-lg p-4 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="nature@zentro.com" type="email" />
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-primary">Password</label>
                        <a class="text-xs text-secondary font-semibold hover:underline" href="index.php?url=forgot-password">Quên mật khẩu?</a>
                    </div>
                    <div class="relative">
                        <input id="login_pass" name="password" required 
                            class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all" 
                            placeholder="••••••••" type="password" />
    
                        <span id="toggleEye" style="z-index: 10;" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors select-none">
                            visibility_off
                        </span>
                    </div>
                </div>

                <button id="submitBtn" type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-lg hover:bg-primary-container transition-all flex justify-center items-center gap-2 group">
                    <span id="btnText">Sign In</span>
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <div class="relative my-10">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-outline-variant/30"></div></div>
                <div class="relative flex justify-center text-xs uppercase tracking-widest">
                    <span class="bg-surface-container-lowest px-4 text-on-surface-variant">Or continue with</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <a href="index.php?url=auth/google" class="flex items-center justify-center gap-3 bg-white border border-outline-variant/30 py-3 rounded-lg hover:bg-surface-container transition-all no-underline text-on-surface shadow-sm">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="18" height="18" alt="Google">
                    <span class="text-sm font-semibold">Google</span>
                </a>
                <a href="index.php?url=auth/apple" class="flex items-center justify-center gap-3 bg-black py-3 rounded-lg hover:bg-gray-800 transition-all no-underline text-white shadow-sm">
                    <i class="devicon-apple-original text-lg"></i>
                    <span class="text-sm font-semibold">Apple</span>
                </a>
            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleEye = document.getElementById('toggleEye');
    const passwordInput = document.getElementById('login_pass');

    // 1. Logic Click để ẩn/hiện mật khẩu
    if (toggleEye && passwordInput) {
        toggleEye.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.textContent = 'visibility'; // Hiện mật khẩu -> đổi sang mắt mở
                this.classList.add('text-primary');
            } else {
                passwordInput.type = 'password';
                this.textContent = 'visibility_off'; // Ẩn mật khẩu -> đổi sang mắt gạch
                this.classList.remove('text-primary');
            }
        });

        // 2. TÍNH NĂNG CON MẮT THÔNG MINH (Đổi icon khi gõ)
        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                // Nếu đang gõ và đang ở chế độ ẩn, hiện icon nhắc nhở có thể mở mắt
                if (this.type === 'password') {
                    toggleEye.textContent = 'visibility'; 
                }
            } else {
                // Nếu xóa sạch text, quay về icon mặc định gạch chéo
                toggleEye.textContent = 'visibility_off';
                // Đảm bảo type cũng trở về password khi xóa sạch
                passwordInput.type = 'password';
                toggleEye.classList.remove('text-primary');
            }
        });
    }

    // 3. Hiệu ứng nút Sign In
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const txt = document.getElementById('btnText');
            txt.textContent = 'Verifying...';
            btn.classList.add('opacity-50', 'pointer-events-none');
        });
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>
