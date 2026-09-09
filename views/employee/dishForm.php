
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

<main class="page-employee-dish-update">
    
    <section class="section-employee-dish-form">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <form action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/modifier" method="POST">
                    <div class="col-12 title">
                        <!-- Champs Titre plat -->
                        <div class="field">
                            <label for="title">Titre plat</label>
                            <input type="text" id="title" name="title" 
                            value="<?= htmlspecialchars($dish['title'] ?? '') ?>" required
                            >
                            <div class="invalid-feedback">Veuillez saisir un titre</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Filtre Catégorie -->
                        <div class="field">
                            <label for="dish_type">Catégorie</label>
                            <select name="dish_type" id="dish_type" required>
                                <option value="">-- Sélectionner une catégorie</option>
                                <?php foreach ($dishTypes as $dishType): ?>
                                    <option 
                                        value="<?= htmlspecialchars($dishType) ?>"
                                        <?= (($dish['dish_type'] ?? '') === $dishType) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars(translateDishType($dishType)) ?>
                                    </option>   
                                <?php endforeach; ?>  
                            </select>  
                            <div class="invalid-feedback">Veuillez sélectionner une catégorie</div>          
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Champs Description plat -->
                        <div class="field">
                            <label for="description">Description plat</label>
                            <textarea id="description" name="description"><?= htmlspecialchars($dish['description'] ?? '') ?></textarea>
                            <div class="invalid-feedback">Veuillez saisir une description</div>
                        </div>
                    </div>
                        
                    <div class="col-12">
                        <!-- Allergènes -->
                        <div class="field-allergen">
                            <div class="col-12 label-title">Allergènes</div>

                            <fieldset>
                                <?php foreach ($allergens as $allergen): ?>
                                    <div class="allergen-item">
                                        <input
                                            type="checkbox"
                                            id="allergen-ids"
                                            name="allergen_ids[]"
                                            value="<?= htmlspecialchars($allergen['allergen_id']) ?>"
                                            <?php if (isset($dishAllergens) && in_array($allergen['allergen_id'], array_column($dishAllergens, 'allergen_id'))): ?>
                                                checked
                                            <?php endif; ?>
                                        >
                                        <label>
                                            <?= htmlspecialchars($allergen['label']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>
                                        
                        </div>
                    </div>
                                    
                    <!-- Boutons -->
                    <div class="col-12 bouton-valider-dish">
                        <button type="submit" id="btn-submit-dish" class="btn btn-success">
                            Valider
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>                        
    </section>

    <section class="section-pictures">
        <div class="container">
            <div class="row photos">
                <h2>Photos du plat</h2>

                <!-- Photos existantes -->
                <?php if (!empty($pictures)): ?>
                    <?php foreach ($pictures as $picture): ?>
                        <div class="col-12">
                            <fieldset>
                                <img
                                    src="<?= htmlspecialchars($picture['url']) ?>"
                                    alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                                >
                                <!-- Bouton supprimer la photo -->
                                <form action="<?= $basePath ?>/plats/photos/<?= $picture['picture_id'] ?>/supprimer" method="post">
                                    <input type="hidden" name="dish_id" value="<?= $dish['dish_id'] ?>">
                                    <button type="submit" onclick="return confirm('Supprimer cette photo ?')" class="btn btn-danger">
                                        <i class="bi bi-x-square"></i> Supprimer
                                    </button>
                                </form>
                            </fieldset>
                        </div>
                    <?php endforeach; ?>                      
                <?php else : ?>

                    <!-- Ajouter une photo -->
                    <div class="col-12">
                        <fieldset class="add-picture">
                                <button  type="button" id="add-photo-btn"><i class="bi bi-plus-square-dotted"></i></button>
                        </fieldset>   
                    </div>  
                        
                    <form
                        action="<?= $basePath ?>/plats/<?= $dish['dish_id'] ?>/photos/ajouter"
                        method="post"
                        enctype="multipart/form-data"
                        id="form-new-picture" class="d-none"
                        
                    >

                        <div class="row new-picture" >
                            <div class="col-12">
                                <label for="photo">Fichier image (jpg, png, webp - max 2Mo)</label>
                                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp" required>
                                <div class="invalid-feedback">
                                    <small>Veuillez uploader une photo valide</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="title">Titre de la photo</label>
                                <input type="text" id="title-photo" name="title">
                                <div class="invalid-feedback">
                                    <small>Veuillez saisir le titre de la photo</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="alt_text">Texte alternatif * (obligatoire RGAA)</label>
                                <input type="text" id="alt_text" name="alt_text" required>
                                <div class="invalid-feedback">
                                    <small>Veuillez saisir le text alternatif de la photo</small>
                                </div>
                            </div>
                            <div class="col-12 bouton">
                                <button type="submit" id="btn-submit-photo" class="btn btn-primary">Ajouter la photo</button>
                            </div>  
                        </div>
                    </form>

                    <?php if (isset($_GET['error']) && $_GET['error'] === 'upload'): ?>
                        <p>Erreur lors de l'upload. Vérifiez le format et la taille du fichier.</p>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <a href="<?= $basePath ?>/plats">Retour à la liste des plats</a>
        </div>
    </section>


</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>