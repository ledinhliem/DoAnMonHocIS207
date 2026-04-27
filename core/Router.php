<?php
class Router
{
    public function dispatch()
    {
        $url = $_GET['url'] ?? '';

        if (preg_match('#^product/(create|edit/.+|delete/.+)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->products();
            return;
        }

        if (preg_match('#^blog/(create|edit/.+|delete/.+)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->blog();
            return;
        }

        if (preg_match('#^promotion/(create|edit/.+|delete/.+)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->dashboard();
            return;
        }

        if (preg_match('#^(inventory/create|inventory/edit/.+|supplier/create|supplier/detail/.+|admin/suppliers)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->inventory();
            return;
        }

        switch ($url) {
            case '':
                require_once __DIR__ . '/../app/controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case 'product':
                require_once __DIR__ . '/../app/controllers/ProductController.php';
                $controller = new ProductController();
                $controller->index();
                break;

            case 'product/detail':
                require_once __DIR__ . '/../app/controllers/ProductController.php';
                $controller = new ProductController();
                $controller->detail();
                break;

            case 'product/search':
                require_once __DIR__ . '/../app/controllers/ProductController.php';
                $controller = new ProductController();
                $controller->search();
                break;

            case 'blog':
                require_once __DIR__ . '/../app/controllers/BlogController.php';
                $controller = new BlogController();
                $controller->index();
                break;

            case 'blog/detail':
                require_once __DIR__ . '/../app/controllers/BlogController.php';
                $controller = new BlogController();
                $controller->detail();
                break;

            case 'blog/subscribe':
                require_once __DIR__ . '/../app/controllers/BlogController.php';
                $controller = new BlogController();
                $controller->subscribe();
                break;

            case 'login':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->login();
                break;

            case 'register':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->register();
                break;

            case 'forgot-password':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->forgot();
                break;

            case 'reset-password':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->reset();
                break;

            case 'cart':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->index();
                break;

            case 'cart/add':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->add();
                break;

            case 'cart/update':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->update();
                break;

            case 'cart/remove':
                require_once __DIR__ . '/../app/controllers/CartController.php';
                $controller = new CartController();
                $controller->remove();
                break;

            case 'checkout':
            case 'order/checkout':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->checkout();
                break;

            case 'order/apply-promo':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->applyPromo();
                break;

            case 'order/payment':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->payment();
                break;

            case 'order/process-payment':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->processPayment();
                break;

            case 'order/transfer':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->transfer();
                break;

            case 'order/feedback':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->feedback();
                break;

            case 'order/submit-feedback':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->submitFeedback();
                break;

            case 'order/success':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->success();
                break;

            case 'order/history':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->history();
                break;

            case 'order/tracking':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->tracking();
                break;

            case 'order/help':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->help();
                break;

            case 'profile':
                require_once __DIR__ . '/../app/controllers/ProfileController.php';
                $controller = new ProfileController();
                $controller->index();
                break;

            case 'admin':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->dashboard();
                break;
            case 'admin/dashboard':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->dashboard();
                break;
            case 'admin/products':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->products();
                break;

            case 'admin/orders':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->orders();
                break;

            case 'admin/inventory':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->inventory();
                break;

            case 'admin/reviews':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->reviews();
                break;

            case 'admin/blog':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->blog();
                break;

            case 'admin/settings':
                require_once __DIR__ . '/../app/controllers/AdminController.php';
                $controller = new AdminController();
                $controller->dashboard();
                break;

            case 'auth/google':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->googleLogin();
                break;

            case 'auth/apple':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->appleLogin();
                break;

            default:
                echo '404 - Không tìm thấy trang';
                break;
        }
    }
}
