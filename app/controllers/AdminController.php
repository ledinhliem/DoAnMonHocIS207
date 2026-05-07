<?php

class AdminController extends Controller
{
    public function __construct()
    {
        $this->checkAdminAccess();
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

    // Kiểm tra các hành động POST từ Bảng điều khiển
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'create_discount':
                $code = $_POST['code'] ?? '';
                $percent = $_POST['percent'] ?? '';
                // Validate đơn giản
                if (!empty($code) && $percent > 0) {
                    $status = 'success';
                    $message = "Đã kích hoạt mã **$code** giảm **$percent%** toàn hệ thống!";
                } else {
                    $status = 'error';
                    $message = "Vui lòng nhập đầy đủ thông tin mã giảm giá!";
                }
                break;

            case 'delete':
                $id = $_POST['promo_id'] ?? '';
                $status = 'success';
                $message = "Đã gỡ bỏ khuyến mãi: **$id**";
                break;

            case 'export_report':
                $status = 'success';
                $message = "Báo cáo Eco-Impact đã được gửi về email của bạn (Alex River).";
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
        $this->view('admin/products', ['title' => 'Quản lý sản phẩm']);
    }

    public function orders()
    {
        $this->view('admin/orders', ['title' => 'Quản lý đơn hàng']);
    }

    /**
     * QUẢN LÝ KHO (INVENTORY)
     * Đã thêm logic xử lý Form và phản hồi
     */
    public function inventory()
    {
        $status = null;
        $message = '';

        // Kiểm tra xem có dữ liệu gửi lên (POST) hay không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add_supplier':
                    // Lấy dữ liệu từ các input "name" 
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

        // Gửi các biến status và message sang view để hiển thị thông báo
        $this->view('admin/inventory', [
            'title' => 'Quản lý kho',
            'status' => $status,
            'message' => $message
        ]);
    }

    public function reviews()
    {
        $this->view('admin/reviews', ['title' => 'Quản lý đánh giá']);
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
                // Logic lưu bài viết của Long sẽ ở đây
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
        'status' => $status,
        'message' => $message
    ]);
    }

    // Thêm vào trong class AdminController
    public function users()
    {
        $userModel = $this->model('UserModel');
        $search = $_GET['search'] ?? '';
        
        $users = $userModel->getAllUsers($search);
        $roles = $userModel->getAllRoles();

        $this->view('admin/users/index', [
            'title' => 'Quản lý người dùng',
            'users' => $users,
            'roles' => $roles,
            'search' => $search
        ]);
    }

    public function updateUserRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'] ?? '';
            $roleId = $_POST['roleId'] ?? '';
            
            $userModel = $this->model('UserModel');
            if ($userModel->updateRole($userId, $roleId)) {
                $_SESSION['success'] = "Cập nhật quyền thành công!";
            }
            header('Location: index.php?url=admin/users');
            exit;
        }
    }

    public function userDetail()
    {
        $id = $_GET['id'] ?? '';
        $userModel = $this->model('UserModel');
        $user = $userModel->getUserInfo($id); 

        $this->view('admin/users/detail', [
            'title' => 'Chi tiết người dùng',
            'user' => $user
        ]);
    }
}
