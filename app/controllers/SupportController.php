<?php

require_once __DIR__ . '/../models/SupportModel.php';

class SupportController extends Controller
{
    private $supportModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->supportModel = new SupportModel();
    }

    public function index()
    {
        $userId = $_SESSION['user_id'] ?? '';

        $this->view('support/index', [
            'title' => 'Hỗ trợ khách hàng',
            'faqs' => $this->supportModel->getFaqs(),
            'questions' => $userId !== '' ? $this->supportModel->getQuestionsByUser((string)$userId) : [],
            'errors' => $_SESSION['support_errors'] ?? [],
            'old' => $_SESSION['support_old'] ?? [],
            'success' => $_SESSION['support_success'] ?? '',
            'error' => $_SESSION['support_error'] ?? '',
        ]);

        unset(
            $_SESSION['support_errors'],
            $_SESSION['support_old'],
            $_SESSION['support_success'],
            $_SESSION['support_error']
        );
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=support');
            exit;
        }

        if (empty($_SESSION['user_id'])) {
            $_SESSION['support_error'] = 'Vui lòng đăng nhập để gửi câu hỏi hỗ trợ.';
            header('Location: index.php?url=login');
            exit;
        }

        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'question' => trim($_POST['question'] ?? ''),
        ];
        $_SESSION['support_old'] = $data;

        $errors = $this->supportModel->validateQuestion($data);
        if (!empty($errors)) {
            $_SESSION['support_errors'] = $errors;
            header('Location: index.php?url=support');
            exit;
        }

        $saved = $this->supportModel->createQuestion(
            (string)$_SESSION['user_id'],
            $data['title'],
            $data['question']
        );

        if ($saved) {
            $_SESSION['support_success'] = 'Câu hỏi của bạn đã được gửi. Admin sẽ phản hồi trong mục này.';
            unset($_SESSION['support_old']);
        } else {
            $_SESSION['support_error'] = 'Chưa thể lưu câu hỏi. Vui lòng kiểm tra bảng hotrokhachhang hoặc thử lại.';
        }

        header('Location: index.php?url=support');
        exit;
    }
}
