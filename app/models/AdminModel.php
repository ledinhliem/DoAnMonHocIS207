<?php

class AdminModel extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT 
                    bv.MaBaiViet,
                    bv.TieuDe,
                    bv.NoiDung,
                    bv.HinhAnhBia,
                    bv.NgayDang,
                    bv.MaNguoiDung,
                    nd.HoTen AS TenTacGia
                FROM baiviet bv
                LEFT JOIN nguoidung nd ON bv.MaNguoiDung = nd.MaNguoiDung
                ORDER BY bv.NgayDang DESC, bv.MaBaiViet DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $sql = "SELECT 
                    MaBaiViet,
                    TieuDe,
                    NoiDung,
                    HinhAnhBia,
                    NgayDang,
                    MaNguoiDung
                FROM baiviet
                WHERE MaBaiViet = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPost($data)
    {
        $sql = "INSERT INTO baiviet (TieuDe, NoiDung, HinhAnhBia, NgayDang, MaNguoiDung)
                VALUES (?, ?, ?, NOW(), ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['TieuDe'],
            $data['NoiDung'],
            $data['HinhAnhBia'],
            $data['MaNguoiDung']
        ]);
    }

    public function updatePost($id, $data)
    {
        $sql = "UPDATE baiviet
                SET TieuDe = ?,
                    NoiDung = ?,
                    HinhAnhBia = ?
                WHERE MaBaiViet = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['TieuDe'],
            $data['NoiDung'],
            $data['HinhAnhBia'],
            $id
        ]);
    }

    public function deletePost($id)
    {
        $sql = "DELETE FROM baiviet WHERE MaBaiViet = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function getAllPromos()
    {
        $sql = "SELECT 
                    MaGiamGia,
                    MaCode,
                    PhamTramGiam,
                    SoLuong,
                    NgayHetHan
                FROM magiamgia
                ORDER BY NgayHetHan DESC, MaGiamGia DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPromoById($id)
    {
        $sql = "SELECT 
                    MaGiamGia,
                    MaCode,
                    PhamTramGiam,
                    SoLuong,
                    NgayHetHan
                FROM magiamgia
                WHERE MaGiamGia = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPromo($data)
    {
        $sql = "INSERT INTO magiamgia (MaCode, PhamTramGiam, SoLuong, NgayHetHan)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['MaCode'],
            $data['PhamTramGiam'],
            $data['SoLuong'],
            $data['NgayHetHan']
        ]);
    }

    public function updatePromo($id, $data)
    {
        $sql = "UPDATE magiamgia
                SET MaCode = ?,
                    PhamTramGiam = ?,
                    SoLuong = ?,
                    NgayHetHan = ?
                WHERE MaGiamGia = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['MaCode'],
            $data['PhamTramGiam'],
            $data['SoLuong'],
            $data['NgayHetHan'],
            $id
        ]);
    }

    public function deletePromo($id)
    {
        $sql = "DELETE FROM magiamgia WHERE MaGiamGia = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function promoCodeExists($code, $ignoreId = null)
    {
        if ($ignoreId) {
            $sql = "SELECT MaGiamGia FROM magiamgia WHERE MaCode = ? AND MaGiamGia != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$code, $ignoreId]);
        } else {
            $sql = "SELECT MaGiamGia FROM magiamgia WHERE MaCode = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$code]);
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}