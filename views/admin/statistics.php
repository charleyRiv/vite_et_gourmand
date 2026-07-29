<?php
/**
 * @var string $h1
 */

require_once __DIR__ . '/../layouts/header.php';
?>

<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    
    <section>
        <h2>KPI</h2>
    </section>

    <section>
        <h2>Commandes par menus</h2>

        <div>
            <form action="admin/statistiques">
                <!-- Filtre Date début-->
                <label for="start-date">Date début</label>
                <input type="date" id="start-date" name="start-date">

                <!-- Filtre Date fin-->
                <label for="end-date">Date fin</label>
                <input type="date" id="end-date" name="end-date">

                <!-- Boutons -->
                    <input type="button" value="Filtrer">
                    <input type="button" value="Reinitialiser">
            </form>
        </div>

        <div>
            Graphique
        </div>

        <div>
            Tableau
        </div>
    </section>

    <section>
        <h2>Chiffre d'affaire par menus</h2>

        <div>
            <form action="admin/statistiques">
                <!-- Filtre par menu -->
                <label for="menu">Menus</label>
                <select name="menu" id="menu">
                    <option value="0">Choisir un menu</option>
                    <option value="1">Noël</option>
                    <option value="2">Pâques</option>
                    <option value="3">Business</option>
                </select>

                <!-- Filtre Date début-->
                <label for="start-date">Date début</label>
                <input type="date" id="start-date" name="start-date">

                <!-- Filtre Date fin-->
                <label for="end-date">Date fin</label>
                <input type="date" id="end-date" name="end-date">

                <!-- Boutons -->
                    <input type="button" value="Filtrer">
                    <input type="button" value="Reinitialiser">
            </form>
        </div>

        <div>
            Tableau
        </div>

        <div>
            Graphique
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>