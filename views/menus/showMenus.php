<?php
/**
 * @var array $menu
 * @var array $dishes
 * @var int $h1
 * @var array $picture
 * @var string $heroImage
 */
require_once __DIR__ . '/../layouts/header.php';

$heroTitle = htmlspecialchars($h1);
$heroImage    = '/assets/images/uploads/hero_banner_charte_001.jpeg';
require_once __DIR__ . '/../layouts/hero.php';
?>

<main class="page-menu-details">
    <section class="section-menu-details">
        <div class="container">
            <div class="row">
                <div class="col-12 description">
                    <p><?= htmlspecialchars($menu['description']) ?></p>
                </div>
                <div class="row g-0 mb-0 categorie">
                    <div class="col-12 col-lg-auto">
                        <p>Thème : <?= htmlspecialchars($menu['theme']) ?></p>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <p>Régime : <?= htmlspecialchars($menu['diet']) ?></p>
                    </div>
                </div>

                <!-- Carousel photos du menu -->
                <?php if (!empty($menu['pictures'])): ?>
                <div class="col-12 mb-4 d-lg-none">
                    <div id="menuCarousel" class="carousel slide" data-bs-ride="carousel">
                
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <?php foreach ($menu['pictures'] as $index => $picture): ?>
                                <button 
                                    type="button" 
                                    data-bs-target="#menuCarousel" 
                                    data-bs-slide-to="<?= $index ?>"
                                    class="<?= $index === 0 ? 'active' : '' ?>"
                                    aria-label="Photo <?= $index + 1 ?>"
                                ></button>
                            <?php endforeach; ?>
                        </div>
                            
                        <!-- Slides -->
                        <div class="carousel-inner">
                            <?php foreach ($menu['pictures'] as $index => $picture): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img 
                                        src="<?= htmlspecialchars($picture['url']) ?>"
                                        alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                                        class="d-block w-100 carousel-img"
                                    >
                                </div>
                            <?php endforeach; ?>
                        </div>
                            
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" 
                            data-bs-target="#menuCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" 
                            data-bs-target="#menuCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                            
                    </div>
                </div>
                <?php endif; ?>

                <div class="row g-0 mb-0">
                    <?php foreach ($dishes as $dish): ?>
                    <div class="col-12 col-lg-4">
                        <article class="menu-dish">
                            <!-- photos -->
                            <div class="col-12">
                                <!-- Photo - cachée en dessous de lg -->
                                <div class="col-12 d-none d-lg-block">
                                    <?php if (!empty($dish['picture'])): ?>
                                        <img 
                                            src="<?= $dish['picture']['url'] ?>"
                                            alt="<?= $dish['picture']['alt_text'] ?>"
                                            class="menu-picture-dish"
                                        >
                                    <?php else : ?>
                                        <p>Image indisponible</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        
                            <!-- infos plat -->
                            <div class="menu-details">
                                <div class="col-12 mb-3">
                                    <h3><?= htmlspecialchars($dish['dish_type']) ?></h3>
                                </div>
                                <div class="col-12 mb-3">
                                    <p><?= htmlspecialchars($dish['title']) ?></p>
                                </div>
                                <div class="col-12 mb-3">
                                    <p><?= htmlspecialchars($dish['description']) ?></p>
                                </div>

                                <!-- ajout allergenes -->
                                <?php if (!empty($dish['allergens'])): ?>
                                    <div class="col-12 menu-allergen">
                                        allergene : <?= htmlspecialchars(implode(', ', array_column($dish['allergens'], 'label'))) ?>
                                    </div>
                                <?php endif ;?>
                            </div>

                        </article>
                    </div>
                    <?php endforeach ;?>

                </div>

                <div class="row g-0 mb-0 menu-infos">
                    <div class="col-12 col-lg-auto">
                        <p><?= htmlspecialchars($menu['price_per_person']) ?>€/ personne</p>
                    </div>
                    <div class="col-12 col-lg-auto">
                        <p>Minimum <?= htmlspecialchars($menu['min_persons']) ?> personnes</p>
                    </div>
                    <div class="col-12 col-lg-auto">
                    <p>Stock : <?php if ($menu['remaining_stock'] === 0): ?>
                                    <span>Bientôt disponible</span>
                                <?php else: ?>
                                    <?= htmlspecialchars($menu['remaining_stock']) ?> disponible(s)
                                <?php endif; ?></p>
                    </div>
                </div>
                <div class="col-12 menu-condition">
                    <p>Conditions de réservation: <?= htmlspecialchars($menu['conditions']) ?></p>
                </div>
                <div class="row g-0 mb-0 menu-commande">
                    <div class="col-12 col-lg-auto justify-content-flex-end">
                        <a href="/commande/etape-1?menu_id=<?= $menu['menu_id'] ?>" class="btn btn-primary">Commander</a>
                    </div>
                    <div class="col-12 col-lg-auto justify-content-flex-start">
                        <a href="/menus">Revenir à la liste des menus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>