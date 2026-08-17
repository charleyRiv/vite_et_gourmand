<?php
/**
 * @var string $h1
 * @var array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>
<br>
<main>
    <h1><?= htmlspecialchars($h1)?></h1>
    <br>
    <form action="/contact" method="POST">
        <!-- Champs Email --> 
        <label for="email">Email</label>
        <?php if (!empty($user)) : ?>
        <input 
            type="text" 
            id="email" 
            name="email" 
            value="<?= htmlspecialchars($user['email'])?>" 
            required>
        <?php else : ?>
        <input type="text" id="email" name="email" required>
        <?php endif; ?>
        <br>
        <!-- Champ Titre -->
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" required>
        <br>
        <!-- Champ Message -->
        <label for="content">Message</label>
        <textarea id="content" name="content" rows="10" cols="60" required></textarea>
        <br>    
        <!-- Bouton submit -->
        <button type="submit">Envoyer</button>
    </form>
</main>

<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>