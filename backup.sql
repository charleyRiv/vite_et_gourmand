/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.3.2-MariaDB, for osx10.21 (arm64)
--
-- Host: localhost    Database: vite_et_gourmand
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `allergen`
--

DROP TABLE IF EXISTS `allergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `allergen` (
  `allergen_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`allergen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allergen`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `allergen` WRITE;
/*!40000 ALTER TABLE `allergen` DISABLE KEYS */;
INSERT INTO `allergen` VALUES
(1,'Gluten'),
(2,'Crustacés'),
(3,'Oeufs'),
(4,'Poissons'),
(5,'Arachides'),
(6,'Soja'),
(7,'Lait'),
(8,'Fruits à coque'),
(9,'Céleri'),
(10,'Moutarde'),
(11,'Graines de sésame'),
(12,'Anhydride sulfureux'),
(13,'Lupin'),
(14,'Mollusques');
/*!40000 ALTER TABLE `allergen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `customer_order`
--

DROP TABLE IF EXISTS `customer_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `event_date` date NOT NULL,
  `delivery_time` time NOT NULL,
  `delivery_street_number` varchar(10) NOT NULL,
  `delivery_street_type` varchar(20) NOT NULL,
  `delivery_street_name` varchar(100) NOT NULL,
  `delivery_zip_code` varchar(10) NOT NULL,
  `delivery_city` varchar(50) NOT NULL,
  `delivery_country` varchar(50) NOT NULL,
  `nb_persons` smallint(6) NOT NULL,
  `calculated_menu_price` decimal(10,2) NOT NULL,
  `delivery_fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL,
  `current_status` enum('pending','accepted','in_preparation','in_delivery','delivered','waiting_material','completed','cancelled') NOT NULL DEFAULT 'pending',
  `material_lent` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_order`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `customer_order` WRITE;
/*!40000 ALTER TABLE `customer_order` DISABLE KEYS */;
INSERT INTO `customer_order` VALUES
(1,'2026-07-29 23:55:23','2026-12-24','19:00:00','8','boulevard','Victor Hugo','75001','Paris','France',12,540.00,35.00,0.00,575.00,'accepted',0,3,1),
(2,'2026-07-29 23:55:23','2026-04-20','12:30:00','3','rue','du Moulin','33000','Bordeaux','France',8,304.00,0.00,0.00,304.00,'completed',0,4,2),
(3,'2026-07-29 23:55:23','2026-08-15','20:00:00','15','avenue','de la Gare','33100','Bordeaux','France',15,825.00,0.00,82.50,742.50,'completed',0,3,4),
(4,'2026-08-09 00:50:10','2026-08-23','20:30:00','1','Route','de l\'Océan','33480','Saint-Hélène','France',20,760.00,22.11,76.00,706.11,'cancelled',0,15,2),
(5,'2026-08-09 00:54:48','2026-10-02','16:00:00','1','avenue','du Général Leclerc','3320','Bordeaux','France',12,144.00,0.00,0.00,144.00,'pending',0,14,7),
(6,'2026-08-09 23:11:14','2026-08-18','16:59:00','20','Allée','Davezac','33200','Bordeaux','France',18,810.00,0.00,81.00,729.00,'completed',0,14,1),
(7,'2026-08-09 23:34:19','2026-08-19','22:33:00','1','avenue','du Général Leclerc','3320','Bordeaux','France',15,180.00,0.00,18.00,162.00,'cancelled',0,14,7),
(8,'2026-08-09 23:38:22','2026-09-06','11:36:00','1','avenue','du Général Leclerc','3320','Bordeaux','France',15,180.00,0.00,18.00,162.00,'pending',0,14,7),
(9,'2026-08-09 23:39:35','2026-08-19','10:39:00','1','avenue','du Général Leclerc','3320','Bordeaux','France',15,180.00,0.00,18.00,162.00,'completed',0,14,7),
(10,'2026-08-12 15:50:31','2026-08-31','20:30:00','5','place','de l\'Hôtel de ville','15300','Murat','France',25,1375.00,223.30,137.50,1460.80,'completed',0,17,4),
(11,'2026-08-12 16:00:33','2026-08-26','16:00:00','5','place','de l\'Hôtel de ville','15300','Murat','France',12,540.00,223.30,0.00,763.30,'in_preparation',0,17,1),
(12,'2026-09-03 13:03:06','2026-09-11','14:30:00','12','rue','de la Liberté','33200','Bordeaux','France',25,1375.00,0.00,137.50,1237.50,'pending',0,14,4),
(13,'2026-09-10 21:45:27','2026-09-11','19:30:00','1','rue','blo ton luc','78140','trou land','ici',80,4400.00,5.00,440.00,3965.00,'pending',0,24,4);
/*!40000 ALTER TABLE `customer_order` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `diet`
--

DROP TABLE IF EXISTS `diet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `diet` (
  `diet_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`diet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diet`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `diet` WRITE;
/*!40000 ALTER TABLE `diet` DISABLE KEYS */;
INSERT INTO `diet` VALUES
(1,'classique'),
(2,'végétarien'),
(3,'vegan'),
(4,'sans gluten'),
(5,'halal'),
(6,'casher');
/*!40000 ALTER TABLE `diet` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish` (
  `dish_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `dish_type` enum('starter','main','dessert') NOT NULL,
  PRIMARY KEY (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` VALUES
(1,'Foie gras maison','Foie gras mi-cuit, chutney de figues et pain brioché','starter'),
(2,'Velouté de potiron','Velouté onctueux de potiron, crème fraîche et noisettes torréfiées','starter'),
(3,'Salade de chèvre chaud','Mesclun, chèvre rôti, noix et miel de lavande','starter'),
(4,'Saumon gravlax','Saumon mariné à l\'aneth, crème citronnée et blinis','starter'),
(5,'Agneau de lait rôti','Gigot d\'agneau rôti aux herbes de Provence, gratin dauphinois','main'),
(6,'Saumon en croûte','Pavé de saumon en croûte de sésame, riz basmati et légumes vapeur','main'),
(7,'Risotto aux champignons','Risotto crémeux aux cèpes et morilles, copeaux de parmesan','main'),
(8,'Filet de boeuf','Filet de boeuf en croûte, sauce Périgueux et pommes sarladaises','main'),
(9,'Bûche de Noël','Bûche maison chocolat et marrons glacés','dessert'),
(10,'Charlotte aux fraises','Charlotte aux fraises fraîches, coulis de fruits rouges','dessert'),
(11,'Tarte Tatin','Tarte Tatin aux pommes caramélisées, crème fraîche épaisse','dessert'),
(12,'Fondant au chocolat','Fondant au chocolat noir 70%, glace vanille maison','dessert'),
(15,'Buche','buche vanille test','dessert'),
(16,'Nouveau plat','','main'),
(17,'Nouveau plat','','main'),
(18,'Nouveau plat','','main'),
(19,'Nouveau plat','','main');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dish_allergen`
--

DROP TABLE IF EXISTS `dish_allergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dish_allergen` (
  `dish_id` int(11) NOT NULL,
  `allergen_id` int(11) NOT NULL,
  PRIMARY KEY (`dish_id`,`allergen_id`),
  KEY `allergen_id` (`allergen_id`),
  CONSTRAINT `1` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`),
  CONSTRAINT `2` FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish_allergen`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dish_allergen` WRITE;
/*!40000 ALTER TABLE `dish_allergen` DISABLE KEYS */;
INSERT INTO `dish_allergen` VALUES
(1,1),
(4,1),
(6,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(9,3),
(10,3),
(11,3),
(12,3),
(4,4),
(6,4),
(15,4),
(3,7),
(5,7),
(7,7),
(9,7),
(10,7),
(11,7),
(12,7),
(15,7),
(3,8),
(6,11),
(15,12);
/*!40000 ALTER TABLE `dish_allergen` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `history_status_order`
--

DROP TABLE IF EXISTS `history_status_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_status_order` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `modified_at` datetime NOT NULL DEFAULT current_timestamp(),
  `reason` text DEFAULT NULL,
  `contact_mode` varchar(50) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_status_order`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `history_status_order` WRITE;
/*!40000 ALTER TABLE `history_status_order` DISABLE KEYS */;
INSERT INTO `history_status_order` VALUES
(1,'pending','2026-11-01 10:00:00',NULL,NULL,1),
(2,'accepted','2026-11-02 14:30:00',NULL,NULL,1),
(3,'pending','2026-11-05 09:00:00',NULL,NULL,2),
(4,'pending','2026-10-01 11:00:00',NULL,NULL,3),
(5,'accepted','2026-10-02 09:00:00',NULL,NULL,3),
(6,'in_preparation','2026-10-15 08:00:00',NULL,NULL,3),
(7,'in_delivery','2026-10-15 11:00:00',NULL,NULL,3),
(8,'delivered','2026-10-15 13:00:00',NULL,NULL,3),
(9,'completed','2026-10-15 13:30:00',NULL,NULL,3),
(10,'pending','2026-08-09 00:50:10',NULL,NULL,4),
(11,'pending','2026-08-09 00:54:48',NULL,NULL,5),
(12,'pending','2026-08-09 23:11:14',NULL,NULL,6),
(13,'pending','2026-08-09 23:34:19',NULL,NULL,7),
(14,'pending','2026-08-09 23:38:22',NULL,NULL,8),
(15,'pending','2026-08-09 23:39:35',NULL,NULL,9),
(16,'cancelled','2026-08-12 01:01:45','blabla','',7),
(17,'pending','2026-08-12 15:50:31',NULL,NULL,10),
(18,'pending','2026-08-12 16:00:33',NULL,NULL,11),
(19,'accepted','2026-08-13 14:38:30','','',9),
(20,'cancelled','2026-08-13 14:44:14','problème d\'approvisionnement','téléphone',4),
(21,'accepted','2026-08-13 23:04:23','','',2),
(22,'waiting_material','2026-08-13 23:04:39','','',2),
(23,'completed','2026-08-13 23:05:03','','',2),
(24,'completed','2026-08-14 00:28:56','','',6),
(25,'accepted','2026-08-19 23:25:14','','',11),
(26,'pending','2026-08-19 23:30:43','','',9),
(27,'accepted','2026-08-19 23:37:09','','',9),
(28,'pending','2026-09-03 13:03:06',NULL,NULL,12),
(29,'completed','2026-09-07 10:34:45','a     a','aa',10),
(30,'in_preparation','2026-09-07 10:49:31','','',11),
(31,'in_preparation','2026-09-10 17:19:13','','',9),
(32,'delivered','2026-09-10 17:19:29','','',9),
(33,'completed','2026-09-10 17:19:45','','',9),
(34,'pending','2026-09-10 21:45:27',NULL,NULL,13);
/*!40000 ALTER TABLE `history_status_order` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `min_persons` int(11) NOT NULL,
  `price_per_person` decimal(10,2) NOT NULL,
  `remaining_stock` int(11) NOT NULL DEFAULT 0,
  `conditions` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `theme_id` int(11) NOT NULL,
  `diet_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `theme_id` (`theme_id`),
  KEY `diet_id` (`diet_id`),
  CONSTRAINT `1` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`theme_id`),
  CONSTRAINT `2` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`diet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES
(1,'Menu Noël Prestige','Un menu raffiné pour sublimer vos fêtes de fin d\'année. Foie gras, saumon et bûche maison.',10,45.00,8,'À commander minimum 7 jours avant la prestation. Conservation au réfrigérateur entre 0 et 4°C.',1,1,1),
(2,'Menu Pâques Famille','Le menu idéal pour réunir toute la famille autour d\'un repas généreux et convivial.',8,38.00,5,'À commander minimum 5 jours avant la prestation.',1,2,1),
(3,'Menu Végétarien Printemps','Une sélection de plats végétariens frais et colorés, parfaits pour la belle saison.',6,32.00,10,'À commander minimum 3 jours avant la prestation. Produits frais de saison.',1,3,2),
(4,'Menu Événement Corporate','Un menu professionnel et élégant pour vos séminaires, cocktails et réunions d\'affaires.',20,55.00,3,'À commander minimum 14 jours avant la prestation. Matériel de service fourni.',1,4,1),
(5,'Menu Vegan Été','Une expérience culinaire 100% végétale, fraîche et savoureuse.',4,28.00,0,'À commander minimum 3 jours avant la prestation.',1,3,3),
(7,'Menu de test','test',10,12.00,10,'cvhwdvj',1,3,1),
(8,'Menu été','Menu rafraîchissant et savoureux pour les fortes chaleurs',3,16.00,30,'A réchauffer juste avant le service',1,3,1),
(9,'Nouveau menu','',1,0.00,0,'',0,3,1),
(10,'Nouveau menu','',1,0.00,0,'',0,3,1),
(11,'Nouveau menu','',1,0.00,0,'',0,3,1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `menu_dish`
--

DROP TABLE IF EXISTS `menu_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_dish` (
  `menu_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`dish_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  CONSTRAINT `2` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_dish`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `menu_dish` WRITE;
/*!40000 ALTER TABLE `menu_dish` DISABLE KEYS */;
INSERT INTO `menu_dish` VALUES
(1,1),
(7,1),
(3,2),
(5,2),
(4,3),
(8,3),
(2,4),
(1,5),
(2,5),
(7,5),
(8,6),
(3,7),
(5,7),
(4,8),
(1,9),
(7,9),
(2,10),
(8,10),
(3,11),
(5,11),
(4,12);
/*!40000 ALTER TABLE `menu_dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `message_contact`
--

DROP TABLE IF EXISTS `message_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_contact` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `sent_at` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_contact`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `message_contact` WRITE;
/*!40000 ALTER TABLE `message_contact` DISABLE KEYS */;
INSERT INTO `message_contact` VALUES
(1,'retour matériel','Je vous écrit afin de voir avec vous les modalités de retour du matériel que vous nous avez prété lors de la prestation de jeudi dernier\r\nCordialement\r\nblabla','utilisateurNonConnecte@mail.fr','2026-08-17 15:53:20'),
(2,'Merci!!','Merci blabjbcjkshjchshvwhvkh','userBordeaux@mail.fr','2026-08-17 15:54:47'),
(3,'petit test','voila pouet','employeTest@mail.com','2026-09-10 00:25:31');
/*!40000 ALTER TABLE `message_contact` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `page_content`
--

DROP TABLE IF EXISTS `page_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_content`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `page_content` WRITE;
/*!40000 ALTER TABLE `page_content` DISABLE KEYS */;
INSERT INTO `page_content` VALUES
(5,'home','Présentation de l\'entreprise','Depuis plus de 25 ans, Vite & Gourmand sublime vos événements depuis Bordeaux. \r\nCe qui a commencé comme une passion pour la gastronomie partagée est devenu une référence incontournable de la restauration événementielle en Gironde.\r\n\r\nQue vous organisiez un repas de famille pour Noël, un déjeuner de Pâques ou un événement d\'entreprise, nous concevons des menus variés et originaux qui sauront satisfaire vos envies, vos convictions alimentaires et votre budget. \r\nChaque prestation est pensée dans le moindre détail pour que vous puissiez profiter pleinement de vos moments précieux, sans vous soucier du reste.','2026-09-09 23:19:55'),
(6,'home','Présentation de l\'équipe','Notre équipe s\'engage sur trois principes fondamentaux : \r\nla qualité des produits, la ponctualité des livraisons et l\'écoute de vos besoins.\r\nJulie assure la conception et la préparation de chaque menu avec des produits frais sélectionnés avec soin. José coordonne la logistique et le suivi de chaque commande pour garantir une livraison dans les temps et en parfaites conditions. \r\nEnsemble, ils mettent leur expertise au service de vos événements depuis plus de 25 ans.','2026-08-14 16:07:36'),
(7,'footer','Horaires','12:00 - 15h00 / 18h00 - 23:00\r\n12:00 - 15h00 / 18h00 - 23:00\r\n18h00 - 23:00\r\nfermé\r\n12:00 - 15h00 / 18h00 - 23:00\r\n12:00 - 15h00 / 18h00 - 23:00\r\nfermé','2026-09-09 23:19:48');
/*!40000 ALTER TABLE `page_content` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `picture_dish`
--

DROP TABLE IF EXISTS `picture_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `picture_dish` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `alt_text` varchar(255) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `dish_id` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `1` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture_dish`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `picture_dish` WRITE;
/*!40000 ALTER TABLE `picture_dish` DISABLE KEYS */;
INSERT INTO `picture_dish` VALUES
(1,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-1',1,1),
(2,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-2',1,2),
(7,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-7',1,7),
(11,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-11',1,11),
(12,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-12',1,12),
(16,'/assets/images/uploads/img_6a712676ad88f2.00461069.png','titre test','test alt test','titre-test',0,15),
(18,'/assets/images/uploads/img_6aa17e76838c91.58294790.png','Bûche de Noël vanille','Bûche de Noël à la vanille fourrée à la crème de marron','b-uche-de-no-el-vanille',0,9),
(19,'/assets/images/uploads/img_6aa17fe7088400.93387069.jpg','Saumon','saumon','saumon',0,4);
/*!40000 ALTER TABLE `picture_dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `picture_menu`
--

DROP TABLE IF EXISTS `picture_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `picture_menu` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `alt_text` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture_menu`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `picture_menu` WRITE;
/*!40000 ALTER TABLE `picture_menu` DISABLE KEYS */;
INSERT INTO `picture_menu` VALUES
(1,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-1',1,1),
(2,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-2',1,2),
(3,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-3',1,3),
(4,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-5',1,5),
(5,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test-4',1,4),
(7,'/assets/images/uploads/img_6a71d574a5ee29.18546294.png','titre asperges test','test alt test','titre-asperges-test',0,7),
(9,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test',0,7),
(11,'/assets/images/uploads/img_6aa17e76838c91.58294790.png','Bûche de Noël vanille','Bûche de Noël à la vanille fourrée à la crème de marron','b-uche-de-no-el-vanille',0,7);
/*!40000 ALTER TABLE `picture_menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text NOT NULL,
  `validation_status` enum('pending','validated','refused') NOT NULL DEFAULT 'pending',
  `reviewed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `1` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`),
  CONSTRAINT `2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES
(1,5,'Prestation exceptionnelle ! Les plats étaient délicieux et le service impeccable.','validated','2026-10-16 10:00:00',3,3),
(2,1,'super','refused','2026-08-14 13:25:32',6,14);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES
(1,'client'),
(2,'employe'),
(3,'administrateur');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(20) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES
(1,'Lundi','09:00:00','18:00:00'),
(2,'Mardi','09:00:00','18:00:00'),
(3,'Mercredi','09:00:00','18:00:00'),
(4,'Jeudi','09:00:00','18:00:00'),
(5,'Vendredi','09:00:00','18:00:00'),
(6,'Samedi','10:00:00','17:00:00'),
(7,'Dimanche','10:00:00','17:00:00');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `theme` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES
(1,'Noël'),
(2,'Pâques'),
(3,'classique'),
(4,'événement');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `public_token` char(36) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `street_number` varchar(10) DEFAULT NULL,
  `street_type` varchar(20) DEFAULT NULL,
  `street_name` varchar(100) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `token_reset` char(36) DEFAULT NULL,
  `token_reset_expiration` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `public_token` (`public_token`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'a1b2c3d4-e5f6-7890-abcd-ef1234567890','admin@viteetgourmand.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Toto','titi','0706070607','20','allée','Davezac','33200','Bordeaux','',1,NULL,NULL,'2026-07-29 23:29:23',NULL,3),
(2,'b2c3d4e5-f6a7-8901-bcde-f12345678901','employe@viteetgourmand.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Toto','titi','0706070607','20','allée','Davezac','33200','Bordeaux','',0,NULL,NULL,'2026-07-29 23:29:23',NULL,2),
(3,'c3d4e5f6-a7b8-9012-cdef-123456789012','client@test.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Toto','titi','0706070607','20','allée','Davezac','33200','Bordeaux','',1,NULL,NULL,'2026-07-29 23:29:23',NULL,1),
(4,'d4e5f6a7-b8c9-0123-defa-234567890123','client2@test.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Toto','titi','0706070607','20','allée','Davezac','33200','Bordeaux','',1,NULL,NULL,'2026-07-29 23:29:23',NULL,1),
(13,'d5b97bf6-db27-6abd-1870-2308536870c3','employeTest@mail.com','$2y$12$O54syG0GNsiExeZ9Ofqc9e583c.2pcNMZOlKUxSz5BxNP6n7iNr9e','Toto','titi','0706070607','20','allée','Davezac','33200','Bordeaux','',1,NULL,NULL,'2026-08-02 23:05:53',NULL,2),
(14,'48969a17-b50d-6d20-6ef7-fc5cf522d128','userBordeaux@mail.fr','$2y$12$thQAmbwjRwC1WdHIyYYMHO1FS50xc5vFlir/w.rz8qgkSF03o1uKa','NomTest','PrenomTest','0707070707','12','rue','de la Liberté','33200','Bordeaux','',1,NULL,NULL,'2026-08-07 14:43:39',NULL,1),
(15,'d677b3e6-b125-d4e9-0e9a-30e921ee27fc','userSaintHelene@mail.fr','$2y$12$NyRox4gKQTBQ/ie23RCsWeDYvtNjiHCiXbPy5oz.UJnl1fX7nWL5u','Pouet','toto','0606060606','1','route','de l\'Océan','33480','Saint-Hélène','France',1,NULL,NULL,'2026-08-07 14:47:02','2026-08-12 14:51:32',1),
(17,'02d06b46-a7cc-ac28-28bc-4247379d1f98','testMail@mail.fr','$2y$12$cF47I4dWtbTFOempoVLHJ.6RWotdDnd0Z4TWkggdX1h22OtUw58bG','toto','toto','0707070707','5','place','de l\'Hôtel de ville','15300','Murat','France',1,'ba9e5c12385da75046c611b93555dc2d','2026-09-01 11:56:31','2026-08-12 15:14:23','2026-08-12 17:00:22',1),
(19,'929431ab4875e90f5b94a164c63a891a','admin2@viteetgourmand.fr','$2y$12$Pr/sq5YKTfvynAX/KUo/ZeRWfVAdS56sXZztkLAG7jMFzPMlGGPFS','Admin','Vite & Gourmand',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-08-15 01:07:08',NULL,3),
(20,'2d9c5057-fbd2-0ea0-0e0e-c3aa62876c22','employeTest2@mail.com','$2y$12$Ospw/A0NFaVgmMBCPr5/l.Yv1fF8nelY8m2XR5jzwOxJlVTdy/ko6','Emp','Loye','exempted','exempted','exempted','exempted','exempted','exempted','exempted',1,NULL,NULL,'2026-08-15 14:49:25',NULL,2),
(22,'e8715ab5-56bd-375b-a0db-267ee5b4972e','bidule.chouette@mailtest.fr','$2y$12$a7ZJNQHgEL/IhqaXIKkZeOjVdxXcX3fY/rDeZSE4FkCgCZfcEXF5G','Bidule','Chouette','exempted','exempted','exempted','exempted','exempted','exempted','exempted',1,NULL,NULL,'2026-09-10 12:28:06',NULL,2),
(23,'f196d2b7-e967-fe5c-1c5f-85fd68f190e3','mrmme@mail.fr','$2y$12$R7FZPkpmLiVfzQ5hS/CfW.ptSt1QZTZpOBfJrrVhAnM48LgH1XlGi','Monsieur','Madame','0606060606','','','','','','',1,NULL,NULL,'2026-09-10 21:26:24',NULL,1),
(24,'06b02624-7454-2da2-8d55-9f11a9342a76','blabla.bla@blo.com','$2y$12$ZSMEsPjZ08I4ZSTAEUICY.9mA81qV2PI5d/VQf1MH6Gvo72hfOANO','blabla','bla','','1','rue','blo ton luc','78140','trou land','ici',1,NULL,NULL,'2026-09-10 21:41:33',NULL,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-11 17:06:08
