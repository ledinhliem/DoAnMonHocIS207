<?php

class VoucherModel extends Model
{
    public function getUserVouchers(string $userId): array
    {
        if ($userId === '') {
            return [];
        }

        try {
            $stmt = $this->db->prepare("
                SELECT uv.voucher_code AS MaGiamGia,
                       uv.source,
                       uv.status,
                       m.PhamTramGiam,
                       m.NgayHetHan,
                       CASE
                           WHEN uv.voucher_code = 'FREESHIP' THEN 'Miễn phí vận chuyển cho đơn hàng này'
                           ELSE CONCAT('Giảm ', m.PhamTramGiam, '% từ phần thưởng của bạn')
                       END AS MoTa
                FROM user_vouchers uv
                JOIN magiamgia m ON m.MaCode = uv.voucher_code
                WHERE uv.user_id = ?
                  AND uv.status = 'unused'
                  AND (m.NgayHetHan IS NULL OR m.NgayHetHan >= CURDATE())
                  AND m.SoLuong > 0
                ORDER BY uv.created_at DESC
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }
    }

    public function markUsed(string $userId, string $code): void
    {
        if ($userId === '' || $code === '') {
            return;
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE user_vouchers
                SET status = 'used', used_at = NOW()
                WHERE user_id = ? AND voucher_code = ? AND status = 'unused'
            ");
            $stmt->execute([$userId, $code]);
        } catch (Throwable $e) {
            return;
        }
    }
}
