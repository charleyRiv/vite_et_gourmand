<?php
/**
 * @package contact_package
 */
class ContactController {
    public function showContactForm(): void
    {
        $pageTitle = 'Contact - Vite & Gourmand';
        $h1 = 'Formulaire de contact - From controller';
        require_once __DIR__ . '/../../views/contact/contact.php';
    }

    public function contact(): void
    {
        //Implementer l'envoi du formulaire de contact en methode POST

        //Redirection
        header('Location: /contact');
        exit();
    }
}