<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main>
    <section class="section-dashboard-admin">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 text-center">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/employes" class="btn btn-dashboard">Gérer les comptes employés</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/statistiques" class="btn btn-dashboard">Pilotage</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/commandes" class="btn btn-dashboard">Gérer les commandes</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/avis" class="btn btn-dashboard">Gérer les avis</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/menus" class="btn btn-dashboard">Gérer les menus</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/plats" class="btn btn-dashboard">Gérer les plats</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/admin/contenus" class="btn btn-dashboard">Gérer les contenus</a>
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <a href="/employe/contact" class="btn btn-dashboard">Voir les messages clients</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>