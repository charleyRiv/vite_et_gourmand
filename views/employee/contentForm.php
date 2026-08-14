<?php
/**
 * @var string $h1
 * @var array $contents
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    
    <?php foreach ($contents as $content) : ?>
    <section>
        <form action="/employe/contenus/<?= $content['content_id'] ?>/modifier" method="POST">

            <!-- Champs Présentation de l'entreprise -->
            <h3><?= htmlspecialchars($content['page'])?> / <?= htmlspecialchars($content['section'])?></h3>
            <br>
            <textarea 
                id="content-<?= $content['content_id'] ?>" 
                name="content" 
                rows="10"
                cols="70"
                
            >
            <?= htmlspecialchars($content['content']) ?>
            </textarea>
            <br>

            <!-- Champs Modifier -->
            <button 
                type="button" 
                class="btn-modify" 
                data-id="<?= $content['content_id'] ?>"
            >
            Modifier
            </button>
            
            <!-- Champs Update -->
            <button 
                type="submit"
                class="btn-submit"
                style="display: box;"
            >
            Valider
        </button>
        </form>
        <form action="/employe/contenus/<?= $content['content_id'] ?>/supprimer" method="post">
            <button type="submit">Supprimer</button>
        </form>
    </section>
    <?php endforeach; ?>

    <!-- Créer un nouveau contenu -->
    <br>
    <button type="button" class="btn-create">Créer un nouveau contenu</button>
    <fieldset style="display: box;">
        <form action="/employe/contenus/creer" method="post">
            <label for="page">Page</label>
            <input type="text" name="page" id="page" required>
            <br>
            <label for="section">Section</label>
            <input type="text" name="section" id="section" required>
            <br>
            <label for="content">Contenu</label>
            <textarea 
                name="content" 
                id="content" 
                rows="10"
                cols="70"
                required>
            </textarea>
            <br>
            <button type="submit">Créer</button>
        </form>
    </fieldset>
    
</main>
<br>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>