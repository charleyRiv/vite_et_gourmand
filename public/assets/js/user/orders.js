document.addEventListener('DOMContentLoaded', function() {
    const cancelBtn = document.getElementById('btn-cancel');
    const reasonInput = document.getElementById('reason');
    const submitBtn = document.getElementById('btn-submit');
    const cancelForm = document.getElementById('cancel-form');
    const keepBtn = document.getElementById('btn-keep');


    //Gestion apparition formulaire d'annulation



    //Règles de validation du formulaire
    const rules = { 
        reason: { 
            validate: (val) => val.trim().length > 1
        }
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

    function unhideField(input) {
        input.classList.remove('d-none');
    }

    function hideField(input) {
        input.classList.add('d-none')
    }

    //Mise à jour du bouton submit
    function updateSubmitBtn() {
        const allValid =
            rules.reason.validate(reasonInput.value);

            submitBtn.disabled = !allValid;
    }

    //Evenements
    reasonInput.addEventListener('input', function() {
        validateField(this, rules.reason);
        updateSubmitBtn();
    });

    cancelBtn.addEventListener('click', function() {
        unhideField(cancelForm);
        hideField(this);
        unhideField(keepBtn);

    });

    keepBtn.addEventListener('click', function() {
        hideField(cancelForm);
        hideField(this);
        unhideField(cancelBtn);
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;
    

});