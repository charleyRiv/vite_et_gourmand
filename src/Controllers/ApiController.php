<?php

class ApiController
{
    public function session(): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'isLoggedIn' => Session::isLoggedIn(),
            'role'       => $_SESSION['role'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'email'      => Session::get('email'),
        ]);
        exit();
    }

    public function csrfToken(): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'token' => generateCsrfToken()
        ]);
        exit();
    }

    public function schedule(): void
    {
        header('Content-Type: application/json');

        require_once __DIR__ . '/../Models/ContentModel.php';
        $contentModel = new ContentModel();
        $schedule = $contentModel->getByFilter('footer', 'Horaires');

        echo json_encode([
            'content' => $schedule[0]['content'] ?? ''
        ]);
        exit();
    }

    public function homeContents(): void
    {
        header('Content-Type: application/json');
        require_once __DIR__ . '/../Models/ContentModel.php';
        $contentModel = new ContentModel();
        $contents = $contentModel->getByFilter('home', null);
        echo json_encode($contents);
        exit();
    }

    public function homeReviews(): void
    {
        header('Content-Type: application/json');
        require_once __DIR__ . '/../Models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getAllValidated();
        echo json_encode($reviews);
        exit();
    }
}