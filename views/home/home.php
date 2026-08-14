<?php
/**
 * @var string $h1
 * @var array $reviews
 */

require_once __DIR__ . '/../layouts/header.php';
?>


<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    <section>
        <a href = '/menus'>Voir les menus</a>
        <a href = '/commande/etape-1'>Commander</a>
    </section>
    <section>
        <h5>Les avis de nos clients</h5>
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