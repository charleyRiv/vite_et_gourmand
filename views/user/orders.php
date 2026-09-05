<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $statuses
 * @var array $menu
 * @var array $dishes
 * @var array $review
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-client-order">
    <section class="section-client-order-menu">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
                    <div class="col-12 delivery-details">
                        <p>Date de livraison : <?= htmlspecialchars($order['DateFr']) ?></p>           
                        <p>Heure de livraison : <?= htmlspecialchars($order['TimeFr'])?></p>
                    </div>

                    <fieldset>
                        <legend>Votre menu</legend>
                        <hr>
                        <div class="row menu">
                            <!-- Colonne de gauche -->
                            <div class="col-12 col-lg-8">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Menu choisi</td>
                                            <td><?= htmlspecialchars($menu['title']) ?></td>
                                        </tr>

                                        <tr>
                                            <td>Thème</td>
                                            <td><?= htmlspecialchars($menu['theme'])?></td>
                                        </tr>

                                        <tr>
                                            <td>Régime</td>
                                            <td><?= htmlspecialchars($menu['diet'])?></td>
                                        </tr>

                                        <tr>
                                            <td>Composition</td>
                                            <td> </td>
                                        </tr>

                                        <tr>
                                            <td class="detail">Entrée</td>
                                            <td><?= htmlspecialchars($dishes[0]['title'])?></td>
                                        </tr>

                                        <tr>
                                            <td class="detail">Plat</td>
                                            <td><?= htmlspecialchars($dishes[1]['title'])?></td>
                                        </tr>

                                        <tr>
                                            <td class="detail">Dessert</td>
                                            <td><?= htmlspecialchars($dishes[2]['title'])?></td>
                                        </tr>

                                        <tr>
                                            <td>Nombre de personnes</td>
                                            <td><?= $order['nb_persons'] ?></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Prix</td>
                                            <td><?= $order['total_price']?> €</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Colonne de droite -->
                            <div class="col-12 col-lg-4 boutons-next">
                                <div class="boutons">
                                    <div class="col-12 status">
                                        <div class="btn <?= getStatusClass($order['current_status']) ?>"><?= $order['current_status_FR']?></div>
                                    </div>
    
                                    <!-- Si le statut est "pending" possibilité de modifier ou annuler la commande -->
                                    <?php if ($order['current_status'] === 'pending') : ?>
                                        <div class="row pending-options">
                                            <div class="col-5 col-lg-12">
                                                <a href="/mon-espace/commande/<?= $order['order_id']?>/modifier" class="btn btn-primary">Modifier</a>
                                            </div>
                                    
                                            <div class="col-5 col-lg-12">
                                                <button type="button" id="btn-cancel" class="btn btn-danger">Annuler ma commande</button>
                                            </div>

                                            <div class="col-5 col-lg-12 d-none" id="btn-keep">
                                                <button type="button" class="btn btn-danger">Conserver ma commande</button>
                                            </div>
                                        </div>
                                </div>
                            </div>

                                <form action="/mon-espace/commande/<?= htmlspecialchars($order['order_id'])?>/annuler" method="POST">
                                    <div class="cancel-form d-none" id="cancel-form">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <label for="reason" class="cancel-form-label">Motif</label>
                                            </div>
                                            <div class="col-12">
                                                <textarea name="reason" id="reason" class="cancel-form-input"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" id="btn-submit" class="btn btn-danger">Annuler ma commande</button>
                                        </div>
                                    </div>
                                </form>
                    
                            <?php endif; ?>
                        </div>
                    </fieldset>
                        
                        <?php if ($order['current_status'] === 'completed' && !empty($review)) : ?> 
                            <div class="col-12 post">
                                <a href="/mon-espace/commande/<?= $order['order_id']?>/avis" class="btn btn-primary">Poster un avis</a>
                            </div> 
                        <?php endif; ?>
                        <?php if ($order['current_status'] === 'completed' && empty($review)) : ?>  
                            <div class="col-12 post">
                                <div class="btn btn-success disabled">Merci pour votre avis</div>
                            </div>
                        <?php endif; ?>
                    
            </div>
        </div>
    </section>

    <section class="section-client-order-historique">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2>Historique</h2>
                </div>

                    <?php foreach ($statuses as $status) : ?>
                        <fieldset>
                            <div class="row historique">
                                <div class="col-12 col-lg-8 infos">
                                    <?= $status['modified_at']?>
                                </div>
                                <div class="col-12 col-lg-4 boutons-next">
                                    <div class="boutons">
                                        <div class="col-12 status">
                                            <div class="btn <?= getStatusClass($status['status']) ?>"><?= htmlspecialchars($status['statusFR']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($status['contact_mode'])): ?>
                                <div class="col-auto cancel-detail">
                                    <p>Mode de contact : <?= htmlspecialchars($status['contact_mode']) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($status['reason'])): ?>
                                <div class="col-auto cancel-detail">
                                    <p>Motif : <?= htmlspecialchars($status['reason']) ?></p>
                                </div>
                            <?php endif; ?>
                        </fieldset>
                    <?php endforeach; ?>
                    <div class="col-12 back">
                        <a href="/mon-espace" class="btn btn-primary">retour à mon espace</a>
                    </div>
            </div>
        </div>
    </section>
    
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>