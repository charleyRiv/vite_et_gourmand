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
    <form action="/commande/etape-4" method="POST">

        <!-- Modifier la commande - retour à l'étape 1 -->
        <a href="/commande/etape-1">Modifier ma commande</a>
        <!-- Bouton S'inscrire -->
        <input type="submit" value="Valider ma commande">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>