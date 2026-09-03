<?php
/**
 * @var string $h1
 * @var array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-profil-client">
    <section class="section-profil-client-modify">
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
                        <div class="profil-client-form">
                            <div class="row profil-client-name">
                                    <!-- Champs Nom -->
                                <div class="col-12 col-lg-6">
                                    <label for="last_name" class="profil-client-label">Nom <span>*</span></label>
                                
                                    <input 
                                        type="text" 
                                        id="last_name" 
                                        name="last_name" 
                                        value= "<?= htmlspecialchars($_POST['last_name'] ??'') ?>"
                                        class="profil-client-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir votre nom</div>
                                </div>

                                <!-- Champs Prenom -->
                                <div class="col-12 col-lg-6">
                                    <label for="first_name" class="profil-client-label">Prenom <span>*</span></label>
                                
                                    <input 
                                        type="text" 
                                        id="first_name" 
                                        name="first_name"
                                        value= "<?= htmlspecialchars($_POST['first_name'] ??'') ?>" 
                                        class="profil-client-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir votre prénom</div>
                                </div>

                            </div>

                            <!-- Champs Telephone -->
                            <div class="col-12 profil-client-label">
                                <label for="phone">Téléphone</label>
                            </div>
                            <div class="col-12">
                                <input 
                                    type="text" 
                                    id="phone" 
                                    name="phone"
                                    class="profil-client-input"
                                    value= "<?= htmlspecialchars($_POST['phone'] ??'') ?>"
                                >
                                <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide</div>
                            </div>


                            <!-- Champs Email -->
                            <div class="col-12 profil-client-label">
                                <label for="email">Email <span>*</span></label>
                            </div>

                            <div class="col-12">
                                <input 
                                    type="text" 
                                    id="email" 
                                    name="email"
                                    class="profil-client-input"
                                    value= "<?= htmlspecialchars($_POST['email'] ??'') ?>" 
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir une adresse email valide</div>
                            </div>

                            <div class="row profil-client-street">
                                <!-- Champs N° voie -->
                                <div class="col-12 col-lg-2">
                                    <label for="street_number" class="profil-client-label">N° Voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_number" 
                                        name="street_number"
                                        value= "<?= htmlspecialchars($_POST['street_number'] ??'') ?>"
                                        class="profil-client-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un numéro de rue valide</div>

                                </div>

                                <!-- Champs Type voie -->
                                <div class="col-12 col-lg-3">
                                    <label for="street_type" class="profil-client-label">Type de voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_type" 
                                        name="street_type"
                                        value= "<?= htmlspecialchars($_POST['street_type'] ??'') ?>"
                                        class="profil-client-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un type de voie valide</div>

                                </div>

                                <!-- Champs Nom voie -->
                                <div class="col-12 col-lg-7 ">
                                    <label for="street_name" class="profil-client-label">Nom de la voie</label>
                                
                                    <input 
                                        type="text" 
                                        id="street_name" 
                                        name="street_name"
                                        value= "<?= htmlspecialchars($_POST['street_name'] ??'') ?>"
                                        class="profil-client-input"
                                    >  
                                    <div class="invalid-feedback">Veuillez saisir un nom de voie valide</div>

                                </div>  
                            </div>

                            <div class="row profil-client-city">
                                <!-- Champs Code Postal -->
                                <div class="col-12 col-lg-3">
                                    <label for="zip_code" class="profil-client-label">Code postal</label>
                                
                                    <input 
                                        type="text" 
                                        id="zip_code" 
                                        name="zip_code"
                                        value= "<?= htmlspecialchars($_POST['zip_code'] ??'') ?>"
                                        class="profil-client-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un code postal valide</div>
                                </div>

                                <!-- Champs Ville -->
                                <div class="col-12 col-lg-9">
                                    <label for="city" class="profil-client-label">Ville</label>
                
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city"
                                        value= "<?= htmlspecialchars($_POST['city'] ??'') ?>"
                                        class="profil-client-input"
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un nom de ville valide</div>
                                </div>
                            </div>

                            <!-- Champs Pays -->
                            <div class="col-12 profil-client-label">
                                <label for="country">Pays</label>
                            </div>
                            <div class="col-12">
                                <input 
                                    type="text" 
                                    id="country" 
                                    name="country"
                                    class="profil-client-input"
                                    value= "<?= htmlspecialchars($_POST['country'] ??'') ?>"
                                >
                                <div class="invalid-feedback">Veuillez saisir un nom de pays valide</div>
                            </div>

                            <div class="row boutons-next">
                                <div class="col-12">
                                    <small><span>*</span> Champs obligatoires</small>
                                </div>

                                <!-- Bouton Modifier le mot de passe -->
                                <div class="col-12 modify-password">
                                    <a href="/mot-de-passe-oublie" class="btn btn-primary">Modifier mon mot de passe</a>
                                </div>

                                <div class="row validate">
                                    <!-- Bouton Valider -->
                                    <div class="col-12 col-lg-6 btn-submit">
                                        <button type="submit" class="btn btn-success" id="btn-submit">Valider</button>
                                    </div>

                                    <div class="col-12 col-lg-6 back">
                                        <a href="/mon-espace">Revenir à mon espace</a>
                                    </div>
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