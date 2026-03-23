<?php

class ProductModel extends Model
{
    public function getAllProducts()
    {
        $sql = "
            SELECT 
                sp.MaSanPham,
                sp.TenSanPham,
                sp.MoTa,
                sp.DiemXanh,
                sp.TrangThai,
                dm.TenDanhMuc,
                th.TenThuongHieu,
                vl.TenVatLieu,
                MIN(bt.GiaTien) AS GiaTu,
                MIN(ha.DuongDan) AS HinhAnh
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDanhMuc = dm.MaDanhMuc
            LEFT JOIN thuonghieu th ON sp.MaThuongHieu = th.MaThuongHieu
            LEFT JOIN vatlieu vl ON sp.MaVatLieu = vl.MaVatLieu
            LEFT JOIN bienthesanpham bt ON sp.MaSanPham = bt.MaSanPham
            LEFT JOIN hinhanhsanpham ha ON sp.MaSanPham = ha.MaSanPham
            GROUP BY 
                sp.MaSanPham, sp.TenSanPham, sp.MoTa, sp.DiemXanh, sp.TrangThai,
                dm.TenDanhMuc, th.TenThuongHieu, vl.TenVatLieu
            ORDER BY sp.MaSanPham DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductById($id)
    {
        $sql = "
            SELECT 
                sp.*,
                dm.TenDanhMuc,
                th.TenThuongHieu,
                vl.TenVatLieu
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDanhMuc = dm.MaDanhMuc
            LEFT JOIN thuonghieu th ON sp.MaThuongHieu = th.MaThuongHieu
            LEFT JOIN vatlieu vl ON sp.MaVatLieu = vl.MaVatLieu
            WHERE sp.MaSanPham = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getProductImages($productId)
    {
        $sql = "
            SELECT MaHinhAnh, MaSanPham, DuongDan
            FROM hinhanhsanpham
            WHERE MaSanPham = :productId
            ORDER BY MaHinhAnh ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getProductVariants($productId)
    {
        $sql = "
            SELECT MaBienThe, MaSanPham, MauSac, KichThuoc, GiaTien, SoLuongTon
            FROM bienthesanpham
            WHERE MaSanPham = :productId
            ORDER BY GiaTien ASC, MaBienThe ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getProductCertificates($productId)
    {
        $sql = "
            SELECT 
                cn.MaChungNhan,
                cn.TenChungNhan,
                cn.Logo,
                cn.MoTa,
                cn.ToChucCap
            FROM sanpham_chungnhan spcn
            INNER JOIN chungnhan cn ON spcn.MaChungNhan = cn.MaChungNhan
            WHERE spcn.MaSanPham = :productId
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}