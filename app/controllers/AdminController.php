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

    /* =========================================================
       DASHBOARD — Phúc
       ========================================================= */

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

    /* =========================================================
       PRODUCTS + CATEGORIES — Ái Linh
       ========================================================= */

    public function products()
    {
        $id = trim($_GET['id'] ?? '');
        $url = $_GET['url'] ?? 'admin/products';

        $status = null;
        $message = '';

        if ($url === 'admin/products/delete' && $id !== '') {
            $this->adminModel->deleteProduct($id);
            header('Location: index.php?url=admin/products');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $url === 'admin/products/edit' && $id !== '') {
            $product = $this->adminModel->getProductById($id);

            if (!$product) {
                header('Location: index.php?url=admin/products&status=error&message=' . urlencode('Không tìm thấy sản phẩm.'));
                exit;
            }

            $canShow = $this->adminModel->productCanBeVisible($id);

            $this->view('admin/products_form', [
                'title' => 'Chỉnh sửa sản phẩm',
                'currentPage' => 'products',
                'product' => $product,
                'categories' => $this->adminModel->getCategoriesList(),
                'brands' => $this->adminModel->getBrands(),
                'materials' => $this->adminModel->getMaterials(),
                'isEdit' => true,
                'canShow' => $canShow,
                'status' => $_GET['status'] ?? null,
                'message' => $_GET['message'] ?? ''
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_product':
                    $productId = $this->adminModel->generateProductId();

                    $productData = [
                        'MaSanPham' => $productId,
                        'TenSanPham' => trim($_POST['TenSanPham'] ?? ''),
                        'MaDanhMuc' => trim($_POST['MaDanhMuc'] ?? ''),
                        'MaThuongHieu' => trim($_POST['MaThuongHieu'] ?? ''),
                        'MaVatLieu' => trim($_POST['MaVatLieu'] ?? ''),
                        'MoTa' => trim($_POST['MoTa'] ?? ''),
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int)$_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => 0
                    ];

                    if ($productData['TenSanPham'] === '' || $productData['MaDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'Tên sản phẩm và danh mục là bắt buộc.';
                    } elseif ($this->adminModel->createProduct($productData)) {
                        if (!empty($_FILES['product_image']['name'])) {
                            $uploadResult = $this->handleProductImageUpload($productId, $_FILES['product_image']);

                            if ($uploadResult !== true) {
                                header('Location: index.php?url=admin/products/edit&id=' . urlencode($productId) . '&status=error&message=' . urlencode($uploadResult));
                                exit;
                            }
                        }

                        header('Location: index.php?url=admin/products/edit&id=' . urlencode($productId) . '&created=1');
                        exit;
                    } else {
                        $status = 'error';
                        $message = 'Tạo sản phẩm thất bại, vui lòng thử lại.';
                    }
                    break;

                case 'update_product':
                    $productId = trim($_POST['MaSanPham'] ?? '');

                    $productData = [
                        'TenSanPham' => trim($_POST['TenSanPham'] ?? ''),
                        'MaDanhMuc' => trim($_POST['MaDanhMuc'] ?? ''),
                        'MaThuongHieu' => trim($_POST['MaThuongHieu'] ?? ''),
                        'MaVatLieu' => trim($_POST['MaVatLieu'] ?? ''),
                        'MoTa' => trim($_POST['MoTa'] ?? ''),
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int)$_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => isset($_POST['TrangThai']) && $_POST['TrangThai'] === '1' ? 1 : 0
                    ];

                    if ($productId === '' || $productData['TenSanPham'] === '' || $productData['MaDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'ID, tên sản phẩm và danh mục là bắt buộc.';
                    } elseif ((int)$productData['TrangThai'] === 1 && !$this->adminModel->productCanBeVisible($productId)) {
                        $status = 'error';
                        $message = 'Sản phẩm chưa đủ điều kiện hiển thị: cần ít nhất 1 biến thể có giá, tồn kho và 1 ảnh.';
                    } elseif ($this->adminModel->updateProduct($productId, $productData)) {
                        if (!empty($_FILES['product_image']['name'])) {
                            $uploadResult = $this->handleProductImageUpload($productId, $_FILES['product_image']);

                            if ($uploadResult !== true) {
                                $status = 'error';
                                $message = $uploadResult;
                                break;
                            }
                        }

                        $status = 'success';
                        $message = 'Cập nhật sản phẩm thành công.';
                    } else {
                        $status = 'error';
                        $message = 'Cập nhật sản phẩm thất bại, vui lòng thử lại.';
                    }
                    break;
            }
        }

        if ($url === 'admin/products/create') {
            $this->view('admin/products_form', [
                'title' => 'Thêm sản phẩm mới',
                'currentPage' => 'products',
                'categories' => $this->adminModel->getCategoriesList(),
                'brands' => $this->adminModel->getBrands(),
                'materials' => $this->adminModel->getMaterials(),
                'isEdit' => false,
                'status' => $status,
                'message' => $message
            ]);
            return;
        }

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'category' => trim($_GET['category'] ?? ''),
            'brand' => trim($_GET['brand'] ?? '')
        ];

        $perPage = 10;
        $currentPageNumber = max(1, (int)($_GET['page'] ?? 1));

        $totalProducts = $this->adminModel->countProductsList($filters);
        $totalPages = max(1, (int)ceil($totalProducts / $perPage));

        if ($currentPageNumber > $totalPages) {
            $currentPageNumber = $totalPages;
        }

        $offset = ($currentPageNumber - 1) * $perPage;

        $products = $this->adminModel->getProductsList($filters, $perPage, $offset);

        $this->view('admin/products', [
            'title' => 'Quản lý sản phẩm',
            'currentPage' => 'products',
            'products' => $products,
            'categories' => $this->adminModel->getCategoriesList(),
            'brands' => $this->adminModel->getBrands(),
            'status' => $status ?? ($_GET['status'] ?? null),
            'message' => $message ?: ($_GET['message'] ?? ''),
            'keyword' => $filters['keyword'],
            'category' => $filters['category'],
            'brand' => $filters['brand'],
            'pagination' => [
                'currentPage' => $currentPageNumber,
                'totalPages' => $totalPages,
                'perPage' => $perPage,
                'totalItems' => $totalProducts
            ]
        ]);
    }

    public function categories()
    {
        $url = $_GET['url'] ?? 'admin/categories';
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_category':
                    $categoryData = [
                        'MaDanhMuc' => $this->adminModel->generateCategoryId(),
                        'TenDanhMuc' => trim($_POST['TenDanhMuc'] ?? ''),
                        'HinhAnh' => trim($_POST['HinhAnh'] ?? ''),
                        'TrangThai' => 1
                    ];

                    if ($categoryData['TenDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'Tên danh mục không được để trống.';
                    } elseif ($this->adminModel->createCategory($categoryData)) {
                        header('Location: index.php?url=admin/categories&status=success&message=' . urlencode('Tạo danh mục thành công.'));
                        exit;
                    } else {
                        $status = 'error';
                        $message = 'Tạo danh mục thất bại, vui lòng thử lại.';
                    }
                    break;

                case 'update_category':
                    $categoryId = trim($_POST['MaDanhMuc'] ?? '');
                    $categoryData = [
                        'TenDanhMuc' => trim($_POST['TenDanhMuc'] ?? ''),
                        'HinhAnh' => trim($_POST['HinhAnh'] ?? ''),
                        'TrangThai' => isset($_POST['TrangThai']) && $_POST['TrangThai'] === '1' ? 1 : 0
                    ];

                    if ($categoryId === '' || $categoryData['TenDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'ID và tên danh mục là bắt buộc.';
                    } elseif ($this->adminModel->updateCategory($categoryId, $categoryData)) {
                        $status = 'success';
                        $message = 'Cập nhật danh mục thành công.';
                    } else {
                        $status = 'error';
                        $message = 'Cập nhật danh mục thất bại, vui lòng thử lại.';
                    }
                    break;
            }
        }

        if ($url === 'admin/categories/delete') {
            $categoryId = trim($_GET['id'] ?? '');
            if ($categoryId !== '') {
                $hasProducts = $this->adminModel->categoryHasProducts($categoryId);
                $this->adminModel->softDeleteCategory($categoryId);

                $message = $hasProducts
                    ? 'Danh mục có sản phẩm → đã chuyển sang trạng thái ẩn, không xóa cứng.'
                    : 'Đã ẩn danh mục thành công.';

                header('Location: index.php?url=admin/categories&status=success&message=' . urlencode($message));
                exit;
            }
        }

        if ($url === 'admin/categories/create') {
            $this->view('admin/categories_form', [
                'title' => 'Thêm danh mục mới',
                'currentPage' => 'categories',
                'isEdit' => false,
                'status' => $status,
                'message' => $message
            ]);
            return;
        }

        if ($url === 'admin/categories/edit') {
            $categoryId = trim($_GET['id'] ?? '');
            $category = $this->adminModel->getCategoryById($categoryId);

            if (!$category) {
                header('Location: index.php?url=admin/categories');
                exit;
            }

            $this->view('admin/categories_form', [
                'title' => 'Chỉnh sửa danh mục',
                'currentPage' => 'categories',
                'category' => $category,
                'isEdit' => true,
                'status' => $status,
                'message' => $message
            ]);
            return;
        }

        $this->view('admin/categories', [
            'title' => 'Quản lý danh mục',
            'currentPage' => 'categories',
            'categories' => $this->adminModel->getCategoriesList(),
            'status' => $status ?? ($_GET['status'] ?? null),
            'message' => $message ?: ($_GET['message'] ?? '')
        ]);
    }

    /* =========================================================
       VARIANTS + GALLERY + INVENTORY + REVIEWS — Yến Linh
       ========================================================= */

    public function variants()
    {
        $maSanPham = trim($_GET['id'] ?? '');
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add_variant':
                    $result = $this->adminModel->addVariant(
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
                    $result = $this->adminModel->updateVariant(
                        $maBienThe,
                        trim($_POST['mau_sac'] ?? ''),
                        trim($_POST['kich_thuoc'] ?? ''),
                        (float)($_POST['gia_tien'] ?? 0),
                        (int)($_POST['so_luong_ton'] ?? 0)
                    );
                    $status = $result ? 'success' : 'error';
                    $message = $result ? 'Đã cập nhật biến thể.' : 'Cập nhật biến thể thất bại.';
                    break;

                case 'delete_variant':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    if ($this->adminModel->variantHasOrders($maBienThe)) {
                        $this->adminModel->updateStock($maBienThe, 0);
                        $status = 'warning';
                        $message = 'Biến thể đã có trong đơn hàng. Đã đặt tồn kho = 0 thay vì xóa cứng.';
                    } elseif ($this->adminModel->deleteVariant($maBienThe)) {
                        $status = 'success';
                        $message = 'Đã xóa biến thể thành công.';
                    } else {
                        $status = 'error';
                        $message = 'Xóa biến thể thất bại.';
                    }
                    break;
            }
        }

        $this->view('admin/variants', [
            'title' => 'Quản lý biến thể',
            'currentPage' => 'products',
            'status' => $status,
            'message' => $message,
            'variants' => $maSanPham ? $this->adminModel->getVariantsByProduct($maSanPham) : [],
            'ma_san_pham' => $maSanPham
        ]);
    }


    public function gallery()
    {
        $maSanPham = trim($_GET['id'] ?? '');
        $status = $_GET['status'] ?? null;
        $message = $_GET['message'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'upload_image') {
                if ($maSanPham === '') {
                    $status = 'error';
                    $message = 'Thiếu mã sản phẩm.';
                } elseif (!empty($_FILES['image']['name'])) {
                    $uploaded = $this->adminModel->uploadGalleryImage($maSanPham, $_FILES['image']);
                    $status = $uploaded ? 'success' : 'error';
                    $message = $uploaded
                        ? 'Đã tải ảnh lên thành công.'
                        : 'Tải ảnh thất bại. Vui lòng kiểm tra định dạng JPG, PNG, WEBP.';
                } else {
                    $status = 'error';
                    $message = 'Vui lòng chọn file ảnh.';
                }
            } elseif ($action === 'delete_image') {
                $maAnh = trim($_POST['ma_anh'] ?? '');
                if ($maAnh === '') {
                    $status = 'error';
                    $message = 'Thiếu mã ảnh.';
                } else {
                    $deleted = $this->adminModel->deleteGalleryImage($maAnh);
                    $status = $deleted ? 'success' : 'error';
                    $message = $deleted ? 'Đã xóa ảnh.' : 'Xóa ảnh thất bại.';
                }
            }

            header(
                'Location: index.php?url=admin/products/gallery&id=' . urlencode($maSanPham)
                    . '&status=' . urlencode((string)$status)
                    . '&message=' . urlencode($message)
            );
            exit;
        }

        $this->view('admin/gallery', [
            'title' => 'Quản lý ảnh sản phẩm',
            'currentPage' => 'products',
            'status' => $status,
            'message' => $message,
            'gallery' => $maSanPham ? $this->adminModel->getGallery($maSanPham) : [],
            'ma_san_pham' => $maSanPham
        ]);
    }

    public function inventory()
    {
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'update_stock':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    $soLuong = (int)($_POST['so_luong_ton'] ?? -1);

                    if ($maBienThe === '' || $soLuong < 0) {
                        $status = 'error';
                        $message = 'Dữ liệu không hợp lệ.';
                    } elseif ($this->adminModel->updateStock($maBienThe, $soLuong)) {
                        $status = 'success';
                        $message = "Đã cập nhật tồn kho biến thể $maBienThe thành $soLuong.";
                    } else {
                        $status = 'error';
                        $message = 'Cập nhật tồn kho thất bại.';
                    }
                    break;

                case 'delete_variant':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    if ($maBienThe === '') {
                        $status = 'error';
                        $message = 'Thiếu mã biến thể.';
                    } elseif ($this->adminModel->variantHasOrders($maBienThe)) {
                        $this->adminModel->updateStock($maBienThe, 0);
                        $status = 'warning';
                        $message = "Biến thể $maBienThe đã có trong đơn hàng. Đã đặt tồn kho = 0 thay vì xóa.";
                    } elseif ($this->adminModel->deleteVariant($maBienThe)) {
                        $status = 'success';
                        $message = "Đã xóa biến thể $maBienThe.";
                    } else {
                        $status = 'error';
                        $message = 'Xóa biến thể thất bại.';
                    }
                    break;

                case 'add_supplier':
                    $tenNCC = trim($_POST['supplier_name'] ?? '');
                    $soDienThoai = trim($_POST['tax_id'] ?? '');
                    $diaChi = trim($_POST['location'] ?? '');

                    if ($tenNCC === '') {
                        $status = 'error';
                        $message = 'Vui lòng nhập tên nhà cung cấp.';
                    } elseif ($this->adminModel->addSupplier($tenNCC, $soDienThoai, $diaChi)) {
                        $status = 'success';
                        $message = "Đã đăng ký nhà cung cấp: $tenNCC";
                    } else {
                        $status = 'error';
                        $message = 'Thêm nhà cung cấp thất bại hoặc thiếu bảng nhacungcap.';
                    }
                    break;
            }
        }

        $keyword = trim($_GET['keyword'] ?? '');

        $this->view('admin/inventory', [
            'title' => 'Quản lý kho',
            'currentPage' => 'inventory',
            'status' => $status,
            'message' => $message,
            'inventory' => $this->adminModel->getInventory($keyword),
            'suppliers' => $this->adminModel->getSuppliers(),
            'entries' => $this->adminModel->getImportReceipts(),
            'keyword' => $keyword
        ]);
    }

    public function reviews()
    {
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $maDanhGia = trim($_POST['ma_danh_gia'] ?? '');

            if ($maDanhGia === '') {
                $status = 'error';
                $message = 'Thiếu mã đánh giá.';
            } else {
                switch ($action) {
                    case 'approve':
                        $status = $this->adminModel->approveReview($maDanhGia) ? 'success' : 'error';
                        $message = $status === 'success' ? "Đã duyệt đánh giá #$maDanhGia." : 'Duyệt đánh giá thất bại.';
                        break;

                    case 'hide':
                        $status = $this->adminModel->hideReview($maDanhGia) ? 'success' : 'error';
                        $message = $status === 'success' ? "Đã ẩn đánh giá #$maDanhGia." : 'Ẩn đánh giá thất bại.';
                        break;

                    case 'delete':
                        $status = $this->adminModel->deleteReview($maDanhGia) ? 'success' : 'error';
                        $message = $status === 'success' ? "Đã xóa đánh giá #$maDanhGia." : 'Xóa đánh giá thất bại.';
                        break;

                    case 'reply':
                        $reply = trim($_POST['reply_content'] ?? '');
                        if ($reply === '') {
                            $status = 'error';
                            $message = 'Nội dung phản hồi không được để trống.';
                        } else {
                            $status = $this->adminModel->saveAdminReply($maDanhGia, $reply) ? 'success' : 'error';
                            $message = $status === 'success'
                                ? "Đã lưu phản hồi cho đánh giá #$maDanhGia."
                                : 'Lưu phản hồi thất bại hoặc thiếu cột PhanHoiAdmin.';
                        }
                        break;
                }
            }
        }

        $keyword = trim($_GET['keyword'] ?? '');
        $tab = $_GET['tab'] ?? 'all';

        $this->view('admin/reviews', [
            'title' => 'Quản lý đánh giá',
            'currentPage' => 'reviews',
            'status' => $status,
            'message' => $message,
            'reviews' => $this->adminModel->getReviews($keyword, $tab),
            'keyword' => $keyword,
            'tab' => $tab
        ]);
    }

    /* =========================================================
       USERS — Ngọc Lan
       ========================================================= */

    public function users()
    {
        $userModel = $this->model('UserModel');
        $search = $_GET['search'] ?? '';

        $users = method_exists($userModel, 'getAllUsers') ? $userModel->getAllUsers($search) : [];
        $roles = method_exists($userModel, 'getAllRoles') ? $userModel->getAllRoles() : [];

        $this->view('admin/users/index', [
            'title' => 'Quản lý người dùng',
            'currentPage' => 'users',
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

            if (method_exists($userModel, 'updateRole') && $userModel->updateRole($userId, $roleId)) {
                $_SESSION['success'] = 'Cập nhật quyền thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật quyền thất bại!';
            }
        }

        header('Location: index.php?url=admin/users');
        exit;
    }

    public function userDetail()
    {
        $id = $_GET['id'] ?? '';
        $userModel = $this->model('UserModel');
        $user = method_exists($userModel, 'getUserInfo') ? $userModel->getUserInfo($id) : null;

        $this->view('admin/users/detail', [
            'title' => 'Chi tiết người dùng',
            'currentPage' => 'users',
            'user' => $user
        ]);
    }

    /* =========================================================
       ORDERS — Phúc
       ========================================================= */

    public function orders()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $filterStatus = trim($_GET['status'] ?? '');
        $status = $_GET['notice_status'] ?? null;
        $message = $_GET['message'] ?? '';

        $this->view('admin/orders', [
            'title' => 'Quản lý đơn hàng',
            'currentPage' => 'orders',
            'orders' => $this->adminModel->getAllOrders($keyword, $filterStatus),
            'stats' => $this->adminModel->getDashboardStats(),
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

        $this->view('admin/order_detail', [
            'title' => 'Chi tiết đơn hàng',
            'currentPage' => 'orders',
            'order' => $order,
            'items' => $this->adminModel->getOrderItems($orderId),
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
            header('Location: index.php?url=admin/orders/detail&id=' . urlencode($orderId) . '&notice_status=' . urlencode($noticeStatus) . '&message=' . urlencode($message));
            exit;
        }

        header('Location: index.php?url=admin/orders&notice_status=' . urlencode($noticeStatus) . '&message=' . urlencode($message));
        exit;
    }

    /* =========================================================
       BLOG + PROMO — Long
       ========================================================= */

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
            $ok = $this->adminModel->deletePost($idFromUrl);
            header('Location: index.php?url=admin/blog&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã xóa bài viết thành công!' : 'Xóa bài viết thất bại!'));
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
                        $ok = $this->adminModel->createPost($data);
                        header('Location: index.php?url=admin/blog&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã thêm bài viết thành công!' : 'Thêm bài viết thất bại!'));
                        exit;
                    }

                    if ($action === 'update_post') {
                        if ($postId === '') {
                            $status = 'error';
                            $message = 'Không tìm thấy ID bài viết cần sửa!';
                        } else {
                            $ok = $this->adminModel->updatePost($postId, $data);
                            header('Location: index.php?url=admin/blog&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã cập nhật bài viết thành công!' : 'Cập nhật bài viết thất bại!'));
                            exit;
                        }
                    }
                }
            }
        }

        if (isset($_GET['status'], $_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
        }

        $this->view('admin/blog', [
            'title' => 'Quản lý Blog',
            'currentPage' => 'blog',
            'status' => $status,
            'message' => $message,
            'posts' => $this->adminModel->getAllPosts(),
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
            $ok = $this->adminModel->deletePromo($idFromUrl);
            header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã xóa mã giảm giá thành công!' : 'Xóa mã giảm giá thất bại!'));
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
                    $ok = $this->adminModel->createPromo($data);
                    header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã tạo mã giảm giá thành công!' : 'Tạo mã giảm giá thất bại!'));
                    exit;
                }

                if ($action === 'update_promo') {
                    if ($promoId === '') {
                        $status = 'error';
                        $message = 'Không tìm thấy ID mã giảm giá cần sửa!';
                    } else {
                        $ok = $this->adminModel->updatePromo($promoId, $data);
                        header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã cập nhật mã giảm giá thành công!' : 'Cập nhật mã giảm giá thất bại!'));
                        exit;
                    }
                }
            }
        }

        if (isset($_GET['status'], $_GET['message'])) {
            $status = $_GET['status'];
            $message = $_GET['message'];
        }

        $this->view('admin/promo', [
            'title' => 'Quản lý mã giảm giá',
            'currentPage' => 'promo',
            'status' => $status,
            'message' => $message,
            'promos' => $this->adminModel->getAllPromos(),
            'editingPromo' => $editingPromo
        ]);
    }

    /* =========================================================
       PRIVATE HELPERS
       ========================================================= */

    private function handleProductImageUpload(string $productId, array $file)
    {
        if (empty($file['name'])) {
            return true;
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExt, true)) {
            return 'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.';
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return 'Lỗi khi tải ảnh lên. Vui lòng thử lại.';
        }

        $destinationDir = ROOT_PATH . '/public/assets/images/products/';
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $safeName = $productId . '_' . time() . '.' . $extension;
        $targetPath = $destinationDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'Không thể lưu ảnh sản phẩm.';
        }

        $this->adminModel->addProductImage($productId, $safeName);
        return true;
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

        if ($expiredDate < date('Y-m-d')) {
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
        $extension = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            return false;
        }

        $uploadDir = ROOT_PATH . '/public/assets/images/blog/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $destination)) {
            return false;
        }

        return 'public/assets/images/blog/' . $fileName;
    }
}
