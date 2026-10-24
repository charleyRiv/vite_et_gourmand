function initConfirmation() {

    const content = document.getElementById('confirmation-content');

    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(dateStr) {
        if (!dateStr) return '--';
        const date = new Date(dateStr + 'T00:00:00');
        return date.toLocaleDateString('fr-FR', {
            weekday: 'long', year: 'numeric',
            month: 'long', day: 'numeric'
        });
    }

    async function loadConfirmation() {
        try {
            const res = await fetch('/api/commande/confirmation');
            const data = await res.json();

            if (data.error) {
                content.innerHTML = `<p class="text-danger">${escapeHtml(data.error)}</p>`;
                return;
            }

            const { order, menu, dishes, maskedEmail } = data;
            const deliveryFees = parseFloat(order.delivery_fees) ?? 0;

            content.innerHTML = `
                <fieldset class="order-confirmation-delivery">
                    <legend>Informations de livraison</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr><td>Nom du client</td>
                                <td>${escapeHtml(order.delivery_first_name ?? '')} ${escapeHtml(order.delivery_last_name ?? '')}</td></tr>
                            <tr><td>Adresse</td>
                                <td>${escapeHtml(order.delivery_street_number)} ${escapeHtml(order.delivery_street_type)} ${escapeHtml(order.delivery_street_name)}<br>
                                    ${escapeHtml(order.delivery_zip_code)} ${escapeHtml(order.delivery_city)}, ${escapeHtml(order.delivery_country)}</td></tr>
                            <tr><td>Date de livraison</td>
                                <td>${formatDate(order.event_date)}</td></tr>
                            <tr><td>Heure de livraison</td>
                                <td>${escapeHtml(order.delivery_time)}</td></tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order-confirmation-menu">
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
                            <tr><td>Nombre de personnes</td>
                                <td>${escapeHtml(String(order.nb_persons))}</td></tr>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="order-confirmation-conditions">
                    <legend>Conditions importantes de ce menu</legend>
                    <hr>
                    <p>${escapeHtml(menu.conditions)}</p>
                </fieldset>

                <fieldset class="order-confirmation-price">
                    <legend>Détail du prix</legend>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr><td>Prix par personne</td>
                                <td>${escapeHtml(String(menu.price_per_person))} €</td></tr>
                            <tr><td>Nombre de personnes</td>
                                <td>x ${escapeHtml(String(order.nb_persons))}</td></tr>
                            <tr><td></td><td>_________</td></tr>
                            <tr><td>Prix du menu</td>
                                <td>${escapeHtml(String(order.calculated_menu_price))} €</td></tr>
                            <tr><td>Réduction 10%<br>
                                    <small>(${order.nb_persons} pers. > ${menu.min_persons} min + 5)</small></td>
                                <td>- ${escapeHtml(String(order.discount))} €</td></tr>
                            <tr>
                                ${deliveryFees > 0
                                    ? `<td>Frais de livraison<br>
                                        <small>${escapeHtml(order.delivery_city)} - hors Bordeaux</small></td>
                                        <td>+ ${deliveryFees.toFixed(2)} €</td>`
                                    : `<td>Frais de livraison<br><small>Bordeaux</small></td>
                                        <td>offert</td>`
                                }
                            </tr>
                            <tr><td></td><td>_________</td></tr>
                        </tbody>
                        <tfoot>
                            <tr><td><strong>Total TTC</strong></td>
                                <td><strong>${escapeHtml(String(order.total_price))} €</strong></td></tr>
                        </tfoot>
                    </table>
                    <hr>
                    <small>Le prix total est calculé sur la base des informations saisies.
                        Il sera confirmé dans votre email de confirmation.</small>
                </fieldset>

                <div class="col-12">
                    <p>Un mail de confirmation vous a été envoyé à ${escapeHtml(maskedEmail)}</p>
                </div>`;

        } catch (error) {
            content.innerHTML = '<p class="text-danger">Erreur lors du chargement de la confirmation.</p>';
        }
    }

    loadConfirmation();
}