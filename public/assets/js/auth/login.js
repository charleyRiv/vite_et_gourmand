function initLogin() {

    const emailInput    = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitBtn     = document.getElementById('btn-submit');
    const messages      = document.getElementById('login-messages');

    // ── Messages succès après inscription/reset ───────────
    const params = new URLSearchParams(window.location.search);
    if (params.get('registered')) {
        messages.innerHTML = `
            <p class="text-success">
                Compte créé avec succès ! Vous pouvez maintenant vous connecter.
            </p>`;
    }
    if (params.get('reset')) {
        messages.innerHTML = `
            <p class="text-success">
                Votre mot de passe a bien été modifié. Vous pouvez maintenant vous connecter.
            </p>`;
    }

    // ── Règles de validation ──────────────────────────────
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message:  'Veuillez saisir une adresse mail valide.'
        },
        password: {
            validate: (val) => val.trim().length >= 8,
            message:  'Le mot de passe doit contenir au moins 8 caractères.'
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
        const allValid =
            rules.email.validate(emailInput.value) &&
            rules.password.validate(passwordInput.value);
        submitBtn.disabled = !allValid;
    }

    // ── Événements validation ─────────────────────────────
    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    passwordInput.addEventListener('input', function() {
        validateField(this, rules.password);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    submitBtn.addEventListener('click', async function() {
        messages.innerHTML = '';

        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('email',      emailInput.value);
        formData.append('password',   passwordInput.value);

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                body:   formData
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                messages.innerHTML = `
                    <ul>
                        <li class="text-danger">${data.error}</li>
                    </ul>`;
            }

        } catch (error) {
            messages.innerHTML = `
                <p class="text-danger">Erreur lors de la connexion. Veuillez réessayer.</p>`;
        }
    });

    // ── État initial ──────────────────────────────────────
    submitBtn.disabled = true;
}