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
    <form action="/commande/etape-3" method="POST">

        <!-- Champs Nombre de personnes -->
        <label for="number-people">Nombre de personnes</label>
        <input type="text" id="number-people" name="number-people" required>

        <!-- Bouton S'inscrire -->
        <input type="submit" value="Suivant">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>