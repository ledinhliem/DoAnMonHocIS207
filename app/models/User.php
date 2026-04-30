<?php

class User extends Model
{
    public function getAllUsers()
    {
        $sql = "SELECT * FROM nguoidung";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}