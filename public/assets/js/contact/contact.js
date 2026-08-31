document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const contentInput = document.getElementById('content');
    const titleInput = document.getElementById('title');
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('btn-submit');

    //Auto-resize textarea
    if (contentInput) {
        contentInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    //Règles de validation
    const rules = {
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message: 'Veuillez saisir une adresse mail valide.'
        },
        title: {
            validate: (val) => val.trim().length >= 3,
            message: 'Le titre doit contenir au moins 3 caractères.'
        },
        content: {
            validate: (val) => val.trim().length >= 10,
            message: 'Le message doit contenir au moins 10 caractères.'
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
            rules.title.validate(titleInput.value) &&
            rules.content.validate(contentInput.value);

            submitBtn.disabled = !allValid;
    }

    //Evenements
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

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;

});