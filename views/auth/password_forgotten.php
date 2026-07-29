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
    <form action="/mot-de-passe-oublie" method="POST">
        <!-- Champs Email -->
        <label for="Email">Email</label>
        <input type="text" id="mail" name="mail" placeholder="mail@mail.fr" required>

        <!-- Champs Mot de passe -->
        <label for="motDePasse">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <!-- Bouton Se connecter -->
        <input type="submit" value="Réinitialiser">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>