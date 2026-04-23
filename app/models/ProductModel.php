<?php
class ProductModel extends Model
{

    public function getProductById($id)
    {

        $sql = "SELECT s.*, d.TenDanhMuc, t.TenThuongHieu, v.TenVatLieu 
                FROM sanpham s
                LEFT JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc
                LEFT JOIN thuonghieu t ON s.MaThuongHieu = t.MaThuongHieu
                LEFT JOIN vatlieu v ON s.MaVatLieu = v.MaVatLieu
                WHERE s.MaSanPham = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVariants($id)
    {
        $sql = "SELECT * FROM bienthesanpham WHERE MaSanPham = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductImages($id)
    {
        $sql = "SELECT DuongDan FROM hinhanhsanpham WHERE MaSanPham = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviews($productId)
    {
        $sql = "SELECT d.*, n.HoTen 
                FROM danhgia d
                JOIN nguoidung n ON d.MaNguoiDung = n.MaNguoiDung
                WHERE d.MaSanPham = ? AND d.TrangThai = 1
                ORDER BY d.NgayDanhGia DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts($category = '', $sort = '')
    {
        $sql = "SELECT * FROM sanpham WHERE 1=1";

        if ($category != '') {
            $sql .= " AND MaDanhMuc = :category";
        }

        if ($sort == 'price_asc') {
            $sql .= " ORDER BY GiaBan ASC";
        } elseif ($sort == 'price_desc') {
            $sql .= " ORDER BY GiaBan DESC";
        } else {
            $sql .= " ORDER BY MaSanPham DESC";
        }

        $stmt = $this->db->prepare($sql);

        if ($category != '') {
            $stmt->bindValue(':category', $category);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
