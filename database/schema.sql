-- ===========================================================
-- Vite et Gourmand Database Schema
-- MariaDB / MySQL 
-- ===========================================================

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE 'role' (
  'role_id' INT AUTO_INCREMENT PRIMARY KEY,
  'label' VARCHAR(50) NOT NULL
);

CREATE TABLE 'theme' (
  'theme_id' INT AUTO_INCREMENT PRIMARY KEY,
  'label' VARCHAR(50) NOT NULL
);

CREATE TABLE 'diet' (
  'diet_id' INT AUTO_INCREMENT PRIMARY KEY,
  'label' VARCHAR(50) NOT NULL
);

CREATE TABLE 'allergen' (
  'allergen_id' INT AUTO_INCREMENT PRIMARY KEY,
  'label' VARCHAR(100) NOT NULL
);

CREATE TABLE 'schedule' (
  'schedule_id' INT AUTO_INCREMENT PRIMARY KEY,
  'day' VARCHAR(20) NOT NULL,
  'opening_time' TIME NOT NULL ,
  'closing_time' TIME NOT NULL
);

CREATE TABLE 'message_contact' (
  'message_id' INT AUTO_INCREMENT PRIMARY KEY,
  'title' VARCHAR(100) NOT NULL,
  'description' TEXT NOT NULL,
  'sender_email' VARCHAR(100) NOT NULL,
  'sent_at' DATETIME NOT NULL
);

CREATE TABLE 'dish' (
  'dish_id' INT AUTO_INCREMENT PRIMARY KEY,
  'title' VARCHAR(100) NOT NULL,
  'description' TEXT,
  'dish_type' ENUM('entrée','plat','dessert') NOT NULL
);

CREATE TABLE 'page_content' (
  'content_id' INT AUTO_INCREMENT PRIMARY KEY,
  'page' VARCHAR(50) NOT NULL,
  'section' VARCHAR(50) NOT NULL,
  'content' TEXT NOT NULL,
  'updated_at' DATETIME NOT NULL
);

CREATE TABLE 'user' (
  'user_id' INT AUTO_INCREMENT PRIMARY KEY,
  'public_token' CHAR(36) NOT NULL UNIQUE,
  'email' VARCHAR(100) NOT NULL UNIQUE,
  'password' VARCHAR(255) NOT NULL,
  'last_name' VARCHAR(50) NOT NULL,
  'first_name' VARCHAR(50) NOT NULL,
  'phone' VARCHAR(20),
  'street_number' VARCHAR(10),
  'street_type' VARCHAR(20),
  'street_name' VARCHAR(100),
  'zip_code' VARCHAR(10),
  'city' VARCHAR(50),
  'country' VARCHAR(50),
  'is_active' TINYINT(1) NOT NULL DEFAULT 1,
  'token_reset' CHAR(36),
  'token_reset_expiration' DATETIME,
  'created_at' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'modified_at' DATETIME,
  'role_id' INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE 'menu' (
  'menu_id' INT AUTO_INCREMENT PRIMARY KEY,
  'title' VARCHAR(100) NOT NULL,
  'description' TEXT NOT NULL,
  'min_persons' INT NOT NULL,
  'price_per_person' DECIMAL(10, 2) NOT NULL,
  'remaining_stock' INT NOT NULL DEFAULT 0,
  'conditions' TEXT,
  'is_active' TINYINT(1) NOT NULL DEFAULT 1,
  'theme_id' INT NOT NULL,
  'diet_id' INT NOT NULL,
  FOREIGN KEY (theme_id) REFERENCES theme(theme_id),
  FOREIGN KEY (diet_id) REFERENCES diet(diet_id)
);

CREATE TABLE 'picture_menu' (
  'picture_id' INT AUTO_INCREMENT PRIMARY KEY,
  'url' VARCHAR(255) NOT NULL,
  'title' VARCHAR(100),
  'alt_text' VARCHAR(255) NOT NULL,
  'slug' VARCHAR(255) NOT NULL,
  'display_order' INT NOT NULL DEFAULT 0,
  'menu_id' INT NOT NULL,
  FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

CREATE TABLE 'picture_dish' (
    'picture_id' INT AUTO_INCREMENT PRIMARY KEY,
    'url' VARCHAR(255) NOT NULL,
    'title' VARCHAR(100),
    'alt_text' VARCHAR(255) NOT NULL,
    'slug' VARCHAR(100),
    'display_order' INT NOT NULL DEFAULT 0,
    'dish_id' INT NOT NULL,
    FOREIGN KEY (dish_id) REFERENCES dish(dish_id)
);

CREATE TABLE 'menu_dish' (
  'menu_id' INT NOT NULL,
  'dish_id' INT NOT NULL,
  PRIMARY KEY (menu_id, dish_id),
  FOREIGN KEY (menu_id) REFERENCES menu(menu_id),
  FOREIGN KEY (dish_id) REFERENCES dish(dish_id)
);

CREATE TABLE 'dish_allergen' (
  'dish_id' INT NOT NULL,
  'allergen_id' INT NOT NULL,
  PRIMARY KEY (dish_id, allergen_id),
  FOREIGN KEY (dish_id) REFERENCES dish(dish_id),
  FOREIGN KEY (allergen_id) REFERENCES allergen(allergen_id)
);

CREATE TABLE 'customer_order' (
  'order_id' INT AUTO_INCREMENT PRIMARY KEY,
  'order_date' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'event_date' DATE NOT NULL,
  'delivery_time' TIME NOT NULL,
  'delivery_street_number' VARCHAR(10) NOT NULL,
  'delivery_street_type' VARCHAR(20) NOT NULL,
  'delivery_street_name' VARCHAR(100) NOT NULL,
  'delivery_zip_code' VARCHAR(10) NOT NULL,
  'delivery_city' VARCHAR(50) NOT NULL,
  'delivery_country' VARCHAR(50) NOT NULL,
  'nb_persons' SMALLINT NOT NULL,
  'calculated_menu_price' DECIMAL(10, 2) NOT NULL,
  'delivery_fees' DECIMAL(10, 2) NOT NULL DEFAULT 0,
  'discount' DECIMAL(10, 2) NOT NULL DEFAULT 0,
  'total_price' DECIMAL(10, 2) NOT NULL,
  'current_status' ENUM(
    'en attente de confirmation',
    'acceptée',
    'en préparation',
    'en cours de livraison',
    'livrée',
    'en attente de retour matériel',
    "terminée",
    'annulée'
    ) NOT NULL DEFAULT 'en attente de confirmation',
  'material_lent' TINYINT(1) NOT NULL DEFAULT 0,
  'user_id' INT NOT NULL,
  'menu_id' INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

CREATE TABLE 'history_status_order' (
  'history_id' INT AUTO_INCREMENT PRIMARY KEY,
  'status' VARCHAR(50) NOT NULL,
  'modified_at' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'reason' TEXT,
  'contact_mode' VARCHAR(50),
  'order_id' INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES customer_order(order_id)
);

CREATE TABLE 'review' (
  'review_id' INT AUTO_INCREMENT PRIMARY KEY,
  'rating' INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
  'comment' TEXT NOT NULL,
  'validation_status' ENUM('en attente','validé','refusé') NOT NULL DEFAULT 'en attente',
  'reviewed_at' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  'order_id' INT NOT NULL UNIQUE,
  'user_id' INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES customer_order(order_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id)
);

SET FOREIGN_KEY_CHECKS = 1;

-- ===========================================================
-- DONNEES INITIALES
-- ===========================================================

INSERT INTO role (label) VALUES ('client'), ('employe'), ('administrateur');

INSERT INTO theme (label) VALUES ('Noël'), ('Pâques'), ('classique'), ('événement');

INSERT INTO diet (label) VALUES
('classique'), ('végétarien'), ('vegan'),
('sans gluten'), ('halal'), ('casher');

INSERT INTO schedule (day, opening_time, closing_time) VALUES
('Lundi', '09:00:00', '18:00:00'),
('Mardi', '09:00:00', '18:00:00'),
('Mercredi', '09:00:00', '18:00:00'),
('Jeudi', '09:00:00', '18:00:00'),
('Vendredi', '09:00:00', '18:00:00'),
('Samedi', '10:00:00', '17:00:00'),
('Dimanche', '10:00:00', '17:00:00');

INSERT INTO page_content (page, section, content, updated_at) VALUES
('home', 'presentation', 'Texte de présentation de Vite & Gourmand à personnaliser', NOW()),
('home', 'team', 'Présentation de Julie et José à personnaliser', NOW());