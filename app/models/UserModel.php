<?php
class UserModel extends Model {
    private string $lastError = '';

    public function getLastError(): string {
        return $this->lastError;
    }
    
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM nguoidung WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email) {
        return $this->getUserByEmail($email);
    }

    public function findByGoogleId(string $googleId) {
        if ($googleId === '' || !$this->columnExists('nguoidung', 'google_id')) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM nguoidung WHERE google_id = ? LIMIT 1");
        $stmt->execute([$googleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createGoogleUser(array $googleUserData) {
        $email = trim($googleUserData['email'] ?? '');
        $name = trim($googleUserData['name'] ?? '');

        if ($email === '') {
            return false;
        }

        $created = $this->createUser([
            'hoten' => $name !== '' ? $name : $email,
            'email' => $email,
            'matkhau' => password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT),
            'maquyen' => '2'
        ]);

        if (!$created) {
            return false;
        }

        $user = $this->getUserByEmail($email);
        if (!$user) {
            return false;
        }

        $this->linkGoogleAccount(
            $user['MaNguoiDung'],
            (string)($googleUserData['google_id'] ?? ''),
            (string)($googleUserData['avatar'] ?? '')
        );

        return $this->getUserByEmail($email);
    }

    public function updateGoogleUserInfo(string $userId, array $googleUserData): bool {
        $sets = [];
        $params = [];

        if ($this->columnExists('nguoidung', 'avatar') && !empty($googleUserData['avatar'])) {
            $sets[] = 'avatar = ?';
            $params[] = $googleUserData['avatar'];
        }

        if ($this->columnExists('nguoidung', 'provider')) {
            $sets[] = 'provider = ?';
            $params[] = 'google';
        }

        if ($this->columnExists('nguoidung', 'google_id') && !empty($googleUserData['google_id'])) {
            $sets[] = 'google_id = ?';
            $params[] = $googleUserData['google_id'];
        }

        if (empty($sets)) {
            return true;
        }

        $params[] = $userId;
        $stmt = $this->db->prepare('UPDATE nguoidung SET ' . implode(', ', $sets) . ' WHERE MaNguoiDung = ?');
        return $stmt->execute($params);
    }

    public function linkGoogleAccount(string $userId, string $googleId, string $avatar = ''): bool {
        return $this->updateGoogleUserInfo($userId, [
            'google_id' => $googleId,
            'avatar' => $avatar
        ]);
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

    public function createPasswordResetToken(string $email, string $tokenHash): bool {
        $this->db->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        $stmt = $this->db->prepare("
            INSERT INTO password_resets (email, token, created_at)
            VALUES (?, ?, NOW())
        ");

        return $stmt->execute([$email, $tokenHash]);
    }

    public function getValidPasswordReset(string $tokenHash) {
        $stmt = $this->db->prepare("
            SELECT email, token, created_at
            FROM password_resets
            WHERE token = ?
              AND created_at >= DATE_SUB(NOW(), INTERVAL 60 MINUTE)
            LIMIT 1
        ");
        $stmt->execute([$tokenHash]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePasswordResetToken(string $tokenHash): bool {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE token = ?");
        return $stmt->execute([$tokenHash]);
    }

    public function updatePasswordByEmail(string $email, string $passwordHash): bool {
        $stmt = $this->db->prepare("UPDATE nguoidung SET MatKhau = ? WHERE Email = ?");
        return $stmt->execute([$passwordHash, $email]);
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

    public function getUserByName(string $name) {
        $sql = "SELECT * FROM nguoidung WHERE HoTen = ? ORDER BY NgayTao DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([trim($name)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data) {
        $this->lastError = '';
        $userId = $data['id'] ?? '';
        $fullName = trim($data['HoTen'] ?? '');
        $phone = trim($data['SoDienThoai'] ?? '');
        $street = trim($data['SoNha_Duong'] ?? '');
        $ward = trim($data['PhuongXa'] ?? '');
        $district = trim($data['QuanHuyen'] ?? '');
        $province = trim($data['TinhThanh'] ?? '');

        if ($userId === '' || $fullName === '') {
            $this->lastError = 'Thiếu mã người dùng hoặc họ tên.';
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
            if ($stmt->rowCount() === 0 && !$this->getUserById($userId)) {
                throw new RuntimeException('Không tìm thấy tài khoản cần cập nhật.');
            }

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

            $this->lastError = $e->getMessage();
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

    private function columnExists(string $table, string $column): bool {
        static $cache = [];
        $key = $table . '.' . $column;

        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = ?
                  AND COLUMN_NAME = ?
            ");
            $stmt->execute([$table, $column]);
            $cache[$key] = ((int)$stmt->fetchColumn()) > 0;
        } catch (Throwable $e) {
            $cache[$key] = false;
        }

        return $cache[$key];
    }

    // Lấy toàn bộ danh sách người dùng kèm tên nhóm quyền
   public function getAllUsers($search = '') {
    // Thêm n.* để lấy tất cả các cột bao gồm TrangThai mới thêm
    $sql = "SELECT n.*, q.TenQuyen 
            FROM nguoidung n 
            JOIN nhomquyen q ON n.MaQuyen = q.MaQuyen";
    
    if (!empty($search)) {
        $sql .= " WHERE n.HoTen LIKE ? OR n.Email LIKE ? OR n.SoDienThoai LIKE ?";
        $stmt = $this->db->prepare($sql);
        $searchParam = "%$search%";
        $stmt->execute([$searchParam, $searchParam, $searchParam]);
    } else {
        $stmt = $this->db->query($sql);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Cập nhật quyền (Role)
    public function updateRole($userId, $newRole) {
        $sql = "UPDATE nguoidung SET MaQuyen = ? WHERE MaNguoiDung = ?";
        return $this->db->prepare($sql)->execute([$newRole, $userId]);
    }

    // Lấy danh sách nhóm quyền để đổ vào Select box
    public function getAllRoles() {
        return $this->db->query("SELECT * FROM nhomquyen")->fetchAll(PDO::FETCH_ASSOC);
    }
}
