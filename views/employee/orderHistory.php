<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $statuses
 * @var array $client
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <section>
        <h3>Date de la prestation</h3>
        <p><?= htmlspecialchars($order['event_date'])?> à <?= htmlspecialchars($order['delivery_time'])?></p>
    </section>

    <h3>Historique</h3>
    <?php foreach ($statuses as $status): ?>
    <section>
        <table>
            <tr>
                <th>status</th>
                <td><?= htmlspecialchars($status['status_fr'] ?? '')?></td>
            </tr>
            <tr>
                <th>date</th>
                <td><?= htmlspecialchars($status['modified_at'] ?? '')?></td>
            </tr>
            <?php if ($status['status'] === 'cancelled') : ?>
            <tr>
                <td>mode de contact</td>
                <td><?= htmlspecialchars($status['contact_mode'] ?? '')?></td>
            </tr>
            <tr>
                <td>motif</td>
                <td><?= htmlspecialchars($status['reason'] ?? '')?></td>
            </tr>
            <?php endif ?>
        </table>
    <br>
    </section>
    <?php endforeach; ?>

    <a href="<?= $basePath ?>/commandes">Retour aux commandes</a>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>