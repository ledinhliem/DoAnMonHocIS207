<?php include 'app/views/layouts/header.php'; ?>
<style>
    /* Diệt con mắt của Edge/Chrome */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none !important;
    }
    
    /* Diệt icon tự động điền của Safari/Chrome */
    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* Ép ô input không hiển thị style mặc định của hệ điều hành */
    input[type="password"] {
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
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
                <a href="index.php?url=login" class="flex-1 py-3 text-center text-sm font-bold uppercase tracking-widest text-on-surface-variant/40 hover:text-primary transition-colors border-b-2 border-transparent">
                    Sign In
                </a>
                <a href="index.php?url=register" class="flex-1 py-3 text-center text-sm font-bold uppercase tracking-widest text-primary border-b-2 border-primary">
                    Join Zentro
                </a>
            </div>

            <div class="mb-8">
                <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">Tạo tài khoản</h2>
                <p class="text-on-surface-variant text-sm">Begin your eco-friendly journey today.</p>
            </div>

            <?php if (isset($data['error']) && !empty($data['error'])): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-sm font-medium text-red-600 mt-0.5"><?php echo $data['error']; ?></p>
                </div>
            <?php endif; ?>

            <form id="registerForm" action="index.php?url=register" method="POST" class="space-y-4 auth-form">
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Full Name</label>
                    <input name="name" required class="w-full bg-surface-container-high border-none rounded-lg p-4 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="Elena Woods" type="text" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"/>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Địa chỉ email</label>
                    <input name="email" required class="w-full bg-surface-container-high border-none rounded-lg p-4 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="nature@zentro.com" type="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"/>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Password</label>
                        <div class="relative">
                            <input id="reg_pass" name="password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                            <span class="z-10 material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reg_pass">visibility_off</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Confirm</label>
                        <div class="relative">
                            <input id="reg_conf" name="confirm_password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                            <span class="z-10 material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reg_conf">visibility_off</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-primary text-white font-bold py-4 rounded-lg hover:bg-primary-container transition-all flex justify-center items-center gap-2 group">
                    Tạo tài khoản
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>
        </section>

        <section class="hidden md:flex flex-col justify-between bg-primary-container text-white p-12 rounded-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="relative z-10">
                <span class="material-symbols-outlined text-4xl mb-6">eco</span>
                <h3 class="font-headline text-4xl font-bold leading-tight mb-6">"Earth provides enough to satisfy every man's needs, but not every man's greed."</h3>
                <p class="text-white/80 text-lg italic">— Mahatma Gandhi</p>
            </div>
            <div class="relative z-10 bg-white/10 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-4xl text-white">verified_user</span>
                    <div>
                        <p class="font-bold text-white">Safe & Secure</p>
                        <p class="text-xs text-white/70">Your data is protected with industry standards.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Xử lý ẩn hiện mật khẩu
    const toggles = document.querySelectorAll('.toggle-password');
    
    toggles.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'visibility'; 
                this.classList.add('text-primary');
            } else {
                input.type = 'password';
                this.textContent = 'visibility_off'; 
                this.classList.remove('text-primary');
            }
        });
    });

    // 2. Bonus: Check mật khẩu khớp nhau trước khi submit
    const form = document.getElementById('registerForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            const pass = document.getElementById('reg_pass').value;
            const conf = document.getElementById('reg_conf').value;
            
            if (pass !== conf) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp! Bạn kiểm tra lại nhé.');
            }
        });
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>