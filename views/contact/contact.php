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
    <form action="/contact" method="POST">
        <!-- Champs Email --> 
        <label for="Email">Email</label>
        <input type="text" id="email" name="email" required>
        <!-- Champ Titre -->
        <label for="Titre">Titre</label>
        <input type="text" id="titre" name="titre" required>
        <!-- Champ Message -->
        <label for="Message">Message</label>
        <input type="text" id="message" name="message" required>
        <!-- Bouton submit -->
        <input type="submit" value="Envoyer">
    </form>
</main>

<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>