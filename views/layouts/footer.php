<?php
require_once __DIR__ . '/../../src/Models/ContentModel.php';
$contentModel = new ContentModel();
$schedule = $contentModel->getByFilter('footer', 'Horaires');

?>
<footer>
    <section class="footer">
        <hr class="separator">
        <div class="container small">
            <div class="row flex-lg-row-reverse justify-content-around align-items-center">
                
                <!-- Footer links - apparait en dernier sur lg -->
                <div class="col-12 col-lg-auto footer-links">
                    <div class="d-flex flex-lg-column justify-content-center align-items-center">
                        <a href="">
                            <img 
                                src="/assets/images/uploads/icone_facebook.svg"
                                alt="facebook"
                                class="icone">
                        </a>
                        <a href="">
                            <img 
                                src="/assets/images/uploads/icone_instagram.svg"
                                alt="instagram"
                                class="icone">
                        </a>
                        <a href="/contact">
                            <img src="/assets/images/uploads/icone_contact.svg"
                            alt="contact"
                            class="icone">
                        </a>
                    </div> 
                </div>               

                <!-- Footer legal -apparait en premier sur lg -->
                <div class="col-12 col-lg-auto footer-schedule">
                        <h4 class="text-center">Horaires</h4>
                    <div class="d-flex justify-content-between">
                        <ul class="list-unstyled text-start">
                            <li>Lundi</li>
                            <li>Mardi</li>
                            <li>Mercredi</li>
                            <li>Jeudi</li>
                            <li>Vendredi</li>
                            <li>Samedi</li>
                            <li>Dimanche</li>
                        </ul>
                        <p class="text-end"><?= nl2br(htmlspecialchars($schedule[0]['content'])) ?></p>
                    </div>
                </div>

                <!-- Footer legal - apparait en premier sur lg -->
                <div class="col-12 col-lg-auto footer-legal">
                    <div class="d-flex flex-lg-column justify-content-center align-items-lg-center">
                        <a href="/legal">Mention légales</a>
                        <a href="/cgv">cgv</a>
                    </div>
                </div> 
            </div>
        </div>
    </section>
</footer>

<!-- Bootsrap-->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<!-- Scripts de page -->
<?php if (isset($extraJs)): ?>
    <?php foreach ($extraJs as $js): ?>
        <script src="<?= htmlspecialchars($js) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>