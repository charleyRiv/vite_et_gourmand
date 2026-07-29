<?php
/**
 * @package menus_package
 */
class MenusController {
    public function index(): void
    {
        $pageTitle = 'Menus - Vite & Gourmand';
        $h1 = 'Menus';
        require_once __DIR__ . '/../../views/menus/menus.php';
    }

    public function show(int $id): void
    {
        $menuName = "Test"; // A remplacer par nom correspondant à l'ID
        $pageTitle = 'Menu ' . $menuName . ' - Vite & Gourmand';
        $h1 = 'Menu ' . $menuName ; // Remplacez $id par la variable nom du menu que vous souhaitez afficher
        require_once __DIR__ . '/../../views/menus/showMenus.php';
    }
}