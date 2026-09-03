<?php
/**
 * @var string $h1
 * @var array $user
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-order1">
    <section class="section-order1-intro">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
                <div class="col-auto order1-infos">
                    <p> 🕐 Délai de commande <br>
                        Chaque menu a un délai minimum de commande
                        indiqué sur sa fiche. Veillez à commander
                        suffisamment à l'avance.
                    </p>
                    <p>📍 Frais de livraison <br>
                        La livraison est offerte à Bordeaux. <br>
                        En dehors de Bordeaux : 5€ + 0,59€/km.
                    </p>
                    <p>👥  Nombre de personnes minimum <br>
                        Chaque menu impose un nombre minimum
                        de convives indiqué sur sa fiche.
                    </p>
                    <p>🎉 Réduction automatique <br>
                        Une réduction de 10% est appliquée
                        automatiquement si vous commandez pour
                        5 personnes de plus que le minimum requis.
                    </p>
                </div>
                <div class="col-12">
                    <h4>Étape 1 - Informations de votre prestation <br>
                        Ces informations nous permettront d'organiser la livraison 
                        de votre commande dans les meilleures conditions.
                    </h4>
                </div>
            </div>
        </div>
    </section>
    <section class="section-order1-form">
        <div class="container">
            <div class="row">
                <form action="/commande/etape-1" method="POST">
                    <fieldset class="order1-user-form">
                        <legend>Contact client</legend>
                        <!-- Champs Nom -->
                        <div class="col-12 order1-label">
                            <label for="last_name">Nom</label>
                        </div>

                        <div class="col-12 order1-input">
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name"
                                value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un nom</div>
                        </div>

                        <!-- Champs Prenom -->
                        <div class="col-12 order1-label">
                            <label for="first_name">Prénom</label>
                        </div>

                        <div class="col-12 order1-input">
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name"
                                value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un prénom</div>
                        </div>

                        <!-- Champs Telephone -->
                        <div class="col-12 order1-label">
                            <label for="phone">Téléphone</label>
                        </div>

                        <div class="col-12 order1-input">
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide</div>
                        </div>

                        <!-- Champs Email -->
                        <div class="col-12 order1-label">
                            <label for="email">Email</label>
                            </div>

                        <div class="col-12 order1-input">
                            <input 
                                type="text" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un mail valide</div>
                        </div>
                    </fieldset>

                    <fieldset class="order1-date-form">
                        <legend>Date et Heure de livraison</legend>

                        <div class="row date-form">
                            <!-- Date -->
                            <div class="col-12 col-xl-6">
                                <label for="date_livraison" class="order1-label">Date de livraison</label>

                                <input 
                                    type="text" 
                                    id="date_livraison" 
                                    name="date_livraison" 
                                    class="order1-input datepicker"
                                    placeholder="Sélectionner une date"
                                    required>
                                <div class="invalid-feedback">
                                    La date séléctionnée est indisponible. <br>
                                    Veuillez séléctionner une autre date.

                                </div>
                            </div>

                            <!-- Heure -->
                            <div class="col-12 col-xl-6">
                                <label for="heure_livraison" class="order1-label time">Heure de livraison</label>


                                <select id="delivery_time" name="heure_livraison" class="order1-input time" required>
                                    <option value="">-- Choisir un créneau --</option>
                                    <?php
                                    $start = strtotime('09:00');
                                    $end   = strtotime('20:00');
                                    $step  = 30 * 60; // 30 minutes en secondes

                                    for ($time = $start; $time <= $end; $time += $step):
                                    ?>
                                        <option value="<?= date('H:i', $time) ?>">
                                            <?= date('H\hi', $time) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="order1-delivery-form">
                        <legend>Adresse de Livraison</legend>

                        <div class="row street">
                            <!-- Champs N° voie -->
                            <div class="col-12 col-xl-2">
                                <label for="street_number" class="order1-label">N° Voie</label>
                            
                            <input 
                                type="text" 
                                id="street_number" 
                                name="street_number" 
                                value="<?= htmlspecialchars($user['street_number'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un numéro de voie</div>
                            </div>

                            <!-- Champs Type voie -->
                            <div class="col-12 col-xl-4">
                                <label for="street_type" class="order1-label">Type de voie</label>
                                
                                <input 
                                    type="text" 
                                    id="street_type" 
                                    name="street_type" 
                                    value="<?= htmlspecialchars($user['street_type'] ?? '') ?>" 
                                    class="order1-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir un type de voie</div>
                            </div>

                            <!-- Champs Nom voie -->
                            <div class="col-12 col-xl-6">
                                <label for="street_name" class="order1-label">Nom de la voie</label>
                                
                                <input 
                                    type="text" 
                                    id="street_name" 
                                    name="street_name" 
                                    value="<?= htmlspecialchars($user['street_name'] ?? '') ?>" 
                                    class="order1-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir un nom de voie</div>
                            </div>
                        </div>

                        <div class="row city">
                            <!-- Champs Code Postal -->
                            <div class="col-12 col-xl-3">
                                <label for="zip_code" class="order1-label">Code postal</label>
                                <input 
                                    type="text" 
                                    id="zip_code" 
                                    name="zip_code" 
                                    value="<?= htmlspecialchars($user['zip_code'] ?? '') ?>" 
                                    class="order1-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir un code postal</div>
                            </div>

                            <!-- Champs Ville -->
                            <div class="col-12 col-xl-9">
                                <label for="city" class="order1-label">Ville</label>
                                <input 
                                    type="text" 
                                    id="city" 
                                    name="city" 
                                    value="<?= htmlspecialchars($user['city'] ?? '') ?>" 
                                    class="order1-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir une ville</div>
                            </div>
                        </div>

                        <!-- Champs Pays -->
                        <div class="col-12 order1-label">
                            <label for="country">Pays</label>
                        </div>

                        <div class="col-12 order1-input">
                            <input 
                                type="text" 
                                id="country" 
                                name="country" 
                                value="<?= htmlspecialchars($user['country'] ?? '') ?>" 
                                class="order1-input"
                                required
                            >
                            <div class="invalid-feedback">Veuillez saisir un pays</div>
                        </div>
                    </fieldset>

                    <div class="row next-step">
                        <!-- Bouton S'inscrire -->
                        <div class="col-12 col-lg-6 btn-next">
                            <button type="submit" class="btn btn-primary" id="btn-submit">Suivant</button>
                        </div>

                        <!-- Bouton S'inscrire -->
                        <div class="col-12 col-lg-6 back">
                            <a href="/menus">Revenir à la liste des menus</a>
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