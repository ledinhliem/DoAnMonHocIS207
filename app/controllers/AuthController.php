<?php
class AuthController extends Controller
{
    public function login()
    {
        $this->view('auth/login', ['title' => 'Đăng nhập']);
    }

    public function register()
    {
        $this->view('auth/register', ['title' => 'Đăng ký']);
    }

    public function forgot()
    {
        $data = ['title' => 'Quên mật khẩu'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = mysqli_connect('localhost', 'root', '', 'sustainable_shop');

            if (!$conn) {
                $data['error_message'] = "Không thể kết nối Database!";
            } else {
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $token = bin2hex(random_bytes(32));

                mysqli_query($conn, "DELETE FROM password_resets WHERE email = '$email'");
                $sql = "INSERT INTO password_resets (email, token) VALUES ('$email', '$token')";

                if (mysqli_query($conn, $sql)) {
    // 1. Tạo link reset khớp với Router (reset-password)
                    $targetUrl = "index.php?url=reset-password&token=" . $token;
    
    // 2. Dùng lệnh header để tự động nhảy trang
                    header("Location: " . $targetUrl);
                    exit(); // Luôn phải có exit để dừng code ngay lập tức
                } else {
                    $data['error_message'] = "Lỗi hệ thống, không thể tạo yêu cầu!";
            }
                mysqli_close($conn);
            }
        }

        $this->view('auth/forgot', $data);
    }

    public function reset()
    {
        // Lấy token từ URL để truyền qua form đặt mật khẩu mới
        $token = $_GET['token'] ?? '';
        $this->view('auth/reset', [
            'title' => 'Đặt lại mật khẩu',
            'token' => $token
        ]);
    }

    public function googleLogin() {
        echo "<script>
                alert('Tính năng đăng nhập Google đang trong quá trình tích hợp bảo mật. Vui lòng đăng nhập bằng Email!');
                window.location.href = 'index.php?url=login';
              </script>";
    }

    public function appleLogin() {
        echo "<script>
                alert('Tính năng đăng nhập Apple sẽ sớm ra mắt trong phiên bản tới!');
                window.location.href = 'index.php?url=login';
              </script>";
    }
}