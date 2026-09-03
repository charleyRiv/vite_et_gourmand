<?php
/**
 * @var string $h1
 * @var array $user
 * @var array $orders
 * @var string $heroImage
 * 
 */
require_once __DIR__ . '/../layouts/header.php';

$heroTitle = htmlspecialchars($h1);
$heroImage    = '/assets/images/uploads/hero_banner_charte_001.jpeg';
require_once __DIR__ . '/../layouts/hero.php';
?>

<main class="page-dashboard-client">
    <section class="section-profil">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Mes informations</h3>
                </div>

                <fieldset>
                    <div class="row infos">
                        <!-- Colonne de gauche -->
                        <div class="col-12 col-lg-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Nom</td>
                                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                                </tr>
                                <tr>
                                    <td>Prénom</td>
                                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                                </tr>
                                <tr>
                                    <td>Téléphone</td>
                                    <td><?= htmlspecialchars($user['phone']) ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                </tr>
                                <tr>
                                    <td>Adresse</td>
                                    <td>
                                        <?= htmlspecialchars($user['street_number']) ?> 
                                        <?= htmlspecialchars($user['street_type']) ?> 
                                        <?= htmlspecialchars($user['street_name']) ?><br>
                                        <?= htmlspecialchars($user['zip_code']) ?> 
                                        <?= htmlspecialchars($user['city']) ?>, 
                                        <?= htmlspecialchars($user['country']) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Colonne de droite -->
                        <div class="col-12 col-lg-4 boutons-next">
                            <form action="/mon-espace/supprimer" method="post">
                                <div class="boutons">
                                    <div class="col-5 col-lg-12 modify">
                                        <a href="/mon-espace/profil" class="btn btn-primary">Modifier</a>
                                    </div>

                                    <div class="col-5 col-lg-12">
                                        <button 
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')"
                                        >
                                            Supprimer mon compte
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </section>

    <section class="section-orders">
        <div class="container">
            <div class="row">
                <div>
                    <h3>Mes commandes</h3>
                </div>
        
                <?php foreach ($orders as $order) : ?>
                <fieldset>
                    <div class="row infos">
                        <div class="col-12 col-lg-8 orders-info">
                            <div class="col-12 title">
                                <p>Commande n°<?= htmlspecialchars($order['order_id'])?></p>
                            </div>
                            <div class="col-12 details">
                                <p><?= htmlspecialchars($order['menu_title'])?> pour <?= htmlspecialchars($order['nb_persons']) ?> personnes</p>

                                <p>Pour le <?= htmlspecialchars($order['DateFr'])?>
                                    à <?= htmlspecialchars($order['TimeFr'])?>
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 boutons-next">
                            <div class="boutons">
                                <div class="col-5 col-lg-12 status">
                                    <div class="btn <?= getStatusClass($order['current_status']) ?>"><?= htmlspecialchars($order['current_status_fr'])?></div>
                                </div>

                                <div class="col-5 col-lg-12">
                                    <a href="/mon-espace/commande/<?= htmlspecialchars($order['order_id'])?>" class="btn btn-primary">Voir le détail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>