<?php
/**
 * @var string $h1
 */

require_once __DIR__ . '/../layouts/header.php';
?>


<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    <section>
        <a href = '/menus'>Voir les menus</a>
        <a href = '/commande/etape-1'>Commander</a>
    </section>
    <section>
        <a href = "">Voir l'avis Google</a>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>