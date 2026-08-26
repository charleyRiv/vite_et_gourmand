<?php
/**
 * @var string $heroTitle
 * @var string $heroImage
 * @var string $heroSubtitle - optionnel
 */
?>

<section class="hero" style="background-image: url('<?= htmlspecialchars($heroImage) ?>');">
    <div class="hero-overlay">
        <div class="container">
            <h1 class="hero-title"><?= htmlspecialchars($heroTitle) ?></h1>
        </div>
    </div>
</section>