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
        
        <!-- Champs Mot de passe -->
        <label for="motDePasse">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required>

        <!-- Champs Confirmation mot de passe-->
        <label for="motDePasseConfirm">Confirmation mot de passe</label>
        <input type="password" id="password" name="passwordConfirm" required>

        <!-- Bouton Se connecter -->
        <input type="submit" value="valider">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>