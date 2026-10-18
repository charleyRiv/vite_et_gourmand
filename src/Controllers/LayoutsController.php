<?php

class LayoutsController
{
    public function header(): void
    {
        header('Content-Type: text/html');
        readfile(__DIR__ . '/../../views/layouts/header.html');
        exit();
    }

    public function footer(): void
    {
        header('Content-Type: text/html');
        readfile(__DIR__ . '/../../views/layouts/footer.html');
        exit();
    }

    public function hero(): void
    {
        header('Content-Type: text/html');
        readfile(__DIR__ . '/../../views/layouts/hero.html');
        exit();
    }
}