<?php
/**
 * @var string $h1
 */

require_once __DIR__ . '/../layouts/header.php';
?>

<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    
    <section>
        <div>
            <form action="/admin/employes" method="POST">
                <input type="bouton" value="Afficher les employés">

                <!-- Champs barre de recherche -->
                <label for="search">Recherche</label>
                <input type="texte" id="search" name="search">

                <!-- Filtre Catégorie -->
                <label for="mail">Mail</label>
                <input type="texte" id="mail" name="mail">

                <!-- Filtre Régime -->
                <label for="status">Statut</label>
                    <select name="status" id="status">
                        <option value="enable">Actif</option>
                        <option value="disable">Inactif</option>
                    </select>


                <!-- Boutons -->
                <input type="button" value="Filtrer">
                <input type="button" value="Reinitialiser">
            </form>
        </div>

        <div>
            <!-- Boutons -->
            <!-- Désactiver -->
            <form action="/admin/employes/1/desactiver" method="POST">
                <input type="submit" value="Désactiver">
            </form>

            <!-- Supprimer -->
            <form action="/admin/employes/1/supprimer" method="POST">
                <input type="submit" value="Supprimer">
            </form>
        </div>

        <div>
            <!-- Boutons -->
            <!-- Désactiver -->
            <form action="/admin/employes/1/desactiver" method="POST">
                <input type="submit" value="Désactiver">
            </form>

            <!-- Supprimer -->
            <form action="/admin/employes/1/supprimer" method="POST">
                <input type="submit" value="Supprimer">
            </form>
        </div>
    <section>
        <div>
            <!-- Creer un nouvel employé -->
            <form action="/admin/employes/creer" method="POST">
                <input type="submit" value="Créer un nouvel employé">
            </form>

        </div>

        <div>
            <form action="/admin/employes/update" method="POST">

                <!-- Champs Email -->
                <label for="Email">Email</label>
                <input type="text" id="mail" name="mail" required>

                <!-- Champs Mot de passe -->
                <label for="motDePasse">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <!-- Champs Confirmation mot de passe-->
                <label for="motDePasseConfirm">Confirmation mot de passe</label>
                <input type="password" id="password" name="passwordConfirm" required>

                <!-- Bouton S'inscrire -->
                <input type="submit" value="Valider">

            </form>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>