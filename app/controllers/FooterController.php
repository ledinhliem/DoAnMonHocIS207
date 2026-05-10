<?php
/**
 * Routes được xử lý:
 *   ?url=ourstory       → app/views/static/ourstory.php
 *   ?url=sustainability → app/views/static/sustainability.php
 *   ?url=terms          → app/views/static/terms.php
 *   ?url=privacy        → app/views/static/privacy.php
 *   ?url=cookies        → app/views/static/cookies.php
 */

class FooterController extends Controller
{
    // ── Map route → [view file, meta] ────────────────────────────────────

    private array $pages = [
        'ourstory' => [
            'view' => 'static/ourstory',
            'meta' => [
                'title'      => 'Câu chuyện của chúng tôi | Zentro',
                'description'=> 'Hành trình xây dựng Zentro — nền tảng mua sắm bền vững hàng đầu Việt Nam.',
                'breadcrumb' => 'Our Story',
            ],
        ],
        'sustainability' => [
            'view' => 'static/sustainability',
            'meta' => [
                'title'      => 'Cam kết Bền vững | Zentro',
                'description'=> 'Zentro cam kết xây dựng một hệ thống thương mại bền vững, có trách nhiệm với môi trường và xã hội.',
                'breadcrumb' => 'Sustainability',
            ],
        ],
        'terms' => [
            'view' => 'static/terms',
            'meta' => [
                'title'      => 'Điều khoản Dịch vụ | Zentro',
                'description'=> 'Điều khoản sử dụng dịch vụ Zentro Sustainable Living.',
                'breadcrumb' => 'Điều khoản Dịch vụ',
            ],
        ],
        'privacy' => [
            'view' => 'static/privacy',
            'meta' => [
                'title'      => 'Chính sách Bảo mật | Zentro',
                'description'=> 'Chính sách bảo mật và quyền riêng tư của Zentro.',
                'breadcrumb' => 'Chính sách Bảo mật',
            ],
        ],
        'cookies' => [
            'view' => 'static/cookies',
            'meta' => [
                'title'      => 'Chính sách Cookie | Zentro',
                'description'=> 'Tìm hiểu cách Zentro sử dụng cookie để cải thiện trải nghiệm của bạn.',
                'breadcrumb' => 'Chính sách Cookie',
            ],
        ],
    ];

    // ── Entry point chính, gọi từ Router ─────────────────────────────────

    public function handle(string $page): void
    {
        if (!array_key_exists($page, $this->pages)) {
            $this->notFound();
            return;
        }

        $config = $this->pages[$page];
        $meta   = $config['meta'];

        $this->view($config['view'], compact('meta'));
    }

    // ── Shortcut methods (nếu router dùng dạng $controller->index()) ─────

    public function ourstory(): void       { $this->handle('ourstory'); }
    public function sustainability(): void { $this->handle('sustainability'); }
    public function terms(): void          { $this->handle('terms'); }
    public function privacy(): void        { $this->handle('privacy'); }
    public function cookies(): void        { $this->handle('cookies'); }

    // ── 404 fallback ─────────────────────────────────────────────────────

    private function notFound(): void
    {
        http_response_code(404);
        $this->view('errors/404');
    }
}