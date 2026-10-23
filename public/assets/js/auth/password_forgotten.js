function initPasswordForgotten() {

    const emailInput  = document.getElementById('email');
    const submitBtn   = document.getElementById('btn-submit');
    const messages    = document.getElementById('password-forgotten-messages');
    const formWrapper = document.getElementById('password-forgotten-form-wrapper');

    // ── Règles de validation ──────────────────────────────
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message:  'Veuillez saisir une adresse mail valide.'
        }
    };

    // ── Fonctions utilitaires ─────────────────────────────
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
            setInvalid(input);
            return false;
        }
    }

    // ── Mise à jour bouton submit ─────────────────────────
    function updateSubmitBtn() {
        submitBtn.disabled = !rules.email.validate(emailInput.value);
    }

    // ── Validation initiale ───────────────────────────────
    function validatePrefilledFields() {
        if (emailInput.value.trim() !== '') {
            validateField(emailInput, rules.email);
        }
        updateSubmitBtn();
    }

    // ── Événements ───────────────────────────────────────
    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('password-forgotten-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        messages.innerHTML = '';

        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('email',      emailInput.value);

        try {
            const response = await fetch('/api/password-forgotten', {
                method: 'POST',
                body:   formData
            });

            const data = await response.json();

            if (data.success) {
                // Cache le formulaire et affiche le message de succès
                formWrapper.style.display = 'none';
                messages.innerHTML = `
                    <div class="col-12">
                        <p class="mb-0">
                            Si un compte est associé à cette adresse email, vous recevrez
                            dans quelques instants un lien de réinitialisation.
                            Pensez à vérifier vos spams.
                        </p>
                    </div>`;
            } else {
                messages.innerHTML = `
                    <ul>
                        <li class="text-danger">${data.error}</li>
                    </ul>`;
            }

        } catch (error) {
            messages.innerHTML = `
                <p class="text-danger">Erreur lors de l'envoi. Veuillez réessayer.</p>`;
        }
    });

    // ── État initial ──────────────────────────────────────
    submitBtn.disabled = true;
    validatePrefilledFields();
}

// OLD
//document.addEventListener('DOMContentLoaded', function() {
//    const emailInput = document.getElementById('email');
//    const submitBtn = document.getElementById('btn-submit');
//
//    //Règles de validation
//    const rules = {
//        email: {
//            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
//            message: 'Veuillez saisir une adresse mail valide.'
//        }
//    };
//
//    // ── Validation initiale des champs pré-remplis ────────
//    function validatePrefilledFields() {
//        const fields = [
//            { input: emailInput,        rule: rules.email },
//        ];
//
//        fields.forEach(({ input, rule }) => {
//            if (input && input.value.trim() !== '') {
//                validateField(input, rule);
//            }
//        });
//
//        updateSubmitBtn();
//    }
//
//    //Fonctions utilitaires
//    function setValid(input) {
//        input.classList.remove('is-invalid');
//        input.classList.add('is-valid');
//    }
//
//    function setInvalid(input) {
//        input.classList.remove('is-valid');
//        input.classList.add('is-invalid');
//    }
//
//    function validateField(input, rule) {
//        if (rule.validate(input.value)) {
//            setValid(input);
//            return true;
//        } else {
//            setInvalid(input, rule.message);
//            return false;
//        }
//    }
//
//    //Mise à jour du bouton submit
//    function updateSubmitBtn() {
//        const allValid =
//            rules.email.validate(emailInput.value);
//
//            submitBtn.disabled = !allValid;
//    }
//
//    //Evenements
//    emailInput.addEventListener('input', function() {
//        validateField(this, rules.email);
//        updateSubmitBtn();
//    });
//
//    //Etat initial - bouton désactivé
//    submitBtn.disabled = true;
//    validatePrefilledFields();
//
//});