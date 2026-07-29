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

    <!-- Modifier la commande - retour à l'étape 1 -->
    <a href="/">Retour à l'accueil</a>

</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>