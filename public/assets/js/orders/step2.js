document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('btn-submit');
    const menu_idSelect = document.getElementById('menu_id');


    //Règles de validation
    const rules = {
        menu:{
            validate: (val) => val !== '' && val !== 'default'
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
            rules.menu.validate(menu_idSelect.value);

            submitBtn.disabled = !allValid;
    }

    // ── Validation initiale des champs pré-remplis ────────
    function validatePrefilledFields() {
        const fields = [
            { input: menu_idSelect,     rule: rules.menu },
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtn();
    }

    //Evenements
    menu_idSelect.addEventListener('input', function() {
        validateField(this, rules.menu);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;
    validatePrefilledFields();

});