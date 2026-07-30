<?php
/**
 * @package auth_package
 */
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Services/AuthServices.php';
require_once __DIR__ . '/../Services/MailService.php';

class AuthController {

    private UserModel $userModel;
    private AuthServices $authServices;
    private MailService $mailService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authServices = new AuthServices();
        $this->mailService = new MailService();
    }

    // GET /Connexion - affiche le formulaire
    public function showLoginForm(): void 
    {
        //Déjà connecté -> redirection
        if (Session::isLoggedIn()) 
        {
            header('Location: /');
            exit();
        }

        $pageTitle = 'Connexion - Vite & Gourmand';
        $h1 = 'Formulaire de connexion';
        $errors = [];

        //Message succès après inscription
        $registrered = isset ($_GET['registrered']);

        require_once __DIR__ . '/../../views/auth/login.php';
    }

    // POST /Connexion - traite le formulaire
    public function login(): void 
    {
        //Détruire toute session existante
        Session::destroy();
        Session::start();

        $errors = [];

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        //Validation basique
        if (empty($email) || empty($password))
            {
                $errors[] = 'Veuillez renseigner votre email et votre mot de passe.';
            }

        //Chercher l'utilisateur en base
        if (empty($errors))
            {
                $user = $this->userModel->findByMail($email);

                if ($user === null || !$this->authServices->verifyPassword($password, $user['password']))
                    {
                        $errors[] = 'Email ou mot de passe incorrect';
                    }
            }

        //Vérifier que le compte est actif
        if (empty($errors) && $user['is_active'] === 0)
            {
                $errors[]= 'Ce compte a été désactivé';
            }

        //S'il y a des erreurs
        if (!empty($errors))
            {
                $pageTitle = 'Connexion - Vite & Gourmand';
                $h1 = 'Formulaire de connexion';

                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            }

        // régénérer l'ID de session (sécurité)
        Session ::regenerate();

        //Stocker les infos de session
        Session::set('role', $user['label']);
        Session::set('user_id', $user['user_id']);
        Session::set('first_name', $user['first_name']);
        Session::set('email', $user['email']);

        //Redirection en fonction du rôle
        match($user['label'])
        {
            'administrateur' => header('Location: /admin'),
            'employe' => header('Location: /employe'),
            default => header('Location: /mon-espace')
        };
        exit();
    }

    //GET /deconnexion
    public function logout(): void
    {
        Session::destroy();
        header('Location: /connexion');
        exit();
    }

    //GET /inscription - affiche le formulaire
    public function showRegisterForm(): void 
    {
        $pageTitle = 'Inscription - Vite & Gourmand';
        $h1 = 'Formulaire d\'inscription';
        require_once __DIR__ . '/../../views/auth/register.php';
    }
    //POST /inscription - traite le formulaire
    public function register(): void 
    {
        $errors = [];

        //Récupération des données
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $streetNumber = trim($_POST['street_number'] ?? '');
        $streetType = trim($_POST['street_type'] ?? '');
        $streetName = trim($_POST['street_name'] ?? '');
        $zipCode = trim($_POST['zip_code'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConf = $_POST['password_confirm'] ?? '';
        $consent = $_POST['consent'] ?? '';

        //Validation des données
        if (empty($firstName))
            $errors[] = 'Le prénom est obligatoire';

        if (empty($lastName))
            $errors[] = 'Le nom est obligatoire';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'L\'adresse mail est invalide';

        if (!$this->authServices->validatePasswordStrength($password))
            $errors[] = 'Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
        
        if ($password !== $passwordConf)
            $errors[] = 'Les mots de passe ne correspondent pas';

        if (empty($consent))
            $errors[] = 'Vous devez accepter la politique de confidentialité';

        //Vérifier si l'email existe déjà
        if (empty($errors) && $this->userModel->findByMail($email) !== null)
            $errors[] = 'Cette adresse email est déjà utilisée';

        
        //S'il y a des erreurs - réaffiche le formulaire
        if (!empty($errors)){
            $pageTitle = 'Inscription - Vite & Gourmand';
            $h1 = 'Formulaire d\'inscription';
            require_once __DIR__ . '/../../views/auth/register.php';
            return;
        }

        // Créer le compte
        $userId = $this->userModel->createUser([
            'public_token' => $this->authServices->generateUUID(), 
            'email' => $email, 
            'password' => $this->authServices->hashPassword($password), 
            'last_name' => $lastName,
            'first_name' => $firstName,
            'phone' => $phone,
            'street_number' => $streetNumber,
            'street_type' => $streetType,
            'street_name' => $streetName,
            'zip_code' => $zipCode,
            'city' => $city,
            'country' => $country,
            'role_id' => 1 //client par défaut 
        ]);

        //Implementer l'envoie du mail de bienvenue

        //Redirection
        header('Location: /');
        exit();
    }

    public function passwordForgotten(): void 
    {
        $pageTitle = 'Mot de passe oublié - Vite & Gourmand';
        $h1 = 'Demande d\'un nouveau mot de passe';
        require_once __DIR__ . '/../../views/auth/password_forgotten.php';
    }

    public function requestModifyPassword(): void
    {
        //Implementer la demande de nouveau mot de passe
        //Implementer l'envoi du mail pour acceder à la page de resetPassword
        
        //Redirection
        header('Location: /');
        exit();
    }

    public function showResetPasswordForm(): void 
    {
        $pageTitle = 'Réinitialiser le mot de passe - Vite & Gourmand';
        $h1 = 'Réinitialisation du mot de passe';
        require_once __DIR__ . '/../../views/auth/password_reset_form.php';
    }

    public function resetPassword(): void 
    {
        // Logique de réinitialisation du mot de passe

        //Redirection vers la page de connexion
        header('Location: /connexion');
        exit();
    }
}