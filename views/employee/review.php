<?php
/**
 * @var string $h1
 * @var array $reviews
 * @var string $date_to
 * @var string $date_from
 * @var int $totalPages
 * @var int $currentPage
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-employee-reviews">
    <section class="section-filters">
        <div class="container">
            <h2><?=  htmlspecialchars($h1)?></h2>

            <form action="/employe/avis" method="GET">
                <div class="row filters">

                    <!-- Filtre Note -->
                    <div class="row rate-filter">
                        <div class="col-auto bouton">
                            <button type="button" id="rate-filter-btn" class="btn btn-filters">
                                Note <i class="bi bi-chevron-compact-down"></i>
                            </button>
                        </div> 
                        <div id="rate_filter" class="col-auto checkboxes d-none" >
                            <?php
                            // Chargement initial = pas de filtre rate dans l'URL
                            $isInitialLoadRate = !isset($_GET['rate']);
                            ?>

                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="col-12">
                                <input 
                                    type="checkbox" 
                                    id="rate_<?= $i ?>" 
                                    name="rate[]"
                                    value="<?= $i ?>"
                                    <?= $isInitialLoadRate || in_array($i, $_GET['rate'] ?? []) ? 'checked' : '' ?>
                                >
                                <label for="rate_<?= $i ?>" class="stars">
                                    <?php for ($j = 1; $j <= $i; $j++): ?>
                                        <img 
                                            src="/assets/images/uploads/icone_starOn.svg" 
                                            alt="étoile" 
                                            class="etoile"
                                        >
                                    <?php endfor; ?>
                                </label>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Filtre date -->
                    <div class="row dates-filter">
                        <div class="col-auto bouton">
                            <button type="button" id="date-filter-btn" class="btn btn-filters">
                                Dates <i class="bi bi-chevron-compact-down"></i>
                            </button>
                        </div>
                        <div id="dates-filter" class="col-auto checkboxes d-none">
                            <div>
                                <label for="date_from">Du :</label>
                                <input 
                                    type="date" 
                                    id="date_from"
                                    name="date_from"
                                    value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>"
                                >
                            </div>
                            <div>
                                <label for="date_to">Au :</label>
                                <input 
                                    type="date" 
                                    id="date_to"
                                    name="date_to"
                                    value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Filtre statut -->
                    <div class="row status-filter">
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
                                    id="status_pending" 
                                    name="status[]"
                                    value="pending"
                                    <?= $isInitialLoadStatus || in_array('pending', $_GET['status'] ?? []) ? 'checked' : '' ?>
                                >
                                <label for="status_pending">En attente</label>
                            </div>

                            <div>
                                <input 
                                    type="checkbox" 
                                    id="status_validated" 
                                    name="status[]"
                                    value="validated"
                                    <?= $isInitialLoadStatus || in_array('validated', $_GET['status'] ?? []) ? 'checked' : '' ?>
                                >
                                <label for="status_validated">Validé</label>
                            </div>

                            <div>
                                <input 
                                    type="checkbox" 
                                    id="status_refused" 
                                    name="status[]"
                                    value="refused"
                                    <?= $isInitialLoadStatus || in_array('refused', $_GET['status'] ?? []) ? 'checked' : '' ?>
                                >
                                <label for="status_refused">Refusé</label>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="row boutons-filters">
                        <div class="col-auto bouton">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>

                        <div class="col-auto bouton">
                            <a href="/employe/avis" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="section-employee-reviews">
        <div class="container">
            <div class="row reviews">
                <?php foreach ($reviews as $review) : ?>
                    <fieldset class="col-12 col-xl-5">
                        <div class="row review-info">
                            <legend>Avis n° <?= htmlspecialchars($review['review_id'])?></legend>

                            <div class="col-12">
                                Date : <?= htmlspecialchars($review['reviewed_at'])?>
                            </div>

                            <div class="col-12 user-name">
                                <?= htmlspecialchars($review['first_name'])?> <?= htmlspecialchars($review['last_name'])?>
                            </div>

                            <div class="row stars">
                                <div class="col-auto stars-rating">
                                    <?php for ($i = 1; $i <= $review['rating']; $i++): ?>
                                        <img 
                                            src="/assets/images/uploads/icone_starOn.svg"
                                            alt="<?= $i ?> étoile(s)"
                                            class="etoile-rating"
                                            data-value="<?= $i ?>"
                                        >
                                    <?php endfor; ?>
                                </div>

                                <div class="col-auto">
                                    <?= htmlspecialchars($review['rating'])?>/5
                                </div>
                            </div>

                            <div class="col-12">
                                Commande n° <?= htmlspecialchars($review['order_id'])?>
                            </div>

                            <div class="col-auto comment">
                                <?= htmlspecialchars($review['comment'])?>
                            </div>

                            <hr>

                            <div class="row boutons">
                                <div class="col-12">
                            <?php if ($review['validation_status'] === 'pending') : ?>
                                <form action="/employe/avis/<?= htmlspecialchars($review['review_id']) ?>/validate" method="POST">
                                        <!-- Champs Valider -->
                                        <button type="submit" class="btn btn-success">Valider</button>
                                </form>

                                <form action="/employe/avis/<?= htmlspecialchars($review['review_id']) ?>/refused" method="POST">
                                        <!-- Champs Refuser -->
                                        <button type="submit" class="btn btn-danger">Refuser</button>
                                </form>
                            <?php else : ?>
                                <div class="col-12">
                                    <?= htmlspecialchars($review['validation_status_fr'])?> le <?= htmlspecialchars($review['reviewed_at'])?>
                                </div>
                            <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pagination -->
    <section class="section-pagination">
        <div class="container">
            <div class="row">
                <div class="col-auto">
                    <a href="<?= $basePath ?>/">retour au dashboard</a>
                </div>
                <?php if ($totalPages > 1): ?>
                    <div class="col-auto">
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