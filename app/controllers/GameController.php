<?php

require_once __DIR__ . '/../models/GameModel.php';

class GameController extends Controller
{
    private GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    public function play(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=');
            exit;
        }

        if (empty($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để chơi nhận voucher.';
            header('Location: ?url=login');
            exit;
        }

        $result = $this->gameModel->play((string)$_SESSION['user_id']);

        $_SESSION['game_result_popup'] = $this->buildResultPopup($result);
        $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?url=cart'));
        exit;
    }

    public function spin(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để chơi nhận voucher.',
                'login_url' => BASE_URL . '?url=login',
            ]);
            exit;
        }

        $result = $this->gameModel->play((string)$_SESSION['user_id']);

        echo json_encode([
            'success' => $result['success'],
            'message' => $result['message'],
            'reward' => $result['reward'] ?? null,
            'voucher_code' => $result['voucher_code'] ?? null,
            'popup' => $this->buildResultPopup($result),
        ]);
        exit;
    }

    public function rewards(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $rewards = array_map(function ($reward) {
            return [
                'key' => $reward['type'] ?? '',
                'label' => $reward['label'] ?? '',
            ];
        }, $this->gameModel->getActiveRewards());

        echo json_encode([
            'success' => true,
            'rewards' => $rewards,
        ]);
        exit;
    }

    private function buildResultPopup(array $result): array
    {
        $code = $result['voucher_code'] ?? null;

        if (!empty($result['success']) && !empty($code)) {
            return [
                'status' => 'win',
                'code' => $code,
                'title' => 'Chúc mừng bạn!',
                'message' => 'Bạn đã trúng voucher ' . $code . ' - ' . $this->voucherDescription((string)$code) . '.',
                'redirect_url' => '?url=cart',
            ];
        }

        if (!empty($result['success'])) {
            return [
                'status' => 'lose',
                'code' => null,
                'title' => 'Tiếc quá!',
                'message' => 'Hôm nay bạn chưa trúng voucher. Mai quay lại thử vận may nhé!',
                'redirect_url' => '',
            ];
        }

        return [
            'status' => 'already_played',
            'code' => $code,
            'title' => 'Bạn đã quay hôm nay rồi',
            'message' => !empty($code)
                ? 'Voucher hôm nay của bạn là ' . $code . '. Hãy dùng trong giỏ hàng nhé!'
                : 'Mai quay lại thử vận may nhé!',
            'redirect_url' => !empty($code) ? '?url=cart' : '',
        ];
    }

    private function voucherDescription(string $code): string
    {
        return match ($code) {
            'GAME5' => 'giảm 5% cho đơn hàng tiếp theo',
            'GAME10' => 'giảm 10% cho đơn hàng tiếp theo',
            'FREESHIP' => 'miễn phí vận chuyển cho đơn hàng tiếp theo',
            default => 'ưu đãi cho đơn hàng tiếp theo',
        };
    }
}
