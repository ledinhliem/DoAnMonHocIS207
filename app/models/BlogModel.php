<?php
require_once __DIR__ . '/../../core/Database.php';

class BlogModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAll()
    {
        $sql = "SELECT 
                    MaBaiViet AS id,
                    TieuDe AS title,
                    NoiDung AS content,
                    HinhAnhBia AS image,
                    NgayDang AS created_at,
                    MaNguoiDung AS user_id
                FROM baiviet
                ORDER BY NgayDang DESC, MaBaiViet DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $blogs = $stmt->fetchAll();

        foreach ($blogs as &$blog) {
            $blog['excerpt'] = $this->makeExcerpt($blog['content']);
            $blog['category'] = 'Sustainability';
            $blog['image'] = $this->formatImagePath($blog['image']);
        }

        return $blogs;
    }

    public function getById($id)
    {
        $sql = "SELECT 
                    MaBaiViet AS id,
                    TieuDe AS title,
                    NoiDung AS content,
                    HinhAnhBia AS image,
                    NgayDang AS created_at,
                    MaNguoiDung AS user_id
                FROM baiviet
                WHERE MaBaiViet = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', trim((string)$id), PDO::PARAM_STR);
        $stmt->execute();

        $blog = $stmt->fetch();

        if (!$blog) {
            return null;
        }

        $blog['excerpt'] = $this->makeExcerpt($blog['content']);
        $blog['category'] = 'Sustainability';
        $blog['image'] = $this->formatImagePath($blog['image']);

        return $blog;
    }

    private function makeExcerpt($content, $length = 160)
    {
        $content = trim(strip_tags($content));

        if (mb_strlen($content, 'UTF-8') <= $length) {
            return $content;
        }

        return mb_substr($content, 0, $length, 'UTF-8') . '...';
    }

    private function formatImagePath($image)
    {
        return blog_image_url($image);
    }
}
