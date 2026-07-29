<?php
/**
 * @package admin_package
 */

require_once __DIR__ . '/EmployeeController.php';

class AdminController extends EmployeeController{
    //ajoute function construct pour verifier le role

    public function showEmployee(): void
    {
        $pageTitle = 'Gerer les employés - Vite & Gourmand';
        $h1 = 'Gérer les employés';
        require_once __DIR__ . '/../../views/admin/employeeForm.php';
    }

    public function createEmployee(): void
    {
        // Ajouter la creation du formulaire et l'envoie en BDD

        //Redirection
        header('Location : /admin/employes');
        exit();
    }

    public function updateEmployee(): void
    {
        // Ajouter la modification du formulaire et l'envoie en BDD

        //Redirection
        header('Location : /admin/employes');
        exit();
    }

    public function desactivateEmployee(): void
    {
        // Ajouter methode de desactivation du compte employé

        //Redirection
        header('Location : /admin/employes');
        exit();
    }

    public function deleteEmployee(): void
    {
        // Ajouter methode de supprimer du compte employé

        //Redirection
        header('Location : /admin/employes');
        exit();
    }

    public function showStatistics(): void
    {
        $pageTitle = 'Statistiques - Vite & Gourmand';
        $h1 = 'Statistiques';
        require_once __DIR__ . '/../../views/admin/statistics.php';
    }
}