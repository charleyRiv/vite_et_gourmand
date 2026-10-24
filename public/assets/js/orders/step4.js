function initStep4() {

    const orderContent = document.getElementById('order4-content');
    const cgvInput = document.getElementById('cgv');
    const conditionsInput = document.getElementById('conditions');
    const submitBtn = document.getElementById('btn-submit');

    // ── Utilitaire XSS ───────────────────────────────────
    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // ── Formatage date ────────────────────────────────────
    function formatDate(dateStr) {
        if (!dateStr) return '--';
        const date = new Date(dateStr + 'T00:00:00');
        return date.toLocaleDateString('fr-FR', {
            weekday: 'long', year: 'numeric',
            month: 'long', day: 'numeric'
        });
    }

    // ── Chargement des données de session ─────────────────
    async function loadOrderSummary() {
        try {
            const sessionRes = await fetch('/api/commande/session-step4');
            const session = await sessionRes.json();

            if (session.error) {
                window.location.href = '/commande/etape-1-v2';
                return;
            }

            const { step1, step2, step3 } = session;

            // Récupère le menu
            const menuRes = await fetch(`/api/menus/${step2.menu_id}`);
            const menu = await menuRes.json();

            // Calcule les prix
            const nbPersons = parseInt(step3.nb_persons);
            const menuPrice = parseFloat(menu.price_per_person) * nbPersons;
            const discount = nbPersons >= menu.min_persons + 5 ? menuPrice * 0.1 : 0;

            // Calcule les frais de livraison
            const feesFormData = new FormData();
            feesFormData.append('street_number', step1.street_number);
            feesFormData.append('street_type', step1.street_type);
            feesFormData.append('street_name', step1.street_name);
            feesFormData.append('zip_code', step1.zip_code);
            feesFormData.append('city', step1.city);
            feesFormData.append('country', step1.country);

            const feesRes = await fetch('/api/delivery-fees', { method: 'POST', body: feesFormData });
            const feesData = await feesRes.json();

            const deliveryFees = feesData.delivery_fees ?? 0;
            const distance = feesData.distance ?? 0;
            const total = menuPrice - discount + deliveryFees;

            // Récupère les plats
            const dishes = menu.dishes || [];

            // ── Rendu du récapitulatif ─────────────────────
            orderContent.innerHTML = `
                <fieldset class="order4-delivery">
                    <legend>Informations de livraison</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr><td>Nom du client</td>
                                <td>${escapeHtml(step1.first_name)} ${escapeHtml(step1.last_name)}</td></tr>
                            <tr><td>Email</td>
                                <td>${escapeHtml(step1.email)}</td></tr>
                            <tr><td>Téléphone</td>
                                <td>${escapeHtml(step1.phone)}</td></tr>
                            <tr><td>Adresse</td>
                                <td>${escapeHtml(step1.street_number)} ${escapeHtml(step1.street_type)} ${escapeHtml(step1.street_name)}<br>
                                    ${escapeHtml(step1.zip_code)} ${escapeHtml(step1.city)}, ${escapeHtml(step1.country)}</td></tr>
                            <tr><td>Date de livraison</td>
                                <td>${formatDate(step1.date_livraison)}</td></tr>
                            <tr><td>Heure de livraison</td>
                                <td>${escapeHtml(step1.heure_livraison)}</td></tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order4-menu">
                    <legend>Votre menu</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr><td>Menu choisi</td><td>${escapeHtml(menu.title)}</td></tr>
                            <tr><td>Thème</td><td>${escapeHtml(menu.theme)}</td></tr>
                            <tr><td>Régime</td><td>${escapeHtml(menu.diet)}</td></tr>
                            <tr><td>Composition</td><td></td></tr>
                            ${dishes.map(d => `
                            <tr><td class="detail">${escapeHtml(d.dish_type)}</td>
                                <td>${escapeHtml(d.title)}</td></tr>`).join('')}
                            <tr><td>Nombre de personnes</td><td>${escapeHtml(String(nbPersons))}</td></tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order4-conditions">
                    <legend>Conditions importantes de ce menu</legend>
                    <hr>
                    <p>${escapeHtml(menu.conditions)}</p>
                </fieldset>

                <fieldset class="order4-price">
                    <legend>Détail du prix</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr><td>Prix par personne</td>
                                <td>${escapeHtml(String(menu.price_per_person))} €</td></tr>
                            <tr><td>Nombre de personnes</td>
                                <td>x ${escapeHtml(String(nbPersons))}</td></tr>
                            <tr><td></td><td>_________</td></tr>
                            <tr><td>Prix du menu</td>
                                <td>${menuPrice.toFixed(2)} €</td></tr>
                            <tr><td>Réduction 10%<br>
                                    <small>(${nbPersons} pers. > ${menu.min_persons} min + 5)</small></td>
                                <td>- ${discount.toFixed(2)} €</td></tr>
                            <tr>
                                ${deliveryFees > 0
                                    ? `<td>Frais de livraison<br>
                                        <small>${escapeHtml(step1.city)} - hors Bordeaux<br>
                                        (5€ + 0,59€ x ${distance} km)</small></td>
                                        <td>+ ${deliveryFees.toFixed(2)} €</td>`
                                    : `<td>Frais de livraison<br><small>Bordeaux</small></td>
                                        <td>offert</td>`
                                }
                            </tr>
                            <tr><td></td><td>_________</td></tr>
                        </tbody>
                        <tfoot>
                            <tr><td><strong>Total TTC</strong></td>
                                <td><strong>${total.toFixed(2)} €</strong></td></tr>
                        </tfoot>
                    </table>
                    <hr>
                    <small>Le prix total est calculé sur la base des informations saisies.
                        Il sera confirmé dans votre email de confirmation.</small>
                </fieldset>`;

        } catch (error) {
            orderContent.innerHTML = '<p class="text-danger">Erreur lors du chargement. Veuillez réessayer.</p>';
        }
    }

    // ── Validation CGV ────────────────────────────────────
    function setValid(input){ input.classList.remove('is-invalid'); input.classList.add('is-valid'); }
    function setInvalid(input){ input.classList.remove('is-valid'); input.classList.add('is-invalid'); }

    function updateSubmitBtn() {
        submitBtn.disabled = !(cgvInput.checked && conditionsInput.checked);
    }

    cgvInput.addEventListener('change', function() {
        this.checked ? setValid(this) : setInvalid(this);
        updateSubmitBtn();
    });

    conditionsInput.addEventListener('change', function() {
        this.checked ? setValid(this) : setInvalid(this);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('order4-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('cgv', cgvInput.checked ? '1' : '');
        formData.append('conditions', conditionsInput.checked ? '1' : '');

        try {
            const response = await fetch('/api/commande/etape-4', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            console.log('Réponse brute:', text);

            const data = JSON.parse(text);
            if (data.success) window.location.href = data.redirect;
            
        } catch (error) {
            console.error('Erreur étape 4 :', error);
        }
    });

    // ── Initialisation ────────────────────────────────────
    submitBtn.disabled = true;
    loadOrderSummary();
}