document.addEventListener('DOMContentLoaded', function() {
    const btnShowEmployee = document.getElementById('show-employee');
    const btnHideEmployee = document.getElementById('hide-employee');
    const sectionEmployee = document.getElementById('section-employee');
    const searchFilter = document.getElementById('search-filter');
    const filtersFilter = document.getElementById('filters-filter');
    const boutonSFilter = document.getElementById('boutons-filter');

    const emailFilterBtn = document.getElementById('email-filter-btn');
    const emailFilterInput = document.getElementById('email-filter');
    const statusFilterBtn = document.getElementById('status-filter-btn');
    const statusFilterInput = document.getElementById('status-filter');
    
    const btnNewEmployeeForm = document.getElementById('new-employee-form-btn');
    const newEmployeeForm = document.getElementById('new-employee-form');

    // Afficher les employes
    btnShowEmployee.addEventListener('click', function() {
        btnShowEmployee.classList.add('d-none');
        btnHideEmployee.classList.remove('d-none');
        sectionEmployee.classList.remove('d-none');
        searchFilter.classList.remove('d-none');
        filtersFilter.classList.remove('d-none');
        boutonSFilter.classList.remove('d-none');
    });

    //Masquer les employes
    btnHideEmployee.addEventListener('click', function() {
        btnHideEmployee.classList.add('d-none');
        btnShowEmployee.classList.remove('d-none');
        sectionEmployee.classList.add('d-none');
        searchFilter.classList.add('d-none');
        filtersFilter.classList.add('d-none');
        boutonSFilter.classList.add('d-none');
    });

    //Afficher les filtres
    emailFilterBtn.addEventListener('click', function() {
        emailFilterInput.classList.toggle('d-none');
    });

    statusFilterBtn.addEventListener('click', function() {
        statusFilterInput.classList.toggle('d-none');
    })

    //Afficher le formulaire de création de user employé
    btnNewEmployeeForm.addEventListener('click', function() {
        newEmployeeForm.classList.toggle('d-none');
    })


    //--FORM NEW EMPLOYEE VALIDATION
    const lastNameInput = document.getElementById('last_name');
    const firstNameInput = document.getElementById('first_name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfInput = document.getElementById('password_confirm');
    const submitBtn = document.getElementById('btn-submit');

    //Afficher mot de passe
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

    //Règles de validation
    const rules = {
        lastName: {
            validate: (val) => val.trim().length > 1
        },
        firstName: {
            validate: (val) => val.trim().length > 1
        },
        email: {
            validate: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()),
            message: 'Veuillez saisir une adresse mail valide.'
        },
        password: {
            validate: (val) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/.test(val)
        },
        passwordConf: {
            validate: (val) => val === passwordInput.value
        },
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
            rules.lastName.validate(lastNameInput.value) &&
            rules.firstName.validate(firstNameInput.value) &&
            rules.email.validate(emailInput.value) &&
            rules.password.validate(passwordInput.value) &&
            rules.passwordConf.validate(passwordConfInput.value);

            submitBtn.disabled = !allValid;
    }

    //Evenements
    lastNameInput.addEventListener('input', function() {
        validateField(this, rules.lastName);
        updateSubmitBtn();
    });

    firstNameInput.addEventListener('input', function() {
        validateField(this, rules.firstName);
        updateSubmitBtn();
    });

    emailInput.addEventListener('input', function() {
        validateField(this, rules.email);
        updateSubmitBtn();
    });

    passwordInput.addEventListener('input', function() {
        validateField(this, rules.password);
        // Revalide le confirm si déjà rempli
        if (passwordConfInput.value !== '') {
            validateField(passwordConfInput, rules.passwordConf);
        }
        updateSubmitBtn();
    });

    passwordConfInput.addEventListener('input', function() {
        validateField(this, rules.passwordConf);
        updateSubmitBtn();
    });

    //Etat initial - bouton désactivé
    submitBtn.disabled = true;


});