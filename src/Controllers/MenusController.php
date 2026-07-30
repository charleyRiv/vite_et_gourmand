<?php
/**
 * @package menus_package
 */

require_once __DIR__ . '/../Models/MenuModel.php';
require_once __DIR__ . '/../Models/DishModel.php';

class MenusController {
    private MenuModel $menuModel;
    private DishModel $dishModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->dishModel = new DishModel();
    }


    public function index(): void
    {
        $menus = $this->menuModel->getAll();

        //Pour chaque menu récupérer la photo du plat principal
        foreach ($menus as &$menu){
            $menu['main_picture'] = $this->menuModel->getMenuPicture($menu['menu_id']);
        }

        $pageTitle = 'Menus - Vite & Gourmand';
        $h1 = 'Menus';
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

        //Récupérer les plats
        $dishes = $this->dishModel->getByMenuId($id);

        //Pour chaque plat récupérer les allergens
        foreach ($dishes as &$dish){
            $dish['allergens'] = $this->dishModel->getAllergensByDishId($dish['dish_id']);
            $dish['pictures'] = $this->dishModel->getPicturesByDishId($dish['dish_id']);
        }

        $pageTitle = htmlspecialchars($menu['title']) . ' - Vite & Gourmand';
        $h1 = htmlspecialchars($menu['title']) ; 
        require_once __DIR__ . '/../../views/menus/showMenus.php';
    }
}