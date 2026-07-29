<?php

/**
* @package  employee_package
*/
class EmployeeController
{
    protected function getBasePath(): string
    {
        //return $_SESSION['role'] === 'administrateur' ? '/admin' : '/employee';
        //Valeur fictive de test
        $role = 'administrateur'; 
        //$role = 'employee';
        return $role === 'administrateur' ? '/admin' : '/employe';
    }

    protected function getViewPath(): string
    {
        //return $_SESSION['role'] === 'administrateur' ? '/admin' : '/employee';
        //Valeur fictive de test
        $role = 'administrateur'; 
        //$role = 'employee';
        return $role === 'administrateur' ? 'admin' : 'employee';
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
        $pageTitle = 'Gerer les commandes - Vite & Gourmand';
        $h1 = 'Gérer les commandes';
        require_once __DIR__ . '/../../views/employee/orders.php';
    }

    public function updateOrder(): void
    {
        // Logique pour soumettre le changement de statut d'une commmande
        // Redirection
        header('Location: /' . $this->getBasePath() . '/commandes/');
        exit();
    }
    
    public function listMenus(): void
    {
        $pageTitle = 'Gérer des menus - Vite & Gourmand';
        $h1 = 'Gérer les menus';
        require_once __DIR__ . '/../../views/employee/menus.php';
    } 
    
        public function createMenu(): void
    {
        // Logique pour créer une instance de l'objet menu en BDD
        //Récuperation de l'ID depuis la BDD
        // $id = $this->db->lastInsertId();
        $id = 1; //Id fictif pour test redirection à remplacer par vrai variable
        
        // Redirection
        header('Location: /employe/menus/' . $id . '/modifier');
        exit();
    }

    public function showEditMenuForm(int $id): void
    {   
        $menuName = 'Menu Test'; // Donnée fictive. A remplacer par le menu correspondant à l'id en BDD
        
        $pageTitle = 'Gérer le menu - Vite & Gourmand';
        $h1 = 'Gérer le menus ' . $menuName;
        require_once __DIR__ . '/../../views/employee/menusForm.php';
    } 

    public function updateMenu(): void
    {
        // Logique pour updater le menu
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        exit();
    }

    public function desactivateMenu(): void
    {
        // Logique pour désactiver le menu
        
        // Redirection
        //header('Location: /' . $this->getBasePath() . '/menus');
        header('Location: /employe/menus');
        exit();
    }

    public function deleteMenu(): void
    {
        // Logique pour supprimer le menu
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/menus');
        //header('Location: /employe/menus');
        exit();
    }

    public function listDishes(): void
    {
        $pageTitle = 'Gérer des plats - Vite & Gourmand';
        $h1 = 'Gérer les plats';
        require_once __DIR__ . '/../../views/employee/dish.php';
    } 

    public function createDish(): void
    {
        // Logique pour créer une instance de l'objet menu en BDD
        //Récuperation de l'ID depuis la BDD
        // $id = $this->db->lastInsertId();
        $id = 1; //Id fictif pour test redirection à remplacer par vrai variable
        
        // Redirection
        header('Location: /' . $this->getBasePath() . '/plats/' . $id . '/modifier');
        exit();
    }

    public function showEditDishForm(int $id): void
    {   
        $dishName = 'Plat Test'; // Donnée fictive. A remplacer par le menu correspondant à l'id en BDD
        
        $pageTitle = 'Gérer le plat - Vite & Gourmand';
        $h1 = 'Gérer le plat ' . $dishName;
        require_once __DIR__ . '/../../views/employee/dishForm.php';
    } 

    public function updateDish(): void
    {
        // Logique pour updater le plat
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/plats');
        exit();
    }

    public function deleteDish(): void
    {
        // Logique pour supprimer le plat
        
        // Redirection
        header('Location: ' . $this->getBasePath() . '/plats');
        exit();
    }

    public function listReviews(): void
    {
        $pageTitle = 'Gérer des avis - Vite & Gourmand';
        $h1 = 'Gérer les avis';
        require_once __DIR__ . '/../../views/employee/review.php';
    } 

    public function updateStatusReview(): void
    {
        //Logique pour changer le statut d'un avis et update la BDD
        //Logique pour inclure ou non dans la section Avis de la page d'accueil
        
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
}