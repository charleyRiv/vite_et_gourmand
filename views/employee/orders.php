<?php
/**
 * @var string $h1
 * @var array $orders
 * @var array $activClients
 * @var array $activStatuses
 * @var array $statuses
 * @var array $statusHistory
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <div>
        <form action="/employe/commandes" method="POST">
            <fieldset>
                <legend>Status</legend>
                <?php foreach ($activStatuses as $activStatus) : ?>
                <div>
                    <input type="checkbox" id="<?= htmlspecialchars($activStatus['current_status'][0])?>" name=""
                    value="<?= htmlspecialchars($activStatus['current_status'])?>" checked />
                    <label for="<?= htmlspecialchars($activStatus['current_status'])?>"><?= htmlspecialchars($activStatus['current_status'])?></label>
                </div>
                <?php endforeach; ?>
            </fieldset>
            <fieldset>
                <legend>Client</legend>
                <?php foreach ($activClients as $client) : ?>
                <div>
                    <input type="checkbox" id="client_name" name="client_name"
                    value="<?= htmlspecialchars($client['last_name'])?>" checked />
                    <label for="client_name"><?= htmlspecialchars($client['last_name'])?> <?= htmlspecialchars($client['first_name'])?>"</label>
                </div>
                <?php endforeach; ?>
            </fieldset>
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>
    <?php foreach ($orders as $order) : ?>
        <section>
        <h3>Commande n°<?= $order['order_id'] ?></h3>    
        <table>
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
        <table>
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

        <form action="/employe/commandes/<?= $order['order_id'] ?>/gerer" method="POST">
            <!-- Champs Satut -->
            <!--label for="status">Status</label-->
            <select name="current_status" id="current_status">
                <option value="">statut</option>
            <?php foreach ($statuses as $value => $label) : ?>
                <option value="<?= htmlspecialchars($value) ?>"
                <?= ($value === $order['current_status']) ? 'selected' : ''?>
                >
                    <?= htmlspecialchars($label) ?>
                </option>
            <?php endforeach; ?>
            </select>

            <br>
            <!-- Champs Mode de contact en cas d'annulation -->
            <label for="contact_mode">Mode de contact</label>
            <input 
                type="text" 
                id="contact_mode" 
                name="contact_mode"
            >

            <br>
            <!-- Champs Motif d'annulation -->
            <label for="reason">Motif d'annulation</label>
            <textarea 
                id="reason" name="reason"
            ></textarea>
            <br>
            <button type="submit">valider</button>
        </form>

        <a href="/employe/commandes/<?= $order['order_id'] ?>/historique">Voir l'historique</a>
        </section>
    <?php endforeach; ?>
        <br>
    <div>
        <a href="">Precedent</a>
        <a href="">Suivant</a>
        <a href="">n°page</a>/nbr page totales
    </div>
</main>
<br>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>