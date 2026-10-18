function initHome() {

    // ── Références DOM ────────────────────────────────────
    const homeIntro = document.getElementById('home-intro');
    const homeTeam = document.getElementById('home-team');
    const homeReviews = document.getElementById('home-reviews');

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

    // ── Rendu étoiles ─────────────────────────────────────
    function renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += `<img src="/assets/images/uploads/icone_starOn.svg" alt="étoile" class="etoile mb-1">`;
            }
        }
        return stars;
    }

    // ── Rendu avis ────────────────────────────────────────
    function renderReviews(reviews) {
        if (reviews.length === 0) {
            homeReviews.innerHTML = '<div class="col-12"><p>Aucun avis disponible.</p></div>';
            return;
        }

        homeReviews.innerHTML = reviews.map(review => `
            <div class="col-12 col-xl-4">
                <article class="home-avis-client">
                    <div class="row">
                        <div class="col-auto col-xl-12 text-info">
                            <p class="mb-0">
                                ${escapeHtml(review.first_name)} ${escapeHtml(review.last_name)}
                            </p>
                        </div>
                        <div class="col-auto col-xl-12">
                            ${renderStars(review.rating)}
                            ${escapeHtml(String(review.rating))}/5
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="align-text-left mb-0">
                                ${escapeHtml(review.comment).replace(/\n/g, '<br>')}
                            </p>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center text-info">
                        <hr class="separator">
                        <div class="col-auto">
                            <p class="mb-0">Il y a ${escapeHtml(review.since)}</p>
                        </div>
                        <div class="col-auto">
                            <a href="/menus-v2/${review.menu_id}">Voir le menu</a>
                        </div>
                    </div>
                </article>
            </div>`).join('');
    }

    // ── Chargement contenus ───────────────────────────────
    async function loadContents() {
        const response = await fetch('/api/home/contents');
        const contents = await response.json();

        if (contents[0]) {
            homeIntro.innerHTML = escapeHtml(contents[0].content).replace(/\n/g, '<br>');
        }
        if (contents[1]) {
            homeTeam.innerHTML = escapeHtml(contents[1].content).replace(/\n/g, '<br>');
        }
    }

    // ── Chargement avis ───────────────────────────────────
    async function loadReviews() {
        const response = await fetch('/api/home/reviews');
        const reviews = await response.json();
        renderReviews(reviews);
    }

    // ── Initialisation ────────────────────────────────────
    Promise.all([loadContents(), loadReviews()]);
}