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
    <form action="/connexion" method="POST">
        <!-- Champs Email -->
        <label for="Email">Email</label>
        <input type="text" id="mail" name="mail" required>

        <!-- Champs Mot de passe -->
        <label for="motDePasse">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <a href="/mot-de-passe-oublie">Mot de passe oublié ?</a>
        <!-- Bouton Se connecter -->
        <input type="submit" value="Se connecter">

    </form>
    <br>
    <a href="/inscription">Je n'ai pas encore de compte. Je m'inscris</a>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>