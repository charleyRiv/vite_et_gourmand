<?php
/**
 * @var string $h1
 * @var array $errors
 * @var string $token
 * @var ?array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-reset-password">
    <section class="section-reset-password">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?=  htmlspecialchars($h1)?></h1>
                </div>

                <div class="col-12">
                    <p class="mb-0">Choisissez un mot de passe solide pour sécuriser votre compte. 
                        Il doit contenir au minimum 8 caractères, dont une majuscule, une minuscule, 
                        un chiffre et un caractère spécial.
                    </p>
                </div>

                <?php if (!empty($errors)) : ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <div class="col-12 error">
                                <li class="list-unstyled"><?= htmlspecialchars($error) ?></li>
                            </div>
                        <?php endforeach ;?>
                    </ul>
                    <div class="col-12 new-request">
                        <a href="/mot-de-passe-oublie">Faire une nouvelle demande</a>
                    </div>
                <?php elseif (isset($user) && $user !== null): ?>
                
                    <form action="/mot-de-passe-oublie/reinitialisation" method="POST">
                        <div class="reset-password-form">
                            <!-- Token caché - transmis avec le formulaire-->
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                            <!-- Champs Mot de passe -->
                            <div class="col-12 reset-password-label">
                                <label for="password">Nouveau mot de passe</label>
                            </div>

                            <div class="input-eye-wrapper">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="reset-password-input pe-5"
                                    required
                                >
                                <button type="button" class="btn-eye" id="btn-eye-password">
                                        <i class="bi bi-eye" id="icon-eye-password"></i>
                                </button>
                                <div class="invalid-feedback">8 caractères minimum, une majuscule, une minuscule,
                                un chiffre et un caractère spécial.</div>
                            </div>

                            <div class="col-12 reset-password-detail">
                                <small>8 caractères minimum, une majuscule, une minuscule,
                                un chiffre et un caractère spécial.</small>
                            </div>

                            <!-- Champs Confirmation mot de passe-->
                            <div class="col-12 reset-password-label">
                                <label for="password_confirm">Confirmer le nouveau mot de passe</label>
                            </div>

                            <div class="input-eye-wrapper">
                                <input 
                                    type="password" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    class="reset-password-input pe-5"
                                    required
                                >
                                <button type="button" class="btn-eye" id="btn-eye-passwordConf">
                                        <i class="bi bi-eye" id="icon-eye-passwordConf"></i>
                                </button>
                                <div class="invalid-feedback">Les mots de passe ne correspondent pas</div>
                            </div>

                                <!-- Bouton Se connecter -->
                            <div class="col-12 btn-validate">
                                <button type="submit" class="btn btn-success" id="btn-submit">Valider</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>