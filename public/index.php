<?php

//Chargement des variables d'environnement
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}

//Affichage des erreurs en mode développement
if (getenv('APP_ENV') === 'development') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

//Chargement des classes core
require_once __DIR__ . '/../src/Core/Router.php';

//Définition des routes
$router = new Router();

//Routes publiques
$router->get('/', 'HomeController', 'index');

//Dispatch de la requête
$router->dispatch(
    $_SERVER['REQUEST_METHOD'], 
    $_SERVER['REQUEST_URI']
    );