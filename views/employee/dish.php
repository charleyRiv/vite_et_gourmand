<?php
/**
 * @var string $h1
 * @var array $dishesType
 * @var array $dishesTypeFr
 * @var array $diets
 * @var array $allergens
 * @var array $dishes
 * @var string $basePath
 * @var array $dishAllergens
 * @var int $totalPages
 * @var int $currentPage
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-employee-dish">
    <section class="section-filters">
        <div class="container">
            <h2><?=  htmlspecialchars($h1)?></h2>

            <form action="/employe/plats" method="GET">
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

                    <div class="col-12 col-xl-9">
                        <div class="row filters-checkbox">

                            <!-- Filtre Catégorie -->
                            <div class="row employee-dish-type-filter">
                                <div class="col-auto bouton">
                                    <button type="button" id="dish-type-filter-btn" class="btn btn-filters">
                                        Catégorie <i class="bi bi-chevron-compact-down"></i>
                                    </button>
                                </div> 
                                <div id="dish-type_filter" class="col-auto checkboxes d-none" >
                                    <?php
                                    // Chargement initial = pas de filtre status dans l'URL
                                    $isInitialLoadType = !isset($_GET['dish_type']);
                                    ?>
                                    <?php foreach ($dishesTypeFr as $dishType) : ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="<?= htmlspecialchars($dishType['dish_type'])?>" 
                                            name="dish_type[]"
                                            value="<?= htmlspecialchars($dishType['dish_type']) ?>"
                                            <?= $isInitialLoadType || in_array($dishType['dish_type'], $_GET['dish_type'] ?? []) 
                                            ? 'checked' : '' ?>
                                        >
                                        <label for="<?= htmlspecialchars($dishType['dish_type'])?>"><?= htmlspecialchars($dishType['label'])?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>   
                            </div>
                        

                            <!-- Filtre Allergènes -->
                            <div class="row employee-allergens-filter">
                                <div class="col-auto bouton">
                                    <button type="button" id="allergens-filter-btn" class="btn btn-filters">
                                        Allergènes <i class="bi bi-chevron-compact-down"></i>
                                    </button>
                                </div> 
                                <div id="allergens-filter" class="col-auto checkboxes d-none" >
                                    <?php
                                    // Chargement initial = pas de filtre status dans l'URL
                                    $isInitialLoadAllergen = !isset($_GET['allergen']);
                                    ?>
                                    <?php foreach ($allergens as $allergen) : ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="<?= htmlspecialchars($allergen['allergen_id'])?>" 
                                            name="allergen[]"
                                            value="<?= htmlspecialchars($allergen['allergen_id']) ?>"
                                            <?= $isInitialLoadAllergen || in_array($allergen['allergen_id'], $_GET['allergen'] ?? []) 
                                            ? 'checked' : '' ?>
                                        >
                                        <label for="<?= htmlspecialchars($allergen['allergen_id'])?>"><?= htmlspecialchars($allergen['label'])?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>

                    
                        <!-- Boutons -->
                        <div class="row boutons-filters">
                            <div class="col-auto bouton">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                            </div>
                            <div class="col-auto bouton">
                                <a href="<?= $basePath ?>/plats" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    

                        
                    
                </div>
            </form>
        </div>
    </section>

    <section class="section-employee-dishes">
        <div class="container">
            <div class="row dishes">
                <?php foreach ($dishes as $dish): ?>
                    <fieldset class="col-12 col-xl-3">
                        <legend><?= htmlspecialchars($dish['title']) ?></legend>

                        <div class="col-12">
                            <?= htmlspecialchars($dish['dish_type_Fr']) ?>
                        </div>

                        <div class="col-12">
                            Nombre de menus associés : <?= htmlspecialchars($dish['menu_count']) ?>
                        </div>

                        <div class="col-12 allergen">
                            Allergènes : 
                            <?= !empty($dish['allergens_labels'])
                                ? htmlspecialchars($dish['allergens_labels'])
                                : 'Aucun' ?>
                        </div>


                        <div class="col-12">
                            <?php if ($dish['dish_picture'] !== null): ?>
                                    <img
                                        src="<?= htmlspecialchars($dish['dish_picture']['url']) ?>"
                                        alt="<?= htmlspecialchars($dish['dish_picture']['alt_text']) ?>"
                                    >
                            <?php else: ?>
                                <div class="img">
                                <small> Pas de photos disponibles</small>
                                </div>
                            <?php endif; ?>
                        </div>
                            
                        <div class="row boutons">
                            <div class="col-12">
                                <form action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/supprimer" method="POST">
                                    <a href="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/modifier" class="btn btn-primary">Modifier</a>
                                    
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form> 
                            </div>
                        </div>
                    </fieldset>
                <?php endforeach; ?>

                <div class="col-12 new-dish">
                    <form action="<?= $basePath ?>/plats/creer" method="POST">
                        <button type="submit" class="btn btn-primary">
                            Créer un nouveau plat
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
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>