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
        <form action="/employe/contenus/1/modifier" method="POST">

            <!-- Champs Présentation de l'entreprise -->
            <label for="presentation">Présentation de l'entreprise</label>
            <input type="texte" id="presentation" name="presentation">
            
            <!-- Champs Modifier -->
            <a href="">Modifier</a>

            <!-- Champs Update -->
            <input type="submit" value="Valider">
        </form>
    </div>

    <div>
        <form action="/employe/contenus/2/modifier" method="POST">

            <!-- Champs Professionnalisme de l'equipe -->
            <label for="prof-team">Professionnalisme de l'équipe</label>
            <input type="texte" id="prof-team" name="prof-team">
            
            <!-- Champs Modifier -->
            <a href="">Modifier</a>

            <!-- Champs Update -->
            <input type="submit" value="Valider">
        </form>
    </div>

    <div>
        <form action="/employe/contenus/3/modifier" method="POST">

            <!-- Champs Horaires -->
            <label for="schedule">Horaires</label>
            <input type="texte" id="schedule" name="schedule">
            
            <!-- Champs Modifier -->
            <a href="">Modifier</a>

            <!-- Champs Update -->
            <input type="submit" value="Valider">
        </form>
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>