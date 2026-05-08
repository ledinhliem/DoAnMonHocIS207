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

        if ((string) $role !== '1') {
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
                    $percent = trim($_POST['percent'] ?? '');

                    if ($code !== '' && is_numeric($percent) && $percent > 0) {
                        $status = 'success';
                        $message = "Đã kích hoạt mã **$code** giảm **$percent%** toàn hệ thống!";
                    } else {
                        $status = 'error';
                        $message = "Vui lòng nhập đầy đủ thông tin mã giảm giá!";
                    }
                    break;

                case 'delete':
                    $id = trim($_POST['promo_id'] ?? '');
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
            'message' => $message,
            'currentPage' => 'dashboard'
        ]);
    }

    public function products()
    {
        $id = $_GET['id'] ?? '';
        $adminModel = $this->model('AdminModel');
        $url = $_GET['url'] ?? 'admin/products';

        $status = null;
        $message = '';

        // DELETE
        if ($url === 'admin/products/delete' && $id) {
            $adminModel->deleteProduct($id);
            header('Location: index.php?url=admin/products');
            exit;
        }

        // EDIT
        if ($url === 'admin/products/edit' && $id) {
            $product = $adminModel->getProductById($id);
            $canShow = $adminModel->productCanBeVisible($id);

            $this->view('admin/products_form', [
                'title' => 'Chỉnh sửa sản phẩm',
                'currentPage' => 'products',
                'product' => $product,
                'categories' => $adminModel->getCategoriesList(),
                'brands' => $adminModel->getBrands(),
                'materials' => $adminModel->getMaterials(),
                'isEdit' => true,
                'canShow' => $canShow
            ]);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_product':
                    $productId = $adminModel->generateProductId();
                    $productData = [
                        'MaSanPham' => $productId,
                        'TenSanPham' => trim($_POST['TenSanPham'] ?? ''),
                        'MaDanhMuc' => trim($_POST['MaDanhMuc'] ?? ''),
                        'MaThuongHieu' => trim($_POST['MaThuongHieu'] ?? ''),
                        'MaVatLieu' => trim($_POST['MaVatLieu'] ?? ''),
                        'MoTa' => trim($_POST['MoTa'] ?? ''),
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int) $_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => 0
                    ];

                    if ($productData['TenSanPham'] === '' || $productData['MaDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'Tên sản phẩm và danh mục là bắt buộc.';
                    } else {
                        $created = $adminModel->createProduct($productData);
                        if ($created) {
                            if (!empty($_FILES['product_image']['name'])) {
                                $uploadResult = $this->handleProductImageUpload($productId, $_FILES['product_image']);
                                if ($uploadResult !== true) {
                                    $status = 'error';
                                    $message = $uploadResult;
                                    break;
                                }
                            }

                            header('Location: index.php?url=admin/products/edit&id=' . urlencode($productId) . '&created=1');
                            exit;
                        }

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
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int) $_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => isset($_POST['TrangThai']) && $_POST['TrangThai'] === '1' ? 1 : 0
                    ];

                    if ($productId === '' || $productData['TenSanPham'] === '' || $productData['MaDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'ID, tên sản phẩm và danh mục là bắt buộc.';
                    } else {

                        if ($productData['TrangThai'] == 1) {
                            if (!$adminModel->productCanBeVisible($productId)) {
                                $status = 'error';
                                $message = 'Sản phẩm chưa đủ điều kiện (cần biến thể + giá + ảnh)';
                                break;
                            }
                        }

                        $updated = $adminModel->updateProduct($productId, $productData);
                        if ($updated) {
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
                    }
                    break;
            }
        }


        if ($url === 'admin/products/create') {
            $this->view('admin/products_form', [
                'title' => 'Thêm sản phẩm mới',
                'currentPage' => 'products',
                'categories' => $adminModel->getCategoriesList(),
                'brands' => $adminModel->getBrands(),
                'materials' => $adminModel->getMaterials(),
                'isEdit' => false,
                'status' => $status,
                'message' => $message
            ]);
            return;
        }


        $products = $adminModel->getProductsList([
            'keyword' => trim($_GET['keyword'] ?? ''),
            'category' => trim($_GET['category'] ?? ''),
            'brand' => trim($_GET['brand'] ?? '')
        ]);

        $this->view('admin/products', [
            'title' => 'Quản lý sản phẩm',
            'currentPage' => 'products',
            'products' => $products,
            'status' => $status,
            'message' => $message,
            'keyword' => trim($_GET['keyword'] ?? ''),
            'category' => trim($_GET['category'] ?? ''),
            'brand' => trim($_GET['brand'] ?? '')
        ]);
    }

    public function categories()
    {
        $url = $_GET['url'] ?? 'admin/categories';
        $adminModel = $this->model('AdminModel');
        $status = null;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_category':
                    $categoryId = $adminModel->generateCategoryId();
                    $categoryData = [
                        'MaDanhMuc' => $categoryId,
                        'TenDanhMuc' => trim($_POST['TenDanhMuc'] ?? ''),
                        'HinhAnh' => trim($_POST['HinhAnh'] ?? ''),
                        'TrangThai' => 1
                    ];

                    if ($categoryData['TenDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'Tên danh mục không được để trống.';
                    } else {
                        $created = $adminModel->createCategory($categoryData);
                        if ($created) {
                            header('Location: index.php?url=admin/categories&created=1');
                            exit;
                        }
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
                    } else {
                        $updated = $adminModel->updateCategory($categoryId, $categoryData);
                        if ($updated) {
                            $status = 'success';
                            $message = 'Cập nhật danh mục thành công.';
                        } else {
                            $status = 'error';
                            $message = 'Cập nhật danh mục thất bại, vui lòng thử lại.';
                        }
                    }
                    break;
            }
        }

        if ($url === 'admin/categories/delete') {
            $categoryId = trim($_GET['id'] ?? '');
            if ($categoryId !== '') {
                $hasProducts = $adminModel->categoryHasProducts($categoryId);
                $adminModel->softDeleteCategory($categoryId);
                $status = 'success';
                if ($hasProducts) {
                    $message = 'Danh mục có sản phẩm → đã chuyển sang trạng thái ẩn (không xóa cứng)';
                } else {
                    $message = 'Đã ẩn danh mục thành công';
                }
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
            $category = $adminModel->getCategoryById($categoryId);
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

        $categories = $adminModel->getCategoriesList();

        $this->view('admin/categories', [
            'title' => 'Quản lý danh mục',
            'currentPage' => 'categories',
            'categories' => $categories,
            'status' => $status,
            'message' => $message
        ]);
    }

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

        if ($file['error'] !== UPLOAD_ERR_OK) {
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

        $adminModel = $this->model('AdminModel');
        $adminModel->addProductImage($productId, $safeName);

        return true;
    }
}
