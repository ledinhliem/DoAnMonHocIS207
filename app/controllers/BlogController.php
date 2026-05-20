<?php
require_once __DIR__ . '/../models/BlogModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/NewsletterModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

class BlogController extends Controller
{
    private $blogModel;
    private $productModel;
    private $newsletterModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->productModel = new ProductModel();
        $this->newsletterModel = new NewsletterModel();
    }

    public function index()
    {
        $blogs = $this->blogModel->getAll();

        $this->view('blog/index', [
            'title' => 'Blog',
            'blogs' => $blogs,
            'success' => $_SESSION['success'] ?? '',
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 1;
        $blog = $this->blogModel->getById($id);

        if (!$blog) {
            echo 'Không tìm thấy bài viết';
            return;
        }

        $products = $this->productModel->getAll();

        $this->view('blog/detail', [
            'title' => $blog['title'],
            'blog' => $blog,
            'products' => array_slice($products, 0, 4),
        ]);
    }

    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=blog');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $redirectTo = trim($_POST['redirect_to'] ?? '?url=blog');

        if ($redirectTo === '' || (!str_starts_with($redirectTo, '/') && !str_starts_with($redirectTo, '?'))) {
            $redirectTo = '?url=blog';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Email không hợp lệ.';
            $_SESSION['error'] = $message;
            $_SESSION['newsletter_error'] = $message;
            header('Location: ' . $redirectTo);
            exit;
        }

        $result = $this->newsletterModel->subscribe($email);

        if (!$result['success']) {
            $_SESSION['error'] = $result['message'];
            $_SESSION['newsletter_error'] = $result['message'];
            header('Location: ' . $redirectTo);
            exit;
        }

        $mailSent = false;
        if ($result['status'] === 'created') {
            $mailSent = $this->sendNewsletterConfirmation($email);
            $this->sendNewsletterAdminNotice($email);
        }

        $message = $result['status'] === 'exists'
            ? 'Email này đã có trong danh sách nhận bản tin.'
            : ($mailSent
                ? 'Đăng ký thành công. Vui lòng kiểm tra email xác nhận.'
                : 'Đăng ký thành công. Email đã được lưu, nhưng máy chủ local chưa gửi được email xác nhận.');

        $_SESSION['success'] = $message;
        $_SESSION['newsletter_success'] = $message;
        header('Location: ' . $redirectTo);
        exit;
    }

    private function sendNewsletterConfirmation(string $email): bool
    {
        $subject = 'Zentro Journal - Cảm ơn bạn đã đăng ký';
        $body = implode("\r\n", [
            'Xin chào,',
            '',
            'Cảm ơn bạn đã đăng ký nhận bản tin Zentro Journal.',
            'Zentro sẽ gửi đến bạn các bài viết mới, thông tin sản phẩm bền vững và ưu đãi phù hợp.',
            '',
            'Trân trọng,',
            'Zentro',
        ]);

        return $this->sendPlainEmail($email, $subject, $body);
    }

    private function sendNewsletterAdminNotice(string $email): bool
    {
        if (!defined('NEWSLETTER_ADMIN_EMAIL') || NEWSLETTER_ADMIN_EMAIL === '') {
            return false;
        }

        $subject = 'Zentro - Có người đăng ký newsletter mới';
        $body = "Email mới đăng ký nhận bản tin: {$email}";

        return $this->sendPlainEmail(NEWSLETTER_ADMIN_EMAIL, $subject, $body);
    }

    private function sendPlainEmail(string $to, string $subject, string $body): bool
    {
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
        }
    }
}
