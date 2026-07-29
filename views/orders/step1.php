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
    <form action="/commande/etape-1" method="POST">
        <fieldset>
            <legend>Coordonnées</legend>

            <!-- Champs Nom -->
            <label for="Nom">Nom</label>
            <input type="text" id="lastname" name="lastname" required>

            <!-- Champs Prenom -->
            <label for="Prenom">Prenom</label>
            <input type="text" id="firstname" name="firstname" required>

            <br>

            <!-- Champs Telephone -->
            <label for="phone">Téléphone</label>
            <input type="text" id="phone" name="phone" required>

            <br>

            <!-- Champs Email -->
            <label for="Email">Email</label>
            <input type="text" id="mail" name="mail" required>
        </fieldset>

        <fieldset>
            <legend>Date et Heure de livraison</legend>
            
            <!-- Date -->
            <div>
                <label for="date_livraison">Date de livraison</label>
                <input type="date" id="date_livraison" name="date_livraison" required>
            </div>

            <!-- Heure -->
            <div>
                <label for="heure_livraison">Heure de livraison</label>
                <input type="time" id="heure_livraison" name="heure_livraison" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Adresse de Livraison</legend>

            <!-- Champs N° voie -->
            <label for="numeroVoie">N° Voie</label>
            <input type="text" id="streetNumber" name="streetNumber" required>

            <!-- Champs Type voie -->
            <label for="typeVoie">Type de voie</label>
            <input type="text" id="streetType" name="streetType" required>

            <!-- Champs Nom voie -->
            <label for="nomVoie">Nom de la voie</label>
            <input type="text" id="streetName" name="streetName" required>

            <!-- Champs Code Postal -->
            <label for="codePostal">Code postal</label>
            <input type="text" id="cityCode" name="cityCode" required>

            <!-- Champs Ville -->
            <label for="Ville">Ville</label>
            <input type="text" id="cityName" name="cityName" required>
        </fieldset>

        <!-- Bouton S'inscrire -->
        <input type="submit" value="Suivant">

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>