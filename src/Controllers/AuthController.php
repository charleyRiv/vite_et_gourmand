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
        $extraJs = ['/assets/js/auth/login.js'];

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
        $extraJs = ['/assets/js/auth/register.js'];
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

        //Envoyer un mail de bienvenue
        $this->mailService->sendWelcome($email, $firstName);

        //Redirection
        header('Location: /');
        exit();
    }

    public function passwordForgotten(): void 
    {
        $email = '';
        if (Session::isLoggedIn()) {
            $email = Session::get('email') ?? '';
        }
        $pageTitle = 'Mot de passe oublié - Vite & Gourmand';
        $h1 = 'Demande d\'un nouveau mot de passe';
        $extraJs = ['/assets/js/auth/password_forgotten.js'];
        require_once __DIR__ . '/../../views/auth/password_forgotten.php';
    }
    //POST /mot-de-passe-oublie
    public function requestModifyPassword(): void
    {
        $email = trim($_POST['email'] ?? '');
        $errors = [];
        $succes = false;

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Veuillez saisir une adresse email valide.';
        }

        if (empty($errors)){
            $user = $this->userModel->findByMail($email);

            //Sécurite: même message si l'email existe ou non
            //pour ne pas révéler si un compte existe
            if ($user !== null){
                $token = $this->authServices->generateToken();
                //$expiration = gmdate('Y-m-d H:i:s', strtotime('+5 minutes'));

                $this->userModel->setResetToken($email, $token);
                $this->mailService->sendPasswordReset($email, $token);
            }
            $succes = true;
        }

        $pageTitle = 'Mot de passe oublié - Vite & Gourmand';
        $h1 = 'Demande d\'un nouveau mot de passe';
        $extraJs = ['/assets/js/auth/reset_password_form.js'];

        require_once __DIR__ . '/../../views/auth/password_forgotten.php';
        
    }

    //GET /mot-de-passe-oublie/reinitialisation
    public function showResetPasswordForm(): void 
    {   
        $token = $_GET['token'] ?? '';
        $errors = [];


        if (empty($token)){
            header('Location: /mot-de-passe-oublie');
            exit();
        }

        //Verfier que le token est valide
        $user = $this->userModel->findByResetToken($token);
        if ($user === null){
            $errors[] = 'Ce lien a expiré ou est invalide. Veuillez faire une nouvelle demande';
        }
        
        $pageTitle = 'Réinitialiser le mot de passe - Vite & Gourmand';
        $h1 = 'Réinitialisation du mot de passe';
        $extraJs = ['/assets/js/auth/reset_password_form.js'];
        require_once __DIR__ . '/../../views/auth/password_reset_form.php';
    }

    // POST /mot-de-passe-oublie/reinitialisation
    public function resetPassword(): void 
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConf = $_POST['password_confirm'] ?? '';
        $errors = [];

        //Verifier le token
        $user = $this->userModel->findByResetToken($token);

        if ($user === null){
            $errors[] = 'Ce lien a expiré ou est invalide. Veuillez faire une nouvelle demande';
            $pageTitle = 'Réinitialiser le mot de passe - Vite & Gourmand';
            $h1 = 'Réinitialisation du mot de passe';
            require_once __DIR__ . '/../../views/auth/password_reset_form.php';
            return;
        }

        //Valider le mot de passe
        if (!$this->authServices->validatePasswordStrength($password)) {
            $errors[] = 'Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
        }

        if ($password !== $passwordConf){
            $errors[] = 'Les mots de passe ne correspondent pas';
        }

        //S'il y a des erreurs
        if(!empty($errors)){
            $pageTitle = 'Réinitialiser le mot de passe - Vite & Gourmand';
            $h1 = 'Réinitialisation du mot de passe';
            require_once __DIR__ . '/../../views/auth/password_reset_form.php';
            return;
        }

        //Mettre à jour le mot de passe et invalider le token
        $this->userModel->updatePassword(
            $user['user_id'],
            $this->authServices->hashPassword($password)
        );

        //Redirection vers la page de connexion
        header('Location: /connexion?reset=1');
        exit();
    }
}