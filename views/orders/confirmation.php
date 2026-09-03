<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $userInfos
 * @var string $orderDateFr
 * @var string $orderTimeFr
 * @var array $menu
 * @var array $dishes
 * @var int $distance
 * @var string $maskedEmail
 */
require_once __DIR__ . '/../layouts/header.php';
?>


<main class="page-order-confirmation">
    <section class="section-order-confirmation">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <fieldset class="order-confirmation-delivery">
                    <legend>Informations de livraison</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Nom du client</td>
                                <td><?= htmlspecialchars($userInfos['first_name'])?> <?= htmlspecialchars($userInfos['last_name']) ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= htmlspecialchars($userInfos['email'])?></td>
                            </tr>

                            <tr>
                                <td>Téléphone</td>
                                <td><?= htmlspecialchars($userInfos['phone'])?></td>
                            </tr>

                            <tr>
                                <td>Adresse</td>
                                <td><?= htmlspecialchars($userInfos['street_number'])?> 
                                    <?= htmlspecialchars($userInfos['street_type'])?> 
                                    <?= htmlspecialchars($userInfos['street_name'])?> <br>
                                    <?= htmlspecialchars($userInfos['zip_code'])?> 
                                    <?= htmlspecialchars($userInfos['city'])?>, 
                                    <?= htmlspecialchars($userInfos['country'])?>
                                </td>
                            </tr>

                            <tr>
                                <td>Date de livraison</td>
                                <td><?= htmlspecialchars($orderDateFr) ?></td>
                            </tr>

                            <tr></tr>
                                <td>Heure de livraison</td>
                                <td><?= htmlspecialchars($orderTimeFr)?></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order-confirmation-menu">
                    <legend>Votre menu</legend>
                    <hr>
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
                    </table>    
                </fieldset>

                <fieldset class="order-confirmation-conditions">
                    <legend>Conditions importantes de ce menu</legend>
                    <hr>
                    <p> <?= htmlspecialchars($menu['conditions']) ?></p>
                </fieldset>


                <fieldset class="order-confirmation-price">
                    <legend>Détail du prix</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Prix par personne</td>
                                <td><?= htmlspecialchars($menu['price_per_person'])?> €</td>
                            </tr>

                            <tr>
                                <td>Nombre de personnes</td>
                                <td>x <?= $order['nb_persons'] ?></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>_________</td>
                            </tr>

                            <tr>
                                <td>Prix du menu</td>
                                <td><?= $order['calculated_menu_price'] ?> €</td>
                            </tr>

                            <tr>
                                <td>Réduction 10% <br>
                                    (<?= $order['nb_persons'] ?> pers. > <?= $menu['min_persons'] ?> min + 5)
                                </td>
                                <td>- <?= $order['discount']?> €</td>
                            </tr>

                            <tr>
                                <?php if ((float) $order['delivery_fees'] > 0): ?>
                                    <td>Frais de livraison <br>
                                        (<?= $userInfos['city'] ?> - hors Bordeaux) <br>
                                        (5€ + 0,59€ x <?= $distance ?> km)
                                    </td>
                                    <td>+ <?= $order['delivery_fees']?> €</td>
                                <?php else: ?>
                                    <td>Frais de livraison <br>
                                        (Bordeaux)
                                    </td>
                                    <td>offert</td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td> </td>
                                <td>_________</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total TTC</td>
                                <td><?= $order['total_price']?> €</td>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <div class="col-12">
                    <small>Le prix total est calculé sur la base des informations saisies. 
                        Il sera confirmé dans votre email de confirmation.</small>
                    </div>   

                </fieldset>

                <div class="col-12">
                    <p>Un mail de confirmation vous a été envoyé à 
                        <?= $maskedEmail ?>
                    </p>
                </div>

                <!-- Modifier la commande - retour à l'étape 1 -->
                <div class="col-12 back">
                    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>