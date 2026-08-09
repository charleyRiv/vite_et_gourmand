<?php
/**
 * @var string $h1
 * @var array $menu
 * @var array $errors
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <form action="/commande/etape-3" method="POST">
        <p>Le menu sélectionné est prévu pour <?= $menu['min_persons'] ?> personnes minimum</p>
        <!-- Champs Nombre de personnes -->
        <label for="nb_persons">Nombre de personnes</label>
        <input 
            type="number" 
            id="nb_persons" 
            name="nb_persons" 
            min="<?= $menu['min_persons'] ?>"
            value="<?= $menu['min_persons'] ?>"
            required
        >
        <br>

        <p>Prévoir l'affichage du prix dynamique</p>
        <section>
            <table> 
                <tr>
                    <td>Prix du menu <br>
                    <?= $menu['price_per_person']?> * nb personnes dynamique
                    </td>
                    <td>prix dynamique €</td>
                </tr> 
                <tr>
                    <td>Réduction 10% <br>
                        <span> -10% si vous comandez pour <br>
                                5 personnes de plus que le minimum requis
                        </span>
                    </td>
                    <td>- reduction dynamique €</td>
                </tr>
                <tr>
                    <td>Total <br>
                    hors frais de livraisons
                    </td>
                    <td>prix dynamique €</td>
                </tr>          
            </table>
        </section>

        <!-- Bouton Précédent -->
        <a href="/commande/etape-2">Précédent</a>
        
        <!-- Bouton S'inscrire -->
        <button type="submit">Suivant</button>

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>