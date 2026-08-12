<?php
/**
 * @package user_package
 */

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/MenuModel.php';
require_once __DIR__ . '/../Services/DistanceService.php';

class UserController {
    private UserModel $userModel;
    private OrderModel $orderModel;
    private MenuModel $menuModel;
    //Vérification de l'authentification et du role client
    public function __construct()
    {
        AuthMiddleware::requireRole(['client']);
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->menuModel = new MenuModel();
    }
    
    public function dashboard(): void 
    {
        //Recupération des données personnelles
        $user_id = Session::get('user_id');
        $user = $this->userModel->findById($user_id);

        $orders = $this->orderModel->getAllWithFilters(['user_id' => $user_id]);

        //Formatter la date et heure de livraison
        foreach ($orders as &$order) {
            $order['DateFr'] = formatDateFr($order['event_date']);
            $order['TimeFr'] = formatTimeFr($order['delivery_time']);
        }
        unset($order);
        
        $pageTitle = 'Mon Espace - Vite & Gourmand';
        $h1 = 'Mon Espace - ' . $user['first_name'];

        require_once __DIR__ . '/../../views/user/dashboard.php';
    }

    public function profileForm(): void 
    {
        //Recupération des données personnelles
        $user_id = Session::get('user_id');
        $user = $this->userModel->findById($user_id);

        $pageTitle = 'Mon Profil - Vite & Gourmand';
        $h1 = 'Modifier mes informations personnelles';
        require_once __DIR__ . '/../../views/user/profile.php';
    }

    public function updateProfile(): void 
    {
        //Récupération des données du formulaire
        $data = $this->getProfileDataFromPost();  
        $erros = $this->validateProfileData($data);  
        
        if (!empty($errors)) {
            $user_id = Session::get('user_id');
            $user = $this->userModel->findById($user_id);

            $h1 = 'Modifier mes informations personnelles';
            require_once __DIR__ . '/../../views/user/profile.php';
        }

        $this->userModel->updateProfile($data);

        // Redirection
        header('Location: /mon-espace');
        exit();
    }

    public function deleteProfile():void
    {
        $user_id = Session::get('user_id');

        $this->userModel->deleteUser($user_id);

        Session::destroy();
        //Redirection
        header('Location: /');
        exit();
    }

    public function showOrders(int $id): void 
    {
        $order = $this->orderModel->getById($id);
        $menu = $this->menuModel->getById($order['menu_id']);
        $dishes = $this->menuModel->getDishesByMenuId($order['menu_id']);
        $statuses = $this->orderModel->getStatusHistory($id);

        $order['current_status_FR'] = translateStatusOrder($order['current_status']);
        //Traduction des status en francais
        foreach ($statuses as &$status) {
            $status['statusFR'] = translateStatusOrder($status['status']);
;        }
        unset($status);

        //Formattage des date et heure
        $order['DateFr'] = formatDateFr($order['event_date']);
        $order['TimeFr'] = formatTimeFr($order['delivery_time']);
        
        $pageTitle = 'Mes Commandes - Vite & Gourmand';
        $h1 = 'Ma commande n°'. $id;
        require_once __DIR__ . '/../../views/user/orders.php';
    }

    public function cancelOrder(int $id): void 
    {
        $order = $this->orderModel->getById($id);
        
        $this->orderModel->cancelOrder($id);
        $orderUpdated = $this->orderModel->getById($id);
        $status = $order['current_status'];
        $reason = trim($_POST['reason']) ?? '';
        $contactMode = '';

        $this->orderModel->addStatusHistory($order['order_id'], $status, $reason, $contactMode);
        // Redirection
        header('Location: /mon-espace');
        exit();
    }

    public function showEditOrderForm(int $id): void
    {
        $order = $this->orderModel->getById($id);
        $menu = $this->menuModel->getById($order['menu_id']);
        $menus = $this->menuModel->getAll();

        $pageTitle = "Modifier ma commande - Vite & Gourmand";
        $h1 = 'Modifier ma commande n°' . $id;
        require_once __DIR__ . '/../../views/user/updateOrdersForm.php';
    }

    public function updateOrder(int $id): void
    {
        $order = $this->orderModel->getById($id);
        $user = $this->userModel->findById($order['user_id']);

        $data = $this->getOrderDataFromPost();

        // Conserver le statut actuel - le client ne peut pas le modifier
        $data['current_status'] = $order['current_status'];
        $data['material_lent'] = $order['material_lent'];
        
        //Récupérer le nouveau menu
        $menu = $this->menuModel->getById($data['menu_id']);
    
        //Calcul des prix avec nouvelles données
        $data['calculated_menu_price'] = (float) $menu['price_per_person'] * $data['nb_persons'];

        //Calcul de la redution de 10% en fonction du nombre de personnes
        if ($data['nb_persons'] >= $menu['min_persons'] + 5) {
            $data['discount'] = $this->orderModel->discount($data['calculated_menu_price']);
        }else {
            $data['discount'] = 0;
        }
        
        //Calcul des frais kilométriques
        //Concat adresse de Livraison
        $street = implode(' ', 
        [
            $data['delivery_street_number'],
            $data['delivery_street_type'],
            $data['delivery_street_name']
        ]);

        $address = implode(', ', [
            $street,
            $data['delivery_zip_code'],
            $data['delivery_city'],
            $data['delivery_country']
        ]);

        //Calcul de la distance
        $distanceService = new DistanceService();

        $distance = floor($distanceService->getDistance($address)) ?? 0;

        //Calcul des frais kilométriques
        if (strtolower($data['delivery_city']) !== 'bordeaux') {
            $data['delivery_fees'] = $this->orderModel->deliveryCharges($distance);
        }else {
            $data['delivery_fees'] = 0;
        }
        $data['total_price'] =  $data['calculated_menu_price'] - $data['discount'] + $data['delivery_fees'];

        //Validation
        $errors = $this->validateOrderData($data);

        if(!empty($errors)) {
            $order = $this->orderModel->getById($id);
            $menu = $this->menuModel->getById($order['menu_id']);
            $menus = $this->menuModel->getAll();
            $h1 = 'Modifier ma commande n°' . $id;
            require_once __DIR__ . '/../../views/user/updateOrdersForm.php';
            return;
        }

        $this->orderModel->updateOrder($id, $data);

        // Redirection
        header('Location: /mon-espace');
        exit();
    }

    public function showOrderReviewForm(int $id): void 
    {
        $pageTitle = 'Noter la commande - Vite & Gourmand';
        $h1 = 'Formulaire avis';
        require_once __DIR__ . '/../../views/user/review.php';
    }

    public function submitOrderReview(int $id): void 
    {
        // Logique pour soumettre l'avis sur la commande
        // Redirection
        header('Location: /mon-espace/commande/' . $id);
        exit();
    }

    //Méthodes privées
    private function getOrderDataFromPost(): array
    {
        return[
            'event_date' => trim($_POST['event_date'] ?? ''),
            'delivery_time' => trim($_POST['delivery_time'] ?? ''),
            'delivery_street_number' => trim($_POST['delivery_street_number'] ?? 0),
            'delivery_street_type' => trim($_POST['delivery_street_type'] ?? 0),
            'delivery_street_name' => trim($_POST['delivery_street_name'] ?? 0),
            'delivery_zip_code' => trim($_POST['delivery_zip_code'] ?? ''),
            'delivery_city' => trim($_POST['delivery_city'] ?? ''),
            'delivery_country' => trim($_POST['delivery_country'] ?? 0),
            'nb_persons' => (int) ($_POST['nb_persons'] ?? 0),
            'calculated_menu_price' => (float) ($_POST['calculated_menu_price'] ?? 0),
            'delivery_fees' => (float) ($_POST['delivery_fees'] ?? 0),
            'discount' => (float) ($_POST['discount'] ?? 0),
            'total_price' => (float) ($_POST['total_price'] ?? 0),
            'menu_id' =>(int) ($_POST['menu_id'] ?? 0)
        ];
    }

    private function validateOrderData(array $data): array
    {
        $errors = [];

        if (empty($data['event_date']))
            $errors[] = 'La date de la prestation est obligatoire';

        if (empty($data['delivery_time']))
            $errors[] = "L'heure de livraison est obligatoire";

        if (empty($data['delivery_street_number']) 
            || empty($data['delivery_street_type'])
            || empty($data['delivery_street_name'])
            || empty($data['delivery_zip_code'])
            || empty($data['delivery_city'])
            || empty($data['delivery_country']))
            $errors[] = "L'adresse complète de livraison est obligatoire";

        if ($data['nb_persons'] <= 0)
            $errors[] = 'Le nombre de personnes doit être supérieur à 0.';

        if (empty($data['menu_id']))
            $errors[] = "la selection d'un menu est obligatoire.";

        return $errors;
    }

    private function getProfileDataFromPost(): array
    {
        return[
            'user_id' => (int) (Session::get('user_id')) ?? 0,
            'last_name' => trim($_POST['last_name'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'street_number' => trim($_POST['street_number'] ?? ''),
            'street_type' => trim($_POST['street_type'] ?? ''),
            'street_name' => trim($_POST['street_name'] ?? ''),
            'zip_code' => trim($_POST['zip_code'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'country' => trim($_POST['country'] ?? ''),
        ];
    }

    private function validateProfileData(array $data): array
    {
        $errors = [];

        if (empty($data['last_name']) || empty($data['first_name']))
            $errors[] = 'Les noms et prénoms sont obligatoires';

        if (empty($data['email']))
            $errors[] = "l'email est obligatoir";

        return $errors;
    }

}