<?php
/**
 * @var array $errors
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-register">
    <section class="section-register">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?=  htmlspecialchars($h1)?></h1>
                </div>
                <!-- Affichage des erreurs -->
                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                        <div class="col-auto">
                            <li><?=  htmlspecialchars($error)?></li>
                        </div>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
                            
                    <form action="/inscription" method="POST">
                        <div class="register-form">
                            <div class="row g-5 register-name">
                                    <!-- Champs Nom -->
                                <div class="col-12 col-lg-6">
                                    <label for="last_name" class="register-label">Nom <span>*</span></label>
                                
                                    <input 
                                        type="text" 
                                        id="last_name" 
                                        name="last_name" 
                                        value= "<?= htmlspecialchars($_POST['last_name'] ??'') ?>"
                                        class="register-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir votre nom</div>
                                </div>

                                <!-- Champs Prenom -->
                                <div class="col-12 col-lg-6">
                                    <label for="first_name" class="register-label">Prenom <span>*</span></label>
                                
                                    <input 
                                        type="text" 
                                        id="first_name" 
                                        name="first_name"
                                        value= "<?= htmlspecialchars($_POST['first_name'] ??'') ?>" 
                                        class="register-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir votre prénom</div>
                                </div>

                            </div>

                            <!-- Champs Telephone -->
                            <div class="col-12 register-label">
                                <label for="phone">Téléphone</label>
                            </div>
                            <div class="col-12 register-input">
                                <input 
                                    type="text" 
                                    id="phone" 
                                    name="phone"
                                    class="register-input"
                                    value= "<?= htmlspecialchars($_POST['phone'] ??'') ?>"
                                >
                                <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide</div>
                            </div>


                            <!-- Champs Email -->
                            <div class="col-12 register-label">
                                <label for="email">Email <span>*</span></label>
                            </div>

                            <div class="col-12 register-input">
                                <input 
                                    type="text" 
                                    id="email" 
                                    name="email"
                                    class="register-input"
                                    value= "<?= htmlspecialchars($_POST['email'] ??'') ?>" 
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir une adresse email valide</div>
                            </div>

                            <div class="row g-5 register-street">
                                <!-- Champs N° voie -->
                                <div class="col-12 col-lg-2">
                                    <label for="street_number" class="register-label">N° Voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_number" 
                                        name="street_number"
                                        value= "<?= htmlspecialchars($_POST['street_number'] ??'') ?>"
                                        class="register-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un numéro de rue valide</div>

                                </div>

                                <!-- Champs Type voie -->
                                <div class="col-12 col-lg-3">
                                    <label for="street_type" class="register-label">Type de voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_type" 
                                        name="street_type"
                                        value= "<?= htmlspecialchars($_POST['street_type'] ??'') ?>"
                                        class="register-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un type de voie valide</div>

                                </div>

                                <!-- Champs Nom voie -->
                                <div class="col-12 col-lg-7 ">
                                    <label for="street_name" class="register-label">Nom de la voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_name" 
                                        name="street_name"
                                        value= "<?= htmlspecialchars($_POST['street_name'] ??'') ?>"
                                        class="register-input"
                                    >  
                                    <div class="invalid-feedback">Veuillez saisir un nom de voie valide</div>

                                </div>  
                            </div>

                            <div class="row g-5 register-city">
                                <!-- Champs Code Postal -->
                                <div class="col-12 col-lg-6">
                                    <label for="zip_code" class="register-label">Code postal</label>
                                
                                    <input 
                                        type="text" 
                                        id="zip_code" 
                                        name="zip_code"
                                        value= "<?= htmlspecialchars($_POST['zip_code'] ??'') ?>"
                                        class="register-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un code postal valide</div>
                                </div>

                                <!-- Champs Ville -->
                                <div class="col-12 col-lg-6">
                                    <label for="city" class="register-label">Ville</label>
                
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city"
                                        value= "<?= htmlspecialchars($_POST['city'] ??'') ?>"
                                        class="register-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un nom de ville valide</div>
                                </div>
                            </div>

                            <!-- Champs Pays -->
                            <div class="col-12 register-label">
                                <label for="country">Pays</label>
                            </div>
                            <div class="col-12 register-input">
                                <input 
                                    type="text" 
                                    id="country" 
                                    name="country"
                                    class="register-input"
                                    value= "<?= htmlspecialchars($_POST['country'] ??'') ?>"
                                >
                                <div class="invalid-feedback">Veuillez saisir un nom de pays valide</div>
                            </div>

                            <!-- Champs Mot de passe -->
                            <div class="col-12 register-label">
                                <label for="password">Mot de passe <span>*</span></label>
                            </div>
                            <div class="input-eye-wrapper">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="register-input pe-5"
                                    required
                                >
                                <button type="button" class="btn-eye" id="btn-eye-password">
                                    <i class="bi bi-eye" id="icon-eye-password"></i>
                                </button>
                                <div class="invalid-feedback">8 caractères minimum, dont au moins 1 lettre minuscule, 1 majuscule, 1 chiffre et 1 caractere special</div>

                            </div>
                            <div class="col-12 register-detail">
                                <small>8 caractères minimum, dont au moins 1 lettre minuscule, 1 majuscule, 1 chiffre et 1 caractere special</small>
                            </div>

                            <!-- Champs Confirmation mot de passe-->
                            <div class="col-12 register-label">
                                <label for="password_confirm">Confirmation mot de passe <span>*</span></label>
                            </div>

                                <div class="input-eye-wrapper">
                                    <input 
                                        type="password" 
                                        id="password_confirm" 
                                        name="password_confirm" 
                                        class="register-input pe-5"
                                        required
                                    >
                                    <button type="button" class="btn-eye" id="btn-eye-passwordConf">
                                        <i class="bi bi-eye" id="icon-eye-passwordConf"></i>
                                    </button>
                                    <div class="invalid-feedback">Les mots de passe ne correspondent pas</div>

                                </div>


                            <div class="col-12">
                                <small><span>*</span> Champs obligatoires</small>
                            </div>

                            <div class="col-12 register-consent">
                                <div class="d-flex gap-2">
                                    <input type="checkbox" id="consent" name="consent" value="1" class="mt-1 register-input" required>
                                    <label for="consent" class="mb-0">
                                        J'accepte la 
                                        <a href="/mentions-legales">politique de confidentialité</a>
                                    </label>
                                    <div class="invalid-feedback">Veuillez accepter la politique de confidentialité</div>
                                </div>
                            </div>

                            <!-- Bouton S'inscrire -->
                            <div class="col-12 btn-register">
                                <button type="submit" class="btn btn-success" id="btn-submit">M'inscrire</button>
                            </div>

                            <div class="col-12 register-login">
                                <a href="/connexion">J'ai déjà un compte. Me connecter</a>
                            </div>
                        </div>        
                    </form>
                </div>
            </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>