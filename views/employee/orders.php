<?php
/**
 * @var string $h1
 * @var array $orders
 * @var array $activClients
 * @var array $activStatuses
 * @var array $statuses
 * @var array $statusHistory
 * @var int $totalPages
 * @var int $currentPage
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-employee-orders">
    <section class="section-filters">
        <div class="container">
            <h2><?=  htmlspecialchars($h1)?></h2>
            <form action="/employe/commandes" method="GET">
                <div class="row filters">
                    <div class="row status-filter">
                        <div class="col-auto bouton">
                            <button type="button" id="status-filter-btn" class="btn btn-filters">
                                Status <i class="bi bi-chevron-compact-down"></i>
                            </button>
                        </div> 
                        <div id="status_filter" class="col-auto checkboxes d-none" >
                            <?php
                            // Chargement initial = pas de filtre status dans l'URL
                            $isInitialLoadStatus = !isset($_GET['status']);
                            ?>
                            <?php foreach ($activStatuses as $activStatus) : ?>
                            <div>
                                <input 
                                    type="checkbox" 
                                    id="<?= htmlspecialchars($activStatus['current_status'][0])?>" 
                                    name="status[]"
                                    value="<?= htmlspecialchars($activStatus['current_status']) ?>"
                                    <?= $isInitialLoadStatus || in_array($activStatus['current_status'], $_GET['status'] ?? []) 
                                    ? 'checked' : '' ?>
                                >
                                <label for="<?= htmlspecialchars($activStatus['current_status'])?>"><?= htmlspecialchars($activStatus['current_status_fr'])?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row status-client">
                        <div class="col-auto bouton">
                            <button type="button" id="client-filter-btn" class="btn btn-filters">
                                Client <i class="bi bi-chevron-compact-down"></i>
                            </button>
                        </div>
                        <div id="client-filter" class="col-auto checkboxes d-none">
                            <?php
                            // Chargement initial = pas de filtre status dans l'URL
                            $isInitialLoadClient = !isset($_GET['client']);
                            ?>
                            <?php foreach ($activClients as $client) : ?>
                            <div>
                                <input type="checkbox" 
                                name="client[]"
                                value="<?= htmlspecialchars($client['last_name'])?>" 
                                <?= $isInitialLoadClient || in_array($client['last_name'], $_GET['client'] ?? []) 
                                ? 'checked' : '' ?>
                                >
                                <label for="client_name"><?= htmlspecialchars($client['last_name'])?> <?= htmlspecialchars($client['first_name'])?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row boutons-filters">
                        <div class="col-auto bouton">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>

                        <div class="col-auto bouton">
                            <a href="/employe/commandes" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </section>

    <section class="section-employee-orders">
        <div class="container">
            <div class="row">
                <?php foreach ($orders as $order) : ?>
                    <fieldset>
                        <div class="col-12">
                            <h5>Commande n°<?= $order['order_id'] ?></h5>
                        </div> 
                        
                        <div class="employee-orders-menu">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Menu choisi</td>
                                        <td><?= htmlspecialchars($order['menu_title'] ?? '')?></td>
                                    </tr>
                                    <tr>
                                        <td>Nombre de personnes </td>
                                        <td><?= htmlspecialchars($order['nb_persons'] ?? '')?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="employee-orders-menu">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Informations de livraison</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nom du client</td>
                                        <td><?= htmlspecialchars($order['last_name'])?> <?= htmlspecialchars($order['first_name'])?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?= htmlspecialchars($order['email'])?></td>
                                    </tr>
                                    <tr>
                                        <td>Téléphone</td>
                                        <td><?= htmlspecialchars($order['phone'])?></td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>
                                            <?= htmlspecialchars($order['delivery_street_number'])?> 
                                            <?= htmlspecialchars($order['delivery_street_type'])?> 
                                            <?= htmlspecialchars($order['delivery_street_name'])?> <br>
                                            <?= htmlspecialchars($order['delivery_zip_code'])?> 
                                            <?= htmlspecialchars($order['delivery_city'])?>, 
                                            <?= htmlspecialchars($order['delivery_country'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date de la prestation</td>
                                        <td><?= htmlspecialchars($order['event_date_fr'])?></td>
                                    </tr>
                                    <tr>
                                        <td>Heure de livraison</td>
                                        <td><?= htmlspecialchars($order['delivery_time_fr'])?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                
                        <form action="/employe/commandes/<?= $order['order_id'] ?>/gerer" method="POST">
                            <?= csrfField() ?>
                            <div class="col-12 status-select">
                                <!-- Champs Satut -->
                                <select name="current_status" class="btn status-select-input <?= getStatusClass($order['current_status']) ?>">
                                    <option value=""> Sélectionner un statut </option>
                                <?php foreach ($statuses as $value => $label) : ?>
                                    <option value="<?= htmlspecialchars($value) ?>"
                                    <?= ($value === $order['current_status']) ? 'selected' : ''?>
                                    >
                                        <?= htmlspecialchars($label) ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="cancel-form d-none">
                                <!-- Champs Mode de contact en cas d'annulation -->
                                <div class="col-12">
                                    <label for="contact_mode">Mode de contact</label>
                                </div>
                                <div class="col-12">
                                    <input 
                                        type="text" 
                                        id="contact_mode" 
                                        name="contact_mode"
                                    >
                                </div>
                            
                                <!-- Champs Motif d'annulation -->
                                <div class="col-12">
                                    <label for="reason">Motif d'annulation</label>
                                </div>
                                <div class="col-12">
                                    <textarea 
                                        id="reason" name="reason">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-12 boutons">
                                <button type="submit" class="col-6 btn btn-primary" id="submit-btn">valider</button>
                            
                                <a href="<?= $basePath ?>/commandes/<?= $order['order_id'] ?>/historique" class="col-4 btn btn-secondary">Voir l'historique</a>
                            </div>
                        </form>                    
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
                                    <?php
                                    $queryParams = $_GET;
                                    $queryParams['page'] = $i;
                                    ?>
                                    <a class="page-link" href="?<?= http_build_query($queryParams) ?>"><?= $i ?>
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