<?php
/**
 * @var string $h1
 * @var array $reviews
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
        <div>
        <form action="/employe/avis" method="POST">
            <!-- Filtre Note -->
            <fieldset>
            <label for="note">Note</label>
                <select name="note" id="note">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </fieldset>

            <!-- Filtre Date -->
            <label for="date">Date</label>
            <input type="date" id="date" name="date">
                        
            <!-- Filtre Statut -->
            <fieldset>
            <label for="status">Statut</label>
                <select name="status" id="status">
                    <option value="waiting">En attente</option>
                    <option value="validate">Validé</option>
                    <option value="refuse">Refusé</option>
                </select>
            </fieldset>

            
            <!-- Boutons -->
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>

    <?php foreach ($reviews as $review) : ?>
    <div>
        
        <section>
            <h4>Avis n° <?= htmlspecialchars($review['review_id'])?></h4>
            <p> Date : <?= htmlspecialchars($review['reviewed_at'])?></p>
            <p><?= htmlspecialchars($review['first_name'])?> <?= htmlspecialchars($review['last_name'])?></p>
            <p>
                <span style="color: #f7bc4d;">
                    <?= str_repeat('★', (int) $review['rating']) ?>
                </span>
                <span style="color: #ccc;">
                    <?= str_repeat('☆', 5 - (int) $review['rating']) ?>
                </span>
                <?= htmlspecialchars($review['rating'])?>/5</p>
            <p>Commande n° <?= htmlspecialchars($review['order_id'])?></p>
            <p><?= htmlspecialchars($review['comment'])?></p>
        </section>
        <section>
            <?php if ($review['validation_status'] === 'pending') : ?>
                <form action="/employe/avis/<?= htmlspecialchars($review['review_id']) ?>/validate" method="POST">

                    <!-- Champs Valider -->
                    <button type="submit">Valider</button>
                </form>
                <form action="/employe/avis/<?= htmlspecialchars($review['review_id']) ?>/refused" method="POST">

                    <!-- Champs Refuser -->
                    <button type="submit">Refuser</button>
                </form>
            <?php else : ?>
                <p><?= htmlspecialchars($review['validation_status_fr'])?> le <?= htmlspecialchars($review['reviewed_at'])?></p>
            <?php endif; ?>
        </section>
    </div>
    <?php endforeach; ?>

</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>