document.addEventListener('DOMContentLoaded', function() {
    // 1. Chức năng Toggle Ẩn/Hiện mật khẩu
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const inputId = this.getAttribute('data-target');
            const input = document.getElementById(inputId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'visibility_off'; // Đổi icon sang nhắm mắt
                this.classList.add('text-primary'); // Đổi màu icon khi hiện pass
            } else {
                input.type = 'password';
                this.textContent = 'visibility';
                this.classList.remove('text-primary');
            }
        });
    });

    // 2. Validate Form Frontend
    const authForm = document.querySelector('form.auth-form');
    if (authForm) {
        authForm.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMsg = '';

            const email = authForm.querySelector('input[type="email"]');
            const password = authForm.querySelector('input[name="password"]');
            const confirmPass = authForm.querySelector('input[name="confirm_password"]');

            // Regex kiểm tra định dạng email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email.value)) {
                errorMsg += '• Vui lòng nhập đúng định dạng email (ví dụ: name@domain.com).\n';
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
                e.preventDefault(); // Ngăn form gửi dữ liệu
                alert("Lỗi nhập liệu:\n\n" + errorMsg);
            }
        });
    }
});