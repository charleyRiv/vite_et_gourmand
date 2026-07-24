<?php
/**
 * @package auth_package
 */
class AuthController {
    public function showLoginForm(): void 
    {
        $pageTitle = 'Connexion - Vite & Gourmand';
        $h1 = 'Formulaire de connexion - From controller';
        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function login(): void 
    {
        // Logique de connexion

        //Redirection
        header('Location : /');
        exit();
    }

    public function showRegisterForm(): void 
    {
        $pageTitle = 'Inscription - Vite & Gourmand';
        $h1 = 'Formulaire d\'inscription - From controller';
        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function register(): void 
    {
        // Logique d'inscription

        //Redirection
        header('Location : /');
        exit();
    }

    public function passwordForgotten(): void 
    {
        $pageTitle = 'Mot de passe oublié - Vite & Gourmand';
        $h1 = 'Mot de passe oublié ? - From controller';
        require_once __DIR__ . '/../../views/auth/password_forgotten.php';
    }

    public function requestModifyPassword(): void
    {
        //Implementer la demande de nouveau mot de passe
        //Implementer l'envoi du mail pour acceder à la page de resetPassword 
    }

    public function showResetPasswordForm(): void {
        $pageTitle = 'Réinitialiser le mot de passe - Vite & Gourmand';
        $h1 = 'Formulaire de réinitialisation du mot de passe - From controller';
        require_once __DIR__ . '/../../views/auth/password_reset_form.php';
    }

    public function resetPassword(): void {
        // Logique de réinitialisation du mot de passe

        //Redirection vers la page de connexion
        header('Location: /connexion');
    }
}