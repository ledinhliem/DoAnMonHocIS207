<?php
/**
 * UserController - Controller cho quản lý người dùng
 * 
 * Xử lý các request liên quan đến:
 * - Đăng nhập (login)
 * - Đăng ký (register)
 * - Xem thông tin cá nhân (profile)
 * - Đăng xuất (logout)
 */

class UserController extends Controller
{
    /**
     * Hàm hỗ trợ redirect (chuyển hướng trang)
     * 
     * @param string $url Đường dẫn routing (ví dụ: 'user/login')
     */
    private function redirect($url)
    {
        header("Location: " . BASE_URL . "/index.php?url=" . $url);
        exit();
    }

    /**
     * Action đăng nhập
     * 
     * GET: Hiển thị form đăng nhập
     * POST: Xử lý dữ liệu đăng nhập
     */
    public function login()
    {
        // Xử lý request POST (form submit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Validate dữ liệu cơ bản
            if (empty($email) || empty($password)) {
                $data = ['error' => 'Email và mật khẩu không được để trống.'];
                $this->view('user/login', $data);
                return;
            }

            // Load model và gọi hàm login
            $userModel = $this->model('UserModel');
            $user = $userModel->login($email, $password);

            // Kiểm tra đăng nhập
            if ($user) {
                // Đăng nhập thành công
                $_SESSION['user'] = $user;
                $_SESSION['success'] = 'Đăng nhập thành công!';
                
                // Chuyển hướng đến trang profile
                $this->redirect('user/profile');
            } else {
                // Đăng nhập thất bại
                $data = ['error' => 'Email hoặc mật khẩu không chính xác.'];
                $this->view('user/login', $data);
            }
        } else {
            // Xử lý request GET (hiển thị form)
            $data = [];
            
            // Kiểm tra có success message từ lần trước không
            if (isset($_SESSION['success'])) {
                $data['success'] = $_SESSION['success'];
                unset($_SESSION['success']);  // Xóa message sau khi sử dụng
            }
            
            $this->view('user/login', $data);
        }
    }

    /**
     * Action đăng ký
     * 
     * GET: Hiển thị form đăng ký
     * POST: Xử lý dữ liệu đăng ký (tuần sau sẽ lưu vào DB)
     */
    public function register()
    {
        // Xử lý request GET (hiển thị form)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [];
            $this->view('user/register', $data);
        } else {
            // Xử lý request POST (week sau sẽ lưu vào DB)
            // Hiện tại chỉ validate form và hiển thị thông báo
            $fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

            // Validate cơ bản
            $errors = [];
            if (empty($fullName)) {
                $errors[] = 'Họ tên không được để trống.';
            }
            if (empty($email)) {
                $errors[] = 'Email không được để trống.';
            }
            if (empty($password) || empty($confirmPassword)) {
                $errors[] = 'Mật khẩu không được để trống.';
            }
            if ($password !== $confirmPassword) {
                $errors[] = 'Mật khẩu xác nhận không khớp.';
            }

            if (!empty($errors)) {
                $data = ['errors' => $errors];
                $this->view('user/register', $data);
            } else {
                // Tuần 1 chỉ validate, tuần sau sẽ save vào DB
                $data = ['success' => 'Đăng ký thành công! Vui lòng đăng nhập.'];
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                $this->redirect('user/login');
            }
        }
    }

    /**
     * Action xem thông tin cá nhân
     * 
     * Yêu cầu phải đã đăng nhập (kiểm tra SESSION)
     * Hiển thị thông tin user + danh sách địa chỉ
     */
    public function profile()
    {
        // Kiểm tra xem người dùng có đăng nhập không
        if (empty($_SESSION['user'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang login
            $this->redirect('user/login');
        }

        // Lấy ID của người dùng từ session
        $userId = $_SESSION['user']['id'];

        // Load model
        $userModel = $this->model('UserModel');

        // Lấy thông tin cá nhân
        $userProfile = $userModel->getUserProfile($userId);

        // Lấy danh sách địa chỉ
        $addresses = $userModel->getUserAddresses($userId);

        // Chuẩn bị dữ liệu để truyền sang view
        $data = [
            'user' => $userProfile,
            'addresses' => $addresses
        ];

        // Gọi view
        $this->view('user/profile', $data);
    }

    /**
     * Action đăng xuất
     * 
     * Xóa thông tin người dùng khỏi session
     * Chuyển hướng về trang đăng nhập
     */
    public function logout()
    {
        // Xóa thông tin người dùng khỏi session
        unset($_SESSION['user']);

        // Tùy chọn: Xóa toàn bộ session (nếu muốn)
        // session_destroy();

        // Lưu thông báo đăng xuất
        $_SESSION['success'] = 'Bạn đã đăng xuất thành công.';

        // Chuyển hướng về trang đăng nhập
        $this->redirect('user/login');
    }
}
