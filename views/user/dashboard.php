<?php
/**
 * @var string $h1
 * @var array $user
 * @var array $orders
 * 
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <section>
        <h2>Mes informations</h2>
        <table>
            <tr>
                <td>Nom : </td>
                <td><?= htmlspecialchars($user['last_name']) ?></td>
            </tr>
            <tr>
                <td>Prénom : </td>
                <td><?= htmlspecialchars($user['first_name']) ?></td>
            </tr>
            <tr>
                <td>Téléphone : </td>
                <td><?= htmlspecialchars($user['phone']) ?></td>
            </tr>
            <tr>
                <td>Email : </td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <td>Adresse : </td>
                <td>
                    <?= htmlspecialchars($user['street_number']) ?> 
                    <?= htmlspecialchars($user['street_type']) ?> 
                    <?= htmlspecialchars($user['street_name']) ?><br>
                    <?= htmlspecialchars($user['zip_code']) ?> 
                    <?= htmlspecialchars($user['city']) ?>, 
                    <?= htmlspecialchars($user['country']) ?>
                </td>
            </tr>
            <tr>
                <td>Mot de passe : </td>
                <td>**********</td>
            </tr>
        </table>
        <a href="/mon-espace/profil">Modifier</a>
    </section>
    <br>
    <section>
        <h2>Mes commandes</h2>
        <?php foreach ($orders as $order) : ?>
        <div>
            <p>Commande n°<?= htmlspecialchars($order['order_id'])?></p>
            <p><?= htmlspecialchars($order['menu_title'])?> pour <?= htmlspecialchars($order['nb_persons']) ?> personnes</p>
            <p>Pour le <?= htmlspecialchars($order['DateFr'])?>
                à <?= htmlspecialchars($order['TimeFr'])?>
            </p>
            <p><?= htmlspecialchars($order['current_status'])?></p>

            <a href="/mon-espace/commande/<?= htmlspecialchars($order['order_id'])?>">Voir le détail</a>
        </div>
        <?php endforeach; ?>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>