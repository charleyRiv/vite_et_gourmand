<?php
/**
 * @var array $menus
 * @var string $h1
 * @var array $allergens
 * @var array $themes
 * @var array $diets
 * @var array $pictures
 * @var string $heroImage
 * @var int $totalPages
 * @var int $currentPage
 */

require_once __DIR__ . '/../layouts/header.php';

$heroTitle = htmlspecialchars($h1);
$heroImage    = '/assets/images/uploads/hero_banner_charte_001.jpeg';
require_once __DIR__ . '/../layouts/hero.php';

?>
<main class="page-menus">
    <section class="menus-filters">
        <!-- Bouton filtre-->
        <div class="d-flex">
                <button type="button" class="btn btn-filters" id="btn-filters">
                    Filtres <i class="bi bi-chevron-compact-down"></i>
                </button>
        </div>

        <!-- Aside filtres -->
        <div class="filters-aside" id="filters-aside">
            <div class="filters-aside-header">
                <h4 class="mb-0">Filtres</h4>
                <button type="button" class="btn-close" id="btn-close-filters"></button>
            </div>

            <form action="/menus" method="get" id="filtres-form">
                <!-- Section Prix -->
                <div class="container">
                    <div class="row">
                        <div class="col-12 price-filter">
                            <div class="col-12">
                                <h4>Prix</h4>
                            </div>
                            <div class="col-12 price-range">
                                <div class="price-labels">
                                    <span id="prix_min_label"><?= htmlspecialchars($_GET['prix_min'] ?? '0') ?> €</span>
                                    <span id="prix_max_label"><?= htmlspecialchars($_GET['prix_max'] ?? '0') ?> €</span>
                                </div>
                                <div class="price-slider">
                                    <input type="range" id="prix_min" name="prix_min" min="0" max="200" step="5" 
                                    value="<?= htmlspecialchars($_GET['prix_min'] ?? '0') ?>">
                                    <input type="range" id="prix_max" name="prix_max" min="0" max="200" step="5" 
                                    value="<?= htmlspecialchars($_GET['prix_max'] ?? '200') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Section Thème -->
                        <div class="col-12 theme-filter">
                            <div class="col-12">
                                <h4>Thème</h4>
                            </div>
                            <?php foreach ($themes as $theme): ?>
                            <div class="col-auto">
                                <label>
                                    <input 
                                        type="checkbox" 
                                        name="themes[]" 
                                        value="<?= $theme['theme_id']?>"
                                        <?= in_array($theme['theme_id'], $_GET['themes'] ?? []) ? 'checked' : '' ?>
                                    >
                                    <?= $theme['label'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
    
                        <!-- Section Régime -->
                        <div class="col-12 diet-filter">
                            <div class="col-12">
                                    <h4>Régime alimentaire</h4>
                                </div>
                            <?php foreach ($diets as $diet): ?>
                            <div class="col-auto">
                                <label>
                                    <input 
                                        type="checkbox" 
                                        name="diets[]" 
                                        value="<?= $diet['diet_id']?>"
                                        <?= in_array($diet['diet_id'], $_GET['diets'] ?? []) ? 'checked' : '' ?>
                                    >
                                    <?= $diet['label'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>                        
                        </div>

                    <!-- Section Nombre de personnes -->
                    <div class="col-12 pers-filter">
                        <div class="col-6">
                            <h4>Nombre de personnes</h4>
                        </div>
                        <div class="col-6">
                            <input 
                                type="number" 
                                id="nb_persons" 
                                name="nb_persons" 
                                min="1" 
                                max="300" 
                                value="<?= htmlspecialchars($_GET['nb_persons'] ?? '20') ?>"
                            >
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Appliquer</button>
                    </div>
                    <div class="col-12">
                        <a href="/menus" class="btn btn-secondary w-100">Réinitialiser</a>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="filters-overlay" id="filters-overlay"></div>
    </section>
    <section class="section-menus">
        <div class="container">
            <div class="row g-4">
                <?php if (empty($menus)): ?>
                    <div class="col-12">
                        <p class="mb-0">Aucun menu disponible pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($menus as $menu): ?>
                        <div class="col-12 col-lg-6">
                            <article class="menus">
                            <!-- Photo du plat principale - A utiliser comme fond de la zone -->
                            <?php if (!empty($pictures)): ?>
                                <div class="menus-overlay" style="background-image: url(<?= htmlspecialchars($pictures['url']) ?>)">
                            <?php endif;?>
                                    <div class="col-12">
                                        <h3><?= htmlspecialchars($menu['title']) ?></h3>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-0"><?= htmlspecialchars($menu['description']) ?></p>
                                    </div>
                                    <hr class="separator">
                                    <div class="col-12 text-lg-end">
                                        <p class="mb-0"><?= htmlspecialchars($menu['price_per_person']) ?> € / personne</p>
                                    </div>
                                    <div class="col-12 text-lg-end">
                                        <p class="mb-0">Minimum <?= htmlspecialchars($menu['min_persons']) ?> personnes</p>
                                    </div>
                                    <div class="col-12 text-lg-start">
                                        <a href="/menus/<?= htmlspecialchars($menu['menu_id']) ?>" class="btn btn-primary">Voir le détail</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-auto text-end text-lg-start">
                    <a href="/commande/etape-1" class="btn btn-primary">Commander</a>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="col-12 col-lg-auto text-center text-lg-end">
                    <nav aria-label="Pagination des menus">
                        <ul class="pagination">

                            <!-- Précédent -->
                            <?php
                            $queyParams = $_GET;
                            $queyParams['page'] = $currentPage - 1;
                            ?>
                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $currentPage -1 ?>">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <!-- Pages -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- Suivant -->
                            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $currentPage + 1 ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--
        <a href="">Precedent</a>
        <a href="">Suivant</a>
        <a href="">n°page</a>/nbr page totales
    </div-->
</main>
<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>