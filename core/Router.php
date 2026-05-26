<?php

class Router
{
    public function dispatch()
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');

        if (preg_match('#^admin/blog/(create|edit/.+|delete/.+)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->blog();
            return;
        }

        if (preg_match('#^admin/promo/(create|edit/.+|delete/.+|flash-delete/.+)$#', $url)) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->promo();
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN ROUTE ALIASES
        |--------------------------------------------------------------------------
        | Các route admin con vẫn đi qua AdminController.
        | Ví dụ:
        | admin/products/create  -> AdminController::products()
        | admin/categories/edit  -> AdminController::categories()
        | admin/orders/detail    -> AdminController::orderDetail()
        */

        $adminRoutes = [
            'admin' => 'dashboard',
            'admin/dashboard' => 'dashboard',

            'admin/products' => 'products',
            'admin/products/create' => 'products',
            'admin/products/edit' => 'products',
            'admin/products/hide' => 'products',
            'admin/products/show' => 'products',
            'admin/products/delete' => 'products',

            'admin/categories' => 'categories',
            'admin/categories/create' => 'categories',
            'admin/categories/edit' => 'categories',
            'admin/categories/delete' => 'categories',

            'admin/products/variants' => 'variants',
            'admin/products/gallery' => 'gallery',

            'admin/inventory' => 'inventory',
            'admin/reviews' => 'reviews',

            'admin/users' => 'users',
            'admin/users/detail' => 'userDetail',
            'admin/users/edit' => 'userDetail',
            'admin/users/update-role' => 'updateUserRole',

            'admin/orders' => 'orders',
            'admin/orders/detail' => 'orderDetail',
            'admin/orders/update-status' => 'updateOrderStatus',

            'admin/blog' => 'blog',
            'admin/blog/create' => 'blog',
            'admin/blog/edit' => 'blog',
            'admin/blog/delete' => 'blog',

            'admin/promo' => 'promo',
            'admin/promo/create' => 'promo',
            'admin/promo/edit' => 'promo',
            'admin/promo/delete' => 'promo',
            'admin/promo/flash-delete' => 'promo',

            'admin/settings' => 'dashboard',
        ];

        if (isset($adminRoutes[$url])) {
            require_once __DIR__ . '/../app/controllers/AdminController.php';

            $controller = new AdminController();
            $method = $adminRoutes[$url];

            if (method_exists($controller, $method)) {
                $controller->$method();
                return;
            }

            echo '404 - Không tìm thấy method admin';
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | LEGACY ADMIN-LIKE ROUTES
        |--------------------------------------------------------------------------
        | Giữ lại một số route cũ nếu project từng dùng.
        */

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

        /*
        |--------------------------------------------------------------------------
        | USER ROUTES
        |--------------------------------------------------------------------------
        */

        switch ($url) {
            case '':
                require_once __DIR__ . '/../app/controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case 'product':
            case 'product/shop':
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

            case 'logout':
                require_once __DIR__ . '/../app/controllers/AuthController.php';
                $controller = new AuthController();
                $controller->logout();
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

            case 'game/play':
                require_once __DIR__ . '/../app/controllers/GameController.php';
                $controller = new GameController();
                $controller->play();
                break;

            case 'game/spin':
                require_once __DIR__ . '/../app/controllers/GameController.php';
                $controller = new GameController();
                $controller->spin();
                break;

            case 'game/rewards':
                require_once __DIR__ . '/../app/controllers/GameController.php';
                $controller = new GameController();
                $controller->rewards();
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

            case 'profile/edit':
                require_once __DIR__ . '/../app/controllers/ProfileController.php';
                $controller = new ProfileController();
                $controller->edit();
                break;

            case 'profile/update':
                require_once __DIR__ . '/../app/controllers/ProfileController.php';
                $controller = new ProfileController();
                $controller->update();
                break;
            case 'ourstory':
            case 'sustainability':
            case 'terms':
            case 'privacy':
            case 'cookies':
                require_once __DIR__ . '/../app/controllers/FooterController.php';
                $controller = new FooterController();
                $controller->handle($url);
                break;
            case 'order/pending-notification':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->pendingNotification();
                break;
 
            case 'order/mark-notified':
                require_once __DIR__ . '/../app/controllers/OrderController.php';
                $controller = new OrderController();
                $controller->markNotified();
                break;
            default:
                echo '404 - Không tìm thấy trang';
                break;
        }
    }
}
