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


<main class="page-employee-menu">
    <section class="section-employee-menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="col">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
    
                <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/modifier" method="POST">
                    <div class="col-12 title">
                        <!-- Champs Titre -->
                        <div class="field">
                            
                                <label for="title">Titre</label>
                            
                                <input type="text" id="title" name="title" 
                                value="<?= htmlspecialchars($menu['title'] ?? '') ?>" required
                                >
                                <div class="invalid-feedback">
                                    <small>Veuillez saisir un titre de menu</small>
                                </div>
                            
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Champs Description menu -->
                        <div class="field">
                                <label for="description">Description menu</label>
                
                                <textarea id="description" name="description"><?= htmlspecialchars($menu['description'] ?? '') ?>
                                </textarea>
                                <div class="invalid-feedback">
                                    <small>Veuillez saisir une description</small>
                                </div>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="infos-row">
                            <!-- Champs Thème -->
                            <div class="field">
                                <div class="col-12 label">
                                    <label for="theme_id">Thème</label>
                                </div>
                                <div class="col-12 input">
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

                                    <div class="invalid-feedback">
                                        <small>Veuillez sélectionner un thème</small>
                                    </div>
                                </div>
                            </div>
                                        
                            <!-- Champs Régime -->
                            <div class="field">
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
                                <div class="invalid-feedback">
                                        <small>Veuillez sélectionner un régime</small>
                                    </div>
                            </div>
                        </div>
                    </div>
                            
                    <div class="col-12">
                        <div class="dish-row">
                            <!-- Champs Entree -->
                            <div class=" field">         
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
                                <div class="invalid-feedback">
                                        <small>Veuillez sélectionner une entrée</small>
                                    </div>            
                            </div>
                            
                            <!-- Champs Plat -->
                            <div class="field">
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
                                <div class="invalid-feedback">
                                    <small>Veuillez sélectionner un plat</small>
                                </div>
                            </div>
                                    
                            <!-- Champs Dessert -->
                            <div class="field">
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
                                <div class="invalid-feedback">
                                    <small>Veuillez sélectionner un dessert</small>
                                </div>
                            </div>   
                        </div>                         
                    </div>

                    <div class="col-12 ">
                        <div class="details-row">
                            <!-- Champs Prix unitaire -->
                            <div class="details">

                                    <label for="price_per_person">Prix unitaire</label>

                                    <input type="text" id="price_per_person" name="price_per_person" value="<?= htmlspecialchars($menu['price_per_person'] ?? '') ?>" required>
                                    <div class="invalid-feedback">
                                        <small>Veuillez saisir un prix valide</small>
                                    </div>
                            </div>  
                                        
                            <!-- Champs Personne minimum -->
                            <div class="details">
                    
                                    <label for="min_persons">Nombre de personne minimum</label>
                                
                                    <input  type="text" id="min_persons" name="min_persons" value="<?= htmlspecialchars($menu['min_persons'] ?? '') ?>" required>
                                    <div class="invalid-feedback">
                                        <small>Veuillez saisir un nombre de personne minimum</small>
                                    </div>
                            </div>
                                        
                                <!-- Champs Stock disponible -->
                            <div class="details">

                                    <label for="remaining_stock">Stock disponible</label>

                                    <input type="text" id="remaining_stock" name="remaining_stock" value="<?= htmlspecialchars($menu['remaining_stock'] ?? '') ?>" required>
                                    <div class="invalid-feedback">
                                        <small>Veuillez saisir une quantité de stock disponible</small>
                                    </div>
                            </div>  
                        </div>  
                    </div>
                    
                    <div class="col-12">
                        <!-- Champs Condition -->
                        <div class="field">
                        
                                <label for="conditions">Conditions</label>
                            
                                <textarea id="conditions" name="conditions"><?= htmlspecialchars($menu['conditions'] ?? '') ?>
                                </textarea>
                                <div class="invalid-feedback">
                                    <small>Veuillez saisir les conditions de vente du menu</small>
                                </div>

                        </div>
                    </div>
                            
                        
                <div class="boutons-wrapper">            
                        <!-- Boutons -->
                        <div class="col-6">
                            <button type="submit" id="btn-submit-menu" class="btn btn-success">Valider</button>
                        </div>
                    </form>
                                        
                        <?php if ($menu['is_active'] === 1):?>
                            <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/desactiver" method="POST">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger">Désactiver</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form action="<?= $basePath ?>/menus/<?= $menu['menu_id'] ?>/activer" method="POST">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-secondary">Activer</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>    
                    
            </div>
        </div>
    </section>
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

    <section class="section-pictures">
        <div class="container">
            <div class="row photos">
                <h2>Photos du menu</h2>

                
                    <!-- Photos existantes -->
                    <?php if (!empty($pictures)): ?>
                        <?php foreach ($pictures as $picture): ?>
                            <div class="col-6 col-xl-3">
                                <fieldset>
                                    <img
                                        src="<?= htmlspecialchars($picture['url']) ?>"
                                        alt="<?= htmlspecialchars($picture['alt_text']) ?>"
                                    >
                                    <!-- Bouton supprimer la photo -->
                                    <form action="/employe/menus/photos/<?= $picture['picture_id'] ?>/supprimer" method="post">
                                        <input type="hidden" name="menu_id" value="<?= $menu['menu_id'] ?>">
                                        <button type="submit" onclick="return confirm('Supprimer cette photo ?')" class="btn btn-danger">
                                            <i class="bi bi-x-square"></i> Supprimer 
                                        </button>
                                    </form>
                                </fieldset>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>


                    <!-- Ajouter une photo --> 
                    <div class="col-6 col-xl-3">
                        <fieldset class="add-picture">
                                <button  type="button" id="add-photo-btn"><i class="bi bi-plus-square-dotted"></i></button>
                        </fieldset>   
                    </div>
                </div>

                <form
                    action="/employe/menus/<?= $menu['menu_id'] ?>/photos/ajouter"
                    method="post"
                    enctype="multipart/form-data"
                > 
                    <div class="row new-picture d-none" id="form-new-picture">
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
            </div>        
        </div>
    </section>
    <section>
        <div class="container">
            <a href="<?= $basePath ?>/menus">Retour à la liste des menus</a>
        </div>
    </section>
</main>



<?php
require_once __DIR__ . '/../layouts/footer.php';
?>