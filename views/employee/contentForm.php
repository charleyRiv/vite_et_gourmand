<?php
/**
 * @var string $h1
 * @var array $contents
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-employee-content">
    <section class="section-employee-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>

                <?php foreach ($contents as $content) : ?>
                <div class="content-form">
                    <form action="/employe/contenus/<?= $content['content_id'] ?>/modifier" method="POST">
                        <?= csrfField() ?>
                
                        <!-- Contenu -->
                        <div class="col-12">
                            <h4><?= htmlspecialchars($content['page'])?> / <?= htmlspecialchars($content['section'])?></h4>
                            <textarea 
                                id="content-<?= $content['content_id'] ?>" 
                                name="content"
                                disabled><?= htmlspecialchars($content['content']) ?></textarea>
                        </div>
                
                        <div class="col-12 boutons">
                    
                            <!-- Modifier -->
                            <button type="button" id="btn-modify-<?= $content['content_id'] ?>" class="btn btn-primary" data-id="<?= $content['content_id'] ?>">Modifier</button>
                            
                            <!-- Valider -->
                            <button type="submit" id="btn-validated-<?= $content['content_id'] ?>" class="btn btn-success d-none" data-id="<?= $content['content_id'] ?>">Valider</button>
                    
                    </form>
                            <!-- Supprimer -->
                            <form action="/employe/contenus/<?= $content['content_id'] ?>/supprimer" method="post">
                                <?= csrfField() ?>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <hr>

    <section class="section-new-content">
        <div class="container">
            <div class="row">
                    <div class="col-12 new">
                        <!-- Créer un nouveau contenu -->
                        <button type="button" id="btn-new" class="btn btn-primary">Créer un nouveau contenu</button>
                    </div>
                    
                        <form action="/employe/contenus/creer" method="post">
                            <?= csrfField() ?>
                            <fieldset id="new-form" class="d-none">
                            <div class="col field">
                                <label for="page">Page</label>
                                <input type="text" name="page" id="page" required>
                                <div class="invalid-feedback">Veuillez saisir une page</div>
                            </div>
                            
                            <div class="col field">
                                <label for="section">Section</label>
                                <input type="text" name="section" id="section" required>
                                <div class="invalid-feedback">Veuillez saisir une section</div>
                            </div>
                            
                            <div class="col field">
                                <label for="content">Contenu</label>
                                <textarea 
                                    name="content" 
                                    id="content" 
                                    required>
                                </textarea>
                                <div class="invalid-feedback">Veuillez saisir un contenu</div>
                            </div>
                            
                            <div class="col-12 bouton-new">
                                <button type="submit" id="btn-submit-new" class="btn btn-success">Créer</button>
                            </div>
                            </fieldset>
                        </form>
                    
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <a href="<?= $basePath ?>/">Retour au dashboard</a>
        </div>
    </section>
</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>