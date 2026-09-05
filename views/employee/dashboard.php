<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main>
    <section class="section-dashboard-employee">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <div class="col-12">
                <form action="/employe/mot-de-passe" method="POST">
                        <button type="submit" class="btn btn-dashboard">Modifier mon mot de passe</button>
                </form>
                </div>

                <div class="col-12 col-xl-6">
                    <a href="/employe/commandes" class="btn btn-dashboard">Gérer les commandes</a>
                </div>
                
                <div class="col-12 col-xl-6">
                    <a href="/employe/avis" class="btn btn-dashboard">Gérer les avis</a>
                </div>

                <div class="col-12 col-xl-6">
                    <a href="/employe/menus" class="btn btn-dashboard">Gérer les menus</a>
                </div>

                <div class="col-12 col-xl-6">
                    <a href="/employe/plats" class="btn btn-dashboard">Gérer les plats</a>
                </div>

                <div class="col-12 col-xl-6">
                    <a href="/employe/contenus" class="btn btn-dashboard">Gérer les contenus</a>
                </div>

                <div class="col-12 col-xl-6">
                    <a href="/employe/contact" class="btn btn-dashboard">Voir les messages clients</a>
                </div>
            </div>
        </div>
    </section>
</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>