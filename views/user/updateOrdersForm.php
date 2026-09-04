<?php
/**
 * @var string $h1
 * @var array $order
 * @var array $menu
 * @var array $menus
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-client-update-order">
    <section class="section-client-update-order">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><?=  htmlspecialchars($h1)?></h2>
                </div>
            
                <form action="/mon-espace/commande/<?= $order['order_id'] ?>/modifier" method="Post">
                    <div class="col-12">
                        <h3>Informations de livraisons </h3>
                    </div>
                        <fieldset class="client-update-order-date-form">
                            <legend>Date et heure de livraison</legend>

                            <div class="row date-form">
                                <!-- Date -->
                                <div class="col-12 col-xl-6">
                                    <label for="date_livraison" class="order1-label">Date de livraison</label>

                                    <input 
                                        type="text" 
                                        id="date_livraison" 
                                        name="event_date" 
                                        class="order1-input datepicker"
                                        placeholder="Sélectionner une date"
                                        value="<?= htmlspecialchars($order['event_date'] ?? '') ?>"
                                        required>
                                    <div class="invalid-feedback">
                                        La date séléctionnée est indisponible. <br>
                                        Veuillez séléctionner une autre date.
                                    </div>
                                </div>

                                    <!-- Heure -->
                                <div class="col-12 col-xl-6">
                                    <label for="heure_livraison" class="order1-label time">Heure de livraison</label>
                                    <select id="heure_livraison" name="heure_livraison" class="order1-input time" required>
                                        <option value="">-- Choisir un créneau --</option>
                                        <?php
                                        $start = strtotime('09:00');
                                        $end   = strtotime('20:00');
                                        $step  = 30 * 60; // 30 minutes en secondes

                                        for ($time = $start; $time <= $end; $time += $step):
                                        ?>
                                            <option value="<?= date('H:i', $time) ?>"
                                                <?= (date('H:i', $time) === substr($order['delivery_time'] ?? '', 0, 5)) ? 'selected' : '' ?>
                                            >
                                                <?= date('H\hi', $time) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="client-update-order-delivery-form">
                            <legend>Adresse de livraison</legend>
                                
                            <div class="row street">
                                <!-- Champs N° voie -->
                                <div class="col-12 col-xl-2">
                                    <label for="street_number" class="client-update-order-label">N° Voie</label>
                                            
                                <input 
                                    type="text" 
                                    id="street_number" 
                                    name="street_number" 
                                    value="<?= htmlspecialchars($order['delivery_street_number'] ?? '')?>"
                                    class="client-update-order-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir un numéro de voie</div>
                                </div>

                                <!-- Champs Type voie -->
                                <div class="col-12 col-xl-4">
                                    <label for="street_type" class="client-update-order-label">Type de voie</label>
                                            
                                    <input 
                                        type="text" 
                                        id="street_type" 
                                        name="street_type" 
                                        value="<?= htmlspecialchars($order['delivery_street_type']?? '')?>"
                                        class="client-update-order-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un type de voie</div>
                                </div>

                                <!-- Champs Nom voie -->
                                <div class="col-12 col-xl-6">
                                    <label for="street_name" class="client-update-order-label">Nom de la voie</label>
                                            
                                    <input 
                                        type="text" 
                                        id="street_name" 
                                        name="street_name" 
                                        value="<?= htmlspecialchars($order['delivery_street_name']?? '')?>"
                                        class="client-update-order-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un nom de voie</div>
                                </div>
                            </div>

                            <div class="row city">
                                <!-- Champs Code Postal -->
                                <div class="col-12 col-xl-3">
                                    <label for="zip_code" class="client-update-order-label">Code postal</label>
                                    <input 
                                        type="text" 
                                        id="zip_code" 
                                        name="zip_code" 
                                        value="<?= htmlspecialchars($order['delivery_zip_code']?? '')?>"
                                        class="client-update-order-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir un code postal</div>
                                </div>

                                <!-- Champs Ville -->
                                <div class="col-12 col-xl-9">
                                    <label for="city" class="client-update-order-label">Ville</label>
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city" 
                                        value="<?= htmlspecialchars($order['delivery_city']??'')?>"
                                        class="client-update-order-input"
                                        required
                                    >
                                    <div class="invalid-feedback">Veuillez saisir une ville</div>
                                </div>
                            </div>

                            <!-- Champs Pays -->
                            <div class="col-12 client-update-order-label">
                                <label for="country">Pays</label>
                            </div>

                            <div class="col-12 client-update-order-input">
                                <input 
                                    type="text" 
                                    id="country" 
                                    name="country" 
                                    value="<?= htmlspecialchars($order['delivery_country']??'')?>"
                                    class="client-update-order-input"
                                    required
                                >
                                <div class="invalid-feedback">Veuillez saisir un pays</div>
                            </div>
                        </fieldset>   
                        
                        <fieldset class="client-update-order-menu-form">
                            <legend>Menu</legend>
                            <div class="col-12 client-update-order-label">
                                <label for="title">Sélectionner un menu</label>
                            </div>
                            <div class="col-12">
                                <select id="menu_id" name="menu_id" class="client-update-order-input" required>
                                    <option value=""></option>
                                    <?php foreach ($menus as $men): ?>
                                        <option value="<?= $men['menu_id']?>"
                                        <?= ($men['menu_id'] == $order['menu_id']) ? 'selected' : '' ?>
                                    >
                                            <?= htmlspecialchars($men['title'])?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner un menu.
                                </div>
                            </div>

                            <!-- Champs Nombre de personnes -->
                            <div class="col-12 client-update-order-label">
                                <label for="nb_persons">Nombre de personnes</label>
                            </div>

                            <div class="col-2">
                                <input 
                                    type="number" 
                                    id="nb_persons" 
                                    name="nb_persons" 
                                    min="<?= $menu['min_persons'] ?>"
                                    value="<?= htmlspecialchars($order['nb_persons'])?>"
                                    class="client-update-order-input"
                                    required
                                >
                                <div class="invalid-feedback">min <?= $menu['min_persons'] ?> personnes.</div>
                            </div>
                            <div class="col-12 warning">
                                <p>Le menu sélectionné est prévu pour <span id="min-persons-display"><?= $menu['min_persons'] ?></span> personnes minimum</p>
                            </div>  
                        </fieldset>

                        <fieldset class="client-update-order-prices">
                            <legend>Détail du nouveau prix</legend>

                            <table class="table table-borderless"> 
                                <tr>
                                    <td>Prix du menu <br>
                                    <small>
                                        <span id="price-per-person-display">
                                            <?= $menu['price_per_person']?></span> € x
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
                                    <td>Frais de livraison<br>
                                        <small id="delivery-detail">-- km</small>
                                    </td>
                                    <td id="delivery-fees">-- €</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong> <br>
                                    <small>frais de livraisons inclus</small>
                                    </td>
                                    <td id="total-price"><strong>-- €</strong></td>
                                </tr>          
                            </table>
                        </fieldset>

                        <div class="row boutons-next">
                            <div class="col-12 col-lg-5 back">
                                <a href="/mon-espace">Revenir à mon espace</a>
                            </div>
                            <div class="col-12 col-lg-5 validate">
                                <button type="submit" id="btn-submit" class="btn btn-success">Valider les modifications</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    const menusData = <?= json_encode(array_column($menus, null, 'menu_id')) ?>;
</script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>