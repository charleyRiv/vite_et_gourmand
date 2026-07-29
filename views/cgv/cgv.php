<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?= htmlspecialchars($h1)?></h1>
    <br>
    <div>
        contenu
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>