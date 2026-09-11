# Vite & Gourmand

Application web de traiteur événementiel bordelais fictif, développée dans le cadre de l'ECF du Titre Professionnel Développeur Web (RNCP) via STUDI.

---

## Stack technique

- PHP 8.4 — architecture MVC personnalisée
- MariaDB — données relationnelles
- MongoDB — statistiques et tableaux de bord
- Bootstrap 5 + SCSS — interface responsive
- JavaScript natif — validation formulaires et interactions UI
- Chart.js — graphiques statistiques
- Flatpickr — sélection de dates
- PHPMailer — envoi d'emails
- api-adresse.data.gouv.fr + OpenRouteService — calcul frais de livraison

---

## Prérequis

- PHP 8.4+
- MariaDB
- MongoDB + extension PHP (`mongodb.so` via PECL)
- Composer
- Node.js + NPM

---

## Installation locale

### 1. Cloner le dépôt

```bash
git clone https://github.com/ton-username/vite-et-gourmand.git
cd vite-et-gourmand
```
### 2. Installer les dépendances

```bash
composer install
npm install
```
### 3. Configurer les variables d'environnement

```bash
cp .env.example .env
```

Renseigner les variables dans `.env` :

```env
APP_ENV=development

DB_HOST=localhost
DB_PORT=3306
DB_NAME=vite_et_gourmand
DB_USER=root
DB_PASS=

MONGO_URI=mongodb://localhost:27017
MONGO_DB=vg_stats

ORS_API_KEY=ta_clé_ors

MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USER=ton_user_mailtrap
MAIL_PASS=ton_pass_mailtrap
```
### 4. Base de données

```bash
# Initialiser la structure
mysql -u vg_user -p vite_et_gourmand < database/schema.sql

# Insérer les données de test (développement uniquement)
mysql -u vg_user -p vite_et_gourmand < database/seed.sql
```

> ⚠️ Ne jamais exécuter `seed.sql` en production

### 5. Extension MongoDB

Ajouter dans `php.ini` :

```ini
extension=/opt/homebrew/lib/php/pecl/20240924/mongodb.so
```

### 6. Lancer le serveur

```bash
php -S localhost:8000 -t public/ public/index.php
```

Application accessible sur `http://localhost:8000`

---
## Structure du projet

```
vite_et_gourmand/
├── public/ ← point d'entrée + assets
│ ├── index.php
│ └── assets/
│ ├── css/
│ ├── js/
│ └── images/
├── src/
│ ├── Controllers/
│ ├── Models/
│ ├── Core/ ← Router, Session, Database, Helpers
│ ├── Services/ ← DistanceService, MailService, StatsService
│ └── Middlewares/
├── views/
│ ├── layouts/
│ ├── auth/
│ ├── menus/
│ ├── orders/
│ ├── user/
│ ├── employee/
│ ├── admin/
│ └── errors/
├── scss/
├── database/
│ ├── schema.sql
│ └── seed.sql
├── .env.example
├── composer.json
└── package.json
```
---

## Rôles et accès

| Rôle | URL | Accès |
|---|---|---|
| Client | `/mon-espace` | Commandes, profil, avis |
| Employé | `/employe` | Commandes, menus, plats, avis, contenus |
| Administrateur | `/admin` | Employés, statistiques + accès employé |

---
## Accès de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Client | client@test.fr | Mot2Pass/Test |
| Employé | employe@test.fr | Mot2Pass/Test |
| Administrateur | admin@test.fr | Mot2Pass/Admin |

---

## Sécurité

- Protection CSRF sur tous les formulaires POST
- Requêtes SQL préparées (PDO)
- `htmlspecialchars()` sur toutes les sorties
- Headers HTTP de sécurité (CSP, X-Frame-Options)
- Cookies de session sécurisés (HttpOnly, SameSite)
- Protection brute force sur la connexion
- Validation MIME type côté serveur pour les uploads

---

## Déploiement

Le déploiement est prévu sur **Heroku**.

> ⚠️ Les fichiers uploadés étant stockés localement, 
> un service de stockage externe (Cloudinary) sera nécessaire 
> en raison du système de fichiers éphémère d'Heroku.

---

## Auteur

Charley Rivory — Formation Développeur Web, STUDI
[Dépôt GitHub](https://github.com/charleyRiv/vite_et_gourmand)