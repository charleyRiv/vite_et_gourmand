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
(12,'Sunday brunch','Assortiment idéal pour vos dimanches matin en famille ou entre amis',5,17.00,10,'A réserver avant la veille 18h. Conserver au frais et réchauffer selon les instructions 30 minutes avant le service',0,3,4);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

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
(20,'Houmous','Houmous de pois chiche accompagné de pignon de pin','starter');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

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
(12,2),
(4,3),
(8,3),
(2,4),
(1,5),
(2,5),
(7,5),
(8,6),
(12,6),
(3,7),
(5,7),
(4,8),
(1,9),
(7,9),
(2,10),
(8,10),
(3,11),
(5,11),
(12,11),
(4,12);
/*!40000 ALTER TABLE `menu_dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

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
(11,'/assets/images/uploads/img_6aa17e76838c91.58294790.png','Bûche de Noël vanille','Bûche de Noël à la vanille fourrée à la crème de marron','b-uche-de-no-el-vanille',0,7),
(13,'/assets/images/uploads/dish_starter_foieGras_001.png','Photo test','Photo de test pour tous les plats','photo-test',0,12),
(14,'/assets/images/uploads/img_6aa17e76838c91.58294790.png','Bûche de Noël vanille','Bûche de Noël à la vanille fourrée à la crème de marron','b-uche-de-no-el-vanille',0,1);
/*!40000 ALTER TABLE `picture_menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

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
(19,'/assets/images/uploads/img_6aa17fe7088400.93387069.jpg','Saumon','saumon','saumon',0,4),
(21,'/assets/images/uploads/img_6aaf0832b7bd00.53643067.jpg','salade thaï','salade thaï','salade-tha-i',0,20);
/*!40000 ALTER TABLE `picture_dish` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

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
(20,3),
(4,4),
(6,4),
(15,4),
(20,5),
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
(14,'48969a17-b50d-6d20-6ef7-fc5cf522d128','userBordeaux@mail.fr','$2y$12$PMNM0nBRJ3x9jpUG7dqHiuhLLcgNyTuVlgf7AgCoWm56rk6df.kku','NomTest','PrenomTest','0707070706','12','rue','de la Liberté','33200','Bordeaux','France',1,NULL,NULL,'2026-08-07 14:43:39','2026-09-20 01:15:06',1),
(15,'d677b3e6-b125-d4e9-0e9a-30e921ee27fc','userSaintHelene@mail.fr','$2y$12$NyRox4gKQTBQ/ie23RCsWeDYvtNjiHCiXbPy5oz.UJnl1fX7nWL5u','Pouet','toto','0606060606','1','route','de l\'Océan','33480','Saint-Hélène','France',1,NULL,NULL,'2026-08-07 14:47:02','2026-08-12 14:51:32',1),
(17,'02d06b46-a7cc-ac28-28bc-4247379d1f98','testMail@mail.fr','$2y$12$cF47I4dWtbTFOempoVLHJ.6RWotdDnd0Z4TWkggdX1h22OtUw58bG','toto','toto','0707070707','5','place','de l\'Hôtel de ville','15300','Murat','France',1,'ba9e5c12385da75046c611b93555dc2d','2026-09-01 11:56:31','2026-08-12 15:14:23','2026-08-12 17:00:22',1),
(19,'929431ab4875e90f5b94a164c63a891a','admin2@viteetgourmand.fr','$2y$12$Pr/sq5YKTfvynAX/KUo/ZeRWfVAdS56sXZztkLAG7jMFzPMlGGPFS','Admin','Vite & Gourmand',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-08-15 01:07:08',NULL,3),
(20,'2d9c5057-fbd2-0ea0-0e0e-c3aa62876c22','employeTest2@mail.com','$2y$12$Ospw/A0NFaVgmMBCPr5/l.Yv1fF8nelY8m2XR5jzwOxJlVTdy/ko6','Emp','Loye','exempted','exempted','exempted','exempted','exempted','exempted','exempted',1,NULL,NULL,'2026-08-15 14:49:25',NULL,2),
(22,'e8715ab5-56bd-375b-a0db-267ee5b4972e','bidule.chouette@mailtest.fr','$2y$12$a7ZJNQHgEL/IhqaXIKkZeOjVdxXcX3fY/rDeZSE4FkCgCZfcEXF5G','Bidule','Chouette','exempted','exempted','exempted','exempted','exempted','exempted','exempted',1,NULL,NULL,'2026-09-10 12:28:06',NULL,2),
(23,'f196d2b7-e967-fe5c-1c5f-85fd68f190e3','mrmme@mail.fr','$2y$12$R7FZPkpmLiVfzQ5hS/CfW.ptSt1QZTZpOBfJrrVhAnM48LgH1XlGi','Monsieur','Madame','0606060606','','','','','','',1,NULL,NULL,'2026-09-10 21:26:24',NULL,1),
(24,'06b02624-7454-2da2-8d55-9f11a9342a76','blabla.bla@blo.com','$2y$12$ZSMEsPjZ08I4ZSTAEUICY.9mA81qV2PI5d/VQf1MH6Gvo72hfOANO','blabla','bla','','1','rue','blo ton luc','78140','trou land','ici',1,NULL,NULL,'2026-09-10 21:41:33',NULL,1),
(25,'0ec849dc-2b23-f657-38db-a89dde73681f','deleted_25@deleted.fr','$2y$12$ZSMEsPjZ05FGBSTAEUICY.9mA81qV2PI5d/VQf1MH6Gvo72hfOANO','Compte','Supprimé','','','','','','','',0,NULL,NULL,'2026-09-18 23:21:20','2026-09-20 01:35:40',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
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

-- Dump completed on 2026-10-19  0:27:44
