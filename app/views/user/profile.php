<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản - Sustainable E-commerce</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Thiết lập màu eco-friendly (xanh lá) */
        :root {
            --color-primary: #16a34a;  /* Xanh lá chính */
            --color-primary-light: #dcfce7;  /* Xanh lá nhạt */
            --color-primary-dark: #15803d;  /* Xanh lá đậm */
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header/Navbar */
        .navbar-profile {
            background-color: var(--color-primary);
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);
        }

        .navbar-profile .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
        }

        .navbar-profile .user-info {
            color: white;
            font-weight: 500;
        }

        /* Main container */
        .profile-container {
            min-height: 100vh;
            padding: 2rem 0;
        }

        /* Sidebar */
        .sidebar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 0;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .sidebar-header {
            background-color: var(--color-primary);
            color: white;
            padding: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #e5e7eb;
            margin: 0;
        }

        .sidebar-menu li:last-child {
            border-bottom: none;
        }

        .sidebar-menu a {
            display: block;
            padding: 1rem 1.5rem;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-menu a:hover {
            background-color: var(--color-primary-light);
            color: var(--color-primary-dark);
            padding-left: 2rem;
        }

        .sidebar-menu a.active {
            background-color: var(--color-primary);
            color: white;
            border-left: 4px solid var(--color-primary-dark);
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
        }

        /* Logout button in sidebar */
        .sidebar-logout {
            padding: 1rem 1.5rem;
            margin-top: 1rem;
            border-top: 2px solid #e5e7eb;
        }

        .sidebar-logout .btn {
            width: 100%;
            background-color: #dc2626;
            border-color: #dc2626;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-logout .btn:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Content area */
        .content-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .content-section h2 {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--color-primary-light);
        }

        /* Profile info card */
        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            background-color: var(--color-primary-light);
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid var(--color-primary);
        }

        .info-item label {
            display: block;
            font-weight: 600;
            color: var(--color-primary-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .info-item .value {
            display: block;
            color: #333;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Address list */
        .address-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .address-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .address-card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.1);
        }

        .address-badge {
            display: inline-block;
            background-color: var(--color-primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .address-card h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .address-card p {
            color: #666;
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }

        .address-card p strong {
            color: #333;
        }

        .address-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .address-actions a {
            flex: 1;
            padding: 0.5rem 0.75rem;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .address-actions .edit {
            background-color: #3b82f6;
            color: white;
        }

        .address-actions .edit:hover {
            background-color: #2563eb;
        }

        .address-actions .delete {
            background-color: #ef4444;
            color: white;
        }

        .address-actions .delete:hover {
            background-color: #dc2626;
        }

        .address-actions .default {
            background-color: var(--color-primary);
            color: white;
        }

        .address-actions .default:hover {
            background-color: var(--color-primary-dark);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }

        .empty-state .btn {
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem 0;
            }

            .content-section {
                padding: 1.5rem;
            }

            .address-list {
                grid-template-columns: 1fr;
            }

            .profile-info-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                margin-bottom: 2rem;
            }
        }

        /* Edit button in profile section */
        .edit-profile-btn {
            margin-top: 1.5rem;
        }

        .edit-profile-btn .btn {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .edit-profile-btn .btn:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        /* Add address button */
        .add-address-btn {
            margin-bottom: 1.5rem;
        }

        .add-address-btn .btn {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .add-address-btn .btn:hover {
            background-color: var(--color-primary-dark);
            border-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-profile">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-leaf"></i> Sustainable Shop
            </a>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <?= htmlspecialchars($user['hoTen'] ?? 'Người dùng') ?>
            </div>
        </div>
    </nav>

    <!-- Main container -->
    <div class="profile-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="sidebar-header">
                            <i class="fas fa-bars"></i> Menu Tài Khoản
                        </div>
                        <ul class="sidebar-menu">
                            <li>
                                <a href="javascript:void(0)" onclick="showSection('profile')" class="menu-link active" data-section="profile">
                                    <i class="fas fa-user"></i> Thông tin chung
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="showSection('addresses')" class="menu-link" data-section="addresses">
                                    <i class="fas fa-map-marker-alt"></i> Địa chỉ
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="showSection('orders')" class="menu-link" data-section="orders">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng
                                </a>
                            </li>
                        </ul>
                        <div class="sidebar-logout">
                            <a href="index.php?url=user/logout" class="btn">
                                <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content area -->
                <div class="col-md-9">
                    <!-- Section 1: Thông tin chung (Profile) -->
                    <div class="content-section active" id="profile">
                        <h2><i class="fas fa-user-circle"></i> Thông tin cá nhân</h2>
                        
                        <div class="profile-info-grid">
                            <!-- Họ tên -->
                            <div class="info-item">
                                <label><i class="fas fa-user"></i> Họ và Tên</label>
                                <span class="value"><?= htmlspecialchars($user['hoTen'] ?? 'N/A') ?></span>
                            </div>

                            <!-- Email -->
                            <div class="info-item">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <span class="value"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></span>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="info-item">
                                <label><i class="fas fa-phone"></i> Số điện thoại</label>
                                <span class="value"><?= htmlspecialchars($user['soDienThoai'] ?? 'N/A') ?></span>
                            </div>

                            <!-- Ngày sinh -->
                            <div class="info-item">
                                <label><i class="fas fa-birthday-cake"></i> Ngày sinh</label>
                                <span class="value">
                                    <?php 
                                    if ($user['ngaySinh'] ?? null) {
                                        $date = DateTime::createFromFormat('Y-m-d', $user['ngaySinh']);
                                        echo $date->format('d/m/Y');
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </span>
                            </div>

                            <!-- Giới tính -->
                            <div class="info-item">
                                <label><i class="fas fa-venus-mars"></i> Giới tính</label>
                                <span class="value"><?= htmlspecialchars($user['gioiTinh'] ?? 'N/A') ?></span>
                            </div>
                        </div>

                        <!-- Edit button -->
                        <div class="edit-profile-btn">
                            <button class="btn" onclick="alert('Chức năng chỉnh sửa sẽ có trong lần cập nhật tiếp theo')">
                                <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                            </button>
                        </div>
                    </div>

                    <!-- Section 2: Địa chỉ (Addresses) -->
                    <div class="content-section" id="addresses">
                        <h2><i class="fas fa-map-marker-alt"></i> Quản lý địa chỉ</h2>
                        
                        <?php if (!empty($addresses)): ?>
                            <div class="add-address-btn">
                                <button class="btn" onclick="alert('Chức năng thêm địa chỉ sẽ có trong lần cập nhật tiếp theo')">
                                    <i class="fas fa-plus"></i> Thêm địa chỉ mới
                                </button>
                            </div>

                            <div class="address-list">
                                <?php foreach ($addresses as $address): ?>
                                    <div class="address-card">
                                        <!-- Badge cho địa chỉ mặc định -->
                                        <?php if ($address['trangThai'] === 'Mặc định'): ?>
                                            <div class="address-badge">
                                                <i class="fas fa-check-circle"></i> Mặc định
                                            </div>
                                        <?php endif; ?>

                                        <!-- Thông tin địa chỉ -->
                                        <h5><?= htmlspecialchars($address['tenDuong'] ?? '') ?></h5>
                                        <p>
                                            <strong>Quận/Huyện:</strong> 
                                            <?= htmlspecialchars($address['quanHuyen'] ?? 'N/A') ?>
                                        </p>
                                        <p>
                                            <strong>Thành phố:</strong> 
                                            <?= htmlspecialchars($address['thanhPho'] ?? 'N/A') ?>
                                        </p>
                                        <p>
                                            <strong>Mã số:</strong> 
                                            <?= htmlspecialchars($address['maSo'] ?? 'N/A') ?>
                                        </p>

                                        <!-- Action buttons -->
                                        <div class="address-actions">
                                            <a href="javascript:void(0)" class="edit" onclick="alert('Chức năng chỉnh sửa sẽ có trong lần cập nhật tiếp theo')">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="javascript:void(0)" class="delete" onclick="alert('Chức năng xóa sẽ có trong lần cập nhật tiếp theo')">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </a>
                                            <?php if ($address['trangThai'] !== 'Mặc định'): ?>
                                                <a href="javascript:void(0)" class="default" onclick="alert('Chức năng này sẽ có trong lần cập nhật tiếp theo')">
                                                    <i class="fas fa-star"></i> Đặt làm mặc định
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Bạn chưa có địa chỉ nào</p>
                                <p style="font-size: 0.9rem; color: #bbb;">Thêm địa chỉ để sử dụng khi mua sắm</p>
                                <button class="btn btn-primary" onclick="alert('Chức năng thêm địa chỉ sẽ có trong lần cập nhật tiếp theo')">
                                    <i class="fas fa-plus"></i> Thêm địa chỉ mới
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Section 3: Đơn hàng (Orders) -->
                    <div class="content-section" id="orders">
                        <h2><i class="fas fa-shopping-bag"></i> Đơn hàng của tôi</h2>
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Chức năng này sẽ có trong phiên bản tiếp theo</p>
                            <p style="font-size: 0.9rem; color: #bbb;">Quay lại <a href="index.php" style="color: var(--color-primary);">Trang chủ</a> để mua sắm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navigation script -->
    <script>
        /**
         * Hàm hiển thị section được chọn
         * @param {string} sectionId - ID của section cần hiển thị
         */
        function showSection(sectionId) {
            // Ẩn tất cả sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Xóa active class khỏi tất cả menu links
            const menuLinks = document.querySelectorAll('.menu-link');
            menuLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Hiển thị section được chọn
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.add('active');
            }

            // Thêm active class vào menu link được chọn
            const selectedLink = document.querySelector(`[data-section="${sectionId}"]`);
            if (selectedLink) {
                selectedLink.classList.add('active');
            }
        }

        // Đặt section mặc định khi tải trang
        document.addEventListener('DOMContentLoaded', function() {
            showSection('profile');
        });
    </script>
</body>
</html>
