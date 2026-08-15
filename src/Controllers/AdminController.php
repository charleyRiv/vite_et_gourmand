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
        $pageTitle = 'Statistiques - Vite & Gourmand';
        $h1 = 'Statistiques';
        require_once __DIR__ . '/../../views/admin/statistics.php';
    }
}