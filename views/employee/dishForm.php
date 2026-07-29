<?php
/**
 * @var string $h1
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    
    <div>
        <form action="/employe/plats/1/modifier" method="POST">
            <!-- Filtre Catégorie -->
            <fieldset>
            <label for="categorie">Catégorie</label>
                <select name="categorie" id="categorie">
                    <option value="starter">Entrée</option>
                    <option value="main-dish">Plat</option>
                    <option value="dessert">Dessert</option>
                </select>
            </fieldset>

            <!-- Champs Description plat -->
            <label for="dish-describe">Description plat</label>
            <input type="texte" id="dish-describe" name="dish-describe">
            
            <img src="/../assets/images/uploads/dish_starter_foieGras_001.png"> 
            
            <!-- Filtre Allergène -->
            <fieldset>
            <label for="allergene">Allergène</label>
                <select name="allergene" id="allergene">
                    <option value="milk">Lait</option>
                    <option value="arachide">Arachide</option>
                    <option value="gluten">Gluten</option>
                </select>
            </fieldset>


            <!-- Filtre Régime -->
            <label for="diet">Régime alimentaire</label>
            <input type="texte" id="diet" name="diet">
            
            <!-- Boutons -->
            <input type="submit" value="Valider">
        </form>
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>