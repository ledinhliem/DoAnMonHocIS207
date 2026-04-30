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
<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 md:py-24 relative z-10">
    <div class="w-full max-w-md bg-surface-container-lowest p-8 md:p-12 rounded-xl shadow-[0_40px_40px_-15px_rgba(25,28,24,0.04)] border border-outline-variant/10">
        
        <div class="text-center mb-8">
            <span class="material-symbols-outlined text-5xl text-primary mb-4 bg-primary-container p-4 rounded-full">key</span>
            <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">New Password</h2>
            <p class="text-on-surface-variant text-sm">Please create a new secure password for your account.</p>
        </div>

        <form id="resetForm" action="index.php?url=reset-password" method="POST" class="space-y-6 auth-form">
            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">New Password</label>
                <div class="relative">
                    <input id="reset_pass" name="password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                    <span class="z-10 material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reset_pass">visibility_off</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-primary px-1">Confirm New Password</label>
                <div class="relative">
                    <input id="reset_conf" name="confirm_password" required class="w-full bg-surface-container-high border-none rounded-lg p-4 pr-12 focus:ring-1 focus:ring-primary/30 focus:bg-surface-container-lowest transition-all placeholder:text-outline" placeholder="••••••••" type="password" />
                    <span class="z-10 material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant cursor-pointer hover:text-primary transition-colors toggle-password select-none" data-target="reset_conf">visibility_off</span>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-lg hover:bg-primary-container transition-all">
                Update Password
            </button>
        </form>
    </div>
</main>

<div class="fixed bottom-0 left-0 w-full h-60 -z-20 opacity-20 pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPnWAociNieVlxiRuRMr0OaGgXkuxiC_JksDaiFam77hYuE58MST_Cjht8R1pZ1NXGLXt53qrxTb9oYwAO_nx_OM9CCvb1FZJQJrLvua1CMyPmsvkcF37cx7dakZw-SB-mB5DN38TB2fjvrPD6U5Q1648v23AmzoalVP3aP93hN5MG-1c6wXOq39KyiPDHh4jpdv-5JME2uJhA99qBTzvWbMoHLKiQ1_4sq9EPsNs2UcKnvaQ5VPajMkiEwHJPTMbcHJLvtvAs8JM" alt="river stone texture" />
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Logic bật/tắt con mắt
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

    // 2. Logic so sánh 2 mật khẩu
    const form = document.getElementById('resetForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            const pass = document.getElementById('reset_pass').value;
            const conf = document.getElementById('reset_conf').value;
            
            if (pass !== conf) {
                e.preventDefault(); // Chặn không cho gửi form
                alert('Mật khẩu xác nhận không khớp! Lan kiểm tra lại nhé.');
            }
        });
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>