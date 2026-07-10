# Vite & Gourmand

Application web de commande de menus traiteur pour l'entreprise Vite & Gourmand.

## Stack technique

- PHP natif + PDO
- MariaDB
- MongoDB
- Bootstrap 5
- JavaScript

## Installation locale

*(À compléter)*

## Accès de test

*(À compléter lors de la finalisation)*

## Base de données

# Initialiser la structure
mysql -u vg_user -p vite_et_gourmand < database/schema.sql

# Insérer les données de test (développement uniquement)
mysql -u vg_user -p vite_et_gourmand < database/seed.sql

⚠️ Ne jamais exécuter seed.sql en production