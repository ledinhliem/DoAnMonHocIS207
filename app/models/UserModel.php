<?php
/**
 * UserModel - Model cho quản lý người dùng
 * 
 * Sử dụng dữ liệu giả (mock data) để mô phỏng các bảng NguoiDung và DiaChi
 * Chưa kết nối với database thực tế (Tuần 1)
 */

class UserModel extends Model
{
    /**
     * Dữ liệu giả cho bảng NguoiDung (Người Dùng)
     * Bao gồm: id, email, password, hoTen, soDienThoai, ngaySinh, gioiTinh
     */
    private $users = [
        [
            'id' => 1,
            'email' => 'test@example.com',
            'password' => 'password123',  // Mật khẩu giả (Week 1 chưa hash)
            'hoTen' => 'Nguyễn Văn A',
            'soDienThoai' => '0912345678',
            'ngaySinh' => '1990-05-15',
            'gioiTinh' => 'Nam'
        ],
        [
            'id' => 2,
            'email' => 'user2@example.com',
            'password' => 'password456',
            'hoTen' => 'Trần Thị B',
            'soDienThoai' => '0987654321',
            'ngaySinh' => '1995-10-20',
            'gioiTinh' => 'Nữ'
        ],
        [
            'id' => 3,
            'email' => 'user3@example.com',
            'password' => 'password789',
            'hoTen' => 'Lê Minh C',
            'soDienThoai' => '0909876543',
            'ngaySinh' => '1988-03-08',
            'gioiTinh' => 'Nam'
        ]
    ];

    /**
     * Dữ liệu giả cho bảng DiaChi (Địa Chỉ)
     * Bao gồm: id, userId, tenDuong, thanhPho, quanHuyen, maSo, trangThai
     */
    private $addresses = [
        [
            'id' => 1,
            'userId' => 1,
            'tenDuong' => '123 Đường Nguyễn Huệ',
            'thanhPho' => 'TP Hồ Chí Minh',
            'quanHuyen' => 'Quận 1',
            'maSo' => '70000',
            'trangThai' => 'Mặc định'
        ],
        [
            'id' => 2,
            'userId' => 1,
            'tenDuong' => '456 Đường Lê Lợi',
            'thanhPho' => 'TP Hồ Chí Minh',
            'quanHuyen' => 'Quận 1',
            'maSo' => '70000',
            'trangThai' => 'Phụ'
        ],
        [
            'id' => 3,
            'userId' => 1,
            'tenDuong' => '789 Đường Trần Hưng Đạo',
            'thanhPho' => 'Thành phố Hải Phòng',
            'quanHuyen' => 'Quận Hải An',
            'maSo' => '180000',
            'trangThai' => 'Phụ'
        ],
        [
            'id' => 4,
            'userId' => 2,
            'tenDuong' => '321 Đường Hai Bà Trưng',
            'thanhPho' => 'TP Hà Nội',
            'quanHuyen' => 'Quận Hoàn Kiếm',
            'maSo' => '100000',
            'trangThai' => 'Mặc định'
        ],
        [
            'id' => 5,
            'userId' => 3,
            'tenDuong' => '654 Đường Đinh Tiên Hoàng',
            'thanhPho' => 'TP Đà Nẵng',
            'quanHuyen' => 'Quận Hải Châu',
            'maSo' => '550000',
            'trangThai' => 'Mặc định'
        ]
    ];

    /**
     * Xử lý đăng nhập người dùng
     * 
     * @param string $email Email người dùng
     * @param string $password Mật khẩu người dùng
     * @return array|false Trả về thông tin người dùng (không bao gồm password) hoặc false nếu đăng nhập thất bại
     */
    public function login($email, $password)
    {
        // Kiểm tra xem email có tồn tại trong dữ liệu giả không
        foreach ($this->users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                // Trả về thông tin người dùng (trừ password)
                return [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'hoTen' => $user['hoTen'],
                    'soDienThoai' => $user['soDienThoai'],
                    'ngaySinh' => $user['ngaySinh'],
                    'gioiTinh' => $user['gioiTinh']
                ];
            }
        }

        // Nếu không tìm thấy, trả về false
        return false;
    }

    /**
     * Lấy thông tin cá nhân của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return array|null Trả về thông tin người dùng hoặc null nếu không tìm thấy
     */
    public function getUserProfile($userId)
    {
        // Tìm kiếm người dùng theo ID
        foreach ($this->users as $user) {
            if ($user['id'] == $userId) {
                // Trả về thông tin đầy đủ (không bao gồm password)
                return [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'hoTen' => $user['hoTen'],
                    'soDienThoai' => $user['soDienThoai'],
                    'ngaySinh' => $user['ngaySinh'],
                    'gioiTinh' => $user['gioiTinh']
                ];
            }
        }

        // Nếu không tìm thấy, trả về null
        return null;
    }

    /**
     * Lấy danh sách địa chỉ của người dùng
     * 
     * @param int $userId ID của người dùng
     * @return array Trả về mảng các địa chỉ hoặc mảng rỗng nếu không có
     */
    public function getUserAddresses($userId)
    {
        $userAddresses = [];

        // Lọc các địa chỉ theo userId
        foreach ($this->addresses as $address) {
            if ($address['userId'] == $userId) {
                $userAddresses[] = $address;
            }
        }

        // Trả về danh sách địa chỉ (có thể là mảng rỗng)
        return $userAddresses;
    }
}
