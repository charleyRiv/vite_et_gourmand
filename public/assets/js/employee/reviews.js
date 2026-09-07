document.addEventListener('DOMContentLoaded', function() {
    const statusBtn = document.getElementById('status-filter-btn');
    const statusFilter = document.getElementById('status_filter');
    const rateBtn = document.getElementById('rate-filter-btn');
    const rateFilter = document.getElementById('rate_filter');
    const dateBtn = document.getElementById('date-filter-btn');
    const dateFilter = document.getElementById('dates-filter');


    // Evenements
    if (statusBtn && statusFilter) {
    statusBtn.addEventListener('click', function() {
        statusFilter.classList.toggle('d-none');
    });
    }

    if (rateBtn && rateFilter) {
    rateBtn.addEventListener('click', function() {
        rateFilter.classList.toggle('d-none');
    });
    }

    if (dateBtn && dateFilter) {
    dateBtn.addEventListener('click', function() {
        dateFilter.classList.toggle('d-none');
    });
    }


});