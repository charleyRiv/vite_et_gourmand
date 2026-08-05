
<?php
/**
 * @var string $h1
 * @var ?array $dish - null si création, rempli si modification
 * @var array $errors
 * @var array $allergens
 * @var array $dishTypes
 * @var array $pictures
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    
    <div>
        <form action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/modifier" method="POST">
            <!-- Filtre Catégorie -->
            <fieldset>
                <legend>Catégorie</legend>
                <select name="dish_type" id="dish_type" required>
                    <?php foreach ($dishTypes as $dishType): ?>
                        <option 
                            value="<?= htmlspecialchars($dishType) ?>"
                            <?= (($dish['dish_type'] ?? '') === $dishType) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars(translateDishType($dishType)) ?>
                        </option>   
                    <?php endforeach; ?>  
                </select>            
            </fieldset>

            <!-- Champs Titre plat -->
            <label for="title">Titre plat</label>
            <input type="text" id="title" name="title" 
            value="<?= htmlspecialchars($dish['title'] ?? '') ?>" required
            >

            <!-- Champs Description plat -->
            <label for="description">Description plat</label>
            <textarea id="description" name="description"><?= htmlspecialchars($dish['description'] ?? '') ?></textarea>

            
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
            <button type="submit">
                Valider
            </button>
        </form>

        <!-- Photos existantes -->
        <?php if (!empty($pictures)): ?>
            <section>
                <h2>Photos du plat</h2>
                <?php foreach ($pictures as $picture): ?>
                    <div>
                        <img
                            src="<?= htmlspecialchars($picture['url']) ?>"
                            alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                        >
                        <!-- Bouton supprimer la photo -->
                        <form action="<?= $basePath ?>/plats/photos/<?= $picture['picture_id'] ?>/supprimer" method="post">
                            <input type="hidden" name="dish_id" value="<?= $dish['dish_id'] ?>">
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
                action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/photos/ajouter"
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

        <a href="<?= $basePath ?>/plats">Retour à la liste des plats</a>

    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>