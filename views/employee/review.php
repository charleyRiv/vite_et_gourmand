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
        <form action="/employe/avis" method="POST">
            <!-- Filtre Note -->
            <fieldset>
            <label for="note">Note</label>
                <select name="note" id="note">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </fieldset>

            <!-- Filtre Date -->
            <label for="date">Date</label>
            <input type="date" id="date" name="date">
                        
            <!-- Filtre Allergène -->
            <fieldset>
            <label for="status">Statut</label>
                <select name="status" id="status">
                    <option value="waiting">En attente</option>
                    <option value="validate">Validé</option>
                    <option value="refuse">Refusé</option>
                </select>
            </fieldset>

            
            <!-- Boutons -->
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>

    <div>
        <h4>Avis n° 1</h4>
        <form action="/employe/avis/1/statut" method="POST">
            <!-- Filtre Statut -->
            <fieldset>
            <label for="status">Choisir le statut</label>
                <select name="status" id="status">
                    <option value="validate">Valider</option>
                    <option value="refuse">Refuser</option>
                </select>
            </fieldset>

            <!-- Champs Update -->
            <input type="submit" value="Valider">
        </form>
    </div>

</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>