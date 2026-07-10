-- ===========================================================
-- DONNEES DE TEST FICTIVES POUR LE SITE VITE ET GOURMAND
-- ===========================================================

-- ===========================================================
-- Comptes de test pour chaque rôle : client, employé, administrateur
-- ===========================================================

-- Mot de passe pour tous les comptes de test : Test1234!
-- Hash bcrypt de "Test1234!" généré via password_hash()

INSERT INTO user (
    public_token, email, password, last_name, first_name,
    phone, street_number, street_type, street_name,
    zip_code, city, country, is_active, created_at, role_id
) VALUES
(
    'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
    'admin@viteetgourmand.fr',
    -- A remplacer par le hash du mot de passe généré via PHP
    -- echo password_hash('Test1234!', PASSWORD_DEFAULT);
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Dupont',
    'José',
    '0612345678',
    '12', 'rue', 'de la Liberté',
    '33000', 'Bordeaux', 'France',
    1, NOW(),
    3  -- administrateur
),
(
    'b2c3d4e5-f6a7-8901-bcde-f12345678901',
    'employe@viteetgourmand.fr',
    -- A remplacer par le hash du mot de passe généré via PHP
    -- echo password_hash('Test1234!', PASSWORD_DEFAULT);
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Martin',
    'Julie',
    '0623456789',
    '5', 'avenue', 'des Fleurs',
    '33000', 'Bordeaux', 'France',
    1, NOW(),
    2  -- employe
),
(
    'c3d4e5f6-a7b8-9012-cdef-123456789012',
    'client@test.fr',
    -- A remplacer par le hash du mot de passe généré via PHP
    -- echo password_hash('Test1234!', PASSWORD_DEFAULT);
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Bernard',
    'Sophie',
    '0634567890',
    '8', 'boulevard', 'Victor Hugo',
    '75001', 'Paris', 'France',
    1, NOW(),
    1  -- client
),
(
    'd4e5f6a7-b8c9-0123-defa-234567890123',
    'client2@test.fr',
    -- A remplacer par le hash du mot de passe généré via PHP
    -- echo password_hash('Test1234!', PASSWORD_DEFAULT);
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Leblanc',
    'Thomas',
    '0645678901',
    '3', 'rue', 'du Moulin',
    '33000', 'Bordeaux', 'France',
    1, NOW(),
    1  -- client
);

-- ===========================================================
-- Allergènes
-- ===========================================================

INSERT INTO allergen (label) VALUES
('Gluten'),
('Crustacés'),
('Oeufs'),
('Poissons'),
('Arachides'),
('Soja'),
('Lait'),
('Fruits à coque'),
('Céleri'),
('Moutarde'),
('Graines de sésame'),
('Anhydride sulfureux'),
('Lupin'),
('Mollusques');

-- ===========================================================
-- Menus de test
-- ===========================================================

INSERT INTO menu (
    title, description, min_persons,
    price_per_person, remaining_stock,
    conditions, is_active, theme_id, diet_id
) VALUES
(
    'Menu Noël Prestige',
    'Un menu raffiné pour sublimer vos fêtes de fin d\'année. Foie gras, saumon et bûche maison.',
    10,
    45.00,
    8,
    'À commander minimum 7 jours avant la prestation. Conservation au réfrigérateur entre 0 et 4°C.',
    1, 1, 1  -- Noël, classique
),
(
    'Menu Pâques Famille',
    'Le menu idéal pour réunir toute la famille autour d\'un repas généreux et convivial.',
    8,
    38.00,
    5,
    'À commander minimum 5 jours avant la prestation.',
    1, 2, 1  -- Pâques, classique
),
(
    'Menu Végétarien Printemps',
    'Une sélection de plats végétariens frais et colorés, parfaits pour la belle saison.',
    6,
    32.00,
    10,
    'À commander minimum 3 jours avant la prestation. Produits frais de saison.',
    1, 3, 2  -- classique, végétarien
),
(
    'Menu Événement Corporate',
    'Un menu professionnel et élégant pour vos séminaires, cocktails et réunions d\'affaires.',
    20,
    55.00,
    3,
    'À commander minimum 14 jours avant la prestation. Matériel de service fourni.',
    1, 4, 1  -- événement, classique
),
(
    'Menu Vegan Été',
    'Une expérience culinaire 100% végétale, fraîche et savoureuse.',
    4,
    28.00,
    0,
    'À commander minimum 3 jours avant la prestation.',
    1, 3, 3  -- classique, vegan
);

-- ===========================================================
-- Plats de test
-- ===========================================================

INSERT INTO dish (title, description, dish_type) VALUES
-- Entrées
('Foie gras maison', 'Foie gras mi-cuit, chutney de figues et pain brioché', 'starter'),
('Velouté de potiron', 'Velouté onctueux de potiron, crème fraîche et noisettes torréfiées', 'starter'),
('Salade de chèvre chaud', 'Mesclun, chèvre rôti, noix et miel de lavande', 'starter'),
('Saumon gravlax', 'Saumon mariné à l\'aneth, crème citronnée et blinis', 'starter'),

-- Plats
('Agneau de lait rôti', 'Gigot d\'agneau rôti aux herbes de Provence, gratin dauphinois', 'main'),
('Saumon en croûte', 'Pavé de saumon en croûte de sésame, riz basmati et légumes vapeur', 'main'),
('Risotto aux champignons', 'Risotto crémeux aux cèpes et morilles, copeaux de parmesan', 'main'),
('Filet de boeuf', 'Filet de boeuf en croûte, sauce Périgueux et pommes sarladaises', 'main'),

-- Desserts
('Bûche de Noël', 'Bûche maison chocolat et marrons glacés', 'dessert'),
('Charlotte aux fraises', 'Charlotte aux fraises fraîches, coulis de fruits rouges', 'dessert'),
('Tarte Tatin', 'Tarte Tatin aux pommes caramélisées, crème fraîche épaisse', 'dessert'),
('Fondant au chocolat', 'Fondant au chocolat noir 70%, glace vanille maison', 'dessert');

-- ===========================================================
-- Association menus et plats
-- ===========================================================

-- Menu Noël Prestige
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(1, 1),  -- Foie gras maison
(1, 5),  -- Agneau de lait rôti
(1, 9);  -- Bûche de Noël

-- Menu Pâques Famille
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(2, 4),  -- Saumon gravlax
(2, 5),  -- Agneau de lait rôti
(2, 10); -- Charlotte aux fraises

-- Menu Végétarien Printemps
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(3, 2),  -- Velouté de potiron
(3, 7),  -- Risotto aux champignons
(3, 11); -- Tarte Tatin

-- Menu Événement Corporate
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(4, 3),  -- Salade de chèvre chaud
(4, 8),  -- Filet de boeuf
(4, 12); -- Fondant au chocolat

-- Menu Vegan Été
INSERT INTO menu_dish (menu_id, dish_id) VALUES
(5, 2),  -- Velouté de potiron (présent dans 2 menus)
(5, 7),  -- Risotto aux champignons (présent dans 2 menus)
(5, 11); -- Tarte Tatin (présent dans 2 menus)

-- ===========================================================
-- Allergenes par plats
-- ===========================================================

INSERT INTO dish_allergen (dish_id, allergen_id) VALUES
-- Foie gras maison : gluten (pain brioché)
(1, 1),
-- Saumon gravlax : poissons, gluten (blinis)
(4, 4), (4, 1),
-- Salade de chèvre chaud : lait, fruits à coque
(3, 7), (3, 8),
-- Agneau de lait rôti : lait
(5, 7),
-- Saumon en croûte : poissons, gluten, graines de sésame
(6, 4), (6, 1), (6, 11),
-- Risotto aux champignons : lait
(7, 7),
-- Filet de boeuf : gluten
(8, 1),
-- Bûche de Noël : gluten, lait, oeufs
(9, 1), (9, 7), (9, 3),
-- Charlotte aux fraises : gluten, lait, oeufs
(10, 1), (10, 7), (10, 3),
-- Tarte Tatin : gluten, lait, oeufs
(11, 1), (11, 7), (11, 3),
-- Fondant au chocolat : gluten, lait, oeufs
(12, 1), (12, 7), (12, 3);

-- ===========================================================
-- Commandes de test
-- ===========================================================

INSERT INTO customer_order (
    order_date, event_date, delivery_time,
    delivery_street_number, delivery_street_type, delivery_street_name,
    delivery_zip_code, delivery_city, delivery_country,
    nb_persons, calculated_menu_price, delivery_fees,
    discount, total_price, current_status, material_lent,
    user_id, menu_id
) VALUES
(
    NOW(), '2026-12-24', '19:00:00',
    '8', 'boulevard', 'Victor Hugo',
    '75001', 'Paris', 'France',
    12, 540.00, 35.00,
    0.00, 575.00, 'accepted', 0,
    3, 1  -- client Sophie, Menu Noël
),
(
    NOW(), '2026-04-20', '12:30:00',
    '3', 'rue', 'du Moulin',
    '33000', 'Bordeaux', 'France',
    8, 304.00, 0.00,
    0.00, 304.00, 'pending', 0,
    4, 2  -- client Thomas, Menu Pâques
),
(
    NOW(), '2026-08-15', '20:00:00',
    '15', 'avenue', 'de la Gare',
    '33100', 'Bordeaux', 'France',
    15, 825.00, 0.00,
    82.50, 742.50, 'completed', 0,
    3, 4  -- client Sophie, Menu Corporate (réduction 10% car 15 >= 20+5 non... à ajuster)
);

-- ===========================================================
-- Historique des statuts de commandes
-- ===========================================================

INSERT INTO history_status_order (status, modified_at, order_id) VALUES
-- Commande 1
('pending', '2026-11-01 10:00:00', 1),
('accepted', '2026-11-02 14:30:00', 1),
-- Commande 2
('pending', '2026-11-05 09:00:00', 2),
-- Commande 3
('pending', '2026-10-01 11:00:00', 3),
('accepted', '2026-10-02 09:00:00', 3),
('in_preparation', '2026-10-15 08:00:00', 3),
('in_delivery', '2026-10-15 11:00:00', 3),
('delivered', '2026-10-15 13:00:00', 3),
('completed', '2026-10-15 13:30:00', 3);

-- ===========================================================
-- Avis de test
-- ===========================================================

INSERT INTO review (
    rating, comment, validation_status,
    reviewed_at, order_id, user_id
) VALUES
(
    5,
    'Prestation exceptionnelle ! Les plats étaient délicieux et le service impeccable.',
    'validated',
    '2026-10-16 10:00:00',
    3, 3
);

-- ===========================================================
-- Contenu de la page d'accueil
-- ===========================================================

INSERT INTO page_content (page, section, content, updated_at) VALUES
(
    'home',
    'presentation',
    'Vite & Gourmand est une entreprise bordelaise spécialisée dans la restauration événementielle depuis plus de 25 ans. Fondée par Julie et José, nous proposons des prestations de traiteur pour tous vos événements, des repas de famille aux séminaires d\'entreprise.',
    NOW()
),
(
    'home',
    'team',
    'Julie et José forment une équipe passionnée et complémentaire. Julie gère la cuisine avec créativité et exigence, tandis que José assure la coordination logistique et la relation client avec professionnalisme.',
    NOW()
);