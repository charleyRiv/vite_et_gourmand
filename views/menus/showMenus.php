<?php
/**
 * @var array $menu
 * @var array $dishes
 * @var int $h1
 * @var array $picture
 */
require_once __DIR__ . '/../layouts/header.php';
?>
<br>
<main>
    <h1><?= htmlspecialchars($h1)?></h1>
    <section>
        <p><?= htmlspecialchars($menu['description']) ?></p>
        <p>Thème : <?= htmlspecialchars($menu['theme']) ?></p>
        <p>Régime : <?= htmlspecialchars($menu['diet']) ?></p>
        <div>
            <?php foreach ($dishes as $dish): ?>
                <article>
                    <!-- photos -->
                    <?php if (!empty($dish['picture'])): ?>
                        <img 
                            src="<?= $dish['picture']['url'] ?>"
                            alt="<?= $dish['picture']['alt_text'] ?>"
                        >
                    <?php else : ?>
                        <p>Image indisponible</p>
                    <?php endif; ?>

                    <!-- infos plat -->
                    <h3><?= htmlspecialchars($dish['dish_type']) ?></h3>
                    <p><?= htmlspecialchars($dish['title']) ?></p>
                    <p><?= htmlspecialchars($dish['description']) ?></p>

                    <!-- ajout allergenes -->
                    <?php if (!empty($dish['allergens'])): ?>
                        <?php foreach ($dish['allergens'] as $allergen): ?>
                            <li><?= htmlspecialchars($allergen['label']) ?></li>
                        <?php endforeach ;?>
                    <?php endif ;?>

                </article>
            <?php endforeach ;?>

        </div>
        <p><?= htmlspecialchars($menu['price_per_person']) ?>€/ personne</p>
        <p>Minimum <?= htmlspecialchars($menu['min_persons']) ?> personnes</p>
        <p>Stock : <?php if ($menu['remaining_stock'] === 0): ?>
                        <span>Bientôt disponible</span>
                    <?php else: ?>
                        <?= htmlspecialchars($menu['remaining_stock']) ?> disponible(s)
                    <?php endif; ?></p>
        <p>Conditions de réservation: <?= htmlspecialchars($menu['conditions']) ?></p>
        <a href="/commande/etape-1?menu_id=<?= $menu['menu_id'] ?>">Commander</a>
        <a href="/menus">Revenir à la liste des menus</a>
    </section>
</main>

<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>