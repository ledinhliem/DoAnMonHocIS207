<?php

class NewsletterModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->ensureTable();
    }

    public function subscribe(string $email): array
    {
        $email = strtolower(trim($email));

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'Email không hợp lệ.',
            ];
        }

        $existing = $this->findByEmail($email);
        if ($existing) {
            return [
                'success' => true,
                'status' => 'exists',
                'message' => 'Email này đã đăng ký nhận bản tin.',
                'subscriber' => $existing,
            ];
        }

        $stmt = $this->db->prepare("
            INSERT INTO newsletter_subscribers (email, created_at)
            VALUES (?, NOW())
        ");

        $stmt->execute([$email]);

        return [
            'success' => true,
            'status' => 'created',
            'message' => 'Đăng ký nhận bản tin thành công.',
            'subscriber' => $this->findByEmail($email),
        ];
    }

    private function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, email, created_at
            FROM newsletter_subscribers
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);

        return $subscriber ?: null;
    }

    private function ensureTable(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }
}
