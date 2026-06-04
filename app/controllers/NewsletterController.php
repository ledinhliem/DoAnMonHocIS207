<?php

require_once __DIR__ . '/../models/NewsletterModel.php';

$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

class NewsletterController extends Controller
{
    private $newsletterModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->newsletterModel = new NewsletterModel();
    }

    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $redirectTo = trim($_POST['redirect_to'] ?? '?url=');

        if ($redirectTo === '' || (!str_starts_with($redirectTo, '/') && !str_starts_with($redirectTo, '?'))) {
            $redirectTo = '?url=';
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

        $mailSent = $this->sendNewsletterConfirmation($email);

        if ($result['status'] === 'created') {
            $this->sendNewsletterAdminNotice($email);
        }

        $message = $result['status'] === 'exists'
            ? ($mailSent
                ? 'Email này đã có trong danh sách. Zentro đã gửi lại email xác nhận cho bạn.'
                : 'Email này đã có trong danh sách, nhưng máy chủ chưa gửi lại được email xác nhận.')
            : ($mailSent
                ? 'Đăng ký thành công. Vui lòng kiểm tra email xác nhận.'
                : 'Đăng ký thành công. Email đã được lưu, nhưng máy chủ chưa gửi được email xác nhận.');

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
}
