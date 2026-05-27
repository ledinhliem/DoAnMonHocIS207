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
        $status = $_SESSION['flash_status'] ?? ($_GET['status'] ?? null);
        $message = $_SESSION['flash_message'] ?? ($_GET['message'] ?? '');
        unset($_SESSION['flash_status'], $_SESSION['flash_message']);

        $stats = $this->adminModel->getDashboardStats();
        $revenueLast7Days = $this->adminModel->getRevenueLast7Days();
        $orderStatusStats = $this->adminModel->getOrderStatusStats();
        $inventoryStockStats = $this->adminModel->getInventoryStockStats();
        $recentOrders = $this->adminModel->getRecentOrders(5);
        $lowStockItems = $this->adminModel->getLowStockItems(5);
        $topSellingProducts = $this->adminModel->getTopSellingProducts(5);

        $this->view('admin/dashboard', [
            'title' => 'Admin Bảng điều khiển',
            'currentPage' => 'dashboard',
            'status' => $status,
            'message' => $message,
            'stats' => $stats,
            'revenueLast7Days' => $revenueLast7Days,
            'orderStatusStats' => $orderStatusStats,
            'inventoryStockStats' => $inventoryStockStats,
            'recentOrders' => $recentOrders,
            'lowStockItems' => $lowStockItems,
            'topSellingProducts' => $topSellingProducts
        ]);
    }

    /* =========================================================
       PRODUCTS + CATEGORIES — Ái Linh
       ========================================================= */

    public function products()
    {
        $id = trim($_GET['id'] ?? '');
        $url = $_GET['url'] ?? 'admin/products';

        $status = $_SESSION['flash_status'] ?? null;
        $message = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_status'], $_SESSION['flash_message']);

        if ($id !== '' && in_array($url, ['admin/products/hide', 'admin/products/show', 'admin/products/delete'], true)) {
            $redirectStatus = 'success';
            $redirectMessage = '';

            if ($url === 'admin/products/hide') {
                $redirectMessage = $this->adminModel->hideProduct($id)
                    ? 'Đã ẩn / ngừng bán sản phẩm.'
                    : 'Ẩn sản phẩm thất bại.';
                $redirectStatus = str_contains($redirectMessage, 'thất bại') ? 'error' : 'success';
            } elseif ($url === 'admin/products/show') {
                $redirectMessage = $this->adminModel->showProduct($id)
                    ? 'Đã mở bán sản phẩm.'
                    : 'Không thể mở bán: sản phẩm cần ít nhất 1 ảnh và 1 biến thể còn tồn kho.';
                $redirectStatus = str_starts_with($redirectMessage, 'Không thể') ? 'error' : 'success';
            } else {
                $redirectMessage = $this->adminModel->deleteProduct($id)
                    ? 'Đã xóa sản phẩm khỏi admin.'
                    : 'Không thể xóa sản phẩm đã có đơn hàng. Hãy dùng Ẩn / Ngừng bán.';
                $redirectStatus = str_starts_with($redirectMessage, 'Không thể') ? 'error' : 'success';
            }

            header('Location: index.php?url=admin/products&status=' . $redirectStatus . '&message=' . urlencode($redirectMessage));
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
                'productVariants' => $this->adminModel->getVariantsByProduct($id, true),
                'isEdit' => true,
                'canShow' => $canShow,
                'status' => $status ?? ($_GET['status'] ?? null),
                'message' => $message ?: ($_GET['message'] ?? '')
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
                        'new_brand_name' => trim($_POST['new_brand_name'] ?? ''),
                        'TenVatLieu' => trim($_POST['TenVatLieu'] ?? ''),
                        'MoTa' => trim($_POST['MoTa'] ?? ''),
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int)$_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => 0,
                        'GiaTien' => trim($_POST['GiaTien'] ?? ''),
                        'primary_stock' => trim($_POST['primary_stock'] ?? '0'),
                        'fashion_type' => trim($_POST['fashion_type'] ?? ''),
                        'fashion_size' => trim($_POST['fashion_size'] ?? ''),
                        'fashion_custom_type' => trim($_POST['fashion_custom_type'] ?? ''),
                        'fashion_custom_size' => trim($_POST['fashion_custom_size'] ?? ''),
                        'variant_size' => trim($_POST['variant_size'] ?? ''),
                        'variant_label' => trim($_POST['variant_label'] ?? '')
                    ];

                    $variants = $this->normalizeProductVariants($_POST['variants'] ?? []);
                    $errors = $this->validateProductData($productData, $_FILES['product_image'] ?? null);
                    $errors = array_merge($errors, $this->validateProductVariants($variants));
                    if (empty($_FILES['product_image']['name'])) {
                        $errors[] = 'Vui lòng chọn ảnh bìa sản phẩm.';
                    }
                    $errors = array_merge($errors, $this->validateProductDetailImageFiles($_FILES['detail_images'] ?? null, 0));
                    if (!empty($errors)) {
                        $status = 'error';
                        $message = implode(' ', $errors);
                        $product = $productData;
                    } elseif (($brandId = $this->resolveBrandId($productData)) === null) {
                        $status = 'error';
                        $message = 'Không thể tạo thương hiệu mới.';
                        $product = $productData;
                    } elseif (($materialId = $this->adminModel->resolveMaterialId($productData['TenVatLieu'] ?? '')) === null) {
                        $status = 'error';
                        $message = 'Không thể lưu vật liệu sản phẩm.';
                        $product = $productData;
                    } else {
                        $productData['MaThuongHieu'] = $brandId;
                        $productData['MaVatLieu'] = $materialId;

                        try {
                            $this->adminModel->beginTransaction();
                            if (!$this->adminModel->createProduct($productData) || !$this->adminModel->saveProductVariants($productId, $variants)) {
                                throw new RuntimeException('Tạo sản phẩm thất bại, vui lòng thử lại.');
                            }

                            $this->adminModel->commit();
                        } catch (Throwable $e) {
                            $this->adminModel->rollBack();
                            $status = 'error';
                            $message = $e->getMessage();
                            $product = $productData;
                            break;
                        }

                        $uploadResult = $this->handleProductImageUpload($productId, $_FILES['product_image']);
                        if ($uploadResult !== true) {
                            header('Location: index.php?url=admin/products/edit&id=' . urlencode($productId) . '&status=error&message=' . urlencode($uploadResult));
                            exit;
                        }

                        $detailUploadResult = $this->handleProductDetailImagesUpload($productId, $_FILES['detail_images'] ?? null);
                        if ($detailUploadResult !== true) {
                            header('Location: index.php?url=admin/products/edit&id=' . urlencode($productId) . '&status=error&message=' . urlencode($detailUploadResult));
                            exit;
                        }

                        $this->redirectWithFlash('index.php?url=admin/products/edit&id=' . urlencode($productId), 'success', 'Tạo sản phẩm thành công. Vui lòng kiểm tra biến thể và ảnh trước khi bật hiển thị.');
                    }
                    break;

                case 'update_product':
                    $productId = trim($_POST['MaSanPham'] ?? '');

                    $productData = [
                        'TenSanPham' => trim($_POST['TenSanPham'] ?? ''),
                        'MaDanhMuc' => trim($_POST['MaDanhMuc'] ?? ''),
                        'MaThuongHieu' => trim($_POST['MaThuongHieu'] ?? ''),
                        'new_brand_name' => trim($_POST['new_brand_name'] ?? ''),
                        'TenVatLieu' => trim($_POST['TenVatLieu'] ?? ''),
                        'MoTa' => trim($_POST['MoTa'] ?? ''),
                        'DiemXanh' => is_numeric($_POST['DiemXanh'] ?? null) ? (int)$_POST['DiemXanh'] : 10,
                        'NguonGoc' => trim($_POST['NguonGoc'] ?? ''),
                        'TacDongMoiTruong' => trim($_POST['TacDongMoiTruong'] ?? ''),
                        'CoTaiChe' => isset($_POST['CoTaiChe']) ? 1 : 0,
                        'ThanThienMoiTruong' => isset($_POST['ThanThienMoiTruong']) ? 1 : 0,
                        'TrangThai' => isset($_POST['TrangThai']) && $_POST['TrangThai'] === '1' ? 1 : 0,
                        'GiaTien' => trim($_POST['GiaTien'] ?? ''),
                        'primary_stock' => trim($_POST['primary_stock'] ?? '0'),
                        'fashion_type' => trim($_POST['fashion_type'] ?? ''),
                        'fashion_size' => trim($_POST['fashion_size'] ?? ''),
                        'fashion_custom_type' => trim($_POST['fashion_custom_type'] ?? ''),
                        'fashion_custom_size' => trim($_POST['fashion_custom_size'] ?? ''),
                        'variant_size' => trim($_POST['variant_size'] ?? ''),
                        'variant_label' => trim($_POST['variant_label'] ?? '')
                    ];

                    $variants = $this->normalizeProductVariants($_POST['variants'] ?? []);
                    $currentDetailCount = $productId !== '' ? $this->adminModel->countProductImages($productId, 'detail') : 0;
                    $errors = $this->validateProductData($productData, $_FILES['product_image'] ?? null, $productId);
                    $errors = array_merge($errors, $this->validateProductVariants($variants, $productId));
                    $errors = array_merge($errors, $this->validateProductDetailImageFiles($_FILES['detail_images'] ?? null, $currentDetailCount));
                    if ($productId === '') {
                        $status = 'error';
                        $message = 'ID sản phẩm là bắt buộc.';
                        $product = array_merge(['MaSanPham' => $productId], $productData);
                    } elseif (!empty($errors)) {
                        $status = 'error';
                        $message = implode(' ', $errors);
                        $product = array_merge(['MaSanPham' => $productId], $productData);
                    } elseif ((int)$productData['TrangThai'] === 1 && !$this->adminModel->productCanBeVisible($productId)) {
                        $status = 'error';
                        $message = 'Sản phẩm chưa đủ điều kiện hiển thị: cần ít nhất 1 biến thể có giá, tồn kho và 1 ảnh.';
                        $product = array_merge(['MaSanPham' => $productId], $productData);
                    } elseif (($brandId = $this->resolveBrandId($productData)) === null) {
                        $status = 'error';
                        $message = 'Không thể tạo thương hiệu mới.';
                        $product = array_merge(['MaSanPham' => $productId], $productData);
                    } elseif (($materialId = $this->adminModel->resolveMaterialId($productData['TenVatLieu'] ?? '')) === null) {
                        $status = 'error';
                        $message = 'Không thể lưu vật liệu sản phẩm.';
                        $product = array_merge(['MaSanPham' => $productId], $productData);
                    } else {
                        $productData['MaThuongHieu'] = $brandId;
                        $productData['MaVatLieu'] = $materialId;
                        try {
                            $this->adminModel->beginTransaction();
                            if (!$this->adminModel->updateProduct($productId, $productData) || !$this->adminModel->replaceProductVariants($productId, $variants)) {
                                throw new RuntimeException('Cập nhật sản phẩm thất bại, vui lòng thử lại.');
                            }
                            $this->adminModel->commit();
                        } catch (Throwable $e) {
                            $this->adminModel->rollBack();
                            $status = 'error';
                            $message = $e->getMessage();
                            $product = array_merge(['MaSanPham' => $productId], $productData);
                            break;
                        }

                        if (!empty($_FILES['product_image']['name'])) {
                            $uploadResult = $this->handleProductImageUpload($productId, $_FILES['product_image']);

                            if ($uploadResult !== true) {
                                $status = 'error';
                                $message = $uploadResult;
                                $product = array_merge(['MaSanPham' => $productId], $productData);
                                break;
                            }
                        }

                        $detailUploadResult = $this->handleProductDetailImagesUpload($productId, $_FILES['detail_images'] ?? null);
                        if ($detailUploadResult !== true) {
                            $status = 'error';
                            $message = $detailUploadResult;
                            $product = array_merge(['MaSanPham' => $productId], $productData);
                            break;
                        }

                        $this->redirectWithFlash('index.php?url=admin/products/edit&id=' . urlencode($productId), 'success', 'Cập nhật sản phẩm thành công.');
                    }
                    break;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $url === 'admin/products/edit') {
            $productId = trim($_POST['MaSanPham'] ?? '');
            $canShow = $productId !== '' ? $this->adminModel->productCanBeVisible($productId) : false;

            $this->view('admin/products_form', [
                'title' => 'Chỉnh sửa sản phẩm',
                'currentPage' => 'products',
                'product' => $product ?? [],
                'categories' => $this->adminModel->getCategoriesList(),
                'brands' => $this->adminModel->getBrands(),
                'materials' => $this->adminModel->getMaterials(),
                'productVariants' => $variants ?? [],
                'isEdit' => true,
                'canShow' => $canShow,
                'status' => $status,
                'message' => $message
            ]);
            return;
        }

        if ($url === 'admin/products/create') {
            $this->view('admin/products_form', [
                'title' => 'Thêm sản phẩm mới',
                'currentPage' => 'products',
                'categories' => $this->adminModel->getCategoriesList(),
                'brands' => $this->adminModel->getBrands(),
                'materials' => $this->adminModel->getMaterials(),
                'productVariants' => $variants ?? [],
                'product' => $product ?? [],
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
        $status = $_SESSION['flash_status'] ?? null;
        $message = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_status'], $_SESSION['flash_message']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create_category':
                    $categoryData = [
                        'MaDanhMuc' => $this->adminModel->generateCategoryId(),
                        'TenDanhMuc' => trim($_POST['TenDanhMuc'] ?? ''),
                        'HinhAnh' => '',
                        'TrangThai' => 1
                    ];

                    if ($categoryData['TenDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'Tên danh mục không được để trống.';
                        $category = $categoryData;
                    } else {
                        $uploadResult = $this->handleCategoryImageUpload($_FILES['category_image'] ?? null);
                        if ($uploadResult === false) {
                            $status = 'error';
                            $message = 'Ảnh danh mục không hợp lệ. Chỉ chấp nhận jpg, jpeg, png, webp.';
                            $category = $categoryData;
                        } else {
                            $categoryData['HinhAnh'] = $uploadResult;
                            if ($this->adminModel->createCategory($categoryData)) {
                                $this->redirectWithFlash('index.php?url=admin/categories', 'success', 'Tạo danh mục thành công.');
                            }

                            $status = 'error';
                            $message = 'Tạo danh mục thất bại, vui lòng thử lại.';
                            $category = $categoryData;
                        }
                    }
                    break;

                case 'update_category':
                    $categoryId = trim($_POST['MaDanhMuc'] ?? '');
                    $categoryData = [
                        'TenDanhMuc' => trim($_POST['TenDanhMuc'] ?? ''),
                        'HinhAnh' => trim($_POST['current_image'] ?? ''),
                        'TrangThai' => isset($_POST['TrangThai']) && $_POST['TrangThai'] === '1' ? 1 : 0
                    ];

                    if ($categoryId === '' || $categoryData['TenDanhMuc'] === '') {
                        $status = 'error';
                        $message = 'ID và tên danh mục là bắt buộc.';
                    } else {
                        $uploadResult = $this->handleCategoryImageUpload($_FILES['category_image'] ?? null, $categoryData['HinhAnh']);
                        if ($uploadResult === false) {
                            $status = 'error';
                            $message = 'Ảnh danh mục không hợp lệ. Chỉ chấp nhận jpg, jpeg, png, webp.';
                            $category = array_merge(['MaDanhMuc' => $categoryId], $categoryData);
                        } else {
                            $categoryData['HinhAnh'] = $uploadResult;
                            if ($this->adminModel->updateCategory($categoryId, $categoryData)) {
                                $this->redirectWithFlash('index.php?url=admin/categories/edit&id=' . urlencode($categoryId), 'success', 'Cập nhật danh mục thành công.');
                            }

                            $status = 'error';
                            $message = 'Cập nhật danh mục thất bại, vui lòng thử lại.';
                            $category = array_merge(['MaDanhMuc' => $categoryId], $categoryData);
                        }
                    }
                    break;
            }
        }

        if (in_array($url, ['admin/categories/delete', 'admin/categories/hide', 'admin/categories/show'], true)) {
            $categoryId = trim($_GET['id'] ?? '');
            if ($categoryId !== '') {
                $hasProducts = $this->adminModel->categoryHasProducts($categoryId);
                $newStatus = $url === 'admin/categories/show' ? 1 : 0;
                $this->adminModel->setCategoryStatus($categoryId, $newStatus);

                $message = $newStatus === 1
                    ? 'Đã hiện danh mục thành công.'
                    : ($hasProducts
                    ? 'Danh mục có sản phẩm → đã chuyển sang trạng thái ẩn, không xóa cứng.'
                    : 'Đã ẩn danh mục thành công.');

                header('Location: index.php?url=admin/categories&status=success&message=' . urlencode($message));
                exit;
            }
        }

        if ($url === 'admin/categories/create') {
            $this->view('admin/categories_form', [
                'title' => 'Thêm danh mục mới',
                'currentPage' => 'categories',
                'isEdit' => false,
                'category' => $category ?? [],
                'status' => $status,
                'message' => $message
            ]);
            return;
        }

        if ($url === 'admin/categories/edit') {
            $categoryId = trim($_GET['id'] ?? '');
            $category = $category ?? $this->adminModel->getCategoryById($categoryId);

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
                } else {
                    $files = $this->normalizeUploadedFiles($_FILES['images'] ?? ($_FILES['image'] ?? null));
                    $currentDetailCount = $this->adminModel->countProductImages($maSanPham, 'detail');
                    $remainingSlots = max(0, AdminModel::PRODUCT_DETAIL_IMAGE_LIMIT - $currentDetailCount);

                    if (empty($files)) {
                        $status = 'error';
                        $message = 'Vui lòng chọn file ảnh.';
                    } elseif ($remainingSlots <= 0) {
                        $status = 'error';
                        $message = 'Sản phẩm đã đủ 8 ảnh chi tiết, không thể tải thêm.';
                    } elseif (count($files) > $remainingSlots) {
                        $status = 'error';
                        $message = 'Chỉ có thể tải thêm tối đa ' . $remainingSlots . ' ảnh chi tiết.';
                    } else {
                        $uploadedCount = 0;
                        $errors = [];

                        foreach ($files as $file) {
                            $validation = $this->validateProductImageFile($file);
                            if ($validation !== true) {
                                $errors[] = $validation;
                                continue;
                            }

                            if ($this->adminModel->uploadGalleryImage($maSanPham, $file, 'detail')) {
                                $uploadedCount++;
                            } else {
                                $errors[] = 'Tải ảnh thất bại.';
                            }
                        }

                        $status = $uploadedCount > 0 && empty($errors) ? 'success' : 'error';
                        $message = $uploadedCount > 0
                            ? 'Đã tải lên ' . $uploadedCount . ' ảnh chi tiết.'
                            : implode(' ', array_unique($errors));
                    }
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
            'imageSummary' => $maSanPham ? $this->adminModel->getProductImageSummary($maSanPham) : [],
            'ma_san_pham' => $maSanPham
        ]);
    }

    public function inventory()
    {
        $status = $_SESSION['flash_status'] ?? null;
        $message = $_SESSION['flash_message'] ?? '';
        unset($_SESSION['flash_status'], $_SESSION['flash_message']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $redirectUrl = 'index.php?url=admin/inventory';

            switch ($action) {
                case 'update_stock':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    $soLuong = (int)($_POST['so_luong_ton'] ?? -1);

                    if ($maBienThe === '' || $soLuong < 0) {
                        $this->redirectWithFlash($redirectUrl, 'error', 'Dữ liệu tồn kho không hợp lệ.');
                    }

                    $ok = $this->adminModel->updateStock($maBienThe, $soLuong);
                    $this->redirectWithFlash(
                        $redirectUrl,
                        $ok ? 'success' : 'error',
                        $ok ? "Đã cập nhật tồn kho biến thể $maBienThe thành $soLuong." : 'Cập nhật tồn kho thất bại.'
                    );

                case 'delete_variant':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    if ($maBienThe === '') {
                        $this->redirectWithFlash($redirectUrl, 'error', 'Thiếu mã biến thể.');
                    }

                    if ($this->adminModel->variantHasOrders($maBienThe)) {
                        $this->adminModel->updateStock($maBienThe, 0);
                        $this->redirectWithFlash($redirectUrl, 'warning', "Biến thể $maBienThe đã có trong đơn hàng. Đã đặt tồn kho = 0 thay vì xóa.");
                    }

                    $ok = $this->adminModel->deleteVariant($maBienThe);
                    $this->redirectWithFlash($redirectUrl, $ok ? 'success' : 'error', $ok ? "Đã xóa biến thể $maBienThe." : 'Xóa biến thể thất bại.');

                case 'add_supplier':
                    $tenNCC = trim($_POST['supplier_name'] ?? '');
                    $soDienThoai = trim($_POST['tax_id'] ?? '');
                    $diaChi = trim($_POST['location'] ?? '');

                    if ($tenNCC === '') {
                        $this->redirectWithFlash($redirectUrl . '#supplier-form', 'error', 'Vui lòng nhập tên nhà cung cấp.');
                    }

                    $ok = $this->adminModel->addSupplier($tenNCC, $soDienThoai, $diaChi);
                    $this->redirectWithFlash(
                        $redirectUrl . '#supplier-form',
                        $ok ? 'success' : 'error',
                        $ok ? "Đã đăng ký nhà cung cấp: $tenNCC" : 'Thêm nhà cung cấp thất bại hoặc thiếu bảng nhacungcap.'
                    );

                case 'add_import_receipt':
                    $maBienThe = trim($_POST['ma_bien_the'] ?? '');
                    $quantity = (int)($_POST['quantity'] ?? 0);
                    $note = trim($_POST['note'] ?? '');
                    $supplierId = trim($_POST['supplier_id'] ?? '');

                    if ($maBienThe === '' || $quantity <= 0) {
                        $this->redirectWithFlash($redirectUrl . '#import-form', 'error', 'Vui lòng chọn biến thể và nhập số lượng lớn hơn 0.');
                    }

                    $ok = $this->adminModel->addImportReceipt($maBienThe, $quantity, $note, $supplierId ?: null);
                    $this->redirectWithFlash(
                        $redirectUrl . '#import-form',
                        $ok ? 'success' : 'error',
                        $ok ? 'Đã thêm phiếu nhập và tăng tồn kho thành công.' : 'Thêm phiếu nhập thất bại.'
                    );
            }
        }

        $keyword = trim($_GET['keyword'] ?? '');
        $filterStatus = trim($_GET['status'] ?? '');
        $validStockStatuses = ['', 'in_stock', 'low_stock', 'out_of_stock'];
        if (!in_array($filterStatus, $validStockStatuses, true)) {
            $filterStatus = '';
        }

        $this->view('admin/inventory', [
            'title' => 'Quản lý kho',
            'currentPage' => 'inventory',
            'status' => $status,
            'message' => $message,
            'inventory' => $this->adminModel->getInventory($keyword, $filterStatus),
            'suppliers' => $this->adminModel->getSuppliers(),
            'entries' => $this->adminModel->getImportReceipts(),
            'keyword' => $keyword,
            'filterStatus' => $filterStatus
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

        if ($actionFromUrl === 'flash-delete' && $idFromUrl) {
            $ok = $this->adminModel->deleteFlashSale($idFromUrl);
            header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã xóa flash sale thành công!' : 'Xóa flash sale thất bại!'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'update_game_rewards') {
                $ok = $this->adminModel->updateGameRewards($_POST['rewards'] ?? []);
                header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã cập nhật vòng quay thành công!' : 'Cập nhật vòng quay thất bại!'));
                exit;
            }

            if ($action === 'create_flash_sale') {
                $productId = trim($_POST['product_id'] ?? '');
                $salePrice = (float)($_POST['sale_price'] ?? 0);
                $stockLimit = (int)($_POST['stock_limit'] ?? 0);
                $startTime = str_replace('T', ' ', $_POST['start_time'] ?? '');
                $endTime = str_replace('T', ' ', $_POST['end_time'] ?? '');

                if ($productId === '' || $salePrice <= 0 || $stockLimit <= 0 || $startTime === '' || $endTime === '' || $endTime <= $startTime) {
                    $status = 'error';
                    $message = 'Dữ liệu flash sale chưa hợp lệ!';
                } else {
                    $ok = $this->adminModel->createFlashSale([
                        'product_id' => $productId,
                        'sale_price' => $salePrice,
                        'stock_limit' => $stockLimit,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'status' => !empty($_POST['status']) ? 1 : 0,
                    ]);
                    header('Location: index.php?url=admin/promo&status=' . ($ok ? 'success' : 'error') . '&message=' . urlencode($ok ? 'Đã tạo flash sale thành công!' : 'Tạo flash sale thất bại!'));
                    exit;
                }
            }

            if ($action === 'create_promo' || $action === 'update_promo') {
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
            'editingPromo' => $editingPromo,
            'gameRewards' => $this->adminModel->getGameRewards(),
            'flashSales' => $this->adminModel->getFlashSales(),
            'flashProducts' => $this->adminModel->getProductsForFlashSale()
        ]);
    }

    /* =========================================================
       PRIVATE HELPERS
       ========================================================= */

    private function redirectWithFlash(string $url, string $status, string $message): void
    {
        $_SESSION['flash_status'] = $status;
        $_SESSION['flash_message'] = $message;
        header('Location: ' . $url);
        exit;
    }

    private function validateProductData(array $data, ?array $imageFile = null, string $productId = ''): array
    {
        $errors = [];

        if (trim((string)($data['TenSanPham'] ?? '')) === '') {
            $errors[] = 'Tên sản phẩm không được để trống.';
        }

        $categoryId = trim((string)($data['MaDanhMuc'] ?? ''));
        if ($categoryId === '' || !$this->adminModel->categoryExists($categoryId)) {
            $errors[] = 'Danh mục không hợp lệ.';
        }

        $brandId = trim((string)($data['MaThuongHieu'] ?? ''));
        if ($brandId === '__new__') {
            if (trim((string)($data['new_brand_name'] ?? '')) === '') {
                $errors[] = 'Vui lòng nhập tên thương hiệu mới.';
            }
        } elseif (!$this->adminModel->brandExists($brandId)) {
            $errors[] = 'Thương hiệu không hợp lệ.';
        }

        if (trim((string)($data['TenVatLieu'] ?? '')) === '') {
            $errors[] = 'Vật liệu không được để trống.';
        }

        $score = $data['DiemXanh'] ?? null;
        if (!is_numeric($score) || (int)$score < 0 || (int)$score > 100) {
            $errors[] = 'Điểm xanh phải từ 0 đến 100.';
        }

        if ($imageFile && !empty($imageFile['name'])) {
            $imageValidation = $this->validateProductImageFile($imageFile);
            if ($imageValidation !== true) {
                $errors[] = $imageValidation;
            }
        }

        return $errors;
    }

    private function resolveBrandId(array $data): ?string
    {
        $brandId = trim((string)($data['MaThuongHieu'] ?? ''));
        if ($brandId === '__new__') {
            return $this->adminModel->createBrand(
                trim((string)($data['new_brand_name'] ?? ''))
            );
        }

        return $brandId;
    }

    private function normalizeProductVariants($rawVariants): array
    {
        if (!is_array($rawVariants)) {
            return [];
        }

        $variants = [];
        foreach ($rawVariants as $variant) {
            if (!is_array($variant)) {
                continue;
            }

            $attributes = [];
            $rawAttributes = $variant['attributes_json'] ?? '';
            if (is_string($rawAttributes) && trim($rawAttributes) !== '') {
                $decoded = json_decode($rawAttributes, true);
                if (is_array($decoded)) {
                    $attributes = $decoded;
                }
            } elseif (is_array($rawAttributes)) {
                $attributes = $rawAttributes;
            }
            $attributes = $this->normalizeVariantAttributeValues($attributes);

            $mappedSize = trim((string)($variant['kich_thuoc'] ?? ''));
            $mappedColor = trim((string)($variant['mau_sac'] ?? ''));
            if ($mappedSize === '') {
                $mappedSize = $this->mapVariantSizeFromAttributes($attributes);
            }
            if ($mappedColor === '') {
                $mappedColor = $this->mapVariantColorFromAttributes($attributes);
            }
            $variantName = trim((string)($variant['name'] ?? ''));
            if ($variantName === '' && !empty($attributes)) {
                $variantName = implode(' / ', array_values($attributes));
            }

            $variants[] = [
                'sku' => strtoupper(trim((string)($variant['sku'] ?? ''))),
                'name' => $variantName,
                'attributes_json' => $attributes,
                'kich_thuoc' => $mappedSize,
                'mau_sac' => $mappedColor,
                'price' => trim((string)($variant['price'] ?? '')),
                'stock' => trim((string)($variant['stock'] ?? '')),
                'status' => isset($variant['status']) ? (int)$variant['status'] : 1,
            ];
        }

        return $variants;
    }

    private function mapVariantSizeFromAttributes(array $attributes): string
    {
        foreach (['Size', 'Dung tích', 'Khối lượng', 'Kích thước', 'Quy cách', 'Loại/kiểu'] as $label) {
            if (!empty($attributes[$label]) && trim((string)$attributes[$label]) !== '0') {
                return trim((string)$attributes[$label]);
            }
        }

        return trim((string)(array_values($attributes)[0] ?? ''));
    }

    private function mapVariantColorFromAttributes(array $attributes): string
    {
        foreach (['Màu sắc', 'Mùi hương', 'Họa tiết', 'Chất liệu'] as $label) {
            if (!empty($attributes[$label]) && trim((string)$attributes[$label]) !== '0') {
                return trim((string)$attributes[$label]);
            }
        }

        return '';
    }

    private function normalizeVariantAttributeValues(array $attributes): array
    {
        $normalized = [];
        foreach ($attributes as $label => $value) {
            $label = trim((string)$label);
            $value = trim((string)$value);
            if ($label === '' || $value === '') {
                continue;
            }
            $normalized[$label] = $value;
        }
        return $normalized;
    }

    private function validateProductVariants(array $variants, string $productId = ''): array
    {
        $errors = [];
        if (empty($variants)) {
            return ['Sản phẩm phải có ít nhất 1 biến thể.'];
        }

        $seenSku = [];
        $seenCombination = [];
        foreach ($variants as $index => $variant) {
            $line = $index + 1;
            $sku = trim((string)($variant['sku'] ?? ''));
            $price = $variant['price'] ?? '';
            $stock = $variant['stock'] ?? '';

            if ($price === '' || !is_numeric($price) || (float)$price < 0) {
                $errors[] = "Biến thể dòng {$line}: giá phải >= 0.";
            }

            if ($stock === '' || !is_numeric($stock) || (int)$stock < 0) {
                $errors[] = "Biến thể dòng {$line}: tồn kho phải >= 0.";
            }

            if ($sku !== '') {
                if (isset($seenSku[$sku])) {
                    $errors[] = "Mã biến thể {$sku} bị trùng trong form.";
                }
                $seenSku[$sku] = true;

                $skuExists = $this->adminModel->variantExists($sku);
                $skuBelongsToProduct = $productId !== '' && $skuExists && $this->variantBelongsToProduct($sku, $productId);
                if ($skuExists && !$skuBelongsToProduct) {
                    $errors[] = "Mã biến thể {$sku} đã tồn tại.";
                }
            }

            $attributes = $variant['attributes_json'] ?? [];
            if (empty($attributes) && trim((string)($variant['name'] ?? '')) === '') {
                $errors[] = "Biến thể dòng {$line}: thiếu thuộc tính biến thể.";
            }

            $combinationKey = json_encode($attributes, JSON_UNESCAPED_UNICODE);
            if ($combinationKey === '[]') {
                $combinationKey = mb_strtolower(trim((string)($variant['name'] ?? '')), 'UTF-8');
            }
            if ($combinationKey !== '' && isset($seenCombination[$combinationKey])) {
                $errors[] = "Biến thể dòng {$line}: tổ hợp thuộc tính bị trùng.";
            }
            $seenCombination[$combinationKey] = true;
        }

        return array_values(array_unique($errors));
    }

    private function variantBelongsToProduct(string $sku, string $productId): bool
    {
        foreach ($this->adminModel->getVariantsByProduct($productId) as $variant) {
            if (($variant['MaBienThe'] ?? '') === $sku) {
                return true;
            }
        }
        return false;
    }

    private function resolvePrimaryVariantSize(array $data): string
    {
        return $this->adminModel->isFashionCategory(trim((string)($data['MaDanhMuc'] ?? '')))
            ? (
                trim((string)($data['fashion_type'] ?? '')) === 'other'
                    ? trim((string)($data['fashion_custom_size'] ?? ''))
                    : trim((string)($data['fashion_size'] ?? ''))
            )
            : trim((string)($data['variant_size'] ?? ''));
    }

    private function resolvePrimaryVariantLabel(array $data): string
    {
        return $this->adminModel->isFashionCategory(trim((string)($data['MaDanhMuc'] ?? '')))
            ? (
                trim((string)($data['fashion_type'] ?? '')) === 'other'
                    ? trim((string)($data['fashion_custom_type'] ?? ''))
                    : trim((string)($data['fashion_type'] ?? ''))
            )
            : trim((string)($data['variant_label'] ?? ''));
    }

    private function validateProductImageFile(array $file)
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return 'Lỗi khi tải ảnh lên. Vui lòng thử lại.';
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo((string)($file['name'] ?? ''), PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExt, true)) {
            return 'Ảnh sản phẩm chỉ nhận jpg, jpeg, png, webp.';
        }

        $imageInfo = @getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            return 'File tải lên không phải ảnh hợp lệ.';
        }

        $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array((string)($imageInfo['mime'] ?? ''), $allowedMime, true)) {
            return 'Ảnh sản phẩm chỉ nhận jpg, jpeg, png, webp.';
        }

        return true;
    }

    private function normalizeUploadedFiles(?array $files): array
    {
        if (!$files || empty($files['name'])) {
            return [];
        }

        if (is_array($files['name'])) {
            $normalized = [];
            foreach ($files['name'] as $index => $name) {
                if ($name === '') {
                    continue;
                }
                $normalized[] = [
                    'name' => $name,
                    'type' => $files['type'][$index] ?? '',
                    'tmp_name' => $files['tmp_name'][$index] ?? '',
                    'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$index] ?? 0,
                ];
            }
            return $normalized;
        }

        return [$files];
    }

    private function validateProductDetailImageFiles(?array $files, int $currentDetailCount = 0): array
    {
        $normalizedFiles = $this->normalizeUploadedFiles($files);
        if (empty($normalizedFiles)) {
            return [];
        }

        $remainingSlots = max(0, AdminModel::PRODUCT_DETAIL_IMAGE_LIMIT - $currentDetailCount);
        if ($remainingSlots <= 0) {
            return ['Sản phẩm đã đủ 8 ảnh chi tiết, không thể tải thêm.'];
        }

        if (count($normalizedFiles) > $remainingSlots) {
            return ['Chỉ có thể tải thêm tối đa ' . $remainingSlots . ' ảnh chi tiết.'];
        }

        $errors = [];
        foreach ($normalizedFiles as $file) {
            $validation = $this->validateProductImageFile($file);
            if ($validation !== true) {
                $errors[] = $validation;
            }
        }

        return array_values(array_unique($errors));
    }

    private function handleProductImageUpload(string $productId, array $file)
    {
        if (empty($file['name'])) {
            return true;
        }

        $validation = $this->validateProductImageFile($file);
        if ($validation !== true) {
            return $validation;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $destinationDir = ROOT_PATH . '/public/assets/images/products/';
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $safeName = $productId . '_' . time() . '.' . $extension;
        $targetPath = $destinationDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'Không thể lưu ảnh sản phẩm.';
        }

        if (!$this->adminModel->replaceProductCoverImage($productId, $safeName)) {
            @unlink($targetPath);
            return 'Không thể lưu ảnh bìa sản phẩm.';
        }

        return true;
    }

    private function handleProductDetailImagesUpload(string $productId, ?array $files)
    {
        $normalizedFiles = $this->normalizeUploadedFiles($files);
        if (empty($normalizedFiles)) {
            return true;
        }

        $currentDetailCount = $this->adminModel->countProductImages($productId, 'detail');
        $remainingSlots = max(0, AdminModel::PRODUCT_DETAIL_IMAGE_LIMIT - $currentDetailCount);
        if (count($normalizedFiles) > $remainingSlots) {
            return 'Chỉ có thể tải thêm tối đa ' . $remainingSlots . ' ảnh chi tiết.';
        }

        foreach ($normalizedFiles as $file) {
            $validation = $this->validateProductImageFile($file);
            if ($validation !== true) {
                return $validation;
            }

            if (!$this->adminModel->uploadGalleryImage($productId, $file, 'detail')) {
                return 'Không thể lưu ảnh chi tiết sản phẩm.';
            }
        }

        return true;
    }

    private function handleCategoryImageUpload(?array $file, string $currentImage = '')
    {
        if (!$file || empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $currentImage;
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExt, true) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $destinationDir = ROOT_PATH . '/public/assets/images/categories/';
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $safeBase = preg_replace('/[^a-z0-9_-]+/i', '-', pathinfo($file['name'], PATHINFO_FILENAME));
        $safeName = strtolower(trim($safeBase, '-')) . '_' . time() . '.' . $extension;
        $targetPath = $destinationDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return false;
        }

        return $safeName;
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
