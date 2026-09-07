document.addEventListener('DOMContentLoaded', function() {
    const statusBtn = document.getElementById('status-filter-btn');
    const statusFilter = document.getElementById('status_filter');
    const clientBtn = document.getElementById('client-filter-btn');
    const clientFilter = document.getElementById('client-filter');

    const statusSelect = document.getElementById('current_status');
    const cancelForm = document.getElementById('cancel-form');
    const contactInput = document.getElementById('contact_mode');
    const submitBtn = document.getElementById('submit-btn');


    //Règles de validation du formulaire
    const rules = { 
        reason: { 
            validate: (val) => val.trim().length > 1
        },
        contact: {
            validate: (val) => val.trim().length > 1
        }
    }

    //Fonction utilitaires
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

    // Initialisation - disable tous les boutons submit au chargement
    document.querySelectorAll('form .boutons button[type="submit"]').forEach(function(btn) {
        btn.disabled = true;
    });

    // Evenements
    if (statusBtn && statusFilter) {
    statusBtn.addEventListener('click', function() {
        statusFilter.classList.toggle('d-none');
    });
    }

    if (clientBtn && clientFilter) {
    clientBtn.addEventListener('click', function() {
        clientFilter.classList.toggle('d-none');
    });
    }

    // Fonction de validation pour chaque formulaire
    function validateOrderForm(form) {
        const select      = form.querySelector('.status-select-input');
        const cancelForm  = form.querySelector('.cancel-form');
        const contactMode = form.querySelector('[name="contact_mode"]');
        const reason      = form.querySelector('[name="reason"]');
        const submitBtn   = form.querySelector('button[type="submit"]');

        if (!select || !submitBtn) return;

        const statusValid = select.value !== '';

        let cancelValid = true;
        if (select.value === 'cancelled') {
            cancelValid = 
                contactMode && contactMode.value.trim().length >= 1 &&
                reason && reason.value.trim().length >= 1;
        }

        submitBtn.disabled = !(statusValid && cancelValid);
    }

    // Délégation - écoute tous les selects de statut
    document.querySelectorAll('.status-select-input').forEach(function(select) {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            validateOrderForm(form);

            // Supprimer toutes les classes btn-*
            this.classList.remove(
                'btn-warning', 'btn-info', 'btn-secondary',
                'btn-success', 'btn-danger', 'btn-light', 'btn-white',
                'btn-primary'
            );

            // Ajouter la classe correspondant au nouveau statut
            const statusClasses = {
                'pending'          : 'btn-white',
                'accepted'         : 'btn-light',
                'in_preparation'   : 'btn-primary',
                'in_delivery'      : 'btn-primary',
                'delivered'        : 'btn-secondary',
                'waiting_material' : 'btn-secondary',
                'completed'        : 'btn-success',
                'cancelled'        : 'btn-danger'
            };
        
            if (statusClasses[this.value]) {
                this.classList.add(statusClasses[this.value]);
            }

            // Trouve le cancel-form dans le même formulaire
            const cancelForm = this.closest('form').querySelector('.cancel-form');
            if (cancelForm) {
                    cancelForm.classList.toggle('d-none', this.value !== 'cancelled');
            }
        });
    });

    // Écoute les inputs du cancel-form
    document.querySelectorAll('.cancel-form input, .cancel-form textarea').forEach(function(input) {
        input.addEventListener('input', function() {
            const form = this.closest('form');

            // Valide le champ selon son nom
        if (this.name === 'contact_mode') {
            validateField(this, rules.contact);
        } else if (this.name === 'reason') {
            validateField(this, rules.reason);
        }
            validateOrderForm(form);
        });
    });



});