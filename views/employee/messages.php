<?php
/**
 * @var string $h1
 * @var array $messages
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <section>
        <form action="/employe/contact" method="get">

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
            <br>
            <button type="submit">Filtrer</button>
            <a href="/employe/contact">Réinitialiser</a>

        </form>
    </section>

    <?php foreach ($messages as $message) :?>
    <article>
        <p>Expediteur : <?= htmlspecialchars($message['sender_email']) ?></p>
        <p>Date : <?= htmlspecialchars($message['sent_at'])?></p>
        <p>Sujet: <?= htmlspecialchars($message['title']) ?></p>
        <p>Message : <br> 
        <?= htmlspecialchars($message['description'])?>
        </p>
    </article>
    <?php endforeach; ?>
    
    <a href="/employe">Revenir au dashboard</a>
</main>
<br>

<?php
//require_once __DIR__ . '/../layouts/footer.php';
?>