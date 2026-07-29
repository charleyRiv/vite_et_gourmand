<?php
/**
 * @var string $h1
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

                    <label>
                        <input type="checkbox" name="themes[]" value="1">
                        Noël
                    </label>
                    <label>
                        <input type="checkbox" name="themes[]" value="2">
                        Pâques
                    </label>
                    <label>
                        <input type="checkbox" name="themes[]" value="3">
                        Classique
                    </label>
                    <label>
                        <input type="checkbox" name="themes[]" value="4">
                        Événement
                    </label>
                </fieldset>

                <!-- Section Régime -->
                <fieldset>
                    <legend>Régime alimentaire</legend>

                    <label>
                        <input type="checkbox" name="diets[]" value="1">
                        Classique
                    </label>
                    <label>
                        <input type="checkbox" name="diets[]" value="2">
                        Végétarien
                    </label>
                    <label>
                        <input type="checkbox" name="diets[]" value="3">
                        Vegan
                    </label>
                    <label>
                        <input type="checkbox" name="diets[]" value="4">
                        Sans gluten
                    </label>
                    <label>
                        <input type="checkbox" name="diets[]" value="5">
                        Halal
                    </label>
                    <label>
                        <input type="checkbox" name="diets[]" value="6">
                        Casher
                    </label>
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
        <a href="/menus/{id}">Voir le détail</a>
        <a href="/menus/{id}">Voir le détail</a>
        <a href="/menus/{id}">Voir le détail</a>
        <a href="/menus/{id}">Voir le détail</a>
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