<?php

?>

<header>
    <nav class="navbar">
        <a href="/">Accueil</a>
        <a href="/menus">Nos Menus</a>
        <a href="/contact">Nous contacter</a>
        
        <!-- Switch connexion/deconnexion -->
        <?php if(Session::isLoggedIn()): ?>
            <form action="/deconnexion" method="POST">
                <button type="submit">Deconnexion</button>
            </form>
            <?php if ($_SESSION['role'] === 'administrateur'): ?>
                <a href="/admin">Dashboard admin</a>

            <?php elseif ($_SESSION['role'] === 'employe'): ?>
                <a href="/employe">Dashboard employé</a>

            <?php else: ?>
                <a href="/mon-espace">Mon espace</a>

            <?php endif; ?>
        <?php else: ?>
            <a href="/connexion">Connexion</a>
            <a href="/inscription">Inscription</a>
        <?php endif;?>
    
    </nav>
</header>