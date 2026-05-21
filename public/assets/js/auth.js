document.addEventListener('DOMContentLoaded', function() {
    // 1. CHỨC NĂNG CON MẮT THÔNG MINH
    const toggleEye = document.getElementById('toggleEye');
    const passwordInput = document.getElementById('login_pass');

    if (toggleEye && passwordInput) {
        // Click để ẩn/hiện mật khẩu
        toggleEye.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.textContent = 'visibility'; // Hiện icon mắt mở
                this.classList.add('text-primary');
            } else {
                passwordInput.type = 'password';
                this.textContent = 'visibility_off'; // Hiện icon mắt gạch
                this.classList.remove('text-primary');
            }
        });

        // Logic gõ mới đổi icon (Đúng yêu cầu của Lan)
        passwordInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                // Nếu đang gõ và đang ở chế độ ẩn thì hiện mắt mở để mời bấm
                if (this.type === 'password') {
                    toggleEye.textContent = 'visibility';
                }
            } else {
                // Nếu xóa sạch chữ thì quay về mắt gạch mặc định
                toggleEye.textContent = 'visibility_off';
                this.type = 'password'; // Reset về ẩn cho an toàn
            }
        });
    }

    // 2. VALIDATE FORM FRONTEND
    const authForm = document.querySelector('form.auth-form');
    if (authForm) {
        authForm.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMsg = '';

            const email = authForm.querySelector('input[type="email"]');
            const password = authForm.querySelector('input[name="password"]');
            const confirmPass = authForm.querySelector('input[name="confirm_password"]');

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email.value)) {
                errorMsg += '• Vui lòng nhập đúng định dạng email.\n';
                isValid = false;
            }

            if (password && password.value.length < 6) {
                errorMsg += '• Mật khẩu phải có ít nhất 6 ký tự.\n';
                isValid = false;
            }

            if (confirmPass && password && password.value !== confirmPass.value) {
                errorMsg += '• Mật khẩu xác nhận không khớp.\n';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert("Lỗi nhập liệu:\n\n" + errorMsg);
            } else {
                // Hiệu ứng loading cho nút bấm của Long
                const submitBtn = authForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = 'Verifying... <span class="animate-pulse">...</span>';
                    submitBtn.classList.add('opacity-50', 'pointer-events-none');
                }
            }
        });
    }
}); // Chỉ đóng ở cuối cùng này thôi nhé Lan!