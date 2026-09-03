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
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
        //$this->dishModel = new DishModel();
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

    public function confirmation(): void 
    {
        $orderId = Session::get('last_order_id');

        //if (!$orderId) {
        //    header('Location: /');
        //    exit();
        //}
        $order = $this->orderModel->getById($orderId);
        
        $userInfos = $this->userModel->findById($order['user_id']);
        $menu = $this->menuModel->getById($order['menu_id']);
        $dishes = $this->menuModel->getDishesByMenuId($order['menu_id']);

        //Formatter la date et heure de livraison
        $orderDateFr = formatDateFr($order['event_date']);
        $orderTimeFr = formatTimeFr($order['delivery_time']);

        //var_dump($userInfos['email']);
        //exit();
        //masquer l'email
        $maskedEmail= maskEmail($userInfos['email']);
        
        //Recupérer la distance
        $distance = ($order['delivery_fees'] - 5)/0.59;

        //Nettoyer la session
        //Session::set('last_order_id', null);

        $pageTitle = 'Commandes - confirmation - Vite & Gourmand';
        $h1= 'Commande n°' . $orderId;
        require_once __DIR__ . '/../../views/orders/confirmation.php';
    }
}