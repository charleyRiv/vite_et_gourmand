<?php
/**
 * @package contact_package
 */

require_once __DIR__ . '/../Services/MailService.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/ContactModel.php';

class ContactController {

    private MailService $mailService;
    private UserModel $userModel;
    private ContactModel $contactModel;
    public function __construct()
    {
        $this->mailService = new MailService();
        $this->userModel = new UserModel();
        $this->contactModel = new ContactModel();
    }

    public function showContactHtml(): void
    {
        readfile(__DIR__ . '/../../views/contact/contact.html');
        exit();
    }

    public function sendContact(): void
    {
        header('Content-Type: application/json');

        $data = [
            'email' => trim($_POST['email'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? '')
        ];

        if (empty($data['email']) || empty($data['title']) || empty($data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Tous les champs sont obligatoires']);
            exit();
        }

        $this->contactModel->send($data);
        $this->mailService->sendContactNotification($data);

        echo json_encode(['success' => true]);
        exit();
    }
    public function showContactForm(): void
    {
        if (Session::isLoggedIn()){
            $user = $this->userModel->findById(Session::get('user_id'));
        }

        $pageTitle = 'Contact - Vite & Gourmand';
        $h1 = 'Nous contacter';
        $extraJs = ['/assets/js/contact/contact.js'];
        require_once __DIR__ . '/../../views/contact/contact.php';
    }

    public function contact(): void
    {
        //Récupération des données formulaire
        $data = [
            'email' => trim($_POST['email']),
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content'])
        ];


        $this->contactModel->send($data);
        $this->mailService->sendContactNotification($data);
        //Redirection
        header('Location: /');
        exit();
    }
}