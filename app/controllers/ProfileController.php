<?php

class ProfileController extends Controller
{
    private function currentUser(UserModel $userModel): array
    {
        $userId = $_SESSION['user_id'] ?? '';
        $user = $userId !== '' ? $userModel->getUserInfo($userId) : false;

        if (is_array($user)) {
            return $user;
        }

        if (!empty($_SESSION['user_email'])) {
            $user = $userModel->getUserByEmail($_SESSION['user_email']);
            if (is_array($user)) {
                $_SESSION['user_id'] = $user['MaNguoiDung'];
                $_SESSION['user_name'] = $user['HoTen'];
                $_SESSION['user_email'] = $user['Email'];
                return $userModel->getUserInfo($user['MaNguoiDung']) ?: $user;
            }
        }

        if (!empty($_SESSION['user_name'])) {
            $user = $userModel->getUserByName($_SESSION['user_name']);
            if (is_array($user)) {
                $_SESSION['user_id'] = $user['MaNguoiDung'];
                $_SESSION['user_name'] = $user['HoTen'];
                $_SESSION['user_email'] = $user['Email'];
                return $userModel->getUserInfo($user['MaNguoiDung']) ?: $user;
            }
        }

        return [];
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $userModel = $this->model('UserModel');
        $user = $this->currentUser($userModel);

        $this->view('profile/index', [
            'user' => $user,
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
        $user = $this->currentUser($userModel);

        $this->view('profile/edit', [
            'user' => $user,
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

        $userModel = $this->model('UserModel');
        $currentUser = $this->currentUser($userModel);
        if (empty($currentUser['MaNguoiDung'])) {
            $_SESSION['profile_old'] = $_POST;
            $_SESSION['error'] = 'Phiên đăng nhập không khớp tài khoản trong hệ thống. Vui lòng đăng xuất rồi đăng nhập lại.';
            header('Location: index.php?url=profile/edit');
            exit;
        }

        $updateData = [
            'id' => $currentUser['MaNguoiDung'],
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

        if ($userModel->updateProfile($updateData)) {
            $updatedUser = $userModel->getUserInfo($updateData['id']);
            $_SESSION['user_name'] = $updatedUser['HoTen'] ?? $updateData['HoTen'];
            $_SESSION['user_email'] = $updatedUser['Email'] ?? ($_SESSION['user_email'] ?? '');
            $_SESSION['user'] = $updatedUser ?: array_merge($currentUser, $updateData);
            unset($_SESSION['checkout_data']);
            $_SESSION['success'] = 'Cập nhật thông tin thành công!';
            header('Location: index.php?url=profile');
        } else {
            $_SESSION['profile_old'] = $updateData;
            $_SESSION['error'] = $userModel->getLastError() ?: 'Có lỗi xảy ra, vui lòng thử lại.';
            header('Location: index.php?url=profile/edit');
        }

        exit;
    }
}
