<?php
/**
 * @var string $h1
 * @var array $errors
 * @var bool $registrered
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>

    <!-- Message de succès après inscription -->
    <?php if (isset($registrered) && $registrered): ?>
        <p> Compte créé avec succès ! Vous pouvez maintenant vous connecter</p>
    <?php endif ; ?>

    <!-- Erreurs -->
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <br>
    <form action="/connexion" method="POST">
        <!-- Champs Email -->
        <label for="email">Email</label>
        <input 
            type="text" 
            id="email" 
            name="email" 
            value = "<?= htmlspecialchars($_POST['email'] ?? '')?>"
            required
            autocomplete="email"
        >

        <br>

        <!-- Champs Mot de passe -->
        <label for="password">Mot de passe</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
            autocomplete="current-password"
        >
        <br>

        <a href="/mot-de-passe-oublie">Mot de passe oublié ?</a>
        
        <br>
        <!-- Bouton Se connecter -->
        <button type="submit">Se connecter</button>

    </form>
    <br>
    <a href="/inscription">Je n'ai pas encore de compte. Je m'inscris</a>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>