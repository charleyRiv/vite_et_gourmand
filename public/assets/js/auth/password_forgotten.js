document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('btn-submit');

    //Règles de validation
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message: 'Veuillez saisir une adresse mail valide.'
        }
    };

    // ── Validation initiale des champs pré-remplis ────────
    function validatePrefilledFields() {
        const fields = [
            { input: emailInput,        rule: rules.email },
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtn();
    }

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
            rules.email.validate(emailInput.value);

            submitBtn.disabled = !allValid;
    }

    //Evenements
    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;
    validatePrefilledFields();

});