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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-20  3:35:25
