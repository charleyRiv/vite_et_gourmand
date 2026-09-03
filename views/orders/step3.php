<?php
/**
 * @var string $h1
 * @var array $menu
 * @var array $errors
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-order3">
    <section class="section-order3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
                <div class="col-12">
                    <p>Veuillez renseigner le nombre de personnes qui dégusteront ce menu</p>
                </div>

                <form action="/commande/etape-3" method="POST">
                    <div class="order3-form">
                        <div class="col-12 warning">
                            <p>Le menu sélectionné est prévu pour <?= $menu['min_persons'] ?> personnes minimum</p>
                        </div>

                        <!-- Champs Nombre de personnes -->
                        <div class="col-12 order3-label">
                            <label for="nb_persons">Nombre de personnes</label>
                        </div>

                        <div class="col-2">
                            <input 
                                type="number" 
                                id="nb_persons" 
                                name="nb_persons" 
                                min="<?= $menu['min_persons'] ?>"
                                value="<?= $menu['min_persons'] ?>"
                                class="order3-input"
                                required
                            >
                            <div class="invalid-feedback">min <?= $menu['min_persons'] ?> personnes.</div>
                    </div>
                        </div>

                    <fieldset class="order3-prices">
                        <legend>Prix</legend>

                        <table class="table table-borderless"> 
                            <tr>
                                <td>Prix du menu <br>
                                <small>
                                    <?= $menu['price_per_person']?> € x
                                    <span id="nb-display"><?= $menu['min_persons']?></span> personnes
                                </small>
                                </td>
                                <td id="menu-price">-- €</td>
                            </tr> 
                            <tr>
                                <td>Réduction 10% <br>
                                    <small> -10% si vous comandez pour
                                            5 personnes de plus que le minimum requis
                                    </small>
                                </td>
                                <td id="discount-price">-- €</td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong> <br>
                                <small>hors frais de livraisons</small>
                                </td>
                                <td id="total-price"><strong>-- €</strong></td>
                            </tr>          
                        </table>
                    </fieldset>


                    <div class="row next-step">
                        <!-- Bouton Précédent -->
                        <div class="col-6 back">
                            <a href="/commande/etape-1" class="btn btn-primary">Précédent</a>
                        </div>

                        <!-- Bouton Suivant -->
                        <div class="col-6 btn-next">
                            <button type="submit" id="btn-submit" class="btn btn-primary">Suivant</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
</main>

<script>
    const pricePerPerson = <?= (float) $menu['price_per_person'] ?>;
    const minPersons     = <?= (int) $menu['min_persons'] ?>;
</script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>