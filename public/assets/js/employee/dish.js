document.addEventListener('DOMContentLoaded', function() {
    const dishTypeBtn = document.getElementById('dish-type-filter-btn');
    const dishTypeFilter = document.getElementById('dish-type_filter');
    const dietBtn = document.getElementById('diet-filter-btn');
    const dietFilter = document.getElementById('diet_filter');
    const allergensBtn = document.getElementById('allergens-filter-btn');
    const allergensFilter = document.getElementById('allergens-filter');
    //const searchInput = document.getElementById('search');


    // Evenements
    if (dishTypeBtn && dishTypeFilter) {
    dishTypeBtn.addEventListener('click', function() {
        dishTypeFilter.classList.toggle('d-none');
    });
    }

    if (dietBtn && dietFilter) {
    dietBtn.addEventListener('click', function() {
        dietFilter.classList.toggle('d-none');
    });
    }

    if (allergensBtn && allergensFilter) {
    allergensBtn.addEventListener('click', function() {
        allergensFilter.classList.toggle('d-none');
    });
    }


});