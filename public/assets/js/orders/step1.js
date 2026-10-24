function initStep1() {

    // ── Références DOM ────────────────────────────────────
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
    const dateInput = document.getElementById('date_livraison');
    const timeSelect = document.getElementById('delivery_time');
    const submitBtn = document.getElementById('btn-submit');

    // ── Pré-remplissage depuis l'API ──────────────────────
    fetch('/api/user/profile')
        .then(r => r.json())
        .then(data => {
            if (!data.user) return;
            const u = data.user;
            lastNameInput.value = u.last_name ?? '';
            firstNameInput.value = u.first_name ?? '';
            phoneInput.value = u.phone ?? '';
            emailInput.value = u.email ?? '';
            streetNumberInput.value = u.street_number ?? '';
            streetTypeInput.value = u.street_type ?? '';
            streetNameInput.value = u.street_name ?? '';
            zipCodeInput.value = u.zip_code ?? '';
            cityInput.value = u.city ?? '';
            countryInput.value = u.country ?? '';
            validatePrefilledFields();
        });

    // ── Flatpickr ─────────────────────────────────────────
    flatpickr('#date_livraison', {
        minDate: new Date().fp_incr(1),
        locale: flatpickr.l10ns.fr,
        disable: [
            function(date) {
                return date.getDay() === 0 || date.getDay() === 4;
            }
        ],
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            if (dayElem.classList.contains('disabled')) {
                dayElem.style.opacity = '0.3';
                dayElem.style.textDecoration = 'line-through';
                dayElem.style.cursor = 'not-allowed';
            }
        },
        dateFormat: 'Y-m-d',
        onChange: function(selectedDates, dateStr) {
            validateField(dateInput, rules.date);
            updateTimeSlots(dateStr);
            updateSubmitBtn();
        }
    });

    // ── Créneaux horaires ─────────────────────────────────
    const schedules = {
        0: null,
        1: [{ start: '12:00', end: '15:00' }, { start: '18:00', end: '23:00' }],
        2: [{ start: '12:00', end: '15:00' }, { start: '18:00', end: '23:00' }],
        3: [{ start: '18:00', end: '23:00' }],
        4: null,
        5: [{ start: '12:00', end: '15:00' }, { start: '18:00', end: '23:00' }],
        6: [{ start: '12:00', end: '15:00' }, { start: '18:00', end: '23:00' }],
    };

    timeSelect.disabled = true;

    function updateTimeSlots(dateStr) {
        timeSelect.innerHTML = '';
        timeSelect.disabled = true;

        if (!dateStr) {
            timeSelect.innerHTML = '<option value="">-- Choisissez d\'abord une date --</option>';
            return;
        }

        const date = new Date(dateStr + 'T00:00:00');
        const dayOfWeek = date.getDay();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (date <= today) {
            timeSelect.innerHTML = '<option value="">-- Créneaux indisponibles --</option>';
            return;
        }

        const schedule = schedules[dayOfWeek];

        if (!schedule) {
            timeSelect.innerHTML = '<option value="">-- Créneaux indisponibles --</option>';
            return;
        }

        timeSelect.disabled = false;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Choisir un créneau --';
        timeSelect.appendChild(defaultOption);

        schedule.forEach(function(slot) {
            const start = slot.start.split(':');
            const end  = slot.end.split(':');
            let startMinutes = parseInt(start[0]) * 60 + parseInt(start[1]);
            let endMinutes = parseInt(end[0])   * 60 + parseInt(end[1]);

            for (let minutes = startMinutes; minutes <= endMinutes; minutes += 30) {
                const hours = Math.floor(minutes / 60).toString().padStart(2, '0');
                const mins = (minutes % 60).toString().padStart(2, '0');
                const option = document.createElement('option');
                option.value = `${hours}:${mins}`;
                option.textContent = `${hours}h${mins}`;
                timeSelect.appendChild(option);
            }
        });
    }

    // ── Règles de validation ──────────────────────────────
    const rules = {
        lastName: { validate: (val) => val.trim().length >= 1 },
        firstName: { validate: (val) => val.trim().length >= 1 },
        phone: { validate: (val) => /^[0-9]{10}$/.test(val.trim()) },
        email: { validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()) },
        streetNumber: { validate: (val) => /^[0-9]+$/.test(val.trim()) },
        streetType: { validate: (val) => {
            const types = ['rue', 'avenue', 'boulevard', 'allée', 'impasse',
                        'route', 'chemin', 'place', 'square', 'passage',
                        'cité', 'villa', 'résidence', 'voie', 'rond-point'];
            return types.includes(val.trim().toLowerCase());
        }},
        streetName: { validate: (val) => val.trim().length >= 1 },
        zipCode: { validate: (val) => /^[0-9]{5}$/.test(val.trim()) },
        city: { validate: (val) => val.trim().length >= 1 },
        country: { validate: (val) => val.trim().length >= 1 },
        date: { validate: (val) => {
            if (!val) return false;
            const date = new Date(val + 'T00:00:00');
            const dayOfWeek = date.getDay();
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(0, 0, 0, 0);
            if (date < tomorrow) return false;
            if (dayOfWeek === 0 || dayOfWeek === 4) return false;
            return true;
        }},
        time: { validate: (val) => val !== '' && val !== null && val !== undefined }
    };

    // ── Fonctions utilitaires ─────────────────────────────
    function setValid(input){ input.classList.remove('is-invalid'); input.classList.add('is-valid'); }
    function setInvalid(input){ input.classList.remove('is-valid'); input.classList.add('is-invalid'); }

    function validateField(input, rule) {
        if (rule.validate(input.value)) { setValid(input);   return true; }
        else { setInvalid(input); return false; }
    }

    function updateSubmitBtn() {
        submitBtn.disabled = !(
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
            rules.time.validate(timeSelect.value)
        );
    }

    function validatePrefilledFields() {
        [
            { input: lastNameInput, rule: rules.lastName },
            { input: firstNameInput, rule: rules.firstName },
            { input: phoneInput, rule: rules.phone },
            { input: emailInput, rule: rules.email },
            { input: streetNumberInput, rule: rules.streetNumber },
            { input: streetTypeInput, rule: rules.streetType },
            { input: streetNameInput, rule: rules.streetName },
            { input: zipCodeInput, rule: rules.zipCode },
            { input: cityInput, rule: rules.city },
            { input: countryInput, rule: rules.country },
        ].forEach(({ input, rule }) => {
            if (input.value.trim() !== '') validateField(input, rule);
        });
        updateSubmitBtn();
    }

    // ── Événements ───────────────────────────────────────
    [
        [lastNameInput, rules.lastName],
        [firstNameInput, rules.firstName],
        [phoneInput, rules.phone],
        [emailInput, rules.email],
        [streetNumberInput, rules.streetNumber],
        [streetTypeInput, rules.streetType],
        [streetNameInput, rules.streetName],
        [zipCodeInput, rules.zipCode],
        [cityInput, rules.city],
        [countryInput, rules.country],
    ].forEach(([input, rule]) => {
        input.addEventListener('input', function() {
            validateField(this, rule);
            updateSubmitBtn();
        });
    });

    timeSelect.addEventListener('change', function() {
        validateField(this, rules.time);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('order1-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const csrfRes = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData(this);
        formData.append('csrf_token', csrfData.token);

        try {
            const response = await fetch('/api/commande/etape-1', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                window.location.href = data.redirect;
            }
        } catch (error) {
            console.error('Erreur étape 1 :', error);
        }
    });

    // ── État initial ──────────────────────────────────────
    submitBtn.disabled = true;
}