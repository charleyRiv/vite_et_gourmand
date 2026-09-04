document.addEventListener('DOMContentLoaded', function() {

    // ── Références ────────────────────────────────────────
    const dateLivraisonInput = document.getElementById('date_livraison');
    const heureLivraisonInput = document.getElementById('heure_livraison');
    const streetNumberInput = document.getElementById('street_number');
    const streetTypeInput = document.getElementById('street_type');
    const streetNameInput = document.getElementById('street_name');
    const zipCodeInput = document.getElementById('zip_code');
    const cityInput = document.getElementById('city');
    const countryInput = document.getElementById('country');
    const menuInput = document.getElementById('menu_id');
    const nbPersonsInput = document.getElementById('nb_persons');
    const submitBtn = document.getElementById('btn-submit');

    // ── Flatpickr ─────────────────────────────────────────
    flatpickr('#date_livraison', {
        minDate: new Date().fp_incr(1), // ← méthode native Flatpickr pour demain
        locale: flatpickr.l10ns.fr,     // ← objet locale
        disable: [
            function(date) {
                return date.getDay() === 0 || date.getDay() === 4; // Dimanche et Jeudi
            }
        ],
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            // Ajoute un style inline sur les jours désactivés
            if (dayElem.classList.contains('disabled')) {
                dayElem.style.opacity = '0.3';
                dayElem.style.textDecoration = 'line-through';
                dayElem.style.cursor = 'not-allowed';
            }
        },
        dateFormat: 'Y-m-d',            // ← format de la valeur envoyée en POST
        onChange: function(selectedDates, dateStr) {
            validateField(dateInput, rules.date);
            updateTimeSlots(dateStr);
            updateSubmitBtn();
        }
    });

    // Horaires par jour de la semaine
    const schedules = {
        0: null,                        // Dimanche - fermé
        1: [//Lundi
            { start: '12:00', end: '15:00' },
            { start: '18:00', end: '23:00' }
        ],
        2: [//Mardi
            { start: '12:00', end: '15:00' },
            { start: '18:00', end: '23:00' }
        ],
        3: [{ start: '18:00', end: '23:00' }], // Mercredi
        4: null, // Jeudi
        5: [//Vendredi
            { start: '12:00', end: '15:00' },
            { start: '18:00', end: '23:00' }
        ],
        6: [//Samedi
            { start: '12:00', end: '15:00' },
            { start: '18:00', end: '23:00' }
        ], 
    };

    // Initialisation - désactiver le select au chargement
    heureLivraisonInput.disabled = true;
    
    dateLivraisonInput.addEventListener('change', function() {
        // Reset du select
        heureLivraisonInput.innerHTML = '<option value="">-- Choisir un créneau --</option>';
        heureLivraisonInput.disabled  = true;
    
        if (this.value) {
            updateTimeSlots(this.value);
        }
    });

    function updateTimeSlots(dateStr) {
        heureLivraisonInput.innerHTML = '';
        heureLivraisonInput.disabled  = true;

        if (!dateStr) {
            heureLivraisonInput.innerHTML = '<option value="">-- Choisissez d\'abord une date --</option>';
            return;
        }

        // Récupérer le jour de la semaine (0=Dimanche, 6=Samedi)
        const date    = new Date(dateStr + 'T00:00:00');
        const dayOfWeek = date.getDay();
        

        // ← Vérification date passée ou aujourd'hui
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (date <= today) {
            heureLivraisonInput.innerHTML = '<option value="">-- Créneaux indisponibles --</option>';
            heureLivraisonInput.disabled  = true;
            return;
        }

        const schedule = schedules[dayOfWeek];

        if (!schedule) {
            heureLivraisonInput.innerHTML = '<option value="">-- Créneaux indisponibles--</option>';
            heureLivraisonInput.disabled  = true;
            return;
        }

        heureLivraisonInput.disabled = false;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Choisir un créneau --';
        heureLivraisonInput.appendChild(defaultOption);

        // Boucle sur chaque tranche horaire
        schedule.forEach(function(slot) {
            const start = slot.start.split(':');
            const end   = slot.end.split(':');

            let startMinutes = parseInt(start[0]) * 60 + parseInt(start[1]);
            let endMinutes   = parseInt(end[0])   * 60 + parseInt(end[1]);

            for (let minutes = startMinutes; minutes <= endMinutes; minutes += 30) {
                const hours  = Math.floor(minutes / 60).toString().padStart(2, '0');
                const mins   = (minutes % 60).toString().padStart(2, '0');

                const option = document.createElement('option');
                option.value       = `${hours}:${mins}`;
                option.textContent = `${hours}h${mins}`;
                heureLivraisonInput.appendChild(option);
            }
        });
    }

    dateLivraisonInput.addEventListener('change', function() {
        updateTimeSlots(this.value);
    });

    // Initialiser si une date est déjà sélectionnée
    if (dateLivraisonInput.value) {
        updateTimeSlots(dateLivraisonInput.value);
    }

    // ── Validation ────────────────────────────────────────
    const rules = {
        date: {
            validate: (val) => {
                if (!val) return false;

                const date      = new Date(val + 'T00:00:00');
                const dayOfWeek = date.getDay();
                const tomorrow  = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(0, 0, 0, 0);

                // Date dans le futur
                if (date < tomorrow) return false;

                // Pas jeudi ni dimanche
                if (dayOfWeek === 0 || dayOfWeek === 4) return false;

                return true;
            }
        },
        time: {
            validate: (val) => val !== '' && val !== null && val !== undefined
        },
        streetNumber: {
            validate: (val) => /^[0-9]+$/.test(val.trim())
        },
        streetType: {
            validate: (val) => {
                const types = ['rue', 'avenue', 'boulevard', 'allée', 'impasse', 
                                'route', 'chemin', 'place', 'square', 'passage',
                                'cité', 'villa', 'résidence', 'voie', 'rond-point'];
                return types.includes(val.trim().toLowerCase());
            }
        },
        streetName: {
            validate: (val) => val.trim().length >= 1
        },
        zipCode: {
            validate: (val) => /^[0-9]{5}$/.test(val.trim())
        },
        city: {
            validate: (val) => val.trim().length >= 1
        },
        country: {
            validate: (val) => val.trim().length >= 1
        },
        menu : {
            validate: (val) => val !== '' && val !== 'default'
        },
        nbPersons: {
            validate: (val) => parseInt(val) >= minPersons
        }
    };

    //Fonctions utilitaires
    function setValid(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    function setInvalid(input) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }

    function validateField(input, rule) {
        if (rule.validate(input.value)) {
            setValid(input);
            return true;
        } else {
            setInvalid(input, rule.message);
            return false;
        }
    }

    //Mise à jour du bouton submit
    function updateSubmitBtn() {
        const allValid =
            rules.date.validate(dateLivraisonInput.value) &&
            rules.time.validate(heureLivraisonInput.value) &&
            rules.streetNumber.validate(streetNumberInput.value) &&
            rules.streetType.validate(streetTypeInput.value) &&
            rules.streetName.validate(streetNameInput.value) &&
            rules.zipCode.validate(zipCodeInput.value) &&
            rules.city.validate(cityInput.value) &&
            rules.country.validate(countryInput.value) &&
            rules.menu.validate(menuInput.value) &&
            rules.nbPersons.validate(nbPersonsInput.value);

            submitBtn.disabled = !allValid;
    }

    // ── Validation initiale des champs pré-remplis ────────
    function validatePrefilledFields() {
        const fields = [
            { input: dateLivraisonInput, rule: rules.date },
            { input: heureLivraisonInput, rule: rules.time },
            { input: streetNumberInput, rule: rules.streetNumber },
            { input: streetTypeInput, rule: rules.streetType },
            { input: streetNameInput, rule: rules.streetName },
            { input: zipCodeInput, rule: rules.zipCode },
            { input: cityInput, rule: rules.city },
            { input: countryInput, rule: rules.country },
            { input: menuInput, rule: rules.menu },
            { input: nbPersonsInput, rule: rules.nbPersons },
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtn();
    }

    //Evenements
    streetNumberInput.addEventListener('input', function() {
        validateField(this, rules.streetNumber);
        updateSubmitBtn();
    });

    streetTypeInput.addEventListener('input', function() {
        validateField(this, rules.streetType);
        updateSubmitBtn();
    });

    streetNameInput.addEventListener('input', function() {
        validateField(this, rules.streetName);
        updateSubmitBtn();
    });

    zipCodeInput.addEventListener('input', function() {
        validateField(this, rules.zipCode);
        updateSubmitBtn();
    });

    cityInput.addEventListener('input', function() {
        validateField(this, rules.city);
        updateSubmitBtn();
    });

    countryInput.addEventListener('input', function() {
        validateField(this, rules.country);
        updateSubmitBtn();
    });

    // Déclenché par Flatpickr
    flatpickr('#date_livraison', {
        // ...
        onChange: function(selectedDates, dateStr) {
            validateField(dateLivraisonInput, rules.date);
            updateTimeSlots(dateStr);
            updateSubmitBtn();
        }
    });
    
    // Déclenché au changement du select
    heureLivraisonInput.addEventListener('change', function() {
        validateField(this, rules.time);
        updateSubmitBtn();
    });

    //Fonction de calcul des frais de livraison via API
    async function fetchDeliveryFees() {
        const formData = new FormData();
        formData.append('street_number', document.getElementById('street_number').value);
        formData.append('street_type', document.getElementById('street_type').value);
        formData.append('street_name', document.getElementById('street_name').value);
        formData.append('zip_code', document.getElementById('zip_code').value);
        formData.append('city', document.getElementById('city').value);
        formData.append('country', document.getElementById('country').value);

        try {
            const response = await fetch('/api/delivery-fees', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erreur calcul livraison', error);
            return { distance: 0, delivery_fees: 0};
        }
        
    }

    // ── Variables menu - initialisées depuis le menu sélectionné ──
    let pricePerPerson = parseFloat(menusData[menuInput.value]?.price_per_person) || 0;
    let minPersons     = parseInt(menusData[menuInput.value]?.min_persons) || 0;

    // Mettre à jour quand le menu change
    menuInput.addEventListener('change', function() {
        const selectedMenu = menusData[this.value];
        if (selectedMenu) {
            pricePerPerson = parseFloat(selectedMenu.price_per_person);
            minPersons     = parseInt(selectedMenu.min_persons);

            //Mise à jour de l'affichage
            document.getElementById('min-persons-display').textContent = minPersons;
            document.getElementById('price-per-person-display').textContent = pricePerPerson;
        }
        calculatePrices();
    });

    // ── Calcul des prix ───────────────────────────────────
    async function calculatePrices() {
        const nbPersons = parseInt(document.getElementById('nb_persons').value) || 0;

        // Prix menu
        const menuPrice = pricePerPerson * nbPersons;

        //Réduction
        const discount =  nbPersons >= minPersons + 5 ?  menuPrice * 0.1 : 0;

        //Frais de livraison
        const deliveryData = await fetchDeliveryFees();
        const deliveryFees = deliveryData.delivery_fees;
        const distance = deliveryData.distance;
        const city = deliveryData.city;

        //Total
        const total = menuPrice - discount + deliveryFees;

        //Mise à jour de l'affichage
        document.getElementById('nb-display').textContent    = nbPersons;
        document.getElementById('menu-price').textContent    = menuPrice.toFixed(2) + ' €';
        document.getElementById('discount-price').textContent = discount > 0
            ? '- ' + discount.toFixed(2) + ' €'
            : '0 €';
        
        if (deliveryFees > 0) {
        document.getElementById('delivery-fees').textContent   = '+ ' + deliveryFees.toFixed(2) + ' €';
        document.getElementById('delivery-detail').textContent = city + ' - hors Bordeaux (5€ + 0,59€ x ' + distance + ' km)';
        } else {
            document.getElementById('delivery-fees').textContent   = 'offert';
            document.getElementById('delivery-detail').textContent = 'Bordeaux';
        }

        document.getElementById('total-price').innerHTML = '<strong>' + total.toFixed(2) + ' €</strong>';
    }

    // Déclencher le recalcul quand l'adresse ou le nb de personnes change
    ['delivery_street_number', 'delivery_street_type', 'delivery_street_name',
    'delivery_zip_code', 'delivery_city', 'delivery_country', 'nb_persons'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', calculatePrices);
    });


    // ── Initialisation ────────────────────────────────────
    submitBtn.disabled = true;
    validatePrefilledFields();
    calculatePrices();

});