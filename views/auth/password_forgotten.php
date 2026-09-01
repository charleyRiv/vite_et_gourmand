<?php
/**
 * @var string $h1
 * @var array $errors
 * @var bool $succes
 * @var string $email
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-reinit-password">
    <section class="section-reinit-password">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?=  htmlspecialchars($h1)?></h1>
                </div>

                <div class="col-12 ">
                    <p class="mb-0">Saisissez l'adresse email associée à votre compte et 
                        nous vous enverrons un lien pour créer un nouveau mot de passe.
                    </p>
                </div>
                    <!--Affichage des erreurs-->
                    <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <div class="col-12 error">
                                <li class="list-unstyled"><?= htmlspecialchars($error)?></li>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                        
                    <!--Message pour lien de réinitialisation -->
                    <?php if (isset($succes) && $succes): ?>
                        <div class="col-12">
                            <p class="mb-0">
                                Si un compte est associé à cette adresse email, vous recevrez
                                dans quelques instants un lien de réinitialisation.
                                Pensez à vérifier vos spams.
                            </p>
                        </div>
                    <?php else: ?>
                    
                        <form action="/mot-de-passe-oublie" method="POST">
                            <div class="reinit-password-form">
                                <!-- Champs Email -->
                                <div class="col-12 reinit-password-label">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-12 reinit-password-input">
                                    <input 
                                        type="text" 
                                        id="email" 
                                        name="email" 
                                        value="<?= htmlspecialchars($email ?? '')?>"
                                        placeholder="mail@mail.fr"
                                        class="reinit-password-input" 
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez renseigner une adresse mail valide</div>
                                </div>
                                <!-- Bouton Se connecter -->
                                <div class="col-12 btn-reinit">
                                    <button type="submit" class="btn btn-primary" id="btn-submit">Réinitialiser</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                    <div class="col-12">
                        <a href="/connexion">← Retour à la connexion</a>
                    </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>