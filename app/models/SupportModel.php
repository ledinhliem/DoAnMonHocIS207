<?php

class SupportModel extends Model
{
    public function getFaqs(): array
    {
        return [
            [
                'question' => 'Làm sao để theo dõi đơn hàng?',
                'answer' => 'Bạn vào Lịch sử, chọn đơn hàng cần xem rồi bấm Theo dõi đơn để xem trạng thái mới nhất.',
            ],
            [
                'question' => 'Tôi có thể đổi địa chỉ giao hàng sau khi đặt không?',
                'answer' => 'Nếu đơn hàng chưa chuyển sang trạng thái đang giao, bạn hãy gửi câu hỏi hỗ trợ kèm mã đơn để admin kiểm tra và cập nhật.',
            ],
            [
                'question' => 'Khi nào tôi nhận được câu trả lời?',
                'answer' => 'Admin sẽ phản hồi trực tiếp trong mục Hỗ trợ khách hàng. Bạn có thể quay lại trang này để xem trạng thái câu hỏi.',
            ],
            [
                'question' => 'Tôi có thể hỏi về sản phẩm trước khi mua không?',
                'answer' => 'Có. Bạn có thể gửi câu hỏi riêng về sản phẩm, chính sách giao hàng hoặc đổi trả để admin trả lời.',
            ],
        ];
    }

    public function getQuestionsByUser(string $userId): array
    {
        if (!$this->tableExists()) {
            return [];
        }

        $stmt = $this->db->prepare("
            SELECT MaHoTro, MaNguoiDung, TieuDe, CauHoi, CauTraLoi, TrangThai, NgayGui, NgayTraLoi, MaAdmin
            FROM hotrokhachhang
            WHERE MaNguoiDung = ?
            ORDER BY NgayGui DESC, MaHoTro DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createQuestion(string $userId, string $title, string $question): bool
    {
        if (!$this->tableExists()) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO hotrokhachhang (MaHoTro, MaNguoiDung, TieuDe, CauHoi, TrangThai, NgayGui)
            VALUES (?, ?, ?, ?, 0, NOW())
        ");

        return $stmt->execute([
            $this->generateSupportId(),
            $userId,
            $title !== '' ? $title : null,
            $question,
        ]);
    }

    public function validateQuestion(array $data): array
    {
        $errors = [];
        $question = trim((string)($data['question'] ?? ''));
        $title = trim((string)($data['title'] ?? ''));

        if ($question === '') {
            $errors['question'] = 'Vui lòng nhập câu hỏi cần hỗ trợ.';
        } elseif (mb_strlen($question, 'UTF-8') < 10) {
            $errors['question'] = 'Câu hỏi cần ít nhất 10 ký tự để admin hiểu rõ hơn.';
        } elseif (mb_strlen($question, 'UTF-8') > 2000) {
            $errors['question'] = 'Câu hỏi không được vượt quá 2000 ký tự.';
        }

        if (mb_strlen($title, 'UTF-8') > 255) {
            $errors['title'] = 'Tiêu đề không được vượt quá 255 ký tự.';
        }

        return $errors;
    }

    private function generateSupportId(): string
    {
        $stmt = $this->db->query("
            SELECT MaHoTro
            FROM hotrokhachhang
            WHERE MaHoTro LIKE 'HT%'
            ORDER BY CAST(SUBSTRING(MaHoTro, 3) AS UNSIGNED) DESC
            LIMIT 1
        ");
        $lastId = $stmt->fetchColumn();
        $nextNumber = $lastId ? ((int)substr($lastId, 2)) + 1 : 1;

        return 'HT' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    private function tableExists(): bool
    {
        $stmt = $this->db->prepare("SHOW TABLES LIKE 'hotrokhachhang'");
        $stmt->execute();
        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
