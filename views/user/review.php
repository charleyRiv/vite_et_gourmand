<?php
/**
 * @var string $h1
 * @var array $order
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <section>
        <h2>Commande n° <?= htmlspecialchars( $order['order_id'])?></h2>
        <table>
            <thead>
                <th>Votre commande</th>
                <th></th>
            </thead>
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
    </section>

    <section>
        <form action="/mon-espace/commande/<?= htmlspecialchars($order['order_id']) ?>/avis" method="POST">
                <!-- Champs Rating -->
                <fieldset>
                    <legend>Note</legend>

                    <div class="stars-rating">

                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" title="5 étoiles">★</label>

                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" title="4 étoiles">★</label>

                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" title="3 étoiles">★</label>

                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" title="2 étoiles">★</label>

                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" title="1 étoile">★</label>

                    </div>
                </fieldset>

                <!-- Champs Message -->
                <label for="comment">Message</label>
                <textarea 
                    type="text" 
                    id="comment" 
                    name="comment" 
                    required
                ></textarea>
            
                <br>
                <!-- Bouton S'inscrire -->
                <button type="submit">Envoyer</button>
        </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>