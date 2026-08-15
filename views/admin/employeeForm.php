<?php
/**
 * @var string $h1
 * @var array $users
 * @var array $errors
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
                <label for="email">Mail</label>
                <input type="texte" id="email" name="email">

                <!-- Filtre Régime -->
                <label for="status">Statut</label>
                    <select name="status" id="status">
                        <option value="enable">Actif</option>
                        <option value="disable">Inactif</option>
                    </select>


                <!-- Boutons -->
                <button type="button">Filtrer</button>
                <button type="button">Réinitialiser</button>
            </form>
        </div>
    </section>
    <section>
        <?php foreach ($users as $user) : ?>
        <div>
            <p><?= htmlspecialchars($user['last_name'])?> <?= htmlspecialchars($user['first_name'])?></p>
            <p>Email : <?= htmlspecialchars($user['email'])?></p>
            <p>Statut : <?= htmlspecialchars($user['is_active']=== 1 ? 'actif' : 'inactif')?></p>
            <!-- Boutons -->
            <?php if ($user['is_active'] === 1) : ?>
            <!-- Désactiver -->
            <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/desactiver" method="POST">
                <button type="submit">Désactiver</button>
            </form>
            <?php else: ?>
            <!-- Activer -->
            <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/activer" method="POST">
                <button type="submit">Activer</button>
            </form>
            <?php endif; ?>

            <!-- Supprimer -->
            <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/supprimer" method="POST">
                <button type="submit">Supprimer</button>
            </form>
        </div>
        <?php endforeach; ?>
    </section>
    <section>
        <?php if (!empty($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

            <!-- Creer un nouvel employé -->
            <button type="button">Créer un nouvel employé</button>

            <form action="/admin/employes/creer" method="POST">

                <!-- Champs Nom -->
                <label for="last_name">Nom</label>
                <input type="text" id="last_name" name="last_name" required>

                <!-- Champs Prenom -->
                <label for="first_name">Prénom</label>
                <input type="text" id="first_name" name="first_name" required>
                <br>
                <!-- Champs Email -->
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
                <br>
                <br>
                <!-- Champs Mot de passe -->
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>

                <br>
                <!-- Champs Confirmation mot de passe-->
                <label for="password_confirm">Confirmation mot de passe</label>
                <input type="password" id="password_confirm" name="password_confirm" required>

                <br>
                <!-- Bouton S'inscrire -->
                <button type="submit">Créer</button>

            </form>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>