document.addEventListener('DOMContentLoaded', function() {
    //Constantes pour le menu
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const typeInput = document.getElementById('dish_type');
    const btnSubmitDish = document.getElementById('btn-submit-dish');

    //Constantes pour les photos
    const btnAddPhoto = document.getElementById('add-photo-btn');
    const formNewPicture = document.getElementById('form-new-picture');
    const photoInput = document.getElementById('photo');
    const titlePhotoInput = document.getElementById('title-photo');
    const altTextInput = document.getElementById('alt_text');
    const btnSubmitPhoto = document.getElementById('btn-submit-photo');

    //Règles de validation
    const rulesDish = {
        title: {
            validate: (val) => val.trim().length > 1
        },
        description: {
            validate: (val) => val.trim().length > 1
        },
        type: {
            validate: (val) => val !== ''
        },
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
    function updateSubmitBtnDish() {
        const allValidDish =
            rulesDish.title.validate(titleInput.value) &&
            rulesDish.description.validate(descriptionInput.value) &&
            rulesDish.type.validate(typeInput.value);

            btnSubmitDish.disabled = !allValidDish;
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
            { input: titleInput, rule: rulesDish.title },
            { input: descriptionInput, rule: rulesDish.description },
            { input: typeInput, rule: rulesDish.type },
        ];

        fields.forEach(({ input, rule }) => {
            if (input && input.value.trim() !== '') {
                validateField(input, rule);
            }
        });

        updateSubmitBtnDish();
    }

    //Evenements
    //Menu
    titleInput.addEventListener('input', function() {
        validateField(this, rulesDish.title);
        updateSubmitBtnDish();
    });

    descriptionInput.addEventListener('input', function() {
        validateField(this, rulesDish.description);
        updateSubmitBtnDish();
    });

    typeInput.addEventListener('change', function() {
        validateField(this, rulesDish.type);
        updateSubmitBtnDish();
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
    btnSubmitDish.disabled = true;
    btnSubmitPhoto.disabled = true;
    validatePrefilledFields();

})

