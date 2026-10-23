
async function loadLayouts(heroTitle = '', heroImage = '') {
    
    // ── Header ────────────────────────────────────────────
    const headerRes = await fetch('/layouts/header');
    const headerHtml = await headerRes.text();
    document.getElementById('app-header').innerHTML = headerHtml;

    // Lien actif dans la navbar
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) {
            link.classList.add('active');
        }
    });

    // ── Auth dans la navbar ───────────────────────────────
    const sessionRes = await fetch('/api/session');
    const session = await sessionRes.json();
    const navAuth = document.getElementById('nav-auth');

    if (session.isLoggedIn) {
        const dashboardUrl = session.role === 'administrateur' ? '/admin'
                           : session.role === 'employe' ? '/employe'
                           : '/mon-espace';

        navAuth.innerHTML = `
            <li class="nav-item">
                <a class="nav-link" href="${dashboardUrl}">
                    <i class="bi bi-person-fill"></i>
                </a>
            </li>
            <li class="nav-item">
                <form action="/deconnexion" method="post" id="logout-form">
                    <input type="hidden" name="csrf_token" id="csrf-token-logout">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Déconnexion</button>
                </form>
            </li>`;

        // Récupère le token CSRF pour le formulaire de déconnexion
        const csrfRes = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();
        document.getElementById('csrf-token-logout').value = csrfData.token;

    } else {
        navAuth.innerHTML = `
            <li class="nav-item">
                <a class="nav-link" href="/connexion-v2">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary btn-sm" href="/inscription-v2">S'inscrire</a>
            </li>`;
    }

    // ── Hero ──────────────────────────────────────────────
    if (heroTitle || heroImage) {
        const heroRes = await fetch('/layouts/hero');
        const heroHtml = await heroRes.text();
        document.getElementById('app-hero').innerHTML = heroHtml;

        if (heroTitle) document.getElementById('hero-title').textContent = heroTitle;
        if (heroImage) document.getElementById('hero').style.setProperty('--hero-bg', `url('${heroImage}')`);
    }

    // ── Footer ────────────────────────────────────────────
    const footerRes = await fetch('/layouts/footer');
    const footerHtml = await footerRes.text();
    document.getElementById('app-footer').innerHTML = footerHtml;

    // Charge les horaires dans le footer
    const scheduleRes  = await fetch('/api/schedule');
    const scheduleData = await scheduleRes.json();
    const scheduleEl = document.getElementById('footer-schedule');
    if (scheduleEl && scheduleData.content) {
        scheduleEl.innerHTML = scheduleData.content.replace(/\n/g, '<br>');
    }
}