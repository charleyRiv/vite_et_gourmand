<?php
require_once __DIR__ . '/../../src/Models/ContentModel.php';
$contentModel = new ContentModel();
$schedule = $contentModel->getByFilter('footer', 'Horaires');

?>
<footer class="footer">
    <section>
        <a href="">Facebook</a>
        <a href="">Instagram</a>
        <a href="/contact">Contact</a>
    </section>
    <section>
        <h4>Horaires</h4>
        <p><?= $schedule[0]['content'] ?></p>
    </section>
    <section>
        <a href="/legal">Mention légales</a>
        <a href="/cgv">cgv</a>
    </section>
</footer>

<!-- Scripts de page -->
<?php if (isset($extraJs)): ?>
    <?php foreach ($extraJs as $js): ?>
        <script src="<?= htmlspecialchars($js) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>