document.getElementById('delete-form').addEventListener('submit', function(e) {
    e.preventDefault();

    if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
        this.onsubmit();
    }
});