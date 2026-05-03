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
        $newId = $this->generateUserId(); 
        
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

    public function updateProfile($data) {
        $userId = $data['id'] ?? '';
        $fullName = trim($data['HoTen'] ?? '');
        $phone = trim($data['SoDienThoai'] ?? '');
        $street = trim($data['SoNha_Duong'] ?? '');
        $ward = trim($data['PhuongXa'] ?? '');
        $district = trim($data['QuanHuyen'] ?? '');
        $province = trim($data['TinhThanh'] ?? '');

        if ($userId === '' || $fullName === '') {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                UPDATE nguoidung
                SET HoTen = ?, SoDienThoai = ?
                WHERE MaNguoiDung = ?
            ");
            $stmt->execute([$fullName, $phone, $userId]);

            $existingStmt = $this->db->prepare("
                SELECT MaDiaChi
                FROM diachi
                WHERE MaNguoiDung = ? AND MacDinh = 1
                LIMIT 1
            ");
            $existingStmt->execute([$userId]);
            $addressId = $existingStmt->fetchColumn();
            $hasAddressInput = $street !== '' || $ward !== '' || $district !== '' || $province !== '';

            if ($addressId) {
                $addressStmt = $this->db->prepare("
                    UPDATE diachi
                    SET SoNha_Duong = ?, PhuongXa = ?, QuanHuyen = ?, TinhThanh = ?, MacDinh = 1
                    WHERE MaDiaChi = ?
                ");
                $addressStmt->execute([$street, $ward, $district, $province, $addressId]);
            } elseif ($hasAddressInput) {
                $this->db->prepare("UPDATE diachi SET MacDinh = 0 WHERE MaNguoiDung = ?")->execute([$userId]);

                $addressStmt = $this->db->prepare("
                    INSERT INTO diachi (MaDiaChi, MaNguoiDung, SoNha_Duong, PhuongXa, QuanHuyen, TinhThanh, MacDinh)
                    VALUES (?, ?, ?, ?, ?, ?, 1)
                ");
                $addressStmt->execute([
                    $this->generateAddressId(),
                    $userId,
                    $street,
                    $ward,
                    $district,
                    $province
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    private function generateUserId() {
        $sql = "SELECT MaNguoiDung
                FROM nguoidung
                WHERE MaNguoiDung LIKE 'U%'
                ORDER BY CAST(SUBSTRING(MaNguoiDung, 2) AS UNSIGNED) DESC
                LIMIT 1";
        $stmt = $this->db->query($sql);
        $lastId = $stmt->fetchColumn();
        $nextNumber = $lastId ? ((int) substr($lastId, 1)) + 1 : 1;

        return 'U' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function generateAddressId() {
        $sql = "SELECT MaDiaChi
                FROM diachi
                WHERE MaDiaChi LIKE 'DC%'
                ORDER BY CAST(SUBSTRING(MaDiaChi, 3) AS UNSIGNED) DESC
                LIMIT 1";
        $stmt = $this->db->query($sql);
        $lastId = $stmt->fetchColumn();
        $nextNumber = $lastId ? ((int) substr($lastId, 2)) + 1 : 1;

        return 'DC' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
