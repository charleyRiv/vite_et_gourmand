<?php
/**
 * @package home_package
 */
class HomeController {
    public function index(): void{
        $pageTitle = 'Accueil - Vite et Gourmand';
        $h1 = 'Bienvenue sur le site Vite et Gourmand ! - From controller';
        require_once __DIR__ . '/../../views/home/home.php';
    }
}