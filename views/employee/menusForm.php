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
        <img src="/../assets/images/uploads/dish_starter_foieGras_001.png">
        <img src="/../assets/images/uploads/Dish_FIletBoeufCroute_001.png">
        <img src="/../assets/images/uploads/Dish_bucheVanille_001.png">   
    </div>
    <div>
        <form action="/employe/menus/1/modifier" method="POST">
            <!-- Champs Description menu -->
            <label for="menu-describe">Description menu</label>
            <input type="texte" id="menu-describe" name="menu-describe">

            <!-- Filtre Thème -->
            <label for="theme">Thème</label>
            <input type="theme" id="theme" name="theme">

            <!-- Filtre Régime -->
            <label for="diet">Régime</label>
            <input type="texte" id="diet" name="diet">
            
            <!-- Champs Entree -->
            <label for="starter">Entrée</label>
            <input type="texte" id="starter" name="starter">

            <!-- Champs Plat -->
            <label for="main-dish">Plat</label>
            <input type="texte" id="main-dish" name="main-dish">

            <!-- Champs Dessert -->
            <label for="dessert">Dessert</label>
            <input type="texte" id="dessert" name="dessert">
            
            <!-- Champs Prix unitaire -->
            <label for="price">Prix unitaire</label>
            <input type="texte" id="price" name="price">
            
            <!-- Champs Personne minimum -->
            <label for="min-people">Nombre de personne minimum</label>
            <input type="texte" id="min-people" name="min-people">

            <!-- Champs Stock disponible -->
            <label for="stock">Stock disponible</label>
            <input type="texte" id="stock" name="stock">

            <!-- Champs Condition -->
            <label for="condition">Conditions</label>
            <input type="texte" id="condition" name="condition">

            <!-- Boutons -->
            <input type="submit" value="Valider">
        </form>

        <form action="/employe/menus/1/desactiver" method="POST">
            <input type="submit" value="Désactiver">
        </form>
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>