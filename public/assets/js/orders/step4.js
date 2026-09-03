document.addEventListener('DOMContentLoaded', function() {
    const cgvInput = document.getElementById('cgv');
    const conditionsInput = document.getElementById('conditions');
    const submitBtn = document.getElementById('btn-submit');

    // Règles de validation
    const rules = {
        cgv: {
            validate: (val) => cgvInput.checked
        },
        conditions: {
            validate: (val) => conditionsInput.checked
        }
    };

    function setInvalid(input) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }

    function setValid(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    function updateSubmitBtn() {
        const allValid =
            rules.cgv.validate() &&
            rules.conditions.validate();

        submitBtn.disabled = !allValid;
    }

    // Événement
    cgvInput.addEventListener('change', function() {
        if (cgvInput.checked) {
            setValid(this);
        } else {
            setInvalid(this);
        }
        updateSubmitBtn();
    });

    conditionsInput.addEventListener('change', function() {
        if (conditionsInput.checked) {
            setValid(this);
        } else {
            setInvalid(this);
        }
        updateSubmitBtn();
    });

    // Initialisation
    updateSubmitBtn();

});