<?php
/**
 * @var string $h1
 * @var string $chartLabelsJson
 * @var string $chartDataJson
 * @var string $barLabelsJson
 * @var string $barDatasetsJson
 * @var string $barModeJson
 * @var string $lineLabelsJson
 * @var string $lineDatasetsJson
 * @var string $lineModeJson
 * @var array $ordersByMenu
 * @var string $totalOrders
 * @var string $totalPercentage
 * @var array $kpi
 * @var array $revenuByMenu
 * @var string $CATotalOrders
 * @var string $CATotalRevenus
 * @var string $CATotalAvg
 */

require_once __DIR__ . '/../layouts/header.php';
?>

<main>
    <h1><?= htmlspecialchars($h1) ?></h1>
    
    <section>
        <h2>KPI</h2>
        <div>
            <h3>Nombre total de commandes</h3>
            <p><?=  htmlspecialchars($kpi['TotalOrders']) ?></p>
        </div>
        <div>
            <h3>Chiffre d'affaires</h3>
            <p><?=  htmlspecialchars($kpi['CATotal']) ?> €</p>
        </div>
        <div>
            <h3>Menu le plus commandé</h3>
            <?php foreach ($kpi['MostOrderedMenu'] as $menu): ?>
            <p><?=  htmlspecialchars($menu['_id']) ?> 
            (<?= $menu['count'] ?> commandes)
            </p>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>Nombre de commandes en cours</h3>
            <p><?=  htmlspecialchars($kpi['ActiveOrders']) ?></p>
        </div>
    </section>

    <section id="order-graphique">
        <h2>Commandes par menus</h2>
        <div>
            <form action="/admin/statistiques#order-graphique" method="get">
                <!-- Filtre Date début-->
                <label for="chart_date_from">Date début</label>
                <input 
                    type="date" 
                    id="chart_date_from" 
                    name="chart_date_from"
                    value="<?= htmlspecialchars($_GET['chart_date_from']?? '') ?>"
                >

                <!-- Filtre Date fin-->
                <label for="chart_date_to">Date fin</label>
                <input 
                    type="date" 
                    id="chart_date_to" 
                    name="chart_date_to"
                    value="<?= htmlspecialchars($_GET['chart_date_to']?? '') ?>"
                >
                
                <!-- Boutons -->
                    <button type="submit">Filtrer</button>
                    <a href="/admin/statistiques">Réinitialiser</a>
            </form>
        </div>

        <div>
            <canvas id="ordersChart" width="400" height="200"></canvas>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Menus</th>
                        <th>Commandes</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordersByMenu as $menu) : ?>
                        <tr>
                            <td><?= htmlspecialchars($menu['_id']) ?></td>
                            <td><?= htmlspecialchars($menu['count']) ?></td>
                            <td><?= htmlspecialchars($menu['percentage']) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><?=  htmlspecialchars($totalOrders) ?></td>
                        <td><?=  htmlspecialchars($totalPercentage) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section id="ca-graphiques">
        <h2>Chiffre d'affaire par menus</h2>
        <div>
            <!-- Choix du mode de graphique : en barre ou ligne -->
            <button type="button" id="btn-bar" style="display: in-line;">Graphique en barres</button>
            <button type="button" id="btn-line" style="display: in-line;">Graphique en ligne</button>
        </div>  
        <div>
            <?php $activeChart = $_GET['active_chart'] ?? 'none'; ?>

            <form action="/admin/statistiques#ca-graphiques" method="get" id="bar-filters" style="display: <?= $activeChart === 'bar' ? 'block' : 'none' ?>;">
                <input type="hidden" name="active_chart" value="bar">
                <!-- Conserver les autres filtres GET -->
                <input type="hidden" name="line_mode" value="<?= $_GET['line_mode'] ?? 'total' ?>">
                <input type="hidden" name="line_date_from" value="<?= $_GET['line_date_from'] ?? '' ?>">
                <input type="hidden" name="line_date_to" value="<?= $_GET['line_date_to'] ?? '' ?>">

                <select name="bar_mode">
                    <option value="month" <?= ($_GET['bar_mode'] ?? 'month') === 'month' ? 'selected' : '' ?>>
                        Par mois
                    </option>
                    <option value="menu" <?= ($_GET['bar_mode'] ?? '') === 'menu' ? 'selected' : '' ?>>
                        Par menu
                    </option>
                </select>

                <input type="date" name="bar_date_from" value="<?= htmlspecialchars($_GET['bar_date_from'] ?? '') ?>">
                <input type="date" name="bar_date_to" value="<?= htmlspecialchars($_GET['bar_date_to'] ?? '') ?>">

                <button type="submit" >Filtrer</button>
                <a href="/admin/statistiques">Réinitialiser</a>
            </form>

            <form action="/admin/statistiques#ca-graphiques" method="get" id="line-filters" style="display: <?= $activeChart === 'line' ? 'block' : 'none' ?>;">
                <input type="hidden" name="active_chart" value="line">
                <!-- Conserver les autres filtres GET -->
                <input type="hidden" name="bar_mode" value="<?= $_GET['bar_mode'] ?? 'month' ?>">
                <input type="hidden" name="bar_date_from" value="<?= $_GET['bar_date_from'] ?? '' ?>">
                <input type="hidden" name="bar_date_to" value="<?= $_GET['bar_date_to'] ?? '' ?>">

                <select name="line_mode">
                    <option value="total" <?= ($_GET['line_mode'] ?? 'total') === 'total' ? 'selected' : '' ?>>
                        CA total
                    </option>
                    <option value="by_menu" <?= ($_GET['line_mode'] ?? '') === 'by_menu' ? 'selected' : '' ?>>
                        Par menu
                    </option>
                </select>

                <input type="date" name="line_date_from" value="<?= htmlspecialchars($_GET['line_date_from'] ?? '') ?>">
                <input type="date" name="line_date_to" value="<?= htmlspecialchars($_GET['line_date_to'] ?? '') ?>">

                <button type="submit">Filtrer</button>
            </form>
        </div>


        <canvas id="barChart" style="display: <?= $activeChart === 'bar' ? 'block' : 'none' ?>;"></canvas>
        <canvas id="lineChart" style="display: <?= $activeChart === 'line' ? 'block' : 'none' ?>;"></canvas>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Menus</th>
                        <th>Commandes</th>
                        <th>CA (€)</th>
                        <th>Prix moyen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($revenuByMenu as $menu) : ?>
                        <tr>
                            <td><?= htmlspecialchars($menu['_id']['menu_title']) ?></td>
                            <td><?= htmlspecialchars($menu['count']) ?></td>
                            <td><?= htmlspecialchars($menu['total']) ?></td>
                            <td><?= htmlspecialchars($menu['avg_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td><?=  htmlspecialchars($CATotalOrders) ?></td>
                        <td><?=  htmlspecialchars($CATotalRevenus) ?></td>
                        <td><?=  htmlspecialchars($CATotalAvg) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</main>

<!-- Données pour Charts.js -->
<script>
    const chartLabels = <?= $chartLabelsJson ?>;
    const chartData = <?= $chartDataJson ?>;

    // Graphique 1 - Barres
    const barLabels   = <?= $barLabelsJson ?>;
    const barDatasets = <?= $barDatasetsJson ?>;
    const barMode     = <?= $barModeJson ?>;

    // Graphique 2 - Ligne
    const lineLabels   = <?= $lineLabelsJson ?>;
    const lineDatasets = <?= $lineDatasetsJson ?>;
    const lineMode     = <?= $lineModeJson ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>