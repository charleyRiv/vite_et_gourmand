<?php
/**
 * @var string $h1
 * @var array $dishesType
 * @var array $diets
 * @var array $allergens
 * @var array $dishes
 * @var string $basePath
 * @var array $dishAllergens
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <div>
        <form action="/employe/menus" method="POST">
            <!-- Champs barre de recherche -->
            <label for="search">Recherche</label>
            <input type="texte" id="search" name="search">

            <!-- Filtre Catégorie -->
                <select name="dish_type" id="dish_type" required>
                    <option value="default">Catégorie</option>
                    <?php foreach ($dishesType as $dishType): ?>
                        <option 
                            value="<?= htmlspecialchars($dishType) ?>"
                            <?= (($dish['dish_type'] ?? '') === $dishType) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars(translateDishType($dishType)) ?>
                        </option>   
                    <?php endforeach; ?>  
                </select>            

            <!-- Filtre Régime -->
                <select name="diet" id="diet">
                    <option value="default">Régime</option>
                    <?php foreach ($diets as $diet): ?>
                    <option value="<?= $diet['diet_id'] ?>">
                        <?= $diet['label'] ?>
                    </option>
                    <?php endforeach; ?>    
                </select>

            <!-- Allergènes -->
            <fieldset>
                <legend>Allergènes</legend>

                <?php foreach ($allergens as $allergen): ?>
                    <label>
                        <input
                            type="checkbox"
                            name="allergen_ids[]"
                            value="<?= htmlspecialchars($allergen['allergen_id']) ?>"
                            <?php if (isset($dishAllergens) && in_array($allergen['allergen_id'], array_column($dishAllergens, 'allergen_id'))): ?>
                                checked
                            <?php endif; ?>
                        >
                        <?= htmlspecialchars($allergen['label']) ?>
                    </label>
                <?php endforeach; ?>
                            
            </fieldset>

            <!-- Boutons -->
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>
    <section>
        <?php foreach ($dishes as $dish): ?>
        <h3><?= htmlspecialchars($dish['title']) ?></h3>

        <p><?= htmlspecialchars($dish['dish_type']) ?></p>
        <p>Nombre de menus associés : <?= htmlspecialchars($dish['menu_count']) ?></p>
        <p>Allergènes : 
            <?php if (!empty($dish['dish_allergens'])): ?>
                <?= htmlspecialchars(implode(', ', array_column($dish['dish_allergens'], 'label' ))) ?>
            <?php else: ?>
                Aucun
            <?php endif; ?>
        </p>
        <p>
            <?php if ($dish['dish_picture'] !== null): ?>
                    <img
                        src="<?= htmlspecialchars($dish['dish_picture']['url']) ?>"
                        alt="<?= htmlspecialchars($dish['dish_picture']['alt_text']) ?>"
                        style="max-width: 80px";
                    >
            <?php else: ?>
                Pas de photos disponibles
            <?php endif; ?>
        </p>

        <a href="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/modifier">Modifier</a>
        <form action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/supprimer" method="POST">
            <button type="submit">
                Supprimer
            </button>
        </form> 
        <?php endforeach; ?>
    </section> 
    <br>
    <div>
        <form action="/employe/plats/creer" method="POST">
            <input type="submit" value="Créer un nouveau plat">
        </form> 
        <a href="">Precedent</a>
        <a href="">Suivant</a>
        <a href="">n°page</a>/nbr page totales
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>