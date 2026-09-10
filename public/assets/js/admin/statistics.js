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
    let chartOrders = null;

    if (ctxOrders) {
        chartOrders = new Chart(ctxOrders.getContext('2d'), {
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
        
    // ResizeObserver sur le conteneur
    const containerOrders = document.getElementById('chartOrders-container');
    const resizeObserverOrders = new ResizeObserver(() => {
        chartOrders.resize();
    });
    resizeObserverOrders.observe(containerOrders);
    }

    window.addEventListener('resize', function() {
        if (chartOrders) chartOrders.resize();
    })


    // ── Graphique CA en barres ────────────────────────────
    const ctxBar = document.getElementById('barChart');
    let chartCaBar = null;

    if (ctxBar) {
        const barChartDatasets = barDatasets.map((data, index) => ({
            label: barMode === 'month' ? 'CA mensuel' : barLabels[index],
            data: data,
            backgroundColor: barMode === 'month' ? '#E8845A' : menuColors[index % menuColors.length],
            borderRadius: 3
        }));

        chartCaBar = new Chart(ctxBar.getContext('2d'), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: barChartDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

        // ResizeObserver sur le conteneur
        const containerCaBar = document.getElementById('chartCa-container');
        const resizeObserverCaBar = new ResizeObserver(() => {
            chartCaBar.resize();
        });
        resizeObserverCaBar.observe(containerCaBar);
    }

    window.addEventListener('resize', function() {
        if (chartCaBar) chartCaBar.resize();
    })

    // ── Graphique CA en ligne ─────────────────────────────
    const ctxLine = document.getElementById('lineChart');
    let chartCaLine = null;

    if (ctxLine) {
        const lineChartDatasets = lineDatasets.map((dataset, index) => ({
            label: dataset.label,
            data: dataset.data,
            borderColor: menuColors[index % menuColors.length],
            backgroundColor: menuColors[index % menuColors.length] + '33',
            tension: 0.3,
            fill: lineMode === 'total'
        }));

        chartCaLine = new Chart(ctxLine.getContext('2d'), {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: lineChartDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
        // ResizeObserver sur le conteneur
            const containerCaLine = document.getElementById('chartCa-container');
            const resizeObserverCaLine = new ResizeObserver(() => {
                chartCaLine.resize();
            });
            resizeObserverCaLine.observe(containerCaLine);
    }

    window.addEventListener('resize', function() {
        if (chartCaLine) chartCaLine.resize();
    })

    // ── Switch entre les graphiques CA ────────────────────
    const btnBar  = document.getElementById('btn-bar');
    const btnLine = document.getElementById('btn-line');

    const ctxBarFilters = document.getElementById('bar-filters');
    const ctxLineFilters = document.getElementById('line-filters');

    if (btnBar && btnLine) {
        btnBar.addEventListener('click', function() {
            btnBar.classList.add('darken');
            btnLine.classList.remove('darken');
            // Mettre à jour le champ hidden active_chart dans le formulaire barres
            document.querySelector('#bar-filters [name="active_chart"]').value = 'bar';
            
            ctxBar.style.display  = 'block';
            ctxBarFilters.style.display = 'block';

            ctxLine.style.display = 'none';
            ctxLineFilters.style.display = 'none';

        });

        btnLine.addEventListener('click', function() {
            btnLine.classList.add('darken');
            btnBar.classList.remove('darken');
            // Mettre à jour le champ hidden active_chart dans le formulaire barres
            document.querySelector('#line-filters [name="active_chart"]').value = 'line';

            ctxBar.style.display  = 'none';
            ctxBarFilters.style.display = 'none';

            ctxLine.style.display = 'block';
            ctxLineFilters.style.display = 'block';
        });
    }
});