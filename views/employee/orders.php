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
        <form action="/employe/commandes" method="POST">
            <fieldset>
            <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="canceled">annulée</option>
                    <option value="validate">acceptée</option>
                    <option value="in-preparation">en préparation</option>
                </select>
            </fieldset>
            <fieldset>
            <label for="clientName">Client</label>
                <select name="clientName" id="clientName">
                    <option value="clientID1">client 1</option>
                    <option value="clientID2">client 2</option>
                    <option value="clientID3">client 3</option>
                </select>
            </fieldset>
            <input type="button" value="Filtrer">
            <input type="button" value="Reinitialiser">
        </form>
    </div>
    <div>
        <h3>Commande n°12345</h3>
        <form action="/employe/commandes/12345/gerer" method="POST">
            
            <!-- Champs Satut -->
            <!--label for="status">Status</label-->
            <select name="status" id="status">
                <option value="canceled">annulée</option>
                <option value="validate">acceptée</option>
                <option value="in-preparation">en préparation</option>
            </select>

            <!-- Champs Mode de contact en cas d'annulation -->
            <label for="contact-mode">Mode de contact</label>
            <input type="text" id="contact-mode" name="contact-mode">

            <!-- Champs Motif d'annulation -->
            <label for="cancel-reason">Motif d'annulation</label>
            <input type="text" id="cancel-reason" name="cancel-reason">
        </form>
    </div>
    <div>
        <h3>Commande n°12346</h3>
        <form action="/employe/commandes/12346/gerer" method="POST">
            
            <!-- Champs Satut -->
            <!--label for="status">Status</label-->
            <select name="status" id="status">
                <option value="canceled">annulée</option>
                <option value="validate">acceptée</option>
                <option value="in-preparation">en préparation</option>
            </select>

        </form>
    </div>
        <div>
        <h3>Commande n°12347</h3>
        <form action="/employe/commandes/12347/gerer" method="POST">
            
            <!-- Champs Satut -->
            <!--label for="status">Status</label-->
            <select name="status" id="status">
                <option value="canceled">annulée</option>
                <option value="validate">acceptée</option>
                <option value="in-preparation">en préparation</option>
            </select>

        </form>
    </div>
        <br>
    <div>
        <a href="">Precedent</a>
        <a href="">Suivant</a>
        <a href="">n°page</a>/nbr page totales
    </div>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>