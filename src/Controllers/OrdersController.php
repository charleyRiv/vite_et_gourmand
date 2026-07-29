<?php
/**
 * @package orders_package
 */
class OrdersController {
    public function step1(): void 
    {
        $pageTitle = 'Commandes - etape-1 - Vite & Gourmand';
        $h1= 'Commander - Etape 1/4';
        require_once __DIR__ . '/../../views/orders/step1.php';
    }

    public function storeStep1(): void 
    {
        // Récupérer les données du formulaire
        //$formData = $_POST;

        // Stocker les données dans la session
        //$_SESSION['order_step1'] = $formData;

        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-2');
        exit();
    }

    public function step2(): void 
    {
        //Vérifier que l'étape 1 a été complétée avant d'accéder à l'étape 2
        //if (!isset($_SESSION['order_step1'])) {
        //    // Rediriger vers l'étape 1 si l'étape 1 n'a pas été complétée
        //    header('Location: /orders/step-1');
        //    exit();
        //}
        $pageTitle = 'Commandes - etape-2 - Vite & Gourmand';
        $h1= 'Commander - Etape 2/4';
        require_once __DIR__ . '/../../views/orders/step2.php';
    }

        public function storeStep2(): void 
        {
        // Récupérer les données du formulaire
        //$formData = $_POST;

        // Stocker les données dans la session
        //$_SESSION['order_step2'] = $formData;

        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-3');
        exit();
    }

    public function step3(): void 
    {
        //Vérifier que l'étape 2 a été complétée avant d'accéder à l'étape 3
        //if (!isset($_SESSION['order_step2'])) {
        //    // Rediriger vers l'étape 2 si l'étape 2 n'a pas été complétée
        //    header('Location: /orders/step-2');
        //    exit();
        //}
        $pageTitle = 'Commandes - etape-3 - Vite & Gourmand';
        $h1= 'Commander - Etape 3/4';
        require_once __DIR__ . '/../../views/orders/step3.php';
    }

    public function storeStep3(): void 
    {
        // Récupérer les données du formulaire
        //$formData = $_POST;

        // Stocker les données dans la session
        //$_SESSION['order_step3'] = $formData;

        // Rediriger vers l'étape suivante
        header('Location: /commande/etape-4');
        exit();
    }

    public function step4(): void 
    {
        //Vérifier que l'étape 3 a été complétée avant d'accéder à l'étape 4
        //if (!isset($_SESSION['order_step3'])) {
        //    // Rediriger vers l'étape 3 si l'étape 3 n'a pas été complétée
        //    header('Location: /orders/step-3');
        //    exit();
        //}
        $pageTitle = 'Commandes - etape-4 - Vite & Gourmand';
        $h1= 'Commander - Etape 4/4';
        require_once __DIR__ . '/../../views/orders/step4.php';
    }

    public function storeStep4(): void 
    {
        // Récupérer les données du formulaire
        //$formData = $_POST;

        // Stocker les données dans la session
        //$_SESSION['order_step4'] = $formData;

        // Rediriger vers l'étape suivante
        header('Location: /commande/confirmation');
        exit();
    }

    public function confirmation(): void 
    {
        //Vérifier que l'étape 4 a été complétée avant d'accéder à la confirmation
        //if (!isset($_SESSION['order_step4'])) {
        //    // Rediriger vers l'étape 4 si l'étape 4 n'a pas été complétée
        //    header('Location: /orders/step-4');
        //    exit();
        //}

        //Donnée fictive. A remplacer
        $idOrder = 010101010;
        $pageTitle = 'Commandes - confirmation - Vite & Gourmand';
        $h1= 'Commande n°' . $idOrder;
        require_once __DIR__ . '/../../views/orders/confirmation.php';
    }
}