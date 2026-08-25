<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Vite & Gourmand')?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <!--Logo-->
            <a class="navbar-brand fw-bold" href="/">
                <img
                    src="/assets/images/uploads/Logo_Figma.svg"
                    alt="Vite & Gourmand"
                >
            </a>

            <!-- Burger mobile -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain"
                aria-controls="navbarMain"
                aria-expanded="false"
                aria-label="Ouvrir le menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Liens-->
            <div class="collapse navbar-collapse" id="navbarMain">

                <!-- Liens principaux -->
                <!--ul class="navbar-nav me-auto mb-2 mb-lg-0"-->
                <ul class="navbar-nav ms-auto align-items-lg-center align-items-end">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/' ? 'active' : '') ?>"
                        href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (str_starts_with($_SERVER['REQUEST_URI'], '/menus') ? 'active' : '') ?>"
                        href="/menus">Nos Menus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/contact' ? 'active' : '') ?>"
                        href="/contact">Nous contacter</a>
                    </li>
        

                <!-- Switch connexion/deconnexion -->
                    <?php if(Session::isLoggedIn()): ?>
                        
                        <?php if ($_SESSION['role'] === 'administrateur'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin">
                                    <i class="bi bi-person-fill "></i>
                                </a>
                            </li>
                        <?php elseif ($_SESSION['role'] === 'employe'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/employe">
                                    <i class="bi bi-person-fill "></i>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/mon-espace">
                                    <i class="bi bi-person-fill "></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <form action="/deconnexion" method="post">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    Déconnexion
                                </button>
                            </form>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/connexion">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="/inscription">
                                S'inscrire
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
