<?php
/**
 * @var string $h1
 * @var array $users
 * @var array $allusers
 * @var array $errors
 */

require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-gestion-employee">
    <section class="section-filtres">
        <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?= htmlspecialchars($h1) ?></h2>
            </div>
    
            <form action="/admin/employes" method="GET">
                <div class="filtres-grp">
                    <div class="col-12 col-xl-auto show d-none" id="show-employee">
                        <button type="button" class="btn btn-filters">
                            Afficher les employés  <i class="bi bi-chevron-compact-down"></i>
                        </button>
                    </div>
                    <div class="col-12 col-xl-auto show" id="hide-employee">
                        <button type="button" class="btn btn-filters">
                            Masquer les employés  <i class="bi bi-chevron-compact-up"></i>
                        </button>
                    </div>

                    <!-- Champs barre de recherche -->
                    <div class="col-12 col-xl-auto search" id="search-filter">
                        <div class="search-wrapper">
                            <i class="bi bi-search"></i>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                placeholder="Rechercher ..."
                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-xl-auto filtres" id="filters-filter">
                        <!-- Filtre Mail -->
                        <div class="field">
                            <button type="button" id="email-filter-btn" class="btn btn-filters">Mail</button>
                            <div id="email-filter" class="col-auto checkboxes d-none" >
                                    <?php
                                    // Chargement initial = pas de filtre status dans l'URL
                                    $isInitialLoadEmail = !isset($_GET['email']);
                                    ?>
                                    <?php foreach ($allusers as $user) : ?>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            id="<?= htmlspecialchars($user['email'])?>" 
                                            name="email[]"
                                            value="<?= htmlspecialchars($user['email']) ?>"
                                            <?= $isInitialLoadEmail || in_array($user['email'], $_GET['email'] ?? []) 
                                            ? 'checked' : '' ?>
                                        >
                                        <label for="<?= htmlspecialchars($user['email'])?>"><?= htmlspecialchars($user['email'])?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>   
                        </div>

                        <!-- Filtre Statut -->
                        <div class="field">
                            <button type="button" id="status-filter-btn" class="btn btn-filters">Statut</button>

                            <div id="status-filter" class="col-auto checkboxes d-none" >
                                <?php
                                // Chargement initial = pas de filtre status dans l'URL
                                $isInitialLoadStatus = !isset($_GET['status']);
                                ?>
                                <div>
                                    <input 
                                        type="checkbox" 
                                        id="status-is-active" 
                                        name="status[]"
                                        value="is_active"
                                        <?= $isInitialLoadStatus || in_array("is_active", $_GET['status'] ?? []) 
                                        ? 'checked' : '' ?>
                                    >
                                    <label for="status-is-active">Actif</label>
                                </div>
                                <div>
                                    <input 
                                        type="checkbox" 
                                        id="status-is-inactive" 
                                        name="status[]"
                                        value="is_inactive"
                                        <?= $isInitialLoadStatus || in_array("is_inactive", $_GET['status'] ?? []) 
                                        ? 'checked' : '' ?>
                                    >
                                    <label for="status-is-inactive">Inactif</label>
                                </div>  
                            </div>
                        </div>
                    </div>


                    <!-- Boutons -->
                    <div class="col-12 col-xl-auto boutons-filtres" id="boutons-filter">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                        <a href="/admin/employes" class="btn btn-secondary">Réinitialiser</a>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </section>

    <section class="section-show-employee" id="section-employee">
        <div class="container">
            <div class="row">
                <?php foreach ($users as $user) : ?>
                    <fieldset class="col-12 col-xl-4">
                        <div class="col-12">
                            <?= htmlspecialchars($user['last_name'])?> <?= htmlspecialchars($user['first_name'])?>
                        </div>

                        <div class="col-12">
                            Email : <?= htmlspecialchars($user['email'])?>
                        </div>

                        <div class="col-12">
                            Statut : <?= htmlspecialchars($user['is_active']=== 1 ? 'actif' : 'inactif')?>
                        </div>

                        <!-- Boutons -->
                        <div class=" boutons">
                            
                                <?php if ($user['is_active'] === 1) : ?>
                                <!-- Désactiver -->
                                <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/desactiver" method="POST">
                                    <button type="submit" class="btn btn-primary">Désactiver</button>
                                </form>
                                <?php else: ?>
                                <!-- Activer -->
                                <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/activer" method="POST">
                                    <button type="submit" class="btn btn-primary">Activer</button>
                                </form>
                                <?php endif; ?>
                            
                                <!-- Supprimer -->
                                <form action="/admin/employes/<?= htmlspecialchars($user['user_id']) ?>/supprimer" method="POST">
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            
                        </div>
                    </fieldset>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-new-employee">
        <div class="container">
            <div class="row">

            <?php if (!empty($errors)) : ?>
                <div class="col">
                    <?php foreach ($errors as $error) : ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Creer un nouvel employé -->
            <div class="col-12 bouton">
                <button type="button" id="new-employee-form-btn" class="btn btn-primary">Créer un nouvel employé</button>
            </div>

            <form action="/admin/employes/creer" method="POST" id="new-employee-form" class="d-none">
                <div class="row new-employee-form">
                    <!-- Champs Nom -->
                    <div class="col-12">
                        <label for="last_name">Nom</label>
                        <input type="text" id="last_name" name="last_name" required>
                        <div class="invalid-feedback">Veuillez saisir votre nom</div>
                    </div>

                    <!-- Champs Prenom -->
                    <div class="col-12">
                        <label for="first_name">Prénom</label>
                        <input type="text" id="first_name" name="first_name" required>
                        <div class="invalid-feedback">Veuillez saisir votre prénom</div>
                    </div>

                    <!-- Champs Email -->
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" required>
                        <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide</div>
                    </div>

                    <!-- Champs Mot de passe -->
                    <div class="col-12">             
                        <label for="password">Mot de passe</label>
                        <div class="input-eye-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                            >
                            <button type="button" class="btn-eye" id="btn-eye-password">
                                <i class="bi bi-eye" id="icon-eye-password"></i>
                            </button>
                            <div class="invalid-feedback">8 caractères minimum, dont au moins 1 lettre minuscule, 1 majuscule, 1 chiffre et 1 caractere special</div>
                        </div>
                    </div>

                    
                    <!-- Champs Confirmation mot de passe-->
                    <div class="col-12"> 
                        <label for="password_confirm">Confirmation mot de passe</label>
                        <div class="input-eye-wrapper">
                            <input 
                                type="password" 
                                id="password_confirm" 
                                name="password_confirm" 
                                required
                            >
                            <button type="button" class="btn-eye" id="btn-eye-passwordConf">
                                <i class="bi bi-eye" id="icon-eye-passwordConf"></i>
                            </button>
                            <div class="invalid-feedback">Les mots de passe ne correspondent pas</div>

                        </div>
                    
                    <!-- Bouton S'inscrire -->
                    <div class="col-12 bouton">
                        <button type="submit" id="btn-submit" class="btn btn-success">Créer</button>
                    </div>
                </div>
            </form>
    </section>

    <section>
        <div class="container">
            <a href="/admin/">Revenir au dashboard</a>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>