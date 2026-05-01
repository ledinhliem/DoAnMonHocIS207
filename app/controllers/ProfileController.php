<?php
class ProfileController extends Controller {
    public function index() {
        // Kiểm tra session (Rule: Phải có login mới xem được profile)
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?url=login'); 
            exit;
        }

        $userModel = $this->model('UserModel');
        $data['user'] = $userModel->getUserInfo($_SESSION['user_id']);
        
        $this->view('profile/index', $data);
    }
}