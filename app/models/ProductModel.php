<?php
class ProductModel extends Model {
    public function getProductById($id) {
        $sql = "SELECT s.*, d.TenDanhMuc, t.TenThuongHieu, v.TenVatLieu 
                FROM sanpham s
                LEFT JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc
                LEFT JOIN thuonghieu t ON s.MaThuongHieu = t.MaThuongHieu
                LEFT JOIN vatlieu v ON s.MaVatLieu = v.MaVatLieu
                WHERE s.MaSanPham = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function getVariants($id) {
        $sql = "SELECT * FROM bienthesanpham WHERE MaSanPham = ?";
        return $this->db->query($sql, [$id])->fetchAll();
    }

    public function getProductImages($id) {
        $sql = "SELECT DuongDan FROM hinhanhsanpham WHERE MaSanPham = ?";
        return $this->db->query($sql, [$id])->fetchAll();
    }
}