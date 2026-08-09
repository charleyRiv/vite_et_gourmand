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
    <form action="/commande/etape-1" method="POST">
        <fieldset>
            <legend>Coordonnées</legend>

            <!-- Champs Nom -->
            <label for="last_name">Nom</label>
            <input 
                type="text" 
                id="last_name" 
                name="last_name"
                value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" 
                required
            >

            <!-- Champs Prenom -->
            <label for="first_name">Prenom</label>
            <input 
                type="text" 
                id="first_name" 
                name="first_name"
                value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" 
                required
            >

            <br>

            <!-- Champs Telephone -->
            <label for="phone">Téléphone</label>
            <input 
                type="text" 
                id="phone" 
                name="phone" 
                value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                required
            >

            <br>

            <!-- Champs Email -->
            <label for="email">Email</label>
            <input 
                type="text" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                required
            >
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
                <input type="time" id="heure_livraison" name="heure_livraison" min="10:30" max="23:00" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Adresse de Livraison</legend>

            <!-- Champs N° voie -->
            <label for="street_number">N° Voie</label>
            <input 
                type="text" 
                id="street_number" 
                name="street_number" 
                value="<?= htmlspecialchars($user['street_number'] ?? '') ?>" 
                required
            >

            <!-- Champs Type voie -->
            <label for="street_type">Type de voie</label>
            <input 
                type="text" 
                id="street_type" 
                name="street_type" 
                value="<?= htmlspecialchars($user['street_type'] ?? '') ?>" 
                required
            >

            <!-- Champs Nom voie -->
            <label for="street_name">Nom de la voie</label>
            <input 
                type="text" 
                id="street_name" 
                name="street_name" 
                value="<?= htmlspecialchars($user['street_name'] ?? '') ?>" 
                required
            >

            <!-- Champs Code Postal -->
            <label for="zip_code">Code postal</label>
            <input 
                type="text" 
                id="zip_code" 
                name="zip_code" 
                value="<?= htmlspecialchars($user['zip_code'] ?? '') ?>" 
                required
            >

            <!-- Champs Ville -->
            <label for="city">Ville</label>
            <input 
                type="text" 
                id="city" 
                name="city" 
                value="<?= htmlspecialchars($user['city'] ?? '') ?>" 
                required
            >

            <br>

            <!-- Champs Pays -->
            <label for="country">Pays</label>
            <input 
                type="text" 
                id="country" 
                name="country" 
                value="<?= htmlspecialchars($user['country'] ?? '') ?>" 
                required
            >
        </fieldset>

        <!-- Bouton S'inscrire -->
        <a href="/menus">Revenir à la liste des menus</a>
        <!-- Bouton S'inscrire -->
        <button type="submit">Suivant</button>

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>