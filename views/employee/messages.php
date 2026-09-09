<?php
/**
 * @var string $h1
 * @var array $messages
 * @var string $basePath
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-messages">
    <section class="section-filtres">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
    
                <form action="/employe/contact" method="get">
                    <div class="filtres">
                        <label for="date_from">Du</label>
                        <input 
                            type="date" 
                            id="date_from" 
                            name="date_from"
                            value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>"
                        >

                        <label for="date_to">Au</label>
                        <input 
                            type="date" 
                            id="date_to" 
                            name="date_to"
                            value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>"
                        >
                    
                        <div class="boutons">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="/employe/contact" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="section-messages">
        <div class="container">
            <div class="row">

                <?php foreach ($messages as $message) :?>
                <article class="message">
                    <div class="col-12">
                        <span>Expediteur : </span><?= htmlspecialchars($message['sender_email']) ?>
                    </div>

                    <div class="col-12">
                        <span>Date : </span><?= htmlspecialchars($message['sent_at'])?>
                    </div>

                    <div class="col-12">
                        <span>Sujet : </span><?= htmlspecialchars($message['title']) ?>
                    </div>

                    <div class="col-12">
                        <span>Message :</span>  
                    </div>

                    <div class="col-12">
                        <?= htmlspecialchars($message['description'])?>
                    </div>
                    
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <a href="<?= $basePath ?>">Revenir au dashboard</a>
        </div>
    </section>
    
</main>


<?php
require_once __DIR__ . '/../layouts/footer.php';
?>