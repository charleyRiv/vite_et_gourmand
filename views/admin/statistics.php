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

<main class="page-admin-statistique">
    
    <section class="section-kpi">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>KPI</h2>
                </div>
                
                <fieldset class="col-12 col-xl-3">
                    <label>Nombre total de commandes</label>
                    <div class="kpi-info">
                        <?=  htmlspecialchars($kpi['TotalOrders']) ?>
                    </div>
                </fieldset>

                <fieldset class="col-12 col-xl-3">
                    <label>Chiffre d'affaires</label>
                    <div class="kpi-info">
                        <?=  htmlspecialchars($kpi['CATotal']) ?> €
                    </div>
                </fieldset>

                <fieldset class="col-12 col-xl-3">
                    <label>Menu le plus commandé</label>
                    <?php foreach ($kpi['MostOrderedMenu'] as $menu): ?>
                    <div class="kpi-info">
                        <?=  htmlspecialchars($menu['_id']) ?> 
                        <div class="col-detail"><small>(<?= $menu['count'] ?> commandes)</small></div>
                    </div>
                    <?php endforeach; ?>
                </fieldset>

                <fieldset class="col-12 col-xl-3">
                    <label>Nombre de commandes en cours</label>
                    <div class="kpi-info">
                        <?=  htmlspecialchars($kpi['ActiveOrders']) ?>
                    </div>
                </fieldset>
            </div>
        </div>
    </section>



    <section class="section-orders" id="order-graphique">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Commandes par menus</h2>
                </div>
                
                <form action="/admin/statistiques#order-graphique" method="get">
                    <div class="row filters">
                        <div class=" col-12 col-xl-auto date-filters">
                            <!-- Filtre Date début-->
                            <div class="date-from-filter">
                                <label for="chart_date_from">Date début</label>
                                <input 
                                    type="date" 
                                    id="chart_date_from" 
                                    name="chart_date_from"
                                    value="<?= htmlspecialchars($_GET['chart_date_from']?? '') ?>"
                                >
                            </div>

                            <!-- Filtre Date fin-->
                            <div class="date-to-filter">
                                <label for="chart_date_to">Date fin</label>
                                <input 
                                    type="date" 
                                    id="chart_date_to" 
                                    name="chart_date_to"
                                    value="<?= htmlspecialchars($_GET['chart_date_to']?? '') ?>"
                                >
                            </div>
                        </div>

                        <div class=" col-12 col-xl-auto bouton-filters">
                            <!-- Boutons -->
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="/admin/statistiques" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </div>
                </form>

                <!-- Graphique -->
                <div class="col-12 order-graphique" id="chartOrders-container">
                    <canvas id="ordersChart"></canvas>
                </div>

                <!-- tableau -->
                <div class="col-12">
                    <table class="table table-bordered">
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
            </div>
        </div>
    </section>


    <section class="section-ca" id="ca-graphiques">
        <div class="container">
            <div class="row">
                <div class="graph-filters">
                    <div class="col-12">
                        <h2>Chiffre d'affaire par menus</h2>
                    </div>
                    <div class="col-12">
                        <!-- Choix du mode de graphique : en barre ou ligne -->
                        <button type="button" id="btn-bar" class="btn btn-primary darken">Graphique en barres</button>
                        <button type="button" id="btn-line" class="btn btn-primary">Graphique en ligne</button>
                    </div>  
                    <div>
                    
                    <?php $activeChart = $_GET['active_chart'] ?? 'bar'; ?>

                    <form action="/admin/statistiques#ca-graphiques" method="get" id="bar-filters" style="display: <?= $activeChart === 'bar' ? 'block' : 'none' ?>;">
                            <input type="hidden" name="active_chart" value="bar">
                            <!-- Conserver les autres filtres GET -->
                            <input type="hidden" name="line_mode" value="<?= $_GET['line_mode'] ?? 'total' ?>">
                            <input type="hidden" name="line_date_from" value="<?= $_GET['line_date_from'] ?? '' ?>">
                            <input type="hidden" name="line_date_to" value="<?= $_GET['line_date_to'] ?? '' ?>">

                        <div class="options-filters">
                            <div class="col-12 col-xl-4">
                                <select name="bar_mode" class="btn btn-filters">
                                    <option value="">Sélectionner un mode d'affichage <i class="bi bi-chevron-compact-down"></i></option>
                                    <option value="month" <?= ($_GET['bar_mode'] ?? 'month') === 'month' ? 'selected' : '' ?>>
                                        Par mois
                                    </option>
                                    <option value="menu" <?= ($_GET['bar_mode'] ?? '') === 'menu' ? 'selected' : '' ?>>
                                        Par menu
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 col-xl-4 date-filters">
                                <div class="date-from-filter">
                                    <label for="bar_date_from">Date début</label>
                                    <input type="date" name="bar_date_from" value="<?= htmlspecialchars($_GET['bar_date_from'] ?? '') ?>">
                                </div>

                                <div class="date-from-filter">
                                    <label for="bar_date_to">Date fin</label>
                                    <input type="date" name="bar_date_to" value="<?= htmlspecialchars($_GET['bar_date_to'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-12 col-xl-4 bouton-filters">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="/admin/statistiques" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </form>

                    <form action="/admin/statistiques#ca-graphiques" method="get" id="line-filters" style="display: <?= $activeChart === 'line' ? 'block' : 'none' ?>;">
                        <input type="hidden" name="active_chart" value="line">
                        <!-- Conserver les autres filtres GET -->
                        <input type="hidden" name="bar_mode" value="<?= $_GET['bar_mode'] ?? 'month' ?>">
                        <input type="hidden" name="bar_date_from" value="<?= $_GET['bar_date_from'] ?? '' ?>">
                        <input type="hidden" name="bar_date_to" value="<?= $_GET['bar_date_to'] ?? '' ?>">

                        <div class="options-filters">
                            <div class="col-12 col-xl-4">
                                <select name="line_mode" class="btn btn-filters">
                                    <option value="">Sélectionner un mode d'affichage <i class="bi bi-chevron-compact-down"></i></option>
                                    <option value="total" <?= ($_GET['line_mode'] ?? 'total') === 'total' ? 'selected' : '' ?>>
                                        CA total
                                    </option>
                                    <option value="by_menu" <?= ($_GET['line_mode'] ?? '') === 'by_menu' ? 'selected' : '' ?>>
                                        Par menu
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 col-xl-4 date-filters">
                                <div class="date-from-filter">
                                    <label for="line_date_from">Date début</label>
                                    <input type="date" name="line_date_from" value="<?= htmlspecialchars($_GET['line_date_from'] ?? '') ?>">
                                </div>

                                <div class="date-to-filter">
                                    <label for="line_date_to">Date fin</label>
                                    <input type="date" name="line_date_to" value="<?= htmlspecialchars($_GET['line_date_to'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-12 col-xl-4 bouton-filters">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="/admin/statistiques" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Graphique -->
                <div class="col-auto ca-graphique" id="chartCa-container">
                    <canvas id="barChart" style="display: <?= $activeChart === 'bar' ? 'block' : 'none' ?>;"></canvas>
                    <canvas id="lineChart" style="display: <?= $activeChart === 'line' ? 'block' : 'none' ?>;"></canvas>
                </div>

                <!-- Tableau -->
                <div class="col-12">
                    <table class="table table-bordered">
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
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <a href="/admin">Revenir au dashboard</a>
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