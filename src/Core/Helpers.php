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

?>