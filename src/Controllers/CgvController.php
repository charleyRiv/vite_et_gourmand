<?php
/**
 * @package cgv_package
 */
class CgvController {
    public function cgv(): void{
        $pageTitle = 'Conditions générales de vente - Vite & Gourmand';
        $h1 = 'Conditions générales de vente';
        require_once __DIR__ . '/../../views/cgv/cgv.php';
    }
}