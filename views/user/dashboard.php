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
        <h2>Mes informations</h2>
        <a href="/mon-espace/profil">Modifier</a>
    </section>
    <br>
    <section>
        <h2>Mes commandes</h2>
        <div>
            <a href="/mon-espace/commande/1">Voir le détail</a>
        </div>

        <div>
            <a href="/mon-espace/commande/2">Voir le détail</a>
        </div>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>