<?php

/**
* @package  employee_package
*/

require_once __DIR__ . '/../Models/MenuModel.php';
require_once __DIR__ . '/../Models/DishModel.php';
require_once __DIR__ . '/../Models/AllergenModel.php';
require_once __DIR__ . '/../Models/DietModel.php';
require_once __DIR__ . '/../Models/ThemeModel.php';
require_once __DIR__ . '/../Models/PictureModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Services/MailService.php';
require_once __DIR__ . '/../Models/ReviewModel.php';

class EmployeeController
{
    private MenuModel $menuModel;
    private DishModel $dishModel;
    private AllergenModel $allergenModel;
    private DietModel $dietModel;
    private ThemeModel $themeModel;
    private PictureModel $pictureModel;
    private OrderModel $orderModel;
    private UserModel $userModel;
    private MailService $mailService;
    private ReviewModel $reviewModel;

    //Vérification de l'authentification et du role client
    public function __construct()
    {
        AuthMiddleware::requireRole(['employe', 'administrateur']);
        $this->menuModel = new MenuModel();  
        $this->dishModel = new DishModel();  
        $this->allergenModel = new AllergenModel();
        $this->dietModel = new DietModel();
        $this->themeModel = new ThemeModel();
        $this->pictureModel = new PictureModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
        $this->mailService = new MailService();
        $this->reviewModel = new ReviewModel();
    }

    protected function getBasePath(): string
    {
        return $_SESSION['role'] === 'administrateur' ? '/admin' : '/employe';
    }

    protected function getViewPath(): string
    {
        return $_SESSION['role'] === 'administrateur' ? '/admin' : '/employee';
    }

    public function dashboard(): void
    {
        $pageTitle = 'Dashboard - Vite & Gourmand';
        $h1 = ' Mon espace ';
        require_once __DIR__ . '/../../views/' . $this->getViewPath() . '/dashboard.php';
    }

    public function requestModifyPassword(): void
    {
        // Redirection
        header('Location: /mot-de-passe-oublie/reinitialisation');
        exit();
    }

    public function listOrders(): void
    {
        $orders = $this->orderModel->getAll();
        $activClients = $this->orderModel->getAllClient();
        $activStatuses = $this->orderModel->getAllStatus();


        //Traduit les status actifs en francais
        foreach ($activStatuses as &$activStatus) {
            $activStatus['current_status'] = translateStatusOrder($activStatus['current_status']);
        }
        unset($activStatus);

        //Récupérer les status des commandes en français
        foreach ($orders as &$order){
            $order['current_status_fr'] = translateStatusOrder($order['current_status']);
            $order['event_date_fr'] = formatDateFr($order['event_date']);
            $order['delivery_time_fr'] = formatTimeFr($order['delivery_time']);        }
        unset($order);

        $statuses = [
            'pending' => translateStatusOrder('pending'),
            'accepted' => translateStatusOrder('accepted'),
            'in_preparation' => translateStatusOrder('in_preparation'),
            'in_delivery' => translateStatusOrder('in_delivery'),
            'delivered' => translateStatusOrder('delivered'),
            'waiting_material' => translateStatusOrder('waiting_material'),
            'completed' => translateStatusOrder('completed'),
            'cancelled' => translateStatusOrder('cancelled')
        ];

        $pageTitle = 'Gerer les commandes - Vite & Gourmand';
        $h1 = 'Gérer les commandes';
        require_once __DIR__ . '/../../views/employee/orders.php';
    }

    public function updateOrder(int $id): void
    {
        //Récupération des données formulaire
        $data = [
            'current_status' => trim($_POST['current_status'] ?? ''),
            'contact_mode' => trim($_POST['contact_mode']) ?? '',
            'reason' => trim($_POST['reason']) ?? ''
        ];


        $errors= [];

        if ($data['current_status'] == null){
            $errors[] = 'Veuillez renseigner un status';
        }

        if ($data['current_status'] === 'cancelled') {
            if ($data['contact_mode'] == null || $data['reason'] == null) {
                $errors[] = 'Veuillez renseigner le mode de contact et le motif de l\'annulation';
            }
        }

        if (!empty($errors)) {
            $orders = $this->orderModel->getAll();
            $activClients = $this->orderModel->getAllClient();
            $activStatuses = $this->orderModel->getAllStatus();


            //Traduit les status actifs en francais
            foreach ($activStatuses as &$activStatus) {
                $activStatus['current_status'] = translateStatusOrder($activStatus['current_status']);
            }
            unset($activStatus);

            //Récupérer les status des commandes en français
            foreach ($orders as &$order){
                $order['current_status_fr'] = translateStatusOrder($order['current_status']);
                $order['event_date_fr'] = formatDateFr($order['event_date']);
                $order['delivery_time_fr'] = formatTimeFr($order['delivery_time']);
            }
            unset($order);

            $statuses = [
                'pending' => translateStatusOrder('pending'),
                'accepted' => translateStatusOrder('accepted'),
                'in_preparation' => translateStatusOrder('in_preparation'),
                'in_delivery' => translateStatusOrder('in_delivery'),
                'delivered' => translateStatusOrder('delivered'),
                'waiting_material' => translateStatusOrder('waiting_material'),
                'completed' => translateStatusOrder('completed'),
                'cancelled' => translateStatusOrder('cancelled')
            ];
                $pageTitle = 'Gerer les commandes - Vite & Gourmand';
                $h1 = 'Gérer les commandes';
                require_once __DIR__ . '/../../views/employee/orders.php';
                return;
        }


        $this->orderModel->updateStatus($id, $data['current_status']);
        $this->orderModel->addStatusHistory($id, $data['current_status'], $data['reason'], $data['contact_mode']);

        //récupération infos client pour envoie de mail
        $order = $this->orderModel->getById($id);
        //Envoyer un mail en cas de pret de materiel
        if ($data['current_status'] === "waiting_material") {
            $this->mailService->sendMaterialReturn($order['email'], $order['first_name']);
        }

        //Envoie de mail pour proposer au client de donner son avis sur la commande
        // Redirection
        if ($data['current_status'] === 'completed') {
            $this->mailService->sendReviewInvitation($order['email'], $order['first_name']);
        }
        header('Location: ' . $this->getBasePath() . '/commandes/');
        exit();
    }

    public function showHistoryOrder(int $id):void
    {
        $order = $this->orderModel->getById($id);
        $statuses = $this->orderModel->getStatusHistory($id);
        $client = $this->userModel->findById($order['user_id']);
        $basePath = $this->getBasePath();

        foreach ($statuses as &$status) {
            $status['status_fr'] = translateStatusOrder($status['status']);
        }
        unset($status);

        if ($order === null){
            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }


        $pageTitle = 'Commande historique - Vite & Gourmand';
        $h1 = 'Commande n°' . $id ;
        require_once __DIR__ . '/../../views/employee/orderHistory.php';
    }
    
    public function listMenus(): void
    {
        $menus = $this->menuModel->getAllAdmin();
        $diets = $this->dietModel->getAll();
        $themes = $this->themeModel->getAll();
        $basePath = $this->getBasePath();

        //Extraire les status présents dans les menus
        $statuses = array_unique(array_column($menus, 'is_active'));
        sort($statuses);

        $pageTitle = 'Gérer des menus - Vite & Gourmand';
        $h1 = 'Gérer les menus';
        require_once __DIR__ . '/../../views/employee/menus.php';
    } 
    
        public function createMenu(): void
    {
        // Créer un menu vide en base
        $id = $this->menuModel->createMenu([
            'title'            => 'Nouveau menu',
            'description'      => '',
            'min_persons'      => 1,
            'price_per_person' => 0,
            'remaining_stock'  => 0,
            'conditions'       => '',
            'is_active'        => 0, // inactif par défaut
            'theme_id'         => 3, // valeur par défaut
            'diet_id'          => 1, // valeur par défaut
        ]);

        // Redirection
        header('Location: /employe/menus/' . $id . '/modifier');
        exit();
    }

    public function showEditMenuForm(int $id): void
    {   
        $menu = $this->menuModel->getByIdAdmin($id);

        if ($menu === null) {
            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }

        $diets = $this->dietModel->getAll();
        $themes = $this->themeModel->getAll();
        $pictures = $this->pictureModel->getByMenuId($id);
        $dishes = $this->dishModel->getAll();
        $starters = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'starter');
        $mains = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'main');
        $desserts = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'dessert');
        $menuDishes = $this->dishModel->getByMenuId($id);
        $basePath = $this->getBasePath();
        $errors = [];
        
        //Pour chaque plat associé, récupérer ses photos
        $menuDishesWithPictures = [];
        foreach ($menuDishes as $dish) {
            $dishPictures = $this->pictureModel->getByDishId($dish['dish_id']);
            $dish['pictures'] = $dishPictures;
            $menuDishesWithPictures[] = $dish;
        }
        $menuDishes = $menuDishesWithPictures;

        // Récupérer les URLs déjà dans la galerie du menu
        $menuPictureUrls = array_column($pictures, 'url');

        $pageTitle = 'Gérer le menu ' . $menu['title'] . ' - Vite & Gourmand';
        $h1 = 'Gérer le menus ' . $menu['title'];
        require_once __DIR__ . '/../../views/employee/menusForm.php';
    } 

    public function updateMenu(int $id): void
    {
        $menu = $this->menuModel->getByIdAdmin($id);
        $basePath = $this->getBasePath();
        $pictures = $this->pictureModel->getByMenuId($id);
        $data = $this->getMenuDataFromPost();
        $errors = $this->validateMenuData($data);
        $dishes = $this->dishModel->getAll();
        $starters = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'starter');
        $mains = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'main');
        $desserts = array_filter($dishes, fn($dish) => $dish['dish_type'] === 'dessert');
        $menuDishes = $this->dishModel->getByMenuId($id);

        if ($menu === null) {
            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }

        if (!empty($errors)) {
            $themes = $this->themeModel->getAll();
            $diets = $this->dietModel->getAll();
            $pictures = $this->pictureModel->getByMenuId($id);
            $pageTitle = 'Modifier ' . $menu['title'] . ' - Vite & Gourmand';
            $h1        = 'Modifier ' . $menu['title'];
            require_once __DIR__ . '/../../views' . $this->getViewPath() . '/menusForm.php';
            return;
        }

        $this->menuModel->updateMenu($id, $data);

        //Mettre à jour les plats associés
        $this->menuModel->deleteMenuDishes($id);
        $dishIds = array_filter($_POST['dish_ids'] ?? [], fn($id) => $id !== '');
        foreach ($dishIds as $dishId) {
            $this->menuModel->addDishToMenu($id, (int) $dishId);
        }

        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        exit();
    }

    public function desactivateMenu(int $id): void
    {
        $this->menuModel->desactivateMenu($id);

        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        //header('Location: /employe/menus');
        exit();
    }

    public function activateMenu(int $id): void
    {
        $this->menuModel->activateMenu($id);
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        exit();
    }

    public function deleteMenu(int $id): void
    {
        $this->menuModel->deleteMenu($id);
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        //header('Location: /employe/menus');
        exit();
    }

    public function listDishes(): void
    {
        $dishesType = $this->dishModel->getDishTypes();
        $diets = $this->dietModel->getAll();
        $allergens = $this->allergenModel->getAll();
        $dishes = $this->dishModel->getAll();
        $basePath = $this->getBasePath();

        //Pour chaque plat récupérer le nombre de menu associés
        foreach ($dishes as &$dish) {
            $dish['menu_count'] = $this->dishModel->getCountDishByMenus($dish['dish_id']);
            $dish['dish_allergens'] = $this->allergenModel->getAllergensByDishId($dish['dish_id']);
            $pictures = $this->pictureModel->getByMenuId($dish['dish_id']);
            $dish['dish_picture'] = $pictures[0] ?? null;
        }
        unset($dish);

        $pageTitle = 'Gérer des plats - Vite & Gourmand';
        $h1 = 'Gérer les plats';
        require_once __DIR__ . '/../../views/employee/dish.php';
    } 

    public function createDish(): void
    {
        $id = $this->dishModel->createDish([
            'title' => 'Nouveau plat',
            'description' => '',
            'dish_type' => 'main', // valeur par défaut
        ]);
        
        // Redirection
        header('Location: /employe/plats/' . $id . '/modifier');
        exit();
    }

    public function showEditDishForm(int $id): void
    {   

        $dish = $this->dishModel->getById($id);
        $allergens = $this->allergenModel->getAll();
        $dishTypes = $this->dishModel->getDishTypes();
        $dishAllergens = $this->allergenModel->getAllergensByDishId($id);
        $pictures = $this->pictureModel->getByDishId($id);
        $basePath = $this->getBasePath();
        
        if ($dish === null) {
            // Redirection avec message d'erreur
            header('Location: ' . $basePath . '/plats/' . $id . '/modifier');
            exit();
        }

        if ($dish === null || $dish === false) {
            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }
        
        $errors = [];       
        $pageTitle = 'Gérer le plat - Vite & Gourmand';
        $h1 = 'Gérer le plat ' . $dish['title'];
        require_once __DIR__ . '/../../views/employee/dishForm.php';
    } 

    public function updateDish(int $id): void
    {
        $dish = $this->dishModel->getById($id);
        $data = $this->getDishDataFromPost();
        $errors = $this->validateDishData($data);
        $basePath = $this->getBasePath();

        if (!empty($errors)) {
            $allergens = $this->allergenModel->getAll();
            $dishAllergens = $this->allergenModel->getAllergensByDishId($id);
            $dishTypes = $this->dishModel->getDishTypes();
            $pictures = $this->pictureModel->getByDishId($id);
            $h1 = 'Gérer le plat ' . $dish['title'];
            require_once __DIR__ . '/../../views/' . $this->getViewPath() . '/dishForm.php';
            return;
        }
        
        //Mettre à jour le plat 
        $this->dishModel->updateDish($id, $data);

        //Mettre à jour les allergenes
        // Supprimer les associations existantes
        $this->allergenModel->deleteAllergensDish($id);

        //Associer les allergenes cochés
        $allergenIds = $_POST['allergen_ids'] ?? [];
        foreach ($allergenIds as $allergenId) {
            $this->allergenModel->attachAllergen($id, (int) $allergenId);
        }

        // Redirection
        header('Location: ' . $this->getBasePath() . '/plats');
        exit();
    }

    public function deleteDish(int $id): void
    {
        $this->dishModel->deleteDish($id);
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/plats');
        exit();
    }

    public function listReviews(): void
    {
        $reviews = $this->reviewModel->getAll();

        foreach ($reviews as &$review) {
            $review['validation_status_fr'] = translateStatusReview($review['validation_status']);
        }
        unset($review);


        $pageTitle = 'Gérer des avis - Vite & Gourmand';
        $h1 = 'Gérer les avis';
        require_once __DIR__ . '/../../views/employee/review.php';
    } 

    public function validateStatusReview(int $id): void
    {
        $this->reviewModel->validateReview($id);
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/avis');
        exit();
    }

    public function refusedStatusReview(int $id): void
    {
        $this->reviewModel->refuseReview($id);

        // Redirection
        header('Location: ' . $this->getBasePath() . '/avis');
        exit();
    }

    public function showEditContentForm(): void
    {
        $pageTitle = 'Gérer des contenus - Vite & Gourmand';
        $h1 = 'Gérer les contenus';
        require_once __DIR__ . '/../../views/employee/contentForm.php';
    } 

    public function updateContent(): void
    {
        //Logique pour updater les contenus du site
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/contenus');
        exit();
    }

    public function addPictureToDish(int $id): void
    {
        $url = $this->uploadPicture('photo');
        $basePath = $this->getBasePath();

        if ($url === null) {
            // Redirection avec message d'erreur
            header('Location: ' . $basePath . '/plats/' . $id . '/modifier');
            exit();
        }

        // Ajouter l'image à la base de données
        $this->pictureModel->addPictureToDish($id, [
            'url' => $url,
            'title' => $_POST['title'] ?? '',
            'alt_text' => $_POST['alt_text'] ?? '',
            'slug' => generateSlug($_POST['title'] ?? '') ?? '',
        ]);

        // Redirection vers le formulaire de modification du plat
        header('Location: ' . $this->getBasePath() . '/plats/' . $id . '/modifier');
        exit();
    }

    public function deleteDishPicture(int $pictureId): void
    {
        // Récupérer l'URL de l'image pour la supprimer du serveur
        $picture = $this->pictureModel->getByDishId($pictureId);

        // Supprimer l'image de la base de données
        $this->pictureModel->deleteFromDish($pictureId);

        // Redirection vers la page précédente
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function addPictureToMenu(int $id): void
    {
        $url = $this->uploadPicture('photo');$basePath = $this->getBasePath();

        if ($url === null) {
            // Redirection avec message d'erreur
            header('Location: ' . $basePath . '/plats/' . $id . '/modifier');
            exit();
        }

        // Ajouter l'image à la base de données
        $this->pictureModel->addPictureToMenu($id, [
            'url' => $url,
            'title' => $_POST['title'] ?? '',
            'alt_text' => $_POST['alt_text'] ?? '',
            'slug' => generateSlug($_POST['title'] ?? basename($url))
        ]);

        // Redirection vers le formulaire de modification du plat
        header('Location: ' . $this->getBasePath() . '/menus/' . $id . '/modifier');
        exit();
    }

    public function deleteMenuPicture(int $pictureId): void
    {
        // Supprimer l'image de la base de données
        $this->pictureModel->deleteFromMenu($pictureId);

        // Redirection vers la page précédente
        $menuId = $_POST['menu_id'] ?? null;
        header('Location: ' . $this->getBasePath() . '/menus/' . $menuId . '/modifier');
        exit();
    }

    public function copyDishPicturesToMenu(int $id): void
    {
        $this->pictureModel->addPictureToMenu($id, [
            'url' => $_POST['url'],
            'title' => $_POST['title'] ?? '',
            'alt_text' => $_POST['alt_text'] ?? '',
            'slug' => generateSlug($_POST['title'] ?? basename($_POST['url']))
        ]);

         // Redirection vers le formulaire de modification du menu
        header('Location: ' . $this->getBasePath() . '/menus/' . $id . '/modifier');
        exit();
    }
    // Méthodes privées utilitaires

    private function getMenuDataFromPost(): array
    {
        return[
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'min_persons' => (int) ($_POST['min_persons'] ?? 0),
            'price_per_person' => (float) ($_POST['price_per_person'] ?? 0),
            'remaining_stock' => (int) ($_POST['remaining_stock'] ?? 0),
            'conditions' => trim($_POST['conditions'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'theme_id' => (int) ($_POST['theme_id'] ?? 0),
            'diet_id' => (int) ($_POST['diet_id'] ?? 0)
        ];
    }

    private function validateMenuData(array $data): array
    {
        $errors = [];

        if (empty($data['title']))
            $errors[] = 'Le titre est obligatoire';

        if (empty($data['description']))
            $errors[] = 'La description est obligatoire';

        if ($data['min_persons'] <= 0)
            $errors[] = 'Le nombre de personnes minimum doit être supérieur à 0.';

        if ($data['price_per_person'] <= 0)
            $errors[] = 'Le prix par personne doit être supérieur à 0.';

        if ($data['theme_id'] <= 0)
            $errors[] = 'Veuillez sélectionner un thème.';

        if ($data['diet_id'] <= 0)
            $errors[] = 'Veuillez sélectionner un régime.';

        return $errors;
    }

    private function getDishDataFromPost(): array
    {
        return[
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'dish_type' => trim($_POST['dish_type'] ?? '')
        ];
    }

    private function validateDishData(array $data): array
    {
        $errors = [];

        if (empty($data['title']))
            $errors[] = 'Le titre est obligatoire';

        if (empty($data['description']))
            $errors[] = 'La description est obligatoire';

        if (empty($data['dish_type']))
            $errors[] = 'Le type de plat est obligatoire';

        return $errors;
    }

    private function uploadPicture(string $inputName): ?string
    {
        // Vérifier qu'un fichier a été envoyé
        if (empty($_FILES[$inputName]['name'])) {
            return null; // Aucun fichier n'a été envoyé
        }

        //Vérifier les erreurs de téléchargement
        if ($_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            return null; // Erreur lors du téléchargement
        }

        // Vérifier le type MIME du fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $mimeType = mime_content_type($_FILES[$inputName]['tmp_name']);
        
        if (!in_array($mimeType, $allowedTypes)) {
            return null; // Type de fichier non autorisé
        }

        //Vérifier les atille (max 2Mo)
        if ($_FILES[$inputName]['size'] > 2 * 1024 * 1024) {
            return null; // Fichier trop volumineux
        }

        //Générer un nom unique
        $extension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $filename= uniqid('img_', true) . '.' . strtolower($extension);
        $uploadDir = __DIR__ . '/../../public/assets/images/uploads/';
        $uploadPath = $uploadDir . $filename;

        // Déplacer le fichier téléchargé vers le répertoire de destination
        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadPath)) {
            return null; // Échec du déplacement du fichier
        }

        return '/assets/images/uploads/' . $filename; // Retourner le chemin relatif pour l'accès public
    }
}