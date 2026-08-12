<?php
/**
 * @var string $h1
 * @var array $errors
 * @var bool $succes
 * @var string $email
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <!--Affichage des erreurs-->
    <?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error)?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <!--Message pour lien de réinitialisation -->
    <?php if (isset($succes) && $succes): ?>
        <p>
            Si un compte est associé à cette adresse email, vous recevrez
            dans quelques instants un lien de réinitialisation.
            Pensez à vérifier vos spams.
        </p>
    <?php else: ?>

        <form action="/mot-de-passe-oublie" method="POST">
            
        <!-- Champs Email -->
            <label for="email">Email</label>
            <input 
                type="text" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($email ?? '')?>"
                placeholder="mail@mail.fr" 
                required
            >

            <!-- Bouton Se connecter -->
            <button type="submit">Réinitialiser</button>

        </form>
    <?php endif; ?>

    <a href="/connexion">← Retour à la connexion</a>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>