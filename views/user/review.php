<?php
/**
 * @var string $h1
 * @var array $order
 */
require_once __DIR__ . '/../layouts/header.php';
?>


<main class="page-client-review">
    <section class="section-client-review-menu">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <div class="col-12">
                    <h3>Commande n° <?= htmlspecialchars( $order['order_id'])?></h3>
                </div>

                <fieldset>
                    <legend>Votre commande</legend>
                    <hr>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Date</td>
                                <td><?= $order['DateFr']?></td>
                            </tr>
                            <tr>
                                <td>Menu choisi</td>
                                <td><?= htmlspecialchars($order['menu_title']) ?></td>
                            </tr>
                            <tr>
                                <td>Nombre de personnes</td>
                                <td><?= htmlspecialchars($order['nb_persons'])?></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </section>

    <section class="section-client-review-rate">
        <div class="container">
            <form action="/mon-espace/commande/<?= htmlspecialchars($order['order_id']) ?>/avis" method="POST">
                <div class="row">
                    
                    <!-- Champs Rating -->
                    <div class="col-12">
                        <h3>Note</h3>
                    </div>

                    <fieldset class="rate">

                        <!-- Input hidden pour stocker la valeur -->
                        <input type="hidden" id="rating" name="rating" value="" class="rating" required>

                        <div class="stars-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <img 
                                    src="/assets/images/uploads/icone_starOff.svg"
                                    alt="<?= $i ?> étoile(s)"
                                    class="etoile-rating"
                                    data-value="<?= $i ?>"
                                >
                            <?php endfor; ?>
                        </div>
                        <div class="invalid-feedback">Veuillez attribuer une note.</div>
                    </fieldset>

                    <!-- Champs Message -->
                    <div class="col-12">
                        <h3 for="comment">Message</h3>
                    </div>
                    <div class="col-12 comment">
                        <textarea 
                            type="text" 
                            id="comment" 
                            name="comment" 
                            required
                        ></textarea>
                    </div>

                    <!-- Bouton S'inscrire -->
                    <div class="col-12 validate">
                        <button type="submit" id="btn-submit" class="btn btn-primary">Envoyer</button>
                    </div>
                    </div>
                </div>
            </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>