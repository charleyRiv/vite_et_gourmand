document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.etoile-rating');
    const ratingInput = document.getElementById('rating');
    const submitBtn = document.getElementById('btn-submit');

    const starOn = '/assets/images/uploads/icone_starOn.svg';
    const starOff = '/assets/images/uploads/icone_starOff.svg';

    // Agrandissement automatique de la zone de texte 
    const commentInput = document.getElementById('comment');

    if (commentInput) {
        commentInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
            updateSubmitBtn();
        });
    }


    // Mets à jour l'affichage des étoiles
    function updateStars(value) {
        stars.forEach(function(star) {
            if (parseInt(star.dataset.value) <= value) {
                star.src = starOn;
            } else {
                star.src = starOff;
            }
        });
    }

    //Survol - aperçu
    stars.forEach(function(star) {
        star.addEventListener('mouseover', function() {
            updateStars(parseInt(this.dataset.value));
        });
    });

    // Quitte la zone - revient à la valeur sélectionnée
    document.querySelector('.stars-rating').addEventListener('mouseleave', function() {
        updateStars(parseInt(ratingInput.value) || 0);
    });

    //Clic - sélectionne la note
    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;
            updateStars(value);
            updateSubmitBtn();
        });
    });

    // Validation
    //Règles de validation
    const rules = {
        rate: {
            validate: (val) => val.trim() !== ''
        },

        comment: {
            validate: (val) => val.trim().length >= 1
        }
    }


    function updateSubmitBtn() {
        const allValid =
            rules.rate.validate(ratingInput.value) &&
            rules.comment.validate(commentInput.value);
        
            submitBtn.disabled = !allValid;
    }

    // Initialisation
    submitBtn.disabled = true;
    updateSubmitBtn();
})