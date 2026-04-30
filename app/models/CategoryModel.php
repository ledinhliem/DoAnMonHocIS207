<?php
class CategoryModel extends Model
{
    public function getAll()
    {
        $sql = "SELECT * FROM danhmuc";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}