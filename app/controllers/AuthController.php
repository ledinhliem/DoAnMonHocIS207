<?php
class AuthController extends Controller {

    public function login() {
        $data = ['title' => 'Đăng nhập'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin.';
            } else {
                $userModel = $this->model('UserModel');
                $user = $userModel->getUserByEmail($email);
            
                if ($user) {
                    $dbPass = trim($user['MatKhau']);

                    // QUAN TRỌNG: Kiểm tra cả 2 trường hợp (mật khẩu mới mã hóa VÀ mật khẩu cũ chưa mã hóa)
                    if (password_verify($password, $dbPass) || $password === $dbPass) {
                        $_SESSION['user_id'] = $user['MaNguoiDung'];
                        $_SESSION['user_name'] = $user['HoTen'];
                        $_SESSION['role'] = $user['MaQuyen']; 

                        // Chuyển hướng theo phân quyền
                        if ($user['MaQuyen'] == '1') {
                            header('Location: index.php?url=admin/dashboard'); // Admin
                        } else {
                            header('Location: index.php?url=profile'); // Khách hàng
                        }
                        exit();
                    } else {
                        $data['error'] = 'Mật khẩu không chính xác.';
                    }
                } else {
                    $data['error'] = 'Email không tồn tại trên hệ thống.';
                }
            }
        }
        $this->view('auth/login', $data);
    }

    public function register() {
        $data = ['title' => 'Đăng ký'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $data['error'] = 'Vui lòng điền đầy đủ thông tin.';
            } elseif ($password !== $confirm) {
                $data['error'] = 'Mật khẩu xác nhận không khớp.';
            } else {
                $userModel = $this->model('UserModel');
                if ($userModel->getUserByEmail($email)) {
                    $data['error'] = 'Email này đã tồn tại trên hệ thống.';
                } else {
                    // Chuẩn bị dữ liệu để lưu vào DB
                    $userData = [
                        'hoten' => $name,
                        'email' => $email,
                        'matkhau' => password_hash($password, PASSWORD_DEFAULT), // Mã hóa an toàn
                        'maquyen' => '2' // Mặc định người mới đăng ký là khách hàng (Quyền 2)
                    ];
                    if ($userModel->createUser($userData)) {
                        header('Location: index.php?url=login');
                        exit();
                    } else {
                        $data['error'] = 'Có lỗi xảy ra, không thể tạo tài khoản.';
                    }
                }
            }
        }
        $this->view('auth/register', $data);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();

        session_destroy();

        // Xóa cả cookie lưu session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Điều hướng về trang chủ hoặc trang đăng nhập
        $baseUrl = defined('BASE_URL') ? BASE_URL : 'index.php';
        header("Location: index.php");
        exit;
    }

}