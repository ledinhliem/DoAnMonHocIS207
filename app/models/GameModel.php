<?php

class GameModel extends Model
{
    private array $rewardPool = [
        ['type' => 'none_1', 'code' => null, 'label' => 'Chúc bạn may mắn lần sau', 'weight' => 16],
        ['type' => 'percent_5_a', 'code' => 'GAME5', 'label' => 'Giảm 5%', 'weight' => 14],
        ['type' => 'none_2', 'code' => null, 'label' => 'Thêm một lượt xanh ngày mai', 'weight' => 14],
        ['type' => 'percent_10_a', 'code' => 'GAME10', 'label' => 'Giảm 10%', 'weight' => 8],
        ['type' => 'free_ship_a', 'code' => 'FREESHIP', 'label' => 'Miễn phí ship', 'weight' => 8],
        ['type' => 'none_3', 'code' => null, 'label' => 'Gần trúng rồi', 'weight' => 12],
        ['type' => 'percent_5_b', 'code' => 'GAME5', 'label' => 'Giảm 5%', 'weight' => 12],
        ['type' => 'none_4', 'code' => null, 'label' => 'May mắn lần sau', 'weight' => 8],
        ['type' => 'percent_10_b', 'code' => 'GAME10', 'label' => 'Giảm 10%', 'weight' => 5],
        ['type' => 'free_ship_b', 'code' => 'FREESHIP', 'label' => 'Miễn phí ship', 'weight' => 3],
    ];

    public function getTodayPlay(string $userId): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT *
                FROM game_plays
                WHERE user_id = ? AND play_date = CURDATE()
                LIMIT 1
            ");
            $stmt->execute([$userId]);
            $play = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return null;
        }

        return $play ?: null;
    }

    public function play(string $userId): array
    {
        if ($userId === '') {
            return ['success' => false, 'message' => 'Vui lòng đăng nhập để chơi.', 'reward' => null];
        }

        $todayPlay = $this->getTodayPlay($userId);
        if ($todayPlay) {
            return [
                'success' => false,
                'message' => 'Bạn đã chơi hôm nay rồi. Hãy quay lại vào ngày mai.',
                'reward' => $todayPlay['reward_type'] ?? null,
                'voucher_code' => $todayPlay['voucher_code'] ?? null,
            ];
        }

        $reward = $this->drawReward();

        try {
            $stmt = $this->db->prepare("
                INSERT INTO game_plays (user_id, play_date, reward_type, voucher_code)
                VALUES (?, CURDATE(), ?, ?)
            ");
            $stmt->execute([$userId, $reward['type'], $reward['code']]);

            if (!empty($reward['code'])) {
                $this->saveUserVoucher($userId, $reward['code']);
            }
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Chưa thể lưu lượt chơi. Vui lòng kiểm tra SQL game_plays/user_vouchers.',
                'reward' => null,
            ];
        }

        return [
            'success' => true,
            'message' => $reward['code']
                ? 'Chúc mừng! Bạn nhận được voucher ' . $reward['label'] . ': ' . $reward['code']
                : 'Rất tiếc, lượt này chưa trúng voucher. Hẹn bạn ngày mai!',
            'reward' => $reward['type'],
            'voucher_code' => $reward['code'],
        ];
    }

    private function drawReward(): array
    {
        $rewardPool = $this->getActiveRewards();
        $totalWeight = array_sum(array_column($rewardPool, 'weight'));
        $roll = random_int(1, max(1, $totalWeight));
        $cursor = 0;

        foreach ($rewardPool as $reward) {
            $cursor += $reward['weight'];
            if ($roll <= $cursor) {
                return $reward;
            }
        }

        return $rewardPool[0];
    }

    public function getActiveRewards(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT reward_key AS type, voucher_code AS code, label, weight, sort_order
                FROM game_rewards
                WHERE status = 1
                ORDER BY sort_order ASC, id ASC
            ");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return $this->rewardPool;
        }

        if (empty($rows)) {
            return $this->rewardPool;
        }

        return array_map(function ($reward) {
            return [
                'type' => (string)($reward['type'] ?? ''),
                'code' => ($reward['code'] ?? '') !== '' ? (string)$reward['code'] : null,
                'label' => (string)($reward['label'] ?? ''),
                'weight' => max(1, (int)($reward['weight'] ?? 1)),
            ];
        }, $rows);
    }

    private function saveUserVoucher(string $userId, string $code): void
    {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO user_vouchers (user_id, voucher_code, source, status)
            VALUES (?, ?, 'game', 'unused')
        ");
        $stmt->execute([$userId, $code]);
    }
}
