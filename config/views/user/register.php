<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Sustainable E-commerce</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Thiết lập màu eco-friendly (xanh lá) */
        :root {
            --color-primary: #16a34a;  /* Xanh lá chính */
            --color-primary-light: #dcfce7;  /* Xanh lá nhạt */
            --color-primary-dark: #15803d;  /* Xanh lá đậm */
        }

        body {
            background: linear-gradient(135deg, var(--color-primary-light) 0%, #e0f7e9 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Container register card */
        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .register-card {
            width: 100%;
            max-width: 480px;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(22, 163, 74, 0.15);
            background: white;
        }

        .register-card .card-header {
            background-color: var(--color-primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem;
            margin: -2rem -2rem 1.5rem -2rem;
            text-align: center;
        }

        .register-card .card-header h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.25);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }

        .form-control.is-valid {
            border-color: #16a34a;
        }

        .form-control.is-valid:focus {
            box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.25);
        }

        .btn-register {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Alert messages */
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        /* Footer text */
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .register-footer p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }

        .register-footer a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-footer a:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        /* Form group spacing */
        .form-group {
            margin-bottom: 1.2rem;
        }

        /* Password strength feedback */
        .password-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: none;
        }

        .password-feedback.match {
            color: #16a34a;
            display: block;
        }

        .password-feedback.mismatch {
            color: #dc2626;
            display: block;
        }

        .form-text {
            display: block;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="card-header">
                <h3><i class="fas fa-leaf"></i> Tạo Tài Khoản</h3>
            </div>

            <!-- Nội dung form -->
            <div class="card-body p-0 pt-4">
                <!-- Hiển thị lỗi nếu có -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <strong>Lỗi!</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form đăng ký -->
                <form method="POST" action="index.php?url=user/register" novalidate id="registerForm">
                    <!-- Họ tên -->
                    <div class="form-group">
                        <label for="fullName" class="form-label">
                            <i class="fas fa-user"></i> Họ và Tên
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="fullName" 
                            name="fullName" 
                            placeholder="Nhập họ và tên của bạn"
                            required
                            value="<?= isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : '' ?>"
                        >
                        <small class="form-text text-muted">Tên đầy đủ của bạn</small>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="Nhập email của bạn"
                            required
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                        >
                        <small class="form-text text-muted">Sẽ dùng để đăng nhập</small>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Mật khẩu
                        </label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password" 
                            placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)"
                            required
                            minlength="6"
                        >
                        <small class="form-text text-muted">Tối thiểu 6 ký tự</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">
                            <i class="fas fa-check-circle"></i> Xác nhận Mật khẩu
                        </label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="confirmPassword" 
                            name="confirmPassword" 
                            placeholder="Nhập lại mật khẩu"
                            required
                        >
                        <div class="password-feedback">
                            <i class="fas fa-check"></i> <span id="feedbackText"></span>
                        </div>
                    </div>

                    <!-- Terms & Conditions checkbox -->
                    <div class="form-check mb-3">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            required
                        >
                        <label class="form-check-label" for="terms">
                            Tôi đồng ý với <a href="#" style="color: var(--color-primary);">Điều khoản sử dụng</a> 
                            và <a href="#" style="color: var(--color-primary);">Chính sách bảo mật</a>
                        </label>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-register" id="submitBtn">
                        <i class="fas fa-user-plus"></i> Đăng Ký
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="register-footer">
                <p>Đã có tài khoản? <a href="index.php?url=user/login">Đăng nhập ngay</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form validation script -->
    <script>
        (function() {
            'use strict';
            
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const feedbackDiv = document.querySelector('.password-feedback');
            const feedbackText = document.getElementById('feedbackText');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('registerForm');

            // Hàm kiểm tra mật khẩu khớp
            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword === '') {
                    // Nếu chưa nhập, ẩn feedback
                    feedbackDiv.classList.remove('match', 'mismatch');
                    return false;
                }

                if (password === confirmPassword && password !== '') {
                    // Mật khẩu khớp
                    feedbackDiv.classList.add('match');
                    feedbackDiv.classList.remove('mismatch');
                    feedbackText.textContent = 'Mật khẩu khớp ✓';
                    confirmPasswordInput.classList.add('is-valid');
                    confirmPasswordInput.classList.remove('is-invalid');
                    return true;
                } else {
                    // Mật khẩu không khớp
                    feedbackDiv.classList.add('mismatch');
                    feedbackDiv.classList.remove('match');
                    feedbackText.textContent = 'Mật khẩu không khớp';
                    confirmPasswordInput.classList.add('is-invalid');
                    confirmPasswordInput.classList.remove('is-valid');
                    return false;
                }
            }

            // Listen for changes on confirm password
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);
            passwordInput.addEventListener('input', function() {
                if (confirmPasswordInput.value !== '') {
                    validatePasswordMatch();
                }
            });

            // Form submit validation
            form.addEventListener('submit', function(event) {
                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const terms = document.getElementById('terms').checked;

                // Validate all fields
                if (!fullName || !email || !password || !confirmPassword) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Vui lòng điền đầy đủ tất cả các trường!');
                    return;
                }

                // Check password match
                if (password !== confirmPassword) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Mật khẩu không khớp!');
                    return;
                }

                // Check password length
                if (password.length < 6) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Mật khẩu phải có ít nhất 6 ký tự!');
                    return;
                }

                // Check terms accepted
                if (!terms) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Vui lòng chấp nhận Điều khoản sử dụng!');
                    return;
                }
            });
        })();
    </script>
</body>
</html>
