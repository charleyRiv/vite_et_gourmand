<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-403">
    <section class="section-403">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Vous n’êtes pas sur la liste des invités!</h2>
                </div>
                <div class="col-12 image-grp">
                    <img src="/assets/images/uploads/403_error_001.png" 
                    alt="un personnage en dessin vectorielle habillé en tenu de cuisinier, 
                    l'air embarrassé, soulève une cloche et rélève une assiette vide">
                    <div class="image-text">
                        Cet espace est réservé à notre équipe. Comme nos menus secrets, 
                        certaines choses ne sont pas pour tout le monde... du moins pas encore !
                    </div>
                </div>
                <div class="col-auto">
                    Si vous êtes un client, connectez-vous à votre espace personnel. 
                    Si vous êtes un employé ou un administrateur, vérifiez vos identifiants 
                    de connexion.
                </div>

                <div class="col">
                    <a href="/connexion" class="btn btn-primary">Me connecter</a>
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