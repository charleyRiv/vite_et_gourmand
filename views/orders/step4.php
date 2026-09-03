<?php
/**
 * @var string $h1
 * @var array $menu
 * @var array $pricing
 * @var array $userInfos
 * @var string $orderDateFr
 * @var string $orderTimeFr
 * @var array $dishes
 * @var int $nbPersons
 * @var int $distance
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-order4">
    <section class="section-order4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
                <div class="col-12 info">
                    <p>Vérifiez attentivement les informations ci-dessous avant de confirmer votre commande. <br>
                        Aucune modification ne sera possible après validation.</p>
                </div>

                <fieldset class="order4-delivery">
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

                <fieldset class="order4-menu">
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
                                <td><?= $nbPersons ?></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order4-conditions">
                    <legend>Conditions importantes de ce menu</legend>
                    <hr>
                    <p> <?= htmlspecialchars($menu['conditions']) ?></p>
                </fieldset>

                <fieldset class="order4-price">
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
                                <td>x <?= $nbPersons ?></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>_________</td>
                            </tr>

                            <tr>
                                <td>Prix du menu</td>
                                <td><?= $pricing['calculated_menu_price'] ?> €</td>
                            </tr>

                            <tr>
                                <td>Réduction 10% <br>
                                    <small>(<?= $nbPersons ?> pers. > <?= $menu['min_persons'] ?> min + 5)</small>
                                </td>
                                <td>- <?= $pricing['discount']?> €</td>
                            </tr>

                            <tr>
                                <?php if ($pricing['delivery_fees'] !== 0): ?>
                                    <td>Frais de livraison <br>
                                        <small><?= $userInfos['city'] ?> - hors Bordeaux<br>
                                        (5€ + 0,59€ x <?= $distance ?> km)</small>
                                    </td>
                                    <td>+ <?= $pricing['delivery_fees']?> €</td>
                                <?php else: ?>
                                    <td>Frais de livraison <br>
                                        <small>Bordeaux</small>
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
                                <td><strong>Total TTC</strong></td>
                                <td><strong><?= $pricing['total_price']?> €</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <div class="col-12">
                    <small>Le prix total est calculé sur la base des informations saisies. 
                        Il sera confirmé dans votre email de confirmation.</small>
                    </div>
                                
                </fieldset>


                <form action="/commande/etape-4" method="POST">
                    <div class="order4-submit">
                        <!--CGV -->
                        <fieldset>
                            <div class="row">
                                <div class="col-1 order4-input">
                                    <input type="checkbox" id="cgv" name="cgv" value="0">
                                </div>

                                <div class="col-11 order4-label">
                                    <label>J’ai lu et j’accepte les 
                                        <a href="/cgv">conditions générales de vente</a>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1 order4-input">
                                    <input type="checkbox" id="conditions" name="cgv" value="1">
                                </div>
                                <div class="col-11 order4-label">
                                    <label>Je confirme avoir pris connaissance des conditions spécifiques.</label>
                                </div>
                            </div>
                                
                            <div class="col-12">
                                <p>Vos données sont protégées conformément au RGPD. 
                                    Aucune information bancaire n’est stockée sur nos serveurs.</p>
                            </div>
                        </fieldset>

                        <!-- Modifier la commande - retour à l'étape 1 -->
                        <div class="col-12 back">
                            <a href="/commande/etape-1" class="btn btn-primary">Modifier ma commande</a>
                        </div>
                                    
                        <!-- Bouton S'inscrire -->
                        <div class="col-12 validate">
                            <button type="submit" class="btn btn-success" id="btn-submit">Valider ma commande</button>
                        </div>
                    </div>                
                </form>

            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>