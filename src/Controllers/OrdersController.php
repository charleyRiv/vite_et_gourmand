<?php
/**
 * @package orders_package
 */
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/MenuModel.php';
//require_once __DIR__ . '/../Models/DishModel.php';
require_once __DIR__ . '/../Services/DistanceService.php';
require_once __DIR__ . '/../Services/MailService.php';
class OrdersController {

    private OrderModel $orderModel;
    private UserModel $userModel;
    private MenuModel $menuModel;
    //private DishModel $dishModel;
    private MailService $mailService;

    public function __construct()
    {
        AuthMiddleware::requireRole(['client']);
            if (str_starts_with($_SERVER['REQUEST_URI'], '/api/')) {
            if (!Session::isLoggedIn()) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode(['error' => 'Non authentifié']);
                exit();
            }
        } else {
            AuthMiddleware::requireRole(['client']);
        }

        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
        $this->mailService = new MailService();
    }
    public function step1(): void 
    {
        //Stocker menu pré-selectionné
        if (isset($_GET['menu_id'])) {
            Session::set('order_preselected_menu', (int) $_GET['menu_id']);
        }

        $user = $this->userModel->findById(Session::get('user_id'));
        
        $pageTitle = 'Commandes - etape-1 - Vite & Gourmand';
        $h1= 'Commander - Etape 1/4';
        $extraJs = ['/assets/js/orders/step1.js'];
        require_once __DIR__ . '/../../views/orders/step1.php';
    }

    public function storeStep1(): void 
    {
        // Stocker les données dans la session
        Session::set('order_step1', $_POST);

        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-2');
        exit();
    }

    public function storeStep1Api(): void
    {
        header('Content-Type: application/json');

        $data = [
            'last_name' => trim($_POST['last_name']?? ''),
            'first_name' => trim($_POST['first_name']?? ''),
            'phone' => trim($_POST['phone']?? ''),
            'email' => trim($_POST['email']?? ''),
            'date_livraison'=> trim($_POST['date_livraison'] ?? ''),
            'heure_livraison'=> trim($_POST['heure_livraison'] ?? ''),
            'street_number' => trim($_POST['street_number'] ?? ''),
            'street_type' => trim($_POST['street_type'] ?? ''),
            'street_name' => trim($_POST['street_name'] ?? ''),
            'zip_code' => trim($_POST['zip_code'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'country' => trim($_POST['country'] ?? ''),
        ];

        // Stocke en session comme l'ancienne version
        Session::set('order_step1', $data);

        echo json_encode(['success' => true, 'redirect' => '/commande/etape-2-v2']);
        exit();
    }

    public function showStep1Html(): void
    {
        readfile(__DIR__ . '/../../views/orders/step1.html');
        exit();
    }

    public function step2(): void 
    {
        //Vérifier que l'étape 1 a été complétée avant d'accéder à l'étape 2
        if (Session::get('order_step1') === null) {
            // Rediriger vers l'étape 1 si l'étape 1 n'a pas été complétée
            header('Location: /commandes/etape-1');
            exit();
        }

        $menus = $this->menuModel->getAll();
        $preselectedMenuId = Session::get('order_preselected_menu');

        $pageTitle = 'Commandes - etape-2 - Vite & Gourmand';
        $h1= 'Commander - Etape 2/4';
        $extraJs = ['/assets/js/orders/step2.js'];
        require_once __DIR__ . '/../../views/orders/step2.php';
    }

    public function storeStep2(): void 
    {
        // Stocker les données dans la session
        Session::set('order_step2', $_POST);
        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-3');
        exit();
    }

    public function storeStep2Api(): void
    {
        header('Content-Type: application/json');

        $menuId = (int) ($_POST['menu_id'] ?? 0);

        if ($menuId === 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Veuillez sélectionner un menu.']);
            exit();
        }

        Session::set('order_step2', ['menu_id' => $menuId]);

        echo json_encode(['success' => true, 'redirect' => '/commande/etape-3-v2']);
        exit();
    }

    public function showStep2Html(): void
    {
        readfile(__DIR__ . '/../../views/orders/step2.html');
        exit();
    }

    public function step3(): void 
    {
        //Vérifier que l'étape 2 a été complétée avant d'accéder à l'étape 3
        if (empty(Session::get('order_step2'))) {
            // Rediriger vers l'étape 2 si l'étape 2 n'a pas été complétée
            header('Location: /commande/etape-2');
            exit();
        }

        //Récupère le menu séléctionné à l'étape 2
        $selectedMenu = Session::get('order_step2')['menu_id'] ?? null;
        $menu = $this->menuModel->getById($selectedMenu);
        $errors = [];


        $pageTitle = 'Commandes - etape-3 - Vite & Gourmand';
        $h1= 'Commander - Etape 3/4';
        $extraJs = ['/assets/js/orders/step3.js'];
        require_once __DIR__ . '/../../views/orders/step3.php';
    }

    public function storeStep3(): void 
    {
        $nbPersons = (int) ($_POST['nb_persons'] ?? 0);

        //Récupère le menu séléctionné à l'étape 2
        $selectedMenu = Session::get('order_step2')['menu_id'] ?? null;
        $menu = $this->menuModel->getById($selectedMenu);

        $errors = [];

        //Conditions nombre personnes minimales
        if ($nbPersons <= 0) {
            $errors[] = 'Le nombre de personnes est obligatoire';
        }

        if ($menu !== null && $nbPersons < $menu['min_persons']) {
            $errors[] = 'Le nombre minimum de personnes pour ce menu est' . $menu['min_persons'] . ' .';
        }

        if (!empty($errors)) {
            $pageTitle = 'Commandes - etape-3 - Vite & Gourmand';
            $h1= 'Commander - Etape 3/4';
            require_once __DIR__ . '/../../views/orders/step3.php';
            return;
        }

        // Stocker les données dans la session
        Session::set('order_step3', $_POST);

        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-4');
        exit();
    }

    public function storeStep3Api(): void
    {
        header('Content-Type: application/json');

        $nbPersons = (int) ($_POST['nb_persons'] ?? 0);

        if ($nbPersons <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre de personnes invalide.']);
            exit();
        }

        Session::set('order_step3', ['nb_persons' => $nbPersons]);

        echo json_encode(['success' => true, 'redirect' => '/commande/etape-4-v2']);
        exit();
    }

    public function showStep3Html(): void
    {
        readfile(__DIR__ . '/../../views/orders/step3.html');
        exit();
    }

    public function step4(): void 
    {
        //Vérifier que l'étape 2 a été complétée avant d'accéder à l'étape 3
        if (empty(Session::get('order_step3'))) {
            // Rediriger vers l'étape 2 si l'étape 2 n'a pas été complétée
            header('Location: /commande/etape-3');
            exit();
        }

        $userInfos = Session::get('order_step1');
        $menu = $this->menuModel->getById(Session::get('order_step2')['menu_id']);
        $nbPersons = (int) Session::get('order_step3')['nb_persons'];

        //Formatter la date et heure de livraison
        $orderDateFr = formatDateFr($userInfos['date_livraison']);
        $orderTimeFr = formatTimeFr($userInfos['heure_livraison']);

        //récupérer les plats du menu
        $dishes = $this->menuModel->getDishesByMenuId($menu['menu_id']);
        
        $pricing = [];

        $pricing['calculated_menu_price'] = (float) $menu['price_per_person'] * $nbPersons;

        //Calcul de la redution de 10% en fonction du nombre de personnes
        if ($nbPersons >= $menu['min_persons'] + 5) {
            $pricing['discount'] = $this->orderModel->discount($pricing['calculated_menu_price']);
        }else {
            $pricing['discount'] = 0;
        }
        
        //Calcul des frais kilométriques
        //Concat adresse de Livraison
        $street = implode(' ', 
        [
            $userInfos['street_number'],
            $userInfos['street_type'],
            $userInfos['street_name']
        ]);

        $address = implode(', ', [
            $street,
            $userInfos['zip_code'],
            $userInfos['city'],
            $userInfos['country']
        ]);

        //Calcul de la distance
        $distanceService = new DistanceService();

        $distance = floor($distanceService->getDistance($address)) ?? 0;

        //Calcul des frais kilométriques
        if (strtolower($userInfos['city']) !== 'bordeaux') {
            $pricing['delivery_fees'] = $this->orderModel->deliveryCharges($distance);
        }else {
            $pricing['delivery_fees'] = 0;
        }
        $pricing['total_price'] =  $pricing['calculated_menu_price'] - $pricing['discount'] + $pricing['delivery_fees'];

        $pageTitle = 'Commandes - etape-4 - Vite & Gourmand';
        $h1= 'Commander - Etape 4/4';
        $extraJs = ['/assets/js/orders/step4.js'];
        require_once __DIR__ . '/../../views/orders/step4.php';
    }

    public function storeStep4(): void 
    {
        // Vérifier que toutes les étapes sont complètes
        if (
            empty(Session::get('order_step1')) ||
            empty(Session::get('order_step2')) ||
            empty(Session::get('order_step3'))
        ) {
            header('Location: /commande/etape-1');
            exit();
        }

        // Récupérer les données des sessions
        $step1 = Session::get('order_step1');
        $step2 = Session::get('order_step2');
        $step3 = Session::get('order_step3');

        // Récupérer le menu pour les calculs
        $menu      = $this->menuModel->getById($step2['menu_id']);
        $nbPersons = (int) $step3['nb_persons'];

        $pricing = [];

        $pricing['calculated_menu_price'] = (float) $menu['price_per_person'] * $nbPersons;

        //Calcul de la redution de 10% en fonction du nombre de personnes
        if ($nbPersons >= $menu['min_persons'] + 5) {
            $pricing['discount'] = $this->orderModel->discount($pricing['calculated_menu_price']);
        }else {
            $pricing['discount'] = 0;
        }
        
        //Calcul des frais kilométriques
        //Concat adresse de Livraison
        $street = implode(' ', 
        [
            $step1['street_number'],
            $step1['street_type'],
            $step1['street_name']
        ]);

        $address = implode(', ', [
            $street,
            $step1['zip_code'],
            $step1['city'],
            $step1['country']
        ]);

        //Calcul de la distance
        $distanceService = new DistanceService();

        $distance = floor($distanceService->getDistance($address)) ?? 0;

        //Calcul des frais kilométriques
        if (strtolower($step1['city']) !== 'bordeaux') {
            $pricing['delivery_fees'] = $this->orderModel->deliveryCharges($distance);
        }else {
            $pricing['delivery_fees'] = 0;
        }
        $pricing['total_price'] =  $pricing['calculated_menu_price'] - $pricing['discount'] + $pricing['delivery_fees'];

        // Créer la commande en base
        $orderId = $this->orderModel->createOrder([
            'event_date'              => $step1['date_livraison'],
            'delivery_time'           => $step1['heure_livraison'],
            'delivery_street_number'  => $step1['street_number'],
            'delivery_street_type'    => $step1['street_type'],
            'delivery_street_name'    => $step1['street_name'],
            'delivery_zip_code'       => $step1['zip_code'],
            'delivery_city'           => $step1['city'],
            'delivery_country'        => $step1['country'],
            'nb_persons'              => $nbPersons,
            'calculated_menu_price'   => $pricing['calculated_menu_price'],
            'delivery_fees'           => $pricing['delivery_fees'],
            'discount'                => $pricing['discount'],
            'total_price'             => $pricing['total_price'],
            'current_status'          => 'pending',
            'material_lent'           => 0,
            'user_id'                 => Session::get('user_id'),
            'menu_id'                 => $step2['menu_id'],
        ]);

        // Ajouter l'historique du statut initial
        $this->orderModel->addStatusHistory(
            $orderId,
            'pending',
            null,
            null
        );

        //Envoyer le mail de confirmation 
        $email = $step1['email'];
        $orderData = $this->orderModel->getById($orderId);
        $orderData['menu_title'] = $menu['title'];
        $orderData['event_date_fr'] = formatDateFr($orderData['event_date']);
        $orderData['delivery_time_fr'] = formatTimeFr($orderData['delivery_time']);
        $this->mailService->sendOrderConfirmation($email, $orderData);

        // Vider les données de commande en session
        Session::set('order_step1', null);
        Session::set('order_step2', null);
        Session::set('order_step3', null);

        //Store order
        Session::set('last_order_id', $orderId);
        // Rediriger vers l'étape suivante
        header('Location: /commande/confirmation');
        exit();
    }

    public function storeStep4Api(): void
    {
        header('Content-Type: application/json');

        try {
            $cgv        = $_POST['cgv']        ?? '';
            $conditions = $_POST['conditions'] ?? '';

            if (empty($cgv) || empty($conditions)) {
                http_response_code(400);
                echo json_encode(['error' => 'Veuillez accepter les conditions.']);
                exit();
            }

            $step1 = Session::get('order_step1');
            $step2 = Session::get('order_step2');
            $step3 = Session::get('order_step3');

            if (!$step1 || !$step2 || !$step3) {
                http_response_code(400);
                echo json_encode(['error' => 'Session expirée. Veuillez recommencer votre commande.']);
                exit();
            }

            $menuId    = (int) $step2['menu_id'];
            $nbPersons = (int) $step3['nb_persons'];
            $menu      = $this->menuModel->getById($menuId);
            $menuPrice = (float) $menu['price_per_person'] * $nbPersons;
            $discount  = $nbPersons >= $menu['min_persons'] + 5 ? $menuPrice * 0.1 : 0;

            $distanceService = new DistanceService();
            $address = $step1['street_number'] . ' ' . $step1['street_type'] . ' '
                    . $step1['street_name']   . ' ' . $step1['zip_code']    . ' '
                    . $step1['city']          . ' ' . $step1['country'];

            $distance     = $distanceService->getDistance($address) ?? 0;
            $deliveryFees = $distance > 0 ? 5 + (0.59 * $distance) : 0;
            $total        = $menuPrice - $discount + $deliveryFees;

            $orderId = $this->orderModel->createOrder([
                'user_id'                => Session::get('user_id'),
                'menu_id'                => $menuId,
                'event_date'             => $step1['date_livraison'],
                'delivery_time'          => $step1['heure_livraison'],
                'delivery_street_number' => $step1['street_number'],
                'delivery_street_type'   => $step1['street_type'],
                'delivery_street_name'   => $step1['street_name'],
                'delivery_zip_code'      => $step1['zip_code'],
                'delivery_city'          => $step1['city'],
                'delivery_country'       => $step1['country'],
                'nb_persons'             => $nbPersons,
                'calculated_menu_price'  => $menuPrice,
                'delivery_fees'          => $deliveryFees,
                'discount'               => $discount,
                'total_price'            => $total,
                'current_status'         => 'pending',
                'material_lent'  => 0,
            ]);

            $this->mailService->sendOrderConfirmation($step1['email'], [
                'order_id'   => $orderId,
                'first_name' => $step1['first_name'],
                'menu_title' => $menu['title'],
                'event_date' => $step1['date_livraison'],
                'total'      => $total,
            ]);

            Session::set('last_order_id', $orderId);
            Session::remove('order_step1');
            Session::remove('order_step2');
            Session::remove('order_step3');

            echo json_encode(['success' => true, 'redirect' => '/commande/confirmation-v2']);
            exit();

        } catch (\Exception $e) {
            error_log('storeStep4Api error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function showStep4Html(): void
    {
        readfile(__DIR__ . '/../../views/orders/step4.html');
        exit();
    }

    public function confirmation(): void 
    {
        $orderId = Session::get('last_order_id');

        $order = $this->orderModel->getById($orderId);
        
        $userInfos = $this->userModel->findById($order['user_id']);
        $menu = $this->menuModel->getById($order['menu_id']);
        $dishes = $this->menuModel->getDishesByMenuId($order['menu_id']);

        //Formatter la date et heure de livraison
        $orderDateFr = formatDateFr($order['event_date']);
        $orderTimeFr = formatTimeFr($order['delivery_time']);

        $maskedEmail= maskEmail($userInfos['email']);
        
        //Recupérer la distance
        $distance = ($order['delivery_fees'] - 5)/0.59;


        $pageTitle = 'Commandes - confirmation - Vite & Gourmand';
        $h1= 'Commande n°' . $orderId;
        require_once __DIR__ . '/../../views/orders/confirmation.php';
    }

    public function showConfirmationHtml(): void
    {
        readfile(__DIR__ . '/../../views/orders/confirmation.html');
        exit();
    }


// Méthodes utilitaires

//Calcul des frais de livraison
    public function calculateDeliveryFees(): void
    {
        header('Content-Type: application/json');
    
        $city        = trim($_POST['city'] ?? '');
        $street      = implode(' ', [
            trim($_POST['street_number'] ?? ''),
            trim($_POST['street_type']   ?? ''),
            trim($_POST['street_name']   ?? '')
        ]);
        $address = implode(', ', [
            $street,
            trim($_POST['zip_code'] ?? ''),
            $city,
            trim($_POST['country'] ?? '')
        ]);
    
        $distanceService = new DistanceService();
        $distance        = floor($distanceService->getDistance($address)) ?? 0;
    
        $deliveryFees = strtolower($city) !== 'bordeaux'
            ? $this->orderModel->deliveryCharges($distance)
            : 0;
    
        echo json_encode([
            'distance'      => $distance,
            'delivery_fees' => $deliveryFees,
            'city'          => $city
        ]);
        exit();
    }
}