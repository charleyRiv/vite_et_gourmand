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
        <div>
            <form action="/mon-espace/commande/1/annuler" method="POST">
                <input type="submit" value="Annuler">
            </form>
            <a href="/mon-espace/commande/1/avis">Poster un avis</a>
        </div>

        <div>
            <h2>Historique</h2>
        </div>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>