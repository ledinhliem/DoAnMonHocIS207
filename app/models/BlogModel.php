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
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
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
        if (empty($image)) {
            return 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80';
        }

        if (str_starts_with($image, 'http')) {
            return $image;
        }

        $imageMap = [
            'BL001_ZeroWaste.jpg' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80',
            'BL002_VaiSoiCafe.webp' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80',
            'BL003_HatViNhua.jpg' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=1200&q=80',
        ];

        return $imageMap[$image] ?? 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80';
    }
}