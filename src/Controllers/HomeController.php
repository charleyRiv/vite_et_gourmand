<?php
/**
 * @package home_package
 */

require_once __DIR__ . '/../Models/ReviewModel.php';
require_once __DIR__ . '/../Models/ContentModel.php';
class HomeController {

    private ReviewModel $reviewModel;
    private ContentModel $contentModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->contentModel = new ContentModel();
    }
    public function index(): void{

        //récuperer les contenus
        $page = 'home';
        $contents = $this->contentModel->getByFilter($page, null);
        
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