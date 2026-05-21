<?php

class ProfileController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $userModel = $this->model('UserModel');

        $this->view('profile/index', [
            'user' => $userModel->getUserInfo($_SESSION['user_id']),
            'success' => $_SESSION['success'] ?? '',
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $userModel = $this->model('UserModel');

        $this->view('profile/edit', [
            'user' => $userModel->getUserInfo($_SESSION['user_id']),
            'errors' => $_SESSION['profile_errors'] ?? [],
            'old' => $_SESSION['profile_old'] ?? [],
            'error' => $_SESSION['error'] ?? '',
        ]);

        unset($_SESSION['profile_errors'], $_SESSION['profile_old'], $_SESSION['error']);
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?url=profile/edit');
            exit;
        }

        $updateData = [
            'id' => $_SESSION['user_id'],
            'HoTen' => trim($_POST['HoTen'] ?? ''),
            'SoDienThoai' => trim($_POST['SoDienThoai'] ?? ''),
            'SoNha_Duong' => trim($_POST['SoNha_Duong'] ?? ''),
            'PhuongXa' => trim($_POST['PhuongXa'] ?? ''),
            'QuanHuyen' => trim($_POST['QuanHuyen'] ?? ''),
            'TinhThanh' => trim($_POST['TinhThanh'] ?? ''),
        ];

        $errors = [];

        if ($updateData['HoTen'] === '') {
            $errors['HoTen'] = 'Vui lòng nhập họ tên.';
        }

        if ($updateData['SoDienThoai'] !== '' && !preg_match('/^[0-9+ ]{8,15}$/', $updateData['SoDienThoai'])) {
            $errors['SoDienThoai'] = 'Số điện thoại không hợp lệ.';
        }

        if (!empty($errors)) {
            $_SESSION['profile_errors'] = $errors;
            $_SESSION['profile_old'] = $updateData;
            header('Location: index.php?url=profile/edit');
            exit;
        }

        $userModel = $this->model('UserModel');

        if ($userModel->updateProfile($updateData)) {
            $_SESSION['user_name'] = $updateData['HoTen'];
            $_SESSION['success'] = 'Cập nhật thông tin thành công!';
            header('Location: index.php?url=profile');
        } else {
            $_SESSION['profile_old'] = $updateData;
            $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
            header('Location: index.php?url=profile/edit');
        }

        exit;
    }
}
