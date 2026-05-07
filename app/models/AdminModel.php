<?php

class AdminModel
{
    private $db;

    public function __construct()
    {
        $this->db = db();
    }

    // =========================================================
    // REVIEWS — danhgia
    // =========================================================

    /**
     * Lấy danh sách đánh giá, có thể lọc theo trạng thái và từ khóa.
     * TrangThai: 1 = Hiện/Duyệt, 0 = Ẩn/Chờ duyệt (theo Admin Flow)
     */
    public function getReviews(string $keyword = '', string $tab = 'all'): array
    {
        $sql = "SELECT dg.*, nd.HoTen AS TenNguoiDung, sp.TenSanPham
                FROM danhgia dg
                LEFT JOIN nguoidung nd ON dg.MaNguoiDung = nd.MaNguoiDung
                LEFT JOIN sanpham sp ON dg.MaSanPham = sp.MaSanPham
                WHERE 1=1";

        $params = [];

        if ($tab === 'pending') {
            $sql .= " AND dg.TrangThai = 0";
        } elseif ($tab === 'approved') {
            $sql .= " AND dg.TrangThai = 1";
        }

        if ($keyword !== '') {
            $sql .= " AND (nd.HoTen LIKE :kw OR sp.TenSanPham LIKE :kw2 OR dg.NoiDung LIKE :kw3)";
            $params[':kw']  = "%$keyword%";
            $params[':kw2'] = "%$keyword%";
            $params[':kw3'] = "%$keyword%";
        }

        $sql .= " ORDER BY dg.NgayDanhGia DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Duyệt đánh giá (TrangThai = 1)
     */
    public function approveReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE danhgia SET TrangThai = 1 WHERE MaDanhGia = ?"
        );
        return $stmt->execute([$maDanhGia]);
    }

    /**
     * Ẩn đánh giá (TrangThai = 0)
     */
    public function hideReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE danhgia SET TrangThai = 0 WHERE MaDanhGia = ?"
        );
        return $stmt->execute([$maDanhGia]);
    }

    /**
     * Xóa đánh giá khỏi DB (chỉ dùng nếu admin chắc chắn)
     */
    public function deleteReview(string $maDanhGia): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM danhgia WHERE MaDanhGia = ?"
        );
        return $stmt->execute([$maDanhGia]);
    }

    /**
     * Lưu phản hồi admin cho một đánh giá
     */
    public function saveAdminReply(string $maDanhGia, string $reply): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE danhgia SET PhanHoiAdmin = ? WHERE MaDanhGia = ?"
        );
        return $stmt->execute([trim($reply), $maDanhGia]);
    }

    // =========================================================
    // INVENTORY — bienthesanpham + nhacungcap + phieunhap
    // =========================================================

    /**
     * Lấy danh sách tồn kho biến thể, join với tên sản phẩm.
     * Hỗ trợ lọc theo từ khóa tên sản phẩm.
     */
    public function getInventory(string $keyword = ''): array
    {
        $sql = "SELECT bt.*, sp.TenSanPham
                FROM bienthesanpham bt
                LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
                WHERE 1=1";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND (sp.TenSanPham LIKE :kw OR bt.MauSac LIKE :kw2 OR bt.KichThuoc LIKE :kw3)";
            $params[':kw']  = "%$keyword%";
            $params[':kw2'] = "%$keyword%";
            $params[':kw3'] = "%$keyword%";
        }

        $sql .= " ORDER BY sp.TenSanPham ASC, bt.MaBienThe ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Cập nhật SoLuongTon cho một biến thể
     */
    public function updateStock(string $maBienThe, int $soLuong): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE bienthesanpham SET SoLuongTon = ? WHERE MaBienThe = ?"
        );
        return $stmt->execute([$soLuong, $maBienThe]);
    }

    /**
     * Kiểm tra biến thể có tồn tại trong chitietdonhang chưa.
     * Trả về true nếu đã bán → không cho xóa cứng.
     */
    public function variantHasOrders(string $maBienThe): bool
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM chitietdonhang WHERE MaBienThe = ?"
        );
        $stmt->execute([$maBienThe]);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Xóa cứng biến thể — chỉ gọi sau khi đã kiểm tra variantHasOrders() = false
     */
    public function deleteVariant(string $maBienThe): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM bienthesanpham WHERE MaBienThe = ?"
        );
        return $stmt->execute([$maBienThe]);
    }

    /**
     * Lấy danh sách nhà cung cấp
     */
    public function getSuppliers(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM nhacungcap ORDER BY TenNCC ASC"
        );
        return $stmt->fetchAll();
    }

    /**
     * Lấy danh sách phiếu nhập, join với tên nhà cung cấp
     */
    public function getImportReceipts(): array
    {
        $sql = "SELECT pn.*, ncc.TenNCC
                FROM phieunhap pn
                LEFT JOIN nhacungcap ncc ON pn.MaNCC = ncc.MaNCC
                ORDER BY pn.NgayNhap DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Thêm nhà cung cấp mới
     */
    public function addSupplier(string $tenNCC, string $soDienThoai, string $diaChi): bool
    {
        // Sinh mã tự động NCC + số thứ tự
        $stmt = $this->db->query("SELECT COUNT(*) FROM nhacungcap");
        $count = (int)$stmt->fetchColumn() + 1;
        $maNCC = 'NCC' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $stmt = $this->db->prepare(
            "INSERT INTO nhacungcap (MaNCC, TenNCC, SoDienThoai, DiaChi) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$maNCC, $tenNCC, $soDienThoai, $diaChi]);
    }

    // =========================================================
    // VARIANT - thêm/bớt biến thể sản phẩm, cập nhật tồn kho
    // =========================================================

    /**
     * Lấy danh sách biến thể của một sản phẩm, join với tên sản phẩm.
     */
    public function getVariantsByProduct(string $maSanPham): array
    {
        $stmt = $this->db->prepare(
            "SELECT bt.*, sp.TenSanPham
            FROM bienthesanpham bt
            LEFT JOIN sanpham sp ON bt.MaSanPham = sp.MaSanPham
            WHERE bt.MaSanPham = ?
            ORDER BY bt.MaBienThe ASC"
        );
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll();
    }

    /**
     * Thêm biến thể mới
     */
    public function addVariant(string $maSanPham, string $mauSac, string $kichThuoc,
                            float $giaTien, int $soLuong): bool
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM bienthesanpham WHERE MaSanPham = ?");
        // Sinh MaBienThe tự động
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM bienthesanpham");
        $stmt->execute();
        $count = (int)$stmt->fetchColumn() + 1;
        $maBienThe = 'BT' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $stmt = $this->db->prepare(
            "INSERT INTO bienthesanpham (MaBienThe, MaSanPham, MauSac, KichThuoc, GiaTien, SoLuongTon)
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$maBienThe, $maSanPham, $mauSac, $kichThuoc, $giaTien, $soLuong]);
    }

    /**
     * Cập nhật thông tin biến thể (màu sắc, kích thước, giá tiền, tồn kho)
     */
    public function updateVariant(string $maBienThe, string $mauSac, string $kichThuoc,
                               float $giaTien, int $soLuong): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE bienthesanpham SET MauSac=?, KichThuoc=?, GiaTien=?, SoLuongTon=?
            WHERE MaBienThe = ?"
        );
        return $stmt->execute([$mauSac, $kichThuoc, $giaTien, $soLuong, $maBienThe]);
    }

    // --------------------------------------------------------
    // GALLERY
    // --------------------------------------------------------

    /**
     * Lấy danh sách ảnh của một sản phẩm, sắp xếp theo MaHinhAnh.
     */
    public function getGallery(string $maSanPham): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM hinhanhsanpham WHERE MaSanPham = ? ORDER BY MaHinhAnh ASC"
        );
        $stmt->execute([$maSanPham]);
        return $stmt->fetchAll();
    }

    /**
     * Tải lên ảnh cho một sản phẩm.
     */
    public function uploadGalleryImage(string $maSanPham, array $file): bool
    {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) return false;

        $filename = uniqid('img_') . '.' . $ext;
        $dest = __DIR__ . '/../../public/uploads/products/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) return false;

        $stmt = $this->db->prepare(
            "INSERT INTO hinhanhsanpham (MaSanPham, DuongDanAnh) VALUES (?, ?)"
        );
        return $stmt->execute([$maSanPham, 'public/uploads/products/' . $filename]);
    }

    /**
     * Xóa ảnh khỏi thư viện của một sản phẩm.
     */
    public function deleteGalleryImage(string $maAnh): bool
    {
        // Lấy đường dẫn để xóa file vật lý
        $stmt = $this->db->prepare("SELECT DuongDanAnh FROM hinhanhsanpham WHERE MaHinhAnh = ?");
        $stmt->execute([$maAnh]);
        $row = $stmt->fetch();
        if ($row && file_exists(__DIR__ . '/../../' . $row['DuongDanAnh'])) {
            unlink(__DIR__ . '/../../' . $row['DuongDanAnh']);
        }

        $stmt = $this->db->prepare("DELETE FROM hinhanhsanpham WHERE MaHinhAnh = ?");
        return $stmt->execute([$maAnh]);
    }
}