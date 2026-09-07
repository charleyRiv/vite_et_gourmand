document.addEventListener('DOMContentLoaded', function() {
    const statusBtn = document.getElementById('status-filter-btn');
    const statusFilter = document.getElementById('status_filter');
    const dietBtn = document.getElementById('diet-filter-btn');
    const dietFilter = document.getElementById('diet_filter');
    const themeBtn = document.getElementById('theme-filter-btn');
    const themeFilter = document.getElementById('theme-filter');
    //const searchInput = document.getElementById('search');


    // Evenements
    if (statusBtn && statusFilter) {
    statusBtn.addEventListener('click', function() {
        statusFilter.classList.toggle('d-none');
    });
    }

    if (dietBtn && dietFilter) {
    dietBtn.addEventListener('click', function() {
        dietFilter.classList.toggle('d-none');
    });
    }

    if (themeBtn && themeFilter) {
    themeBtn.addEventListener('click', function() {
        themeFilter.classList.toggle('d-none');
    });
    }


});