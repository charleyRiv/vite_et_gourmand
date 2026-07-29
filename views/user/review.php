<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <section>

    </section>

    <section>
        <form action="/mon-espace/1/avis" method="POST">
                <!-- Champs Rating -->
                <fieldset>
                    <legend>Votre note</legend>

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
                <label for="message">Message</label>
                <input type="text" id="message" name="message" required>
            
                <!-- Bouton S'inscrire -->
                <input type="submit" value="Envoyer">
        </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>