<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $statuses
 * @var array $menu
 * @var array $dishes
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <div>
        <p>Date de livraison : <?= htmlspecialchars($order['DateFr']) ?></p>           
        <p>Heure de livraison : <?= htmlspecialchars($order['TimeFr'])?></p>

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

        <p><?= $order['current_status_FR']?></p>

        <!-- Si le statut est "pending" possibilité de modifier ou annuler la commande -->
        <?php if ($order['current_status'] === 'pending') : ?>
            <a href="/mon-espace/commande/<?= $order['order_id']?>/modifier">Modifier</a>
            <fieldset>
                <legend>Annuler ma commande</legend>
            <form action="/mon-espace/commande/<?= htmlspecialchars($order['order_id'])?>/annuler" method="POST">
                <label for="reason">Motif</label>
                <textarea name="reason" id="reason"></textarea>
                <br>
                <input type="submit" value="Annuler">
            </form>
            </fieldset>
        <?php endif; ?>

        
        <?php if ($order['current_status'] === 'completed') : ?>
        <a href="/mon-espace/commande/<?= $order['order_id']?>/avis">Poster un avis</a>
        <?php endif; ?>
    </div>

    <div>
        <h2>Historique</h2>
        <?php foreach ($statuses as $status) : ?>
            <p><?= $status['modified_at']?></p>
            <p><?= htmlspecialchars($status['statusFR']) ?></p>
            
            <?php if (!empty($status['contact_mode'])): ?>
                <p>Mode de contact : <?= htmlspecialchars($status['contact_mode']) ?></p>
            <?php endif; ?>
            <?php if (!empty($status['reason'])): ?>
                <p>Motif : <?= htmlspecialchars($status['reason']) ?></p>
            <?php endif; ?>
        
        <?php endforeach; ?>
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>