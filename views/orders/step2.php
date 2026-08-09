<?php
/**
 * @var string $h1
 * @var array $menus
 * @var int $preselectedMenuId
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<br>
<main>
    <h1><?=  htmlspecialchars($h1)?></h1>
    <br>
    <form action="/commande/etape-2" method="POST">

        <label for="title">Sélectionner un menu</label>
        <select id="menu_id" name="menu_id" required>
            <option value="default"></option>
            <?php foreach ($menus as $menu): ?>
                <option value="<?= $menu['menu_id']?>"
                <?= ($preselectedMenuId == $menu['menu_id']) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($menu['title'])?>
                </option>
            <?php endforeach; ?>
        </select>
    <br>

        <!-- Bouton Précédent -->
        <a href="/commande/etape-1">Précédent</a>
        
        <!-- Bouton Suivant -->
        <button type="submit">Suivant</button>

    </form>
</main>
<br>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>