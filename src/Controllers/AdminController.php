<?php
/**
 * @package admin_package
 */

require_once __DIR__ . '/EmployeeController.php';
require_once __DIR__ . '/../Services/AuthServices.php';

class AdminController extends EmployeeController{

    private AuthServices $authServices;
    //Vérification de l'authentification et du role client
    public function __construct()
    {
        parent::__construct();
        AuthMiddleware::requireRole(['administrateur']);
        $this->authServices = new AuthServices();
    }

    public function showEmployee(): void
    {
        $users = $this->userModel->getAllEmployee();

        $pageTitle = 'Gerer les employés - Vite & Gourmand';
        $h1 = 'Gérer les employés';
        require_once __DIR__ . '/../../views/admin/employeeForm.php';
    }

    public function createEmployee(): void
    {
        $errors = [];

        //Récupération des données
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        

        //Validation des données
        if (empty($firstName))
            $errors[] = 'Le prénom est obligatoire';

        if (empty($lastName))
            $errors[] = 'Le nom est obligatoire';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'L\'adresse mail est invalide';

        if (!$this->authServices->validatePasswordStrength($password))
            $errors[] = 'Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
        
        if ($password !== $password_confirm)
            $errors[] = 'Les mots de passe ne correspondent pas';

        //Vérifier si l'email existe déjà
        if (empty($errors) && $this->userModel->findByMail($email) !== null)
            $errors[] = 'Cette adresse email est déjà utilisée';

        
        //S'il y a des erreurs - réaffiche le formulaire
        if (!empty($errors)){
            $users = $this->userModel->getAllEmployee();
            $pageTitle = 'Gerer les employés - Vite & Gourmand';
            $h1 = 'Gérer les employés';
            require_once __DIR__ . '/../../views/admin/employeeForm.php';
            return;
        }

        $data = [
            'public_token' => $this->authServices->generateUUID(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $this->authServices->hashPassword($password)
            ];

        //Créer l'employé
        $this->userModel->createEmployee($data);

        //Envoyer le mail de bienvenue
        $this->mailService->sendEmployeeCreated($data['email']);

        //Redirection
        header('Location: /admin/employes');
        exit();
    }

    public function updateEmployee(): void
    {
        // Ajouter la modification du formulaire et l'envoie en BDD

        //Redirection
        header('Location: /admin/employes');
        exit();
    }

    public function desactivateEmployee(int $id): void
    {
        $errors = [];
        if ($id === null) {
            $errors[] = 'user_id manquant';
            header('Location: /admin/employes');
            exit();
        }

        $this->userModel->disableEmploye($id);

        //Redirection
        header('Location: /admin/employes');
        exit();
    }

    public function activateEmployee(int $id): void
    {
        $errors = [];
        if ($id === null) {
            $errors[] = 'user_id manquant';
            header('Location: /admin/employes');
            exit();
        }

        $this->userModel->enableEmploye($id);

        //Redirection
        header('Location: /admin/employes');
        exit();
    }

    public function deleteEmployee(int $id): void
    {
        $this->userModel->deleteUser($id);

        //Redirection
        header('Location: /admin/employes');
        exit();
    }

    public function showStatistics(): void
    {
        //KPI
        $kpi = [];
        //Nombre de commandes totales
        $kpi['TotalOrders'] = $this->statsService->getOrderCountTotal();
        //Menu le plus commandé
        $kpi['MostOrderedMenu'] = $this->statsService->getMostOrderedMenu();
        //Nombre de commandes en cours (exclus terminées)
        $kpi['ActiveOrders'] = $this->orderModel->getActiveOrdersCount();
        //CA total
        $kpi['CATotal'] = $this->statsService->getTotalRevenue();


        //---Nombre de commandes par menu
        $dateFrom = $_GET['chart_date_from'] ?? null;
        $dateTo = $_GET['chart_date_to'] ?? null;

        $ordersByMenu = $this->statsService->getOrderCountByMenu($dateFrom, $dateTo);
        
        //Récupérer tous les menus depuis MariaBD
        $allMenus = $this->menuModel->getAll();
        
        //Indexer les résultats MongoDB par titre de menu
        $mongoData = [];
        foreach ($ordersByMenu as $item) {
            $mongoData[$item['_id']] = $item['count'];
        }

        //Fusionner tous les menus avec 0 par defaut
        $chartLabels = [];
        $chartData = [];

        foreach ($allMenus as $menu) {
            $chartLabels[] = $menu['title'];
            $chartData[] = $mongoData[$menu['title']]?? 0;
        }

        $extraJs = ['/assets/js/admin/statistics.js'];
        //Encoder en JSON pour Javascript
        $chartLabelsJson = json_encode($chartLabels);
        $chartDataJson = json_encode($chartData);

        //---Tableau du nombre de commandes
        //Calculer le total
        $totalOrders = array_sum(
            array_column(
                iterator_to_array($ordersByMenu) ?? [],
                'count'
        ));

        //Ajouter le pourcentage à chaque item
        $ordersByMenuWithStats = [];
        foreach ($ordersByMenu as $item) {
            $ordersByMenuWithStats[] = [
                '_id' => $item['_id'],
                'count' => $item['count'],
                'percentage' => $totalOrders > 0 
                    ? round(($item['count'] / $totalOrders) * 100, 1)
                    : 0
            ];
            }


        //CA par menu
        //Données concaténées pour tableau
        $revenuByMenu = $this->statsService->getRevenueByMenu();

        //Calculer le total des commandes
        $CATotalOrders = array_sum(
            array_column(
                iterator_to_array($revenuByMenu) ?? [],
                'count'
        ));

        $CATotalRevenus = array_sum(
            array_column(
                iterator_to_array($revenuByMenu) ?? [],
                'total'
            ));

        $CATotalAvg = !empty($revenuByMenu)
            ? round(
                array_sum(
                    array_column($revenuByMenu, 'total'))
                    / count($revenuByMenu), 2)
            : 0;

        //var_dump($revenuByMenu);
        // Graphique 1 - Barres CA par mois ou par menu
        $barMode    = $_GET['bar_mode'] ?? 'month'; // 'month' ou 'menu'
        $barDateFrom = $_GET['bar_date_from'] ?? null;
        $barDateTo   = $_GET['bar_date_to'] ?? null;

        if ($barMode === 'month') {
            $barData = $this->statsService->getRevenueByMonth($barDateFrom, $barDateTo);
            $barLabels   = array_map(fn($item) => $item['_id'], $barData);
            $barDatasets = [array_map(fn($item) => (float) $item['total'], $barData)];
        } else {
            $barData = $this->statsService->getRevenueByMenu(null, $barDateFrom, $barDateTo);
            $barLabels  = array_map(fn($item) => $item['_id']['menu_title'], $barData);
            $barDatasets = [array_map(fn($item) => (float) $item['total'], $barData)];
        }

        // Graphique 2 - Ligne évolution CA total
        $lineMode     = $_GET['line_mode'] ?? 'total'; // 'total' ou 'by_menu'
        $lineDateFrom = $_GET['line_date_from'] ?? null;
        $lineDateTo   = $_GET['line_date_to'] ?? null;

        if ($lineMode === 'total') {
            $lineData = $this->statsService->getRevenueByMonth($lineDateFrom, $lineDateTo);
            $lineLabels   = array_map(fn($item) => $item['_id'], $lineData);
            $lineDatasets = [[
                'label' => 'CA total',
                'data'  => array_map(fn($item) => (float) $item['total'], $lineData)
            ]];
        } else {
            // Une ligne par menu
            $lineData = $this->statsService->getRevenueByMenuAndMonth($lineDateFrom, $lineDateTo);

            // Extraire tous les mois uniques
            $months = array_unique(array_map(fn($item) => $item['_id']['month'], $lineData));
            sort($months);
            $lineLabels = array_values($months);

            // Extraire tous les menus uniques
            $menuTitles = array_unique(array_map(fn($item) => $item['_id']['menu_title'], $lineData));

            // Indexer les données par menu et mois
            $indexed = [];
            foreach ($lineData as $item) {
                $indexed[$item['_id']['menu_title']][$item['_id']['month']] = (float) $item['total'];
            }

            // Construire les datasets - un par menu
            $lineDatasets = [];
            foreach ($menuTitles as $title) {
                $data = [];
                foreach ($lineLabels as $month) {
                    $data[] = $indexed[$title][$month] ?? 0;
                }
                $lineDatasets[] = [
                    'label' => $title,
                    'data'  => $data
                ];
            }
        }

        // Graphique 1 - Barres
        $barLabelsJson = json_encode($barLabels);
        $barDatasetsJson   = json_encode($barDatasets);
        $barModeJson   = json_encode($barMode);

        // Graphique 2 - Ligne
        $lineLabelsJson  = json_encode($lineLabels);
        $lineDatasetsJson    = json_encode($lineDatasets);
        $lineModeJson     = json_encode($lineMode);
        $allMenuTitlesJson    = json_encode(array_column($allMenus, 'title'));


        //Passer à la vue
        $ordersByMenu = $ordersByMenuWithStats;
        $totalOrders = array_sum(array_column($ordersByMenu, 'count'));
        $totalPercentage = array_sum(array_column($ordersByMenu, 'percentage'));
        

        $pageTitle = 'Statistiques - Vite & Gourmand';
        $h1 = 'Statistiques';
        require_once __DIR__ . '/../../views/admin/statistics.php';
    }
}