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

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <p>Vérifiez attentivement les informations ci-dessous avant de confirmer votre commande. 
        Aucune modification ne sera possible après validation.</p>
    <br>
    <section>
        <table>
            <thead>
                <tr>
                    <th>Informations de livraison</th>
                    <th> </th>
                </tr>
            </thead>
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
    </section>

    <section>
        <table>
            <thead>
                <th>Votre menu</th>
                <th> </th>
            </thead>
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
                    <td>Entrée</td>
                    <td><?= htmlspecialchars($dishes[0]['title'])?></td>
                </tr>

                <tr>
                    <td>Plat</td>
                    <td><?= htmlspecialchars($dishes[1]['title'])?></td>
                </tr>

                <tr>
                    <td>Dessert</td>
                    <td><?= htmlspecialchars($dishes[2]['title'])?></td>
                </tr>

                <tr>
                    <td>Nombre de personnes</td>
                    <td><?= $nbPersons ?></td>
                </tr>
            </tbody>
        </table>
    
    </section>
    <section>
            <h4>Conditions importantes de ce menu</h4>
            <p> <?= htmlspecialchars($menu['conditions']) ?></p>
    </section>
    <section>
        <table>
            <thead>
                <th>Détail du prix</th>
                <th> </th>
            </thead>
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
                        (<?= $nbPersons ?> pers. > <?= $menu['min_persons'] ?> min + 5)
                    </td>
                    <td>- <?= $pricing['discount']?> €</td>
                </tr>

                <tr>
                    <?php if ($pricing['delivery_fees'] !== 0): ?>
                        <td>Frais de livraison <br>
                            (<?= $userInfos['city'] ?> - hors Bordeaux) <br>
                            (5€ + 0,59€ x <?= $distance ?> km)
                        </td>
                        <td>+ <?= $pricing['delivery_fees']?> €</td>
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
                    <td><?= $pricing['total_price']?> €</td>
                </tr>
            </tfoot>
        </table>
        <p>Le prix total est calculé sur la base des informations saisies. 
            Il sera confirmé dans votre email de confirmation.</p>
            
    </section>
    <section>
        <form action="/commande/etape-4" method="POST">
            <!--CGV -->
            <fieldset>
                <input type="checkbox" id="conditions" name="cgv" value="0">
                <label>J’ai lu et j’accepte les conditions générales de vente</label>

                <br>
                <input type="checkbox" id="conditions" name="cgv" value="1">
                <label>Je confirme avoir pris connaissance des conditions spécifiques.</label>
            
                <p>Vos données sont protégées conformément au RGPD. 
                    Aucune information bancaire n’est stockée sur nos serveurs.</p>
            </fieldset>
            <!-- Modifier la commande - retour à l'étape 1 -->
            <a href="/commande/etape-1">Modifier ma commande</a>
            <!-- Bouton S'inscrire -->
            <button type="submit">Valider ma commande</button>

        </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>