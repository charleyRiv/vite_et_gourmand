<?php
/**
 * @var string $h1
 * @var array $menus
 * @var int $preselectedMenuId
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="page-order2">
    <section class="section-order2-form">
        <div class="container">
            <div class="row">
                <h2><?=  htmlspecialchars($h1)?></h2>

                <form action="/commande/etape-2" method="POST">
                    <div class="row order2-form">
                        <div class="col-12 order2-label">
                            <label for="title">Séléctionner un menu</label>
                        </div>
                        <div class="col-12">
                            <select id="menu_id" name="menu_id" class="order2-input" required>
                                <option value=""></option>
                                <?php foreach ($menus as $menu): ?>
                                    <option value="<?= $menu['menu_id']?>"
                                    <?= ($preselectedMenuId == $menu['menu_id']) ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($menu['title'])?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Veuillez sélectionner un menu.
                            </div>
                        </div>

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

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>