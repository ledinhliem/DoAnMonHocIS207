<?php
// core/Database.php

// 1. Định nghĩa hằng số an toàn
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_PORT')) define('DB_PORT', '3306');
if (!defined('DB_NAME')) define('DB_NAME', 'sustainable_shop');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

class Database
{
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $conn;

    public function connect()
    {
        if ($this->conn == null) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Kết nối database thất bại: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}

// 2. Tạo hàm db() dùng chung để fix lỗi "Call to undefined function db()"
if (!function_exists('db')) {
    function db() {
        static $database = null;
        if ($database === null) {
            $database = new Database();
        }
        return $database->connect();
    }
}