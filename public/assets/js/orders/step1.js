document.addEventListener('DOMContentLoaded', function() {

    // ── CHOIX DE LA DATE ET L'HEURE DE LIVRAISON ──────────────
    const lastNameInput = document.getElementById('last_name');
    const firstNameInput = document.getElementById('first_name');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const streetNumberInput = document.getElementById('street_number');
    const streetTypeInput = document.getElementById('street_type');
    const streetNameInput = document.getElementById('street_name');
    const zipCodeInput = document.getElementById('zip_code');
    const cityInput = document.getElementById('city');
    const countryInput = document.getElementById('country');
    const submitBtn = document.getElementById('btn-submit');
    const dateInput = document.getElementById('date_livraison');
    const timeSelect = document.getElementById('delivery_time');


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
    timeSelect.disabled = true;
    
    dateInput.addEventListener('change', function() {
        // Reset du select
        timeSelect.innerHTML = '<option value="">-- Choisir un créneau --</option>';
        timeSelect.disabled  = true;
    
        if (this.value) {
            updateTimeSlots(this.value);
        }
    });

    function updateTimeSlots(dateStr) {
        timeSelect.innerHTML = '';
        timeSelect.disabled  = true;

        if (!dateStr) {
            timeSelect.innerHTML = '<option value="">-- Choisissez d\'abord une date --</option>';
            return;
        }

        // Récupérer le jour de la semaine (0=Dimanche, 6=Samedi)
        const date    = new Date(dateStr + 'T00:00:00');
        const dayOfWeek = date.getDay();
        

        // ← Vérification date passée ou aujourd'hui
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (date <= today) {
            timeSelect.innerHTML = '<option value="">-- Créneaux indisponibles --</option>';
            timeSelect.disabled  = true;
            return;
        }

        const schedule = schedules[dayOfWeek];

        if (!schedule) {
            timeSelect.innerHTML = '<option value="">-- Créneaux indisponibles--</option>';
            timeSelect.disabled  = true;
            return;
        }

        timeSelect.disabled = false;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Choisir un créneau --';
        timeSelect.appendChild(defaultOption);

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
                timeSelect.appendChild(option);
            }
        });
    }

    dateInput.addEventListener('change', function() {
        updateTimeSlots(this.value);
    });

    // Initialiser si une date est déjà sélectionnée
    if (dateInput.value) {
        updateTimeSlots(dateInput.value);
    }


    //Règles de validation
    const rules = {
        lastName: {
            validate: (val) => val.trim().length >= 1
        },
        firstName: {
            validate: (val) => val.trim().length >= 1
        },
        phone: {
            validate: (val) => /^[0-9]{10}$/.test(val.trim())
        },
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
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
            rules.lastName.validate(lastNameInput.value) &&
            rules.firstName.validate(firstNameInput.value) &&
            rules.phone.validate(phoneInput.value) &&
            rules.email.validate(emailInput.value) &&
            rules.streetNumber.validate(streetNumberInput.value) &&
            rules.streetType.validate(streetTypeInput.value) &&
            rules.streetName.validate(streetNameInput.value) &&
            rules.zipCode.validate(zipCodeInput.value) &&
            rules.city.validate(cityInput.value) &&
            rules.country.validate(countryInput.value) &&
            rules.date.validate(dateInput.value) &&
            rules.time.validate(timeSelect.value);

            submitBtn.disabled = !allValid;
    }

    // ── Validation initiale des champs pré-remplis ────────
    function validatePrefilledFields() {
        const fields = [
            { input: lastNameInput,     rule: rules.lastName },
            { input: firstNameInput,    rule: rules.firstName },
            { input: phoneInput,        rule: rules.phone },
            { input: emailInput,        rule: rules.email },
            { input: streetNumberInput, rule: rules.streetNumber },
            { input: streetTypeInput,   rule: rules.streetType },
            { input: streetNameInput,   rule: rules.streetName },
            { input: zipCodeInput,      rule: rules.zipCode },
            { input: cityInput,         rule: rules.city },
            { input: countryInput,      rule: rules.country },
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtn();
    }

    //Evenements
    lastNameInput.addEventListener('input', function() {
        validateField(this, rules.lastName);
        updateSubmitBtn();
    });

    firstNameInput.addEventListener('input', function() {
        validateField(this, rules.firstName);
        updateSubmitBtn();
    });

    phoneInput.addEventListener('input', function() {
        validateField(this, rules.phone);
        updateSubmitBtn();
    });

    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

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
            validateField(dateInput, rules.date);
            updateTimeSlots(dateStr);
            updateSubmitBtn();
        }
    });
    
    // Déclenché au changement du select
    timeSelect.addEventListener('change', function() {
        validateField(this, rules.time);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;
    validatePrefilledFields();

});