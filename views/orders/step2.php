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
    <form action="/commande/etape-2" method="POST">

        <label for="menu_id">Choisissez votre menu</label>
        <select id="menu_id" name="menu_id" required>

        <option value="">-- Sélectionnez un menu --</option>
        <option value="">-- Sélectionnez un menu --</option>
        <option value="">-- Sélectionnez un menu --</option>
    <br>
        <!-- Bouton S'inscrire -->
        <input type="submit" value="Suivant">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>