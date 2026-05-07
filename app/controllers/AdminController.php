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

    // --------------------------------------------------------
    // DASHBOARD
    // --------------------------------------------------------

    public function dashboard()
    {
        $status  = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_discount':
                    $code    = $_POST['code'] ?? '';
                    $percent = $_POST['percent'] ?? '';
                    if (!empty($code) && $percent > 0) {
                        $status  = 'success';
                        $message = "Đã kích hoạt mã **$code** giảm **$percent%** toàn hệ thống!";
                    } else {
                        $status  = 'error';
                        $message = "Vui lòng nhập đầy đủ thông tin mã giảm giá!";
                    }
                    break;

                case 'delete':
                    $id      = $_POST['promo_id'] ?? '';
                    $status  = 'success';
                    $message = "Đã gỡ bỏ khuyến mãi: **$id**";
                    break;

                case 'export_report':
                    $status  = 'success';
                    $message = "Báo cáo Eco-Impact đã được gửi về email của bạn.";
                    break;
            }
        }

        $this->view('admin/dashboard', [
            'title'   => 'Admin Bảng điều khiển',
            'status'  => $status,
            'message' => $message,
        ]);
    }

    // --------------------------------------------------------
    // PRODUCTS
    // --------------------------------------------------------

    public function products()
    {
        $this->view('admin/products', ['title' => 'Quản lý sản phẩm']);
    }

    // --------------------------------------------------------
    // ORDERS
    // --------------------------------------------------------

    public function orders()
    {
        $this->view('admin/orders', ['title' => 'Quản lý đơn hàng']);
    }

    // --------------------------------------------------------
    // INVENTORY
    // --------------------------------------------------------

    public function inventory()
    {
        require_once __DIR__ . '/../models/AdminModel.php';
        $model = new AdminModel();

        $status  = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {

                // Cập nhật SoLuongTon biến thể
                case 'update_stock':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    $soLuong   = (int)($_POST['so_luong_ton'] ?? -1);

                    if ($maBienThe === '' || $soLuong < 0) {
                        $status  = 'error';
                        $message = "Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.";
                    } elseif ($model->updateStock($maBienThe, $soLuong)) {
                        $status  = 'success';
                        $message = "Đã cập nhật tồn kho biến thể **$maBienThe** thành **$soLuong** sản phẩm.";
                    } else {
                        $status  = 'error';
                        $message = "Cập nhật thất bại. Vui lòng thử lại.";
                    }
                    break;

                // Xóa biến thể — kiểm tra ràng buộc đơn hàng trước
                case 'delete_variant':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    if ($maBienThe === '') {
                        $status  = 'error';
                        $message = "Thiếu mã biến thể.";
                    } elseif ($model->variantHasOrders($maBienThe)) {
                        // Đã từng bán → chỉ đặt SoLuongTon = 0, không xóa cứng
                        $model->updateStock($maBienThe, 0);
                        $status  = 'warning';
                        $message = "Biến thể **$maBienThe** đã có trong đơn hàng. Đã đặt tồn kho = 0 thay vì xóa để bảo toàn lịch sử.";
                    } elseif ($model->deleteVariant($maBienThe)) {
                        $status  = 'success';
                        $message = "Đã xóa biến thể **$maBienThe** thành công.";
                    } else {
                        $status  = 'error';
                        $message = "Xóa thất bại. Vui lòng thử lại.";
                    }
                    break;

                // Thêm nhà cung cấp mới
                case 'add_supplier':
                    $tenNCC      = trim($_POST['supplier_name'] ?? '');
                    $soDienThoai = trim($_POST['tax_id'] ?? '');   // dùng field tax_id làm SĐT tạm
                    $diaChi      = trim($_POST['location'] ?? '');

                    if ($tenNCC === '') {
                        $status  = 'error';
                        $message = "Vui lòng nhập tên nhà cung cấp.";
                    } elseif ($model->addSupplier($tenNCC, $soDienThoai, $diaChi)) {
                        $status  = 'success';
                        $message = "Đã đăng ký thành công nhà cung cấp: **$tenNCC**";
                    } else {
                        $status  = 'error';
                        $message = "Thêm nhà cung cấp thất bại. Vui lòng thử lại.";
                    }
                    break;
            }
        }

        $keyword   = trim($_GET['keyword'] ?? '');
        $inventory = $model->getInventory($keyword);
        $suppliers = $model->getSuppliers();
        $receipts  = $model->getImportReceipts();

        $this->view('admin/inventory', [
            'title'     => 'Quản lý kho',
            'status'    => $status,
            'message'   => $message,
            'inventory' => $inventory,   // bienthesanpham + TenSanPham
            'suppliers' => $suppliers,   // nhacungcap
            'entries'   => $receipts,    // phieunhap + TenNCC
        ]);
    }

    // --------------------------------------------------------
    // REVIEWS 
    // --------------------------------------------------------

    public function reviews()
    {
        require_once __DIR__ . '/../models/AdminModel.php';
        $model = new AdminModel();

        $status  = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action    = $_POST['action'] ?? '';
            $maDanhGia = trim($_POST['ma_danh_gia'] ?? '');

            if ($maDanhGia === '') {
                $status  = 'error';
                $message = "Thiếu mã đánh giá.";
            } else {
                switch ($action) {

                    case 'approve':
                        if ($model->approveReview($maDanhGia)) {
                            $status  = 'success';
                            $message = "Đã duyệt đánh giá **#$maDanhGia**.";
                        } else {
                            $status  = 'error';
                            $message = "Duyệt thất bại. Vui lòng thử lại.";
                        }
                        break;

                    case 'hide':
                        if ($model->hideReview($maDanhGia)) {
                            $status  = 'success';
                            $message = "Đã ẩn đánh giá **#$maDanhGia**.";
                        } else {
                            $status  = 'error';
                            $message = "Ẩn thất bại. Vui lòng thử lại.";
                        }
                        break;

                    case 'delete':
                        if ($model->deleteReview($maDanhGia)) {
                            $status  = 'success';
                            $message = "Đã xóa đánh giá **#$maDanhGia**.";
                        } else {
                            $status  = 'error';
                            $message = "Xóa thất bại. Vui lòng thử lại.";
                        }
                        break;

                    case 'reply':
                        $reply = trim($_POST['reply_content'] ?? '');
                        if ($reply === '') {
                            $status  = 'error';
                            $message = "Nội dung phản hồi không được để trống.";
                        } elseif ($model->saveAdminReply($maDanhGia, $reply)) {
                            $status  = 'success';
                            $message = "Đã lưu phản hồi cho đánh giá **#$maDanhGia**.";
                        } else {
                            $status  = 'error';
                            $message = "Lưu phản hồi thất bại. Vui lòng thử lại.";
                        }
                        break;
                }
            }
        }

        $keyword = trim($_GET['keyword'] ?? '');
        $tab     = $_GET['tab'] ?? 'all';
        $reviews = $model->getReviews($keyword, $tab);

        $this->view('admin/reviews', [
            'title'   => 'Quản lý đánh giá',
            'status'  => $status,
            'message' => $message,
            'reviews' => $reviews,
        ]);
    }

    // --------------------------------------------------------
    // VARIANTS
    // --------------------------------------------------------

    public function variants()
{
    require_once __DIR__ . '/../models/AdminModel.php';
    $model = new AdminModel();

    $maSanPham = trim($_GET['id'] ?? '');
    $status = null; $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'add_variant':
                $result = $model->addVariant(
                    $maSanPham,
                    trim($_POST['mau_sac'] ?? ''),
                    trim($_POST['kich_thuoc'] ?? ''),
                    (float)($_POST['gia_tien'] ?? 0),
                    (int)($_POST['so_luong_ton'] ?? 0)
                );
                $status = $result ? 'success' : 'error';
                $message = $result ? 'Đã thêm biến thể thành công.' : 'Thêm biến thể thất bại.';
                break;

            case 'update_variant':
                $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                $result = $model->updateVariant(
                    $maBienThe,
                    trim($_POST['mau_sac'] ?? ''),
                    trim($_POST['kich_thuoc'] ?? ''),
                    (float)($_POST['gia_tien'] ?? 0),
                    (int)($_POST['so_luong_ton'] ?? 0)
                );
                $status = $result ? 'success' : 'error';
                $message = $result ? "Đã cập nhật biến thể." : "Cập nhật thất bại.";
                break;

            // delete_variant đã xử lý trong inventory(), dùng chung logic
            case 'delete_variant':
                $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                if ($model->variantHasOrders($maBienThe)) {
                    $model->updateStock($maBienThe, 0);
                    $status = 'warning';
                    $message = "Biến thể đã có trong đơn hàng. Đã đặt tồn kho = 0.";
                } elseif ($model->deleteVariant($maBienThe)) {
                    $status = 'success';
                    $message = "Đã xóa biến thể thành công.";
                } else {
                    $status = 'error';
                    $message = "Xóa thất bại.";
                }
                break;
        }
    }

    $variants = $maSanPham ? $model->getVariantsByProduct($maSanPham) : [];

    $this->view('admin/variants', [
        'title'      => 'Quản lý biến thể',
        'status'     => $status,
        'message'    => $message,
        'variants'   => $variants,
        'ma_san_pham' => $maSanPham,
    ]);
    }

    // --------------------------------------------------------
    // GALLERY
    // --------------------------------------------------------
    public function gallery()
{
    require_once __DIR__ . '/../models/AdminModel.php';
    $model = new AdminModel();

    $maSanPham = trim($_GET['id'] ?? '');
    $status = null; $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'upload_image') {
            if (!empty($_FILES['image']['tmp_name'])) {
                $result = $model->uploadGalleryImage($maSanPham, $_FILES['image']);
                $status = $result ? 'success' : 'error';
                $message = $result ? 'Đã tải ảnh lên thành công.' : 'Tải ảnh thất bại.';
            } else {
                $status = 'error';
                $message = 'Vui lòng chọn file ảnh.';
            }
        } elseif ($action === 'delete_image') {
            $maAnh = trim($_POST['ma_anh'] ?? '');
            $result = $model->deleteGalleryImage($maAnh);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Đã xóa ảnh.' : 'Xóa ảnh thất bại.';
        }
    }

    $gallery = $maSanPham ? $model->getGallery($maSanPham) : [];

    $this->view('admin/gallery', [
        'title'      => 'Quản lý ảnh sản phẩm',
        'status'     => $status,
        'message'    => $message,
        'gallery'    => $gallery,
        'ma_san_pham' => $maSanPham,
    ]);
}

    // --------------------------------------------------------
    // BLOG
    // --------------------------------------------------------

    public function blog()
    {
        $status  = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_post':
                    $title      = $_POST['title'] ?? '';
                    $postStatus = $_POST['status'] ?? 'draft';
                    $status     = 'success';
                    $message    = "Thành công! Bài viết **$title** đã được lưu dưới dạng **$postStatus**.";
                    break;

                case 'delete':
                    $id      = $_POST['post_id'] ?? '';
                    $status  = 'success';
                    $message = "Đã xóa bài viết ID: #$id thành công!";
                    break;

                case 'edit':
                    $id      = $_POST['post_id'] ?? '';
                    $status  = 'success';
                    $message = "Đang chuyển hướng đến trình chỉnh sửa cho bài viết #$id...";
                    break;
            }
        }

        $this->view('admin/blog', [
            'title'   => 'Quản lý Blog',
            'status'  => $status,
            'message' => $message,
        ]);
    }
}