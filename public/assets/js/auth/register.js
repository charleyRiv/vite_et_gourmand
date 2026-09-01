document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
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
    const passwordInput = document.getElementById('password');
    const passwordConfInput = document.getElementById('password_confirm');
    const consentInput = document.getElementById('consent');
    const submitBtn = document.getElementById('btn-submit');

    //Afficher mot de passe
    const btnEyePassword = document.getElementById('btn-eye-password');
    const iconEyePassword = document.getElementById('icon-eye-password');
    const btnEyePasswordConf = document.getElementById('btn-eye-passwordConf');
    const iconEyePasswordConf = document.getElementById('icon-eye-passwordConf');

    if (btnEyePassword) {
        btnEyePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconEyePassword.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                iconEyePassword.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    if (btnEyePasswordConf) {
        btnEyePasswordConf.addEventListener('click', function() {
            if (passwordConfInput.type === 'password') {
                passwordConfInput.type = 'text';
                iconEyePasswordConf.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordConfInput.type = 'password';
                iconEyePasswordConf.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    //Règles de validation
    const rules = {
        lastName: {
            validate: (val) => val.trim().length > 1
        },
        firstName: {
            validate: (val) => val.trim().length > 1
        },
        phone: {
            validate: (val) => val.trim() === '' || /^[0-9]{10}$/.test(val.trim())
        },
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message: 'Veuillez saisir une adresse mail valide.'
        },
        streetNumber: {
            validate: (val) => val.trim() === '' || /^[0-9]+$/.test(val.trim())
        },
        streetType: {
            validate: (val) => {
                if (val.trim() === '') return true; // optionnel
                const types = ['rue', 'avenue', 'boulevard', 'allée', 'impasse', 
                                'route', 'chemin', 'place', 'square', 'passage',
                                'cité', 'villa', 'résidence', 'voie', 'rond-point'];
                return types.includes(val.trim().toLowerCase());
            }
        },
        streetName: {
            validate: (val) => val.trim() === '' || val.trim().length > 1
        },
        zipCode: {
            validate: (val) => val.trim() === '' || /^[0-9]{5}$/.test(val.trim())
        },
        city: {
            validate: (val) => val.trim() === '' || val.trim().length > 1
        },
        country: {
            validate: (val) => val.trim() === '' || val.trim().length > 1
        },
        password: {
            validate: (val) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/.test(val)
        },
        passwordConf: {
            validate: (val) => val === passwordInput.value
        },
        consent: {
            validate: (val) => consentInput.checked
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
            //rules.phone.validate(phoneInput.value) &&
            rules.email.validate(emailInput.value) &&
            //rules.streetNumber.validate(streetNumberInput.value) &&
            //rules.streetType.validate(streetTypeInput.value) &&
            //rules.streetName.validate(streetNameInput.value) &&
            //rules.zipCode.validate(zipCodeInput.value) &&
            //rules.city.validate(cityInput.value) &&
            //rules.country.validate(countryInput.value) &&
            rules.password.validate(passwordInput.value) &&
            rules.passwordConf.validate(passwordConfInput.value) &&
            rules.consent.validate(consentInput.value);

            submitBtn.disabled = !allValid;
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

    passwordInput.addEventListener('input', function() {
        validateField(this, rules.password);
        // Revalide le confirm si déjà rempli
        if (passwordConfInput.value !== '') {
            validateField(passwordConfInput, rules.passwordConf);
        }
        updateSubmitBtn();
    });

    passwordConfInput.addEventListener('input', function() {
        validateField(this, rules.passwordConf);
        updateSubmitBtn();
    });

    consentInput.addEventListener('change', function() {
        validateField(this, rules.consent);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;

});