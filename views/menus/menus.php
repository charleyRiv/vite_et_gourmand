<?php
/**
 * @var array $menus
 * @var string $h1
 * @var array $allergens
 * @var array $themes
 * @var array $diets
 * @var array $pictures
 */

require_once __DIR__ . '/../layouts/header.php';

?>
<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    <br>
    <section>
        <!-- Boutons -->
        <div>
            <button type="submit">Filtrer</button>
            <a href="/menus">Réinitialiser</a>
        </div>

        <div aria-hidden="true">
            <form action="/menus" method="get" id="filtres-form">

                <!-- Section Prix -->
                <fieldset>
                    <legend>Prix</legend>

                    <div>
                        <label for="prix_min">
                            Prix minimum : <span id="prix-min-label">0€</span>
                        </label>
                        <input 
                            type="range" 
                            id="prix_min" 
                            name="prix_min" 
                            min="0" 
                            max="200" 
                            step="5" 
                            value="0"
                        >
                    </div>
                </fieldset>

                <!-- Section Thème -->
                <fieldset>
                    <legend>Thème</legend>
                    <?php foreach ($themes as $theme): ?>
                    <label>
                        <input 
                            type="checkbox" 
                            name="themes[]" 
                            value="<?= $theme['theme_id']?>"
                        >
                        <?= $theme['label'] ?>
                    </label>
                    <?php endforeach; ?>
                </fieldset>

                <!-- Section Régime -->
                <fieldset>
                    <legend>Régime alimentaire</legend>
                    <?php foreach ($diets as $diet): ?>
                    <label>
                        <input 
                            type="checkbox" 
                            name="diets[]" 
                            value="<?= $diet['diet_id']?>"
                        >
                        <?= $diet['label'] ?>
                    </label>
                    <?php endforeach; ?>
                    
                </fieldset>

                <!-- Section Nombre de personnes -->
                <fieldset>
                    <legend>Nombre de personnes</legend>
                    <div>
                        <label for="prix_max">
                            Prix maximum : <span id="prix-max-label">200€</span>
                        </label>
                        <input 
                            type="range" 
                            id="prix_max" 
                            name="prix_max" 
                            min="0" 
                            max="200" 
                            step="5" 
                            value="200"
                        >
                    </div>
                </fieldset>

            </form>

        <br>
        </div>
    </section>
    <section>
    <?php if (empty($menus)): ?>
        <p>Aucun menu disponible pour le moment.</p>
    <?php else: ?>
        <?php foreach ($menus as $menu): ?>
            <article>
                <!-- Photo du plat principale - A utiliser comme fond de la zone -->
                <?php if (!empty($pictures)): ?>
                    <img
                        src="<?= htmlspecialchars($pictures['url']) ?>"
                        alt="<?= htmlspecialchars($pictures['alt_text']) ?>"
                        style="max-width: 100px";
                    >
                    <?php else: ?>
                        <p>Photo indisponible</p>
                <?php endif;?>
                <h3><?= htmlspecialchars($menu['title']) ?></h3>
                <p><?= htmlspecialchars($menu['description']) ?></p>
                <p><?= htmlspecialchars($menu['price_per_person']) ?> € / personne</p>
                <p>Minimum <?= htmlspecialchars($menu['min_persons']) ?> personnes</p>
                <a href="/menus/<?= htmlspecialchars($menu['menu_id']) ?>">Voir le détail</a>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
    </section>
    <br>
    <div>
        <a href="/commande/etape-1">Commander</a>
        <a href="">Precedent</a>
        <a href="">Suivant</a>
        <a href="">n°page</a>/nbr page totales
    </div>
</main>
<br>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>