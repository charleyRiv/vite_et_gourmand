<?php
/**
 * @var string $h1
 * @var array $errors
 * @var array $themes
 * @var array $diets
 * @var ?array $menu - null si création, rempli si modification
 * @var array $pictures
 * @var string $basePath
 * @var array $starters
 * @var array $mains
 * @var array $desserts
 * @var array $menuDishes
 * @var array $menuPictureUrls
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <div>
        <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/modifier" method="POST">
            <!-- Champs Titre -->
            <label for="title">Thème</label>
            <input type="text" id="title" name="title" 
            value="<?= htmlspecialchars($menu['title'] ?? '') ?>" required
            >
        
            <br>

            <!-- Champs Description menu -->
            <label for="description">Description menu</label>
            <textarea id="description" name="description">
                <?= htmlspecialchars($menu['description'] ?? '') ?>
            </textarea>

            <br>

            <!-- Champs Thème -->
            <label for="theme_id">Thème</label>
            <select name="theme_id" id="theme_id" required>
                <option value="">-- Sélectionner un thème --</option>
                <?php foreach ($themes as $theme): ?>
                    <option 
                        value="<?= htmlspecialchars($theme['theme_id']) ?>"
                        <?= (($menu['theme_id'] ?? '') == $theme['theme_id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($theme['label']) ?>
                    </option>   
                <?php endforeach; ?>
            </select>

            <!-- Champs Régime -->
            <label for="diet_id">Régime</label>
            <select name="diet_id" id="diet_id" required>
                <option value="">-- Sélectionner un régime --</option>
                <?php foreach ($diets as $diet): ?>
                    <option 
                        value="<?= htmlspecialchars($diet['diet_id']) ?>"
                        <?= (($menu['diet_id'] ?? '') == $diet['diet_id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($diet['label']) ?>
                    </option>   
                <?php endforeach; ?>
            </select>

            <br>

            <!-- Champs Entree -->
            <label for="starter">Entrée</label>
            <select name="dish_ids[]" id="starter" required>
                <option value="">-- Sélectionner une entrée --</option>
                <?php foreach ($starters as $starter): ?>
                    <option 
                        value="<?= htmlspecialchars($starter['dish_id']) ?>"
                        <?= in_array(
                            $starter['dish_id'],
                            array_column($menuDishes, 'dish_id')
                        ) ? 'selected' : '' 
                        ?>
                    >
                        <?= htmlspecialchars($starter['title']) ?>
                    </option>   
                <?php endforeach; ?>
            </select>

            <!-- Champs Plat -->
            <label for="main">Plat</label>
            <select name="dish_ids[]" id="main" required>
                <option value="">-- Sélectionner un plat --</option>
                <?php foreach ($mains as $main): ?>
                    <option 
                        value="<?= htmlspecialchars($main['dish_id']) ?>"
                        <?= in_array(
                            $main['dish_id'],
                            array_column($menuDishes, 'dish_id')
                        ) ? 'selected' : '' 
                        ?>
                    >
                        <?= htmlspecialchars($main['title']) ?>
                    </option>   
                <?php endforeach; ?>
            </select>

            <!-- Champs Dessert -->
            <label for="dessert">Dessert</label>
            <select name="dish_ids[]" id="dessert" required>
                <option value="">-- Sélectionner un dessert --</option>
                <?php foreach ($desserts as $dessert): ?>
                    <option 
                        value="<?= htmlspecialchars($dessert['dish_id']) ?>"
                        <?= in_array(
                            $dessert['dish_id'],
                            array_column($menuDishes, 'dish_id')
                        ) ? 'selected' : '' 
                        ?>
                    >
                        <?= htmlspecialchars($dessert['title']) ?>
                    </option>   
                <?php endforeach; ?>
            </select>
            
            <br>

            <!-- Champs Prix unitaire -->
            <label for="price_per_person">Prix unitaire</label>
            <input type="text" id="price_per_person" name="price_per_person" value="<?= htmlspecialchars($menu['price_per_person'] ?? '') ?>" required>
            
            <!-- Champs Personne minimum -->
            <label for="min_persons">Nombre de personne minimum</label>
            <input type="text" id="min_persons" name="min_persons" value="<?= htmlspecialchars($menu['min_persons'] ?? '') ?>" required>

            <!-- Champs Stock disponible -->
            <label for="remaining_stock">Stock disponible</label>
            <input type="text" id="remaining_stock" name="remaining_stock" value="<?= htmlspecialchars($menu['remaining_stock'] ?? '') ?>" required>

            <br>

            <!-- Champs Condition -->
            <label for="conditions">Conditions</label>
            <textarea id="conditions" name="conditions">
                <?= htmlspecialchars($menu['conditions'] ?? '') ?>
            </textarea>

            <br>

            <!-- Boutons -->
            <button type="submit">Valider</button>
        </form>
        
        <?php if ($menu['is_active'] === 1):?>
            <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/desactiver" method="POST">
                <button type="submit">Désactiver</button>
            </form>
        <?php else: ?>
            <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/activer" method="POST">
                <button type="submit">Activer</button>
            </form>
        <?php endif; ?>


    </div>

    <?php foreach ($menuDishes as $dish): ?>

        <?php
        // Filtrer les photos du plat non encore ajoutées au menu
        $availablePictures = array_filter(
            $dish['pictures'],
            fn($pic) => !in_array($pic['url'], $menuPictureUrls)
        );
        ?>

        <?php if (!empty($availablePictures)): ?>
            <div>
                <p><?= htmlspecialchars($dish['title']) ?></p>

                <?php foreach ($availablePictures as $picture): ?>
                    <img
                        src="<?= htmlspecialchars($picture['url']) ?>"
                        alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                        style="max-width: 150px;"
                    >
                    <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/photos/copier-depuis-plat" method="post">
                        <input type="hidden" name="url" value="<?= htmlspecialchars($picture['url']) ?>">
                        <input type="hidden" name="alt_text" value="<?= htmlspecialchars($picture['alt_text']) ?>">
                        <input type="hidden" name="title" value="<?= htmlspecialchars($picture['title'] ?? '') ?>">
                        <button type="submit">Ajouter cette photo au menu</button>
                    </form>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    <?php endforeach; ?>

    <!-- Photos existantes -->
    <?php if (!empty($pictures)): ?>
        <section>
            <h2>Photos du menu</h2>
            <?php foreach ($pictures as $picture): ?>
                <div>
                    <img
                        src="<?= htmlspecialchars($picture['url']) ?>"
                        alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                    >
                    <!-- Bouton supprimer la photo -->
                    <form action="/employe/menus/photos/<?= $picture['picture_id'] ?>/supprimer" method="post">
                        <input type="hidden" name="menu_id" value="<?= $menu['menu_id'] ?>">
                        <button type="submit" onclick="return confirm('Supprimer cette photo ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    
    <!-- Ajouter une photo -->
    <section>
        <form
            action="/employe/menus/<?= $menu['menu_id'] ?>/photos/ajouter"
            method="post"
            enctype="multipart/form-data"
        >
            <button type="button" id="add-photo-btn">+</button>
            
            <label for="photo">Fichier image (jpg, png, webp - max 2Mo)</label>
            <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" required>
            <label for="title">Titre de la photo</label>
            <input type="text" id="title" name="title">
            <label for="alt_text">Texte alternatif * (obligatoire RGAA)</label>
            <input type="text" id="alt_text" name="alt_text" required>
            <button type="submit">Ajouter la photo</button>
        </form>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'upload'): ?>
            <p>Erreur lors de l'upload. Vérifiez le format et la taille du fichier.</p>
        <?php endif; ?>
    </section>
</main>
<br>
<a href="<?= $basePath ?>/menus">Retour à la liste des menus</a>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>