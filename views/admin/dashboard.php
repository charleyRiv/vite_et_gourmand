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
        <a href="/admin/employes">Gérer les comptes employés</a>

        <a href="/admin/statistiques">Pilotage</a>

        <a href="/admin/commandes">Gérer les commandes</a>

        <a href="/admin/avis">Gérer les avis</a>

        <a href="/admin/menus">Gérer les menus</a>

        <a href="/admin/plats">Gérer les plats</a>

        <a href="/admin/contenus">Gérer les contenus</a>
</main>
<br>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>