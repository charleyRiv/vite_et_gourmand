function initContact() {

    const form         = document.getElementById('contact-form');
    const emailInput   = document.getElementById('email');
    const titleInput   = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const submitBtn    = document.getElementById('btn-submit');

    // ── Auto-resize textarea ──────────────────────────────
    if (contentInput) {
        contentInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    // ── Pré-rempli si connecté ────────────────────────────
    fetch('/api/session')
        .then(r => r.json())
        .then(session => {
            if (session.isLoggedIn && session.email) {
                emailInput.value = session.email;
            }
        });

    // ── Règles de validation ──────────────────────────────
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message:  'Veuillez saisir une adresse mail valide.'
        },
        title: {
            validate: (val) => val.trim().length >= 3,
            message:  'Le titre doit contenir au moins 3 caractères.'
        },
        content: {
            validate: (val) => val.trim().length >= 10,
            message:  'Le message doit contenir au moins 10 caractères.'
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
            rules.email.validate(emailInput.value)     &&
            rules.title.validate(titleInput.value)     &&
            rules.content.validate(contentInput.value);

        submitBtn.disabled = !allValid;
    }

    // ── Événements validation ─────────────────────────────
    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    titleInput.addEventListener('input', function() {
        validateField(this, rules.title);
        updateSubmitBtn();
    });

    contentInput.addEventListener('input', function() {
        validateField(this, rules.content);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Récupère le token CSRF
        const csrfRes  = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('email',      emailInput.value);
        formData.append('title',      titleInput.value);
        formData.append('content',    contentInput.value);

        try {
            const response = await fetch('/api/contact', {
                method: 'POST',
                body:   formData
            });

            const data = await response.json();

            if (data.success) {
                // ← Remplace showSuccessPopup PHP
                alert('Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.');
                form.reset();
                submitBtn.disabled = true;
            } else {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }

        } catch (error) {
            alert('Erreur lors de l\'envoi du message.');
        }
    });

    // ── État initial ──────────────────────────────────────
    submitBtn.disabled = true;
}

// OLD
//document.addEventListener('DOMContentLoaded', function() {
//    const form = document.getElementById('contact-form');
//    const contentInput = document.getElementById('content');
//    const titleInput = document.getElementById('title');
//    const emailInput = document.getElementById('email');
//    const submitBtn = document.getElementById('btn-submit');
//
//    //Auto-resize textarea
//    if (contentInput) {
//        contentInput.addEventListener('input', function() {
//            this.style.height = 'auto';
//            this.style.height = this.scrollHeight + 'px';
//        });
//    }
//
//    //Règles de validation
//    const rules = {
//        email: {
//            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
//            message: 'Veuillez saisir une adresse mail valide.'
//        },
//        title: {
//            validate: (val) => val.trim().length >= 3,
//            message: 'Le titre doit contenir au moins 3 caractères.'
//        },
//        content: {
//            validate: (val) => val.trim().length >=10,
//            message: 'Le message doit contenir au moins 10 caractères.'
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
//            rules.email.validate(emailInput.value) &&
//            rules.title.validate(titleInput.value) &&
//            rules.content.validate(contentInput.value);
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
//    titleInput.addEventListener('input', function() {
//        validateField(this, rules.title);
//        updateSubmitBtn();
//    });
//
//    contentInput.addEventListener('input', function() {
//        validateField(this, rules.content);
//        updateSubmitBtn();
//    });
//
//    //Alerte de confirmation
//    if (typeof showSuccessPopup !== 'undefined' && showSuccessPopup) {
//        alert('Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.');
//    }
//
//
//    //Etat initial - bouton désactivé
//    submitBtn.disabled = true;
//
//});