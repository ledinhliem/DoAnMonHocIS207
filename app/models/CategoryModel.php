<?php
class CategoryModel extends Model
{
    public function getAll()
    {
        $sql = "SELECT * FROM danhmuc WHERE COALESCE(TrangThai, 1) = 1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
