<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-404">
    <section class="section-404">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Oups... Cette page s’est éclipsée!</h2>
                </div>
                <div class="col-12 image-grp">
                    <img src="/assets/images/uploads/404_error_002.png" 
                    alt="un personnage en dessin vectorielle habillé en tenu de cuisinier, 
                    l'air embarrassé, soulève une cloche et rélève une assiette vide">
                    <div class="image-text">
                        On a cherché partout, même dans nos recettes secrètes, mais la page que vous demandez est introuvable
                    </div>
                </div>
                <div class="col-auto">
                    Pas de panique ! Contrairement à nos menus, cette page ne sera pas livrée. <br>
                    Mais nos plats, eux, sont toujours au rendez-vous.
                </div>

                <div class="col">
                    <a href="/menus" class="btn btn-primary">Voir nos menus</a>
                </div>

                <div class="'col">
                    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>