<?php
/**
 * @var string $h1
 * @var array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <section>
        <h2>Mes informations</h2>
        <form action="/mon-espace/profil" method="POST">
                <!-- Champs Nom -->
                <label for="last_name">Nom</label>
                <input 
                    type="text" 
                    id="last_name" 
                    name="last_name" 
                    value="<?= htmlspecialchars($user['last_name']) ?? '' ?>"
                    required
                >

                <!-- Champs Prenom -->
                <label for="first_name">Prenom</label>
                <input 
                    type="text" 
                    id="first_name" 
                    name="first_name" 
                    value="<?= htmlspecialchars($user['first_name']) ?? '' ?>"
                    required
                >
                <br>

                <!-- Champs Telephone -->
                <label for="phone">Téléphone</label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    value="<?= htmlspecialchars($user['phone']) ?? '' ?>"
                >

                <br>

                <!-- Champs Email -->
                <label for="email">Email</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($user['email']) ?? '' ?>"
                    readonly
                >
                <br>
                <!-- Champs N° voie -->
                <label for="street_number">N° Voie</label>
                <input 
                    type="text" 
                    id="street_number" 
                    name="street_number" 
                    value="<?= htmlspecialchars($user['street_number']) ?? '' ?>"
                >

                <!-- Champs Type voie -->
                <label for="street_type">Type de voie</label>
                <input 
                    type="text" 
                    id="street_type" 
                    name="street_type" 
                    value="<?= htmlspecialchars($user['street_type']) ?? '' ?>"
                >

                <!-- Champs Nom voie -->
                <label for="street_name">Nom de la voie</label>
                <input 
                    type="text" 
                    id="street_name" 
                    name="street_name" 
                    value="<?= htmlspecialchars($user['street_name']) ?? '' ?>"
                >
                <br>
                <!-- Champs Code Postal -->
                <label for="zip_code">Code postal</label>
                <input 
                    type="text" 
                    id="zip_code" 
                    name="zip_code" 
                    value="<?= htmlspecialchars($user['zip_code']) ?? '' ?>"
                >

                <!-- Champs Ville -->
                <label for="city">Ville</label>
                <input 
                    type="text" 
                    id="city" 
                    name="city" 
                    value="<?= htmlspecialchars($user['city']) ?? '' ?>"
                >

                <br>
                <!-- Champs Ville -->
                <label for="country">Pays</label>
                <input 
                    type="text" 
                    id="country" 
                    name="country" 
                    value="<?= htmlspecialchars($user['country']) ?? '' ?>"
                >

                <br>
                <a href="/mot-de-passe-oublie">Modifier mon mot de passe</a>
                <br>
                
                <!-- Bouton Valider -->
                <input type="submit" value="Valider">
                <br>
                <a href="/mon-espace">Revenir à mon espace</a>
        </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>