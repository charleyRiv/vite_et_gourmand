function initResetPassword() {

    const passwordInput = document.getElementById('password');
    const passwordConfInput = document.getElementById('password_confirm');
    const submitBtn = document.getElementById('btn-submit');
    const messages = document.getElementById('reset-messages');
    const formWrapper = document.getElementById('reset-form-wrapper');

    // ── Récupère le token depuis l'URL ────────────────────
    const params = new URLSearchParams(window.location.search);
    const token  = params.get('token') ?? '';

    if (!token) {
        formWrapper.style.display = 'none';
        messages.innerHTML = `
            <div class="col-12 error">
                <p>Ce lien de réinitialisation est invalide ou expiré.</p>
                <a href="/mot-de-passe-oublie-v2">Faire une nouvelle demande</a>
            </div>`;
        return;
    }

    // ── Afficher/masquer mot de passe ─────────────────────
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

    // ── Règles de validation ──────────────────────────────
    const rules = {
        password: {
            validate: (val) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/.test(val)
        },
        passwordConf: {
            validate: (val) => val === passwordInput.value
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
        submitBtn.disabled = !(
            rules.password.validate(passwordInput.value) &&
            rules.passwordConf.validate(passwordConfInput.value)
        );
    }

    // ── Événements ───────────────────────────────────────
    passwordInput.addEventListener('input', function() {
        validateField(this, rules.password);
        if (passwordConfInput.value !== '') {
            validateField(passwordConfInput, rules.passwordConf);
        }
        updateSubmitBtn();
    });

    passwordConfInput.addEventListener('input', function() {
        validateField(this, rules.passwordConf);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('reset-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        messages.innerHTML = '';

        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('token', token);
        formData.append('password', passwordInput.value);
        formData.append('password_confirm', passwordConfInput.value);

        try {
            const response = await fetch('/api/reset-password', {
                method: 'POST',
                body:   formData
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                messages.innerHTML = `
                    <div class="col-12 error">
                        <p class="text-danger">${data.error}</p>
                        <a href="/mot-de-passe-oublie-v2">Faire une nouvelle demande</a>
                    </div>`;
            }

        } catch (error) {
            messages.innerHTML = `
                <p class="text-danger">Erreur lors de la réinitialisation. Veuillez réessayer.</p>`;
        }
    });

    // ── État initial ──────────────────────────────────────
    submitBtn.disabled = true;
}

// OLD
//document.addEventListener('DOMContentLoaded', function() {
//    const form = document.getElementById('register-form');
//    const passwordInput = document.getElementById('password');
//    const passwordConfInput = document.getElementById('password_confirm');
//    const submitBtn = document.getElementById('btn-submit');
//
//    //Afficher mot de passe
//    const btnEyePassword = document.getElementById('btn-eye-password');
//    const iconEyePassword = document.getElementById('icon-eye-password');
//    const btnEyePasswordConf = document.getElementById('btn-eye-passwordConf');
//    const iconEyePasswordConf = document.getElementById('icon-eye-passwordConf');
//
//    if (btnEyePassword) {
//        btnEyePassword.addEventListener('click', function() {
//            if (passwordInput.type === 'password') {
//                passwordInput.type = 'text';
//                iconEyePassword.classList.replace('bi-eye', 'bi-eye-slash');
//            } else {
//                passwordInput.type = 'password';
//                iconEyePassword.classList.replace('bi-eye-slash', 'bi-eye');
//            }
//        });
//    }
//
//    if (btnEyePasswordConf) {
//        btnEyePasswordConf.addEventListener('click', function() {
//            if (passwordConfInput.type === 'password') {
//                passwordConfInput.type = 'text';
//                iconEyePasswordConf.classList.replace('bi-eye', 'bi-eye-slash');
//            } else {
//                passwordConfInput.type = 'password';
//                iconEyePasswordConf.classList.replace('bi-eye-slash', 'bi-eye');
//            }
//        });
//    }
//
//    //Règles de validation
//    const rules = {
//        password: {
//            validate: (val) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/.test(val)
//        },
//        passwordConf: {
//            validate: (val) => val === passwordInput.value
//        }
//    };
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
//            rules.password.validate(passwordInput.value) &&
//            rules.passwordConf.validate(passwordConfInput.value);
//
//            submitBtn.disabled = !allValid;
//    }
//
//    //Evenements
//    passwordInput.addEventListener('input', function() {
//        validateField(this, rules.password);
//        // Revalide le confirm si déjà rempli
//        if (passwordConfInput.value !== '') {
//            validateField(passwordConfInput, rules.passwordConf);
//        }
//        updateSubmitBtn();
//    });
//
//    passwordConfInput.addEventListener('input', function() {
//        validateField(this, rules.passwordConf);
//        updateSubmitBtn();
//    });
//
//    //Etat initial - bouton désactivé
//    submitBtn.disabled = true;
//
//});