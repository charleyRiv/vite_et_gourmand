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
                <div class="row g-0 mb-0">
                    <?php foreach ($dishes as $dish): ?>
                    <div class="col-12 col-lg-4">
                        <article class="menu-dish">
                            <!-- photos -->
                            <div class="col-12">
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