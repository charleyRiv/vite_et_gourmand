<?php
/**
 * @var string $h1
 * @var array $errors
 * @var bool $registrered
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-login">
    <section class="section-login">
        <div class="container">
            <form action="/connexion" method="POST">
                <div class="row">
                    <div class="col-12">
                        <h1><?=  htmlspecialchars($h1)?></h1>
                    </div> 
                    <div class="col-12">
                        <!-- Message de succès après inscription -->
                        <?php if (isset($registrered) && $registrered): ?>
                            <p> Compte créé avec succès ! Vous pouvez maintenant vous connecter</p>
                        <?php endif ; ?>
                        
                        <!-- Message succès après réinitialisation -->
                            <?php if (isset($_GET['reset'])): ?>
                                <p>Votre mot de passe a bien été modifié. Vous pouvez maintenant vous connecter</p>
                            <?php endif; ?>
                            
                        <!-- Erreurs -->
                        <?php if (!empty($errors)): ?>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>     
                    <div class="login-form">                
                        <!-- Champs Email -->
                        <div class="col-12 login-label">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-12 login-input">
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                value = "<?= htmlspecialchars($_POST['email'] ?? '')?>"
                                class="login-email"
                                required
                                autocomplete="email"
                            >
                            <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                        </div>        
                                    
                        <!-- Champs Mot de passe -->
                        <div class="col-12 login-label">
                            <label for="password">Mot de passe</label>
                        </div>
                        <div class="col-12 login-input">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="login-password"
                                required
                                autocomplete="current-password"
                            >
                            <div class="invalid-feedback">Le mot de passe doit contenir au moins 8 caractères</div>
                        </div>
                        <div class="col-12">       
                            <a href="/mot-de-passe-oublie">Mot de passe oublié ?</a>
                        </div>
                        <!-- Bouton Se connecter -->
                        <div class="col-12 btn">
                            <button type="submit" id="btn-submit" class="btn btn-primary">Se connecter</button>
                        </div>
                        <div class="col-12 login-subscribe">
                            <a href="/inscription">Je n'ai pas encore de compte. Je m'inscris</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>