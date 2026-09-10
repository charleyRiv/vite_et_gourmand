<?php
/**
 * @var string $h1
 * @var array $diets
 * @var array $themes
 * @var array $menus
 * @var array $statuses
 * @var int $totalPages
 * @var int $currentPage
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-employee-menus">
    <section class="section-filters">
        <div class="container">
            <h2><?=  htmlspecialchars($h1)?></h2>

            <form action="/employe/menus" method="GET">
                <div class="row filters">

                    <!-- Champs barre de recherche -->
                    <div class="col-12 col-xl-3 search">
                        <div class="search-wrapper">
                            <i class="bi bi-search"></i>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                placeholder="Rechercher ..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-xl-5">
                        <div class="row filters-checkbox">
                            <!-- Filtre Régime -->
                            <div class="row employee-diet-filter">
                                <div class="col-auto bouton">
                                    <button type="button" id="diet-filter-btn" class="btn btn-filters">
                                        Régime <i class="bi bi-chevron-compact-down"></i>
                                    </button>
                                </div> 
                                <div id="diet_filter" class="col-auto checkboxes d-none" >
                                    <?php
                                    // Chargement initial = pas de filtre status dans l'URL
                                    $isInitialLoadDiet = !isset($_GET['diet']);
                                    ?>
                                    <?php foreach ($diets as $diet) : ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="<?= htmlspecialchars($diet['diet_id'])?>" 
                                            name="diet[]"
                                            value="<?= htmlspecialchars($diet['diet_id']) ?>"
                                            <?= $isInitialLoadDiet || in_array($diet['diet_id'], $_GET['diet'] ?? []) 
                                            ? 'checked' : '' ?>
                                        >
                                        <label for="<?= htmlspecialchars($diet['diet_id'])?>"><?= htmlspecialchars($diet['label'])?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>


                            <!-- Filtre Thème -->
                            <div class="row employee-theme-filter">
                                <div class="col-auto bouton">
                                    <button type="button" id="theme-filter-btn" class="btn btn-filters">
                                        Thème <i class="bi bi-chevron-compact-down"></i>
                                    </button>
                                </div> 
                                <div id="theme-filter" class="col-auto checkboxes d-none" >
                                    <?php
                                    // Chargement initial = pas de filtre status dans l'URL
                                    $isInitialLoadTheme = !isset($_GET['theme']);
                                    ?>
                                    <?php foreach ($themes as $theme) : ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="<?= htmlspecialchars($theme['theme_id'])?>" 
                                            name="theme[]"
                                            value="<?= htmlspecialchars($theme['theme_id']) ?>"
                                            <?= $isInitialLoadTheme || in_array($theme['theme_id'], $_GET['theme'] ?? []) 
                                            ? 'checked' : '' ?>
                                        >
                                        <label for="<?= htmlspecialchars($theme['theme_id'])?>"><?= htmlspecialchars($theme['label'])?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div> 
                            </div>    
                                    
                            <!-- Filtre statut -->
                            <div class="row employee-status-filter">
                                <div class="col-auto bouton">
                                    <button type="button" id="status-filter-btn" class="btn btn-filters">
                                        Status <i class="bi bi-chevron-compact-down"></i>
                                    </button>
                                </div>
                                <div id="status_filter" class="col-auto checkboxes d-none">
                                    <?php $isInitialLoadStatus = !isset($_GET['status']); ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="status_is_active" 
                                            name="status[]"
                                            value="is_active"
                                            <?= $isInitialLoadStatus || in_array('is_active', $_GET['status'] ?? []) ? 'checked' : '' ?>
                                        >
                                        <label for="status_is_active">Actif</label>
                                    </div>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="status_is_inactive" 
                                            name="status[]"
                                            value="is_inactive"
                                            <?= $isInitialLoadStatus || in_array('is_inactive', $_GET['status'] ?? []) ? 'checked' : '' ?>
                                        >
                                        <label for="status_is_inactive">Inactif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                    <div class="col-12 col-xl-4">
                        <!-- Boutons -->
                        <div class="row boutons-filters">
                            <div class="col-auto bouton">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                            </div>
                            <div class="col-auto bouton">
                                <a href="<?= $basePath ?>/menus" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="section-employee-menus">
        <div class="container">
            <div class="row menus">
                <?php foreach ($menus as $menu): ?>
                    <fieldset class="col-12 col-xl-5">
                        <legend><?= htmlspecialchars($menu['title']) ?></legend>
                
                        <div class="col-12">
                            Thème : <?= htmlspecialchars($menu['theme']) ?> 
                        </div>

                        <div class="col-12">
                            Régime : <?= htmlspecialchars($menu['diet']) ?> 
                        </div>

                        <div class="col-12">
                            Prix : <?= htmlspecialchars($menu['price_per_person']) ?>€ /personne    
                        </div>

                        <div class="col-12">
                            Stock : <?= htmlspecialchars($menu['remaining_stock']) ?>   
                        </div>

                        <div class="col-12">
                            Statut : <?= htmlspecialchars($menu['is_active']) === 1 ? 'actif' : 'inactif' ?>  
                        </div>

                        <div class="row boutons">
                            <div class="col-12">
                                <form action="<?=$basePath ?>/menus/<?= htmlspecialchars($menu['menu_id'])?>/supprimer" method="POST">
                                    <?= csrfField() ?>
                                    <a href="<?=$basePath ?>/menus/<?= htmlspecialchars($menu['menu_id'])?>/modifier" class="btn btn-primary">Modifier</a>
                                    <button type="submit" class="btn btn-danger"> Supprimer</button>
                                </form> 
                            </div>
                        </div>
                    </fieldset>
                <?php endforeach; ?>

                <div class="col-12 new-menu">
                    <form action="/employe/menus/creer" method="POST">
                        <?= csrfField() ?>
                        <button type="submit" class="btn btn-primary">
                            Créer un nouveau menu
                        </button>
                    </form> 
                </div>
            </div>
        </div>
    </section>


    <!-- Pagination -->
    <section class="section-pagination">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-4">
                    <a href="<?= $basePath ?>/">retour au dashboard</a>
                </div>

                <?php if ($totalPages > 1): ?>
                    <div class="col-12 col-xl-8">
                        <nav aria-label="Pagination des menus">
                            <ul class="pagination">
                                <!-- Précédent -->
                                <?php
                                $queryParams = $_GET;
                                $queryParams['page'] = $currentPage - 1;
                                ?>
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query($queryParams) ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                <!-- Pages -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php
                                    $queryParams['page'] = $i;
                                    ?>
                                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="?<?= http_build_query($queryParams) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <!-- Suivant -->
                                <?php
                                $queryParams['page'] = $currentPage + 1;
                                ?>
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query($queryParams) ?>">
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
    
</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>