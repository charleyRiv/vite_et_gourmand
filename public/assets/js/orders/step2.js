function initStep2() {

    const menuSelect = document.getElementById('menu_id');
    const submitBtn = document.getElementById('btn-submit');

    // ── Récupère l'id pré-sélectionné depuis l'URL ────────
    const params = new URLSearchParams(window.location.search);
    const preselectedMenuId = params.get('menu_id');

    // ── Charge les menus depuis l'API ─────────────────────
    fetch('/api/menus?status=is_active')
        .then(r => r.json())
        .then(data => {
            data.menus.forEach(menu => {
                const option = document.createElement('option');
                option.value = menu.menu_id;
                option.textContent = menu.title;
                if (preselectedMenuId && menu.menu_id == preselectedMenuId) {
                    option.selected = true;
                }
                menuSelect.appendChild(option);
            });
            validatePrefilledFields();
        });

    // ── Règles de validation ──────────────────────────────
    const rules = {
        menu: { validate: (val) => val !== '' && val !== 'default' }
    };

    function setValid(input){ input.classList.remove('is-invalid'); input.classList.add('is-valid'); }
    function setInvalid(input){ input.classList.remove('is-valid'); input.classList.add('is-invalid'); }

    function validateField(input, rule) {
        if (rule.validate(input.value)) { setValid(input);   return true; }
        else { setInvalid(input); return false; }
    }

    function updateSubmitBtn() {
        submitBtn.disabled = !rules.menu.validate(menuSelect.value);
    }

    function validatePrefilledFields() {
        if (menuSelect.value.trim() !== '') {
            validateField(menuSelect, rules.menu);
        }
        updateSubmitBtn();
    }

    menuSelect.addEventListener('change', function() {
        validateField(this, rules.menu);
        updateSubmitBtn();
    });

    // ── Soumission via fetch ──────────────────────────────
    document.getElementById('order2-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const csrfRes = await fetch('/api/csrf-token');
        const csrfData = await csrfRes.json();

        const formData = new FormData();
        formData.append('csrf_token', csrfData.token);
        formData.append('menu_id', menuSelect.value);

        try {
            const response = await fetch('/api/commande/etape-2', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                window.location.href = data.redirect;
            }
        } catch (error) {
            console.error('Erreur étape 2 :', error);
        }
    });

    submitBtn.disabled = true;
}
