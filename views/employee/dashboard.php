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
        <form action="/employe/mot-de-passe" method="POST">
            <input type="submit" value="Modifier mon mot de passe">
        </form>

        <a href="/employe/commandes">Gérer les commandes</a>

        <a href="/employe/avis">Gérer les avis</a>

        <a href="/employe/menus">Gérer les menus</a>

        <a href="/employe/plats">Gérer les plats</a>

        <a href="/employe/contenus">Gérer les contenus</a>
</main>
<br>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>