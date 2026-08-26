<?php
/**
 * @var string $h1
 * @var array $reviews
 * @var array $contents
 * @var string $heroImage
 */

require_once __DIR__ . '/../layouts/header.php';

$heroTitle = htmlspecialchars($h1);
$heroImage    = '/assets/images/uploads/hero_banner_charte_001.jpeg';
require_once __DIR__ . '/../layouts/hero.php';

?>


<main class="page-home">

    <section class="section-home">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-center"><?= nl2br(htmlspecialchars($contents[0]['content'] ?? '')) ?></p>
                </div>
            </div>
            <div class="row gx-5 justify-content-around">
                <div class="col-auto">
                    <a href = '/menus' class="btn btn-primary">Voir les menus</a>
                </div>
                <div class="col-auto">
                    <a href = '/commande/etape-1' class="btn btn-primary">Commander</a>
                </div>
            </div>
        </div>
    </section>
    <section class="section-team">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-xl-6">
                    <img src="/assets/images/uploads/equipe_photo_001.webp" 
                        alt="Julie et José, fondateurs de Vite & Gourmand, souriants dans leur cuisine professionnelle, préparant et dressant des plats avec des ingrédients frais disposés sur le plan de travail."
                        width="300"
                        class="img-fluid w-100"
                        >
                </div>
                <div class="col-12 col-xl-6">
                    <p class="text-center"><?= nl2br(htmlspecialchars($contents[1]['content'] ?? ''))?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="section-avis">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Les avis de nos clients</h4>
                </div>
            </div>
            <div class="row">
                <?php foreach ($reviews as $review) : ?>
                    <div class="col-12 col-xl-4">
                        <article class="home-avis-client">
                            <!-- Nom + rating -->
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto text-info">
                                    <p class="mb-0"><?= htmlspecialchars($review['first_name'])?> <?= htmlspecialchars($review['last_name'])?></p>
                                </div>
                                <div class="col-auto">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review['rating']): ?>
                                            <img src="/assets/images/uploads/icone_starOn.svg" alt="étoile" class="etoile mb-1">
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <?= htmlspecialchars($review['rating'])?>/5
                                </div>
                            </div>

                            <!-- Commentaire -->
                            <div class="row">
                                <div class="col-12">
                                    <p class="align-text-left mb-0"><?= nl2br(htmlspecialchars($review['comment']))?></p>
                                </div>
                            </div>

                            <hr class="separator">

                            <!-- Date et lien -->
                            <div class="row justify-content-between align-items-center text-info">
                                <div class="col-auto">
                                    <p class="mb-0">Il y a <?= $review['since'] ?></p>
                                </div>
                                <div class="col-auto">
                                    <a href ="/menus/<?= $review['menu_id']?>">Voir le menu</a>
                                </div>
                            </div>
                        </article> 
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>