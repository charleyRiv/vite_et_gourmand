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
  CONSTRAINT `fk_customer_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `fk_customer_order_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_dish_allergen_dish` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`),
  CONSTRAINT `fk_dish_allergen_allergen` FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_history_status_order_customer_order` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_menu_theme` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`theme_id`),
  CONSTRAINT `fk_menu_diet` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`diet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_menu_dish_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  CONSTRAINT `fk_menu_dish_dish` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_picture_dish_dish` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_picture_menu_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_review_customer_order` FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`order_id`),
  CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-20  3:32:10
