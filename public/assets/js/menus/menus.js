function initMenus() {

    // ── État ──────────────────────────────────────────────
    let currentPage = 1;
    let currentFilters = {};
    let totalPages = 1;

    // ── Références DOM ────────────────────────────────────
    const menusList = document.getElementById('menus-list');
    const paginationEl = document.getElementById('pagination');
    const themesCheckboxes = document.getElementById('themes-checkboxes');
    const dietsCheckboxes = document.getElementById('diets-checkboxes');
    const filtresForm = document.getElementById('filtres-form');
    const btnFilters = document.getElementById('btn-filters');
    const btnCloseFilters = document.getElementById('btn-close-filters');
    const filtersAside = document.getElementById('filters-aside');
    const filtersOverlay = document.getElementById('filters-overlay');
    const btnReset = document.getElementById('btn-reset');
    const prixMinInput = document.getElementById('prix_min');
    const prixMaxInput = document.getElementById('prix_max');
    const prixMinLabel = document.getElementById('prix_min_label');
    const prixMaxLabel = document.getElementById('prix_max_label');
    const nbPersonsInput = document.getElementById('nb_persons');

    // ── Utilitaire XSS ───────────────────────────────────
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // ── Fetch API ─────────────────────────────────────────
    async function fetchMenus(page = 1, filters = {}) {
        const params = new URLSearchParams();
        params.set('page', page);

        if (filters.prix_min)   params.set('prix_min',   filters.prix_min);
        if (filters.prix_max)   params.set('prix_max',   filters.prix_max);
        if (filters.nb_persons) params.set('nb_persons', filters.nb_persons);

        (filters.themes || []).forEach(t => params.append('themes[]', t));
        (filters.diets  || []).forEach(d => params.append('diets[]',  d));

        const response = await fetch(`/api/menus?${params.toString()}`);
        if (!response.ok) throw new Error('Erreur API');
        return await response.json();
    }

    // ── Rendu filtres ─────────────────────────────────────
    function renderFilters(themes, diets) {
        themesCheckboxes.innerHTML = themes.map(theme => `
            <div class="col-auto">
                <label>
                    <input type="checkbox" name="themes[]" value="${theme.theme_id}">
                    ${escapeHtml(theme.label)}
                </label>
            </div>
        `).join('');

        dietsCheckboxes.innerHTML = diets.map(diet => `
            <div class="col-auto">
                <label>
                    <input type="checkbox" name="diets[]" value="${diet.diet_id}">
                    ${escapeHtml(diet.label)}
                </label>
            </div>
        `).join('');
    }

    // ── Rendu menus ───────────────────────────────────────
    function renderMenus(menus) {
        if (menus.length === 0) {
            menusList.innerHTML = `
                <div class="col-12">
                    <p class="mb-0">Aucun menu disponible pour le moment.</p>
                </div>`;
            return;
        }

        menusList.innerHTML = menus.map(menu => {
            const bgImage = menu.main_picture
                ? menu.main_picture.url
                : '/assets/images/uploads/default.png';

            return `
                <div class="col-12 col-lg-6">
                    <article class="menus">
                        <div class="menus-overlay" style="background-image: url('${bgImage}')">
                            <div class="col-12">
                                <h3>${escapeHtml(menu.title)}</h3>
                            </div>
                            <div class="col-12">
                                <p class="mb-0">${escapeHtml(menu.description)}</p>
                            </div>
                            <hr class="separator">
                            <div class="col-12 text-lg-end">
                                <p class="mb-0">${escapeHtml(menu.price_per_person)} € / personne</p>
                            </div>
                            <div class="col-12 text-lg-end">
                                <p class="mb-0">Minimum ${escapeHtml(menu.min_persons)} personnes</p>
                            </div>
                            <div class="col-12 text-lg-start">
                                <a href="/menus-v2/${menu.menu_id}" class="btn btn-primary">Voir le détail</a>
                            </div>
                        </div>
                    </article>
                </div>`;
        }).join('');
    }

    // ── Rendu pagination ──────────────────────────────────
    function renderPagination(current, total) {
        if (total <= 1) {
            paginationEl.innerHTML = '';
            return;
        }

        let html = `
            <li class="page-item ${current <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${current - 1}">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>`;

        for (let i = 1; i <= total; i++) {
            html += `
                <li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        html += `
            <li class="page-item ${current >= total ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${current + 1}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>`;

        paginationEl.innerHTML = html;

        paginationEl.querySelectorAll('[data-page]').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page);
                if (page >= 1 && page <= totalPages) {
                    loadMenus(page);
                }
            });
        });
    }

    // ── Chargement principal ──────────────────────────────
    async function loadMenus(page = 1) {
        currentPage = page;
        menusList.innerHTML = '<div class="col-12 text-center"><p>Chargement...</p></div>';

        try {
            const data = await fetchMenus(page, currentFilters);
            totalPages = data.totalPages;

            if (page === 1 && themesCheckboxes.innerHTML === '') {
                renderFilters(data.themes, data.diets);
            }

            renderMenus(data.menus);
            renderPagination(data.currentPage, data.totalPages);

        } catch (error) {
            menusList.innerHTML = `
                <div class="col-12">
                    <p>Erreur lors du chargement des menus.</p>
                </div>`;
        }
    }

    // ── Événements prix ───────────────────────────────────
    prixMinInput.addEventListener('input', function () {
        prixMinLabel.textContent = this.value + ' €';
    });

    prixMaxInput.addEventListener('input', function () {
        prixMaxLabel.textContent = this.value + ' €';
    });

    // ── Événement filtres ─────────────────────────────────
    filtresForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        currentFilters = {
            prix_min:   formData.get('prix_min'),
            prix_max:   formData.get('prix_max'),
            nb_persons: nbPersonsInput.value,
            themes:     formData.getAll('themes[]'),
            diets:      formData.getAll('diets[]'),
        };
        loadMenus(1);
        filtersAside.classList.remove('open');
        filtersOverlay.classList.remove('open');
    });

    // ── Réinitialisation ──────────────────────────────────
    btnReset.addEventListener('click', function () {
        filtresForm.reset();
        prixMinLabel.textContent = '0 €';
        prixMaxLabel.textContent = '200 €';
        currentFilters = {};
        loadMenus(1);
    });

    // ── Toggle filtres ────────────────────────────────────
    btnFilters.addEventListener('click', function () {
        filtersAside.classList.add('open');
        filtersOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    btnCloseFilters.addEventListener('click', function () {
        filtersAside.classList.remove('open');
        filtersOverlay.classList.remove('open');
        document.body.style.overflow = '';
    });

    filtersOverlay.addEventListener('click', function () {
        filtersAside.classList.remove('open');
        filtersOverlay.classList.remove('open');
        document.body.style.overflow = '';
    });

    // ── Initialisation ────────────────────────────────────
    loadMenus(1);
}