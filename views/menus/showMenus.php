<?php
/**
 * @var int $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>
<br>
<main>
    <h1><?= htmlspecialchars($h1)?></h1>
    <section>
        <br>
        <a href="/commande/etape-1">Commander</a>
    </section>
</main>

<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>