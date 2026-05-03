<?php
class UserModel extends Model {
    
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM nguoidung WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        // Tạo mã ID mới ngẫu nhiên dạng U + 4 số
        $newId = 'U' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT); 
        
        $sql = "INSERT INTO nguoidung (MaNguoiDung, HoTen, Email, MatKhau, MaQuyen) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $newId,
            $data['hoten'],
            $data['email'],
            $data['matkhau'], 
            $data['maquyen'] 
        ]);
    }

    public function getUserInfo($id) {
        // JOIN bảng nguoidung và diachi để lấy luôn địa chỉ mặc định (nếu có)
        $sql = "SELECT n.*, d.SoNha_Duong, d.PhuongXa, d.QuanHuyen, d.TinhThanh 
                FROM nguoidung n 
                LEFT JOIN diachi d ON n.MaNguoiDung = d.MaNguoiDung AND d.MacDinh = 1 
                WHERE n.MaNguoiDung = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM nguoidung WHERE MaNguoiDung = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}