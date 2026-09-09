document.addEventListener('DOMContentLoaded', function() {
    //Constantes pour le menu
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const themeInput = document.getElementById('theme_id');
    const dietInput = document.getElementById('diet_id');
    const starterInput = document.getElementById('starter');
    const mainInput = document.getElementById('main');
    const dessertInput = document.getElementById('dessert');
    const priceInput = document.getElementById('price_per_person');
    const minPersonsInput = document.getElementById('min_persons');
    const stockInput = document.getElementById('remaining_stock');
    const conditionsInput = document.getElementById('conditions');
    const btnSubmitMenu = document.getElementById('btn-submit-menu');

    //Constantes pour les photos
    const btnAddPhoto = document.getElementById('add-photo-btn');
    const formNewPicture = document.getElementById('form-new-picture');
    const photoInput = document.getElementById('photo');
    const titlePhotoInput = document.getElementById('title-photo');
    const altTextInput = document.getElementById('alt_text');
    const btnSubmitPhoto = document.getElementById('btn-submit-photo');

    //Règles de validation
    const rulesMenu = {
        title: {
            validate: (val) => val.trim().length > 1
        },
        description: {
            validate: (val) => val.trim().length > 1
        },
        theme: {
            validate: (val) => val !== ''
        },
        diet: {
            validate: (val) => val !== ''
        },
        starter: {
            validate: (val) => val !== ''
        },
        main: {
            validate: (val) => val !== ''
        },
        dessert: {
            validate: (val) => val !== ''
        },
        price: {
            validate: (val) => val.trim() !== '' && parseFloat(val) > 0
        },
        minPersons: {
            validate: (val) => val.trim() !== '' && parseFloat(val) > 0
        },
        stock: {
            validate: (val) => val.trim() !== '' && parseFloat(val) >= 0
        },
        conditions: {
            validate: (val) => val.trim().length > 1
        }
    }

    const rulesPicture = {
        photo: {
            validate: (val) => val !== '' && photoInput.files.length > 0
        },
        titlePhoto: {
            validate: (val) => val.trim().length > 1
        },
        altText: {
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

    //Mise à jour du bouton submit Menu
    function updateSubmitBtnMenu() {
        const allValidMenu =
            rulesMenu.title.validate(titleInput.value) &&
            rulesMenu.description.validate(descriptionInput.value) &&
            rulesMenu.theme.validate(themeInput.value)&&
            rulesMenu.diet.validate(dietInput.value) &&
            rulesMenu.starter.validate(starterInput.value) &&
            rulesMenu.main.validate(mainInput.value) &&
            rulesMenu.dessert.validate(dessertInput.value) &&
            rulesMenu.price.validate(priceInput.value) &&
            rulesMenu.minPersons.validate(minPersonsInput.value) &&
            rulesMenu.stock.validate(stockInput.value) &&
            rulesMenu.conditions.validate(conditionsInput.value);

            btnSubmitMenu.disabled = !allValidMenu;
    }

   //Mise à jour du bouton submit Menu
    function updateSubmitBtnPicture() {
        const allValidPhoto =
            rulesPicture.titlePhoto.validate(titlePhotoInput.value) &&
            rulesPicture.photo.validate(photoInput.value) &&
            rulesPicture.altText.validate(altTextInput.value);

            btnSubmitPhoto.disabled = !allValidPhoto;
    } 

    // ── Validation initiale des champs pré-remplis ────────
    function validatePrefilledFields() {
        const fields = [
            { input: titleInput, rule: rulesMenu.title },
            { input: descriptionInput, rule: rulesMenu.description },
            { input: themeInput, rule: rulesMenu.theme },
            { input: dietInput, rule: rulesMenu.diet },
            { input: starterInput, rule: rulesMenu.starter },
            { input: mainInput, rule: rulesMenu.main },
            { input: dessertInput, rule: rulesMenu.dessert },
            { input: priceInput, rule: rulesMenu.price },
            { input: minPersonsInput, rule: rulesMenu.minPersons },
            { input: stockInput, rule: rulesMenu.stock },
            { input: conditionsInput, rule: rulesMenu.conditions},
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtnMenu();
    }

    //Evenements
    //Menu
    titleInput.addEventListener('input', function() {
        validateField(this, rulesMenu.title);
        updateSubmitBtnMenu();
    });

    descriptionInput.addEventListener('input', function() {
        validateField(this, rulesMenu.description);
        updateSubmitBtnMenu();
    });

    themeInput.addEventListener('change', function() {
        validateField(this, rulesMenu.theme);
        updateSubmitBtnMenu();
    });

    dietInput.addEventListener('change', function() {
        validateField(this, rulesMenu.diet);
        updateSubmitBtnMenu();
    });

    starterInput.addEventListener('change', function() {
        validateField(this, rulesMenu.starter);
        updateSubmitBtnMenu();
    });

    mainInput.addEventListener('change', function() {
        validateField(this, rulesMenu.main);
        updateSubmitBtnMenu();
    });

    dessertInput.addEventListener('change', function() {
        validateField(this, rulesMenu.dessert);
        updateSubmitBtnMenu();
    });

    priceInput.addEventListener('input', function() {
        validateField(this, rulesMenu.price);
        updateSubmitBtnMenu();
    });

    minPersonsInput.addEventListener('input', function() {
        validateField(this, rulesMenu.minPersons);
        updateSubmitBtnMenu();
    });

    stockInput.addEventListener('input', function() {
        validateField(this, rulesMenu.stock);
        updateSubmitBtnMenu();
    });

    conditionsInput.addEventListener('input', function() {
        validateField(this, rulesMenu.conditions);
        updateSubmitBtnMenu();
    });

    //Photos

    photoInput.addEventListener('change', function() {
        validateField(this, rulesPicture.photo)
        updateSubmitBtnPicture();
    });

    titlePhotoInput.addEventListener('input', function() {
        validateField(this, rulesPicture.titlePhoto)
        updateSubmitBtnPicture();
    });

    altTextInput.addEventListener("input", function() {
        validateField(this, rulesPicture.altText)
        updateSubmitBtnPicture();
    });

    //Apparition du formulaire de création de photo
    btnAddPhoto.addEventListener('click', function() {
        formNewPicture.classList.toggle('d-none')
    })

    //Etat initial - bouton désactivé
    btnSubmitMenu.disabled = true;
    btnSubmitPhoto.disabled = true;
    validatePrefilledFields();

})

