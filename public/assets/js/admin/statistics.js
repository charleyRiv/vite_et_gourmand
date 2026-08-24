document.addEventListener('DOMContentLoaded', function() {
    
    // ── Couleurs des menus ────────────────────────────────
    const menuColors = [
        '#E8845A',
        '#7A9E7E',
        '#5B7FA6',
        '#B5651D',
        '#2E7D4F',
        '#3D2B3D',
        '#C0392B',
    ];

    // ── Fonction utilitaire - retour à la ligne des labels ─
    function wrapLabel(label, maxLength = 14) {
        if (label.length <= maxLength) return label;

        const words = label.split(' ');
        const lines = [];
        let currentLine = '';

        words.forEach(word => {
            if ((currentLine + ' ' + word).trim().length <= maxLength) {
                currentLine = (currentLine + ' ' + word).trim();
            } else {
                if (currentLine) lines.push(currentLine);
                currentLine = word;
            }
        });

        if (currentLine) lines.push(currentLine);
        return lines;
    }

    const tickCallback = function(value) {
        return wrapLabel(this.getLabelForValue(value));
    };

    // ── Graphique commandes par menu ──────────────────────
    const ctxOrders = document.getElementById('ordersChart');
    if (ctxOrders) {
        new Chart(ctxOrders.getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Nombre de commandes',
                    data: chartData,
                    backgroundColor: menuColors,
                    borderRadius: 3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Nombre de commandes par menu'
                    }
                },
                scales: {
                    x: { ticks: { maxRotation: 90, minRotation: 90, callback: tickCallback } },
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    // ── Graphique CA en barres ────────────────────────────
    const ctxBar = document.getElementById('barChart');
    if (ctxBar) {
        const barChartDatasets = barDatasets.map((data, index) => ({
            label: barMode === 'month' ? 'CA mensuel' : barLabels[index],
            data: data,
            backgroundColor: barMode === 'month' ? '#E8845A' : menuColors[index % menuColors.length],
            borderRadius: 3
        }));

        new Chart(ctxBar.getContext('2d'), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: barChartDatasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: barMode !== 'month' },
                    title: {
                        display: true,
                        text: barMode === 'month' ? 'CA par mois' : 'CA par menu'
                    }
                },
                scales: {
                    x: { ticks: { maxRotation: 90, minRotation: 90, callback: tickCallback } },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value + ' €'
                        }
                    }
                }
            }
        });
    }

    // ── Graphique CA en ligne ─────────────────────────────
    const ctxLine = document.getElementById('lineChart');
    if (ctxLine) {
        const lineChartDatasets = lineDatasets.map((dataset, index) => ({
            label: dataset.label,
            data: dataset.data,
            borderColor: menuColors[index % menuColors.length],
            backgroundColor: menuColors[index % menuColors.length] + '33',
            tension: 0.3,
            fill: lineMode === 'total'
        }));

        new Chart(ctxLine.getContext('2d'), {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: lineChartDatasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: lineMode === 'by_menu' },
                    title: {
                        display: true,
                        text: lineMode === 'by_menu' ? 'Évolution CA par menu' : 'Évolution CA total'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value + ' €'
                        }
                    }
                }
            }
        });
    }

    // ── Switch entre les graphiques CA ────────────────────
    const btnBar  = document.getElementById('btn-bar');
    const btnLine = document.getElementById('btn-line');

    const ctxBarFilters = document.getElementById('bar-filters');
    const ctxLineFilters = document.getElementById('line-filters');

    if (btnBar && btnLine) {
        btnBar.addEventListener('click', function() {
            // Mettre à jour le champ hidden active_chart dans le formulaire barres
            document.querySelector('#bar-filters [name="active_chart"]').value = 'bar';
            
            ctxBar.style.display  = 'block';
            ctxBarFilters.style.display = 'block';

            ctxLine.style.display = 'none';
            ctxLineFilters.style.display = 'none';

        });

        btnLine.addEventListener('click', function() {
            // Mettre à jour le champ hidden active_chart dans le formulaire barres
            document.querySelector('#line-filters [name="active_chart"]').value = 'line';

            ctxBar.style.display  = 'none';
            ctxBarFilters.style.display = 'none';

            ctxLine.style.display = 'block';
            ctxLineFilters.style.display = 'block';
        });
    }
});