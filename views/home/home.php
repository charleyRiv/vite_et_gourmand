<?php
/**
 * @var string $h1
 * @var array $reviews
 * @var array $contents
 */

require_once __DIR__ . '/../layouts/header.php';
?>


<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    <section>
        <p><?= htmlspecialchars($contents[0]['content'] ?? '') ?></p>
        <a href = '/menus'>Voir les menus</a>
        <a href = '/commande/etape-1'>Commander</a>
    </section>
    <br>
    <section>
        <img src="/assets/images/uploads/equipe_photo_001.webp" 
            alt="Julie et José, fondateurs de Vite & Gourmand, souriants dans leur cuisine professionnelle, préparant et dressant des plats avec des ingrédients frais disposés sur le plan de travail."
            width="300"
            >
        <p><?= htmlspecialchars($contents[1]['content'] ?? '')?></p>
    </section>
    <section>
        <h4>Les avis de nos clients</h4>
        <?php foreach ($reviews as $review) : ?>
            <article>
                <p><?= htmlspecialchars($review['first_name'])?> <?= htmlspecialchars($review['last_name'])?>
                    <span style="color: #f7bc4d;">
                        <?= str_repeat('★', (int) $review['rating']) ?>
                    </span>
                    <?= htmlspecialchars($review['rating'])?>/5
                </p>
                <p><?= htmlspecialchars($review['comment'])?></p>
                <p>Il y a <?= $review['since'] ?>
                <a href ="/menus/<?= $review['menu_id']?>">Voir le menu</a>
                </p>
            </article> 
        <?php endforeach; ?>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>