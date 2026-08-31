<?php
/**
 * @var string $h1
 * @var array $user
 * @var string $heroImage
 */
require_once __DIR__ . '/../layouts/header.php';

$heroTitle = htmlspecialchars($h1);
$heroImage    = '/assets/images/uploads/hero_banner_charte_001.jpeg';
require_once __DIR__ . '/../layouts/hero.php';
?>

<main class="page-contact">
    <section class="section-contact">
        <div class="container">
                <form action="/contact" id="contact-form" method="POST">
                <div class="row">
                    <!-- Champs Email --> 
                    <div class="col-12 contact-label">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-12 contact-input">
                        <?php if (!empty($user)) : ?>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            value="<?= htmlspecialchars($user['email'])?>" 
                            class="w-100 contact-email"
                            required>
                        <?php else : ?>
                        <input type="text" id="email" name="email" class="w-100 contact-email" placeholder="mail@mail.fr"required>
                        <?php endif; ?>
                    <div class="invalid-feedback">Veuillez saisir une adresse email valide.</div>
                    </div>

                    <!-- Champ Titre -->
                    <div class="col-12 contact-label">
                        <label for="title">Titre</label>
                    </div>
                    <div class="col-12 contact-input">
                        <input type="text" id="title" name="title" placeholder="Titre" class="w-100 contact-title" required>
                        <div class="invalid-feedback">Le titre doit contenir au moins 3 caractères.</div>
                    </div>
                

                    <!-- Champ Message -->
                    <div class="col-12 contact-label">
                        <label for="content">Message</label>
                    </div>
                    <div class="col-12 contact-input">
                        <textarea id="content" name="content" class="w-100 contact-content" required></textarea>
                        <div class="invalid-feedback">Le message doit contenir au moins 10 caractères.</div>
                    </div>
                    
                    <!-- Bouton submit -->
                    <div class="col-12 btn">
                        <button type="submit" id="btn-submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>