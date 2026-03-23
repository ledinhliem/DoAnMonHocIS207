<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Sustainable E-commerce</title>
    
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

        /* Container login card */
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(22, 163, 74, 0.15);
            background: white;
        }

        .login-card .card-header {
            background-color: var(--color-primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem;
            margin: -2rem -2rem 1.5rem -2rem;
            text-align: center;
        }

        .login-card .card-header h3 {
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

        .btn-login {
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

        .btn-login:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .btn-login:active {
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
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .login-footer p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }

        .login-footer a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        /* Form group spacing */
        .form-group {
            margin-bottom: 1.2rem;
        }

        /* Icon input */
        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .input-icon .form-control {
            padding-left: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="card-header">
                <h3><i class="fas fa-leaf"></i> Sustainable Shop</h3>
            </div>

            <!-- Nội dung form -->
            <div class="card-body p-0 pt-4">
                <!-- Hiển thị lỗi nếu có -->
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Hiển thị thông báo thành công nếu có -->
                <?php if (isset($success) && !empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form đăng nhập -->
                <form method="POST" action="index.php?url=user/login" novalidate>
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
                        <small class="form-text text-muted d-block mt-1">
                            💡 Thử: test@example.com
                        </small>
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
                            placeholder="Nhập mật khẩu của bạn"
                            required
                        >
                        <small class="form-text text-muted d-block mt-1">
                            💡 Thử: password123
                        </small>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Nhớ tôi
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none" style="color: var(--color-primary); font-size: 0.9rem;">
                            Quên mật khẩu?
                        </a>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>Chưa có tài khoản? <a href="index.php?url=user/register">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Form validation script -->
    <script>
        // Validation cơ bản với HTML5 + Bootstrap
        (function() {
            'use strict';
            
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(event) {
                // Validate dữ liệu trước khi submit
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();

                if (!email || !password) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Vui lòng điền đầy đủ email và mật khẩu!');
                }
            });
        })();
    </script>
</body>
</html>
