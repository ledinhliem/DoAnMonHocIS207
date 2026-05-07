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
        $status = $_GET['status'] ?? null;
        $message = $_GET['message'] ?? '';

        $stats = $this->adminModel->getDashboardStats();
        $recentOrders = $this->adminModel->getRecentOrders(5);

        $this->view('admin/dashboard', [
            'title' => 'Admin Bảng điều khiển',
            'currentPage' => 'dashboard',
            'status' => $status,
            'message' => $message,
            'stats' => $stats,
            'recentOrders' => $recentOrders
        ]);
    }

    public function orders()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $filterStatus = trim($_GET['status'] ?? '');
        $status = $_GET['notice_status'] ?? null;
        $message = $_GET['message'] ?? '';

        $orders = $this->adminModel->getAllOrders($keyword, $filterStatus);
        $stats = $this->adminModel->getDashboardStats();

        $this->view('admin/orders', [
            'title' => 'Quản lý đơn hàng',
            'currentPage' => 'orders',
            'orders' => $orders,
            'stats' => $stats,
            'keyword' => $keyword,
            'filterStatus' => $filterStatus,
            'status' => $status,
            'message' => $message
        ]);
    }

    public function orderDetail()
    {
        $orderId = trim($_GET['id'] ?? '');

        if ($orderId === '') {
            header('Location: index.php?url=admin/orders&notice_status=error&message=' . urlencode('Thiếu mã đơn hàng.'));
            exit;
        }

        $order = $this->adminModel->getOrderById($orderId);

        if (!$order) {
            header('Location: index.php?url=admin/orders&notice_status=error&message=' . urlencode('Không tìm thấy đơn hàng.'));
            exit;
        }

        $items = $this->adminModel->getOrderItems($orderId);

        $this->view('admin/order_detail', [
            'title' => 'Chi tiết đơn hàng',
            'currentPage' => 'orders',
            'order' => $order,
            'items' => $items,
            'status' => $_GET['notice_status'] ?? null,
            'message' => $_GET['message'] ?? ''
        ]);
    }

    public function updateOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=admin/orders');
            exit;
        }

        $orderId = trim($_POST['order_id'] ?? '');
        $newStatus = trim($_POST['new_status'] ?? '');
        $redirect = $_POST['redirect'] ?? 'orders';

        if ($orderId === '') {
            header('Location: index.php?url=admin/orders&notice_status=error&message=' . urlencode('Thiếu mã đơn hàng.'));
            exit;
        }

        $result = $this->adminModel->updateOrderStatus($orderId, $newStatus);

        $noticeStatus = $result['success'] ? 'success' : 'error';
        $message = $result['message'];

        if ($redirect === 'detail') {
            header(
                'Location: index.php?url=admin/orders/detail&id=' . urlencode($orderId)
                . '&notice_status=' . urlencode($noticeStatus)
                . '&message=' . urlencode($message)
            );
            exit;
        }

        header(
            'Location: index.php?url=admin/orders'
            . '&notice_status=' . urlencode($noticeStatus)
            . '&message=' . urlencode($message)
        );
        exit;
    }

    public function products()
    {
        $this->view('admin/products', [
            'title' => 'Quản lý sản phẩm',
            'currentPage' => 'products'
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
                    $supplierName = $_POST['supplier_name'] ?? '';
                    $taxId = $_POST['tax_id'] ?? '';

                    if (!empty($supplierName) && !empty($taxId)) {
                        $status = 'success';
                        $message = "Đã đăng ký thành công nhà cung cấp: **$supplierName**";
                    } else {
                        $status = 'error';
                        $message = "Vui lòng điền đầy đủ các trường bắt buộc!";
                    }
                    break;

                case 'delete':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đã xóa bản ghi phiếu nhập **#$entryId** thành công.";
                    break;

                case 'edit':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đang mở chế độ chỉnh sửa cho phiếu **#$entryId**.";
                    break;

                case 'view':
                    $entryId = $_POST['entry_id'] ?? '';
                    $status = 'success';
                    $message = "Đang tải chi tiết phiếu nhập **#$entryId**...";
                    break;
            }
        }

        $this->view('admin/inventory', [
            'title' => 'Quản lý kho',
            'currentPage' => 'inventory',
            'status' => $status,
            'message' => $message
        ]);
    }

    public function reviews()
    {
        $this->view('admin/reviews', [
            'title' => 'Quản lý đánh giá',
            'currentPage' => 'reviews'
        ]);
    }

    public function blog()
    {
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_post':
                    $title = $_POST['title'] ?? '';
                    $postStatus = $_POST['status'] ?? 'draft';
                    $status = 'success';
                    $message = "Thành công! Bài viết **$title** đã được lưu dưới dạng **$postStatus**.";
                    break;

                case 'delete':
                    $id = $_POST['post_id'] ?? '';
                    $status = 'success';
                    $message = "Đã xóa bài viết ID: #$id thành công!";
                    break;

                case 'edit':
                    $id = $_POST['post_id'] ?? '';
                    $status = 'success';
                    $message = "Đang chuyển hướng đến trình chỉnh sửa cho bài viết #$id...";
                    break;
            }
        }

        $this->view('admin/blog', [
            'title' => 'Quản lý Blog',
            'currentPage' => 'blog',
            'status' => $status,
            'message' => $message
        ]);
    }
}