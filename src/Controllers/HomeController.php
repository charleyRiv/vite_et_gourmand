<?php
/**
 * @package home_package
 */

require_once __DIR__ . '/../Models/ReviewModel.php';
class HomeController {

    private ReviewModel $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }
    public function index(): void{

        //Récupérer les avis clients
        $reviews = $this->reviewModel->getAllValidated();


        foreach ($reviews as &$review) {
            $review['since'] = $this->reviewModel->formatDiffDate($review['reviewed_at']);
        }
        unset($review);

        $pageTitle = 'Accueil - Vite et Gourmand';
        $h1 = 'Accueil';
        require_once __DIR__ . '/../../views/home/home.php';
    }
}