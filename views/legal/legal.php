<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main class="page-legal">
    <section class="section-legal">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?= htmlspecialchars($h1) ?></h1>
                </div>

                <div class="col-12">
                    <h4>Editeur du site</h4>
                </div>
                <div>
                    <p>Raison sociale : Vite & Gourmand <br>
                        Forme juridique : SARL <br>
                        Capital social : 50 000,00 EUROS <br>
                        Siège social : 12 rue de la Liberté, 33000 Bordeaux, France <br>
                        Numéro SIRET : 111 111 111 R.C.S Paris <br>
                        Numéro TVA intracommunautaire : FR1111111111 <br>
                        Téléphone : 05 05 05 05 05 <br>
                        Email : contact@viteetgourmand.fr 
                    </p>
                </div>

                <div class="col-12">
                    <h4>Directeur de la publication</h4>
                </div>
                <div>
                    <p>José José</p>
                </div>

                <div class="col-12">
                    <h4>Hébergeur</h4>
                </div>
                <div>
                    <p>Nom : Heroku (Salesforce Inc.) <br>
                        Adresse : 415 Mission Street, Suite 300, San Francisco, CA 94105, États-Unis <br>
                        Site : heroku.com
                    </p>
                </div>

                <div class="col-12">
                    <h4>Propriété intellectuelle</h4>
                </div>
                <div>
                    <p>L'ensemble des contenus présents sur ce site (textes, images, graphismes, 
                        logo, icônes) est la propriété exclusive de Vite & Gourmand et est protégé 
                        par les lois françaises et internationales relatives à la propriété intellectuelle. 
                        Toute reproduction, représentation, modification ou exploitation partielle ou totale des contenus 
                        sans autorisation expresse et préalable de Vite & Gourmand est strictement interdite.
                    </p>
                </div>

                <div class="col-12">
                    <h4>Données personnelles</h4>
                </div>
                <div>
                    <p>Conformément au Règlement Général sur la Protection des Données (RGPD - Règlement UE 2016/679) 
                        et à la loi Informatique et Libertés du 6 janvier 1978 modifiée, vous disposez d'un droit d'accès, 
                        de rectification, d'effacement et de portabilité de vos données personnelles. Pour exercer ces droits, 
                        vous pouvez contacter Vite & Gourmand à l'adresse suivante : contact@viteetgourmand.fr 
                    </p>
                </div>

                <div class="col-12">
                    <h4>Cookies</h4>
                </div>
                <div>
                    <p>Ce site utilise des cookies techniques nécessaires à son bon fonctionnement. Aucun cookie publicitaire 
                        ou de tracking tiers n'est utilisé. 
                    </p>
                </div>

                <div class="col-12">
                    <h4>Responsabilité</h4>
                </div>
                <div>
                    <p>Vite & Gourmand s'efforce de fournir des informations aussi précises que possible sur ce site. 
                        Toutefois, elle ne pourra être tenue responsable des omissions, inexactitudes ou carences dans 
                        la mise à jour des informations, qu'elles soient de son fait ou du fait des tiers partenaires.
                    </p>
                </div>

                <div class="col-12">
                    <h4>Droit applicable</h4>
                </div>
                <div>
                    <p>Le présent site est soumis au droit français. 
                        En cas de litige, les tribunaux français seront seuls compétents.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>