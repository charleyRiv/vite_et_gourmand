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

<main class="page-employee-order-history">
    <h2><?=  htmlspecialchars($h1)?></h2>
    <section class="section-employee-order-info">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h3>Date de la prestation</h3>
                </div>

                <div class="col-12">
                    <?= htmlspecialchars($order['event_date'])?> à <?= htmlspecialchars($order['delivery_time'])?>
                </div>        
            </div>
        </div>
    </section>

    <section class="section-employee-order-history">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h3>Historique</h3>
                </div>

                <?php foreach ($statuses as $status): ?>
                    <fieldset>
                        <table class="table table-borderless">
                            <tr>
                                <th>status</th>
                                <td>
                                    <span class="btn <?= getStatusClass($status['status']) ?>">
                                        <?= htmlspecialchars($status['status_fr'] ?? '')?>
                                    </span>
                                </td>
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
                    </fieldset>    
                <?php endforeach; ?>
                
                <div class="col-12 back">
                    <a href="<?= $basePath ?>/commandes">Retour aux commandes</a>
                </div>
            </div>
        </div>
    </section>

    
</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>