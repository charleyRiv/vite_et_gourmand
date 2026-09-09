document.addEventListener('DOMContentLoaded', function() {
    const btnNewContenu = document.getElementById('btn-new');
    const formNewContenu = document.getElementById('new-form');
    const pageInput = document.getElementById('page');
    const sectionInput = document.getElementById('section');
    const contentInput = document.getElementById('content');
    const btnSubmitNew = document.getElementById('btn-submit-new');

    //Afficher le formulaire
    btnNewContenu.addEventListener('click', function() {
        formNewContenu.classList.toggle('d-none');
    });

    //Règles de validation formulaire de creation contenu
    const rules = {
        page: {
            validate : (val) => val.trim().length > 1
        },
        section: {
            validate : (val) => val.trim().length > 1
        },
        content: {
            validate : (val) => val.trim().length > 1
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

    //Mise à jour du bouton submit Menu
    function updateSubmitBtn() {
        const allValid =
            rules.page.validate(pageInput.value) &&
            rules.section.validate(sectionInput.value) &&
            rules.content.validate(contentInput.value);

            btnSubmitNew.disabled = !allValid;
    }

    //Evenements
    pageInput.addEventListener('input', function() {
        validateField(this, rules.page);
        updateSubmitBtn();
    });

    sectionInput.addEventListener('input', function() {
        validateField(this, rules.section);
        updateSubmitBtn();
    });

    contentInput.addEventListener('input', function() {
        validateField(this, rules.content);
        updateSubmitBtn();
    });

    // Autoresize des zones de texte
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px' ;
    }

    //Au chargement, ajuste les textareas pré-remplis
    document.querySelectorAll('textarea').forEach(function(textarea) {
        autoResize(textarea);
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });

    //Modifier un contenu
    document.querySelectorAll('[id^="btn-modify"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const contentId = this.dataset.id;

            //Récupère les éléments du même formulaire
            const textarea = document.getElementById('content-' + contentId);
            const btnValidate = this.closest('.content-form').querySelector('[id^="btn-validated"]');
            //const btnModify = this.closest('.content-form').querySelector('[id^="btn-modify"]');

            // Toggle disable de textarea
            textarea.removeAttribute('disabled');
            textarea.focus();

            // Toggle les boutons
            this.classList.add('d-none');
            btnValidate.classList.remove('d-none');
        });
    });

    //Valider un contenu
    document.querySelectorAll('[id^="btn-validated"]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const contentId = this.dataset.id;

            //Récupère les éléments du même formulaire
            const textarea = document.getElementById('content-' + contentId);
            //const btnValidate = this.closest('.content-form').querySelector('[id^="btn-validated"]');
            const btnModify = this.closest('.content-form').querySelector('[id^="btn-modify"]');

            // Toggle disable de textarea
            textarea.addAttribute('disabled');
            textarea.blur();

            // Toggle les boutons
            this.classList.add('d-none');
            btnModify.classList.remove('d-none');
        });
    });

    //Etat initial - bouton désactivé
    btnSubmitNew.disabled = true;

});