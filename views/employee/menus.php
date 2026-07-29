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
        <form action="/employe/menus" method="POST">
            <!-- Champs barre de recherche -->
            <label for="search">Recherche</label>
            <input type="texte" id="search" name="search">

            <!-- Filtre Régime -->
            <fieldset>
            <label for="diet">Régime</label>
                <select name="diet" id="diet">
                    <option value="veggie">vegetarien</option>
                    <option value="vegan">vegan</option>
                    <option value="in-hallal">hallal</option>
                </select>
            </fieldset>

            <!-- Filtre Thème -->
            <fieldset>
            <label for="theme">Thème</label>
                <select name="theme" id="theme">
                    <option value="christmas">Noël</option>
                    <option value="paques">Pâques</option>
                    <option value="business">Entreprise</option>
                </select>
            </fieldset>

            <!-- Filtre Statut -->
            <fieldset>
            <label for="status">Statut</label>
                <select name="status" id="status">
                    <option value="enable">actif</option>
                    <option value="disable">inactif</option>
                </select>
            </fieldset>

            <!-- Boutons -->
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>
    <div>
        <h3>Menu A</h3>

            <a href="/employe/menus/1/modifier">Modifier</a>
            <form action="/employe/menus/1/supprimer" method="POST">
                <input type="submit" value="Supprimer">
            </form> 
    </div> 

    <div>
    <h3>Menu B</h3>
        <a href="/employe/menus/2/modifier">Modifier</a>
        <form action="/employe/menus/2/supprimer" method="POST">
            <input type="submit" value="Supprimer">
        </form> 
    </div> 

    <div>
        <h3>Menu C</h3>
        <a href="/employe/menus/3/modifier">Modifier</a>
        <form action="/employe/menus/3/supprimer" method="POST">
            <input type="submit" value="Supprimer">
        </form> 
    </div> 

    <br>
    <div>
        <form action="/employe/menus/creer" method="POST">
            <input type="submit" value="Créer un nouveau menu">
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