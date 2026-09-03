document.addEventListener('DOMContentLoaded', function() {
    const nbPersonsInput = document.getElementById('nb_persons');
    const nbDispplay = document.getElementById('nb-display');
    const menuPriceCell = document.getElementById('menu-price');
    const discountCell = document.getElementById('discount-price');
    const totalCell = document.getElementById('total-price');
    const submitBtn = document.getElementById('btn-submit');

    function calculatePrices() {
        const nbPersons = parseInt(nbPersonsInput.value) || 0;

        //Prix du menu
        const menuPrice = pricePerPerson * nbPersons;

        // Déduction 10% si nb_persons >= min_persons + 5
        const discount = nbPersons >= minPersons + 5
            ? menuPrice * 0.1
            : 0;

        // Total
        const total = menuPrice - discount;

        // Mise a jour de l'affichage
        nbDispplay.textContent = nbPersons;
        menuPriceCell.textContent = menuPrice.toFixed(2) + ' €';
        discountCell.textContent = discount > 0
            ? '- ' + discount.toFixed(2) + ' €'
            : '0 €'
        totalCell.innerHTML = '<strong>' + total.toFixed(2) + ' €</strong>';
    }

    // Règles de validation
    const rules = {
        nbPersons: {
            validate: (val) => parseInt(val) >= minPersons
        }
    };

    function setInvalid(input) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }

    function setValid(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    function updateSubmitBtn() {
        submitBtn.disabled = !rules.nbPersons.validate(nbPersonsInput.value);
    }

    // Événement
    nbPersonsInput.addEventListener('input', function() {
        if (rules.nbPersons.validate(this.value)) {
            setValid(this);
        } else {
            setInvalid(this);
        }
        calculatePrices();
        updateSubmitBtn();
    });

    // Initialisation
    calculatePrices();
    updateSubmitBtn();

});