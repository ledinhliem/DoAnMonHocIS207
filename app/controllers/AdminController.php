<?php

class AdminController extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->checkAdminAccess();
        $this->adminModel = $this->model('AdminModel');
    }

    private function checkAdminAccess()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $role = $_SESSION['role'] ?? $_SESSION['MaQuyen'] ?? null;

        if ((string)$role !== '1') {
            header('Location: index.php');
            exit;
        }
    }

    public function dashboard()
    {
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_discount':
                    $code = trim($_POST['code'] ?? '');
                    $percent = (int)($_POST['percent'] ?? 0);

                    if ($code !== '' && $percent > 0) {
                        $status = 'success';
                        $message = "Đã kích hoạt mã $code giảm $percent% toàn hệ thống!";
                    } else {
                        $status = 'error';
                        $message = 'Vui lòng nhập đầy đủ thông tin mã giảm giá!';
                    }
                    break;

                case 'delete':
                    $id = $_POST['promo_id'] ?? '';
                    $status = 'success';
                    $message = "Đã gỡ bỏ khuyến mãi: $id";
                    break;

                case 'export_report':
                    $status = 'success';
                    $message = 'Báo cáo Eco-Impact đã được gửi về email của bạn.';
                    break;
            }
        }

        $this->view('admin/dashboard', [
            'title' => 'Admin Bảng điều khiển',
            'status' => $status,
            'message' => $message
        ]);
    }

    public function products()
    {
        $this->view('admin/products', [
            'title' => 'Quản lý sản phẩm'
        ]);
    }

    public function orders()
    {
        $this->view('admin/orders', [
            'title' => 'Quản lý đơn hàng'
        ]);
    }

    public function inventory()
    {
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add_supplier':
                    $supplierName = trim($_POST['supplier_name'] ?? '');
                    $taxId = trim($_POST['tax_id'] ?? '');

                    if ($supplierName !== '' && $taxId !== '') {
                        $status = 'success';
                        $message = "Đã đăng ký thành công nhà cung cấp: $supplierName";
                    } else {
                        $status = 'error';
                        $message = 'Vui lòng điền đầy đủ các trường bắt buộc!';
                    }
                    break;

                case 'delete':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đã xóa bản ghi phiếu nhập #$entryId thành công.";
                    break;

                case 'edit':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đang mở chế độ chỉnh sửa cho phiếu #$entryId.";
                    break;

                case 'view':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đang tải chi tiết phiếu nhập #$entryId...";
                    break;
            }
        }

        $this->view('admin/inventory', [
            'title' => 'Quản lý kho',
            'status' => $status,
            'message' => $message
        ]);
    }

    public function reviews()
    {
        $this->view('admin/reviews', [
            'title' => 'Quản lý đánh giá'
        ]);
    }

    public function blog()
    {
        $status = null;
        $message = '';
        $editingPost = null;

        $url = $_GET['url'] ?? '';
        $segments = explode('/', trim($url, '/'));
        $actionFromUrl = $segments[2] ?? null;
        $idFromUrl = $segments[3] ?? null;

        if ($actionFromUrl === 'edit' && $idFromUrl) {
            $editingPost = $this->adminModel->getPostById($idFromUrl);

            if (!$editingPost) {
                $status = 'error';
                $message = 'Không tìm thấy bài viết cần sửa!';
            }
        }

        if ($actionFromUrl === 'delete' && $idFromUrl) {
            if ($this->adminModel->deletePost($idFromUrl)) {
                header('Location: index.php?url=admin/blog&status=success&message=' . urlencode('Đã xóa bài viết thành công!'));
                exit;
            }

            header('Location: index.php?url=admin/blog&status=error&message=' . urlencode('Xóa bài viết thất bại!'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $postId = $_POST['post_id'] ?? '';
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $currentImage = $_POST['current_image'] ?? '';

            if ($title === '' || $content === '') {
                $status = 'error';
                $message = 'Vui lòng nhập đầy đủ tiêu đề và nội dung bài viết!';
            } else {
                $coverImage = $this->uploadCoverImage('cover_image', $currentImage);

                if ($coverImage === false) {
                    $status = 'error';
                    $message = 'Ảnh bìa không hợp lệ. Chỉ cho phép jpg, jpeg, png, webp!';
                } else {
                    $data = [
                        'TieuDe' => $title,
                        'NoiDung' => $content,
                        'HinhAnhBia' => $coverImage,
                        'MaNguoiDung' => $_SESSION['user_id']
                    ];

                    if ($action === 'create_post') {
                        if ($this->adminModel->createPost($data)) {
                            header('Location: index.php?url=admin/blog&status=success&message=' . urlencode('Đã thêm bài viết thành công!'));
                            exit;
                        }

                        $status = 'error';
                        $message = 'Thêm bài viết thất bại!';
                    }

                    if ($action === 'update_post') {
                        if ($postId === '') {
                            $status = 'error';
                            $message = 'Không tìm thấy ID bài viết cần sửa!';
                        } elseif ($this->adminModel->updatePost($postId, $data)) {
                            header('Location: index.php?url=admin/blog&status=success&message=' . urlencode('Đã cập nhật bài viết thành công!'));
                            exit;
                        } else {
                            $status = 'error';
                            $message = 'Cập nhật bài viết thất bại!';
                        }
                    }
                }
            }
        }

        if (isset($_GET['status'], $_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
        }

        $posts = $this->adminModel->getAllPosts();

        $this->view('admin/blog', [
            'title' => 'Quản lý Blog',
            'status' => $status,
            'message' => $message,
            'posts' => $posts,
            'editingPost' => $editingPost
        ]);
    }

    public function promo()
    {
        $status = null;
        $message = '';
        $editingPromo = null;

        $url = $_GET['url'] ?? '';
        $segments = explode('/', trim($url, '/'));
        $actionFromUrl = $segments[2] ?? null;
        $idFromUrl = $segments[3] ?? null;

        if ($actionFromUrl === 'edit' && $idFromUrl) {
            $editingPromo = $this->adminModel->getPromoById($idFromUrl);

            if (!$editingPromo) {
                $status = 'error';
                $message = 'Không tìm thấy mã giảm giá cần sửa!';
            }
        }

        if ($actionFromUrl === 'delete' && $idFromUrl) {
            if ($this->adminModel->deletePromo($idFromUrl)) {
                header('Location: index.php?url=admin/promo&status=success&message=' . urlencode('Đã xóa mã giảm giá thành công!'));
                exit;
            }

            header('Location: index.php?url=admin/promo&status=error&message=' . urlencode('Xóa mã giảm giá thất bại!'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $promoId = $_POST['promo_id'] ?? '';
            $code = strtoupper(trim($_POST['code'] ?? ''));
            $percent = (int)($_POST['percent'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 0);
            $expiredDate = $_POST['expired_date'] ?? '';

            if (!$this->isValidPromoData($code, $percent, $quantity, $expiredDate, $message)) {
                $status = 'error';
            } elseif ($this->adminModel->promoCodeExists($code, $action === 'update_promo' ? $promoId : null)) {
                $status = 'error';
                $message = 'Mã giảm giá này đã tồn tại!';
            } else {
                $data = [
                    'MaCode' => $code,
                    'PhamTramGiam' => $percent,
                    'SoLuong' => $quantity,
                    'NgayHetHan' => $expiredDate
                ];

                if ($action === 'create_promo') {
                    if ($this->adminModel->createPromo($data)) {
                        header('Location: index.php?url=admin/promo&status=success&message=' . urlencode('Đã tạo mã giảm giá thành công!'));
                        exit;
                    }

                    $status = 'error';
                    $message = 'Tạo mã giảm giá thất bại!';
                }

                if ($action === 'update_promo') {
                    if ($promoId === '') {
                        $status = 'error';
                        $message = 'Không tìm thấy ID mã giảm giá cần sửa!';
                    } elseif ($this->adminModel->updatePromo($promoId, $data)) {
                        header('Location: index.php?url=admin/promo&status=success&message=' . urlencode('Đã cập nhật mã giảm giá thành công!'));
                        exit;
                    } else {
                        $status = 'error';
                        $message = 'Cập nhật mã giảm giá thất bại!';
                    }
                }
            }
        }

        if (isset($_GET['status'], $_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
        }

        $promos = $this->adminModel->getAllPromos();

        $this->view('admin/promo', [
            'title' => 'Quản lý mã giảm giá',
            'status' => $status,
            'message' => $message,
            'promos' => $promos,
            'editingPromo' => $editingPromo
        ]);
    }

    private function isValidPromoData($code, $percent, $quantity, $expiredDate, &$message)
    {
        if ($code === '') {
            $message = 'Vui lòng nhập mã giảm giá!';
            return false;
        }

        if ($percent <= 0 || $percent > 100) {
            $message = 'Phần trăm giảm phải lớn hơn 0 và không vượt quá 100!';
            return false;
        }

        if ($quantity <= 0) {
            $message = 'Số lượng mã giảm giá phải lớn hơn 0!';
            return false;
        }

        if ($expiredDate === '') {
            $message = 'Vui lòng chọn ngày hết hạn!';
            return false;
        }

        $today = date('Y-m-d');

        if ($expiredDate < $today) {
            $message = 'Ngày hết hạn không được nhỏ hơn ngày hiện tại!';
            return false;
        }

        return true;
    }

    private function uploadCoverImage($inputName, $currentImage = '')
    {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] === UPLOAD_ERR_NO_FILE) {
            return $currentImage;
        }

        if ($_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $originalName = $_FILES[$inputName]['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        $uploadDir = __DIR__ . '/../../public/assets/images/blog/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $destination)) {
            return false;
        }

        return 'public/assets/images/blog/' . $fileName;
    }
}