function initStep3() {

    const nbPersonsInput = document.getElementById('nb_persons');
    const nbDisplay = document.getElementById('nb-display');
    const pricePerPersonDisplay = document.getElementById('price-per-person-display');
    const menuPriceCell = document.getElementById('menu-price');
    const discountCell = document.getElementById('discount-price');
    const totalCell = document.getElementById('total-price');
    const submitBtn = document.getElementById('btn-submit');
    const minPersonsWarning = document.getElementById('min-persons-warning');
    const nbPersonsFeedback = document.getElementById('nb-persons-feedback');

    let pricePerPerson = 0;
    let minPersons = 0;

    // ── Récupère le menu sélectionné en session via l'API ─
    // On récupère le menu_id depuis la session via un endpoint dédié
    fetch('/api/commande/session-step2')
        .then(r => r.json())
        .then(data => {
            if (!data.menu_id) {
                window.location.href = '/commande/etape-2-v2';
                return;
            }
            return fetch(`/api/menus/${data.menu_id}`);
        })
        .then(r => r.json())
        .then(menu => {
            pricePerPerson = parseFloat(menu.price_per_person);
            minPersons = parseInt(menu.min_persons);

            // Met à jour l'affichage
            minPersonsWarning.textContent = `Le menu sélectionné est prévu pour ${minPersons} personnes minimum`;
            pricePerPersonDisplay.textContent = pricePerPerson;
            nbPersonsInput.min = minPersons;
            nbPersonsInput.value = minPersons;
            nbPersonsFeedback.textContent = `Minimum ${minPersons} personnes.`;

            calculatePrices();
            updateSubmitBtn();
        });

    // ── Calcul des prix ───────────────────────────────────
    function calculatePrices() {
        const nbPersons = parseInt(nbPersonsInput.value) || 0;
        const menuPrice = pricePerPerson * nbPersons;
        const discount  = nbPersons >= minPersons + 5 ? menuPrice * 0.1 : 0;
        const total = menuPrice - discount;

        nbDisplay.textContent = nbPersons;
        menuPriceCell.textContent = menuPrice.toFixed(2) + ' €';
        discountCell.textContent = discount > 0 ? '- ' + discount.toFixed(2) + ' €' : '0 €';
        totalCell.innerHTML = '<strong>' + total.toFixed(2) + ' €</strong>';
    }

    // ── Validation ────────────────────────────────────────
    function setValid(input){ input.classList.remove('is-invalid'); input.classList.add('is-valid'); }
    function setInvalid(input){ input.classList.remove('is-valid'); input.classList.add('is-invalid'); }

    function updateSubmitBtn() {
        submitBtn.disabled = parseInt(nbPersonsInput.value) < minPersons;
    }

    nbPersonsInput.addEventListener('input', function() {
        parseInt(this.value) >= minPersons ? setValid(this) : setInvalid(this);
        calculatePrices();
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('order3-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('nb_persons', nbPersonsInput.value);

        try {
            const response = await fetch('/api/commande/etape-3', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.success) window.location.href = data.redirect;
        } catch (error) {
            console.error('Erreur étape 3 :', error);
        }
    });

    submitBtn.disabled = true;
}

// OLD
//document.addEventListener('DOMContentLoaded', function() {
//    const nbPersonsInput = document.getElementById('nb_persons');
//    const nbDispplay = document.getElementById('nb-display');
//    const menuPriceCell = document.getElementById('menu-price');
//    const discountCell = document.getElementById('discount-price');
//    const totalCell = document.getElementById('total-price');
//    const submitBtn = document.getElementById('btn-submit');
//
//    function calculatePrices() {
//        const nbPersons = parseInt(nbPersonsInput.value) || 0;
//
//        //Prix du menu
//        const menuPrice = pricePerPerson * nbPersons;
//
//        // Déduction 10% si nb_persons >= min_persons + 5
//        const discount = nbPersons >= minPersons + 5
//            ? menuPrice * 0.1
//            : 0;
//
//        // Total
//        const total = menuPrice - discount;
//
//        // Mise a jour de l'affichage
//        nbDispplay.textContent = nbPersons;
//        menuPriceCell.textContent = menuPrice.toFixed(2) + ' €';
//        discountCell.textContent = discount > 0
//            ? '- ' + discount.toFixed(2) + ' €'
//            : '0 €'
//        totalCell.innerHTML = '<strong>' + total.toFixed(2) + ' €</strong>';
//    }
//
//    // Règles de validation
//    const rules = {
//        nbPersons: {
//            validate: (val) => parseInt(val) >= minPersons
//        }
//    };
//
//    function setInvalid(input) {
//        input.classList.remove('is-valid');
//        input.classList.add('is-invalid');
//    }
//
//    function setValid(input) {
//        input.classList.remove('is-invalid');
//        input.classList.add('is-valid');
//    }
//
//    function updateSubmitBtn() {
//        submitBtn.disabled = !rules.nbPersons.validate(nbPersonsInput.value);
//    }
//
//    // Événement
//    nbPersonsInput.addEventListener('input', function() {
//        if (rules.nbPersons.validate(this.value)) {
//            setValid(this);
//        } else {
//            setInvalid(this);
//        }
//        calculatePrices();
//        updateSubmitBtn();
//    });
//
//    // Initialisation
//    calculatePrices();
//    updateSubmitBtn();
//
//});