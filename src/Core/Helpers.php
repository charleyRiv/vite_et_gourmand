<?php

//Extraire le dishType d'un plat et le traduire en français
function translateDishType(string $dishType): string
{
    return match($dishType) {
        'starter' => 'Entrée',
        'main'    => 'Plat',
        'dessert' => 'Dessert',
        default   => $dishType
    };
}

//créer un slug à partir d'un texte
function generateSlug(string $text): string
{
    // Convertir les accents
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    // Tout en minuscules
    $slug = strtolower($slug);
    // Remplacer tout ce qui n'est pas alphanumérique par un tiret
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    // Supprimer les tirets en début et fin
    $slug = trim($slug, '-');
    return $slug;
}

//Date format
function formatDateFr(string $date): string
{
    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = date('n', $timestamp);
    $year = date('Y', $timestamp);

    $months = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];

    $dateFr = $day . ' ' . $months[$month] . ' ' . $year;
    return $dateFr;
}

function formatTimeFr(string $time): string
{
    $timestamp = strtotime($time);
    $timeFr = date('H', $timestamp) . 'h' . date('i', $timestamp);
    return $timeFr;
}

function maskEmail(string $email): string
{
    [$local, $domain] = explode('@', $email);

    $firstChar = substr($local, 0,1);
    $lastChar = substr($local, -1);
    $maskedLocal = $firstChar . str_repeat('*', strlen($local) - 2) . $lastChar;
    $masked = $maskedLocal . '@' . $domain;
    return $masked;
}

?>