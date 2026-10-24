<?php

class ApiController
{
    public function session(): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'isLoggedIn' => Session::isLoggedIn(),
            'role'       => $_SESSION['role'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'email'      => Session::get('email'),
        ]);
        exit();
    }

    public function csrfToken(): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'token' => generateCsrfToken()
        ]);
        exit();
    }

    public function schedule(): void
    {
        header('Content-Type: application/json');

        require_once __DIR__ . '/../Models/ContentModel.php';
        $contentModel = new ContentModel();
        $schedule = $contentModel->getByFilter('footer', 'Horaires');

        echo json_encode([
            'content' => $schedule[0]['content'] ?? ''
        ]);
        exit();
    }

    public function homeContents(): void
    {
        header('Content-Type: application/json');
        require_once __DIR__ . '/../Models/ContentModel.php';
        $contentModel = new ContentModel();
        $contents = $contentModel->getByFilter('home', null);
        echo json_encode($contents);
        exit();
    }

    public function homeReviews(): void
    {
        header('Content-Type: application/json');
        require_once __DIR__ . '/../Models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getAllValidated();
        echo json_encode($reviews);
        exit();
    }

    public function userProfile(): void
    {
        header('Content-Type: application/json');

        if (!Session::isLoggedIn()) {
            echo json_encode(['user' => null]);
            exit();
        }

        require_once __DIR__ . '/../Models/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->findById(Session::get('user_id'));

        echo json_encode(['user' => $user]);
        exit();
    }

    public function sessionStep2(): void
    {
        header('Content-Type: application/json');
        $step2 = Session::get('order_step2');
        echo json_encode(['menu_id' => $step2['menu_id'] ?? null]);
        exit();
    }

    public function sessionStep4(): void
    {
        header('Content-Type: application/json');

        $step1 = Session::get('order_step1');
        $step2 = Session::get('order_step2');
        $step3 = Session::get('order_step3');

        if (!$step1 || !$step2 || !$step3) {
            http_response_code(400);
            echo json_encode(['error' => 'Session incomplète']);
            exit();
        }

        echo json_encode([
            'step1' => $step1,
            'step2' => $step2,
            'step3' => $step3,
        ]);
        exit();
    }

    public function sessionConfirmation(): void
    {
        header('Content-Type: application/json');

        $orderId = Session::get('last_order_id');

        if (!$orderId) {
            http_response_code(400);
            echo json_encode(['error' => 'Aucune commande trouvée.']);
            exit();
        }

        require_once __DIR__ . '/../Models/OrderModel.php';
        require_once __DIR__ . '/../Models/MenuModel.php';
        require_once __DIR__ . '/../Models/DishModel.php';
        require_once __DIR__ . '/../Models/PictureModel.php';

        $orderModel = new OrderModel();
        $menuModel  = new MenuModel();
        $dishModel  = new DishModel();

        $order = $orderModel->getById($orderId);
        $menu = $menuModel->getById($order['menu_id']);
        $dishes = $dishModel->getByMenuId($order['menu_id']);

        // Masque l'email
        $email = $order['email'] ?? Session::get('email') ?? '';
        $parts = explode('@', $email);
        $masked = substr($parts[0], 0, 2) . '***@' . ($parts[1] ?? '');

        echo json_encode([
            'order' => $order,
            'menu' => $menu,
            'dishes' => $dishes,
            'maskedEmail' => $masked,
        ]);
        exit();
    }
}