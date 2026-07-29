<?php
// Simulation pour le développement - à supprimer plus tard
//$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'administrateur';
//$_SESSION['role'] = 'employe';
?>

<header>
    <nav class="navbar">
        <a href="/">Accueil</a>
        <a href="/menus">Nos Menus</a>
        <a href="/contact">Nous contacter</a>
        <a href="/connexion">Connexion</a>
        <a href="/inscription">Inscription</a>

        <?php if ($_SESSION['role'] === 'administrateur'): ?>
            <a href="/admin">Dashboard admin</a>

        <?php elseif ($_SESSION['role'] === 'employe'): ?>
            <a href="/employe">Dashboard employé</a>

        <?php else: ?>
            <a href="/admin">Mon espace</a>

        <?php endif; ?>
    
    </nav>
</header>