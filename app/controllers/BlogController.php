<?php

require_once __DIR__ . '/../models/BlogModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/NewsletterModel.php';

$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;

class BlogController extends Controller
{
    private $blogModel;
    private $productModel;
    private $newsletterModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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

    public function detail($id = null)
    {
        // Hỗ trợ cả 2 dạng link:
        // ?url=blog/detail&id=BL004
        // ?url=blog/detail/BL004
        $id = $id ?? ($_GET['id'] ?? '');

        if ($id === '') {
            echo 'Thiếu mã bài viết.';
            return;
        }

        $blog = $this->blogModel->getById($id);

        if (!$blog) {
            echo 'Không tìm thấy bài viết.';
            return;
        }

        $relatedData = $this->getRelatedProductsForBlog($blog, $id);

        $this->view('blog/detail', [
            'title' => $blog['title'] ?? 'Blog',
            'blog' => $blog,
            'products' => $relatedData['products'],
            'relatedTitle' => $relatedData['title'],
            'relatedDescription' => $relatedData['description'],
            'relatedCollectionUrl' => $relatedData['collectionUrl'],
        ]);
    }

   private function getRelatedProductsForBlog(array $blog, string $blogId): array
{
    /*
        ID blog thực tế trong web hiện tại:
        BL004 = Limloop tái sinh rác thải nhựa
        BL003 = Tẩy da chết thuần chay
        BL002 = Công nghệ vải sợi cà phê
        BL001 = Hành trình Zero Waste

        Sản phẩm vẫn lấy từ cửa hàng bằng ProductModel->getAll().
        Ở đây chỉ chọn đúng mã sản phẩm phù hợp với từng blog.
    */

    $productIds = [];
    $relatedTitle = 'Sản phẩm sống xanh liên quan';
    $relatedDescription = 'Các sản phẩm được lấy trực tiếp từ cửa hàng Zentro và chọn theo chủ đề bài viết.';
    $collectionUrl = '?url=product';

    if ($blogId === 'BL004') {
        // Limloop: rác thải nhựa, tái chế, thủ công
        // Chọn sản phẩm liên quan trực tiếp đến tái chế, giảm nhựa, upcycling.
        $productIds = ['P007', 'P010', 'P003', 'P008'];

        $relatedTitle = 'Sản phẩm tái chế và giảm nhựa';
        $relatedDescription = 'Gợi ý các sản phẩm trong cửa hàng phù hợp với tinh thần tái sinh vật liệu, giảm rác thải nhựa và kéo dài vòng đời sản phẩm như câu chuyện Limloop.';
        $collectionUrl = '?url=product&impact=tái%20chế';
    } elseif ($blogId === 'BL003') {
        // Tẩy da chết thuần chay: skincare, mỹ phẩm, hạt vi nhựa
        $productIds = ['P001', 'P002', 'P028', 'P029'];

        $relatedTitle = 'Sản phẩm chăm sóc cá nhân xanh';
        $relatedDescription = 'Gợi ý các sản phẩm chăm sóc cá nhân trong cửa hàng, phù hợp với chủ đề thuần chay, lành tính và hạn chế hạt vi nhựa.';
        $collectionUrl = '?url=product&category=C004';
    } elseif ($blogId === 'BL002') {
        // Vải sợi cà phê: thời trang tuần hoàn, chất liệu mới
        $productIds = ['P005', 'P006', 'P020', 'P022'];

        $relatedTitle = 'Sản phẩm thời trang bền vững';
        $relatedDescription = 'Gợi ý các sản phẩm thời trang trong cửa hàng, phù hợp với chủ đề vải sợi cà phê, vật liệu tái chế và thời trang tuần hoàn.';
        $collectionUrl = '?url=product&category=C003';
    } elseif ($blogId === 'BL001') {
        // Hành trình Zero Waste: đồ dùng hằng ngày, giảm rác
        $productIds = ['P003', 'P004', 'P008', 'P011'];

        $relatedTitle = 'Sản phẩm zero-waste cho thói quen hằng ngày';
        $relatedDescription = 'Gợi ý các sản phẩm trong cửa hàng giúp giảm nhựa dùng một lần, thay thế đồ dùng khó phân hủy và bắt đầu lối sống zero-waste.';
        $collectionUrl = '?url=product&category=C001';
    }

    $products = $this->getProductsByIdsFromStore($productIds);

    return [
        'products' => $products,
        'title' => $relatedTitle,
        'description' => $relatedDescription,
        'collectionUrl' => $collectionUrl,
    ];
}

private function getProductsByIdsFromStore(array $ids): array
{
    $allProducts = $this->productModel->getAll();

    $productMap = [];

    foreach ($allProducts as $product) {
        $productId = $product['MaSanPham'] ?? $product['id'] ?? '';

        if ($productId !== '') {
            $productMap[$productId] = $product;
        }
    }

    $selectedProducts = [];

    foreach ($ids as $id) {
        if (isset($productMap[$id])) {
            $selectedProducts[] = $productMap[$id];
        }
    }

    return $selectedProducts;
}

    private function containsAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            $keyword = mb_strtolower($keyword, 'UTF-8');

            if (mb_strpos($text, $keyword, 0, 'UTF-8') !== false) {
                return true;
            }
        }

        return false;
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