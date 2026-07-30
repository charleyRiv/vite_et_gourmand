<?php
/**
 * @var array $errors
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <!-- Affichage des erreurs -->
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?=  htmlspecialchars($error)?></li>
            <?php endforeach;?>
        </ul>
    <?php endif; ?>

    <form action="/inscription" method="POST">
        <!-- Champs Nom -->
        <label for="last_name">Nom <span>*</span></label>
        <input 
            type="text" 
            id="last_name" 
            name="last_name" 
            value= "<?= htmlspecialchars($_POST['last_name'] ??'') ?>"
            required
        >

        <!-- Champs Prenom -->
        <label for="first_name">Prenom <span>*</span></label>
        <input 
            type="text" 
            id="first_name" 
            name="first_name"
            value= "<?= htmlspecialchars($_POST['first_name'] ??'') ?>" 
            required
        >

        <br>

        <!-- Champs Telephone -->
        <label for="phone">Téléphone</label>
        <input 
            type="text" 
            id="phone" 
            name="phone"
            value= "<?= htmlspecialchars($_POST['phone'] ??'') ?>"
        >

        <br>

        <!-- Champs Email -->
        <label for="email">Email <span>*</span></label>
        <input 
            type="text" 
            id="email" 
            name="email"
            value= "<?= htmlspecialchars($_POST['email'] ??'') ?>" 
            required
        >

        <br>

        <!-- Champs N° voie -->
        <label for="street_number">N° Voie</label>
        <input 
            type="text" 
            id="street_number" 
            name="street_number"
            value= "<?= htmlspecialchars($_POST['street_number'] ??'') ?>"
        >

        <!-- Champs Type voie -->
        <label for="street_type">Type de voie</label>
        <input 
            type="text" 
            id="street_type" 
            name="street_type"
            value= "<?= htmlspecialchars($_POST['street_type'] ??'') ?>"
        >

        <!-- Champs Nom voie -->
        <label for="street_name">Nom de la voie</label>
        <input 
            type="text" 
            id="street_name" 
            name="street_name"
            value= "<?= htmlspecialchars($_POST['street_name'] ??'') ?>"
        >
        
        <br>

        <!-- Champs Code Postal -->
        <label for="zip_code">Code postal</label>
        <input 
            type="text" 
            id="zip_code" 
            name="zip_code"
            value= "<?= htmlspecialchars($_POST['zip_code'] ??'') ?>"
        >

        <!-- Champs Ville -->
        <label for="city">Ville</label>
        <input 
            type="text" 
            id="city" 
            name="city"
            value= "<?= htmlspecialchars($_POST['city'] ??'') ?>"
        >
        
        <br>

        <!-- Champs Pays -->
        <label for="country">Pays</label>
        <input 
            type="text" 
            id="country" 
            name="country"
            value= "<?= htmlspecialchars($_POST['country'] ??'') ?>"
        >

        <br>

        <!-- Champs Mot de passe -->
        <label for="password">Mot de passe <span>*</span></label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required
        >
        <p>
            10 caractères minimum, dont au moins 1 lettre minuscule, 1 majuscule, 1 chiffre et 1 caractere special
        </p>

        <br>

        <!-- Champs Confirmation mot de passe-->
        <label for="password_confirm">Confirmation mot de passe <span>*</span></label>
        <input 
            type="password" 
            id="password_confirm" 
            name="password_confirm" 
            required
        >
        <p><span>*</span> Champs Obligatoire</p>
        <label>
            <input type="checkbox" name="consent" value="1" required>
            J'accepte la <a href="/mentions-legales">politique de confidentialité</a>
        </label>
        <br>

        <!-- Bouton S'inscrire -->
        <button type="submit">S'inscrire</button>

    </form>
    <br>
    <a href="/connexion">J'ai déjà un compte. Me connecter</a>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>