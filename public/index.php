<?php

// Loading environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore les commentaires et les lignes sans =
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Show erreurs in development mode
if (getenv('APP_ENV') === 'development') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// Loading core classes
require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Core/Session.php';
require_once __DIR__ . '/../src/Middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../src/Core/Helpers.php';

// Start session
Session::start();

// Définition des routes
$router = new Router();

// Public routes
$router->get('/', 'HomeController', 'index');
$router->get('/menus', 'MenusController', 'index');
$router->get('/menus/{id}', 'MenusController', 'show');
$router->get('/contact', 'ContactController', 'showContactForm');
$router->post('/contact', 'ContactController', 'contact');
$router->get('/legal', 'LegalController', 'legal');
$router->get('/cgv', 'CgvController', 'cgv');


// ── Authentification ──────────────────────────────────────
$router->get('/connexion', 'AuthController', 'showLoginForm');
$router->post('/connexion', 'AuthController', 'login');
$router->post('/deconnexion', 'AuthController', 'logout');
$router->get('/inscription', 'AuthController', 'showRegisterForm');
$router->post('/inscription', 'AuthController', 'register');
$router->get('/mot-de-passe-oublie', 'AuthController', 'passwordForgotten');
$router->post('/mot-de-passe-oublie', 'AuthController', 'requestModifyPassword');
$router->get('/mot-de-passe-oublie/reinitialisation', 'AuthController', 'showResetPasswordForm');
$router->post('/mot-de-passe-oublie/reinitialisation', 'AuthController', 'resetPassword');

// __ Orders ───────────────────────────────────────────────
$router->get('/commande/etape-1', 'OrdersController', 'step1');
$router->post('/commande/etape-1', 'OrdersController', 'storeStep1');
$router->get('/commande/etape-2', 'OrdersController', 'step2');
$router->post('/commande/etape-2', 'OrdersController', 'storeStep2');
$router->get('/commande/etape-3', 'OrdersController', 'step3');
$router->post('/commande/etape-3', 'OrdersController', 'storeStep3');
$router->get('/commande/etape-4', 'OrdersController', 'step4');
$router->post('/commande/etape-4', 'OrdersController', 'storeStep4');
$router->get('/commande/confirmation', 'OrdersController', 'confirmation');

// ── Client area ─────────────────────────────────────────
$router->get('/mon-espace', 'UserController', 'dashboard');
    // Gestion du profil
$router->get('/mon-espace/profil', 'UserController', 'profileForm');
$router->post('/mon-espace/profil', 'UserController', 'updateProfile');
$router->post('/mon-espace/supprimer', 'UserController', 'deleteProfile');

    // Gestion des commandes
$router->get('/mon-espace/commande/{id}/modifier', 'UserController','showEditOrderForm');
$router->post('/mon-espace/commande/{id}/modifier','UserController', 'updateOrder');
$router->get('/mon-espace/commande/{id}', 'UserController', 'showOrders');
$router->post('/mon-espace/commande/{id}/annuler', 'UserController', 'cancelOrder');
    // Gestion des avis
$router->get('/mon-espace/commande/{id}/avis', 'UserController', 'showOrderReviewForm');
$router->post('/mon-espace/commande/{id}/avis', 'UserController', 'submitOrderReview');

// ── Employee area ────────────────────────────────────────
$router->get('/employe', 'EmployeeController', 'dashboard');
$router->post('/employe/mot-de-passe', 'EmployeeController', 'requestModifyPassword');
    // Orders management
$router->get('/employe/commandes', 'EmployeeController', 'listOrders');
$router->post('/employe/commandes/{id}/gerer', 'EmployeeController', 'updateOrder');
$router->get('/employe/commandes/{id}/historique', 'EmployeeController', 'showHistoryOrder');

    // Menus management
$router->get('/employe/menus', 'EmployeeController', 'listMenus');
$router->post('/employe/menus/creer', 'EmployeeController', 'createMenu');
$router->get('/employe/menus/{id}/modifier', 'EmployeeController', 'showEditMenuForm');
$router->post('/employe/menus/{id}/modifier', 'EmployeeController', 'updateMenu');
$router->post('/employe/menus/{id}/desactiver', 'EmployeeController', 'desactivateMenu');
$router->post('/employe/menus/{id}/activer', 'EmployeeController', 'm');
$router->post('/employe/menus/{id}/supprimer', 'EmployeeController', 'deleteMenu');
$router->post('/employe/menus/{id}/photos/ajouter', 'EmployeeController', 'addPictureToMenu');
$router->post('/employe/menus/photos/{pictureId}/supprimer', 'EmployeeController', 'deleteMenuPicture');
$router->post('/employe/menus/{id}/photos/copier-depuis-plat', 'EmployeeController', 'copyDishPicturesToMenu');
    // Dishes management
$router->get('/employe/plats', 'EmployeeController', 'listDishes');
$router->post('/employe/plats/creer', 'EmployeeController', 'createDish');
$router->get('/employe/plats/{id}/modifier', 'EmployeeController', 'showEditDishForm');
$router->post('/employe/plats/{id}/modifier', 'EmployeeController', 'updateDish');
$router->post('/employe/plats/{id}/supprimer', 'EmployeeController', 'deleteDish');
$router->post('/employe/plats/{id}/photos/ajouter', 'EmployeeController', 'addPictureToDish');
$router->post('/employe/plats/photos/{pictureId}/supprimer', 'EmployeeController', 'deleteDishPicture');
    // Reviews management
$router->get('/employe/avis', 'EmployeeController', 'listReviews');
$router->post('/employe/avis/{id}/validate', 'EmployeeController', 'validateStatusReview');
$router->post('/employe/avis/{id}/refused', 'EmployeeController', 'refusedStatusReview');

    // Content management
$router->get('/employe/contenus', 'EmployeeController', 'showEditContentForm');
$router->post('/employe/contenus/creer', 'EmployeeController', 'createContent');
$router->post('/employe/contenus/{id}/modifier', 'EmployeeController', 'updateContent');
$router->post('/employe/contenus/{id}/supprimer', 'EmployeeController', 'deleteContent');

// ── Admin area ─────────────────────────────────
$router->get('/admin', 'AdminController', 'dashboard');
    // Orders management
$router->get('/admin/commandes', 'AdminController', 'listOrders');
$router->post('/admin/commandes/{id}/gerer', 'AdminController', 'updateOrder');
    // Menus management
$router->get('/admin/menus', 'AdminController', 'listMenus');
$router->post('/admin/menus/creer', 'AdminController', 'createMenu');
$router->get('/admin/menus/{id}/modifier', 'AdminController', 'showEditMenuForm');
$router->post('/admin/menus/{id}/modifier', 'AdminController', 'updateMenu');
$router->post('/admin/menus/{id}/desactiver', 'AdminController', 'desactivateMenu');
$router->post('/admin/menus/{id}/supprimer', 'AdminController', 'deleteMenu');
    // Dishes management
$router->get('/admin/plats', 'AdminController', 'listDishes');
$router->post('/admin/plats/creer', 'AdminController', 'createDish');
$router->get('/admin/plats/{id}/modifier', 'AdminController', 'showEditDishForm');
$router->post('/admin/plats/{id}/modifier', 'AdminController', 'updateDish');
$router->post('/admin/plats/{id}/supprimer', 'AdminController', 'deleteDish');
    // Reviews management
$router->get('/admin/avis', 'AdminController', 'listReviews');
$router->post('/admin/avis/{id}/statut', 'AdminController', 'updateStatusReview');
    // Content management
$router->get('/admin/contenus', 'AdminController', 'showEditContentForm');
$router->post('/admin/contenus/{id}/modifier', 'AdminController', 'updateContent');
    // Employee management
$router->get('/admin/employes', 'AdminController', 'showEmployee');
$router->post('/admin/employes/creer', 'AdminController', 'createEmployee');
$router->post('/admin/employes/update', 'AdminController', 'updateEmployee');
$router->post('/admin/employes/{id}/desactiver', 'AdminController', 'desactivateEmployee');
$router->post('/admin/employes/{id}/supprimer', 'AdminController', 'deleteEmployee');
    // Business management
$router->get('/admin/statistiques', 'AdminController', 'showStatistics');

//Request dispatch
$router->dispatch(
    $_SERVER['REQUEST_METHOD'], 
    $_SERVER['REQUEST_URI']
    );