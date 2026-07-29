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
    <section>
        <h2>Mes informations</h2>
        <form action="/mon-espace/profil" method="POST">
                <!-- Champs Nom -->
                <label for="Nom">Nom</label>
                <input type="text" id="lastname" name="lastname" required>

                <!-- Champs Prenom -->
                <label for="Prenom">Prenom</label>
                <input type="text" id="firstname" name="firstname" required>

                <br>

                <!-- Champs Telephone -->
                <label for="phone">Téléphone</label>
                <input type="text" id="phone" name="phone">

                <br>

                <!-- Champs Email -->
                <label for="Email">Email</label>
                <input type="text" id="mail" name="mail" required>

                <!-- Champs N° voie -->
                <label for="numeroVoie">N° Voie</label>
                <input type="text" id="streetNumber" name="streetNumber">

                <!-- Champs Type voie -->
                <label for="typeVoie">Type de voie</label>
                <input type="text" id="streetType" name="streetType">

                <!-- Champs Nom voie -->
                <label for="nomVoie">Nom de la voie</label>
                <input type="text" id="streetName" name="streetName">

                <!-- Champs Code Postal -->
                <label for="codePostal">Code postal</label>
                <input type="text" id="cityCode" name="cityCode">

                <!-- Champs Ville -->
                <label for="Ville">Ville</label>
                <input type="text" id="cityName" name="cityName">

                <!-- Champs Mot de passe -->
                <label for="motDePasse">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <a href="/mot-de-passe-oublie">Modifier mon mot de passe</a>
                
                <!-- Bouton S'inscrire -->
                <input type="submit" value="Valider">
        </form>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>