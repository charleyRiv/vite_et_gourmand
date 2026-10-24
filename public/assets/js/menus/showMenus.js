function initShowMenu() {

    const menuDetail = document.getElementById('menu-detail');

    // ── Récupère l'id depuis l'URL ────────────────────────
    const pathParts = window.location.pathname.split('/');
    const menuId    = pathParts[pathParts.length - 1];

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

    // ── Rendu carousel ────────────────────────────────────
    function renderCarousel(pictures) {
        const defaultPicture = {
            url:      '/assets/images/uploads/default.png',
            alt_text: 'Image non disponible'
        };

        while (pictures.length < 3) {
            pictures.push(defaultPicture);
        }

        const indicators = pictures.map((pic, i) => `
            <button 
                type="button" 
                data-bs-target="#menuCarousel" 
                data-bs-slide-to="${i}"
                class="${i === 0 ? 'active' : ''}"
                aria-label="Photo ${i + 1}">
            </button>`).join('');

        const slides = pictures.map((pic, i) => `
            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                <img 
                    src="${escapeHtml(pic.url)}"
                    alt="${escapeHtml(pic.alt_text)}"
                    class="d-block w-100 carousel-img"
                >
            </div>`).join('');

        return `
            <div class="col-12 mb-4 d-lg-none">
                <div id="menuCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">${indicators}</div>
                    <div class="carousel-inner">${slides}</div>
                    <button class="carousel-control-prev" type="button" 
                        data-bs-target="#menuCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" 
                        data-bs-target="#menuCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>`;
    }

    // ── Rendu plats ───────────────────────────────────────
    function renderDishes(dishes) {
        return dishes.map(dish => {
            const pictureUrl = dish.picture
                ? dish.picture.url
                : '/assets/images/uploads/default.png';

            const pictureAlt = dish.picture
                ? dish.picture.alt_text
                : 'Image bientôt disponible';

            const allergens = dish.allergens && dish.allergens.length > 0
                ? `<div class="col-12 menu-allergen">
                    allergènes : ${escapeHtml(dish.allergens.map(a => a.label).join(', '))}
                    </div>`
                : '';

            return `
                <div class="col-12 col-lg-4">
                    <article class="menu-dish">
                        <div class="col-12 d-none d-lg-block">
                            <img 
                                src="${escapeHtml(pictureUrl)}"
                                alt="${escapeHtml(pictureAlt)}"
                                class="menu-picture-dish"
                            >
                        </div>
                        <div class="menu-details">
                            <div class="col-12 mb-3">
                                <h3>${escapeHtml(dish.dish_type)}</h3>
                            </div>
                            <div class="col-12 mb-3">
                                <p>${escapeHtml(dish.title)}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <p>${escapeHtml(dish.description)}</p>
                            </div>
                            ${allergens}
                        </div>
                    </article>
                </div>`;
        }).join('');
    }

    // ── Rendu menu complet ────────────────────────────────
    function renderMenu(menu) {

        // Met à jour le titre de la page et le hero
        document.title = `${menu.title} - Vite & Gourmand`;
        const heroTitle = document.getElementById('hero-title');
        if (heroTitle) heroTitle.textContent = menu.title;

        const stock = menu.remaining_stock === 0
            ? '<span>Bientôt disponible</span>'
            : `${escapeHtml(String(menu.remaining_stock))} disponible(s)`;

        menuDetail.innerHTML = `
            <div class="col-12 description">
                <p>${escapeHtml(menu.description)}</p>
            </div>
            <div class="row g-0 mb-0 categorie">
                <div class="col-12 col-lg-auto">
                    <p>Thème : ${escapeHtml(menu.theme)}</p>
                </div>
                <div class="col-12 col-lg-auto">
                    <p>Régime : ${escapeHtml(menu.diet)}</p>
                </div>
            </div>

            ${renderCarousel(menu.pictures || [])}

            <div class="row g-0 mb-0">
                ${renderDishes(menu.dishes || [])}
            </div>

            <div class="row g-0 mb-0 menu-infos">
                <div class="col-12 col-lg-auto">
                    <p>${escapeHtml(menu.price_per_person)}€ / personne</p>
                </div>
                <div class="col-12 col-lg-auto">
                    <p>Minimum ${escapeHtml(String(menu.min_persons))} personnes</p>
                </div>
                <div class="col-12 col-lg-auto">
                    <p>Stock : ${stock}</p>
                </div>
            </div>

            <div class="col-12 menu-condition">
                <p>Conditions de réservation : ${escapeHtml(menu.conditions)}</p>
            </div>

            <div class="row g-0 mb-0 menu-commande">
                <div class="col-12 col-lg-auto">
                    <a href="/commande/etape-1-v2?menu_id=${menu.menu_id}" class="btn btn-primary">
                        Commander
                    </a>
                </div>
                <div class="col-12 col-lg-auto">
                    <a href="/menus-v2">Revenir à la liste des menus</a>
                </div>
            </div>`;
    }

    // ── Chargement ────────────────────────────────────────
    async function loadMenu() {
        try {
            const response = await fetch(`/api/menus/${menuId}`);

            if (!response.ok) {
                menuDetail.innerHTML = '<div class="col-12"><p>Menu introuvable.</p></div>';
                return;
            }

            const menu = await response.json();
            renderMenu(menu);

        } catch (error) {
            menuDetail.innerHTML = '<div class="col-12"><p>Erreur lors du chargement.</p></div>';
        }
    }

    // ── Initialisation ────────────────────────────────────
    loadMenu();
}