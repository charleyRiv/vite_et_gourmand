<?php
/**
 * @package user_package
 */
class UserController {
    //Vérification de l'authentification et du role client
    public function __construct()
    {
        AuthMiddleware::requireRole(['client']);
    }
    
    public function dashboard(): void 
    {
        $pageTitle = 'Mon Espace - Vite & Gourmand';
        $h1 = 'Mon Espace Personnel';
        //Ajouter variable $name
        require_once __DIR__ . '/../../views/user/dashboard.php';
    }

    public function profileForm(): void 
    {
        $pageTitle = 'Mon Profil - Vite & Gourmand';
        $h1 = 'Modifier mes informations personnelles';
        //Récupérer et stocker dans variables les informations du user depuis la BDD
        require_once __DIR__ . '/../../views/user/profile.php';
    }

    public function updateProfile(): void 
    {
        // Logique pour mettre à jour le profil de l'utilisateur
        
        // Redirection
        header('Location: /mon-espace');
        exit();
    }

    public function showOrders(int $id): void 
    {
        $pageTitle = 'Mes Commandes - Vite & Gourmand';
        $h1 = 'Ma commande n°'. $id;
        require_once __DIR__ . '/../../views/user/orders.php';
    }

    public function cancelOrder(int $id): void 
    {
        // Logique pour annuler la commande
        
        // Redirection
        header('Location: /mon-espace');
        exit();
    }

    public function showOrderReviewForm(int $id): void 
    {
        $pageTitle = 'Noter la commande - Vite & Gourmand';
        $h1 = 'Formulaire avis';
        require_once __DIR__ . '/../../views/user/review.php';
    }

    public function submitOrderReview(int $id): void 
    {
        // Logique pour soumettre l'avis sur la commande
        // Redirection
        header('Location: /mon-espace/commande/' . $id);
        exit();
    }
}