<?php
/**
 * @package menus_package
 */
class MenusController {
    public function index(): void
    {
        $pageTitle = 'Menus - Vite & Gourmand';
        $h1 = 'Menus - From Controller';
        require_once __DIR__ . '/../../views/menus/menus.php';
    }

    public function show(int $id): void
    {
        $pageTitle = 'Menu' . $id . ' - Vite & Gourmand';
        $h1 = 'Menu' . $id ; // Remplacez $id par la variable nom du menu que vous souhaitez afficher
        require_once __DIR__ . '/../../views/menus/showMenus.php';
    }
}