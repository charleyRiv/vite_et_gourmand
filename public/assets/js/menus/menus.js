document.addEventListener('DOMContentLoaded', function() {
    const btnFilters = document.getElementById('btn-filters');
    const btnClose = document.getElementById('btn-close-filters');
    const filtersAside = document.getElementById('filters-aside');
    const filtersOverlay = document.getElementById('filters-overlay');

    // OUvrir
    btnFilters.addEventListener('click', function() {
        filtersAside.classList.add('open');
        filtersOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    //Fermer via bouton close
    btnClose.addEventListener('click', closeFilters);

    //Fermer via overlay
    filtersOverlay.addEventListener('click', closeFilters);

    function closeFilters() {
        filtersAside.classList.remove('open');
        filtersOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    //Filtres prix slider
    const minSlider = document.getElementById('prix_min');
    const maxSlider = document.getElementById('prix_max');
    const minLabel = document.getElementById('prix_min_label');
    const maxlabel = document.getElementById('prix_max_label');

    if (maxSlider && maxSlider && minLabel && maxlabel) {
        function updateSliders() {
            const min = parseInt(minSlider.value);
            const max = parseInt(maxSlider.value);

            //Empêcher le croisement
            if (min > max) {
                minSlider.value = max;
            }
            if (max < min) {
                maxSlider.value = min
            }

            minLabel.textContent = minSlider.value + ' €';
            maxlabel.textContent = maxSlider.value + ' €';
        }
    }    
    
    updateSliders();
    minSlider.addEventListener('input', updateSliders);
    maxSlider.addEventListener('input', updateSliders);
});