<?php
/**
 * @package menus_package
 */

require_once __DIR__ . '/../Models/MenuModel.php';
require_once __DIR__ . '/../Models/DishModel.php';
require_once __DIR__ . '/../Models/AllergenModel.php';
require_once __DIR__ . '/../Models/DietModel.php';
require_once __DIR__ . '/../Models/ThemeModel.php';
require_once __DIR__ . '/../Models/PictureModel.php';

class MenusController {
    private MenuModel $menuModel;
    private DishModel $dishModel;
    private AllergenModel $allergenModel;
    private DietModel $dietModel;
    private ThemeModel $themeModel;
    private PictureModel $pictureModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->dishModel = new DishModel();
        $this->allergenModel = new AllergenModel();
        $this->dietModel = new DietModel();
        $this->themeModel = new ThemeModel();
        $this->pictureModel = new PictureModel();
    }


    public function index(): void
    {
        $currentPage = (int) ($_GET['page'] ?? 1);
        $perPage = 4;

        // Récupérer les filtres depuis GET
        $filters = [
            'prix_min'   => $_GET['prix_min']   ?? null,
            'prix_max'   => $_GET['prix_max']   ?? null,
            'themes'     => $_GET['themes']     ?? [],
            'diets'      => $_GET['diets']      ?? [],
            'nb_persons' => $_GET['nb_persons'] ?? null,
        ];
        $offset = ($currentPage -1) * $perPage;

        $totalMenus = $this->menuModel->countWithFilters($filters);
        $totalPages = ceil($totalMenus / $perPage);
        
        $menus = $this->menuModel->getAllWithFilters($filters, $perPage, $offset);
        //$menus = $this->menuModel->getAll();
        $allergens = $this->allergenModel->getAll();
        $themes = $this->themeModel->getAll();
        $diets = $this->dietModel->getAll();

        //Pour chaque menu récupérer la photo du plat principal
        foreach ($menus as &$menu){
            $menu['pictures'] = $this->pictureModel->getByMenuId($menu['menu_id']);
            $pictures = $menu['pictures'][0];
            $menu['diets'] = $this->dietModel->getDietByMenuId($menu['menu_id']);
            $menu['themes'] = $this->themeModel->getThemeByMenuId($menu['menu_id']);
            $menu['dishes'] = $this->dishModel->getByMenuId($menu['menu_id']);
            foreach ($menu['dishes'] as $dish){
                $dish['allergens'] = $this->allergenModel->getAllergensByDishId($dish['dish_id']);
            }
        }
        unset($menu);

        $pageTitle = 'Menus - Vite & Gourmand';
        $h1 = 'Menus';
        $extraJs = ['/assets/js/menus/menus.js'];
        require_once __DIR__ . '/../../views/menus/menus.php';
    }

    public function show(int $id): void
    {
        $menu = $this->menuModel->getById($id);

        // Menu introuvable -> 404
        if ($menu === null)
            {
            http_response_code(404);
            require_once __DIR__ . '/../../views/errors/404.php';
            return;
        }
        
        $menu['pictures'] = $this->pictureModel->getByMenuId($menu['menu_id']);
        $menu['diets'] = $this->dietModel->getDietByMenuId($menu['menu_id']);
        $menu['themes'] = $this->themeModel->getThemeByMenuId($menu['menu_id']);

        //Récupérer les plats
        $dishes = $this->dishModel->getByMenuId($id);

        //Pour chaque plat récupérer les allergens
        foreach ($dishes as &$dish){
            $dish['allergens'] = $this->allergenModel->getAllergensByDishId($dish['dish_id']);  
            $dish['dish_type'] = translateDishType($dish['dish_type']);
            $dish['picture'] = $this->pictureModel->getByDishId($dish['dish_id'])[0] ?? null; 
        }
        unset($dish);

        $pageTitle = htmlspecialchars($menu['title']) . ' - Vite & Gourmand';
        $h1 = htmlspecialchars($menu['title']) ; 
        require_once __DIR__ . '/../../views/menus/showMenus.php';
    }
}