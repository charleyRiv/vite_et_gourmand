<?php
/**
 * @package legal_package
 */
class LegalController {
    public function legal(): void{
        $pageTitle = 'Mentions légales - Vite & Gourmand';
        $h1 = 'Mentions légales';
        require_once __DIR__ . '/../../views/legal/legal.php';
    }
}