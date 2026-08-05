<?php
/**
 * @var string $h1
 * @var array $errors
 * @var string $token
 * @var ?array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach ;?>
        </ul>
        <a href="/mot-de-passe-oublie">Faire une nouvelle demande</a>
    <?php elseif (isset($user) && $user !== null): ?>

        <form action="/mot-de-passe-oublie/reinitialisation" method="POST">

            <!-- Token caché - transmis avec le formulaire-->
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <!-- Champs Mot de passe -->
            <label for="password">Nouveau mot de passe <span>*</span></label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
            >

            <p>
                10 caractères minimum, une majuscule, une minuscule,
                un chiffre et un caractère spécial.
            </p>

            <!-- Champs Confirmation mot de passe-->
            <label for="password_confirm">Confirmer le nouveau mot de passe</label>
            <input 
                type="password" 
                id="password_confirm" 
                name="password_confirm" 
                required
            >

            <!-- Bouton Se connecter -->
            <button type="submit">Valider</button>

        </form>
    <?php endif; ?>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>