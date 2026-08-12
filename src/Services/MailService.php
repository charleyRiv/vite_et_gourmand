<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailService {

    private PHPMailer $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        // Configuration SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAIL_USER'];
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $_ENV['MAIL_PORT'];
        $this->mailer->CharSet = 'UTF-8';

        // Expéditeur par défaut
        $this->mailer->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );
    }

    /**
     * Mail de bienvenue à l'inscription
     */
    public function sendWelcome(string $email, string $firstName): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Bienvenue sur Vite & Gourmand !';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Bienvenue {$firstName} !</h1>
                <p>Votre compte a bien été créé sur Vite & Gourmand.</p>
                <p>Vous pouvez dès maintenant consulter nos menus et passer commande.</p>
                <p>À bientôt,<br>Julie et José, L'équipe Vite & Gourmand</p>
            ";
            $this->mailer->AltBody = "Bienvenue {$firstName} ! Votre compte a bien été créé.";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur mail bienvenue : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mail de confirmation de commande
     */
    public function sendOrderConfirmation(string $email, array $orderData): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Confirmation de votre commande - Vite & Gourmand';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Votre commande est confirmée !</h1>
                <p>Merci pour votre commande. Voici le récapitulatif :</p>
                <ul>
                    <li>N° de commande : {$orderData['order_id']}</li>
                    <li>Menu : {$orderData['menu_title']}</li>
                    <li>Nombre de personnes : {$orderData['nb_persons']}</li>
                    <li>Date de prestation : {$orderData['event_date_fr']}</li>
                    <li>Heure de livraison : {$orderData['delivery_time_fr']}</li>
                    <li>Adresse de livraison : {$orderData['delivery_street_number']} 
                    {$orderData['delivery_street_type']} {$orderData['delivery_street_name']}, 
                    {$orderData['delivery_zip_code']} {$orderData['delivery_city']}, 
                    {$orderData['delivery_country']}
                    <li>Prix total : {$orderData['total_price']}€</li>
                </ul>
                <p>Notre équipe va prendre en charge votre commande.</p>
                <p>À bientôt,<br>Julie et José, l'équipe Vite & Gourmand</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur mail confirmation commande : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mail de réinitialisation du mot de passe
     */
    public function sendPasswordReset(string $email, string $token): bool {
        try {
            $resetLink = $_ENV['APP_URL'] . '/mot-de-passe-oublie/reinitialisation?token=' . $token;
            $this->mailer->setFrom('noreply@viteetgourmand.fr', 'Vite & Gourmand');
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Réinitialisation de votre mot de passe - Vite & Gourmand';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Réinitialisation de mot de passe</h1>
                <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
                <p>Cliquez sur le lien ci-dessous pour le réinitialiser :</p>
                <p><a href='{$resetLink}'>Réinitialiser mon mot de passe</a></p>
                <p>Ce lien est valable <strong>5 minutes</strong>.</p>
                <p>Si vous n'êtes pas à l'origine de cette demande, ignorez ce mail.</p>
                <p>L'équipe Vite & Gourmand</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur envoi mail resrt : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mail d'invitation à donner un avis
     */
    public function sendReviewInvitation(string $email, string $firstName): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Donnez votre avis - Vite & Gourmand';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Votre avis nous intéresse !</h1>
                <p>Bonjour {$firstName},</p>
                <p>Votre commande est maintenant terminée. Nous espérons que vous avez apprécié notre prestation.</p>
                <p>N'hésitez pas à nous laisser un avis depuis votre espace client.</p>
                <p>Merci pour votre confiance,<br>L'équipe Vite & Gourmand</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur mail invitation avis : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mail retour de matériel
     */
    public function sendMaterialReturn(string $email, string $firstName): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Retour de matériel - Vite & Gourmand';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Retour de matériel</h1>
                <p>Bonjour {$firstName},</p>
                <p>Du matériel vous a été prêté lors de votre prestation.</p>
                <p>Merci de le restituer dans un délai de <strong>10 jours ouvrés</strong>.</p>
                <p>Sans retour de votre part dans ce délai, des frais de <strong>600€</strong> 
                vous seront facturés conformément à nos conditions générales de vente.</p>
                <p>Pour organiser le retour, contactez-nous directement.</p>
                <p>L'équipe Vite & Gourmand</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur mail retour matériel : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mail de création de compte employé
     */
    public function sendEmployeeCreated(string $email): bool {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Création de votre compte employé - Vite & Gourmand';
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h1>Votre compte employé a été créé</h1>
                <p>Un compte employé vient d'être créé pour vous sur l'application Vite & Gourmand.</p>
                <p>Votre identifiant de connexion est cette adresse mail : <strong>{$email}</strong></p>
                <p>Pour obtenir votre mot de passe, rapprochez-vous de l'administrateur.</p>
                <p>L'équipe Vite & Gourmand</p>
            ";
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log('Erreur mail création employé : ' . $e->getMessage());
            return false;
        }
    }
}