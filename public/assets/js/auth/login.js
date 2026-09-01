document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const passwordInput = document.getElementById('password');
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('btn-submit');

    //Règles de validation
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message: 'Veuillez saisir une adresse mail valide.'
        },
        password: {
            validate: (val) => val.trim().length >= 8,
            message: 'Le mot de passe doit contenir au moins 8 caractères.'
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
            rules.email.validate(emailInput.value) &&
            rules.password.validate(passwordInput.value);

            submitBtn.disabled = !allValid;
    }

    //Evenements
    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    passwordInput.addEventListener('input', function() {
        validateField(this, rules.password);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;

});