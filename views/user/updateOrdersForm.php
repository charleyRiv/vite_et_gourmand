<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $menu
 * @var array $menus
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <form action="/mon-espace/commande/<?= $order['order_id'] ?>/modifier" method="Post">
        <h3>Informations de livraisons </h3>
        <fieldset>
            <legend>Date de livraison</legend>
                <label for="event_date">Date de livraison</label>
                <input 
                    type="date" 
                    name="event_date" 
                    id="event_date" 
                    value="<?= htmlspecialchars($order['event_date'] ?? '') ?>"
                >
                <br>
                <label for="delivery_time">Heure</label>
                <input 
                    type="time" 
                    name="delivery_time" 
                    id="delivery_time" 
                    value="<?= htmlspecialchars($order['delivery_time'] ?? '') ?>"
                >
        </fieldset>
        <fieldset>
            <legend>Adresse de livraison</legend>
                <label for="delivery_street_number">N° de la voie</label>
                <input 
                    type="text" 
                    name="delivery_street_number" 
                    id="delivery_street_number" 
                    value="<?= htmlspecialchars($order['delivery_street_number'] ?? '')?>"
                >
                <label for="delivery_street_type">Type de voie</label>
                <input 
                    type="text" 
                    name="delivery_street_type" 
                    id="delivery_street_type" 
                    value="<?= htmlspecialchars($order['delivery_street_type']?? '')?>"
                >
                <label for="delivery_street_name">Nom de la voie</label>
                <input 
                    type="text" 
                    name="delivery_street_name" 
                    id="delivery_street_name" 
                    value="<?= htmlspecialchars($order['delivery_street_name']?? '')?>"
                >
                <br>
                <label for="delivery_zip_code">Code Postal</label>
                <input 
                    type="text" 
                    name="delivery_zip_code" 
                    id="delivery_zip_code" 
                    value="<?= htmlspecialchars($order['delivery_zip_code']?? '')?>"
                >
                <label for="delivery_city">Ville</label>
                <input 
                    type="text" 
                    name="delivery_city" 
                    id="delivery_city" 
                    value="<?= htmlspecialchars($order['delivery_city']??'')?>"
                >
                <br>
                <label for="delivery_country">Pays</label>
                <input 
                    type="text" 
                    name="delivery_country" 
                    id="delivery_country" 
                    value="<?= htmlspecialchars($order['delivery_country']??'')?>"
                >        
        </fieldset>
        <fieldset>
            <legend>Menu</legend>
                <label for='menu_id'>Choix du menu</label>
                <select name="menu_id" id="menu_id">
                    <option value="">-- Sélectionner un menu --</option>
                    </option>
                    <?php foreach ($menus as $men) : ?>
                    <option
                        value="<?= htmlspecialchars($men['menu_id']) ?>"
                        <?= ($men['menu_id'] == $order['menu_id']) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($men['title']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <label for="nb_persons">Nombre de personnes <br>
                        ajouter minimum nbrPersonsDynamique personnes
                </label>
                <input 
                    type="text" 
                    name="nb_persons" 
                    id="nb_persons" 
                    min="miniprice Dynamique"
                    value="<?= htmlspecialchars($order['nb_persons'])?>"
                >    
        </fieldset>
        <fieldset>
            <legend>Détail du nouveau prix</legend>
            <table>
                <tbody>
                    <tr>
                        <td>Prix par personne</td>
                        <td>prix unitaire dynamique €</td>
                    </tr>

                    <tr>
                        <td>Nombre de personnes</td>
                        <td>x nbPersonnesDynamique</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>_________</td>
                    </tr>
                        
                    <tr>
                        <td>Prix du menu</td>
                        <td> prix menu dynamique €</td>
                    </tr>
                        
                    <tr>
                        <td>Réduction 10% <br>
                            (nbdyn pers. > minPersDyn min + 5)
                        </td>
                        <td>- discountDyn €</td>
                    </tr>

                    <tr>
                        calcul frais de livraisons dynamiques
                    </tr>
                    <tr>
                        <td> </td>
                        <td>_________</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Nouveau Prix TTC</td>
                        <td>total prix dynamqiue €</td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
        <a href="/mon-espace">Revenir à mon espace</a>
        <button type="submit">Valider les modifications</button>
    </form>
    
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>