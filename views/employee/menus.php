<?php
/**
 * @var string $h1
 * @var array $diets
 * @var array $themes
 * @var array $menus
 * @var array $statuses
 * @var string $basePath
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

            <!-- Filtre Régime -->
            <fieldset>
            <label for="diet">Régime</label>
                <select name="diet" id="diet">
                    <option value="default">--Filtrer les régimes</option>
                    <?php foreach ($diets as $diet): ?>
                    <option value="<?= $diet['diet_id'] ?>">
                        <?= $diet['label'] ?>
                    </option>
                    <?php endforeach; ?>    
                </select>
            </fieldset>

            <!-- Filtre Thème -->
            <fieldset>
            <label for="theme">Thème</label>
                <select name="theme" id="theme">
                    <option value="default">-- Filtrer les thèmes --</option>
                    <?php foreach ($themes as $theme): ?>
                    <option value="<?= $theme['theme_id']?>">
                        <?= $theme['label'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </fieldset>

            <!-- Filtre Statut -->
            <fieldset>
            <label for="status">Statut</label>
                <select id="filter-status">
                    <option value="default">--Filtrer par statut--</option>
                    <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status ?>">
                        <?= $status === 1 ? 'Actif' : 'Inactif' ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
            
            <!-- Boutons -->
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>

    <section>
    <?php foreach ($menus as $menu): ?>
        <h3><?= htmlspecialchars($menu['title']) ?></h3>

        <p>Thème : <?= htmlspecialchars($menu['theme']) ?></p>
        <p>Régime : <?= htmlspecialchars($menu['diet']) ?></p>
        <p>Prix : <?= htmlspecialchars($menu['price_per_person']) ?>€ /personne</p>
        <p>Stock : <?= htmlspecialchars($menu['remaining_stock']) ?></p>
        <p>Statut : <?= $menu['is_active'] === 1 ? 'actif' : 'inactif' ?></p>
        
        <a href="<?=$basePath ?>/menus/<?= $menu['menu_id']?>/modifier">Modifier</a>
        <form action="<?=$basePath ?>/menus/<?= $menu['menu_id']?>/supprimer" method="POST">
            <button type="submit"> Supprimer</button>
        </form> 
    <?php endforeach; ?>
    </section>

    <br>
    <div>
        <form action="/employe/menus/creer" method="POST">
            <button type="submit">
                Créer un nouveau menu
            </button>
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