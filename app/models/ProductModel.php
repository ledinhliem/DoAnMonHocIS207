<?php
class ProductModel extends Model
{
    private $table = "sanpham";

    public function getAll($filters = [])
    {
        $sql = "SELECT s.*, d.TenDanhMuc, MIN(b.GiaTien) AS Gia, MIN(h.DuongDan) AS HinhAnh
        FROM sanpham s
        LEFT JOIN danhmuc d ON s.MaDanhMuc = d.MaDanhMuc
        LEFT JOIN bienthesanpham b ON s.MaSanPham = b.MaSanPham
        LEFT JOIN hinhanhsanpham h ON s.MaSanPham = h.MaSanPham
        WHERE 1=1";

        // keyword
        if (!empty($filters['keyword'])) {
            $keyword = $filters['keyword'];
            $sql .= " AND s.TenSanPham LIKE '%$keyword%'";
        }

        // category
        if (!empty($filters['category'])) {
            $category = $filters['category'];
            $sql .= " AND s.MaDanhMuc = '$category'";
        }

        // price
        if (!empty($filters['price_max'])) {
            $price = $filters['price_max'];
            $sql .= " AND b.GiaTien <= '$price'";
        }

        // impact
        if (!empty($filters['impact'])) {
            $impact = $filters['impact'];
            $sql .= " AND s.TacDongMoiTruong = '$impact'";
        }
        $sql .= " GROUP BY s.MaSanPham";

        // sort
        if (!empty($filters['sort'])) {

            if ($filters['sort'] == 'price_asc') {
                $sql .= " ORDER BY Gia ASC";
            } elseif ($filters['sort'] == 'price_desc') {
                $sql .= " ORDER BY Gia DESC";
            } elseif ($filters['sort'] == 'impact_desc') {
                $sql .= " ORDER BY s.TacDongMoiTruong DESC";
            } else {
                $sql .= " ORDER BY s.MaSanPham DESC";
            }

        }
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM sanpham WHERE MaSanPham = '$id'";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM danhmuc";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImpacts()
    {
        return [
            'Thân thiện' => 'Trung hòa carbon',
            'Không nhựa' => 'Không nhựa',
            'Tái chế' => 'Vật liệu tái chế nâng cấp',
        ];
    }
}