<?php

$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

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
                        if (isset($user['TrangThai']) && (int)$user['TrangThai'] === 0) {
                            $data['error'] = 'Tài khoản của bạn đang bị khóa.';
                        } else {
                            $_SESSION['user_id'] = $user['MaNguoiDung'];
                            $_SESSION['user_name'] = $user['HoTen'];
                            $_SESSION['user_email'] = $user['Email'];
                            $_SESSION['role'] = $user['MaQuyen']; 

                        // Chuyển hướng theo phân quyền
                        if ($user['MaQuyen'] == '1') {
                            header('Location: index.php?url=admin/dashboard'); // Admin
                        } else {
                            header('Location: index.php?url=profile'); // Khách hàng
                        }
                            exit();
                        }
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
public function forgot() {
    $data = ['title' => 'Quên mật khẩu'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['error_message'] = 'Vui lòng nhập địa chỉ email hợp lệ.';
        } else {
            $userModel = $this->model('UserModel');
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);

                if ($userModel->createPasswordResetToken($email, $tokenHash)) {
                    $resetUrl = $this->buildResetPasswordUrl($token);
                    $sent = $this->sendPasswordResetEmail($email, $user['HoTen'] ?? 'bạn', $resetUrl);

                    if ($sent) {
                        $data['success_message'] = 'Hướng dẫn đặt lại mật khẩu đã được gửi đến email của bạn.';
                    } else {
                        $data['error_message'] = 'Không thể gửi email đặt lại mật khẩu. Vui lòng thử lại sau.';
                    }
                } else {
                    $data['error_message'] = 'Có lỗi xảy ra, vui lòng thử lại sau.';
                }
            } else {
                    $data['error_message'] = 'Email không tồn tại trên hệ thống.';            }
        }
    }

    $this->view('auth/forgot', $data);
}

public function reset() {
    $token = trim($_GET['token'] ?? $_POST['token'] ?? '');
    $data = [
        'title' => 'Đặt lại mật khẩu',
        'token' => $token
    ];

    if ($token === '') {
        $data['error_message'] = 'Liên kết đặt lại mật khẩu không hợp lệ.';
        $this->view('auth/reset', $data);
        return;
    }

    $userModel = $this->model('UserModel');
    $tokenHash = hash('sha256', $token);
    $resetRecord = $userModel->getValidPasswordReset($tokenHash);

    if (!$resetRecord) {
        $data['error_message'] = 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.';
        $this->view('auth/reset', $data);
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (strlen($password) < 6) {
            $data['error_message'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        } elseif ($password !== $confirm) {
            $data['error_message'] = 'Mật khẩu xác nhận không khớp.';
        } elseif ($userModel->updatePasswordByEmail($resetRecord['email'], password_hash($password, PASSWORD_DEFAULT))) {
            $userModel->deletePasswordResetToken($tokenHash);
            $_SESSION['auth_message'] = 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới.';
            header('Location: index.php?url=login');
            exit;
        } else {
            $data['error_message'] = 'Không thể cập nhật mật khẩu. Vui lòng thử lại sau.';
        }
    }

    $this->view('auth/reset', $data);
}

private function buildResetPasswordUrl(string $token): string {
    $baseUrl = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

    if ($baseUrl !== '') {
        return $baseUrl . '/index.php?url=reset-password&token=' . urlencode($token);
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $path = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'), '/\\');

    return $scheme . '://' . $host . $path . '/index.php?url=reset-password&token=' . urlencode($token);
}

private function sendPasswordResetEmail(string $email, string $name, string $resetUrl): bool {
    $subject = 'Zentro - Đặt lại mật khẩu';
    $body = implode("\r\n", [
        'Xin chào ' . $name . ',',
        '',
        'Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản Zentro.',
        'Bấm vào liên kết bên dưới để tạo mật khẩu mới:',
        $resetUrl,
        '',
        'Liên kết này sẽ hết hạn sau 60 phút.',
        'Nếu bạn không yêu cầu, hãy bỏ qua email này.',
        '',
        'Trân trọng,',
        'Zentro',
    ]);

    return $this->sendPlainEmail($email, $subject, $body);
}

private function sendPlainEmail(string $to, string $subject, string $body): bool {
    if (!class_exists(PHPMailer::class)) {
        return false;
    }

    if (
        !defined('SMTP_HOST') ||
        !defined('SMTP_PORT') ||
        !defined('SMTP_USERNAME') ||
        !defined('SMTP_PASSWORD') ||
        SMTP_USERNAME === '' ||
        SMTP_PASSWORD === ''
    ) {
        return false;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)SMTP_PORT;

        $fromEmail = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : SMTP_USERNAME;
        $fromName = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Zentro';

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;

        return $mail->send();
    } catch (MailException $e) {
        return false;
    } catch (Throwable $e) {
        return false;
    }
}

public function googleLogin() {
    $config = $this->getGoogleOAuthConfig();

    if (!$config['ready']) {
        $_SESSION['auth_error'] = 'Google Login chưa được cấu hình. Vui lòng kiểm tra GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET và GOOGLE_REDIRECT_URI.';
        header('Location: index.php?url=login');
        exit;
    }

    $state = bin2hex(random_bytes(32));
    $_SESSION['google_oauth_state'] = $state;

    $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => $config['client_id'],
        'redirect_uri' => $config['redirect_uri'],
        'response_type' => 'code',
        'scope' => 'openid email profile',
        'state' => $state,
        'access_type' => 'online',
        'prompt' => 'select_account'
    ]);

    header('Location: ' . $authUrl);
    exit;
}

public function googleCallback() {
    $config = $this->getGoogleOAuthConfig();

    if (!$config['ready']) {
        $_SESSION['auth_error'] = 'Google Login chưa được cấu hình đầy đủ.';
        header('Location: index.php?url=login');
        exit;
    }

    if (!empty($_GET['error'])) {
        $_SESSION['auth_error'] = 'Google từ chối đăng nhập: ' . htmlspecialchars($_GET['error']);
        header('Location: index.php?url=login');
        exit;
    }

    $state = $_GET['state'] ?? '';
    $sessionState = $_SESSION['google_oauth_state'] ?? '';
    unset($_SESSION['google_oauth_state']);

    if ($state === '' || $sessionState === '' || !hash_equals($sessionState, $state)) {
        $_SESSION['auth_error'] = 'Phiên đăng nhập Google không hợp lệ. Vui lòng thử lại.';
        header('Location: index.php?url=login');
        exit;
    }

    $code = $_GET['code'] ?? '';
    if ($code === '') {
        $_SESSION['auth_error'] = 'Google không trả về mã xác thực.';
        header('Location: index.php?url=login');
        exit;
    }

    $tokenResponse = $this->httpPostForm('https://oauth2.googleapis.com/token', [
        'code' => $code,
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'],
        'redirect_uri' => $config['redirect_uri'],
        'grant_type' => 'authorization_code'
    ]);

    if (!$tokenResponse['ok']) {
        $_SESSION['auth_error'] = 'Không thể xác thực với Google. Vui lòng thử lại.';
        header('Location: index.php?url=login');
        exit;
    }

    $tokenData = json_decode($tokenResponse['body'], true);
    $accessToken = $tokenData['access_token'] ?? '';

    if ($accessToken === '') {
        $_SESSION['auth_error'] = 'Google không trả về access token hợp lệ.';
        header('Location: index.php?url=login');
        exit;
    }

    $profileResponse = $this->httpGetJson('https://www.googleapis.com/oauth2/v3/userinfo', [
        'Authorization: Bearer ' . $accessToken
    ]);

    if (!$profileResponse['ok']) {
        $_SESSION['auth_error'] = 'Không thể lấy thông tin tài khoản Google.';
        header('Location: index.php?url=login');
        exit;
    }

    $googleProfile = json_decode($profileResponse['body'], true);
    $email = trim($googleProfile['email'] ?? '');
    $verified = filter_var($googleProfile['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);

    if ($email === '' || !$verified) {
        $_SESSION['auth_error'] = 'Tài khoản Google cần có email đã xác minh.';
        header('Location: index.php?url=login');
        exit;
    }

    $googleUserData = [
        'google_id' => (string)($googleProfile['sub'] ?? ''),
        'email' => $email,
        'name' => trim($googleProfile['name'] ?? ''),
        'avatar' => (string)($googleProfile['picture'] ?? '')
    ];

    $userModel = $this->model('UserModel');
    $user = $userModel->findByGoogleId($googleUserData['google_id']);

    if (!$user) {
        $user = $userModel->findByEmail($email);

        if ($user) {
            $userModel->linkGoogleAccount($user['MaNguoiDung'], $googleUserData['google_id'], $googleUserData['avatar']);
            $user = $userModel->findByEmail($email);
        } else {
            $user = $userModel->createGoogleUser($googleUserData);
        }
    } else {
        $userModel->updateGoogleUserInfo($user['MaNguoiDung'], $googleUserData);
        $user = $userModel->getUserById($user['MaNguoiDung']) ?: $user;
    }

    if (!$user) {
        $_SESSION['auth_error'] = 'Không thể tạo hoặc đăng nhập tài khoản Google.';
        header('Location: index.php?url=login');
        exit;
    }

    if (isset($user['TrangThai']) && (int)$user['TrangThai'] === 0) {
        $_SESSION['auth_error'] = 'Tài khoản của bạn đang bị khóa.';
        header('Location: index.php?url=login');
        exit;
    }

    $this->setLoginSession($user);

    if (($user['MaQuyen'] ?? '') == '1') {
        header('Location: index.php?url=admin/dashboard');
    } else {
        header('Location: index.php');
    }
    exit;
}

private function getGoogleOAuthConfig(): array {
    $clientId = defined('GOOGLE_CLIENT_ID') ? trim(GOOGLE_CLIENT_ID) : '';
    $clientSecret = defined('GOOGLE_CLIENT_SECRET') ? trim(GOOGLE_CLIENT_SECRET) : '';
    $redirectUri = defined('GOOGLE_REDIRECT_URI') ? trim(GOOGLE_REDIRECT_URI) : '';

    return [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'ready' => $clientId !== '' && $clientSecret !== '' && $redirectUri !== ''
    ];
}

private function setLoginSession(array $user): void {
    $_SESSION['user_id'] = $user['MaNguoiDung'];
    $_SESSION['user_name'] = $user['HoTen'];
    $_SESSION['user_email'] = $user['Email'];
    $_SESSION['role'] = $user['MaQuyen'];
}

private function httpPostForm(string $url, array $data): array {
    $body = http_build_query($data);

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_TIMEOUT => 15
        ]);

        $response = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'ok' => $response !== false && $status >= 200 && $status < 300,
            'body' => $response !== false ? $response : '',
            'error' => $error
        ];
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $body,
            'timeout' => 15
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    return [
        'ok' => $response !== false,
        'body' => $response !== false ? $response : '',
        'error' => $response === false ? 'request_failed' : ''
    ];
}

private function httpGetJson(string $url, array $headers = []): array {
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array_merge(['Accept: application/json'], $headers),
            CURLOPT_TIMEOUT => 15
        ]);

        $response = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'ok' => $response !== false && $status >= 200 && $status < 300,
            'body' => $response !== false ? $response : '',
            'error' => $error
        ];
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", array_merge(['Accept: application/json'], $headers)) . "\r\n",
            'timeout' => 15
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    return [
        'ok' => $response !== false,
        'body' => $response !== false ? $response : '',
        'error' => $response === false ? 'request_failed' : ''
    ];
}

public function appleLogin() {
    $_SESSION['auth_message'] = 'Chức năng đăng nhập Apple chưa được cấu hình.';
    header('Location: index.php?url=login');
    exit;
}


}
